<?php

Route::get('setting', 'Setting\SettingController@index')->name('admin.setting');
Route::post('setting', 'Setting\SettingController@save');

Route::get('setting-email', 'Setting\EmailController@index')->name('admin.setting.email');
Route::post('setting-email', 'Setting\EmailController@save');

Route::group(['prefix' => 'email-template'], function () {
    Route::get('/', 'Setting\EmailTemplateController@index')->name('admin.email-template');
    Route::get('/get-data', 'Setting\EmailTemplateController@index')->name('admin.email-template.get-data');
    Route::post('/bulk-actions', 'Setting\EmailTemplateController@bulkActions')->name('admin.email-template.bulk-actions');
});