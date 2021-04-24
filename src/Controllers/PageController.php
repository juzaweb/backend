<?php

namespace Tadcms\Backend\Controllers;

use Tadcms\Backend\Abstracts\PostControllerAbstract;

class PageController extends PostControllerAbstract
{
    protected $postType = 'pages';
    protected $postTypeSingular = 'page';

    protected function label(): string
    {
        return trans('tadcms::app.pages');
    }
}
