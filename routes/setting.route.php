<?php

Route::get('setting', 'Setting\SettingController@index')->name('admin.setting');

Route::post('setting', 'Setting\SettingController@save')->name('admin.setting.save');