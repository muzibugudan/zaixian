<?php

namespace App\Http\Controllers\Admin;

use App\Model\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Role;
class RoleController extends Controller
{
//    显示授权页面
    public function auth($id){
//        获取所有的权限列表
        $perms=Permission::get();
//        获取所有的角色
        $role=Role::find($id);

//        获取当前角色拥有的权限
        $own_perms=$role->permission;
           // dd($own_perms);
//        角色拥有的权限id
            $own_pers=[];
            foreach ($own_perms as $v){
                $own_pers[]=$v->id;
            }
        return view('admin.role.auth',compact('role','perms','own_pers'));
    }

//    处理授权方法
    public function doAuth(Request $request)
    {
        $input=$request->except('_token');
       // dd($input);
//        删除用户已有的权限
        \DB::table('role_permission')->where('role_id',$input['role_id'])->delete();

//        添加新权限
        if(!empty($input['permission_id'])){
            foreach($input['permission_id'] as $v){
                \DB::table('role_permission')->insert(['role_id'=>$input['role_id'],'permission_id'=>$v]);
            }
         }
         return redirect('admin/role');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //获取所有的角色数据
        $role=Role::get();
        // 返回视图
        return view('admin.role.list',compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.role.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  获取表单提交数据
        $input=$request->except('_token');
        // dd($input);
        // 添加到数据库
        $res=Role::create($input);
        if($res){
            return redirect('admin/role');
        }else{
            return back()->with('msg','添加失败');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $role=Role::find($id);
        return view('admin.role.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input=$request->all();
        //1  根据id获取要修改的记录
        $role=Role::find($id);
       
//        2   获取要修改的用户名;
        $role->role_name=$input['role_name'];
        $res=$role->save();
        if($res){
            $data=[
                'status'=>0,
                'msg'=>'修改信息成功',
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'修改信息失败',
            ];
        }
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role=Role::find($id);
        $res=$role->delete();
        if($res){
            $data = [
                'status'=>0,
                'message'=>'删除成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'删除失败'
            ];
        }
        return $data;
    }
   

}
