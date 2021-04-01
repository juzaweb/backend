<?php

namespace Tadcms\Backend\Controllers\Auth;

use Tadcms\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\User;

class RegisterController extends FrontendController
{
    public function index() {
        do_action('auth.register.index');
        
        return view('auth.register');
    }
    
    public function register(Request $request) {
        do_action('auth.register.handle', $request);
    
        // Validate register
        $request->validate([
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|min:6|max:32',
        ]);
        
        // Create user
        $name = $request->post('name');
        $email = $request->post('email');
        $password = $request->post('password');
        
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => \Hash::make($password),
        ]);
    
        do_action('auth.register.success', $user);
        
        return redirect()->route('home');
    }
}
