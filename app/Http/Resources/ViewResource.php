<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ViewResource extends JsonResource
{

    public function toArray($request)
    {
        return parent::toArray($request);
        $data['video'] = new VideoResource($this->whenLoaded('video'));

        return $data;
    }
}
