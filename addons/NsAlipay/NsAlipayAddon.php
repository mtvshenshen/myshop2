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
namespace addons\NsAlipay;

use addons\NsAlipay\data\service\AlipayConfig;
use data\service\UnifyPay;
use addons\NsAlipay\data\service\AliPay;
use addons\NsAlipay\data\service\AliPayVerify;
use Qiniu\json_decode;
class NsAlipayAddon extends \addons\Addons
{

    public $info = array(
        'name' => 'NsAlipay', // 插件名称标识
        'title' => '支付宝', // 插件中文名
        'description' => '该系统支持即时到账接口', // 插件概述
        'status' => 1, // 状态 1启用 0禁用
        'author' => 'niushop', // 作者
        'version' => '1.0', // 版本号
        'has_addonslist' => 0, // 是否有下级插件 例如：第三方登录插件下有 qq登录，微信登录
        'content' => '', // 插件的详细介绍或使用方法
        'ico' => 'addons/NsAlipay/ico.png'
    );
    
    /**
     * 后台支付设置
     * @param unknown $param
     * @return mixed
     */
    public function payconfig($param)
    {
        $alipay_config = new AlipayConfig();
       	$edition = $alipay_config->getAliPayVersion(0);
        if(empty($edition)){
       		$config = $alipay_config->getAlipayConfig(0);
       	}else{
       		$is_use = json_decode($edition['value'], true);
       		if($is_use['is_use'] == 0){
       			$config = $alipay_config->getAlipayConfig(0);
       		}else{
       			$config = $alipay_config->getAlipayConfigNew(0);
       		}
       	}
       	$status = $alipay_config->getAliPayStatus(0);
       	$status_is = json_decode($status['value'],true);
       	$config['is_use'] = $status_is['is_use'];
        $config["logo"] = $this->info['ico'];
        $config["pay_name"] = "支付宝";
        $config["desc"] = "该系统支持即时到账接口";
        $config['url'] = __URL('__URL__/NsAlipay/'.ADMIN_MODULE.'/Config/payaliconfig');
        $config['pay_logo'] = "public/admin/images/pay.png";  //支付按钮
        $config['pay_url'] = 'APP_MAIN/pay/alipay';//支付跳转页面
        $config['h5_icon'] = 'zhifu.png';
        $config['pc_icon'] = 'alipay.png';
        $config['lang'] = 'alipay';
        return  $config;
    }
    
    /**
     * 支付(必存在)
     * @param unknown $param
     */
    public function pay($param)
    {
        $out_trade_no = $param['no'];
        if (!isWeixin()) {
            $notify_url = str_replace("/index.php", '', __URL__);
            $notify_url = str_replace("index.php", '', $notify_url);
            $notify_url = $notify_url . "/alipay.php";
            $return_url = __URL(__URL__ . '/wap/Pay/aliPayReturn');
            $show_url = __URL(__URL__ . '/wap/Pay/aliUrlBack');
            $pay = new UnifyPay();
            $res = $pay->aliPay($out_trade_no, $notify_url, $return_url, $show_url);
            echo "<meta charset='UTF-8'><script>window.location.href='" . $res . "'</script>";
        } else {
            // echo "点击右上方在浏览器中打开";
            $this->assign("status", -1);
            $order_no = $this->getOrderNoByOutTradeNo($out_trade_no);
            $this->assign("order_no", $order_no);
            if (request()->isMobile()) {
                return $this->view($this->style . "Pay/payCallback");
            } else {
                return $this->view($this->style . "Pay/payCallbackPc");
            }
        }
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
        $pay = new UnifyPay();
        $params = request()->post();
        $verify_result = $pay->getVerifyResult($params, 'notify');
        if ($verify_result) { // 验证成功
            $out_trade_no = request()->post('out_trade_no', '');
            // 支付宝交易号
            $trade_no = request()->post('trade_no', '');
            	
            // 交易状态
            $trade_status = request()->post('trade_status', '');

            if ($trade_status == 'TRADE_FINISHED') {
                $retval = $pay->onlinePay($out_trade_no, 2, $trade_no);
            } else
                if ($trade_status == 'TRADE_SUCCESS') {
                    $retval = $pay->onlinePay($out_trade_no, 2, $trade_no);
                }
            echo "success"; 
        } else {
            // 验证失败
            echo "fail";
        } 
    }
    
    /**
     * 退款(必存在)
     * @param unknown $param
     */
    public function refund($param)
    {
        $pay = new AliPay();
        $retval = $pay->aliPayRefund($param['refund_no'], $param['out_trade_no'], $param['refund_fee']);
        return $retval;
    }
    
    /**
     * 转账
     * @param unknown $param
     */
    public function transfer($param)
    {
        $pay = new AliPay();
        $retval = $pay->aliPayTransfer($param['out_biz_no'], $param['ali_account'], $param['money']);
        return $retval;
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