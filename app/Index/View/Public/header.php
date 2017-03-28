<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>湘依信息</title>

    <!-- Bootstrap -->
    <link href="<?php echo CSS_HOST;?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo CSS_HOST;?>/css/blog.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="blog-masthead">
    <div class="container">
        <nav class="blog-nav">
            <a class="blog-nav-item <?php if(empty($is_login)){echo 'active';}?>" href="<?php echo HTTP_DOMAIN;?>/">Home</a>
            <?php if(empty($_SESSION['user_name'])){?>
            <a class="blog-nav-item "
               href="javascript:void(0)">登录</a>
            <?php }else{?>
                <a class="blog-nav-item "
                   href="javascript:void(0)">注销</a>
            <?php }?>
            <form action="<?php echo HTTP_DOMAIN;?>/indexsearch" method="GET" class="navbar-form navbar-right">
                <div class="form-group">
                    <input name="search_word" type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">搜索</button>
            </form>
        </nav>

    </div>
</div>