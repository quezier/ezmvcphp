<?php
return array(
    'admin_tolistarticletyp'=>array(
        'method' => 'GET',
        'rank_num'=>2,
        'privilege_name'=>'文章类型管理',
        'parent_privilege_name'=>'内容管理',
        'privilege_type'=>1,
        'call' => 'Admin/ArticleType/toArticleTypeList'
    ),
    'admin_pagearticletyplist'=>array(
        'method' => 'GET',
        'rank_num'=>3,
        'privilege_name'=>'查询分页文章类型列表',
        'parent_privilege_name'=>'文章类型管理',
        'privilege_type'=>4,
        'call' => 'Admin/ArticleType/pageArticleTypeList'
    ),
    'admin_toaddarticletyp'=>array(
        'method' => 'GET',
        'rank_num'=>3,
        'privilege_name'=>'跳转到添加文章类型页面',
        'parent_privilege_name'=>'文章类型管理',
        'privilege_type'=>2,
        'call' => 'Admin/ArticleType/toAddArticleType'
    ),
    'admin_doaddarticletyp'=>array(
        'method' => 'POST',
        'rank_num'=>4,
        'privilege_name'=>'添加文章类型动作',
        'parent_privilege_name'=>'跳转到添加文章类型页面',
        'privilege_type'=>2,
        'call' => 'Admin/ArticleType/doAddArticleType'
    ),
    'admin_toeditarticletyp'=>array(
        'method' => 'GET',
        'rank_num'=>3,
        'privilege_name'=>'跳转到编辑文章类型页面',
        'parent_privilege_name'=>'文章类型管理',
        'privilege_type'=>3,
        'call' => 'Admin/ArticleType/toEditArticleType'
    ),
    'admin_doeditarticletyp'=>array(
        'method' => 'POST',
        'rank_num'=>4,
        'privilege_name'=>'编辑文章类型动作',
        'parent_privilege_name'=>'跳转到编辑文章类型页面',
        'privilege_type'=>2,
        'call' => 'Admin/ArticleType/doEditArticleType'
    )
);