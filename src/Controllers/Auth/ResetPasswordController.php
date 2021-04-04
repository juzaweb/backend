<?php

namespace Tadcms\Backend\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use Tadcms\System\Models\PasswordReset;
use Theanh\Lararepo\Controller;
use Illuminate\Http\Request;
use Tadcms\System\Models\User;

class ResetPasswordController extends Controller
{
    public function index($email, $token)
    {
        do_action('auth.reset-password.index');
        
        $user = User::whereEmail($email)
            ->whereExists(function ($query) use ($email, $token) {
                $query->select(['email'])
                    ->where('email', '=', $email)
                    ->where('token', '=', $token);
            })
            ->firstOrFail();
        
        return view('tadcms::auth.forgot_password', [
            'user' => $user,
        ]);
    }
    
    public function resetPassword($email, $token, Request $request)
    {
        do_action('auth.reset-password.handle');
    
        $request->validate([
            'password' => 'required|string|min:6|max:32',
            'password_confirmation' => 'required|string|max:32|min:6'
        ]);
    
        $passwordReset = PasswordReset::where('email', '=', $email)
            ->where('token', '=', $token)
            ->firstOrFail();
    
        DB::beginTransaction();
        try {
            $passwordReset->delete();
        
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    
        return redirect()->route('auth.login');
    }
}
