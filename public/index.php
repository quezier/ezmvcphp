<?php
define('IS_DEBUG',true);
define('IS_REQUEST_FILTER',true);//是否开启对post,get等请求数据的关键字过滤
define('NOW_TIME',time());
define('SITE_NAME','世易优品');
define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);
define('START_TIME', microtime(true));
define('START_MEMORY_USAGE', memory_get_usage());
define('DIR_SP', DIRECTORY_SEPARATOR);
define('HTTP_HOST', $_SERVER['HTTP_HOST']);
define('SERVER_PORT', $_SERVER['SERVER_PORT']);
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('HTTP_DOMAIN', (strtolower($_SERVER['SERVER_PORT']) == 443 ? 'https' : 'http') . '://'
    . HTTP_HOST . (($p = SERVER_PORT) != 80 AND $p != 443 ? ":$p" : ''));
define('REQUEST_URI', urldecode($_SERVER['REQUEST_URI']));
define('PATH', parse_url(REQUEST_URI, PHP_URL_PATH));
define('IS_SESSION_REDIS',true);//是否使用redis保存session
define('IMG_HOST',HTTP_DOMAIN.'/images/');
define('JS_HOST',HTTP_DOMAIN);
define('CSS_HOST',HTTP_DOMAIN);
define('MANAGE_ACCESS_NAME','man');
define('SESSION_WITH_SUBDOMAIN',false);
if(SESSION_WITH_SUBDOMAIN)
{
    ini_set('session.cookie_path', '/');
    ini_set('session.cookie_domain', '.syypn.test');
    ini_set('session.cookie_lifetime', '0');
}


require "../vendor/autoload.php";
require "../boot.php";