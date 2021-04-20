<?php

Route::get('setting', 'Setting\SettingController@index')->name('admin.setting');
Route::get('setting/{form}', 'Setting\SettingController@index')->name('admin.setting');
Route::post('setting/{form}', 'Setting\SettingController@save');
Route::post('setting/email/send-test-mail', 'Setting\SettingController@sendTestMail')->name('admin.setting.test-email');

Route::group(['prefix' => 'email-template'], function () {
    Route::get('/', 'Setting\EmailTemplateController@index')->name('admin.email-template');
    Route::get('/get-data', 'Setting\EmailTemplateController@index')->name('admin.email-template.get-data');
    Route::post('/bulk-actions', 'Setting\EmailTemplateController@bulkActions')->name('admin.email-template.bulk-actions');
});
