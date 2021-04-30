<?php

namespace Tadcms\Backend\Helpers\Menu;

use Tadcms\Backend\Helpers\MenuCollection;

/**
 * Class BackendMenu
 *
 * @package    Tadcms\Tadcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/tadcms/tadcms
 * @license    MIT
 */
class BackendMenu
{
    public static function render()
    {
        $items = MenuCollection::make(apply_filters('admin_menu', []));
        return view('tadcms::items.admin_menu', [
            'items' => $items,
        ]);
    }
}
