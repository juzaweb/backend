<?php

namespace Tadcms\Backend\Controllers;

use Tadcms\Backend\Abstracts\PostControllerAbstract;
use Tadcms\System\Models\Post;

class PostController extends PostControllerAbstract
{
    protected $postType = 'posts';
    protected $postTypeSingular = 'post';

    public function index()
    {
        return view('tadcms::post.index', [
            'title' => trans('tadcms::app.posts'),
            'postType' => $this->postType,
        ]);
    }
    
    public function create()
    {
        $this->addBreadcrumb([
            'title' => trans('tadcms::app.posts'),
            'url' => route("admin.{$this->postType}.index"),
        ]);

        $taxonomies = [];
        $model = new Post();
        
        return view('tadcms::post.form', [
            'model' => $model,
            'lang' => app()->getLocale(),
            'title' => trans('tadcms::app.add-new'),
            'postType' => $this->postType,
            'taxonomies' => $taxonomies
        ]);
    }
    
    public function edit($id)
    {
        $this->addBreadcrumb([
            'title' => trans('tadcms::app.posts'),
            'url' => route("admin.{$this->postType}.index"),
        ]);

        $taxonomies = [];
        
        $model = $this->postRepository->findOrFail($id);
        $model->load(['translations', 'taxonomies']);
        $selectedTaxonomies = $model->taxonomies->pluck('id')->toArray();

        return view('tadcms::post.form', [
            'model' => $model,
            'lang' => app()->getLocale(),
            'title' => $model->title,
            'postType' => $this->postType,
            'taxonomies' => $taxonomies,
            'selectedTaxonomies' => $selectedTaxonomies
        ]);
    }
}
