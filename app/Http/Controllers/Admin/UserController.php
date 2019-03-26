<?php

namespace App\Http\Controllers\Admin;

use App\Model\Permission;
use App\Model\Role;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
//    用户角色授予
    public function auth($id)
    {
//        获取所有角色
        $role=Role::get();
//        获取当前用户
        $user=User::find($id);
//        获取当前用户拥有的角色
        $own_role=$user->role;
        $own_roles=[];
        foreach ($own_role as $v){
            $own_roles[]=$v->id;
        }
        return view('admin.user.auth',compact('user','role','own_roles'));
    }

//    用户角色修改
    public function doAuth(Request $request)
    {
        $input=$request->except('_token');
//        dd($input);
//        删除用户已有的角色
        \DB::table('user_role')->where('user_id',$input['user_id'])->delete();

//        添加新角色
        if(!empty($input['role_id'])){
            foreach($input['role_id'] as $v){
                \DB::table('user_role')->insert(['user_id'=>$input['user_id'],'role_id'=>$v]);
            }
        }
        return redirect('admin/user');
    }
    /**
     * 获取用户列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //1  获取表单提交的数据
        $user=User::orderBy('user_id','asc')
            ->where(function($query) use ($request)
            {
                $username=$request->input('username');
                $email=$request->input('email');
                if(!empty($username)){
                    $query->where('user_name','like','%'.$username.'%');
                }
                if(!empty($email)){
                    $query->where('email','like','%'.$email.'%');
                }
            })
            ->paginate($request->input('num')?$request->input('num'):3);
//        $user=User::paginate(3);
        return view('admin.user.list',compact('user','request'));
    }

    /**
     * 用户添加页面
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.user.add');
    }

    /**
     * 执行添加操作
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return 111;
        //1 接受表单提交的数据
        $input=$request->all();

//        2 进行表单验证
        $username=$input['email'];
        $pass=Crypt::encrypt($input['pass']);
        $res=User::create(['user_name'=>$username,'user_pass'=>$pass,'email'=>$input['email']]);
//        3 添加到数据库

//        4 根据添加是否成功,给客户端返回json格式的反馈
        if($res){
            $data=[
                'status'=>0,
                'message'=>'添加成功',
            ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'添加失败',
            ];
        }
        return $data;
    }

    /**
     * 显示一条用户数据
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 返回修改页面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::find($id);
        return view('admin.user.edit',compact('user'));
    }

    /**
     * 执行修改操作
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //1  根据id获取要修改的记录
        $user=User::find($id);
//        2   获取要修改的用户名;
        $username=$request->input('user_name');
        $user->user_name=$username;
        $res=$user->save();
        if($res){
                $data=[
                    'status'=>0,
                    'message'=>'修改信息成功',
                ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'修改信息失败',
            ];
        }
        return $data;
    }

    /**
     * 执行删除操作
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user=User::find($id);
        $res=$user->delete();
        if($res){
            $data=[
                'status'=>0,
                'message'=>'删除信息成功',
            ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'删除信息失败功',
            ];
        }
        return $data;
    }

//    删除选中用户
    public function delAll(Request $request){
        $input=$request->input('ids');

        $res=User::destroy($input);
        if($res){
            $data=[
                'status'=>0,
                'message'=>'删除信息成功',
            ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'删除信息失败功',
            ];
        }
        return $data;
    }
}
