<?php
/**
 * PintuanOrder.php
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

use data\model\AlbumPictureModel;
use data\model\NsCartModel;
use data\model\NsGoodsModel;
use data\service\OrderQuery;

/**
 * 拼团订单控制器
 *
 * @author Administrator
 *
 */
class Pintuan extends Order
{
	
	/**
	 * 订单数据存session
	 *
	 * @return number
	 */
	public function orderCreateSession()
	{
		$tag = request()->post('tag', '');
		if (empty($tag)) {
			return -1;
		}
		$_SESSION['order_tag'] = 'spelling';
		$_SESSION['order_sku_list'] = request()->post('sku_id') . ':' . request()->post('num');
		$_SESSION['order_goods_type'] = request()->post("goods_type"); // 实物类型标识
		$_SESSION['order_tuangou_group_id'] = request()->post("tuangou_group_id", 0);
		return 1;
	}
	
	/**
	 * 立即购买
	 */
	public function buyNowSession()
	{
		$order_sku_list = isset($_SESSION["order_sku_list"]) ? $_SESSION["order_sku_list"] : "";
		if (empty($order_sku_list)) {
			$this->redirect(__URL__); // 没有商品返回到首页
		}
		
		$cart_list = array();
		$order_sku_list = explode(":", $_SESSION["order_sku_list"]);
		$sku_id = $order_sku_list[0];
		$num = $order_sku_list[1];
		
		// 获取商品sku信息
		$goods_sku = new \data\model\NsGoodsSkuModel();
		$sku_info = $goods_sku->getInfo([
			'sku_id' => $sku_id
		], '*');
		
		// 查询当前商品是否有SKU主图
		$order_query = new OrderQuery();
		$picture = $order_query->getSkuPictureBySkuId($sku_info);
		
		// 清除非法错误数据
		$cart = new NsCartModel();
		if (empty($sku_info)) {
			$cart->destroy([
				'buyer_id' => $this->uid,
				'sku_id' => $sku_id
			]);
			$this->redirect(__URL__); // 没有商品返回到首页
		}
		$pintuan = new Pintuan();
		$goods = new NsGoodsModel();
		$goods_info = $goods->getInfo([
			'goods_id' => $sku_info["goods_id"]
		], 'max_buy,state,point_exchange_type,point_exchange,picture,goods_id,goods_name,max_use_point');
		
		$cart_list["stock"] = $sku_info['stock']; // 库存
		$cart_list["sku_id"] = $sku_info["sku_id"];
		$cart_list["sku_name"] = $sku_info["sku_name"];

//		$goods_preference = new GoodsPreference();
//		$member_price = $goods_preference->getGoodsSkuMemberPrice($sku_info['sku_id'], $this->uid);
		$goods_pintuan = $pintuan->getGoodsPintuanDetail($sku_info["goods_id"]);
		$cart_list["price"] = $goods_pintuan['tuangou_money'];
		
		$cart_list["goods_id"] = $goods_info["goods_id"];
		$cart_list["goods_name"] = $goods_info["goods_name"];
		$cart_list["max_buy"] = $goods_info['max_buy']; // 限购数量
		$cart_list['point_exchange_type'] = $goods_info['point_exchange_type']; // 积分兑换类型 0 非积分兑换 1 只能积分兑换
		$cart_list['point_exchange'] = $goods_info['point_exchange']; // 积分兑换
		if ($goods_info['state'] != 1) {
			$this->redirect(__URL__); // 商品状态 0下架，1正常，10违规（禁售）
		}
		$cart_list["num"] = $num;
		$cart_list["max_use_point"] = $goods_info["max_use_point"] * $num;
		// 如果购买的数量超过限购，则取限购数量
		if ($goods_info['max_buy'] != 0 && $goods_info['max_buy'] < $num) {
			$num = $goods_info['max_buy'];
		}
		// 如果购买的数量超过库存，则取库存数量
		if ($sku_info['stock'] < $num) {
			$num = $sku_info['stock'];
		}
		// 获取图片信息
		$album_picture_model = new AlbumPictureModel();
		$picture_info = $album_picture_model->get($picture == 0 ? $goods_info['picture'] : $picture);
		$cart_list['picture_info'] = $picture_info;
		
		if (count($cart_list) == 0) {
			$this->redirect(__URL__); // 没有商品返回到首页
		}
		$list[] = $cart_list;
		$goods_sku_list = $sku_id . ":" . $num; // 商品skuid集合
		$res["list"] = $list;
		$res["goods_sku_list"] = $goods_sku_list;
		return $res;
	}
	
	/**
	 * 我的拼单
	 * @return array|\think\response\View
	 */
	public function lists()
	{
		$this->assign("title", "我的拼单");
		return $this->view($this->style . 'pintuan/lists');
	}
	
	/**
	 * 拼团分享界面
	 * 创建时间：2017年12月28日14:10:47
	 * (non-PHPdoc)
	 *
	 * @see \app\wap\controller\Order::spellGroupShare()
	 */
	public function share()
	{
		$ticket = $this->getShareTicket();
		$this->assign("signPackage", $ticket);
		return $this->view($this->style . 'pintuan/share');
	}
}