<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AdminRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthorizationRequest;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;


class AdminsController extends Controller
{
    public function login(AuthorizationRequest $request)
    {
        $username = $request->username;

        filter_var($username, FILTER_VALIDATE_EMAIL) ?
            $credentials['email'] = $username :
            $credentials['phone'] = $username;

        $credentials['password'] = $request->password;

        if (!$token = \Auth::guard('adminapi')->attempt($credentials)) {
            throw new AuthenticationException('用户名或密码错误');
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
        ])->setStatusCode(201);
    }
    public function create(AdminRequest $request)
    {
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
            'admin_type' => $request->admin_type,
            'password' => bcrypt($request->password),
        ]);

        return new AdminResource($admin);
    }
}
