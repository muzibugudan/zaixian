<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Org\code\Code;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;

class LoginController extends Controller
{
    //后台登录页
    public function login()
    {
        return view('admin.login');
    }
//    验证码
    public function code()
    {
        $code=new Code;

        return $code->make();
    }
//    后台表单验证
    public function doLogin(Request $request)
    {

//        1 接受表单提交到的数据
        $input=$request->except('_token');


//        2 进行表单验证
        $rule=[
            'username'=>'required|between:4,18',
            'password'=>'required|between:4,18|alpha_dash',
        ];
        $msg=[
            'username.required'=>'用户名必须输入',
            'username.between'=>'用户名长度必须在4-18位之间',
            'password.required'=>'密码必须输入',
            'password.between'=>'密码长度必须在4-18位之间',
            'password.alpha_dash'=>'密码必须是数字字母下划线',
        ];

        $validator = Validator::make($input,$rule,$msg);
        if ($validator->fails()) {
            return redirect('admin/login')
                ->withErrors($validator)
                ->withInput();
        }
//        3 验证是否有此用户(用户名,密码,验证码)
//            验证码
            if(strtolower($input['code'])!=strtolower(session()->get('code'))){
                return redirect('admin/login')->with('errors','验证码错误');
            }
//            用户名
           $user= User::where('user_name',$input['username'])->first();
            if(!$user){
                return redirect('admin/login')->with('errors','用户名为空');
            }
//            密码
            if($input['password'] != Crypt::decrypt($user->user_pass)){
                return redirect('admin/login')->with('errors','密码错误');

            }
////        4 保存用户信息到session中
            session()->put('user',$user);
////        5跳转打后台页面
           return redirect('admin/index');
    }
//    加密算法
    public function jiami()
    {
//        1 md5加密 生成一个32位字符串
//        $str='123456';
//        return md5($str);
//        2 哈希加密  生成65位字符串
//        $str='123456';
//        $hash= Hash::make($str);
//        return $hash
//        if(Hash::check($str,$hash)){
//            return '密码正确';
//        }else{
//            return '密码错误';
//        }
//        3 crypt加密  生成255位字符串
        $str='admin';
        $str_crypt=Crypt::encrypt($str);
       return $str_crypt;
        $crypt_str='eyJpdiI6ImpjejYwd1Y4WldEQWxpT2QzOHY4akE9PSIsInZhbHVlIjoiUStoNFpJNDdHXC8wNEROZ2RBUjBSbkE9PSIsIm1hYyI6Ijc5OWNmNzlmODMzODRjMTA2ZjBhNTk4YjIyYWE4ZTg2ZTkyMDJjZTk3ZTc0MmMzYmU3YWE1ZjUzMGZmOGRhOGEifQ';
        if(Crypt::decrypt($crypt_str)==$str){
            return '密码正确';
        }
    }
//    后台首页
    public function index()
    {
        return view('admin.index');
    }
//    后台欢迎页
    public function welcome()
    {
        return view('admin.welcome');
    }
//    后台退出
    public function logout()
    {
//        清空session中的用户信息
        session()->flush();
//        跳转到登录页面
         return redirect('admin/login');
    }
//    没有权限的路由
    public function noaccess()
    {
        return view('errors.noaccess');
    }
}


