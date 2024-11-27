<?php
/**
 * i18n.php
 *
 * Provides functions for internationalization and localization.
 *
 * @package CustomI18n
 * @version 1.0.0
 */

// Ensure no direct access
defined('ABSPATH') || exit;

/**
 * Global array to store translations.
 *
 * @var array
 */
$GLOBALS['global_translations'] = [];

/**
 * Global variable to store the current locale.
 *
 * @var string
 */
$GLOBALS['current_locale'] = 'en_US'; // Default locale

/**
 * Initializes the current locale from the 'language' cookie.
 * Sanitizes the locale name before setting it.
 */
function init_locale_from_cookie(): void
{
    if (isset($_COOKIE['language'])) {
        $locale = sanitize_locale_name($_COOKIE['language']);
        if (!empty($locale)) {
            set_locale($locale);
        }
    }
}

// Initialize the locale from the cookie
init_locale_from_cookie();

/**
 * Sets the current locale.
 *
 * @param string $locale The locale to set.
 */
function set_locale(string $locale): void
{
    global $current_locale;

    // Sanitize the locale name
    $locale = sanitize_locale_name($locale);

    if (!empty($locale)) {
        $current_locale = $locale;
    }
}

/**
 * Gets the current locale.
 *
 * @return string The current locale.
 */
function get_locale(): string
{
    global $current_locale;
    return $current_locale;
}

/**
 * Registers a single translation.
 *
 * @param string      $domain          The text domain.
 * @param string      $text            The original text.
 * @param string      $translated_text The translated text.
 * @param string|null $context         Optional. The context for the translation.
 * @param string|null $locale          Optional. The locale for which the translation is registered.
 *                                     Default is null, which means the current locale is used.
 */
function register_translation(string $domain, string $text, string $translated_text, ?string $context = null, ?string $locale = null): void
{
    global $global_translations;

    // Use the provided locale or default to current locale
    $locale = $locale ?? get_locale();

    // Initialize the domain if not set
    if (!isset($global_translations[$domain])) {
        $global_translations[$domain] = [];
    }

    // Initialize the locale for the domain if not set
    if (!isset($global_translations[$domain][$locale])) {
        $global_translations[$domain][$locale] = ['no_context' => [], 'contexts' => []];
    }

    if ($context === null) {
        // No context
        $global_translations[$domain][$locale]['no_context'][$text] = $translated_text;
    } else {
        // With context
        if (!isset($global_translations[$domain][$locale]['contexts'][$context])) {
            $global_translations[$domain][$locale]['contexts'][$context] = [];
        }
        $global_translations[$domain][$locale]['contexts'][$context][$text] = $translated_text;
    }
}

/**
 * Registers a text domain with translations.
 *
 * @param string      $domain        The text domain.
 * @param array       $translations  An associative array of translations.
 *                                   Format: array('original_text' => 'translated_text', ...)
 * @param string|null $locale        Optional. The locale for which the translations are registered.
 *                                   Default is null, which means the current locale is used.
 */
function register_text_domain(string $domain, array $translations, ?string $locale = null): void
{
    foreach ($translations as $original_text => $translated_text) {
        // Ensure both original and translated texts are strings
        if (is_string($original_text) && is_string($translated_text)) {
            register_translation($domain, $original_text, $translated_text, null, $locale);
        }
    }
}

/**
 * Registers context-based translations for a text domain.
 *
 * @param string      $domain        The text domain.
 * @param array       $translations  An associative array of context-based translations.
 *                                   Format: array('context' => array('original_text' => 'translated_text', ...), ...)
 * @param string|null $locale        Optional. The locale for which the translations are registered.
 *                                   Default is null, which means the current locale is used.
 */
function register_context_translations(string $domain, array $translations, ?string $locale = null): void
{
    foreach ($translations as $context => $context_translations) {
        if (is_array($context_translations)) {
            foreach ($context_translations as $original_text => $translated_text) {
                if (is_string($original_text) && is_string($translated_text)) {
                    register_translation($domain, $original_text, $translated_text, $context, $locale);
                }
            }
        }
    }
}

/**
 * Translates text.
 *
 * @param string $text   The text to translate.
 * @param string $domain Optional. The text domain. Default 'default'.
 *
 * @return string The translated text.
 */
function translate(string $text, string $domain = 'default'): string
{
    global $global_translations;

    $locale = get_locale();

    if (isset($global_translations[$domain][$locale]['no_context'][$text])) {
        $translated = $global_translations[$domain][$locale]['no_context'][$text];

        /**
         * Filter the translated text.
         *
         * @param string $translated The translated text.
         * @param string $text       The original text.
         * @param string $domain     The text domain.
         */
        return apply_filters('translate', $translated, $text, $domain);
    }

    /**
     * Filter the original text if no translation is found.
     *
     * @param string $text   The original text.
     * @param string $domain The text domain.
     */
    return apply_filters('translate', $text, $text, $domain);
}

/**
 * Translates text with context.
 *
 * @param string $text    The text to translate.
 * @param string $context The context for the translation.
 * @param string $domain  Optional. The text domain. Default 'default'.
 *
 * @return string The translated text.
 */
function translate_with_gettext_context(string $text, string $context, string $domain = 'default'): string
{
    global $global_translations;

    $locale = get_locale();

    if (isset($global_translations[$domain][$locale]['contexts'][$context][$text])) {
        $translated = $global_translations[$domain][$locale]['contexts'][$context][$text];

        /**
         * Filter the translated text with context.
         *
         * @param string $translated The translated text.
         * @param string $text       The original text.
         * @param string $context    The context.
         * @param string $domain     The text domain.
         */
        return apply_filters('translate_with_gettext_context', $translated, $text, $context, $domain);
    }

    /**
     * Filter the original text if no translation is found.
     *
     * @param string $text    The original text.
     * @param string $context The context.
     * @param string $domain  The text domain.
     */
    return apply_filters('translate_with_gettext_context', $text, $text, $context, $domain);
}

