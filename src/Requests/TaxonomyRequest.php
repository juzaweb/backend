<?php

namespace Tadcms\Backend\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaxonomyRequest extends FormRequest
{
    public function rules()
    {
        $locale = app()->getLocale();

        return [
            $locale . '.name' => 'required|string|max:250',
            $locale . '.description' => 'nullable|string|max:300',
            $locale . '.thumbnail' => 'nullable|string|max:150',
            'parent_id' => 'nullable|exists:taxonomies,id',
        ];
    }

    public function attributes()
    {
        $locale = app()->getLocale();
        return [
            $locale . '.name' => trans('tadcms::app.name'),
            $locale . '.description' => trans('tadcms::app.description'),
            $locale . '.thumbnail' => trans('tadcms::app.thumbnail'),
        ];
    }
}
