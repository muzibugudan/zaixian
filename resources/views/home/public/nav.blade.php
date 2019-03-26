<nav class="am-g am-g-fixed blog-fixed blog-nav">
<!-- <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only blog-button" data-am-collapse="{target: '#blog-collapse'}" ><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button> -->
 
  <div class="am-collapse am-topbar-collapse" id="blog-collapse">
    <ul class="am-nav am-nav-pills am-topbar-nav">
      <li class="am-active">
        <a href="{{ url('index') }}" style="margin-right:20px ">首页</a>
      </li>
       @foreach($cateone as $k=>$v)
        <li class="am-dropdown" data-am-dropdown style="margin-right:15px ">
          <a class="am-dropdown-toggle" data-am-dropdown-toggle href="{{ url('/lists/'.$v->cate_id) }}">
            {{ $v->cate_name }} 
              <span class="am-icon-caret-down"></span>
            @if(!empty($catetwo[$k]))
              <ul class="am-dropdown-content">
                @foreach($catetwo[$k] as $m=>$n)
                <li><a href="{{ url('/lists/'.$n->cate_id) }}">{{ $n->cate_name }}</a></li>   
                 @endforeach      
              </ul>
            @endif
         </a>  
        </li>
       @endforeach
       <li class="am-dropdown" data-am-dropdown> 
            <a href="" class="am-dropdown-toggle" data-am-dropdown-toggle>生活美拍
              <span class="am-icon-caret-down"></span>
              <ul class="am-dropdown-content">
                <li><a href="{{ url('jiaoluo') }}">西安 角落</a></li>
                <li><a href="{{ url('sanqin') }}">三秦镜头</a></li>
              </ul>
            </a>
        </li>
    </ul>
    <form class="am-topbar-form am-topbar-left am-form-inline" role="search">
      <div class="am-form-group">
        <input type="text" class="am-form-field am-input-sm" placeholder="搜索">
      </div>
    </form>
    @if(session('homeuser'))  
    <span class="am-topbar-right am-form-inline " style="margin-top: 13px"><a href="/loginout">退出</a></span>
    <span class="am-topbar-right am-form-inline ">
      <ul class="am-nav am-nav-pills am-topbar-nav">
        <li class="am-dropdown" data-am-dropdown> 
            <a href="" class="am-dropdown-toggle" data-am-dropdown-toggle>{{ session('homeuser')->user_name }}
              <span class="am-icon-caret-down"></span>
              <ul class="am-dropdown-content">
                <li><a href="">个人中心</a></li>
                <li><a href="{{ url('precollection') }}">我的收藏</a></li>
              </ul>
            </a>
        </li>  
      </ul>
    </span>
    
    @else
      <span class="am-topbar-right am-form-inline" style="margin-top: 12px"><a href="/emailregister">注册</a></span>
      <span class="am-topbar-right am-form-inline " style="margin-top: 12px"><a href="/login">登录</a></span>
    @endif
  </div> 
</nav>
<hr>