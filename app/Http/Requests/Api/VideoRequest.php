<?php

namespace App\Http\Requests\Api;


class VideoRequest extends FormRequest
{
    public function rules()
    {
        switch($this->method()) {
            case 'POST':
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
                break;
            case 'PATCH':
                return [
                    'title'              => 'string',
                    'introduction'       => 'string',
                    'category_id_one'    => 'exists:categories,id',
                    'category_id_second' => 'exists:categories,id',
                    'country'            => 'string',
                    'province'           => 'string',
                    'city'               => 'string',
                    'url'                => 'string',
                    'cover'              => 'string',
                    'cover_s'            => 'string',
                    'video_duration'     => 'string',
                    'time'               => 'string',
                    'watch_jurisdiction' => 'string',
                    'transfer'           => 'string',
                ];
                break;
        }
    }
}
