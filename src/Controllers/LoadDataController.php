<?php

namespace Tadcms\Backend\Controllers;

use Illuminate\Http\Request;
use Tadcms\System\Models\Taxonomy;

class LoadDataController extends BackendController
{
    public function loadData($func, Request $request)
    {
        if (method_exists($this, $func)) {
            return $this->{$func}($request);
        }
        
        return $this->error('Function not found');
    }
    
    protected function loadAllLanguage(Request $request)
    {
        $search = $request->get('search');
        $languages = collect(trans('tadcms::languages'));
        
        if ($search) {
            //$languages = $languages->where('');
        }
    }
    
    protected function loadTaxonomy(Request $request)
    {
        $search = $request->get('search');
        $explodes = $request->get('explodes');
        $taxonomy = $request->get('taxonomy');
        
        $query = Taxonomy::query();
        $query->select([
            'id',
            'name AS text'
        ]);
        $query->where('taxonomy', '=', $taxonomy);
        
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
}