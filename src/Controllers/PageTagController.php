<?php

namespace Tadcms\Backend\Controllers;

use Tadcms\Backend\Abstracts\TaxonomyControllerAbstract;

class PageTagController extends TaxonomyControllerAbstract
{
    protected $type = 'page';
    protected $taxonomy = 'page-tags';
    protected $taxonomySingular = 'tag';
    protected $supports = [];

    protected function label(): string
    {
        return trans('tadcms::app.tags');
    }
}
