<?php

namespace Tadcms\Backend\Providers;

use Illuminate\Support\ServiceProvider;
use Tadcms\System\Facades\HookAction;

class HookActionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        HookAction::loadActionForm(__DIR__ . '/../../actions');
    }
}
