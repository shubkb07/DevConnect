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
    'hook',
    'kses',
    'escaping',
    'sanitization',
    'i18n',
);

foreach ($funtions_files_names as $file_name) {
    require_once ABSPATH . 'includes/functions/' .$file_name . '.php';
}