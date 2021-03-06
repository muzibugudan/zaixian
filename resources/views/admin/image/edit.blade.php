<!DOCTYPE html>
<html>
  
  <head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
      <meta name="csrf-token" content="{{ csrf_token() }}">
      @include('admin.public.styles')
      @include('admin.public.script')
  </head>
  
  <body>
    <div class="x-body">
        <form class="layui-form">
            
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>分类
                </label>
                <div class="layui-input-inline">
                    <select name="cate_id">
                        @if($imgs->cate_id == 1)
                        <option selected value="1">西安 角落</option>
                        <option  value="2">三秦镜头</option>
                        @else
                        <option selected  value="2">三秦镜头</option>
                        <option  value="1">西安 角落</option>
                        @endif
                    </select>
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div> 
                
            <div class="layui-form-item">
                <label for="L_art_title" class="layui-form-label">
                    <span class="x-red">*</span>图片标题
                </label>
                <div class="layui-input-block">
                    {{csrf_field()}}
                    <input type="text" id="L_art_title" name="img_title" required=""
                           autocomplete="off" class="layui-input" value="{{ $imgs->img_title }}">
                </div>
            </div>
            <!-- <div class="layui-form-item">
                <label for="L_art_editor" class="layui-form-label">
                    <span class="x-red">*</span>编辑
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_art_editor" name="art_editor" required=""
                           autocomplete="off" class="layui-input" value="{{ $imgs->art_editor }}">
                </div>
            </div> -->
           <!--  <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">缩略图</label>
                <div class="layui-input-block layui-upload">
                    <input type="hidden" id="img1" class="hidden" name="art_thumb" value="">
                    <button type="button" class="layui-btn" id="test1">
                        <i class="layui-icon">&#xe67c;</i>修改图片
                    </button>
                     <input type="file" name="photo" id="photo_upload" style="display: none;" />
                </div>
            </div> -->


            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">缩略图</label>
                <div class="layui-input-block">
                    <img src="{{ $imgs->img_thumb }}" alt=""  style="max-width: 350px; max-height:100px;">
                    <!-- <input type="file" name="art_thumb" value="" id="photo_upload"/> -->
                </div>
                
            </div>
            
            <div class="layui-form-item">
                <label for="L_art_tag" class="layui-form-label">
                    <span class="x-red">*</span>描述
                </label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" class="layui-textarea" name="img_description">{{ $imgs->img_description }}</textarea>
                </div>
            </div>
            
          <div class="layui-form-item">
              <input type="hidden" name="img_id" value="{{ $imgs->img_id }}">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="edit" lay-submit="">
                  修改
              </button>
          </div>
      </form>
    </div>
    <script>
      layui.use(['form','layer','upload','element'], function(){
          $ = layui.jquery;
        var form = layui.form
        ,layer = layui.layer;
          var upload = layui.upload;
          var element = layui.element;

        $('#photo_upload').on('change',function () {
                var obj = this;
                var formData = new FormData($('#art_form')[0]);
                $.ajax({
                    url: '/admin/image/upload',
                    type: 'post',
                    data: formData,
                    // 因为data值是FormData对象，不需要对数据做处理
                    processData: false,
                    contentType: false,
                    success: function(data){
                        // if(data['ServerNo']=='200'){
                        //     // 如果成功
                        //     {{--$('#art_thumb_img').attr('src', '{{ env('ALIOSS_DOMAIN')  }}'+data['ResultData']);--}}
                        //     {{--$('#art_thumb_img').attr('src', '{{ env('QINIU_DOMAIN')  }}'+data['ResultData']);--}}
                        //     // $('#art_thumb_img').attr('src', '/uploads/'+data['ResultData']);
                        //     $('input[name=art_thumb]').val('/uploads/'+data['ResultData']);
                        //     $(obj).off('change');
                        // }else{
                        //     // 如果失败
                        //     alert(data['ResultData']);
                        // }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        var number = XMLHttpRequest.status;
                        var info = "错误号"+number+"文件上传失败!";
                        // 将菊花换成原图
                        // $('#pic').attr('src', '/file.png');
                        alert(info);
                    },
                    async: true
                });

      

        //监听提交
        form.on('submit(edit)', function(data){
            var img_id = $("input[name='img_id']").val();
            //console.log(uid);
            $.ajax({
                type: 'PUT',
                url: '/admin/image/'+img_id,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data:JSON.stringify(data.field),
                data:data.field,
                success: function(data){

                    if(data.status == 0){
                        layer.alert("修改成功", {icon: 6},function () {
                            parent.location.reload();
                        });
                    }else{
                        layer.alert("修改失败", {icon: 5},function () {
                            parent.location.reload();
                        });
                    }

                },
                error:function(data) {
                    //console.log(1111111111111111);
                    // console.log(data.msg);
                },
            });
          return false;
        });
        
        
      });
  </script>
    <script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();</script>
  </body>

</html>