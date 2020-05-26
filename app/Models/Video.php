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


    public function resolveRouteBinding($value)
    {
        return QueryBuilder::for(self::class)
            ->allowedIncludes('user', 'category')
            ->where($this->getRouteKeyName(), $value)
            ->first();
    }
    public function scopeBeginTime(QueryBuilder $query, $date)
    {
        return $query->where('shooting_time', '>=', $date);
    }
    public function scopeEndTime(QueryBuilder $query, $date)
    {
        return $query->where('shooting_time', '<=', $date);
    }
    public function scopeBeginLength(QueryBuilder $query, $date)
    {
        return $query->where('video_duration', '>=', $date);
    }
    public function scopeEndLength(QueryBuilder $query, $date)
    {
        return $query->where('video_duration', '<=', $date);
    }
}
