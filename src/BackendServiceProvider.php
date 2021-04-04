<?php

namespace Tadcms\Backend;

use Tadcms\Backend\Providers\MenuServiceProvider;
use Tadcms\Backend\Providers\BladeServiceProvider;
use Tadcms\Backend\Macros\RouterMacros;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Tadcms\Backend\Providers\MailConfigServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootViews();
        $this->bootTranslations();
    }
    
    public function register()
    {
        $this->registerRouteMacros();
        $this->app->register(BladeServiceProvider::class);
        $this->app->register(MenuServiceProvider::class);
        $this->app->register(MailConfigServiceProvider::class);
    }
    
    protected function registerRouteMacros()
    {
        Router::mixin(new RouterMacros());
    }
    
    protected function bootViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'tadcms');
    }
    
    protected function bootTranslations() {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'tadcms');
    }
}