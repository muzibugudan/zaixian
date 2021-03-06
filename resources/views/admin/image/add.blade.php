<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.public.styles')
    @include('admin.public.script')
</head>

<body>
<div class="x-body">
    <form class="layui-form" id="img_form" action="{{ url('admin/image') }}" method="post">
        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>图片分类
            </label>
            <div class="layui-input-inline">
                <select name="cate_id">
                    <option value="">==顶级分类==</option>
                   
                        <option value="1">西安 角落</option>
                        <option value="2">三秦镜头</option>
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
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">缩略图</label>
            <div class="layui-input-block layui-upload">
                <input type="hidden" id="img1" class="hidden" name="img_thumb" value="">
                <button type="button" class="layui-btn" id="test1">
                    上传图片
                </button>
                <input type="file" name="photo" id="photo_upload" style="display: none;">
            </div>
        </div>


        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label"></label>
            <div class="layui-input-block">
                <img src="" alt="" id="art_thumb_img" style="max-width: 350px; max-height:100px;">
            </div>
        </div>
        
        <div class="layui-form-item">
            <label for="L_art_tag" class="layui-form-label">
                <span class="x-red">*</span>描述
            </label>
            <div class="layui-input-block">
                <textarea placeholder="请输入内容" class="layui-textarea" name="img_description"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="add" lay-submit="">
                增加
            </button>
        </div>
    </form>
</div>
</body>
<!-- <script>
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
    });

    //Markdown AJAX
    $('#previewBtn').click(function(){
        $.ajax({
            url:"/admin/article/pre_mk",
            type:"post",
            data:{
                cont:$('#z-textarea').val()
            },
            success:function(res){
                $('#z-textarea-preview').html(res);
            },
            error:function(err){
                console.log(err.responseText);
            }
        });
    })
</script> -->
    
<script>
    $('#test1').on('click',function () {
         $('#photo_upload').trigger('click');
         $('#photo_upload').on('change',function () {
            var obj = this;

            var formData = new FormData($('#img_form')[0]);
            $.ajax({
                url: '/admin/image/upload',
                type: 'post',
                data: formData,
                // 因为data值是FormData对象，不需要对数据做处理
                processData: false,
                contentType: false,
                success: function(data){
                    if(data['ServerNo']=='200'){
                        // 如果成功
                        
                        $('#art_thumb_img').attr('src', '/uploads/'+data['ResultData']);
                        $('input[name=img_thumb]').val('/uploads/'+data['ResultData']);
                        $(obj).off('change');
                        // alert(添加成功);

                    }else{
                        // 如果失败
                        alert(data['ResultData']);
                    }
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
        });
    });
</script>
<script>
    // layui.use(['form','layer','upload'], function(){
        // $ = layui.jquery;
        // var form = layui.form
        // ,layer = layui.layer;
        // var upload = layui.upload;
        // var element = layui.element;
        // var btn = layui.btn;

        // $('#test1').on('click',function () {
        //         $('#photo_upload').trigger('click');
        //         $('#photo_upload').on('change',function () {
        //             var obj = this;

        //             var formData = new FormData($('#img_form')[0]);
        //             $.ajax({
        //                 url: '/admin/image/upload',
        //                 type: 'post',
        //                 data: formData,
        //                 // 因为data值是FormData对象，不需要对数据做处理
        //                 processData: false,
        //                 contentType: false,
        //                 success: function(data){
        //                     if(data['ServerNo']=='200'){
        //                         // 如果成功
                                
        //                         $('#art_thumb_img').attr('src', '/uploads/'+data['ResultData']);
        //                         $('input[name=img_thumb]').val('/uploads/'+data['ResultData']);
        //                         $(obj).off('change');
        //                         // alert(添加成功);

        //                     }else{
        //                         // 如果失败
        //                         alert(data['ResultData']);
        //                     }
        //                 },
        //                 error: function(XMLHttpRequest, textStatus, errorThrown) {
        //                     var number = XMLHttpRequest.status;
        //                     var info = "错误号"+number+"文件上传失败!";
        //                     // 将菊花换成原图
        //                     // $('#pic').attr('src', '/file.png');
        //                     alert(info);
        //                 },
        //                 async: true
        //             });
        //         });

        // });

        //监听提交
        form.on('submit(add)', function(data){
            //发异步，把数据提交给php
              $.ajax({
                  type:'POST',
                  url:'/admin/image',
                  dataType:'json',
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  data:data.field,
                  success:function(data){
                      // 弹层提示添加成功，并刷新父页面
                      // console.log(data);
                      if(data.status == 0){
                          alert(添加成功);
                      }else{
                          layer.alert(data.message,{icon:5});
                      }
                  },
                  error:function(){
                      //错误信息
                  }
        });


    // });
</script>
<script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();</script>
</html>