<?php
/**
 * Created by PhpStorm.
 * User: fyq
 * Date: 2017/4/25
 * Time: 17:49
 */

namespace Core\WxLib;


class PayNotifyCallBack extends WxPayNotify
{
    //查询订单
    public function Queryorder($transaction_id)
    {

        //初始化日志
        $logHandler= new CLogFileHandler(PROJECT_ROOT.DIR_SP.'wxlogs'.DIR_SP.date('Y-m-d',time()).'.txt');
        $log = Log::Init($logHandler, 15);

        Log::DEBUG("begin notify");
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = WxPayApi::orderQuery($input);
        Log::DEBUG("query:" . json_encode($result));
        if(array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS")
        {
            return true;
        }
        return false;
    }

    //重写回调处理函数
    public function NotifyProcess($data, &$msg)
    {
        file_put_contents(PROJECT_ROOT.DIR_SP.'wxlogs'.DIR_SP.date('Y-m-d',time()).'.txt',json_encode($data));
        //初始化日志
        $logHandler= new CLogFileHandler(PROJECT_ROOT.DIR_SP.'wxlogs'.DIR_SP.date('Y-m-d',time()).'.txt');
        $log = Log::Init($logHandler, 15);

        Log::DEBUG("begin notify");
        Log::DEBUG("call back:" . json_encode($data));
        $notfiyOutput = array();

        if(!array_key_exists("transaction_id", $data)){
            $msg = "输入参数不正确";
            return false;
        }
        //查询订单，判断订单真实性
        if(!$this->Queryorder($data["transaction_id"])){
            $msg = "订单查询失败";
            return false;
        }
        $orderNo = $data['out_trade_no'];
        $returnCode = $data['return_code'];
        $userOpenID = $data['openid'];
        $transaction_id = $data['transaction_id'];
        $totalFee = $data['total_fee'] / 100;
        Log::DEBUG(date('Y-m-d H:i:s').'  '.json_encode($data));
        return true;
    }
}