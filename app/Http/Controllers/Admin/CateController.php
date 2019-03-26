<?php

namespace App\Http\Controllers\Admin;

use App\Model\Cate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CateController extends Controller
{
//    修改排序
    public function changeOrder(Request $request){
//        获取参数
        $input=$request->except('_token');
//        dd($input);
//        通过id获取当前分类
        $cate=Cate::find($input['cate_id']);
//        修改当前分类的排序值
        $res = $cate->update(['cate_order'=>$input['cate_order']]);
        if($res){
            $data=[
                'status'=>0,
                'msg'=>"修改成功"
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>"修改失败"
            ];
        }
//        return $data;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //获取分类数据
        $cate=(new Cate())->tree();
        return view('admin.cate.list',compact('cate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获取一级类
        $cate=Cate::where('cate_pid',0)->get();
        return view('admin.cate.add',compact('cate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //接受添加分类的方法
        $input=$request->except('_token');
//        添加到数据库
        $res=Cate::create($input);
        if($res){
            return redirect('admin/cate');
        }else{
            return back();
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
        $cate=Cate::find($id);
        return view('admin.cate.edit',compact('cate'));
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
        // 获取想要修改的数据
        $input=$request->all();
        $cate=Cate::find($id);
        $cate->cate_name=$input['cate_name'];
        $cate->cate_title=$input['cate_title'];
        $res=$cate->save();
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cate=Cate::find($id);
        $res=$cate->delete();
        if($res){
            $data=[
                'status'=>0,
                'message'=>'删除成功'
            ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'删除失败'
            ];
        }
        return $data;
    }
}
