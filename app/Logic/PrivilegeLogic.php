<?php


namespace App\Logic;

use App\Model\PrivilegeModel;
use Core\PubFunc;

class PrivilegeLogic
{
    private $privilegeModel;
    function __construct()
    {
        $this->privilegeModel = new PrivilegeModel();
    }

    function getAllPrivilege()
    {
        $rs = $this->privilegeModel->selectAll('',"WHERE privilege_type=1 AND is_del=1 AND privilege_name<>'公共权限管理'");
        unset($this->privilegeModel);
        return $rs;
    }

    function getNeedFields($needFields)
    {
        $fields = $this->privilegeModel->fields;
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

    /**
     * 根据主键id更新数据
     * @param array $data 要更新的数据集
     * @return array
     */
    function update($data)
    {
        $rs = $this->privilegeModel->updateAuto($data);
        return $rs;
    }

    function pagePrivilegeList($param)
    {
        $p = 1;
        if (!empty($param['p'])) {
            $p = $param['p'];
        }
        unset($param['p']);
        $where = ' WHERE 1=1 ';
        $changeResult = $this->privilegeModel->getWhereAndParamForPage($param);
        if($changeResult['status']==2)
        {
            return $changeResult;
        }
        $where.= $changeResult['result']['where'];
        $data = $changeResult['result']['param'];
        $where.=" ORDER BY privilege.id desc";
        $rs = $this->privilegeModel->page($p, 0, '', $where,$data , $field = '*');
        return $rs;
    }

    /**
     * 根据id查询权限
     * @param int $id 主键id
     * @return array
     */
    function getById($id)
    {
        if(empty($id)){return PubFunc::returnArray(2,false,'缺少参数');}
        $rs = $this->privilegeModel->selectOne('','WHERE id=:id',array('id'=>$id),'*');
        return $rs;
    }

    /**
     * 添加权限
     * @param array $data 添加的数据,不要包含主键id
     * @return array
     */
    function insert($data)
    {
        $rs = $this->privilegeModel->insert($data);
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
     * 获取测试插入用的数据
     * @return array
     */
    function getInsertData()
    {
        $rs = $this->privilegeModel->_testData;
        $adminInfo = PubFunc::adminInfo();
        $rs['add_admin_id']=$adminInfo['admin_id'];
        $rs['add_date']=time();
        $rs['is_del']=1;
        return $rs;
    }

    /**
     * 根据多个主键id查询数据
     * @param string $ids 多个主键id组成的字符串，以逗号隔开
     * @param string $fields 要查询的字段
     * @return array
     */
    function getByIds($ids,$fields='')
    {
        $rs = $this->privilegeModel->selectAll('',"WHERE id in(".$ids.") AND privilege_type=1 AND (rank_num=1 or rank_num=2) AND privilege_name<>'公共权限管理'",null,$fields);
        //echo $this->privilegeModel->pdoHelper->sqlDebug;exit;
        return $rs;
    }

    /**
     * 根据名称查询数据
     * @param string $name 权限名称
     * @return array
     */
    function getByName($name)
    {
        $rs = $this->privilegeModel->selectOne('','WHERE privilege_name=:name AND is_del=1',array('name'=>$name),'id');
        return $rs;
    }

    /**
     * 根据uri查询数据
     * @param string $url 权限路径
     * @return array
     */
    function getByUri($url)
    {
        $rs = $this->privilegeModel->selectOne('','WHERE privilege_url=:url AND is_del=1',array('url'=>$url),'id');

        return $rs;
    }

    /**
     * 按照权限等级重新组织权限数组
     * @param array $adminPrivileges 管理员的权限数组
     * @return array
     */
    function reBuildPrivileges($adminPrivileges)
    {
        //$adminPrivileges=PubFunc::session('admin_privileges');
        if(!empty($adminPrivileges))
        {
            $firstPrivileges = $this->getPrivilegesByRank($adminPrivileges, 1);
            foreach ($firstPrivileges as $key => $val)
            {
                $firstPrivileges[$key]['sub_pri'] = array();
                foreach ($adminPrivileges as $akey => $aval){

                    if($aval['parent_id']==$val['id'])
                    {
                        array_push($firstPrivileges[$key]['sub_pri'],$aval);
                    }
                }

            }
            return PubFunc::returnArray(1,$firstPrivileges,'解析并重新组合权限数组成功');
        }
        else{
            return PubFunc::returnArray(2,false,'确实权限数组');
        }

    }

    /**
     * 获取指定等级的权限
     * @param array $privileges 目标数组
     * @param int $rank 顶级
     * @return array
     */
    public function getPrivilegesByRank($privileges,$rank)
    {
        $tmpArray=array();
        foreach ($privileges as $key=>$value)
        {
            if($value['rank_num']==$rank)
            {
                array_push($tmpArray, $value);
            }
        }
        return $tmpArray;
    }

    /**
     * 大后台分配权限菜单使用的方获取权限的方法
     * @param int $id 作为父级id,查询下属的权限
     * @param int $role_id 角色id
     * @return array
     */
    function getPrivilege($id,$role_id)
    {

        if(empty($id))
        {
            $parent_id=0;
        }
        else
        {
            $parent_id=$id;
        }
        $condition['is_del']=1;
        //$result=$privilegeLogic->get($condition);
        $result = $this->privilegeModel->selectAll('',"WHERE is_del = 1 AND parent_id=:pid AND privilege_name<>'公共权限管理'",array('pid'=>$parent_id));

        $distributePrivilegeLogic = new DistributePrivilegeLogic();
        $distributePrivilegeArray=$distributePrivilegeLogic->getByRoleId($role_id);
        //标记当前角色拥有的权限数组
        $pointedPrivileges=$this->ParentPointer($result['result'], $distributePrivilegeArray['result']);

        unset($this->privilegeModel);
        unset($distributePrivilegeLogic);
        return $pointedPrivileges;
    }

    /**
     * 在目标权限数组中标记出指定角色拥有的权限
     * @param array $dis_privileges 目标权限数组
     * @param array $role_privileges 角色拥有的权限数组
     * @return array 标记好的目标权限数组
     */
    function ParentPointer($dis_privileges,$role_privileges)
    {
        $privileges=array();

        if(!empty($dis_privileges)&&count($dis_privileges)>0)
        {
            foreach ($dis_privileges as $k=>$v)
            {
                $tmp=array();
                $tmp['id']=$v['id'];
                $tmp['pId']=$v['parent_id'];
                $tmp['name']=$v['privilege_name'];
                $chkResult=$this->chkSub($v['id']);
                if($chkResult['status']==1&&!empty($chkResult['result']))
                {
                    $tmp['isParent']=true;//设置+号
                    //$tmp['notCheck']=false;//标记不允许选择
                    //$tmp['nocheck']=true;//父级节点不需要checkbox
                }
                //else
                //{
                //$tmp['notCheck']=true;
                if(!empty($role_privileges)&&count($role_privileges)>0)
                {
                    foreach ($role_privileges as $key=>$val)
                    {
                        if($val['privilege_id']==$v['id'])
                        {
                            $tmp['checked']=true;
                        }
                    }
                    //$tmp['checked']=true;
                }
                //}
                array_push($privileges, $tmp);
            }
        }
        else
        {
            $privileges=null;
        }
        return $privileges;
    }

    /**
     * 检查是否有子级
     * @param int $parent_id 父级id
     * @return array
     */
    function chkSub($parent_id)
    {
        $result=$this->privilegeModel->selectOne('','WHERE parent_id=:pid AND is_del = 1',array('pid'=>$parent_id), 'id');

        return $result;
    }

    /**
     * 检查路径是否重复
     * @param array $data 参数数组
     * @return array
     */
    function check($data)
    {
        $url=$data['privilege_url'];
        $result=$this->privilegeModel->selectOne('','WHERE privilege_url=:url AND is_del=1',array('url'=>$url), 'id');
        if(!empty($result['result']))
        {
            return PubFunc::returnArray(2,false,'路径已经存在');
        }
        return $result;
    }

    /**
     * 自动根据路由配置扫描添加权限记录
     */
    function autoAdd()
    {
        try {
            $routerDirPath = PROJECT_ROOT . DIR_SP . "config" . DIR_SP . "router" . DIR_SP;
            $mainRouter = require PROJECT_ROOT . DIR_SP . "config" . DIR_SP . "router" . DIR_SP . "main.php";
            $firstLevelArray = array();
            $adminConfigArray = array();
            //先找出属于管理后台的所有权限
            foreach ($mainRouter as $mrKey => $mrVal) {
                $adminConfig = array();
                if (preg_match("/^admin\/.*$/", $mrVal)) {
                    $adminConfig = require $routerDirPath . $mrVal . '.php';
                    $adminConfigArray = array_merge($adminConfigArray, $adminConfig);
                }
            }
            //按级别放置
            $firstLevelArray = $this->getCustomPrivilegesByRank($adminConfigArray, 1);
            $secondLevelArray = $this->getCustomPrivilegesByRank($adminConfigArray, 2);
            $thirdLevelArray = $this->getCustomPrivilegesByRank($adminConfigArray, 3);
            $fourLevelArray = $this->getCustomPrivilegesByRank($adminConfigArray, 4);

            /*--------------------------------------------------------------一级权限处理-------------------------------*/
            foreach ($firstLevelArray as $flaKey => $flaVal) {
                //判断当前权限是否已经存在于数据库
                $getByNameResult = $this->getByName($flaVal['privilege_name']);
                //如果不存在，就插入一条记录
                if ($getByNameResult['status'] == 1 && empty($getByNameResult['result'])) {

                    $insertTestData = $this->getInsertData();
                    $flaVal = array_merge($insertTestData, $flaVal);
                    $this->insert($flaVal);
                }
            }
            /*--------------------------------------------------------------一级权限处理结束-------------------------------*/

            $secondResult = $this->subPrivilegeHandler($secondLevelArray);
            if ($secondResult['status'] == 2) {
                return $secondResult;
            }
            $thirdResult = $this->subPrivilegeHandler($thirdLevelArray);
            if ($thirdResult['status'] == 2) {
                return $thirdResult;
            }
            $fourResult = $this->subPrivilegeHandler($fourLevelArray);
            if ($fourResult['status'] == 2) {
                return $fourResult;
            }
            return PubFunc::returnArray(1,false,'添加成功');
        }catch (\Exception $e){
            $error = PubFunc::exceptionHandler($e);
            return PubFunc::returnArray(2,false,$error);
        }
    }

    /**
     * 子级权限的添加处理
     * @param array $subPrivileges 需要添加的子级权限
     * @return array
     */
    private function subPrivilegeHandler($subPrivileges)
    {
        if(!empty($subPrivileges)&&count($subPrivileges)>0)
        {
            foreach ($subPrivileges as $flaKey => $flaVal) {
                //判断当前权限是否已经存在于数据库
                $getByNameResult = $this->getByName($flaVal['privilege_name']);
                //如果不存在，就插入一条记录
                if($getByNameResult['status']==1&&empty($getByNameResult['result']))
                {
                    //查询父级权限的id
                    $getByParentNameResult = $this->getByName($flaVal['parent_privilege_name']);
                    if($getByParentNameResult['status']==1&&!empty($getByParentNameResult['result'])&&count($getByParentNameResult['result'])>0)
                    {
                        $pid = $getByParentNameResult['result']['id'];
                        $insertTestData = $this->getInsertData();
                        $flaVal = array_merge($insertTestData,$flaVal);
                        $flaVal['parent_id']=$pid;
                        $this->insert($flaVal);
                    }
                    else{
                        return PubFunc::returnArray(2,false,"[".$flaVal['privilege_name']."]的父级目录不存在");
                    }
                }
            }
        }
        else{
            return PubFunc::returnArray(2,false,'传入的子级权限不能为空');
        }
        return PubFunc::returnArray(1,false,'子级权限添加成功');
    }

    /**
     * 从指定的权限集合中根据权限等级筛选权限
     * @param array $adminConfigArray 指定的权限集合
     * @param int $rank_num 指定等级
     * @return array
     */
    private function getCustomPrivilegesByRank($adminConfigArray,$rank_num)
    {
        $tmpArray = array();
        foreach ($adminConfigArray as $acaKey => $acaVal)
        {
            if($acaVal['rank_num']==$rank_num)
            {
                $acaVal['privilege_url'] = $acaKey;
                array_push($tmpArray,$acaVal);
            }
        }
        return $tmpArray;
    }

}