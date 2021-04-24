<?php

Route::tadResource('comments', 'CommentController');

Route::tadResource('posts', 'PostController');

Route::tadResource('pages', 'PageController');

Route::tadResource('categories', 'TaxonomyController');

Route::tadResource('tags', 'TagController');

Route::tadResource('page-tags', 'TagController');
