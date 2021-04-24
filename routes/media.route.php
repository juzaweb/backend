<?php

Route::group(['prefix' => 'media'], function () {
    Route::get('/', 'MediaController@index')->name('admin.media');
    Route::get('/folder/{folder}', 'MediaController@index')->name('admin.media.folder')->where('folder', '[0-9]+');
    Route::post('/add-folder', 'MediaController@addFolder')->name('admin.media.add-folder');
});
