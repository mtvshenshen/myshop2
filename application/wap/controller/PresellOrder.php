<?php
/**
 * PresellOrder.php
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

/**
 * 预售订单控制器
 *
 * @author Administrator
 *
 */
class PresellOrder extends Order
{
	/**
	 * 获取当前会员的订单列表
	 */
	public function myPresellOrderList()
	{
		$this->assign("title", lang('presell_my_order'));
		$this->assign("title_before", lang('presell_my_order'));
		return $this->view($this->style . 'PresellOrder/myPresellOrderList');
	}
	
	/**
	 * 订单详情
	 *
	 */
	public function orderDetail()
	{
		$this->assign("title", lang('member_order_details'));
		$this->assign("title_before", lang('member_order_details'));
		return $this->view($this->style . 'PresellOrder/orderDetail');
	}
}