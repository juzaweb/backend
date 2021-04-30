<?php

namespace Tadcms\Backend\Controllers\Appearance;

use Illuminate\Http\Request;
use Tadcms\Backend\Controllers\BackendController;
use Tadcms\System\Models\Menu;

class MenuController extends BackendController
{
    public function index($id = null)
    {
        $menuBlocks = $this->getMenuBlocks();
        return view('tadcms::menu.index', [
            'title' => trans('tadcms::app.menus'),
            'menuBlocks' => $menuBlocks
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

    public function addItem(Request $request)
    {
        $request->validate([
            'key' => 'required|string'
        ]);

        $menuKey = $request->post('key');
        $menuBlock = $this->getMenuBlocks($menuKey);
        $blockComponent = $menuBlock->get('component');

        $request->validate($blockComponent::validateData());

        $data = $blockComponent::addData($request);

        $itemView = view('tadcms::items.menu_item', [
            'menuKey' => $menuKey,
            'menuBlock' => $menuBlock,
            'data' => $data,
        ]);

        return $this->response([
            'html' => $itemView->render()
        ], true);
    }

    protected function getMenuBlocks($key = null)
    {
        $menuItems = collect(apply_filters('tadcms.menu_blocks', []));
        if ($key) {
            return $menuItems->get($key);
        }

        return $menuItems->sortBy('position');
    }
}
