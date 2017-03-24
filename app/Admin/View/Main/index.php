<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <?php require  $adminPublicLinkView;?>
    <title>欢迎首页</title>
    <style>
        .info {
            line-height: 2.5rem;
            list-style-type: disc;
            margin-left: 20px
        }
        /*日历css*/
        .content{border:3px solid #ddd;width:405px; height:344px;margin:0 auto;}
        .datetable{border-top:1px solid #ccc;border-left:1px solid #ccc;background:#fff;}
        .datetable td{border-bottom:1px solid #ccc;border-right:1px solid #ccc;text-align:center;}
        .datetable thead{background:#006600;}
        .datetable thead td{padding:10px 5px;font:normal 12px/normal 'microsoft yahei';color:#000000;text-align:center;}
        .datetable thead td span{padding:0 5px;}
        .datetable tbody td{padding:5px 3px;font-size:12px;}
    </style>
</head>

<body class=" ">

<!-- Docs master nav -->
<?php require  $adminPublicHeaderView;?>
<!-- Page content of course! -->
<div id="main">
    <div class="wrapper">
        <?php require  $adminPublicMenuView;?>
        <section id="content" class="hh-min-width">
            <div class="breadcrumbs-wrapper">
                <div class="container">
                    <div class="row no-margin">
                        <div class="col s12" style="padding-bottom: 10px;">
                            <h5 class="breadcrumbs-title">首页</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
<!--
                <div class="card">
                    <div class="card-heading">
                        <h4>操作快捷入口</h4>
                        <ul class="actions">
                            <li>
                                <a class="waves-effect waves-block waves-light collapse-btn card-a" href="#">
                                    <i class="mdi-hardware-keyboard-arrow-down"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-content">
                        <a class="waves-effect waves-pink btn-flat hh-border-1" href="">
                            待确认订单
                            <small class="count teal">0</small>
                        </a>
                        <a class="waves-effect waves-pink btn-flat hh-border-1" href="">
                            待付款订单
                            <small class="count light-blue">0</small>
                        </a>
                        <a class="waves-effect waves-pink btn-flat hh-border-1" href="">
                            待发货订单
                            <small class="count red">0</small>
                        </a>
                    </div>
                </div>-->
                <div class="card" style='display: none'>
                    <div class="card-heading">
                        <h4>待办事项</h4>
                        <ul class="actions">
                            <li class="hh-operate">
                                <a class="waves-effect waves-light btn" href="#"><i class="mdi-content-add"></i>添加事项</a>
                            </li>
                            <li>
                                <a class="waves-effect waves-block waves-light collapse-btn card-a" href="#">
                                    <i class="mdi-hardware-keyboard-arrow-down"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-content">
                        <table class="highlight hh-table-bordered hh-table-margin">
                            <thead>
                            <tr>
                                <th width="70"></th>
                                <th>事项内容</th>
                                <th width="120">事项添加人</th>
                                <th width="120">添加时间</th>
                                <th width="140">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="pink lighten-5">
                                <td><input class="filled-in" type="checkbox" id="checkbox-1"><label
                                        for="checkbox-1"></label></td>
                                <td class="text-left">事项内容事项内容事项内容事项内容事项内容事项内容事项内</td>
                                <td>小乔</td>
                                <td>2015-15-15</td>
                                <td><a class="btn-floating waves-effect waves-light amber darken-4 hh-btn-small"
                                       title="星标"><i class="mdi-action-grade"></i></a><a
                                        class="btn-floating waves-effect waves-light blue-grey lighten-2 hh-btn-small"
                                        title="删除事件"><i class="mdi-navigation-close"></i></a></td>
                            </tr>
                            <tr class="cyan lighten-5">
                                <td><input class="filled-in" type="checkbox" id="checkbox-2"><label
                                        for="checkbox-2"></label></td>
                                <td class="text-left">事项内容事项内容事项内容事项内容事项内容事项内容事项内</td>
                                <td>小乔</td>
                                <td>2015-15-15</td>
                                <td><a class="btn-floating waves-effect waves-light amber darken-4 hh-btn-small"
                                       title="星标"><i class="mdi-action-grade"></i></a><a
                                        class="btn-floating waves-effect waves-light blue-grey lighten-2 hh-btn-small"
                                        title="删除事件"><i class="mdi-navigation-close"></i></a></td>
                            </tr>
                            <tr class="light-green lighten-5">
                                <td><input class="filled-in" type="checkbox" id="checkbox-3"><label
                                        for="checkbox-3"></label></td>
                                <td class="text-left">事项内容事项内容事项内容事项内容事项内容事项内容事项内</td>
                                <td>小乔</td>
                                <td>2015-15-15</td>
                                <td><a class="btn-floating waves-effect waves-light amber darken-4 hh-btn-small"
                                       title="星标"><i class="mdi-action-grade"></i></a><a
                                        class="btn-floating waves-effect waves-light blue-grey lighten-2 hh-btn-small"
                                        title="删除事件"><i class="mdi-navigation-close"></i></a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- 公告 开始 -->
                <div class="card">
                    <div class="card-heading ">
                        <h4>公告</h4>
                        <ul class="actions">
                            <li>
                                <a class="waves-effect waves-block waves-light collapse-btn card-a" href="#">
                                    <i class="mdi-hardware-keyboard-arrow-down"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-content">
                        <table class="highlight hh-table-bordered hh-table-margin">
                            <thead>
                            <tr>
                                <th style='line-height: 2rem;'>标题</th>
                                <th>简介</th>
                                <th width="120">发布时间</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td class="text-left" style='line-height: 2rem'>事项内容事项内容事项内容</td>
                                <td class="text-left">事项内容</td>
                                <td>2015-15-15</td>
                            </tr>
                            <tr>
                                <td class="text-left" style='line-height: 2rem'>事项内容事项内容事项内容</td>
                                <td class="text-left">事项内容</td>
                                <td>2015-15-15</td>
                            </tr>
                            <tr>
                                <td class="text-left" style='line-height: 2rem'>事项内容事项内容事项内容</td>
                                <td class="text-left">事项内容</td>
                                <td>2015-15-15</td>
                            </tr>
                            </tbody>
                        </table>
                        <!-- 翻页 开始 -->
                        <div class="pag-wrap right-align">
                        </div>
                        <!-- 翻页 结束 -->
                    </div>
                </div>
                <!-- 公告 结束 -->


                <div style='width:100%;float: left'>
                    <!-- 系统信息开始 -->
                    <div class="card" style='width:72%; height:auto;float: left'>
                        <div class="card-heading ">
                            <h4>系统信息</h4>
                            <ul class="actions">
                                <li>
                                    <a class="waves-effect waves-block waves-light collapse-btn card-a" href="#">
                                        <i class="mdi-hardware-keyboard-arrow-down"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-content">
                            <div style='margin-top:10px;font-weight:bold;'>数据库服务器</div>
                            <div style='margin-top:12px'>
                                <ul>
                                    <li class="info">服务器： mysql wampserver (127.0.0.1 via TCP/IP)</li>
                                    <li class="info">服务器类型： MySQL</li>
                                    <li class="info">服务器版本： 5.6.17 - MySQL Community Server (GPL)</li>
                                    <li class="info">协议版本： 10</li>
                                    <li class="info">服务器字符集： UTF-8 Unicode (utf8)</li>
                                </ul>
                            </div>
                            <div style='margin-top:15px;font-weight:bold;'>网站服务器</div>
                            <div style='margin-top:12px'>
                                <ul>
                                    <li class="info">Apache/2.4.9 (Win64) PHP/5.5.12</li>
                                    <li class="info">数据库客户端版本： libmysql - mysqlnd 5.0.11-dev - 20120503 - $Id:
                                        bf9ad53b11c9a57efdb1057292d73b928b8c5c77 $
                                    </li>
                                    <li class="info">PHP 扩展： mysqli 文档</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- 系统信息结束 -->
                    <!-- 日历 结束 -->
                    <div class="card" style="width:27%;float:right;height:auto">
                        <div class="card-heading ">
                            <h4>日历</h4>
                            <ul class="actions">
                                <li>
                                    <a class="waves-effect waves-block waves-light collapse-btn card-a" href="#">
                                        <i class="mdi-hardware-keyboard-arrow-down"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-content">
                            <form name="CLD" class="content">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="datetable"
                                       height='323px'>
                                    <thead>
                                    <tr>
                                        <td colSpan=7><span style='color:white'>公历</span>
                                            <select name="SY" onchange="changeCld();"
                                                    style="font-SIZE: 9pt;width:100px">
                                                <script>
                                                    for (i = 1900; i < 2050; i++)
                                                        document.write('<option>' + i);
                                                </script>
                                            </select><span style='color:white'>年</span>
                                            <select name="SM" onchange="changeCld();" style="font-SIZE: 9pt;width:70px">
                                                <script>
                                                    for (i = 1; i < 13; i++)
                                                        document.write('<option>' + i);
                                                </script>
                                            </select><span style='color:white'>月</span>
                                            </font><span id="GZ" style='color:white'></span>
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr style="background:#eee;">
                                        <td width="54">日</td>
                                        <td width="54">一</td>
                                        <td width="54">二</td>
                                        <td width="54">三</td>
                                        <td width="54">四</td>
                                        <td width="54">五</td>
                                        <td width="54">六</td>
                                    </tr>
                                    <script>
                                        var gNum;
                                        for (i = 0; i < 6; i++) {
                                            document.write('<tr align="center">');
                                            for (j = 0; j < 7; j++) {
                                                gNum = i * 7 + j;
                                                document.write('<td id="GD' + gNum + '"><font id="SD' + gNum + '" size=2 face="Arial Black"');
                                                if (j == 0)
                                                    document.write('color="red"');
                                                if (j == 6)
                                                    document.write('color="red"');
                                                document.write('></font><br/><font id="LD' + gNum + '" size=2 style="font-size:9pt"></font></td>');
                                            }
                                            document.write('</tr>');
                                        }
                                    </script>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                    <!-- 日历 结束 -->
                </div>
            </div>
    </div>
    </section>
</div>
</div>

<?php require  $adminPublicFooterView;?>
<script src="<?php echo HTTP_DOMAIN; ?>/js/admin/calendar.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //日历
        initial();
    });
</script>

<script>(function(T,h,i,n,k,P,a,g,e){g=function(){P=h.createElement(i);a=h.getElementsByTagName(i)[0];P.src=k;P.charset="utf-8";P.async=1;a.parentNode.insertBefore(P,a)};T["ThinkPageWeatherWidgetObject"]=n;T[n]||(T[n]=function(){(T[n].q=T[n].q||[]).push(arguments)});T[n].l=+new Date();if(T.attachEvent){T.attachEvent("onload",g)}else{T.addEventListener("load",g,false)}}(window,document,"script","tpwidget","//widget.thinkpage.cn/widget/chameleon.js"))</script>
<script>tpwidget("init", {
        "flavor": "bubble",
        "location": "WT029G15ETRJ",
        "geolocation": "enabled",
        "position": "bottom-left",
        "margin": "20px 20px",
        "language": "zh-chs",
        "unit": "c",
        "theme": "chameleon",
        "uid": "UEBAB41310",
        "hash": "3821d289bb7c57f24891157740a1af84"
    });
    tpwidget("show");</script>
</body>

</html>
