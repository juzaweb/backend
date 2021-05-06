<?php

namespace Tadcms\Backend\Controllers\Appearance;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Tadcms\Backend\Controllers\BackendController;
use Tadcms\System\Facades\HookAction;
use Tadcms\System\Models\Menu;
use Tadcms\System\Repositories\MenuRepository;

class MenuController extends BackendController
{
    protected $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function index()
    {
        $menuBlocks = $this->getMenuBlocks();

        return view('tadcms::menu.index', [
            'title' => trans('tadcms::app.menus'),
            'menuBlocks' => $menuBlocks
        ]);
    }

    public function edit($id)
    {
        $menu = $this->menuRepository->find($id);
        $menuBlocks = $this->getMenuBlocks();

        return view('tadcms::menu.index', [
            'title' => trans('tadcms::app.menus'),
            'menuBlocks' => $menuBlocks,
            'menu' => $menu
        ]);
    }
    
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
        ]);
        
        $model = Menu::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->save();
        
        return $this->success([
            'message' => trans('tadcms::app.saved-successfully'),
            'redirect' => route('admin.menu.id', $model->id)
        ]);
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
        $items = [];

        if (is_array(reset($data))) {
            foreach ($data as $item) {
                $items[] = view('tadcms::items.menu_item', [
                    'menuBlock' => $menuBlock,
                    'data' => $item,
                ])->render();
            }
        } else {
            $items[] = view('tadcms::items.menu_item', [
                'menuBlock' => $menuBlock,
                'data' => $data,
            ])->render();
        }

        return $this->response([
            'items' => $items
        ], true);
    }

    protected function getPostTypes()
    {
        $postTypes = apply_filters('tadcms.post_types', []);
        return $postTypes;
    }

    protected function getTaxonomies()
    {
        $taxonomies = collect(apply_filters('tadcms.taxonomies', []));
        $result = [];
        foreach ($taxonomies as $taxonomy) {
            $objectTypes = Arr::get($taxonomy, 'object_types');
            foreach ($objectTypes as $objectType) {
                $result[] = $objectType;
            }
        }
        return $result;
    }

    protected function addPostTypeMenuItem()
    {
        $postTypes = $this->getPostTypes();
        foreach ($postTypes as $postType) {
            HookAction::registerMenuItem('tadcms.post_type.' . $postType->get('singular'), [
                'label' => $postType->get('label'),
                'component' => 'Tadcms\Backend\MenuItems\PostTypeMenuItem',
            ]);
        }
    }

    protected function addTaxonomyMenuItem()
    {
        $taxonomies = $this->getTaxonomies();
        foreach ($taxonomies as $taxonomy) {
            HookAction::registerMenuItem('tadcms.' . $taxonomy->get('menu_slug'), [
                'label' => $taxonomy->get('type_label'),
                'component' => 'Tadcms\Backend\MenuItems\TaxonomyMenuItem',
            ]);
        }
    }

    protected function addCustomMenuItem()
    {
        HookAction::registerMenuItem('tadcms.custom_links', [
            'label' => trans('tadcms::app.custom-links'),
            'component' => 'Tadcms\Backend\MenuItems\CustomLinkMenuItem',
            'position' => 99
        ]);
    }

    protected function getMenuBlocks($key = null)
    {
        $this->addPostTypeMenuItem();
        $this->addTaxonomyMenuItem();
        $this->addCustomMenuItem();

        $menuItems = collect(apply_filters('tadcms.menu_blocks', []));
        if ($key) {
            return $menuItems->get($key);
        }

        return $menuItems->sortBy('position');
    }
}
