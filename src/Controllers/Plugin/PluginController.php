<?php

namespace Tadcms\Backend\Controllers\Plugin;

use Tadcms\Backend\Controllers\BackendController;
use Tadcms\Traits\ArrayPagination;
use Tadcms\Facades\Plugin;

/**
 * Class Tadcms\Backend\Controllers\Plugin\PluginController
 *
 * @package    Theanh\Tadcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/theanhk/tadcms
 * @license    MIT
 */
class PluginController extends BackendController
{
    use ArrayPagination;
    
    public function index()
    {
        return view('tadcms::plugin.index', [
            'title' => trans('tadcms::app.plugins'),
        ]);
    }
    
    public function getDataTable()
    {
        $offset = $this->request->get('offset', 0);
        $limit = $this->request->get('limit', 20);
        
        $plugins = Plugin::all();
        $total = count($plugins);
    
        $page = $offset <= 0 ? 1 : (round($offset / $limit));
        $data = $this->arrayPaginate($plugins, $limit, $page);
        $items = [];
        
        foreach ($data as $item) {
            $items[] = array_merge($item, [
                'id' => $item['namespace'],
                'status' => Plugin::isActivated($item['namespace']) ?
                    'active' : 'inactive',
            ]);
        }
        
        return response()->json([
            'total' => $total,
            'rows' => $items,
        ]);
    }
    
    public function bulkActions()
    {
        $this->request->validate([
            'ids' => 'required',
        ], [], [
            'ids' => trans('tadcms::app.plugins')
        ]);
        
        $ids = $this->request->post('ids');
        foreach ($ids as $plugin) {
            switch ($this->request->post('action')) {
                case 'delete':
                    Plugin::delete($plugin);
                    break;
                case 'activate':
                    Plugin::activate($plugin);
                    break;
                case 'deactivate':
                    Plugin::deActivate($plugin);
                    break;
            }
        }
        
        return $this->success(trans('app.successfully'));
    }
}
