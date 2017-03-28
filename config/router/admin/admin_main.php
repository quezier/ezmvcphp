<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/6 0006
 * Time: 上午 11:32
 */
return array(
    'admin_modifyuserpwd' => array(
        'method' => 'GET',
        'rank_num' =>2,
        'privilege_name' => '修改密码',
        'parent_privilege_name' => '公共权限管理',
        'privilege_type' => 5,
        'call' => 'Admin/Main/doModifyAdminUserPwd'
    ),
    'admin_togetcity'=>array(
        'method' => 'GET',
        'rank_num'=>2,
        'privilege_name'=>'根据省id查询市',
        'parent_privilege_name'=>'公共权限管理',
        'privilege_type'=>5,
        'call' => 'Admin/Main/toGetCity'
    ),
    'admin_togetcountry'=>array(
        'method' => 'GET',
        'rank_num'=>2,
        'privilege_name'=>'根据市id查询区县',
        'parent_privilege_name'=>'公共权限管理',
        'privilege_type'=>5,
        'call' => 'Admin/Main/toGetCountry'
    )
);