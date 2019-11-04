<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:67:"F:\xampp\htdocs\chzu\public/../application/xt\view\index\index.html";i:1566887475;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>后台登录</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>

    <link rel="shortcut icon" href="/chzu/public/static/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="/chzu/public/static/css/font.css">
    <link rel="stylesheet" href="/chzu/public/static/css/xadmin.css">
    <link rel="stylesheet" href="/chzu/public/static/css/theme.css"/>

</head>
<body>
<!-- 顶部开始 -->
<div class="container ">
    <div class="logo"><a href="index.html">滁州科协科技智库系统</a></div>
    <div class="left_open">
        <i title="展开左侧栏" class="iconfont">&#xe699;</i>
    </div>
    <iframe  style="margin-left: 20px;margin-top: 14px;" class="weather" width="450" scrolling="no" height="30" frameborder="0" allowtransparency="true" src="//i.tianqi.com/index.php?c=code&id=1&color=%23FFFFFF&icon=4&wind=1&num=2&site=12"></iframe>
    <ul class="layui-nav right " lay-filter="">
        <!--<li class="layui-nav-item">-->
            <!--<iframe  class="weather" width="450" scrolling="no" height="30" frameborder="0" allowtransparency="true" src="//i.tianqi.com/index.php?c=code&id=1&color=%23FFFFFF&icon=4&wind=1&num=2&site=12"></iframe>-->
        <!--</li>-->
        <li class="layui-nav-item">
            <a href="javascript:;">切换主题</a>
            <dl class="layui-nav-child">
                <dd class="layui-this"><a href="javascript:;" id="default">默认</a></dd>
                <dd><a href="javascript:;" id="cyan">藏青</a></dd>
                <!--<dd><a href="javascript:;" id="ml">墨绿</a></dd>-->
                <!--<dd><a href="javascript:;" id="yl">艳蓝</a></dd>-->
            </dl>
        </li>
        <li class="layui-nav-item">
            <a href="javascript:;"><?php echo $user['nick_name']; ?></a>
            <dl class="layui-nav-child">
                <dd><a href="javascript:;" id="user_logout">退出</a></dd>
            </dl>
        </li>
        <li class="layui-nav-item to-index"><a href="index">首页</a></li>
    </ul>

</div>
<!-- 顶部结束 -->
<!-- 中部开始 -->
<!-- 左侧菜单开始 -->
<div class="left-nav  layui-nav-tree layui-nav-side">
    <div id="side-nav">
        <ul id="nav" lay-shrink="all">
            <li>
                <a _href="html/expertInfoList">
                    <i class="iconfont">&#xe74e;</i>
                    <cite>专家信息管理</cite>
                </a>

            </li>
            <li>
                <a _href="html/expertAnalysis">
                    <i class="iconfont">&#xe6b4;</i>
                    <cite>统计分析</cite>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6eb;</i>
                    <cite>系统管理</cite>
                    <i class="iconfont nav_right">&#xe6a7;</i>
                </a>
                <ul class="sub-menu">
                    <li><a _href="xt/adminList"><i class="iconfont">&#xe6b8;</i><cite>用户管理</cite></a></li>
                    <!--<li><a _href="xt/adminOrg"><i class="iconfont">&#xe811;</i><cite>组织机构管理</cite></a></li>-->
                    <li><a _href="xt/adminOrg"><i class="iconfont">&#xe811;</i><cite>单位地区管理</cite></a></li>
                    <li><a _href="xt/adminCode"><i class="iconfont">&#xe707;</i><cite>基础代码管理</cite></a></li>
                </ul>
            </li>


        </ul>
    </div>
</div>
<button class="layui-btn" onclick="x_admin_show('添加用户','./admin-add.html')"><i class="layui-icon"></i>添加</button>
<!-- <div class="x-slide_left"></div> -->
<!-- 左侧菜单结束 -->
<!-- 右侧主体开始 -->
<div class="page-content">
    <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
        <ul class="layui-tab-title">
            <li class="home"><i class="layui-icon">&#xe68e;</i>我的桌面</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src='welcome' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
        </div>
    </div>
</div>
<div class="page-content-bg"></div>
<!-- 右侧主体结束 -->
<!-- 中部结束 -->
<!-- 底部开始 -->
<div class="footer">
    <div class="copyright">Copyright ©2019 L-admin v2.3 All Rights Reserved</div>
</div>
<!-- 底部结束 -->

</body>
<script src="/chzu/public/static/js/jquery.min.js"></script>
<script src="/chzu/public/static/lib/layui/layui.js" charset="utf-8"></script>
<script src="/chzu/public/static/js/xadmin.js" type="text/javascript"></script>
<script>
    $(function () {
        //上方导航栏相关功能//
        //退出登录
        $('#user_logout').on('click', function () {
            $.post("xt/user/logout", {}, function (result) {
                if (result.code === 200) {
                    layer.msg("登出成功!", {
                        time: 1500,
                        end: function () {
                            $(location).attr('href', 'login');
                        }
                    });
                } else {
                    layer.msg("登出失败!");
                }
            }, 'json');
        })
        //切换主题
        $('#cyan').on('click', function () {
            $('.container').removeClass('layui-bg-green layui-bg-blue').addClass('layui-bg-cyan');
//            $('.container').style.backgroundColor = "#00a597";
            $('.left-nav').removeClass('layui-bg-green layui-bg-blue').addClass('layui-bg-cyan');
            $('#nav .sub-menu li').removeClass('layui-bg-green layui-bg-blue').addClass('layui-bg-cyan');
        });
//        $('#ml').on('click', function () {
//            $('.container').removeClass('layui-bg-cyan layui-bg-blue').addClass('layui-bg-green');
//            $('.left-nav').removeClass('layui-bg-cyan layui-bg-blue').addClass('layui-bg-green');
//            $('#nav .sub-menu li').removeClass('layui-bg-cyan layui-bg-blue').addClass('layui-bg-green');
//        });
//        $('#yl').on('click', function () {
//            $('.container').addClass('layui-bg-blue');
//            $('.left-nav').addClass('layui-bg-blue');
//            $('#nav .sub-menu li').addClass('layui-bg-blue');
//        });
        $('#default').on('click', function () {
            $('.container').removeClass('layui-bg-cyan layui-bg-blue layui-bg-green');
            $('.left-nav').removeClass('layui-bg-cyan layui-bg-blue layui-bg-green');
            $('#nav .sub-menu li').removeClass('layui-bg-cyan layui-bg-blue layui-bg-green');
        });



        //左侧菜单栏相关功能//


        //内容区域相关功能//
    })
</script>

</html>