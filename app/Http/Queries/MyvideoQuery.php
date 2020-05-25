<?php

namespace App\Http\Queries;

use App\Models\Video;
use App\Models\Category;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Http\Request;

class MyvideoQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        parent::__construct(Video::query());

        $userId = auth('api')->id();
        $order = $request->time_mode;

        switch ($order) {
            case 1:
                $this->allowedIncludes('user', 'category')
                    ->where('user_id','=',$userId)
                    ->orderBy('created_at','desc')
                    ->allowedFilters([
                        AllowedFilter::exact('status'),
                        AllowedFilter::exact('category_id'),

                    ]);
                break;
            case 2:
                $this->allowedIncludes('user', 'category')
                    ->where('user_id','=',$userId)
                    ->orderBy('created_at','asc')
                    ->allowedFilters([
                        AllowedFilter::exact('status'),
                        AllowedFilter::exact('category_id'),

                    ]);
                break;

            default:
                $this->allowedIncludes('user', 'category')
                    ->where('user_id','=',$userId)
                    ->allowedFilters([
                        AllowedFilter::exact('status'),
                        AllowedFilter::exact('category_id'),

                    ]);
                break;
        }
    }
}
