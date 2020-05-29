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
                    'category_id'        => 'required',
                    'shooting_country'   => 'required|string',
                    'shooting_province'  => 'string',
                    'shooting_city'      => 'string',
                    'url'                => 'required|string',
                    'cover'              => 'required|string',
                    'cover_s'            => 'required|string',
                    'video_duration'     => 'required|string',
                    'shooting_time'      => 'required|string',
                    'user_watch_jurisdiction' => 'required',
                    'transfer'           => 'required',
                ];
                break;
            case 'PATCH':
                return [
                    'title'              => 'string',
                    'introduction'       => 'string',
                    'category_id'        => 'exists:categories,id',
                    'shooting_country'   => 'string',
                    'shooting_province'  => 'string',
                    'shooting_city'      => 'string',
                    'url'                => 'string',
                    'cover'              => 'string',
                    'cover_s'            => 'string',
                    'video_duration'     => 'string',
                    'shooting_time'               => 'string',
                    'user_watch_jurisdiction' => 'string',
                    'transfer'           => 'string',
                ];
                break;
        }
    }
}
