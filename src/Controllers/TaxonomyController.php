<?php

namespace Tadcms\Backend\Controllers;

use Illuminate\Http\Request;
use Tadcms\Backend\Controllers\BackendController;
use Tadcms\System\Models\Taxonomy;
use Tadcms\Services\TaxonomyService;
use Tadcms\Services\DataTableService;

class TaxonomyController extends BackendController
{
    /**
     * @var \Tadcms\Services\TaxonomyService $taxonomyService
     * */
    protected $taxonomyService;
    
    public function __construct(
        Request $request,
        TaxonomyService $taxonomyService)
    {
        
        parent::__construct($request);
        
        $this->taxonomyService = $taxonomyService;
    }
    
    public function index($type = 'posts', $taxonomy = 'categories')
    {
        $model = $this->taxonomyService->firstOrNew(['id' => null]);
        
        return view('tadcms::category.index', [
            'title' => 'Category',
            'type' => $type,
            'taxonomy' => $taxonomy,
            'model' => $model,
        ]);
    }
    
    public function form($type = 'posts', $taxonomy = 'categories', $id = null)
    {
        $model = $this->taxonomyService->firstOrNew(['id' => $id]);
        
        $title = $model->name ?: trans('tadcms::app.add-new');
        
        $this->addBreadcrumb([
            'title' => trans('tadcms::app.category'),
            'url' => route('admin.taxonomy', [$type, $taxonomy])
        ]);
        
        return view('tadcms::category.form', [
            'model' => $model,
            'title' => $title,
            'type' => $type,
            'taxonomy' => $taxonomy,
        ]);
    }
    
    public function getDataTable($type, $taxonomy)
    {
        $table = (new DataTableService($request))
            ->setModel(Taxonomy::class)
            ->search(['name', 'description']);
    
        $table->where('taxonomy', '=', $taxonomy);
        
        $rows = $table->offsetAndLimit()
            ->getRows();
        
        foreach ($rows as $row) {
            $row->created = $row->created_at->format('H:i Y-m-d');
            $row->edit_url = route('admin.taxonomy.edit', [$type, $taxonomy, $row->id]);
        }
        
        return $table->jsonResponse($rows);
    }
    
    public function save($type, $taxonomy)
    {
        $this->validate($request, [
            'name' => 'required|string|max:250',
            'description' => 'nullable|string|max:300',
            'status' => 'required|in:0,1',
            'thumbnail' => 'nullable|string|max:250',
        ]);
        
        $this->taxonomyService->save(
            array_merge($request->all(), [
                'taxonomy' => $taxonomy,
                'post_type' => $type
            ])
        );
        
        return $this->success(trans('tadcms::app.saved_successfully'));
    }
    
    public function bulkActions($type, $taxonomy)
    {
        $this->validate($request, [
            'ids' => 'required|array',
        ]);
    
        do_action('bulk_action_taxonomy', $request->post());
        
        $action = $request->post('action');
        
        switch ($action) {
            case 'delete':
    
                $this->taxonomyService->delete(
                    $request->post('ids')
                );
                
                break;
        }
        
        return $this->success(
            trans('tadcms::app.successfully')
        );
    }
}