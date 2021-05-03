<?php

use Tadcms\System\Facades\HookAction;

HookAction::addAdminMenu(
    trans('tadcms::app.dashboard'),
    'dashboard',
    [
        'icon' => 'fa fa-dashboard',
        'position' => 1
    ]
);

/*HookAction::addAdminMenu(
    'tadcms::app.dashboard',
    'dashboard',
    [
        'icon' => 'fa fa-dashboard',
        'position' => 1,
        'parent' => 'dashboard',
    ]
);*/

/*HookAction::addAdminMenu(
    'tadcms::app.updates',
    'dashboard.update',
    [
        'icon' => 'fa fa-upgrade',
        'position' => 2,
        'parent' => 'dashboard',
    ]
);*/

HookAction::addAdminMenu(
    trans('tadcms::app.comments'),
    'comments',
    [
        'icon' => 'fa fa-comments',
        'position' => 30
    ]
);

HookAction::addAdminMenu(
    trans('tadcms::app.media'),
    'media',
    [
        'icon' => 'fa fa-photo',
        'position' => 5
    ]
);

HookAction::addAdminMenu(
    trans('tadcms::app.users'),
    'users',
    [
        'icon' => 'fa fa-users',
        'position' => 60
    ]
);

/*add_menu_page(
    'tadcms::app.translations',
    'translations',
    'fa fa-language',
    null,
    100
);*/

/*add_menu_page(
    'tadcms::app.permissions',
    'translations',
    'fa fa-language',
    null,
    100
);*/

HookAction::addAdminMenu(
    trans('tadcms::app.notification'),
    'notification',
    [
        'icon' => 'fa fa-bell',
        'position' => 100
    ]
);


