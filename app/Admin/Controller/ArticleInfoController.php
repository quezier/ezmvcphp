<?php
namespace App\Admin\Controller;
use App\Logic\ArticleInfoLogic;
use App\Logic\ArticleTypeLogic;
use Core\BaseController;
use Core\PubFunc;
class ArticleInfoController extends BaseController
{
    private $articleInfoLogic;
    function __construct()
    {
        parent::__construct();
        $this->articleInfoLogic = new ArticleInfoLogic();
    }

    function toArticleInfoList(){
        $needFieldsResult = $this->articleInfoLogic->getNeedFields(array('id','title','is_del'));

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
            '添加'=>HTTP_DOMAIN.'/admin_toaddarticleinf/last_url/'.trim(PATH,'/')
        );
        $dropDownMenus = array(
            '编辑'=>HTTP_DOMAIN.'/admin_toeditarticleinf/id/{{v.id}}/last_url/'.trim(PATH,'/')
        );
        $searchInputs = array(
            'eq_title'=>array('type'=>'text','name'=>'标题')
        );
        $this->setVariable('tableCName','文章');
        $this->setVariable('titleNames',$titleNames);
        $this->setVariable('displayFields',$displayFields);
        $this->setVariable('dropDownMenus',$dropDownMenus);
        $this->setVariable('tableTitleButtons',$tableTitleButtons);
        $this->setVariable('searchInputs',$searchInputs);
        $this->setVariable('actionUrl',HTTP_DOMAIN."/admin_pagearticleinflist");
        $this->displayList();
    }

    function toAddArticleInfo(){
        $needFieldsResult = $this->articleInfoLogic->getNeedFields(array('article_type_id','title','content'));
        if($needFieldsResult['status']==2)
        {
            return $needFieldsResult;
        }
        $needFields = $needFieldsResult['result'];
        $articleTypeLogic = new ArticleTypeLogic();
        $articleTypeResult = $articleTypeLogic->getAllArticleType();
        $articleTypes = !empty($articleTypeResult['result'])?$articleTypeResult['result']:null;
        $list = array();
        if(count($articleTypes)>0)
        {
            foreach ($articleTypes as $atKey => $atVal){
                $list[$atVal['id']] =  $atVal['type_name'];
            }
        }
        $addFields = array(
            'article_type_id'=>array('cn_name'=>$needFields['article_type_id'],'type'=>'select','list'=>$list),
            'title'=>array('cn_name'=>$needFields['title'],'type'=>'text'),
            'content'=>array('cn_name'=>$needFields['content'],'type'=>'editor','is_one_row'=>1),
        );

        $this->setVariable('tableCName','文章');
        $this->setVariable('addFields',$addFields);
        $this->setVariable('actionUrl',HTTP_DOMAIN."/admin_doaddarticleinf");
        $this->displayAdd();
    }

    function toEditArticleInfo(){
        $id = !empty($_GET['id'])?intval($_GET['id']):0;
        $rs = $this->articleInfoLogic->getById($id);
        if($rs['status']==1&&!empty($rs['result'])&&count($rs['result'])>0)
        {
            $this->setVariable('tableObject',$rs['result']);
        }
        $dataConfig = PubFunc::config('data_dictionary');

        $needFieldsResult = $this->articleInfoLogic->getNeedFields(array('is_del'));
        if($needFieldsResult['status']==2)
        {
            return $needFieldsResult;
        }
        $needFields = $needFieldsResult['result'];
        $articleTypeLogic = new ArticleTypeLogic();
        $articleTypeResult = $articleTypeLogic->getAllArticleType();
        $articleTypes = !empty($articleTypeResult['result'])?$articleTypeResult['result']:null;
        $list = array();
        if(count($articleTypes)>0)
        {
            foreach ($articleTypes as $atKey => $atVal){
                $list[$atVal['id']] =  $atVal['type_name'];
            }
        }
        $editFields = array(
            'article_type_id'=>array('cn_name'=>$needFields['article_type_id'],'type'=>'select','list'=>$list),
            'title'=>array('cn_name'=>$needFields['title'],'type'=>'text'),
            'content'=>array('cn_name'=>$needFields['content'],'type'=>'editor','is_one_row'=>1),
            'is_del'=>array('cn_name'=>$needFields['is_del'],'type'=>'radio','list'=>$dataConfig['is_del'])
        );
        $this->setVariable('tableCName','文章');
        $this->setVariable('editFields',$editFields);
        $this->setVariable('actionUrl',HTTP_DOMAIN."/admin_doeditarticleinf");
        $this->displayEdit();
    }

    function pageArticleInfoList()
    {
        $rs = $this->articleInfoLogic->pageArticleInfoList($_GET);
        echo json_encode($rs);exit;
    }

    function doAddArticleInfo()
    {
        if(!empty($_POST['content']))
        {
            $_POST['content'] = htmlentities($_POST['content']);
        }
        $rs = $this->articleInfoLogic->insertFromTestData($_POST);

        echo json_encode($rs);exit;
    }

    function doEditArticleInfo()
    {
        if(!empty($_POST['content']))
        {
            $_POST['content'] = htmlentities($_POST['content']);
        }
        $rs = $this->articleInfoLogic->update($_POST);
        echo json_encode($rs);exit;
    }
}