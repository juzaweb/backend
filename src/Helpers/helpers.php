<?php

function breadcrumb($name, $add_items = []) {
    $items = apply_filters($name . '_breadcrumb', []);
    
    if ($add_items) {
        foreach ($add_items as $add_item) {
            $items[] = $add_item;
        }
    }
    
    return \Tadcms\Backend\Helpers\Menu\Breadcrumb::render($name, $items);
}

function admin_header() {
    do_action('admin_header');
}

function admin_footer() {
    do_action('admin_footer');
}

/**
 * TAD CMS: Add a top-level menu page.
 *
 * This function takes a capability which will be used to determine whether
 * or not a page is included in the menu.
 *
 * The function which is hooked in to handle the output of the page must check
 * that the user has the required capability as well.
 *
 * @param string $menu_title The trans key to be used for the menu.
 * @param string $menu_slug The url name to refer to this menu by. not include admin-cp
 * @param string $icon Url icon or fa icon fonts
 * @param string $parent The parent of menu. Default null
 * @param int $position The position in the menu order this item should appear.
 * @return bool.
 */
function add_menu_page($menu_title, $menu_slug, $icon = '', $parent = null, $position = 20) {
    $newmenu = [
        'title' => $menu_title,
        'key' => $menu_slug,
        'icon' => $icon,
        'url' => $menu_slug,
        'parent' => $parent,
        'position' => $position,
    ];
    
    return add_filters('admin_menu', function ($menu) use ($newmenu) {
        if ($newmenu['parent']) {
            $menu[$newmenu['parent']]['children'][$newmenu['key']] = $newmenu;
        }
        else {
            if (isset($menu[$newmenu['key']])) {
                
                if (isset($menu[$newmenu['key']]['children'])) {
                    $newmenu['children'] = $menu[$newmenu['key']]['children'];
                }
                
                $menu[$newmenu['key']] = $newmenu;
            }
            else {
                $menu[$newmenu['key']] = $newmenu;
            }
        }
        
        return $menu;
    }, $position);
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

/**
 * TAD CMS: Creates or modifies a taxonomy object.
 * @param string $taxonomy (Required) Taxonomy key, must not exceed 32 characters.
 * @param string $object_type (Required) Taxonomy key, must not exceed 32 characters.
 * @param array $args (Optional) Array of arguments for registering a post type.
 * @return void
 * */
function register_taxonomy($taxonomy, $object_type, $args = []) {
    $default = [
        'label' => '',
        'description' => '',
        'menu_position' => 20,
        'menu_icon' => 'fa fa-list-alt',
        'supports' => [],
    ];
    
    $args = array_merge($default, $args);
    
    if ($object_type) {
        // Register taxonomy has post type
        $taxonomy = 'taxonomy.' . $object_type . '.' . $taxonomy;
        
        /*$parent = in_array($object_type, ['posts', 'pages']) ? $object_type
            : 'post-type.' . $object_type;*/
        $parent = 'post-type.' . $object_type;
        
        add_menu_page(
            $args['label'],
            $taxonomy,
            $args['menu_icon'],
            $parent,
            $args['menu_position']
        );
    }
    
    /*else {
    
        $taxonomy = 'taxonomy.' . $taxonomy;
        
        add_menu_page(
            $args['label'],
            $taxonomy,
            $args['menu_icon'],
            null,
            $args['menu_position']
        );
    }*/
}

/**
 * TAD CMS: Registers a post type.
 * @param string $post_type (Required) Post type key. Must not exceed 20 characters
 * @param array $args (Optional) Array of arguments for registering a post type.
 * @return void
 * */
function register_post_type($post_type, $args = []) {
    
    $default = [
        'label' => '',
        'description' => '',
        'show_in_menu' => true,
        'menu_position' => 20,
        'menu_icon' => 'fa fa-list-alt',
        'supports' => [],
    ];
    
    $args = array_merge($default, $args);
    
    $menu_slug = 'post-type.' . $post_type;
    /*if (!in_array($post_type, ['posts', 'pages'])) {
        $menu_slug = 'post-type.' . $post_type;
    }*/
    
    add_menu_page(
        $args['label'],
        $menu_slug,
        $args['menu_icon'],
        null,
        $args['menu_position']
    );
    
    add_menu_page(
        $args['label'],
        $menu_slug,
        $args['menu_icon'],
        $menu_slug,
        $args['menu_position']
    );
    
    add_menu_page(
        'tadcms::app.add-new',
        $menu_slug . '.create',
        $args['menu_icon'],
        $menu_slug,
        $args['menu_position']
    );
    
    if (in_array('category', $args['supports'])) {
        register_taxonomy('categories', $post_type, [
            'label' => 'tadcms::app.categories',
            'menu_position' => $args['menu_position'] + 1
        ]);
    }
    
    if (in_array('tag', $args['supports'])) {
        register_taxonomy('tags', $post_type, [
            'label' => 'tadcms::app.tags',
            'menu_position' => $args['menu_position'] + 1
        ]);
    }
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

function register_setting_page($setting, $args = []) {
    return add_filters('setting_pages', function ($items) use ($setting, $args) {
        $items[$setting] = [
            'label' => $args['label'],
        ];
    });
}

/**
 * TAD CMS: Add general setting page
 * @param string $html_input // Html input/textarea/select tags input setting
 * */
function add_general_setting($html_input) {
    add_action('setting.form_general', function () use ($html_input) {
        echo $html_input;
    });
}

/**
 * TAD CMS: Add setting page
 * @param string $tag
 * @param string $view // View form setting
 * */
function add_setting_page($tag, $view) {
    add_filters('setting_menu', function ($menu) use ($tag, $view) {
        $menu[$tag] = $view;
        return $menu;
    });
}
