<?php
/**
 * kses.php
 *
 * Provides functions for sanitizing and filtering HTML content securely.
 * Includes helper functions for attribute checking, protocol validation,
 * entity decoding, and HTML parsing.
 *
 * @package CustomKSES
 * @version 1.0.0
 */

// Ensure no direct access
defined('ABSPATH') || exit;

/**
 * Complete array of allowed HTML tags and their allowed attributes.
 *
 * @var array
 */
$allowed_html = [
    // Text-level semantics
    'a'          => [
        'href'      => true,
        'title'     => true,
        'rel'       => true,
        'target'    => true,
        'download'  => true,
        'hreflang'  => true,
        'type'      => true,
        'name'      => true,
    ],
    'abbr'       => [
        'title' => true,
    ],
    'b'          => [],
    'bdi'        => [
        'dir' => true,
    ],
    'bdo'        => [
        'dir' => true,
    ],
    'br'         => [],
    'cite'       => [],
    'code'       => [],
    'data'       => [
        'value' => true,
    ],
    'dfn'        => [
        'title' => true,
    ],
    'em'         => [],
    'i'          => [],
    'kbd'        => [],
    'mark'       => [],
    'q'          => [
        'cite' => true,
    ],
    'rp'         => [],
    'rt'         => [],
    'rtc'        => [],
    'ruby'       => [],
    's'          => [],
    'samp'       => [],
    'small'      => [],
    'span'       => [
        'class' => true,
        'style' => true,
        'id'    => true,
    ],
    'strong'     => [],
    'sub'        => [],
    'sup'        => [],
    'time'       => [
        'datetime' => true,
    ],
    'u'          => [],
    'var'        => [],
    'wbr'        => [],

    // Content sectioning
    'address'    => [],
    'article'    => [],
    'aside'      => [],
    'footer'     => [],
    'header'     => [],
    'h1'         => [],
    'h2'         => [],
    'h3'         => [],
    'h4'         => [],
    'h5'         => [],
    'h6'         => [],
    'main'       => [],
    'nav'        => [],
    'section'    => [],

    // Grouping content
    'blockquote' => [
        'cite' => true,
    ],
    'dd'         => [],
    'div'        => [
        'class' => true,
        'id'    => true,
        'style' => true,
    ],
    'dl'         => [],
    'dt'         => [],
    'figcaption' => [],
    'figure'     => [],
    'hr'         => [],
    'li'         => [
        'value' => true,
    ],
    'ol'         => [
        'reversed' => true,
        'start'    => true,
        'type'     => true,
    ],
    'p'          => [
        'class' => true,
        'style' => true,
    ],
    'pre'        => [],
    'ul'         => [],

    // Table content
    'table'      => [
        'border'       => true,
        'cellpadding'  => true,
        'cellspacing'  => true,
        'summary'      => true,
        'width'        => true,
        'class'        => true,
        'id'           => true,
        'style'        => true,
    ],
    'caption'    => [],
    'col'        => [
        'align'   => true,
        'char'    => true,
        'charoff' => true,
        'span'    => true,
        'valign'  => true,
        'width'   => true,
    ],
    'colgroup'   => [
        'align'   => true,
        'char'    => true,
        'charoff' => true,
        'span'    => true,
        'valign'  => true,
        'width'   => true,
    ],
    'tbody'      => [
        'align'   => true,
        'char'    => true,
        'charoff' => true,
        'valign'  => true,
    ],
    'td'         => [
        'abbr'    => true,
        'align'   => true,
        'axis'    => true,
        'bgcolor' => true,
        'char'    => true,
        'charoff' => true,
        'colspan' => true,
        'headers' => true,
        'height'  => true,
        'nowrap'  => true,
        'rowspan' => true,
        'scope'   => true,
        'valign'  => true,
        'width'   => true,
        'style'   => true,
        'class'   => true,
        'id'      => true,
    ],
    'tfoot'      => [
        'align'   => true,
        'char'    => true,
        'charoff' => true,
        'valign'  => true,
    ],
    'th'         => [
        'abbr'    => true,
        'align'   => true,
        'axis'    => true,
        'bgcolor' => true,
        'char'    => true,
        'charoff' => true,
        'colspan' => true,
        'headers' => true,
        'height'  => true,
        'nowrap'  => true,
        'rowspan' => true,
        'scope'   => true,
        'valign'  => true,
        'width'   => true,
        'style'   => true,
        'class'   => true,
        'id'      => true,
    ],
    'thead'      => [
        'align'   => true,
        'char'    => true,
        'charoff' => true,
        'valign'  => true,
    ],
    'tr'         => [
        'align'   => true,
        'bgcolor' => true,
        'char'    => true,
        'charoff' => true,
        'valign'  => true,
    ],

    // Forms
    'button'     => [
        'disabled' => true,
        'name'     => true,
        'type'     => true,
        'value'    => true,
        'autofocus'=> true,
        'form'     => true,
        'formaction'=> true,
        'formenctype'=> true,
        'formmethod'=> true,
        'formnovalidate'=> true,
        'formtarget'=> true,
    ],
    'datalist'   => [],
    'fieldset'   => [
        'disabled' => true,
        'form'     => true,
        'name'     => true,
    ],
    'form'       => [
        'action'  => true,
        'method'  => true,
        'enctype' => true,
        'name'    => true,
        'target'  => true,
        'accept-charset' => true,
        'autocomplete' => true,
        'novalidate' => true,
    ],
    'input'      => [
        'accept'     => true,
        'align'      => true,
        'alt'        => true,
        'autocomplete' => true,
        'autofocus'  => true,
        'checked'    => true,
        'dirname'    => true,
        'disabled'   => true,
        'form'       => true,
        'formaction' => true,
        'formenctype'=> true,
        'formmethod' => true,
        'formnovalidate'=> true,
        'formtarget' => true,
        'height'     => true,
        'list'       => true,
        'max'        => true,
        'maxlength'  => true,
        'min'        => true,
        'multiple'   => true,
        'name'       => true,
        'pattern'    => true,
        'placeholder'=> true,
        'readonly'   => true,
        'required'   => true,
        'size'       => true,
        'src'        => true,
        'step'       => true,
        'type'       => true,
        'value'      => true,
        'width'      => true,
    ],
    'label'      => [
        'for' => true,
        'form' => true,
    ],
    'legend'     => [],
    'meter'      => [
        'value'   => true,
        'min'     => true,
        'max'     => true,
        'low'     => true,
        'high'    => true,
        'optimum' => true,
        'form'    => true,
    ],
    'optgroup'   => [
        'disabled' => true,
        'label'    => true,
    ],
    'option'     => [
        'disabled' => true,
        'label'    => true,
        'selected' => true,
        'value'    => true,
    ],
    'select'     => [
        'disabled' => true,
        'form'     => true,
        'multiple' => true,
        'name'     => true,
        'required' => true,
        'size'     => true,
    ],
    'textarea'   => [
        'cols'     => true,
        'dirname'  => true,
        'disabled' => true,
        'form'     => true,
        'maxlength'=> true,
        'name'     => true,
        'placeholder' => true,
        'readonly' => true,
        'required' => true,
        'rows'     => true,
        'wrap'     => true,
    ],
    'output'     => [
        'for'      => true,
        'form'     => true,
        'name'     => true,
    ],
    'progress'   => [
        'max'      => true,
        'value'    => true,
    ],

    // Embedded content
    'audio'      => [
        'autoplay' => true,
        'controls' => true,
        'loop'     => true,
        'muted'    => true,
        'preload'  => true,
        'src'      => true,
    ],
    'img'        => [
        'alt'      => true,
        'crossorigin' => true,
        'height'   => true,
        'ismap'    => true,
        'longdesc' => true,
        'referrerpolicy' => true,
        'sizes'    => true,
        'src'      => true,
        'srcset'   => true,
        'usemap'   => true,
        'width'    => true,
    ],
    'video'      => [
        'autoplay' => true,
        'controls' => true,
        'height'   => true,
        'loop'     => true,
        'muted'    => true,
        'poster'   => true,
        'preload'  => true,
        'src'      => true,
        'width'    => true,
    ],
    'source'     => [
        'media'    => true,
        'src'      => true,
        'type'     => true,
        'sizes'    => true,
        'srcset'   => true,
    ],
    'track'      => [
        'default'  => true,
        'kind'     => true,
        'label'    => true,
        'src'      => true,
        'srclang'  => true,
    ],
    'embed'      => [
        'height'   => true,
        'src'      => true,
        'type'     => true,
        'width'    => true,
    ],
    'iframe'     => [
        'src'             => true,
        'height'          => true,
        'width'           => true,
        'name'            => true,
        'sandbox'         => true,
        'allow'           => true,
        'allowfullscreen' => true,
        'referrerpolicy'  => true,
        'frameborder'     => true,
        'scrolling'       => true,
    ],
    'object'     => [
        'data'     => true,
        'type'     => true,
        'height'   => true,
        'width'    => true,
        'classid'  => true,
        'codebase' => true,
        'codetype' => true,
        'name'     => true,
        'usemap'   => true,
        'form'     => true,
    ],
    'param'      => [
        'name'     => true,
        'value'    => true,
    ],

    // Scripting
    'script'     => [
        'src'      => true,
        'type'     => true,
        'async'    => true,
        'defer'    => true,
        'crossorigin' => true,
        'integrity'   => true,
        'nomodule'    => true,
    ],
    'noscript'   => [],

    // Other
    'del'        => [
        'cite'     => true,
        'datetime' => true,
    ],
    'ins'        => [
        'cite'     => true,
        'datetime' => true,
    ],
    'map'        => [
        'name' => true,
    ],
    'area'       => [
        'alt'     => true,
        'coords'  => true,
        'href'    => true,
        'shape'   => true,
        'target'  => true,
        'download'=> true,
        'rel'     => true,
        'hreflang'=> true,
        'type'    => true,
    ],
    'svg'        => [
        'width'   => true,
        'height'  => true,
        'viewBox' => true,
        'xmlns'   => true,
        'version' => true,
        'preserveAspectRatio' => true,
        'baseProfile' => true,
        'contentScriptType' => true,
        'contentStyleType' => true,
        'class'   => true,
        'style'   => true,
        'id'      => true,
        'fill'    => true,
        'stroke'  => true,
    ],
    'path'       => [
        'd'           => true,
        'pathLength'  => true,
        'stroke'      => true,
        'fill'        => true,
        'transform'   => true,
        'style'       => true,
        'class'       => true,
        'id'          => true,
    ],
    'circle'     => [
        'cx'          => true,
        'cy'          => true,
        'r'           => true,
        'stroke'      => true,
        'fill'        => true,
        'style'       => true,
        'class'       => true,
        'id'          => true,
    ],
    'rect'       => [
        'x'           => true,
        'y'           => true,
        'width'       => true,
        'height'      => true,
        'rx'          => true,
        'ry'          => true,
        'stroke'      => true,
        'fill'        => true,
        'style'       => true,
        'class'       => true,
        'id'          => true,
    ],
    'ellipse'    => [
        'cx'          => true,
        'cy'          => true,
        'rx'          => true,
        'ry'          => true,
        'stroke'      => true,
        'fill'        => true,
        'style'       => true,
        'class'       => true,
        'id'          => true,
    ],
    'line'       => [
        'x1'          => true,
        'y1'          => true,
        'x2'          => true,
        'y2'          => true,
        'stroke'      => true,
        'style'       => true,
        'class'       => true,
        'id'          => true,
    ],
    'polygon'    => [
        'points'      => true,
        'stroke'      => true,
        'fill'        => true,
        'style'       => true,
        'class'       => true,
        'id'          => true,
    ],
    'polyline'   => [
        'points'      => true,
        'stroke'      => true,
        'fill'        => true,
        'style'       => true,
        'class'       => true,
        'id'          => true,
    ],
    'text'       => [
        'x'           => true,
        'y'           => true,
        'dx'          => true,
        'dy'          => true,
        'textLength'  => true,
        'lengthAdjust'=> true,
        'font-family' => true,
        'font-size'   => true,
        'fill'        => true,
        'stroke'      => true,
        'style'       => true,
        'class'       => true,
        'id'          => true,
    ],
    'g'          => [
        'transform'   => true,
        'fill'        => true,
        'stroke'      => true,
        'style'       => true,
        'class'       => true,
        'id'          => true,
    ],
    // You can include other SVG elements as needed
];

