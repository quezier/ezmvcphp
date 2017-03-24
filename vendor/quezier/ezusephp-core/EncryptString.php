<?php


namespace Core;


class EncryptString
{

    /**
     * 加密字符串
     *
     * @param string 加密内容
     * @param string $key 加密关键字
     * @param int $algo 加密规则
     * @param int $mode 加密模式
     * @return string
     */
    public static function encrypt($text, $key, $algo = MCRYPT_RIJNDAEL_256, $mode = MCRYPT_MODE_CBC)
    {

        $iv = mcrypt_create_iv(mcrypt_get_iv_size($algo, $mode), MCRYPT_RAND);
        $text = mcrypt_encrypt($algo, hash('sha256', $key, TRUE), $text, $mode, $iv) . $iv;
        return hash('sha256', $key . $text) . $text;
    }


    /**
     * 解密字符串
     *
     * @param string 解密内容
     * @param string $key 解密关键字
     * @param int $algo 加密规则
     * @param int $mode 加密模式
     * @return string
     */
    public static function decrypt($text, $key, $algo = MCRYPT_RIJNDAEL_256, $mode = MCRYPT_MODE_CBC)
    {
        $hash = substr($text, 0, 64);
        $text = substr($text, 64);
        if(hash('sha256', $key . $text) != $hash) return;
        $iv = substr($text, -mcrypt_get_iv_size($algo, $mode));
        return rtrim(mcrypt_decrypt($algo, hash('sha256', $key, TRUE), substr($text, 0, -strlen($iv)), $mode, $iv), "\x0");
    }


}