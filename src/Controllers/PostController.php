<?php

namespace Tadcms\Backend\Controllers;

use Illuminate\Http\Request;
use Tadcms\System\Repositories\PostRepository;

class PostController extends BackendController
{
    protected $postRepository;
    
    public function __construct(
        PostRepository $postRepository
    ) {
        $this->postRepository = $postRepository;
    }
    
    public function index($postType)
    {
        return view('tadcms::post.index', [
            'title' => trans('tadcms::app.post'),
            'post_type' => $postType,
        ]);
    }
    
    public function create($postType)
    {
        $model = $this->postRepository->newModel();
        
        $this->addBreadcrumb([
            'title' => trans('tadcms::app.posts'),
            'url' => route('admin.post-type.index', [$postType]),
        ]);
    
        return view('tadcms::post.form', [
            'model' => $model,
            'title' => trans('tadcms::app.add-new'),
            'post_type' => $postType,
        ]);
    }
    
    public function edit($postType, $id) {
        $model = $this->postRepository->findOrFail($id);
        //$categories = Category::where('status', '=', 1)->get();
        
        $this->addBreadcrumb([
            'title' => trans('tadcms::app.posts'),
            'url' => route('admin.post-type', [$postType]),
        ]);
        
        return view('tadcms::post.form', [
            'model' => $model,
            'title' => $model->title ?: trans('tadcms::app.add-new'),
            'post_type' => $postType,
        ]);
    }
    
    public function getDataTable(Request $request, $postType) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = $this->postRepository->query();
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
                $subquery->orWhere('description', 'like', '%'. $search .'%');
            });
        }
        
        $query->where('type', '=', $postType);
        
        if (!is_null($status)) {
            $query->where('status', '=', $status);
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        foreach ($rows as $row) {
            $row->thumb_url = $row->getThumbnail();
            $row->created = $row->created_at->format('H:i Y-m-d');
            $row->edit_url = route('admin.post-type.edit', [$postType, $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function store($postType, Request $request) {
        $this->validate($request, [
            'id' => 'nullable|exists:posts,id',
            'title' => 'required|string|max:250',
            'status' => 'required|string|in:0,1',
            'thumbnail' => 'nullable|string|max:150',
            'categories' => 'nullable|string|max:200',
        ]);
        
        $this->postRepository->create($request->all());
        
        return $this->success('tadcms::app.saved-successfully');
    }
    
    public function update($postType, $id, Request $request) {
        $this->validate($request, [
            'id' => 'nullable|exists:posts,id',
            'title' => 'required|string|max:250',
            'status' => 'required|string|in:0,1',
            'thumbnail' => 'nullable|string|max:150',
            'categories' => 'nullable|string|max:200',
        ]);
        
        $this->postRepository->update($id, $request->all());
        
        return $this->success('tadcms::app.saved-successfully');
    }
}
