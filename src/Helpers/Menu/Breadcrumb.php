<?php

namespace Tadcms\Backend\Helpers\Menu;

/**
 * Class Breadcrumb
 *
 * @package    Tadcms\Tadcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/tadcms/tadcms
 * @license    MIT
 */
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