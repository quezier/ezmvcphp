<?php
namespace Core;
class CreateHtml
{
    /**
     * 设定要注入到模板变量的值
     * @param string $key
     * @param $val
     */
    function setVariable( $key,$val)
    {
        $this->$key = $val;
    }

    /**
     * 生成html内容
     * @param string $templatePath 模板路径包括模板文件名
     * @return bool true:成功 false:失败
     * @throws \Exception
     */
    function create( $templatePath) {
        $content = '';
        try{

            ob_start();
            extract((array)$this);
            if(file_exists($templatePath))
            {
                require $templatePath;
            }
            else{
                throw new \Exception('模板路径不存在');
            }
            $content = ob_get_clean();

        }
        catch (\Exception $e)
        {
            $errorInfo = \Core\PubFunc::exceptionHandler($e);
            if(IS_DEBUG)
            {
                echo $errorInfo;exit;
            }

        }
        return $content;
    }
    /**
     * 生成html文件
     * @param string $templatePath 模板路径包括模板文件名
     * @param string $htmlPath 生成的html文件的路径包括文件名
     * @return array
     * @throws \Exception
     */
    function CreateHtmlFile( $templatePath, $htmlPath)
    {
        $content = $this->create($templatePath);
        try{
            if(!empty($htmlPath))
            {
                file_put_contents($htmlPath,$content);
                unset($content);

            }
            else{
                return \Core\PubFunc::returnArray(2,false,'没有指定存放生成的html文件的路径');

            }
        }
        catch (\Exception $e)
        {
            $errorInfo = \Core\PubFunc::exceptionHandler($e);
            if(IS_DEBUG)
            {
                echo $errorInfo;exit;
            }
        }
        return \Core\PubFunc::returnArray(1,false,'创建html文件成功');
    }

}