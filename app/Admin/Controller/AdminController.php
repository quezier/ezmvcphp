<?php
namespace App\Admin\Controller;
use App\Logic\AdminGalleryLogic;
use App\Logic\AdminLogic;
use Core\BaseController;
use Core\CreateUniqueNo;
use Core\Cropper;
use Core\Image;
use Core\PubFunc;
use App\Logic\RoleLogic;
use Core\Upload;

class AdminController extends BaseController
{
    private $adminLogic;
    function __construct()
    {
        parent::__construct();
        $this->adminLogic = new AdminLogic();
    }

    function toAdminList(){
        $needFieldsResult = $this->adminLogic->getNeedFields(array('id','role_id','name','mobile','nick','sex','email','is_del'));
        if($needFieldsResult['status']==1)
        {
            $titleNames = array_values($needFieldsResult['result']);
            $displayFields = array_keys($needFieldsResult['result']);
        }
        else{
            return $needFieldsResult;
        }
        $titleNames[0]='序号';
        $titleNames[1]='角色';
        $tableTitleButtons = array(
            '添加'=>HTTP_DOMAIN.'/admin_toaddadmin/last_url/'.trim(PATH,'/')
        );
        $dropDownMenus = array(
            '编辑'=>HTTP_DOMAIN.'/admin_toeditadmin/id/{{v.id}}/last_url/'.trim(PATH,'/'),
            '上传相册'=>HTTP_DOMAIN.'/admin_toupload/id/{{v.id}}/last_url/'.trim(PATH,'/'),
            '管理头像'=>HTTP_DOMAIN.'/admin_tocropper/id/{{v.id}}/last_url/'.trim(PATH,'/'),
        );

        $searchInputs = array(
            'like_admin_name'=>array('type'=>'text','name'=>'用户名')
        );
        $this->setVariable('tableCName','管理员');
        $this->setVariable('titleNames',$titleNames);
        $this->setVariable('displayFields',$displayFields);
        $this->setVariable('dropDownMenus',$dropDownMenus);
        $this->setVariable('tableTitleButtons',$tableTitleButtons);
        $this->setVariable('searchInputs',$searchInputs);
        $this->setVariable('actionUrl',HTTP_DOMAIN."/admin_pageadminlist");
        $this->displayList();
    }
    
    function toAddAdmin(){
        $needFieldsResult = $this->adminLogic->getNeedFields(array('name','nick','email','mobile','role_id','sex','pwd'));
        if($needFieldsResult['status']==2)
        {
            return $needFieldsResult;
        }
        $needFields = $needFieldsResult['result'];
        $needFields['repwd'] = '确认密码';
        $needFields['role_id'] = '角色';
        $roleLogic = new RoleLogic();
        $getAllRoleResult = $roleLogic->getAllRole();
        if($getAllRoleResult['status']==1&&!empty($getAllRoleResult['result'])&&count($getAllRoleResult['result'])>0)
        {
            $rolesArray = $getAllRoleResult['result'];
            $roles = array();
            foreach ($rolesArray as $raKey => $raVal)
            {
                $roles[$raVal['id']] = $raVal['role_name'];
            }
        }
        $configArray = PubFunc::config('data_dictionary');
        $sexArray = $configArray['sex'];
        $addFields = array(
            'name'=>array('cn_name'=>$needFields['name'],'type'=>'text'),
            'nick'=>array('cn_name'=>$needFields['nick'],'type'=>'text'),
            'email'=>array('cn_name'=>$needFields['email'],'type'=>'text'),
            'mobile'=>array('cn_name'=>$needFields['mobile'],'type'=>'text'),
            'role_id'=>array('cn_name'=>$needFields['role_id'],'type'=>'select','list'=>$roles),
            'sex'=>array('cn_name'=>$needFields['sex'],'type'=>'radio','list'=>$sexArray),
            'pwd'=>array('cn_name'=>$needFields['pwd'],'type'=>'password'),
            'repwd'=>array('cn_name'=>$needFields['repwd'],'type'=>'password')
        );

        $this->setVariable('tableCName','管理员');
        $this->setVariable('addFields',$addFields);
        $this->setVariable('actionUrl',HTTP_DOMAIN."/admin_doaddadmin");
        $this->displayAdd();
    }

