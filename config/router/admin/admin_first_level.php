<?php
return array(
    'admin_first_privilege'=>array(
        'method'=>'GET',
        'rank_num'=>1,
        'privilege_name'=>'系统管理',
        'privilege_css'=>'mdi-action-settings-applications',
        'parent_privilege_name'=>'',
        'privilege_type'=>1,//1.左边主菜单 2.按钮 3.下拉列表 4.数据url
        'call'=>''
    ),
    'admin_first_pubprivilege'=>array(
        'method'=>'GET',
        'rank_num'=>1,
        'privilege_name'=>'公共权限管理',
        'privilege_css'=>'',
        'parent_privilege_name'=>'',
        'privilege_type'=>1,//1.左边主菜单 2.按钮 3.下拉列表 4.数据url
        'call'=>''
    ),
    'admin_first_content'=>array(
        'method'=>'GET',
        'rank_num'=>1,
        'privilege_name'=>'内容管理',
        'privilege_css'=>'mdi-action-book',
        'parent_privilege_name'=>'',
        'privilege_type'=>1,//1.左边主菜单 2.按钮 3.下拉列表 4.数据url
        'call'=>''
    )
);