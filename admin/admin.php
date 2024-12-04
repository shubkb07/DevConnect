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
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <meta http-equiv="refresh" content="60">
    <!-- Tailwind CSS -->
    <link href="/admin/assets/css/tailwind.min.css" rel="stylesheet">
    <!-- Flowbite CSS -->
    <link href="/admin/assets/css/flowbite.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/admin/assets/css/admin.css" rel="stylesheet">
    <script>
        tailwind.config = {
            plugins: [
                require('flowbite/plugin')({
                    charts: true,
                }),
            ]
        }
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
    <!-- Sidebar -->
    <aside id="default-sidebar"
        class="sidebar fixed top-0 left-0 z-40 w-64 h-screen transition-transform transform -translate-x-full sm:translate-x-0"
        aria-label="Sidenav">
        <div
            class="flex flex-col justify-between h-full overflow-y-auto py-5 px-3 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div>
                <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">DevConnect</span>
                </a>
                <br>
                <ul class="space-y-2">
                    <!-- Overview -->
                    <li>
                        <a href="#"
                            class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <!-- Icon -->
                            <svg aria-hidden="true"
                                class="w-6 h-6 text-gray-400 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                            </svg>
                            <span class="ml-3">Overview</span>
                        </a>
                    </li>
                    <!-- Pages Dropdown -->
                    <li>
                        <button type="button"
                            class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                            <svg aria-hidden="true"
                                class="flex-shrink-0 w-6 h-6 text-gray-400 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">Pages</span>
                            <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <ul id="dropdown-pages" class="hidden py-2 space-y-2">
                            <li>
                                <a href="#"
                                    class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 dark:text-white dark:hover:bg-gray-700 hover:bg-gray-100 group">
                                    Settings
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 dark:text-white dark:hover:bg-gray-700 hover:bg-gray-100 group">
                                    Kanban
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 dark:text-white dark:hover:bg-gray-700 hover:bg-gray-100 group">
                                    Calendar
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Add more sidebar items as needed -->
                </ul>
            </div>
            <!-- Bottom Sidebar Items -->
            <ul class="space-y-2 pt-5 mt-5 border-t border-gray-200 dark:border-gray-700">
                <!-- Docs -->
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                        <!-- Icon -->
                        <svg aria-hidden="true"
                            class="flex-shrink-0 w-6 h-6 text-gray-400 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z">
                            </path>
                        </svg>
                        <span class="ml-3">Docs</span>
                    </a>
                </li>
                <!-- Add more bottom items as needed -->
                <!-- Log Out Button -->
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                        <!-- Logout Icon -->
                        <svg class="w-6 h-6 text-gray-400 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                            height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
                            <path
                                d="M480-120v-80h280v-560H480v-80h280q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H480Zm-80-160-55-58 102-102H120v-80h327L345-622l55-58 200 200-200 200Z" />
                        </svg>
                        <span class="ml-3">Log Out</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="flex flex-col min-h-screen">
        <!-- Navbar -->
        <nav
            class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 fixed top-0 left-0 right-0 z-30 transition-colors duration-300">
            <div class="flex justify-between items-center h-16 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center">
                    <!-- Sidebar Toggle Button (Mobile) -->
                    <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar"
                        aria-controls="default-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6 text-gray-400 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                    <!-- Logo (Centered on Mobile) -->
                    <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse mx-auto sm:mx-0">
                        <span
                            class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">DevConnect</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Search Button -->
                    <div class="relative">
                        <button id="search-button" type="button"
                            class="flex text-sm rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                            aria-expanded="false">
                            <span class="sr-only">Open Search</span>
                            <svg class="w-6 h-6 text-gray-400 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 -960 960 960" fill="currentColor">
                                <path
                                    d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Notification Icon -->
                    <div class="relative">
                        <button type="button"
                            class="flex text-sm rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                            id="notification-menu-button" aria-expanded="false"
                            data-dropdown-toggle="notification-dropdown" data-dropdown-placement="bottom">
                            <span class="sr-only">Open notification menu</span>
                            <!-- Bell Icon -->
                            <svg class="w-6 h-6 text-gray-400 dark:text-gray-400" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 22a2 2 0 002-2h-4a2 2 0 002 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4a1.5 1.5 0 00-3 0v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z">
                                </path>
                            </svg>
                            <!-- Notification Badge -->
                            <span
                                class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">3</span>
                        </button>
                        <!-- Notification Dropdown -->
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-60 dark:bg-gray-700 dark:divide-gray-600"
                            id="notification-dropdown">
                            <div class="px-4 py-3">
                                <span class="block text-sm text-gray-900 dark:text-white">You have 3 new
                                    notifications</span>
                            </div>
                            <ul class="py-2" aria-labelledby="notification-menu-button">
                                <li>
                                    <a href="#"
                                        class="flex items-center p-2 text-base md:text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                        <!-- Notification Icon -->
                                        <svg class="w-6 h-6 text-gray-400 dark:text-gray-400" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M12 22a2 2 0 002-2h-4a2 2 0 002 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4a1.5 1.5 0 00-3 0v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z">
                                            </path>
                                        </svg>
                                        <span class="ml-3">New message from John</span>
                                    </a>
                                </li>
                                <!-- Add more notifications as needed -->
                            </ul>
                            <div class="px-4 py-3">
                                <a href="#" class="text-sm text-blue-600 dark:text-blue-500 hover:underline">View all
                                    notifications</a>
                            </div>
                        </div>
                    </div>
                    <!-- User Profile -->
                    <div class="relative">
                        <button type="button"
                            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                            id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                            data-dropdown-placement="bottom">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 rounded-full"
                                src="https://flowbite.com/docs/images/people/profile-picture-3.jpg" alt="User photo">
                        </button>
                        <!-- Dropdown Menu -->
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-60 dark:bg-gray-700 dark:divide-gray-600"
                            id="user-dropdown">
                            <div class="px-4 py-3">
                                <span class="block text-sm text-gray-900 dark:text-white">Bonnie Green</span>
                                <span
                                    class="block text-sm text-gray-500 truncate dark:text-gray-400">name@flowbite.com</span>
                            </div>
                            <ul class="py-2" aria-labelledby="user-menu-button">
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 text-base md:text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
                                </li>
                                <!-- Add more user options as needed -->
                            </ul>
                        </div>
                    </div>
                    <!-- Theme Toggle Button -->
                    <button id="theme-toggle" type="button"
                        class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                        <span class="sr-only">Toggle dark mode</span>
                        <!-- Sun Icon -->
                        <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 -960 960 960" fill="currentColor">
                            <path
                                d="M440-760v-160h80v160h-80Zm266 110-55-55 112-115 56 57-113 113Zm54 210v-80h160v80H760ZM440-40v-160h80v160h-80ZM254-652 140-763l57-56 113 113-56 54Zm508 512L651-255l54-54 114 110-57 59ZM40-440v-80h160v80H40Zm157 300-56-57 112-112 29 27 29 28-114 114Zm283-100q-100 0-170-70t-70-170q0-100 70-170t170-70q100 0 170 70t70 170q0 100-70 170t-170 70Zm0-80q66 0 113-47t47-113q0-66-47-113t-113-47q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-160Z" />
                        </svg>
                        <!-- Moon Icon -->
                        <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 960 960" fill="currentColor">
                            <g transform="matrix(0 -1 1 0 960 960)">
                                <path
                                    d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Zm0-80q88 0 158-48.5T740-375q-20 5-40 8t-40 3q-123 0-209.5-86.5T364-660q0-20 3-40t8-40q-78 32-126.5 102T200-480q0 116 82 198t198 82Zm-10-270Z" />
                            </g>
                        </svg>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Main Content Area -->
        <main class="flex-1 p-4 sm:ml-64 mt-16 transition-colors duration-300">
            <!-- Your main content goes here -->
            <div class="container mx-auto">
                <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white">Dashboard</h1>
                <p class="text-gray-700 dark:text-gray-300">Welcome to your admin dashboard!</p>

                <div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 mt-6 mb-6">
                    <!-- Content -->
                    <p class="text-gray-900 dark:text-white">Content</p>
                </div>
                <div class="max-w-fit mx-auto bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 mt-6 mb-6">
                    <!-- Content -->
                    <p class="text-gray-900 dark:text-white mt-6 mb-6">Content</p>
                </div>
                <div
                    class="max-w-fit mx-auto bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 flex justify-center items-center mt-6 mb-6">
                    <!-- Content -->
                    <p class="text-gray-900 dark:text-white">Centered Content</p>
                </div>
                <div
                    class="max-w-fit mx-auto bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 flex justify-center items-center mt-6 mb-6">
                    <!-- Content -->
                    <p class="text-gray-900 dark:text-white">Centered Content</p>
                </div>
                <div
                    class="w-auto mx-auto bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 flex justify-center items-center mt-6 mb-6">
                    <!-- Content -->
                    <p class="text-gray-900 dark:text-white">Centered Content</p>
                </div>
                <div class="flex items-center justify-center bg-gray-100 dark:bg-gray-900">
                    <div class="w-auto bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                        <!-- Content -->
                        <p class="text-gray-900 dark:text-white">Centered Content</p>
                    </div>
                </div>


        </main>
    </div>

    <!-- Floating Search Bar -->
    <div id="search-bar-container"
        class="fixed inset-0 flex items-start justify-center bg-black bg-opacity-50 hidden z-50 pt-16">
        <form class="max-w-md w-full mx-auto p-4 bg-transparent">
            <!-- Close Button (optional) -->
            <button type="button" id="close-search"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <label for="default-search"
                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 19l-4-4m0-7A7 7 0 111 8a7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="search" id="default-search"
                    class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white bg-opacity-80 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:bg-opacity-80 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search..." required />
                <button type="submit"
                    class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
            </div>
        </form>
    </div>



    <!--ApexCharts JS-->
    <script src="/admin/assets/js/apexcharts.js"></script>

    <!-- Flowbite JS -->
    <script src="/admin/assets/js/flowbite.min.js"></script>
    <script src="/admin/assets/js/admin.js"></script>

</body>

</html>