<?php

Route::group(['prefix' => 'media'], function () {
    Route::get('/', 'MediaController@index')->name('admin.media');
    
});