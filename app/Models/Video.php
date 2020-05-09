<?php

namespace App\Models;

class Video extends Model
{
    protected $fillable = ['title', 'introduction','user_id', 'category_id_one', 'category_id_second', 'country', 'province', 'city', 'url',
        'cover','cover_s','video_duration','time','watch_jurisdiction','transfer'
    ];
    // 通过order进行话题排序
    public function scopeWithOrder($query, $order)
    {
        switch ($order) {
            case 'recent':
                $query = $this->recent();
                break;

            default:
                $query = $this->recentReplied();
                break;
        }
        return $query->with('user', 'category');
    }

    // 按照创建时间倒序排列
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeRecentReplied($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }
}
