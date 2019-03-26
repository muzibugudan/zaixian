@extends('layouts.home')
@section('title','在西安')

@section('banner')
        
@show 

@section('main-wrap')
<!-- content srart -->
<div class="am-g am-g-fixed blog-fixed">
    <div class="am-u-md-12 am-u-sm-12">
   
        @foreach($art_col as $n)
            @foreach($n as $v)
            <article class="am-g blog-entry-article">
           
                <div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-img">
                    <img src="{{ $v->art_thumb}}" alt="{{ $v->art_title}}" class="am-u-sm-12" style="width: 600px; height: 300px">
                </div>
                <div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-text">
                    <span><a href="{{ url('detail/'.$v->art_id) }}" class="blog-color">article &nbsp;</a></span>
                    <span>{{ $v->art_editor }} &nbsp;</span>
                    <span>{{ date('Y-m-d',$v->art_time) }}</span>
                    <span class="single-meta-views" style="align-self: right">点击量:<i class="fa fa-fire"></i>&nbsp;{{ $v->art_view }}&nbsp;</span>
                    <h1><a href="{{ url('detail/'.$v->art_id) }}">{{ $v->art_title }}</a></h1>
                    <p>{{ $v->art_description }}</p>
                    <!-- <p><a href="" class="blog-continue">continue reading</a></p> -->
                </div>
             
            </article>
            @endforeach
        @endforeach
        <!-- <ul class="am-pagination">
          <li class="am-pagination-prev"><a href="">&laquo; Prev</a></li>
          <li class="am-pagination-next"><a href="">Next &raquo;</a></li>
        </ul> -->
       
    </div>

</div>
<!-- content end -->
@endsection
