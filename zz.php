<?php

/**
 * Charts and Visualizations
 */

// Line Chart
function line_chart($id, $data, $options = []) {
    if (empty($id) || empty($data)) {
        return '<div class="text-red-500">Error: Line Chart requires an ID and data.</div>';
    }
    $options_json = json_encode($options);
    return "<canvas id=\"{$id}\" data-options='{$options_json}'></canvas>";
}

// Bar Chart
function bar_chart($id, $data, $options = []) {
    if (empty($id) || empty($data)) {
        return '<div class="text-red-500">Error: Bar Chart requires an ID and data.</div>';
    }
    $options_json = json_encode($options);
    return "<canvas id=\"{$id}\" data-options='{$options_json}'></canvas>";
}

// Pie Chart
function pie_chart($id, $data, $options = []) {
    if (empty($id) || empty($data)) {
        return '<div class="text-red-500">Error: Pie Chart requires an ID and data.</div>';
    }
    $options_json = json_encode($options);
    return "<canvas id=\"{$id}\" data-options='{$options_json}'></canvas>";
}

// Donut Chart
function donut_chart($id, $data, $options = []) {
    if (empty($id) || empty($data)) {
        return '<div class="text-red-500">Error: Donut Chart requires an ID and data.</div>';
    }
    $options_json = json_encode($options);
    return "<canvas id=\"{$id}\" data-options='{$options_json}'></canvas>";
}

// Area Chart
function area_chart($id, $data, $options = []) {
    if (empty($id) || empty($data)) {
        return '<div class="text-red-500">Error: Area Chart requires an ID and data.</div>';
    }
    $options_json = json_encode($options);
    return "<canvas id=\"{$id}\" data-options='{$options_json}'></canvas>";
}

// Scatter Plot
function scatter_plot($id, $data, $options = []) {
    if (empty($id) || empty($data)) {
        return '<div class="text-red-500">Error: Scatter Plot requires an ID and data.</div>';
    }
    $options_json = json_encode($options);
    return "<canvas id=\"{$id}\" data-options='{$options_json}'></canvas>";
}

// Bubble Chart
function bubble_chart($id, $data, $options = []) {
    if (empty($id) || empty($data)) {
        return '<div class="text-red-500">Error: Bubble Chart requires an ID and data.</div>';
    }
    $options_json = json_encode($options);
    return "<canvas id=\"{$id}\" data-options='{$options_json}'></canvas>";
}

// Radar Chart
function radar_chart($id, $data, $options = []) {
    if (empty($id) || empty($data)) {
        return '<div class="text-red-500">Error: Radar Chart requires an ID and data.</div>';
    }
    $options_json = json_encode($options);
    return "<canvas id=\"{$id}\" data-options='{$options_json}'></canvas>";
}

// Heatmap
function heatmap($id, $data, $options = []) {
    if (empty($id) || empty($data)) {
        return '<div class="text-red-500">Error: Heatmap requires an ID and data.</div>';
    }
    $options_json = json_encode($options);
    return "<div id=\"{$id}\" data-options='{$options_json}'></div>";
}

// Treemap
function treemap($id, $data, $options = []) {
    if (empty($id) || empty($data)) {
        return '<div class="text-red-500">Error: Treemap requires an ID and data.</div>';
    }
    $options_json = json_encode($options);
    return "<div id=\"{$id}\" data-options='{$options_json}'></div>";
}

// Waterfall Chart
function waterfall_chart($id, $data, $options = []) {
    if (empty($id) || empty($data)) {
        return '<div class="text-red-500">Error: Waterfall Chart requires an ID and data.</div>';
    }
    $options_json = json_encode($options);
    return "<canvas id=\"{$id}\" data-options='{$options_json}'></canvas>";
}

// Candlestick Chart
function candlestick_chart($id, $data, $options = []) {
    if (empty($id) || empty($data)) {
        return '<div class="text-red-500">Error: Candlestick Chart requires an ID and data.</div>';
    }
    $options_json = json_encode($options);
    return "<canvas id=\"{$id}\" data-options='{$options_json}'></canvas>";
}

// Sankey Diagram
function sankey_diagram($id, $data, $options = []) {
    if (empty($id) || empty($data)) {
        return '<div class="text-red-500">Error: Sankey Diagram requires an ID and data.</div>';
    }
    $options_json = json_encode($options);
    return "<div id=\"{$id}\" data-options='{$options_json}'></div>";
}

// Box and Whisker Plot
function box_whisker_plot($id, $data, $options = []) {
    if (empty($id) || empty($data)) {
        return '<div class="text-red-500">Error: Box and Whisker Plot requires an ID and data.</div>';
    }
    $options_json = json_encode($options);
    return "<canvas id=\"{$id}\" data-options='{$options_json}'></canvas>";
}

/**
 * Input Components
 */

// Text Input
function text_input($name, $label, $value = '', $attributes = []) {
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"mb-4\">
        <label class=\"block text-gray-700 text-sm font-bold mb-2\" for=\"{$name}\">
            {$label}
        </label>
        <input class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline\" id=\"{$name}\" name=\"{$name}\" type=\"text\" value=\"{$value}\"{$attrs}>
    </div>";
}

// Number Input
function number_input($name, $label, $value = '', $attributes = []) {
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"mb-4\">
        <label class=\"block text-gray-700 text-sm font-bold mb-2\" for=\"{$name}\">
            {$label}
        </label>
        <input class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline\" id=\"{$name}\" name=\"{$name}\" type=\"number\" value=\"{$value}\"{$attrs}>
    </div>";
}

// Password Input
function password_input($name, $label, $attributes = []) {
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"mb-4\">
        <label class=\"block text-gray-700 text-sm font-bold mb-2\" for=\"{$name}\">
            {$label}
        </label>
        <input class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline\" id=\"{$name}\" name=\"{$name}\" type=\"password\"{$attrs}>
    </div>";
}

// Email Input
function email_input($name, $label, $value = '', $attributes = []) {
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"mb-4\">
        <label class=\"block text-gray-700 text-sm font-bold mb-2\" for=\"{$name}\">
            {$label}
        </label>
        <input class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline\" id=\"{$name}\" name=\"{$name}\" type=\"email\" value=\"{$value}\"{$attrs}>
    </div>";
}

// Search Input
function search_input($name, $label, $value = '', $attributes = []) {
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"mb-4\">
        <label class=\"block text-gray-700 text-sm font-bold mb-2\" for=\"{$name}\">
            {$label}
        </label>
        <input class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline\" id=\"{$name}\" name=\"{$name}\" type=\"search\" value=\"{$value}\"{$attrs}>
    </div>";
}

