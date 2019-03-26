<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Image;

class ImageController extends Controller
{
      // 文件上传
    public function upload(Request $request)
    {
        $file=$request->file('photo');
//        判断长传文件是否有效
       if(!$file->isValid()){
            return response()->json(['ServerNo'=>'400','ResultData'=>'无效的上传文件']);
       }
//       获取源文件的扩展名
        $ext = $file->getClientOriginalExtension();
//       生成新文件名
        $newfile=md5(time().rand(1000,9999)).'.'.$ext;
//        文件上传的指定路径
        $path=public_path('uploads');
//       将文件从临时目录移动到制定目录
        if(!$file->move($path,$newfile)){
            return response()->json(['ServerNo'=>'400','ResultData'=>'保存文件失败']);
        }

        return response()->json(['ServerNo'=>'200','ResultData'=>$newfile]);
//        $res=Image::make($file)->resize(100,100)->save($path.'/'.$newfile);

       // if($res){
       //     return response()->json(['ServerNo'=>'200','ResultData'=>$newfile]);
       // }else{
       //     return response()->json(['ServerNo'=>'400','ResultData'=>'保存文件失败']);
       // }
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $imgs=Image::orderBy('img_id','asc')->paginate(5);
        return view('admin.image.list',compact('imgs','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //返回添加页面
        return view('admin.image.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $input = $request->except('_token','photo');
        //添加时间
        $input['img_time'] = time();
        // 数据保存
        $res = Image::create($input);

        if($res){
//            如果添加成功，更新redis
//             \Redis::rpush($listkey,$res->art_id);
//             \Redis::hMset($hashkey.$res->art_id,$res->toArray());

            return redirect('admin/image');
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
        $imgs=Image::find($id);
        return view('admin.image.edit',compact('imgs'));
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
        // 获取要修改的id记录
        $art = Image::find($id);
        // 获取要修改的内容
       $input = $request->except('img_id','_token','art_thumb');
       // dd($input);
//        使用模型修改表记录的两种方法,方法一
        $res = $art->update($input);

        if($res){
            $data = [
                'status'=>0,
                'msg'=>'修改成功'
            ];
        }else{
//            return 2222;
            $data = [
                'status'=>1,
                'msg'=>'修改失败'
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
        $res=Image::find($id)->delete();

        if($res){
            $data=[
                'status'=>0,
                'message'=>'删除成功'
            ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'删除成功'
            ];
        }

        return $data;
    }
}
