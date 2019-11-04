<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"F:\xampp\htdocs\chzu\public/../application/xt\view\html\admin_area_add.html";i:1563843710;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>地区添加</title>
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
                地区名称
            </label>
            <div class="layui-input-inline">
                <input type="text" id="name" name="name" required lay-verify="required"
                       autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                <span class="x-red">*</span>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="code" class="layui-form-label">
                <span class="x-red">*</span>地区编码
            </label>
            <div class="layui-input-inline">
                <input type="text" id="code" name="code"
                       autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="parent_id" class="layui-form-label">
                <span class="x-red">*</span>上级区域ID
            </label>
            <div class="layui-input-inline">
                <input type="text" id="parent_id" name="parent_id"
                       autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">
            </label>
            <button class="layui-btn" lay-filter="add" lay-submit="" style="background-color: #FF5722;">
                添加此地区信息
            </button>
        </div>

    </form>
</div>
<script>
    layui.use(['form', 'layer'], function () {
        $ = layui.jquery;
        var form = layui.form
                , layer = layui.layer;
        //监听提交
        form.on('submit(add)', function (data) {
            //发异步，把数据提交给php
            $.ajax({
                url: '/chzu/public/xt/areas',
                type: 'POST',
                dataType: 'json',
                data: {
                    name: data.field.name,
                    code: data.field.code,
                    parent_id: data.field.parent_id
                },
                success: function (data) {
                    var returnCode = data.code;
                    if (returnCode == 200) {
                        layer.closeAll('loading');
                        layer.load(2);
                        layer.msg("添加成功", {icon: 6});
                        setTimeout(function () {
                            window.parent.location.reload();//修改成功后刷新父界面
                        }, 1000);
                    } else {
                        console.log(returnCode);
                        layer.msg("添加失败，" + data.msg, {icon: 5});
                    }
                }
            });
            return false;
        });
    });
</script>
</body>
</html>