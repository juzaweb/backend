<?php

namespace Tadcms\Backend\Providers;

use Illuminate\Support\ServiceProvider;
use Tadcms\Backend\Facades\HookAction;

class MenuServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (config('tadcms.use_post')) {

        }
    
        if (config('tadcms.use_page')) {

        }
    }
}