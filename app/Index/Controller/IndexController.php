<?php
namespace App\Index\Controller;
use App\Logic\ArticleInfoLogic;
use Core\BaseController;

/**
 * @package        EzMvcPHP
 * @author         quezier
 * @email          33590896@qq.com
 */
class IndexController extends BaseController
{

    function index()
    {
        $articleInfoLogic = new ArticleInfoLogic();
        $articleInfoResult = $articleInfoLogic->getSomeArticleInfo(20);
        $this->setVariable('articles',$articleInfoResult['result']);
        $this->display();
        //$this->toTip('注意这是错误提示','http://www.test.ed/adminindex/');
    }

    function detail()
    {
        $id = !empty($_GET['id'])?$_GET['id']:0;
        $articleInfoLogic = new ArticleInfoLogic();
        $articleResult = $articleInfoLogic->getById($id);
        $article = $articleResult['result'];
        $this->setVariable('article',$article);
        $this->display();
    }

    function search()
    {
        $word = $_GET['search_word'];
        $articleInfoLogic = new ArticleInfoLogic();
        if(!empty($word))
        {
            $articleInfoResult = $articleInfoLogic->getBySearch($word);
            $this->setVariable('articles',$articleInfoResult['result']);
        }
        else{
            $articleInfoResult = $articleInfoLogic->getSomeArticleInfo(20);
            $this->setVariable('articles',$articleInfoResult['result']);
        }
        $this->display();
    }
    /**
     * 用于提示后自动跳转
     */
    function tip()
    {
		if(!empty($_GET['tip_url']))
        {
            $tmpUrlArr = parse_url($_GET['tip_url']);
            $host = $tmpUrlArr['host'];
            $has_http = true;
            //如果tip_url不带http://的话，就没有host元素
            if(empty($host))
            {
                $tmpUrlArr = parse_url('http://'.$_GET['tip_url']);
                $host = $tmpUrlArr['host'];
                $has_http = false;
            }
            $curHost = HTTP_HOST;
            if($host!=$curHost)
            {
                $info = '非法域名';
                $url = HTTP_DOMAIN;
            }
            else{
                $info = $_GET['info'];
                $url = $_GET['tip_url'];
                if(empty($has_http)){$url = 'http://'.$url;}
            }
        }
        $this->setVariable('info',addslashes($info));
        $this->setVariable('tip_url',addslashes($url));
        $this->display();
    }
}