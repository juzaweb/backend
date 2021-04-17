<?php

namespace Tadcms\Backend\Controllers;

use Illuminate\Http\Request;
use Tadcms\Backend\Controllers\BackendController;
use Tadcms\Backend\Requests\TaxonomyRequest;
use Tadcms\System\Models\Taxonomy;
use Tadcms\System\Repositories\TaxonomyRepository;

class TaxonomyController extends BackendController
{
    protected $taxonomyRepository;
    
    public function __construct(
        TaxonomyRepository $taxonomyRepository
    ) {
        $this->taxonomyRepository = $taxonomyRepository;
    }
    
    public function index($taxonomy)
    {
        $model = $this->taxonomyRepository->firstOrNew(['id' => null]);
        
        return view('tadcms::taxonomy.index', [
            'title' => 'Category',
            'taxonomy' => $taxonomy,
            'model' => $model,
        ]);
    }
    
    public function getDataTable($taxonomy, Request $request)
    {
        $search = $request->get('search');
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
    
        $query = Taxonomy::query();
        $query->where('taxonomy', '=', $taxonomy);
    
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
                $subquery->orWhere('description', 'like', '%'. $search .'%');
            });
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
    
        foreach ($rows as $row) {
            $row->edit_url = route('admin.taxonomy.edit', [$taxonomy, $row->id]);
        }
    
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function create($taxonomy)
    {
        $model = $this->taxonomyRepository->newModel();
    
        $this->addBreadcrumb([
            'title' => trans('tadcms::app.category'),
            'url' => route('admin.taxonomy.index', [$taxonomy])
        ]);
        
        return view('tadcms::taxonomy.form', [
            'model' => $model,
            'title' => trans('tadcms::app.add-new'),
            'taxonomy' => $taxonomy,
        ]);
    }
    
    public function edit($taxonomy, $id)
    {
        $model = $this->taxonomyRepository->findOrFail($id);
        $model->load('parent');
        
        $this->addBreadcrumb([
            'title' => trans('tadcms::app.category'),
            'url' => route('admin.taxonomy.index', [$taxonomy])
        ]);
        
        return view('tadcms::taxonomy.form', [
            'model' => $model,
            'title' => $model->name,
            'taxonomy' => $taxonomy,
        ]);
    }
    
    public function store($taxonomy, TaxonomyRequest $request)
    {
        $this->taxonomyRepository->create($request->all());
        
        return $this->success(trans('tadcms::app.successfully'));
    }
    
    public function update($taxonomy, $id, TaxonomyRequest $request)
    {
        $this->taxonomyRepository->update($id, $request->all());
    
        return $this->success(trans('tadcms::app.successfully'));
    }
    
    public function bulkActions($taxonomy, Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'action' => 'required',
        ]);
    
        do_action('bulk_action.taxonomy.' . $taxonomy, $request->post());
        
        $action = $request->post('action');
        $ids = $request->post('ids');
        
        switch ($action) {
            case 'delete':
                foreach ($ids as $id) {
                    $this->taxonomyRepository->delete($id);
                }
                break;
        }
        
        return $this->success(
            trans('tadcms::app.successfully')
        );
    }
}