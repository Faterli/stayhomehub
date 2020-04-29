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
            });

        Route::middleware('throttle:' . config('api.rate_limits.access'))
            ->group(function () {

            });
    });
