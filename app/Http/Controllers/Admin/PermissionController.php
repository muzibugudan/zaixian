<?php

namespace App\Http\Controllers\Admin;

use App\Model\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //获取所有权限路由
        $perms=Permission::get();
//        dd($input);
        return view('admin.permission.list',compact('perms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permission.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //接受数据
        $input=$request->except('_token');
        $res=Permission::create($input);
        if($res){
            return redirect('admin/permission');
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
        $per=Permission::find($id);
        return view('admin.Permission.edit',compact('per'));
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
        // 获取想要修改的id
        $per=Permission::find($id);
        // 获取表单提交的内容
        $per->per_name=$input['per_name'];
        $per->per_url=$input['per_url'];
        $res=$per->save();
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
        // 获取要删除的数据
       $per= permission::find($id);
       $res=$per->delete();
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
