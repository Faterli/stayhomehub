<?php

namespace App\Models;


use Auth;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;

class User extends Authenticatable implements MustVerifyEmailContract, JWTSubject
{
    use MustVerifyEmailTrait;

    use Notifiable {
        notify as protected laravelNotify;
    }
    public function notify($instance)
    {
    // 如果要通知的人是当前用户，就不必通知了!
    if ($this->id == auth('api')->id()) {
        return; }
    // 只有数据库类型通知才需提醒，直接发送 Email 或者其他的都 Pass

    if (method_exists($instance, 'toDatabase'))
    {
        $this->increment('notification_count');
    }

    $this->laravelNotify($instance);
    }


    protected $fillable = [
        'name', 'email', 'phone', 'password','avatar','gender','birthday'
    ];

    public function video()
    {
        return $this->hasMany(Video::class);
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

}
