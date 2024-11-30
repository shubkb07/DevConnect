<?php
/**
 * Hook.php
 *
 * Contains functions for managing hooks: actions and filters.
 *
 * @package CustomHooks
 * @version 1.0.0
 */

// Ensure no direct access
defined('ABSPATH') || exit;
/*
 * Global array to store all hooks.
 *
 * @var array
 */
$GLOBALS['custom_hooks'] = array(
	'actions' => array(),
	'filters' => array(),
);


/**
 * Adds a filter to a specific hook.
 *
 * @param string   $hook_name The name of the filter hook.
 * @param callable $callback  The callback to be run when the filter is applied.
 * @param integer  $priority  Optional. Used to specify the order in which the functions
 *                            associated with a particular action are executed. Default 10.
 */
function add_filter(string $hook_name, callable $callback, int $priority = 10): void
{
	global $custom_hooks;

	if (! isset($custom_hooks['filters'][$hook_name])) {
		  $custom_hooks['filters'][$hook_name] = array();
	}

	$custom_hooks['filters'][$hook_name][$priority][] = $callback;
}//end add_filter()


/**
 * Applies filters to a value.
 *
 * @param string $hook_name The name of the filter hook.
 * @param mixed  $value     The value to be filtered.
 * @param mixed  ...$args   Additional parameters to pass to the callback functions.
 *
 * @return mixed The filtered value.
 */
function apply_filters(string $hook_name, $value, ...$args) {
	global $custom_hooks;

	if (! isset($custom_hooks['filters'][$hook_name])) {
		  return $value;
	}

 // end if
	ksort($custom_hooks['filters'][$hook_name]);

	foreach ($custom_hooks['filters'][$hook_name] as $callbacks) {
		foreach ($callbacks as $callback) {
			if (is_callable($callback)) {
				$value = $callback($value, ...$args);
			}
		}
	}

	return $value;

}//end apply_filters()


/**
 * Adds an action to a specific hook.
 *
 * @param string   $hook_name The name of the action hook.
 * @param callable $callback  The callback to be run when the action is fired.
 * @param integer  $priority  Optional. Used to specify the order in which the functions
 *                            associated with a particular action are executed. Default 10.
 */
function add_action(string $hook_name, callable $callback, int $priority = 10): void
{
	global $custom_hooks;

	if (! isset($custom_hooks['actions'][$hook_name])) {
		  $custom_hooks['actions'][$hook_name] = array();
	}

	$custom_hooks['actions'][$hook_name][$priority][] = $callback;

}//end add_action()


/**
 * Executes all callbacks attached to an action hook.
 *
 * @param string $hook_name The name of the action hook.
 * @param mixed  ...$args   Optional. Additional arguments passed to the callback functions.
 */
function do_action(string $hook_name, ...$args): void
{
	global $custom_hooks;

	if (! isset($custom_hooks['actions'][$hook_name])) {
		  return;
	}

 // end if
	ksort($custom_hooks['actions'][$hook_name]);

	foreach ($custom_hooks['actions'][$hook_name] as $callbacks) {
		foreach ($callbacks as $callback) {
			if (is_callable($callback)) {
				$callback(...$args);
			}
		}
	}

}//end do_action()


/**
 * Removes a filter from a hook.
 *
 * @param string   $hook_name The name of the filter hook.
 * @param callable $callback  The callback to be removed.
 * @param integer  $priority  Optional. The priority of the callback. Default 10.
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

}//end remove_filter()


/**
 * Removes an action from a hook.
 *
 * @param string   $hook_name The name of the action hook.
 * @param callable $callback  The callback to be removed.
 * @param integer  $priority  Optional. The priority of the callback. Default 10.
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

}//end remove_action()


/**
 * Checks if a filter has been registered for a hook.
 *
 * @param string   $hook_name The name of the filter hook.
 * @param callable $callback  Optional. The callback to check for. Default null.
 *
 * @return boolean True if the filter exists, false otherwise.
 */
function has_filter(string $hook_name, callable $callback = null): bool
{
	global $custom_hooks;

	if (! isset($custom_hooks['filters'][$hook_name])) {
		  return false;
	}

	if ($callback === null) {
		 return ! empty($custom_hooks['filters'][$hook_name]);
	}

	foreach ($custom_hooks['filters'][$hook_name] as $priority => $callbacks) {
		if (in_array($callback, $callbacks, true)) {
			return true;
		}
	}

	return false;

}//end has_filter()


/**
 * Checks if an action has been registered for a hook.
 *
 * @param string   $hook_name The name of the action hook.
 * @param callable $callback  Optional. The callback to check for. Default null.
 *
 * @return boolean True if the action exists, false otherwise.
 */
function has_action(string $hook_name, callable $callback = null): bool
{
	global $custom_hooks;

	if (! isset($custom_hooks['actions'][$hook_name])) {
		  return false;
	}

	if ($callback === null) {
		 return ! empty($custom_hooks['actions'][$hook_name]);
	}

	foreach ($custom_hooks['actions'][$hook_name] as $priority => $callbacks) {
		if (in_array($callback, $callbacks, true)) {
			return true;
		}
	}

	return false;

}//end has_action()


/**
 * Removes all filters from a hook.
 *
 * @param string  $hook_name The name of the filter hook.
 * @param integer $priority  Optional. The priority number to remove. Default null.
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

}//end remove_all_filters()


/**
 * Removes all actions from a hook.
 *
 * @param string  $hook_name The name of the action hook.
 * @param integer $priority  Optional. The priority number to remove. Default null.
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

}//end remove_all_actions()
