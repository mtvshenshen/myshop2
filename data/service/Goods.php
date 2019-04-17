<?php
/**
 * Goods.php
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
 * 商品服务层
 */
use data\model\AlbumPictureModel as AlbumPictureModel;
use data\model\NsAttributeModel;
use data\model\NsAttributeValueModel;
use data\model\NsCartModel;
use data\model\NsClickFabulousModel;
use data\model\NsConsultModel;
use data\model\NsConsultTypeModel;
use data\model\NsCouponModel;
use data\model\NsCouponTypeModel;
use data\model\NsGoodsAttributeDeletedModel;
use data\model\NsGoodsAttributeModel;
use data\model\NsGoodsBrandModel;
use data\model\NsGoodsBrowseModel;
use data\model\NsGoodsCategoryModel as NsGoodsCategoryModel;
use data\model\NsGoodsDeletedModel;
use data\model\NsGoodsDeletedViewModel;
use data\model\NsGoodsEvaluateModel;
use data\model\NsGoodsGroupModel as NsGoodsGroupModel;
use data\model\NsGoodsLadderPreferentialModel;
use data\model\NsGoodsMemberDiscountModel;
use data\model\NsGoodsModel as NsGoodsModel;
use data\model\NsGoodsSkuDeletedModel;
use data\model\NsGoodsSkuModel as NsGoodsSkuModel;
use data\model\NsGoodsSkuPictureDeleteModel;
use data\model\NsGoodsSkuPictureModel;
use data\model\NsGoodsSpecModel as NsGoodsSpecModel;
use data\model\NsGoodsSpecValueModel as NsGoodsSpecValueModel;
use data\model\NsGoodsViewModel as NsGoodsViewModel;
use data\model\NsMemberLevelModel;
use data\model\NsMemberModel;
use data\model\NsOrderGoodsModel;
use data\model\NsOrderModel;
use data\model\NsPromotionDiscountModel;
use data\model\NsShopModel;
use data\service\BaseService as BaseService;
use data\service\promotion\GoodsDiscount;
use data\service\promotion\GoodsExpress;
use data\service\promotion\GoodsMansong;
use data\service\promotion\GoodsPreference;
use data\service\promotion\PromoteRewardRule;
use think\Cache;
use think\Db;
use think\Log;

class Goods extends BaseService
{
	
	private $goods;
	
	function __construct()
	{
		parent::__construct();
		$this->goods = new NsGoodsModel();
	}
	
	/**
	 * 获取指定条件下商品列表
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 */
	public function getGoodsList($page_index = 1, $page_size = 0, $condition = '', $order = 'ng.sort asc,ng.create_time desc', $group_id = 0)
	{
		$goods_view = new NsGoodsViewModel();
		// 针对商品分类
		if (!empty($condition['ng.category_id'])) {
			$goods_category = new GoodsCategory();
			$category_list = $goods_category->getCategoryTreeList($condition['ng.category_id']);
			unset($condition['ng.category_id']);
			$query_goods_ids = "";
			$goods_list = $goods_view->getGoodsViewQueryField($condition, "ng.goods_id");
			if (!empty($goods_list) && count($goods_list) > 0) {
				foreach ($goods_list as $goods_obj) {
					if ($query_goods_ids === "") {
						$query_goods_ids = $goods_obj["goods_id"];
					} else {
						$query_goods_ids = $query_goods_ids . "," . $goods_obj["goods_id"];
					}
				}
				$extend_query = "";
				$category_str = explode(",", $category_list);
				foreach ($category_str as $category_id) {
					if ($extend_query === "") {
						$extend_query = " FIND_IN_SET( " . $category_id . ",ng.extend_category_id) ";
					} else {
						$extend_query = $extend_query . " or FIND_IN_SET( " . $category_id . ",ng.extend_category_id) ";
					}
				}
				$condition = " ng.goods_id in (" . $query_goods_ids . ") and ( ng.category_id in (" . $category_list . ") or " . $extend_query . ")";
			}
		}
		$goods_view = new NsGoodsViewModel();
		$list = $goods_view->getGoodsViewList($page_index, $page_size, $condition, $order);
		if (!empty($list['data'])) {
			// 用户针对商品的收藏
			foreach ($list['data'] as $k => $v) {
				if (!empty($this->uid)) {
					$member = new Member();
					$list['data'][ $k ]['is_favorite'] = $member->getIsMemberFavorites($this->uid, $v['goods_id'], 'goods');
				} else {
					$list['data'][ $k ]['is_favorite'] = 0;
				}
				// 查询商品单品活动信息
				$goods_preference = new GoodsPreference();
				$goods_promotion_info = $goods_preference->getGoodsPromote($v['goods_id']);
				$list["data"][ $k ]['promotion_info'] = $goods_promotion_info;
				
				if ($v['point_exchange_type'] == 0 || $v['point_exchange_type'] == 2) {
					$list['data'][ $k ]['display_price'] = '￥' . $v["promotion_price"];
				} else {
					if ($v['point_exchange_type'] == 1 && $v["promotion_price"] > 0) {
						$list['data'][ $k ]['display_price'] = '￥' . $v["promotion_price"] . '+' . $v["point_exchange"] . '积分';
					} else {
						$list['data'][ $k ]['display_price'] = $v["point_exchange"] . '积分';
					}
				}
				
				// 查询商品标签
				$ns_goods_group = new NsGoodsGroupModel();
				$group_name = "";
				// $group_id = 0;
				if (!empty($v['group_id_array'])) {
					$group_id_array = explode(",", $v['group_id_array']);
					
					if (empty($group_id) || !in_array($group_id, $group_id_array)) {
						$group_id = $group_id_array[0];
					}
					
					$group_info = $ns_goods_group->getInfo([
						"group_id" => $group_id
					], "group_name");
					
					if (!empty($group_info)) {
						$group_name = $group_info['group_name'];
					}
				}
				$list["data"][ $k ]['group_name'] = $group_name;
			}
		}
		return $list;
		
		// TODO Auto-generated method stub
	}
	
	/**
	 * 直接查询商品列表
	 *
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 */
	public function getGoodsViewList($page_index = 1, $page_size = 0, $condition = '', $order = 'ng.sort asc')
	{
		$goods_view = new NsGoodsViewModel();
		$list = $goods_view->getGoodsViewList($page_index, $page_size, $condition, $order);
		return $list;
	}
	
	/**
	 * 排行数据查询
	 *
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 * @return multitype:\data\model\unknown
	 */
	public function getGoodsRankViewList($page_index = 1, $page_size = 0, $condition = '', $order = 'ng.sort asc')
	{
		$goods_model = new NsGoodsModel();
		// 针对商品分类
		$viewObj = $goods_model->alias("ng")
			->join('sys_album_picture ng_sap', 'ng_sap.pic_id = ng.picture', 'left')
			->field("ng.goods_id,ng.goods_name,ng_sap.pic_cover_mid,ng.promotion_price,ng.market_price,ng.goods_type,ng.stock,ng_sap.pic_id,ng.max_buy,ng.state,ng.is_hot,ng.is_recommend,ng.is_new,ng.sales,ng_sap.pic_cover_small");
		$queryList = $goods_model->viewPageQuery($viewObj, $page_index, $page_size, $condition, $order);
		$queryCount = $this->getGoodsQueryCount($condition);
		$list = $goods_model->setReturnList($queryList, $queryCount, $page_size);
		return $list;
	}
	
	/**
	 * 获取某种条件下商品数量
	 * @param unknown $condition
	 */
	public function getGoodsCount($condition)
	{
		$count = $this->goods->where($condition)->count();
		return $count;
		
		// TODO Auto-generated method stub
	}
	
	/**
	 * 二维码路径进库
	 *
	 * @param unknown $goodsId
	 * @param unknown $url
	 */
	function goods_QRcode_make($goodsId, $url)
	{
		$data = array(
			'QRcode' => $url
		);
		$result = $this->goods->save($data, [
			'goods_id' => $goodsId
		]);
		if ($result > 0) {
			return SUCCESS;
		} else {
			return UPDATA_FAIL;
		}
	}
	
	/**
	 * 添加修改商品
	 * @param unknown $data
	 */
	public function addOrEditGoods($data)
	{
		
		$goods_id = $data['goods_id'];
		$sku_array = $data['skuArray'];
		if (!is_numeric($data['goods_type'])) {
			$goods_config = hook('getGoodsConfig', [ 'type' => $data['goods_type'] ]);
			$goods_type = arrayFilter($goods_config)[0]['id'];
		} else {
			$goods_type = $data['goods_type'];
		}
		
		//取分类
		$category_list = $this->getGoodsCategoryId($data['category_id']);
		
		$goods_data = array(
			
			'goods_type' => $goods_type,
			'goods_name' => $data['goods_name'],
			'shop_id' => $this->instance_id,
			'keywords' => $data['keywords'],
			'introduction' => $data['introduction'],
			'description' => $data['description'],
			'code' => $data['code'],
			'state' => $data['state'],
			"goods_unit" => $data['goods_unit'],
			
			'category_id' => $data['category_id'],
			'category_id_1' => $category_list[0],
			'category_id_2' => $category_list[1],
			'category_id_3' => $category_list[2],
			
			'supplier_id' => $data['supplier_id'],    //供应商
			'brand_id' => $data['brand_id'],       //品牌
			'group_id_array' => $data['group_id_array'], //分组
			
			//价钱
			'market_price' => $data['market_price'],
			'price' => $data['price'],
			'promotion_price' => $data['price'],
			'cost_price' => $data['cost_price'],
			
			//积分
			'point_exchange_type' => $data['point_exchange_type'],
			'point_exchange' => $data['point_exchange'],
			'give_point' => $data['give_point'],
			'max_use_point' => $data['max_use_point'],
			'integral_give_type' => $data['integral_give_type'], //积分赠送类型 0固定值 1按比率
			
			//会员折扣
			'is_member_discount' => $data['is_member_discount'],
			
			//物流
			'shipping_fee' => $data['shipping_fee'],
			'shipping_fee_id' => $data['shipping_fee_id'],
			'goods_weight' => $data['goods_weight'],
			'goods_volume' => $data['goods_volume'],
			'shipping_fee_type' => $data['shipping_fee_type'],
			
			//库存
			'stock' => $data['stock'],
			'min_stock_alarm' => $data['min_stock_alarm'],  //库存预警
			'is_stock_visible' => $data['is_stock_visible'], //显示库存
			
			//限购
			'max_buy' => $data['max_buy'],
			'min_buy' => $data['min_buy'],
			
			//基础量
			'clicks' => $data['clicks'],
			'sales' => $data['sales'],
			'shares' => $data['shares'],
			
			//地址
			'province_id' => $data['province_id'],
			'city_id' => $data['city_id'],
			
			//图片
			'picture' => $data['picture'],
			'img_id_array' => $data['img_id_array'],
			'sku_img_array' => $data['sku_img_array'],
			'QRcode' => $data['QRcode'],
			'goods_video_address' => $data['goods_video_address'],
			
			//属性规格
			'goods_attribute_id' => $data['goods_attribute_id'],
			'goods_spec_format' => $data['goods_spec_format'],
			
			//日期
			'production_date' => strtotime($data['production_date']),
			'shelf_life' => $data['shelf_life'], //保质期
			
			//模板
			'pc_custom_template' => $data['pc_custom_template'],
			'wap_custom_template' => $data['wap_custom_template'],
			
			//预售
			'is_open_presell' => $data['is_open_presell'],
			'presell_time' => getTimeTurnTimeStamp($data['presell_time']),
			'presell_day' => $data['presell_day'],
			'presell_delivery_type' => $data['presell_delivery_type'],
			'presell_price' => $data['presell_price'],
		);
		
		$this->goods->startTrans();
		$error = 0;
		try {
			// 检查当前添加的规格集合中，是否有新增的规格、规格值
			$goods_spec_format = json_decode($data['goods_spec_format'], true);
			$spec_id_arr = array();
			$spec_value_id_arr = array();
			foreach ($goods_spec_format as $k => $v) {
				
				if ($v['spec_id'] < 0) {
					
					// 记录之前spec_id的值，后续用于替换
					$temp_spec_id = $goods_spec_format[ $k ]['spec_id'];
					$goods_spec_format[ $k ]['spec_id'] = $this->addGoodsSpecService($this->instance_id, $v['spec_name'], $v['value'][0]['spec_show_type'], 1, 0, '', 0, 1, "", $goods_id);
				}
				
				// 由于需要替换操作，需要先处理规格值，从里到外
				foreach ($v['value'] as $k_value => $v_value) {
					
					// 规格已经添到库中，但是规格值还没有进库，需要添加
					if ($goods_spec_format[ $k ]['value'][ $k_value ]['spec_value_id'] < 0) {
						$goods_spec_format[ $k ]['value'][ $k_value ]['spec_id'] = $goods_spec_format[ $k ]['spec_id'];
						
						// 记录之前spec_value_id的值，后续用于替换
						$temp_spec_value_id = $goods_spec_format[ $k ]['value'][ $k_value ]['spec_value_id'];
						
						// 添加规格值
						$goods_spec_format[ $k ]['value'][ $k_value ]['spec_value_id'] = $this->addGoodsSpecValueService($goods_spec_format[ $k ]['value'][ $k_value ]['spec_id'], $v_value['spec_value_name'], $v_value['spec_value_data'], 1, '');
						
						array_push($spec_value_id_arr, $goods_spec_format[ $k ]['value'][ $k_value ]['spec_value_id']);
						
						// 替换规格值id
						$sku_array = str_replace($temp_spec_value_id, $goods_spec_format[ $k ]['value'][ $k_value ]['spec_value_id'], $sku_array);
					}
				}
				
				if ($v['spec_id'] < 0) {
					
					// 记录新增的规格id，后续用于绑定当前商品
					array_push($spec_id_arr, $goods_spec_format[ $k ]['spec_id']);
					
					// 替换规格id
					$sku_array = str_replace($temp_spec_id, $goods_spec_format[ $k ]['spec_id'], $sku_array);
				}
			}
			$goods_spec_format = json_encode($goods_spec_format, JSON_UNESCAPED_UNICODE);
			$goods_data['goods_spec_format'] = $goods_spec_format;
			$_SESSION['goods_spec_format'] = $goods_spec_format;
			
			if (empty($goods_id)) {
				
				$goods_data['create_time'] = time();
				$goods_data['sale_date'] = time();
				
				$res = $this->goods->save($goods_data);
				$goods_id = $this->goods->goods_id;
				
				//添加商品记录
				$this->addUserLog($this->uid, 1, '商品', '添加商品', '添加商品:' . $goods_data['goods_name']);
				
				if (!empty($sku_array)) {
					
					$sku_list_array = explode('§', $sku_array);
					foreach ($sku_list_array as $k => $v) {
						$res = $this->addOrUpdateGoodsSkuItem($this->goods->goods_id, $v);
						if (!$res) {
							$error = 1;
						}
					}
					
					// sku图片添加
					if (!empty($data['sku_picture_values'])) {
						$sku_picture_array = json_decode($data['sku_picture_values'], true);
						foreach ($sku_picture_array as $k => $v) {
							$res = $this->addGoodsSkuPicture($this->instance_id, $goods_id, $v["spec_id"], $v["spec_value_id"], $v["img_ids"]);
							if (!$res) {
								$error = 1;
							}
						}
					}
				} else {
					
					$goods_sku = new NsGoodsSkuModel();
					// 添加一条skuitem
					$sku_data = array(
						'goods_id' => $goods_id,
						'sku_name' => '',
						'market_price' => $data['market_price'],
						'price' => $data['price'],
						'promote_price' => $data['price'],
						'cost_price' => $data['cost_price'],
						'stock' => $data['stock'],
						'picture' => 0,
						'code' => $data['code'],
						'QRcode' => '',
						'create_date' => time(),
						'volume' => $data['goods_volume'],
						'weight' => $data['goods_weight'],
					);
					$res = $goods_sku->save($sku_data);
					if (!$res) {
						$error = 1;
					}
				}
			} else {
				
				$data_goods['update_time'] = time();
				$res = $this->goods->save($goods_data, [
					'goods_id' => $goods_id
				]);
				$this->addUserLog($this->uid, 1, '商品', '修改商品', '修改商品:' . $data['goods_name']);
				
				if (!empty($sku_array)) {
					
					$sku_list_array = explode('§', $sku_array);
					
					// 删除商品规格、以及与当前商品关联的规格、规格值
					$this->deleteSkuItemAndGoodsSpec($goods_id, $sku_list_array);
					
					foreach ($sku_list_array as $k => $v) {
						$res = $this->addOrUpdateGoodsSkuItem($goods_id, $v);
						if (!$res) {
							$error = 1;
						}
					}
					// 修改时先删除原来的规格图片
					$this->deleteGoodsSkuPicture([
						"goods_id" => $goods_id
					]);
					
					// sku图片添加
					$sku_picture_array = array();
					if (!empty($data['sku_picture_values'])) {
						$sku_picture_array = json_decode($data['sku_picture_values'], true);
						foreach ($sku_picture_array as $k => $v) {
							$res = $this->addGoodsSkuPicture($this->instance_id, $goods_id, $v["spec_id"], $v["spec_value_id"], $v["img_ids"]);
							if (!$res) {
								$error = 1;
							}
						}
					}
				} else {
					
					$sku_data = array(
						'goods_id' => $goods_id,
						'sku_name' => '',
						'market_price' => $data['market_price'],
						'price' => $data['price'],
						'promote_price' => $data['price'],
						'cost_price' => $data['cost_price'],
						'stock' => $data['stock'],
						'picture' => 0,
						'code' => $data['code'],
						'QRcode' => '',
						'update_date' => time(),
						'volume' => $data['goods_volume'],
						'weight' => $data['goods_weight'],
					);
					$goods_sku = new NsGoodsSkuModel();
					$retval = $goods_sku->destroy([ 'goods_id' => $goods_id ]);
					$retval = $goods_sku->save($sku_data);
				}
				$this->modifyGoodsPromotionPrice($goods_id);
			}
			
			// 将新增的规格与当前商品进行关联
			if (count($spec_id_arr) > 0) {
				$spec_id_arr = implode(",", $spec_id_arr);
				$ns_goods_spec_model = new NsGoodsSpecModel();
				$ns_goods_spec_model->save([ 'goods_id' => $goods_id ], [ 'spec_id' => [ "in", $spec_id_arr ] ]);
			}
			
			//规格值
			if (count($spec_value_id_arr) > 0) {
				$spec_value_id_arr = implode(",", $spec_value_id_arr);
				$ns_goods_spec_value_model = new NsGoodsSpecValueModel();
				$ns_goods_spec_value_model->save([ 'goods_id' => $goods_id ], [ 'spec_value_id' => [ "in", $spec_value_id_arr ] ]);
			}
			
			// 每次都要重新更新商品属性
			$goods_attribute_model = new NsGoodsAttributeModel();
			$goods_attribute_model->destroy([ 'goods_id' => $goods_id ]);
			if (!empty($data['goods_attribute'])) {
				$goods_attribute_array = json_decode($data['goods_attribute'], true);
				if (!empty($goods_attribute_array[0]['attr_value_id'])) {
					foreach ($goods_attribute_array as $k => $v) {
						$goods_attribute_model = new NsGoodsAttributeModel();
						$attribute_data = array(
							'goods_id' => $goods_id,
							'shop_id' => $this->instance_id,
							'attr_value_id' => $v['attr_value_id'],
							'attr_value' => $v['attr_value'],
							'attr_value_name' => $v['attr_value_name'],
							'sort' => $v['sort'],
							'create_time' => time()
						);
						$goods_attribute_model->save($attribute_data);
					}
				}
			}
			
			// 阶梯优惠信息
			$ladder_preference_arr = explode(",", $data['ladder_preference']);
			// 先清除原有的优惠
			$nsGoodsLadderPreferential = new NsGoodsLadderPreferentialModel();
			$nsGoodsLadderPreferential->destroy([ 'goods_id' => $goods_id ]);
			
			if (!empty($ladder_preference_arr[0])) {
				foreach ($ladder_preference_arr as $v) {
					$ladder_preference_info = explode(":", $v);
					$ladder_data = array(
						"goods_id" => $goods_id,
						"quantity" => $ladder_preference_info[0],
						"price" => $ladder_preference_info[1]
					);
					$nsGoodsLadderPreferential = new NsGoodsLadderPreferentialModel();
					$nsGoodsLadderPreferential->save($ladder_data);
				}
			}
			unset($_SESSION['goods_spec_format']);
			
			//设置会员折扣
			$this->setMemberDiscount($goods_id, $data['member_discount_arr'], $data['decimal_reservation_number']);
			
			//编辑商品成功
			if (empty($data['goods_id'])) {
				hook("addGoodsSuccess", $data);
			} else {
				hook("editGoodsSuccess", $data);
			}
			
			if ($error == 0) {
				
				//编辑商品后清除商品详情缓存
				Cache::tag("niu_goods")->set("getBasisGoodsDetail" . $goods_id, "");
				Cache::tag("niu_goods")->set("getBusinessGoodsInfo_" . $goods_id . '_' . $this->uid, "");
				
				$this->goods->commit();
				return $goods_id;
			} else {
				$this->goods->rollback();
				return 0;
			}
		} catch (\Exception $e) {
			$this->goods->rollback();
			Log::write('编辑商品出错--' . $e->getMessage());
			return $e->getMessage();
		}
	}
	
	/**
	 * 修改 商品的 促销价格
	 *
	 * @param unknown $goods_id
	 */
	protected function modifyGoodsPromotionPrice($goods_id)
	{
		$discount_goods = new GoodsDiscount();
		$goods = new NsGoodsModel();
		$goods_sku = new NsGoodsSkuModel();
		$discount = $discount_goods->getDiscountByGoodsid($goods_id);
		if ($discount == -1) {
			// 当前商品没有参加活动
		} else {
			// 当前商品有正在进行的活动
			// 查询出商品的价格进行修改
			$goods_price = $goods->getInfo([
				'goods_id' => $goods_id
			], 'price');
			$goods->save([
				'promotion_price' => $goods_price['price'] * $discount / 10
			], [
				'goods_id' => $goods_id
			]);
			// 查询出所有的商品sku价格进行修改
			$goods_sku_list = $goods_sku->getQuery([
				'goods_id' => $goods_id
			], 'sku_id, price', '');
			foreach ($goods_sku_list as $k => $v) {
				$goods_sku = new NsGoodsSkuModel();
				$goods_sku->save([
					'promote_price' => $v['price'] * $discount / 10
				], [
					'sku_id' => $v['sku_id']
				]);
			}
		}
	}
	
