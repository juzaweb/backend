<?php

namespace Tadcms\Backend\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:250',
            'password' => 'required_if:id,==,|nullable|string|max:32|min:6|confirmed',
            'avatar' => 'nullable|mimetypes:image/jpeg,image/png,image/gif',
            'email' => 'required_if:id,==,|unique:users,email',
            'status' => 'required|in:active,inactive,trash',
            'password_confirmation' => 'required_if:password,!=,null|nullable|string|max:32|min:6'
        ];
    }
    
    public function attributes()
    {
        return [
            'name' => trans('tadcms::app.name'),
            'email' => trans('tadcms::app.email'),
            'password' => trans('tadcms::app.password'),
            'password_confirmation' => trans('tadcms::app.password_confirmation'),
            'avatar' => trans('tadcms::app.avatar'),
            'status' => trans('tadcms::app.status'),
        ];
    }
}