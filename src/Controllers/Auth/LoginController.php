<?php

namespace Tadcms\Backend\Controllers\Auth;

use Theanh\Lararepo\Controller;
use Illuminate\Http\Request;
use Tadcms\System\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        
        do_action('auth.login.index');
        
        //
        
        return view('tadcms::auth.login');
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
        
        if (!User::whereEmail($email)->exists()) {
            return $this->error(trans('Email or password is incorrect'));
        }
        
        if (\Auth::attempt(['email' => $email, 'password' => $password])) {
            do_action('auth.login.success', \Auth::user());
            
            if ($request->has('redirect')) {
                return $this->redirect(
                    $request->input('redirect')
                );
            }
            
            return $this->redirect(route('home'));
        }
    
        do_action('auth.login.failed');
        
        return $this->error('Email or password is incorrect');
    }
    
    public function logout()
    {
        if (\Auth::check()) {
            \Auth::logout();
        }
        
        return redirect()->route('home');
    }
}
