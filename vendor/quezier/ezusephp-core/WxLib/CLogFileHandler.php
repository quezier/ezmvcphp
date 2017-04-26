<?php
/**
 * Created by PhpStorm.
 * User: fyq
 * Date: 2017/4/25
 * Time: 15:31
 */

namespace Core\WxLib;


class CLogFileHandler
{
    private $handle = null;

    public function __construct($file = '')
    {
        $this->handle = fopen($file,'a');
    }

    public function write($msg)
    {
        fwrite($this->handle, $msg, 4096);
    }

    public function __destruct()
    {
        fclose($this->handle);
    }
}