<?php

Route::group(['prefix' => 'themes'], function () {
    Route::get('/', 'Appearance\ThemeController@index')->name('admin.themes');
    
    Route::get('/get-data', 'Appearance\ThemeController@getAllThemes')->name('admin.themes.get-data');
    
    Route::get('/install', 'Appearance\ThemeInstallController@index')->name('admin.themes.install');
    
    Route::post('/save', 'Design\ThemeController@save')->name('admin.themes.save');
    
    Route::post('/active', 'Appearance\ThemeInstallController@index')->name('admin.themes.install.active');
});

Route::group(['prefix' => 'menus'], function () {
    Route::get('/', 'Appearance\MenuController@index')->name('admin.menu');
    
    Route::get('/{id}', 'Design\MenuController@index')->name('admin.menu.id');
    
    Route::post('/add-menu', 'Design\MenuController@addMenu')->name('admin.menu.add');
    
    Route::post('/save', 'Design\MenuController@save')->name('admin.menu.save');
    
    Route::post('/get-data', 'Design\MenuController@getItems')->name('admin.menu.items');
});

Route::group(['prefix' => 'design/editor'], function () {
    Route::get('/', 'Design\ThemeEditorController@index')->name('admin.design.editor');
    
    Route::post('/save', 'Design\ThemeEditorController@save')->name('admin.design.editor.save');
});