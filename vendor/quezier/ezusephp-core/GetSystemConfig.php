<?php
/**
 * Created by PhpStorm.
 * User: fyq
 * Date: 2017/3/9
 * Time: 15:45
 */

namespace Core;


use App\Logic\SystemConfigLogic;

class GetSystemConfig
{
    /**
     * 根据系统配置英文名称获取配置
     * @param array $param 一维参数数组
     * @return array
     *
     */
    static function getByEnName($param)
    {
        $where = 'WHERE is_del=1 AND (';
        $tmpParam = array();
        if(!empty($param)&&count($param)>0&&is_array($param))
        {
            foreach ($param as $pKey => $pVal)
            {
                $where.=" en_name='".$pVal."' or";
            }
            $where=rtrim($where,' or');
            $where.=' )';
        }
        else{
            return PubFunc::returnArray(2,false,'参数错误');
        }
        $sysConfigLogic = new SystemConfigLogic();
        $rs = $sysConfigLogic->getAll('',$where,null,'*');
        if($rs['status']==2||($rs['status']==1&&empty($rs['result'])))
        {
            return PubFunc::returnArray(2,false,'');
        }
        $config = array();
        foreach ($rs['result'] as $cKey => $cVal)
        {
            $config[$cVal['en_name']]['config_value'] = $cVal['config_value'];
            $config[$cVal['en_name']]['config_name'] = $cVal['config_name'];

        }
        return  PubFunc::returnArray(1,$config,'');
    }
}