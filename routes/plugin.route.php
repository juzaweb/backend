<?php

Route::tadResource('plugins', 'Backend\Plugin\PluginController');

Route::get('plugins/install', 'Backend\Plugin\PluginInstallController@index')->name('admin.plugins.install');

