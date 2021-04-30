<?php

namespace Tadcms\Backend\MenuItems;

use Tadcms\Backend\Abstracts\MenuItemAbstract;
use Tadcms\System\Models\Taxonomy;

class TaxonomyMenuItem
{
    public function add()
    {
        $items = Taxonomy::limit(5)->get();

        return view('tadcms::menu_items.taxonomy.form_add', [
            'items' => $items,
            'title' => trans('tadcms::app.categories'),
        ]);
    }

    public function edit()
    {

    }

    public function data()
    {
        return [
            'title' => '',
            'url' => '',
        ];
    }
}
