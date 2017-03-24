<?php
return array(
    'admin_tolistarticleinf'=>array(
        'method' => 'GET',
        'rank_num'=>2,
        'privilege_name'=>'文章管理',
        'parent_privilege_name'=>'内容管理',
        'privilege_type'=>1,
        'call' => 'Admin/ArticleInfo/toArticleInfoList'
    ),
    'admin_pagearticleinflist'=>array(
        'method' => 'GET',
        'rank_num'=>3,
        'privilege_name'=>'查询分页文章列表',
        'parent_privilege_name'=>'文章管理',
        'privilege_type'=>4,
        'call' => 'Admin/ArticleInfo/pageArticleInfoList'
    ),
    'admin_toaddarticleinf'=>array(
        'method' => 'GET',
        'rank_num'=>3,
        'privilege_name'=>'跳转到添加文章页面',
        'parent_privilege_name'=>'文章管理',
        'privilege_type'=>2,
        'call' => 'Admin/ArticleInfo/toAddArticleInfo'
    ),
    'admin_doaddarticleinf'=>array(
        'method' => 'POST',
        'rank_num'=>4,
        'privilege_name'=>'添加文章动作',
        'parent_privilege_name'=>'跳转到添加文章页面',
        'privilege_type'=>2,
        'call' => 'Admin/ArticleInfo/doAddArticleInfo'
    ),
    'admin_toeditarticleinf'=>array(
        'method' => 'GET',
        'rank_num'=>3,
        'privilege_name'=>'跳转到编辑文章页面',
        'parent_privilege_name'=>'文章管理',
        'privilege_type'=>3,
        'call' => 'Admin/ArticleInfo/toEditArticleInfo'
    ),
    'admin_doeditarticleinf'=>array(
        'method' => 'POST',
        'rank_num'=>4,
        'privilege_name'=>'编辑文章动作',
        'parent_privilege_name'=>'跳转到编辑文章页面',
        'privilege_type'=>2,
        'call' => 'Admin/ArticleInfo/doEditArticleInfo'
    )
);