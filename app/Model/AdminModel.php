<?php 
namespace App\Model;
use Core\BaseModel;
use Core\PdoHelper;
class AdminModel extends BaseModel{
	public $fields=array(
		'id'=>'主键',
		'certificatetype_id'=>'证件类型',
		'certificate_value'=>'证件编号',
		'role_id'=>'角色id',
		'email'=>'邮箱',
		'mobile'=>'手机',
		'name'=>'用户名',
		'pwd'=>'密码',
		'img'=>'头像',
		'nick'=>'负责人',
		'sex'=>'性别',
		'invitation_code'=>'邀请码',
		'invitationcode_path'=>'二维码路径',
		'balance'=>'余额',
		'freeze_money'=>'冻结资金',
		'broker_id'=>'上级经纪人',
		'agent_id'=>'所属代理',
		'member_company_id'=>'所属贸易商',
		'operation_center_id'=>'所属运营商',
		'manager_id'=>'大后台',
		'is_recharge'=>'是否允许充值',
		'is_getcash'=>'是否允许提现',
		'operationcenter_commission_percent'=>'运营佣金比例',
		'commerce_commission_percent'=>'贸易商佣金比例',
		'broker_commission_percent'=>'经纪人佣金比例',
		'agent_sharebonus_percent'=>'代理分红比例',
		'is_trade'=>'是否允许交易',
		'is_riskuser'=>'是否风险用户',
		'regdate'=>'注册时间',
		'edtdate'=>'最后修改时间',
		'login_date'=>'登录时间',
		'edtid'=>'修改人id',
		'regip'=>'注册ip',
		'login_ip'=>'登录ip',
		'login_error'=>'登录错误次数',
		'is_del'=>'是否可用',
	);
	public $pk='id';
    function __construct($inputPdoHelper = NULL){
        parent::__construct($inputPdoHelper);
        $this->tableName = 'admin';
        $this->_validateRuleArray = array(
			'certificatetype_id'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'证件类型的值必须是整数且必须是正数,最大长度11'),
			'certificate_value'=>array('rule'=>'/^(.*){1,1}$/','tip'=>'证件编号的值必须是字符且,最大长度100'),
			'role_id'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'角色id的值必须是整数且必须是正数,最大长度11'),
			'email'=>array('rule'=>'/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i','tip'=>'邮箱的值必须是邮箱'),
			'mobile'=>array('rule'=>'/^(1(([35][0-9])|(47)|[8][0126789]))\d{8}$/','tip'=>'手机的值必须是手机'),
			'name'=>array('rule'=>'/^(.*){1,1}$/','tip'=>'用户名的值必须是字符且,最大长度200'),
			'pwd'=>array('rule'=>'/^(.*){1,1}$/','tip'=>'密码的值必须是字符且,最大长度64'),
			'img'=>array('rule'=>'/^(.*){1,1}$/','tip'=>'头像的值必须是字符且,最大长度100'),
			'nick'=>array('rule'=>'/^(.*){1,1}$/','tip'=>'负责人的值必须是字符且,最大长度50'),
			'sex'=>array('rule'=>'/^-{0,1}[0-9]{1,1}$/','tip'=>'性别的值必须是整数且,最大长度1'),
			'invitation_code'=>array('rule'=>'/^(.*){1,1}$/','tip'=>'邀请码的值必须是字符且,最大长度6'),
			'invitationcode_path'=>array('rule'=>'/^(.*){1,1}$/','tip'=>'二维码路径的值必须是字符且,最大长度100'),
			'balance'=>array('rule'=>'/^-{0,1}[0-9]{1,9}\.{0,1}[0-9]{0,2}$/','tip'=>'余额的值必须是小数且,最大长度11'),
			'freeze_money'=>array('rule'=>'/^-{0,1}[0-9]{1,9}\.{0,1}[0-9]{0,2}$/','tip'=>'冻结资金的值必须是小数且,最大长度11'),
			'broker_id'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'上级经纪人的值必须是整数且必须是正数,最大长度11'),
			'agent_id'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'所属代理的值必须是整数且必须是正数,最大长度11'),
			'member_company_id'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'所属贸易商的值必须是整数且必须是正数,最大长度11'),
			'operation_center_id'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'所属运营商的值必须是整数且必须是正数,最大长度11'),
			'manager_id'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'大后台的值必须是整数且必须是正数,最大长度11'),
			'is_recharge'=>array('rule'=>'/^-{0,0}[0-9]{1,1}$/','tip'=>'是否允许充值的值必须是整数且必须是正数,最大长度1'),
			'is_getcash'=>array('rule'=>'/^-{0,0}[0-9]{1,1}$/','tip'=>'是否允许提现的值必须是整数且必须是正数,最大长度1'),
			'operationcenter_commission_percent'=>array('rule'=>'/^-{0,0}[0-9]{1,1}\.{0,1}[0-9]{0,3}$/','tip'=>'运营佣金比例的值必须是小数且必须是正数,最大长度4'),
			'commerce_commission_percent'=>array('rule'=>'/^-{0,0}[0-9]{1,1}\.{0,1}[0-9]{0,3}$/','tip'=>'贸易商佣金比例的值必须是小数且必须是正数,最大长度4'),
			'broker_commission_percent'=>array('rule'=>'/^-{0,0}[0-9]{1,1}\.{0,1}[0-9]{0,3}$/','tip'=>'经纪人佣金比例的值必须是小数且必须是正数,最大长度4'),
			'agent_sharebonus_percent'=>array('rule'=>'/^-{0,0}[0-9]{1,1}\.{0,1}[0-9]{0,3}$/','tip'=>'代理分红比例的值必须是小数且必须是正数,最大长度4'),
			'is_trade'=>array('rule'=>'/^-{0,0}[0-9]{1,1}$/','tip'=>'是否允许交易的值必须是整数且必须是正数,最大长度1'),
			'is_riskuser'=>array('rule'=>'/^-{0,0}[0-9]{1,1}$/','tip'=>'是否风险用户的值必须是整数且必须是正数,最大长度1'),
			'regdate'=>array('rule'=>'/^-{0,1}[0-9]{1,11}$/','tip'=>'注册时间的值必须是整数且,最大长度11'),
			'edtdate'=>array('rule'=>'/^-{0,1}[0-9]{1,11}$/','tip'=>'最后修改时间的值必须是整数且,最大长度11'),
			'login_date'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'登录时间的值必须是整数且必须是正数,最大长度11'),
			'edtid'=>array('rule'=>'/^-{0,0}[0-9]{1,11}$/','tip'=>'修改人id的值必须是整数且必须是正数,最大长度11'),
			'regip'=>array('rule'=>'/^(.*){1,1}$/','tip'=>'注册ip的值必须是字符且,最大长度50'),
			'login_ip'=>array('rule'=>'/^(.*){1,1}$/','tip'=>'登录ip的值必须是字符且,最大长度50'),
			'login_error'=>array('rule'=>'/^-{0,1}[0-9]{1,2}$/','tip'=>'登录错误次数的值必须是整数且,最大长度2'),
			'is_del'=>array('rule'=>'/^-{0,1}[0-9]{1,1}$/','tip'=>'是否可用的值必须是整数且,最大长度1')
		);

        $this->_testData = array(
			'certificatetype_id'=>0,
			'certificate_value'=>'无',
			'role_id'=>0,
			'email'=>'test@test.com',
			'mobile'=>'13888888888',
			'name'=>'无',
			'pwd'=>'无',
			'img'=>'无',
			'nick'=>'无',
			'sex'=>0,
			'invitation_code'=>'无',
			'invitationcode_path'=>'无',
			'balance'=>0.0,
			'freeze_money'=>0.0,
			'broker_id'=>0,
			'agent_id'=>0,
			'member_company_id'=>0,
			'operation_center_id'=>0,
			'manager_id'=>0,
			'is_recharge'=>0,
			'is_getcash'=>0,
			'operationcenter_commission_percent'=>0.0,
			'commerce_commission_percent'=>0.0,
			'broker_commission_percent'=>0.0,
			'agent_sharebonus_percent'=>0.0,
			'is_trade'=>0,
			'is_riskuser'=>0,
			'regdate'=>0,
			'edtdate'=>0,
			'login_date'=>0,
			'edtid'=>0,
			'regip'=>'无',
			'login_ip'=>'无',
			'login_error'=>0,
			'is_del'=>1
		);

    }
	public function insertTest(){
		$sql = "INSERT INTO admin (id,certificatetype_id,certificate_value,role_id,email,mobile,name,pwd,img,nick,sex,invitation_code,invitationcode_path,balance,freeze_money,broker_id,agent_id,member_company_id,operation_center_id,manager_id,is_recharge,is_getcash,operationcenter_commission_percent,commerce_commission_percent,broker_commission_percent,agent_sharebonus_percent,is_trade,is_riskuser,regdate,edtdate,login_date,edtid,regip,login_ip,login_error,is_del) VALUES (NULL,:certificatetype_id,:certificate_value,:role_id,:email,:mobile,:name,:pwd,:img,:nick,:sex,:invitation_code,:invitationcode_path,:balance,:freeze_money,:broker_id,:agent_id,:member_company_id,:operation_center_id,:manager_id,:is_recharge,:is_getcash,:operationcenter_commission_percent,:commerce_commission_percent,:broker_commission_percent,:agent_sharebonus_percent,:is_trade,:is_riskuser,:regdate,:edtdate,:login_date,:edtid,:regip,:login_ip,:login_error,:is_del)";
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