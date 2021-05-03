<?php

use Tadcms\System\Facades\HookAction;

HookAction::addAdminMenu(
    trans('tadcms::app.setting'),
    'setting',
    [
        'icon' => 'fa fa-cogs',
        'position' => 99
    ]
);

HookAction::addAdminMenu(
    trans('tadcms::app.general-setting'),
    'setting',
    [
        'icon' => 'fa fa-cogs',
        'parent' => 'setting',
        'position' => 1
    ]
);

HookAction::addAdminMenu(
    trans('tadcms::app.email-template'),
    'email-template',
    [
        'icon' => 'fa fa-cogs',
        'parent' => 'setting',
        'position' => 3
    ]
);
