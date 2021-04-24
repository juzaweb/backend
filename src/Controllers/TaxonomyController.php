<?php

namespace Tadcms\Backend\Controllers;

use Tadcms\Backend\Abstracts\TaxonomyControllerAbstract;

class TaxonomyController extends TaxonomyControllerAbstract
{
    protected $type = 'post';
    protected $taxonomy = 'categories';
    protected $taxonomySingular = 'category';

    protected function label(): string
    {
        return trans('tadcms::app.categories');
    }
}