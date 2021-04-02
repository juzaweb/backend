<?php

namespace Tadcms\Backend\Controllers;

use Illuminate\Http\Request;
use Tadcms\Backend\Requests\SaveUserRequest;
use Tadcms\System\Repositories\UserRepository;

class UserController extends BackendController
{
    protected $userRepository;
    
    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }
    
    public function index() {
        return view('tadcms::user.index', [
            'title' => trans('tadcms::app.users')
        ]);
    }
    
    public function getDataTable(Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = $this->userRepository->query()
            ->select(['id', 'name', 'email', 'status', 'created_at']);
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
            });
        }
        
        if ($status) {
            $query->where('status', '=', $status);
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        foreach ($rows as $row) {
            $row->edit_url = route('admin.users.edit', [$row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function form($id = null) {
        $this->addBreadcrumb([
            'title' => trans('tadcms::app.users'),
            'url' => route('admin.users'),
        ]);
        
        $model = $this->userRepository->firstOrNew(['id' => $id]);
        return view('tadcms::user.form', [
            'model' => $model,
            'title' => $model->name ?: trans('tadcms::app.add-new')
        ]);
    }
    
    public function save(SaveUserRequest $request) {
        $user = $this->userRepository->updateOrCreate([
            'id' => $request->post('id')
        ], $request->all());
        
        $this->userRepository
            ->setAdmin($user, $request->post('is_admin'));
        
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $extention = $avatar->getClientOriginalExtension();
            $newname = $user->id . '.' . $extention;
            $upload = $avatar->storeAs('avatars', $newname, config('file-manager.upload_disk'));
            
            if ($upload) {
                $this->userRepository
                    ->setAvatar($user, $newname);
            }
        }
        
        return $this->success(
            trans('tadcms::app.save-successfully'),
            route('admin.users')
        );
    }
    
    public function bulkActions(Request $request) {
        $request->validate([
            'ids' => 'required',
        ], [], [
            'ids' => trans('tadcms::app.users')
        ]);
        
        $ids = $request->post('ids');
        $action = $request->post('action');
        
        switch ($action) {
            case 'delete':
                foreach ($ids as $id) {
                    $this->userRepository->delete($id);
                }
                break;
            case 'trash':
            case 'active':
            case 'inactive':
                foreach ($ids as $id) {
                    $this->userRepository->update($id, ['status' => $action]);
                }
                break;
        }
    
        return $this->success(
            trans('tadcms::app.successfully')
        );
    }
}
