<?php
/**
 * AlipayConfig.php
 *
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
namespace addons\NsAlipay\data\service;

use data\service\BaseService;
use data\model\NsOrderPaymentModel;
use data\service\UnifyPay;

/**
 * 支付宝支付配置
 */
class Pay extends BaseService
{

    /**
     * 执行支付宝支付
     * @param unknown $out_trade_no
     * @param unknown $notify_url
     * @param unknown $return_url
     * @param unknown $show_url
     */
    public function aliPay($out_trade_no, $notify_url, $return_url, $show_url)
    {
        $unify_pay = new UnifyPay();
        $data = $unify_pay->getPayInfo($out_trade_no);
        if ($data < 0) {
            return $data;
        }
        $pay = new NsOrderPaymentModel();
        $pay->save([ 'pay_type' => 2 ], [ 'out_trade_no' => $out_trade_no ]);
        $ali_pay = new AliPay();
        $retval = $ali_pay->setAliPay($out_trade_no, $data['pay_body'], $data['pay_detail'], $data['pay_money'], 3, $notify_url, $return_url, $show_url);
        return $retval;
        // TODO Auto-generated method stub
    }
    
    /**
     * 支付宝原路退款
     * @param unknown $refund_no
     * @param unknown $out_trade_no商户订单号不是支付流水号
     * @param unknown $refund_fee
     */
    public function aliPayRefund($refund_no, $out_trade_no, $refund_fee)
    {
        $pay = new AliPay();
        $retval = $pay->aliPayRefund($refund_no, $out_trade_no, $refund_fee);
        return $retval;
    }
    
    /**
     * 支付宝转账
     * @param unknown $out_biz_no
     * @param unknown $ali_account
     * @param unknown $money
     * @return \data\extend\alipay\提交表单HTML文本
     */
    public function aliayTransfers($out_biz_no, $ali_account, $money)
    {
        $aliay_pay = new AliPay();
        $result = $aliay_pay->aliPayTransfer($out_biz_no, $ali_account, $money);
        return $result["response"]["alipay"];
    }

    /**
     * 获取支付宝配置参数是否正确,支付成功后使用
     */
    public function getVerifyResult($params, $type)
    {
    	$alipay_verify = new AliPayVerify();
    	$pay = $alipay_verify->aliPayClass();
        $verify = $pay->getVerifyResult($params, $type);
        return $verify;
    }
    
    /**
     * 关闭订单
     * @param unknown $out_trade_no
     */
    public function orderClose($out_trade_no)
    {
        $pay = new AliPay();
        $res = $pay->setOrderClose($out_trade_no);
        return $res;
    }
    
}