<?php
/**
 * Contains Escaping Functions.
 *
 * PHP Version 8.3
 *
 * @category Main
 * @package  DevConnect
 * @author   Shubham <shub@shub.com>
 * @license  https://www.mit.edu/~amini/LICENSE.md MIT License
 * @link     https://shubkb.com
 */

if (! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

// Get the request URI.
$_URI = explode('/', trim(explode('?', trim($_SERVER['REQUEST_URI'], '/'))[0], '/'));

if ( file_exists( ABSPATH . 'config.php' ) ) {
	include_once ABSPATH . 'config.php';
	include_once ABSPATH . 'includes/functions.php';
	if ( ! defined( 'SITE_STATUS' ) ) {
		die('SITE_STATUS needs to be defined as given in config-sample.php');
	} elseif ( 'PRE_SETUP' === SITE_STATUS ) {
		if ( 1 === count($_URI) && $_URI[0] === 'site-setup' ) {
			include_once ABSPATH . 'admin/site-setup.php';
			die();
		} else {
			header('Location: /site-setup', true, 307);
		}
	}
} else {
	if ( 1 === count($_URI) && $_URI[0] === 'setup' ) {
		include_once ABSPATH . 'admin/setup.php';
		die();
	} else {
		header('Location: /setup', true, 307);
	}
}

if ( 1 === count($_URI) && $_URI[0] === 'login' ) {
	include_once ABSPATH . 'admin/login.php';
	exit();
} elseif ( 1 === count($_URI) && $_URI[0] === 'logout' ) {
	logout();
}

if ( $_URI[0] === 'admin' && is_user_logged_in() ) {
	include_once ABSPATH . 'admin/admin.php';
	exit();
}

// json empty.
header('content-type: application/json');
header('Access-Control-Allow-Origin: *');

if ( $_URI[0] === 'api' ) {
	include_once ABSPATH . 'includes/api.php';
	die();
}

if ( $_URI[0] === '' ) {
	echo json_encode(
		array(
			'status' => 'ok',
			'message' => 'Welcome to DevConnect API',
			'user' => $user,
			'server' => $_SERVER,
			'ip' => $ip,
		)
	);
} else {
	echo json_encode(
		array(
			'status' => '404',
			'message' => 'Not Found',
			'user' => $user,
			'server' => $_SERVER,
			'ip' => $ip,
		)
	);
}
