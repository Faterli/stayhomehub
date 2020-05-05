<?php

namespace App\Http\Requests\Api;

class VideoRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title'              => 'required|string',
            'introduction'       => 'required|string',
            'category_id_one'    => 'required',
            'category_id_second' => 'required',
            'country'            => 'required|string',
            'province'           => 'required|string',
            'city'               => 'required|string',
            'url'                => 'required|string',
            'cover'              => 'required|string',
            'cover_s'            => 'required|string',
            'video_duration'     => 'required|string',
            'time'               => 'required|string',
            'watch_jurisdiction' => 'required',
            'transfer'           => 'required',
        ];
    }
}
