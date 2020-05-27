<?php

namespace App\Http\Resources;

use App\Models\Admin;
use App\Models\Video;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['user'] = new UserResource($this->whenLoaded('user'));
        $data['video'] = new VideoResource($this->whenLoaded('video'));
        $data['admin'] = new AdminResource($this->whenLoaded('admin'));

        return $data;
    }
}
