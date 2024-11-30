<?php
// admin.php

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('No direct script access allowed');
}

// Include the components.php file
include_once ABSPATH . 'admin/components.php';

// Initialize the global menus array
global $menus;
$menus = [];

/**
 * Adds a main menu to the sidebar.
 *
 * @param string $slug Unique identifier for the menu.
 * @param string $name Display name of the menu.
 * @param string $url URL the menu links to.
 * @param callable $callback Function to generate the page content.
 * @param string $icon Material icon name.
 */
function add_menu($slug, $name, $url, $callback, $icon = 'dashboard') {
    global $menus;
    $menus[$slug] = [
        'slug' => $slug,
        'name' => $name,
        'url' => $url,
        'callback' => $callback,
        'icon' => $icon,
        'sub_menu' => []
    ];
}

/**
 * Adds a sub-menu under a main menu.
 *
 * @param string $slug Unique identifier for the sub-menu.
 * @param string $main_menu_slug The slug of the main menu to attach this sub-menu to.
 * @param string $name Display name of the sub-menu.
 * @param string $url URL the sub-menu links to.
 * @param callable $callback Function to generate the page content.
 * @param string $icon Material icon name.
 */
function add_sub_menu($slug, $main_menu_slug, $name, $url, $callback, $icon = 'subdirectory_arrow_right') {
    global $menus;
    if (isset($menus[$main_menu_slug])) {
        $menus[$main_menu_slug]['sub_menu'][$slug] = [
            'slug' => $slug,
            'name' => $name,
            'url' => $url,
            'callback' => $callback,
            'icon' => $icon
        ];
    } else {
        echo '<div class="text-red-500 p-4">Error: Main menu slug "' . htmlspecialchars($main_menu_slug) . '" not found.</div>';
    }
}

// Example usage (You can remove or comment out these lines in production)
/*
add_menu('dashboard', 'Dashboard', '/admin/dashboard', 'dashboard_page_callback', 'dashboard');
add_sub_menu('settings', 'dashboard', 'Settings', '/admin/dashboard/settings', 'settings_page_callback', 'settings');
*/

// You can define your menu items by calling add_menu and add_sub_menu functions here or in your routing logic.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <!-- Tailwind CSS via CDN with necessary plugins -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="/admin/assets/css/admin.css">
    <!-- Responsive Meta Tag -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="flex h-screen bg-gray-100" data-theme="light">
    <!-- Sidebar -->
    <aside id="sidebar" class="bg-white shadow-lg w-64 flex-shrink-0 transition-transform transform md:translate-x-0 -translate-x-full">
        <!-- Logo and Toggle Button -->
        <div class="flex items-center justify-between p-4">
            <span class="text-xl font-bold">YourLogo</span>
            <button id="sidebar-close" class="text-gray-700 md:hidden">
                <i class="material-icons">close</i>
            </button>
        </div>
        <!-- Navigation Menu -->
        <nav>
            <ul>
                <?php foreach ($menus as $menu): ?>
                    <li>
                        <a href="<?php echo htmlspecialchars($menu['url']); ?>" class="flex items-center p-4 text-gray-700 hover:bg-gray-200">
                            <i class="material-icons"><?php echo htmlspecialchars($menu['icon']); ?></i>
                            <span class="ml-2"><?php echo htmlspecialchars($menu['name']); ?></span>
                        </a>
                        <?php if (!empty($menu['sub_menu'])): ?>
                            <ul class="pl-8">
                                <?php foreach ($menu['sub_menu'] as $sub): ?>
                                    <li>
                                        <a href="<?php echo htmlspecialchars($sub['url']); ?>" class="flex items-center p-4 text-gray-600 hover:bg-gray-200">
                                            <i class="material-icons"><?php echo htmlspecialchars($sub['icon']); ?></i>
                                            <span class="ml-2"><?php echo htmlspecialchars($sub['name']); ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </aside>

    <!-- Overlay for Mobile Sidebar -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-50 hidden md:hidden"></div>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col">
        <!-- Top Navigation Bar -->
        <header class="flex items-center justify-between p-4 bg-white shadow">
            <div class="flex items-center">
                <button id="sidebar-open" class="text-gray-700 mr-4 md:hidden">
                    <i class="material-icons">menu</i>
                </button>
                <span id="page-title" class="text-xl font-bold">Dashboard</span>
            </div>
            <button id="theme-toggle" class="text-gray-700">
                <i class="material-icons">brightness_4</i>
            </button>
        </header>

        <!-- Content Section -->
        <main class="flex-1 p-4 overflow-auto">
            <?php
                // Your routing logic goes here.
                // Example:
                // if (isset($_GET['page']) && function_exists($_GET['page'])) {
                //     call_user_func($_GET['page']);
                // } else {
                //     echo "Welcome to the Admin Dashboard!";
                // }

                // Placeholder for content
                // Replace this with your routing and content logic
            ?>
        </main>
    </div>

    <!-- Custom Admin JS -->
    <script src="/admin/assets/js/admin.js"></script>
</body>
</html>
