<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;
use App\Http\Resources\ImageResource;
use App\Http\Requests\Api\ImageRequest;

class ImagesController extends Controller
{
    public function store(ImageRequest $request, ImageUploadHandler $uploader, Image $image)
    {
        $user = $request->user();

        $size = $request->type == 'avatar' ? 416 : 1024;
        $result = $uploader->save($request->image, Str::plural($request->type), $user->id, $size);

        $image->path = $result['path'];
        $image->type = $request->type;
        $image->user_id = $user->id;
        $image->save();

        $info = new ImageResource($image);
         return response()->json([
                 'code' => 200,
                 'message' => '',
                 'result' => $info,
         ]);
    }
    public function store_admin(ImageRequest $request, ImageUploadHandler $uploader, Image $image)
    {
        $user_id = '0000';

        $size = $request->type == 'avatar' ? 416 : 1024;
        $result = $uploader->save($request->image, Str::plural($request->type), $user_id, $size);

        $image->path = $result['path'];
        $image->type = $request->type;
        $image->user_id = $user_id;
        $image->save();

        return new ImageResource($image);
    }
}
