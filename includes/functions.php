<?php
/**
 * Functions
 *
 * Provides functions for sanitizing and filtering HTML content securely.
 * Includes helper functions for attribute checking, protocol validation,
 * entity decoding, and HTML parsing.
 *
 * @package Functions
 * @version 1.0.0
 */

$funtions_files_names = array(
	'configuration',
	'connection',
	'hook',
	'kses',
	'escaping',
	'sanitization',
	'i18n',
	'options',
	'user',
	'posts',
);

foreach ($funtions_files_names as $file_name) {
	include_once ABSPATH . 'includes/functions/' . $file_name . '.php';
}