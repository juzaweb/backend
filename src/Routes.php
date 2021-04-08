<?php

namespace Tadcms\Backend;

use Illuminate\Support\Facades\Route;

class Routes
{
    protected static $namespace = '\\Tadcms\\Backend\\Controllers';
    
    public static function web()
    {
        Route::group(['namespace' => self::$namespace], function () {
            require(__DIR__ . '/../routes/web.php');
        });
    }
    
    public static function auth()
    {
        Route::group(['namespace' => self::$namespace], function () {
            require(__DIR__ . '/../routes/auth.php');
        });
    }
    
    public static function api()
    {
    
    }
}