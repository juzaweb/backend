<?php

use Tadcms\System\Facades\HookAction;

HookAction::addAdminMenu(
    trans('tadcms::app.appearance'),
    'themes',
    [
        'icon' => 'fa fa-paint-brush',
        'position' => 45
    ]
);

HookAction::addAdminMenu(
    trans('tadcms::app.themes'),
    'themes',
    [
        'icon' => 'fa fa-cogs',
        'parent' => 'themes',
        'position' => 45
    ]
);

HookAction::addAdminMenu(
    trans('tadcms::app.menus'),
    'menus',
    [
        'icon' => 'fa fa-cogs',
        'parent' => 'themes',
        'position' => 46
    ]
);

HookAction::addAdminMenu(
    trans('tadcms::app.menus'),
    'menus',
    [
        'icon' => 'fa fa-cogs',
        'parent' => 'themes',
        'position' => 46
    ]
);
