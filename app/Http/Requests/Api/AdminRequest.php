<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    public function rules()
    {

        switch ($this->method()) {
            case 'POST':
                return [
                    'admin_name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:admins,admin_name',
                    'email' => 'required||unique:admins,email',
                    'phone' => [
                        'required',
                        'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199)\d{8}$/',
                        'unique:admins,phone'
                    ],
                    'password' => 'required|alpha_dash|min:6',
                    'status' => 'required',
                    'admin_type' => 'required',
                ];
                break;
            case 'PATCH':
                return [
                    'admin_name' => 'string|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/',
                    'email' => 'string',
                    'phone' => [
                        'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199)\d{8}$/',
                    ],
                    'password' => 'alpha_dash|min:6',
                    'status' => 'string',
                    'admin_type' => 'string',
                ];
                break;}
    }
}