	/**
	 * 获取单个商品的sku属性
	 */
	public function getGoodsAttribute($goods_id)
	{
		// 查询商品主表
		$goods = new NsGoodsModel();
		$goods_detail = $goods->get($goods_id);
		$spec_list = array();
		if (!empty($goods_detail) && !empty($goods_detail['goods_spec_format']) && $goods_detail['goods_spec_format'] != "[]") {
			$spec_list = json_decode($goods_detail['goods_spec_format'], true);
			if (!empty($spec_list)) {
				foreach ($spec_list as $k => $v) {
					foreach ($v["value"] as $m => $t) {
						if (empty($t["spec_show_type"])) {
							$spec_list[ $k ]["value"][ $m ]["spec_show_type"] = 1;
						}
						
						$spec_list[ $k ]["value"][ $m ]["picture"] = $this->getGoodsSkuPictureBySpecId($goods_id, $spec_list[ $k ]["value"][ $m ]['spec_id'], $spec_list[ $k ]["value"][ $m ]['spec_value_id']);
					}
				}
			}
		}
		return $spec_list;
	}
	
	/**
	 * 获取商品的sku信息
	 *
	 * @param unknown $goods_id
	 */
	public function getGoodsSku($goods_id)
	{
		$goods_sku = new NsGoodsSkuModel();
		$list = $goods_sku->getQuery([ 'goods_id' => $goods_id ]);
		return $list;
		// TODO Auto-generated method stub
	}
	
	/**
	 * 更新商品的sku数据
	 *
	 * @param unknown $goods_id
	 * @param unknown $sku_list
	 */
	public function ModifyGoodsSku($goods_id, $sku_list)
	{
		// TODO Auto-generated method stub
	}
	
	/**
	 * 获取商品的图片信息
	 *
	 * @param unknown $goods_id
	 */
	public function getGoodsImg($goods_id)
	{
		// TODO Auto-generated method stub
		$goods_info = $this->goods->getInfo([
			'goods_id' => $goods_id
		], 'picture');
		$pic_info = array();
		if (!empty($goods_info)) {
			$picture = new AlbumPictureModel();
			$pic_info['pic_cover'] = '';
			if (!empty($goods_info['picture'])) {
				$pic_info = $picture->get($goods_info['picture']);
			}
		}
		return $pic_info;
	}
	
	/**
	 * 商品下架
	 *
	 * @param unknown $condition
	 */
	public function ModifyGoodsOffline($condition)
	{
		Cache::clear("niu_goods_group");
		Cache::clear("niu_goods_category_block");
		Cache::clear("niu_goods");
		$data = array(
			"state" => 0,
			'update_time' => time()
		);
		$result = $this->goods->save($data, "goods_id  in($condition)");
		if ($result > 0) {
			// 商品下架成功钩子
			hook("goodsOfflineSuccess", [
				'goods_id' => $condition
			]);
			return SUCCESS;
		} else {
			return UPDATA_FAIL;
		}
	}
	
	/**
	 * 商品上架
	 *
	 * @param unknown $condition
	 */
	public function ModifyGoodsOnline($condition)
	{
		Cache::clear("niu_goods_group");
		Cache::clear("niu_goods_category_block");
		Cache::clear("niu_goods");
		$data = array(
			"state" => 1,
			'update_time' => time()
		);
		$result = $this->goods->save($data, "goods_id  in($condition)");
		if ($result > 0) {
			// 商品上架成功钩子
			hook("goodsOnlineSuccess", [
				'goods_id' => $condition
			]);
			return SUCCESS;
		} else {
			return UPDATA_FAIL;
		}
	}
	
	/**
	 * 删除商品
	 *
	 * @param unknown $goods_id
	 */
	public function deleteGoods($goods_id)
	{
		Cache::clear("niu_goods_group");
		Cache::clear("niu_goods_category_block");
		Cache::clear("niu_goods");
		$this->goods->startTrans();
		try {
			// 商品删除之前钩子
			hook("goodsDeleteBefore", [
				'goods_id' => $goods_id
			]);
			// 将商品信息添加到商品回收库中
			$this->addGoodsDeleted($goods_id);
			$condition = array(
				'shop_id' => $this->instance_id,
				'goods_id' => $goods_id
			);
			$res = $this->goods->destroy($goods_id);
			
			if ($res > 0) {
				$goods_id_array = explode(',', $goods_id);
				$goods_sku_model = new NsGoodsSkuModel();
				$goods_attribute_model = new NsGoodsAttributeModel();
				$goods_sku_picture = new NsGoodsSkuPictureModel();
				foreach ($goods_id_array as $k => $v) {
					// 删除商品sku
					$goods_sku_model->destroy([
						'goods_id' => $v
					]);
					// 删除商品属性
					$goods_attribute_model->destroy([
						'goods_id' => $v
					]);
					// 删除规格图片
					$goods_sku_picture->destroy([
						'goods_id' => $v
					]);
				}
			}
			$this->goods->commit();
			if ($res > 0) {
				// 商品删除成功钩子
				hook("goodsDeleteSuccess", [
					'goods_id' => $goods_id
				]);
				return SUCCESS;
			} else {
				return DELETE_FAIL;
			}
		} catch (\Exception $e) {
			$this->goods->rollback();
			return DELETE_FAIL;
		}
	}
	
	/**
	 * 商品删除以前 将商品挪到 回收站中
	 *
	 * @param unknown $goods_ids
	 */
	private function addGoodsDeleted($goods_ids)
	{
		$this->goods->startTrans();
		try {
			$goods_id_array = explode(',', $goods_ids);
			foreach ($goods_id_array as $k => $v) {
				// 得到商品的信息 备份商品
				$goods_info = $this->goods->get($v);
				$goods_delete_model = new NsGoodsDeletedModel();
				$goods_info = json_decode(json_encode($goods_info), true);
				$goods_delete_obj = $goods_delete_model->getInfo([
					"goods_id" => $v
				]);
				if (empty($goods_delete_obj)) {
					$goods_info["update_time"] = time();
					$goods_delete_model->save($goods_info);
					// 商品的sku 信息备份
					$goods_sku_model = new NsGoodsSkuModel();
					$goods_sku_list = $goods_sku_model->getQuery([
						"goods_id" => $v
					], "*", "");
					foreach ($goods_sku_list as $goods_sku_obj) {
						$goods_sku_deleted_model = new NsGoodsSkuDeletedModel();
						$goods_sku_obj = json_decode(json_encode($goods_sku_obj), true);
						$goods_sku_obj["update_date"] = time();
						$goods_sku_deleted_model->save($goods_sku_obj);
					}
					// 商品的属性 信息备份
					$goods_attribute_model = new NsGoodsAttributeModel();
					$goods_attribute_list = $goods_attribute_model->getQuery([
						'goods_id' => $v
					], "*", "");
					foreach ($goods_attribute_list as $goods_attribute_obj) {
						$goods_attribute_delete_model = new NsGoodsAttributeDeletedModel();
						$goods_attribute_obj = json_decode(json_encode($goods_attribute_obj), true);
						$goods_attribute_delete_model->save($goods_attribute_obj);
					}
					// 商品的sku图片备份
					$goods_sku_picture = new NsGoodsSkuPictureModel();
					$goods_sku_picture_list = $goods_sku_picture->getQuery([
						'goods_id' => $v
					], "*", "");
					foreach ($goods_sku_picture_list as $goods_sku_picture_list_obj) {
						$goods_sku_picture_delete = new NsGoodsSkuPictureDeleteModel();
						$goods_sku_picture_list_obj = json_decode(json_encode($goods_sku_picture_list_obj), true);
						$goods_sku_picture_delete->save($goods_sku_picture_list_obj);
					}
				}
			}
			$this->goods->commit();
			return 1;
		} catch (\Exception $e) {
			Log::write('wwwwwwwwwwww' . $e->getMessage());
			$this->goods->rollback();
			return $e->getMessage();
		}
	}
	
	/**
	 * 删除商品的图片信息
	 *
	 * @param unknown $goods_id
	 */
	public function deleteGoodImages($goods_id)
	{
		// TODO Auto-generated method stub
	}
	
	/**
	 * 查询商品的基础信息
	 * 每次访问商品详情时，点击量都会发生变化，如果缓存了，则看不到点击量的变化。其他字段也可能会出现问题
	 *
	 * @param array $param
	 */
	public function getBasisGoodsDetail($param = [])
	{
		$cache = Cache::tag("niu_goods")->get("getBasisGoodsDetail" . $param['goods_id']);
		
		if (empty($cache)) {
			// 商品的基础信息
			$goods = new NsGoodsModel();
			$goods_detail = $goods->get($param['goods_id']);
			if ($goods_detail == null) {
				return null;
			}
			
			$goods_detail['bargain_id'] = $param['bargain_id'];
			$goods_detail['group_id'] = $param['group_id'];
			
			// 查询商品sku
			$goods_sku = new NsGoodsSkuModel();
			$goods_sku_detail = $goods_sku->where([
				'goods_id' => $param['goods_id'],
//			'stock' => [ '>', 0 ]
			])->select();
			
			//默认数据，选择第一个
			$goods_detail['sku_id'] = $goods_sku_detail[0]['sku_id'];
			$goods_detail['price'] = $goods_sku_detail[0]['price'];
			$goods_detail['promotion_price'] = $goods_sku_detail[0]['promote_price'];
			$goods_detail['stock'] = $goods_sku_detail[0]['stock'];
			$goods_detail['sku_name'] = $goods_sku_detail[0]['sku_name'];
			$goods_detail['sku_picture'] = 0;//当前sku主图id
			
			$spec_list = json_decode($goods_detail['goods_spec_format'], true);
			if (!empty($spec_list)) {
				// 排序字段
//			$sort = array(
//				'field' => 'sort'
//			);
//			$arrSort = array();
				$album = new Album();
				foreach ($spec_list as $k => $v) {
					$spec_list[ $k ]['sort'] = 0;
					
					foreach ($v["value"] as $m => $t) {
						if (empty($t["spec_show_type"])) {
							$spec_list[ $k ]["value"][ $m ]["spec_show_type"] = 1;
						}
						
						//默认选中第一个规格
						$spec_list[ $k ]["value"][ $m ]["selected"] = ($m == 0) ? true : false;
						
						//匹配规格是否允许点击
						foreach ($goods_sku_detail as $d => $dv) {
							$value = $spec_list[ $k ]["value"][ $m ]['spec_id'] . ":" . $spec_list[ $k ]["value"][ $m ]['spec_value_id'];
							$match = strstr($dv['attr_value_items'], $value);
							if ($match) {
								$spec_list[ $k ]["value"][ $m ]['disabled'] = $dv['stock'] == 0 ? true : false;
							}
						}
						
						// 规格图片
						// 判断规格数组中图片路径是id还是路径
						if ($t["spec_show_type"] == 3) {
							if (is_numeric($t["spec_value_data"])) {
								$picture_detail = $album->getAlubmPictureDetail([
									"pic_id" => $t["spec_value_data"]
								]);
								if (!empty($picture_detail)) {
									$spec_list[ $k ]["value"][ $m ]["picture_id"] = $picture_detail['pic_id'];
									$spec_list[ $k ]["value"][ $m ]["spec_value_data"] = $picture_detail["pic_cover_micro"];
									$spec_list[ $k ]["value"][ $m ]["spec_value_data_big_src"] = $picture_detail["pic_cover_big"];
								} else {
									$spec_list[ $k ]["value"][ $m ]["spec_value_data"] = '';
									$spec_list[ $k ]["value"][ $m ]["spec_value_data_big_src"] = '';
									$spec_list[ $k ]["value"][ $m ]["picture_id"] = 0;
								}
							} else {
								$spec_list[ $k ]["value"][ $m ]["spec_value_data_big_src"] = $t["spec_value_data"];
								$spec_list[ $k ]["value"][ $m ]["picture_id"] = 0;
							}
						}
					}
				}
				
				// 排序字段
//			foreach ($spec_list as $uniqid => $row) {
//				foreach ($row as $key => $value) {
//					$arrSort[ $key ][ $uniqid ] = $value;
//				}
//			}
//          array_multisort($arrSort[$sort['field']], SORT_ASC, $spec_list);
			}
			$goods_detail['spec_list'] = $spec_list;
			
			
			// sku多图数据
//			$sku_picture_list = $this->getGoodsSkuPicture($param['goods_id']);
			
			//查询规格图片
			$picture_model = new AlbumPictureModel();
			foreach ($goods_sku_detail as $k => $v) {
				if (!empty($v['sku_img_array'])) {
					$goods_sku_detail[ $k ]['sku_img_list'] = $picture_model->getQuery([ "pic_id" => [ "in", $v['sku_img_array'] ] ]);
					if (!empty($goods_sku_detail[ $k ]['sku_img_list']) && count($goods_sku_detail[ $k ]['sku_img_list']) == 1) {
						$goods_sku_detail[ $k ]['sku_img_main'] = $goods_sku_detail[ $k ]['sku_img_list'][0];
						if ($v['sku_id'] == $goods_detail['sku_id'] && $goods_detail['sku_picture'] == 0 && !empty($goods_sku_detail[ $k ]['sku_img_main'])) {
							$goods_detail['sku_picture'] = $goods_sku_detail[ $k ]['sku_img_list'][0];
						}
					} else {
						$goods_sku_detail[ $k ]['sku_img_main'] = $picture_model->getInfo([ "pic_id" => $v['picture'] ]);
						if ($v['sku_id'] == $goods_detail['sku_id'] && $goods_detail['sku_picture'] == 0 && !empty($goods_sku_detail[ $k ]['sku_img_main'])) {
							$goods_detail['sku_picture'] = $v['picture'];
						}
					}
				}
			}
			
			$goods_detail['sku_list'] = $goods_sku_detail;
			
			if (!empty($goods_detail['img_id_array'])) {
				// 查询图片表
				$goods_img_list = Db::query("select * from sys_album_picture where pic_id in(" . $goods_detail['img_id_array'] . ") order by instr('," . $goods_detail['img_id_array'] . ",',CONCAT(',',pic_id,',')) ");
				$goods_detail['goods_img_list'] = $goods_img_list;
			}
			
			// 查询分类名称
			$goods_category = new GoodsCategory();
			if (!empty($goods_detail["category_id"])) {
				$category_name = $goods_category->getCategoryParentQuery($goods_detail["category_id"]);
				$goods_detail['parent_category_name'] = $category_name;
			}
			
			// 查询商品类型相关信息
			if ($goods_detail['goods_attribute_id'] != 0) {
				$attribute_model = new NsAttributeModel();
				$attribute_info = $attribute_model->getInfo([
					'attr_id' => $goods_detail['goods_attribute_id']
				], 'attr_name');
				$goods_detail['goods_attribute_name'] = $attribute_info['attr_name'];
				$goods_attribute_model = new NsGoodsAttributeModel();
				$goods_attribute_list = $goods_attribute_model->getQuery([
					'goods_id' => $param['goods_id']
				], 'attr_id, goods_id, shop_id, attr_value_id, attr_value, attr_value_name, sort', 'sort');
				$goods_detail['goods_attribute_list'] = $goods_attribute_list;
			} else {
				$goods_detail['goods_attribute_name'] = '';
				$goods_detail['goods_attribute_list'] = array();
			}
			
			$goods_attribute_list = $goods_detail['goods_attribute_list'];
			$goods_attribute_list_new = array();
			foreach ($goods_attribute_list as $item) {
				$attr_value_name = '';
				foreach ($goods_attribute_list as $key => $item_v) {
					if ($item_v['attr_value_id'] == $item['attr_value_id']) {
						$attr_value_name .= $item_v['attr_value_name'] . ',';
						unset($goods_attribute_list[ $key ]);
					}
				}
				if (!empty($attr_value_name)) {
					array_push($goods_attribute_list_new, array(
						'attr_value_id' => $item['attr_value_id'],
						'attr_value' => $item['attr_value'],
						'attr_value_name' => rtrim($attr_value_name, ',')
					));
				}
			}
			
			$goods_detail['goods_attribute_list'] = $goods_attribute_list_new;
			
			if ($goods_detail['match_ratio'] == 0) {
				$goods_detail['match_ratio'] = 100;
			}
			if ($goods_detail['match_point'] == 0) {
				$goods_detail['match_point'] = 5;
			}
			// 处理小数
			$goods_detail['match_ratio'] = round($goods_detail['match_ratio'], 2);
			$goods_detail['match_point'] = round($goods_detail['match_point'], 2);
			
			Cache::tag("niu_goods")->set("getBasisGoodsDetail" . $param['goods_id'], $goods_detail);
		} else {
			$goods_detail = $cache;
		}
		
		return $this->getBusinessGoodsInfo($goods_detail, $param);
	}
	
	//去重复，保留一个
	private function array_unique($array)
	{
		$out = array();
		foreach ($array as $key => $value) {
			if (!in_array($value, $out)) {
				$out[ $key ] = $value;
			}
		}
		return $out; //最后返回数组out
	}
	
	/**
	 * 得到当前时间戳的毫秒数
	 *
	 * @return number
	 */
	private function getCurrentTime()
	{
		$time = time();
		$time = $time * 1000;
		return $time;
	}
	
