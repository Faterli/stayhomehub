<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{

    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                $userId = auth('adminapi')->id();

                return [
                    'video_id'  => 'exists:videos,id',
                    'pic'       => 'exists:images,id,type,banner,user_id,' . $userId,
                    'status'    => 'required|string',
                ];
                break;
            case 'PATCH':
                $userId = auth('adminapi')->id();

                return [
                    'video_id'  => 'exists:videos,id',
                    'pic'       => 'exists:images,id,type,banner,user_id,' . $userId,
                    'status'    => 'string',
                ];
                break;
        }
    }
}
