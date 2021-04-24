<?php

namespace Tadcms\Backend\Helpers;

use Illuminate\Support\Arr;

/**
 * Class HookAction
 *
 * @package    Theanh\Tadcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/theanhk/tadcms
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
    public function addMenuPage($menuTitle, $menuSlug, $args = [])
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
}
