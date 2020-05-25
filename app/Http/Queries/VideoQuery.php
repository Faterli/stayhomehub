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
        $start = '2000-01-01 00:00:00';
        $end   = '2030-01-01 00:00:00';
        if (isset($request->time_buckets))
        {
            $start_time = $request->time_buckets;
            $end_time   = $start_time + 1;
            $start = $start_time.'-01-01 00:00:00';
            $end = $end_time.'-01-01 00:00:00';
        }
        if (isset($request->year))
        {
            $start_year = $request->year;
            $end_year   = $start_year + 1;

            if(isset($request->month)){

                $start_month = $request->month;

                $start = $start_year.'-'.$start_month.'-01 00:00:00';
                $end = $start_year.'-'.$start_month.'-31 00:00:00';
            }else{
                $start = $start_year.'-01-01 00:00:00';
                $end = $end_year.'-01-01 00:00:00';
            }
        }

        if (isset($request->category_id))
        {
            if ($request->category_id >10)
            {
                $this->allowedIncludes('user', 'category')
                    ->where('category_id',"=",  $request->category_id)
                    ->where('shooting_time',">",  $start)
                    ->where('shooting_time',"<",  $end)
                    ->allowedFilters([
                        'title','status',
                    ]);
            }else{

                $categoryid = $request->category_id;

                $_category_arr = Category::where(['parentId'=>$categoryid])->get()->toArray();
                $category_arr = array_column($_category_arr,'id');
                array_push($category_arr,$categoryid);
                $this->allowedIncludes('user', 'category')
                    ->whereIn('category_id',  $category_arr)
                    ->where('shooting_time',">",  $start)
                    ->where('shooting_time',"<",  $end)
                    ->allowedFilters([
                        'title','status',
                    ]);
            }

        }else{
            $this->allowedIncludes('user', 'category')
                ->where('shooting_time',">",  $start)
                ->where('shooting_time',"<",  $end)
                ->allowedFilters([
                    'title','status',
                    AllowedFilter::exact('category_id'),
                ]);
        }
        if (isset($request->rank)){
            $rank = $request->rank;
            if ($rank == 'view'){
                if (isset($request->time))
                {
                    $time = $request->time;
                    if ($time == 'day'){
                        $this->allowedIncludes('user', 'category')
                            ->where('shooting_time', '>',date('Y-m-d 00:00:00',strtotime(now())))
                            ->orderBy('view_count','desc')
                            ->allowedFilters([
                                'status',
                            ]);
                    }elseif ($time == 'week'){
                        $this->allowedIncludes('user', 'category')
                            ->where('shooting_time', '>',date('Y-m-d 00:00:00',strtotime('this week Monday',time())))
                            ->orderBy('view_count','desc')
                            ->allowedFilters([
                                'status',
                            ]);
                    }elseif ($time == 'month'){
                        $this->allowedIncludes('user', 'category')
                            ->where('shooting_time', '>',date('Y-m-01 00:00:00',strtotime(now())))
                            ->orderBy('view_count','desc')
                            ->allowedFilters([
                                'status',
                            ]);
                    }elseif ($time == 'year'){
                        $this->allowedIncludes('user', 'category')
                            ->where('shooting_time', '>',date('Y-01-01 00:00:00',strtotime(now())))
                            ->orderBy('view_count','desc')
                            ->allowedFilters([
                                'status',
                            ]);
                    }elseif ($time == 'all'){
                        $this->allowedIncludes('user', 'category')
                            ->orderBy('view_count','desc')
                            ->allowedFilters([
                                'status',
                            ]);
                    }
                }
                $this->allowedIncludes('user', 'category')
                     ->orderBy('view_count','desc')
                     ->allowedFilters([
                        'status',
                    ]);
            }elseif ($rank == 'collect'){
                if (isset($request->time))
                {
                    $time = $request->time;
                    if ($time == 'day'){
                        $this->allowedIncludes('user', 'category')
                            ->where('shooting_time', '>',date('Y-m-d 00:00:00',strtotime(now())))
                            ->orderBy('collect_count','desc')
                            ->allowedFilters([
                                'status',
                            ]);
                    }elseif ($time == 'week'){
                        $this->allowedIncludes('user', 'category')
                            ->where('shooting_time', '>',date('Y-m-d 00:00:00',strtotime('this week Monday',time())))
                            ->orderBy('collect_count','desc')
                            ->allowedFilters([
                                'status',
                            ]);
                    }elseif ($time == 'month'){
                        $this->allowedIncludes('user', 'category')
                            ->where('shooting_time', '>',date('Y-m-01 00:00:00',strtotime(now())))
                            ->orderBy('collect_count','desc')
                            ->allowedFilters([
                                'status',
                            ]);
                    }elseif ($time == 'year'){
                        $this->allowedIncludes('user', 'category')
                            ->where('shooting_time', '>',date('Y-01-01 00:00:00',strtotime(now())))
                            ->orderBy('collect_count','desc')
                            ->allowedFilters([
                                'status',
                            ]);
                    }elseif ($time == 'all'){
                        $this->allowedIncludes('user', 'category')
                            ->orderBy('collect_count','desc')
                            ->allowedFilters([
                                'status',
                            ]);
                    }
                }
                $this->allowedIncludes('user', 'category')
                    ->orderBy('collect_count','desc')
                    ->allowedFilters([
                        'status',
                    ]);
            }


        }



    }
}
