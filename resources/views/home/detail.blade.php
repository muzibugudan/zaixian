@extends('layouts.home')
@section('title','在西安')

@section('banner')
        
@show

@section('main-wrap')
<!-- content srart -->
<div class="am-g am-g-fixed blog-fixed blog-content">
    <div class="am-u-sm-12">
      <article class="am-article blog-article-p">
        <div class="am-article-hd">
          <h1 class="am-article-title blog-text-center">{{ $art->art_title}}</h1>
          @if(session('homeuser'))
          <form action="{{ url('collection') }}" method="get">
          <p class="am-article-meta blog-text-center">
              <span><a href="#" class="blog-color">article &nbsp;</a></span>-
              <span><a href="#">{{ $art->art_editor}} &nbsp;</a></span>-
              <span><a href="#">{{ date('Y-m-d H:i:s',$art->art_time) }}</a></span>
              <input type="hidden" value="{{ $art->art_id}}" name="art_id">
              <span style="margin-left: 20px"><button class="am-btn am-btn-danger" id="my-popover" >+ 点击收藏 </button></span> 
          </p>
          </form>
          @else
          <form action="{{ url('login') }}" method="get">
          <p class="am-article-meta blog-text-center">
              <span><a href="#" class="blog-color">article &nbsp;</a></span>-
              <span><a href="#">{{ $art->art_editor}} &nbsp;</a></span>-
              <span><a href="#">{{ date('Y-m-d H:i:s',$art->art_time) }}</a></span>
              <span style="margin-left: 20px"><button class="am-btn am-btn-danger" id="popover" >+ 登录收藏哦! </button></span> 
          </p>
          </form>
          @endif

        </div>        
        <div class="am-article-bd">
          <img src="{{ $art->art_thumb}}" alt="{{ $art->art_title}}" class="blog-entry-img blog-article-margin" style="width: 1100px;height: 600px"><br>          
        <p class="class="am-article-lead"">
         <span class="blog-color">/{{ $art->art_editor }}</span><br>
          
        {!! $art->art_content !!}
        </p>
        </div>
      </article>
        
        <div class="am-g blog-article-widget blog-article-margin">
          <div class="am-u-lg-4 am-u-md-5 am-u-sm-7 am-u-sm-centered blog-text-center">
            <span class="am-icon-tags"> &nbsp;</span><a href="#">标签</a> , <a href="#">{{ $art->art_tag}}</a> 
            <hr>
            <a href=""><span class="am-icon-qq am-icon-fw am-primary blog-icon"></span></a>
            <a href=""><span class="am-icon-wechat am-icon-fw blog-icon"></span></a>
            <a href=""><span class="am-icon-weibo am-icon-fw blog-icon"></span></a>
          </div>
        </div>

        <hr>
        <div class="am-g blog-author blog-article-margin">
          <div class="am-u-sm-3 am-u-md-3 am-u-lg-2">
            <img src="{{ $art->art_thumb}}" alt="{{ $art->art_title}}" class="blog-author-img am-circle">
          </div>
          <div class="am-u-sm-9 am-u-md-9 am-u-lg-10">
          <h3><span>作者 &nbsp;: &nbsp;</span><span class="blog-color">{{ $art->art_editor }}</span></h3>
            <p>{{ $art->art_description }}</p>
          </div>
        </div>
        <hr>
        <ul class="am-pagination blog-article-margin">
          @if($pre)
          <li class="am-pagination-prev"><a href="{{ url('detail/'.$pre->art_id)}}" class="">&laquo; {{ $pre->art_title}}</a></li>
          @else
          <li class="am-pagination-next"><a href="JavaScript:;">已经到头啦 &raquo;</a></li>
          @endif
          @if($next)
          <li class="am-pagination-next"><a href="{{ url('detail/'.$next->art_id) }}">{{ $next->art_title}} &raquo;</a></li>
          @else
          <li class="am-pagination-next"><a href="JavaScript:;">已经是最后一篇了&raquo;</a></li>
          @endif
        </ul>
        
        <hr>

        <form class="am-form am-g" action="{{ url('comment') }}" method="post" id="commentform">
            <h3 class="blog-comment">评论</h3>
          <fieldset>
            <div class="am-form-group am-u-sm-4 blog-clear-left">
              <input type="text" class="" placeholder="名字" name="author" id="author">
              <!-- <input type="hidden" class=""  name="uid" value="{{ $art->art_id }}"> -->
            </div>
             {{ csrf_field() }}
            <div class="am-form-group am-u-sm-4">
              <input type="email" class="" placeholder="邮箱" name="email" id="email">
            </div>

            <!-- <div class="am-form-group am-u-sm-4 blog-clear-right">
              <input type="password" class="" placeholder="网站">
            </div> -->
        
            <div class="am-form-group">
              <textarea class="" rows="5" placeholder="一字千金" name="comment"></textarea>
            </div>
            <input type="hidden" name="comment_post_ID" value="{{ $art->art_id }}" id="comment_post_ID" />
            <p><button type="submit" class="am-btn am-btn-default">发表评论</button></p>
          </fieldset>
        </form>
        <h3>用户评论</h3>
        
        @foreach($comment as $v)
        <hr>
        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 0px;">{{ $v->content }}</p>
        <p style="margin-bottom:-20px">
        <a class="answer__info--author-name mr5" title="{{ $v->nickname }}" href="https://segmentfault.com/u/zhaoji" style="box-sizing: border-box; background: transparent; color: rgb(0, 154, 97); text-decoration-line: none; outline: 0px; max-width: 8em; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 2px; line-height: 16px; margin-right: 5px !important;">{{ $v->nickname }}</a>&nbsp;
        </p>
        <p>
          <a href="https://segmentfault.com/q/1010000003099229/a-1020000003101218" style="box-sizing: border-box; background: transparent; color: rgb(153, 153, 153); text-decoration-line: none; outline: 0px; font-size: 13px;">{{ date('Y-m-d H:i:s',$v->create_time) }} 评论</a>
        </p>
        @endforeach
    </div>
</div>
<!-- content end -->
@endsection

