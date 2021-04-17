<?php

Route::group(['prefix' => 'media'], function () {
    Route::get('/', 'MediaController@index')->name('admin.media');
    Route::get('/type/{type}', 'MediaController@index')->name('admin.media.type');
    Route::get('/type/{type}/folder/{folder}', 'MediaController@index')->name('admin.media.folder')->where('folder', '[0-9]+');
    Route::post('/add-folder', 'MediaController@addFolder')->name('admin.media.add-folder');
    Route::post('/upload', 'MediaController@addFolder')->name('admin.media.upload');
});