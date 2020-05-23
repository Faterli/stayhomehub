<?php

namespace App\Http\Queries;

use App\Models\Meta;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class MetaQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Meta::query());
        $user_id = auth('api')->id();

        $this->allowedIncludes('user', 'category', 'video')
            ->where('user_id',"=",  $user_id)
            ->allowedFilters([
                'type','created_at',
                AllowedFilter::exact('video_id'),
            ]);
    }
}
