<?php

use Illuminate\Http\Request;

Route::prefix('v1')
    ->namespace('Api')
    ->name('api.v1.')
    ->group(function () {
        //管理员
        //登录
        Route::get('admin/login', 'AdminsController@login')
            ->name('api.admins.store');
        // 登出
        Route::delete('admin/logout', 'AdminsController@logout')
            ->name('api.admins.logout');
        // CURD
        Route::resource('admin', 'AdminsController')->only([
            'index','store', 'update', 'destroy', 'show'
        ]);


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
                // 游客可以访问的接口
                //轮播图 列表页，详情页
                Route::resource('banner', 'BannersController')->only([
                    'index', 'show'

                ]);
                //视频列表页，详情页
                Route::resource('video', 'VideoController')->only([
                    'index', 'show'
                ]);
                // 某个用户的详情
                Route::get('users/{user}', 'UsersController@show')
                    ->name('users.show');
                // 某个用户的详情
                Route::get('rank', 'MetasController@rank')
                    ->name('metas.rank');
                // 上传图片
                Route::post('adminimages', 'ImagesController@store_admin')
                    ->name('images.store_admin');

                // 登录后可以访问的接口
                Route::middleware('auth:api')->group(function() {
                    // 当前登录用户信息
                    Route::get('user/details', 'UsersController@me')
                        ->name('user.show');
                    // 编辑登录用户信息
                    Route::patch('user/update/info', 'UsersController@update')
                        ->name('user.update');
                    // 上传图片
                    Route::post('images', 'ImagesController@store')
                        ->name('images.store');
                    // 修改手机号
                    Route::put('user/update/phone', 'UsersController@rephone')
                        ->name('users.rephone');

                    //上传、修改、删除视频CURD
                    Route::resource('video', 'VideoController')->only([
                        'index', 'store', 'update', 'destroy', 'show'
                    ]);

                    //足迹点赞收藏接口
                    Route::resource('meta', 'MetasController')->only([
                        'index', 'store',
                    ]);
                });

                // 后台登录后可以访问的接口
                Route::middleware('auth:adminapi')->group(function() {
                    //轮播图 CURD
                    Route::resource('banner', 'BannersController')->only([
                        'store', 'update', 'destroy',
                    ]);

                });

                // 分类列表
                Route::get('/column/home/list', 'CategoriesController@index')
                    ->name('categories.index');
                // 查看某个用户发布的视频
                Route::get('users/{user}/video', 'VideoController@userIndex')
                    ->name('users.video.index');
            });
    });
