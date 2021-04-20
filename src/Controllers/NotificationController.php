<?php

namespace Tadcms\Backend\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Tadcms\System\Models\User;
use Theanh\Notification\Models\ManualNotification;

class NotificationController extends BackendController
{
    public function index()
    {
        return view('tadcms::notification.index', [
            'title' => trans('tadcms::app.notification')
        ]);
    }
    
    public function getDataTable(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = ManualNotification::query();
        if ($search) {
            $query->where(function (Builder $subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
                $subquery->orWhere('subject', 'like', '%'. $search .'%');
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
            $row->created = (string) $row->created_at;
            $row->edit_url = route('admin.notification.edit', ['id' => $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function create()
    {
        $this->addBreadcrumb([
            'name' => trans('tadcms::app.notification'),
            'url' => route('admin.notification')
        ]);

        $model = new ManualNotification();
        return view('tadcms::notification.form', [
            'title' => trans('tadcms::app.add-new'),
            'model' => $model,
        ]);
    }

    public function edit($id)
    {
        $this->addBreadcrumb([
            'name' => trans('tadcms::app.notification'),
            'url' => route('admin.notification')
        ]);

        $model = ManualNotification::findOrFail($id);
        $users = User::whereIn('id', explode(',', $model->users))
            ->get(['id', 'name']);
        return view('tadcms::notification.form', [
            'title' => $model->name,
            'model' => $model,
            'users' => $users,
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'subject' => 'required|string|max:300',
            'content' => 'required',
            'type' => 'required|in:1,2,3',
        ]);
        
        $users = $request->post('users');
        $users = $users ? implode(',', $users) : null;

        $model = new ManualNotification();
        $model->fill($request->all());
        $model->setAttribute('users', $users);
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.notification'),
        ]);
    }

    public function update(Request $request, $id)
    {

    }
    
    public function bulkActions(Request $request)
    {
        $request->validate([
            'ids' => 'required',
            'action' => 'required',
        ], [], [
            'ids' => trans('app.notification')
        ]);

        $action = $request->post('action');
        switch ($action) {
            case 'delete':
                ManualNotification::destroy($request->post('ids'));
                break;
        }

        return response()->json([
            'status' => 'success',
            'message' => trans('app.deleted_successfully'),
        ]);
    }
}
