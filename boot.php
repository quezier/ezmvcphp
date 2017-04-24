<?php
define('PROJECT_ROOT', realpath(__DIR__));
if(IS_SESSION_REDIS)
{
    ini_set('session.save_handler','redis');
    ini_set('session.save_path','tcp://127.0.0.1:6379');
}
if (IS_DEBUG) {
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    ini_set('display_errors', '1');
}

if (empty($_SESSION)) {
    session_start();
}
if(empty($_SESSION['chk_multi_submit_token']))
{
    $_SESSION['chk_multi_submit_token'] = md5(uniqid(md5(microtime(true)), true));
}
else{
    $sessionChksubmittoken = $_SESSION['chk_multi_submit_token'];
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $curMultiSubmitToken = !empty($_POST['chk_multi_submit_token'])?$_POST['chk_multi_submit_token']:'';
    }
    elseif ($_SERVER['REQUEST_METHOD']=='GET')
    {
        $curMultiSubmitToken = !empty($_GET['chk_multi_submit_token'])?$_GET['chk_multi_submit_token']:'';
    }
    if(!empty($curMultiSubmitToken))
    {
        chkMutiSubmit($sessionChksubmittoken,$curMultiSubmitToken);
    }

}
function chkMutiSubmit($sessionToken,$curToken)
{
    if ($sessionToken==$curToken) {
        $_SESSION['chk_multi_submit_token'] = md5(uniqid(md5(microtime(true)), true));

    } else {
        gotoTip("重复提交");
        exit;

    }
}
if(empty($_SESSION['csrf_token']))
{
    $_SESSION['csrf_token'] = md5(uniqid(md5(microtime(true)), true));
}
else{
    $sessionCSRFToken = $_SESSION['csrf_token'];
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $curCSRFToken = !empty($_POST['csrf_token'])?$_POST['csrf_token']:'';
    }
    elseif ($_SERVER['REQUEST_METHOD']=='GET')
    {
        $curCSRFToken = !empty($_GET['csrf_token'])?$_GET['csrf_token']:'';
    }
    if(!empty($curCSRFToken))
    {
        $_SESSION['csrf_token'] = md5(uniqid(md5(microtime(true)), true));
        chkMutiSubmit($sessionCSRFToken,$curCSRFToken);
    }

}
function chkCSRFToken($sessionCSRFToke,$curCSRFToken)
{
    if($sessionCSRFToke!=$curCSRFToken)
    {
        gotoTip("非法提交");
        exit;
    }
}

$_GET=array();
//如果不是首页
if (PATH != "/") {

    if(REQUEST_METHOD=='GET') {
        //如果url带有?号
        $questionPos = strpos(REQUEST_URI, '?');
        if (!empty($questionPos)) {
            $questionUrlArray = explode("?", REQUEST_URI);
            //判断?后面是否有参数
            if (!empty($questionUrlArray[1])) {
                //判断?后面是否有&号
                $andPos = strpos($questionUrlArray[1], '&');
                if (!empty($andPos)) {
                    $questionUrlAndArray = explode("&", $questionUrlArray[1]);
                    foreach ($questionUrlAndArray as $questionUrlAndVal) {
                        if (!empty($questionUrlAndVal)) {
                            $questionUrlAndValArray = explode("=", $questionUrlAndVal);
                            $_GET[$questionUrlAndValArray[0]] = $questionUrlAndValArray[1];
                        }

                    }
                } else {
                    $eqPos = strpos($questionUrlArray[1], '=');
                    if (!empty($eqPos)) {
                        $eqParamArray = explode("=", $questionUrlArray[1]);
                        $_GET[$eqParamArray[0]] = $eqParamArray[1];
                    }

                }
            }
        }
    }
    //处理斜杠传参的情况
    $tmpPath = trim(PATH, "/");
    $tmpPathArr = explode("/", $tmpPath);
    $searchPath = array_shift($tmpPathArr);
    //如果带参数
    $paramCount = count($tmpPathArr);
    if ($paramCount > 1) {
        if ($paramCount % 2 == 0) {
            $tmpGetArr = array();
            $keyArray = array();
            $valArray = array();
            for ($i = 0; $i < count($tmpPathArr); $i++) {
                if (($i + 1) % 2 == 0) {
                    array_push($valArray, $tmpPathArr[$i]);
                } else {
                    array_push($keyArray, $tmpPathArr[$i]);
                }
            }
            for ($i = 0; $i < count($keyArray); $i++) {
                $tmpGetArr[$keyArray[$i]] = $valArray[$i];
            }
            $_GET = array_merge($_GET, $tmpGetArr);
        } else {
            gotoTip("参数名与值不对应");
            exit;
        }
    }
} else {
    $searchPath = PATH;
}

