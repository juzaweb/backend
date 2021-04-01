<?php

namespace Tadcms\Backend\Controllers\Appearance;

use Illuminate\Http\Request;
use Tadcms\Backend\Controllers\BackendController;

class ThemeInstallController extends BackendController
{
    public function index() {
        return view('tadcms::backend.theme.install', [
            'title' => trans('tadcms::app.themes'),
        ]);
    }
}
