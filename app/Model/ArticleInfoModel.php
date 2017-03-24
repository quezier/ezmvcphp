<?php 
namespace App\Model;
use Core\BaseModel;
use Core\PdoHelper;
class ArticleInfoModel extends BaseModel{
	public $fields=array(
		'id'=>'主键',
		'article_type_id'=>'文章类型',
		'title'=>'标题',
		'content'=>'文章内容',
		'user_id'=>'作者',
		'pub_date'=>'发布时间',
		'sort'=>'排序',
		'is_del'=>'是否可用',
	);
	public $pk='id';
    function __construct($inputPdoHelper = NULL){
        parent::__construct($inputPdoHelper);
        $this->tableName = 'article_info';
        $this->_validateRuleArray = array(
			'article_type_id'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'文章类型的值必须是整数且必须是正数,最大长度11'),
			'title'=>array('rule'=>'/^(.*){1,1}$/','tip'=>'标题的值必须是字符且,最大长度100'),
			'content'=>array('rule'=>'text_5000','tip'=>'文章内容的值必须是'),
			'user_id'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'作者的值必须是整数且必须是正数,最大长度11'),
			'pub_date'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'发布时间的值必须是整数且必须是正数,最大长度11'),
			'sort'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'排序的值必须是整数且必须是正数,最大长度11'),
			'is_del'=>array('rule'=>'/^-{0,0}[0-9]{1,1}$/','tip'=>'是否可用的值必须是整数且必须是正数,最大长度1')
		);

        $this->_testData = array(
			'article_type_id'=>0,
			'title'=>'无',
			'content'=>'无',
			'user_id'=>0,
			'pub_date'=>0,
			'sort'=>0,
			'is_del'=>1
		);

    }
	public function insertTest(){
		$sql = "INSERT INTO article_info (id,article_type_id,title,content,user_id,pub_date,sort,is_del) VALUES (NULL,:article_type_id,:title,:content,:user_id,:pub_date,:sort,:is_del)";
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