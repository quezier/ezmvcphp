<?php
namespace App\Inject;
use App\Logic\AdminLogic;
use App\Logic\DistributePrivilegeLogic;
use App\Logic\PrivilegeLogic;
use Core\BaseController;
use Core\CheckPrivilegePerAccess;
use Core\PubFunc;

/**
 * @package        EzMvcPHP
 * @author         quezier
 * @email          33590896@qq.com
 */
class PreController extends BaseController
{
    function action(){
        if(!IS_DEBUG&&MODULE=='Test')
        {
            $this->toTip('只有测试模式下才能访问',HTTP_DOMAIN.'/admin');exit;
        }

        //如果已经登录，访问登录页面直接跳转到主页
        if(MODULE=='Admin'&&CONTROLLER=='Index'&&ACTION=='index')
        {
            if(!empty($_SESSION['admin_id']))
            {
                $this->redirect(HTTP_DOMAIN.'/adminmain');exit;
            }
        }
        //权限检查
        if(MODULE=='Admin'&&CONTROLLER!='Index')
        {
            if(empty($_SESSION['admin_name']))
            {
                if(PubFunc::isAjax())
                {
                    echo json_encode(PubFunc::returnArray(2,false,'请先登录'));exit;
                }
                $this->toTip('请先登录',HTTP_DOMAIN.'/'.MANAGE_ACCESS_NAME);exit;
            }
            $admin_id = PubFunc::session('admin_id');
            $adminLogic = new AdminLogic();
            $adminResult = $adminLogic->getById($admin_id);
            if($adminResult['status']==2||($adminResult['status']==1&&empty($adminResult['result'])))
            {
                PubFunc::logOut();
                $this->toTip('查询用户信息错误或者用户已被禁用',HTTP_DOMAIN.'/'.MANAGE_ACCESS_NAME);exit;
            }
            $uri = strtolower(trim(PATH,'/'));
            $chkResult = CheckPrivilegePerAccess::chkPrivilegeByUriAndAdminID($uri,$admin_id);
            if($chkResult['status']==2)
            {
                if(\Core\PubFunc::isAjax())
                {
                    echo json_encode(\Core\PubFunc::returnArray(2,false,$chkResult['msg']));exit;
                }
                $this->toTip($chkResult['msg'],HTTP_DOMAIN.'/adminmain');exit;
            }

        }
        //echo 'action before controller';
        //记录每次操作日志
    }
}