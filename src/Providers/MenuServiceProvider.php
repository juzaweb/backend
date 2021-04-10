<?php

namespace Tadcms\Backend\Providers;

use Illuminate\Support\ServiceProvider;
use Tadcms\Backend\Facades\HookAction;

class MenuServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (config('tadcms.use_post')) {
            HookAction::registerPostType('posts', [
                'label' => 'tadcms::app.posts',
                'menu_icon' => 'fa fa-edit',
                'menu_position' => 15,
                'supports' => ['category', 'tag']
            ]);
        }
    
        if (config('tadcms.use_page')) {
            HookAction::registerPostType('pages', [
                'label' => 'tadcms::app.pages',
                'menu_icon' => 'fa fa-paste',
                'menu_position' => 20,
                'supports' => ['tag']
            ]);
        }
    }
}