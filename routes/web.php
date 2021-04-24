<?php

use Theanh\FileManager\Routes AS FileManagerRoutes;

Route::group(['middleware' => 'admin'], function () {

    require (__DIR__ . '/taxonomy.route.php');
    
    require (__DIR__ . '/appearance.route.php');
    
    require (__DIR__ . '/media.route.php');
    
    require (__DIR__ . '/plugin.route.php');
    
    require (__DIR__ . '/setting.route.php');
    
    require (__DIR__ . '/user.route.php');

    Route::get('/', 'DashboardController@index');

    Route::get('/dashboard', 'DashboardController@dashboard')->name('admin.dashboard');
    
    Route::get('/dashboard/update', 'DashboardController@update')->name('admin.dashboard.update');
    
    Route::get('/load-data/{func}', 'LoadDataController@loadData')->name('admin.load_data');
    
    Route::tadResource('notification', 'NotificationController');
    
    //Route::tadResource('languages', 'LanguageController');
    
    //Route::post('languages/sync', 'LanguageController@syncLanguage')->name('admin.languages.sync');
    
    //Route::post('languages/set-default', 'LanguageController@setDefault')->name('admin.languages.default');
    
    Route::group(['prefix' => 'file-manager'], function () {
        FileManagerRoutes::web();
    });
});
