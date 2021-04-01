<?php

namespace Tadcms\Backend\Controllers;

use Illuminate\Http\Request;
use Tadcms\Backend\Controllers\BackendController;

class ResourceController extends BackendController
{
    protected $resource;
    
    public function __construct(Request $request)
    {
        parent::__construct($request);
        
        $this->resource = app()->make();
    }
    
    public function getData() {
        /**
         * @var \Tadcms\Datatables\AdminDatatable $datatable
         * */
        $datatable = new ($this->resource->datatable());
        
        return $this->response($datatable->makeData(), true);
    }
    
    public function save() {
        $this->resource->save($this->request);
        
        return $this->success('Updated');
    }
    
    public function getForm() {
        return $this->response([
            'items' => $this->resource->form(),
        ], true);
    }
    
    public function bullActions() {
    
    }
}