<?php
/**
 * @package        EzMvcPHP
 * @author         quezier
 * @email          33590896@qq.com
 */
return array(
    'email'=>array('rule'=>'/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i','default'=>'test@test.com'),
    'mobile'=>array('rule'=>'/^(1(([35][0-9])|(47)|[8][0126789]))\d{8}$/','default'=>'13888888888'),
    'tel'=>array('rule'=>'/^0\d{2,3}(\-)?\d{7,8}$/','default'=>'0731-88888888'),
    'zip'=>array('rule'=>'/^\d{6}$/','default'=>'123456'),
    'str'=>array('rule'=>'/^(.*){1,%d}$/','default'=>'无'),
    'int'=>array('rule'=>'/^-{0,%d}[0-9]{1,%d}$/','default'=>'0'),
    'double'=>array('rule'=>'/^-{0,%d}[0-9]{1,%d}\.{0,1}[0-9]{0,%d}$/','default'=>'0.0'),
    'text'=>array('rule'=>'text_5000','default'=>'无')
);