<?php

namespace App\Http\Controllers\Admin;

use App\Model\Article;
use App\Model\Cate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;;
use Image;
use Redis;
use Storge;


class ArticleController extends Controller
{

    // 将markdown语法转化成html语法内容
    public function pre_mk(Request $request)
    {
        return Markdown::converToHtml($request->cont);
    }
//    文件上传
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

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $arts=[];
//        $art=Article::get();
////        所有文章id
//        $listkey='LIST:ARTICLE';
////        所有文章内容
//        $hashkey='HASH:ARTICLE:';
//        if(Redis::exists($listkey)){
////            存放所有要获取文章的id
//            $lists=Redis::lrange($listkey,0,-1);
//            foreach ($lists as $k=>$v){
//                $arts=Redis::hgetall($hashkey.$v);
//            }
//        }else{
////            连接数据库  获取数据
//              $arts = Article::get()->toArray();
////            将数据存入redis
//            foreach ($arts as $v){
////                将文章的id存放到listkey中
//                Redis::rpush($listkey,$v['art_id']);
////                将文章添加到hsahkey中
//                Redis::hmset($hashkey.$v['art_id'],$v);
//            }
//
////            将数据返回
//
//        }
        $arts = Article::orderBy('art_id','desc')->join('category',function($join){
            $join->on('article.cate_id','=','category.cate_id');
        })->paginate(7);
        
       return view('admin.article.list',compact('arts','cate_name','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $cates= (new Cate)->tree();
        return view('admin.article.add',compact('cates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $listkey = 'LIST:ARTICLE';
        // $hashkey = 'HASH:ARTICLE:';

        $input = $request->except('_token','photo');
        //添加时间
        $input['art_time'] = time();
        $input['art_view'] = 0;
        $input['art_status'] = 0;

        // 将提交的文章数据保存到数据库

        $res = Article::create($input);

        if($res){
// //            如果添加成功，更新redis
//             \Redis::rpush($listkey,$res->art_id);
//             \Redis::hMset($hashkey.$res->art_id,$res->toArray());

            return redirect('admin/article');
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
        $cates = (new Cate)->tree();
        $arts=Article::find($id);
        return view('admin.article.edit',compact('arts','cates'));
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
        $art = Article::find($id);
        // 获取要修改的内容
       $input = $request->except('artid','_token','phote');
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
        $res=Article::find($id)->delete();

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

    // 批量选中删除
    public function delAll(Request $request)
    {

        $input = $request->input('ids');
        dd($input);

        // $res = Article::destroy($input);

        // if($res){
        //     $data = [
        //         'status'=>0,
        //         'message'=>'删除成功'
        //     ];
        // }else{
        //     $data = [
        //         'status'=>1,
        //         'message'=>'删除失败'
        //     ];
        // }
        // return $data;
    }
  

}
