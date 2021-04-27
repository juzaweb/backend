<?php

namespace Tadcms\Backend\Controllers;

use Illuminate\Http\Request;
use Tadcms\System\Models\Menu;
use Tadcms\System\Models\Taxonomy;
use Tadcms\System\Models\User;

class LoadDataController extends BackendController
{
    public function loadData($func, Request $request)
    {
        if (method_exists($this, $func)) {
            return $this->{$func}($request);
        }
        
        return $this->error('Function not found.');
    }
    
    protected function loadAllLanguage(Request $request)
    {
        $search = $request->get('search');
        $languages = collect(trans('tadcms::languages'));
        
        if ($search) {
            //$languages = $languages->where('');
        }
    }
    
    protected function loadTaxonomies(Request $request)
    {
        $search = $request->get('search');
        $explodes = $request->get('explodes');
        $type = $request->get('type');
        $taxonomy = $request->get('taxonomy');

        $query = Taxonomy::query()->with(['translations']);
        $query->select([
            'id',
        ]);

        $query->where('type', '=', $type);
        $query->where('taxonomy', '=', $taxonomy);
        
        if ($search) {
            $query->whereTranslation('name', 'like', '%'. $search .'%');
        }
        
        if ($explodes) {
            $query->whereNotIn('id', $explodes);
        }
        
        $paginate = $query->paginate(10);
        $data['results'] = $query->get();
        foreach ($data['results'] as $item) {
            $item->text = $item->name;
        }

        if ($paginate->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }
        
        return response()->json($data);
    }

    protected function loadUsers(Request $request)
    {
        $search = $request->get('search');
        $explodes = $request->get('explodes');

        $query = User::query();
        $query->select([
            'id',
            'name AS text'
        ]);

        if ($search) {
            $query->where('name', 'like', '%'. $search .'%');
        }

        if ($explodes) {
            $query->whereNotIn('id', explode(',', $explodes));
        }

        $paginate = $query->paginate(10);
        $data['results'] = $query->get();
        if ($paginate->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }

        return response()->json($data);
    }

    protected function loadMenus(Request $request)
    {
        $search = $request->get('search');

        $query = Menu::query();
        $query->select([
            'id',
            'name AS text'
        ]);

        if ($search) {
            $query->where('name', 'like', '%'. $search .'%');
        }

        $paginate = $query->paginate(10);
        $data['results'] = $query->get();
        if ($paginate->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }

        return response()->json($data);
    }
}
