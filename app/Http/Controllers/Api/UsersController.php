<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Api\UserRequest;

class UsersController extends Controller
{
    //
    public function store(UserRequest $request)
    {
        // 取出缓存中对应键名的验证码
        $verifyData = \Cache::get($request->verification_key);

        // 如果没有即验证码已经失效
        if (!$verifyData) {
            return $this->response->error('验证码已失效', 422);
        }

        // 校验缓存中的验证码和传入的验证码是否匹配
        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            // 返回401
            return $this->response->errorUnauthorized('验证码错误');
        }

        // 创建用户
        $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password),
        ]);

        // 清除验证码缓存
        \Cache::forget($request->verification_key);

        return $this->response->created();
    }
}
