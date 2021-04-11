<?php

namespace Tadcms\Backend\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:250',
            'status' => 'required|string|in:0,1',
            'thumbnail' => 'nullable|string|max:150',
        ];
    }
}