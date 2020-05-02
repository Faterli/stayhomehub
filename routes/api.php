<?php

use Illuminate\Http\Request;

Route::prefix('v1')
    ->namespace('Api')
    ->name('api.v1.')
    ->group(function () {

        Route::middleware('throttle:' . config('api.rate_limits.sign'))
            ->group(function () {
                // 短信验证码
                Route::post('user/code', 'VerificationCodesController@store')
                    ->name('verificationCodes.store');
                // 用户注册
                Route::post('user/register', 'UsersController@store')
                    ->name('users.store');
                // 找回密码
                Route::post('user/update/pwd', 'UsersController@repassword')
                    ->name('users.repassword');
                // 修改手机号
                Route::post('user/update/phone', 'UsersController@rephone')
                    ->name('users.rephone');
                // 登录
                Route::post('/user/login', 'AuthorizationsController@store')
                    ->name('api.authorizations.store');
                // 刷新token
                Route::put('/user/current', 'AuthorizationsController@update')
                    ->name('authorizations.update');
                // 删除token
                Route::delete('/user/logout', 'AuthorizationsController@destroy')
                    ->name('authorizations.destroy');
                //用户检测（手机号是否已注册）
                Route::post('/user/check', 'VerificationCodesController@check')
                    ->name('verificationCodes.check');
            });

        Route::middleware('throttle:' . config('api.rate_limits.access'))
            ->group(function () {

            });
    });
