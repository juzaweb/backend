<?php

namespace Tadcms\Backend\Controllers;

use Illuminate\Database\Schema\Blueprint;
use Tadcms\Backend\Controllers\BackendController;
use Tadcms\System\Models\Translation;
use Tadcms\System\Models\Language;

class LanguageController extends BackendController
{
    public function index() {
        
        return view('tadcms::language.index', [
            'title' => trans('tadcms::app.languages'),
        ]);
    }
    
    public function getDataTable() {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Language::query();
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
                $subquery->orWhere('key', 'like', '%'. $search .'%');
            });
        }
    
        if (!is_null($status)) {
            $query->where('status', '=', $status);
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        foreach ($rows as $row) {
            $row->created = $row->created_at->format('H:i Y-m-d');
            $row->tran_url = route('admin.setting.translate', [$row->key]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save() {
        $request->validate([
            'key' => 'required|string|max:3|min:2|alpha|unique:languages,key',
            'name' => 'required|string|max:250|unique:languages,name',
        ], [], [
            'key' => trans('app.key'),
            'name' => trans('app.name'),
        ]);
        
        $model = Language::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        if ($model->save()) {
            $new_col = $model->key;
            if (!\Schema::hasColumn('translation', $new_col)) {
                \Schema::table('translation', function (Blueprint $table) use ($new_col) {
                    $table->string($new_col, 300)->nullable();
                });
            }
        }
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.setting.languages'),
        ]);
    }
    
    public function remove() {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('app.genres')
        ]);
        
        $ids = $request->post('ids');
        foreach ($ids as $id) {
            $lang = Language::find($id);
            if ($lang->key == 'en') {
                continue;
            }
            
            Language::destroy([$id]);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.deleted_successfully'),
            'redirect' => route('admin.setting.languages'),
        ]);
    }
    
    public function setDefault() {
        $request->validate([
            'id' => 'required|exists:languages,id',
        ], [], [
            'id' => trans('app.language')
        ]);
        
        Language::where('id', '=', $request->post('id'))
            ->update([
                'default' => 1,
            ]);
    
        Language::where('id', '!=', $request->post('id'))
            ->update([
                'default' => 0,
            ]);
    
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
        ]);
    }
    
    public function syncLanguage() {
        Translation::syncLanguage();
    
        return response()->json([
            'status' => 'success',
            'message' => trans('app.sync_successfully'),
            'redirect' => route('admin.setting.languages'),
        ]);
    }
    
    protected function recurseCopy($src, $dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurseCopy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}
