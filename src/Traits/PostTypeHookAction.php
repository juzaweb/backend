<?php
/**
 * @package    tadcms\tadcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/tadcms/tadcms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/3/2021
 * Time: 11:05 AM
 */

namespace Tadcms\Backend\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;

trait PostTypeHookAction
{
    /**
     * TAD CMS: Creates or modifies a taxonomy object.
     * @param string $taxonomy (Required) Taxonomy key, must not exceed 32 characters.
     * @param string $objectType
     * @param array $args (Optional) Array of arguments for registering a post type.
     * @return void
     *
     * @throws \Exception
     */
    public function registerTaxonomy($taxonomy, $objectType, $args = [])
    {
        $type = Str::singular($objectType);
        $opts = [
            'label' => '',
            'description' => '',
            'repository' => 'Tadcms\\System\\Repositories\\TaxonomyRepository',
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
                    'singular' => $args->get('singular'),
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

        $this->registerPermalink($taxonomy, [
            'label' => $args->get('label'),
            'base' => $args->get('singular'),
            'callback' => 'Tadcms\\Frontend\\Controllers\\TaxonomyController'
        ]);
    }

    /**
     * TAD CMS: Registers a post type.
     * @param string $key (Required) Post type key. Must not exceed 20 characters
     * @param array $args Array of arguments for registering a post type.
     *
     * @throws \Exception
     */
    public function registerPostType($key, $args = [])
    {
        $args = array_merge([
            'label' => '',
            'description' => '',
            'repository' => 'Tadcms\\System\\Repositories\\PostRepository',
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
            trans('tadcms::app.all') . ' '. $args->get('label'),
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

        $this->registerPermalink($key, [
            'label' => $args->get('label'),
            'base' => $args->get('singular'),
            'callback' => 'Tadcms\Frontend\Controllers\PostController'
        ]);
    }
}
