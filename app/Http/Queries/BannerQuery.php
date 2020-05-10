<?php

namespace App\Http\Queries;

use App\Models\Banner;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class BannerQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Banner::query());

        $this->allowedIncludes('video')
            ->allowedFilters([
                'status',
                AllowedFilter::exact('video_id'),
            ]);
    }
}
