<?php

namespace Tadcms\Backend\Controllers\Plugin;

use Tadcms\Backend\Controllers\BackendController;

class PluginInstallController extends BackendController
{
    public function index() {
        $this->addBreadcrumb([
            'title' => trans('tadcms::app.plugins'),
            'url' => route('admin.plugins'),
        ]);
        
        return view('tadcms::backend.plugin.install', [
            'title' => trans('tadcms::app.install-plugins'),
        ]);
    }
    
    public function upload() {
    
    }
    
    public function download() {
    
    }
}
