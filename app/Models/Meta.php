<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $fillable = [
        'user_id', 'video_id', 'type'
    ];
    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
