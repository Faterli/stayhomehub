<?php

namespace App\Http\Controllers\Api;

use App\Http\Queries\AdminQuery;
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
                'user_info' => auth('adminapi')->user(),
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => \Auth::guard('adminapi')->factory()->getTTL() * 600
            ],
        ]);
    }
    public function index(Request $request,  AdminQuery $query)
    {
        $admin = $query->paginate();

        return response()->json([
            'code' => 200,
            'message' => '查询成功',
            'result' => [
                AdminResource::collection($admin)
            ],
        ]);
    }

    public function store(AdminRequest $request)
    {
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
            'admin_type' => $request->admin_type,
            'password' => bcrypt($request->password),
        ]);
        return response()->json([
            'code' => 200,
            'message' => '添加成功',
            'result' => [
                new AdminResource($admin)
            ],
        ]);
    }
    public function logout()
    {
        auth('adminapi')->logout();
        return response()->json([
            'code' => 200,
            'message' => '登出成功',
            'result' => [

            ],
        ]);
    }

    //修改
    public function update(AdminRequest $request, Admin $admin)
    {


        $admin->update($request->all());
        $info = new AdminResource($admin);
        return response()->json([
            'code' => 200,
            'message' => '修改成功',
            'result' => $info,
        ]);
    }
    //删除
    public function destroy(Admin $admin)
    {

        $admin->delete();

        return response()->json([
            'code' => 200,
            'message' => '删除成功',
            'result' => [
            ],
        ]);
    }

    //详情
    public function show($adminId, AdminQuery $query)
    {
        $admin = $query->findOrFail($adminId);
        return new AdminResource($admin);
    }
}
