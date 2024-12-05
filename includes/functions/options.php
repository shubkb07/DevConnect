<?php

if (!defined('ABSPATH')) {
    die('Direct access not allowed.');
}

// Global variable to store options.
$options = [];

/**
 * Retrieve and load all options with autoload set to 'yes' into the global $options array.
 *
 * @global array $options
 * @return void
 */
function load_autoload_options() {
    global $db, $options;

    $query = "SELECT option_name, option_value FROM " . $db->prefix() . "options WHERE autoload = 'yes'";
    $result = $db->execute_query($query);

    while ($row = $result->fetch_assoc()) {
        if (is_serialized($row['option_value'])) {
            $options[$row['option_name']] = unserialize($row['option_value']);
        } else {
            $options[$row['option_name']] = $row['option_value'];
        }
    }
}

/**
 * Add a new option to the database.
 *
 * @param string $key The option key.
 * @param mixed $value The option value.
 * @param bool $autoload Whether the option should be autoloaded. Default is false.
 * @return bool True if the option is added successfully, false otherwise.
 */
function add_option($key, $value, $autoload = false, $checked = false) {
    global $db, $options;

    if (false === $checked) {
        if ($options[$key] !== null) {
            return false; // Key already exists.
        }

        // Check if the key already exists in the database.
        $query = "SELECT COUNT(*) AS count FROM " . $db->prefix() . "options WHERE option_name = ?";
        $result = $db->execute_query($query, [$key], 's');
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            return false; // Key already exists.
        }
    }

    // Insert the new option.
    $query = "INSERT INTO " . $db->prefix() . "options (option_name, option_value, autoload) VALUES (?, ?, ?)";
    $autoload_value = $autoload ? 'yes' : 'no';
    $success = $db->execute_query($query, [$key, $value, $autoload_value], 'sss');

    if ($success) {
        $options[$key] = $value; // Update global options if autoload is 'yes'.
    }

    return $success;
}

/**
 * Update an option or add it if it does not exist.
 *
 * @param string $key The option key.
 * @param mixed $value The new option value.
 * @param bool $autoload Whether the option should be autoloaded. Default is false.
 * @return bool True if the option was updated or added successfully, false otherwise.
 */
function update_option($key, $value, $autoload = false) {
    global $db, $options;

    // Check if the key exists in the database.
    $query = "SELECT COUNT(*) AS count FROM " . $db->prefix() . "options WHERE option_name = ?";
    $result = $db->execute_query($query, [$key], 's');
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        // Key exists, update it.
        $query = "UPDATE " . $db->prefix() . "options SET option_value = ?, autoload = ? WHERE option_name = ?";
        $autoload_value = $autoload ? 'yes' : 'no';
        $success = $db->execute_query($query, [$value, $autoload_value, $key], 'sss');

        if ($success) {
            // Update global options if autoload is 'yes', or remove if 'no'.
            $options[$key] = $value;
        }

        return $success;
    }

    // Key does not exist, add it.
    return add_option($key, $value, $autoload, true);
}

/**
 * Get the value of an option.
 *
 * @param string $key The option key.
 * @return mixed|null The option value, or null if the option does not exist.
 */
function get_option($key) {
    global $db, $options;

    // Check if the option is already loaded in the $options array.
    if (isset($options[$key])) {
        return $options[$key];
    }

    // Retrieve the option from the database.
    $query = "SELECT option_value FROM " . $db->prefix() . "options WHERE option_name = ?";
    $result = $db->execute_query($query, [$key], 's');

    if ($row = $result->fetch_assoc()) {
        if (is_serialized($row['option_value'])) {
            $options[$key] = unserialize($row['option_value']);
        } else {
            $options[$key] = $row['option_value'];
        }
        return $options[$key];
    }

    return null;
}

/**
 * Delete an option.
 *
 * @param string $key The option key.
 * @return bool True if the option was deleted successfully, false otherwise.
 */
function delete_option($key) {
    global $db;

    $query = "DELETE FROM " . $db->prefix() . "options WHERE option_name = ?";
    $success = $db->execute_query($query, [$key], 's');

    if ($success) {
        global $options;
        unset($options[$key]); // Remove the option from the global $options array.
    }

    return $success;
}

// Load all autoload options into the global $options array at the start.
load_autoload_options();
