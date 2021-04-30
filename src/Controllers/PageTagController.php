<?php

namespace Tadcms\Backend\Controllers;

use Tadcms\Backend\Abstracts\TaxonomyControllerAbstract;

class PageTagController extends TaxonomyControllerAbstract
{
    protected $objectType = 'pages';
    protected $taxonomy = 'tags';
}
