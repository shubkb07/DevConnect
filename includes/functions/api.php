<?php

if (!defined('ABSPATH')) {
	die('Direct access not allowed.');
}

// Global variable to store API routes.
$api = [];

/**
 * Register an API route.
 *
 * @param string $namespace The namespace for the API route.
 * @param string $api_name The name of the API route.
 * @param string $method The HTTP method for the API route.
 * @param callable $callback The callback function for the API route.
 * @param array $explanation An explanation of the API route.
 */
function register_api_route($namespace, $api_name, $method, $callback, $explanation) {
	global $api;

	$api[] = [
		'namespace' => $namespace,
		'api_name' => $api_name,
		'method' => strtoupper($method),
		'callback' => $callback,
		'explanation' => $explanation,
	];
}

// Include all API function files.
$functions_files_names = [
	'posts',
	'users',
	'authentication',
	'comments',
	'notification',
	'tags',
];

foreach ($functions_files_names as $file_name) {
	include_once ABSPATH . 'includes/api/' . $file_name . '.php';
}

// Handle incoming API requests.
if (isset($_URI) && is_array($_URI)) {
	global $api;

	// If the URI length is 3, process the request.
	if (count($_URI) === 3) {
		$namespace = $_URI[1];
		$api_name = $_URI[2];
		$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

		foreach ($api as $route) {
			if (
				$route['namespace'] === $namespace &&
				$route['api_name'] === $api_name &&
				$route['method'] === $request_method
			) {
				// Parse PUT, DELETE, and PATCH data if necessary.
				if ($request_method === 'PUT') {
					parse_str(file_get_contents('php://input'), $put_vars);
				} elseif ($request_method === 'DELETE') {
					parse_str(file_get_contents('php://input'), $delete_vars);
				} elseif ($request_method === 'PATCH') {
					parse_str(file_get_contents('php://input'), $patch_vars);
				}

				// Combine all parameter sources with priority.
				$parameters = [];
				$all_sources = [
					'POST' => array_map('esc_html', $_POST),
					'GET' => array_map('esc_html', $_GET),
					'COOKIE' => array_map('esc_html', $_COOKIE),
					'PUT' => isset($put_vars) ? array_map('esc_html', $put_vars) : [],
					'DELETE' => isset($delete_vars) ? array_map('esc_html', $delete_vars) : [],
					'PATCH' => isset($patch_vars) ? array_map('esc_html', $patch_vars) : [],
				];

				// Start with the method-specific parameters.
				if (isset($all_sources[$request_method])) {
					$parameters = $all_sources[$request_method];
					unset($all_sources[$request_method]); // Remove the highest-priority source.
				}

				// Merge remaining sources in priority order (POST > GET > COOKIE > PUT > DELETE > PATCH).
				foreach ($all_sources as $source) {
					$parameters = array_merge($source, $parameters);
				}

				// Call the registered callback with the parameters.
				echo json_encode(call_user_func($route['callback'], $parameters));
				die();
			}
		}

		// If no route matches, return a 404 response.
		echo json_encode([
			'status' => '404',
			'message' => 'Not Found',
		]);
		die();
	}

	// If URI length is more than 1 but no route matches, return a 404 response.
	if (count($_URI) > 1) {
		echo json_encode([
			'status' => '404',
			'message' => 'Not Found',
		]);
		die();
	}

	// If URI length is 1, return the list of registered APIs.
	if (count($_URI) === 1) {
		// Generate formatted explanations for each API route.
		$api_explanations = array_map(function ($route) {
			return [
				'path' => "https://be.loc/api/{$route['namespace']}/{$route['api_name']}",
				'usage' => $route['explanation'],
			];
		}, $api);

		// Output the explanations as JSON.
		echo json_encode($api_explanations);
		die();
	}
}
