<?php

Route::get('setting', 'Setting\SettingController@index')->name('admin.setting');
Route::post('setting', 'Setting\SettingController@save');

Route::get('setting-email', 'Setting\EmailController@index')->name('admin.setting.email');
Route::post('setting-email', 'Setting\EmailController@save');