/**
 * List of allowed protocols for URLs.
 *
 * @var array
 */
$allowed_protocols = [
    'http',
    'https',
    'ftp',
    'ftps',
    'mailto',
    'news',
    'irc',
    'ircs',
    'gopher',
    'nntp',
    'feed',
    'telnet',
    'mms',
    'rtsp',
    'rtmp',
    'svn',
    'tel',
    'fax',
    'xmpp',
    'webcal',
    'urn',
    'cid',
    'mid',
    'sms',
    'smsto',
    'sip',
    'sips',
    'tftp',
    'ssh',
    'sftp',
    'ldap',
    'ldaps',
    'steam',
    'bitcoin',
    'magnet',
    'geo',
    'skype',
    'viber',
    'whatsapp',
    'matrix',
    'ed2k',
    'notes',
    'dat',
    'ipfs',
    'ipns',
    'dweb',
    'datashare',
    'irc6',
    'snews',
    'feed',
    'itms',
    'market',
    'intent',
    'chrome',
    'about',
    'blob',
    'data', // Be cautious with data URIs
    // Any other protocols you wish to allow
];

// The rest of the kses.php code remains unchanged.


/**
 * Decodes HTML entities in a string.
 *
 * @param string $string The string to decode.
 * @return string The decoded string.
 */
