<?php
/**
 * Created by PhpStorm.
 * User: fyq
 * Date: 2017/3/9
 * Time: 14:21
 */

namespace Core;


use App\Logic\DataDictionaryLogic;

class GetDataDictionary
{
    /**
     * 根据字典类型id查询所属的所有字典数据
     * @param int $typeID 字典类型id
     * @return array
     */
    static function get($typeID)
    {
        $ddLogic = new DataDictionaryLogic();
        $rs = $ddLogic->getAll('','WHERE is_del=1 AND datadictionarytype_id=:typeID',array('typeID'=>$typeID),'*');
        return $rs;
    }
}