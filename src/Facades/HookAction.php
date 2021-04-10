<?php

namespace Tadcms\Backend\Facades;

use Illuminate\Support\Facades\Facade;

class HookAction extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tadhook';
    }
}