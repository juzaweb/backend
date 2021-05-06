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
        return view('tadcms::menu_items.taxonomy.form_edit', [
            'data' => $data
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     * */
    public static function addData($request)
    {
        $taxonomyIds = $request->input('taxonomy_ids');
        $taxonomies = Taxonomy::with('translations')
            ->whereIn('id', $taxonomyIds)
            ->get(['id']);

        $result = [];
        foreach ($taxonomies as $taxonomy) {
            $result[] = [
                'text' => $taxonomy->name,
                'id' => $taxonomy->id,
                'model' => Taxonomy::class,
            ];
        }

        return $result;
    }

    public static function getLink($data)
    {
        $taxonomy = Taxonomy::find($data->get('id'));
        return '/text/' . $taxonomy->slug;
    }
}
