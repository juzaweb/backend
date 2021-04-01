<?php

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', 'Auth\LoginController@index')->name('admin.login');
});