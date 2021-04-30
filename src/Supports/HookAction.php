<?php

namespace Tadcms\Backend\Supports;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class HookAction
 *
 * @package    Tadcms\Tadcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/tadcms/tadcms
 * @license    MIT
 */
class HookAction
{
    /**
     * TAD CMS: Add a top-level menu page.
     *
     * This function takes a capability which will be used to determine whether
     * or not a page is included in the menu.
     *
     * The function which is hooked in to handle the output of the page must check
     * that the user has the required capability as well.
     *
     * @param string $menuTitle The trans key to be used for the menu.
     * @param string $menuSlug The url name to refer to this menu by. not include admin-cp
     * @param array $args
     * - string $icon Url icon or fa icon fonts
     * - string $parent The parent of menu. Default null
     * - int $position The position in the menu order this item should appear.
     * @return bool.
     */
    public function addAdminMenu($menuTitle, $menuSlug, $args = [])
    {
        $opts = [
            'title' => $menuTitle,
            'key' => $menuSlug,
            'icon' => 'fa fa-list-alt',
            'url' => str_replace('.', '/', $menuSlug),
            'parent' => null,
            'position' => 20,
        ];
        $item = array_merge($opts, $args);
        
        return add_filters('admin_menu', function ($menu) use ($item) {
            if ($item['parent']) {
                $menu[$item['parent']]['children'][$item['key']] = $item;
            } else {
                if (Arr::has($menu, $item['key'])) {
                    if (Arr::has($menu[$item['key']], 'children')) {
                        $item['children'] = $menu[$item['key']]['children'];
                    }
                    $menu[$item['key']] = $item;
                } else {
                    $menu[$item['key']] = $item;
                }
            }
            
            return $menu;
        });
    }

    /**
     * TAD CMS: Add setting form
     * @param string $key
     * @param array $args
     **/
    public function addSettingForm($key, $args = [])
    {

    }

    public function addGeneralSettingInput($html_input)
    {
        add_action('setting.form_general', function () use ($html_input) {
            echo $html_input;
        });
    }

    /**
     * TAD CMS: Creates or modifies a taxonomy object.
     * @param string $taxonomy (Required) Taxonomy key, must not exceed 32 characters.
     * @param string $objectType
     * @param array $args (Optional) Array of arguments for registering a post type.
     * @return void
     * */
    public function registerTaxonomy($taxonomy, $objectType, $args = [])
    {
        $type = Str::singular($objectType);
        $opts = [
            'label' => '',
            'description' => '',
            'hierarchical' => false,
            'parent' => $objectType,
            'menu_slug' => $type . '.' . $taxonomy,
            'menu_position' => 20,
            'menu_icon' => 'fa fa-list-alt',
            'supports' => [
                'thumbnail',
                'hierarchical'
            ],
        ];

        $args['type'] = $type;
        $args['taxonomy'] = $taxonomy;
        $args['singular'] = Str::singular($taxonomy);
        $args = collect(array_merge($opts, $args));

        add_filters('tadcms.taxonomies', function ($items) use ($taxonomy, $objectType, $args) {
            if (Arr::has($items, $taxonomy)) {
                $items[$taxonomy]['object_types'][$objectType] = $args;
            } else {
                $items[$taxonomy] = [
                    'taxonomy' => $taxonomy,
                    'singular' => Str::singular($taxonomy),
                    'object_types' => [
                        $objectType => $args
                    ]
                ];
            }
            return $items;
        });

        $this->addAdminMenu(
            $args->get('label'),
            $args->get('menu_slug'),
            [
                'icon' => 'fa fa-list-alt',
                'parent' => $args->get('parent'),
                'position' => $args->get('menu_position')
            ]
        );
    }

    /**
     * TAD CMS: Registers a post type.
     * @param string $key (Required) Post type key. Must not exceed 20 characters
     * @param array $args Array of arguments for registering a post type.
     * */
    public function registerPostType($key, $args = [])
    {
        $args = array_merge([
            'label' => '',
            'description' => '',
            'menu_position' => 20,
            'menu_icon' => 'fa fa-list-alt',
            'supports' => [],
        ], $args);

        $args['key'] = $key;
        $args['singular'] = Str::singular($key);
        $args = collect($args);

        add_filters('tadcms.post_types', function ($items) use ($args) {
            $items[$args->get('key')] = $args;
            return $items;
        });

        $this->addAdminMenu(
            $args->get('label'),
            $key,
            [
                'icon' => 'fa fa-edit',
                'position' => 15
            ]
        );

        $this->addAdminMenu(
            trans('tadcms::app.all-posts'),
            $key,
            [
                'position' => 2,
                'parent' => $key,
            ]
        );

        $this->addAdminMenu(
            trans('tadcms::app.add-new'),
            $key . '.create',
            [
                'position' => 3,
                'parent' => $key,
            ]
        );

        $supports = $args->get('supports', []);
        if (in_array('category', $supports)) {
            $this->registerTaxonomy('categories', $key, [
                'label' => trans('tadcms::app.categories'),
                'menu_position' => 4,
            ]);
        }

        if (in_array('tag', $args['supports'])) {
            $this->registerTaxonomy('tags', $key, [
                'label' => trans('tadcms::app.tags'),
                'menu_position' => 5,
                'supports' => []
            ]);
        }
    }

    /**
     * TAD CMS: Registers menu item in menu builder.
     * @param string $key
     * @param array $args
     *      - label (Required): Label for item
     *      - component (Required): Menu item class handle
     * @throws \Exception
     * */
    public function registerMenuItem($key, $args = [])
    {
        if (empty($args['label'])) {
            throw new \Exception('Args label is required');
        }

        if (empty($args['component'])) {
            throw new \Exception('Args component is required');
        }

        add_filters('tadcms.menu_blocks', function ($items) use ($key, $args) {
            array_merge([
                'label' => '',
                'component' => '',
                'position' => 20
            ], $args);
            $args['key'] = $key;

            $items[$key] = collect($args);
            return $items;
        });
    }

}
