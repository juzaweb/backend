<?php

namespace Tadcms\Backend\Controllers\Auth;

use Tadcms\Lararepo\Controller;
use Illuminate\Http\Request;
use Tadcms\System\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        do_action('auth.login.index');
        
        //
        
        return view('tadcms::auth.login', [
            'title' => trans('tadcms::app.sign-in')
        ]);
    }
    
    public function login(Request $request)
    {
        // Login handle action
        do_action('auth.login.handle', $request);
    
        // Validate login
        $request->validate([
            'email' => 'required|email|max:150',
            'password' => 'required|min:6|max:32',
        ]);
        
        $email = $request->post('email');
        $password = $request->post('password');
        $remember = filter_var($request->post('remember'), FILTER_VALIDATE_BOOLEAN);
        
        $user = User::whereEmail($email)->first(['status']);
        
        if (!$user) {
            return $this->error(trans('tadcms::message.login-form.login-failed'));
        }
        
        if ($user->status != 'active') {
            return $this->error(trans('tadcms::message.login-form.user-is-banned'));
        }
        
        if (Auth::attempt([
            'email' => $email,
            'password' => $password
        ], $remember)) {
            do_action('auth.login.success', Auth::user());

            return $this->success(trans('tadcms::app.login-successfully'));
        }
    
        do_action('auth.login.failed');
        
        return $this->error(trans('tadcms::message.login-form.login-failed'));
    }
    
    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }
        
        return redirect()->to('/');
    }
}
