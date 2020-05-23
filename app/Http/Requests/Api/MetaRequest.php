<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class MetaRequest extends FormRequest
{
    public function rules()
    {
        return [
            'video_id'   => 'exists:videos,id',
            'operate'    => 'string',
        ];
    }

}
