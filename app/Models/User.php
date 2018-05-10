<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);    // 一对多关系
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;    // 检查模型对应的user_id是否是当前登录系统的id
    }

    // 和回复模块的一对多关系
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
