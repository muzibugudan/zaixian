<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Model\User;

class LoginController extends Controller
{
    // 邮箱登陆页
    public function login()
    {
    	return view('home.login');
    }

    // 邮箱验证登录
    public function doLogin(Request $request)
    {
    	// 获取邮箱和密码
    	$input=$request->except('_token');
    	$user_name=$input['user_name'];
    	$password=$input['password'];

    	// 验证用户是否存在
    	$user = User::where('user_name',$user_name)->first();
    	if(empty($user)){
    		return redirct('login')->with('errors','用户名不存在');
    	}

    	// 验证密码
    	if($password !=  Crypt::decrypt($user->user_pass) ){
            return redirect('login')->with('errors','密码不对');
        }

        // 成功
        session()->put('homeuser',$user);

        return redirect('index');
    }

    //退出登录
    public function loginOut()
    {
        session()->forget('homeuser');
        setcookie('password', "",time()-1);
        return redirect('index');
    }

    // 加密算法
    public function jiami()
    {
    	 $str = 'admin';
    	 return  Crypt::encrypt($str);
    	 $Crypt='eyJpdiI6ImQ3Z1hMd1RZampmempjTVVMZkRnT2c9PSIsInZhbHVlIjoiTHp3Z1B5MHBzcEJ2S1VDMEl2V3R3dz09IiwibWFjIjoiYTg5MDZmMmU1OTYwYmQ5ZTc3NDU5NGVhZmFhOGFjNWFkYzBkZWVhZTJhZDdhY2Y4ZTQwMWE0YWFhZTUzN2YyYSJ9';
    }
}
