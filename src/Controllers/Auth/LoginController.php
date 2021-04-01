<?php

namespace Tadcms\Backend\Controllers\Auth;

use Tadcms\Backend\Controllers\BackendController;

class LoginController extends BackendController
{
    public function index() {
        return view('tadcms::auth.login');
    }
}