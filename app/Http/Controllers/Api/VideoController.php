<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VideoRequest;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Resources\VideoResource;
use Auth;
use function GuzzleHttp\Promise\all;


class VideoController extends Controller
{
    public function store(VideoRequest $request, Video $video)
    {
        $video->fill($request->all());
        $video->user_id = $request->user()->id;
        $video->save();


        return (new VideoResource($video));
    }

    public function update(VideoRequest $request, Video $video)
    {
        $videos = $video->all();

        $this->authorize('update', ($videos[$request->route('id')-1]));

        $res = Video::where('id', $request->route('id'))
            ->update($request->all());
        if($res){
            return response()->json([
                'code' => 0,
                'message' => '更改成功',
                'data' => [true],
            ])->setStatusCode(201);
        }else{
            return response()->json([
                'code' => 0,
                'message' => '更新失败',
                'data' => [$res],
            ])->setStatusCode(201);
        }
    }

}
