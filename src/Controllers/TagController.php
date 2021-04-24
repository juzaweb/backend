<?php

namespace Tadcms\Backend\Controllers;

use Tadcms\Backend\Abstracts\TaxonomyControllerAbstract;

class TagController extends TaxonomyControllerAbstract
{
    protected $type = 'post';
    protected $taxonomy = 'tags';
    protected $taxonomySingular = 'tag';

    protected function label(): string
    {
        return trans('tadcms::app.tags');
    }
}
