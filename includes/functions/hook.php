<?php
/**
 * hook.php
 *
 * Contains functions for managing hooks: actions and filters.
 *
 * @package CustomHooks
 * @version 1.0.0
 */

// Ensure no direct access
defined('ABSPATH') || exit;

/**
 * Global array to store all hooks.
 *
 * @var array
 */
$GLOBALS['custom_hooks'] = [
    'actions' => [],
    'filters' => [],
];

/**
 * Adds a filter to a specific hook.
 *
 * @param string   $hook_name     The name of the filter hook.
 * @param callable $callback      The callback to be run when the filter is applied.
 * @param int      $priority      Optional. Used to specify the order in which the functions
 *                                associated with a particular action are executed. Default 10.
 */
function add_filter(string $hook_name, callable $callback, int $priority = 10): void
{
    global $custom_hooks;

    if (!isset($custom_hooks['filters'][$hook_name])) {
        $custom_hooks['filters'][$hook_name] = [];
    }

    $custom_hooks['filters'][$hook_name][$priority][] = $callback;
}

/**
 * Applies filters to a value.
 *
 * @param string $hook_name The name of the filter hook.
 * @param mixed  $value     The value to be filtered.
 * @param mixed  ...$args   Additional parameters to pass to the callback functions.
 *
 * @return mixed The filtered value.
 */
function apply_filters(string $hook_name, $value, ...$args)
{
    global $custom_hooks;

    if (!isset($custom_hooks['filters'][$hook_name])) {
        return $value;
    }

    // Sort callbacks by priority
    ksort($custom_hooks['filters'][$hook_name]);

    foreach ($custom_hooks['filters'][$hook_name] as $callbacks) {
        foreach ($callbacks as $callback) {
            if (is_callable($callback)) {
                $value = $callback($value, ...$args);
            }
        }
    }

    return $value;
}

/**
 * Adds an action to a specific hook.
 *
 * @param string   $hook_name The name of the action hook.
 * @param callable $callback  The callback to be run when the action is fired.
 * @param int      $priority  Optional. Used to specify the order in which the functions
 *                            associated with a particular action are executed. Default 10.
 */
function add_action(string $hook_name, callable $callback, int $priority = 10): void
{
    global $custom_hooks;

    if (!isset($custom_hooks['actions'][$hook_name])) {
        $custom_hooks['actions'][$hook_name] = [];
    }

    $custom_hooks['actions'][$hook_name][$priority][] = $callback;
}

/**
 * Executes all callbacks attached to an action hook.
 *
 * @param string $hook_name The name of the action hook.
 * @param mixed  ...$args   Optional. Additional arguments passed to the callback functions.
 */
function do_action(string $hook_name, ...$args): void
{
    global $custom_hooks;

    if (!isset($custom_hooks['actions'][$hook_name])) {
        return;
    }

    // Sort callbacks by priority
    ksort($custom_hooks['actions'][$hook_name]);

    foreach ($custom_hooks['actions'][$hook_name] as $callbacks) {
        foreach ($callbacks as $callback) {
            if (is_callable($callback)) {
                $callback(...$args);
            }
        }
    }
}

/**
 * Removes a filter from a hook.
 *
 * @param string   $hook_name The name of the filter hook.
 * @param callable $callback  The callback to be removed.
 * @param int      $priority  Optional. The priority of the callback. Default 10.
 */
function remove_filter(string $hook_name, callable $callback, int $priority = 10): void
{
    global $custom_hooks;

    if (isset($custom_hooks['filters'][$hook_name][$priority])) {
        foreach ($custom_hooks['filters'][$hook_name][$priority] as $key => $registered_callback) {
            if ($registered_callback === $callback) {
                unset($custom_hooks['filters'][$hook_name][$priority][$key]);
            }
        }
    }
}

/**
 * Removes an action from a hook.
 *
 * @param string   $hook_name The name of the action hook.
 * @param callable $callback  The callback to be removed.
 * @param int      $priority  Optional. The priority of the callback. Default 10.
 */
function remove_action(string $hook_name, callable $callback, int $priority = 10): void
{
    global $custom_hooks;

    if (isset($custom_hooks['actions'][$hook_name][$priority])) {
        foreach ($custom_hooks['actions'][$hook_name][$priority] as $key => $registered_callback) {
            if ($registered_callback === $callback) {
                unset($custom_hooks['actions'][$hook_name][$priority][$key]);
            }
        }
    }
}

/**
 * Checks if a filter has been registered for a hook.
 *
 * @param string   $hook_name The name of the filter hook.
 * @param callable $callback  Optional. The callback to check for. Default null.
 *
 * @return bool True if the filter exists, false otherwise.
 */
function has_filter(string $hook_name, callable $callback = null): bool
{
    global $custom_hooks;

    if (!isset($custom_hooks['filters'][$hook_name])) {
        return false;
    }

    if ($callback === null) {
        return !empty($custom_hooks['filters'][$hook_name]);
    }

    foreach ($custom_hooks['filters'][$hook_name] as $priority => $callbacks) {
        if (in_array($callback, $callbacks, true)) {
            return true;
        }
    }

    return false;
}

/**
 * Checks if an action has been registered for a hook.
 *
 * @param string   $hook_name The name of the action hook.
 * @param callable $callback  Optional. The callback to check for. Default null.
 *
 * @return bool True if the action exists, false otherwise.
 */
function has_action(string $hook_name, callable $callback = null): bool
{
    global $custom_hooks;

    if (!isset($custom_hooks['actions'][$hook_name])) {
        return false;
    }

    if ($callback === null) {
        return !empty($custom_hooks['actions'][$hook_name]);
    }

    foreach ($custom_hooks['actions'][$hook_name] as $priority => $callbacks) {
        if (in_array($callback, $callbacks, true)) {
            return true;
        }
    }

    return false;
}

/**
 * Removes all filters from a hook.
 *
 * @param string $hook_name The name of the filter hook.
 * @param int    $priority  Optional. The priority number to remove. Default null.
 */
function remove_all_filters(string $hook_name, int $priority = null): void
{
    global $custom_hooks;

    if (isset($custom_hooks['filters'][$hook_name])) {
        if ($priority === null) {
            unset($custom_hooks['filters'][$hook_name]);
        } else {
            unset($custom_hooks['filters'][$hook_name][$priority]);
        }
    }
}

/**
 * Removes all actions from a hook.
 *
 * @param string $hook_name The name of the action hook.
 * @param int    $priority  Optional. The priority number to remove. Default null.
 */
function remove_all_actions(string $hook_name, int $priority = null): void
{
    global $custom_hooks;

    if (isset($custom_hooks['actions'][$hook_name])) {
        if ($priority === null) {
            unset($custom_hooks['actions'][$hook_name]);
        } else {
            unset($custom_hooks['actions'][$hook_name][$priority]);
        }
    }
}
