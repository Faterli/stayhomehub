<?php

namespace App\Models;

use Spatie\QueryBuilder\QueryBuilder;


class Video extends Model
{
    protected $fillable = ['title', 'introduction','user_id', 'category_id', 'shooting_country', 'shooting_province', 'shooting_city', 'url',
        'cover','cover_s','video_duration','shooting_time','user_watch_jurisdiction','transfer','collect_count','view_count'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function metas()
    {
        return $this->hasMany(Meta::class);
    }
    public function view()
    {
        return $this->hasMany(View::class);
    }

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

    public function resolveRouteBinding($value)
    {
        return QueryBuilder::for(self::class)
            ->allowedIncludes('user', 'category')
            ->where($this->getRouteKeyName(), $value)
            ->first();
    }
}
