<?php

namespace Tadcms\Backend\MenuItems;

use Tadcms\Backend\Abstracts\MenuItemAbstract;
use Tadcms\System\Models\Taxonomy;

class TaxonomyMenuItem extends MenuItemAbstract
{
    public static function formAdd()
    {

        return view('tadcms::menu_items.taxonomy.form_add');
    }

    public static function formEdit($data)
    {
        return view('tadcms::menu_items.taxonomy.form_edit');
    }

    public static function addData($request)
    {
        return [

        ];
    }

    public static function getLink($data)
    {
        $taxonomy = Taxonomy::find($data->get('id'));
        return '/text/' . $taxonomy;
    }
}
