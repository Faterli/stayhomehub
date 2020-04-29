<?php

use Illuminate\Http\Request;

Route::prefix('v1')->namespace('Api')->name('api.v1.')->group(function () {
    // 短信验证码
    Route::post('user/code', 'VerificationCodesController@store')
        ->name('verificationCodes.store');
});
