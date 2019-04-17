<?php
/**
 * Goods.php
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

use addons\NsBargain\data\service\Bargain;
use addons\NsPintuan\data\service\Pintuan;
use data\service\Config as WebConfig;
use data\service\Goods as GoodsService;
use data\service\GoodsCategory;
use data\service\Promotion;
use data\service\WebSite;

/**
 * 商品相关
 *
 * @author Administrator
 *
 */
class Goods extends BaseWap
{
	
	/**
	 * 商品详情
	 *
	 * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
	 */
	public function detail()
	{
		$goods_id = request()->get('goods_id', 0);
		$sku_id = request()->get('sku_id', 0);
		$bargain_id = request()->get('bargain_id', 0);
		$group_id = request()->get("group_id", 0);
		
		if ($goods_id == 0) {
			$this->error("没有获取到商品信息");
		}
		
		$this->assign('goods_id', $goods_id);
		$this->assign('sku_id', $sku_id);
		$this->assign('bargain_id', $bargain_id);
		$this->assign('group_id', $group_id);
		
		$this->web_site = new WebSite();
		
		// 切换到PC端
		if (!request()->isMobile() && $this->web_info['web_status'] == 1) {
			$redirect = __URL(__URL__ . "/goods/detail?goods_id=" . $goods_id);
			$this->redirect($redirect);
			exit();
		}
		
		$data = api('System.Goods.goodsDetail', [ 'goods_id' => $goods_id, 'sku_id' => $sku_id, 'bargain_id' => $bargain_id, 'group_id' => $group_id ]);
		$data = $data['data'];
		if (empty($data['goods_detail'])) {
			$redirect = __URL(__URL__ . '/index');
			$this->redirect($redirect);
		}
		
		if ($data['goods_detail']['goods_type'] == 0) {
			$virtual_goods = api("System.Config.virtualGoodsConfig");
			$virtual_goods = $virtual_goods['data'];
			if ($virtual_goods == 0) {
				$redirect = __URL(__URL__ . '/index');
				$this->error("未开启虚拟商品功能", $redirect);
			}
		}
		
		$this->assign("data", $data);
		return $this->view($this->style . 'goods/detail');
	}
	
	/**
	 * 得到当前时间戳的毫秒数
	 *
	 * @return number
	 */
	public function getCurrentTime()
	{
		$time = time();
		$time = $time * 1000;
		return $time;
	}
	
	/**
	 * 返回商品数量和当前商品的限购
	 *
	 * @param unknown $goods_id
	 */
	public function getCartInfo($goods_id)
	{
		$goods = new GoodsService();
		$cartlist = $goods->getCart($this->uid);
		$num = 0;
		if (!empty($cartlist)) {
			foreach ($cartlist as $v) {
				if ($v["goods_id"] == $goods_id) {
					$num = $v["num"];
				}
			}
		}
		$this->assign("carcount", count($cartlist)); // 购物车商品数量
		$this->assign("num", $num); // 购物车已购买商品数量
	}
	
	/**
	 * 购物车页面
	 */
	public function cart()
	{
		$this->assign("title", "购物车");
		return $this->view($this->style . 'goods/cart');
	}
	
	/**
	 * 平台商品分类列表
	 */
	public function category()
	{
		$webConfig = new WebConfig();
		$show_type = $webConfig->getWapClassifiedDisplayMode($this->instance_id);
		$show_type = json_decode($show_type, true);
		$this->assign('show_type', $show_type);
		$this->assign("title", "商品分类");
		return $this->view($this->style . 'goods/category');
	}
	
	/**
	 * 店铺商品分组列表
	 */
	public function groupList()
	{
		$this->assign("title", '商品分组');
		return $this->view($this->style . 'goods/group_list');
	}
	
	/**
	 * 加入购物车前显示商品规格
	 */
	public function joinCart()
	{
		$goods = new GoodsService();
		$goods_id = request()->post('goods_id', '');
		$goods_detail = $goods->getGoodsDetail($goods_id);
		$this->assign("goods_detail", $goods_detail);
		$this->assign("shopname", $this->shop_name);
		return $this->view($this->style . 'goods/join_cart');
	}
	
	/**
	 * 品牌专区
	 */
	public function brand()
	{
		$this->assign("title_before", "品牌专区");
		$this->assign("title", "品牌专区");
		return $this->view($this->style . 'goods/brand');
	}
	
