<?php

namespace Tadcms\Backend\Abstracts;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Tadcms\Backend\Controllers\BackendController;
use Tadcms\Backend\Requests\PostRequest;
use Tadcms\System\Models\Post;
use Tadcms\System\Repositories\PostRepository;
use Tadcms\System\Repositories\TaxonomyRepository;

abstract class PostControllerAbstract extends BackendController
{
    protected $postRepository;
    protected $taxonomyRepository;
    protected $postType = 'posts';
    protected $setting;

    public function __construct(
        PostRepository $postRepository,
        TaxonomyRepository $taxonomyRepository
    ) {
        $this->postRepository = $postRepository;
        $this->taxonomyRepository = $taxonomyRepository;
        $this->setting = $this->getSetting();

        if (empty($this->setting)) {
            throw new \Exception('Post type ' . $this->postType . ' does not exists.');
        }
    }

    public function index()
    {
        $taxonomies = $this->getTaxonomies();
        return view('tadcms::post.index', [
            'title' => $this->setting->get('label'),
            'postType' => $this->postType,
            'taxonomies' => $taxonomies,
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

        return view('tadcms::post.form', [
            'model' => $model,
            'lang' => app()->getLocale(),
            'title' => trans('tadcms::app.add-new'),
            'postType' => $this->postType,
            'taxonomies' => $taxonomies,
        ]);
    }

    public function edit($id)
    {
        $this->addBreadcrumb([
            'title' => $this->setting->get('label'),
            'url' => route("admin.{$this->postType}.index"),
        ]);

        $model = $this->postRepository->find($id);
        $model->load(['translations']);
        $taxonomies = $this->getTaxonomies();

        return view('tadcms::post.form', [
            'model' => $model,
            'lang' => app()->getLocale(),
            'title' => $model->title,
            'postType' => $this->postType,
            'taxonomies' => $taxonomies,
        ]);
    }

    public function getDataTable(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $taxonomies = $request->get('taxonomies');

        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);

        $query = Post::query()->with(['translations']);
        $query->where('type', '=', $this->setting->get('singular'));

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

    public function store(PostRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->postRepository->create(array_merge($request->all(), [
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

    public function update($id, PostRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->postRepository->update(array_merge($request->all(), [
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
                        $this->postRepository->delete($id);
                    }
                    break;
                case 'public':
                case 'private':
                case 'draft':
                    foreach ($ids as $id) {
                        $this->postRepository->update($id, [
                            'status' => $action
                        ]);
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
