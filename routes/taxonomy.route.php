<?php

Route::tadResource('comments', 'CommentController');

Route::tadResource('post-type/{type}', 'PostController', [
    'name' => 'post-type'
]);

Route::tadResource('taxonomy/{taxonomy}', 'TaxonomyController', [
    'name' => 'taxonomy'
]);
