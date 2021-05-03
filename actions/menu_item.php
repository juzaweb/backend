<?php

use Tadcms\System\Facades\HookAction;

HookAction::registerMenuItem('tadcms.custom_links', [
    'label' => trans('tadcms::app.custom-links'),
    'component' => 'Tadcms\Backend\MenuItems\CustomLinkMenuItem',
    'position' => 99
]);
