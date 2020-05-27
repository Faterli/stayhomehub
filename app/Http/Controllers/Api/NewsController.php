<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Queries\NewsQuery;
use App\Http\Requests\Api\NewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request,  NewsQuery $query)
    {
        $news = $query->paginate();
        $notification = NewsResource::collection($news);
        $total        = NewsResource::collection($news)->total();
        $notification_res = [];
        foreach ($notification as $value)
        {
            $notification_single = [];
            $notification_single['id'] = !empty($value['id']) ? $value['id'] : '';
            $notification_single['status'] = !empty($value['admin_id']) ? 3 : 2;
            $notification_single['send_time'] = !empty($value['created_at']) ? date('Y-m-d H:i:s',strtotime($value['created_at'])) : '';
            $notification_single['content'] = "用户".$value['user']['name']."上传了新的作品【".$value['video']['title']."】，请尽快审核";

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

    // 获取所有未读通知总数
    public function stats(Request $request)
    {
        $num = News::where('admin_id','=','')->count();
        return response()->json([
            'code' => 200,
            'message' => '查询成功',
            'result' => [
                'unread_count' => $num,
            ],
        ]);
    }

}
