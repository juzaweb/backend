<?php

use Tadcms\Backend\Facades\HookAction;

HookAction::addAdminMenu(
    trans('tadcms::app.plugins'),
    'plugins',
    [
        'icon' => 'fa fa-plug',
        'position' => 50
    ]
);
