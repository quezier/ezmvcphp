<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/6 0006
 * Time: 下午 16:00
 */
return array(
    'ADMIN_SMTP_HOST'=>'smtp.qq.com',
    'ADMIN_SMTP_USERNAME'=>'qq@qq.com',//邮箱地址
    'ADMIN_SMTP_PWD'=>'sdfasdfadfaf',//qq邮箱后台获取授权码
    'default_view_folder'=>PROJECT_ROOT.DIR_SP.'app'.DIR_SP.MODULE.DIR_SP.'View'.DIR_SP,
    'public_view_folder'=>PROJECT_ROOT.DIR_SP.'app'.DIR_SP.'View'.DIR_SP.'Public'.DIR_SP,
    'admin_public_list_View'=>PROJECT_ROOT.DIR_SP.'app'.DIR_SP.'View'.DIR_SP.'Public'.DIR_SP.'list.php',
    'admin_public_link_view'=>PROJECT_ROOT.DIR_SP.'app'.DIR_SP.'View'.DIR_SP.'Public'.DIR_SP.'link.php',
    'admin_public_header_view'=>PROJECT_ROOT.DIR_SP.'app'.DIR_SP.'View'.DIR_SP.'Public'.DIR_SP.'header.php',
    'admin_public_menu_view'=>PROJECT_ROOT.DIR_SP.'app'.DIR_SP.'View'.DIR_SP.'Public'.DIR_SP.'menu.php',
    'admin_public_footer_view'=>PROJECT_ROOT.DIR_SP.'app'.DIR_SP.'View'.DIR_SP.'Public'.DIR_SP.'footer.php',
    'default_admin_errortourl'=>HTTP_HOST.'/adminmain',
    'default_admin_successtourl'=>HTTP_HOST.'/adminmain',
    'admin_loginurl'=>HTTP_HOST.'/'.MANAGE_ACCESS_NAME,
    'default_index_errortourl'=>HTTP_HOST,
    'default_index_successtourl'=>HTTP_HOST,
    'img_host'=>HTTP_DOMAIN.'/images/',//图片主机地址
    'js_host'=>HTTP_DOMAIN,//js主机地址
    'css_host'=>HTTP_DOMAIN,//css主机地址
    'uploads_path'=>PROJECT_ROOT.DIR_SP.'public'.DIR_SP.'images'.DIR_SP.'uploads'.DIR_SP,
    'uploads_thumb_path'=>PROJECT_ROOT.DIR_SP.'public'.DIR_SP.'images'.DIR_SP.'uploads_thumb'.DIR_SP,
    'file_upload_type'=>'local',
    'upload_type_config'=>array(
        'maxSize'    =>    2097152,
        'rootPath'   =>    PROJECT_ROOT.DIR_SP.'public'.DIR_SP.'images'.DIR_SP.'uploads'.DIR_SP,
        'savePath'   =>    '',
        'saveName'   =>    \Core\CreateUniqueNo::createUniqueNo(),
        'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
        'autoSub'    =>    true,
        'subName'    =>    array('date','Ymd'),
    ),
    'public_login_url'=>'www.api.bs/plogin',
    'public_logout_url'=>'www.api.bs/plogout',
    'allow_host'=>array(
        'www.test.bs',
        'www.api.bs'
    ),
    'ALIYUN_MSG'=>array(
        'ID'=>'',
        'SECRET'=>'',
        'SIGN_NAME'=>''
    )

);