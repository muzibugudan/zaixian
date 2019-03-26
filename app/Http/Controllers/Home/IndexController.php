<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Cate;
use App\Model\Article;
use App\Model\Image;
use App\Model\Comment;
use App\Model\Collection;

class IndexController extends CommonController
{
    //前台首页
    public function index(Request $request)
    {
    	//获取相关二级类及二级类下的文章
        $cate_arts = Article::orderBy('art_id','desc')
                ->where('cate_id',28)
                ->paginate(5);
        // dd($cate_arts);
        $art_host=Article::orderBy('art_id','desc')
                 ->where('cate_id',24)
                 ->paginate(5);
    	return view('home.index',compact('cate_arts','art_host','request'));
    }
    public function detail(Request $request,$id)
    {
    	//文章的查看次数+1
        \DB::table('article')
            ->where('art_id', $id)
            ->increment('art_view');

        $art = Article::with('cate')->where('art_id',$id)->first();

//        上一篇 下一篇
//        1 2 5  6 7 8
        $pre = Article::where('art_id','<',$id)->orderBy('art_id','desc')->first();
//        dd($pre);

        $next = Article::where('art_id','>',$id)->orderBy('art_id','asc')->first();


//        相关文章
        $similar = Article::where('cate_id',$art->cate_id)->take(4)->get();

//        文章评论
        $comment = Comment::where('post_id',$art->art_id)->get();
        return view('home.detail',compact('art','pre','next','similar','comment'));
    }
    public function lists(Request $request,$id)
    {
        //        获取分类
        $cate = Cate::find($id);

        $cateid = $cate->cate_id;

        $catename = $cate->cate_name;
//        dd($catename);
        $arr = [];
        if($cate->cate_pid == 0){
            $cate = Cate::where('cate_pid',$cate->cate_id)->get();
            //存放分类id的数组
            $arr = [];
            foreach ($cate as $v){
                $arr[] = $v->cate_id;
            }
        }else{
            $arr[] = $cate->cate_id;
        }
        //获取分类下的文章
        $arts = Article::whereIn('cate_id',$arr)->paginate(3);

        return view('home.lists',compact('catename','cateid','arts','request'));
    }
   
    public function jiaoluo(Request $request)
    {
        $cate_img=Image::orderBy('img_id','desc')->where('cate_id',1)->get();
       
        return view('home.img',compact('cate_img'));
    }

    public function sanqin(Request $request)
    {

    }

    public function comment(Request $request)
    {
        $input = $request->all();
        $input['create_time'] = time();
        $res = Comment::create(['nickname'=>$input['author'],'content'=>$input['comment'],'post_id'=>$input['comment_post_ID'],
            'create_time'=>$input['create_time']]);

        if($res){
            return redirect('detail/'.$input['comment_post_ID']);
        }else{

            return redirect('detail/'.$input['comment_post_ID']);
        }
    }

      // 个人收藏页
    public function precollection(Request $request)
    {
        // 获取用户id
        $res=$request->session()->get('homeuser');
        $user_id=$res['user_id'];
        
        // 读取用户收藏文章的id
        $arts=Collection::where(['user_id'=>$user_id])->get(['art_id']);
        $own_arts=[];
        foreach($arts as $v){
            $own_arts[]=$v->art_id;

        }
      
        // 获取文章
        $art_col=[];
        foreach ($own_arts as $v) {
             $art_col[]=Article::orderBy('art_id','asc')
                 ->where(['art_id'=>$v])->get();
            
        }
       // dd($art_col);
       // dd($art_col->art_title);

        
        return view('home.collection',compact('art_col'));
    }
}
