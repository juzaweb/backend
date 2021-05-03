<?php

use Tadcms\System\Facades\HookAction;

HookAction::addAdminMenu(
    trans('tadcms::app.plugins'),
    'plugins',
    [
        'icon' => 'fa fa-plug',
        'position' => 50
    ]
);
