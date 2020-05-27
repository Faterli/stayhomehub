<?php
namespace App\Observers;
use App\Models\News;
use App\Notifications\VideoAdmin;
class NewsObserver
{
    public function updated(News $news){
        //通知视频作者视频审核结果
        $news->video->user->notify(new VideoAdmin($news));
    }

}