/**
 * Retrieves the translated text.
 *
 * @param string $text   The text to translate.
 * @param string $domain Optional. The text domain. Default 'default'.
 *
 * @return string The translated text.
 */
function __(string $text, string $domain = 'default'): string
{
    return translate($text, $domain);
}

/**
 * Displays the translated text.
 *
 * @param string $text   The text to translate and display.
 * @param string $domain Optional. The text domain. Default 'default'.
 */
function _e(string $text, string $domain = 'default'): void
{
    echo translate($text, $domain);
}

/**
 * Retrieves the translated text with context.
 *
 * @param string $text    The text to translate.
 * @param string $context The context for the translation.
 * @param string $domain  Optional. The text domain. Default 'default'.
 *
 * @return string The translated text.
 */
function _x(string $text, string $context, string $domain = 'default'): string
{
    return translate_with_gettext_context($text, $context, $domain);
}

/**
 * Displays the translated text with context.
 *
 * @param string $text    The text to translate and display.
 * @param string $context The context for the translation.
 * @param string $domain  Optional. The text domain. Default 'default'.
 */
function _ex(string $text, string $context, string $domain = 'default'): void
{
    echo translate_with_gettext_context($text, $context, $domain);
}

/**
 * Retrieves the translated text and escapes it for use in an attribute.
 *
 * @param string $text   The text to translate.
 * @param string $domain Optional. The text domain. Default 'default'.
 *
 * @return string The escaped, translated text.
 */
function esc_attr__(string $text, string $domain = 'default'): string
{
    $translated = __( $text, $domain );
    $escaped = esc_attr( $translated );

    /**
     * Filter the escaped, translated text.
     *
     * @param string $escaped    The escaped, translated text.
     * @param string $text       The original text.
     * @param string $domain     The text domain.
     */
    return apply_filters('esc_attr__', $escaped, $text, $domain);
}

/**
 * Retrieves the translated text and escapes it for use in HTML output.
 *
 * @param string $text   The text to translate.
 * @param string $domain Optional. The text domain. Default 'default'.
 *
 * @return string The escaped, translated text.
 */
function esc_html__(string $text, string $domain = 'default'): string
{
    $translated = __( $text, $domain );
    $escaped = esc_html( $translated );

    /**
     * Filter the escaped, translated text.
     *
     * @param string $escaped    The escaped, translated text.
     * @param string $text       The original text.
     * @param string $domain     The text domain.
     */
    return apply_filters('esc_html__', $escaped, $text, $domain);
}

/**
 * Displays the translated text, escaped for use in an attribute.
 *
 * @param string $text   The text to translate and display.
 * @param string $domain Optional. The text domain. Default 'default'.
 */
function esc_attr_e(string $text, string $domain = 'default'): void
{
    $translated = __( $text, $domain );
    $escaped = esc_attr( $translated );

    /**
     * Filter the escaped, translated text.
     *
     * @param string $escaped    The escaped, translated text.
     * @param string $text       The original text.
     * @param string $domain     The text domain.
     */
    $filtered = apply_filters('esc_attr_e', $escaped, $text, $domain);

    echo $filtered;
}

/**
 * Displays the translated text, escaped for use in HTML output.
 *
 * @param string $text   The text to translate and display.
 * @param string $domain Optional. The text domain. Default 'default'.
 */
function esc_html_e(string $text, string $domain = 'default'): void
{
    $translated = __( $text, $domain );
    $escaped = esc_html( $translated );

    /**
     * Filter the escaped, translated text.
     *
     * @param string $escaped    The escaped, translated text.
     * @param string $text       The original text.
     * @param string $domain     The text domain.
     */
    $filtered = apply_filters('esc_html_e', $escaped, $text, $domain);

    echo $filtered;
}

/**
 * Retrieves the translated text with context and escapes it for use in an attribute.
 *
 * @param string $text    The text to translate.
 * @param string $context The context for the translation.
 * @param string $domain  Optional. The text domain. Default 'default'.
 *
 * @return string The escaped, translated text.
 */
function esc_attr_x(string $text, string $context, string $domain = 'default'): string
{
    $translated = _x( $text, $context, $domain );
    $escaped = esc_attr( $translated );

    /**
     * Filter the escaped, translated text.
     *
     * @param string $escaped    The escaped, translated text.
     * @param string $text       The original text.
     * @param string $context    The context.
     * @param string $domain     The text domain.
     */
    return apply_filters('esc_attr_x', $escaped, $text, $context, $domain);
}

/**
 * Retrieves the translated text with context and escapes it for use in HTML output.
 *
 * @param string $text    The text to translate.
 * @param string $context The context for the translation.
 * @param string $domain  Optional. The text domain. Default 'default'.
 *
 * @return string The escaped, translated text.
 */
function esc_html_x(string $text, string $context, string $domain = 'default'): string
{
    $translated = _x( $text, $context, $domain );
    $escaped = esc_html( $translated );

    /**
     * Filter the escaped, translated text.
     *
     * @param string $escaped    The escaped, translated text.
     * @param string $text       The original text.
     * @param string $context    The context.
     * @param string $domain     The text domain.
     */
    return apply_filters('esc_html_x', $escaped, $text, $context, $domain);
}
