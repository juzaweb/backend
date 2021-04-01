<?php

$admin_prefix = config('tadcms.admin-prefix');

Route::group(['prefix' => $admin_prefix], function () {
    require (__DIR__ . '/auth.route.php');
});

Route::group(['prefix' => $admin_prefix, 'middleware' => 'admin'], function (){
    
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
    
    require (__DIR__ . '/taxonomy.route.php');
    
    require (__DIR__ . '/appearance.route.php');
    
    require (__DIR__ . '/media.route.php');
    
    require (__DIR__ . '/plugin.route.php');
    
    require (__DIR__ . '/setting.route.php');
    
    require (__DIR__ . '/user.route.php');
    
    Route::tadResource('notification', 'Backend\NotificationController');
    
    Route::tadResource('languages', 'Backend\LanguageController');
    
    Route::post('languages/sync', 'Backend\LanguageController@syncLanguage')->name('admin.languages.sync');
    
    Route::post('languages/set-default', 'Backend\LanguageController@setDefault')->name('admin.languages.default');
});