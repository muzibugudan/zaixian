<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Model\User;

class RegisterController extends Controller
{
    // 注册页
    public function emailregister()
    {
    	return view('home.emailregist');
    }

    // 添加注册用户
    public function emailReg(Request $request)
    {
    	// 获取注册用户资料
    	$input=$request->except('_token','user_repass');
    	$input['user_name'] = $input['user_name'];
    	$input['phone'] = $input['phone'];
    	$input['email'] = $input['email'];
    	$input['user_pass'] = Crypt::encrypt($input['user_pass']);  
        $input['token'] = md5($input['email'].$input['user_pass'].'123');
        $input['expire'] = time()+3600*24;

        $user = User::create($input);

        if($user){
        	return redirect('login')->with('active','请先登录邮箱激活账号');
        }else{
        	return redirect('emailregister');
        }
    }
}
