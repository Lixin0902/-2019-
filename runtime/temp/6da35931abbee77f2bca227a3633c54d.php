<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"F:\xampp\htdocs\chzu\public/../application/xt\view\html\admin_area_edit.html";i:1566548883;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>地区信息编辑</title>
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
                <span class="x-red">*</span>地区名称
            </label>
            <div class="layui-input-inline">
                <input type="text" id="name" name="name" required lay-verify="required"
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
                确认更改此地区信息
            </button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        var parent_json = eval('(' + parent.json + ')');
        $("#name").val(parent_json.name);
        $("#parent_id").val(parent_json.parent_id);
    });

    layui.use(['form', 'layer'], function () {
        $ = layui.jquery;
        var form = layui.form
                , layer = layui.layer;
        //监听提交
        form.on('submit(add)', function (data) {
            console.log(data);
            var parent_json = eval('(' + parent.json + ')');
            var key_id = parent_json.key_id;
            console.log(key_id)
            //发异步，把数据提交给php
            $.ajax({
                url: '/chzu/public/xt/areas/' + key_id,
                type: 'POST',
                dataType: 'json',
                data: {
                    _method: 'PUT',
                    name: data.field.name,
                    parent_id: data.field.parent_id
                },
                success: function (data) {
                    var returnCode = data.code;
                    if (returnCode == 200) {
                        layer.closeAll('loading');
                        layer.load(2);
                        layer.msg("修改成功", {icon: 6});
                        setTimeout(function () {
                            window.parent.location.reload();//修改成功后刷新父界面
                        }, 1000);
                    } else {
                        console.log(returnCode);
                        layer.msg("修改失败", {icon: 5});
                    }
                }
            });
            return false;
        });
    });
</script>
</body>
</html>