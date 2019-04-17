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

namespace app\web\controller;

use data\service\GoodsCategory as GoodsCategoryService;

/**
 * 商品控制器
 */
class Goods extends BaseWeb
{
	/**
	 * 商品详情
	 */
	public function detail()
	{
		$goods_id = request()->get('goods_id', 0);
		$sku_id = request()->get('sku_id', 0);
		
		if (empty($goods_id) && $sku_id) {
			$redirect = __URL(__URL__ . '/index');
			$this->redirect($redirect);
		}
		
		$default_client = request()->cookie("default_client", "");
		if ($default_client == "shop") {
		} elseif (request()->isMobile() && $this->web_info['wap_status'] == 1) {
			$redirect = __URL(__URL__ . "/wap/goods/detail?goods_id=" . $goods_id);
			$this->redirect($redirect);
			exit();
		}
		
		$this->assign('goods_id', $goods_id);
		$this->assign('sku_id', $sku_id);
		
		$data = api('System.Goods.goodsDetail', [ 'goods_id' => $goods_id, 'sku_id' => $sku_id ]);
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
		
		//SEO搜索引擎
		$seo = api("System.Config.seo");
		$seo = $seo['data'];
		if (!empty($data['goods_detail']['keywords'])) {
			$seo['seo_meta'] = $data['goods_detail']['keywords']; // 关键词
		}
		$seo['seo_desc'] = $data['goods_detail']['goods_name'];
		$this->assign("seo_config", $seo);
		
		$this->assign("data", $data);
		$this->assign("title_before", $data['goods_detail']['goods_name']);
		
		if (!empty($data["pc_custom_template"])) {
			// 用户自定义商品详情界面
			return $this->view($this->style . 'goods/' . $data["pc_custom_template"]);
		} else {
			return $this->view($this->style . 'goods/detail');
		}
		
	}
	
	/**
	 * 商品列表
	 */
	public function lists()
	{
		$category_id = request()->get('category_id', ''); // 商品分类
		$keyword = request()->get('keyword', ''); // 关键词
		$shipping_fee = request()->get('fee', ''); // 是否包邮，0：包邮；1：运费价格
		$stock = request()->get('jxsyh', ''); // 仅显示有货，大于0
		$page = request()->get('page', '1'); // 当前页
		$order = request()->get('obyzd', ''); // 排序字段,order by ziduan
		$sort = request()->get('sort', ''); // 排序方式
		$brand_id = request()->get('brand_id', ''); // 品牌id
		$brand_name = request()->get('brand_name', ''); // 品牌名牌
		$min_price = request()->get('min_price', ''); // 价格区间,最小
		$max_price = request()->get('max_price', ''); // 最大
		$platform_proprietary = request()->get('platform_proprietary', ''); // 平台自营 shopid== 1
		$province_id = request()->get('province_id', ''); // 商品所在地
		$province_name = request()->get('province_name', ''); // 所在地名称
		$attr = request()->get('attr', ''); // 属性值
		$spec = request()->get('spec', ''); // 规格值
		
		$data = [
			'category_id' => $category_id,
			'keyword' => $keyword,
			'shipping_fee' => $shipping_fee,
			'stock' => $stock,
			'page' => $page,
			'order' => $order,
			'sort' => $sort,
			'brand_id' => $brand_id,
			'brand_name' => $brand_name,
			'min_price' => $min_price,
			'max_price' => $max_price,
			'platform_proprietary' => $platform_proprietary,
			'province_id' => $province_id,
			'province_name' => $province_name,
			'attr' => $attr,
			'spec' => $spec,
		];
		$this->assign('data', $data);
		foreach ($data as $k => $v) {
			$this->assign("$k", "$v");
		}
		$goods_category = new GoodsCategoryService();
		$goods_category_info = $goods_category->getGoodsCategoryDetail($category_id);
		
		$template = 'goods/lists';
		if (!empty($goods_category_info["pc_custom_template"])) {
			$template = 'goods/' . $goods_category_info["pc_custom_template"];
		}
		
		$this->assign("title_before", "商品列表");
		return $this->view($this->style . $template);
	}
	
	/**
	 * 店铺品牌
	 */
	public function brand()
	{
		$page_index = request()->get('page_index', 1);
		$category_id = request()->get('category_id', 0);
		$this->assign('page_index', $page_index);
		$this->assign('category_id', $category_id);
		$this->assign("title_before", "品牌列表");
		return $this->view($this->style . 'goods/brand');
	}
	
	/**
	 * 全部商品分类
	 */
	public function category()
	{
		$this->assign("title_before", "商品分类");
		return $this->view($this->style . 'goods/category');
	}
	
	/**
	 * 积分中心
	 */
	public function point()
	{
		$id = request()->get('id', '');
		$this->assign("id", $id);
		$this->assign("title_before", "积分中心");
		return $this->view($this->style . 'goods/point');
	}
	
	/**
	 * 商品购买咨询
	 */
	public function consult()
	{
		$this->assign('goods_id', request()->get('goods_id', ''));
		$this->assign('page_index', request()->get('page', 1));
		$this->assign('ct_id', request()->get('ct_id', ''));
		$this->assign("title_before", "商品咨询");
		return $this->view($this->style . 'goods/consult');
	}
	
	/**
	 * 购物车
	 */
	public function cart()
	{
		$this->assign("title_before", "购物车");
		return $this->view($this->style . 'goods/cart');
	}
	
	/**
	 * 选择优惠套餐
	 */
	public function combo()
	{
		$this->checkLogin();
		$this->assign("combo_id", request()->get("combo_id", 0));
		$this->assign('curr_id', request()->get("curr_id", 0));
		$this->assign("title_before", "组合套餐");
		return $this->view($this->style . "goods/combo");
	}
	
	
	/**
	 * 优惠券
	 */
	public function coupon()
	{
		$this->assign('page_index', request()->get('page', 1));
		$this->assign('page_size', 9);
		$this->assign("title_before", "优惠券");
		return $this->view($this->style . 'goods/coupon');
	}
	
	/**
	 * 团购专区
	 */
	public function groupBuy()
	{
		$this->assign('page', request()->get("page", 1));
		$this->assign("title_before", "团购专区");
		return $this->view($this->style . 'goods/groupbuy');
	}
	
	/**
	 * 专题活动列表页面
	 */
	public function topic()
	{
		$this->assign("title_before", "专题活动列表");
		return $this->view($this->style . 'goods/topic');
	}
	
	/**
	 * 专区活动详情
	 */
	public function topicDetail()
	{
		$topic_id = request()->get('topic_id', 0);
		if (!is_numeric($topic_id)) {
			$this->error("没有获取到专题信息");
		}
		$this->assign("topic_id", $topic_id);
		$detail = api("System.Goods.promotionTopicDetail", [ 'topic_id' => $topic_id ]);
		$detail = $detail['data'];
		$this->assign('info', $detail);
		$this->assign("title_before", "专题活动详情");
		return $this->view($this->style . 'goods/' . $detail['pc_topic_template']);
	}
	
	/**
	 * 限时折扣
	 */
	public function discount()
	{
		$page = request()->get('page', 1);
		$category_id = request()->get('category_id', 0);
		$this->assign("page", $page);
		$this->assign("category_id", $category_id);
		$this->assign("title_before", "限时折扣");
		return $this->view($this->style . 'goods/discount');
	}
}