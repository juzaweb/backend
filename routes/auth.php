<?php

$namespace = '\\Tadcms\\Backend\\Controllers';

Route::group(['namespace' => $namespace, 'middleware' => 'guest'], function () {
    Route::get('/login', 'Auth\LoginController@index')->name('auth.login');
    Route::post('/login', 'Auth\LoginController@login')->name('auth.login.handle');
    
    Route::get('/register', 'Auth\RegisterController@index')->name('auth.register');
    Route::post('/register', 'Auth\RegisterController@register')->name('auth.register.handle');
    
    Route::get('/forgot-password', 'Auth\ForgotPasswordController@index')->name('auth.forgot-password');
    Route::post('/forgot-password', 'Auth\ForgotPasswordController@forgotPassword');
});

Route::group(['namespace' => $namespace, 'middleware' => 'auth'], function () {
    Route::get('/logout', 'Auth\LoginController@logout')->name('auth.logout');
});