if (IS_REQUEST_FILTER) {
    //检查请求参数是否安全
    filterAction();
}

//选择路由
$currentRouter = selectRouter($searchPath);
$requestMethod = $currentRouter['method'];
if ($requestMethod != $_SERVER['REQUEST_METHOD']) {
    gotoTip('请求方式错误');
}
//针对子域名的情况进行处理，如果要使用泛域名，可以在这里处理
if (PATH == '/') {
    $routerCallArray = $currentRouter['call'];
    $httpHostArray = explode('.', HTTP_HOST);
    $requestCall = empty($currentRouter['call'][$httpHostArray[0]]) ? '' : $currentRouter['call'][$httpHostArray[0]];
    //如果地址栏输入的子域名不是www而且在路由配置也匹配不到的话，默认使用首页对应call的第一个元素
    if (empty($requestCall)) {
        foreach ($currentRouter['call'] as $key => $val) {
            $requestCall = $val;
            break;
        }
    }
} else {
    $requestCall = $currentRouter['call'];
}

//如果是闭包函数直接执行
if (is_object($requestCall)) {
    call_user_func($requestCall);
}//如果是路由就解析
elseif (is_string($requestCall)) {

    $requestCallArr = explode('/', $requestCall);
    $module = $requestCallArr[0];
    $controller = $requestCallArr[1];
    $function = $requestCallArr[2];

    define('MODULE', $module);
    define('CONTROLLER', $controller);
    define('ACTION', $function);
    $injectArray = require PROJECT_ROOT . DIR_SP . 'config' . DIR_SP . 'inject.php';
    if (!empty($injectArray) && count($injectArray) > 0) {
        $preControllerClass = $injectArray['pre_controller']['class'];
        $preControllerAction = $injectArray['pre_controller']['action'];
        $preController = new $preControllerClass();
        $preController->$preControllerAction();
    }

    $class = 'App\\' . MODULE . '\Controller\\' . CONTROLLER . 'Controller';
    $controllerObj = new $class();
    $controllerObj->$function();
} else {
    gotoTip('无法解析的路由');
}

if (!empty($injectArray) && count($injectArray) > 0) {
    $preControllerClass = $injectArray['after_controller']['class'];
    $preControllerAction = $injectArray['after_controller']['action'];
    $preController = new $preControllerClass();
    $preController->$preControllerAction();
}
//选择路由
function selectRouter($searchPath)
{
    $routerConfigPath = PROJECT_ROOT.DIR_SP."config".DIR_SP."router".DIR_SP;
    $routerConfigNameArr = require $routerConfigPath . "main.php";
    $currentRouter = array();
    $isHaveRouter = false;
    foreach ($routerConfigNameArr as $key => $val) {
        $tmpConfigArray = null;
        if (!empty($val)) {
            $tmpConfigFilePath = $routerConfigPath . $val . '.php';
            if(file_exists($tmpConfigFilePath))
            {
                $tmpConfigArray = require $tmpConfigFilePath;
            }
            else{
                continue;
            }

            $currentRouter = !empty($tmpConfigArray[$searchPath]) ? $tmpConfigArray[$searchPath] : false;
            if (!empty($currentRouter)) {
                $isHaveRouter = true;
                break;
            }
        }

    }
    unset($tmpConfigArray);
    if(empty($isHaveRouter))
    {
        gotoTip('404');
    }
    return $currentRouter;
}

