@extends('layouts.home')
@section('title','西安角落')

  @section('banner')

  @show 

@section('main-wrap')
<!-- content srart -->
<div class="am-g am-g-fixed blog-fixed blog-content">
  <figure data-am-widget="figure" class="am am-figure am-figure-default" data-am-figure="{  pureview: 'true' }">
      <div id="container">   
        @foreach($cate_img as $v)       
        <div><img src="{{ $v->img_thumb}}" alt="{{ $v->img_title}}"><h3>{{ $v->img_title}}</h3>{{ $v->img_description}}</div>
        
        @endforeach
      </div> 
  </figure>

</div>
<!-- content end -->
@endsection
        