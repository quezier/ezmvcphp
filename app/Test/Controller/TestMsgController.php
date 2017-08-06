<?php
/**
 * Created by PhpStorm.
 * User: quezier
 * Date: 2017/8/6 0006
 * Time: 下午 20:19
 */

namespace App\Test\Controller;
use Aliyun\SmsSend;
use Core\BaseController;

class TestMsgController extends BaseController
{
    function __construct()
    {
        parent::__construct();
    }

    function index(){
        $demo = new SmsSend();
        $response = $demo->sendForFindPwd('13973290996',array('number'=>'666666'));
        print_r($response);
    }
}