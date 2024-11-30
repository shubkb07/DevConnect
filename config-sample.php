<?php
/**
 * Pre-load Global Variables
 *
 * @package pre-load
 */

// Database Configuration.
define('DB_HOST', '');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_NAME', '');
define('DB_PREFIX', '');
define( 'DB_CHARSET', 'utf8' );
define('DB_COLLATE', '');

// Site Settings.
// SIte Status before setup PRE_SETUP, after setup ACTIVE, or in maintainace mode MAINTENANCE.
define('SITE_STATUS', 'PRE_SETUP');
define('ENFORCE_HTTPS', true);
define('SECURE_AUTH_KEY', '');
define('LOGGED_IN_KEY', '');
define('NONCE_KEY', '');
define('AUTH_SALT', '');
define('SECURE_AUTH_SALT', '');
define('LOGGED_IN_SALT', '');
define('NONCE_SALT', '');
define('CACHE_KEY_SALT', '');