	/**
	 * 查询商品的业务数据
	 * @param $goods_detail 商品基础信息
	 * @param $param    存放sku_id、活动id，不进行缓存
	 * @return mixed
	 */
	public function getBusinessGoodsInfo($goods_detail, $param)
	{
		$cache = Cache::tag("niu_goods")->get("getBusinessGoodsInfo_" . $goods_detail['goods_id'] . '_' . $this->uid);
		if (empty($cache)) {
			/**
			 * *******************************************会员价格-start****************************************************
			 */
			//会员折扣部分查询
			// 查询会员等级
			$goods_member_discount = 100;
			$member_decimal_reservation_number = 2;
			if (!empty($this->uid)) {
				$ns_goods_member_discount = new NsGoodsMemberDiscountModel();
				
				$member = new NsMemberModel();
				$member_info = $member->getInfo([
					'uid' => $this->uid
				], 'member_level');
				
				$member_goods_discount = $ns_goods_member_discount->getInfo([ 'goods_id' => $goods_detail['goods_id'], 'level_id' => $member_info['member_level'] ], 'discount,decimal_reservation_number');
				
				//商品会员等级折扣
				if (!empty($member_goods_discount)) {
					$goods_member_discount = $member_goods_discount['discount'];
					$member_decimal_reservation_number = $member_goods_discount['decimal_reservation_number'];
				} else {
					$member_level_model = new NsMemberLevelModel();
					$member_level_discount = $member_level_model->getInfo([ 'level_id' => $member_info['member_level'] ], 'goods_discount');
					if (!empty($member_level_discount['goods_discount'])) $goods_member_discount = $member_level_discount['goods_discount'] * 100;
				}
			}
			// 查询商品会员价
			if ($goods_member_discount == 100) {
				$goods_detail['is_show_member_price'] = 0;
				$goods_detail['member_price'] = $goods_detail['price'];
				// 商品sku价格
				foreach ($goods_detail['sku_list'] as $k => $v) {
					$goods_detail['sku_list'][ $k ]['member_price'] = $goods_detail['price'];
				}
			} else {
				$goods_detail['is_show_member_price'] = 1;
				$goods_detail['member_price'] = round($goods_member_discount * $goods_detail['price'] / 100, $member_decimal_reservation_number);
				foreach ($goods_detail['sku_list'] as $k => $goods_sku) {
					$goods_detail['sku_list'][ $k ]['member_price'] = round($goods_member_discount * $goods_sku['price'] / 100, $member_decimal_reservation_number);
				}
			}
			if ($goods_detail['integral_give_type'] == 1 && $goods_detail['give_point'] > 0) {
				$price = $goods_detail['member_price'] > $goods_detail['promotion_price'] ? $goods_detail['member_price'] : $goods_detail['promotion_price'];
				$goods_detail['give_point'] = round($price * $goods_detail['give_point'] * 0.01);
			}
			
			$integral_flag = 0; // 是否是积分商品
			
			// 1 积分加现金购买 2 积分兑换或直接购买 3 只支持积分兑换
			if ($goods_detail["point_exchange_type"] == 1 || $goods_detail["point_exchange_type"] == 2 || $goods_detail["point_exchange_type"] == 3) {
				$integral_flag++;
			}
			$goods_detail['integral_flag'] = $integral_flag;
			
			// 积分抵现比率
			$integral_balance = 0; // 积分可抵金额
			$promotion = new Promotion();
			$point_config = $promotion->getPointConfig();
			if ($point_config["is_open"] == 1) {
				if ($goods_detail['max_use_point'] > 0 && $point_config['convert_rate'] > 0) {
					$integral_balance = $goods_detail['max_use_point'] * $point_config['convert_rate'];
				}
			}
			
			$goods_detail['integral_balance'] = $integral_balance;
			
			// 获取当前时间
			$goods_detail['current_time'] = $this->getCurrentTime();
			
			//阶梯优惠
			$goods_ladder_preferential_list = $this->getGoodsLadderPreferential([ 'goods_id' => $goods_detail["goods_id"] ], "quantity desc", "quantity,price");
			$goods_ladder_preferential_list = array_reverse($goods_ladder_preferential_list);
			$goods_detail['goods_ladder_preferential_list'] = $goods_ladder_preferential_list;
			
			//优惠券
			$goods_detail['goods_coupon_list'] = $this->getGoodsCoupon($goods_detail['goods_id'], $this->uid);
			
			/**
			 * *******************************************会员价格-end*********************************************************
			 */
			
			//营销活动详情
			$promotion_detail = [];
			
			$promotion = new Promotion();
			$goods_promotion = $promotion->getGoodsPromotion([ 'goods_id' => $goods_detail["goods_id"] ]);
			if (!empty($goods_promotion)) {
				foreach ($goods_promotion as $k => $v) {
					if ($v['promotion_addon'] == "DISCOUNT") {
						//限时折扣
						$goods_discount_info = new NsPromotionDiscountModel();
						$discount_detail = $goods_discount_info->getInfo([
							'discount_id' => $v['promotion_id']
						], 'start_time, end_time,discount_name');
						if (!empty($discount_detail)) {
							$promotion_detail['discount_detail'] = $discount_detail;
						}
					} elseif ($v['promotion_addon'] == "MANJIAN") {
						//满减送
						// 查询商品满减送活动
						$goods_mansong = new GoodsMansong();
						$goods_detail['mansong_name'] = $goods_mansong->getGoodsMansongName($goods_detail["goods_id"]);
						
					} else {
						//NsBargain 砍价，NsPintuan 拼团，NsGroupBuy 团购，
						
						//插件内的营销活动详情，包括：组合套餐、拼团、砍价
						$promotion_detail_addon = hook("getPromotionDetail", [ 'promotion_type' => $v['promotion_addon'], 'goods_id' => $goods_detail["goods_id"], 'bargain_id' => $param['bargain_id'], 'group_id' => $param['group_id'] ]);
						$promotion_detail_addon = array_filter($promotion_detail_addon);
						if (!empty($promotion_detail_addon)) {
							foreach ($promotion_detail_addon as $k => $v) {
								if ($v['promotion_type'] == "NsCombopackage") {
									$promotion_detail['combo_package'] = $v;
								} elseif ($v['promotion_type'] == "NsPintuan") {
									$promotion_detail['pintuan'] = $v;
								} elseif ($v['promotion_type'] == "NsBargain") {
									$promotion_detail['bargain'] = $v;
								} elseif ($v['promotion_type'] == "NsGroupBuy") {
									$promotion_detail['group_buy'] = $v;
									//团购活动要更新最大最小购买量
									$goods_detail['min_buy'] = $v['data']['min_num'];
									$goods_detail['max_buy'] = $v['data']['max_num'];
								}
							}
						}
						
					}
				}
			}
			
			$goods_detail['goods_promotion'] = $goods_promotion;
			$goods_detail['promotion_detail'] = $promotion_detail;
			
			//限购
			$purchase_restriction_num = $goods_detail['min_buy'] > 0 ? $goods_detail['min_buy'] : 1;
			$goods_purchase_restriction = $this->getGoodsPurchaseRestrictionForCurrentUser($goods_detail["goods_id"], $purchase_restriction_num);
			$goods_detail['goods_purchase_restriction'] = $goods_purchase_restriction;
			
			// 查询包邮活动
			$full = new Promotion();
			$baoyou_info = $full->getPromotionFullMail($this->instance_id);
			if ($baoyou_info['is_open'] == 1) {
				if ($baoyou_info['full_mail_money'] == 0) {
					$goods_detail['baoyou_name'] = '全场包邮';
				} else {
					$goods_detail['baoyou_name'] = '满' . $baoyou_info['full_mail_money'] . '元包邮';
				}
			} else {
				$goods_detail['baoyou_name'] = '';
			}
			$goods_express = new GoodsExpress();
			$goods_detail['shipping_fee_name'] = $goods_express->getGoodsExpressTemplate($goods_detail["goods_id"], 1, 1, 1);
			if (is_string($goods_detail['shipping_fee_name'])) {
				$shipping_fee_name_arr = array();
				array_push($shipping_fee_name_arr, array(
					'co_id' => 0,
					'company_name' => $goods_detail['shipping_fee_name'],
					'is_default' => 0,
					'express_fee' => 0
				));
				$goods_detail['shipping_fee_name'] = $shipping_fee_name_arr;
			}
			
			// 查询商品的已购数量
			if (!empty($this->uid)) {
				$orderGoods = new NsOrderGoodsModel();
				$num = $orderGoods->getSum([
					"goods_id" => $goods_detail["goods_id"],
					"buyer_id" => $this->uid,
					"order_status" => array(
						"neq",
						5
					)
				], "num");
				$goods_detail["purchase_num"] = $num;
			} else {
				$goods_detail["purchase_num"] = 0;
			}
			Cache::tag("niu_goods")->set("getBusinessGoodsInfo_" . $goods_detail['goods_id'] . '_' . $this->uid, $goods_detail, 60);
		} else {
			$goods_detail = $cache;
		}
		
		
		// *********************************这里要动态查询变化频率高的数据*********************************
		
		$goods = new NsGoodsModel();
		$goods_info = $goods->getInfo([ 'goods_id' => $param['goods_id'] ], "collects,sales");
		$goods_detail['collects'] = $goods_info['collects'];//
		$goods_detail['sales'] = $goods_info['sales'];
		
		$curr_sku_index = 0;//当前选中的规格下标
		$spec_list = $goods_detail['spec_list'];
		if (!empty($param['sku_id'])) {
			foreach ($spec_list as $k => $v) {
				
				foreach ($v["value"] as $m => $t) {
					
					foreach ($goods_detail['sku_list'] as $a => $b) {
						//找到当前选中的sku信息
						if ($b['sku_id'] == $param['sku_id']) {
							$curr_sku_index = $a;
							$value = $spec_list[ $k ]["value"][ $m ]['spec_id'] . ":" . $spec_list[ $k ]["value"][ $m ]['spec_value_id'];
							$spec_list[ $k ]["value"][ $m ]['selected'] = (strstr($b['attr_value_items'], $value) && $b['stock'] > 0) ? true : false;
							$goods_detail['price'] = $b['price'];
							$goods_detail['sku_id'] = $param['sku_id'];
							$goods_detail['promotion_price'] = $b['promote_price'];
							$goods_detail['stock'] = $b['stock'];
							$goods_detail['sku_name'] = $b['sku_name'];
						}
					}
				}
			}
		}
		
		$goods_detail['spec_list'] = $spec_list;
		
		//检测当前选中的规格是否存在图片集合
		if (isset($goods_detail['sku_list'][ $curr_sku_index ]['sku_img_list'])) {
			//将model对象转换为数组格式，然后合并商品主图集合
			$current_sku_img_list = json_encode($goods_detail['sku_list'][ $curr_sku_index ]['sku_img_list']);
			$deal_sku_img_list = json_decode($current_sku_img_list, true);
			if (!empty($goods_detail['goods_img_list'])) {
				$goods_detail['img_list'] = $this->array_unique(array_merge($deal_sku_img_list, $goods_detail['goods_img_list']));
			} else {
				
				$goods_detail['img_list'] = $deal_sku_img_list;
			}
		} else {
			if (!empty($goods_detail['goods_img_list'])) {
				$goods_detail['img_list'] = $goods_detail['goods_img_list'];
			}
		}
		return $goods_detail;
	}
	
	/**
	 * 获取单条商品的详细信息
	 *
	 * @param int $goods_id
	 */
	public function getGoodsDetail($goods_id)
	{
		// 查询商品主表
		$goods = new NsGoodsModel();
		$goods_detail = $goods->get($goods_id);
		if ($goods_detail == null) {
			return null;
		}
		$goods_preference = new GoodsPreference();
		if (!empty($this->uid)) {
			$member_discount = $goods_preference->getMemberLevelDiscount($this->uid);
		} else {
			$member_discount = 1;
		}
		
		// 查询商品会员价
		if ($member_discount == 1) {
			$goods_detail['is_show_member_price'] = 0;
		} else {
			$goods_detail['is_show_member_price'] = 1;
		}
		$member_price = $member_discount * $goods_detail['price'];
		$goods_detail['member_price'] = $member_price;
		
		// sku多图数据
		$sku_picture_list = $this->getGoodsSkuPicture($goods_id);
		$goods_detail["sku_picture_list"] = $sku_picture_list;
		$goods_all_picture = array();
		foreach ($sku_picture_list as $picture_obj) {
			$spec_value_id = $picture_obj["spec_value_id"];
			$goods_all_picture[ $spec_value_id ] = $picture_obj;
		}
		
		// 查询商品分组表
		$goods_group = new NsGoodsGroupModel();
		$goods_group_list = $goods_group->all($goods_detail['group_id_array']);
		$goods_detail['goods_group_list'] = $goods_group_list;
		
		// 查询商品sku表
		$goods_sku = new NsGoodsSkuModel();
		$goods_sku_detail = $goods_sku->where('goods_id=' . $goods_id)->select();
		
		foreach ($goods_sku_detail as $k => $goods_sku) {
			$goods_sku_detail[ $k ]['member_price'] = $goods_sku['price'] * $member_discount;
			
			$picture_model = new AlbumPictureModel();
			$sku_img_ids = $goods_sku['sku_img_array'];
			if (!empty($sku_img_ids)) {
				$picture_list = $picture_model->getQuery("pic_id in ($sku_img_ids)", "*", "");
			} else {
				$picture_list = [];
			}
			$goods_sku_detail[ $k ]['picture_list'] = $picture_list;
		}
		
		$goods_detail['sku_list'] = $goods_sku_detail;
		
		//默认数据，选择第一个
		$goods_detail['sku_id'] = $goods_sku_detail[0]['sku_id'];
		$goods_detail['price'] = $goods_sku_detail[0]['price'];
		$goods_detail['promotion_price'] = $goods_sku_detail[0]['promote_price'];
// 		$goods_detail['stock'] = $goods_sku_detail[0]['stock'];
		$goods_detail['sku_name'] = $goods_sku_detail[0]['sku_name'];
		
		$spec_list = json_decode($goods_detail['goods_spec_format'], true);
		
		if (!empty($spec_list)) {
			foreach ($spec_list as $k => $v) {
				
				$spec_list[ $k ]['sort'] = 0;
				
				foreach ($v["value"] as $m => $t) {
					if (empty($t["spec_show_type"])) {
						$spec_list[ $k ]["value"][ $m ]["spec_show_type"] = 1;
					}
					
					//默认选中第一个规格
					$spec_list[ $k ]["value"][ $m ]["selected"] = ($m == 0) ? true : false;
					
					//匹配规格是否允许点击
					foreach ($goods_sku_detail as $d => $dv) {
						$value = $spec_list[ $k ]["value"][ $m ]['spec_id'] . ":" . $spec_list[ $k ]["value"][ $m ]['spec_value_id'];
						$match = strstr($dv['attr_value_items'], $value);
						if ($match) {
							$spec_list[ $k ]["value"][ $m ]['disabled'] = $dv['stock'] == 0 ? true : false;
						}
					}
					
					$picture = 0;
					$sku_img_array = $goods_all_picture[ $spec_list[ $k ]["value"][ $m ]['spec_value_id'] ];
					if (!empty($sku_img_array)) {
						$array = explode(",", $sku_img_array['sku_img_array']);
						$picture = $array[0];
					}
					// 查询SKU规格主图，没有返回0
					$spec_list[ $k ]["value"][ $m ]["picture"] = $picture;
					// $this->getGoodsSkuPictureBySpecId($goods_id, $spec_list[$k]["value"][$m]['spec_id'], $spec_list[$k]["value"][$m]['spec_value_id']);
				}
			}
		}
		$goods_detail['spec_list'] = $spec_list;
		// 查询图片表
		$goods_img = new AlbumPictureModel();
		
		if (!empty($goods_detail['img_id_array'])) {
			$goods_img_list = Db::query("select * from sys_album_picture where pic_id in(" . $goods_detail['img_id_array'] . ") order by instr('," . $goods_detail['img_id_array'] . ",',CONCAT(',',pic_id,',')) ");
			$img_temp_array = array();
			$img_array = explode(",", $goods_detail['img_id_array']);
			foreach ($img_array as $k => $v) {
				if (!empty($goods_img_list)) {
					foreach ($goods_img_list as $t => $m) {
						if ($m["pic_id"] == $v) {
							$img_temp_array[] = $m;
						}
					}
				}
			}
		}
		
		$goods_picture = $goods_img->get($goods_detail['picture']);
		$goods_detail["img_temp_array"] = $img_temp_array;
		$goods_detail['img_list'] = $goods_img_list;
		$goods_detail['picture_detail'] = $goods_picture;
		// 查询分类名称
		$category_name = $this->getGoodsCategoryName($goods_detail['category_id_1'], $goods_detail['category_id_2'], $goods_detail['category_id_3']);
		$goods_detail['category_name'] = $category_name;
		// 扩展分类
		$extend_category_array = array();
		if (!empty($goods_detail['extend_category_id'])) {
			$extend_category_ids = $goods_detail['extend_category_id'];
			$extend_category_id_1s = $goods_detail['extend_category_id_1'];
			$extend_category_id_2s = $goods_detail['extend_category_id_2'];
			$extend_category_id_3s = $goods_detail['extend_category_id_3'];
			$extend_category_id_str = explode(",", $extend_category_ids);
			$extend_category_id_1s_str = explode(",", $extend_category_id_1s);
			$extend_category_id_2s_str = explode(",", $extend_category_id_2s);
			$extend_category_id_3s_str = explode(",", $extend_category_id_3s);
			foreach ($extend_category_id_str as $k => $v) {
				$extend_category_name = $this->getGoodsCategoryName($extend_category_id_1s_str[ $k ], $extend_category_id_2s_str[ $k ], $extend_category_id_3s_str[ $k ]);
				$extend_category_array[] = array(
					"extend_category_name" => $extend_category_name,
					"extend_category_id" => $v,
					"extend_category_id_1" => $extend_category_id_1s_str[ $k ],
					"extend_category_id_2" => $extend_category_id_2s_str[ $k ],
					"extend_category_id_3" => $extend_category_id_3s_str[ $k ]
				);
			}
		}
		$goods_detail['extend_category_name'] = "";
		$goods_detail['extend_category'] = $extend_category_array;
		
		// 查询商品类型相关信息
		if ($goods_detail['goods_attribute_id'] != 0) {
			$attribute_model = new NsAttributeModel();
			$attribute_info = $attribute_model->getInfo([
				'attr_id' => $goods_detail['goods_attribute_id']
			], 'attr_name');
			$goods_detail['goods_attribute_name'] = $attribute_info['attr_name'];
			$goods_attribute_model = new NsGoodsAttributeModel();
			$goods_attribute_list = $goods_attribute_model->getQuery([
				'goods_id' => $goods_id
			], '*', 'sort');
			
			$goods_detail['goods_attribute_list'] = $goods_attribute_list;
		} else {
			$goods_detail['goods_attribute_name'] = '';
			$goods_detail['goods_attribute_list'] = array();
		}
		// 查询商品单品活动信息
		$goods_preference = new GoodsPreference();
		$goods_promotion_info = $goods_preference->getGoodsPromote($goods_id);
		if (!empty($goods_promotion_info)) {
			$goods_discount_info = new NsPromotionDiscountModel();
			$goods_detail['promotion_detail'] = $goods_discount_info->getInfo([
				'discount_id' => $goods_detail['promote_id']
			], 'start_time, end_time,discount_name');
		}
		// 判断活动内容是否为空
		if (!empty($goods_detail['promotion_detail'])) {
			$goods_detail['promotion_info'] = $goods_promotion_info;
		} else {
			$goods_detail['promotion_info'] = "";
		}
		// 查询商品满减送活动
		$goods_mansong = new GoodsMansong();
		$goods_detail['mansong_name'] = $goods_mansong->getGoodsMansongName($goods_id);
		// 查询包邮活动
		$full = new Promotion();
		$baoyou_info = $full->getPromotionFullMail($this->instance_id);
		if ($baoyou_info['is_open'] == 1) {
			if ($baoyou_info['full_mail_money'] == 0) {
				$goods_detail['baoyou_name'] = '全场包邮';
			} else {
				$goods_detail['baoyou_name'] = '满' . $baoyou_info['full_mail_money'] . '元包邮';
			}
		} else {
			$goods_detail['baoyou_name'] = '';
		}
		$goods_express = new GoodsExpress();
		$goods_detail['shipping_fee_name'] = $goods_express->getGoodsExpressTemplate($goods_id, 1, 1, 1);
		
		$shop_model = new NsShopModel();
		$shop_name = $shop_model->getInfo(array(
			"shop_id" => $goods_detail["shop_id"]
		), "shop_name");
		$goods_detail["shop_name"] = $shop_name["shop_name"];
		// 查询商品规格图片
		$goos_sku_picture = new NsGoodsSkuPictureModel();
		$goos_sku_picture_query = $goos_sku_picture->getQuery([
			"goods_id" => $goods_id
		], "*", '');
		$album_picture = new AlbumPictureModel();
		foreach ($goos_sku_picture_query as $k => $v) {
			if ($v["sku_img_array"] != "") {
				$spec_name = '';
				$spec_value_name = '';
				foreach ($spec_list as $t => $m) {
					if ($m["spec_id"] == $v["spec_id"]) {
						foreach ($m["value"] as $c => $b) {
							if ($b["spec_value_id"] == $v["spec_value_id"]) {
								$spec_name = $b["spec_name"];
								$spec_value_name = $b["spec_value_name"];
							}
						}
					}
				}
				$goos_sku_picture_query[ $k ]["spec_name"] = $spec_name;
				$goos_sku_picture_query[ $k ]["spec_value_name"] = $spec_value_name;
				$tmp_img_array = $album_picture->getQuery([
					"pic_id" => [
						"in",
						$v["sku_img_array"]
					]
				], "*", '');
				$pic_id_array = explode(',', (string) $v["sku_img_array"]);
				$goos_sku_picture_query[ $k ]["sku_picture_query"] = array();
				$sku_picture_query_array = array();
				foreach ($pic_id_array as $t => $m) {
					foreach ($tmp_img_array as $q => $z) {
						if ($m == $z["pic_id"]) {
							$sku_picture_query_array[] = $z;
						}
					}
				}
				$goos_sku_picture_query[ $k ]["sku_picture_query"] = $sku_picture_query_array;
				// $goos_sku_picture_query[$k]["sku_picture_query"] = $album_picture->getQuery(["pic_id"=>["in",$v["sku_img_array"]]], "*", '');
			} else {
				unset($goos_sku_picture_query[ $k ]);
			}
		}
		sort($goos_sku_picture_query);
		$goods_detail["sku_picture_array"] = $goos_sku_picture_query;
		// 查询商品的已购数量
		$orderGoods = new NsOrderGoodsModel();
		$num = $orderGoods->getSum([
			"goods_id" => $goods_id,
			"buyer_id" => $this->uid,
			"order_status" => array(
				"neq",
				5
			)
		], "num");
		$goods_detail["purchase_num"] = $num;
		
		return $goods_detail;
	}
	
	/**
	 * 查询sku多图数据
	 */
	public function getGoodsSkuPicture($goods_id)
	{
		$goods_sku = new NsGoodsSkuPictureModel();
		$sku_picture_list = $goods_sku->getQuery([
			"goods_id" => $goods_id
		], "*", "");
		$total_sku_img_array = array();
		foreach ($sku_picture_list as $k => $v) {
			$sku_img_ids = $v["sku_img_array"];
			$sku_img_array = explode(",", $sku_img_ids);
			if (!empty($total_sku_img_array)) {
				$total_sku_img_array = array_keys(array_flip($total_sku_img_array) + array_flip($sku_img_array));
			} else {
				$total_sku_img_array = $sku_img_array;
			}
		}
		$total_sku_img_ids = implode(",", $total_sku_img_array);
		$picture_model = new AlbumPictureModel();
		if (!empty($total_sku_img_ids)) {
			$picture_list = $picture_model->getQuery("pic_id in ($total_sku_img_ids)", "*", "");
		} else {
			$picture_list = '';
		}
		
		foreach ($sku_picture_list as $k => $v) {
			$sku_img_ids = $v["sku_img_array"];
			$sku_img_array = explode(",", $sku_img_ids);
			$album_picture_list = array();
			foreach ($picture_list as $picture_obj) {
				$curr_pic_id = $picture_obj["pic_id"];
				if (in_array($curr_pic_id, $sku_img_array)) {
					$album_picture_list[] = $picture_obj;
				}
			}
			$sku_picture_list[ $k ]["album_picture_list"] = $album_picture_list;
		}
		return $sku_picture_list;
	}
	
	/**
	 * 根据商品id、规格id、规格值id查询
	 * @param unknown $goods_id
	 * @param unknown $spec_id
	 * @param unknown $spec_value_id
	 */
	public function getGoodsSkuPictureBySpecId($goods_id, $spec_id, $spec_value_id)
	{
		$picture = 0;
		
		$goods_sku = new NsGoodsSkuPictureModel();
		$sku_img_array = $goods_sku->getInfo([
			"goods_id" => $goods_id,
			"spec_id" => $spec_id,
			"spec_value_id" => $spec_value_id,
			"shop_id" => $this->instance_id
		], "sku_img_array");
		if (!empty($sku_img_array)) {
			$array = explode(",", $sku_img_array['sku_img_array']);
			$picture = $array[0];
		}
		return $picture;
	}
	
	/**
	 * 商品规格列表
	 *
	 * @param unknown $condition
	 * @param unknown $field
	 */
	public function getGoodsAttributeList($condition, $field, $order)
	{
		$spec = new NsGoodsSpecModel();
		$list = $spec->getQuery($condition, $field, $order);
		return $list;
	}
	
	/**
	 * 商品规格值列表
	 *
	 * @param unknown $condition
	 * @param unknown $field
	 */
	public function getGoodsAttributeValueList($condition, $field)
	{
		$attribute = new NsGoodsSpecValueModel();
		$list = $attribute->getQuery($condition, $field, '');
		return $list;
	}
	
	/**
	 * 添加商品规格
	 *
	 * @param unknown $spec_name
	 * @param unknown $sort
	 * @param unknown $is_visible
	 */
	public function addGoodsSpec($spec_name, $sort = 0)
	{
		$attribute = new NsGoodsSpecModel();
		$data = array(
			'shop_id' => $this->instance_id,
			'spec_name' => $spec_name,
			'sort' => 0,
			'create_time' => time()
		);
		$find_id = $attribute->get([
			'spec_name' => $spec_name
		]);
		if (!empty($find_id)) {
			return $find_id['spec_id'];
		} else {
			$res = $attribute->save($data);
			return $attribute->spec_id;
		}
	}
	
	/**
	 * 添加商品规格值
	 *
	 * @param unknown $spec_id
	 * @param unknown $spec_value
	 * @param unknown $sort
	 */
	public function addGoodsSpecValue($spec_id, $spec_value, $sort = 0)
	{
		$spec_value_model = new NsGoodsSpecValueModel();
		$data = array(
			'spec_id' => $spec_id,
			'spec_value_name' => $spec_value,
			'sort' => $sort,
			'create_time' => time()
		);
		$find_id = $spec_value_model->get([
			'spec_value_name' => $spec_value,
			'spec_id' => $spec_id
		]);
		if (!empty($find_id)) {
			return $find_id['spec_value_id'];
		} else {
			$res = $spec_value_model->save($data);
			return $spec_value_model->spec_value_id;
		}
		
		// TODO Auto-generated method stub
	}
	
