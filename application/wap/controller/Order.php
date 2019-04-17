<?php
/**
 * Order.php
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

namespace app\wap\controller;

use data\service\OrderAction;
use data\service\OrderQuery;
use think\Cookie;

/**
 * 订单控制器
 *
 *
 */
class Order extends BaseWap
{
	
	public function __construct()
	{
		parent::__construct();
		$this->checkLogin();
	}
	
	/**
	 * 检测用户
	 */
	private function checkLogin()
	{
		$uid = $this->uid;
		$redirect = __URL(__URL__ . "/wap/login");
		if (empty($uid)) {
			$this->redirect($redirect); // 用户未登录
		}
		$is_member = $this->user->getSessionUserIsMember();
		if (empty($is_member)) {
			$this->redirect($redirect); // 用户未登录
		}
	}
	
	/**
	 * 待付款订单
	 */
	public function payment()
	{
		$this->assign("title", "订单结算");
		$this->assign("title_before", "订单结算");
		
		$create_data = $this->orderCreateData();
		$this->assign("create_data", $create_data);
		return $this->view($this->style . 'order/payment');
	}
	
	/**
	 * 订单数据存session，待删除
	 *
	 * @return number
	 */
	public function orderCreateSession()
	{
		$tag = request()->post('tag', '');
		if (empty($tag)) {
			return -1;
		}
		if ($tag == 'cart') {
			$_SESSION['order_tag'] = 'cart';
			$_SESSION['cart_list'] = request()->post('cart_id');
			$_SESSION['order_goods_type'] = 1; // 商品类型标识
		}
		if ($tag == 'buy_now') {
			$_SESSION['order_tag'] = 'buy_now';
			$_SESSION['order_sku_list'] = request()->post('sku_id') . ':' . request()->post('num');
			$_SESSION['order_goods_type'] = request()->post("goods_type"); // 商品类型标识
		}
		if ($tag == 'combination_packages') {
			$_SESSION['order_tag'] = 'combination_packages';
			$_SESSION['order_sku'] = request()->post("data");
			$_SESSION['combo_id'] = request()->post("combo_id", "");
			$_SESSION['combo_buy_num'] = request()->post("buy_num", "");
			$_SESSION['order_goods_type'] = request()->post("goods_type"); // 商品类型标识
		}
		if ($tag == 'groupbuy') {
			$_SESSION['order_tag'] = 'groupbuy';
			$_SESSION['order_sku_list'] = request()->post('sku_id') . ':' . request()->post('num');
			$_SESSION['order_goods_type'] = request()->post("goods_type"); // 商品类型标识
		}
		if ($tag == 'js_point_exchange') {
			$_SESSION['order_tag'] = 'js_point_exchange';
			$_SESSION['order_sku_list'] = request()->post('sku_id') . ':' . request()->post('num');
			$_SESSION['order_goods_type'] = request()->post("goods_type"); // 商品类型标识
		}
		if ($tag == 'goods_presell') {
			$_SESSION['order_tag'] = 'goods_presell';
			$_SESSION['order_sku_list'] = request()->post('sku_id') . ':' . request()->post('num');
			$_SESSION['order_goods_type'] = request()->post("goods_type"); // 商品类型标识
		}
		
		return 1;
	}
	
	/**
	 * 获取当前会员的订单列表
	 */
	public function lists()
	{
		$this->assign("title", lang('member_my_order'));
		$this->assign("title_before", lang('member_my_order'));
		return $this->view($this->style . 'order/lists');
	}
	
	/**
	 * 评价
	 *
	 * @return \think\response\View
	 */
	public function evaluate()
	{
	    $again = request()->get('again', 0);
	    if($again){
	        $this->assign("title", lang('member_i_want_again_evaluate'));
	        $this->assign("title_before", lang('member_i_want_again_evaluate'));
	    }else{
    		$this->assign("title", lang('member_i_want_evaluate'));
    		$this->assign("title_before", lang('member_i_want_evaluate'));
	    }
	    $this->assign('again', $again);
		return $this->view($this->style . 'order/evaluate');
	}
	
	/**
	 * 订单详情
	 *
	 * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
	 */
	public function detail()
	{
		$this->assign("title", '订单详情');
		$this->assign("title_before", '订单详情');
		return $this->view($this->style . 'order/detail');
	}
	
	/**
	 * 物流详情页
	 */
	public function logistics()
	{
		$this->assign("title", "查看物流");
		$this->assign("title_before", "查看物流");
		return $this->view($this->style . 'order/logistics');
	}
	
	/**
	 * 订单项退款详情
	 */
	public function refundDetail()
	{
		$this->assign("title", '申请退款');
		$this->assign("title_before", '申请退款');
		return $this->view($this->style . 'order/refund_detail');
	}
	
