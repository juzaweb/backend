<?php

namespace Tadcms\Backend\Controllers;

use Tadcms\System\Models\Comment;

class CommentController extends BackendController
{
    public function index()
    {
        return view('tadcms::comment.index', [
            'title' => trans('tadcms::app.comments')
        ]);
    }
    
    public function getDataTable()
    {
        $search = $this->request->get('search');
        $status = $this->request->get('status');
        
        $sort = $this->request->get('sort', 'id');
        $order = $this->request->get('order', 'desc');
        $offset = $this->request->get('offset', 0);
        $limit = $this->request->get('limit', 20);
        
        $query = Comment::query();
        $query->select([
            'a.*',
            'b.name AS author',
            'c.title AS post'
        ]);
        
        $query->from('comments AS a');
        $query->join('users AS b', 'b.id', '=', 'a.user_id');
        $query->join('posts AS c', 'c.id', '=', 'a.post_id');
        
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
    
    public function destroy()
    {
        $this->request->validate($this->request, [
            'ids' => 'required',
        ], [], [
            'ids' => trans('tadcms::app.comments')
        ]);
        
        Comment::destroy($this->request->post('ids'));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('tadcms::app.deleted_successfully'),
        ]);
    }
    
    public function publicis()
    {
        $this->request->validate([
            'ids' => 'required',
            'status' => 'required|in:0,1,2,3',
        ], [], [
            'ids' => trans('tadcms::app.post_comments'),
            'status' => trans('tadcms::app.status'),
        ]);
        
        $status = $this->request->post('status');
        
        Comment::whereIn('id', $this->request->post('ids'))
            ->update([
                'status' => $status,
            ]);
        
        return $this->success('tadcms::app.updated_status_successfully');
    }
}
