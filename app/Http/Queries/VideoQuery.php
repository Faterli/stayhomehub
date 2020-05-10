<?php

namespace App\Http\Queries;

use App\Models\Video;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class VideoQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Video::query());

        $this->allowedIncludes('user', 'category')
            ->allowedFilters([
                'title',
                AllowedFilter::exact('category_id'),
                AllowedFilter::scope('withOrder'),
            ]);
    }
}
