<?php

/**
 * Sanitization
 *
 * Contains functions for sanitizing data inputs.
 *
 * @package CustomSanitization
 * @version 1.0.0
 */

declare(strict_types=1);

// Ensure no direct access
defined('ABSPATH') || exit;

/**
 * Sanitizes a username string.
 *
 * Removes unsafe characters from a username.
 *
 * @param string $username The username to sanitize.
 * @param bool   $strict   Optional. If true, only alphanumeric characters are allowed. Default false.
 *
 * @return string The sanitized username.
 */
function sanitize_user(string $username, bool $strict = false): string
{
    $raw_username = $username;

    // Remove all HTML tags.
    $username = strip_tags($username);

    // Remove accents.
    $username = remove_accents($username);

    // Optionally remove all characters except alphanumeric.
    if ($strict) {
        $username = preg_replace('/[^a-zA-Z0-9]/', '', $username);
    } else {
        $username = preg_replace('/[^a-zA-Z0-9 _.\-@]/', '', $username);
    }

    /**
     * Filter the sanitized username.
     *
     * @param string $username     The sanitized username.
     * @param string $raw_username The original username.
     * @param bool   $strict       Whether strict sanitization is applied.
     */
    return apply_filters('sanitize_user', $username, $raw_username, $strict);
}

/**
 * Sanitizes a string key.
 *
 * @param string $key The key to sanitize.
 *
 * @return string The sanitized key.
 */
function sanitize_key(string $key): string
{
    $raw_key = $key;

    // Lowercase and remove invalid characters.
    $key = strtolower($key);
    $key = preg_replace('/[^a-z0-9_\-]/', '', $key);

    /**
     * Filter the sanitized key.
     *
     * @param string $key     The sanitized key.
     * @param string $raw_key The original key.
     */
    return apply_filters('sanitize_key', $key, $raw_key);
}

/**
 * Sanitizes a title, replacing whitespace and non-alphanumeric characters with dashes.
 *
 * @param string $title          The title to sanitize.
 * @param string $fallback_title Optional. A title to use if $title is empty.
 * @param string $context        Optional. The context for the sanitization. Default 'save'.
 *
 * @return string The sanitized title.
 */
function sanitize_title(string $title, string $fallback_title = '', string $context = 'save'): string
{
    $raw_title = $title;

    // Remove HTML tags.
    $title = strip_tags($title);

    // Remove accents.
    $title = remove_accents($title);

    // Convert to lowercase.
    $title = strtolower($title);

    // Replace non-alphanumeric characters with dashes.
    $title = preg_replace('/[^a-z0-9\s\-]/', '', $title);

    // Replace multiple whitespace or dashes with a single dash.
    $title = preg_replace('/[\s\-]+/', '-', $title);

    // Trim leading and trailing dashes.
    $title = trim($title, '-');

    // If the title is empty, use the fallback title.
    if (empty($title) && !empty($fallback_title)) {
        $title = sanitize_title($fallback_title, '', $context);
    }

    /**
     * Filter the sanitized title.
     *
     * @param string $title      The sanitized title.
     * @param string $raw_title  The original title.
     * @param string $context    The context for the sanitization.
     */
    return apply_filters('sanitize_title', $title, $raw_title, $context);
}

/**
 * Sanitizes a title for use in queries.
 *
 * @param string $title The title to sanitize.
 *
 * @return string The sanitized title.
 */
function sanitize_title_for_query(string $title): string
{
    // Reuse sanitize_title with appropriate context.
    $title = sanitize_title($title, '', 'query');

    /**
     * Filter the sanitized title for query.
     *
     * @param string $title The sanitized title.
     */
    return apply_filters('sanitize_title_for_query', $title);
}

/**
 * Sanitizes a title, replacing whitespace and non-alphanumeric characters with dashes.
 *
 * @param string $title     The title to sanitize.
 * @param string $raw_title Optional. Not used, kept for compatibility.
 * @param string $context   Optional. The context for the sanitization. Default 'display'.
 *
 * @return string The sanitized title.
 */
function sanitize_title_with_dashes(string $title, string $raw_title = '', string $context = 'display'): string
{
    // Use sanitize_title with the provided context.
    $title = sanitize_title($title, '', $context);

    /**
     * Filter the sanitized title with dashes.
     *
     * @param string $title     The sanitized title.
     * @param string $raw_title The original title.
     * @param string $context   The context for the sanitization.
     */
    return apply_filters('sanitize_title_with_dashes', $title, $raw_title, $context);
}

/**
 * Sanitizes an ORDER BY clause for use in SQL queries.
 *
 * @param string $orderby The ORDER BY clause to sanitize.
 *
 * @return string The sanitized ORDER BY clause.
 */
