<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"F:\xampp\htdocs\chzu\public/../application/xt\view\html\admin_org.html";i:1566890442;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>组织机构和地区管理</title>
    <link rel="stylesheet" type="text/css" href="/chzu/public/static/lib/layui/css/layui.css">
    <link rel="stylesheet" type="text/css" href="/chzu/public/static/css/xadmin.css">
    <link rel="stylesheet" type="text/css" href="/chzu/public/static/css/font.css">
    <script src="/chzu/public/static/js/jquery.min.js"></script>
    <script src="/chzu/public/static/js/xadmin.js"></script>
</head>
<body>
<!--tabpanel: 1.单位 2.地区-->
<div class="layui-tab layui-tab-brief" lay-filter="">
    <ul class="layui-tab-title">
        <li id="areaOnclick">地区管理</li>
        <li class="layui-this">单位管理</li>
    </ul>
    <div class="layui-tab-content">
        <!--地区部分html-->
        <div class="layui-tab-item">
            <form class="layui-form">
                <div class="layui-form-item">
                    <div class="layui-input-inline">
                        <input type="text" id="codename" name="" placeholder="请输入地区名称" autocomplete="off"
                               class="layui-input">
                    </div>
                </div>
            </form>
            <button class="layui-btn" id="search" style="position: absolute;top: 61px;left: 216px;">查询</button>
            <xblock>
                <button class="layui-btn" onclick="x_admin_show('新增地区信息','adminAreaAdd')"><i
                        class="layui-icon"></i>新增地区信息
                </button>
            </xblock>
            <table id="table1" class="layui-table" lay-filter="table1"></table>
        </div>

        <!--组织机构部分html-->
        <div class="layui-tab-item layui-show">
            <iframe src="adminOrganisesTable" scrolling="no" style="border: none;width:100%;height: 500px;"></iframe>
        </div>
    </div>
</div>
<script src="/chzu/public/static/lib/layui/layui.js"></script>
<script type="text/javascript">
    layui.use(['element', 'form'], function () {
        element = layui.element;
        form = layui.form;

    });
    layui.config({
        base: '/chzu/public/static/css/module/'
    }).extend({
        treetable: 'treetable-lay/treetable'
    }).use(['layer', 'table', 'treetable'], function () {
        var $ = layui.jquery;
        var table = layui.table;
        var layer = layui.layer;
        var treetable = layui.treetable;

        //        每行后面的操作栏功能实现
        table.on('tool(table1)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
            var data = obj.data; //获得当前行数据
            var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
            var tr = obj.tr; //获得当前行 tr 的DOM对象
            var checkStatus = table.checkStatus('demo');
            if (layEvent === 'del') { //删除
                layer.confirm('确定要删除吗？', function (index) {
                    layer.close(index);
                    //向服务端发送删除指令
                    $.ajax({
                        url: "/chzu/public/xt/areas/" + data['key_id'],
                        data: {
                            '_method': 'delete'
                        },
                        type: "post",
                        dataType: 'json',
                        success: function (data) {
                            if (data.code == 200) {
                                obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
                                layer.msg("删除成功");
//                                location.reload();
                            } else {
                                layer.msg("删除失败，" + data.msg);
                            }
                        }
                    })
                });
            } else if (layEvent === 'edit') { //编辑
                json = JSON.stringify(data)
                layer.open({
                    title: '编辑地区信息',
                    type: 2,
                    shade: false,
                    maxmin: true,
                    shade: 0.5,
                    area: ['50%', '90%'],
                    content: 'adminAreaEdit',
                    zIndex: layer.zIndex,
                    success: function (layero, index) {
                        var body = layui.layer.getChildFrame('body', index);
                    },
                    end: function () {
                    }
                });
            }
        });

        // 渲染表格
        function renderTable1() {
            layer.msg('因省市较多，请耐心等待', {
                icon: 16,
                shade: 0.01
            });
            var tableReload = treetable.render({
                treeColIndex: 1,
                treeSpid: 0,
                treeIdName: 'key_id',
                treePidName: 'parent_id',
                treeDefaultClose: true,
                treeLinkage: false,
                elem: '#table1',
                url: "/chzu/public/xt/areas",
                page: false,
                response: {
                    statusCode: 200 //规定成功的状态码，默认：0
//                    , countName: 'count' //规定数据总数的字段名称，默认：count
                    , dataName: 'data' //规定数据列表的字段名称，默认：data
                },
                cols: [[
                    {type: 'numbers'},
                    {field: 'key_id', title: 'ID'},
                    {field: 'name', title: '地区名'},
                    {field: 'code', title: '编号'},
                    {field: 'level', title: '排序'},
                    {fixed: 'right', title: '操作', align: 'center', toolbar: '#barDemo'}
                ]],
                done: function () {
                    layer.closeAll('loading');
                }
            });
        }
        $('#areaOnclick').one("click", function () {
            renderTable1();
        });

        // 搜索按钮点击事件 根据输入内容突出显示符合条件的文本
        $('#search').click(function () {
//            layer.msg('疯狂查询中...',{
//                icon:16,
//                shade:0.01
//            });
            var keyword = $('#codename').val();
            var $tds = $('#table1').next('.treeTable').find('.layui-table-body tbody tr td');
            if (!keyword) {
                $tds.css('background-color', 'transparent');
                layer.msg("请输入关键字", {icon: 5});
                return;
            }
            var searchCount = 0;
            $tds.each(function () {
                $(this).css('background-color', 'transparent');
                if ($(this).text().indexOf(keyword) >= 0) {
                    $(this).css('background-color', 'rgba(250,230,160,0.5)');
                    if (searchCount == 0) {
                        $('body,html').stop(true);//火狐 ie不支持body,谷歌支持的是body，所以为了兼容写body和html   stop()方法停止当前正在运行的动画
                        $('body,html').animate({scrollTop: $(this).offset().top - 150}, 500);
                    }
                    searchCount++;
                }
            });
            if (searchCount == 0) {
                layer.msg("没有匹配结果", {icon: 5});
            } else {
                treetable.expandAll('#table1');
            }
        });

        //    添加回车事件，输入后，按回车即可查询
        document.onkeydown=function(event) {
            e = event ? event :(window.event ? window.event : null);
            if(e.keyCode==13){
//执行的方法
//            alert('回车检测到了');
                var keyword = $('#codename').val();
                var $tds = $('#table1').next('.treeTable').find('.layui-table-body tbody tr td');
                if (!keyword) {
                    $tds.css('background-color', 'transparent');
                    layer.msg("请输入关键字", {icon: 5});
                    return;
                }
                var searchCount = 0;
                $tds.each(function () {
                    $(this).css('background-color', 'transparent');
                    if ($(this).text().indexOf(keyword) >= 0) {
                        $(this).css('background-color', 'rgba(250,230,160,0.5)');
                        if (searchCount == 0) {
                            $('body,html').stop(true);//火狐 ie不支持body,谷歌支持的是body，所以为了兼容写body和html   stop()方法停止当前正在运行的动画
                            $('body,html').animate({scrollTop: $(this).offset().top - 150}, 500);
                        }
                        searchCount++;
                    }
                });
                if (searchCount == 0) {
                    layer.msg("没有匹配结果", {icon: 5});
                } else {
                    treetable.expandAll('#tree-table');
                }
                return false;
            }
        }
    });
</script>

<!--地区表格操作按钮部分-->
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
</body>
</html>