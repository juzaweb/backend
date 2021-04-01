<?php

namespace Tadcms\Backend\Controllers;

class DashboardController extends BackendController
{
    public function index()
    {
        return view('tadcms::dashboard', [
            'title' => trans('tadcms::app.dashboard'),
        ]);
    }
}