function sanitize_sql_orderby(string $orderby): string
{
    $raw_orderby = $orderby;

    // Remove any characters that are not allowed in SQL ORDER BY clauses.
    $orderby = preg_replace('/[^a-zA-Z0-9_,\s\.`]/', '', $orderby);

    /**
     * Filter the sanitized ORDER BY clause.
     *
     * @param string $orderby     The sanitized ORDER BY clause.
     * @param string $raw_orderby The original ORDER BY clause.
     */
    return apply_filters('sanitize_sql_orderby', $orderby, $raw_orderby);
}

/**
 * Sanitizes an HTML class string.
 *
 * @param string $class    The class string to sanitize.
 * @param string $fallback Optional. A fallback value if the class is empty.
 *
 * @return string The sanitized class string.
 */
function sanitize_html_class(string $class, string $fallback = ''): string
{
    $raw_class = $class;

    // Remove invalid characters.
    $class = preg_replace('/[^a-zA-Z0-9_\-]/', '', $class);

    // If the class is empty, use the fallback.
    if (empty($class) && !empty($fallback)) {
        $class = sanitize_html_class($fallback);
    }

    /**
     * Filter the sanitized HTML class.
     *
     * @param string $class     The sanitized class.
     * @param string $raw_class The original class.
     * @param string $fallback  The fallback value.
     */
    return apply_filters('sanitize_html_class', $class, $raw_class, $fallback);
}

/**
 * Sanitizes a locale name.
 *
 * @param string $locale_name The locale name to sanitize.
 *
 * @return string The sanitized locale name.
 */
function sanitize_locale_name(string $locale_name): string
{
    $raw_locale_name = $locale_name;

    // Lowercase and remove invalid characters.
    $locale_name = strtolower($locale_name);
    $locale_name = preg_replace('/[^a-z0-9_\-]/', '', $locale_name);

    /**
     * Filter the sanitized locale name.
     *
     * @param string $locale_name     The sanitized locale name.
     * @param string $raw_locale_name The original locale name.
     */
    return apply_filters('sanitize_locale_name', $locale_name, $raw_locale_name);
}

/**
 * Sanitizes an email address.
 *
 * @param string $email The email address to sanitize.
 *
 * @return string The sanitized email address.
 */
function sanitize_email(string $email): string
{
    $raw_email = $email;

    // Remove illegal characters.
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    /**
     * Filter the sanitized email address.
     *
     * @param string $email     The sanitized email.
     * @param string $raw_email The original email.
     */
    return apply_filters('sanitize_email', $email, $raw_email);
}

/**
 * Sanitizes a URL.
 *
 * @param string $url       The URL to sanitize.
 * @param array  $protocols Optional. An array of allowed protocols.
 *
 * @return string The sanitized URL.
 */
function sanitize_url(string $url, array $protocols = null): string
{
    // Use esc_url() for sanitization.
    $url = esc_url($url, $protocols);

    /**
     * Filter the sanitized URL.
     *
     * @param string $url The sanitized URL.
     */
    return apply_filters('sanitize_url', $url);
}

/**
 * Sanitizes an option value based on the option name.
 *
 * @param string $option The name of the option.
 * @param mixed  $value  The value of the option.
 *
 * @return mixed The sanitized value.
 */
function sanitize_option(string $option, $value)
{
    $raw_value = $value;

    // Add custom sanitization rules based on the option name.
    switch ($option) {
        case 'email':
            $value = sanitize_email($value);
            break;
        case 'url':
            $value = sanitize_url($value);
            break;
        case 'text':
            $value = sanitize_text_field($value);
            break;
        default:
            // Default sanitization.
            $value = sanitize_text_field($value);
            break;
    }

    /**
     * Filter the sanitized option value.
     *
     * @param mixed  $value     The sanitized value.
     * @param string $option    The option name.
     * @param mixed  $raw_value The original value.
     */
    return apply_filters('sanitize_option', $value, $option, $raw_value);
}

/**
 * Sanitizes a string from user input or from the database.
 *
 * @param string $str The string to sanitize.
 *
 * @return string The sanitized string.
 */
function sanitize_text_field(string $str): string
{
    $raw_str = $str;

    // Remove all HTML tags.
    $str = strip_tags($str);

    // Remove control characters.
    $str = preg_replace('/[\x00-\x1F\x7F]/u', '', $str);

    // Trim whitespace.
    $str = trim($str);

    /**
     * Filter the sanitized text field.
     *
     * @param string $str     The sanitized string.
     * @param string $raw_str The original string.
     */
    return apply_filters('sanitize_text_field', $str, $raw_str);
}

/**
 * Sanitizes a textarea field.
 *
 * @param string $str The textarea content to sanitize.
 *
 * @return string The sanitized content.
 */
