@extends('layouts.home')
@section('title','在西安')

@section('main-wrap')
    <div class="am-g am-g-fixed blog-fixed">
        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span><h3>精彩特推</h3>
        
        <div class="am-u-md-8 am-u-sm-12">
            @foreach($cate_arts as $m=>$n)
            <article class="am-g blog-entry-article">
                <a href="{{ url('/detail/'.$n->art_id) }}">
                    <div class="am-u-lg-5 am-u-md-12 am-u-sm-12 blog-entry-img">
                    <img src="{{ $n->art_thumb }}" alt="{{ $n->art_title }}" class="am-u-sm-12" style="width: 300px;height: 150px">
                    </div>
                </a>
                <div class="am-u-lg-7 am-u-md-12 am-u-sm-12 blog-entry-text">
                    <span><a href="" class="blog-color">article &nbsp;</a></span>
                    <span> {{ $n->art_editor }} &nbsp;</span>
                    <span>{{ date('Y-m-d H:i:s',$n->art_time) }}</span>
                    <span class="single-meta-views" style="align-self: right">点击量:<i class="fa fa-fire"></i>&nbsp;{{ $n->art_view }}&nbsp;</span>
                    <h1><a href="{{ url('/detail/'.$n->art_id) }}">{{ $n->art_title }}</a></h1>
                    <p>{{ $n->art_description }}</p>
                </div>
            </article>
            @endforeach
            <!-- <ul class="am-pagination">
              <li class="am-pagination-prev"><a href="">&laquo; Prev</a></li>
              <li class="am-pagination-next"><a href="">Next &raquo;</a></li>
            </ul> -->
            <div class="page" style="margin-bottom: 20px">
               {!! $cate_arts->appends($request->all())->render() !!}
            </div>
        </div>

        <!-- 右侧边栏 start -->
            @include('home.public.aside')
        <!-- 右侧边栏 end --> 
    </div>
@endsection