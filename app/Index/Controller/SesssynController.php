<?php


namespace App\Index\Controller;


use Core\BaseController;
use Core\PubFunc;

class SesssynController extends BaseController
{
    function __construct()
    {
        parent::__construct();
    }
    
    function index()
    {
        $referer = $_SERVER['HTTP_REFERER'];
        if (!empty($referer)){
            $isRightReferer = PubFunc::chkReferer($referer);
            if(empty($isRightReferer) ){
                $this->toTip('非法访问');exit;
            }
        }
        
        PubFunc::goWithHeader(HTTP_DOMAIN);exit;

    }

    function logout()
    {
        $referer = $_SERVER['HTTP_REFERER'];
        if (!empty($referer)){
            $isRightReferer = PubFunc::chkReferer($referer);
            if(empty($isRightReferer) ){
                $this->toTip('非法访问');exit;
            }
        }
        setcookie('PHPSESSID','');
        session_destroy();
        PubFunc::goWithHeader(HTTP_DOMAIN);exit;
    }
}