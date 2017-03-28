<?php 
namespace App\Model;
use Core\BaseModel;
use Core\PdoHelper;
class CountryModel extends BaseModel{
	public $fields=array(
		'id'=>'主键',
		'city_id'=>'市编号',
		'country_id'=>'地区编号',
		'country_name'=>'名称',
		'is_del'=>'是否可用',
	);
	public $pk='id';
    function __construct($inputPdoHelper = NULL){
        parent::__construct($inputPdoHelper);
        $this->tableName = 'country';
        $this->_validateRuleArray = array(
			'city_id'=>array('rule'=>'/^-{0,0}[0-9]{1,20}$/','tip'=>'市编号的值必须是整数且必须是正数,最大长度20'),
			'country_id'=>array('rule'=>'/^-{0,0}[0-9]{1,20}$/','tip'=>'地区编号的值必须是整数且必须是正数,最大长度20'),
			'country_name'=>array('rule'=>'/^(.*){1,1}$/','tip'=>'名称的值必须是字符且,最大长度64'),
			'is_del'=>array('rule'=>'/^-{0,0}[0-9]{1,1}$/','tip'=>'是否可用的值必须是整数且必须是正数,最大长度1')
		);

        $this->_testData = array(
			'city_id'=>0,
			'country_id'=>0,
			'country_name'=>'无',
			'is_del'=>1
		);

    }
	public function insertTest(){
		$sql = "INSERT INTO country (id,city_id,country_id,country_name,is_del) VALUES (NULL,:city_id,:country_id,:country_name,:is_del)";
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