    function toEditAdmin(){
        $id = !empty($_GET['id'])?intval($_GET['id']):0;
        $rs = $this->adminLogic->getById($id);
        if($rs['status']==1&&!empty($rs['result'])&&count($rs['result'])>0)
        {
            $this->setVariable('tableObject',$rs['result']);
        }
        $dataConfig = PubFunc::config('data_dictionary');

        $needFieldsResult = $this->adminLogic->getNeedFields(array('name','nick','email','mobile','role_id','sex','is_del'));
        if($needFieldsResult['status']==2)
        {
            return $needFieldsResult;
        }
        $needFields = $needFieldsResult['result'];
        $roleLogic = new RoleLogic();
        $getAllRoleResult = $roleLogic->getAllRole();
        if($getAllRoleResult['status']==1&&!empty($getAllRoleResult['result'])&&count($getAllRoleResult['result'])>0)
        {
            $rolesArray = $getAllRoleResult['result'];
            $roles = array();
            foreach ($rolesArray as $raKey => $raVal)
            {
                $roles[$raVal['id']] = $raVal['role_name'];
            }
        }
        $configArray = PubFunc::config('data_dictionary');
        $sexArray = $configArray['sex'];
        $editFields = array(
            'name'=>array('cn_name'=>$needFields['name'],'type'=>'text'),
            'nick'=>array('cn_name'=>$needFields['nick'],'type'=>'text'),
            'email'=>array('cn_name'=>$needFields['email'],'type'=>'text'),
            'mobile'=>array('cn_name'=>$needFields['mobile'],'type'=>'text'),
            'role_id'=>array('cn_name'=>$needFields['role_id'],'type'=>'select','list'=>$roles),
            'sex'=>array('cn_name'=>$needFields['sex'],'type'=>'radio','list'=>$sexArray),
            'is_del'=>array('cn_name'=>$needFields['is_del'],'type'=>'radio','list'=>$dataConfig['is_del']),
        );
        $this->setVariable('tableCName','管理员');
        $this->setVariable('editFields',$editFields);
        $this->setVariable('actionUrl',HTTP_DOMAIN."/admin_doeditadmin");
        $this->displayEdit();
    }

    function pageAdminList()
    {
        $_GET['neq_role_id']=1;
        $rs = $this->adminLogic->pageAdminList($_GET);
        echo json_encode($rs);exit;
    }

    function doAddAdmin()
    {
        $pwd = $_POST['pwd'];
        $repwd = $_POST['repwd'];
        if($pwd!=$repwd){echo json_encode(PubFunc::returnArray(2,false,'两次输入的密码不一致'));exit;}
        $chkNameResult = $this->adminLogic->chkInfo('name',$_POST['name'],'用户名');
        if($chkNameResult['status']==2){echo json_encode($chkNameResult);exit;}

        $chkMobileResult = $this->adminLogic->chkInfo('mobile',$_POST['mobile'],'手机');
        if($chkMobileResult['status']==2){echo json_encode($chkMobileResult);exit;}

        $chkEmailResult = $this->adminLogic->chkInfo('email',$_POST['email'],'邮箱');
        if($chkEmailResult['status']==2){echo json_encode($chkEmailResult);exit;}

        $chkNickResult = $this->adminLogic->chkInfo('nick',$_POST['nick'],'昵称');
        if($chkNickResult['status']==2){echo json_encode($chkNickResult);exit;}

        $_POST['regip'] = PubFunc::getIP();
        $invitationCode = PubFunc::getRandomString(4);
        $_POST['invitation_code'] = $invitationCode;
        $invitationCodePath = PubFunc::getQrcode($invitationCode);
        $_POST['invitationcode_path'] = $invitationCodePath;
        $rs = $this->adminLogic->insertFromTestData($_POST);
        echo json_encode($rs);exit;
    }

    function doEditAdmin()
    {
        $rs = $this->adminLogic->update($_POST);
        echo json_encode($rs);exit;
    }
    
    function toUpload()
    {
        $id = !empty($_GET['id'])?$_GET['id']:0;
        if(empty($id))
        {
            $this->toTip('缺少id参数',HTTP_DOMAIN.'/admin_tolistadmin');
        }
        $option = array(
            'file_count'=>6,
            'single_file_size'=>2*1024*1024,
            'id'=>$id,
            'extensions'=>'gif,jpg,jpeg,bmp,png',
            'mime_types'=>'image/gif,image/jpg,image/jpeg,image/png',
            'server'=>HTTP_DOMAIN.'/admin_doupload',
            'del_server'=>HTTP_DOMAIN.'/admin_dodelimg'
        );
        $this->setVariable('option',$option);
        $this->setVariable('tableCName','管理员');
        $this->displayUpload();
    }

