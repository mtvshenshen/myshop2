<?php
/**
 * Login.php
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2015-2025 山西牛酷信息科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: http://www.niushop.com.cn
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用。
 * 任何企业和个人不允许对程序代码以任何形式任何目的再发布。
 * =========================================================
 * @author : niuteam
 * @date : 2015.1.17
 * @version : v1.0.0.0
 */
namespace app\api\controller;

use data\service\Member;
use think\Session;
use data\service\Config as ConfigService;
use data\service\promotion\PromoteRewardRule;

/**
 * 登录、注册相关api
 * @author Administrator
 */
class Login extends BaseApi
{    
    /**
     * 登录配置
     */
    public function loginConfig(){
        $title = '获取登录配置信息';
        
        $config = new ConfigService();
        // 登录配置
        $login_config = $config->getLoginConfig();
        // 验证码配置
        $code_config = $config->getLoginVerifyCodeConfig(0);
        
        $data = array(
            'login_config' => $login_config,
            'code_config' => $code_config
        );
        return $this->outMessage($title, $data);
    }
    
    /**
     * 登录
     */
    public function login(){
        $title = '会员登录';
        
        $user_name = $this->get('username', '');
        $password = $this->get('password', '');
        
        $member = new Member();
        if (empty($user_name)) return $this->outMessage($title, ['code' => -1, 'message' => '缺少必须参数username']);
        if (empty($password)) return $this->outMessage($title, ['code' => -1, 'message' => '缺少必须参数password']);
            
        $retval = $member->login($user_name, $password);
        if ($retval > 0) {
            $model = $this->getRequestModel();
            $uid = Session::get($model . 'uid');
            $token = array(
                'uid' => $retval,
                'request_time' => time()
            );
            $encode = $this->niuEncrypt(json_encode($token));
            $data = array(
                'code' => 1,
                'token' => $encode,
                'message' => '登录成功'
            );
            return $this->outMessage($title, $data);
        } else {
            return $this->outMessage($title, AjaxReturn($retval));
        }
    }
    
    /**
     * 手机动态码登录
     */
    public function mobileLogin(){
        $title = "手机动态码登录";
        
        $mobile = isset($this->params['mobile']) ? $this->params['mobile'] : "";
        $sms_captcha = isset($this->params['sms_captcha']) ? $this->params['sms_captcha'] : "";
        if(empty($mobile)) return $this->outMessage($title, ['code' => 0, 'message' => '缺少必须参数mobile']);
        if(empty($sms_captcha)) return $this->outMessage($title, ['code' => 0, 'message' => '缺少必须参数sms_captcha']);
        
        $member = new Member();
        $sms_captcha_code = Session::get('mobileVerificationCode');
        $sendMobile = Session::get('sendMobile');
        
        if($mobile != $sendMobile) return $this->outMessage($title, ['code' => 0, 'message' => '登录手机号与验证时的不一致']);   
        
        if ($sms_captcha == $sms_captcha_code && ! empty($sms_captcha_code)) {
            $retval = $member->login($mobile, '');
        } else {
            $retval = - 10;
        }
    
        if ($retval > 0) {
            $model = $this->getRequestModel();
            $uid = Session::get($model . 'uid');
            $token = array(
                'uid' => $uid,
                'request_time' => time()
            );
            $encode = $this->niuEncrypt(json_encode($token));
            $data = array(
                'code' => 1,
                'token' => $encode
            );
            return $this->outMessage($title, $data);
        } else {
            return $this->outMessage($title, AjaxReturn($retval));
        }
    }
    
    /**
     * 注册配置
     */
    public function registerConfig(){
        $title = '获取注册配置信息';
        
        $config = new ConfigService();
        // 注册配置
        $reg_config_info = $config->getRegisterAndVisit(0);
        $reg_config = json_decode($reg_config_info["value"], true);
        // 验证码配置
        $code_config = $config->getLoginVerifyCodeConfig(0);
        
        $data = array(
            'reg_config' => $reg_config,
            'code_config' => $code_config
        );
        return $this->outMessage($title, $data);
    }
    
