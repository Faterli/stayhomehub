<?php

namespace App\Http\Queries;

use App\Models\Video;
use App\Models\Category;
use App\Models\User;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Http\Request;

class AdminvideoQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        parent::__construct(Video::query());

        if ($request->real_name){
            $real_name = $request->real_name;

            $userId = User::firstWhere('name','LIKE', $real_name)->id;
            $this->allowedIncludes('user', 'category')
                ->where('user_id','=',$userId)
                ->allowedFilters([
                    'title',
                    AllowedFilter::exact('status'),
                    AllowedFilter::exact('category_id'),
                    AllowedFilter::scope('begin_time'),
                    AllowedFilter::scope('end_time'),
                    AllowedFilter::scope('begin_length'),
                    AllowedFilter::scope('end_length'),

                ]);


        }else{
            $this->allowedIncludes('user', 'category')
                ->allowedFilters([
                    'title',
                    AllowedFilter::exact('status'),
                    AllowedFilter::exact('category_id'),
                    AllowedFilter::scope('begin_time'),
                    AllowedFilter::scope('end_time'),
                    AllowedFilter::scope('begin_length'),
                    AllowedFilter::scope('end_length'),

                ]);
        }



    }

}
