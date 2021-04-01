<?php

namespace Tadcms\Backend\Controllers\Appearance;

use Tadcms\Facades\Theme;
use Tadcms\Backend\Controllers\BackendController;
use Tadcms\Traits\ArrayPagination;

class ThemeController extends BackendController
{
    use ArrayPagination;
    
    public function index() {
        return view('tadcms::theme.index', [
            'title' => trans('tadcms::app.themes'),
        ]);
    }
    
    public function getAllThemes() {
        $page = $this->request->get('page', 1);
        $page_size = $this->request->get('page_size', 10);
        
        $themes = Theme::all();
        $data = $this->arrayPaginate($themes, $page_size, $page);
        
        return $this->response([
            'items' => $data->items(),
            'load_more' => $data->nextPageUrl() ? true : false,
        ], true);
    }
}
