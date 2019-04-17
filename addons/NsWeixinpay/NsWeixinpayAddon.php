<?php
// +----------------------------------------------------------------------
// | test [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.zzstudio.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Byron Sampson <xiaobo.sun@gzzstudio.net>
// +----------------------------------------------------------------------
namespace addons\NsWeixinpay;

use addons\NsWeixinpay\data\service\WxpayConfig;
class NsWeixinpayAddon extends \addons\Addons
{

    public $info = array(
        'name' => 'NsWeixinpay', // 插件名称标识
        'title' => '微信支付', // 插件中文名
        'description' => '该系统支持微信网页支付和扫码支付', // 插件概述
        'status' => 1, // 状态 1启用 0禁用
        'author' => 'niushop', // 作者
        'version' => '1.0', // 版本号
        'has_addonslist' => 0, // 是否有下级插件 例如：第三方登录插件下有 qq登录，微信登录
        'content' => '', // 插件的详细介绍或使用方法
        'ico' => 'addons/NsWeixinpay/ico.png'
    );
    
    public function payconfig($param)
    {
        $weixinpay_config = new WxpayConfig();
        $config = $weixinpay_config->getWpayConfig(0);
        $config["logo"] = $this->info['ico'];
        $config["pay_name"] = "微信支付";
        $config["desc"] = "该系统支持微信网页支付和扫码支付";
        $config['url'] = __URL('__URL__/NsWeixinpay/'.ADMIN_MODULE.'/Config/paywchatconfig');
        $config['pay_logo'] = "public/admin/images/pay.png";  //支付按钮
        $config['pay_url'] = 'APP_MAIN/pay/wchatpay';//支付页面
        $config['h5_icon'] = 'weifu.png';
        $config['pc_icon'] = 'wechat_qr.png';
        $config['lang'] = 'wechat_payment';
        return  $config;
    }
    
    
    /**
     * 支付(必存在)
     * @param unknown $param
     */
    public function pay($param)
    {
        
    }
    
    /**
     * 同步回调(必存在)
     * @param unknown $param
     */
    public function payReturn($param)
    {
        
    }
    
    /**
     * 异步回调(必存在)
     * @param unknown $param
     */
    public function payNotify($param)
    {
        
    }
    
    /**
     * 退款(必存在)
     * @param unknown $param
     */
    public function refund($param)
    {
        
    }
    
    /**
     * 转账
     * @param unknown $param
     */
    public function transfer($param)
    {
        
    }   
    
    // 钩子名称（需要该钩子调用的页面）
    /**
     * 插件安装(non-PHPdoc)
     * @see \addons\Addons::install()
     */
   public function install(){
       return true;
   }
   
   /**
    * 插件卸载(non-PHPdoc)
    * @see \addons\Addons::uninstall()
    */
   public function uninstall(){
       return true;
   }
}