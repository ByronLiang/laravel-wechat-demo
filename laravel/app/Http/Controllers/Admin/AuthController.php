<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\LoginRequest;

class AuthController extends Controller
{
    public function postLogin(LoginRequest $request)
    {
        if (auth()->attempt($request->getData(), $request->get('remember'))) {
            return \JSend::success(auth()->user());
        }
        return \JSend::error('账号或者密码错误');
    }
}