	/**
	 * 订单后期支付页面
	 */
	public function orderPay()
	{
		$order_id = request()->get('id', 0);
		$out_trade_no = request()->get('out_trade_no', 0);
		$order_action = new OrderAction();
		$order_query = new OrderQuery();
		if ($order_id != 0) {
			// 更新支付流水号
			$order_action->createNewOutTradeNoReturnBalance($order_id);
			$new_out_trade_no = $order_query->getOrderNewOutTradeNo($order_id);
			$url = __URL(__URL__ . '/wap/pay/pay?out_trade_no=' . $new_out_trade_no);
			header("Location: " . $url);
			exit();
		} else {
			// 待结算订单处理
			if ($out_trade_no != 0) {
				$url = __URL(__URL__ . '/wap/pay/getpayvalue?out_trade_no=' . $out_trade_no);
				exit();
			} else {
				$this->error("没有获取到支付信息");
			}
		}
	}
	
	/**
	 * 订单项退款详情 售后
	 */
	public function afterSale()
	{
		$order_goods_id = request()->get('order_goods_id', 0);
		if (!is_numeric($order_goods_id)) {
			$this->error("没有获取到退款信息");
		}
		$this->assign("title", '申请售后');
		$this->assign("title_before", '申请售后');
		return $this->view($this->style . "order/aftersale");
	}
	
	/**
	 * 订单后期预定金支付页面
	 */
	public function orderPresellPay()
	{
		$order_id = request()->get('id', 0);
		$order_query = new OrderQuery();
		$order_action = new OrderAction();
		$presell_order_info = $order_query->getOrderPresellInfo(0, [
			'relate_id' => $order_id
		]);
		$presell_order_id = $presell_order_info['presell_order_id'];
		
		if ($presell_order_id != 0) {
			// 更新支付流水号
			$order_action->createNewOutTradeNoReturnBalancePresellOrder($presell_order_id);
			$new_out_trade_no = $order_query->getPresellOrderNewOutTradeNo($presell_order_id);
			$url = __URL(__URL__ . '/wap/pay/pay?out_trade_no=' . $new_out_trade_no);
			header("Location: " . $url);
			exit();
		}
	}
	
	/**
	 * 买家提货
	 */
	public function pickup()
	{
		$this->assign('title', '订单自提');
		return $this->view($this->style . 'order/pickup');
	}
	
	/**
	 * 自提订单门店审核
	 */
	public function pickupToExamine()
	{
		$order_id = request()->get('orderId', 0);
		$order_query = new OrderQuery();
		// 判断该用户是否已登录
// 		if (empty($this->uid)) {
// // 			$_SESSION['login_pre_url'] = __URL(\think\Config::get('view_replace_str.APP_MAIN') . "/order/orderPickupCodeToExamine?order_id=" . $order_id);
// 			$this->redirect("Login/index");
// 		}
		$res = $order_query->getOrderPickupInfo($order_id);
		if (empty($res['picked_up_code'])) {
			$this->error("未获取到自提信息！");
		}
		// 判断当前用户是否是该门店的审核员
		$isPickedUpAuditor = $order_query->currUserIsPickedUpAuditor($res['picked_up_id'], $this->uid);
		if (!$isPickedUpAuditor) {
			$this->error("您不是该门店的审核员！");
		}
		$detail = $order_query->getOrderDetail($order_id);
		if (empty($detail)) {
			$this->error("没有获取到订单信息");
		}
		$this->assign("order", $detail);
		$this->assign('title', '自提核销');
		return $this->view($this->style . 'order/pickup_toexamine');
	}
	
	/**
	 * 图片上传
	 */
	public function uploadImage()
	{
		if (!empty($_FILES['file'])) {
			$file_path = request()->post("file_path", "wap_order");
			$upload = new \data\service\Upload();
			$result = $upload->image($_FILES["file"], $file_path);
			return json_encode($result);
		}
	}
	
	
	/**
	 * 添加订单创建所需数据
	 */
	public function addOrderCreateData(){
	    $data = request()->post("data", "");
	    Cookie::set("orderCreateData", $data);
	    return AjaxReturn(1);
	}
	
	/**
	 * 获取创建所需数据
	 */
	public function orderCreateData(){

	    $data = Cookie::get('orderCreateData');

	    $data = json_decode($data, true);
	    return $data;
	}
	
	/**
	 * 清除创建所需数据
	 */
	public function deleteCreateData(){
	    $data = Cookie::get('orderCreateData');
	    $data = json_decode($data, true);
	    Cookie::set('orderCreateData', '');
	    //立即购买
	    if($data["order_tag"] == "2"){
	        //清除购物车
	        $res = api("System.Goods.deleteCartByGoods", ["goods_sku_list" => $data["goods_sku_list"]]);
	    }
	    
	    return AjaxReturn($res);
	}
}