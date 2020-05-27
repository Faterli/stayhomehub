<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
{
    public function rules()
    {
        return [
            'video_id'  => 'exists:videos,id',
            'user_id'   => 'exists:users,id',
        ];
    }
}
