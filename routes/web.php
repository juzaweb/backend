<?php

use Theanh\FileManager\Routes AS FileManagerRoutes;

$namespace = '\\Tadcms\\Backend\\Controllers';

Route::group(['namespace' => $namespace], function () {
    require (__DIR__ . '/auth.route.php');
});

Route::group(['namespace' => $namespace, 'middleware' => 'admin'], function () {
    //require (__DIR__ . '/taxonomy.route.php');
    
    require (__DIR__ . '/appearance.route.php');
    
    //require (__DIR__ . '/media.route.php');
    
    require (__DIR__ . '/plugin.route.php');
    
    require (__DIR__ . '/setting.route.php');
    
    require (__DIR__ . '/user.route.php');
    
    Route::get('/', 'DashboardController@index')->name('admin.dashboard');
    
    //Route::tadResource('notification', 'NotificationController');
    
    //Route::tadResource('languages', 'LanguageController');
    
    //Route::post('languages/sync', 'LanguageController@syncLanguage')->name('admin.languages.sync');
    
    //Route::post('languages/set-default', 'LanguageController@setDefault')->name('admin.languages.default');
    
    Route::group(['prefix' => 'file-manager'], function () {
        FileManagerRoutes::web();
    });
});
