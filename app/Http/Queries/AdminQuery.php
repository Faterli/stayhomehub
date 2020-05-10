<?php

namespace App\Http\Queries;

use App\Models\Admin;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class AdminQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Admin::query());
        $this->allowedFilters([
                'name',
            ]);
    }
}
