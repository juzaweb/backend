<?php

Route::tadResource('posts', 'Backend\PostController', [
    'name' => 'posts'
]);

Route::tadResource('pages', 'Backend\PostController', [
    'name' => 'pages',
]);

Route::tadResource('comments', 'CommentController');

Route::tadResource('post-type/{type}', 'PostController', [
    'name' => 'post-type'
]);

Route::tadResource('taxonomy/{taxonomy}', 'TaxonomyController', [
    'name' => 'taxonomy'
]);