	/**
	 * 添加商品sku列表
	 *
	 * @param unknown $goods_id
	 * @param unknown $sku_item_array
	 * @return Ambigous <number, \think\false, boolean, string>
	 */
	private function addOrUpdateGoodsSkuItem($goods_id, $sku_item_array)
	{
		$sku_item = explode('¦', $sku_item_array);
		$goods_sku = new NsGoodsSkuModel();
		$sku_name = $this->createSkuName($sku_item[0]);
		
		$condition = array(
			'goods_id' => $goods_id,
			'attr_value_items' => $sku_item[0]
		);
		$sku_count = $goods_sku->where($condition)->find();
		
		$picture = 0;
		if (!empty($sku_item[8])) {
			
			$sku_img_array = explode(',', $sku_item[8]);
			$picture = $sku_img_array[0];
		}
		
		if (empty($sku_count)) {
			$data = array(
				'goods_id' => $goods_id,
				'sku_name' => $sku_name,
				'attr_value_items' => $sku_item[0],
				'attr_value_items_format' => $sku_item[0],
				'price' => $sku_item[1],
				'promote_price' => $sku_item[1],
				'market_price' => $sku_item[2],
				'cost_price' => $sku_item[3],
				'stock' => $sku_item[4],
				'picture' => $picture,
				'sku_img_array' => $sku_item[8],
				'code' => $sku_item[5],
				'QRcode' => '',
				'create_date' => time(),
				'volume' => $sku_item[6],
				'weight' => $sku_item[7],
			);
			$goods_sku->save($data);
			return $goods_sku->sku_id;
		} else {
			$data = array(
				'goods_id' => $goods_id,
				'sku_name' => $sku_name,
				'price' => $sku_item[1],
				'promote_price' => $sku_item[1],
				'market_price' => $sku_item[2],
				'cost_price' => $sku_item[3],
				'stock' => $sku_item[4],
				'code' => $sku_item[5],
				'QRcode' => '',
				'update_date' => time(),
				'volume' => $sku_item[6],
				'weight' => $sku_item[7],
				'picture' => $picture,
				'sku_img_array' => $sku_item[8],
			);
			$res = $goods_sku->save($data, [
				'sku_id' => $sku_count['sku_id']
			]);
			return $res;
		}
	}
	
	/**
	 * 批量修改sku信息
	 * @param unknown $goods_id
	 * @param unknown $goods_sku_arr
	 */
	public function updateGoodsSkuBatch($goods_sku_arr, $goods_id)
	{
		
		$goods_model = new NsGoodsModel();
		$goods_model->startTrans();
		try {
			
			$goods_price = 0;
			$goods_stock = 0;
			$market_price = 0;
			//sku修改
			foreach ($goods_sku_arr as $item) {
				
				$goods_sku = new NsGoodsSkuModel();
				$data = array(
					'price' => $item['price'],
					'promote_price' => $item['price'],
					'market_price' => $item['market_price'],
					'cost_price' => $item['cost_price'],
					'stock' => $item['stock'],
					'code' => $item['code'],
					'update_date' => time()
				);
				$res = $goods_sku->save($data, [ 'sku_id' => $item['sku_id'] ]);
				
				if ($goods_price == 0 || $goods_price > $item['price']) {
					$goods_price = $item['price'];
				}
				if ($market_price == 0 || $market_price > $item['market_price']) {
					$market_price = $item['market_price'];
				}
				$goods_stock += $item['stock'];
			}
			
			//商品表修改
			$goods_data = array(
				'price' => $goods_price,
				'promotion_price' => $goods_price,
				'market_price' => $market_price,
				'stock' => $goods_stock
			);
			$goods_model->save($goods_data, [ 'goods_id' => $goods_id ]);
			
			//编辑商品后清除商品详情缓存
			Cache::tag("niu_goods")->set("getBasisGoodsDetail" . $goods_id, "");
			Cache::tag("niu_goods")->set("getBusinessGoodsInfo_" . $goods_id . '_' . $this->uid, "");
			$goods_model->commit();
			return 1;
		} catch (\Exception $e) {
			
			$goods_model->rollback();
			return $e->getMessage();
		}
	}
	
	/**
	 * 删除当前商品的SKU项，以及关联的规格、规格值
	 * @param unknown $goods_id
	 * @param unknown $sku_list_array
	 */
	private function deleteSkuItemAndGoodsSpec($goods_id, $sku_list_array)
	{
		$sku_item_list_array = array();
		foreach ($sku_list_array as $k => $sku_item_array) {
			$sku_item = explode('¦', $sku_item_array);
			$sku_item_list_array[] = $sku_item[0];
		}
		$goods_spec = new NsGoodsSpecModel();
		$goods_spec_value = new NsGoodsSpecValueModel();
		
		// 当前商品的规格数组
		$spec_id_arr = array();
		
		// 当前商品的规格值数组
		$spec_value_id_arr = array();
		
		foreach ($sku_item_list_array as $k => $v) {
			$one = explode(";", $v);
			foreach ($one as $one_k => $one_v) {
				$curr_arr = explode(":", $one_v);
				$spec_id = $curr_arr[0];
				$spec_value_id = $curr_arr[1];
				array_push($spec_id_arr, $spec_id);
				array_push($spec_value_id_arr, $spec_value_id);
			}
		}
		$spec_id_arr = array_unique($spec_id_arr);
		$spec_id_arr = array_values($spec_id_arr);
		
		$spec_value_id_arr = array_unique($spec_value_id_arr);
		$spec_value_id_arr = array_values($spec_value_id_arr);
		
		// 要删除的规格id数组
		$del_spec_id_arr = array();
		
		// 要删除的规格值id数组
		$del_spec_value_id_arr = array();
		
		// 查询当前商品关联的规格列表
		$goods_spec_id_array = $goods_spec->getQuery([
			'goods_id' => $goods_id
		], "spec_id", "");
		
		if (!empty($goods_spec_id_array)) {
			foreach ($goods_spec_id_array as $k => $v) {
				
				// 如果不存在则加入到规格删除队列数组中...
				if (!in_array($v['spec_id'], $spec_id_arr)) {
					array_push($del_spec_id_arr, $v['spec_id']);
				}
				
				// 查询当前规格的所有规格值列表
				$goods_spec_value_id_array = $goods_spec_value->getQuery([
					'spec_id' => $v['spec_id']
				], "spec_value_id", "");
				
				if (!empty($goods_spec_value_id_array)) {
					
					foreach ($goods_spec_value_id_array as $k_value => $v_value) {
						
						// 如果不存在则加入到规格值删除队列数组中...
						if (!in_array($v_value['spec_value_id'], $spec_value_id_arr)) {
							array_push($del_spec_value_id_arr, $v_value['spec_value_id']);
						}
					}
				}
			}
		}
		
		// echo "要删除的规格：";//测试代码，建议保留.....
		// print_r(json_encode($del_spec_id_arr));
		
		// echo "要删除的规格值：";//测试代码，建议保留.....
		// print_r(json_encode($del_spec_value_id_arr));
		
		// 删除当前商品没有用到的规格值集合
		if (count($del_spec_value_id_arr) > 0) {
			$del_spec_value_id_arr = implode($del_spec_value_id_arr, ",");
			$res = $goods_spec_value->destroy([
				'spec_value_id' => [
					'in',
					$del_spec_value_id_arr
				]
			]);
		}
		
		// 删除当前商品没有用到的规格集合
		if (count($del_spec_id_arr) > 0) {
			$del_spec_id_arr = implode($del_spec_id_arr, ",");
			$res = $goods_spec->destroy([
				'spec_id' => [
					'in',
					$del_spec_id_arr
				]
			]);
		}
		$goods_sku = new NsGoodsSkuModel();
		$list = $goods_sku->where('goods_id=' . $goods_id)->select();
		if (!empty($list)) {
			foreach ($list as $k => $v) {
				if (!in_array($v['attr_value_items'], $sku_item_list_array)) {
					$goods_sku->destroy($v['sku_id']);
				}
			}
		}
	}
	
	/**
	 * 组装sku name
	 *
	 * @param unknown $pvs
	 * @return string
	 */
	private function createSkuName($pvs)
	{
		$name = '';
		$pvs_array = explode(';', $pvs);
		foreach ($pvs_array as $k => $v) {
			$value = explode(':', $v);
			$prop_id = $value[0];
			$prop_value = $value[1];
			$goods_spec_value_model = new NsGoodsSpecValueModel();
			$value_name = $this->getUserSkuName($prop_value);
			$name = $name . $value_name . ' ';
		}
		return $name;
	}
	
	/**
	 * 获取用户自定义的规格值名称
	 *
	 * @param unknown $spec_id
	 */
	private function getUserSkuName($spec_id)
	{
		$sku_name = "";
		$goods_spec_format = $_SESSION['goods_spec_format'];
		if (!empty($goods_spec_format)) {
			$goods_spec_format = json_decode($goods_spec_format, true);
			foreach ($goods_spec_format as $spec_value) {
				foreach ($spec_value["value"] as $spec) {
					if ($spec_id == $spec['spec_value_id']) {
						$sku_name = $spec['spec_value_name'];
					}
				}
			}
		}
		return $sku_name;
	}
	
	/**
	 * 根据当前分类ID查询商品分类的三级分类ID
	 *
	 * @param unknown $category_id
	 */
	private function getGoodsCategoryId($category_id)
	{
		// 获取分类层级
		$goods_category = new NsGoodsCategoryModel();
		$info = $goods_category->get($category_id);
		if ($info['level'] == 1) {
			return array(
				$category_id,
				0,
				0
			);
		}
		if ($info['level'] == 2) {
			// 获取父级
			return array(
				$info['pid'],
				$category_id,
				0
			);
		}
		if ($info['level'] == 3) {
			$info_parent = $goods_category->get($info['pid']);
			// 获取父级
			return array(
				$info_parent['pid'],
				$info['pid'],
				$category_id
			);
		}
	}
	
	/**
	 * 根据当前商品分类组装分类名称
	 *
	 * @param unknown $category_id_1
	 * @param unknown $category_id_2
	 * @param unknown $category_id_3
	 */
	private function getGoodsCategoryName($category_id_1, $category_id_2, $category_id_3)
	{
		$name = '';
		$goods_category = new NsGoodsCategoryModel();
		$info_1 = $goods_category->getInfo([
			'category_id' => $category_id_1
		], 'category_name');
		$info_2 = $goods_category->getInfo([
			'category_id' => $category_id_2
		], 'category_name');
		$info_3 = $goods_category->getInfo([
			'category_id' => $category_id_3
		], 'category_name');
		if (!empty($info_1['category_name'])) {
			$name = $info_1['category_name'] . ' > ';
		}
		if (!empty($info_2['category_name'])) {
			$name = $name . '' . $info_2['category_name'] . ' > ';
		}
		if (!empty($info_3['category_name'])) {
			$name = $name . '' . $info_3['category_name'];
		}
		return $name;
	}
	
	/**
	 * 按照添加查询特定分页列表
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 * @param string $field
	 */
	public function getSearchGoodsList($page_index = 1, $page_size = 0, $condition = '', $order = '', $field = '*')
	{
		$result = $this->goods->pageQuery($page_index, $page_size, $condition, $order, $field);
		foreach ($result['data'] as $k => $v) {
			$picture = new AlbumPictureModel();
			$pic_info = array();
			$pic_info['pic_cover'] = '';
			if (!empty($v['picture'])) {
				$pic_info = $picture->get($v['picture']);
			}
			$result['data'][ $k ]['picture_info'] = $pic_info;
		}
		return $result;
	}
	
	
	/**
	 * 修改商品分组
	 *
	 * @param unknown $goods_id
	 * @param unknown $goods_type
	 */
	public function ModifyGoodsGroup($goods_id, $goods_type)
	{
		Cache::clear('niu_goods_group');
		$data = array(
			"group_id_array" => $goods_type,
			"update_time" => time()
		);
		$result = $this->goods->save($data, "goods_id  in($goods_id)");
		if ($result > 0) {
			return SUCCESS;
		} else {
			return UPDATA_FAIL;
		}
	}
	
	/**
	 * 修改商品 推荐 1=热销 2=推荐 3=新品
	 */
	public function ModifyGoodsRecommend($goods_ids, $goods_type)
	{
		$goods = new NsGoodsModel();
		$goods->startTrans();
		try {
			$goods_id_array = explode(',', $goods_ids);
			$goods_type = explode(',', $goods_type);
			$data = array(
				"is_new" => $goods_type[0],
				"is_recommend" => $goods_type[1],
				"is_hot" => $goods_type[2]
			);
			foreach ($goods_id_array as $k => $v) {
				$goods = new NsGoodsModel();
				$goods->save($data, [
					'goods_id' => $v
				]);
			}
			$goods->commit();
			return 1;
		} catch (\Exception $e) {
			$goods->rollback();
			return $e->getMessage();
		}
	}
	
	/**
	 * 获取商品可得积分
	 *
	 * @param unknown $goods_id
	 */
	public function getGoodsGivePoint($goods_id)
	{
		$goods = new NsGoodsModel();
		$point_info = $goods->getInfo([
			'goods_id' => $goods_id
		], 'give_point');
		return $point_info['give_point'];
	}
	
	/**
	 * 获取商品赠送积分
	 * @param unknown $goods_id
	 * @param unknown $sku_id
	 * @param unknown $num
	 * @return Ambigous <number, unknown>
	 */
	public function getGoodsGivePointNew($goods_id, $sku_id, $num)
	{
		$give_point = 0; // 赠送积分
		
		$goods = new NsGoodsModel();
		$goods_preference = new GoodsPreference();
		
		$goods_info = $goods->getInfo([
			'goods_id' => $goods_id
		], 'give_point,integral_give_type');
		if ($goods_info['integral_give_type'] == 0) {
			$give_point = $goods_info['give_point'];
		} else {
			if ($goods_info['give_point'] > 0) {
				$sku_price = $goods_preference->getGoodsSkuPrice($sku_id);
				$sku_price = $goods_preference->getGoodsLadderPreferentialPrice($sku_id, $num, $sku_price);
				$give_point = round($sku_price * ($goods_info['give_point'] * 0.01));
			}
		}
		return $give_point;
	}
	
	/**
	 * 通过商品skuid查询goods_id
	 *
	 * @param unknown $sku_id
	 */
	public function getGoodsId($sku_id)
	{
		$goods_sku = new NsGoodsSkuModel();
		$sku_info = $goods_sku->getInfo([
			'sku_id' => $sku_id
		], 'goods_id');
		return $sku_info['goods_id'];
	}
	
	/**
	 * 获取购物车中项目，根据cartid
	 *
	 * @param unknown $carts
	 */
	public function getCartList($carts)
	{
		$cart = new NsCartModel();
		$cart_list = $cart->getQuery([
			'buyer_id' => $this->uid
		], '*', 'cart_id');
		$cart_array = explode(',', $carts);
		$list = array();
		foreach ($cart_list as $k => $v) {
			$goods = new NsGoodsModel();
			$goods_info = $goods->getInfo([
				'goods_id' => $v['goods_id']
			], 'max_buy,state,point_exchange_type,point_exchange,max_use_point');
			// 获取商品sku信息
			$goods_sku = new NsGoodsSkuModel();
			$sku_info = $goods_sku->getInfo([
				'sku_id' => $v['sku_id']
			], 'stock');
			if (empty($sku_info)) {
				$cart->destroy([
					'buyer_id' => $this->uid,
					'sku_id' => $v['sku_id']
				]);
				continue;
			} else {
				if ($sku_info['stock'] == 0) {
					$cart->destroy([
						'buyer_id' => $this->uid,
						'sku_id' => $v['sku_id']
					]);
					continue;
				}
			}
			
			$v['stock'] = $sku_info['stock'];
			$v['max_buy'] = $goods_info['max_buy'];
			$v['point_exchange_type'] = $goods_info['point_exchange_type'];
			$v['point_exchange'] = $goods_info['point_exchange'];
			if ($goods_info['state'] != 1) {
				$this->cartDelete($v['cart_id']);
				unset($v);
			}
			$num = $v['num'];
			if ($goods_info['max_buy'] != 0 && $goods_info['max_buy'] < $v['num']) {
				$num = $goods_info['max_buy'];
			}
			
			if ($sku_info['stock'] < $num) {
				$num = $sku_info['stock'];
			}
			if ($num != $v['num']) {
				// 更新购物车
				$this->cartAdjustNum($v['cart_id'], $sku_info['stock']);
				$v['num'] = $num;
			}
			$v["max_use_point"] = $goods_info["max_use_point"] * $num;
			// 获取阶梯优惠后的价格
			$v["price"] = $this->getGoodsLadderPreferentialInfo($v["goods_id"], $v['num'], $v['price']);
			// 获取图片信息
			$picture = new AlbumPictureModel();
			$picture_info = $picture->get($v['goods_picture']);
			$v['picture_info'] = $picture_info;
			if (in_array($v['cart_id'], $cart_array)) {
				$list[] = $v;
			}
		}
		return $list;
	}
	
	/**
	 * 获取购物车
	 *
	 * @param unknown $uid
	 */
	public function getCart($uid, $shop_id = 0)
	{
		if ($uid > 0) {
			$cart = new NsCartModel();
			$cart_goods_list = null;
			if ($shop_id == 0) {
				$cart_goods_list = $cart->getQuery([
					'buyer_id' => $this->uid
				], '*', '');
			} else {
				
				$cart_goods_list = $cart->getQuery([
					'buyer_id' => $this->uid,
					'shop_id' => $shop_id
				], '*', '');
			}
		} else {
			$cart_goods_list = cookie('cart_array');
			if (empty($cart_goods_list)) {
				$cart_goods_list = null;
			} else {
				$cart_goods_list = json_decode($cart_goods_list, true);
			}
		}
		$goods_id_array = array();
		if (!empty($cart_goods_list)) {
			foreach ($cart_goods_list as $k => $v) {
				$goods = new NsGoodsModel();
				$goods_info = $goods->getInfo([
					'goods_id' => $v['goods_id']
				], 'max_buy,state,point_exchange_type,point_exchange,goods_name,price, picture, min_buy ');
				// 获取商品sku信息
				$goods_sku = new NsGoodsSkuModel();
				$sku_info = $goods_sku->getInfo([
					'sku_id' => $v['sku_id']
				], 'stock, price, sku_name, promote_price');
				// 将goods_id 存放到数组中
				$goods_id_array[] = $v["goods_id"];
				// 验证商品或sku是否存在,不存在则从购物车移除
				if ($uid > 0) {
					// var_dump($goods_info);
					if (empty($goods_info)) {
						$cart->destroy([
							'goods_id' => $v['goods_id'],
							'buyer_id' => $uid
						]);
						unset($cart_goods_list[ $k ]);
						continue;
					}
					if (empty($sku_info)) {
						unset($cart_goods_list[ $k ]);
						$cart->destroy([
							'buyer_id' => $uid,
							'sku_id' => $v['sku_id']
						]);
						continue;
					}
				} else {
					if (empty($goods_info)) {
						unset($cart_goods_list[ $k ]);
						$this->cartDelete($v['cart_id']);
						continue;
					}
					if (empty($sku_info)) {
						unset($cart_goods_list[ $k ]);
						$this->cartDelete($v['cart_id']);
						continue;
					}
				}
				// exit();
				// 为cookie信息完善商品和sku信息
				if ($uid > 0) {
					// 查看用户会员价
					$goods_preference = new GoodsPreference();
					$member_discount = 1;
					if (!empty($this->uid)) {
						$goods_member_discount = $goods_preference->getGoodsMemberDiscount($uid, $v["goods_id"]);
						if (!empty($goods_member_discount)) {
							$member_discount = $goods_member_discount;
						} else {
							$member_discount = $goods_preference->getMemberLevelDiscount($uid);
						}
					}
					$member_price = $member_discount * $sku_info['price'];
					$member_price = $this->handleMemberPrice($v["goods_id"], $member_price);
					if ($member_price > $sku_info["promote_price"]) {
						$price = $sku_info["promote_price"];
					} else {
						$price = $member_price;
					}
					$update_data = array(
						"goods_name" => $goods_info["goods_name"],
						"sku_name" => $sku_info["sku_name"],
						"goods_picture" => $v['goods_picture'], // $goods_info["picture"],
						"price" => $price
					);
					// 更新数据
					$cart->save($update_data, [
						"cart_id" => $v["cart_id"]
					]);
					$cart_goods_list[ $k ]["price"] = $price;
					$cart_goods_list[ $k ]["goods_name"] = $goods_info["goods_name"];
					$cart_goods_list[ $k ]["sku_name"] = $sku_info["sku_name"];
					$cart_goods_list[ $k ]["goods_picture"] = $v['goods_picture']; // $goods_info["picture"];
				} else {
					$cart_goods_list[ $k ]["price"] = $sku_info["promote_price"];
					$cart_goods_list[ $k ]["goods_name"] = $goods_info["goods_name"];
					$cart_goods_list[ $k ]["sku_name"] = $sku_info["sku_name"];
					$cart_goods_list[ $k ]["goods_picture"] = $v['goods_picture']; // $goods_info["picture"];
				}
				
				$cart_goods_list[ $k ]['stock'] = $sku_info['stock'];
				$cart_goods_list[ $k ]['max_buy'] = $goods_info['max_buy'];
				$cart_goods_list[ $k ]['min_buy'] = $goods_info['min_buy'];
				$cart_goods_list[ $k ]['point_exchange_type'] = $goods_info['point_exchange_type'];
				$cart_goods_list[ $k ]['point_exchange'] = $goods_info['point_exchange'];
				
				if ($goods_info['state'] != 1) {
					unset($cart_goods_list[ $k ]);
					// 更新cookie购物车
					$this->cartDelete($v['cart_id']);
					continue;
				}
				$num = $v['num'];
				if ($goods_info['max_buy'] != 0 && $goods_info['max_buy'] < $v['num']) {
					$num = $goods_info['max_buy'];
				}
				if ($sku_info['stock'] < $num) {
					$num = $sku_info['stock'];
				}
				// 商品最小购买数大于现购买数
				if ($goods_info['min_buy'] > 0 && $num < $goods_info['min_buy']) {
					$num = $goods_info['min_buy'];
				}
				// 商品最小购买数大于现有库存
				if ($goods_info['min_buy'] > $sku_info['stock']) {
					unset($cart_goods_list[ $k ]);
					// 更新cookie购物车
					$this->cartDelete($v['cart_id']);
					continue;
				}
				if ($num != $v['num']) {
					// 更新购物车
					$cart_goods_list[ $k ]['num'] = $num;
					$this->cartAdjustNum($v['cart_id'], $num);
				}
				
				$cart_goods_list[ $k ]["promotion_price"] = round($cart_goods_list[ $k ]["price"], 2);
				// 阶梯优惠后的价格
				$cart_goods_list[ $k ]["price"] = $this->getGoodsLadderPreferentialInfo($v['goods_id'], $num, $cart_goods_list[ $k ]["price"]);
			}
			// 为购物车图片
			foreach ($cart_goods_list as $k => $v) {
				$picture = new AlbumPictureModel();
				$picture_info = $picture->get($v['goods_picture']);
				$cart_goods_list[ $k ]['picture_info'] = $picture_info;
			}
			sort($cart_goods_list);
			// $cart_goods_list[0]["goods_id_array"] = $goods_id_array;
		}
		return $cart_goods_list;
	}
	
