<?php
return array(
    'man' => array(
        'method' => 'GET',
        'call' => 'Admin/Index/index'
    ),
    //index 登录
    'adminlogin' => array(
        'method' => 'POST',
        'call' => 'Admin/Index/doLogin'
    ),
    //main/index
    'adminmain' => array(
        'method' => 'GET',
        'call' => 'Admin/Main/index'
    ),
    'adminverifycode' => array(
        'method' => 'GET',
        'call' => 'Admin/Index/getVerifyCode'
    ),
    'adminlogout' => array(
        'method' => 'GET',
        'call' => 'Admin/Index/logout'
    ),
    'admintoforgetpwd' => array(
        'method' => 'GET',
        'call' => 'Admin/Index/toForgetPwd'
    ),
    'admindoforgetpwd' => array(
        'method' => 'POST',
        'call' => 'Admin/Index/doForgetPwd'
    )
);
