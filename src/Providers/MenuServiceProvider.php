<?php

namespace Tadcms\Backend\Providers;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->addMenuLeft();
    }
    
    protected function addMenuLeft() {
        
        add_menu_page(
            'tadcms::app.dashboard',
            '',
            'fa fa-dashboard',
            null,
            1
        );
        
        /*if (config('tadcms.use_post')) {
            register_post_type('posts', [
                'label' => 'tadcms::app.posts',
                'menu_icon' => 'fa fa-edit',
                'menu_position' => 15,
                'supports' => ['category', 'tag']
            ]);
        }
        
        if (config('tadcms.use_page')) {
            register_post_type('pages', [
                'label' => 'tadcms::app.pages',
                'menu_icon' => 'fa fa-paste',
                'menu_position' => 20,
                'supports' => ['tag']
            ]);
        }*/
        
        /*add_menu_page(
            'tadcms::app.comments',
            'comments',
            'fa fa-comments',
            null,
            30
        );*/
        
        /*add_menu_page(
            'tadcms::app.media',
            'media',
            'fa fa-photo',
            null,
            5
        );*/
        
        add_menu_page(
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
        
        $this->addAppearanceMenu();
        
        $this->addPluginMenu();
        
        $this->addSettingMenu();
    }
    
    protected function addAppearanceMenu() {
        add_menu_page(
            'tadcms::app.appearance',
            'themes',
            'fa fa-paint-brush',
            null,
            45
        );
        
        add_menu_page(
            'tadcms::app.themes',
            'themes',
            'fa fa-cogs',
            'themes',
            45
        );
        
        /*add_menu_page(
            'tadcms::app.menus',
            'menus',
            'fa fa-cogs',
            'themes',
            46
        );*/
    }
    
    protected function addPluginMenu() {
        add_menu_page(
            'tadcms::app.plugins',
            'plugins',
            'fa fa-plug',
            null,
            50
        );
    }
    
    protected function addSettingMenu() {
        add_menu_page(
            'tadcms::app.setting',
            'setting',
            'fa fa-cogs',
            null,
            99
        );
        
        add_menu_page(
            'tadcms::app.general-setting',
            'setting',
            'fa fa-cogs',
            'setting',
            99
        );
    
        add_menu_page(
            'tadcms::app.email-setting',
            'setting-email',
            'fa fa-cogs',
            'setting',
            99
        );
    }
}