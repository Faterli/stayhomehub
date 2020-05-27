<?php
namespace App\Observers;
use App\Models\News;
use App\Models\Video;
class VideoObserver{
    public function created(Video $video)
    {
        $userId = auth('api')->id();

        $where = [
            'video_id'  => $video->id,
            'status'    => 1,
            'user_id'   => $userId??0,
        ];
        $count = News::where($where)->count();
        if (empty($count))
        {
            News::create($where);
        }

    }
}
