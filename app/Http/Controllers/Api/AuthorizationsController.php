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
            throw new AuthenticationException('用户名或密码错误');
        }

         return response()->json([
                 'code' => 200,
                 'message' => '',
                 'result' => [
                     'user_id' => auth('api')->id(),
                     'access_token' => $token,
                     'token_type' => 'Bearer',
                     'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
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
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
