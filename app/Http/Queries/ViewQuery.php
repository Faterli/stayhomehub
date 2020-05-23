<?php

namespace App\Http\Queries;

use App\Models\View;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class ViewQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(View::query());
        $user_id = auth('api')->id();

        $this->allowedIncludes('user', 'category', 'video')
            ->where('user_id',"=",  $user_id)
            ->allowedFilters([
                'created_at',
                AllowedFilter::exact('video_id'),
            ]);
    }
}
