<?php
namespace App\Observers;
use App\Models\Meta;
use App\Notifications\VideoReplied;
class MetaObserver
{
    public function created(Meta $meta)
    {
        $meta->video->up_count = $meta->video->metas->count();
        $meta->video->save();

        //通知视频作者有新的点赞
        $meta->video->user->notify(new VideoReplied($meta));
    }
    public function deleted(Meta $meta)
    {
        $meta->video->up_count = $meta->video->metas->count();
        $meta->video->save();

        // 通知视频作者有新的取消点赞
        $meta->video->user->notify(new VideoReplied($meta));
    }
}