	/**
	 * 添加购物车
	 *
	 * @param unknown $uid
	 * @param unknown $shop_id
	 * @param unknown $shop_name
	 * @param unknown $goods_id
	 * @param unknown $goods_name
	 * @param unknown $sku_id
	 * @param unknown $sku_name
	 * @param unknown $price
	 * @param unknown $num
	 * @param unknown $picture
	 * @param unknown $bl_id
	 */
	public function addCart($uid, $shop_id, $shop_name, $goods_id, $goods_name, $sku_id, $sku_name, $price, $num, $picture, $bl_id)
	{
		$retval = array(
			'code' => 0,
			"message" => ""
		);
		// 商品限购，判断是否允许添加到购物车
		$goods_purchase_restriction = array(
			"code" => 1,
			"message" => "添加购物车成功"
		);
		if ($uid > 0) {
			$cart = new NsCartModel();
			$condition = array(
				'buyer_id' => $uid,
				'sku_id' => $sku_id
			);
			
			// 查询当前用户所购买的商品限购，是否允许添加到购物车中
			$goods_purchase_restriction = $this->getGoodsPurchaseRestrictionForCurrentUser($goods_id, $num);
			if ($goods_purchase_restriction['code'] == 0) {
				$retval = $goods_purchase_restriction;
				return $retval;
			}
			
			$count = $cart->where($condition)->count();
			if ($count == 0 || empty($count)) {
				$data = array(
					'buyer_id' => $uid,
					'shop_id' => $shop_id,
					'shop_name' => $shop_name,
					'goods_id' => $goods_id,
					'goods_name' => $goods_name,
					'sku_id' => $sku_id,
					'sku_name' => $sku_name,
					'price' => $price,
					'num' => $num,
					'goods_picture' => $picture,
					'bl_id' => $bl_id
				);
				$cart->save($data);
				$retval['code'] = $cart->cart_id;
				$retval['message'] = lang("added_cart_success");
			} else {
				$cart = new NsCartModel();
				// 查询商品限购
				$goods = new NsGoodsModel();
				$get_num = $cart->getInfo($condition, 'cart_id,num');
				$max_buy = $goods->getInfo([
					'goods_id' => $goods_id
				], 'max_buy');
				$new_num = $num + $get_num['num'];
				if ($max_buy['max_buy'] != 0) {
					
					if ($new_num > $max_buy['max_buy']) {
						$new_num = $max_buy['max_buy'];
					}
				}
				$data = array(
					'num' => $new_num
				);
				$res = $cart->save($data, $condition);
				if ($res) {
					$retval['code'] = $get_num['cart_id'];
					$retval['message'] = lang("added_cart_success");
				}
			}
		} else {
			
			// 未登录的情况下添加购物车
			$cart_array = cookie('cart_array');
			$data = array(
				'shop_id' => $shop_id,
				'goods_id' => $goods_id,
				'sku_id' => $sku_id,
				'num' => $num,
				'goods_picture' => $picture
			);
			if (!empty($cart_array)) {
				$cart_array = json_decode($cart_array, true);
				$tmp_array = array();
				foreach ($cart_array as $k => $v) {
					$tmp_array[] = $v['cart_id'];
				}
				$cart_id = max($tmp_array) + 1;
				$is_have = true;
				foreach ($cart_array as $k => $v) {
					if ($v["goods_id"] == $goods_id && $v["sku_id"] == $sku_id) {
						$is_have = false;
						$cart_array[ $k ]["num"] = $data["num"] + $v["num"];
					}
				}
				
				if ($is_have) {
					$data["cart_id"] = $cart_id;
					$cart_array[] = $data;
				}
				// 检查商品限购，是否允许添加到购物车中
				$goods_purchase_restriction = $this->getGoodsPurchaseRestrictionForCurrentUser($goods_id, $num);
			} else {
				$data["cart_id"] = 1;
				$cart_array[] = $data;
			}
			try {
				
				// 商品限购了，不允许添加
				if ($goods_purchase_restriction['code'] == 0) {
					$retval = $goods_purchase_restriction;
				} else {
					$cart_array_string = json_encode($cart_array);
					cookie('cart_array', $cart_array_string, 3600);
					$retval['code'] = 1;
					$retval['message'] = lang("added_cart_success");
				}
			} catch (\Exception $e) {
				
				$retval['code'] = 0;
				$retval['message'] = lang("failed_to_add_cart");
			}
		}
		return $retval;
	}
	
	/**
	 * 购物车修改数量
	 *
	 * @param unknown $cart_id
	 * @param unknown $num
	 */
	public function cartAdjustNum($cart_id, $num)
	{
		if ($this->uid > 0) {
			$cart = new NsCartModel();
			$data = array(
				'num' => $num
			);
			$retval = $cart->save($data, [
				'cart_id' => $cart_id
			]);
			return $retval;
		} else {
			$result = $this->updateCookieCartNum($cart_id, $num);
			return $result;
		}
	}
	
	/**
	 * 购物车项目删除
	 *
	 * @param unknown $cart_id_array
	 *            多项用，隔开
	 */
	public function cartDelete($cart_id_array)
	{
		if ($this->uid > 0) {
			$cart = new NsCartModel();
			$retval = $cart->destroy($cart_id_array);
			return $retval;
		} else {
			$result = $this->deleteCookieCart($cart_id_array);
			return $result;
		}
	}
	
	/**
	 * 获取分组商品列表
	 *
	 * @param unknown $goods_group_id
	 * @param number $num
	 */
	public function getGroupGoodsList($goods_group_id, $condition = '', $num = 0, $order = '')
	{
		$goods_list = array();
		$goods = new NsGoodsModel();
		$condition['state'] = 1;
		$list = $goods->getQuery($condition, '*', $order);
		foreach ($list as $k => $v) {
			$picture = new AlbumPictureModel();
			$picture_info = $picture->get($v['picture']);
			$v['picture_info'] = $picture_info;
			$group_id_array = explode(',', $v['group_id_array']);
			if (in_array($goods_group_id, $group_id_array) || $goods_group_id == 0) {
				$goods_list[] = $v;
			}
		}
		foreach ($goods_list as $k => $v) {
			if (!empty($this->uid)) {
				$member = new Member();
				$goods_list[ $k ]['is_favorite'] = $member->getIsMemberFavorites($this->uid, $v['goods_id'], 'goods');
			} else {
				$goods_list[ $k ]['is_favorite'] = 0;
			}
			
			$goods_sku = new NsGoodsSkuModel();
			// 获取sku列表
			$sku_list = $goods_sku->where([
				'goods_id' => $v['goods_id']
			])->select();
			$goods_list[ $k ]['sku_list'] = $sku_list;
			
			// 查询商品单品活动信息
			$goods_preference = new GoodsPreference();
			$goods_promotion_info = $goods_preference->getGoodsPromote($v['goods_id']);
			$goods_list[ $k ]['promotion_info'] = $goods_promotion_info;
		}
		if ($num == 0) {
			return $goods_list;
		} else {
			$count_list = count($goods_list);
			if ($count_list > $num) {
				return array_slice($goods_list, 0, $num);
			} else {
				return $goods_list;
			}
		}
	}
	
	/**
	 * 获取限时折扣的商品
	 *
	 * @param number $page_index
	 * @param number $page_size
	 * @param unknown $condition
	 * @param string $order
	 */
	public function getDiscountGoodsList($page_index = 1, $page_size = 0, $condition = array(), $order = '')
	{
		$goods_discount = new GoodsDiscount();
		$goods_list = $goods_discount->getDiscountGoodsList($page_index, $page_size, $condition, $order);
		return $goods_list;
	}
	
	/**
	 * 商品评价信息
	 *
	 * @param unknown $goods_id
	 */
	public function getGoodsEvaluate($goods_id)
	{
		$goodsEvaluateModel = new NsGoodsEvaluateModel();
		$condition['goods_id'] = $goods_id;
		$field = 'order_id, order_no, order_goods_id, goods_id, goods_name, goods_price, goods_image, storeid, storename, content, addtime, image, explain_first, member_name, uid, is_anonymous, scores, again_content, again_addtime, again_image, again_explain';
		return $goodsEvaluateModel->getQuery($condition, $field, 'id ASC');
	}
	
	/**
	 * 商品评价表
	 *
	 * @param number $page_index
	 * @param number $page_size
	 * @param unknown $condition
	 * @param string $order
	 * @param unknown $field
	 */
	public function getGoodsEvaluateList($page_index = 1, $page_size = 0, $condition = array(), $order = '', $field = '*')
	{
		$goodsEvaluateModel = new NsGoodsEvaluateModel();
		return $goodsEvaluateModel->pageQuery($page_index, $page_size, $condition, $order, $field);
	}
	
	/**
	 * 获取商品的店铺ID
	 *
	 * @param unknown $goods_id
	 */
	public function getGoodsShopid($goods_id)
	{
		$goods_model = new NsGoodsModel();
		$goods_info = $goods_model->getInfo([
			'goods_id' => $goods_id
		], 'shop_id');
		return $goods_info['shop_id'];
	}
	
	/**
	 * 商品评价信息的数量
	 * @evaluate_count总数量 @imgs_count带图的数量 @praise_count好评数量 @center_count中评数量 bad_count差评数量
	 *
	 * @param int $goods_id
	 */
	public function getGoodsEvaluateCount($goods_id)
	{
		$goods_evaluate = new NsGoodsEvaluateModel();
		$evaluate_count_list['evaluate_count'] = $goods_evaluate->where([
			'goods_id' => $goods_id,
			'is_show' => 1
		])->count();
		
		$evaluate_count_list['imgs_count'] = $goods_evaluate->where([
			'goods_id' => $goods_id,
			'is_show' => 1
		])->where('image|again_image', 'NEQ', '')->count();
		
		$evaluate_count_list['praise_count'] = $goods_evaluate->where([
			'goods_id' => $goods_id,
			'explain_type' => 1,
			'is_show' => 1
		])->count();
		
		$evaluate_count_list['center_count'] = $goods_evaluate->where([
			'goods_id' => $goods_id,
			'explain_type' => 2,
			'is_show' => 1
		])->count();
		
		$evaluate_count_list['bad_count'] = $goods_evaluate->where([
			'goods_id' => $goods_id,
			'explain_type' => 3,
			'is_show' => 1
		])->count();
		return $evaluate_count_list;
	}
	
	/**
	 * 查询商品兑换所需积分
	 *
	 * @param unknown $goods_id返回0表示不能兑换
	 */
	public function getGoodsPointExchange($goods_id)
	{
		$goods_model = new NsGoodsModel();
		$goods_info = $goods_model->getInfo([
			'goods_id' => $goods_id
		], 'point_exchange_type,point_exchange');
		if ($goods_info['point_exchange_type'] == 0) {
			return 0;
		} else {
			return $goods_info['point_exchange'];
		}
	}
	
