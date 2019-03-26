<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>在西安 | 登录</title>

  <!-- Set render engine for 360 browser -->
  <meta name="renderer" content="webkit">

  <!-- No Baidu Siteapp-->
  <meta http-equiv="Cache-Control" content="no-siteapp"/>

  <link rel="icon" type="image/png" href="assets/i/favicon.png">

  <!-- Add to homescreen for Chrome on Android -->
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="icon" sizes="192x192" href="assets/i/app-icon72x72@2x.png">

  <!-- Add to homescreen for Safari on iOS -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="Amaze UI"/>
  <link rel="apple-touch-icon-precomposed" href="assets/i/app-icon72x72@2x.png">

  <!-- Tile icon for Win8 (144x144 + tile color) -->
  <meta name="msapplication-TileImage" content="assets/i/app-icon72x72@2x.png">
  <meta name="msapplication-TileColor" content="#0e90d2">

  <!-- SEO: If your mobile URL is different from the desktop URL, add a canonical link to the desktop page https://developers.google.com/webmasters/smartphone-sites/feature-phones -->
  <!--
  <link rel="canonical" href="http://www.example.com/">
  -->
  @include('home.public.styles')
</head>
<body>
<header>
  <div class="log-header">
      <h1><a href="/">在 西安</a> </h1>
  </div>    
  <div class="log-re">
    <a href="/emailregister"><button type="button" class="am-btn am-btn-default am-radius log-button">注册</button></a>
  </div> 
</header>

<div class="log"> 
  <div class="am-g">
  <div class="am-u-lg-3 am-u-md-6 am-u-sm-8 am-u-sm-centered log-content">
    <h1 class="log-title am-animation-slide-top">在西安</h1>
    <br>
    <form class="am-form" id="log-form" action="{{ url('dologin') }}" method="post">
      {{ csrf_field() }}
      @if(session('errors'))
           <script></script>
        @endif

        @if(session('active'))
            <p style="color:red;">{{ session('active') }}</p>
        @endif
      <div class="am-input-group am-radius am-animation-slide-left">       
        <input type="text" name="user_name" id="doc-vld-user-2-1" class="am-radius" data-validation-message="请输入用户名" placeholder="用户名" required/>
        <span class="am-input-group-label log-icon am-radius"><i class="am-icon-user am-icon-sm am-icon-fw"></i></span>
      </div>      
      <br>
      <div class="am-input-group am-animation-slide-left log-animation-delay">       
        <input type="password" class="am-form-field am-radius log-input" placeholder="密码" minlength="3" required name="password">
        <span class="am-input-group-label log-icon am-radius"><i class="am-icon-lock am-icon-sm am-icon-fw"></i></span>
      </div>      
      <br>
      <button type="submit" class="am-btn am-btn-primary am-btn-block am-btn-lg am-radius am-animation-slide-bottom log-animation-delay">登 录</button>
            <p class="am-animation-slide-bottom log-animation-delay"><a href="#">忘记密码?</a></p>
      <div class="am-btn-group  am-animation-slide-bottom log-animation-delay-b">
      <p>使用第三方登录</p>
      <a href="#" class="am-btn am-btn-secondary am-btn-sm"><i class="am-icon-github am-icon-sm"></i> Github</a>
      <a href="#" class="am-btn am-btn-success am-btn-sm"><i class="am-icon-google-plus-square am-icon-sm"></i> Google+</a>
      <a href="#" class="am-btn am-btn-primary am-btn-sm"><i class="am-icon-stack-overflow am-icon-sm"></i> stackOverflow</a>
      </div>
    </form>
  </div>
  </div>
  <footer class="log-footer">   
    © 2019 李镓 1229844289@qq.com.
  </footer>
</div>



<!--[if (gte IE 9)|!(IE)]><!-->
@include('home.public.script')
</body>
</html>