<?php

namespace Tadcms\Backend\Helpers\Menu;

/**
 * Class Tadcms\Backend\Helpers\Menu\BackendMenu
 *
 * @package    Theanh\Tadcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/theanhk/tadcms
 * @license    MIT
 */
class BackendMenu
{
    public static function render() {
        $menu = new BackendMenu();
        
        return view('tadcms::items.admin_menu', [
            'items' => $menu->getAdminMenu(),
        ]);
    }
    
    public function getAdminMenu() {
        return apply_filters('admin_menu', []);
    }
}