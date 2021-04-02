<?php

namespace Tadcms\Backend\Controllers;

use Tadcms\System\Models\Language;
use Tadcms\System\Models\Translation;

class TranslationController extends BackendController
{
    public function index($lang) {
        
        
        Language::where('key', '=', $lang)->firstOrFail();
        
        return view('tadcms::translation.index', [
            'lang' => $lang
        ]);
    }
    
    public function getDataTable($lang) {
        $search = $request->get('search');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
    
        $translator = app('translator');
    
        $rows = [];
        
        foreach ($translator->alias() as $alias) {
            dd($alias);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save($lang) {
        $request->validate([
            'key' => 'required|string|exists:translation,key',
            'value' => 'required|max:250',
        ], [], [
            'key' => trans('tadcms::app.key'),
            'value' => trans('tadcms::app.translate'),
        ]);
        
        $model = Translation::firstOrNew(['key' => $request->post('key')]);
        $model->setAttribute($lang, $request->post('value'));
        $model->save();
        
        return $this->success(
            trans('tadcms::app.save_successfully')
        );
    }
}
