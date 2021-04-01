<?php

namespace Tadcms\Backend;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Tadcms\Backend\Macros\RouterMacros;

class BackendServiceProvider extends ServiceProvider
{
    public function boot()
    {
    
    }
    
    public function register()
    {
        $this->registerRouteMacros();
    }
    
    protected function registerRouteMacros()
    {
        Router::mixin(new RouterMacros());
    }
}