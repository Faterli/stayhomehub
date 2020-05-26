<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'id', 'video_id', 'cover', 'status'
    ];
    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
