<?php

Route::tadResource('comments', 'CommentController');

Route::tadResource('posts', 'PostController');

Route::tadResource('pages', 'PageController');

Route::tadResource('page/tags', 'PageTagController');

Route::tadResource('post/categories', 'TaxonomyController');

Route::tadResource('post/tags', 'TagController');

Route::get('tags/component-item', 'TagController@getTagComponent')->name('admin.tags.component-item');
