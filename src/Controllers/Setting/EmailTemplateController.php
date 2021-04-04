<?php

namespace Tadcms\Backend\Controllers\Setting;

use Illuminate\Http\Request;
use Tadcms\Backend\Controllers\BackendController;
use Theanh\EmailTemplate\Models\EmailTemplate;

class EmailTemplateController extends BackendController
{
    public function index()
    {
        return view('tadcms::email_template.index', [
            'title' => trans('tadcms::app.email-template')
        ]);
    }
    
    public function form($id = null)
    {
        $model = EmailTemplate::firstOrNew(['id' => $id]);
        
        return view('tadcms::email_template.form', [
            'model' => $model
        ]);
    }
    
    public function getDataTable(Request $request)
    {
        $search = $request->get('search');
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
    
        $query = EmailTemplate::query();
        $query->select([
            'a.*',
        ]);
        
        if ($search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->orWhere('b.name', 'like', '%'. $search .'%');
                
            });
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save(Request $request)
    {
    
    }
    
    public function bulkActions(Request $request) {
        $request->validate([
            'ids' => 'required',
        ], [], [
            'ids' => trans('tadcms::validation.attributes.email_templates')
        ]);
        
        $ids = $request->post('ids');
        $action = $request->post('action');
        
        switch ($action) {
            case 'delete':
                EmailTemplate::whereIn('id', $ids)
                    ->delete();
                break;
        }
        
        return $this->success(
            trans('tadcms::app.successfully')
        );
    }
}
