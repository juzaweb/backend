<?php

namespace Tadcms\Backend\Middleware;

use Closure;
use Tadcms\Backend\Helpers\Menu\BackendMenu;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!\Auth::check()) {
            return redirect()->route('auth.login');
        }
        
        if (\Auth::user()->is_admin == 0) {
            return redirect()->to('/');
        }
        
        do_action('admin.middleware');
        
        $this->addBackendMenu();
        
        return $next($request);
    }
    
    protected function addBackendMenu()
    {
        BackendMenu::tadMenuLeft();
        BackendMenu::tadAppearanceMenu();
        BackendMenu::tadPluginMenu();
        BackendMenu::tadSettingMenu();
        if (config('tadcms.use_post')) {
            BackendMenu::tadPostTypeMenu();
        }

        if (config('tadcms.use_page')) {
            BackendMenu::tadPageMenu();
        }
    }
}
