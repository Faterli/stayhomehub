<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VideoRequest;
use App\Models\Meta;
use App\Models\Video;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\VideoResource;
use Auth;
use function GuzzleHttp\Promise\all;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Queries\VideoQuery;


class VideoController extends Controller
{

    public function index(Request $request,  VideoQuery $query)
    {
        $video = $query->paginate();
        $list  = VideoResource::collection($video);
        $total = count($list);
        foreach ($list as $k=>$v){
            $where = [
                'user_id' => auth('api')->id(),
                'video_id'=>$v['id'],
                'type'=>'collect',
            ];
            $count = Meta::where($where)->count();
            $list[$k]['is_collect'] = empty($count) ? false : true ;

        }
        return response()->json([
            'code' => 200,
            'message' => '查询成功',
            'result' =>[
                'list'  => $list,
                'total' => $total,
            ]

            ,
        ]);
    }

    public function userIndex(Request $request, User $user, VideoQuery $query)
    {
        $video = $query->where('user_id', $user->id)->paginate();

        return VideoResource::collection($video);
    }


    //上传
    public function store(VideoRequest $request, Video $video)
    {
        $video->fill($request->all());
        $video->user_id = $request->user()->id;
        $video->save();

         return response()->json([
                 'code' => 200,
                 'message' => '上传成功',
                 'result' =>
                     new VideoResource($video)
                  ,
         ]);
    }


    //修改
    public function update(VideoRequest $request, Video $video)
    {

        $this->authorize('update', $video);

        $video->update($request->all());
        return response()->json([
            'code' => 200,
            'message' => '修改成功',
            'result' =>
                new VideoResource($video)
            ,
        ]);
    }
    //删除
    public function destroy(Video $video)
    {
        $this->authorize('destroy', $video);

        $video->delete();

        return response()->json([
            'code' => 200,
            'message' => '删除成功',
            'result' => [
            ],
        ]);
    }
    //详情
    public function show($videoId, VideoQuery $query)
    {
        $user_id = auth('api')->id();
        $where = [
            'video_id'  => $videoId,
            'user_id'   => $user_id??0,
            'type'      => 'view',
        ];
        Meta::create($where);
        $video = $query->findOrFail($videoId);
        return response()->json([
            'code' => 200,
            'message' => '查询详情成功',
            'result' =>
                new VideoResource($video)
            ,
        ]);
    }

}
