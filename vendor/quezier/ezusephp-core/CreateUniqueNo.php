<?php
namespace Core;
class CreateUniqueNo
{
    /**
     * 生成唯一订单号
     * @return string 订单号
     */
    static function createOrder()
    {
        $year_code = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
        return $year_code[intval(date('Y')) - 2016] .
        strtoupper(dechex(date('m'))) . date('d') .
        substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%d', rand(0, 99));
    }

    /**
     * 生成唯一标识
     * @return string 唯一标识
     */
    static function createUniqueNo()
    {
        return md5(uniqid(md5(microtime(true)),true));
    }
}