<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/27 0027
 * Time: 上午 11:47
 */
namespace App\Logic;
use App\Model\AdminModel;
use App\Model\MoneyFlowModel;
use Core\CreateUniqueNo;
use Core\PasswordEncrypted;
use Core\PubFunc;

class AdminLogic
{

    public $adminModel;
    private $privilegeLogic;

    function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->privilegeLogic = new PrivilegeLogic();
    }

    function getAllAdmin()
    {
        $rs = $this->adminModel->selectAll('','WHERE is_del=1');
        unset($this->adminModel);
        return $rs;
    }

    function getNeedFields($needFields)
    {
        $fields = $this->adminModel->fields;
        $tmpArray = array();
        if(!empty($fields)&&!empty($needFields)&&count($needFields)>0)
        {
            foreach ($needFields as $nfKey => $nfVal)
            {
                if(array_key_exists($nfVal,$fields))
                {
                    $tmpArray[$nfVal] = $fields[$nfVal];
                }
            }
            return PubFunc::returnArray(1,$tmpArray,'获取数组成功');
        }
        else{
            return PubFunc::returnArray(2,false,'缺少参数');
        }
    }

    function selectAll()
    {
        return $this->adminModel->selectAll();
    }

    function insertTest()
    {
        return $this->adminModel->insertTest();
    }

    function selectOne($name)
    {
        $param = array(
            'email' => $name,
            'mobile' => $name,
            'name' => $name
        );
        $where = " where (`email`=:email or `mobile`=:mobile or `name`=:name) and is_del=1";
        return $this->adminModel->selectOne('',$where,$param,$field = '*');
    }

    /**
     * 根据管理员id获取分配的权限
     * @param int $adminID 管理员id
     * @return array
     */
    function getPrivilegeByAdminID($adminID)
    {
        if(!empty($adminID))
        {
            $sql = 'select mobile,email from admin  WHERE is_del=1 AND id=:id';

            $roleIDArray = $this->adminModel->selectOne($sql,'',array('id'=>$adminID),'');

            $mobile = $roleIDArray['result']['mobile'];
            $email = $roleIDArray['result']['email'];
            PubFunc::session('admin_email',$email);
            PubFunc::session('admin_mobile',$mobile);
            $distributePrivilegeArray = $this->privilegeLogic->getAllPrivilege();
            return $distributePrivilegeArray;

        }
        else{
            return PubFunc::returnArray(2,false,'缺少管理员id');
        }

    }
    /**
     * 分页查询数据
     * @param array $param
     * @return array
     */
    function pageAdminList($param)
    {
        $p = 1;
        if (!empty($param['p'])) {
            $p = $param['p'];
        }
        $where = ' WHERE 1=1 and admin.is_del=1 ';
        $changeResult = $this->adminModel->getWhereAndParamForPage($param,true);
        if($changeResult['status']==2)
        {
            return $changeResult;
        }
        $where.= $changeResult['result']['where'];
        $data = $changeResult['result']['param'];
        $where.=" ORDER BY admin.id desc";
        $sql = "select admin.id,admin.name,role.role_name as role_id,admin.mobile,admin.nick,admin.email,admin.is_del,admin.sex,admin.regdate,admin.balance,admin.freeze_money from admin LEFT JOIN role ON role.id=admin.role_id ".$where;
        $rs = $this->adminModel->page($p, 0, $sql, '',$data , $field = '*');
        return $rs;
    }

    /**
     * 插入记录
     * @param array $data
     * @return array
     */
    function insert($data)
    {
        if(!empty($data['pwd'])){
            $data['pwd'] = PasswordEncrypted::encryptPassword($data['pwd']);
        }
        $rs = $this->adminModel->insert($data);
        return $rs;
    }

    /**
     * 与测试数据合并生成插入数据，并插入,因为每个字段不能为空
     * @param array $data 要插入的数据
     * @return array
     */
    function insertFromTestData($data)
    {
        $insertTestData = $this->getInsertData();
        $data = array_merge($insertTestData, $data);
        $rs = $this->insert($data);
        return $rs;
    }

    /**
     * 检查用户名，手机，邮箱等是否重复
     * @param string $name 字段名，如：mobile,name,email
     * @param string $info 字段对应的值
     * @param string $fieldName 字段名称
     * @return array
     */
    function chkInfo($name,$info,$fieldName)
    {
        $rs = $this->adminModel->selectOne('',"WHERE {$name}=:{$name} AND is_del=1",array("{$name}"=>$info),'id');
        if($rs['status']==1&&!empty($rs['result'])&&!empty($rs['result']['id']))
        {
            return PubFunc::returnArray(2,false,$fieldName.'在数据库中已存在');
        }
        return $rs;
    }


    /**
     * 获取测试插入用的数据
     * @return array
     */
    function getInsertData()
    {
        $rs = $this->adminModel->_testData;
        $rs['regdate']=time();
        $rs['is_del']=1;
        return $rs;
    }

    /**
     * 根据主键id更新数据
     * @param array $data 要更新的数据集
     * @return array
     */
    function update($data)
    {
        $rs = $this->adminModel->updateAuto($data);
        return $rs;
    }

   
    /**
     * 根据id查询数据
     * @param int $id 主键id
     * @return array
     */
    function getById($id)
    {
        if(empty($id)){return PubFunc::returnArray(2,false,'缺少参数');}
        $rs = $this->adminModel->selectOne('','WHERE is_del=1 AND id=:id',array('id'=>$id),'*');
        return $rs;
    }

    /**
     * 根据邮箱查询用户
     * @param string $email 邮箱
     * @return array
     */
    function getByEmail($email){
        if(empty($email)){return PubFunc::returnArray(2,false,'缺少参数');}
        $rs = $this->adminModel->selectOne('','WHERE email=:email and is_del=1',array('email'=>$email),'*');
        return $rs;
    }

    /**
     * 查询用户余额
     * @param int $adminID 用户id
     * @return array
     */
    function getBalance($adminID)
    {
        if(empty($adminID)){return PubFunc::returnArray(2,false,'缺少参数');}
        $rs = $this->adminModel->selectOne('','WHERE id=:id and is_del=1',array('id'=>$adminID),'balance');
        return $rs;
    }

    /**
     * 执行sql语句
     * @param string $sql sql语句
     * @param array $param 参数数组
     * @return array
     */
    function sql($sql,$param)
    {
        $rs = $this->adminModel->sql($sql,$param);
        return $rs;
    }

}