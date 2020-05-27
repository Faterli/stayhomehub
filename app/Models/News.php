<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{

    protected $fillable = [
        'user_id', 'video_id','admin_id', 'status', 'reason'
    ];
    public function video()
    {
        return $this->belongsTo(Video::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
