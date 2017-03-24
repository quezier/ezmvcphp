<!DOCTYPE html class="login-content">
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>登录</title>
    <meta name="description" content="">
    <?php require  $adminPublicLinkView;?>
</head>
<body class="login-content" >
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
<form class="lc-block" id="l-login">
    <h4>管理后台登录</h4>
    <div class="input-field ">
        <i class="mdi-hardware-phone-android prefix"></i>
        <input id="input-1" name="admin_email" placeholder="邮箱" type="text" class="validate[required]">

    </div>
    <div class="input-field ">
        <i class="mdi-action-lock-outline prefix"></i>
        <input id="input-2" name="admin_pwd" placeholder="密码" type="password" class="validate[required]">

    </div>
    <div class="input-field  left-align " id="captcha-container">
        <input name="verify" id="verify_text" placeholder="验证码" type="text" class="validate[required]"
               style="vertical-align:middle;width:180px;height:40px;">&nbsp;&nbsp;
        <img id="img_vcode" src="<?php echo HTTP_DOMAIN; ?>/adminverifycode" width="115" height="40" style="vertical-align:middle;"/>

    </div>
    <div class="remember clearfix">
        <div class="left">
            <input type="checkbox" id="check1"/>
            <label for="check1">记住用户名</label>
        </div>
        <div class="right">
            <a href="admintoforgetpwd">忘记密码?</a> <!-- | <a href="register.html">免费注册</a>-->
        </div>
    </div>
    <a class="btn btn-login waves-effect waves-light pink lighten-1" id="login">登录</a>
</form>
<?php require  $adminPublicFooterView;?>
<script type="text/javascript" src="<?php echo HTTP_DOMAIN; ?>/js/admin/jquery.cookie.js "></script>
<script language="javascript" type="text/javascript">

    var captcha_img = $('#img_vcode');
    var verifyimg = captcha_img.attr("src");
    captcha_img.attr('title', '点击刷新');
    captcha_img.click(function(){
        if( verifyimg.indexOf('?')>0){
            $(this).attr("src", verifyimg+'&random='+Math.random());
        }else{
            $(this).attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
        }
    });

</script>
<script type="text/javascript">
    $(function () {
        if ($.cookie(location.host + '_username')) {
            $('#input-1').val($.cookie(location.host + '_username'));
        }
        if ($.cookie(location.host + '_is_remember') == 1) {
            $('#check1').prop('checked', true);
        }

        $('#l-login').validationEngine();
        $("#login").click(function () {
            if ($('#l-login').validationEngine('validate')) {
                    var v = $("#input-1").val();
                    $("#input-1").val($.trim(v));  //去除前后空格
                    var param = $("#l-login").serialize();
                    $.post("<?php echo HTTP_DOMAIN; ?>/adminlogin/dologin", param, function (data) {
                        if (data.status == 2) {
                            swal('提示', data.msg, 'error');
                            if(data.msg=='验证码错误！')
                            {
                                $('#img_vcode').attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
                                $('#verify_text').val('');
                            }
                            return;
                        } else {
                            location.href = data.result;
                        }
                    }, "json");
            }
        });

        $('#check1').click(function () {
            var username = $('#input-1').val();
            if ($(this).prop('checked') == true) {
                if (username) {
                    $.cookie(location.host + '_username', username);
                    $.cookie(location.host + '_is_remember', 1);
                }
            } else {
                if ($.cookie(location.host + '_username')) {
                    $.cookie(location.host + '_username', '', {expires: -1});
                    $.cookie(location.host + '_is_remember', '', {expires: -1});
                }
            }
        });

        $(document).keypress(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                $("#login").click();
            }
        });
    });
</script>

</body>

</html>
