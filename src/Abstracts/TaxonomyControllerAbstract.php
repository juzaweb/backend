<?php

namespace Tadcms\Backend\Abstracts;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tadcms\System\Repositories\TaxonomyRepository;
use Tadcms\Backend\Controllers\BackendController;
use Tadcms\Backend\Requests\TaxonomyRequest;
use Tadcms\System\Models\Taxonomy;

abstract class TaxonomyControllerAbstract extends BackendController
{
    protected $type;
    protected $taxonomy;
    protected $taxonomySingular;
    protected $taxonomyRepository;

    protected $supports = [
        'thumbnail',
        'hierarchical'
    ];

    public function __construct(
        TaxonomyRepository $taxonomyRepository
    ) {
        $this->taxonomyRepository = $taxonomyRepository;
    }

    public function index()
    {
        $model = $this->taxonomyRepository->firstOrNew(['id' => null]);
        return view('tadcms::taxonomy.index', [
            'title' => $this->getTitle(),
            'taxonomy' => $this->taxonomy,
            'model' => $model,
            'lang' => $this->getLocale(),
            'supports' => $this->supports
        ]);
    }

    public function create()
    {
        $model = $this->taxonomyRepository->newModel();
        $this->addBreadcrumb([
            'title' => $this->getTitle(),
            'url' => route('admin.'. $this->taxonomy .'.index')
        ]);

        return view('tadcms::taxonomy.form', [
            'model' => $model,
            'title' => trans('tadcms::app.add-new'),
            'taxonomy' => $this->taxonomy,
            'taxonomySingular' => $this->taxonomySingular,
            'type' => $this->type,
            'lang' => $this->getLocale(),
            'supports' => $this->supports
        ]);
    }

    public function edit($id)
    {
        $model = $this->taxonomyRepository->findOrFail($id);
        $model->load('parent');

        $this->addBreadcrumb([
            'title' => $this->getTitle(),
            'url' => route('admin.'. $this->taxonomy .'.index')
        ]);

        return view('tadcms::taxonomy.form', [
            'model' => $model,
            'title' => $model->name,
            'taxonomy' => $this->taxonomy,
            'taxonomySingular' => $this->taxonomySingular,
            'type' => $this->type,
            'lang' => $this->getLocale(),
            'supports' => $this->supports
        ]);
    }

    public function getDataTable(Request $request)
    {
        $search = $request->get('search');
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);

        $query = Taxonomy::query()->with(['translations']);
        $query->where('taxonomy', '=', $this->taxonomySingular);
        $query->where('type', '=', $this->type);

        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhereTranslationLike('name', '%'. $search .'%');
                $subquery->orWhereTranslationLike('description', '%'. $search .'%');
            });
        }

        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();

        foreach ($rows as $row) {
            $row->edit_url = route("admin.{$this->taxonomy}.edit", [$row->id]);
            $row->thumbnail = upload_url($row->thumbnail);
        }

        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }

    public function store(TaxonomyRequest $request)
    {
        $this->taxonomyRepository->create(array_merge($request->all(), [
            'type' => $this->type,
            'taxonomy' => $this->taxonomySingular
        ]));

        return $this->success(trans('tadcms::app.successfully'));
    }

    public function update($id, TaxonomyRequest $request)
    {
        $this->taxonomyRepository->update($id, array_merge($request->all(), [
            'type' => $this->type,
            'taxonomy' => $this->taxonomySingular
        ]));

        return $this->success(trans('tadcms::app.successfully'));
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'action' => 'required',
        ]);

        do_action('bulk_action.taxonomy.' . $this->taxonomy, $request->post());

        $action = $request->post('action');
        $ids = $request->post('ids');

        try {
            DB::beginTransaction();
            switch ($action) {
                case 'delete':
                    foreach ($ids as $id) {
                        $this->taxonomyRepository->delete($id);
                    }
                    break;
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $this->success(
            trans('tadcms::app.successfully')
        );
    }

    protected function getLocale()
    {
        return request()->input('locale') ?? app()->getLocale();
    }

    protected function getTitle()
    {
        return $this->label();
    }

    abstract protected function label() : string;
}
