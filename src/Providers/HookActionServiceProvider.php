<?php

namespace Tadcms\Backend\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class HookActionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            $files = File::allFiles(__DIR__ . '/../../actions');
            foreach ($files as $file) {
                require_once($file->getRealPath());
            }
        });
    }
}
