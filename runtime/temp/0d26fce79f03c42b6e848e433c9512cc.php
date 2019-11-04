<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"F:\xampp\htdocs\chzu\public/../application/xt\view\html\admin_org_add.html";i:1566887935;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>组织机构添加</title>
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
                <span class="x-red">*</span>单位名称
            </label>
            <div class="layui-input-inline">
                <input type="text" id="name" name="name" required lay-verify="required"
                       autocomplete="off" class="layui-input">
            </div>
        </div>

        <!--<div class="layui-form-item">-->
            <!--<label for="parent_id" class="layui-form-label" style="width: 106px;">-->
                <!--<span class="x-red">*</span>上级组织机构ID-->
            <!--</label>-->
            <!--<div class="layui-input-inline">-->
                <!--<input type="text" id="parent_id" name="parent_id"-->
                       <!--autocomplete="off" class="layui-input">-->
            <!--</div>-->
        <!--</div>-->

        <div class="layui-form-item">
            <label for="sort" class="layui-form-label">
                <span class="x-red">*</span>编号
            </label>
            <div class="layui-input-inline">
                <input type="text" id="code" name="code"
                       autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="sort" class="layui-form-label">
                <span class="x-red">*</span>排序号
            </label>
            <div class="layui-input-inline">
                <input type="text" id="sort" name="sort"
                       autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">
            </label>
            <button class="layui-btn" lay-filter="add" lay-submit="" style="background-color: #FF5722;margin-left: 27px;">
                添加此单位信息
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
                url: '/chzu/public/xt/organises',
                type: 'POST',
                dataType: 'json',
                data: {
                    name: data.field.name,
                    code: data.field.code,
//                    parent_id: data.field.parent_id,
                    parent_id: 0,
                    sort: data.field.sort
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
                        //加载层-风格
                    } else {
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