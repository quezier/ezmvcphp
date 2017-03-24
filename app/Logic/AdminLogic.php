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
    private $distributePrivilegeLogic;

    function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->privilegeLogic = new PrivilegeLogic();
        $this->distributePrivilegeLogic = new DistributePrivilegeLogic();
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
            $sql = 'select role.id as role_id,role.role_name,admin.mobile,admin.email from admin LEFT JOIN role ON admin.role_id=role.id WHERE admin.is_del=1 AND admin.id=:id';

            $roleIDArray = $this->adminModel->selectOne($sql,'',array('id'=>$adminID),'');
            if($roleIDArray['status']==1&&!empty($roleIDArray['result']))
            {
                $roleID = $roleIDArray['result']['role_id'];
                $roleName = $roleIDArray['result']['role_name'];
                $mobile = $roleIDArray['result']['mobile'];
                $email = $roleIDArray['result']['email'];
                PubFunc::session('admin_role_id',$roleID);
                PubFunc::session('admin_role_name',$roleName);
                PubFunc::session('admin_email',$email);
                PubFunc::session('admin_mobile',$mobile);
                //如果当前是超级管理员，角色id固定为1
                if($roleID==1)
                {
                    //查询角色被分配的权限id,超级管理员直接返回所有可用权限
                    $distributePrivilegeArray = $this->privilegeLogic->getAllPrivilege();
                    return $distributePrivilegeArray;
                }
                else{
                    //查询角色被分配的权限id
                    $distributePrivilegeArray = $this->distributePrivilegeLogic->getByRoleId($roleID);
                    if($distributePrivilegeArray['status']==1&&is_array($distributePrivilegeArray['result'])&&count($distributePrivilegeArray['result'])>0)
                    {
                        $distributePrivileges = $distributePrivilegeArray['result'];
                        $privilegesIDs = '';
                        foreach ($distributePrivileges as $key => $val) {
                            $privilegesIDs.=$val['privilege_id'].',';
                        }
                        $privilegesIDs = rtrim($privilegesIDs,',');
                        $privilegesResult = $this->privilegeLogic->getByIds($privilegesIDs,'id,privilege_name,privilege_url,rank_num,parent_id,privilege_css');

                        if($privilegesResult['status']==1&&!empty($privilegesResult['result'])&&count($privilegesResult['result'])>0)
                        {
                            PubFunc::session('admin_privileges',$privilegesResult['result']);
                        }
                        return $privilegesResult;
                    }
                    else if($distributePrivilegeArray['status']==1&&empty($distributePrivilegeArray['result'])){
                        return PubFunc::returnArray(2,false,'该用户没有被分配权限');
                    }
                }
            }
            else{
                return PubFunc::returnArray(2,false,'没有分配角色');
            }
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

    /**根据用户ID 角色ID 权限查询
     * @param $ID
     * @param $adminID
     * @param $adminID
     * @return array
     */
    function getAdminByWhere($ID,$adminID,$roleID){
        $data=array();
        $where='';
        $data['id']=$ID;
        if($roleID==5){//大后台
            $data['manager_id']=$adminID;
            $where=' WHERE id=:id and manager_id=:manager_id';
        }else if($roleID==6){//运营中心
            $data['operation_center_id']=$adminID;
            $where=' WHERE id=:id and operation_center_id=:operation_center_id';
        }else if($roleID==7){//贸易中心
            $data['member_company_id']=$adminID;
            $where=' WHERE id=:id and member_company_id=:member_company_id';
        }else if($roleID==8){//代理中心
            $data['agent_id']=$adminID;
            $where=' WHERE id=:id and agent_id=:agent_id';
        }else if($roleID==1)//超级管理员
        {
            $where=' WHERE id=:id ';
        }else
        {
            return PubFunc::returnArray(1,false,'对不起，您没有权限！');
        }
        $where.=' and is_del=1 ';
        $rs = $this->adminModel->selectOne('',$where,$data);
        return $rs;
    }

    /**加减币
     * @param $data
     * @return array
     */
    function upAdminBalanceById($data)
    {
        $this->adminModel->beginTransaction();
        $balance=$data['balance'];
        $moneyflow=array();
        if(isset($data['addmoney'])){//加币
            $moneyflow['change_money']=abs($data['addmoney']);
            $moneyflow['trade_type']=9;
            $moneyflow['aftertrade_balance']=$balance+$moneyflow['change_money'];
            $data['balance']=$moneyflow['aftertrade_balance'];
        }
        if(isset($data['lessmoney'])){//减币
            $moneyflow['change_money']=-abs($data['lessmoney']);
            $moneyflow['trade_type']=10;
            $moneyflow['aftertrade_balance']=$balance-abs($moneyflow['change_money']);
            $data['balance']=$moneyflow['aftertrade_balance'];
        }
        $adminRs=$this->adminModel->updateAuto($data);
        if($adminRs['status']==2)
        {
            $this->adminModel->rollBack();
            return PubFunc::returnArray(2,false,'更新余额失败');
        }

        $moneyflowmodel=new MoneyFlowModel($this->adminModel->pdoHelper);
        $rechargeNo = CreateUniqueNo::createOrder();
        $adminID = PubFunc::session('admin_id');
        $roleID = PubFunc::session('admin_role_id');
        $moneyflow['op_date']=time();
        $moneyflow['pretrade_balance']=$balance;
        $moneyflow['moneyflow_no']=$rechargeNo;
        $moneyflow['trade_no']='无';
        $moneyflow['admin_id']=$data['id'];
        $moneyflow['role_id']=$roleID;
        $moneyflow['op_id']=$adminID;
        $moneyflowRs=$moneyflowmodel->insert($moneyflow);
        if($moneyflowRs['status']==2)
        {
            $this->adminModel->rollBack();
            return PubFunc::returnArray(2,false,'添加资金流水失败');
        }
        $this->adminModel->commit();
        return PubFunc::returnArray(1,false,'操作成功');
    }

}