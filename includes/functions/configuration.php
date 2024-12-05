<?php
define('DAY_IN_HOURS', 24);
define('DAY_IN_MINUTES', DAY_IN_HOURS * 60);
define('DAY_IN_SECONDS', DAY_IN_MINUTES * 60);
define('HOUR_IN_MINUTES', 60);
define('HOUR_IN_SECONDS', HOUR_IN_MINUTES * 60);
define('MINUTE_IN_SECONDS', 60);
define('SECOND_IN_MILLISECONDS', 1000);
define('SECOND_IN_MICROSECONDS', SECOND_IN_MILLISECONDS * 1000);
define('SECOND_IN_NANOSECONDS', SECOND_IN_MICROSECONDS * 1000);

define('IP', $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['HTTP_X_REAL_IP'] ?? (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]) : $_SERVER['REMOTE_ADDR']));
$ip = IP;

if (isset($_COOKIE['color-theme'])) {
    define('PREFERS_COLOR_SCHEME', $_COOKIE['color-theme'] === 'light' ? 'light' : 'dark');
} elseif (isset($_SERVER['HTTP_SEC_CH_PREFERS_COLOR_SCHEME'])) {
    define('PREFERS_COLOR_SCHEME', $_SERVER['HTTP_SEC_CH_PREFERS_COLOR_SCHEME'] === 'light' ? 'light' : 'dark');
}
