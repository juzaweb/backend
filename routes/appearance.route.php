<?php

Route::group(['prefix' => 'themes'], function () {
    Route::get('/', 'Appearance\ThemeController@index')->name('admin.themes');
    
    //Route::get('/get-data', 'Appearance\ThemeController@getDataTable')->name('admin.themes.get-data');
    
    //Route::post('/activate', 'Appearance\ThemeController@activate')->name('admin.themes.activate');
    
    Route::get('/install', 'Appearance\ThemeInstallController@index')->name('admin.themes.install');
    
    Route::get('/editor', 'Appearance\ThemeEditorController@index')->name('admin.themes.editor');
    
    Route::post('/editor', 'Appearance\ThemeEditorController@save')->name('admin.themes.editor.save');
});

Route::group(['prefix' => 'menus'], function () {
    Route::get('/', 'Appearance\MenuController@index')->name('admin.menu');
    
    Route::get('/{id}', 'Appearance\MenuController@index')->name('admin.menu.id');

    Route::post('/save', 'Appearance\MenuController@save')->name('admin.menu.save');

    Route::post('/add-item', 'Appearance\MenuController@addItem')->name('admin.menu.add-item');
});
