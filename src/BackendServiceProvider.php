<?php

namespace Tadcms\Backend;

use Tadcms\Backend\Macros\RouterMacros;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

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