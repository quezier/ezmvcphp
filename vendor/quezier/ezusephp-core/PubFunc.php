<?php
namespace Core;
use PHPQRCode\QRcode;

/**
 * @package        EzMvcPHP
 * @author         quezier
 * @email          33590896@qq.com
 */
class PubFunc
{
    static function varDump($obj)
    {
        echo '<pre>';
        var_dump($obj);
    }

    /**
     * 读取配置文件
     *
     * @param string $file 配置文件名称
     * @param bool $clear 是否清空配置
     * @return array
     */
    static function config($file = 'Config',$isClear = FALSE)
    {
        $configs = array();

        if($isClear)
        {
            unset($configs[$file]);
            return;
        }

        if(empty($configs[$file]))
        {
            $configFilePath = PROJECT_ROOT .DIR_SP. 'config'.DIR_SP . $file . '.php';
            if(file_exists($configFilePath))
            {
                $configs = require $configFilePath;
            }
        }

        return $configs;
    }

    /**
     * 读取系统配置
     * @param string $name
     * @return bool|mixed
     */
    static function sysConfig($name)
    {
        $sysConfig = self::config('sys');
        if(!empty($sysConfig)&&count($sysConfig)>0)
        {
            return $sysConfig[$name];
        }
        else{
            return false;
        }
    }

    /**
     * 读取数据字典配置
     * @param string $name
     * @return bool|mixed
     */
    static function ddConfig($name)
    {
        $ddConfig = self::config('data_dictionary');
        if(!empty($ddConfig)&&count($ddConfig)>0)
        {
            return $ddConfig[$name];
        }
        else{
            return false;
        }
    }

    /**
     * 创建多级目录
     * @param string $path 目录路径
     * @param int $mode 文件权限
     * @return boolean true or false
     */
    static function createMultiClassFolder($path, $mode = 0777) {
        if (!empty($path)) {
            if (\is_dir($path)) {
                return false;
            } else {
                $rs = \mkdir($path, $mode, true);
                return !empty($rs) ? true : false;
            }
        } else {
            return false;
        }
    }

    /**
     * 异常信息处理，采用php配置的方式
     * @param \Exception $e
     * @return string 错误信息
     */
    static function exceptionHandler(\Exception $e)
    {
        $errorInfo = "{$e->getMessage()} [{$e->getFile()}] ({$e->getLine()})";
        error_log($errorInfo);
        return $errorInfo;
    }

    /**
     * @param string $status 状态 1.成功 2.失败
     * @param string | array $result 结果集
     * @param string $msg 提示信息
     * @return array
     */
    static function returnArray( $status, $result, $msg)
    {
        return array('status'=>$status,'result'=>$result,'msg'=>$msg);
    }

    /**
     * 检查提交的CSRF_TOKEN
     * @param string $csrfToken CSRF_TOKEN
     * @return bool
     */
    static function checkCSRF( $csrfToken)
    {
        if(empty($_SESSION)){session_start();}
        $sessionCSRFToken = !empty($_SESSION['csrf_token'])?$_SESSION['csrf_token']:'';
        $_SESSION['csrf_token'] = null;
        unset($_SESSION['csrf_token']);
        if($sessionCSRFToken == $csrfToken)
        {
            return false;
        }
        else{
            return true;
        }
    }

    /**
     * 获取当前会话的CSRF_TOKEN
     * @return string 当前会话的CSRF_TOKEN
     */
    static function getCSRFToken()
    {
        if(empty($_SESSION)){session_start();}
        return !empty($_SESSION['csrf_token'])?$_SESSION['csrf_token']:'';
    }

    /**
     * 用session保存数据
     * @param string $key 键名
     * @param string | int | array | bool $val 要保存的值
     * @param array 其它参数值
     * @return mixed
     */
    static function session( $key,$val = false,array $param = null)
    {
        if(!$_SESSION){session_start();}
        if(empty($val))
        {
            return !empty($_SESSION[$key])?$_SESSION[$key]:false;
        }
        else{
            $_SESSION[$key] = $val;
        }
    }

    /**
     * 获取后台登录管理员用户的信息
     * @return array
     */
    static function adminInfo()
    {
        if(!$_SESSION){session_start();}
        if(empty($_SESSION['admin_id']))
        {
           return self::returnArray(2,false,'请先登录');
        }
        $admin['admin_id'] = $_SESSION['admin_id'];
        $admin['admin_name'] = $_SESSION['admin_name'];
        return $admin;
    }
    /**
     * 获取前台登录用户的信息
     * @return array
     */
    static function userInfo()
    {
        if(!$_SESSION){session_start();}
        if(empty($_SESSION['user_id']))
        {
            return self::returnArray(2,false,'请先登录');
        }
        $user['user_id'] = $_SESSION['user_id'];
        $user['user_name'] = $_SESSION['user_name'];
        return $user;
    }

    /**
     * 下划线命名法转pascal命名法
     * @param string $str 以下划线分割的字符串
     * @return string
     */
    static function lineToPascal( $str)
    {
        $tmpStrArray = explode('_', $str);
        $className = '';
        for ($i = 0; $i < count($tmpStrArray); $i++) {
            $className .= \ucfirst($tmpStrArray[$i]);
        }
        return $className;
    }

