<?php

namespace Tadcms\Backend\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaxonomyRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:250',
            'description' => 'nullable|string|max:300',
            'status' => 'required|in:0,1',
            'thumbnail' => 'nullable|string|max:250',
        ];
    }
}