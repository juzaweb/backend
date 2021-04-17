<?php

namespace Tadcms\Backend\Helpers\Menu;

use Tadcms\Backend\Facades\HookAction;
use Tadcms\Backend\Helpers\MenuCollection;
use Theanh\LaravelHooks\Facades\Events;

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
        $items = MenuCollection::make(Events::filter('admin_menu', []));
        return view('tadcms::items.admin_menu', [
            'items' => $items,
        ]);
    }
    
    public static function tadMenuLeft() {
        HookAction::addMenuPage(
            'tadcms::app.dashboard',
            'dashboard',
            [
                'icon' => 'fa fa-dashboard',
                'position' => 1
            ]
        );
    
        /*HookAction::addMenuPage(
            'tadcms::app.dashboard',
            'dashboard',
            [
                'icon' => 'fa fa-dashboard',
                'position' => 1,
                'parent' => 'dashboard',
            ]
        );*/
    
        /*HookAction::addMenuPage(
            'tadcms::app.updates',
            'dashboard.update',
            [
                'icon' => 'fa fa-upgrade',
                'position' => 2,
                'parent' => 'dashboard',
            ]
        );*/
    
        HookAction::addMenuPage(
            'tadcms::app.comments',
            'comments',
            [
                'icon' => 'fa fa-comments',
                'position' => 30
            ]
        );
    
        HookAction::addMenuPage(
            'tadcms::app.media',
            'media',
            [
                'icon' => 'fa fa-photo',
                'position' => 5
            ]
        );
    
        HookAction::addMenuPage(
            'tadcms::app.users',
            'users',
            [
                'icon' => 'fa fa-users',
                'position' => 60
            ]
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
            [
                'icon' => 'fa fa-paint-brush',
                'position' => 45
            ]
        );
    
        HookAction::addMenuPage(
            'tadcms::app.themes',
            'themes',
            [
                'icon' => 'fa fa-cogs',
                'parent' => 'themes',
                'position' => 45
            ]
        );
    
        HookAction::addMenuPage(
            'tadcms::app.menus',
            'menus',
            [
                'icon' => 'fa fa-cogs',
                'parent' => 'themes',
                'position' => 46
            ]
        );
    
        HookAction::addMenuPage(
            'tadcms::app.menus',
            'menus',
            [
                'icon' => 'fa fa-cogs',
                'parent' => 'themes',
                'position' => 46
            ]
        );
    }
    
    public static function tadPluginMenu() {
        HookAction::addMenuPage(
            'tadcms::app.plugins',
            'plugins',
            [
                'icon' => 'fa fa-plug',
                'position' => 50
            ]
        );
    }
    
    public static function tadSettingMenu() {
        HookAction::addMenuPage(
            'tadcms::app.setting',
            'setting',
            [
                'icon' => 'fa fa-cogs',
                'position' => 99
            ]
        );
        
        HookAction::addMenuPage(
            'tadcms::app.general-setting',
            'setting',
            [
                'icon' => 'fa fa-cogs',
                'parent' => 'setting',
                'position' => 1
            ]
        );
        
        HookAction::addMenuPage(
            'tadcms::app.email-setting',
            'setting-email',
            [
                'icon' => 'fa fa-cogs',
                'parent' => 'setting',
                'position' => 2
            ]
        );
        
        HookAction::addMenuPage(
            'tadcms::app.email-template',
            'email-template',
            [
                'icon' => 'fa fa-cogs',
                'parent' => 'setting',
                'position' => 3
            ]
        );
    }
    
    public static function tadPostTypeMenu()
    {
        $items = Events::filter('post_types', []);
        foreach ($items as $item) {
            $menuSlug = 'post-type.' . $item['post_type'];
            HookAction::addMenuPage(
                $item['label'],
                $menuSlug,
                [
                    'icon' => $item['menu_icon'],
                    'position' => $item['menu_position']
                ]
            );
    
            HookAction::addMenuPage(
                $item['label'],
                $menuSlug,
                [
                    'icon' => $item['menu_icon'],
                    'position' => 2,
                    'parent' => $menuSlug,
                ]
            );
    
            HookAction::addMenuPage(
                'tadcms::app.add-new',
                $menuSlug . '.create',
                [
                    'icon' => $item['menu_icon'],
                    'position' => 3,
                    'parent' => $menuSlug,
                ]
            );
        }
        
    }
    
    public static function tadTaxonomyMenu()
    {
        $items = Events::filter('taxonomies', []);
        foreach ($items as $item) {
            $taxonomy = 'taxonomy.' . $item['taxonomy'];
            HookAction::addMenuPage(
                $item['label'],
                $taxonomy,
                [
                    'icon' => $item['menu_icon'],
                    'parent' => $item['parent'],
                    'url' => 'taxonomy/' . $item['taxonomy'],
                    'position' => $item['menu_position']
                ]
            );
        }
    }
}