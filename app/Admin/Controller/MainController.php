<?php

namespace App\Admin\Controller;
use App\Logic\CityLogic;
use App\Logic\CountryLogic;
use Core\BaseController;
use Core\PasswordEncrypted;
use App\Logic\AdminLogic;
use Core\PubFunc;

/**
 * 后台主入口
 *
 * @author Fuyingque
 */
class MainController extends BaseController {

    private $adminLogic;
    function __construct()
    {
        parent::__construct();
        $this->adminLogic = new AdminLogic();
    }

    function index() {
        $this->display();
    }

    function doModifyAdminUserPwd(){
        $data["id"]=$_SESSION["admin_id"];
        $data["pwd"]= PasswordEncrypted::encryptPassword($_GET["password1"]);
        $res=$this->adminLogic->update($data);
        echo json_encode($res);
    }

    function toGetCity()
    {
        $provinceID = !empty($_GET['province_id'])?$_GET['province_id']:0;
        if(empty($provinceID))
        {
            echo json_encode(PubFunc::returnArray(2,false,'缺少省id'));exit;
        }
        $cityLogic = new CityLogic();
        $cityResult = $cityLogic->getAll('','WHERE is_del=1 AND province_id=:province_id',array('province_id'=>$provinceID),'*');
        if($cityResult['status']==1&&!empty($cityResult['result']))
        {
            echo json_encode(PubFunc::returnArray(1,$cityResult['result'],'查询市成功'));exit;
        }
        else{
            echo json_encode(PubFunc::returnArray(2,false,'查询市失败'));exit;
        }
    }

    function toGetCountry()
    {
        $cityID = !empty($_GET['city_id'])?$_GET['city_id']:0;
        if(empty($cityID))
        {
            echo json_encode(PubFunc::returnArray(2,false,'缺少市id'));exit;
        }
        $countryLogic = new CountryLogic();
        $countryResult = $countryLogic->getAll('','WHERE is_del=1 AND city_id=:city_id',array('city_id'=>$cityID),'*');
        if($countryResult['status']==1&&!empty($countryResult['result']))
        {
            echo json_encode(PubFunc::returnArray(1,$countryResult['result'],'查询区县成功'));exit;
        }
        else{
            echo json_encode(PubFunc::returnArray(2,false,'查询区县失败'));exit;
        }
    }
}
