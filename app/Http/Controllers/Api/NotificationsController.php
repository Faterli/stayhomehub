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

        return NotificationResource::collection($notifications);
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