function sanitize_textarea_field(string $str): string
{
    $raw_str = $str;

    // Remove all HTML tags except allowed tags.
    $allowed_tags = [
        'br' => [],
        'em' => [],
        'strong' => [],
        // Add more tags if needed.
    ];

    $str = kses($str, $allowed_tags);

    /**
     * Filter the sanitized textarea field.
     *
     * @param string $str     The sanitized string.
     * @param string $raw_str The original string.
     */
    return apply_filters('sanitize_textarea_field', $str, $raw_str);
}

/**
 * Sanitizes a MIME type.
 *
 * @param string $mime_type The MIME type to sanitize.
 *
 * @return string The sanitized MIME type.
 */
function sanitize_mime_type(string $mime_type): string
{
    $raw_mime_type = $mime_type;

    // Remove invalid characters.
    $mime_type = preg_replace('/[^a-zA-Z0-9\.\+\-\/]/', '', $mime_type);

    /**
     * Filter the sanitized MIME type.
     *
     * @param string $mime_type     The sanitized MIME type.
     * @param string $raw_mime_type The original MIME type.
     */
    return apply_filters('sanitize_mime_type', $mime_type, $raw_mime_type);
}

/**
 * Sanitizes trackback URLs.
 *
 * @param string $to_ping The trackback URLs to sanitize.
 *
 * @return string The sanitized trackback URLs.
 */
function sanitize_trackback_urls(string $to_ping): string
{
    $raw_to_ping = $to_ping;

    // Split URLs by line breaks.
    $urls = preg_split('/[\r\n]+/', $to_ping);

    $sanitized_urls = [];

    foreach ($urls as $url) {
        $url = sanitize_url($url);
        if (!empty($url)) {
            $sanitized_urls[] = $url;
        }
    }

    // Join URLs back into a string.
    $to_ping = implode("\n", $sanitized_urls);

    /**
     * Filter the sanitized trackback URLs.
     *
     * @param string $to_ping     The sanitized trackback URLs.
     * @param string $raw_to_ping The original trackback URLs.
     */
    return apply_filters('sanitize_trackback_urls', $to_ping, $raw_to_ping);
}

/**
 * Sanitizes a hex color string, e.g. '#ff0000' or 'ff0000'.
 *
 * @param string $color The hex color string to sanitize.
 *
 * @return string|null The sanitized hex color (with hash), or null if invalid.
 */
function sanitize_hex_color(string $color): ?string
{
    $raw_color = $color;

    // Add hash if missing.
    if ('#' !== substr($color, 0, 1)) {
        $color = '#' . $color;
    }

    // Validate hex color.
    if (preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
        /**
         * Filter the sanitized hex color.
         *
         * @param string $color     The sanitized color.
         * @param string $raw_color The original color.
         */
        return apply_filters('sanitize_hex_color', $color, $raw_color);
    }

    return null;
}

/**
 * Sanitizes a hex color string without hash, e.g. 'ff0000'.
 *
 * @param string $color The hex color string to sanitize.
 *
 * @return string|null The sanitized hex color (without hash), or null if invalid.
 */
function sanitize_hex_color_no_hash(string $color): ?string
{
    $raw_color = $color;

    // Remove hash if present.
    $color = ltrim($color, '#');

    // Validate hex color.
    if (preg_match('/^[0-9a-fA-F]{6}$/', $color)) {
        /**
         * Filter the sanitized hex color without hash.
         *
         * @param string $color     The sanitized color.
         * @param string $raw_color The original color.
         */
        return apply_filters('sanitize_hex_color_no_hash', $color, $raw_color);
    }

    return null;
}

/**
 * Removes accents from characters.
 *
 * @param string $string The string to remove accents from.
 *
 * @return string The string with accents removed.
 */