    function doUpload()
    {

        $id = !empty($_POST['uid'])?$_POST['uid']:0;
        if(empty($id))
        {
            echo json_encode(PubFunc::returnArray(2,false,'缺少uid'));exit;
        }
        if(empty($_FILES['file']))
        {
            echo json_encode(PubFunc::returnArray(2,false,'没有上传文件'));exit;
        }
        $upload = new Upload(PubFunc::sysConfig('upload_type_config'));
        $uploadResult = $upload->uploadOne($_FILES['file']);
        if(!empty($uploadResult))
        {
            $savePath = trim($uploadResult['savepath'],'/');
            $saveName = $uploadResult['savename'];
            $uploadsPath = PubFunc::sysConfig('uploads_path');
            $uploadThumbPath = PubFunc::sysConfig('uploads_thumb_path');
            $oriFilePath = $uploadsPath.$savePath.DIR_SP.$saveName;
            $imageObj = new Image();
            $imageObj->open($oriFilePath);
            $imageObj->thumb(120,120,Image::IMAGE_THUMB_CENTER);
            $uploadThumbPath.=date('Ymd',time()).DIR_SP;
            if(!file_exists($uploadThumbPath))
            {
                PubFunc::createMultiClassFolder($uploadThumbPath);
            }
            $saveResult = $imageObj->save($uploadThumbPath.$saveName);
            if(!empty($saveResult)&&is_array($saveResult)&&$saveResult['status']==2)
            {
                echo json_encode($saveResult);exit;
            }
            else{
                $addData['admin_id'] = $id;
                $addData['img_url'] = $savePath.DIR_SP.$saveName;
                $addData['add_date'] = time();
                $adminGalleryLogic = new AdminGalleryLogic();
                $addResult = $adminGalleryLogic->insertFromTestData($addData);
                if($addResult['status']==1)
                {
                    echo json_encode(PubFunc::returnArray(1,$addResult['result'],'上传成功'));exit;
                }
                else{
                    echo json_encode(PubFunc::returnArray(2,false,'保存失败'));exit;
                }
            }
        }
        else{
            echo json_encode(PubFunc::returnArray(2,false,$upload->getError()));exit;
        }
    }

    function toCropper()
    {
        $id = !empty($_GET['id'])?$_GET['id']:0;
        if(empty($id))
        {
            $this->toTip('缺少id参数',HTTP_DOMAIN.'/admin_tolistadmin');
        }
        $getResult = $this->adminLogic->getById($id);
        if($getResult['status']!=1)
        {
            $this->toTip('查询出错',HTTP_DOMAIN.'/admin_tolistadmin');
        }
        $img = $getResult['result']['img'];
        $this->setVariable('id',$id);
        $this->setVariable('img',!empty($img)&&$img!='无'?HTTP_DOMAIN.'/images/avatar/min/'.$img:'');
        $this->setVariable('tableCName','管理员');
        $this->displayCropper();
    }
    function doCropper()
    {

        $id = !empty($_POST['id'])?$_POST['id']:0;
        if(empty($id))
        {
            echo json_encode(PubFunc::returnArray(2,false,'缺少参数id'));exit;
        }
        $crop = new Cropper(
            isset($_POST['avatar_src']) ? $_POST['avatar_src'] : null,
            isset($_POST['avatar_data']) ? $_POST['avatar_data'] : null,
            isset($_FILES['avatar_file']) ? $_FILES['avatar_file'] : null,
            PROJECT_ROOT.DIR_SP.'public'.DIR_SP.'images'.DIR_SP.'avatar'.DIR_SP
        );

        if($crop -> getMsg() == 'success')
        {
            $updResult = $this->adminLogic->update(array('id'=>$id,'img'=>$crop->getResult()));
            if($updResult['status']!=1)
            {
                echo json_encode($updResult);exit;
            }
            $sysConfig = PubFunc::config('sys');
            echo json_encode(PubFunc::returnArray(1,$sysConfig['img_host'].'avatar/min/'.$crop->getResult(),'图片处理成功'));exit;

        }
        else{
            echo json_encode(PubFunc::returnArray(2,false,$crop->getMsg()));exit;
        }
    }

    function doDelImg()
    {
        $uid = !empty($_POST['uid'])?$_POST['uid']:0;
        if(empty($uid))
        {
            echo json_encode(PubFunc::returnArray(2,false,'缺少uid'));exit;
        }
        $agid = !empty($_POST['agid'])?$_POST['agid']:0;
        if(empty($agid))
        {
            echo json_encode(PubFunc::returnArray(2,false,'缺少agid'));exit;
        }
        $adminGalleryLogic = new AdminGalleryLogic();
        $updData['id'] = $agid;
        $updData['is_del'] = 2;
        $updResult = $adminGalleryLogic->update($updData);
        if($updResult['status']==1)
        {
            echo json_encode(PubFunc::returnArray(1,$updResult['result'],'删除成功'));exit;
        }
        else{
            echo json_encode(PubFunc::returnArray(2,false,'保存失败'));exit;
        }
    }
}