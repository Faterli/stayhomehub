<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['title', 'introduction','user_id', 'category_id_one', 'category_id_second', 'country', 'province', 'city', 'url',
        'cover','cover_s','video_duration','time','watch_jurisdiction','transfer'];
}
