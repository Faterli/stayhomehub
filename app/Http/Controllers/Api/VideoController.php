<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VideoRequest;
use App\Models\Meta;
use App\Models\Video;
use App\Models\Category;
use App\Models\User;
use App\Models\View;
use Illuminate\Http\Request;
use App\Http\Resources\VideoResource;
use Auth;
use function GuzzleHttp\Promise\all;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Queries\VideoQuery;
use App\Http\Queries\MyvideoQuery;
use App\Http\Queries\AdminvideoQuery;


class VideoController extends Controller
{

    public function index(Request $request,  VideoQuery $query)
    {
        $video = $query->paginate($request->pagesize, ['*'], 'page', $request->page);
        $list  = VideoResource::collection($video);
        $total = VideoResource::collection($video)->total();
        foreach ($list as $k=>$v){
            $where = [
                'user_id' => auth('api')->id(),
                'video_id'=>$v['id'],
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
    public function home(Request $request,  MyvideoQuery $query)
    {
        //\DB::enableQueryLog();

        $order = $request->time_mode;
        $list  = VideoResource::collection($query->paginate($request->pagesize, ['*'], 'page', $request->page));
        $total = VideoResource::collection($query->paginate($request->pagesize, ['*'], 'page', $request->page))->total();

        //return response()->json(\DB::getQueryLog());die();
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

    public function selection()
    {
        $video = Video::orderBy('collect_count','desc')->limit(5)->get();;

        $total = count($video);
        foreach ($video as $k=>$v){
            $where = [
                'user_id' => auth('api')->id(),
                'video_id'=>$v['id'],
            ];
            $count = Meta::where($where)->count();
            $video[$k]['is_collect'] = empty($count) ? false : true ;

        }
        return response()->json([
            'code' => 200,
            'message' => '查询成功',
            'result' =>[
                'list'  => $video,
                'total' => $total,
            ]

            ,
        ]);
    }
    public function rank(Request $request)
    {
        $video = Video::orderBy('collect_count','desc')->get();;

        $total = count($video);

        return response()->json([
            'code' => 200,
            'message' => '查询成功',
            'result' =>[
                'list'  => $video,
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
        $video->status = 1;
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
//        $user_id = auth('api')->id();
//        $where = [
//            'video_id'  => $videoId,
//            'user_id'   => $user_id??0,
//            'type'      => 'view',
//        ];
//        Meta::create($where);

        $userId = auth('api')->id();

        $view_where = [
            'video_id'  => $videoId,
            'user_id'   => $userId??0,
        ];
        $count = View::where($view_where)->count();
        if (empty($count))
        {
            View::create($view_where);
        }
        $video = $query->findOrFail($videoId);
        $res = new VideoResource($video);
        $where = [
            'user_id' => $userId??0,
            'video_id'=>$videoId,
        ];
        $count = Meta::where($where)->count();
        $res['is_collect'] = empty($count) ? false : true ;

        return response()->json([
            'code' => 200,
            'message' => '查询详情成功',
            'result' =>$res
        ]);
    }

    #后台视频接口(搜索)
    public function search(Request $request,  AdminvideoQuery $query)
    {
        $video = $query->paginate($request->pagesize, ['*'], 'page', $request->page);
        $list  = VideoResource::collection($video);
        $total = VideoResource::collection($video)->total();

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
    //后台获取详情
    public function details(Request $request)
    {
        $res = Video::firstWhere('id',$request->id);
        if(!empty($res['category_id']))
        {
            $res['column_id'] = $res['category_id'];
            $column_name = Category::where(['id'=>$res['category_id']])->get('name')->first();

            $res['column_name'] = $column_name['name']??'';

        }
        return response()->json([
            'code' => 200,
            'message' => '查询详情成功',
            'result' =>$res
        ]);
    }

    //后台更新视频信息
    public function edit(Request $request)
    {
        Video::where('id',$request->id)->update($request->all());
        return response()->json([
            'code' => 200,
            'message' => '修改成功',
            'result' =>Video::firstWhere('id',$request->id)
            ,
        ]);
    }
}
