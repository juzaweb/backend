<?php

Route::get('setting', 'Backend\Setting\SettingController@index')->name('admin.setting');

Route::post('setting', 'Backend\Setting\SettingController@save')->name('admin.setting.save');