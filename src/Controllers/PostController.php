<?php

namespace Tadcms\Backend\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tadcms\Backend\Requests\PostRequest;
use Tadcms\System\Models\Post;
use Tadcms\System\Repositories\PostRepository;
use Tadcms\System\Repositories\TaxonomyRepository;

class PostController extends BackendController
{
    protected $postRepository;
    protected $taxonomyRepository;
    
    public function __construct(
        PostRepository $postRepository,
        TaxonomyRepository $taxonomyRepository
    ) {
        $this->postRepository = $postRepository;
        $this->taxonomyRepository = $taxonomyRepository;
    }
    
    public function index($postType)
    {
        $config = $this->postRepository->getConfig($postType);
        
        return view('tadcms::post.index', [
            'title' => trans($config->get('label')),
            'post_type' => $postType,
        ]);
    }
    
    public function create($postType)
    {
        $config = $this->postRepository->getConfig($postType);
        $this->addBreadcrumb([
            'title' => trans($config->get('label')),
            'url' => route('admin.post-type.index', [$postType]),
        ]);
        
        $taxonomyConfig = $this->taxonomyRepository->getConfig();
        $taxonomies = $taxonomyConfig->filter(function ($item) use ($postType) {
            return in_array('post-type.' . $postType, $item['object_types']);
        });
        
        $model = $this->postRepository->newModel();
        
        return view('tadcms::post.form', [
            'model' => $model,
            'title' => trans('tadcms::app.add-new'),
            'postType' => $postType,
            'taxonomies' => $taxonomies
        ]);
    }
    
    public function edit($postType, $id) {
        $config = $this->postRepository->getConfig($postType);
        $this->addBreadcrumb([
            'title' => trans($config->get('label')),
            'url' => route('admin.post-type.index', [$postType]),
        ]);
    
        $taxonomyConfig = $this->taxonomyRepository->getConfig();
        $taxonomies = $taxonomyConfig->filter(function ($item) use ($postType) {
            return in_array('post-type.' . $postType, $item['object_types']);
        });
        
        $model = $this->postRepository->findOrFail($id);
        $model->load(['taxonomies']);
        $selectedTaxonomies = $model->taxonomies->pluck('id')->toArray();
        
        return view('tadcms::post.form', [
            'model' => $model,
            'title' => $model->title,
            'postType' => $postType,
            'config' => $config,
            'taxonomies' => $taxonomies,
            'selectedTaxonomies' => $selectedTaxonomies
        ]);
    }
    
    public function getDataTable($postType, Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Post::query();
        
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
    
    public function store($postType, PostRequest $request) {
        DB::beginTransaction();
        try {
            $this->postRepository->create(array_merge($request->all(), [
                'type' => $postType
            ]));
        
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->error($exception->getMessage());
        }
        
        return $this->success(trans('tadcms::app.saved-successfully'));
    }
    
    public function update($postType, $id, PostRequest $request) {
        DB::beginTransaction();
        try {
            $this->postRepository->update($id, array_merge($request->all(), [
                'type' => $postType
            ]));
            
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        
        return $this->success(trans('tadcms::app.saved-successfully'));
    }
}