    /**
     * 账号注册
     */
    public function usernameRegister(){
        $title = "账号注册";
        $web_config = new ConfigService();
        $member = new Member();
        
        $user_name = isset($this->params['username']) ? $this->params['username'] : "";
        $password = isset($this->params['password']) ? $this->params['password'] : "";
        $email = isset($this->params['email']) ? $this->params['email'] : "";
        $mobile = isset($this->params['mobile']) ? $this->params['mobile'] : "";
       
        $retval_id = $member->registerMember($user_name, $password, $email, $mobile, '', '', '', '', '');
        if ($retval_id > 0) {
            Session::pull('mobileVerificationCode');
            session::pull('mobileVerificationCode_time');
            // 微信的会员绑定
            if (empty($user_name)) {
                $user_name = $mobile;
            }
            $bind_message_info = Session::get("bind_message_info");
            $this->wchatBindMember($user_name, $password, $bind_message_info);
            // 注册成功送优惠券
            $integralConfig = $web_config->getIntegralConfig(0);
            if ($integralConfig['register_coupon'] == 1) {
                $rewardRule = new PromoteRewardRule();
                $res = $rewardRule->getRewardRuleDetail(0);
                if ($res['reg_coupon'] != 0) {
                    $member->memberGetCoupon($retval_id, $res['reg_coupon'], 2);
                }
            }
            
            $token = array(
                'uid' => $retval_id,
                'request_time' => time()
            );
            $encode = $this->niuEncrypt(json_encode($token));
            $data = array(
                'code' => 1,
                'token' => $encode
            );
        }else{
            $data = [
                'code' => -1,
                'message' => getErrorInfo($retval_id)
            ];
        }
        return $this->outMessage($title, $data);
    }
    
    /**
     * 邮箱注册
     */
    public function emailRegister(){
        $title = "PC端、邮箱注册";
        
        $email = isset($this->params['email']) ? $this->params['email'] : "";
        $password = isset($this->params['password']) ? $this->params['password'] : "";
        $email_code = isset($this->params['email_code']) ? $this->params['email_code'] : "";
        
        $member = new Member();
        $web_config = new ConfigService();
        
        $notice = $web_config->getNoticeEmailConfig(0);
        
        // 判断邮箱是否开启
        if ($notice[0]['is_use'] == 1) {
            if(empty($email_code)) return $this->outMessage($title, -1, -1, '缺少必须参数email_code');
            $param = session::get('emailVerificationCode');
            if($email_code != $param){
                return $this->outMessage($title, -1, -1, '手机验证码错误');
            }
        } 
        
        $retval_id = $member->registerMember('', $password, $email, '', '', '', '', '', '');
        
        if ($retval_id > 0) {
            // 注册成功送优惠券
            Session::pull('emailVerificationCode');
            $integralConfig = $web_config->getIntegralConfig(0);
            if ($integralConfig['register_coupon'] == 1) {
                $rewardRule = new PromoteRewardRule();
                $res = $rewardRule->getRewardRuleDetail(0);
                if ($res['reg_coupon'] != 0) {
                    $member->memberGetCoupon($retval_id, $res['reg_coupon'], 2);
                }
            }
            $token = array(
                'uid' => $retval_id,
                'request_time' => time()
            );
            $encode = $this->niuEncrypt(json_encode($token));
            $data = array(
                'code' => 1,
                'token' => $encode
            );
        }else{
            $data = [
                'code' => -1,
                'message' => getErrorInfo($retval_id)
            ];
        }
        return $this->outMessage($title, $data);
    }
    
