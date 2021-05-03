<?php

namespace Tadcms\Backend\Controllers;

use Illuminate\Http\Request;
use Tadcms\Backend\Abstracts\PostControllerAbstract;

class PageController extends PostControllerAbstract
{
    protected $postType = 'pages';
    protected $viewPrefix = 'tadcms::page';

    protected function validateRequest(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'status' => 'required|string|in:public,private,draft,trash',
            'thumbnail' => 'nullable|string|max:150',
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
            ->with(['translations']);

        if ($search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->orWhereTranslationLike('name', '%'. $search .'%');
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
            $row->created = get_date($row->created_at);
            $row->edit_url = route("admin.{$this->postType}.edit", [$row->id]);
        }

        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
}
