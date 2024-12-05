<?php
// admin.php

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('No direct script access allowed');
}

// Include the components.php file
include_once ABSPATH . 'admin/components.php';

// Example usage (You can remove or comment out these lines in production)
/*
add_menu('dashboard', 'Dashboard', '/admin/dashboard', 'dashboard_page_callback', 'dashboard');
add_sub_menu('settings', 'dashboard', 'Settings', '/admin/dashboard/settings', 'settings_page_callback', 'settings');
*/

// You can define your menu items by calling add_menu and add_sub_menu functions here or in your routing logic.
?>

<!DOCTYPE html>
<html lang="en" class="<?php echo PREFERS_COLOR_SCHEME === 'dark' ? 'dark' : ''; ?>" meow="<?php echo PREFERS_COLOR_SCHEME; ?>">
<?php get_head(); ?>

<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
    <?php get_navbar(); ?>
    <!-- Main Content Area -->
    <main class="flex-1 p-4 sm:ml-64 mt-16 transition-colors duration-300">
        <!-- Your main content goes here -->
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white"><? echo get_pagename(); ?></h1>
            <?php echo get_content(); ?>
        </div>
    </main>
    <?php get_footer(); ?>
</body>

</html>