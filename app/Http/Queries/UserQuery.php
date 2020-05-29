<?php

namespace App\Http\Queries;

use App\Models\User;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class UserQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(User::query());
        $this->allowedFilters([
            'name',
        ]);
    }
}
