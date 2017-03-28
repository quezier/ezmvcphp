<?php 
namespace App\Model;
use Core\BaseModel;
use Core\PdoHelper;
class AdminGalleryModel extends BaseModel{
	public $fields=array(
		'id'=>'主键',
		'admin_id'=>'管理员',
		'img_url'=>'图片地址',
		'add_date'=>'发布时间',
		'is_del'=>'是否可用',
	);
	public $pk='id';
    function __construct($inputPdoHelper = NULL){
        parent::__construct($inputPdoHelper);
        $this->tableName = 'admin_gallery';
        $this->_validateRuleArray = array(
			'admin_id'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'管理员的值必须是整数且必须是正数,最大长度11'),
			'img_url'=>array('rule'=>'/^(.*){1,1}$/','tip'=>'图片地址的值必须是字符且,最大长度100'),
			'add_date'=>array('rule'=>'/^-{0,1}[0-9]{1,11}$/','tip'=>'发布时间的值必须是整数且,最大长度11'),
			'is_del'=>array('rule'=>'/^-{0,1}[0-9]{1,1}$/','tip'=>'是否可用的值必须是整数且,最大长度1')
		);

        $this->_testData = array(
			'admin_id'=>0,
			'img_url'=>'无',
			'add_date'=>0,
			'is_del'=>1
		);

    }
	public function insertTest(){
		$sql = "INSERT INTO admin_gallery (id,admin_id,img_url,add_date,is_del) VALUES (NULL,:admin_id,:img_url,:add_date,:is_del)";
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