// Autocomplete Input
function autocomplete_input($name, $label, $options = [], $attributes = []) {
    $options_html = '';
    foreach ($options as $option) {
        $options_html .= "<option value=\"{$option}\">{$option}</option>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"mb-4\">
        <label class=\"block text-gray-700 text-sm font-bold mb-2\" for=\"{$name}\">
            {$label}
        </label>
        <input list=\"{$name}_list\" class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline\" id=\"{$name}\" name=\"{$name}\"{$attrs}>
        <datalist id=\"{$name}_list\">
            {$options_html}
        </datalist>
    </div>";
}

// Select/Dropdown
function select_dropdown($name, $label, $options = [], $selected = '', $attributes = []) {
    $options_html = '';
    foreach ($options as $value => $text) {
        $is_selected = ($value == $selected) ? 'selected' : '';
        $options_html .= "<option value=\"{$value}\" {$is_selected}>{$text}</option>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"mb-4\">
        <label class=\"block text-gray-700 text-sm font-bold mb-2\" for=\"{$name}\">
            {$label}
        </label>
        <select class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline\" id=\"{$name}\" name=\"{$name}\"{$attrs}>
            {$options_html}
        </select>
    </div>";
}

// Multi-select
function multi_select($name, $label, $options = [], $selected = [], $attributes = []) {
    $options_html = '';
    foreach ($options as $value => $text) {
        $is_selected = in_array($value, $selected) ? 'selected' : '';
        $options_html .= "<option value=\"{$value}\" {$is_selected}>{$text}</option>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"mb-4\">
        <label class=\"block text-gray-700 text-sm font-bold mb-2\" for=\"{$name}\">
            {$label}
        </label>
        <select multiple class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline\" id=\"{$name}\" name=\"{$name}[]\"{$attrs}>
            {$options_html}
        </select>
    </div>";
}

// Checkbox
function checkbox($name, $label, $checked = false, $attributes = []) {
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    $is_checked = $checked ? 'checked' : '';
    return "
    <div class=\"mb-4\">
        <label class=\"inline-flex items-center\">
            <input type=\"checkbox\" class=\"form-checkbox\" name=\"{$name}\" {$is_checked}{$attrs}>
            <span class=\"ml-2\">{$label}</span>
        </label>
    </div>";
}

// Radio Button
function radio_button($name, $label, $value, $checked = false, $attributes = []) {
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    $is_checked = $checked ? 'checked' : '';
    return "
    <div class=\"mb-4\">
        <label class=\"inline-flex items-center\">
            <input type=\"radio\" class=\"form-radio\" name=\"{$name}\" value=\"{$value}\" {$is_checked}{$attrs}>
            <span class=\"ml-2\">{$label}</span>
        </label>
    </div>";
}

// Toggle Switch
function toggle_switch($name, $label, $checked = false, $attributes = []) {
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    $is_checked = $checked ? 'checked' : '';
    return "
    <div class=\"flex items-center mb-4\">
        <label for=\"{$name}\" class=\"mr-2\">{$label}</label>
        <input type=\"checkbox\" id=\"{$name}\" name=\"{$name}\" class=\"toggle-switch\" {$is_checked}{$attrs}>
    </div>";
}

// Date Picker
function date_picker($name, $label, $value = '', $attributes = []) {
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"mb-4\">
        <label class=\"block text-gray-700 text-sm font-bold mb-2\" for=\"{$name}\">
            {$label}
        </label>
        <input type=\"date\" id=\"{$name}\" name=\"{$name}\" value=\"{$value}\" class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline\"{$attrs}>
    </div>";
}

// Time Picker
function time_picker($name, $label, $value = '', $attributes = []) {
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"mb-4\">
        <label class=\"block text-gray-700 text-sm font-bold mb-2\" for=\"{$name}\">
            {$label}
        </label>
        <input type=\"time\" id=\"{$name}\" name=\"{$name}\" value=\"{$value}\" class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline\"{$attrs}>
    </div>";
}

// Date Range Picker
function date_range_picker($name, $label, $start_value = '', $end_value = '', $attributes = []) {
    $attrs_start = '';
    $attrs_end = '';
    if (isset($attributes['start'])) {
        foreach ($attributes['start'] as $key => $val) {
            $attrs_start .= " {$key}=\"{$val}\"";
        }
    }
    if (isset($attributes['end'])) {
        foreach ($attributes['end'] as $key => $val) {
            $attrs_end .= " {$key}=\"{$val}\"";
        }
    }
    return "
    <div class=\"mb-4\">
        <label class=\"block text-gray-700 text-sm font-bold mb-2\">
            {$label}
        </label>
        <div class=\"flex space-x-2\">
            <input type=\"date\" id=\"{$name}_start\" name=\"{$name}_start\" value=\"{$start_value}\" class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline\"{$attrs_start}>
            <input type=\"date\" id=\"{$name}_end\" name=\"{$name}_end\" value=\"{$end_value}\" class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline\"{$attrs_end}>
        </div>
    </div>";
}

// Color Picker
function color_picker($name, $label, $value = '#000000', $attributes = []) {
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"mb-4\">
        <label class=\"block text-gray-700 text-sm font-bold mb-2\" for=\"{$name}\">
            {$label}
        </label>
        <input type=\"color\" id=\"{$name}\" name=\"{$name}\" value=\"{$value}\" class=\"shadow appearance-none border rounded w-16 h-10 p-0 focus:outline-none focus:shadow-outline\"{$attrs}>
    </div>";
}

// File Upload
function file_upload($name, $label, $attributes = []) {
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"mb-4\">
        <label class=\"block text-gray-700 text-sm font-bold mb-2\" for=\"{$name}\">
            {$label}
        </label>
        <input type=\"file\" id=\"{$name}\" name=\"{$name}\" class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline\"{$attrs}>
    </div>";
}

// Slider
function slider($name, $label, $min, $max, $step = 1, $value = '', $attributes = []) {
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"mb-4\">
        <label for=\"{$name}\" class=\"block text-gray-700 text-sm font-bold mb-2\">{$label}</label>
        <input type=\"range\" id=\"{$name}\" name=\"{$name}\" min=\"{$min}\" max=\"{$max}\" step=\"{$step}\" value=\"{$value}\" class=\"w-full\"{$attrs}>
    </div>";
}

// Rating Input
function rating_input($name, $label, $max = 5, $value = 0, $attributes = []) {
    $stars = '';
    for ($i = 1; $i <= $max; $i++) {
        $checked = ($i <= $value) ? 'checked' : '';
        $stars .= "<input type=\"radio\" name=\"{$name}\" value=\"{$i}\" class=\"hidden\" {$checked}>
                   <label class=\"cursor-pointer text-yellow-500 text-2xl\">&#9733;</label>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"mb-4\">
        <span class=\"block text-gray-700 text-sm font-bold mb-2\">{$label}</span>
        <div class=\"flex space-x-1\"{$attrs}>
            {$stars}
        </div>
    </div>";
}

/**
 * Navigation Components
 */

// Sidebar Menu
function sidebar_menu($menus, $current = '') {
    $menu_html = '';
    foreach ($menus as $menu) {
        $active = ($menu['slug'] === $current) ? 'bg-gray-200' : '';
        $menu_html .= "
        <li>
            <a href=\"{$menu['url']}\" class=\"block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-200 {$active}\">
                <i class=\"material-icons\">{$menu['icon']}</i> {$menu['name']}
            </a>";
        if (!empty($menu['sub_menu'])) {
            $submenu_html = '<ul class="ml-4">';
            foreach ($menu['sub_menu'] as $sub) {
                $submenu_html .= "
                <li>
                    <a href=\"{$sub['url']}\" class=\"block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-200\">
                        <i class=\"material-icons\">{$sub['icon']}</i> {$sub['name']}
                    </a>
                </li>";
            }
            $submenu_html .= '</ul>';
            $menu_html .= $submenu_html;
        }
        $menu_html .= "</li>";
    }
    return "<nav class=\"w-64 bg-white shadow-md h-full overflow-y-auto\">
                <ul class=\"py-4\">
                    {$menu_html}
                </ul>
            </nav>";
}

// Top Navigation Bar
function top_navbar($title = '', $actions = []) {
    $actions_html = '';
    foreach ($actions as $action) {
        $actions_html .= "<button class=\"text-gray-700 hover:text-gray-900 mx-2\" onclick=\"{$action['onclick']}\">
                            <i class=\"material-icons\">{$action['icon']}</i>
                          </button>";
    }
    return "
    <header class=\"flex justify-between items-center bg-white shadow-md p-4\">
        <h1 class=\"text-xl font-semibold\">{$title}</h1>
        <div class=\"flex items-center\">
            {$actions_html}
        </div>
    </header>";
}

// Breadcrumbs
function breadcrumbs($items = []) {
    $breadcrumb_html = '';
    foreach ($items as $index => $item) {
        if ($index > 0) {
            $breadcrumb_html .= "<span class=\"mx-2\">&gt;</span>";
        }
        if (isset($item['url'])) {
            $breadcrumb_html .= "<a href=\"{$item['url']}\" class=\"text-blue-500 hover:underline\">{$item['name']}</a>";
        } else {
            $breadcrumb_html .= "<span>{$item['name']}</span>";
        }
    }
    return "<nav class=\"text-sm mb-4\">{$breadcrumb_html}</nav>";
}

// Tabs
function tabs($tabs = [], $active = '') {
    $tabs_html = '';
    foreach ($tabs as $tab) {
        $is_active = ($tab['slug'] === $active) ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-600';
        $tabs_html .= "<a href=\"{$tab['url']}\" class=\"mr-6 pb-2 {$is_active}\">{$tab['name']}</a>";
    }
    return "<div class=\"border-b mb-4\">{$tabs_html}</div>";
}

// Accordion
function accordion($items = []) {
    $accordion_html = '';
    foreach ($items as $index => $item) {
        $accordion_html .= "
        <div class=\"border-b\">
            <button class=\"w-full text-left py-2 px-4 focus:outline-none accordion-button\" data-index=\"{$index}\">
                {$item['title']}
                <i class=\"material-icons float-right\">expand_more</i>
            </button>
            <div class=\"accordion-content hidden px-4 py-2\">
                {$item['content']}
            </div>
        </div>";
    }
    return "<div class=\"accordion\">{$accordion_html}</div>";
}

// Dropdown Menu
function dropdown_menu($trigger, $items = []) {
    $items_html = '';
    foreach ($items as $item) {
        $items_html .= "<a href=\"{$item['url']}\" class=\"block px-4 py-2 hover:bg-gray-100\">{$item['name']}</a>";
    }
    return "
    <div class=\"relative inline-block text-left\">
        <div>
            <button type=\"button\" class=\"inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none\" id=\"menu-button\" aria-expanded=\"true\" aria-haspopup=\"true\">
                {$trigger}
                <i class=\"material-icons ml-2\">arrow_drop_down</i>
            </button>
        </div>
        <div class=\"origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden\" role=\"menu\" aria-orientation=\"vertical\" aria-labelledby=\"menu-button\">
            <div class=\"py-1\" role=\"none\">
                {$items_html}
            </div>
        </div>
    </div>";
}

// Pagination
function pagination($current, $total, $base_url) {
    if ($total <= 1) return '';
    $pagination_html = '<div class="flex justify-center mt-4">';
    for ($i = 1; $i <= $total; $i++) {
        $active = ($i == $current) ? 'bg-blue-500 text-white' : 'bg-white text-blue-500';
        $pagination_html .= "<a href=\"{$base_url}?page={$i}\" class=\"mx-1 px-3 py-1 rounded {$active}\">{$i}</a>";
    }
    $pagination_html .= '</div>';
    return $pagination_html;
}

// Side Panel
function side_panel($content, $is_open = false) {
    $display = $is_open ? 'block' : 'hidden';
    return "<div class=\"fixed right-0 top-0 h-full w-64 bg-white shadow-lg p-4 {$display}\">
                {$content}
            </div>";
}

/**
 * Data Display Components
 */

// Data Table
function data_table($headers = [], $rows = [], $attributes = []) {
    $thead = '<thead class="bg-gray-200">';
    foreach ($headers as $header) {
        $thead .= "<th class=\"py-2 px-4\">{$header}</th>";
    }
    $thead .= '</thead>';

    $tbody = '<tbody>';
    foreach ($rows as $row) {
        $tbody .= '<tr class="border-b hover:bg-gray-100">';
        foreach ($row as $cell) {
            $tbody .= "<td class=\"py-2 px-4\">{$cell}</td>";
        }
        $tbody .= '</tr>';
    }
    $tbody .= '</tbody>';

    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }

    return "<table class=\"min-w-full table-auto\"{$attrs}>
                {$thead}
                {$tbody}
            </table>";
}

// Sortable Table
function sortable_table($headers = [], $rows = [], $current_sort = '', $sort_direction = 'asc', $attributes = []) {
    $thead = '<thead class="bg-gray-200">';
    foreach ($headers as $header) {
        $direction = ($current_sort == $header) ? ($sort_direction == 'asc' ? '↑' : '↓') : '';
        $thead .= "<th class=\"py-2 px-4 cursor-pointer\" onclick=\"sortTable('{$header}')\">{$header} {$direction}</th>";
    }
    $thead .= '</thead>';

    $tbody = '<tbody>';
    foreach ($rows as $row) {
        $tbody .= '<tr class="border-b hover:bg-gray-100">';
        foreach ($row as $cell) {
            $tbody .= "<td class=\"py-2 px-4\">{$cell}</td>";
        }
        $tbody .= '</tr>';
    }
    $tbody .= '</tbody>';

    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }

    return "<table class=\"min-w-full table-auto\"{$attrs}>
                {$thead}
                {$tbody}
            </table>";
}

// Filterable Table
function filterable_table($headers = [], $rows = [], $filters = [], $attributes = []) {
    $filter_html = '<div class="flex space-x-4 mb-4">';
    foreach ($filters as $filter) {
        $filter_html .= $filter;
    }
    $filter_html .= '</div>';

    $thead = '<thead class="bg-gray-200">';
    foreach ($headers as $header) {
        $thead .= "<th class=\"py-2 px-4\">{$header}</th>";
    }
    $thead .= '</thead>';

    $tbody = '<tbody>';
    foreach ($rows as $row) {
        $tbody .= '<tr class="border-b hover:bg-gray-100">';
        foreach ($row as $cell) {
            $tbody .= "<td class=\"py-2 px-4\">{$cell}</td>";
        }
        $tbody .= '</tr>';
    }
    $tbody .= '</tbody>';

    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }

    return "{$filter_html}
            <table class=\"min-w-full table-auto\"{$attrs}>
                {$thead}
                {$tbody}
            </table>";
}

// Card
function card($title, $content, $footer = '', $attributes = []) {
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"bg-white shadow rounded p-4\"{$attrs}>
        <h2 class=\"text-xl font-semibold mb-2\">{$title}</h2>
        <div class=\"mb-2\">{$content}</div>
        <div>{$footer}</div>
    </div>";
}

// List View
function list_view($items = [], $attributes = []) {
    $items_html = '';
    foreach ($items as $item) {
        $items_html .= "<li class=\"py-2 px-4 border-b\">{$item}</li>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<ul class=\"bg-white shadow rounded\"{$attrs}>{$items_html}</ul>";
}

// Grid View
function grid_view($items = [], $columns = 3, $attributes = []) {
    $grid_html = '<div class="grid grid-cols-' . $columns . ' gap-4">';
    foreach ($items as $item) {
        $grid_html .= "<div class=\"bg-white shadow rounded p-4\">{$item}</div>";
    }
    $grid_html .= '</div>';
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div class=\"{$attrs}\">{$grid_html}</div>";
}

// Timeline
function timeline($events = [], $attributes = []) {
    $events_html = '';
    foreach ($events as $event) {
        $events_html .= "
        <div class=\"flex mb-4\">
            <div class=\"flex-shrink-0\">
                <div class=\"h-8 w-8 bg-blue-500 rounded-full flex items-center justify-center text-white\">
                    <i class=\"material-icons\">{$event['icon']}</i>
                </div>
            </div>
            <div class=\"ml-4\">
                <h3 class=\"text-lg font-semibold\">{$event['title']}</h3>
                <p class=\"text-gray-600\">{$event['description']}</p>
                <span class=\"text-sm text-gray-400\">{$event['time']}</span>
            </div>
        </div>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div class=\"timeline\"{$attrs}>{$events_html}</div>";
}

// Progress Bar
function progress_bar($percentage, $label = '', $color = 'blue', $attributes = []) {
    $color_classes = [
        'blue' => 'bg-blue-500',
        'green' => 'bg-green-500',
        'red' => 'bg-red-500',
        'yellow' => 'bg-yellow-500',
        'purple' => 'bg-purple-500',
    ];
    $color_class = isset($color_classes[$color]) ? $color_classes[$color] : 'bg-blue-500';
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"mb-4\"{$attrs}>
        <div class=\"flex justify-between mb-1\">
            <span>{$label}</span>
            <span>{$percentage}%</span>
        </div>
        <div class=\"w-full bg-gray-200 rounded-full h-4\">
            <div class=\"{$color_class} h-4 rounded-full\" style=\"width: {$percentage}%;\"></div>
        </div>
    </div>";
}

// Stat Card/Metric Card
function stat_card($title, $value, $icon = '', $color = 'blue', $attributes = []) {
    $color_classes = [
        'blue' => 'bg-blue-500',
        'green' => 'bg-green-500',
        'red' => 'bg-red-500',
        'yellow' => 'bg-yellow-500',
        'purple' => 'bg-purple-500',
    ];
    $color_class = isset($color_classes[$color]) ? $color_classes[$color] : 'bg-blue-500';
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"flex items-center p-4 bg-white shadow rounded\"{$attrs}>
        <div class=\"p-3 rounded-full {$color_class} text-white\">
            <i class=\"material-icons\">{$icon}</i>
        </div>
        <div class=\"ml-4\">
            <p class=\"text-sm text-gray-600\">{$title}</p>
            <p class=\"text-lg font-semibold\">{$value}</p>
        </div>
    </div>";
}

// Alert/Notification Box
function alert_box($message, $type = 'info', $dismissible = false, $attributes = []) {
    $type_classes = [
        'info' => 'bg-blue-100 text-blue-700',
        'success' => 'bg-green-100 text-green-700',
        'danger' => 'bg-red-100 text-red-700',
        'warning' => 'bg-yellow-100 text-yellow-700',
        'error' => 'bg-red-100 text-red-700',
        'update' => 'bg-purple-100 text-purple-700',
        'notification' => 'bg-gray-100 text-gray-700',
        'hurray' => 'bg-pink-100 text-pink-700',
    ];
    $class = isset($type_classes[$type]) ? $type_classes[$type] : $type_classes['info'];
    $dismiss = $dismissible ? '<button class="ml-4 text-lg leading-none">&times;</button>' : '';
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div class=\"flex items-center justify-between px-4 py-3 rounded {$class} mb-4\" role=\"alert\"{$attrs}>
                <span>{$message}</span>
                {$dismiss}
            </div>";
}

// Tooltip
function tooltip($text, $tooltip_text, $position = 'top', $attributes = []) {
    $positions = ['top', 'right', 'bottom', 'left'];
    $pos = in_array($position, $positions) ? $position : 'top';
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<span class=\"relative group\"{$attrs}>
                {$text}
                <span class=\"absolute {$pos}-full left-1/2 transform -translate-x-1/2 mt-2 px-2 py-1 bg-gray-700 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity\">
                    {$tooltip_text}
                </span>
            </span>";
}

// Modal/Dialog
function modal_dialog($id, $title, $content, $actions = [], $attributes = []) {
    $actions_html = '';
    foreach ($actions as $action) {
        $actions_html .= "<button class=\"bg-{$action['color']}-500 hover:bg-{$action['color']}-700 text-white font-bold py-2 px-4 rounded\" onclick=\"{$action['onclick']}\">{$action['text']}</button>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div id=\"{$id}\" class=\"fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden\"{$attrs}>
        <div class=\"bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full\">
            <div class=\"px-4 pt-5 pb-4\">
                <h3 class=\"text-lg leading-6 font-medium text-gray-900 mb-4\">{$title}</h3>
                <div class=\"\">
                    {$content}
                </div>
            </div>
            <div class=\"px-4 py-3 bg-gray-50 text-right\">
                {$actions_html}
            </div>
        </div>
    </div>";
}

// Popover
function popover($trigger, $content, $position = 'right', $attributes = []) {
    $positions = ['top', 'right', 'bottom', 'left'];
    $pos = in_array($position, $positions) ? $position : 'right';
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div class=\"relative group\"{$attrs}>
                {$trigger}
                <div class=\"absolute {$pos}-full left-1/2 transform -translate-x-1/2 mt-2 w-48 bg-white border rounded shadow-lg p-2 opacity-0 group-hover:opacity-100 transition-opacity\">
                    {$content}
                </div>
            </div>";
}

/**
 * Interactive Elements
 */

// Buttons
function button($text, $type = 'primary', $attributes = []) {
    $type_classes = [
        'primary' => 'bg-blue-500 hover:bg-blue-700 text-white',
        'secondary' => 'bg-gray-500 hover:bg-gray-700 text-white',
        'success' => 'bg-green-500 hover:bg-green-700 text-white',
        'danger' => 'bg-red-500 hover:bg-red-700 text-white',
        'warning' => 'bg-yellow-500 hover:bg-yellow-700 text-white',
        'info' => 'bg-teal-500 hover:bg-teal-700 text-white',
        'light' => 'bg-white hover:bg-gray-100 text-gray-800',
        'dark' => 'bg-gray-800 hover:bg-gray-900 text-white',
    ];
    $classes = isset($type_classes[$type]) ? $type_classes[$type] : $type_classes['primary'];
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<button class=\"py-2 px-4 rounded {$classes}\"{$attrs}>{$text}</button>";
}

// Icon Buttons
function icon_button($icon, $type = 'primary', $attributes = []) {
    $type_classes = [
        'primary' => 'bg-blue-500 hover:bg-blue-700 text-white',
        'secondary' => 'bg-gray-500 hover:bg-gray-700 text-white',
        'success' => 'bg-green-500 hover:bg-green-700 text-white',
        'danger' => 'bg-red-500 hover:bg-red-700 text-white',
        'warning' => 'bg-yellow-500 hover:bg-yellow-700 text-white',
        'info' => 'bg-teal-500 hover:bg-teal-700 text-white',
        'light' => 'bg-white hover:bg-gray-100 text-gray-800',
        'dark' => 'bg-gray-800 hover:bg-gray-900 text-white',
    ];
    $classes = isset($type_classes[$type]) ? $type_classes[$type] : $type_classes['primary'];
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<button class=\"p-2 rounded {$classes}\"{$attrs}>
                <i class=\"material-icons\">{$icon}</i>
            </button>";
}

// Dropdown Buttons
function dropdown_button($trigger_text, $type = 'primary', $items = [], $attributes = []) {
    $type_classes = [
        'primary' => 'bg-blue-500 hover:bg-blue-700 text-white',
        'secondary' => 'bg-gray-500 hover:bg-gray-700 text-white',
        'success' => 'bg-green-500 hover:bg-green-700 text-white',
        'danger' => 'bg-red-500 hover:bg-red-700 text-white',
        'warning' => 'bg-yellow-500 hover:bg-yellow-700 text-white',
        'info' => 'bg-teal-500 hover:bg-teal-700 text-white',
        'light' => 'bg-white hover:bg-gray-100 text-gray-800',
        'dark' => 'bg-gray-800 hover:bg-gray-900 text-white',
    ];
    $classes = isset($type_classes[$type]) ? $type_classes[$type] : $type_classes['primary'];
    $items_html = '';
    foreach ($items as $item) {
        $items_html .= "<a href=\"{$item['url']}\" class=\"block px-4 py-2 hover:bg-gray-100\">{$item['name']}</a>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"relative inline-block text-left\"{$attrs}>
        <button type=\"button\" class=\"inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50\" id=\"dropdown-button\">
            {$trigger_text}
            <i class=\"material-icons ml-2\">arrow_drop_down</i>
        </button>
        <div class=\"origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden\" role=\"menu\">
            <div class=\"py-1\" role=\"none\">
                {$items_html}
            </div>
        </div>
    </div>";
}

// Split Buttons
function split_button($main_text, $type = 'primary', $dropdown_items = [], $attributes = []) {
    $type_classes = [
        'primary' => 'bg-blue-500 hover:bg-blue-700 text-white',
        'secondary' => 'bg-gray-500 hover:bg-gray-700 text-white',
        'success' => 'bg-green-500 hover:bg-green-700 text-white',
        'danger' => 'bg-red-500 hover:bg-red-700 text-white',
        'warning' => 'bg-yellow-500 hover:bg-yellow-700 text-white',
        'info' => 'bg-teal-500 hover:bg-teal-700 text-white',
        'light' => 'bg-white hover:bg-gray-100 text-gray-800',
        'dark' => 'bg-gray-800 hover:bg-gray-900 text-white',
    ];
    $main_class = isset($type_classes[$type]) ? $type_classes[$type] : $type_classes['primary'];
    $dropdown_class = 'bg-gray-500 hover:bg-gray-700 text-white';
    $dropdown_items_html = '';
    foreach ($dropdown_items as $item) {
        $dropdown_items_html .= "<a href=\"{$item['url']}\" class=\"block px-4 py-2 hover:bg-gray-100\">{$item['name']}</a>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"flex\"{$attrs}>
        <button class=\"py-2 px-4 rounded-l {$main_class}\">{$main_text}</button>
        <div class=\"relative\">
            <button class=\"py-2 px-4 rounded-r {$dropdown_class}\">
                <i class=\"material-icons\">arrow_drop_down</i>
            </button>
            <div class=\"absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden\" role=\"menu\">
                <div class=\"py-1\" role=\"none\">
                    {$dropdown_items_html}
                </div>
            </div>
        </div>
    </div>";
}

// Accordion
function interactive_accordion($items = [], $attributes = []) {
    $accordion_html = '';
    foreach ($items as $index => $item) {
        $accordion_html .= "
        <div class=\"border-b\">
            <button class=\"w-full text-left py-2 px-4 focus:outline-none accordion-button\" data-index=\"{$index}\">
                {$item['title']}
                <i class=\"material-icons float-right\">expand_more</i>
            </button>
            <div class=\"accordion-content hidden px-4 py-2\">
                {$item['content']}
            </div>
        </div>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div class=\"accordion\"{$attrs}>{$accordion_html}</div>";
}

// Collapsible Sections
function collapsible_section($title, $content, $attributes = []) {
    return "
    <details class=\"mb-4\">
        <summary class=\"cursor-pointer font-semibold text-gray-700\">{$title}</summary>
        <div class=\"mt-2 pl-4\">
            {$content}
        </div>
    </details>";
}

// Drag and Drop Interfaces
function drag_and_drop($id, $items = [], $attributes = []) {
    $items_html = '';
    foreach ($items as $item) {
        $items_html .= "<div class=\"p-2 mb-2 bg-gray-200 rounded\" draggable=\"true\">{$item}</div>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div id=\"{$id}\" class=\"drag-container\"{$attrs}>{$items_html}</div>";
}

// Resizable Containers
function resizable_container($content, $attributes = []) {
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div class=\"resizable bg-white p-4 shadow rounded\"{$attrs}>
                {$content}
            </div>";
}

// Sortable Lists
function sortable_list($id, $items = [], $attributes = []) {
    $items_html = '';
    foreach ($items as $item) {
        $items_html .= "<li class=\"p-2 bg-gray-100 mb-2 rounded cursor-move\">{$item}</li>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<ul id=\"{$id}\" class=\"sortable-list\"{$attrs}>{$items_html}</ul>";
}

/**
 * Feedback and Notification Components
 */

// Toast/Snackbar
function toast($message, $type = 'normal', $duration = 3000, $attributes = []) {
    $type_classes = [
        'normal' => 'bg-gray-800 text-white',
        'success' => 'bg-green-500 text-white',
        'danger' => 'bg-red-500 text-white',
        'warning' => 'bg-yellow-500 text-white',
        'error' => 'bg-red-600 text-white',
        'alert' => 'bg-orange-500 text-white',
        'update' => 'bg-blue-500 text-white',
        'notification' => 'bg-teal-500 text-white',
        'hurray' => 'bg-pink-500 text-white',
    ];
    $class = isset($type_classes[$type]) ? $type_classes[$type] : $type_classes['normal'];
    $attrs = "data-duration=\"{$duration}\" ";
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div class=\"toast fixed bottom-4 right-4 px-4 py-2 rounded shadow-lg {$class}\" {$attrs}>
                {$message}
            </div>";
}

// Alert Banners
function alert_banner($message, $type = 'info', $dismissible = false, $attributes = []) {
    return alert_box($message, $type, $dismissible, $attributes);
}

// Loading Spinner
function loading_spinner($size = 'md', $color = 'blue', $attributes = []) {
    $size_classes = [
        'sm' => 'w-4 h-4',
        'md' => 'w-8 h-8',
        'lg' => 'w-12 h-12',
    ];
    $size_class = isset($size_classes[$size]) ? $size_classes[$size] : $size_classes['md'];
    $color_classes = [
        'blue' => 'border-blue-500',
        'green' => 'border-green-500',
        'red' => 'border-red-500',
        'yellow' => 'border-yellow-500',
        'purple' => 'border-purple-500',
    ];
    $color_class = isset($color_classes[$color]) ? $color_classes[$color] : $color_classes['blue'];
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div class=\"loader border-4 border-t-4 {$color_class} rounded-full animate-spin {$size_class}\"{$attrs}></div>";
}

// Progress Indicator
function progress_indicator($current, $total, $attributes = []) {
    $percentage = ($total > 0) ? ($current / $total) * 100 : 0;
    return progress_bar($percentage, "{$current} of {$total}", 'blue', $attributes);
}

// Confirmation Dialog
function confirmation_dialog($id, $message, $confirm_text = 'Confirm', $cancel_text = 'Cancel', $attributes = []) {
    return modal_dialog($id, 'Confirmation', "<p>{$message}</p>", [
        ['text' => $confirm_text, 'color' => 'green', 'onclick' => "confirmAction()"],
        ['text' => $cancel_text, 'color' => 'red', 'onclick' => "closeModal('{$id}')"],
    ], $attributes);
}

/**
 * Advanced Visualization Components
 */

// Geographic Map
function geographic_map($id, $data, $options = [], $attributes = []) {
    $options_json = json_encode($options);
    $data_json = json_encode($data);
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div id=\"{$id}\" data-data='{$data_json}' data-options='{$options_json}' class=\"w-full h-64\"{$attrs}></div>";
}

// Interactive World Map
function interactive_world_map($id, $data, $options = [], $attributes = []) {
    return geographic_map($id, $data, $options, $attributes);
}

// Choropleth Map for States of World
function choropleth_map($id, $data, $options = [], $attributes = []) {
    return geographic_map($id, $data, $options, $attributes);
}

// Network Graph
function network_graph($id, $data, $options = [], $attributes = []) {
    $options_json = json_encode($options);
    $data_json = json_encode($data);
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div id=\"{$id}\" data-data='{$data_json}' data-options='{$options_json}' class=\"w-full h-64\"{$attrs}></div>";
}

// Funnel Chart
function funnel_chart($id, $data, $options = [], $attributes = []) {
    return bar_chart($id, $data, $options); // Reusing bar_chart as placeholder
}

// Spark Lines
function spark_lines($id, $data, $options = [], $attributes = []) {
    $options_json = json_encode($options);
    $data_json = json_encode($data);
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<canvas id=\"{$id}\" data-data='{$data_json}' data-options='{$options_json}' class=\"sparkline\"{$attrs}></canvas>";
}

/**
 * Data Filtering and Manipulation
 */

// Filter Sidebar
function filter_sidebar($filters = [], $attributes = []) {
    $filters_html = '';
    foreach ($filters as $filter) {
        $filters_html .= "<div class=\"mb-4\">{$filter}</div>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<aside class=\"w-64 bg-gray-100 p-4\"{$attrs}>{$filters_html}</aside>";
}

// Multi-level Filter
function multi_level_filter($filters = [], $attributes = []) {
    $filters_html = '';
    foreach ($filters as $filter) {
        $filters_html .= "<div class=\"mb-4\">{$filter}</div>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div class=\"multi-level-filter\"{$attrs}>{$filters_html}</div>";
}

// Advanced Search
function advanced_search($fields = [], $attributes = []) {
    $fields_html = '';
    foreach ($fields as $field) {
        $fields_html .= $field;
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<form class=\"advanced-search mb-4\"{$attrs}>
                <div class=\"grid grid-cols-2 gap-4\">
                    {$fields_html}
                </div>
                <button type=\"submit\" class=\"mt-4 btn btn-primary\">Search</button>
            </form>";
}

// Quick Filters
function quick_filters($filters = [], $attributes = []) {
    $filters_html = '';
    foreach ($filters as $filter) {
        $filters_html .= "<button class=\"btn btn-secondary mr-2 mb-2\">{$filter}</button>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div class=\"quick-filters\"{$attrs}>{$filters_html}</div>";
}

// Filter Chips
function filter_chips($chips = [], $attributes = []) {
    $chips_html = '';
    foreach ($chips as $chip) {
        $chips_html .= "<span class=\"inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-gray-200 mr-2 mb-2\">
                            {$chip} <button class=\"ml-1 text-gray-500 hover:text-gray-700\">&times;</button>
                        </span>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div class=\"filter-chips\"{$attrs}>{$chips_html}</div>";
}

// Sort Dropdown
function sort_dropdown($options = [], $selected = '', $attributes = []) {
    $options_html = '';
    foreach ($options as $value => $text) {
        $is_selected = ($value == $selected) ? 'selected' : '';
        $options_html .= "<option value=\"{$value}\" {$is_selected}>{$text}</option>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<select class=\"shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline\"{$attrs}>
                {$options_html}
            </select>";
}

/**
 * User and Profile Components
 */

// Avatar
function avatar($image_url, $alt = 'Avatar', $size = 'md', $attributes = []) {
    $size_classes = [
        'sm' => 'w-8 h-8',
        'md' => 'w-12 h-12',
        'lg' => 'w-16 h-16',
    ];
    $size_class = isset($size_classes[$size]) ? $size_classes[$size] : $size_classes['md'];
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<img src=\"{$image_url}\" alt=\"{$alt}\" class=\"rounded-full {$size_class}\"{$attrs}>";
}

// User Profile Card
function user_profile_card($avatar_url, $name, $email, $actions = [], $attributes = []) {
    $actions_html = '';
    foreach ($actions as $action) {
        $actions_html .= button($action['text'], $action['type'], ['onclick' => $action['onclick']]);
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"flex items-center p-4 bg-white shadow rounded\"{$attrs}>
        " . avatar($avatar_url, $name, 'lg') . "
        <div class=\"ml-4\">
            <h2 class=\"text-xl font-semibold\">{$name}</h2>
            <p class=\"text-gray-600\">{$email}</p>
            <div class=\"mt-2\">
                {$actions_html}
            </div>
        </div>
    </div>";
}

// Login/Signup Form
function login_signup_form($action, $fields = [], $submit_text = 'Submit', $attributes = []) {
    $fields_html = '';
    foreach ($fields as $field) {
        $fields_html .= $field;
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<form action=\"{$action}\" method=\"POST\" class=\"w-full max-w-sm\"{$attrs}>
                {$fields_html}
                <div class=\"flex items-center justify-between\">
                    <button type=\"submit\" class=\"btn btn-primary\">{$submit_text}</button>
                </div>
            </form>";
}

// Permission Level Indicator
function permission_level_indicator($level, $max = 5, $attributes = []) {
    $stars = '';
    for ($i = 1; $i <= $max; $i++) {
        $star = ($i <= $level) ? '★' : '☆';
        $stars .= "<span class=\"text-yellow-500\">{$star}</span>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div class=\"permission-level\"{$attrs}>{$stars}</div>";
}

// User Status
function user_status($status, $attributes = []) {
    $status_classes = [
        'online' => 'bg-green-500',
        'offline' => 'bg-gray-500',
        'busy' => 'bg-red-500',
        'away' => 'bg-yellow-500',
    ];
    $class = isset($status_classes[$status]) ? $status_classes[$status] : 'bg-gray-500';
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<span class=\"inline-block w-3 h-3 rounded-full {$class}\" title=\"{$status}\"{$attrs}></span>";
}

// Role-based Access Control Indicators
function role_based_indicator($roles = [], $attributes = []) {
    $roles_html = '';
    foreach ($roles as $role) {
        $roles_html .= "<span class=\"inline-block bg-blue-200 text-blue-800 text-xs px-2 py-1 rounded mr-2\">{$role}</span>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div class=\"role-indicator\"{$attrs}>{$roles_html}</div>";
}

/**
 * Miscellaneous Components
 */

// Dark/Light Mode Toggle
function dark_light_toggle($attributes = []) {
    return "
    <button id=\"theme-toggle\" class=\"focus:outline-none\" title=\"Toggle Dark/Light Mode\">
        <i class=\"material-icons\">brightness_4</i>
    </button>";
}

// Language Selector
function language_selector($languages = [], $current = '', $attributes = []) {
    $options_html = '';
    foreach ($languages as $code => $name) {
        $selected = ($code == $current) ? 'selected' : '';
        $options_html .= "<option value=\"{$code}\" {$selected}>{$name}</option>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<select class=\"shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline\"{$attrs}>
                {$options_html}
            </select>";
}

// Responsive Grid System
function responsive_grid($items = [], $columns = 3, $attributes = []) {
    $grid_html = '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-' . $columns . ' gap-4">';
    foreach ($items as $item) {
        $grid_html .= "<div>{$item}</div>";
    }
    $grid_html .= '</div>';
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div class=\"responsive-grid\"{$attrs}>{$grid_html}</div>";
}

// Card Deck
function card_deck($cards = [], $attributes = []) {
    $deck_html = '';
    foreach ($cards as $card) {
        $deck_html .= "<div class=\"flex-1\">{$card}</div>";
    }
    return "<div class=\"flex space-x-4\">{$deck_html}</div>";
}

// Carousel
function carousel($id, $images = [], $attributes = []) {
    $images_html = '';
    foreach ($images as $image) {
        $images_html .= "<div class=\"carousel-item\">
                            <img src=\"{$image['src']}\" alt=\"{$image['alt']}\" class=\"w-full\">
                         </div>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div id=\"{$id}\" class=\"carousel relative\"{$attrs}>
                {$images_html}
                <button class=\"carousel-prev absolute top-1/2 left-0 transform -translate-y-1/2 bg-gray-800 text-white p-2\">&#10094;</button>
                <button class=\"carousel-next absolute top-1/2 right-0 transform -translate-y-1/2 bg-gray-800 text-white p-2\">&#10095;</button>
            </div>";
}

// Wizard/Multi-step Form
function wizard_form($steps = [], $current_step = 1, $content = '', $attributes = []) {
    $steps_html = '';
    foreach ($steps as $step) {
        $active = ($step['number'] == $current_step) ? 'text-blue-500' : 'text-gray-500';
        $steps_html .= "<div class=\"flex-1 text-center {$active}\">{$step['title']}</div>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "
    <div class=\"wizard-form\"{$attrs}>
        <div class=\"flex mb-4\">
            {$steps_html}
        </div>
        <div class=\"wizard-content\">
            {$content}
        </div>
    </div>";
}

// Embedded Media Player
function media_player($type, $src, $controls = true, $attributes = []) {
    $controls_attr = $controls ? 'controls' : '';
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    if ($type == 'video') {
        return "<video src=\"{$src}\" class=\"w-full\" {$controls_attr} {$attrs}></video>";
    } elseif ($type == 'audio') {
        return "<audio src=\"{$src}\" class=\"w-full\" {$controls_attr} {$attrs}></audio>";
    }
    return '';
}

// Share Buttons
function share_buttons($platforms = [], $url, $attributes = []) {
    $buttons_html = '';
    foreach ($platforms as $platform) {
        $share_url = '';
        switch ($platform) {
            case 'facebook':
                $share_url = "https://www.facebook.com/sharer/sharer.php?u={$url}";
                break;
            case 'twitter':
                $share_url = "https://twitter.com/intent/tweet?url={$url}";
                break;
            case 'linkedin':
                $share_url = "https://www.linkedin.com/shareArticle?mini=true&url={$url}";
                break;
            case 'whatsapp':
                $share_url = "https://api.whatsapp.com/send?text={$url}";
                break;
            case 'email':
                $share_url = "mailto:?body={$url}";
                break;
            default:
                continue;
        }
        $buttons_html .= "<a href=\"{$share_url}\" target=\"_blank\" class=\"mr-2\">
                            <i class=\"material-icons\">share</i> {$platform}
                          </a>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div class=\"share-buttons flex\"{$attrs}>{$buttons_html}</div>";
}

/**
 * Specialized Dashboards Components
 */

// Performance Metrics
function performance_metrics($metrics = [], $attributes = []) {
    $metrics_html = '';
    foreach ($metrics as $metric) {
        $metrics_html .= stat_card($metric['title'], $metric['value'], $metric['icon'], $metric['color']);
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div class=\"performance-metrics grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4\"{$attrs}>{$metrics_html}</div>";
}

// KPI Indicators
function kpi_indicators($kpis = [], $attributes = []) {
    $kpi_html = '';
    foreach ($kpis as $kpi) {
        $kpi_html .= stat_card($kpi['title'], $kpi['value'], $kpi['icon'], $kpi['color']);
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div class=\"kpi-indicators grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4\"{$attrs}>{$kpi_html}</div>";
}

// Comparison Widgets
function comparison_widget($title, $current, $previous, $attributes = []) {
    $change = $current - $previous;
    $change_class = ($change >= 0) ? 'text-green-500' : 'text-red-500';
    $change_icon = ($change >= 0) ? 'arrow_upward' : 'arrow_downward';
    return card($title, "
                <p class=\"text-2xl font-bold\">{$current}</p>
                <p class=\"{$change_class}\"><i class=\"material-icons\">{$change_icon}</i> {$change}</p>
            ");
}

// Trend Indicators
function trend_indicator($label, $value, $trend = 'up', $attributes = []) {
    $trend_class = ($trend == 'up') ? 'text-green-500' : 'text-red-500';
    $trend_icon = ($trend == 'up') ? 'arrow_upward' : 'arrow_downward';
    return "
    <div class=\"flex items-center mb-2\">
        <span class=\"font-semibold mr-2\">{$label}:</span>
        <span class=\"{$trend_class}\">{$value} <i class=\"material-icons\">{$trend_icon}</i></span>
    </div>";
}

// Anomaly Detection Visualization
function anomaly_detection($id, $data, $options = [], $attributes = []) {
    return line_chart($id, $data, $options); // Reusing line_chart as placeholder
}

// Predictive Analytics Visualization
function predictive_analytics($id, $data, $options = [], $attributes = []) {
    return area_chart($id, $data, $options); // Reusing area_chart as placeholder
}

/**
 * Interaction and Utility Components
 */

// Clipboard Copy Button
function clipboard_copy_button($text, $attributes = []) {
    return "<button class=\"clipboard-copy btn btn-secondary\" data-clipboard-text=\"{$text}\">
                <i class=\"material-icons\">content_copy</i>
            </button>";
}

// Zoom Controls
function zoom_controls($attributes = []) {
    return "
    <div class=\"zoom-controls flex space-x-2\">
        <button class=\"btn btn-secondary\" onclick=\"zoomIn()\"><i class=\"material-icons\">zoom_in</i></button>
        <button class=\"btn btn-secondary\" onclick=\"zoomOut()\"><i class=\"material-icons\">zoom_out</i></button>
    </div>";
}

// Fullscreen Toggle
function fullscreen_toggle($attributes = []) {
    return "<button class=\"fullscreen-toggle btn btn-secondary\" onclick=\"toggleFullscreen()\">
                <i class=\"material-icons\">fullscreen</i>
            </button>";
}

// Responsive Layout Shifter
function layout_shifter($layouts = [], $attributes = []) {
    $buttons_html = '';
    foreach ($layouts as $layout) {
        $buttons_html .= "<button class=\"btn btn-secondary mr-2\" onclick=\"shiftLayout('{$layout}')\">{$layout}</button>";
    }
    $attrs = '';
    foreach ($attributes as $key => $val) {
        $attrs .= " {$key}=\"{$val}\"";
    }
    return "<div class=\"layout-shifter\"{$attrs}>{$buttons_html}</div>";
}

// Scroll Progress Indicator
function scroll_progress_indicator($attributes = []) {
    return "<div id=\"scroll-progress\" class=\"fixed top-0 left-0 h-1 bg-blue-500\" style=\"width: 0%;\"></div>";
}

/**
 * Complex Data Representations
 */

// Parallel Coordinates Plot
function parallel_coordinates_plot($id, $data, $options = [], $attributes = []) {
    return "<div id=\"{$id}\" data-data='" . json_encode($data) . "' data-options='" . json_encode($options) . "' class=\"w-full h-64\"{$attributes}></div>";
}

// Network Relationship Diagram
function network_relationship_diagram($id, $data, $options = [], $attributes = []) {
    return network_graph($id, $data, $options, $attributes);
}

?>
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











    Database Tables:
$table_queries = [
        "{$table_prefix}users" => "CREATE TABLE IF NOT EXISTS {$table_prefix}users (
            ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            user_login varchar(60) NOT NULL DEFAULT '',
            user_pass varchar(255) NOT NULL DEFAULT '',
            user_nicename varchar(50) NOT NULL DEFAULT '',
            user_email varchar(100) NOT NULL DEFAULT '',
            user_url varchar(100) NOT NULL DEFAULT '',
            user_registered datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            user_activation_key varchar(255) NOT NULL DEFAULT '',
            user_status int(11) NOT NULL DEFAULT '0',
            display_name varchar(250) NOT NULL DEFAULT '',
            PRIMARY KEY (ID),
            UNIQUE KEY user_login_key (user_login),
            UNIQUE KEY user_nicename (user_nicename),
            UNIQUE KEY user_email (user_email)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "{$table_prefix}terms" => "CREATE TABLE IF NOT EXISTS {$table_prefix}terms (
            term_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            name varchar(200) NOT NULL DEFAULT '',
            slug varchar(200) NOT NULL DEFAULT '',
            PRIMARY KEY (term_id),
            UNIQUE KEY slug (slug)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "{$table_prefix}term_taxonomy" => "CREATE TABLE IF NOT EXISTS {$table_prefix}term_taxonomy (
            term_taxonomy_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            term_id bigint(20) unsigned NOT NULL DEFAULT 0,
            taxonomy varchar(32) NOT NULL DEFAULT '',
            description longtext NOT NULL,
            count bigint(20) NOT NULL DEFAULT 0,
            PRIMARY KEY (term_taxonomy_id),
            UNIQUE KEY term_id_taxonomy (term_id, taxonomy),
            FOREIGN KEY (term_id) REFERENCES {$table_prefix}terms(term_id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "{$table_prefix}termmeta" => "CREATE TABLE IF NOT EXISTS {$table_prefix}termmeta (
            meta_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            term_id bigint(20) unsigned NOT NULL DEFAULT '0',
            meta_key varchar(255) DEFAULT NULL,
            meta_value longtext,
            PRIMARY KEY (meta_id),
            KEY term_id (term_id),
            FOREIGN KEY (term_id) REFERENCES {$table_prefix}terms(term_id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "{$table_prefix}options" => "CREATE TABLE IF NOT EXISTS {$table_prefix}options (
            option_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            option_name varchar(191) NOT NULL DEFAULT '',
            option_value longtext NOT NULL,
            autoload varchar(20) NOT NULL DEFAULT 'yes',
            PRIMARY KEY (option_id),
            UNIQUE KEY option_name (option_name)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "{$table_prefix}posts" => "CREATE TABLE IF NOT EXISTS {$table_prefix}posts (
            ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            post_author bigint(20) unsigned NOT NULL DEFAULT '0',
            post_date_gmt datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            post_content longtext NOT NULL,
            post_title text NOT NULL,
            post_excerpt text NOT NULL,
            post_status varchar(20) NOT NULL DEFAULT 'publish',
            post_reputation int(11) NOT NULL DEFAULT '0',
            comment_status varchar(20) NOT NULL DEFAULT 'open',
            post_name varchar(200) NOT NULL DEFAULT '',
            post_modified_gmt datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            slug varchar(255) NOT NULL DEFAULT '',
            comment_count bigint(20) NOT NULL DEFAULT '0',
            PRIMARY KEY (ID),
            FOREIGN KEY (post_author) REFERENCES {$table_prefix}users(ID) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "{$table_prefix}postmeta" => "CREATE TABLE IF NOT EXISTS {$table_prefix}postmeta (
            meta_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            post_id bigint(20) unsigned NOT NULL DEFAULT '0',
            meta_key varchar(255) DEFAULT NULL,
            meta_value longtext,
            PRIMARY KEY (meta_id),
            KEY post_id (post_id),
            FOREIGN KEY (post_id) REFERENCES {$table_prefix}posts(ID) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "{$table_prefix}comments" => "CREATE TABLE IF NOT EXISTS {$table_prefix}comments (
            comment_ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            comment_post_ID bigint(20) unsigned NOT NULL DEFAULT '0',
            comment_author tinytext NOT NULL,
            comment_reputation int(11) NOT NULL DEFAULT '0',
            comment_author_email varchar(100) NOT NULL DEFAULT '',
            comment_author_url varchar(200) NOT NULL DEFAULT '',
            comment_author_IP varchar(100) NOT NULL DEFAULT '',
            comment_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            comment_date_gmt datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            comment_content text NOT NULL,
            comment_agent varchar(255) NOT NULL DEFAULT '',
            comment_type varchar(20) NOT NULL DEFAULT 'comment',
            comment_parent bigint(20) unsigned NOT NULL DEFAULT '0',
            user_id bigint(20) unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (comment_ID),
            FOREIGN KEY (comment_post_ID) REFERENCES {$table_prefix}posts(ID) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES {$table_prefix}users(ID) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "{$table_prefix}commentmeta" => "CREATE TABLE IF NOT EXISTS {$table_prefix}commentmeta (
            meta_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            comment_id bigint(20) unsigned NOT NULL DEFAULT '0',
            meta_key varchar(255) DEFAULT NULL,
            meta_value longtext,
            PRIMARY KEY (meta_id),
            KEY comment_id (comment_id),
            FOREIGN KEY (comment_id) REFERENCES {$table_prefix}comments(comment_ID) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "{$table_prefix}usermeta" => "CREATE TABLE IF NOT EXISTS {$table_prefix}usermeta (
            umeta_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            user_id bigint(20) unsigned NOT NULL DEFAULT '0',
            meta_key varchar(255) DEFAULT NULL,
            meta_value longtext,
            PRIMARY KEY (umeta_id),
            KEY user_id (user_id),
            FOREIGN KEY (user_id) REFERENCES {$table_prefix}users(ID) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    ];
DB connection is done by

<?php

if (!defined('ABSPATH')) {
    die('Direct access not allowed.');
}

class DBConnection {
    private $connection;
    private $prefix;

    public function __construct() {

        // Establish the connection.
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->connection->connect_error) {
            throw new Exception('Database connection failed: ' . $this->connection->connect_error);
        }

        // Set the table prefix.
        $this->prefix = defined('DB_PREFIX') ? DB_PREFIX : '';
    }

    public function get_connection() {
        return $this->connection;
    }

    public function prefix() {
        return $this->prefix;
    }

    public function execute_query($query, $params = [], $types = '') {
        $stmt = $this->connection->prepare($query);

        if ($stmt === false) {
            throw new Exception('Query preparation failed: ' . $this->connection->error);
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();

        if ($stmt->errno) {
            throw new Exception('Query execution failed: ' . $stmt->error);
        }

        $result = $stmt->get_result();
        $stmt->close();

        return $result;
    }

    public function close() {
        $this->connection->close();
    }
}

// Instantiate the database connection and store it globally.
global $db;
$db = new DBConnection();




Write posts.php that contains all below function fully working, production level, no need to include file, if will be include self:

Retrieving Posts:
- get_posts(array $args = null|(numberposts-default 10, -1 for all, category-Category ID or comma-separated list of IDs (this or any children) default 0,include-An array of post IDs to retrieve, default empty array, exclude-An array of post IDs not to retrieve, default empty array, suppress_filters-Whether to suppress filters. Default true.)) - Retrieves an array of posts based on specified parameters, return posts array.
- get_post(post_id) - Retrieves a specific post by ID
- get_post_field($field,post_id) - Retrieves a specific field from a post
- get_post_id_from_slug(slug) - Retrive id from slug.

Post Creation and Modification:
- insert_post(array $postarr) - Creates a new post, post title and content are required, slug name will be created from title, and if slug already present then it will append -{number increment start from 1.} and reputation will be 0 always, user can't add in array.
- update_post(array $postarr) - Updates an existing post, everything is optional.
- delete_post(posr_id or slug) - Deletes a post
- trash_post(posr_id or slug) - Moves a post to trash
- untrash_post(posr_id or slug) - Restores a post from trash


Post Meta Functions:
- add_post_meta(int $post_id, string $meta_key, mixed $meta_value, bool $unique = false) - Adds new post metadata
- get_post_meta(post_id, key, single) - Retrieves post metadata
- update_post_meta(post_id, key, value, prev_value - If specified, only update existing metadata entries with this value. Otherwise, update all entries) - Updates post metadata
- delete_post_meta(post_id, key, value - string or array,delete row with this values only. otherwise all) - Deletes post metadata


Post Status and Type:
- get_post_status(id or slug) - Retrieves the post status
- is_post_type_archive(id or slug) - Checks if viewing a specific post type archive


Post Taxonomy Functions:
- get_the_terms() - Retrieves terms for a post
- get_the_term_list() - Gets a list of terms for a post
- set_post_terms() - Sets terms for a post
- remove_object_terms() - Removes terms from a post


Post Permalink and URL:
- get_permalink($post_id, string $taxonomy) - Retrieves the post's permalink
- get_post_permalink(post_id) - Gets a specific post's permalink (slug)

Post Author Functions:
- get_the_author_meta(author_id) - Retrieves author metadata.
- get_the_author_posts_link(author_id) - Gets link to author's posts.
