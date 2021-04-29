<?php

namespace Tadcms\Backend\Abstracts;

use Illuminate\View\View;

abstract class MenuItemAbstract
{
    /**
     * Render component view form items
     * @return View
     * */
    abstract public function items();
}
