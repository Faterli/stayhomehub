<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Queries\MetaQuery;
use App\Http\Requests\Api\MetaRequest;
use App\Http\Resources\MetaResource;
use App\Models\Meta;
use Illuminate\Http\Request;

class MetasController extends Controller
{
    public function index(Request $request,  MetaQuery $query)
    {
        $meta = $query->paginate();

        $collect = MetaResource::collection($meta);
        $collect_v = [];
        foreach ($collect as $v) {
            if (!empty($v['video'])){
                $collect_v[] = $v['video'];
            }

        }
        $total = count($collect_v);

        return response()->json([
            'code' => 200,
            'message' => '查询成功',
            'result' =>[
                'list'  => $collect_v,
                'total' => $total,
            ]

            ,
        ]);
    }
    //点击操作
    public function store(MetaRequest $request)
    {
        $userId = auth('api')->id();

        $where = [
            'video_id'  => $request->video_id,
            'user_id'   => $userId,
        ];


        if (!empty($request->operate) && $request->operate == 2){
            $meta = Meta::where($where)->first();
            if (empty($meta->id)){
                return response()->json([
                    'code' => 400,
                    'message' => '你已经取消收藏了',
                    'data' => [],
                ])->setStatusCode(200);
            }
            $down = Meta::find($meta->id);
            $down->delete();

        }elseif($request->operate == 1){
            $count = Meta::where($where)->count();

            if ($count){
                return response()->json([
                    'code' => 400,
                    'message' => '你已经收藏了',
                    'data' => [],
                ])->setStatusCode(200);
            }
            $meta = Meta::create($where);
        }
        if ($meta || $down){
            $count = Meta::where('video_id','=',$request->video_id)->count();

            return response()->json([
                'code' => 200,
                'message' => '操作成功',
                'data' => ['num'=>$count],
            ])->setStatusCode(200);
        }

    }

    public function rank(Request $request,MetaQuery $query)
    {

        $type = $request->type;
        $time = $request->time;

        $list = $query
                ->where('type',$type)
                ->where('created_at','>',$time)
                ->select('video_id',\DB::raw('count(*) as num'))
                ->groupBy('video_id')
                ->orderBy('num','desc')
                ->get();

        return response()->json([
            'code' => 200,
            'message' => '查询成功',
            'data' => MetaResource::collection($list),
        ])->setStatusCode(200);


    }




}