    /**
     * 手机注册
     */
    public function mobileRegister(){
        $title = "手机号注册";
        $mobile = isset($this->params['mobile']) ? $this->params['mobile'] : "";
        $password = isset($this->params['password']) ? $this->params['password'] : "";
        $mobile_code = isset($this->params['mobile_code']) ? $this->params['mobile_code'] : "";
        
        $member = new Member();
        $web_config = new ConfigService();
        
        $noticeMobile = $web_config->getNoticeMobileConfig(0);
        if ($noticeMobile[0]['is_use'] == 1) {
           if(empty($mobile_code)) return $this->outMessage($title, -1, -1, '缺少必须参数mobile_code');
           $param = session::get('mobileVerificationCode');
           if($mobile_code != $param){
               return $this->outMessage($title, -1, -1, '手机验证码错误');
           }
        } 
        
        $retval_id = $member->registerMember('', $password, '', $mobile, '', '', '', '', '');
        
        if ($retval_id > 0) {
            Session::pull('mobileVerificationCode');
            Session::pull('mobileVerificationCode_times');
            // 注册成功送优惠券
            $integralConfig = $web_config->getIntegralConfig(0);
            if ($integralConfig['register_coupon'] == 1) {
                $rewardRule = new PromoteRewardRule();
                $res = $rewardRule->getRewardRuleDetail(0);
                if ($res['reg_coupon'] != 0) {
                    $member->memberGetCoupon($retval_id, $res['reg_coupon'], 2);
                }
            }
            $token = array(
                'uid' => $retval_id,
                'request_time' => time()
            );
            $encode = $this->niuEncrypt(json_encode($token));
            $data = array(
                'code' => 1,
                'token' => $encode
            );
        }else{
            $data = [
                'code' => -1,
                'message' => getErrorInfo($retval_id)
            ];
        }
        return $this->outMessage($title, $data);
    }
    
    /**
     * 绑定账号
     * 创建时间：2019年1月4日17:00:06
     */
    public function bindAccount()
    {
        $title = "绑定账号";
        
        $web_config = new ConfigService();
        $member = new Member();
        
        // 登录配置
        $code_config = $web_config->getLoginVerifyCodeConfig(0);
        $user_name = isset($this->params['username']) ? $this->params['username'] : "";
        $password = isset($this->params['password']) ? $this->params['password'] : "";
    
        $retval = $member->login($user_name, $password);
    
        if ($retval > 0) {
            // qq登录
            if (isset($_SESSION['login_type']) && $_SESSION['login_type'] == 'QQLOGIN') {
                $qq_openid = $_SESSION['qq_openid'];
                $qq_info = $_SESSION['qq_info'];
                if (! empty($qq_openid) && ! empty($qq_info)) {
                    $res = $member->bindQQ($qq_openid, $qq_info);
                    if ($res) {
                        // 拉取用户头像
                        $uid = $member->getCurrUserId();
                        $url = str_replace('api.php', 'index.php', __URL(__URL__ . 'wap/login/updateUserImg?uid=' . $uid . '&type=qq'));
                        http($url, 1);
                        unset($_SESSION['qq_openid']);
                        unset($_SESSION['qq_info']);
                        unset($_SESSION['bund_pre_url']);
                        unset($_SESSION['login_type']);
                        return $this->outMessage($title, 1, 1, "绑定成功");
                    } else {
                        return $this->outMessage($title, - 1, - 1, "账号绑定失败");
                    }
                } else {
                    return $this->outMessage($title, - 1, - 1, "未获取到绑定信息");
                }
            }
            // 微信登录
            if (isset($_SESSION['login_type']) && $_SESSION['login_type'] == 'WCHAT') {
                $unionid = $_SESSION['wx_unionid'];
                $wx_info = $_SESSION['wx_info'];
                $member = new Member();
                if (! empty($unionid) && ! empty($wx_info)) {
                    $res = $member->bindWchat($unionid, $wx_info);
                    if ($res) {
                        // 拉取用户头像
                        $uid = $member->getCurrUserId();
                        $url = str_replace('api.php', 'index.php', __URL(__URL__ . 'wap/login/updateUserImg?uid=' . $uid . '&type=wchat'));
                        http($url, 1);
                        unset($_SESSION['wx_unionid']);
                        unset($_SESSION['wx_info']);
                        unset($_SESSION['bund_pre_url']);
                        unset($_SESSION['login_type']);
                        return $this->outMessage($title, 1, 1, "绑定成功");
                    } else {
                        return $this->outMessage($title, - 1, - 1, "账号绑定失败");
                    }
                } else {
                    return $this->outMessage($title, - 1, - 1, "未获取到绑定信息");
                }
            }
        } else {
            return $this->outMessage($title, - 1, - 1, "用户名或密码错误");
        }
    
        return $this->outMessage($title, - 1, - 1, "绑定失败");
    }
    
