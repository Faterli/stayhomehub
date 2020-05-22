<?php

namespace App\Http\Queries;

use App\Models\Video;
use App\Models\Category;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Http\Request;

class VideoQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        parent::__construct(Video::query());

        if (isset($request->category_id))
        {
            if ($request->category_id >10)
            {
                $this->allowedIncludes('user', 'category')
                    ->where('category_id',"=",  $request->category_id)
                    ->allowedFilters([
                        'title','status',
                        AllowedFilter::scope('withOrder'),
                    ]);
            }else{

                $categoryid = $request->category_id;

                $_category_arr = Category::where(['parentId'=>$categoryid])->get()->toArray();
                $category_arr = array_column($_category_arr,'id');

                $this->allowedIncludes('user', 'category')
                    ->whereIn('category_id',  $category_arr)
                    ->allowedFilters([
                        'title','status',
                        AllowedFilter::scope('withOrder'),
                    ]);
            }

        }else{
            $this->allowedIncludes('user', 'category')
                ->allowedFilters([
                    'title','status',
                    AllowedFilter::scope('withOrder'),
                ]);
        }

    }
}
