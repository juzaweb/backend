<?php

namespace Tadcms\Backend\Controllers;

use Illuminate\Http\Request;
use Theanh\Lararepo\Controllers\Controller;

class BackendController extends Controller
{
    public $breadcrumb_items = [];
    
    /**
     * @var \Illuminate\Http\Request $request
     * */
    protected $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function callAction($method, $parameters)
    {
        /**
         * TAD CMS
         * Action after call action backend
         * Add action to this hook add_action('backend.call_action', $callback)
         * */
        do_action('backend.call_action', $method, $parameters);
        
        return parent::callAction($method, $parameters);
    }
    
    protected function addBreadcrumb(array $item, $name = 'admin') {
        add_filters($name . '_breadcrumb', function ($items) use ($item) {
            $items[] = $item;
            return $items;
        });
    }
}
