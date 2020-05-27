<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Queries\NewsQuery;
use App\Http\Requests\Api\NewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request,  NewsQuery $query)
    {
        $news = $query->paginate();

        return MetaResource::collection($news);
    }

    //修改
    public function update(NewsRequest $request, News $news)
    {
        $userId = auth('api')->id();

        if (auth('api')->id())
        {
            $userId = auth('api')->id();
        }else{
            $userId = '0000';

        }

        $news = News::create([
            'video_id' => $request->name,
            'user_id' => $request->email,
        ]);

        return new UserResource($news);
    }
}