	/**
	 * 商品列表
	 */
	public function lists()
	{
		// 查询购物车中商品的数量
		$uid = $this->uid;
		$goods_category_service = new GoodsCategory();
		$this->assign('uid', $uid);
		
		$category_id = request()->get('category_id', ''); // 商品分类
		$brand_id = request()->get('brand_id', ''); // 品牌
		$this->assign('brand_id', $brand_id);
		$this->assign('category_id', $category_id);
		// 筛选条件
		
		if ($category_id != "") {
			$goods_category_info = $goods_category_service->getGoodsCategoryDetail($category_id);
		}
		$template = 'goods/lists';
		if (!empty($goods_category_info["wap_custom_template"])) {
			$template = 'goods/' . $goods_category_info["wap_custom_template"];
		}
		$this->assign("title", "商品列表");
		return $this->view($this->style . $template);
	}
	
	/**
	 * 积分中心
	 *
	 * @return \think\response\View
	 */
	public function point()
	{
		$this->assign('title', "积分中心");
		return $this->view($this->style . 'goods/point');
	}
	
	/**
	 * 商品组合套餐列表
	 */
	public function combo()
	{
		if (!addon_is_exit('NsCombopackage')) {
			$this->error('未检测到组合套餐插件');
		}
		$goods_id = request()->get("goods_id", 0);
		if (empty($goods_id)) {
			$this->error('缺少参数');
		}
		$this->assign("goods_id", $goods_id);
		$this->assign("title", lang("combo_package"));
		return $this->view($this->style . "goods/combo");
	}
	
	/**
	 * 优惠券列表
	 */
	public function coupon()
	{
		$this->assign("title", '优惠券领取');
		return $this->view($this->style . 'goods/coupon');
	}
	
	/**
	 * 领取优惠券
	 */
	public function couponReceive()
	{
		return $this->view($this->style . 'goods/coupon_receive');
	}
	
	/**
	 * 拼团专区
	 * 创建时间：2017年12月27日15:35:28
	 */
	public function pintuan()
	{
		if (!addon_is_exit('NsPintuan')) {
			$this->error('未检测到拼团插件');
		}
		$this->assign('title', "拼团专区");
		return $this->view($this->style . "goods/pintuan");
	}
	
	/**
	 * 团购专区
	 */
	public function groupBuy()
	{
		$this->assign("title", "团购专区");
		return $this->view($this->style . 'goods/groupbuy');
	}
	
	/**
	 * 专题活动列表页面
	 */
	public function topic()
	{
		$this->assign('title', "专题活动");
		return $this->view($this->style . 'goods/topic');
	}
	
	public function topicDetail()
	{
		$topic_id = request()->get('topic_id', 0);
		
		if (!is_numeric($topic_id)) {
			$this->error("没有获取到专题信息");
		}
		$promotion = new Promotion();
		$topic_goods = $promotion->getPromotionTopicDetail($topic_id);
		$this->assign('info', $topic_goods);
		$this->assign('title', "专题信息");
		return $this->view($this->style . 'goods/' . $topic_goods['wap_topic_template']);
	}
	
	/**
	 * 砍价商品列表
	 */
	public function bargain()
	{
		if (!addon_is_exit('NsBargain')) {
			$this->error('未检测到砍价插件');
		}
		$this->assign('title', "砍价专区");
		return $this->view($this->style . 'goods/bargain');
	}
	
	/**
	 * 砍价商品详情
	 */
	public function detailBargain()
	{
		if (!addon_is_exit('NsBargain')) {
			$this->error('未检测到砍价插件');
		}
		return $this->view($this->style . 'goods/detail_bargain');
	}
	
	/**
	 * 砍价商品发起页面
	 */
	public function bargainLaunch()
	{
		if (!addon_is_exit('NsBargain')) {
			$this->error('未检测到砍价插件');
		}
		// 分享
		$ticket = $this->getShareTicket();
		$launch_id = request()->get('launch_id', '');
		$this->assign('launch_id', $launch_id);
		$this->assign("signPackage", $ticket);
		$this->assign('title', "我的砍价");
		return $this->view($this->style . 'goods/bargain_launch');
	}
	
	/**
	 * 限时折扣
	 */
	public function discount()
	{
		$current_time = $this->getCurrentTime();
		$this->assign('ms_time', $current_time);
		$this->assign("title_before", "限时折扣");
		$this->assign("title", "限时折扣");
		return $this->view($this->style . 'goods/discount');
	}
}