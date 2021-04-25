<?php

namespace Tadcms\Backend\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function rules()
    {
        $lang = app()->getLocale();
        return [
            $lang . '.title' => 'required|string|max:250',
            'status' => 'required|string|in:public,private,draft,trash',
            $lang . 'thumbnail' => 'nullable|string|max:150',
        ];
    }
}
