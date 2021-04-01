<?php

Route::tadResource('plugins', 'Plugin\PluginController');

Route::get('plugins/install', 'Plugin\PluginInstallController@index')->name('admin.plugins.install');