function remove_accents(string $string): string
{
    // Check if Normalizer class exists
    if (class_exists('Normalizer')) {
        // Normalize to decomposed form (NFD)
        $string = \Normalizer::normalize($string, \Normalizer::FORM_D);
        if ($string === false) {
            // Normalization failed, return original string
            return $string;
        }
        // Remove diacritic marks
        $string = preg_replace('/\p{Mn}/u', '', $string);
    } else {
        // Fallback if Normalizer class is not available
        $chars = [
            // Latin-1 Supplement
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A',
            'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE','Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
            'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O',
            'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O',
            'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U',
            'Ý' => 'Y', 'Þ' => 'TH','ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a',
            'ä' => 'a', 'å' => 'a', 'æ' => 'ae','ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
            'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o',
            'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
            'ý' => 'y', 'þ' => 'th','ÿ' => 'y',

            // Latin Extended-A
            'Ā' => 'A', 'ā' => 'a',
            'Ă' => 'A', 'ă' => 'a',
            'Ą' => 'A', 'ą' => 'a',
            'Ć' => 'C', 'ć' => 'c',
            'Ĉ' => 'C', 'ĉ' => 'c',
            'Ċ' => 'C', 'ċ' => 'c',
            'Č' => 'C', 'č' => 'c',
            'Ď' => 'D', 'ď' => 'd',
            'Đ' => 'D', 'đ' => 'd',
            'Ē' => 'E', 'ē' => 'e',
            'Ĕ' => 'E', 'ĕ' => 'e',
            'Ė' => 'E', 'ė' => 'e',
            'Ę' => 'E', 'ę' => 'e',
            'Ě' => 'E', 'ě' => 'e',
            'Ĝ' => 'G', 'ĝ' => 'g',
            'Ğ' => 'G', 'ğ' => 'g',
            'Ġ' => 'G', 'ġ' => 'g',
            'Ģ' => 'G', 'ģ' => 'g',
            'Ĥ' => 'H', 'ĥ' => 'h',
            'Ħ' => 'H', 'ħ' => 'h',
            'Ĩ' => 'I', 'ĩ' => 'i',
            'Ī' => 'I', 'ī' => 'i',
            'Ĭ' => 'I', 'ĭ' => 'i',
            'Į' => 'I', 'į' => 'i',
            'İ' => 'I', 'ı' => 'i',
            'Ĳ' => 'IJ','ĳ' => 'ij',
            'Ĵ' => 'J', 'ĵ' => 'j',
            'Ķ' => 'K', 'ķ' => 'k',
            'Ĺ' => 'L', 'ĺ' => 'l',
            'Ļ' => 'L', 'ļ' => 'l',
            'Ľ' => 'L', 'ľ' => 'l',
            'Ŀ' => 'L', 'ŀ' => 'l',
            'Ł' => 'L', 'ł' => 'l',
            'Ń' => 'N', 'ń' => 'n',
            'Ņ' => 'N', 'ņ' => 'n',
            'Ň' => 'N', 'ň' => 'n',
            'Ŋ' => 'N', 'ŋ' => 'n',
            'Ō' => 'O', 'ō' => 'o',
            'Ŏ' => 'O', 'ŏ' => 'o',
            'Ő' => 'O', 'ő' => 'o',
            'Œ' => 'OE','œ' => 'oe',
            'Ŕ' => 'R', 'ŕ' => 'r',
            'Ŗ' => 'R', 'ŗ' => 'r',
            'Ř' => 'R', 'ř' => 'r',
            'Ś' => 'S', 'ś' => 's',
            'Ŝ' => 'S', 'ŝ' => 's',
            'Ş' => 'S', 'ş' => 's',
            'Š' => 'S', 'š' => 's',
            'Ţ' => 'T', 'ţ' => 't',
            'Ť' => 'T', 'ť' => 't',
            'Ŧ' => 'T', 'ŧ' => 't',
            'Ũ' => 'U', 'ũ' => 'u',
            'Ū' => 'U', 'ū' => 'u',
            'Ŭ' => 'U', 'ŭ' => 'u',
            'Ů' => 'U', 'ů' => 'u',
            'Ű' => 'U', 'ű' => 'u',
            'Ų' => 'U', 'ų' => 'u',
            'Ŵ' => 'W', 'ŵ' => 'w',
            'Ŷ' => 'Y', 'ŷ' => 'y',
            'Ÿ' => 'Y',
            'Ź' => 'Z', 'ź' => 'z',
            'Ż' => 'Z', 'ż' => 'z',
            'Ž' => 'Z', 'ž' => 'z',
            'ſ' => 's',

            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D',
            'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => 'Th',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M',
            'Ν' => 'N', 'Ξ' => 'Ks','Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y',
            'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'Ps','Ω' => 'O',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd',
            'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => 'th',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm',
            'ν' => 'n', 'ξ' => 'ks','ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y',
            'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps','ω' => 'o',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o',
            'ύ' => 'y', 'ή' => 'h', 'ώ' => 'o', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

            // Cyrillic
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G',
            'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo','Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
            'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch','Ш' => 'Sh','Щ' => 'Sh','Ъ' => '',
            'Ы' => 'Y', 'Ь' => '',  'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g',
            'д' => 'd', 'е' => 'e', 'ё' => 'yo','ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch','ш' => 'sh','щ' => 'sh','ъ' => '',
            'ы' => 'y', 'ь' => '',  'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',

            // Special characters
            '©' => '(c)', '®' => '(r)', '™' => '(tm)', '℠' => '(sm)', '…' => '...',
            '€' => 'euro', '£' => 'pound', '¥' => 'yen', '$' => 'dollar',
        ];

        $string = strtr($string, $chars);
    }

    return $string;
}
