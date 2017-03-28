<?php

namespace App\Admin\Controller;

use App\Logic\AdminLogic;
use App\Logic\AdminRoleLogic;
use App\Logic\PrivilegeLogic;
use Core\BaseController;
use Core\PubFunc;
use Core\Verify;
use Core\PasswordEncrypted;

/**
 * @package        EzMvcPHP
 * @author         quezier
 * @email          33590896@qq.com
 */
class IndexController extends BaseController
{

    function index()
    {
        $this->display('Index/login');
    }

    /**
     * 登录
     */
    function doLogin()
    {
        $name = $_POST["admin_email"];
        $pwd = $_POST["admin_pwd"];
        $code = $_POST["verify"];
        $verify = new Verify();
        //检测验证码是否正确，返回true/false
        $checkCode = $verify->check($code, '');
        if ($checkCode) {
            $adminLogic = new AdminLogic();
            //根据用户名/手机号码/邮件查询用户
            $result = $adminLogic->selectOne($name);
            if (is_bool($result['result'])) {
                echo json_encode(PubFunc::returnArray('2', '', '用户不存在或被禁用！'));
            } else {
                //数据库中存储的密码
                $dataPwd = $result['result']['pwd'];
                //比较用户提交的密码与数据库中的密码是否匹配
                $boolPwd = PasswordEncrypted::verifyPassword($pwd, $dataPwd);
                if ($boolPwd) {
                    $getPrivilegeResult = $adminLogic->getPrivilegeByAdminID($result['result']['id']);
                    if ($getPrivilegeResult['status'] == 1) {
                        $loginTime = time();
                        $loginIP = PubFunc::getIP();
                        $updData = array(
                            'id'=>$result['result']['id'],
                            'login_ip'=>$loginIP,
                            'login_date'=>$loginTime
                        );
                        $updResult = $adminLogic->update($updData);
                        if($updResult['status']==2)
                        {
                            echo json_encode(PubFunc::returnArray('2', '', '更新登录数据错误！'));exit;
                        }

                        PubFunc::session('admin_id', $result['result']['id']);
                        PubFunc::session('admin_name', $result['result']['name']);

                        $privileges = $getPrivilegeResult['result'];
                        $privilegeLogic = new PrivilegeLogic();
                        $rebuildPrivileges = $privilegeLogic->reBuildPrivileges($privileges);
                        PubFunc::session('rank_privileges', $rebuildPrivileges['result']);

                        echo json_encode(PubFunc::returnArray('1', "http://" . HTTP_HOST . "/adminmain", '登录成功！'));
                    } else {
                        echo json_encode($getPrivilegeResult);
                    }
                } else {
                    echo json_encode(PubFunc::returnArray('2', '', '密码错误！'));
                }
            }
        } else {
            echo json_encode(PubFunc::returnArray('2', '', '验证码错误！'));
        }
        exit;
    }

    /**
     * 退出登录
     */
    function logout()
    {
        PubFunc::logOut();
        $this->redirect("http://" . HTTP_HOST . "/".MANAGE_ACCESS_NAME);
    }

    /**
     * 验证码
     */
    function getVerifyCode()
    {

        $verify = new Verify();
        $verify->entry();
    }

    function toForgetPwd()
    {
        $this->display();
    }

    function doForgetPwd()
    {
        $email = $_POST["email"];
        $adminLogic = new AdminLogic();
        //根据邮箱查询用户
        $res = $adminLogic->getByEmail($email);
        if ($res['result']) {
            //根据当前时间戳生成6位数密码
            $chars = '0123456789';
            $randpwd = mt_srand(time());
            while (strlen($randpwd) < 6) {
                $randpwd .= substr($chars, (mt_rand() % strlen($chars)), 1);
            }
            if (strlen($randpwd) > 6) {
                $randpwd = substr($randpwd, 0, 5);
            }
            //发送邮件
            $message = "尊敬的用户" . $email . "：您好！您的密码已修改，新密码为：" . $randpwd . "！";
            $send = PubFunc::sendEmail('超级管理员', '忘记密码', $email, $message);
            if ($send['status'] != 1) {
                echo json_encode($send);
            } else {
                $id=$res['result']['id'];
                $pwd = PasswordEncrypted::encryptPassword($randpwd);
                //更新密码
                $data['id']=$id;
                $data['pwd']=$pwd;
                $result = $adminLogic->update($data);
                echo json_encode($result);
            }

        } else {
            echo json_encode(PubFunc::returnArray('2', '', '邮箱不存在！'));
        }

        exit;
    }
}

