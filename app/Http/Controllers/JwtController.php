<?php

namespace App\Http\Controllers;

use App\Common\Auth\JwtAuth;
use Illuminate\Http\Request;

class JwtController extends Controller
{

    public  function  Login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        //去数据库或者缓存中查找用户信息
        $token  = JwtAuth::getInstance()->setUid('1')->encode()->getToken();
        return response()->json(['code'=>0,'msg'=>'success','token'=>$token]);
    }
}
