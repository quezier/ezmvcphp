<?php
/**
 * @package        EzMvcPHP
 * @author         quezier
 * @email          33590896@qq.com
 */
return array(
    '/'=>array(
        'method'=>'GET',
        'call'=>array(
            'www'=>'Index/Index/index'
        )//针对子域名的设置，默认子域名是www,只有首页需要这样配置
    ),
    'createmodel'=>array(
        'method'=>'GET',
        'call'=>'Test/CreateModel/createModel'
    ),
    'testcall'=>array(
        'method'=>'GET',
        'call'=>function(){
            echo '回调函数测试';exit;
        }
    ),
    'publictip'=>array(
        'method'=>'GET',
        'call'=>'Index/Index/tip'
    ),
    'indexdetail'=>array(
        'method'=>'GET',
        'call'=>'Index/Index/detail'
    ),
    'indexsearch'=>array(
        'method'=>'GET',
        'call'=>'Index/Index/search'
    ),
    'sesssyn'=>array(
        'method'=>'GET',
        'call'=>'Index/Sesssyn/index'
    ),
    'synlogout'=>array(
        'method'=>'GET',
        'call'=>'Index/Sesssyn/logout'
    )
);