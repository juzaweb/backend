<?php

namespace Tadcms\Backend\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static addMenuPage($menuTitle, $menuSlug, $args)
 * @method static registerTaxonomy($taxonomy, array $args)
 * @method static registerPostType($postType, array $args)
 * @see \Tadcms\Backend\Helpers\HookAction
 * */
class HookAction extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tadhook';
    }
}