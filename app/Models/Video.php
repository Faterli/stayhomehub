<?php

namespace App\Models;

class Video extends Model
{
    protected $fillable = ['title', 'introduction','user_id', 'category_id_one', 'category_id_second', 'country', 'province', 'city', 'url',
        'cover','cover_s','video_duration','time','watch_jurisdiction','transfer'
    ];

}
