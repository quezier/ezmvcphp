<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width initial-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>温馨提示</title>
        <meta name="description" content="">
        <link rel="stylesheet" href="http://<?php echo HTTP_HOST;?>/css/vendor.min.css">
        <link rel="stylesheet" href="http://<?php echo HTTP_HOST;?>/css/main.min.css">
    </head>
    <body class="four-zero-content">
        <div id="loader-wrapper">
            <div id="loader"></div>        
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
        <div class="four-zero">
            <h4 style="margin-top: 40px;"><?php echo $info;?></h4>
            <small>将在 <span id="mes">5</span> 秒钟后<a id="jumpto" href="<?php echo $tip_url?>">跳转</a>！</small>
            <div class="nav-actions">
                <a class="btn-floating btn-large waves-effect waves-light" href="<?php echo $tip_url?>"><i class="mdi-action-home"></i></a>
            </div>
        </div>
        <script type="text/javascript" src="http://<?php echo HTTP_HOST;?>/js/admin/vendor.min.js "></script>
        <script type="text/javascript" src="http://<?php echo HTTP_HOST;?>/js/admin/main.min.js "></script>
        <script type="text/javascript">
            var i = 5; 
            var intervalid; 
            intervalid = setInterval("fun()", 1000);
            function fun() { 
                if (i == 0) { 
                    window.location.href = "<?php echo $tip_url?>";
                    clearInterval(intervalid); 
                } 
                document.getElementById("mes").innerHTML = i; 
                i--; 
            }
        </script>
    </body>
</html>