    /**
     * 当前php版本与指定的版本比较，如果小于指定版本返回false,否则返回true
     * @param string $compareVersion 指定版本，默认是7.0.1
     * @return bool
     */
    static function comparePHPVersion($compareVersion = '7.0.1'){
        if(version_compare(PHP_VERSION,$compareVersion, '<')){
            return false;
        }else{
            return true;
        }
    }
    /**
     * 发送邮件
     * @param string $fromName 发送方名称
     * @param string $fromTitle 发送方邮件标题
     * @param string $toEmail 接收方邮件名
     * @param string $message 邮件正文，可以是html
     * @param string $fromEmail 发送方邮件名
     * @param boolean $isSecure 是否使用安全连接 true:是 false:否
     * @param int $port 如果isSecure为ture，则设置此端口
     * @param string $smtpSecure 安全连接类型，默认是ssl
     * @param string $smtpHost smtp主机地址
     * @param string $userName smtp用户名
     * @param string $userPwd smtp密码
     * @return array
     */
    static function sendEmail( $fromName, $fromTitle, $toEmail, $message, $fromEmail='', $isSecure=true, $port=465, $smtpSecure='ssl', $smtpHost='', $userName='', $userPwd='')
    {
        $sysConfig=self::config('sys');
        $host=!empty($smtpHost)?$smtpHost:$sysConfig['ADMIN_SMTP_HOST'];
        $user=!empty($userName)?$userName:$sysConfig['ADMIN_SMTP_USERNAME'];
        $pwd=!empty($userPwd)?$userPwd:$sysConfig['ADMIN_SMTP_PWD'];
        $fEmail=!empty($fromEmail)?$fromEmail:$sysConfig['ADMIN_SMTP_USERNAME'];
        $mail=new PHPMailer();
        $mail->IsSMTP();                // 设置PHPMailer使用SMTP服务器发送Email
        $mail->CharSet='UTF-8';         // 设置邮件的字符编码，若不指定，则为'UTF-8'
        $mail->AddAddress($toEmail);    // 添加收件人地址，可以多次使用来添加多个收件人
        $mail->msgHTML($message);           // 设置邮件正文
        $mail->From=$fEmail;  // 设置邮件头的From字段。
        $mail->FromName=$fromName;  // 设置发件人名字
        $mail->Subject=$fromTitle;          // 设置邮件标题
        $mail->Host=$host;     // 设置SMTP服务器。
        $mail->SMTPAuth=true;           // 设置为"需要验证" ThinkPHP 的C方法读取配置文件
        $mail->Username=$user;     // 设置用户名和密码。
        $mail->Password=$pwd;
        if(!empty($isSecure))
        {
            $mail->Port=$port;
            $mail->SMTPSecure=$smtpSecure;
        }
        // 发送邮件。
        if (!$mail->send()) {
            return array('status'=>2,'result'=>false,'msg'=>"邮件发送错误: " . $mail->ErrorInfo);
        } else {
            return array('status'=>1,'result'=>false,'msg'=>"邮件发送成功");
        }
    }

    /**
     * 验证是否是ajax请求，如果是返回true,否则返回false
     * @return bool
     */
    static function isAjax()
    {
        if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * 检查来源主机是否非法
     * @return bool
     */
    static function chkReferer($referer)
    {
        $allowUrl = PubFunc::sysConfig('allow_host');
        $refereHost = explode('/',$referer);
        $refereHost = $refereHost[2];
        if(!in_array($refereHost,$allowUrl))
        {
            return false;
        }
        else{
            return true;
        }
    }

    /**
     * js跳转设定头部
     * @param $url
     */
    static function goWithHeader($url)
    {
        echo '<html><head><meta http-equiv="Content-Language" content="zh-CN"><meta HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=gb2312"><meta http-equiv="refresh"  
content="0;url='.$url.'"><title>loading ... </title></head><body>
</html>';
        exit();
    }

    /**
     * 获取用户真实 IP
     */
    static function getIP()
    {
        static $realip;
        if (isset($_SERVER)){
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $realip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $realip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")){
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            }
        }
        return $realip;
    }

    /**
     * 获取 IP  地理位置
     * 淘宝IP接口
     * @Return: array
     */
    static function getCity($ip = '')
    {
        if($ip == ''){
            $url = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json";
            $ip=json_decode(file_get_contents($url),true);
            $data = $ip;
        }else{
            $url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
            $ip=json_decode(file_get_contents($url));
            if((string)$ip->code=='1'){
                return false;
            }
            $data = (array)$ip->data;
        }

        return $data;
    }

    /**
     * 随机生成字母数字组合
     * @param int $len 长度
     * @param null $chars 默认不传参表示生成字母和数字组合，90:表示只生成小写字母，122:表示只生成大写字母
     * @return string
     */
    static function getRandomString($len, $chars=null)
    {
        if (is_null($chars)) {
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        }
        mt_srand(10000000*(double)microtime());
        for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++) {
            $str .= $chars[mt_rand(0, $lc)];
        }
        return $str;
    }

    /**
     * 生成二维码
     * @param string $str 要生成二维码的字符
     * @param string $path 存放二维码图片的路径
     * @param string $outPath 输出要存放数据库的图片路径
     * @return string
     */
    static function getQrcode($str,$path='',$outPath='')
    {
        $qrcodeFileName = date('YmdHms',time()).CreateUniqueNo::createUniqueNo().'.png';
        if(empty($path))
        {
            $path = PROJECT_ROOT.DIR_SP.'public'.DIR_SP.'images'.DIR_SP.'qrcode'.DIR_SP.$qrcodeFileName;
        }

        QRcode::png($str,$path,'L',4,2);
        if(empty($outPath))
        {
            $outPath = 'qrcode/'.$qrcodeFileName;
        }
        return $outPath;
    }

    /**
     * 退出登录清空session操作
     */
    static function logOut()
    {
        if (empty($_SESSION)) {
            session_start();
        }
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600);
        }
        $_SESSION = array();
        session_destroy();
    }
	/**
     * 输出utf-8中文
     */
    static function headerUTFEIGHT()
    {
        header("Content-type: text/html; charset=utf-8");
    }
}