<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"F:\xampp\htdocs\chzu\public/../application/index\view\html\certificate_add.html";i:1565312565;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>专家资格证书添加</title>
    <link rel="stylesheet" type="text/css" href="/chzu/public/static/css/xadmin.css">
    <link rel="stylesheet" type="text/css" href="/chzu/public/static/css/font.css">
    <script src="/chzu/public/static/js/jquery.min.js"></script>
    <script src="/chzu/public/static/lib/layui/layui.js"></script>
    <script src="/chzu/public/static/js/xadmin.js"></script>
</head>
<body>
<div class="x-body">
    <form class="layui-form">
        <div class="layui-form-item">
            <label for="name" class="layui-form-label">
                <span class="x-red">*</span>证书名称
            </label>
            <div class="layui-input-inline">
                <input type="text" id="name" name="name" required lay-verify="required"
                       autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="sort" class="layui-form-label">
                <span class="x-red">*</span>证书排序
            </label>
            <div class="layui-input-inline">
                <input type="text" id="sort" name="sort"
                       autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="code" class="layui-form-label">
                <span class="x-red">*</span>证书编号
            </label>
            <div class="layui-input-inline">
                <input type="text" id="code" name="code" lay-verify="required"
                       autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
        <label class="layui-form-label">
            <span class="x-red">*</span>所属专家姓名
        </label>
        <div class="layui-input-inline">
            <select name="fk_expert_info_id" id="fk_expert_info_id" lay-search>
                <option value="">请选择或搜索</option>
            </select>
        </div>
        </div>

        <div class="layui-form-item pane">

            <label class="layui-form-label">
                <span class="x-red">*</span>资格证书图片
            </label>
            <img src="/chzu/public/static/images/no-photo.jpg" name="img" id="img" width="110px" height="150px">
            <input type="file" value="上传图片" name="file"  id="file" onchange="change()" style="display: inline-block">
            <!--<div class="layui-form-mid" style="color: red;">注意：建议上传295*413像素照片<br>-->
            <!--<ol>-->
            <!--<li>1、请上传100KB以内，近期一寸蓝底照片。</li>-->
            <!--<li>2、照片尺寸5:7，建议上传295*413像素照片。</li>-->
            <!--<li>3、此照片将用于证书头像照，请保证图片清晰度。</li>-->
            <!--<li>4、右侧图片预览，需要求IE8及以上浏览器。</li>-->
            <!--</ol>-->
            <!--</div>-->
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">
            </label>
            <button class="layui-btn" lay-filter="add" lay-submit="" style="background-color: #FF5722;">
                确认添加此资格证书信息
            </button>
        </div>
    </form>

</div>

<script type="text/javascript">
    /**
     * 初始化Form渲染，以便获取下拉框的值
     */
    function renderFrom() {
        layui.use('form', function () {
            var form = layui.form;
            form.render();
        })
    }
    /**
     * 表单中带下拉框的内容查询
     */
    layui.use(['form'], function () {
        var form = layui.form;
        var $ = layui.jquery;
        $(function () {
//                    从数据库获取专家信息名称填入到下拉框中
            var str = '';
            $.ajax({
                type: "GET",
                url: "/chzu/public/experInfo",
                data: {},
                dataType: "json",
                success: function (data) {
                    var da = data.data;
                    $.each(da, function (i, json) {
                        var $option = $("<option value='" + json["key_id"] + "'>" + json["name"] + "</option>");
                        $("#fk_expert_info_id").append($option);
                        renderFrom();
                    });
                }
            });
        })
    });
//    资格证书显示
    function change(){
        var img=document.getElementById("img");
        var file=document.getElementById("file");
        img.src=window.URL.createObjectURL(file.files[0]);
    }

    layui.use(['form', 'layer'], function () {
        $ = layui.jquery;
        var form = layui.form
                , layer = layui.layer;
        //监听提交
        form.on('submit(add)', function (data) {
            var formData = new FormData();
            formData.append("image",$("#file")[0].files[0]);
            formData.append("name",data.field.name);
            formData.append("sort",data.field.sort);
            formData.append("code",data.field.code);
            formData.append("fk_expert_info_id",data.field.fk_expert_info_id);
            //发异步，把数据提交给php
            $.ajax({
                url: '/chzu/public/experCertificate',
                type: 'POST',
                dataType: 'json',
                data: formData,
                processData:false,  //使数据不作处理，以便向后台传输文件流
                contentType:false,  //不要设置Content-Type请求头
                success: function (data) {
                    var returnCode = data.code;
                    if (returnCode == 200) {
                        layer.closeAll('loading');
                        layer.load(2);
                        layer.msg("添加成功", {icon: 6});
                        setTimeout(function () {
                            window.parent.location.reload();//修改成功后刷新父界面
                        }, 1000);
                        //加载层-风格
                    } else {
                        console.log(returnCode);
                        layer.msg("添加失败，请检查信息是否符合要求", {icon: 5});
                    }
                }
            });
            return false;
        });
    });
</script>
</body>
</html>