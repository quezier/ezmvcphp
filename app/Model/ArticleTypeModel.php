<?php 
namespace App\Model;
use Core\BaseModel;
use Core\PdoHelper;
class ArticleTypeModel extends BaseModel{
	public $fields=array(
		'id'=>'主键',
		'type_name'=>'类型名称',
		'sort'=>'排序',
		'is_del'=>'是否可用',
	);
	public $pk='id';
    function __construct($inputPdoHelper = NULL){
        parent::__construct($inputPdoHelper);
        $this->tableName = 'article_type';
        $this->_validateRuleArray = array(
			'type_name'=>array('rule'=>'/^(.*){1,1}$/','tip'=>'类型名称的值必须是字符且,最大长度45'),
			'sort'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'排序的值必须是整数且必须是正数,最大长度11'),
			'is_del'=>array('rule'=>'/^-{0,0}[0-9]{1,1}$/','tip'=>'是否可用的值必须是整数且必须是正数,最大长度1')
		);

        $this->_testData = array(
			'type_name'=>'无',
			'sort'=>0,
			'is_del'=>1
		);

    }
	public function insertTest(){
		$sql = "INSERT INTO article_type (id,type_name,sort,is_del) VALUES (NULL,:type_name,:sort,:is_del)";
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