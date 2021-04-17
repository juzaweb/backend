<?php

namespace Tadcms\Backend\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Tadcms\Backend\Facades\HookAction;

class TaxonomyRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:250',
            'description' => 'nullable|string|max:300',
            'thumbnail' => 'nullable|string|max:150',
            'taxonomy' => 'required',
            'parent_id' => 'nullable|exists:taxonomies,id',
        ];
    }
    
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $taxonomy = $this->input('taxonomy');
        $taxonomies = apply_filters('taxonomies', []);
        if (!isset($taxonomies[$taxonomy])) {
            $taxonomy = null;
        }
        
        $this->merge([
            'taxonomy' => $taxonomy,
        ]);
    }
}