	/**
	 * 获取商品咨询类型列表
	 *
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 */
	public function getConsultTypeList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$consult_type = new NsConsultTypeModel();
		$list = $consult_type->pageQuery($page_index, $page_size, $condition, $order, '');
		return $list;
	}
	
	/**
	 * 获取商品咨询列表
	 *
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 */
	public function getConsultList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$consult = new NsConsultModel();
		$list = $consult->pageQuery($page_index, $page_size, $condition, $order, '');
		if (!empty($list)) {
			foreach ($list['data'] as $k => $v) {
				$pic_info = $this->getGoodsImg($v['goods_id']);
				$list['data'][ $k ]['picture_info'] = $pic_info;
			}
		}
		return $list;
	}
	
	/**
	 * 添加 商品咨询
	 *
	 * @param unknown $goods_id
	 * @param unknown $goods_name
	 * @param unknown $uid
	 * @param unknown $member_name
	 * @param unknown $shop_id
	 * @param unknown $shop_name
	 * @param unknown $ct_id
	 * @param unknown $consult_content
	 */
	public function addConsult($goods_id, $goods_name, $uid, $member_name, $shop_id, $shop_name, $ct_id, $consult_content)
	{
		$consult = new NsConsultModel();
		$data = array(
			'goods_id' => $goods_id,
			'goods_name' => $goods_name,
			'uid' => $uid,
			'member_name' => $member_name,
			'shop_id' => $shop_id,
			'shop_name' => $shop_name,
			'ct_id' => $ct_id,
			'consult_content' => $consult_content,
			'consult_addtime' => time()
		);
		$consult->save($data);
		$data['consult_id'] = $consult->consult_id;
		hook("consultSaveSuccess", $data);
		$res = $consult->consult_id;
		return $res;
	}
	
	/**
	 * 回复 商品咨询 （店铺后台）
	 *
	 * @param unknown $consult_id
	 * @param unknown $consult_reply
	 */
	public function replyConsult($consult_id, $consult_reply)
	{
		$consult = new NsConsultModel();
		$data = array(
			'consult_reply' => $consult_reply,
			'consult_reply_time' => time()
		);
		$res = $consult->save($data, [
			'consult_id' => $consult_id
		]);
		$data['consult_id'] = $consult_id;
		hook("replyConsultSaveSuccess", $data);
		return $res;
	}
	
	/**
	 * 添加 商品咨询类型
	 *
	 * @param unknown $ct_name
	 * @param unknown $ct_introduce
	 * @param unknown $ct_sort
	 */
	public function addConsultType($ct_name, $ct_introduce, $ct_sort)
	{
	}
	
	/**
	 * 修改商品咨询类型
	 *
	 * @param unknown $ct_id
	 * @param unknown $ct_name
	 * @param unknown $ct_introduce
	 * @param unknown $ct_sort
	 */
	public function updateConsultType($ct_id, $ct_name, $ct_introduce, $ct_sort)
	{
	}
	
	/**
	 * 删除 商品咨询（店铺后台）
	 *
	 * @param unknown $consult_id
	 */
	
	public function deleteConsult($consult_id)
	{
		$consult = new NsConsultModel();
		return $consult->destroy($consult_id);
	}
	
	/**
	 * 删除 商品咨询类型
	 *
	 * @param unknown $ct_id
	 */
	public function deleteConsultType($ct_id)
	{
	}
	
	/**
	 * 获取商品咨询详情
	 *
	 * @param unknown $ct_id
	 */
	public function getConsultDetail($ct_id)
	{
	}
	
	/**
	 * 获取销售钱排行的商品
	 *
	 * @param unknown $condition
	 */
	public function getGoodsRank($condition)
	{
		$goods = new NsGoodsModel();
		$goods_list = $goods->where($condition)
			->order("real_sales desc")
			->limit(6)
			->select();
		return $goods_list;
	}
	
	/**
	 * 获取咨询个数
	 *
	 * @param unknown $condition
	 */
	public function getConsultCount($condition)
	{
		$consult = new NsConsultModel();
		$count = $consult->where($condition)->count();
		return $count;
	}
	
	/**
	 * 获取商品运费模板情况
	 *
	 * @param unknown $goods_id
	 * @param unknown $province_id
	 * @param unknown $city_id
	 */
	public function getGoodsExpressTemplate($goods_id, $province_id, $city_id, $district_id)
	{
		$goods_express = new GoodsExpress();
		$retval = $goods_express->getGoodsExpressTemplate($goods_id, $province_id, $city_id, $district_id);
		return $retval;
	}
	
	/**
	 * 获取 商品规格列表
	 *
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 */
	public function getGoodsSpecList($page_index = 1, $page_size = 0, $condition = '', $order = '', $field = '*')
	{
		$goods_spec = new NsGoodsSpecModel();
		$goods_spec_value = new NsGoodsSpecValueModel();
		$goods_spec_list = $goods_spec->pageQuery($page_index, $page_size, $condition, $order, $field);
		if (!empty($goods_spec_list['data'])) {
			foreach ($goods_spec_list['data'] as $ks => $vs) {
				$goods_spec_value_name = '';
				$spec_value_list = $goods_spec_value->getQuery([
					'spec_id' => $vs['spec_id'],
					'goods_id' => 0
				], '*', '');
				foreach ($spec_value_list as $kv => $vv) {
					$goods_spec_value_name = $goods_spec_value_name . ',' . $vv['spec_value_name'];
				}
				$goods_spec_list['data'][ $ks ]['spec_value_list'] = $spec_value_list;
				$goods_spec_value_name = $goods_spec_value_name == '' ? '' : substr($goods_spec_value_name, 1);
				$goods_spec_list['data'][ $ks ]['spec_value_name_list'] = $goods_spec_value_name;
			}
		}
		return $goods_spec_list;
	}
	
	/**
	 * 获取 商品规格详情
	 *
	 * @param unknown $spec_id
	 */
	public function getGoodsSpecDetail($spec_id)
	{
		$goods_spec = new NsGoodsSpecModel();
		$goods_spec_value = new NsGoodsSpecValueModel();
		$info = $goods_spec->getInfo([
			'spec_id' => $spec_id
		], '*');
		$goods_spec_value_name = '';
		if (!empty($info)) {
			// 去除规格属性空值
			$goods_spec_value->destroy([
				'spec_id' => $info['spec_id'],
				'spec_value_name' => ''
			]);
			$spec_value_list = $goods_spec_value->getQuery([
				'spec_id' => $info['spec_id'],
				"goods_id" => 0
			], '*', '');
			foreach ($spec_value_list as $kv => $vv) {
				$goods_spec_value_name = $goods_spec_value_name . ',' . $vv['spec_value_name'];
			}
		}
		$info['spec_value_name_list'] = substr($goods_spec_value_name, 1);
		$info['spec_value_list'] = $spec_value_list;
		return $info;
	}
	
	/**
	 * 添加 商品规格
	 *
	 * @param unknown $shop_id
	 * @param unknown $spec_name
	 * @param unknown $is_visible
	 * @param unknown $sort
	 */
	public function addGoodsSpecService($shop_id, $spec_name, $show_type, $is_visible, $sort, $spec_value_str, $attr_id = 0, $is_screen, $spec_des, $goods_id = 0)
	{
		$goods_spec = new NsGoodsSpecModel();
		$goods_spec->startTrans();
		try {
			$data = array(
				'shop_id' => $shop_id,
				'spec_name' => $spec_name,
				'show_type' => $show_type,
				'is_visible' => $is_visible,
				'sort' => $sort,
				"is_screen" => $is_screen,
				'spec_des' => $spec_des,
				'create_time' => time(),
				'goods_id' => $goods_id
			);
			$goods_spec->save($data);
			$spec_id = $goods_spec->spec_id;
			// 添加规格并修改上级分类关联规格
			if ($attr_id > 0) {
				$attribute = new NsAttributeModel();
				$attribute_info = $attribute->getInfo([
					"attr_id" => $attr_id
				], "*");
				if ($attribute_info["spec_id_array"] == '') {
					$attribute->save([
						"spec_id_array" => $spec_id
					], [
						"attr_id" => $attr_id
					]);
				} else {
					$attribute->save([
						"spec_id_array" => $attribute_info["spec_id_array"] . "," . $spec_id
					], [
						"attr_id" => $attr_id
					]);
				}
			}
			$spec_value_array = explode(',', $spec_value_str);
			$spec_value_array = array_filter($spec_value_array); // 去空
			$spec_value_array = array_unique($spec_value_array); // 去重复
			foreach ($spec_value_array as $k => $v) {
				$spec_value = array();
				if ($show_type == 2) {
					$spec_value = explode(':', $v);
					$this->addGoodsSpecValueService($spec_id, $spec_value[0], $spec_value[1], 1, 255);
				} else {
					$this->addGoodsSpecValueService($spec_id, $v, '', 1, 255);
				}
			}
			$goods_spec->commit();
			$data['spec_id'] = $spec_id;
			hook("goodsSpecSaveSuccess", $data);
			return $spec_id;
		} catch (\Exception $e) {
			$goods_spec->rollback();
			return $e->getMessage();
		}
	}
	
	/**
	 * 修改 商品规格
	 *
	 * @param unknown $spec_id
	 * @param unknown $shop_id
	 * @param unknown $spec_name
	 * @param unknown $is_visible
	 * @param unknown $sort
	 */
	public function updateGoodsSpecService($spec_id, $shop_id, $spec_name, $show_type, $is_visible, $sort, $spec_value_str, $is_screen, $spec_des, $goods_id = 0)
	{
		$goods_spec = new NsGoodsSpecModel();
		$goods_spec->startTrans();
		try {
			$data = array(
				'shop_id' => $shop_id,
				'spec_name' => $spec_name,
				'show_type' => $show_type,
				'is_visible' => $is_visible,
				'is_screen' => $is_screen,
				'sort' => $sort,
				'spec_des' => $spec_des,
				'goods_id' => $goods_id
			);
			$res = $goods_spec->save($data, [
				'spec_id' => $spec_id
			]);
			// 删掉规格下的属性
			$this->deleteSpecValue([
				"spec_id" => $spec_id
			]);
			if (!empty($spec_value_str)) {
				$spec_value_array = explode(',', $spec_value_str);
				$spec_value_array = array_filter($spec_value_array); // 去空
				$spec_value_array = array_unique($spec_value_array); // 去重复
				foreach ($spec_value_array as $k => $v) {
					$spec_value = array();
					if ($show_type == 2) {
						$spec_value = explode(':', $v);
						$this->addGoodsSpecValueService($spec_id, $spec_value[0], $spec_value[1], 1, 255);
					} else {
						$this->addGoodsSpecValueService($spec_id, $v, '', 1, 255);
					}
				}
			}
			$goods_spec->commit();
			$data['spec_id'] = $spec_id;
			hook("goodsSpecSaveSuccess", $data);
			return $res;
		} catch (\Exception $e) {
			$goods_spec->rollback();
			return $e->getMessage();
		}
	}
	
	/**
	 * 添加商品规格属性
	 *
	 * @param unknown $spec_id
	 * @param unknown $spec_value_name
	 * @param unknown $spec_value_data
	 * @param unknown $is_visible
	 * @param unknown $sort
	 */
	public function addGoodsSpecValueService($spec_id, $spec_value_name, $spec_value_data, $is_visible, $sort)
	{
		$goods_spec_value = new NsGoodsSpecValueModel();
		$data = array(
			'spec_id' => $spec_id,
			'spec_value_name' => $spec_value_name,
			'spec_value_data' => $spec_value_data,
			'is_visible' => $is_visible,
			'sort' => $sort,
			'create_time' => time()
		);
		$goods_spec_value->save($data);
		return $goods_spec_value->spec_value_id;
	}
	
	/**
	 * 检测 商品规格是否使用过
	 * 返回true = 使用过 或者 false = 没有使用过
	 *
	 * @param unknown $spec_id
	 */
	public function checkGoodsSpecIsUse($spec_id)
	{
		// 1.查询所有当前规格下，所有的商品属性，组成字符串
		$goods_spec_value = new NsGoodsSpecValueModel();
		$goods_sku = new NsGoodsSkuModel();
		$goods_sku_delete = new NsGoodsSkuDeletedModel();
		$spec_value_list = $goods_spec_value->getQuery([
			'spec_id' => $spec_id,
			'goods_id' => 0
		], '*', '');
		if (!empty($spec_value_list)) {
			$check_str = '';
			$res = 0;
			foreach ($spec_value_list as $k => $v) {
				$check_str = $spec_id . ':' . $v['spec_value_id'] . ';';
				$res += $goods_sku->where(" CONCAT(attr_value_items, ';') like '%" . $check_str . "%'")->count();
				$res += $goods_sku_delete->where(" CONCAT(attr_value_items, ';') like '%" . $check_str . "%'")->count();
				if ($res > 0) {
					return true;
					break;
				}
			}
			if ($res == 0) {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * 检测 商品规格属性是否使用过
	 * 返回true = 使用过 或者 false = 没有使用过
	 *
	 * @param unknown $spec_id
	 * @param unknown $spec_value_id
	 */
	public function checkGoodsSpecValueIsUse($spec_id, $spec_value_id)
	{
		$check_str = $spec_id . ':' . $spec_value_id . ';';
		$goods_sku = new NsGoodsSkuModel();
		$goods_sku_delete = new NsGoodsSkuDeletedModel();
		// 商品sku
		$res = $goods_sku->where(" CONCAT(attr_value_items, ';') like '%" . $check_str . "%'")->count();
		// 商品回收站sku
		$res_delete = $goods_sku_delete->where(" CONCAT(attr_value_items, ';') like '%" . $check_str . "%'")->count();
		if (($res + $res_delete) > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 添加商品评价回复
	 * $id 评价id
	 * $replyContent 回复内容
	 * $replyType 回复类型
	 */
	public function addGoodsEvaluateReply($id, $replyContent, $replyType)
	{
		$goodsEvaluate = new NsGoodsEvaluateModel();
		if ($replyType == 1) {
			return $goodsEvaluate->save([
				'explain_first' => $replyContent
			], [
				'id' => $id
			]);
		} elseif ($replyType == 2) {
			return $goodsEvaluate->save([
				'again_explain' => $replyContent
			], [
				'id' => $id
			]);
		}
	}
	
	/**
	 * 设置评价显示状态
	 */
	public function setEvaluateShowStatu($id)
	{
		$goodsEvaluate = new NsGoodsEvaluateModel();
		$showStatu = $goodsEvaluate->getInfo([
			'id' => $id
		], 'is_show');
		if ($showStatu['is_show'] == 1) {
			return $goodsEvaluate->save([
				'is_show' => 0
			], [
				'id' => $id
			]);
		} elseif ($showStatu['is_show'] == 0) {
			return $goodsEvaluate->save([
				'is_show' => 1
			], [
				'id' => $id
			]);
		}
	}
	
	/**
	 * 删除评价
	 */
	public function deleteEvaluate($id)
	{
		$goodsEvaluate = new NsGoodsEvaluateModel();
		return $goodsEvaluate->destroy($id);
	}
	
	/**
	 * 删除 商品规格属性
	 *
	 * @param unknown $spec_id
	 * @param unknown $spec_value_id
	 */
	public function deleteGoodsSpecValue($spec_id, $spec_value_id)
	{
		// 检测是否使用
		$res = $this->checkGoodsSpecValueIsUse($spec_id, $spec_value_id);
		// 检测规格属性数量
		$result = $this->getGoodsSpecValueCount([
			'spec_id' => $spec_id
		]);
		if ($res) {
			return -1;
		} else
			if ($result == 1) {
				return -2;
			} else {
				$goods_spec_value = new NsGoodsSpecValueModel();
				return $goods_spec_value->destroy($spec_value_id);
			}
	}
	
	/**
	 * 获取一定条件商品规格值 条数
	 *
	 * @param unknown $condition
	 */
	public function getGoodsSpecValueCount($condition)
	{
		$spec_value = new NsGoodsSpecValueModel();
		$count = $spec_value->where($condition)->count();
		return $count;
	}
	
	/**
	 * 删除 商品规格
	 *
	 * @param unknown $spec_id
	 */
	public function deleteGoodsSpec($spec_id)
	{
		$goods_spec = new NsGoodsSpecModel();
		$goods_spec_value = new NsGoodsSpecValueModel();
		$goods_spec->startTrans();
		try {
			$spec_id_array = explode(',', $spec_id);
			foreach ($spec_id_array as $k => $v) {
				// $res = $this->checkGoodsSpecIsUse($v);
				// if ($res) {
				// return - 1;
				// $goods_spec->rollback();
				// } else {
				$goods_spec->destroy($v);
				$goods_spec_value->destroy([
					'spec_id' => $v
				]);
				// }
			}
			
			$goods_spec->commit();
			hook("goodsSpecDeleteSuccess", $spec_id);
			return 1;
		} catch (\Exception $e) {
			$goods_spec->rollback();
			return $e->getMessage();
		}
	}
	
	/**
	 * 修改商品规格单个字段
	 *
	 * @param unknown $spec_id
	 * @param unknown $field_name
	 * @param unknown $field_value
	 */
	public function modifyGoodsSpecField($spec_id, $field_name, $field_value)
	{
		$goods_spec = new NsGoodsSpecModel();
		return $goods_spec->save([
			"$field_name" => $field_value
		], [
			'spec_id' => $spec_id
		]);
	}
	
	/**
	 * 修改 商品规格属性 单个字段
	 *
	 * @param unknown $spec_value_id
	 * @param unknown $field_name
	 * @param unknown $field_value
	 */
	public function modifyGoodsSpecValueField($spec_value_id, $field_name, $field_value)
	{
		$goods_spec_value = new NsGoodsSpecValueModel();
		return $goods_spec_value->save([
			"$field_name" => $field_value
		], [
			'spec_value_id' => $spec_value_id
		]);
	}
	
	/**
	 * 修改属性的使用状态
	 * @param unknown $attr_id
	 * @param unknown $is_use
	 */
	public function updateAttributeIsUse($attr_id, $is_use)
	{
		$goods_spec = new NsAttributeModel();
		return $goods_spec->save([
			'is_use' => $is_use
		], [
			'attr_id' => $attr_id
		]);
	}
	
	/**
	 * 获取 商品类型列表
	 *
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 * @param string $field
	 */
	public function getAttributeServiceList($page_index = 1, $page_size = 0, $condition = '', $order = '', $field = '*')
	{
		$attribute = new NsAttributeModel();
		$attribute_value = new NsAttributeValueModel();
		$list = $attribute->pageQuery($page_index, $page_size, $condition, $order, $field);
		if (!empty($list['data'])) {
			foreach ($list['data'] as $k => $v) {
				$new_array = $attribute_value->getQuery([
					'attr_id' => $v['attr_id']
				], 'attr_value_name', '');
				$value_str = '';
				foreach ($new_array as $kn => $vn) {
					$value_str = $value_str . ',' . $vn['attr_value_name'];
				}
				$value_str = substr($value_str, 1);
				$list['data'][ $k ]['value_str'] = $value_str;
			}
		}
		return $list;
	}
	
	/**
	 * 添加 商品类型
	 *
	 * @param unknown $attribute_name
	 * @param unknown $is_use
	 * @param unknown $spec_id_array
	 * @param unknown $sort
	 * @param unknown $value_string
	 */
	public function addAttributeService($attr_name, $is_use, $spec_id_array, $sort, $value_string, $brand_id_array)
	{
		$attribute = new NsAttributeModel();
		$attribute->startTrans();
		try {
			$data = array(
				"attr_name" => $attr_name,
				"is_use" => $is_use,
				"spec_id_array" => $spec_id_array,
				"sort" => $sort,
				"brand_id_array" => $brand_id_array,
				"create_time" => time()
			);
			$attribute->save($data);
			$attr_id = $attribute->attr_id;
			if (!empty($value_string)) {
				$value_array = explode(';', $value_string);
				foreach ($value_array as $k => $v) {
					$new_array = array();
					$new_array = explode('|', $v);
					$this->addAttributeValueService($attr_id, $new_array[0], $new_array[1], $new_array[2], $new_array[3], $new_array[4]);
				}
			}
			$attribute->commit();
			$data['attr_id'] = $attr_id;
			hook("goodsAttributeSaveSuccess", $data);
			return $attr_id;
		} catch (\Exception $e) {
			$attribute->rollback();
			return $e->getMessage();
		}
	}
	
	/**
	 * 修改商品类型
	 *
	 * @param unknown $attr_id
	 * @param unknown $attr_name
	 * @param unknown $is_use
	 * @param unknown $spec_id_array
	 * @param unknown $sort
	 */
	public function updateAttributeService($attr_id, $attr_name, $is_use, $spec_id_array, $sort, $value_string, $brand_id_array)
	{
		$attribute = new NsAttributeModel();
		$attribute->startTrans();
		try {
			$data = array(
				"attr_name" => $attr_name,
				"is_use" => $is_use,
				"spec_id_array" => $spec_id_array,
				"sort" => $sort,
				'brand_id_array' => $brand_id_array,
				"modify_time" => time()
			);
			$res = $attribute->save($data, [
				'attr_id' => $attr_id
			]);
			if (!empty($value_string)) {
				$value_array = explode(';', $value_string);
				foreach ($value_array as $k => $v) {
					$new_array = explode('|', $v);
					$this->addAttributeValueService($attr_id, $new_array[0], $new_array[1], $new_array[2], $new_array[3], $new_array[4]);
				}
			}
			$attribute->commit();
			$data['attr_id'] = $attr_id;
			hook("goodsAttributeSaveSuccess", $data);
			return $res;
		} catch (\Exception $e) {
			$attribute->rollback();
			return $e->getMessage();
		}
	}
	
	/**
	 * 添加 商品类型属性
	 *
	 * @param unknown $attr_id
	 * @param unknown $value
	 * @param unknown $type
	 * @param unknown $sort
	 * @param unknown $is_search
	 */
	public function addAttributeValueService($attr_id, $attr_value_name, $type, $sort, $is_search, $value)
	{
		$attribute_value = new NsAttributeValueModel();
		$data = array(
			'attr_id' => $attr_id,
			'attr_value_name' => $attr_value_name,
			'type' => $type,
			'sort' => $sort,
			'is_search' => $is_search,
			'value' => $value
		);
		$attribute_value->save($data);
		return $attribute_value->attr_value_id;
	}
	
	/**
	 * 获取商品类型详情
	 *
	 * @param unknown $attr_id
	 */
	public function getAttributeServiceDetail($attr_id, $condition = '')
	{
		$attribute = new NsAttributeModel();
		$info = $attribute->get($attr_id);
		$condition = Array();
		if (!empty($info)) {
			$condition['attr_id'] = $attr_id;
			$array = $this->getAttributeValueServiceList(1, 0, $condition, 'sort');
			$info['value_list'] = $array;
		}
		return $info;
	}
	
	/**
	 * 获取商品类型属性列表
	 *
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 * @param string $field
	 */
	public function getAttributeValueServiceList($page_index = 1, $page_size = 0, $condition = '', $order = '', $field = '*')
	{
		$attribute_value = new NsAttributeValueModel();
		return $attribute_value->pageQuery($page_index, $page_size, $condition, $order, $field);
	}
	
	/**
	 * 删除 商品类型
	 *
	 * @param unknown $attr_value_id
	 */
	public function deleteAttributeService($attr_id)
	{
		$attribute = new NsAttributeModel();
		$attribute_value = new NsAttributeValueModel();
		$res = $attribute->destroy($attr_id);
		$attribute_value->destroy([
			'attr_id' => $attr_id
		]);
		hook("goodsAttributeDeleteSuccess", [
			'attr_id' => $attr_id
		]);
		return $res;
	}
	
	/**
	 * 删除 商品类型属性
	 *
	 * @param unknown $attr_id
	 */
	public function deleteAttributeValueService($attr_id, $attr_value_id)
	{
		$attribute_value = new NsAttributeValueModel();
		// 检测类型属性数量
		$result = $this->getGoodsAttrValueCount([
			'attr_id' => $attr_id
		]);
		if ($result == 1) {
			return -2;
		} else {
			return $attribute_value->destroy($attr_value_id);
		}
	}
	
	/**
	 * 获取一定条件下商品类型值的 条数
	 *
	 * @param unknown $condition
	 */
	public function getGoodsAttrValueCount($condition)
	{
		$attr_value = new NsAttributeValueModel();
		$count = $attr_value->where($condition)->count();
		return $count;
	}
	
	/**
	 * 修改商品属性值 单个值
	 *
	 * @param unknown $field_name
	 * @param unknown $field_value
	 */
	public function modifyAttributeValueService($attr_value_id, $field_name, $field_value)
	{
		$attribute_value = new NsAttributeValueModel();
		return $attribute_value->save([
			"$field_name" => $field_value
		], [
			'attr_value_id' => $attr_value_id
		]);
	}
	
	/**
	 * 修改 商品类型 单个字段
	 *
	 * @param unknown $attr_id
	 * @param unknown $field_name
	 * @param unknown $field_value
	 */
	public function modifyAttributeFieldService($attr_id, $field_name, $field_value)
	{
		$attribute = new NsAttributeModel();
		return $attribute->save([
			"$field_name" => $field_value
		], [
			'attr_id' => $attr_id
		]);
	}
	
	/**
	 * 判断商品属性名称是否已经存在
	 * 存在 返回 true 不存在返回 false
	 *
	 * @param unknown $value_name
	 */
	public function checkGoodsSpecValueNameIsUse($spec_id, $value_name)
	{
		$goods_spec_value = new NsGoodsSpecValueModel();
		$num = $goods_spec_value->where([
			'spec_id' => $spec_id,
			'spec_value' => $value_name,
			'goods_id' => 0
		])->count();
		return $num > 0 ? true : false;
	}
	
	/**
	 * 获取分类详情
	 *
	 * @param [] $condition
	 */
	public function getAttributeInfo($condition)
	{
		$attribute = new NsAttributeModel();
		$info = $attribute->getInfo($condition, "*");
		return $info;
	}
	
	/**
	 * 获取所需规格
	 *
	 * @param array $condition
	 */
	public function getGoodsSpecQuery($condition, $goods_id = 0)
	{
		// TODO Auto-generated method stub
		$goods_spec = new NsGoodsSpecModel();
		$goods_spec_query = $goods_spec->getQuery($condition, "*", 'sort');
		
		foreach ($goods_spec_query as $k => $v) {
			$goods_spec_value = new NsGoodsSpecValueModel();
			$goods_spec_value_query = $goods_spec_value->getQuery([
				"spec_id" => $v["spec_id"],
				"goods_id" => [ 'in', '0,' . $goods_id ]
			], "*", '');
			$goods_spec_query[ $k ]["values"] = $goods_spec_value_query;
		}
		return $goods_spec_query;
	}
	
	/**
	 * 查询商品分类下的商品属性及商品规格
	 */
	public function getGoodsAttrSpecQuery($condition)
	{
		// TODO Auto-generated method stub
		if ($condition["attr_id"] == 0) {
			return -1;
		}
		$goods_attribute = $this->getAttributeInfo($condition);
		$condition_spec["spec_id"] = array(
			"in",
			$goods_attribute['spec_id_array']
		);
		$condition_spec["is_visible"] = 1;
		$condition_spec['goods_id'] = 0; // 与商品关联的规格不进行查询
		$spec_list = $this->getGoodsSpecQuery($condition_spec); // 商品规格
		
		$attribute_detail = $this->getAttributeServiceDetail($condition["attr_id"], [
			'is_search' => 1
		]);
		$attribute_list = $attribute_detail['value_list']['data'];
		
		foreach ($attribute_list as $k => $v) {
			$value_items = explode(",", $v['value']);
			$attribute_list[ $k ]['value_items'] = $value_items;
		}
		
		$list["spec_list"] = $spec_list; // 商品规格集合
		$list["attribute_list"] = $attribute_list; // 商品属性集合
		return $list;
	}
	
	/**
	 * 查询商品属性
	 */
	public function getGoodsAttributeQuery($condition)
	{
		// TODO Auto-generated method stub
		$goods_attribute = new NsGoodsAttributeModel();
		$query = $goods_attribute->getQuery($condition, "*", "");
		return $query;
	}
	
	/**
	 * 商品回收库的分页
	 *
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 */
	public function getGoodsDeletedList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		// 针对商品分类
		if (!empty($condition['ng.category_id'])) {
			$goods_category = new GoodsCategory();
			$category_list = $goods_category->getCategoryTreeList($condition['ng.category_id']);
			$condition['ng.category_id'] = array(
				'in',
				$category_list
			);
		}
		$goods_view = new NsGoodsDeletedViewModel();
		$list = $goods_view->getGoodsViewList($page_index, $page_size, $condition, $order);
		if (!empty($list['data'])) {
			// 用户针对商品的收藏
			foreach ($list['data'] as $k => $v) {
				if (!empty($this->uid)) {
					$member = new Member();
					$list['data'][ $k ]['is_favorite'] = $member->getIsMemberFavorites($this->uid, $v['goods_id'], 'goods');
				} else {
					$list['data'][ $k ]['is_favorite'] = 0;
				}
				// 查询商品单品活动信息
				$goods_preference = new GoodsPreference();
				$goods_promotion_info = $goods_preference->getGoodsPromote($v['goods_id']);
				$list["data"][ $k ]['promotion_info'] = $goods_promotion_info;
			}
		}
		return $list;
	}
	
	/**
	 * 恢复商品
	 *
	 * @param unknown $goods_ids
	 */
	public function regainGoodsDeleted($goods_ids)
	{
		$goods_array = explode(",", $goods_ids);
		$this->goods->startTrans();
		try {
			foreach ($goods_array as $goods_id) {
				$goods_delete_model = new NsGoodsDeletedModel();
				$goods_delete_obj = $goods_delete_model->getInfo([
					"goods_id" => $goods_id
				]);
				$goods_delete_obj = json_decode(json_encode($goods_delete_obj), true);
				$goods_model = new NsGoodsModel();
				$goods_model->save($goods_delete_obj);
				$goods_delete_model->where("goods_id=$goods_id")->delete();
				// sku 恢复
				$goods_sku_delete_model = new NsGoodsSkuDeletedModel();
				$sku_delete_list = $goods_sku_delete_model->getQuery([
					"goods_id" => $goods_id
				], "*", "");
				foreach ($sku_delete_list as $sku_obj) {
					$sku_obj = json_decode(json_encode($sku_obj), true);
					$sku_model = new NsGoodsSkuModel();
					$sku_model->save($sku_obj);
				}
				$goods_sku_delete_model->where("goods_id=$goods_id")->delete();
				// 属性恢复
				$goods_attribute_delete_model = new NsGoodsAttributeDeletedModel();
				$attribute_delete_list = $goods_attribute_delete_model->getQuery([
					"goods_id" => $goods_id
				], "*", "");
				foreach ($attribute_delete_list as $attribute_delete_obj) {
					$attribute_delete_obj = json_decode(json_encode($attribute_delete_obj), true);
					$attribute_model = new NsGoodsAttributeModel();
					$attribute_model->save($attribute_delete_obj);
				}
				$goods_attribute_delete_model->where("goods_id=$goods_id")->delete();
				// sku图片恢复
				$goods_sku_picture_delete = new NsGoodsSkuPictureDeleteModel();
				$goods_sku_picture_delete_list = $goods_sku_picture_delete->getQuery([
					'goods_id' => $goods_id
				], "*", "");
				foreach ($goods_sku_picture_delete_list as $goods_sku_picture_list_delete_obj) {
					$goods_sku_picture = new NsGoodsSkuPictureModel();
					$goods_sku_picture_list_delete_obj = json_decode(json_encode($goods_sku_picture_list_delete_obj), true);
					$goods_sku_picture->save($goods_sku_picture_list_delete_obj);
				}
				$goods_sku_picture_delete->where("goods_id=$goods_id")->delete();
			}
			$this->goods->commit();
			return SUCCESS;
		} catch (\Exception $e) {
			
			dump($e->getMessage());
			$this->goods->rollback();
			return UPDATA_FAIL;
		}
	}
	
	/**
	 * 拷贝商品信息
	 *
	 * @param unknown $goods_id
	 */
	public function copyGoodsInfo($goods_id)
	{
		$goods_detail = $this->getGoodsDetail($goods_id);
		$goods_attribute = $this->getGoodsAttribute($goods_id);
		$goods_attribute_arr = array();
		foreach ($goods_detail['goods_attribute_list'] as $item) {
			$item_arr = array(
				'attr_value_id' => $item['attr_value_id'],
				'attr_value' => $item['attr_value'],
				'attr_value_name' => $item['attr_value_name'],
				'sort' => $item['sort']
			);
			array_push($goods_attribute_arr, $item_arr);
		}
		$skuArray = '';
		foreach ($goods_detail['sku_list'] as $item) {
			if (!empty($item['attr_value_items'])) {
				$skuArray .= $item['attr_value_items'] . '¦' . $item['price'] . "¦" . $item['market_price'] . "¦" . $item['cost_price'] . "¦" . $item['stock'] . "¦" . $item['code'] . '§';
			}
		}
		$skuArray = rtrim($skuArray, '§');
		// sku规格图片
		$goods_sku_picture = new NsGoodsSkuPictureModel();
		$goods_sku_picture_query = $goods_sku_picture->getQuery([
			"goods_id" => $goods_id
		], "goods_id, shop_id, spec_id, spec_value_id, sku_img_array", '');
		$goods_sku_picture_query_array = array();
		foreach ($goods_sku_picture_query as $k => $v) {
			$goods_sku_picture_query_array[ $k ]["spec_id"] = $v["spec_id"];
			$goods_sku_picture_query_array[ $k ]["spec_value_id"] = $v["spec_value_id"];
			$goods_sku_picture_query_array[ $k ]["img_ids"] = $v["sku_img_array"];
		}
		if (empty($goods_sku_picture_query_array)) {
			$goods_sku_picture_str = "";
		} else {
			$goods_sku_picture_str = json_encode($goods_sku_picture_query_array);
		}
		// 阶梯优惠信息
		$ladder_preference = "";
		$goodsLadderPreferentialList = $this->getGoodsLadderPreferential([
			"goods_id" => $goods_id
		]);
		foreach ($goodsLadderPreferentialList as $v) {
			$v = $v["quantity"] . ":" . $v["price"];
		}
		$ladder_preference = implode(",", $goodsLadderPreferentialList);

// 		$virtual_goods_service = new VirtualGoods();
// 		$virtual_goods_type_info = $virtual_goods_service->getVirtualGoodsTypeInfo([
// 			'relate_goods_id' => $goods_detail['goods_id']
// 		]);
// 		$virtual_goods_type_data = json_encode($virtual_goods_type_info);
		
		//商品会员折扣信息
		$ns_goods_member_discount = new NsGoodsMemberDiscountModel();
		$discount_info = $ns_goods_member_discount->getQuery([
			"goods_id" => $goods_detail['goods_id']
		], "*", "");
		$decimal_reservation_number = -1;
		if (!empty($discount_info)) {
			$decimal_reservation_number = $discount_info[0]['decimal_reservation_number'];
		}
		$discount_info = json_encode($discount_info);
		
		$data = array(
			'goods_id' => 0,
			'goods_type' => $goods_detail['goods_type'],
			'goods_name' => $goods_detail['goods_name'] . '--副本',
			'shop_id' => $goods_detail['shop_id'],
			'keywords' => $goods_detail['keywords'],
			'introduction' => $goods_detail['introduction'],
			'description' => $goods_detail['description'],
			'code' => $goods_detail['code'],
			'state' => $goods_detail['state'],
			"goods_unit" => $goods_detail['goods_unit'],
			
			'category_id' => $goods_detail['category_id'],
			'category_id_1' => $goods_detail['category_id_1'],
			'category_id_2' => $goods_detail['category_id_2'],
			'category_id_3' => $goods_detail['category_id_3'],
			
			'supplier_id' => $goods_detail['supplier_id'],    //供应商
			'brand_id' => $goods_detail['brand_id'],       //品牌
			'group_id_array' => $goods_detail['group_id_array'], //分组
			
			//价钱
			'market_price' => $goods_detail['market_price'],
			'price' => $goods_detail['price'],
			'promotion_price' => $goods_detail['price'],
			'cost_price' => $goods_detail['cost_price'],
			
			//积分
			'point_exchange_type' => $goods_detail['point_exchange_type'],
			'point_exchange' => $goods_detail['point_exchange'],
			'give_point' => $goods_detail['give_point'],
			'max_use_point' => $goods_detail['max_use_point'],
			'integral_give_type' => $goods_detail['integral_give_type'], //积分赠送类型 0固定值 1按比率
			
			//会员折扣
			'is_member_discount' => $goods_detail['is_member_discount'],
			
			//物流
			'shipping_fee' => $goods_detail['shipping_fee'],
			'shipping_fee_id' => $goods_detail['shipping_fee_id'],
			'goods_weight' => $goods_detail['goods_weight'],
			'goods_volume' => $goods_detail['goods_volume'],
			'shipping_fee_type' => $goods_detail['shipping_fee_type'],
			
			//库存
			'stock' => $goods_detail['stock'],
			'min_stock_alarm' => $goods_detail['min_stock_alarm'],  //库存预警
			'is_stock_visible' => $goods_detail['is_stock_visible'], //显示库存
			
			//限购
			'max_buy' => $goods_detail['max_buy'],
			'min_buy' => $goods_detail['min_buy'],
			
			//基础量
			'clicks' => $goods_detail['clicks'],
			'sales' => $goods_detail['sales'],
			'shares' => $goods_detail['shares'],
			
			//地址
			'province_id' => $goods_detail['province_id'],
			'city_id' => $goods_detail['city_id'],
			
			//图片
			'picture' => $goods_detail['picture'],
			'img_id_array' => $goods_detail['img_id_array'],
			'sku_img_array' => $goods_detail['sku_img_array'],
			'QRcode' => $goods_detail['QRcode'],
			'goods_video_address' => $goods_detail['goods_video_address'],
			
			//属性规格
			'goods_attribute_id' => $goods_detail['goods_attribute_id'],
			'goods_spec_format' => $goods_detail['goods_spec_format'],
			
			//日期
			'production_date' => $goods_detail['production_date'],
			'shelf_life' => $goods_detail['shelf_life'], //保质期
			
			//模板
			'pc_custom_template' => $goods_detail['pc_custom_template'],
			'wap_custom_template' => $goods_detail['wap_custom_template'],
			
			//预售
			'is_open_presell' => $goods_detail['is_open_presell'],
			'presell_time' => $goods_detail['presell_time'],
			'presell_day' => $goods_detail['presell_day'],
			'presell_delivery_type' => $goods_detail['presell_delivery_type'],
			'presell_price' => $goods_detail['presell_price'],
			
			'sku_picture_values' => $goods_sku_picture_str,
			'ladder_preference' => $ladder_preference,
			'member_discount_arr' => $discount_info,
			'decimal_reservation_number' => $decimal_reservation_number
		);
		
		$data['skuArray'] = $skuArray;
		$res = $this->addOrEditGoods($data);
		return $res;
	}
	
	/**
	 * 删除回收站商品
	 *
	 * @param unknown $goods_id
	 */
	public function deleteRecycleGoods($goods_id)
	{
		$goods_delete = new NsGoodsDeletedModel();
		$goods_delete->startTrans();
		try {
			$res = $goods_delete->where("goods_id in ($goods_id) and shop_id=$this->instance_id ")->delete();
			if ($res > 0) {
				$goods_id_array = explode(',', $goods_id);
				$goods_sku_model = new NsGoodsSkuDeletedModel();
				$goods_attribute_model = new NsGoodsAttributeDeletedModel();
				$goods_sku_picture_delete = new NsGoodsSkuPictureDeleteModel();
				foreach ($goods_id_array as $k => $v) {
					// 删除商品sku
					$goods_sku_model->where("goods_id = $v")->delete();
					// 删除商品属性
					$goods_attribute_model->where("goods_id = $v")->delete();
					// 删除
					$goods_sku_picture_delete->where("goods_id = $v")->delete();
				}
			}
			$goods_delete->commit();
			if ($res > 0) {
				return SUCCESS;
			} else {
				return DELETE_FAIL;
			}
		} catch (\Exception $e) {
			$goods_delete->rollback();
			return DELETE_FAIL;
		}
	}
	
	/**
	 * 删除购物车cookie
	 * @param unknown $cart_id_array
	 * @return number
	 */
	private function deleteCookieCart($cart_id_array)
	{
		// TODO Auto-generated method stub
		// 获取删除条件拼装
		$cart_id_array = trim($cart_id_array);
		if (empty($cart_id_array) && $cart_id_array != 0) {
			return 0;
		}
		// 获取购物车
		$cart_goods_list = cookie('cart_array');
		if (empty($cart_goods_list)) {
			$cart_goods_list = array();
		} else {
			$cart_goods_list = json_decode($cart_goods_list, true);
		}
		foreach ($cart_goods_list as $k => $v) {
			if (strpos((string) $cart_id_array, (string) $v["cart_id"]) !== false) {
				unset($cart_goods_list[ $k ]);
			}
		}
		if (empty($cart_goods_list)) {
			cookie('cart_array', null);
			return 1;
		} else {
			sort($cart_goods_list);
			try {
				cookie('cart_array', json_encode($cart_goods_list), 3600);
				return 1;
			} catch (\Exception $e) {
				return 0;
			}
		}
	}
	
	/**
	 * 修改cookie购物车的数量
	 *
	 * @param unknown $cart_id
	 * @param unknown $num
	 * @return number
	 */
	private function updateCookieCartNum($cart_id, $num)
	{
		// 获取购物车
		$cart_goods_list = cookie('cart_array');
		if (empty($cart_goods_list)) {
			$cart_goods_list = array();
		} else {
			$cart_goods_list = json_decode($cart_goods_list, true);
		}
		foreach ($cart_goods_list as $k => $v) {
			if ($v["cart_id"] == $cart_id) {
				$cart_goods_list[ $k ]["num"] = $num;
			}
		}
		sort($cart_goods_list);
		try {
			cookie('cart_array', json_encode($cart_goods_list), 3600);
			return 1;
		} catch (\Exception $e) {
			return 0;
		}
	}
	
	/**
	 * 用户登录后同步购物车数据
	 */
	public function syncUserCart($uid)
	{
		// TODO Auto-generated method stub
		$cart = new NsCartModel();
		$cart_query = $cart->getQuery([
			"buyer_id" => $uid
		], '*', '');
		// 获取购物车
		$cart_goods_list = cookie('cart_array');
		if (empty($cart_goods_list)) {
			$cart_goods_list = array();
		} else {
			$cart_goods_list = json_decode($cart_goods_list, true);
		}
		$goodsmodel = new NsGoodsModel();
		$web_site = new WebSite();
		$goods_sku = new NsGoodsSkuModel();
		
		$web_info = $web_site->getWebSiteInfo();
		// 遍历cookie购物车
		if (!empty($cart_goods_list)) {
			foreach ($cart_goods_list as $k => $v) {
				// 商品信息
				$goods_info = $goodsmodel->getInfo([
					'goods_id' => $v['goods_id']
				], 'picture, goods_name, price');
				// sku信息
				$sku_info = $goods_sku->getInfo([
					'sku_id' => $v['sku_id']
				], 'price, sku_name, promote_price');
				if (empty($goods_info)) {
					break;
				}
				if (empty($sku_info)) {
					break;
				}
				// 查看用户会员价
				$goods_preference = new GoodsPreference();
				if (!empty($this->uid)) {
					$member_discount = $goods_preference->getMemberLevelDiscount($uid);
				} else {
					$member_discount = 1;
				}
				$member_price = $member_discount * $sku_info['price'];
				if ($member_price > $sku_info["promote_price"]) {
					$price = $sku_info["promote_price"];
				} else {
					$price = $member_price;
				}
				// 判断此用户有无购物车
				if (empty($cart_query)) {
					// 获取商品sku信息
					$this->addCart($uid, $this->instance_id, $web_info['title'], $v["goods_id"], $goods_info["goods_name"], $v["sku_id"], $sku_info["sku_name"], $price, $v["num"], $goods_info["picture"], 0);
				} else {
					$is_have = true;
					foreach ($cart_query as $t => $m) {
						if ($m["sku_id"] == $v["sku_id"] && $m["goods_id"] == $v["goods_id"]) {
							$is_have = false;
							$num = $m["num"] + $v["num"];
							$this->cartAdjustNum($m["cart_id"], $num);
							break;
						}
					}
					if ($is_have) {
						$this->addCart($uid, $this->instance_id, $web_info['title'], $v["goods_id"], $goods_info["goods_name"], $v["sku_id"], $sku_info["sku_name"], $price, $v["num"], $goods_info["picture"], 0);
					}
				}
			}
		}
		cookie('cart_array', null);
	}
	
	/**
	 * 更改商品排序
	 *
	 * @param unknown $goods_id
	 * @param unknown $sort
	 * @return boolean
	 */
	public function updateGoodsSort($goods_id, $sort)
	{
		$goods = new NsGoodsModel();
		return $goods->save([
			'sort' => $sort
		], [
			'goods_id' => $goods_id
		]);
	}
	
	/**
	 * 添加商品规格关联图
	 *
	 * @param unknown $goods_id
	 * @param unknown $spec_id
	 * @param unknown $spec_value_id
	 * @param unknown $sku_img_array
	 */
	public function addGoodsSkuPicture($shop_id, $goods_id, $spec_id, $spec_value_id, $sku_img_array)
	{
		// TODO Auto-generated method stub
		$goods_sku_picture = new NsGoodsSkuPictureModel();
		$data = array(
			"shop_id" => $shop_id,
			"goods_id" => $goods_id,
			"spec_id" => $spec_id,
			"spec_value_id" => $spec_value_id,
			"sku_img_array" => $sku_img_array,
			"create_time" => time(),
			"modify_time" => time()
		);
		$retval = $goods_sku_picture->save($data);
		return $retval;
	}
	
	/**
	 * 删除商品规格图片
	 *
	 * @param unknown $condition
	 */
	public function deleteGoodsSkuPicture($condition)
	{
		// TODO Auto-generated method stub
		$goods_sku_picture = new NsGoodsSkuPictureModel();
		$retval = $goods_sku_picture->destroy($condition);
		return $retval;
	}
	
	/**
	 * 获取随机的商品
	 */
	public function getRandGoodsList()
	{
		$result = $this->goods->getQuery([
			'state' => 1
		], 'goods_id', '');
		$res = array_rand($result, 12);
		$goods_id_list = array();
		foreach ($res as $v) {
			$goods_id_list[] = $result[ $v ];
		}
		$goodsList = array();
		foreach ($goods_id_list as $g) {
			$goodsList[] = $this->getGoodsDetail($g['goods_id']);
		}
		return $goodsList;
	}
	
	/**
	 * 查看符合条件的sku列表信息
	 *
	 * @param unknown $condition
	 */
	public function getGoodsSkuQuery($condition)
	{
		// TODO Auto-generated method stub
		$goods_sku_model = new NsGoodsSkuModel();
		$goods_query = $goods_sku_model->getQuery($condition, "goods_id", "");
		return $goods_query;
	}
	
	/**
	 * 获取商品优惠劵
	 */
	public function getGoodsCoupon($goods_id, $uid)
	{
		$coupon = new NsCouponModel();
		$coupon_type = new NsCouponTypeModel();
		$coupon_type_id_list = $coupon_type->getCouponTypeListByGoodsdetail($goods_id);
		/* 		$coupon_list = array();
				foreach ($coupon_type_id_list as $v) {
					// 已领取，已使用的数目
					$already_received = $coupon->getCount([
						'coupon_type_id' => $v['coupon_type_id'],
						"state" => [
							'neq',
							0
						]
					]);
					if ($v['count'] > $already_received) {
						$coupon_detial = $v;
					}
					if (!empty($coupon_detial)) {
						$receive_quantity = 0;
						if (!empty($uid)) {
							$receive_quantity = $coupon->getCount([
								"coupon_type_id" => $coupon_detial['coupon_type_id'],
								"uid" => $uid
							]);
						}
						
						$coupon_detial['receive_quantity'] = $receive_quantity;
						if ($coupon_detial['max_fetch'] == 0 || ($coupon_detial['max_fetch'] != 0 && $coupon_detial['max_fetch'] > $receive_quantity)) {
							$coupon_list[] = $coupon_detial;
						}
					}
				} */
		return $coupon_type_id_list;
	}
	
	/**
	 * 设置点赞送积分
	 */
	public function setGoodsSpotFabulous($shop_id, $uid, $goods_id)
	{
		$click_goods = new NsClickFabulousModel();
		// 点赞成功送积分
		$rewardRule = new PromoteRewardRule();
		// 查询点赞赠送积分数量，然后叠加
		$info = $rewardRule->getRewardRuleDetail($shop_id);
		$data = array(
			'shop_id' => $shop_id,
			'uid' => $uid,
			'goods_id' => $goods_id,
			'status' => 1,
			'number' => $info['click_point'],
			'create_time' => time()
		);
		$retval = $click_goods->save($data);
		if ($retval > 0) {
			$res = $rewardRule->addMemberPointData($shop_id, $uid, $info['click_point'], 19, '点赞赠送积分');
		}
		return $retval;
	}
	
	/**
	 * 查询点赞状态
	 *
	 * @param int $shop_id
	 * @param int $uid
	 * @param int $goods_id
	 */
	public function getGoodsSpotFabulous($shop_id, $uid, $goods_id)
	{
		$click_goods = new NsClickFabulousModel();
		$start_time = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$end_time = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
		$condition = array(
			'shop_id' => $shop_id,
			'uid' => $uid,
			'goods_id' => $goods_id,
			'create_time' => array(
				'between',
				[
					$start_time,
					$end_time
				]
			)
		);
		
		$retval = $click_goods->getInfo($condition);
		return $retval;
	}
	
	/**
	 * 修改商品名称或促销语
	 */
	public function updateGoodsNameOrIntroduction($goods_id, $up_type, $up_content)
	{
		$condition = array(
			"goods_id" => $goods_id,
			"shop_id" => $this->instance_id
		);
		if ($up_type == "goods_name") {
			return $this->goods->save([
				"goods_name" => $up_content
			], $condition);
		} elseif ($up_type == "introduction") {
			return $this->goods->save([
				"introduction" => $up_content
			], $condition);
		}
	}
	
	/**
	 * 修改商品属性排序
	 * @param unknown $attr_value_id
	 * @param unknown $sort
	 * @param unknown $shop_id
	 */
	public function updateGoodsAttributeSort($attr_value_id, $sort, $shop_id)
	{
		$goods_attribute = new NsGoodsAttributeModel();
		return $goods_attribute->save([
			"sort" => $sort
		], [
			"attr_value_id" => $attr_value_id,
			"shop_id" => $shop_id
		]);
	}
	
	/**
	 * 查询当前用户所购买的商品限购，是否能够继续购买
	 * 1.查询当前商品是否限购
	 * 2.如果该商品限购，则查询当前用户的订单项表中是否有该商品的记录
	 *
	 * @param int $goods_id商品id
	 * @return int，1：允许购买，0：不允许购买
	 */
	function getGoodsPurchaseRestrictionForCurrentUser($goods_id, $num = 0, $flag = "")
	{
		$res = array(
			"code" => 1,
			"message" => "允许购买",
			"value" => 0
		);
		$ns_goods_model = new NsGoodsModel();
		$max_buy = $ns_goods_model->getInfo([
			"goods_id" => $goods_id,
			"shop_id" => $this->instance_id
		], 'max_buy');
		
		$result = $num; // 用户购买的数量 + 购物车中的数量 + 订单交易数量不能超过商品的限购
		
		// 检测该商品是否有限购
		if (!empty($max_buy)) {
			if ($max_buy['max_buy'] > 0) {
				
				// 如果当前是订单验证，不需要查询购物车
				if ($flag != "order") {
					
					// 检测购物车中是否存在该商品
					$cart_list = $this->getCart($this->uid);
					if (!empty($cart_list)) {
						foreach ($cart_list as $k => $v) {
							if ($v['goods_id'] == $goods_id) {
								$result += $v['num'];
							}
						}
					}
				}
				if (!empty($this->uid)) {
					
					// 用户可能分开进行购买，统计当前用户购买了多少件该商品
					$ns_order_goods_model = new NsOrderGoodsModel();
					$order_goods_list = $ns_order_goods_model->getQuery([
						"goods_id" => $goods_id,
						"shop_id" => $this->instance_id,
						"buyer_id" => $this->uid
					], "order_id,num", "");
					if (!empty($order_goods_list)) {
						
						$ns_order_model = new NsOrderModel();
						foreach ($order_goods_list as $k => $v) {
							
							// 查询订单记录，排除已关闭的订单
							$count = $ns_order_model->getCount([
								'order_id' => $v['order_id'],
								"order_status" => [
									"neq",
									5
								]
							]);
							if ($count > 0) {
								$result += $v['num'];
							}
						}
					}
				}
				if ($result > $max_buy['max_buy']) {
					
					$res['code'] = 0;
					$res['message'] = "该商品每人限购" . $max_buy['max_buy'] . "件";
					$res['value'] = $result - $max_buy['max_buy']; // 还能购买的商品数量
				}
			}
		}
		
		return $res;
	}
	
	/**
	 * 添加营销活动时获取商品列表
	 *
	 * @param unknown $page_index
	 * @param unknown $page_size
	 * @param unknown $condition
	 * @param unknown $order
	 * @param unknown $field
	 * @return number[]|unknown[]
	 */
	public function getSelectGoodsList($page_index, $page_size, $condition, $order, $field)
	{
		$ns_goods = new NsGoodsModel();
		$list = $ns_goods->pageQuery($page_index, $page_size, $condition, $order, $field);
		return $list;
	}
	
	/**
	 * 获取商品阶梯优惠
	 * @param $condition
	 * @param string $order
	 * @param string $filed
	 * @return mixed
	 */
	public function getGoodsLadderPreferential($condition, $order = "", $filed = "*")
	{
		$nsGoodsLadderPreferential = new NsGoodsLadderPreferentialModel();
		$list = $nsGoodsLadderPreferential->pageQuery(1, 0, $condition, $order, $filed);
		return $list["data"];
	}
	
	/**
	 * 获取购买数量满足条件的阶梯优惠信息
	 *
	 * @param unknown $goods_id
	 * @param unknown $num
	 */
	public function getGoodsLadderPreferentialInfo($goods_id, $num, $goods_price)
	{
		$nsGoodsLadderPreferential = new NsGoodsLadderPreferentialModel();
		$condition["goods_id"] = $goods_id;
		$condition["quantity"] = array(
			"ELT",
			$num
		);
		$res = $nsGoodsLadderPreferential->pageQuery(1, 1, $condition, "quantity desc", "*");
		if ($res["total_count"] > 0) {
			$goods_price -= $res["data"][0]["price"];
		}
		$goods_price = $goods_price < 0 ? 0 : round($goods_price, 2);
		return $goods_price;
	}
	
	/**
	 * 获取商品轨迹列表
	 * @param unknown $page_index
	 * @param unknown $page_size
	 * @param unknown $condition
	 * @param unknown $order
	 * @param string $field
	 */
	public function getGoodsBrowseList($page_index, $page_size, $condition, $order, $field = "*")
	{
		// TODO Auto-generated method stub
		$goods_browse = new NsGoodsBrowseModel();
		$goods_browse_list = $goods_browse->pageQuery($page_index, $page_size, $condition, $order, $field);
		$category_list = array();
		if (!empty($goods_browse_list)) {
			foreach ($goods_browse_list["data"] as $k => $v) {
				$goods_info = $this->goods->getInfo([
					"goods_id" => $v["goods_id"]
				], "category_id, category_id_1, goods_name, promotion_type, promotion_price, shop_id, price, picture, clicks, point_exchange_type, point_exchange");
				
				$ablum_picture = new AlbumPictureModel();
				$picture_info = $ablum_picture->getInfo([
					"pic_id" => $goods_info["picture"]
				]);
				$goods_info["picture_info"] = $picture_info;
				$goods_category = new NsGoodsCategoryModel();
				$category_info = $goods_category->getInfo([
					"category_id" => $v["category_id"]
				], "category_name, short_name, category_id");
				// 判断数组是否存在(拼装分类列表)
				if (!empty($category_info)) {
					if (!in_array($category_info, $category_list)) {
						$category_list[] = $category_info;
					}
				}
				$goods_browse_list["data"][ $k ]["goods_info"] = $goods_info;
				$goods_browse_list["data"][ $k ]["category"] = $category_info;
			}
		}
		$goods_browse_list["category_list"] = $category_list;
		
		return $goods_browse_list;
	}
	
	/**
	 * 添加商品轨迹
	 * @param int $goods_id
	 * @param int $uid
	 */
	public function addGoodsBrowse($goods_id, $uid)
	{
		$goods_browse = new NsGoodsBrowseModel();
		try {
			// 判断原足迹中是否有这个商品
			$condition = array(
				"goods_id" => $goods_id,
				"uid" => $uid
			);
			$count = $goods_browse->getCount($condition);
			if ($count > 0) {
				$goods_browse->destroy($condition);
			}
			$goods_model = new NsGoodsModel();
			$goods_info = $goods_model->getInfo([
				"goods_id" => $goods_id
			], "category_id");
			$data = array(
				"goods_id" => $goods_id,
				"uid" => $uid,
				"create_time" => time(),
				"category_id" => $goods_info["category_id"],
				"add_date" => date('Y-m-d', time())
			);
			$goods_browse->save($data);
			$goods_browse->commit();
			return $goods_browse->browse_id;
		} catch (\Exception $e) {
			$goods_browse->rollback();
			return 0;
		}
	}
	
	/**
	 * 删除商品轨迹
	 * @param unknown $condition
	 */
	public function deleteGoodsBrowse($condition)
	{
		// TODO Auto-generated method stub
		$goods_browse = new NsGoodsBrowseModel();
		$retval = $goods_browse->destroy($condition);
		return $retval;
	}
	
	/**
	 * 根据条件、指定数量查询商品
	 */
	public function getGoodsQueryLimit($condition, $field, $page_size = PAGESIZE, $order = "ng.sort asc")
	{
		$goods_model = new NsGoodsModel();
		$list = $goods_model->alias("ng")
			->join('sys_album_picture ng_sap', 'ng_sap.pic_id = ng.picture', 'left')
			->field($field)
			->where($condition)
			->order($order)
			->limit("0,$page_size")
			->select();
		return $list;
	}
	
	/**
	 * 商品表视图，不关联任何表
	 * @param unknown $condition
	 * @param unknown $field
	 * @param unknown $order
	 */
	public function getGoodsViewQueryField($condition, $field, $order)
	{
		$goods_model = new NsGoodsModel();
		$viewObj = $goods_model->alias('ng')->field($field);
		$list = $viewObj->where($condition)
			->order($order)
			->select();
		return $list;
	}
	
	/**
	 * 获取商品查询数量，分页用
	 * 创建时间：2018年1月4日16:52:45
	 *
	 * @param unknown $condition
	 * @return unknown
	 */
	public function getGoodsQueryCount($condition, $where_sql = "")
	{
		$goods_model = new NsGoodsModel();
		$viewObj = $goods_model->alias('ng');
		if (!empty($where_sql)) {
			$count = $goods_model->viewCountNew($viewObj, $condition, $where_sql);
		} else {
			$count = $goods_model->viewCount($viewObj, $condition);
		}
		return $count;
	}
	
	/**
	 * 后台商品列表
	 * 创建时间：2018年1月5日11:07:41
	 *
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 * @return unknown|\think\cache\mixed
	 */
	public function getBackStageGoodsList($page_index = 1, $page_size = 0, $condition = '', $order = 'ng.sort asc')
	{
		// $json = json_encode($condition);
		// $list_cache = Cache::tag("goods_service")->get("get_back_stage_goods_list" . $json . $page_index);
		// if (empty($list_cache)) {
		
		$goods_model = new NsGoodsModel();
		// 针对商品分类
		if (!empty($condition['ng.category_id'])) {
			$goods_category = new GoodsCategory();
			
			// 获取当前商品分类的子分类
			$category_list = $goods_category->getCategoryTreeList($condition['ng.category_id']);
			
			unset($condition['ng.category_id']);
			$query_goods_ids = "";
			$goods_list = $this->getGoodsViewQueryField($condition, "ng.goods_id", "");
			if (!empty($goods_list) && count($goods_list) > 0) {
				foreach ($goods_list as $goods_obj) {
					if ($query_goods_ids === "") {
						$query_goods_ids = $goods_obj["goods_id"];
					} else {
						$query_goods_ids = $query_goods_ids . "," . $goods_obj["goods_id"];
					}
				}
				$extend_query = "";
				$category_str = explode(",", $category_list);
				foreach ($category_str as $category_id) {
					if ($extend_query === "") {
						$extend_query = " FIND_IN_SET( " . $category_id . ",ng.extend_category_id) ";
					} else {
						$extend_query = $extend_query . " or FIND_IN_SET( " . $category_id . ",ng.extend_category_id) ";
					}
				}
				$condition = " ng.goods_id in (" . $query_goods_ids . ") and ( ng.category_id in (" . $category_list . ") or " . $extend_query . ")";
			}
		}
		
		$viewObj = $goods_model->alias("ng")
			->join('sys_album_picture ng_sap', 'ng_sap.pic_id = ng.picture', 'left')
			->field("ng.goods_id,ng.goods_name,ng.promotion_price,ng.market_price,ng.goods_type,ng.stock,ng.introduction,ng.max_buy,ng.state,ng.is_hot,ng.is_recommend,ng.is_new,ng.sales,ng.shipping_fee,ng_sap.pic_cover_micro,ng.code,ng.create_time,ng.QRcode,ng.price,ng.real_sales,ng.sort,ng.group_id_array");
		$query_list = $goods_model->viewPageQuery($viewObj, $page_index, $page_size, $condition, $order);
		
		//关联插件信息
		foreach ($query_list as $list_k => $list_v) {
			$info_list = hook("getGoodsRelationInfo", [ "goods_info" => $list_v ]);
			$info_list = arrayFilter($info_list);
			if (!empty($info_list)) {
				foreach ($info_list as $info_k => $info_v) {
					$query_list[ $list_k ][ $info_v["key"] ] = $info_v["info"];
				}
			}
			//商品类型配置
			$goods_config = hook('getGoodsConfig', [ 'type_id' => $list_v['goods_type'] ]);
			$query_list[ $list_k ]['type_config'] = arrayFilter($goods_config)[0];
		}
		
		
		$queryCount = $this->getGoodsQueryCount($condition);
		$list = $goods_model->setReturnList($query_list, $queryCount, $page_size);
		// Cache::tag("goods_service")->set("get_back_stage_goods_list" . $json . $page_index, $list);
		return $list;
		// } else {
		// return $list_cache;
		// }
	}
	
	/**
	 * 优化过后的商品列表
	 * 创建时间：2018年1月4日17:46:05
	 *
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 * @return unknown|\think\cache\mixed
	 */
	public function getGoodsListNew($page_index = 1, $page_size = 0, $condition = '', $order = 'ng.sort asc')
	{
		$json = json_encode($condition);
		$goods_model = new NsGoodsModel();
		$where_sql = "";
		// 针对商品分类
		if (!empty($condition['ng.category_id'])) {
			$goods_category = new GoodsCategory();
			$select_category_id = $condition['ng.category_id'];
			unset($condition['ng.category_id']);
			$category_model = new NsGoodsCategoryModel();
			$select_category_obj = $category_model->getInfo([
				"category_id" => $select_category_id
			], "level");
			$select_level = $select_category_obj["level"];
			if ($select_level == 1) {
				$where_sql = "(ng.category_id_1=$select_category_id or FIND_IN_SET( " . $select_category_id . ",ng.extend_category_id_1))";
			} elseif ($select_level == 2) {
				$where_sql = "(ng.category_id_2=$select_category_id or FIND_IN_SET( " . $select_category_id . ",ng.extend_category_id_2))";
			} elseif ($select_level == 3) {
				$where_sql = "(ng.category_id_3=$select_category_id or FIND_IN_SET( " . $select_category_id . ",ng.extend_category_id_3))";
			}
		}
		$viewObj = $goods_model->alias("ng")
			->join('sys_album_picture ng_sap', 'ng_sap.pic_id = ng.picture', 'left')
			->field("ng.goods_id,ng.goods_name,ng_sap.pic_cover_mid,ng.promotion_price,ng.market_price,ng.goods_type,ng.stock,ng_sap.pic_id,ng.max_buy,ng.state,ng.is_hot,ng.is_recommend,ng.is_new,ng.sales,ng_sap.pic_cover_small,ng.group_id_array,ng.shipping_fee,ng.point_exchange_type,ng.point_exchange,ng.is_open_presell");
		$queryList = $goods_model->viewPageQueryNew($viewObj, $page_index, $page_size, $condition, $where_sql, $order);
		$queryCount = $this->getGoodsQueryCount($condition, $where_sql);
		$list = $goods_model->setReturnList($queryList, $queryCount, $page_size);
		$goods_sku = new NsGoodsSkuModel();
		$goods_preference = new GoodsPreference();
		// 用户针对商品的收藏
		foreach ($list['data'] as $k => $v) {
			if ($v['point_exchange_type'] == 0 || $v['point_exchange_type'] == 2) {
				$list['data'][ $k ]['display_price'] = '￥' . $v["promotion_price"];
			} else {
				if ($v['point_exchange_type'] == 1 && $v["promotion_price"] > 0) {
					$list['data'][ $k ]['display_price'] = '￥' . $v["promotion_price"] . '+' . $v["point_exchange"] . '积分';
				} else {
					$list['data'][ $k ]['display_price'] = $v["point_exchange"] . '积分';
				}
			}
			// $list['data'][$k]['sku_list'] = $sku_list;
		}
		return $list;
	}
	
	/**
	 * 修改商品点击量
	 * @param int $goods_id
	 * @return number
	 */
	public function updateGoodsClicks($goods_id)
	{
		$res = 0;
		$model = new NsGoodsModel();
		$info = $model->getInfo([
			'goods_id' => $goods_id
		], "clicks");
		if (!empty($info)) {
			$clicks = 0;
			if (!empty($info['clicks'])) {
				$clicks = $info['clicks'];
			}
			$clicks++;
			$res = $model->save([
				'clicks' => $clicks
			], [
				'goods_id' => $goods_id
			]);
		}
		return $res;
	}
	
	/**
	 * 通过商品标签数组获取商品标签
	 *
	 * @param unknown $goods_group_id_array
	 */
	public function getGoodsTabByGoodsGroupId($goods_group_id_str)
	{
		if (!empty($goods_group_id_str)) {
			$ns_group = new NsGoodsGroupModel();
			$goods_tab_arr = $ns_group->getQuery([
				'group_id' => [
					"in",
					$goods_group_id_str
				]
			], "group_id, group_name", "");
			return $goods_tab_arr;
		}
		return array();
	}
	
	/**
	 * 通过商品id获取商品sku列表
	 *
	 * @param unknown $goods_id
	 */
	public function getGoodsSkuListByGoodsId($goods_id)
	{
		$goods_sku = new NsGoodsSkuModel();
		$goods_preference = new GoodsPreference();
		
		$goods_promotion_info = $goods_preference->getGoodsPromote($goods_id);
		
		$sku_list = $goods_sku->where([
			'goods_id' => $goods_id
		])
			->field("attr_value_items,stock,promote_price,price,sku_id,sku_name")
			->select();
		
		if (!empty($sku_list)) {
			foreach ($sku_list as $k => $v) {
				// 判断该商品目前是否参与活动 参与的话sku价格取 促销价 否则取原价
				$sku_list[ $k ]["price"] = empty($goods_promotion_info) ? $v['price'] : $v['promote_price'];
			}
		}
		return $sku_list;
	}
	
	/**
	 * 商品批量处理
	 *
	 * @param unknown $info
	 */
	public function batchProcessingGoods($info)
	{
		if (!empty($info['goods_ids'])) {
			$goods_model = new NsGoodsModel(); // 商品主表
			$goods_sku_model = new NsGoodsSkuModel(); // 商品sku表
			// 开启事物
			$goods_model->startTrans();
			try {
				$goods_id_array = explode(',', $info['goods_ids']);
				if (count($goods_id_array) > 0) {
					foreach ($goods_id_array as $v) {
						$goods_data = array(); // 商品修改项
						if ($info['brand_id'] != 0) {
							$goods_data['brand_id'] = $info['brand_id'];
						}
						
						if ($info['catrgory_one'] > 0) {
							$goods_data['category_id_1'] = $info['catrgory_one'];
							$goods_data['category_id_2'] = $info['catrgory_two'];
							$goods_data['category_id_3'] = $info['catrgory_three'];
							if ($info['catrgory_three'] > 0) {
								$goods_data['category_id'] = $info['catrgory_three'];
							} else
								if ($info['catrgory_two'] > 0) {
									$goods_data['category_id'] = $info['catrgory_two'];
								} else {
									$goods_data['category_id'] = $info['catrgory_one'];
								}
						}
						
						$condition["goods_id"] = $v;
						// 商品sku列表
						$goods_sku_list = $goods_sku_model->getQuery($condition, "*", "");
						
						foreach ($goods_sku_list as $goods_sku) {
							$data = array(); // 商品sku修该项
							if ($info['price'] != 0) {
								$price = $goods_sku["price"] + $info['price'];
								$data['price'] = $price < 0 ? 0 : $price;
								$data['promote_price'] = $price < 0 ? 0 : $price;
							}
							if ($info['market_price'] != 0) {
								$market_price = $goods_sku["market_price"] + $info['market_price'];
								$data['market_price'] = $market_price < 0 ? 0 : $market_price;
							}
							if ($info['cost_price'] != 0) {
								$cost_price = $goods_sku["cost_price"] + $info['cost_price'];
								$data['cost_price'] = $cost_price < 0 ? 0 : $cost_price;
							}
							if ($info['stock'] != 0) {
								$stock = $goods_sku["stock"] + $info['stock'];
								$data['stock'] = $stock < 0 ? 0 : $stock;
							}
							$goods_sku_model = new NsGoodsSkuModel(); // 商品sku表
							if (count($data) > 0) {
								$goods_sku_model->save($data, [
									"sku_id" => $goods_sku['sku_id']
								]);
							}
						}
						
						$goods_data['stock'] = $goods_sku_model->getSum($condition, "stock");
						$goods_data['promotion_price'] = $goods_sku_model->getMin($condition, "price");
						$goods_data['price'] = $goods_sku_model->getMin($condition, "price");
						$goods_data['market_price'] = $goods_sku_model->getMin($condition, "market_price");
						$goods_data['cost_price'] = $goods_sku_model->getMin($condition, "cost_price");
						$goods_model = new NsGoodsModel(); // 商品主表
						if (count($goods_data) > 0) {
							$goods_model->save($goods_data, [
								"goods_id" => $v
							]);
						}
						$this->modifyGoodsPromotionPrice($v);
					}
				}
				$goods_model->commit();
				return $retval = array(
					"code" => 1,
					"message" => '操作成功'
				);
			} catch (\Exception $e) {
				$goods_model->rollback();
				return $retval = array(
					"code" => 0,
					"message" => $e->getMessage()
				);
			}
		} else {
			return $retval = array(
				"code" => 0,
				"message" => '请至少选择一件商品'
			);
		}
	}
	
	/**
	 * 获取规格信息
	 *
	 * @param unknown $condition
	 * @return unknown
	 */
	public function getGoodsSpecInfoQuery($condition, $goods_id = 0)
	{
		$condition_spec = array();
		if ($condition["attr_id"] > 0) {
			$goods_attribute = $this->getAttributeInfo($condition);
			$condition_spec["spec_id"] = array(
				"in",
				$goods_attribute['spec_id_array']
			);
		}
		$condition_spec["is_visible"] = 1;
		$condition_spec['goods_id'] = [ 'in', '0,' . $goods_id ]; // 与商品关联的规格不进行查询
		$spec_list = $this->getGoodsSpecQuery($condition_spec, $goods_id); // 商品规格
		$list["spec_list"] = $spec_list; // 商品规格集合
		return $list;
	}
	
	/**
	 * 删除商品规格值
	 * @param unknown $condition
	 */
	public function deleteSpecValue($condition)
	{
		// 删掉规格下的属性
		$goods_spec_value = new NsGoodsSpecValueModel();
		return $goods_spec_value->destroy($condition);
	}
	
	/**
	 * 设置商品折扣
	 * @param unknown $goods_ids
	 * @param unknown $discount_info
	 */
	public function setMemberDiscount($goods_ids, $discount_info, $decimal_reservation_number)
	{
		
		if (!empty($goods_ids) && !empty($discount_info)) {
			$ns_goods_member_discount = new NsGoodsMemberDiscountModel();
			$ns_goods_member_discount->startTrans();
			try {
				$discount_info_arr = json_decode($discount_info, true);
				
				$goods_ids = explode(",", $goods_ids);
				foreach ($goods_ids as $goods_id) {
					foreach ($discount_info_arr as $v) {
						$count = $ns_goods_member_discount->getCount([ "level_id" => $v["level_id"], "goods_id" => $goods_id ]);
						$data["goods_id"] = $goods_id;
						$data["discount"] = $v["discount"];
						$data["level_id"] = $v["level_id"];
						$data["decimal_reservation_number"] = $decimal_reservation_number;
						if ($count == 0) {
							$ns_goods_member_discount = new NsGoodsMemberDiscountModel();
							$ns_goods_member_discount->save($data);
						} else {
							$ns_goods_member_discount = new NsGoodsMemberDiscountModel();
							$ns_goods_member_discount->save($data, [ "level_id" => $v["level_id"], "goods_id" => $goods_id ]);
						}
					}
				}
				
				$ns_goods_member_discount->commit();
				return array(
					"code" => 1,
					"message" => "设置成功"
				);
			} catch (\Exception $e) {
				$ns_goods_member_discount->rollback();
				return array(
					"code" => 0,
					"message" => $e->getMessage()
				);
			}
		} else {
			return array(
				"code" => 0,
				"message" => "操作失败"
			);
		}
	}
	
	/**
	 * 获取商品会员折扣
	 * @param unknown $level_id
	 * @param unknown $goods_id
	 * @return string
	 */
	public function getGoodsDiscountByMemberLevel($level_id, $goods_id)
	{
		$ns_goods_member_discount = new NsGoodsMemberDiscountModel();
		$goods_member_discount_detail = $ns_goods_member_discount->getInfo([ "level_id" => $level_id, "goods_id" => $goods_id ], "discount,decimal_reservation_number");
		if (!empty($goods_member_discount_detail["discount"])) {
			$member_level_discount = $goods_member_discount_detail;
		} else {
			$member_level_discount = array(
				"discount" => "",
				"decimal_reservation_number" => -1
			);
		}
		return $member_level_discount;
	}
	
	/**
	 * 获取商品会员折扣列表
	 * @param unknown $goods_id
	 */
	public function showMemberDiscount($goods_id)
	{
		$ns_goods_member_discount = new NsGoodsMemberDiscountModel();
		$discount_list = $ns_goods_member_discount->getQuery([ "goods_id" => $goods_id ], "level_id,discount,decimal_reservation_number", "");
		
		$decimal_reservation_number = -1;
		if (!empty($discount_list)) {
			$decimal_reservation_number = $discount_list[0]['decimal_reservation_number'];
		}
		
		$list = array(
			"discount_list" => $discount_list,
			"decimal_reservation_number" => $decimal_reservation_number
		);
		return $list;
	}
	
	/**
	 * 处理会员价
	 * @param unknown $goods_id
	 * @param unknown $member_price
	 */
	public function handleMemberPrice($goods_id, $member_price)
	{
		$discount_info = $this->showMemberDiscount($goods_id);
		$decimal_reservation_number = $discount_info['decimal_reservation_number'];
		if ($decimal_reservation_number >= 0) {
			$member_price = round($member_price, $decimal_reservation_number);
		}
		return sprintf("%.2f", $member_price);
	}
	
	/**
	 * 修改商品品牌的推荐状态
	 */
	public function updateGoodsBrandType($brand_id, $brand_recommend)
	{
		
		$goods_brank_model = new NsGoodsBrandModel();
		
		$data['brand_recommend'] = $brand_recommend;
		
		$res = $goods_brank_model->save($data, [ 'brand_id' => $brand_id ]);
		
		return $res;
	}
	
	/**
	 * 商品规格详情列表
	 * @param unknown $goods_id
	 */
	public function getGoodsSkuDetailsList($goods_id)
	{
		
		$goods_sku_model = new NsGoodsSkuModel();
		$goods_sku_list = $goods_sku_model->getQuery([ 'goods_id' => $goods_id ], '*');
		
		$order_query = new OrderQuery();
		$picture = new AlbumPictureModel();
		foreach ($goods_sku_list as $item) {
			
			if (!empty($item['picture'])) {
				$item['pic_cover'] = $picture->getInfo([ 'pic_id' => $item['picture'] ], 'pic_cover_mid')['pic_cover_mid'];
			} else {
				$item['pic_cover'] = '';
			}
		}
		return $goods_sku_list;
	}
	
	/**
	 * 商品列表
	 */
	public function getRecommendGoodsList($page_index = 1, $page_size = 0, $condition = '', $order = 'ng.sort asc')
	{
		$goods_model = new NsGoodsModel();
		$viewObj = $goods_model->alias("ng")
			->join('sys_album_picture ng_sap', 'ng_sap.pic_id = ng.picture', 'left')
			->field("ng.price,ng.brand_id,ng.goods_id,ng.goods_name,ng_sap.pic_cover_mid,ng.promotion_price,ng.market_price,ng.goods_type,ng.stock,ng_sap.pic_id,ng.max_buy,ng.state,ng.is_hot,ng.is_recommend,ng.is_new,ng.sales,ng_sap.pic_cover_small,ng.group_id_array,ng.shipping_fee,ng.point_exchange_type,ng.point_exchange,ng.is_open_presell");
		$list = $goods_model->viewPageQueryNew($viewObj, $page_index, $page_size, $condition, '', $order);
		return $list;
	}
}