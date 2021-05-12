<?php

namespace Tadcms\Backend;

use Tadcms\Backend\Providers\HookActionServiceProvider;
use Tadcms\Backend\Providers\LivewireServiceProvider;
use Tadcms\Backend\Providers\BladeServiceProvider;
use Tadcms\Backend\Macros\RouterMacros;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Tadcms\Backend\Providers\DbConfigServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootPublishes();
        $this->bootViews();
        $this->bootMiddlewares();
        $this->bootTranslations();
    }
    
    public function register()
    {
        $this->registerRouteMacros();
        $this->app->register(HookActionServiceProvider::class);
        $this->app->register(BladeServiceProvider::class);
        $this->app->register(DbConfigServiceProvider::class);
        $this->app->register(LivewireServiceProvider::class);
    }
    
    protected function registerRouteMacros()
    {
        Router::mixin(new RouterMacros());
    }
    
    protected function bootViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'tadcms');
    }
    
    protected function bootTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'tadcms');
    }
    
    protected function bootMiddlewares()
    {
        $this->app['router']->aliasMiddleware('admin', \Tadcms\Backend\Middleware\Admin::class);
    }

    protected function bootPublishes()
    {
        $this->publishes([
            __DIR__.'/../assets' => public_path('tadcms/assets'),
        ], 'tadcms_assets');

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/tadcms'),
        ], 'tadcms_lang');
    }
}
