<?php

namespace Tadcms\Backend\Controllers;

use Tadcms\Backend\Abstracts\TaxonomyControllerAbstract;

class TaxonomyController extends TaxonomyControllerAbstract
{
    protected $type = 'post';
    protected $taxonomy = 'categories';
    protected $taxonomySingular = 'category';

    public function index()
    {
        $model = $this->taxonomyRepository->firstOrNew(['id' => null]);
        return view('tadcms::taxonomy.index', [
            'title' => trans('tadcms::app.' . $this->taxonomy),
            'taxonomy' => $this->taxonomy,
            'model' => $model,
            'lang' => $this->getLocale()
        ]);
    }

    public function create()
    {
        $model = $this->taxonomyRepository->newModel();

        $this->addBreadcrumb([
            'title' => trans('tadcms::app.' . $this->taxonomy),
            'url' => route('admin.'. $this->taxonomy .'.index')
        ]);

        return view('tadcms::taxonomy.form', [
            'model' => $model,
            'title' => trans('tadcms::app.add-new'),
            'taxonomy' => $this->taxonomy,
            'lang' => $this->getLocale()
        ]);
    }

    public function edit($id)
    {
        $model = $this->taxonomyRepository->findOrFail($id);
        $model->load('parent');

        $this->addBreadcrumb([
            'title' => trans('tadcms::app.categories'),
            'url' => route('admin.'. $this->taxonomy .'.index')
        ]);

        return view('tadcms::taxonomy.form', [
            'model' => $model,
            'title' => $model->name,
            'taxonomy' => $this->taxonomy,
            'lang' => $this->getLocale()
        ]);
    }
}