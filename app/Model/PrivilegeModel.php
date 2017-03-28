<?php 
namespace App\Model;
use Core\BaseModel;
use Core\PdoHelper;
class PrivilegeModel extends BaseModel{
	public $fields=array(
		'id'=>'主键',
		'privilege_name'=>'名称',
		'privilege_url'=>'路径',
		'privilege_type'=>'类型',
		'privilege_css'=>'权限css样式',
		'add_date'=>'添加时间',
		'edit_date'=>'编辑时间',
		'add_admin_id'=>'添加人id',
		'edit_admin_id'=>'编辑人id',
		'parent_id'=>'父级id',
		'rank_num'=>'权限等级',
		'privilege_sort'=>'排序',
		'is_del'=>'是否可用',
	);
	public $pk='id';
    function __construct($inputPdoHelper = NULL){
        parent::__construct($inputPdoHelper);
        $this->tableName = 'privilege';
        $this->_validateRuleArray = array(
			'privilege_name'=>array('rule'=>'/^(.*){1,1}$/','tip'=>'名称的值必须是字符且,最大长度100'),
			'privilege_url'=>array('rule'=>'/^(.*){1,1}$/','tip'=>'路径的值必须是字符且,最大长度200'),
			'privilege_type'=>array('rule'=>'/^-{0,1}[0-9]{1,2}$/','tip'=>'类型的值必须是整数且,最大长度2'),
			'privilege_css'=>array('rule'=>'/^(.*){1,1}$/','tip'=>'权限css样式的值必须是字符且,最大长度200'),
			'add_date'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'添加时间的值必须是整数且必须是正数,最大长度11'),
			'edit_date'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'编辑时间的值必须是整数且必须是正数,最大长度11'),
			'add_admin_id'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'添加人id的值必须是整数且必须是正数,最大长度11'),
			'edit_admin_id'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'编辑人id的值必须是整数且必须是正数,最大长度11'),
			'parent_id'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'父级id的值必须是整数且必须是正数,最大长度11'),
			'rank_num'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'权限等级的值必须是整数且必须是正数,最大长度11'),
			'privilege_sort'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'排序的值必须是整数且必须是正数,最大长度11'),
			'is_del'=>array('rule'=>'/^-{0,0}[0-9]{1,1}$/','tip'=>'是否可用的值必须是整数且必须是正数,最大长度1')
		);

        $this->_testData = array(
			'privilege_name'=>'无',
			'privilege_url'=>'无',
			'privilege_type'=>0,
			'privilege_css'=>'无',
			'add_date'=>0,
			'edit_date'=>0,
			'add_admin_id'=>0,
			'edit_admin_id'=>0,
			'parent_id'=>0,
			'rank_num'=>0,
			'privilege_sort'=>0,
			'is_del'=>1
		);

    }
	public function insertTest(){
		$sql = "INSERT INTO privilege (id,privilege_name,privilege_url,privilege_type,privilege_css,add_date,edit_date,add_admin_id,edit_admin_id,parent_id,rank_num,privilege_sort,is_del) VALUES (NULL,:privilege_name,:privilege_url,:privilege_type,:privilege_css,:add_date,:edit_date,:add_admin_id,:edit_admin_id,:parent_id,:rank_num,:privilege_sort,:is_del)";
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