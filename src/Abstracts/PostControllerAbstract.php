<?php

namespace Tadcms\Backend\Abstracts;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Tadcms\System\Models\Post;

abstract class PostControllerAbstract extends ResourceControllerAbstract
{
    protected $postType = 'posts';
    protected $viewPrefix = 'tadcms::post';
    protected $setting;

    public function __construct()
    {
        $this->setting = $this->getSetting();

        if (empty($this->setting)) {
            throw new \Exception('Post type ' . $this->postType . ' does not exists.');
        }
    }

    protected function mainRepository()
    {
        return app($this->setting->get('repository'));
    }

    protected function validateRequest(Request $request)
    {
        $lang = app()->getLocale();
        $request->validate([
            $lang . '.title' => 'required|string|max:250',
            'status' => 'required|string|in:public,private,draft,trash',
            $lang . 'thumbnail' => 'nullable|string|max:150',
        ]);
    }

    public function index()
    {
        $taxonomies = $this->getTaxonomies();
        return view($this->viewPrefix . '.index', [
            'title' => $this->setting->get('label'),
            'postType' => $this->postType,
            'taxonomies' => $taxonomies,
            'setting' => $this->setting,
        ]);
    }

    public function create()
    {
        $this->addBreadcrumb([
            'title' => $this->setting->get('label'),
            'url' => route("admin.{$this->postType}.index"),
        ]);

        $model = new Post();
        $taxonomies = $this->getTaxonomies();

        return view($this->viewPrefix . '.form', [
            'model' => $model,
            'lang' => app()->getLocale(),
            'title' => trans('tadcms::app.add-new'),
            'postType' => $this->postType,
            'taxonomies' => $taxonomies,
            'setting' => $this->setting,
        ]);
    }

    public function edit($id)
    {
        $this->addBreadcrumb([
            'title' => $this->setting->get('label'),
            'url' => route("admin.{$this->postType}.index"),
        ]);

        $model = $this->mainRepository()->find($id);
        $model->load(['translations']);
        $taxonomies = $this->getTaxonomies();

        return view($this->viewPrefix . '.form', [
            'model' => $model,
            'lang' => app()->getLocale(),
            'title' => $model->title ?? $model->name,
            'postType' => $this->postType,
            'taxonomies' => $taxonomies,
            'setting' => $this->setting,
        ]);
    }

    public function getDataTable(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $singular = $this->setting->get('singular');
        $taxonomies = $request->get('taxonomies');

        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);

        $query = $this->mainRepository()->query()
            ->with(['translations'])
            ->where('type', '=', $singular);

        if ($search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->orWhereTranslationLike('title', '%'. $search .'%');
                //$subQuery->orWhereTranslationLike('content', '%'. $search .'%');
            });
        }

        if ($taxonomies) {
            $taxonomies = explode(',', $taxonomies);
            foreach ($taxonomies as $taxonomy) {
                $query->whereHas('taxonomies', function ($q) use ($taxonomy) {
                    $q->where('id', '=', $taxonomy);
                });
            }
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
            $row->thumb_url = $row->getThumbnail();
            $row->created = get_date($row->created_at);
            $row->edit_url = route("admin.{$this->postType}.edit", [$row->id]);
        }

        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);

        DB::beginTransaction();
        try {
            $this->mainRepository()->create(array_merge($request->all(), [
                'type' => $this->setting->get('singular')
            ]));

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $this->success(
            trans('tadcms::app.saved-successfully')
        );
    }

    public function update($id, Request $request)
    {
        $this->validateRequest($request);

        DB::beginTransaction();
        try {
            $this->mainRepository()->update(array_merge($request->all(), [
                'type' => $this->setting->get('singular')
            ]), $id);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $this->success(
            trans('tadcms::app.saved-successfully')
        );
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'action' => 'required',
        ]);

        $action = $request->post('action');
        $ids = $request->post('ids');

        try {
            DB::beginTransaction();
            switch ($action) {
                case 'delete':
                    foreach ($ids as $id) {
                        $this->mainRepository()->delete($id);
                    }
                    break;
                case 'public':
                case 'private':
                case 'draft':
                    foreach ($ids as $id) {
                        $this->mainRepository()->update([
                            'status' => $action
                        ], $id);
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

    /**
     * @return \Illuminate\Support\Collection
     * */
    protected function getSetting()
    {
        return Arr::get(apply_filters('tadcms.post_types', []), $this->postType);
    }

    protected function getTaxonomies()
    {
        $taxonomies = collect(apply_filters('tadcms.taxonomies', []));
        $taxonomies = $taxonomies->filter(function ($item) {
            return Arr::has($item['object_types'], $this->postType);
        })->mapWithKeys(function ($item) {
            return [$item['taxonomy'] => $item['object_types'][$this->postType]];
        });

        $taxonomies = $taxonomies ? $taxonomies->sortBy('menu_position') : [];

        return $taxonomies;
    }
}
