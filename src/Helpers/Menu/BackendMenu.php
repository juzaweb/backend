<?php

namespace Tadcms\Backend\Helpers\Menu;

use Tadcms\Backend\Facades\HookAction;

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
        return view('tadcms::items.admin_menu', [
            'items' => HookAction::getFilter('admin_menu', []),
        ]);
    }
    
    public static function tadMenuLeft() {
        HookAction::addMenuPage(
            'tadcms::app.dashboard',
            '',
            'fa fa-dashboard',
            null,
            1
        );
    
        HookAction::addMenuPage(
            'tadcms::app.comments',
            'comments',
            'fa fa-comments',
            null,
            30
        );
        
        /*add_menu_page(
            'tadcms::app.media',
            'media',
            'fa fa-photo',
            null,
            5
        );*/
    
        HookAction::addMenuPage(
            'tadcms::app.users',
            'users',
            'fa fa-users',
            null,
            60
        );
        
        /*add_menu_page(
            'tadcms::app.languages',
            'languages',
            'fa fa-language',
            null,
            100
        );*/
        
        /*add_menu_page(
            'tadcms::app.notification',
            'notification',
            'fa fa-bell',
            null,
            100
        );*/
        
    }
    
    public static function tadAppearanceMenu() {
        HookAction::addMenuPage(
            'tadcms::app.appearance',
            'themes',
            'fa fa-paint-brush',
            null,
            45
        );
    
        HookAction::addMenuPage(
            'tadcms::app.themes',
            'themes',
            'fa fa-cogs',
            'themes',
            45
        );
    
        HookAction::addMenuPage(
            'tadcms::app.menus',
            'menus',
            'fa fa-cogs',
            'themes',
            46
        );
    }
    
    public static function tadPluginMenu() {
        HookAction::addMenuPage(
            'tadcms::app.plugins',
            'plugins',
            'fa fa-plug',
            null,
            50
        );
    }
    
    public static function tadSettingMenu() {
        HookAction::addMenuPage(
            'tadcms::app.setting',
            'setting',
            'fa fa-cogs',
            null,
            99
        );
        
        HookAction::addMenuPage(
            'tadcms::app.general-setting',
            'setting',
            'fa fa-cogs',
            'setting',
            99
        );
        
        HookAction::addMenuPage(
            'tadcms::app.email-setting',
            'setting-email',
            'fa fa-cogs',
            'setting',
            99
        );
        
        HookAction::addMenuPage(
            'tadcms::app.email-template',
            'email-template',
            'fa fa-cogs',
            'setting',
            99
        );
    }
    
    public static function tadPostTypeMenu()
    {
        $items = HookAction::getFilter('post_types', []);
        foreach ($items as $item) {
            $menu_slug = 'post-type.' . $item['post_type'];
            HookAction::addMenuPage(
                $item['label'],
                $menu_slug,
                $item['menu_icon'],
                null,
                $item['menu_position']
            );
    
            HookAction::addMenuPage(
                $item['label'],
                $menu_slug,
                $item['menu_icon'],
                $menu_slug,
                $item['menu_position']
            );
    
            HookAction::addMenuPage(
                'tadcms::app.add-new',
                $menu_slug . '.create',
                $item['menu_icon'],
                $menu_slug,
                $item['menu_position']
            );
        }
        
    }
    
    public static function tadTaxonomyMenu()
    {
        $items = HookAction::getFilter('taxonomies', []);
        foreach ($items as $item) {
            $taxonomy = 'taxonomy.' . $item['taxonomy'];
            HookAction::addMenuPage(
                $item['label'],
                $taxonomy,
                $item['menu_icon'],
                $item['parent'],
                $item['menu_position']
            );
        }
    }
}