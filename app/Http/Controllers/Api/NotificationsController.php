<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Auth;
use App\Http\Resources\NotificationResource;

class NotificationsController extends Controller
{
    // 获取所有通知
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications()->paginate();

        $notification = NotificationResource::collection($notifications);
        $total        = NotificationResource::collection($notifications)->total();

        $notification_res = [];
        foreach ($notification as $value)
        {
            $notification_single = [];
            $notification_single['id'] = !empty($value['id']) ? $value['id'] : '';
            $notification_single['status'] = !empty($value['read_at']) ? 3 : 2;
            $notification_single['send_time'] = !empty($value['created_at']) ? date('Y-m-d H:i:s',strtotime($value['created_at'])) : '';
            if ($value['data']['type'] == 'collect'){
                $notification_single['content'] = "用户".$value['data']['user_name']."收藏了您的作品【".$value['data']['video_title']."】";
            }elseif($value['data']['type'] == 'cancel_collect'){
                $notification_single['content'] = "用户".$value['data']['user_name']."取消收藏了您的作品【".$value['data']['video_title']."】";
            }
            $notification_res[] = $notification_single;
        }
        return response()->json([
            'code' => 200,
            'message' => '查询成功',
            'result' =>[
                'list'  => $notification_res,
                'total' => $total,
            ]
        ]);
    }

    // 一键已读所有通知
    public function read(Request $request)
    {
        Auth::user()->markAsRead();
        return response()->json([
            'code' => 200,
            'message' => '操作成功',
            'result' => [

            ],
        ]);
    }
    // 获取所有未读通知总数
    public function stats(Request $request)
    {
         return response()->json([
                 'code' => 200,
                 'message' => '查询成功',
                 'result' => [
                     'unread_count' => $request->user()->notification_count,
                  ],
         ]);
    }
}
