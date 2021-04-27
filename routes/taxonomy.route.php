<?php

Route::tadResource('comments', 'CommentController');

Route::tadResource('posts', 'PostController');

Route::tadResource('pages', 'PageController');

Route::tadResource('categories', 'TaxonomyController');

Route::tadResource('tags', 'TagController');

Route::get('tags/component-item', 'TagController@getTagComponent')->name('admin.tags.component-item');

Route::tadResource('page-tags', 'PageTagController');
