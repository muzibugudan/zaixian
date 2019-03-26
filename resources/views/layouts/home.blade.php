<!doctype html>
<html>
<head>
  @include('home.public.meta')
  <title>@yield('title')</title>
  @include('home.public.styles')
  @include('home.public.script')
</head>
<body id="blog" bgcolor="#D2B48C">

    @section('subject','我帮你 读懂西安这座城') 
    <!-- nav start -->
        @include('home.public.header')
    <!-- nav start -->

    <!-- nav start -->
        <!-- 导航条 -->

        @include('home.public.nav')
    <!-- nav end -->

    <!-- 轮播图 -->
    <!-- banner start -->
    @section('banner')
        @include('home.public.banner')
     @show 
        
    <!-- banner end -->

    <!-- content srart -->
    @section('main-wrap')
    
     @show  
    <!-- content end -->

    <!---footer start -->
        @include('home.public.footer')
    <!---footer end -->
    
</body>
</html>