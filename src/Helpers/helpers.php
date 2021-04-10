<?php

use Tadcms\Backend\Helpers\Menu\Breadcrumb;

function breadcrumb($name, $add_items = []) {
    $items = apply_filters($name . '_breadcrumb', []);
    
    if ($add_items) {
        foreach ($add_items as $add_item) {
            $items[] = $add_item;
        }
    }
    
    return Breadcrumb::render($name, $items);
}

function admin_header() {
    do_action('admin_header');
}

function admin_footer() {
    do_action('admin_footer');
}

/**
 * TAD CMS: Registers the script to admin panel
 * @param string $handle (Required) Name of the script. Should be unique.
 * @param string $src (Required) Full URL of the script, or path of the script relative to site
 * @param string|bool|null $ver String specifying script version number, if it has one, which is added to the URL as a query string for cache busting purposes.
 * @param bool $in_footer (Optional) Whether to enqueue the script before </body> instead of in the <head>
 * @return bool
 *
 */
function add_admin_script($handle, $src, $ver = '1.0', $in_footer = false) {
    /**
     * If is't url
     * */
    if (!is_url($src)) {
        // Check is script in module
        if (strpos('/Modules/', $src)) {
            $src = '';
        }
        // Check is script in theme
        else if (strpos('/Themes/')) {
            $src = theme_asset($src);
        }
        // Can't find script
        else {
            return false;
        }
    }
    
    if ($in_footer) {
        
        add_action('admin_header');
        
        return add_filters('admin_footer_script', [
            'src' => $src
        ]);
    }
    
    return add_filters('admin_header_script', [
        'src' => $src
    ]);
}

function register_notification($key, $name, $class) {
    return add_filters('notify_methods', function ($items) use ($key, $name, $class) {
        $items[$key] = [
            'name' => $name,
            'class' => $class
        ];
        
        return $items;
    });
}

/**
 * TAD CMS: Add general setting page
 * @param string $html_input // Html input/textarea/select tags input setting
 **/
function add_general_setting($html_input) {
    add_action('setting.form_general', function () use ($html_input) {
        echo $html_input;
    });
}
