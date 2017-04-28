<?php
/**
 * Created by PhpStorm.
 * User: fyq
 * Date: 2017/4/25
 * Time: 10:14
 */

namespace Core;

/**
 * 保存远程图片到本地
 * Class ImageSaveRemote
 * @package Core
 */
class ImageSaveRemote
{
    /**
     * @param $url 远程图片路径
     * @param $filePath 本地文件夹路径
     * @param $fileName 图片名称
     */
    static function save($url,$filePath,$fileName)
    {

        try{
            ob_start();
            readfile($url);
            $img=ob_get_contents();
            ob_end_clean();
            if(!file_exists($filePath))
            {
                mkdir($filePath,0777,true);
            }
            //文件大小
            $fp2=fopen($filePath.DIR_SP.$fileName,'a');
            fwrite($fp2,$img);
            fclose($fp2);
            unset($img);
            return true;
        }
        catch (\Exception $e)
        {

            return false;
        }

    }
}