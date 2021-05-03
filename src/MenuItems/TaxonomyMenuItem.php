<?php

namespace Tadcms\Backend\MenuItems;

use Tadcms\Backend\Abstracts\MenuItemAbstract;
use Tadcms\System\Models\Taxonomy;

class TaxonomyMenuItem extends MenuItemAbstract
{
    public static function formAdd()
    {
        $items = [];

        return view('tadcms::menu_items.taxonomy.form_add', [
            'items' => $items
        ]);
    }

    public static function formEdit($data)
    {
        return view('tadcms::menu_items.taxonomy.form_edit');
    }

    public static function addData($request)
    {
        return [
            'text' => $request->input('text'),
            'id' => $request->input('id'),
        ];
    }

    public static function getLink($data)
    {
        $taxonomy = Taxonomy::find($data->get('id'));
        return '/text/' . $taxonomy->slug;
    }
}
