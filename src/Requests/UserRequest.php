<?php

namespace Tadcms\Backend\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:250',
            'password' => 'required_if:id,==,|nullable|string|max:32|min:6|confirmed',
            'avatar' => 'nullable|string|max:150',
            'email' => 'required_if:id,==,|email|unique:users,email',
            'status' => 'required|in:active,inactive,trash',
            'password_confirmation' => 'required_if:password,!=,null|nullable|string|max:32|min:6'
        ];
    }
}
