<?php 
namespace App\Model;
use Core\BaseModel;
use Core\PdoHelper;
class ProvinceModel extends BaseModel{
	public $fields=array(
		'id'=>'主键',
		'province_id'=>'省份编号',
		'province_name'=>'省份名称',
		'is_del'=>'是否可用',
	);
	public $pk='id';
    function __construct($inputPdoHelper = NULL){
        parent::__construct($inputPdoHelper);
        $this->tableName = 'province';
        $this->_validateRuleArray = array(
			'province_id'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'省份编号的值必须是整数且必须是正数,最大长度11'),
			'province_name'=>array('rule'=>'/^(.*){1,1}$/','tip'=>'省份名称的值必须是字符且,最大长度32'),
			'is_del'=>array('rule'=>'/^-{0,0}[0-9]{1,1}$/','tip'=>'是否可用的值必须是整数且必须是正数,最大长度1')
		);

        $this->_testData = array(
			'province_id'=>0,
			'province_name'=>'无',
			'is_del'=>1
		);

    }
	public function insertTest(){
		$sql = "INSERT INTO province (id,province_id,province_name,is_del) VALUES (NULL,:province_id,:province_name,:is_del)";
        //验证插入的数据是否符合数据库定义的字段规则
        $chkDataArray = $this->validateDbField($this->_testData,$this->_validateRuleArray);
        if($chkDataArray['status']==1)
        {
            $insertResultArray = $this->pdoHelper->setSql($sql)->setParam($chkDataArray['result'])->insert();
            return $insertResultArray;
        }
        return $chkDataArray;
	}
}