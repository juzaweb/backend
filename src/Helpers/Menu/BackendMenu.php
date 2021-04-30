<?php

namespace Tadcms\Backend\Helpers\Menu;

use Tadcms\Backend\Facades\HookAction;
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
    
    public static function tadPostTypeMenu()
    {
        HookAction::addAdminMenu(
            'tadcms::app.posts',
            'posts',
            [
                'icon' => 'fa fa-edit',
                'position' => 15
            ]
        );

        HookAction::addAdminMenu(
            'tadcms::app.all-posts',
            'posts',
            [
                'position' => 2,
                'parent' => 'posts',
            ]
        );

        HookAction::addAdminMenu(
            'tadcms::app.add-new',
            'posts.create',
            [
                'position' => 3,
                'parent' => 'posts',
            ]
        );

        HookAction::addAdminMenu(
            'tadcms::app.categories',
            'categories',
            [
                'icon' => 'fa fa-list-alt',
                'parent' => 'posts',
                'position' => 4
            ]
        );

        HookAction::addAdminMenu(
            'tadcms::app.tags',
            'tags',
            [
                'icon' => 'fa fa-list-alt',
                'parent' => 'posts',
                'position' => 5
            ]
        );
    }

    public static function tadPageMenu()
    {
        HookAction::addAdminMenu(
            'tadcms::app.pages',
            'pages',
            [
                'icon' => 'fa fa-edit',
                'position' => 15
            ]
        );

        HookAction::addAdminMenu(
            'tadcms::app.all-pages',
            'pages',
            [
                'position' => 2,
                'parent' => 'pages',
            ]
        );

        HookAction::addAdminMenu(
            'tadcms::app.add-new',
            'pages.create',
            [
                'position' => 3,
                'parent' => 'pages',
            ]
        );

        HookAction::addAdminMenu(
            'tadcms::app.tags',
            'page-tags',
            [
                'icon' => 'fa fa-list-alt',
                'parent' => 'pages',
                'position' => 5
            ]
        );
    }
}