    /**
     * 找回密码
     */
    public function findPassword()
    {
        $type = isset($this->params['type']) ? $this->params['type'] : "mobile";
        $info = isset($this->params['info']) ? $this->params['info'] : "";
        $condition = [];
        if ($type == "mobile") {
            $condition = [
                'user_tel' => $info
            ];
        } else if ($type == "email") {
            $condition = [
                'user_email' => $info
            ];
        }
        $member = new Member();
        $res = $member->getUserInfoByCondition($condition);
        return $this->outMessage("忘记修改密码账号验证", $res);
    }
   
    /**
     * 找回密码 密码重置
     * @return multitype:number string |\think\response\Json
     */
    public function passwordReset()
    {
        $title = "找回密码密码重置";
        
        $account = isset($this->params['account']) ? $this->params['account'] : "";
        $password = isset($this->params['password']) ? $this->params['password'] : "";
        $type = isset($this->params['type']) ? $this->params['type'] : "";
        $code = isset($this->params['code']) ? $this->params['code'] : "";
    
        $param = Session::get('findPasswordVerificationCode');
        if ($code != $param) {
            return $this->outMessage($title, ['code' => -1, 'message' => '动态码错误']);
        }
       
        $member = new Member();
        if ($type == "email") {
            $codeEmail = Session::get("codeEmail");
            if ($account != $codeEmail) {
                return $this->outMessage($title, ['code' => -1, '该邮箱与验证时的邮箱不符']);
            } 
            $res = $member->updateUserPasswordByEmail($account, $password);
            // 重置密码后 清除session
            Session::delete('codeEmail');
            Session::delete('findPasswordVerificationCode');
        } elseif ($type == "mobile") {
            $codeMobile = Session::get("codeMobile");
            if ($account != $codeMobile) {
                return $this->outMessage($title, ['code' => -1, '该手机号与验证时的手机不符']);
            } 
            $res = $member->updateUserPasswordByMobile($account, $password);
            // 重置密码后 清除session
            Session::delete('codeMobile');
            Session::delete('findPasswordVerificationCode');
        }
        return $this->outMessage($title, AjaxReturn($res));
    }
    
