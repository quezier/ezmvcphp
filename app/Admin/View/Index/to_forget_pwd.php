<!DOCTYPE html class="login-content">
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>忘记密码</title>
    <?php require  $adminPublicLinkView;?>
</head>

<body class="login-content">
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
<form class="lc-block" id="l-findpwd">
    <h4>忘记密码</h4>
    <div class="input-field ">
        <i class="mdi-hardware-phone-android prefix"></i>
        <input id="email" name="email" placeholder="邮箱" type="text" class="validate[required,custom[email]]">
    </div>
    <a class="btn btn-login waves-effect waves-light pink lighten-1" id="findpwd">发送</a>
    <p class="login-link right-align" style="margin-top: 20px">
        <a href="<?php echo HTTP_DOMAIN; ?>/admin">已有账号？马上登录</a>
    </p>
</form>
<?php require  $adminPublicFooterView;?>
<script type="text/javascript" src="<?php echo HTTP_DOMAIN; ?>/js/admin/jquery.cookie.js "></script>
<script type="text/javascript">
    $(function () {
        $('#l-findpwd').validationEngine();
        $('#findpwd').on('click', forgetPassword);
        function forgetPassword() {
            if ($('#l-findpwd').validationEngine('validate')) {
                var param = $('#l-findpwd').serializeObject();//form表单上数据转成[{name:value},,,,]
                $('#findpwd').children('i').css('display', 'block');
                $('#findpwd').unbind('click');
                $.ajax({
                    url: "<?php echo HTTP_DOMAIN; ?>/admindoforgetpwd",
                    dataType: 'json',
                    type: 'post',
                    data:param,
                    success: function (data) {
                        if (data.status == 1) {
                            swal({
                                title: "提示",
                                text: "密码发送成功！",
                                type: "info",
                                showCancelButton: false
                            }, function () {
                                $.cookie(location.host + '_username', $('#email').val());
                                $.cookie(location.host + '_is_remember', 1);
                                location.href = "<?php echo HTTP_DOMAIN . '/admin';?>";
                            });
                        } else {
                            swal('提示', data.msg, 'error');
                        }
                        $('#findpwd').children('i').css('display', 'none');
                        $('#findpwd').on('click', forgetPassword);
                    }, error: function (xhr, text, error) {
                        $('#ico_loading').hide();
                        $('#findpwd').on('click', forgetPassword);
                        $('#findpwd').children('i').css('display', 'none');
                        swal('提示', '请求失败', 'error');
                    }
                });

            } else {
                swal("错误", "表单验证不通过!", "error");
            }
        }

        //回车提交
        document.onkeydown = function (e) {
            var ev = document.all ? window.event : e;
            if (ev.keyCode == 13) {
                e.preventDefault();
            }
        };
        $('#email').keyup(function (e) {
            if (e.keyCode == 13) {
                forgetPassword();
            }
        });

    });
</script>

</body>
</html>
