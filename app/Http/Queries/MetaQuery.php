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

        $this->allowedIncludes('user', 'category', 'video')
            ->allowedFilters([
                'type',
                AllowedFilter::exact('user_id'),
                AllowedFilter::exact('video_id'),
            ]);
    }
}
