<?php

namespace Tadcms\Backend\Controllers;

class LoginController extends BackendController
{
    public function index() {
        return view('tadcms::auth.login');
    }
}