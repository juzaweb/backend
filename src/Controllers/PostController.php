<?php

namespace Tadcms\Backend\Controllers;

use Tadcms\Backend\Abstracts\PostControllerAbstract;

class PostController extends PostControllerAbstract
{
    protected $postType = 'posts';
    protected $postTypeSingular = 'post';

    protected function label(): string
    {
        return trans('tadcms::app.posts');
    }
}
