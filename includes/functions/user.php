<?php
/**
 * User Management Functions
 *
 * This file contains functions for user authentication, management, roles,
 * capabilities, metadata, and session handling. It ensures secure and efficient
 * operations adhering to best practices.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    die('Direct access not allowed.');
}

// Define constants if not already defined
if (!defined('DAY_IN_SECONDS')) {
    define('DAY_IN_SECONDS', 86400);
}

// Global variable to hold current user data
global $user;

// Initialize the global $user variable
if (is_user_logged_in()) {
    $user_id = get_user_id_by_session_token($_COOKIE['auth_token']);
    if ($user_id) {
        $user = get_userdata($user_id);
    } else {
        $user = null;
    }
} else {
    $user = null;
}

/**
 * Generate a secure random authentication key.
 *
 * @return string A 64-character hexadecimal string.
 * @throws Exception If an appropriate source of randomness cannot be found.
 */
function generate_auth_key($length = 64, $include_symbols = false) {

    // Define character sets
    $sets = [
        'ABCDEFGHIJKLMNOPQRSTUVWXYZ',        // Uppercase letters
        'abcdefghijklmnopqrstuvwxyz',        // Lowercase letters
        '0123456789',                        // Numbers
    ];

    // Include symbols if specified
    if ($include_symbols) {
        $sets[] = '!@#$%^&*()-_=+[]{}|;:,.<>?/~`'; // Symbols
    }

    // Shuffle the sets to randomize their order
    shuffle($sets);

    $auth_key = '';
    $all_characters = implode('', $sets); // Combine all sets into one string
    $all_length = strlen($all_characters);

    // Ensure at least one character from each set is included
    foreach ($sets as $set) {
        $auth_key .= $set[random_int(0, strlen($set) - 1)];
    }

    // Fill the remaining length with random characters from the combined set
    for ($i = strlen($auth_key); $i < $length; $i++) {
        $auth_key .= $all_characters[random_int(0, $all_length - 1)];
    }

    // Shuffle the final key to ensure the placement of characters is random
    return str_shuffle($auth_key);
}

/**
 * Hash a password securely using AUTH_SALT.
 *
 * @param string $password The plaintext password.
 * @return string The hashed password.
 */
function hash_password($password) {
    return password_hash(AUTH_SALT . $password, PASSWORD_DEFAULT);
}

/**
 * Verify a password against a hashed password.
 *
 * @param string $password The plaintext password.
 * @param string $hash The hashed password.
 * @return bool True if the password matches, false otherwise.
 */
function check_password($password, $hash) {
    return password_verify(AUTH_SALT . $password, $hash);
}

/**
 * Generate a random password.
 *
 * @param int $length The length of the password. Default is 12.
 * @return string The generated password.
 * @throws Exception If an appropriate source of randomness cannot be found.
 */
function generate_password($length = 12) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+[]{}|;:,.<>?';
    $password = '';
    $max = strlen($chars) - 1;
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, $max)];
    }
    return $password;
}

/**
 * Set a user's password.
 *
 * @param int $user_id The ID of the user.
 * @param string $password The new plaintext password.
 * @throws Exception If the update fails.
 */
function set_password($user_id, $password) {
    global $db;

    $hashed_password = hash_password($password);

    $query = "UPDATE {$db->prefix()}users SET user_pass = ? WHERE ID = ?";
    $params = [$hashed_password, $user_id];
    $types = 'si';

    $db->execute_query($query, $params, $types);
}

/**
 * Create a new user.
 *
 * @param string $username The desired username.
 * @param string $password The desired password.
 * @param string $email The user's email address. Optional.
 * @return int The ID of the newly created user.
 * @throws Exception If user creation fails.
 */
function create_user($username, $password, $email = '') {
    $user_data = [
        'user_login' => $username,
        'user_pass' => $password,
        'user_email' => $email
    ];

    return insert_user($user_data);
}

/**
 * Insert a new user with comprehensive user data.
 *
 * @param array $user_data An associative array of user data.
 * @return int The ID of the newly created user.
 * @throws Exception If required fields are missing or insertion fails.
 */
