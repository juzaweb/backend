<?php

Route::group(['prefix' => 'media'], function () {
    Route::get('/', 'Backend\MediaController@index')->name('admin.media');
    
});