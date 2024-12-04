<?php
// components.php

if (!defined('ABSPATH')) {
    exit('No direct script access allowed');
}

global $menu;

function add_menu($slug, $name, $submenu = false, $order, $options=array()) {
    global $menu;
    if (!empty($menu_slug) && !empty($name)) {
        if (! $submenu && (array_key_exists("callback",$options))) {
            
        } elseif (! $submenu) {
            throw new Exception('CallBack Required');
        }
    }
}
