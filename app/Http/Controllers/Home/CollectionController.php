<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Collection;
use App\Model\Article;

class CollectionController extends Controller
{
	// 文章收藏
    public function collection(Request $request)
    {
    	// 获取文章id和用户id
    	$art_id=$request->input('art_id');
    	$res=$request->session()->get('homeuser');
    	$user_id=$res['user_id'];

    	// 将数据存入
    	$res=Collection::create(['user_id'=>$user_id,'art_id'=>$art_id]);

    	if($res){
    		return back();
    	}else{

    	}
    }

  

}
