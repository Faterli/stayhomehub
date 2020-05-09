<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VideoRequest;
use App\Models\Video;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\VideoResource;
use Auth;
use function GuzzleHttp\Promise\all;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;


class VideoController extends Controller
{

    public function index(Request $request, Video $video)
    {
        $video = QueryBuilder::for(Video::class)
            ->allowedIncludes('user', 'category')
            ->allowedFilters([
                'title',
                AllowedFilter::exact('category_id'),
                AllowedFilter::scope('withOrder'),
            ])
            ->paginate();

        return VideoResource::collection($video);
    }

    public function userIndex(Request $request, User $user)
    {
        $query = $user->video()->getQuery();

        $video = QueryBuilder::for($query)
            ->allowedIncludes('user', 'category')
            ->allowedFilters([
                'title',
                AllowedFilter::exact('category_id'),
                AllowedFilter::scope('withOrder'),
            ])
            ->paginate();

        return VideoResource::collection($video);
    }


    //上传
    public function store(VideoRequest $request, Video $video)
    {
        $video->fill($request->all());
        $video->user_id = $request->user()->id;
        $video->save();


        return (new VideoResource($video));
    }
    //修改
    public function update(VideoRequest $request, Video $video)
    {

        $this->authorize('update', $video);

        $video->update($request->all());
        return (new VideoResource($video));
    }
    //删除
    public function destroy(Video $video)
    {
        $this->authorize('destroy', $video);

        $video->delete();

        return response(null, 204);
    }


}
