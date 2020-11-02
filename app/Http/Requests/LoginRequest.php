<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'  =>  'required|between:1,18',
            'password'  =>  'required|between:4,18',
        ];
    }

    public function messages()
    {
        return [
            'username.required' =>  '请填写用户名',
            'username.between' =>  '用户名在1-18位之间',
            'password.required' =>  '请填写密码',
            'password.between' =>  '密码在1-18位之间',
        ];
    }
}
