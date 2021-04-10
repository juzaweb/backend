<?php

namespace Tadcms\Backend\Controllers;

use Tadcms\System\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends BackendController
{
    public function index()
    {
        return view('tadcms::comment.index', [
            'title' => trans('tadcms::app.comments')
        ]);
    }
    
    public function getDataTable(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Comment::query();
        $query->select([
            'a.*',
            'b.name AS author',
            'c.title AS post'
        ]);
        
        $query->from('comments AS a');
        $query->join('posts AS c', 'c.id', '=', 'a.post_id');
        $query->leftJoin('users AS b', 'b.id', '=', 'a.user_id');
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('b.name', 'like', '%'. $search .'%');
                $subquery->orWhere('a.content', 'like', '%'. $search .'%');
                $subquery->orWhere('c.title', 'like', '%'. $search .'%');
            });
        }
        
        if ($status) {
            $query->where('a.status', '=', $status);
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        foreach ($rows as $row) {
            $row->created = $row->created_at->format('H:i Y-m-d');
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
}
