<?php

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', 'Auth\LoginController@index')->name('admin.login');
    
    Route::post('/login', 'Auth\LoginController@login')->name('admin.login.handle');
});