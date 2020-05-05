<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VideoRequest;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Resources\VideoResource;

class VideoController extends Controller
{
    public function store(VideoRequest $request, Video $video)
    {
        $video->fill($request->all());
        $video->user_id = $request->user()->id;
        $video->save();


        return (new VideoResource($video));
    }

}
