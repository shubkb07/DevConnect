<?php
/**
 * escaping.php
 *
 * Provides functions for safely escaping data for output in various contexts.
 * These functions help prevent injection vulnerabilities and ensure data integrity.
 *
 * @package CustomEscaping
 * @version 1.0.0
 */

// Ensure no direct access
defined('ABSPATH') || exit;

/**
 * Escapes data for use in SQL queries.
 *
 * **Note:** It's highly recommended to use prepared statements and parameterized queries
 * instead of manual escaping to prevent SQL injection attacks.
 *
 * @param mixed $data The data to be escaped.
 *
 * @return mixed The escaped data.
 */
function esc_sql($data)
{
	// If data is an array, recursively escape each value.
	if (is_array($data)) {
		foreach ($data as $key => $value) {
			$data[$key] = esc_sql($value);
		}
		return $data;
	}

	// Ensure the data is a scalar value.
	if (!is_scalar($data)) {
		return '';
	}

	// Escape special characters for use in SQL statements.
	$escaped_data = addslashes($data);

	/**
	 * Filter the SQL escaped data.
	 *
	 * @param mixed $escaped_data The escaped data.
	 * @param mixed $data         The original data.
	 */
	return apply_filters('esc_sql', $escaped_data, $data);
}

/**
 * Sanitizes a URL for safe use in HTML attributes.
 *
 * @param string $url        The URL to be sanitized.
 * @param array  $protocols  Optional. An array of allowed URL protocols.
 *                           Default is global $allowed_protocols.
 * @param string $_context   Optional. The context for the URL. Default 'display'.
 *
 * @return string The sanitized URL.
 */
function esc_url(string $url, array $protocols = null, string $_context = 'display'): string
{
	// Use default protocols if none are provided.
	$protocols = $protocols ?? $GLOBALS['allowed_protocols'];

	// Remove control characters and trim the URL.
	$url = trim($url);
	$url = preg_replace('/[\x00-\x1F\x7F]/u', '', $url);

	// Sanitize the URL using kses functions.
	$clean_url = kses_clean_url($url);

	// Escape the URL for HTML output.
	$clean_url = esc_html($clean_url);

	/**
	 * Filter the escaped URL.
	 *
	 * @param string $clean_url The sanitized URL.
	 * @param string $url       The original URL.
	 * @param string $_context  The context for the URL.
	 */
	return apply_filters('esc_url', $clean_url, $url, $_context);
}

/**
 * Sanitizes a URL for database storage.
 *
 * @param string $url       The URL to be sanitized.
 * @param array  $protocols Optional. An array of allowed URL protocols.
 *                          Default is global $allowed_protocols.
 *
 * @return string The sanitized URL.
 */
function esc_url_raw(string $url, array $protocols = null): string
{
	// Use default protocols if none are provided.
	$protocols = $protocols ?? $GLOBALS['allowed_protocols'];

	// Remove control characters and trim the URL.
	$url = trim($url);
	$url = preg_replace('/[\x00-\x1F\x7F]/u', '', $url);

	// Sanitize the URL using kses functions.
	$clean_url = kses_clean_url($url);

	/**
	 * Filter the raw escaped URL.
	 *
	 * @param string $clean_url The sanitized URL.
	 * @param string $url       The original URL.
	 */
	return apply_filters('esc_url_raw', $clean_url, $url);
}

/**
 * Escapes text for safe use in JavaScript strings.
 *
 * @param string $text The text to be escaped.
 *
 * @return string The escaped text.
 */
function esc_js(string $text): string
{
	// Escape special characters.
	$safe_text = str_replace(
		['\\', "'", '"', "\n", "\r", "</"],
		['\\\\', "\\'", '\\"', '\\n', '\\r', '<\/'],
		$text
	);

	/**
	 * Filter the escaped JavaScript text.
	 *
	 * @param string $safe_text The escaped text.
	 * @param string $text      The original text.
	 */
	return apply_filters('esc_js', $safe_text, $text);
}

/**
 * Escapes text for safe use in HTML output.
 *
 * @param string $text The text to be escaped.
 *
 * @return string The escaped text.
 */
function esc_html(string $text): string
{
	$safe_text = htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

	/**
	 * Filter the escaped HTML text.
	 *
	 * @param string $safe_text The escaped text.
	 * @param string $text      The original text.
	 */
	return apply_filters('esc_html', $safe_text, $text);
}

/**
 * Escapes text for safe use in HTML attributes.
 *
 * @param string $text The text to be escaped.
 *
 * @return string The escaped text.
 */
function esc_attr(string $text): string
{
	$safe_text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false);

	/**
	 * Filter the escaped attribute text.
	 *
	 * @param string $safe_text The escaped text.
	 * @param string $text      The original text.
	 */
	return apply_filters('esc_attr', $safe_text, $text);
}

/**
 * Escapes text for safe use inside textarea elements.
 *
 * @param string $text The text to be escaped.
 *
 * @return string The escaped text.
 */
function esc_textarea(string $text): string
{
	$safe_text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

	/**
	 * Filter the escaped textarea text.
	 *
	 * @param string $safe_text The escaped text.
	 * @param string $text      The original text.
	 */
	return apply_filters('esc_textarea', $safe_text, $text);
}

/**
 * Escapes text for safe use in XML documents.
 *
 * @param string $text The text to be escaped.
 *
 * @return string The escaped text.
 */
function esc_xml(string $text): string
{
	$safe_text = htmlspecialchars($text, ENT_QUOTES | ENT_XML1, 'UTF-8');

	/**
	 * Filter the escaped XML text.
	 *
	 * @param string $safe_text The escaped text.
	 * @param string $text      The original text.
	 */
	return apply_filters('esc_xml', $safe_text, $text);
}