function insert_user($user_data) {
    global $db;

    // Check required fields
    if (empty($user_data['user_login']) || empty($user_data['user_pass']) || empty($user_data['user_email'])) {
        throw new Exception('Required fields missing.');
    }

    // Check if username or email already exists
    if (username_exists($user_data['user_login'])) {
        throw new Exception('Username already exists.');
    }

    if (!empty($user_data['user_email']) && email_exists($user_data['user_email'])) {
        throw new Exception('Email already exists.');
    }

    // Hash the password
    $hashed_password = hash_password($user_data['user_pass']);

    // Set default values if not provided
    $user_nicename = isset($user_data['user_nicename']) ? $user_data['user_nicename'] : $user_data['user_login'];
    $display_name = isset($user_data['display_name']) ? $user_data['display_name'] : $user_data['user_login'];
    $user_url = isset($user_data['user_url']) ? $user_data['user_url'] : '';
    $user_registered = isset($user_data['user_registered']) ? $user_data['user_registered'] : date('Y-m-d H:i:s');
    $user_status = isset($user_data['user_status']) ? $user_data['user_status'] : 0;

    $query = "INSERT INTO {$db->prefix()}users (user_login, user_pass, user_nicename, user_email, user_url, user_registered, user_status, display_name)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $params = [
        $user_data['user_login'],
        $hashed_password,
        $user_nicename,
        $user_data['user_email'],
        $user_url,
        $user_registered,
        $user_status,
        $display_name
    ];
    $types = 'ssssssis';

    $db->execute_query($query, $params, $types);

    // Get the inserted user ID
    $user_id = $db->get_connection()->insert_id;

    return $user_id;
}

/**
 * Check if a username exists.
 *
 * @param string $username The username to check.
 * @return bool True if the username exists, false otherwise.
 */
function username_exists($username) {
    global $db;

    $query = "SELECT ID FROM {$db->prefix()}users WHERE user_login = ?";
    $params = [$username];
    $types = 's';

    $result = $db->execute_query($query, $params, $types);

    return $result->num_rows > 0;
}

/**
 * Check if an email exists.
 *
 * @param string $email The email to check.
 * @return bool True if the email exists, false otherwise.
 */
function email_exists($email) {
    global $db;

    $query = "SELECT ID FROM {$db->prefix()}users WHERE user_email = ?";
    $params = [$email];
    $types = 's';

    $result = $db->execute_query($query, $params, $types);

    return $result->num_rows > 0;
}

/**
 * Retrieve a user by a specific field.
 *
 * @param string $field The field to query by (e.g., 'ID', 'user_login').
 * @param mixed $value The value to search for.
 * @return array|false The user data as an associative array or false if not found.
 * @throws Exception If an invalid field is provided.
 */
function get_user_by($field, $value) {
    global $db;

    $allowed_fields = ['ID', 'user_login', 'user_email', 'user_nicename', 'user_url'];
    if (!in_array($field, $allowed_fields)) {
        throw new Exception('Invalid field for get_user_by.');
    }

    $query = "SELECT * FROM {$db->prefix()}users WHERE {$field} = ?";
    $params = [$value];
    $types = 's';

    $result = $db->execute_query($query, $params, $types);

    if ($result->num_rows === 1) {
        return $result->fetch_assoc();
    }

    return false;
}

/**
 * Get user data by ID.
 *
 * @param int $user_id The ID of the user.
 * @return array|false The user data as an associative array or false if not found.
 */
function get_userdata($user_id) {
    $user = get_user_by('ID', $user_id);
    if ($user) {
        return $user;
    }
    return false;
}

/**
 * Get the current logged-in user's ID.
 *
 * @return int The user ID or 0 if not logged in.
 */
function get_current_user_id() {
    global $user;
    if ($user && isset($user['ID'])) {
        return (int)$user['ID'];
    }
    return 0;
}

/**
 * Retrieve a list of users with advanced filtering.
 *
 * @param array $args An associative array of query parameters.
 * @return array An array of user data arrays.
 */
