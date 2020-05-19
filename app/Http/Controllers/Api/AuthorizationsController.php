<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use App\Http\Requests\Api\AuthorizationRequest;

class AuthorizationsController extends Controller
{
    public function store(AuthorizationRequest $request)
    {
        $username = $request->username;

        filter_var($username, FILTER_VALIDATE_EMAIL) ?
            $credentials['email'] = $username :
            $credentials['phone'] = $username;

        $credentials['password'] = $request->password;

        if (!$token = \Auth::guard('api')->attempt($credentials)) {
//            throw new AuthenticationException('用户名或密码错误');
            return response()->json([
                'code' => 400,
                'message' => '用户名或密码错误',
                'result' => [
                ],
            ])->setStatusCode(200);
        }

         return response()->json([
                 'code' => 200,
                 'message' => '',
                 'result' => [
                     'user_info' => auth('api')->user(),
                     'access_token' => $token,
                     'token_type' => 'Bearer',
                     'expires_in' => \Auth::guard('api')->factory()->getTTL() * 86400
                  ],
         ]);
    }
    public function update()
    {
        $token = auth('api')->refresh();
         return response()->json([
                 'code' => 200,
                 'message' => '',
                 'result' => [
                     $this->respondWithToken($token)
                  ],
         ]);
    }

    public function destroy()
    {
        auth('api')->logout();
         return response()->json([
                 'code' => 200,
                 'message' => '登出成功',
                 'result' => [

                  ],
         ]);
    }
    //腾讯云api签名生成
    public function signature(Request $request)
    {
        // tx云 API 密钥
        $secret_id = env('VOD_TXYUN_ACCESS_ID');
        $secret_key = env('VOD_TXYUN_ACCESS_KEY');

        // 确定签名的当前时间和失效时间
        $current = time();
        $expired = $current + 86400;  // 签名有效期：1天

        // 向参数列表填入参数
        $arg_list = array(
            "secretId" => $secret_id,
            "currentTimeStamp" => $current,
            "expireTime" => $expired,
            "random" => rand());

        // 计算签名
        $original = http_build_query($arg_list);
        $signature = base64_encode(hash_hmac('SHA1', $original, $secret_key, true).$original);


        return response()->json([
            'code' => 200,
            'message' => '获取成功',
            'result' =>$signature


        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

}
