<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Meta;
class VideoReplied extends Notification
{
    use Queueable;
    public $meta;
    public function __construct(Meta $meta)
    {
    // 注入回复实体，方便 toDatabase 方法中的使用
        $this->meta = $meta;
    }
    public function via($notifiable)
    {
    // 开启通知的频道
        return ['database'];
    }
    public function toDatabase($notifiable)
    {
        $video = $this->meta->video;

        return [
            'id' => $this->meta->id,
            'user_id' => $this->meta->user->id,
            'user_name' => $this->meta->user->name,
            'user_avatar' => $this->meta->user->avatar,
            'video_link' => $video->url,
            'video_id' => $video->id,
            'video_title' => $video->title,
            'type' => 'collect',
        ];

    }
}
