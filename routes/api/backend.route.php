<?php

Route::get('backend/menu/menu-left', 'Backend\MenuController@menuLeftItems');

Route::get('backend/menu/menu-top', 'Backend\MenuController@menuTopItems');

Route::group(['prefix' => 'resource'], function () {
    Route::get('{name}/data-table', 'Backend\ResourceController@getData');
    
    Route::get('{name}/form', 'Backend\ResourceController@getForm');
});