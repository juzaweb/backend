<?php

use Tadcms\Backend\Facades\HookAction;

HookAction::registerPostType('posts', [
    'label' => trans('tadcms::app.posts'),
    'menu_icon' => 'fa fa-edit',
    'menu_position' => 15,
    'supports' => ['category', 'tag'],
]);

HookAction::registerTaxonomy('categories', 'pages', [
    'label' => trans('tadcms::app.categories'),
    'menu_position' => 4,
]);
