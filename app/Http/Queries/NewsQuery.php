<?php

namespace App\Http\Queries;

use App\Models\News;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class NewsQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(News::query());

        $this->allowedIncludes('video')
            ->allowedFilters([
                'type',
                AllowedFilter::exact('user_id'),
                AllowedFilter::exact('video_id'),
            ]);
    }
}
