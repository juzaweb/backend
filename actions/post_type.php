<?php

use Tadcms\System\Facades\HookAction;

HookAction::registerPostType('posts', [
    'label' => trans('tadcms::app.posts'),
    'menu_icon' => 'fa fa-edit',
    'menu_position' => 15,
    'supports' => ['category', 'tag'],
]);

HookAction::registerPostType('pages', [
    'label' => trans('tadcms::app.pages'),
    'repository' => 'Tadcms\\System\\Repositories\\PageRepository',
    'menu_icon' => 'fa fa-edit',
    'menu_position' => 15,
    'supports' => ['tag'],
]);