function checkVal($val, $rule)
{
    if (preg_match("/" . $rule . "/is", $val) == 1) {
        gotoTip(参数有安全问题);
    } else {
        return $val;
    }
}

function filterVal($arr, $rule)
{
    if (is_array($arr)) {
        foreach ((array)$arr as $key => $value) {

            if (!is_array($value)) {
                $arr[$key] = checkVal($value, $rule);
            } else {
                filterVal($arr[$key], $rule);
            }
        }
    }
}

function filterAction()
{
    //get拦截规则
    $getfilter = "\\<.+javascript:window\\[.{1}\\\\x|<.*=(&#\\d+?;?)+?>|<.*(data|src)=data:text\\/html.*>|\\b(alert\\(|confirm\\(|expression\\(|prompt\\(|benchmark\s*?\(.*\)|sleep\s*?\(.*\)|load_file\s*?\\()|<[a-z]+?\\b[^>]*?\\bon([a-z]{4,})\s*?=|^\\+\\/v(8|9)|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.*\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)|UPDATE\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE)@{0,2}(\\(.+\\)|\\s+?.+?\\s+?|(`|'|\").*?(`|'|\"))FROM(\\(.+\\)|\\s+?.+?|(`|'|\").*?(`|'|\"))|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
    //post拦截规则
    $postfilter = "<.*=(&#\\d+?;?)+?>|<.*data=data:text\\/html.*>|\\b(alert\\(|confirm\\(|expression\\(|prompt\\(|benchmark\s*?\(.*\)|sleep\s*?\(.*\)|load_file\s*?\\()|<[^>]*?\\b(onerror|onmousemove|onload|onclick|onmouseover)\\b|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.*\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)|UPDATE\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE)(\\(.+\\)|\\s+?.+?\\s+?|(`|'|\").*?(`|'|\"))FROM(\\(.+\\)|\\s+?.+?|(`|'|\").*?(`|'|\"))|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
    //cookie拦截规则
    $cookiefilter = "benchmark\s*?\(.*\)|sleep\s*?\(.*\)|load_file\s*?\\(|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.*\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)|UPDATE\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE)@{0,2}(\\(.+\\)|\\s+?.+?\\s+?|(`|'|\").*?(`|'|\"))FROM(\\(.+\\)|\\s+?.+?|(`|'|\").*?(`|'|\"))|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
    if (!empty($_POST) && count($_POST) > 0) {
        filterVal($_POST, $postfilter);
    }
    if (!empty($_GET) && count($_GET) > 0) {
        filterVal($_GET, $getfilter);
    }
    if (!empty($_FILES) && count($_FILES) > 0) {
        filterVal($_FILES, $postfilter);
    }
    if (!empty($_COOKIE) && count($_COOKIE) > 0) {
        filterVal($_COOKIE, $cookiefilter);
    }
    if (!empty($_REQUEST) && count($_REQUEST) > 0) {
        filterVal($_REQUEST, $postfilter);
    }
}
function gotoTip($info,$url='')
{
    if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
        echo json_encode(array('status'=>2,'result'=>false,'msg'=>$info));exit;
    }else{
        if(empty($url))
        {
            $uri = trim(PATH,'/');
            if(substr($uri,0,6)=='admin_'||substr($uri,0,5)=='admin')
            {
                header("Location: http://".HTTP_HOST."/publictip?info=".urlencode($info)."&tip_url=".urlencode(HTTP_DOMAIN.'/'.MANAGE_ACCESS_NAME));
                exit;
            }
            else{
                header("Location: http://".HTTP_HOST."/publictip?info=".urlencode($info)."&tip_url=".urlencode(HTTP_DOMAIN));
                exit;
            }
        }
        header("Location: http://".HTTP_HOST."/publictip?info=".urlencode($info)."&tip_url=".urlencode($url));
        exit;
    }

}