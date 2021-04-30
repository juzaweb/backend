<?php

namespace Tadcms\Backend\Traits;

trait FilterHandle
{
    protected function addMenuItem($items, $key, $args)
    {
        $items[$key] = $args;
        return $items;
    }
}
