<?php

namespace Tadcms\Backend\Controllers\Appearance;

use Illuminate\Http\Request;
use Tadcms\Backend\Controllers\BackendController;
use Tadcms\System\Models\Menu;

class MenuController extends BackendController
{
    public function index($id = null)
    {
        return view('tadcms::menu.index', [
            'title' => trans('tadcms::app.menus'),
        ]);
    }
    
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'content' => 'required',
        ]);
        
        $model = Menu::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->save();
        
        return $this->success(
            trans('tadcms::app.saved-successfully')
        );
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:menus,id'
        ], [], [
            'id' => trans('tadcms::app.menu')
        ]);

        Menu::destroy([$request->input('id')]);

        return $this->success(
            trans('tadcms::app.deleted-successfully')
        );
    }

    public function getItems(Request $request)
    {
        $request->validate([
            'type' => 'required',
        ]);
        
        $type = $request->post('type');
        $items = $request->post('items');
        
        switch ($type) {
            case 'genre':
                $items = Genres::where('status', '=', 1)
                    ->whereIn('id', $items)
                    ->get(['id', 'name', 'slug']);
                $result = [];
                
                foreach ($items as $item) {
                    $url = parse_url(route('genre', [$item->slug]))['path'];
                    $result[] = [
                        'name' => $item->name,
                        'url' => route('genre', [$item->slug]),
                        'object_id' => $item->id,
                    ];
                }
                
                return response()->json($result);
            case 'country':
                $items = Countries::where('status', '=', 1)
                    ->whereIn('id', $items)
                    ->get(['id', 'name', 'slug']);
                $result = [];
                
                foreach ($items as $item) {
                    $url = parse_url(route('country', [$item->slug]))['path'];
                    $result[] = [
                        'name' => $item->name,
                        'url' => $url,
                        'object_id' => $item->id,
                    ];
                }
                
                return response()->json($result);
            case 'type':
                $items = Types::where('status', '=', 1)
                    ->whereIn('id', $items)
                    ->get(['id', 'name', 'slug']);
                $result = [];
                
                foreach ($items as $item) {
                    $url = parse_url(route('type', [$item->slug]))['path'];
                    $result[] = [
                        'name' => $item->name,
                        'url' => $url,
                        'object_id' => $item->id,
                    ];
                }
                
                return response()->json($result);
            case 'page':
                $items = Pages::whereIn('id', $items)
                    ->get(['id', 'name', 'slug']);
                $result = [];
                
                foreach ($items as $item) {
                    $url = parse_url(route('page', [$item->slug]))['path'];
                    $result[] = [
                        'name' => $item->name,
                        'url' => $url,
                        'object_id' => $item->id,
                    ];
                }
                
                return response()->json($result);
        }
        
        return response()->json([
            'status' => 'error',
            'message' => ''
        ]);
    }
}
