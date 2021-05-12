<?php

namespace Tadcms\Backend\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tadcms\Backend\Abstracts\ResourceControllerAbstract;
use Tadcms\System\Models\User;
use Tadcms\System\Repositories\UserRepository;

class UserController extends ResourceControllerAbstract
{
    protected $userRepository;
    
    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    protected function mainRepository()
    {
        return $this->userRepository;
    }

    protected function validateRequest(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'password' => 'required_if:id,==,|nullable|string|max:32|min:6|confirmed',
            'avatar' => 'nullable|mimetypes:image/jpeg,image/png,image/gif',
            'email' => 'required_if:id,==,|email|unique:users,email',
            'status' => 'required|in:active,inactive,trash',
            'password_confirmation' => 'required_if:password,!=,null|nullable|string|max:32|min:6'
        ]);
    }
    
    public function index()
    {

        return view('tadcms::user.index', [
            'title' => trans('tadcms::app.users')
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
        
        $query = $this->mainRepository()
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
    
    public function create()
    {
        $this->addBreadcrumb([
            'title' => trans('tadcms::app.users'),
            'url' => route('admin.users.index'),
        ]);
    
        $model = new User();
        return view('tadcms::user.form', [
            'model' => $model,
            'title' => trans('tadcms::app.add-new')
        ]);
    }
    
    public function edit($id)
    {
        $this->addBreadcrumb([
            'title' => trans('tadcms::app.users'),
            'url' => route('admin.users.index'),
        ]);
        
        $model = $this->userRepository->find($id);
        return view('tadcms::user.form', [
            'model' => $model,
            'title' => $model->name
        ]);
    }
    
    public function store(Request $request)
    {
        $this->validateRequest($request);

        $user = $this->userRepository->create($request->all());
        $user->setAttribute('is_admin', $request->post('is_admin'))
            ->save();
        
        return $this->success(
            trans('tadcms::app.create-successfully')
        );
    }
    
    public function update($id, Request $request)
    {
        $this->validateRequest($request);

        $user = $this->userRepository->update($request->all(), $id);
        $user->setAttribute('is_admin', $request->post('is_admin'))
            ->save();
    
        return $this->success(
            trans('tadcms::app.update-successfully')
        );
    }
    
    public function bulkActions(Request $request)
    {
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
                    $this->userRepository->update(['status' => $action], $id);
                }
                break;
        }
    
        return $this->success(
            trans('tadcms::app.update-successfully')
        );
    }
}
