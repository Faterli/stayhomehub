<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{

    public function rules()
    {
        switch ($this->method()) {
            case 'POST':

                return [
                    'video_id'  => 'exists:videos,id',
                    'pic'       => 'exists:images,id,type,banner',
                    'status'    => 'required|string',
                ];
                break;
            case 'PATCH':

                return [
                    'video_id'  => 'exists:videos,id',
                    'pic'       => 'exists:images,id,type,banner',
                    'status'    => 'string',
                ];
                break;
        }
    }
}
