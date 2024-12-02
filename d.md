Components Documentation
========================

Welcome to the **Components Documentation** for your PHP Admin Panel. This document provides a comprehensive guide to all the reusable PHP functions defined in `components.php`. These functions generate various HTML components, enabling you to build dynamic and interactive admin interfaces efficiently.

* * *

Table of Contents
-----------------

*   [Form Inputs](#form-inputs)
*   [Navigation Components](#navigation-components)
*   [Data Display Components](#data-display-components)
*   [Interactive Elements](#interactive-elements)
*   [Feedback and Notification Components](#feedback-and-notification-components)
*   [Advanced Visualization Components](#advanced-visualization-components)
*   [Data Filtering and Manipulation](#data-filtering-and-manipulation)
*   [User and Profile Components](#user-and-profile-components)
*   [Miscellaneous Components](#miscellaneous-components)
*   [Specialized Dashboards Components](#specialized-dashboards-components)
*   [Interaction and Utility Components](#interaction-and-utility-components)
*   [Complex Data Representations](#complex-data-representations)

* * *

Form Inputs
-----------

### Text Input

Generates a standard text input field.

#### Parameters:

*   **name**: The name attribute of the input.
*   **placeholder**: Placeholder text.
*   **value**: Default value of the input.
*   **attributes**: Additional HTML attributes as an associative array.

#### Usage:

    <?php
    echo text_input('username', 'Enter your username', '', ['class' => 'form-input']);
    ?>

### Password Input

Generates a password input field.

#### Parameters:

*   **name**: The name attribute of the input.
*   **placeholder**: Placeholder text.
*   **value**: Default value of the input.
*   **attributes**: Additional HTML attributes as an associative array.

#### Usage:

    <?php
    echo password_input('password', 'Enter your password', '', ['class' => 'form-input']);
    ?>

Navigation Components
---------------------

### Sidebar Menu

Generates a dynamic sidebar navigation menu based on defined menus and sub-menus.

#### Parameters:

*   **menus**: An associative array of menu items.
*   **active**: The slug of the currently active menu item.

#### Usage:

    <?php
    echo sidebar_menu($menus, 'dashboard');
    ?>

### Top Navigation Bar

Creates a top navigation bar with customizable elements like logo, search, and user profile.

#### Parameters:

*   **logo**: HTML content for the logo.
*   **links**: An array of navigation links.
*   **profile**: HTML content for the user profile section.

#### Usage:

    <?php
    echo top_navbar($logo_html, $nav_links, $profile_html);
    ?>

Data Display Components
-----------------------

### Data Table

Generates an HTML table with headers and rows.

#### Parameters:

*   **headers**: An array of table headers.
*   **rows**: A two-dimensional array of table data.
*   **attributes**: Additional HTML attributes for the table.

#### Usage:

    <?php
    $headers = ['Name', 'Email', 'Role'];
    $rows = [
        ['John Doe', 'john@example.com', 'Admin'],
        ['Jane Smith', 'jane@example.com', 'Editor']
    ];
    echo data_table($headers, $rows, ['class' => 'table-auto w-full']);
    ?>

### Sortable Table

Creates a table with sortable columns.

#### Parameters:

*   **headers**: An array of table headers.
*   **rows**: A two-dimensional array of table data.
*   **current\_sort**: The column currently sorted.
*   **sort\_direction**: Direction of sorting ('asc' or 'desc').
*   **attributes**: Additional HTML attributes for the table.

#### Usage:

    <?php
    echo sortable_table($headers, $rows, 'Name', 'asc', ['class' => 'table-auto w-full']);
    ?>

Interactive Elements
--------------------

### Buttons

Generates a customizable button with different styles.

#### Parameters:

*   **text**: The button label.
*   **type**: The style type ('primary', 'secondary', 'success', etc.).
*   **attributes**: Additional HTML attributes for the button.

#### Usage:

    <?php
    echo button('Submit', 'primary', ['onclick' => 'submitForm()']);
    ?>

### Icon Buttons

Creates a button that displays an icon instead of text.

#### Parameters:

*   **icon**: The Material Icon name.
*   **type**: The style type ('primary', 'secondary', etc.).
*   **attributes**: Additional HTML attributes for the button.

#### Usage:

    <?php
    echo icon_button('delete', 'danger', ['onclick' => 'deleteItem()']);
    ?>

Feedback and Notification Components
------------------------------------

### Toast/Snackbar

Displays transient notifications to the user.

#### Parameters:

*   **message**: The notification message.
*   **type**: The type of notification ('success', 'error', 'info', etc.).
*   **duration**: Duration in milliseconds before the toast disappears.
*   **attributes**: Additional HTML attributes for the toast.

#### Usage:

    <?php
    showToast('Data saved successfully!', 'success', 3000);
    ?>

### Alert Banners

Creates alert banners for important messages.

#### Parameters:

*   **message**: The alert message.
*   **type**: The alert type ('info', 'success', 'danger', etc.).
*   **dismissible**: Whether the alert can be dismissed.
*   **attributes**: Additional HTML attributes for the alert.

#### Usage:

    <?php
    echo alert_box('Invalid credentials provided.', 'danger', true);
    ?>

Advanced Visualization Components
---------------------------------

### Geographic Map

Embeds an interactive geographic map.

#### Parameters:

*   **id**: The HTML id attribute for the map container.
*   **data**: Data points or regions to display on the map.
*   **options**: Configuration options for the map.
*   **attributes**: Additional HTML attributes for the map container.

#### Usage:

    <?php
    $mapData = [...]; // Define your map data
    $mapOptions = [...]; // Define your map options
    echo geographic_map('world-map', $mapData, $mapOptions, ['class' => 'w-full h-64']);
    ?>

### Network Graph

Creates an interactive network graph visualization.

#### Parameters:

*   **id**: The HTML id attribute for the graph container.
*   **data**: Nodes and links data for the graph.
*   **options**: Configuration options for the graph.
*   **attributes**: Additional HTML attributes for the graph container.

#### Usage:

    <?php
    $graphData = [...]; // Define your network data
    $graphOptions = [...]; // Define your graph options
    echo network_graph('network-graph', $graphData, $graphOptions, ['class' => 'w-full h-64']);
    ?>

Data Filtering and Manipulation
-------------------------------

### Filter Sidebar

Creates a sidebar with various filters for data manipulation.

#### Parameters:

*   **filters**: An array of filter components.
*   **attributes**: Additional HTML attributes for the sidebar.

#### Usage:

    <?php
    $filters = [
        checkbox_input('filter1', 'Option 1'),
        checkbox_input('filter2', 'Option 2')
    ];
    echo filter_sidebar($filters, ['class' => 'w-64']);
    ?>

### Advanced Search

Generates an advanced search form with multiple fields.

#### Parameters:

*   **fields**: An array of form field components.
*   **attributes**: Additional HTML attributes for the form.

#### Usage:

    <?php
    $fields = [
        text_input('search', 'Search...', ''),
        select_input('category', ['All', 'Category 1', 'Category 2'], 'All')
    ];
    echo advanced_search($fields, ['class' => 'mb-4']);
    ?>

User and Profile Components
---------------------------

### Avatar

Displays a user's avatar image.

#### Parameters:

*   **image\_url**: The URL of the avatar image.
*   **alt**: Alternative text for the image.
*   **size**: The size of the avatar ('sm', 'md', 'lg').
*   **attributes**: Additional HTML attributes for the image.

#### Usage:

    <?php
    echo avatar('https://example.com/avatar.jpg', 'John Doe', 'md', ['class' => 'border']);
    ?>

### User Profile Card

Creates a user profile card with avatar, name, email, and action buttons.

#### Parameters:

*   **avatar\_url**: URL of the user's avatar.
*   **name**: User's name.
*   **email**: User's email address.
*   **actions**: An array of action buttons.
*   **attributes**: Additional HTML attributes for the card.

#### Usage:

    <?php
    $actions = [
        ['text' => 'Edit', 'type' => 'primary', 'onclick' => 'editProfile()'],
        ['text' => 'Delete', 'type' => 'danger', 'onclick' => 'deleteProfile()']
    ];
    echo user_profile_card('https://example.com/avatar.jpg', 'John Doe', 'john@example.com', $actions, ['class' => 'mb-4']);
    ?>

Miscellaneous Components
------------------------

### Dark/Light Mode Toggle

Provides a button to toggle between dark and light themes.

#### Parameters:

*   **attributes**: Additional HTML attributes for the toggle button.

#### Usage:

    <?php
    echo dark_light_toggle(['class' => 'mr-4']);
    ?>

### Language Selector

Creates a dropdown for selecting languages.

#### Parameters:

*   **languages**: An associative array of language codes and names.
*   **current**: The currently selected language code.
*   **attributes**: Additional HTML attributes for the select element.

#### Usage:

    <?php
    $languages = ['en' => 'English', 'es' => 'Spanish', 'fr' => 'French'];
    echo language_selector($languages, 'en', ['onchange' => 'changeLanguage(this.value)']);
    ?>

Specialized Dashboards Components
---------------------------------

### Performance Metrics

Displays a grid of performance metrics using stat cards.

#### Parameters:

*   **metrics**: An array of metric data.
*   **attributes**: Additional HTML attributes for the metrics container.

#### Usage:

    <?php
    $metrics = [
        ['title' => 'Users', 'value' => '1,200', 'icon' => 'person', 'color' => 'blue'],
        ['title' => 'Sales', 'value' => '$34,000', 'icon' => 'shopping_cart', 'color' => 'green']
    ];
    echo performance_metrics($metrics, ['class' => 'mb-4']);
    ?>

### KPI Indicators

Shows Key Performance Indicators in a grid layout.

#### Parameters:

*   **kpis**: An array of KPI data.
*   **attributes**: Additional HTML attributes for the KPI container.

#### Usage:

    <?php
    $kpis = [
        ['title' => 'Revenue', 'value' => '$50,000', 'icon' => 'attach_money', 'color' => 'purple'],
        ['title' => 'Expenses', 'value' => '$20,000', 'icon' => 'money_off', 'color' => 'red']
    ];
    echo kpi_indicators($kpis, ['class' => 'mb-4']);
    ?>

Interaction and Utility Components
----------------------------------

### Clipboard Copy Button

Creates a button that copies specified text to the clipboard.

#### Parameters:

*   **text**: The text to be copied.
*   **attributes**: Additional HTML attributes for the button.

#### Usage:

    <?php
    echo clipboard_copy_button('Copy this text', ['class' => 'ml-2']);
    ?>

### Zoom Controls

Provides buttons to zoom in and out of the page.

#### Parameters:

*   **attributes**: Additional HTML attributes for the zoom controls container.

#### Usage:

    <?php
    echo zoom_controls();
    ?>

Complex Data Representations
----------------------------

### Parallel Coordinates Plot

Embeds a parallel coordinates plot for multidimensional data visualization.

#### Parameters:

*   **id**: The HTML id attribute for the plot container.
*   **data**: The data points for the plot.
*   **options**: Configuration options for the plot.
*   **attributes**: Additional HTML attributes for the plot container.

#### Usage:

    <?php
    $plotData = [...]; // Define your plot data
    $plotOptions = [...]; // Define your plot options
    echo parallel_coordinates_plot('parallel-plot', $plotData, $plotOptions, ['class' => 'w-full h-64']);
    ?>

### Network Relationship Diagram

Generates a network relationship diagram to visualize connections between entities.

#### Parameters:

*   **id**: The HTML id attribute for the diagram container.
*   **data**: Nodes and relationships data.
*   **options**: Configuration options for the diagram.
*   **attributes**: Additional HTML attributes for the diagram container.

#### Usage:

    <?php
    $diagramData = [...]; // Define your network data
    $diagramOptions = [...]; // Define your diagram options
    echo network_relationship_diagram('network-diagram', $diagramData, $diagramOptions, ['class' => 'w-full h-64']);
    ?>