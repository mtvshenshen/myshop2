<?php
/**
 * Shop.php
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

namespace data\service;

/**
 * 店铺服务层
 */
use data\service\BaseService as BaseService;
use data\model\NsShopAdModel as NsShopAdModel;
use data\model\NsShopNavigationModel as NsShopNavigationModel;
use data\model\NsShopModel as NsShopModel;
use think;
use data\model\NsShopWeixinShareModel;
use data\model\NsMemberWithdrawSettingModel;
use data\model\NsOrderGoodsViewModel;
use data\model\NsShopNavigationTemplateModel;
use data\model\NsPickupPointModel;
use data\model\NsShopRecommendModel;
use data\model\NsMemberAccountModel;
use data\model\NsShopRecommendTypeModel;
use data\model\NsGoodsFloorModel;
use think\Cache;
use data\model\BaseModel;

class Shop extends BaseService
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 获取店铺轮播图列表
	 *
	 * @param unknown $page_index
	 * @param number $page_size
	 * @param string $order
	 * @param string $where
	 */
	public function getShopAdList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$shop_ad = new NsShopAdModel();
		$list = $shop_ad->pageQuery($page_index, $page_size, $condition, $order, '*');
		return $list;
	}
	
	/**
	 * 添加店铺轮播图
	 *
	 * @param unknown $ad_image
	 * @param unknown $link_url
	 * @param unknown $sort
	 */
	public function addShopAd($ad_image, $link_url, $sort, $type, $background)
	{
		$data['shop_id'] = $this->instance_id;
		$data['ad_image'] = $ad_image;
		$data['link_url'] = $link_url;
		$data['sort'] = $sort;
		$data['type'] = $type;
		$data['background'] = $background;
		$shop_ad = new NsShopAdModel();
		$res = $shop_ad->save($data);
		$id = $shop_ad->id;
		return $id;
	}
	
	/**
	 * 修改店铺轮播图
	 *
	 * @param unknown $id
	 * @param unknown $ad_image
	 * @param unknown $link_url
	 * @param unknown $sort
	 */
	public function updateShopAd($id, $ad_image, $link_url, $sort, $type, $background)
	{
		$data['shop_id'] = $this->instance_id;
		$data['ad_image'] = $ad_image;
		$data['link_url'] = $link_url;
		$data['sort'] = $sort;
		$data['type'] = $type;
		$data['background'] = $background;
		$shop_ad = new NsShopAdModel();
		$res = $shop_ad->save($data, [
			'id' => $id
		]);
		return $res;
	}
	
	/**
	 * 获取店铺轮播图详情
	 *
	 * @param unknown $id
	 */
	public function getShopAdDetail($id)
	{
		$shop_ad = new NsShopAdModel();
		$info = $shop_ad->get($id);
		return $info;
	}
	
	/**
	 * 删除店铺轮播图
	 *
	 * @param unknown $id
	 */
	public function delShopAd($id)
	{
		$shop_ad = new NsShopAdModel();
		$res = $shop_ad->destroy([
			'id' => $id,
			'shop_id' => $this->instance_id
		]);
		return $res;
	}
	
	/**
	 * 店铺导航添加
	 *
	 * @param unknown $shop_id
	 * @param unknown $nav_title
	 * @param unknown $nav_url
	 * @param unknown $type
	 * @param unknown $sort
	 */
	public function addShopNavigation($nav_title, $nav_url, $type, $sort, $align, $nav_type, $is_blank, $template_name, $nav_icon, $is_show)
	{
		Cache::clear("niu_shop_navigation");
		$shop_navigation = new NsShopNavigationModel();
		$data = array(
			'shop_id' => $this->instance_id,
			'nav_title' => $nav_title,
			'nav_url' => $nav_url,
			'type' => $type,
			'align' => $align,
			'sort' => $sort,
			'nav_type' => $nav_type,
			'is_blank' => $is_blank,
			'template_name' => $template_name,
			'create_time' => time(),
			'modify_time' => time(),
			'nav_icon' => $nav_icon,
			'is_show' => $is_show
		);
		$shop_navigation->save($data);
		$retval = $shop_navigation->nav_id;
		return $retval;
	}
	
	/**
	 * 店铺导航修改
	 *
	 * @param unknown $shop_id
	 * @param unknown $nav_title
	 * @param unknown $nav_url
	 * @param unknown $type
	 * @param unknown $sort
	 */
	public function updateShopNavigation($nav_id, $nav_title, $nav_url, $type, $sort, $align, $nav_type, $is_blank, $template_name, $nav_icon, $is_show)
	{
		Cache::clear("niu_shop_navigation");
		$shop_navigation = new NsShopNavigationModel();
		$data = array(
			'nav_title' => $nav_title,
			'nav_url' => $nav_url,
			'type' => $type,
			'align' => $align,
			'sort' => $sort,
			'nav_type' => $nav_type,
			'is_blank' => $is_blank,
			'template_name' => $template_name,
			'modify_time' => time(),
			'nav_icon' => $nav_icon,
			'is_show' => $is_show
		);
		$shop_navigation->save($data, [
			'nav_id' => $nav_id
		]);
		return $nav_id;
	}
	
	/**
	 * 修改店铺列表排序
	 * @param unknown $shop_id
	 */
	public function updateShopSort($shop_id, $shop_sort)
	{
		$shop = new NsShopModel();
		$data = array(
			'shop_sort' => $shop_sort
		);
		$shop->save($data, [
			'shop_id' => $shop_id
		]);
		
		return $shop_id;
	}
	
	/**
	 * 设置店铺推荐
	 * @param unknown $shop_id
	 */
	public function setRecomment($shop_id, $shop_recommend)
	{
		$shop = new NsShopModel();
		$data = array(
			'shop_recommend' => $shop_recommend
		);
		$shop->save($data, [
			'shop_id' => $shop_id
		]);
		
		return $shop_id;
	}
	
	/**
	 * 店铺导航删除
	 *
	 * @param unknown $nav_id
	 */
	public function delShopNavigation($nav_id)
	{
		Cache::clear("niu_shop_navigation");
		$shop_navigation = new NsShopNavigationModel();
		$retval = $shop_navigation->destroy($nav_id);
		return $retval;
	}
	
	/**
	 * 导航列表
	 *
	 * @param unknown $page_index
	 * @param number $page_size
	 * @param string $order
	 * @param string $where
	 */
	public function ShopNavigationList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$data = array(
			$page_index,
			$page_size,
			$condition,
			$order
		);
		$data = json_encode($data);
		$cache = Cache::tag("niu_shop_navigation")->get("ShopNavigationList" . $data);
		if (empty($cache)) {
			$shop_navigation = new NsShopNavigationModel();
			$list = $shop_navigation->pageQuery($page_index, $page_size, $condition, $order, '*');
			Cache::tag("niu_shop_navigation")->set("ShopNavigationList" . $data, $list);
			return $list;
		} else {
			return $cache;
		}
	}
	
    /**
     * 导航列表
     * @param unknown $type 1:pc  2:wap
     */
	public function ShopNavigationQuery($type)
	{
	    $cache = Cache::tag("niu_shop_navigation")->get("ShopNavigationQuery" . $type);
	    if (empty($cache)) {
	        $shop_navigation = new NsShopNavigationModel();
	        $list = $shop_navigation->getQuery(['type' => $type], '*');
	        Cache::tag("niu_shop_navigation")->set("ShopNavigationQuery" . $type, $list);
	        return $list;
	    } else {
	        return $cache;
	    }
	}
	
	/**
	 * 查询店铺导航详情
	 *
	 * @param unknown $nav_id
	 */
	public function shopNavigationDetail($nav_id)
	{
		$cache = Cache::tag("niu_shop_navigation")->get("shopNavigationDetail".$nav_id);
		// if(empty($cache))
		// {
		$shop_navigation = new NsShopNavigationModel();
		$info = $shop_navigation->get($nav_id);
		Cache::tag("niu_shop_navigation")->set("shopNavigationDetail".$nav_id, $info);
		return $info;
		// }else{
		// return $info;
		// }
	}
	
	/**
	 * 修改导航排序
	 *
	 * @param unknown $nav_id
	 * @param unknown $sort
	 */
	public function modifyShopNavigationSort($nav_id, $sort)
	{
		Cache::clear("niu_shop_navigation");
		$shop_navigation = new NsShopNavigationModel();
		$retval = $shop_navigation->save([
			'sort' => $sort
		], [
			'nav_id' => $nav_id
		]);
		return $retval;
	}
	
	
	/**
	 * 用户店铺消费(non-PHPdoc)
	 *
	 */
	public function getShopUserConsume($shop_id, $uid)
	{
		$member_account = new NsMemberAccountModel();
		$money = $member_account->getInfo([
			"shop_id" => $shop_id,
			'uid' => $uid
		]);
		if (!empty($money)) {
			return $money['member_cunsum'];
		} else {
			return 0;
		}
	}
	
	/**
	 * 修改店铺分享设置
	 * @param unknown $shop_id
	 * @param unknown $goods_param_1
	 * @param unknown $goods_param_2
	 * @param unknown $shop_param_1
	 * @param unknown $shop_param_2
	 * @param unknown $shop_param_3
	 * @param unknown $qrcode_param_1
	 * @param unknown $qrcode_param_2
	 */
	public function updateShopShareCinfig($shop_id, $goods_param_1, $goods_param_2, $shop_param_1, $shop_param_2, $shop_param_3, $qrcode_param_1, $qrcode_param_2)
	{
		$shop_share = new NsShopWeixinShareModel();
		$data = array(
			'goods_param_1' => $goods_param_1,
			'goods_param_2' => $goods_param_2,
			'shop_param_1' => $shop_param_1,
			'shop_param_2' => $shop_param_2,
			'shop_param_3' => $shop_param_3,
			'qrcode_param_1' => $qrcode_param_1,
			'qrcode_param_2' => $qrcode_param_2
		);
		$retval = $shop_share->save($data, [
			'shop_id' => $shop_id
		]);
		return $retval;
	}
	
	/**
	 * 获取店铺分享设置
	 * @param unknown $shop_id
	 * @return \think\static
	 */
	public function getShopShareConfig($shop_id)
	{
		$shop_share = new NsShopWeixinShareModel();
		$count = $shop_share->getCount([
			'shop_id' => $shop_id
		]);
		if ($count > 0) {
			$info = $shop_share->get($shop_id);
		} else {
			$data = array(
				'shop_id' => $shop_id,
				'goods_param_1' => '优惠价：',
				'goods_param_2' => '全场正品',
				'shop_param_1' => '欢迎打开',
				'shop_param_2' => '分享赚佣金',
				'shop_param_3' => '',
				'qrcode_param_1' => '向您推荐',
				'qrcode_param_2' => '注册有优惠'
			);
			$shop_share->save($data);
			$info = $shop_share->get($shop_id);
		}
		return $info;
	}
	
	
	/**
	 * 生成佣金流水号
	 */
	private function getWithdrawNo()
	{
		$no_base = date("ymdhis", time());
		$withdraw_no = $no_base . rand(111, 999);
		return $withdraw_no;
	}
	
	
	/**
	 * 获取订单商品列表
	 * @param unknown $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 */
	public function getShopOrderAccountRecordsList($page_index, $page_size = 0, $condition = '', $order = '')
	{
		$order_goods = new NsOrderGoodsViewModel();
		$return = $order_goods->getOrderGoodsViewList($page_index, $page_size, $condition, $order);
		return $return;
	}
	
	
	/**
	 * 添加会员提现设置
	 * @param unknown $shop_id
	 * @param unknown $withdraw_cash_min
	 * @param unknown $withdraw_multiple
	 * @param unknown $withdraw_poundage
	 * @param unknown $withdraw_message
	 * @param unknown $withdraw_account_type
	 */
	public function addMemberWithdrawSetting($shop_id, $withdraw_cash_min, $withdraw_multiple, $withdraw_poundage, $withdraw_message, $withdraw_account_type)
	{
		// TODO Auto-generated method stub
		$member_withdraw_setting = new NsMemberWithdrawSettingModel();
		$data = array(
			"shop_id" => $shop_id,
			"withdraw_cash_min" => $withdraw_cash_min,
			"withdraw_multiple" => $withdraw_multiple,
			"withdraw_poundage" => $withdraw_poundage,
			"withdraw_message" => $withdraw_message,
			"withdraw_account_type" => $withdraw_account_type,
			"create_time" => time()
		);
		$member_withdraw_setting->save($data);
		return $member_withdraw_setting->id;
	}
	
	/**
	 * 修改会员提现设置
	 * @param unknown $shop_id
	 * @param unknown $withdraw_cash_min
	 * @param unknown $withdraw_multiple
	 * @param unknown $withdraw_poundage
	 * @param unknown $withdraw_message
	 * @param unknown $withdraw_account_type
	 * @param unknown $id
	 */
	public function updateMemberWithdrawSetting($shop_id, $withdraw_cash_min, $withdraw_multiple, $withdraw_poundage, $withdraw_message, $withdraw_account_type, $id)
	{
		// TODO Auto-generated method stub
		$member_withdraw_setting = new NsMemberWithdrawSettingModel();
		$data = array(
			"withdraw_cash_min" => $withdraw_cash_min,
			"withdraw_multiple" => $withdraw_multiple,
			"withdraw_poundage" => $withdraw_poundage,
			"withdraw_message" => $withdraw_message,
			"withdraw_account_type" => $withdraw_account_type,
			"modify_time" => time()
		);
		$retval = $member_withdraw_setting->where(array(
			"shop_id" => $shop_id,
			"id" => $id
		))->update($data);
		return $retval;
	}
	
	/**
	 * 获取提现设置信息
	 *
	 * @param string $field
	 */
	public function getWithdrawInfo($shop_id)
	{
		$member_withdraw_setting = new NsMemberWithdrawSettingModel();
		$info = $member_withdraw_setting->getInfo([
			"shop_id" => $shop_id
		]);
		
		return $info;
	}
	
	/**
	 * 获取导航商城模块
	 * @param unknown $use_type
	 */
	public function getShopNavigationTemplate($use_type)
	{
		$template_model = new NsShopNavigationTemplateModel();
		$template_list = $template_model->getQuery([
			"is_use" => 1,
			"use_type" => array( "in", $use_type)
		], "*", "");
		return $template_list;
	}
	
	/**
	 * 自提点添加
	 *
	 * @param unknown $shop_id
	 * @param unknown $name
	 * @param unknown $address
	 * @param unknown $contact
	 * @param unknown $phone
	 * @param unknown $province_id
	 * @param unknown $city_id
	 * @param unknown $district_id
	 * @param unknown $longitude
	 * @param unknown $latitude
	 */
	public function addPickupPoint($data)
	{
	    
		$pickup_point_model = new NsPickupPointModel();
		$data["create_time"] = time();
		
		$pickup_point_model->save($data);
		return $pickup_point_model->id;
	}
	
	/**
	 * 自提点修改
	 * @param unknown $id
	 * @param unknown $shop_id
	 * @param unknown $name
	 * @param unknown $address
	 * @param unknown $contact
	 * @param unknown $phone
	 * @param unknown $province_id
	 * @param unknown $city_id
	 * @param unknown $district_id
	 * @param unknown $longitude
	 * @param unknown $latitude
	 * @return boolean
	 */
	public function updatePickupPoint($data, $condition)
	{
		$pickup_point_model = new NsPickupPointModel();
// 		$data = array(
// 			"shop_id" => $shop_id,
// 			"name" => $name,
// 			"address" => $address,
// 			"contact" => $contact,
// 			"phone" => $phone,
// 			"province_id" => $province_id,
// 			'city_id' => $city_id,
// 			'district_id' => $district_id
// 		);
		$retval = $pickup_point_model->save($data, $condition);
		return $retval;
	}
	
	/**
	 * 自提点列表
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $where
	 * @param string $order
	 * @return multitype:number unknown
	 */
	public function getPickupPointList($page_index = 1, $page_size = 0, $where = '', $order = '')
	{
		$pickup_point_model = new NsPickupPointModel();
		$list = $pickup_point_model->pageQuery($page_index, $page_size, $where, $order, '*');
		if (!empty($list)) {
			$address = new Address();
			foreach ($list['data'] as $k => $v) {
				$list['data'][ $k ]['province_name'] = $address->getProvinceName($v['province_id']);
				$list['data'][ $k ]['city_name'] = $address->getCityName($v['city_id']);
				$list['data'][ $k ]['district_name'] = $address->getDistrictName($v['district_id']);
			}
		}
		return $list;
	}
	
	/**
	 * 删除自提点
	 * @param unknown $pickip_id
	 */
	public function deletePickupPoint($pickip_id)
	{
		$pickup_point_model = new NsPickupPointModel();
		$retval = $pickup_point_model->destroy($pickip_id);
		return $retval;
	}
	
	/**
	 * 获取自提点详情
	 * @param unknown $pickip_id
	 */
	public function getPickupPointDetail($pickip_id)
	{
		$pickup_point_model = new NsPickupPointModel();
		$pickup_point_detail = $pickup_point_model->get($pickip_id);
		return $pickup_point_detail;
	}
	
	/**
	 * 功能说明：获取店铺信息
	 */
	public function getShopInfo($shop)
	{
		// 获取信息
		$shopInfo['shopId'] = $shop;
		$shopInfo['shopName'] = $this->instance_name;
		// 返回信息
		return $shopInfo;
	}
	
	/**
	 * 获取店铺商品推荐
	 */
	public function getGoodsRecommend($page_index = 1, $page_size = 0, $condition = [], $order = '', $field = '*') {
	    $list = Cache::tag("niu_goods_wap_block")->get("getGoodsRecommend");
	    $recommend = new NsShopRecommendModel();
	    if(empty($list)) {

    	    $list = $recommend->pageQuery($page_index, $page_size, $condition, $order, $field);
	        Cache::tag("niu_goods_wap_block")->set("getGoodsRecommend", $list);
	    }

	    $goods = new Goods();
	    foreach ($list['data'] as $k => $v) {
	        if($v['type'] == 1) {//标签
	            $goods_group = new GoodsGroup();
	            $info = $goods_group->getGoodsGroupDetail($v['alis_id']);
	            $list['data'][$k]['type_name'] = $info['group_name'];
	            $list['data'][$k]['name'] = '标签';
	            
	            // $str = "FIND_IN_SET(" . $v['alis_id'] . ",ng.group_id_array)";
	            // $conditions[""] = [
	            //     [
	            //         "EXP",
	            //         $str
	            //     ]
	            // ];
	            $list['data'][$k]['goods_list'] = $goods->getRecommendGoodsList(1,$v['show_num'],$conditions);
	            
	        }else if($v['type'] == 2) {//分类
	            $goodsCategory = new GoodsCategory();
	            $info = $goodsCategory->getParentCategory($v['alis_id']);
	            $list['data'][$k]['type_name'] = $info;
	            $list['data'][$k]['name'] = '分类';
	            $list['data'][$k]['goods_list'] = $goods->getRecommendGoodsList(1,$v['show_num'],['ng.category_id' => $v['alis_id']]);
	            
	        }else if($v['type'] == 3) {//品牌
	            $goodsbrand = new GoodsBrand();
	            $info = $goodsbrand->getGoodsBrandInfo($v['alis_id'], 'brand_name');
	            $list['data'][$k]['type_name'] = $info['brand_name'];
	            $list['data'][$k]['name'] = '品牌';
	            $list['data'][$k]['goods_list'] = $goods->getRecommendGoodsList(1,$v['show_num'],['ng.brand_id' => $v['alis_id']]);
	        }else if($v['type'] == 4) {
	            $list['data'][$k]['type_name'] = '新品';
	            $list['data'][$k]['name'] = '推荐';
	            $list['data'][$k]['goods_list'] = $goods->getRecommendGoodsList(1,$v['show_num'],['ng.is_new' => 1]);
	        }else if($v['type'] == 5) {
	            $list['data'][$k]['type_name'] = '精品';
	            $list['data'][$k]['name'] = '推荐';
	            $list['data'][$k]['goods_list'] = $goods->getRecommendGoodsList(1,$v['show_num'],['ng.is_recommend' => 1]);
	        }else if($v['type'] == 6) {
	            $list['data'][$k]['type_name'] = '热卖';
	            $list['data'][$k]['name'] = '推荐';
	            $list['data'][$k]['goods_list'] = $goods->getRecommendGoodsList(1,$v['show_num'],['ng.is_hot' => 1]);
	        }else if($v['type'] == 7) {
	            $list['data'][$k]['goods_list'] = $goods->getRecommendGoodsList(1,$v['show_num'],['ng.goods_id' => ['in', $v['alis_id']]]);
	            $list['data'][$k]['name'] = '自定义';
	            $list['data'][$k]['goods_id_array'] = trim($v['alis_id'], ',');
	            $list['data'][$k]['type_name'] = '自定义';
	        }else{
	            $list['data'][$k]['type_name'] = '';
	        }
	    }
	    return $list;
    	
	}
	
	/**
	 * 添加店铺商品推荐
	 */
	public function addGoodsRecommend($alis_id, $type, $name = '', $num = 0, $shop_id = 0) {
	    Cache::clear("niu_goods_wap_block");
	    $shop_recommend = new NsShopRecommendModel();
	    $data = [
	        'alis_id' => $alis_id,
	        'type'          => $type,
	        'recommend_name'          => $name,
	        'show_num'           => $num
	    ];
	    $res = $shop_recommend->save($data);
	    return $res;
	}

	/**
	 * 修改店铺商品推荐
	 */
	public function updateGoodsRecommend($recommend_id, $alis_id, $type, $name = '', $num = 0, $shop_id = 0) {
	    Cache::clear("niu_goods_wap_block");
	    $shop_recommend = new NsShopRecommendModel();
	    $data = [
	        'alis_id' => $alis_id,
	        'type'          => $type,
	        'recommend_name'          => $name,
	        'show_num'           => $num
	    ];
	    $res = $shop_recommend->save($data, ['id' => $recommend_id]);
	    return $res;
	    
	}
	
	
	/**
	 * 删除店铺商品推荐
	 * @param unknown $ids
	 */
	public function delectGoodsRecommend($recommend_id, $shop_id = 0){
	    Cache::clear("niu_shop_navigation");
	    if(empty($recommend_id)) return -1;
	    $recommend = new NsShopRecommendModel();
        $res = $recommend->destroy(['id' => $recommend_id]);
        return $res;
	      
	}
	
	/**
	 * 添加商品推荐分类
	 */
	public function addRecommendType($data, $condition)
	{
	    $model = new NsShopRecommendTypeModel();
	    $res = $model->save($data);
	    return $res;
	}
	
	/**
	 * 商品推荐分类列表
	 */
	public function getRecommendTypeList($page_index = 1, $page_size = 0, $condition = '', $order = '', $field = '*')
	{
	    $model = new NsShopRecommendTypeModel();
	    $list = $model->pageQuery($page_index, $page_size, $condition, $order, $field);
	    return $list;
	}
	
	/**
	 * 商品推荐条幅
	 */
	public function saveRecommendImg($id, $img)
	{
		Cache::clear("niu_goods_wap_block");
	    $model = new NsShopRecommendModel();
	    $res = $model->save(['img' => $img], ['id' => $id]);
	    return $res;
	}
	
	
	/**
	 * 自提点列表
	 * @param string $condition
	 */
	public function getPickupPointQuery($condition)
	{
	    $pickup_point_model = new NsPickupPointModel();
	    $list = $pickup_point_model->getQuery($condition);
	    if (!empty($list)) {
	        $address = new Address();
	        foreach ($list as $k => $v) {
	            $list[ $k ]['province_name'] = $address->getProvinceName($v['province_id']);
	            $list[ $k ]['city_name'] = $address->getCityName($v['city_id']);
	            $list[ $k ]['district_name'] = $address->getDistrictName($v['district_id']);
	        }
	    }
	    return $list;
	}
	
	/**
	 * 楼层
	 */
	public function setGoodsFloor($data, $condition = [])
	{
        $model = new NsGoodsFloorModel();
        
        if($condition) {
            $res = $model->save($data, $condition);
        }else {
            $res = $model->save($data);
        }
        
        return $res;
    }
    
    /**
     * 楼层列表（不关联）
     */
    public function getGoodsFloorList($page_index = 1, $page_size = 0, $condition = '', $order = '', $field = '*')
    {
        $model = new NsGoodsFloorModel();
        $list = $model->pageQuery($page_index, $page_size, $condition, $order, $field);
        
        return $list;
    }
    

    /**
     * 更改楼层排序
     */
    public function updateFloorSort($sort, $id)
    {
        $model = new NsGoodsFloorModel();
        $retval = $model->save([
            'sort' => $sort
        ], [
            'id' => $id
        ]);
        return $retval;
    }
    
    /**
     * 删除楼层
     */
    public function deleteFloor($id)
    {
        $model = new NsGoodsFloorModel();
        $retval = $model->destroy(['id' => ['in', $id]]);
        return $retval;
    }
    
    /**
     * 获取板块信息
     *
     * @param $condition
     * @param string $field
     * @return array
     */
    public function getFloorInfo($condition, $field = '*')
    {
    
        $model = new NsGoodsFloorModel();
        $res = $model->getInfo($condition, $field);
        return $res;
    }
    
    /**
     * 处理板块模板数据结构
     * @param $data
     * @return mixed
     */
    public function formatBlockData($data)
    {
        if (!empty($data)) {
            $product_model = new Goods();
            $goodsCategoty = new GoodsCategory();
            $goodsBrand = new GoodsBrand();
    
            foreach ($data as $k => $v) {
                if ($k == "text") {
                } elseif ($k == "product_category") {
    
                    //查询商品分类信息
                    foreach ($v as $child_k => $child_v) {
                        if (!empty($child_v)) {
                            $condition = array();
                            $condition['category_id'] = ['in', $child_v];
                            $list = $goodsCategoty->getGoodsCategoryList(1, 0, $condition, '', "*");
                            if ($list['code'] == 0) {
                                $data[$k][$child_k] = $list['data'];
                            }
                        }
                    }
    
                } elseif ($k == "product") {
    
                    foreach ($v as $child_k => $child_v) {
                        if (!empty($child_v)) {
                            $condition = array();
    
                            $page_size = PAGESIZE;
                             
                            if (!empty($child_v['page_size'])) {
                                $page_size = $child_v['page_size'];
                            }
                            if ($child_v['product_source'] == 'product_category') {
                                $condition['ng.category_id'] = $child_v['source_value'];
                            } elseif ($child_v['product_source'] == 'product_label') {
                                $condition['ng.group_id_array'] = ["like","%".$child_v['source_value']."%"];
                            } elseif ($child_v['product_source'] == 'product_brand') {
                                $condition['ng.brand_id'] = $child_v['source_value'];
                            } elseif ($child_v['product_source'] == 'product_recommend') {
                                $condition[$child_v['source_value']] = 1;
                            } elseif ($child_v['product_source'] == 'product_diy') {
                                $condition['ng.goods_id'] = ['in', $child_v['source_value']['goods_id']];
                                $page_size = 0;//自选产品，数量由用户控制
                            }
                            
                            $list = $product_model->getGoodsList(1, $page_size, $condition);
                            $data[$k][$child_k] = $list['data'];
                        }
                    }
    
                } elseif ($k == "adv") {
    
                } elseif ($k == "brand") {
    
                    //查询品牌
                    foreach ($v as $child_k => $child_v) {
                        if (!empty($child_v)) {
                            $condition = array();
                            $condition['brand_id'] = ['in', $child_v];
                            $list = $goodsBrand->getGoodsBrandList(1, 0, $condition, "sort desc", "*");
                            if ($list['code'] == 0) {
                                $data[$k][$child_k] = $list['data'];
                            }
                        }
                    }
    
                }
            }
            return $data;
        }
    }
    
}
