<?php
/**
 * Created by PhpStorm.
 * User: fyq
 * Date: 2017/3/17
 * Time: 14:08
 */

namespace Core;


class DateTool
{
    /**
     * 获取今日开始时间戳和结束时间戳
     * @return array
     */
    static function beToday()
    {
        $beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
        $endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
        return array('begin'=>$beginToday,'end'=>$endToday);
    }
    /**
     * php获取昨日起始时间戳和结束时间戳
     * @return array
     */
    static function beYesterday()
    {
        $beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
        $endYesterday=mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
        return array('begin'=>$beginYesterday,'end'=>$endYesterday);
    }
    /**
     * 获取上周起始时间戳和结束时间戳
     * @return array
     */
    static function beLastWeek(){
        $beginLastWeek=mktime(0,0,0,date('m'),date('d')-date('w')+1-7,date('Y'));
        $endLastWeek=mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'));
        return array('begin'=>$beginLastWeek,'end'=>$endLastWeek);
    }
    /**
     * 获取本月起始时间戳和结束时间戳
     * @return array
     */
    static function beCurMonth(){
        $beginCurMonth=mktime(0,0,0,date('m'),1,date('Y'));
        $endCurMonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
        return array('begin'=>$beginCurMonth,'end'=>$endCurMonth);
    }

}