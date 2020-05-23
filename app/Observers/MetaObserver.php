<?php
namespace App\Observers;
use App\Models\Meta;
use App\Notifications\VideoReplied;
class MetaObserver
{
    public function created(Meta $meta)
    {
        $meta->video->collect_count = $meta->video->metas->count();
        $meta->video->save();

        //通知视频作者有新的收藏
        $meta->video->user->notify(new VideoReplied($meta));
    }
    public function deleted(Meta $meta)
    {
        $meta->video->collect_count = $meta->video->metas->count();
        $meta->video->save();

        // 通知视频作者有新的取消收藏
        $meta->video->user->notify(new VideoReplied($meta));
    }
}
