<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Requests\Api\UserRequest;
use App\Http\Requests\Api\RepasswordRequest;
use App\Http\Requests\Api\VerificationCodeRequest;
use Illuminate\Auth\AuthenticationException;
use Zttp\Zttp;

class UsersController extends Controller
{
    public function store(UserRequest $request)
    {
        $verifyData = \Cache::get($request->verification_key);

        if (!$verifyData) {
            abort(403, '验证码已失效');
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            // 返回401
            throw new AuthenticationException('验证码错误');
        }
        $response = Zttp::withHeaders(['Accept' => 'application/json'])
            ->get('http://shibe.online/api/shibes', []);
        $avatar = $response->json();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password),
            'avatar' => $avatar[0]??'',
        ]);

        // 清除验证码缓存
        \Cache::forget($request->verification_key);

        return new UserResource($user);
    }
    //重置密码
    public function repassword(RepasswordRequest $request)
    {
        $verifyData = \Cache::get($request->verification_key);

        if (!$verifyData) {
            abort(403, '验证码已失效');
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            // 返回401
            throw new AuthenticationException('验证码错误');
        }
        $user = User::where('phone', $verifyData['phone'])
                ->update(['password' => bcrypt($request->password)]);

        // 清除验证码缓存
        \Cache::forget($request->verification_key);

        if($user){
            return response()->json([
                'code' => 0,
                'message' => '密码重置成功',
                'data' => [true],
            ])->setStatusCode(201);
        }else{
            return response()->json([
                'code' => 0,
                'message' => '重置失败',
                'data' => [$user],
            ])->setStatusCode(201);
        }
    }
    //修改手机号
    public function rephone(VerificationCodeRequest $request)
    {
        $verifyData = \Cache::get($request->verification_key);

        if (!$verifyData) {
            abort(403, '验证码已失效');
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            // 返回401
            throw new AuthenticationException('验证码错误');
        }
        $user = $request->user();

        $attributes = $request->only(['phone']);

        $user->update($attributes);

        $res = new UserResource($user);

        // 清除验证码缓存
        \Cache::forget($request->verification_key);

        if($res){
            return response()->json([
                'code' => 0,
                'message' => '手机号修改成功',
                'data' => [true],
            ])->setStatusCode(201);
        }else{
            return response()->json([
                'code' => 0,
                'message' => '修改失败',
                'data' => [$res],
            ])->setStatusCode(201);
        }
    }

    public function show(User $user, Request $request)
    {
        return new UserResource($user);
    }

    public function me(Request $request)
    {
        return new UserResource($request->user());
    }
    public function update(UserRequest $request)
    {
        $user = $request->user();

        $attributes = $request->only(['gender', 'birthday']);

        if(!empty($attributes['birthday'])){
            $attributes['birthday'] = strtotime($attributes['birthday']);
        }
        if ($request->avatar_image_id) {
            $image = Image::find($request->avatar_image_id);

            $attributes['avatar'] = $image->path;
        }
        $user->update($attributes);

        return (new UserResource($user));
    }
}
