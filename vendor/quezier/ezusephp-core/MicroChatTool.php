<?php
/**
 * Created by PhpStorm.
 * User: fyq
 * Date: 2017/4/25
 * Time: 10:56
 */

namespace Core;
use App\Logic\LevelSettingLogic;
use App\Logic\UserInfoLogic;
/**
 * 微信工具类
 * Class MicroChatTool
 * @package Core
 */
class MicroChatTool
{
    /**
     * 获取微信返回的code后的业务逻辑
     */
    static function recCode($code,$state)
    {
        try{
            if(!empty($state))
            {
                $stateArray = explode('|',$state);
                if(!empty($stateArray[1]))
                {
                    $plzcode = $stateArray[1];
                }
            }
            if(empty($code))
            {
                return PubFunc::returnArray(2,false,'获取code失败');
            }
            $wxConfig = PubFunc::sysConfig('wei_xin');

            if(empty($state)||$stateArray[0]!=$wxConfig['state_msg'])
            {
                return PubFunc::returnArray(2,false,'state错误');
            }
            $appid = $wxConfig['app_id'];;
            $secret = $wxConfig['app_secret'];;
            $getAccessTokenUrl="https://api.weixin.qq.com/sns/oauth2/access_token";
            $getAccessTokenData="appid={$appid}&secret={$secret}&code={$code}&grant_type=authorization_code";
            $result=PubFunc::curlGet($getAccessTokenUrl, $getAccessTokenData);
            if(!empty($result))
            {
                //pr($result);exit;
                $accessTokenData=  json_decode($result,true);
                $expires_in=$accessTokenData['expires_in'];
                $access_token=$accessTokenData['access_token'];
                $openid=$accessTokenData['openid'];

                if(empty($openid))
                {
                    return PubFunc::returnArray(2,false,'没有获取到openid');
                }
                $getUserInfoUrl="https://api.weixin.qq.com/sns/userinfo";
                $getUserInfoData="access_token={$access_token}&openid={$openid}&lang=zh_CN&scope=snsapi_userinfo";
                $userInfo=PubFunc::curlGet($getUserInfoUrl, $getUserInfoData);
                $userInfoArr=  json_decode($userInfo,true);
                if(!empty($userInfoArr['nickname']))
                {
                    //$unionid=$userInfoArr['unionid'];
                    $nickname=$userInfoArr['nickname'];
                    $sex=$userInfoArr['sex'];
                    $headImgUrl=$userInfoArr['headimgurl'];

                    $userInfoLogic = new UserInfoLogic();
                    $userResult=$userInfoLogic->getOne('',"WHERE wxopenid=:oid AND is_del=1",array('oid'=>$openid),'id,username,user_logo');

                    $userArr=$userResult['result'];
                    if(!empty($userArr)&&!empty($userArr['id']))
                    {
                        PubFunc::session('user_id',$userArr['id']);
                        PubFunc::session('user_name',$userArr['username']);
                        PubFunc::session('user_logo',$userArr['user_logo']);
                        PubFunc::session('user_wx_openid',$openid);
                        $updData['login_ip']=PubFunc::getIP();
                        $updData['login_date']=time();
                        $updData['id']=$userArr['id'];
                        $userInfoLogic->update($updData);
                    }
                    else{
                        $newTime = time();
                        $data['sex']=$sex;
                        $data['wxopenid']=$openid;

                        $data['username']=$nickname;
                        $data['userpwd'] = PasswordEncrypted::encryptPassword('123456');
                        $data['reg_date']= $newTime;
                        $data['user_level']=1;
                        $data['reg_ip']=PubFunc::getIP();
                        //$plzcode = intval($plzcode);
                        //var_dump($plzcode);exit;
                        if(!empty($plzcode))
                        {
                            $levelSettingLogic = new LevelSettingLogic();
                            $levelSettingResult = $levelSettingLogic->getOne(''," limit 0,1 ");
                            if($levelSettingResult['status']==1&&!empty($levelSettingResult['result']))
                            {
                                $levelSetting = $levelSettingResult['result'];
                            }
                            $countResult = $userInfoLogic->sql("select count(*) as num from user_info where parent_id=:pid",array('pid'=>$plzcode));
                            //var_dump($levelSettingResult);var_dump($countResult);exit;
                            if($countResult['status']==1&&!empty($countResult['result']))
                            {
                                $count = $countResult['result'][0]['num'];
                                if($count>=$levelSetting['second_number']&&$count<$levelSetting['third_number'])
                                {
                                    $parentData['id']=$plzcode;
                                    $parentData['user_level']=2;
                                    $userInfoLogic->update($parentData);
                                }
                                elseif ($count>=$levelSetting['third_number'])
                                {
                                    $parentData['id']=$plzcode;
                                    $parentData['user_level']=3;
                                    $userInfoLogic->update($parentData);
                                }
                            }
                            $data['parent_id']=$plzcode;
                        }

                        if(!empty($headImgUrl))
                        {
                            $data['user_logo']=$headImgUrl;
                        }
                        //var_dump($data);exit;
                        $addResult = $userInfoLogic->insert($data);
                        if($addResult['status']==1&&!empty($addResult['result']))
                        {
                            $userID = $addResult['result'];

                            PubFunc::session('user_id',$userID);
                            PubFunc::session('user_name',$nickname);
                            PubFunc::session('user_logo',$headImgUrl);
                            PubFunc::session('user_wx_openid',$openid);
                        }
                        else{

                            return PubFunc::returnArray(2,false,'注册失败,请关闭微信浏览器重试或联系管理员');
                        }
                    }

                }
                else{
                    return PubFunc::returnArray(2,false,'微信没有返回用户信息');
                }
            }
            else{
                return PubFunc::returnArray(2,false,'获取openid错误');
            }
        }
        catch (\Exception $e)
        {
            if(IS_DEBUG)
            {
                echo $e->getMessage();
            }
            else{

                PubFunc::doLog($e->getMessage());
            }
            return PubFunc::returnArray(2,false,'程序出错,请关闭微信浏览器重试或联系管理员');
        }
        return PubFunc::returnArray(1,false,'处理成功');
    }
}