function get_users($args = []) {
    global $db;

    $query = "SELECT * FROM {$db->prefix()}users";
    $conditions = [];
    $params = [];
    $types = '';

    if (!empty($args)) {
        if (isset($args['include']) && is_array($args['include'])) {
            $placeholders = implode(',', array_fill(0, count($args['include']), '?'));
            $conditions[] = "ID IN ($placeholders)";
            $params = array_merge($params, $args['include']);
            $types .= str_repeat('i', count($args['include']));
        }

        if (isset($args['exclude']) && is_array($args['exclude'])) {
            $placeholders = implode(',', array_fill(0, count($args['exclude']), '?'));
            $conditions[] = "ID NOT IN ($placeholders)";
            $params = array_merge($params, $args['exclude']);
            $types .= str_repeat('i', count($args['exclude']));
        }

        if (isset($args['search'])) {
            $conditions[] = "user_login LIKE ?";
            $params[] = '%' . $args['search'] . '%';
            $types .= 's';
        }

        // Additional filters can be added here
    }

    if (!empty($conditions)) {
        $query .= ' WHERE ' . implode(' AND ', $conditions);
    }

    $result = $db->execute_query($query, $params, $types);

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    return $users;
}

/**
 * Count users by role.
 *
 * @param string $role The role to count. If empty, counts all users.
 * @return int The number of users.
 */
function count_users($role = '') {
    global $db;

    if ($role) {
        $query = "SELECT COUNT(DISTINCT u.ID) as count FROM {$db->prefix()}users u
                  INNER JOIN {$db->prefix()}usermeta um ON u.ID = um.user_id
                  WHERE um.meta_key = 'role' AND um.meta_value = ?";
        $params = [$role];
        $types = 's';
    } else {
        $query = "SELECT COUNT(*) as count FROM {$db->prefix()}users";
        $params = [];
        $types = '';
    }

    $result = $db->execute_query($query, $params, $types);
    $row = $result->fetch_assoc();
    return (int)$row['count'];
}

/**
 * Update an existing user.
 *
 * @param int $user_id The ID of the user to update.
 * @param array $userdata An associative array of user data to update.
 * @throws Exception If no valid fields are provided.
 */
function update_user($user_id, $userdata) {
    global $db;

    if (empty($user_id)) {
        throw new Exception('User ID is required.');
    }

    $allowed_fields = ['user_login', 'user_pass', 'user_email', 'user_url', 'user_nicename', 'display_name', 'user_status'];

    $set_clauses = [];
    $params = [];
    $types = '';

    foreach ($userdata as $field => $value) {
        if (in_array($field, $allowed_fields)) {
            if ($field === 'user_pass') {
                $value = hash_password($value);
            }
            $set_clauses[] = "{$field} = ?";
            $params[] = $value;
            $types .= 's';
        }
    }

    if (empty($set_clauses)) {
        throw new Exception('No valid fields to update.');
    }

    $query = "UPDATE {$db->prefix()}users SET " . implode(', ', $set_clauses) . " WHERE ID = ?";
    $params[] = $user_id;
    $types .= 'i';

    $db->execute_query($query, $params, $types);
}

/**
 * Delete a user.
 *
 * @param int $user_id The ID of the user to delete.
 */
function delete_user($user_id) {
    global $db;

    $query = "DELETE FROM {$db->prefix()}users WHERE ID = ?";
    $params = [$user_id];
    $types = 'i';

    $db->execute_query($query, $params, $types);
}

/**
 * Delete multiple users.
 *
 * @param array $user_ids An array of user IDs to delete.
 * @throws Exception If no user IDs are provided.
 */
function delete_users($user_ids = []) {
    global $db;

    if (empty($user_ids)) {
        throw new Exception('No user IDs provided.');
    }

    // Ensure all IDs are integers
    $user_ids = array_map('intval', $user_ids);

    $placeholders = implode(',', array_fill(0, count($user_ids), '?'));
    $query = "DELETE FROM {$db->prefix()}users WHERE ID IN ($placeholders)";
    $types = str_repeat('i', count($user_ids));
    $params = $user_ids;

    $db->execute_query($query, $params, $types);
}

/**
 * Add user metadata.
 *
 * @param int $user_id The ID of the user.
 * @param string $meta_key The metadata key.
 * @param mixed $meta_value The metadata value.
 * @param bool $unique Whether the metadata key should be unique.
 * @return bool True on success, false if the key exists and $unique is true.
 */
function add_user_meta($user_id, $meta_key, $meta_value, $unique = false) {
    global $db;

    if ($unique) {
        $existing = get_user_meta($user_id, $meta_key, true);
        if (!empty($existing)) {
            return false; // Meta key already exists
        }
    }

    $query = "INSERT INTO {$db->prefix()}usermeta (user_id, meta_key, meta_value) VALUES (?, ?, ?)";
    $params = [$user_id, $meta_key, maybe_serialize($meta_value)];
    $types = 'iss';

    $db->execute_query($query, $params, $types);

    return true;
}

