<?php

Route::group(['prefix' => 'themes'], function () {
    Route::get('/', 'Appearance\ThemeController@index')->name('admin.themes');
    
    //Route::get('/get-data', 'Appearance\ThemeController@getDataTable')->name('admin.themes.get-data');
    
    //Route::post('/activate', 'Appearance\ThemeController@activate')->name('admin.themes.activate');
    
    Route::get('/install', 'Appearance\ThemeInstallController@index')->name('admin.themes.install');
});

Route::group(['prefix' => 'menus'], function () {
    Route::get('/', 'Appearance\MenuController@index')->name('admin.menu');
    
    Route::get('/{id}', 'Appearance\MenuController@index')->name('admin.menu.id');
    
    Route::post('/add-menu', 'Appearance\MenuController@addMenu')->name('admin.menu.add');
    
    Route::post('/save', 'Appearance\MenuController@save')->name('admin.menu.save');
    
    Route::post('/get-data', 'Appearance\MenuController@getItems')->name('admin.menu.items');
});

Route::group(['prefix' => 'design/editor'], function () {
    Route::get('/', 'Appearance\ThemeEditorController@index')->name('admin.design.editor');
    
    Route::post('/save', 'Appearance\ThemeEditorController@save')->name('admin.design.editor.save');
});