<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Queries\BannerQuery;
use App\Http\Requests\Api\BannerRequest;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use App\Models\Image;
use Illuminate\Http\Request;

class BannersController extends Controller
{
    public function index(Request $request,  BannerQuery $query)
    {
        $banner = $query->paginate();

        return BannerResource::collection($banner);
    }
    //新增
    public function store(BannerRequest $request)
    {
        $image = Image::find($request->pic);

        $banner = Banner::create([
            'video_id' => $request->video_id,
            'pic' => $image->path,
            'status' => $request->status,
        ]);
        return response()->json([
            'code' => 200,
            'message' => '添加成功',
            'result' => [
                new BannerResource($banner)
            ],
        ]);
    }
    //修改
    public function update(BannerRequest $request, Banner $banner)
    {
        $attributes = $request->only(['video_id', 'status']);
        if($request->pic){
            $image = Image::find($request->pic);
            $attributes['avatar'] = $image->path;
        }


        $banner->update($attributes);
        return response()->json([
            'code' => 200,
            'message' => '修改成功',
            'result' => [
                new BannerResource($banner)
            ],
        ]);
    }
    //删除
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return response()->json([
            'code' => 200,
            'message' => '删除成功',
            'result' => [
            ],
        ]);
    }
    //详情
    public function show($bannerId, BannerQuery $query)
    {
        $banner = $query->findOrFail($bannerId);

        return new BannerResource($banner);
    }
}