function kses_decode_entities(string $string): string
{
    // Convert numeric entities
    $string = preg_replace_callback('/&#(x?[0-9a-fA-F]+);/', 'kses_decode_entity', $string);

    // Convert named entities
    return html_entity_decode($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Callback function to decode numeric HTML entities.
 *
 * @param array $matches The regex matches.
 * @return string The decoded character.
 */
function kses_decode_entity(array $matches): string
{
    $entity = $matches[1];

    if (preg_match('/^x([0-9a-fA-F]+)$/', $entity, $hex_match)) {
        $code = hexdec($hex_match[1]);
    } else {
        $code = intval($entity);
    }

    return mb_chr($code, 'UTF-8');
}

/**
 * Normalizes HTML entities in a string.
 *
 * @param string $string The string to normalize.
 * @return string The normalized string.
 */
function kses_normalize_entities(string $string): string
{
    // Replace entities in hexadecimal format
    $string = preg_replace('/&#x([0-9a-fA-F]+);?/u', '&#x$1;', $string);

    // Replace entities in decimal format
    $string = preg_replace('/&#([0-9]+);?/u', '&#$1;', $string);

    return $string;
}

/**
 * Converts all applicable characters to HTML entities.
 *
 * @param string $string The string to encode.
 * @return string The encoded string.
 */
function kses_encode_entities(string $string): string
{
    return htmlentities($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Strips slashes from a string or array recursively.
 *
 * @param mixed $value The value to strip slashes from.
 * @return mixed The value with slashes stripped.
 */
function kses_stripslashes($value)
{
    if (is_array($value)) {
        return array_map('kses_stripslashes', $value);
    }

    return stripslashes($value);
}

/**
 * Checks and cleans a URL.
 *
 * @param string $url The URL to check.
 * @return string The cleaned URL or an empty string if invalid.
 */
function kses_clean_url(string $url): string
{
    $url = trim($url);
    $url = kses_decode_entities($url);
    $url = preg_replace('/[^a-z0-9-~+_.?#=&;,\/:%@!*()\[\]]/i', '', $url);

    // Check for disallowed protocols
    if (!kses_validate_protocol($url)) {
        return '';
    }

    return $url;
}

/**
 * Validates a URL's protocol.
 *
 * @param string $url The URL to validate.
 * @return bool True if the protocol is allowed, false otherwise.
 */
function kses_validate_protocol(string $url): bool
{
    global $allowed_protocols;

    $url = strtolower($url);
    $protocol = substr($url, 0, strpos($url, ':'));

    if ($protocol && in_array($protocol, $allowed_protocols, true)) {
        return true;
    }

    return false;
}

/**
 * Parses HTML attributes from a tag.
 *
 * @param string $tag The HTML tag.
 * @return array An associative array of attributes and their values.
 */
function kses_parse_attributes(string $tag): array
{
    $attributes = [];
    $pattern = '/(\w+)\s*=\s*(?:"([^"]*)"|\'([^\']*)\'|([^\s>]+))/';

    if (preg_match_all($pattern, $tag, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
            $attr_name = strtolower($match[1]);
            $attr_value = $match[2] ?? $match[3] ?? $match[4] ?? '';
            $attributes[$attr_name] = $attr_value;
        }
    }

    return $attributes;
}

/**
 * Sanitizes an array of attributes against allowed attributes.
 *
 * @param string $element The HTML element name.
 * @param array  $attributes The attributes to sanitize.
 * @param array  $allowed_html The allowed HTML tags and attributes.
 * @return array The sanitized attributes.
 */
function kses_sanitize_attributes(string $element, array $attributes, array $allowed_html): array
{
    $sanitized_attributes = [];

    if (!isset($allowed_html[$element]) || !is_array($allowed_html[$element])) {
        return $sanitized_attributes;
    }

    $allowed_attributes = $allowed_html[$element];

    foreach ($attributes as $attr_name => $attr_value) {
        if (isset($allowed_attributes[$attr_name])) {
            $checker = $allowed_attributes[$attr_name];
            $attr_value = kses_decode_entities($attr_value);
            $attr_value = kses_strip_bad_protocols($attr_value);

            if (kses_check_attribute_value($attr_value, $checker)) {
                $sanitized_attributes[$attr_name] = $attr_value;
            }
        }
    }

    return $sanitized_attributes;
}

/**
 * Checks if an attribute value is valid based on its expected type.
 *
 * @param string $value The attribute value.
 * @param mixed  $checker The expected type or a custom validation callback.
 * @return bool True if valid, false otherwise.
 */
function kses_check_attribute_value(string $value, $checker): bool
{
    if (is_callable($checker)) {
        return call_user_func($checker, $value);
    }

    switch ($checker) {
        case true:
            // Any value is allowed
            return true;
        case 'url':
            return (bool)filter_var($value, FILTER_VALIDATE_URL);
        case 'int':
            return (bool)filter_var($value, FILTER_VALIDATE_INT);
        case 'bool':
            return in_array(strtolower($value), ['true', 'false', '1', '0'], true);
        case 'class':
            // Validate class names (alphanumeric and spaces)
            return preg_match('/^[a-zA-Z0-9\s_-]+$/', $value);
        case 'style':
            // Basic validation for inline styles
            return kses_validate_css($value);
        default:
            // Default to false
            return false;
    }
}

/**
 * Validates inline CSS styles.
 *
 * @param string $css The CSS string.
 * @return bool True if valid, false otherwise.
 */
function kses_validate_css(string $css): bool
{
    // For simplicity, allow only alphanumeric, colons, semicolons, and basic punctuation
    return preg_match('/^[a-zA-Z0-9\s:;#%.,()-]+$/', $css);
}

/**
 * Removes disallowed protocols from a string.
 *
 * @param string $string The string to process.
 * @return string The cleaned string.
 */
function kses_strip_bad_protocols(string $string): string
{
    do {
        $original_string = $string;
        $string = preg_replace_callback('/^([^:]+):/i', 'kses_bad_protocol_callback', $string);
    } while ($original_string !== $string);

    return $string;
}

/**
 * Callback function to remove disallowed protocols.
 *
 * @param array $matches The regex matches.
 * @return string The cleaned string.
 */
function kses_bad_protocol_callback(array $matches): string
{
    $protocol = strtolower($matches[1]);

    global $allowed_protocols;

    return in_array($protocol, $allowed_protocols, true) ? $matches[0] : '';
}

/**
 * Splits HTML content into an array of tags and text.
 *
 * @param string $html The HTML content.
 * @return array The split content.
 */
function kses_html_split(string $html): array
{
    $regex = '%(<[^>]*>|\s*[^<]*)%';
    preg_match_all($regex, $html, $matches);

    return $matches[0];
}

/**
 * Sanitizes HTML content by removing disallowed tags and attributes.
 *
 * @param string $html The HTML content to sanitize.
 * @param array  $allowed_html The allowed HTML tags and attributes.
 * @return string The sanitized HTML content.
 */
function kses(string $html, array $allowed_html): string
{
    $html = kses_normalize_entities($html);
    $parts = kses_html_split($html);
    $sanitized_content = '';

    foreach ($parts as $part) {
        if (substr($part, 0, 1) !== '<') {
            // Text content
            $sanitized_content .= kses_decode_entities($part);
        } else {
            // Tag content
            $sanitized_content .= kses_sanitize_tag($part, $allowed_html);
        }
    }

    return $sanitized_content;
}

/**
 * Sanitizes an HTML tag.
 *
 * @param string $tag The HTML tag.
 * @param array  $allowed_html The allowed HTML tags and attributes.
 * @return string The sanitized tag or an empty string if disallowed.
 */
function kses_sanitize_tag(string $tag, array $allowed_html): string
{
    $matches = [];
    if (!preg_match('/^<\s*(\/?\s*\w+)([^>]*)>$/s', $tag, $matches)) {
        // Not a valid tag
        return '';
    }

    $element = strtolower(trim($matches[1], '/'));
    $is_closing_tag = strpos($matches[1], '/') === 0;
    $attributes_str = $matches[2];

    if (!isset($allowed_html[$element])) {
        // Tag not allowed
        return '';
    }

    if ($is_closing_tag) {
        return "</{$element}>";
    }

    $attributes = kses_parse_attributes($attributes_str);
    $sanitized_attributes = kses_sanitize_attributes($element, $attributes, $allowed_html);

    // Reconstruct the tag
    $attributes_str = '';
    foreach ($sanitized_attributes as $attr_name => $attr_value) {
        $attr_value = htmlspecialchars($attr_value, ENT_QUOTES, 'UTF-8');
        $attributes_str .= " {$attr_name}=\"{$attr_value}\"";
    }

    return "<{$element}{$attributes_str}>";
}

/**
 * Converts all keys in an array to lowercase.
 *
 * @param array $array The array to process.
 * @return array The array with lowercase keys.
 */
function kses_array_lc(array $array): array
{
    $lowercased_array = [];
    foreach ($array as $key => $value) {
        $lowercased_array[strtolower($key)] = $value;
    }
    return $lowercased_array;
}

/**
 * Detects errors in HTML code.
 *
 * @param string $html The HTML code to check.
 * @return array An array of error messages.
 */
function kses_detect_html_errors(string $html): array
{
    $errors = [];
    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->loadHTML($html);
    $libxml_errors = libxml_get_errors();
    foreach ($libxml_errors as $error) {
        $errors[] = $error->message;
    }
    libxml_clear_errors();
    libxml_use_internal_errors(false);

    return $errors;
}

/**
 * Removes potential XSS vectors from a string.
 *
 * @param string $string The string to clean.
 * @return string The cleaned string.
 */
function kses_remove_xss(string $string): string
{
    // Remove script and style tags
    $string = preg_replace('/<(script|style)[^>]*>.*?<\/\1>/si', '', $string);

    // Remove event handlers and javascript: URIs
    $string = preg_replace('/on\w+="[^"]*"/i', '', $string);
    $string = preg_replace('/on\w+=\'[^\']*\'/i', '', $string);
    $string = preg_replace('/on\w+=\w+/i', '', $string);
    $string = preg_replace('/javascript:/i', '', $string);

    return $string;
}
