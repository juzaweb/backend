<?php

namespace Tadcms\Backend\Controllers;

use Illuminate\Http\Request;
use Tadcms\Backend\Abstracts\TaxonomyControllerAbstract;

class TagController extends TaxonomyControllerAbstract
{
    protected $objectType = 'posts';
    protected $taxonomy = 'tags';

    public function getTagComponent(Request $request)
    {
        $item = $this->taxonomyRepository->findOrFail($request->input('id'));

        return $this->response([
            'html' => view('tadcms::components.tag-item', [
                'item' => $item
            ])
                ->render()
        ], true);
    }
}