/**
 * Update user metadata.
 *
 * @param int $user_id The ID of the user.
 * @param string $meta_key The metadata key.
 * @param mixed $meta_value The new metadata value.
 */
function update_user_meta($user_id, $meta_key, $meta_value) {
    global $db;

    // Check if meta exists
    $existing = get_user_meta($user_id, $meta_key, true);

    if ($existing !== false) {
        $query = "UPDATE {$db->prefix()}usermeta SET meta_value = ? WHERE user_id = ? AND meta_key = ?";
        $params = [maybe_serialize($meta_value), $user_id, $meta_key];
        $types = 'sis';
    } else {
        $query = "INSERT INTO {$db->prefix()}usermeta (user_id, meta_key, meta_value) VALUES (?, ?, ?)";
        $params = [$user_id, $meta_key, maybe_serialize($meta_value)];
        $types = 'iss';
    }

    $db->execute_query($query, $params, $types);
}

/**
 * Retrieve user metadata.
 *
 * @param int $user_id The ID of the user.
 * @param string $meta_key The metadata key. Optional.
 * @param bool $single Whether to return a single value.
 * @return mixed The metadata value(s) or false if not found.
 */
function get_user_meta($user_id, $meta_key = '', $single = false) {
    global $db;

    if ($meta_key) {
        $query = "SELECT meta_value FROM {$db->prefix()}usermeta WHERE user_id = ? AND meta_key = ?";
        $params = [$user_id, $meta_key];
        $types = 'is';
    } else {
        $query = "SELECT meta_key, meta_value FROM {$db->prefix()}usermeta WHERE user_id = ?";
        $params = [$user_id];
        $types = 'i';
    }

    $result = $db->execute_query($query, $params, $types);

    if ($meta_key) {
        if ($result->num_rows === 0) {
            return false;
        }
        if ($single) {
            $row = $result->fetch_assoc();
            return maybe_unserialize($row['meta_value']);
        } else {
            $meta_values = [];
            while ($row = $result->fetch_assoc()) {
                $meta_values[] = maybe_unserialize($row['meta_value']);
            }
            return $meta_values;
        }
    } else {
        $all_meta = [];
        while ($row = $result->fetch_assoc()) {
            $all_meta[$row['meta_key']] = maybe_unserialize($row['meta_value']);
        }
        return $all_meta;
    }
}

/**
 * Delete user metadata.
 *
 * @param int $user_id The ID of the user.
 * @param string $meta_key The metadata key.
 */
function delete_user_meta($user_id, $meta_key) {
    global $db;

    $query = "DELETE FROM {$db->prefix()}usermeta WHERE user_id = ? AND meta_key = ?";
    $params = [$user_id, $meta_key];
    $types = 'is';

    $db->execute_query($query, $params, $types);
}

/**
 * Add a new user role.
 *
 * @param string $role_name The machine-readable name of the role.
 * @param string $display_name The human-readable name of the role. Optional.
 * @param array $capabilities An array of capabilities for the role. Optional.
 * @return bool True on success.
 * @throws Exception If the role already exists.
 */
function add_role($role_name, $display_name = '', $capabilities = []) {
    // Get existing roles
    $roles = get_option('roles');

    if (isset($roles[$role_name])) {
        throw new Exception('Role already exists.');
    }

    $roles[$role_name] = [
        'name' => $display_name ?: $role_name,
        'capabilities' => $capabilities
    ];

    update_option('roles', $roles);

    return true;
}

/**
 * Remove an existing user role.
 *
 * @param string $role_name The machine-readable name of the role.
 * @return bool True on success.
 * @throws Exception If the role does not exist.
 */
function remove_role($role_name) {
    $roles = get_option('roles', []);
    if (!isset($roles[$role_name])) {
        throw new Exception('Role does not exist.');
    }
    unset($roles[$role_name]);
    update_option('roles', $roles);
    return true;
}

/**
 * Get details of a specific role.
 *
 * @param string $role_name The machine-readable name of the role.
 * @return array|false The role details or false if not found.
 */
