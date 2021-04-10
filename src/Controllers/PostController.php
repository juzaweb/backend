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
    
    public function index($post_type = 'posts')
    {
        
        return view('tadcms::post.index', [
            'title' => trans('tadcms::app.post'),
            'post_type' => $post_type,
        ]);
    }
    
    public function form($post_type = 'posts', $id = null) {
        $model = $this->postRepository->firstOrNew(['id' => $id]);
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
    
    public function getDataTable(Request $request, $post_type = 'posts') {
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
    
    public function save(Request $request, $post_type = 'posts') {
        $this->validate($request, [
            'id' => 'nullable|exists:posts,id',
            'title' => 'required|string|max:250',
            'status' => 'required|string|in:0,1',
            'thumbnail' => 'nullable|string|max:150',
            'categories' => 'nullable|string|max:200',
        ]);
        
        $this->postRepository->save(array_merge($request->all(), [
            'type' => $post_type,
        ]));
        
        return $this->success('tadcms::app.saved_successfully');
    }
}