    /**
     * 完善信息
     * 创建时间：2019年1月4日19:18:11
     */
    public function perfectInfo()
    {
        $title = "完善信息";
    
        // 登录配置
        $web_config = new ConfigService();
        $member = new Member();
    
        $code_config = $web_config->getLoginVerifyCodeConfig(0);
    
        $user_name = isset($this->params['username']) ? $this->params['username'] : "";
        $password = isset($this->params['password']) ? $this->params['password'] : "";
        $captcha = isset($this->params['captcha']) ? $this->params['captcha'] : "";
        $exist = $member->judgeUserNameIsExistence($user_name);
        if ($exist) {
            return $this->outMessage($title, [
                "code" => - 1,
                "message" => "该用户名已存在"
            ]);
        }
      
        // qq
        if (isset($_SESSION['login_type']) && $_SESSION['login_type'] == 'QQLOGIN') {
            $qq_openid = $_SESSION['qq_openid'];
            $qq_info = $_SESSION['qq_info'];
            $result = $member->registerMember($user_name, $password, '', '', $qq_openid, $qq_info, '', '', '');
        }
    
        // 微信
        if (isset($_SESSION['login_type']) && $_SESSION['login_type'] == 'WCHAT') {
            $unionid = $_SESSION['wx_unionid'];
            $wx_info = $_SESSION['wx_info'];
            $result = $member->registerMember($user_name, $password, '', '', '', '', '', $wx_info, $unionid);
        }
    
        if ($result > 0) {
            // 注册成功送优惠券
            $integralConfig = $web_config->getIntegralConfig(0);
            if ($integralConfig['register_coupon'] == 1) {
                $rewardRule = new PromoteRewardRule();
                $res = $rewardRule->getRewardRuleDetail(0);
                if ($res['reg_coupon'] != 0) {
                    $member->memberGetCoupon($result, $res['reg_coupon'], 2);
                }
            }
    
            // 注册成功之后
            if (isset($_SESSION['login_type']) && $_SESSION['login_type'] == 'QQLOGIN') {
                unset($_SESSION['qq_openid']);
                unset($_SESSION['qq_info']);
            } elseif (isset($_SESSION['login_type']) && $_SESSION['login_type'] == 'WCHAT') {
                unset($_SESSION['wx_unionid']);
                unset($_SESSION['wx_info']);
            }
    
            $url = empty($_SESSION['login_pre_url']) ? __URL(__URL__ . "/wap/member/index") : $_SESSION['login_pre_url'];
            return $this->outMessage($title, [
                "code" => 1,
                "message" => "注册成功",
                "url" => $url
            ]);
        } else {
            return $this->outMessage($title, [
                "code" => - 1,
                "message" => "注册失败"
            ]);
        }
        return $this->outMessage("获取注册访问设置", null);
    }
    
    /**
     * 注册协议
     */
    public function registerAgreement(){
        $config = new ConfigService();
        $info = $config->getRegistrationAgreement(0);
        return $this->outMessage("注册协议", $info['value']);
    }
    
    /**
     * 发送注册短信验证码
     */
    public function sendRegisterMobileCode()
    {
        $title = '发送短信验证码';
        $params['mobile'] = isset($this->params['mobile']) ? $this->params['mobile'] : "";
      
        $params['shop_id'] = 0;
        $result = runhook('Notify', 'registSmsValidation', $params);
        Session::set('mobileVerificationCode', $result['param']);
        Session::set('sendMobile', $params['mobile']);
        $data['code'] = $result['param'];
        $data['mobile'] = $params['mobile'];
    
        if (empty($result)) {
            $result = [
                'code' => - 1,
                'message' => "发送失败"
            ];
        } else if ($result["code"] != 0) {
            $result = [
                'code' => $result["code"],
                'message' => $result["message"]
            ];
        } else if ($result["code"] == 0) {
            $result = [
                'code' => 0,
                'message' => "发送成功"
            ];
        }
        return $this->outMessage($title, $result);
    }
    
    /**
     * 发送邮箱验证码
     */
    public function sendRegisterEmailCode()
    {
        $title = "发送邮箱验证码";
        
        $params['email'] = isset($this->params['email']) ? $this->params['email'] : "";
        $params['shop_id'] = 0;
        $result = runhook('Notify', 'registEmailValidation', $params);
        Session::set('emailVerificationCode', $result['param']);
        if (empty($result)) {
            $result = [
                'code' => - 1,
                'message' => "发送失败"
            ];
        } elseif ($result['code'] == 0) {
            $result = [
                'code' => 0,
                'message' => "发送成功"
            ];
        } else {
            $result = [
                'code' => $result['code'],
                'message' => $result['message']
            ];
        }
        return $this->outMessage($title, $result);
    }

