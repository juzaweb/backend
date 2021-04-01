<?php

namespace Tadcms\Backend\Controllers;

use Illuminate\Http\Request;
use Tadcms\System\Models\Post;
use Tadcms\Services\PostService;

class PostController extends BackendController
{
    protected $postService;
    
    public function __construct(
        Request $request,
        PostService $postService)
    {
        parent::__construct($request);
        
        $this->postService = $postService;
    }
    
    public function index($post_type = 'posts') {
        return view('tadcms::post.index', [
            'title' => trans('tadcms::app.post'),
            'post_type' => $post_type,
        ]);
    }
    
    public function form($post_type = 'posts', $id = null) {
        $model = Post::firstOrNew(['id' => $id]);
        //$categories = Category::where('status', '=', 1)->get();
        
        $this->addBreadcrumb([
            'title' => trans('tadcms::app.posts'),
            'url' => route('admin.post-type', [$post_type]),
        ]);
        
        return view('tadcms::post.form', [
            'model' => $model,
            'title' => $model->title ?: trans('tadcms::app.add-new'),
            'post_type' => $post_type,
        ]);
    }
    
    public function getDataTable($post_type = 'posts') {
        $search = $this->request->get('search');
        $status = $this->request->get('status');
        
        $sort = $this->request->get('sort', 'id');
        $order = $this->request->get('order', 'desc');
        $offset = $this->request->get('offset', 0);
        $limit = $this->request->get('limit', 20);
        
        $query = Post::query();
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
                $subquery->orWhere('description', 'like', '%'. $search .'%');
            });
        }
        
        $query->where('type', '=', $post_type);
        
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
            $row->edit_url = route('admin.post-type.edit', [$post_type, $row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function save($post_type = 'posts') {
        $this->validate($this->request, [
            'id' => 'nullable|exists:posts,id',
            'title' => 'required|string|max:250',
            'status' => 'required|string|in:0,1',
            'thumbnail' => 'nullable|string|max:250',
            'categories' => 'nullable|string|max:200',
        ]);
        
        $this->postService->save(array_merge($this->request->all(), [
            'type' => $post_type,
        ]));
        
        return $this->success('tadcms::app.saved_successfully');
    }
    
    public function destroy() {
        $this->validate($this->request, [
            'ids' => 'required',
        ], [], [
            'ids' => trans('tadcms::app.posts')
        ]);
        
        $this->postService->delete($this->request->post('ids'));
        
        return $this->success('tadcms::app.deleted_successfully');
    }
}