function get_role($role_name) {
    $roles = get_option('roles', []);
    if (isset($roles[$role_name])) {
        return $roles[$role_name];
    }
    return false;
}

/**
 * Add a capability to a role.
 *
 * @param string $role_name The machine-readable name of the role.
 * @param string $capability The capability to add.
 * @return bool True on success.
 * @throws Exception If the role does not exist.
 */
function add_cap($role_name, $capability) {
    $roles = get_option('roles', []);
    if (!isset($roles[$role_name])) {
        throw new Exception('Role does not exist.');
    }

    if (!in_array($capability, $roles[$role_name]['capabilities'])) {
        $roles[$role_name]['capabilities'][] = $capability;
        update_option('roles', $roles);
    }

    return true;
}

/**
 * Remove a capability from a role.
 *
 * @param string $role_name The machine-readable name of the role.
 * @param string $capability The capability to remove.
 * @return bool True on success.
 * @throws Exception If the role does not exist.
 */
function remove_cap($role_name, $capability) {
    $roles = get_option('roles', []);
    if (!isset($roles[$role_name])) {
        throw new Exception('Role does not exist.');
    }

    $key = array_search($capability, $roles[$role_name]['capabilities']);
    if ($key !== false) {
        unset($roles[$role_name]['capabilities'][$key]);
        // Reindex the array
        $roles[$role_name]['capabilities'] = array_values($roles[$role_name]['capabilities']);
        update_option('roles', $roles);
    }

    return true;
}

/**
 * Check if the current user has a specific capability.
 *
 * @param string $capability The capability to check.
 * @return bool True if the user has the capability, false otherwise.
 */
function current_user_can($capability) {
    if (!is_user_logged_in()) {
        return false;
    }

    $user = $GLOBALS['user'];
    $user_role = get_user_meta($user['ID'], 'role', true);
    if (!$user_role) {
        return false;
    }

    $role = get_role($user_role);
    if (!$role) {
        return false;
    }

    return in_array($capability, $role['capabilities']);
}

/**
 * Check if a specific user has a capability.
 *
 * @param int $user_id The ID of the user.
 * @param string $capability The capability to check.
 * @return bool True if the user has the capability, false otherwise.
 */
function user_can($user_id, $capability) {
    $user_role = get_user_meta($user_id, 'role', true);
    if (!$user_role) {
        return false;
    }

    $role = get_role($user_role);
    if (!$role) {
        return false;
    }

    return in_array($capability, $role['capabilities']);
}

/**
 * Get the current user's session token.
 *
 * @return string|false The session token or false if not found.
 */
function get_session_token() {
    if (!is_user_logged_in()) {
        return false;
    }

    $user_id = get_current_user_id();
    return get_user_meta($user_id, 'session_token', true);
}

/**
 * Log in a user with optional remember me functionality.
 *
 * @param string $username The username.
 * @param string $password The password.
 * @param bool $remember Whether to remember the user for 30 days. Default is false (2 days).
 * @return bool True on successful login.
 * @throws Exception If authentication fails.
 */