    /**
     * 发送找回密码 短信 邮箱验证码
     */
    public function sendFindPasswordCode()
    {
        $title = "获取前端邮箱是否存在";
        $send_type = isset($this->params['type']) ? $this->params['type'] : "";
        $send_param = isset($this->params['send_param']) ? $this->params['send_param'] : "";
        
        if(empty($send_type)) return $this->outMessage($title, ['code' => -1, 'message' => '缺少必须参数type']);
        if(empty($send_param)) return $this->outMessage($title, ['code' => -1, 'message' => '缺少必须参数send_param']);
        
        $member = new Member();
        if ($send_type == 'sms') {
            if (! $member->memberIsMobile($send_param)) {
                $result = [
                    'code' => - 1,
                    'message' => "该手机号未注册"
                ];
                return $this->outMessage($title, $result);
            } else {
                Session::set("codeMobile", $send_param);
            }
        } elseif ($send_type == 'email') {
            $member->memberIsEmail($send_param);
            if (! $member->memberIsEmail($send_param)) {
                $result = [
                    'code' => - 1,
                    'message' => "该邮箱未注册"
                ];
                return $this->outMessage($title, $result);
            } else {
                Session::set("codeEmail", $send_param);
            }
        }
        $params = array(
            "send_type" => $send_type,
            "send_param" => $send_param,
            "shop_id" => 0
        );
        $result = runhook("Notify", "forgotPassword", $params);
        Session::set('findPasswordVerificationCode', $result['param']);
    
        if (empty($result)) {
            $result = [
                'code' => - 1,
                'message' => "发送失败"
            ];
        } elseif ($result['code'] == 0) {
            $result = [
                'code' => 0,
                'message' => "发送成功"
            ];
        } else {
            $result = [
                'code' => $result['code'],
                'message' => $result['message']
            ];
        }
        return $this->outMessage($title, $result);
    }
    
    /**
     * 验证注册手机验证码
     */
    public function checkRegisterMobileCode()
    {
        $send_param = isset($this->params['send_param']) ? $this->params['send_param'] : "";
    
        $param = session::get('mobileVerificationCode');
       
        if ($send_param == $param && $send_param != '') {
            $data = [
                'code' => 0,
                'message' => "验证码一致"
            ];
        } else {
            $data = [
                'code' => 1,
                'message' => "验证码不一致"
            ];
        }
    
        return $this->outMessage("验证注册手机号验证码", $data);
    }
    

    /**
     * 验证邮箱验证码
     */
    public function checkRegisterEmailCode()
    {
        $send_param = isset($this->params['send_param']) ? $this->params['send_param'] : "";
    
        $param = Session::get('emailVerificationCode');
    
        if ($send_param == $param && $send_param != '') {
            $data = [
                'code' => 0,
                'message' => "验证码一致"
            ];
        } else {
            $data = [
                'code' => 1,
                'message' => "验证码不一致"
            ];
        }
    
        return $this->outMessage("验证注册邮箱验证码", $data);
    }
    
    /**
     * 找回密码动态码验证
     */
    public function checkFindPasswordCode(){
        $title = "找回密码动态码验证";
        
        $send_param = isset($this->params['send_param']) ? $this->params['send_param'] : "";
        $param = Session::get('findPasswordVerificationCode');
        
        if ($send_param == $param && $send_param != '') {
            $retval = [
                'code' => 0,
                'message' => "验证码一致"
            ];
        } else {
            $retval = [
                'code' => 1,
                'message' => "验证码不一致"
            ];
        }
        return $this->outMessage($title, $retval);
    }
    
    /**
     * 微信绑定用户
     */
    public function wchatBindMember($user_name, $password, $bind_message_info, $source_uid = '')
    {
        $bind_message_info = json_decode($bind_message_info, true);
        $bind_message_info['token'] = array(
            'openid' => $bind_message_info['openid']
        );
        unset($bind_message_info['openid']);
        $bind_message_info = json_encode($bind_message_info);
        $applet_member = new Member();
        $uid = $applet_member->getUidWidthApplet($user_name, $password);
    
        if (! empty($uid)) {
            $user_info = $applet_member->getUserInfoByUid($uid);
            if (empty($user_info['wx_openid']) && empty($user_info['wx_unionid'])) {
                Session::set("bind_message_info", $bind_message_info);
                Session::set('source_uid', $source_uid);
                $applet_member->wchatBindMember($uid, $bind_message_info);
                return 1;
            } else {
                return - 1;
            }
        }
    }
}