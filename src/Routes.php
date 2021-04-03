<?php

namespace Tadcms\Backend;

class Routes
{
    public static function web()
    {
        require (__DIR__ . '/../routes/web.php');
    }
    
    public static function auth()
    {
        require (__DIR__ . '/../routes/auth.php');
    }
    
    public static function api()
    {
    
    }
}