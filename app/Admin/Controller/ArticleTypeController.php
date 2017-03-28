<?php
namespace App\Admin\Controller;
use App\Logic\ArticleTypeLogic;
use Core\BaseController;
use Core\PubFunc;
class ArticleTypeController extends BaseController
{
    private $articleTypeLogic;
    function __construct()
    {
        parent::__construct();
        $this->articleTypeLogic = new ArticleTypeLogic();
    }

    function toArticleTypeList(){
        $needFieldsResult = $this->articleTypeLogic->getNeedFields(array('id','type_name','is_del'));

        if($needFieldsResult['status']==1)
        {
            $titleNames = array_values($needFieldsResult['result']);
            $displayFields = array_keys($needFieldsResult['result']);
        }
        else{
            return $needFieldsResult;
        }
        $titleNames[0] = '序号';
        $tableTitleButtons = array(
            '添加'=>HTTP_DOMAIN.'/admin_toaddarticletyp/last_url/'.trim(PATH,'/')
        );
        $dropDownMenus = array(
            '编辑'=>HTTP_DOMAIN.'/admin_toeditarticletyp/id/{{v.id}}/last_url/'.trim(PATH,'/')
        );
        $searchInputs = array(
            'like_type_name'=>array('type'=>'text','name'=>'名称')
        );
        $this->setVariable('tableCName','文章类型');
        $this->setVariable('titleNames',$titleNames);
        $this->setVariable('displayFields',$displayFields);
        $this->setVariable('dropDownMenus',$dropDownMenus);
        $this->setVariable('tableTitleButtons',$tableTitleButtons);
        $this->setVariable('searchInputs',$searchInputs);
        $this->setVariable('actionUrl',HTTP_DOMAIN."/admin_pagearticletyplist");
        $this->displayList();
    }

    function toAddArticleType(){
        $needFieldsResult = $this->articleTypeLogic->getNeedFields(array('type_name'));
        if($needFieldsResult['status']==2)
        {
            return $needFieldsResult;
        }
        $needFields = $needFieldsResult['result'];
        $addFields = array(
            'type_name'=>array('cn_name'=>$needFields['type_name'],'type'=>'text')
        );

        $this->setVariable('tableCName','文章类型');
        $this->setVariable('addFields',$addFields);
        $this->setVariable('actionUrl',HTTP_DOMAIN."/admin_doaddarticletyp");
        $this->displayAdd();
    }

    function toEditArticleType(){
        $id = !empty($_GET['id'])?intval($_GET['id']):0;
        $rs = $this->articleTypeLogic->getById($id);
        if($rs['status']==1&&!empty($rs['result'])&&count($rs['result'])>0)
        {
            $this->setVariable('tableObject',$rs['result']);
        }
        $dataConfig = PubFunc::config('data_dictionary');

        $needFieldsResult = $this->articleTypeLogic->getNeedFields(array('type_name','is_del'));
        if($needFieldsResult['status']==2)
        {
            return $needFieldsResult;
        }
        $needFields = $needFieldsResult['result'];
        $editFields = array(
            'type_name'=>array('cn_name'=>$needFields['type_name'],'type'=>'text'),
            'is_del'=>array('cn_name'=>$needFields['is_del'],'type'=>'radio','list'=>$dataConfig['is_del']),
        );
        $this->setVariable('tableCName','文章类型');
        $this->setVariable('editFields',$editFields);
        $this->setVariable('actionUrl',HTTP_DOMAIN."/admin_doeditarticletyp");
        $this->displayEdit();
    }

    function pageArticleTypeList()
    {
        $rs = $this->articleTypeLogic->pageArticleTypeList($_GET);
        echo json_encode($rs);exit;
    }

    function doAddArticleType()
    {
        $rs = $this->articleTypeLogic->insertFromTestData($_POST);
        echo json_encode($rs);exit;
    }

    function doEditArticleType()
    {
        $rs = $this->articleTypeLogic->update($_POST);
        echo json_encode($rs);exit;
    }
}