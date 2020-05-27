<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\News;
class VideoAdmin extends Notification
{
    use Queueable;
    public $news;
    public function __construct(News $news)
    {
        // 注入回复实体，方便 toDatabase 方法中的使用
        $this->news = $news;
    }
    public function via($notifiable)
    {
        // 开启通知的频道
        return ['database'];
    }
    public function toDatabase($notifiable)
    {
        $video = $this->news->video;
        $status = $this->news->status;
        if ($status == 2){
            return [
                'id' => $this->news->id,
                'admin_id' => $this->news->admin->id,
                'admin_name' => $this->news->admin->admin_name,
                'video_link' => $video->url,
                'video_id' => $video->id,
                'video_title' => $video->title,
                'status' => $status,
            ];
        }elseif ($status == 3)
        {
            return [
                'id' => $this->news->id,
                'admin_id' => $this->news->admin->id,
                'admin_name' => $this->news->admin->admin_name,
                'admin_email' => $this->news->admin->email,
                'video_link' => $video->url,
                'video_id' => $video->id,
                'video_title' => $video->title,
                'status' => $status,
                'reason' => $this->news->reason

            ];
        }


    }
}
