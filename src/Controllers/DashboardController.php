<?php

namespace Tadcms\Backend\Controllers;

class DashboardController extends BackendController
{
    public function index()
    {
        return redirect()->route('admin.dashboard');
    }

    public function dashboard()
    {
        return view('tadcms::dashboard.index', [
            'title' => trans('tadcms::app.dashboard'),
        ]);
    }
    
    public function update()
    {
        return view('tadcms::dashboard.update', [
            'title' => trans('tadcms::app.updates'),
        ]);
    }
}
