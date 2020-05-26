<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Queries\ViewQuery;
use App\Http\Requests\Api\ViewRequest;
use App\Http\Resources\ViewResource;
use App\Models\View;

class ViewController extends Controller
{
    public function index(Request $request,  ViewQuery $query)
    {
        $view       = $query->paginate();
        $view_month = $query->where('created_at', '>',date('Y-m-01 00:00:00',strtotime(now())))->paginate();
        $view_today = $query->where('created_at', '>',date('Y-m-d 00:00:00',strtotime(now())))->paginate();


        $collect_today = ViewResource::collection($view_today);
        $collect_month = ViewResource::collection($view_month);
        $collect       = ViewResource::collection($view);

        $total_today   = ViewResource::collection($view_today)->total();
        $total_month   = ViewResource::collection($view_month)->total();
        $total         = ViewResource::collection($view)->total();

        $collect_v_today = [];
        foreach ($collect_today as $v) {
            if (!empty($v['video'])){
                $collect_v_today[] = $v['video'];
            }

        }
        $collect_v_month = [];
        foreach ($collect_month as $va) {
            if (!empty($va['video'])){
                $collect_v_month[] = $va['video'];
            }

        }
        $collect_v = [];
        foreach ($collect as $val) {
            if (!empty($val['video'])){
                $collect_v[] = $val['video'];
            }

        }

        $list = [
            'today'  => [
                'total'=> $total_today,
                'list' => $collect_v_today,
            ],
            'yesterday' => [
                'total'=> $total_month,
                'list' => $collect_v_month,
            ],
            'within_a_week' => [
                'total'=> $total,
                'list' => $collect_v,
            ],
        ];
        return response()->json([
            'code' => 200,
            'message' => '查询成功',
            'result' => $list,
        ]);
    }
    //点击操作
    public function store(ViewRequest $request)
    {


        $userId = auth('api')->id();

        $where = [
            'video_id'  => $request->video_id,
            'user_id'   => $userId,
        ];

        $view  = View::where($where)->first();

        if (empty($view->id)){
            return response()->json([
                'code' => 400,
                'message' => '你已经删除记录了',
                'data' => [],
            ])->setStatusCode(200);
        }
        $down = View::find($view->id);
        $down->delete();


        if ($view){
            $count = View::where('video_id','=',$request->video_id)->count();

            return response()->json([
                'code' => 200,
                'message' => '删除记录了',
                'data' => ['num'=>$count],
            ])->setStatusCode(200);
        }

    }

}
