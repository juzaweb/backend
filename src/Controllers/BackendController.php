<?php

namespace Tadcms\Backend\Controllers;

use Theanh\Lararepo\Controller;

class BackendController extends Controller
{
    public $breadcrumb_items = [];
    
    public function callAction($method, $parameters)
    {
        /**
         * TAD CMS: Backend
         *
         * Action after call action backend
         * Add action to this hook add_action('backend.call_action', $callback)
         * */
        do_action('backend.call_action', $method, $parameters);
        
        return parent::callAction($method, $parameters);
    }
    
    protected function addBreadcrumb(array $item, $name = 'admin')
    {
        add_filters($name . '_breadcrumb', function ($items) use ($item) {
            $items[] = $item;
            return $items;
        });
    }
}
