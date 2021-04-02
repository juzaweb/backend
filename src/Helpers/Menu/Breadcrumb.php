<?php

namespace Tadcms\Backend\Helpers\Menu;

class Breadcrumb
{
    public static function render($name, $items = []) {
        return view(static::getNameView($name), [
            'items' => $items
        ]);
    }
    
    public static function getNameView($name) {
        return apply_filters('breadcrumb.render', [
            'admin' => 'tadcms::items.breadcrumb',
        ])[$name];
    }
}