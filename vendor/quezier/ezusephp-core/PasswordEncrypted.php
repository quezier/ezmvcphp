<?php


namespace Core;
use Phpass\Hash;

/**
 * 加密用户的密码
 * @package        EzMvcPHP
 * @author         quezier
 * @email          33590896@qq.com
 */
class PasswordEncrypted
{
    /**
     * 根据用户的密码生成存放到数据库的加密密码hash字符串,长度为60
     * @param string $password 用户密码
     * @return string
     */
    static function encryptPassword( $password)
    {
        if(PubFunc::comparePHPVersion()){

            return password_hash($password,PASSWORD_DEFAULT);
        }
        else{
            $phpassHash = new Hash();
            return $phpassHash->hashPassword($password);
        }
    }

    /**
     * 验证用户提交的密码
     * @param string $password 用户提交的密码
     * @param string $hash 从数据库取出的加密密码hash字符串
     * @return bool
     */
    static function verifyPassword( $password, $hash)
    {
        if(PubFunc::comparePHPVersion()) {
            if (password_verify($password, $hash)) {
                return true;
            } else {
                return false;
            }
        }else{
            $phpassHash = new Hash();
            if($phpassHash->checkPassword($password,$hash))
            {
                return true;
            }
            else{
                return false;
            }
        }
    }
}