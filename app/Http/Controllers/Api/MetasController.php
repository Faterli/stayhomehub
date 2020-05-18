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

        return MetaResource::collection($meta);
    }
    //点击操作
    public function store(MetaRequest $request)
    {
        $userId = auth('api')->id();

        $where = [
            'video_id'  => $request->video_id,
            'user_id'   => $userId,
            'type'      => $request->type,
        ];

        $count = Meta::where($where)->count();

        if (!empty($count)){
            $meta = Meta::where($where)->delete();
        }else{
            $meta = Meta::create($where);
        }
        if ($meta){
            $count = Meta::where($where)->count();

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
