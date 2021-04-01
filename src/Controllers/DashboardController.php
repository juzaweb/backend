<?php

namespace Tadcms\Backend\Controllers;

class DashboardController extends BackendController
{
    public function index()
    {
        return view('tadcms::backend.dashboard', [
            'title' => trans('tadcms::app.dashboard'),
        ]);
    }
}