function signon($identifier, $password, $remember = false) {
    global $db;

    // get user from email or username.
    $user = get_user_by(str_contains($identifier, '@') ? 'user_email' : 'user_login', $identifier);

    if (!$user) {
        throw new Exception('Invalid username or password.');
    }

    // Verify password
    if (!check_password($password, $user['user_pass'])) {
        throw new Exception('Invalid username or password.');
    }

    // Set auth cookie
    set_auth_cookie($user['ID'], $remember, isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' );

    // Update global $user variable
    global $user;
    $user = get_userdata($user['ID']);

    return true;
}

/**
 * Set authentication cookies.
 *
 * @param int $user_id The ID of the user.
 * @param bool $remember Whether to remember the user for 30 days.
 * @param bool $secure Whether to set the secure flag on the cookie.
 */
function set_auth_cookie($user_id, $remember = false, $secure = false) {

    $user = get_user_by('ID', $user_id);
    if (empty($token)) {
        $token = $user['user_login'] . '-' . generate_auth_key();
    }

    // Set the session token and expiration in usermeta
    if ($remember) {
        $expiration = time() + 30 * DAY_IN_SECONDS; // 30 days
    } else {
        $expiration = time() + 2 * DAY_IN_SECONDS; // 2 days
    }

    $signon_sessions_json = get_user_meta($user_id, 'session_token', true);
    $signon_sessions = $signon_sessions_json ? $signon_sessions_json : array();

    // Limit to 10 sessions
    if (count($signon_sessions) >= 10) {
        array_shift($signon_sessions); // Remove the oldest session
    }

    $session_created = array(
        'session_token' => $token,
        'expiration' => $expiration,
        'ua' => $_SERVER['HTTP_USER_AGENT'],
        'nonce' => array(),
    );

    // Append the new session
    $signon_sessions[] = $session_created;

    // Update usermeta
    update_user_meta($user_id, 'session_token', serialize($signon_sessions));

    // Set the auth cookie
    setcookie('auth_token', $token, $expiration, '/', '', $secure, true);
}

/**
 * Remove all authentication cookies.
 */
function remove_auth_cookie() {
    setcookie('auth_token', '', time() - 3600, '/', '', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on', true);
}

/**
 * Validate the authentication cookie.
 *
 * @param string $token The session token from the cookie.
 * @return bool True if valid, false otherwise.
 */
function validate_auth_cookie($token) {
    $user = get_user_by('user_login', explode('-', $token)[0]);

    if($user_sessions = get_user_meta($user['ID'],'session_token', true)) {
        // Current time
        $current_time = time();

        // Iterate over the nested arrays.
        foreach ($user_sessions as $session) {
            // Check if 'expiration' key exists and if the session is still valid
            if (isset($session['expiration']) && $session['expiration'] >= $current_time) {
                $active_sessions[] = $session;
            }
        }


        foreach ($active_sessions as $session) {
            if ($session['session_token'] === $token && $session['ua'] === $_SERVER['HTTP_USER_AGENT']) {
                return true;
            }
        }
    }

    return false;
}

/**
 * Check if a user is currently logged in.
 *
 * @return bool True if logged in, false otherwise.
 */
function is_user_logged_in() {
    if (isset($_COOKIE['auth_token'])) {
        return validate_auth_cookie($_COOKIE['auth_token']);
    }
    return false;
}

/**
 * Log out the current user.
 */
function logout() {
    if (!is_user_logged_in()) {
        return;
    }

    $user_id = get_current_user_id();

    $sessions = get_user_meta($user_id, 'session_token', true);

    $current_token = $_COOKIE['auth_token'];

    // Remove the session with the matching token
    $sessions = array_filter($sessions, function($session) use ($current_token) {
        return $session['session_token'] !== $current_token;
    });

    // Remove session data
    update_user_meta($user_id, 'session_token', $sessions);

    // Remove auth cookie
    remove_auth_cookie();

    // Clear global $user variable
    global $user;
    $user = null;
}

/**
 * Destroy the current user's session.
 */
function destroy_current_session() {
    if (!is_user_logged_in()) {
        return;
    }

    $user_id = get_current_user_id();
    delete_user_meta($user_id, 'session_token');
    delete_user_meta($user_id, 'session_expiration');
    delete_user_meta($user_id, 'remember_me');
    remove_auth_cookie();

    // Clear global $user variable
    global $user;
    $user = null;
}

/**
 * Serialize data if necessary.
 *
 * @param mixed $data The data to serialize.
 * @return mixed The serialized data or the original data.
 */
function maybe_serialize($data) {
    if (is_array($data) || is_object($data)) {
        return serialize($data);
    }
    return $data;
}

/**
 * Unserialize data if it is serialized.
 *
 * @param mixed $data The data to unserialize.
 * @return mixed The unserialized data or the original data.
 */
function maybe_unserialize($data) {
    if (is_serialized($data)) {
        return @unserialize($data);
    }
    return $data;
}

/**
 * Get the user ID associated with a session token.
 *
 * @param string $token The session token.
 * @return int The user ID or 0 if not found.
 */
function get_user_id_by_session_token($token) {

    $user = get_user_by('user_login', explode('-', $token)[0]);

    if($user_sessions = get_user_meta($user['ID'],'session_token')) {
        // Current time
        $current_time = time();

        // Iterate over the nested arrays
        foreach ($user_sessions as $outer_array) {
            foreach ($outer_array as $session) {
                // Check if 'expiration' key exists and if the session is still valid
                if (isset($session['expiration']) && $session['expiration'] >= $current_time) {
                    $active_sessions[] = $session;
                }
            }
        }

        foreach ($active_sessions as $session) {
            if ($session['session_token'] === $token && $session['ua'] === $_SERVER['HTTP_USER_AGENT']) {
                $user['session_token'] = '';
                return $user['ID'];
            }
        }
    }

    return 0;
}

/**
 * Bearer Token Genrator.
 */
function generate_bearer_token($key) {
    $bearer_token = bin2hex(random_bytes(32));
    update_option( $key . '_bearer_token', $bearer_token);
    return $bearer_token;
}

function get_all_bearer_token() {
    global $db;
    $query = "SELECT option_name, option_value FROM " . $db->prefix() . "options WHERE option_name LIKE '%_bearer_token'";
    $result = $db->execute_query($query);
    $bearer_tokens = array();
    while ($row = $result->fetch_assoc()) {
        $bearer_tokens[preg_replace('/_bearer_token$/', '', $row['option_name'])] = $row['option_value'];
    }
    return $bearer_tokens;
}

function delete_bearer_token($key) {
    return delete_option($key . '_bearer_token');
}

function is_bearer() {
    if (isset($_SERVER['HTTP_AUTH_KEY']) && isset($_SERVER['HTTP_AUTHORIZATION']) && str_starts_with($_SERVER['HTTP_AUTHORIZATION'], 'Bearer ')) {
        $key_bearer_value = get_option($_SERVER['HTTP_AUTH_KEY'] . '_bearer_token');
        return $key_bearer_value === substr($_SERVER['HTTP_AUTHORIZATION'], 7);
    }
    return false;
}

function is_bearer_active() {
    return get_option('bearer') === 'yes';
}

/**
 * Retrieve all roles.
 *
 * @return array An associative array of roles.
 */
function get_all_roles() {
    return get_option('roles', []);
}

/**
 * Define Role Names and Display Names
 */
$roles_to_create = [
    'admin' => 'Administrator',
    'subscriber' => 'Subscriber'
];

/**
 * Define Capabilities for Each Role
 */
$role_capabilities = [
    'admin' => [
        'manage_options',    // Ability to manage site options
        'edit_posts',        // Ability to edit posts
        'edit_users',        // Ability to edit users
        'delete_users',      // Ability to delete users
        'create_posts',      // Ability to create posts
        'publish_posts',     // Ability to publish posts
        'edit_pages',        // Ability to edit pages
        'manage_categories', // Ability to manage categories
        'moderate_comments', // Ability to moderate comments
        'manage_roles',      // Ability to manage roles
        // Add more capabilities as needed
    ],
    'subscriber' => [
        'read',              // Ability to read content
        'create_posts',      // Ability to create posts (for forum participation)
        'edit_posts',        // Ability to edit their own posts
        'delete_posts',      // Ability to delete their own posts
        // Add more capabilities as needed
    ]
];

/**
 * Ensure that the specified role exists. If it doesn't, the role is created.
 *
 * @param string $role_name        The machine-readable name of the role.
 * @param string $display_name     The human-readable name of the role.
 * @param array  $capabilities     An array of capabilities assigned to the role.
 *
 * @return void
 */
function ensure_role_exists($role_name, $display_name, $capabilities) {
    try {
        // Check if the role already exists
        $existing_role = get_role($role_name);
        if (!$existing_role) {
            // Add the new role
            add_role($role_name, $display_name, $capabilities);
        }
    } catch (Exception $e) {
        echo "Error creating role '" . esc_html($role_name) . "': " . esc_html($e->getMessage()) . "<br>";
    }
}

/**
 * Create all defined roles.
 *
 * @param array $roles_to_create      An associative array of role names and display names.
 * @param array $role_capabilities    An associative array of role capabilities.
 *
 * @return void
 */
function create_roles($roles_to_create, $role_capabilities) {
    foreach ($roles_to_create as $role_name => $display_name) {
        // Get capabilities for the role
        $capabilities = isset($role_capabilities[$role_name]) ? $role_capabilities[$role_name] : [];
        
        // Ensure the role exists with the defined capabilities
        ensure_role_exists($role_name, $display_name, $capabilities);
    }
}

// Execute the role creation
create_roles($roles_to_create, $role_capabilities);
