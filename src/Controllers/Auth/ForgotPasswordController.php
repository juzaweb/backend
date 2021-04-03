<?php

namespace Tadcms\Backend\Controllers\Auth;

use Tadcms\Http\Controllers\FrontendController;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    protected $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function index() {
        return view('');
    }
    
    public function forgotPassword() {
        $this->request->validate([
            'email' => 'required',
        ]);
        
        
    }
}
