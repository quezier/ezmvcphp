<?php
return array(
    'admin_tolistadmin'=>array(
        'method' => 'GET',
        'rank_num'=>2,
        'privilege_name'=>'管理员管理',
        'parent_privilege_name'=>'系统管理',
        'privilege_type'=>1,
        'call' => 'Admin/Admin/toAdminList'
    ),
    'admin_pageadminlist'=>array(
        'method' => 'GET',
        'rank_num'=>3,
        'privilege_name'=>'查询分页管理员列表',
        'parent_privilege_name'=>'管理员管理',
        'privilege_type'=>4,
        'call' => 'Admin/Admin/pageAdminList'
    ),
    'admin_toaddadmin'=>array(
        'method' => 'GET',
        'rank_num'=>3,
        'privilege_name'=>'跳转到添加管理员页面',
        'parent_privilege_name'=>'管理员管理',
        'privilege_type'=>2,
        'call' => 'Admin/Admin/toAddAdmin'
    ),
    'admin_doaddadmin'=>array(
        'method' => 'POST',
        'rank_num'=>4,
        'privilege_name'=>'添加管理员动作',
        'parent_privilege_name'=>'跳转到添加管理员页面',
        'privilege_type'=>2,
        'call' => 'Admin/Admin/doAddAdmin'
    ),
    'admin_toeditadmin'=>array(
        'method' => 'GET',
        'rank_num'=>3,
        'privilege_name'=>'跳转到编辑管理员页面',
        'parent_privilege_name'=>'管理员管理',
        'privilege_type'=>3,
        'call' => 'Admin/Admin/toEditAdmin'
    ),
    'admin_doeditadmin'=>array(
        'method' => 'POST',
        'rank_num'=>4,
        'privilege_name'=>'编辑管理员动作',
        'parent_privilege_name'=>'跳转到编辑管理员页面',
        'privilege_type'=>2,
        'call' => 'Admin/Admin/doEditAdmin'
    ),
    'admin_tocropper'=>array(
        'method' => 'GET',
        'rank_num'=>3,
        'privilege_name'=>'跳转到上传头像',
        'parent_privilege_name'=>'管理员管理',
        'privilege_type'=>3,
        'call' => 'Admin/Admin/toCropper'
    ),
    'admin_docropper'=>array(
        'method' => 'POST',
        'rank_num'=>4,
        'privilege_name'=>'上传头像并裁剪动作',
        'parent_privilege_name'=>'管理员管理',
        'privilege_type'=>2,
        'call' => 'Admin/Admin/doCropper'
    ),
    'admin_toupload'=>array(
        'method' => 'GET',
        'rank_num'=>3,
        'privilege_name'=>'跳转到上传文件',
        'parent_privilege_name'=>'管理员管理',
        'privilege_type'=>3,
        'call' => 'Admin/Admin/toupload'
    ),
    'admin_doupload'=>array(
        'method' => 'POST',
        'rank_num'=>4,
        'privilege_name'=>'上传文件动作',
        'parent_privilege_name'=>'跳转到上传文件',
        'privilege_type'=>2,
        'call' => 'Admin/Admin/doupload'
    ),
    'admin_dodelimg'=>array(
        'method' => 'POST',
        'rank_num'=>4,
        'privilege_name'=>'删除文件动作',
        'parent_privilege_name'=>'跳转到上传文件',
        'privilege_type'=>4,
        'call' => 'Admin/Admin/doDelImg'
    )

);