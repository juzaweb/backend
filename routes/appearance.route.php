<?php

Route::group(['prefix' => 'themes'], function () {
    Route::get('/', 'Backend\Appearance\ThemeController@index')->name('admin.themes');
    
    Route::get('/get-data', 'Backend\Appearance\ThemeController@getAllThemes')->name('admin.themes.get-data');
    
    Route::get('/install', 'Backend\Appearance\ThemeInstallController@index')->name('admin.themes.install');
    
    Route::post('/save', 'Backend\Design\ThemeController@save')->name('admin.themes.save');
    
    Route::post('/active', 'Backend\Appearance\ThemeInstallController@index')->name('admin.themes.install.active');
});

Route::group(['prefix' => 'menus'], function () {
    Route::get('/', 'Backend\Appearance\MenuController@index')->name('admin.menu');
    
    Route::get('/{id}', 'Backend\Design\MenuController@index')->name('admin.menu.id');
    
    Route::post('/add-menu', 'Backend\Design\MenuController@addMenu')->name('admin.menu.add');
    
    Route::post('/save', 'Backend\Design\MenuController@save')->name('admin.menu.save');
    
    Route::post('/get-data', 'Backend\Design\MenuController@getItems')->name('admin.menu.items');
});

Route::group(['prefix' => 'design/editor'], function () {
    Route::get('/', 'Backend\Design\ThemeEditorController@index')->name('admin.design.editor');
    
    Route::post('/save', 'Backend\Design\ThemeEditorController@save')->name('admin.design.editor.save');
});