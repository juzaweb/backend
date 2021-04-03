<?php

namespace Tadcms\Backend\Controllers\Appearance;

use Illuminate\Http\Request;
use Theanh\MultiTheme\Facades\Theme;
use Tadcms\Backend\Controllers\BackendController;
use Tadcms\System\Traits\ArrayPagination;

class ThemeController extends BackendController
{
    use ArrayPagination;
    
    public function index()
    {
        return view('tadcms::theme.index', [
            'title' => trans('tadcms::app.themes'),
        ]);
    }
    
    public function getDataTable(Request $request)
    {
        $page = $request->get('page', 1);
        $page_size = $request->get('page_size', 10);
        
        $themes = Theme::all();
        $data = $this->arrayPaginate($themes, $page_size, $page);
        
        return $this->response([
            'items' => $data->items(),
            'load_more' => $data->nextPageUrl() ? true : false,
        ], true);
    }
    
    public function activate(Request $request)
    {
        $request->validate([
            'theme' => 'required'
        ]);
        
        $theme = $request->post('theme');
        if (!Theme::has($theme)) {
            return $this->error(trans('tadcms::message.theme-not-found'));
        }
        
        set_config('activated_theme', $theme);
        return $this->redirect(
            route('admin.themes')
        );
    }
}
