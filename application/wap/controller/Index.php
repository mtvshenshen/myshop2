<?php
/**
 * Index.php
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

use addons\Nsfx\data\service\NfxPromoter;
use data\service\Config;
use data\service\WebSite;
use think\Cookie;

class Index extends BaseWap
{
	
	/**
	 * 商品标签板块每层显示商品个数
	 *
	 * @var unknown
	 */
	public $recommend_goods_num = 4;
	
	/**
	 * 手机端首页
	 *
	 * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
	 */
	public function index()
	{
		$config = new Config();
		$this->web_site = new WebSite();

		if($user_shop_id = request()->get('user_shop_id')){
			Cookie::set("user_shop_id", $user_shop_id);
		}

		// 分享
		$ticket = $this->getShareTicket();
		$this->assign("signPackage", $ticket);
		
		// 公众号二维码获取
		
		// 公众号配置查询
		$wchat_config = $config->getInstanceWchatConfig($this->instance_id);
		
		$is_subscribe = 0; // 标识：是否显示顶部关注 0：[隐藏]，1：[显示]
		if ($this->web_info["is_show_follow"] == 1) {
			// 检查是否配置过微信公众号
			if (!empty($wchat_config['value'])) {
				if (!empty($wchat_config['value']['appid']) && !empty($wchat_config['value']['appsecret'])) {
					// 如何判断是否关注
					if (isWeixin()) {
						if (!empty($this->uid)) {
							// 检查当前用户是否关注
							$user_sub = $this->user->checkUserIsSubscribeInstance($this->uid, $this->instance_id);
							if ($user_sub == 0) {
								// 未关注
								$is_subscribe = 1;
							}
						}
					}
				}
			}
		}
		
		$this->assign("is_subscribe", $is_subscribe);
		
		$source_uid = request()->get('source_uid', '');
		if (!empty($source_uid)) {
		    $this->redirect("/wap/index/shopIndex", ['source_uid' => $source_uid]);
			$_SESSION['source_uid'] = $source_uid;
		}
		
		if($this->uid && addon_is_exit('Nsfx')){
		    $fx_promoter = new NfxPromoter();
		    $parent_promoter = $fx_promoter->getMemberParentPromoter($this->uid);
		    if(!empty($parent_promoter['uid'])){
		        $this->redirect("/wap/index/shopIndex", ['source_uid' => $parent_promoter['uid']]);
		    }
		}
		
		// 判断是否开启了自定义模块
		if ($this->custom_template_is_enable == 1 && addon_is_exit('NsDiyView')) {
			// 获取自定义模板信息
			$this->redirect(__URL(\think\Config::get('view_replace_str.APP_MAIN') . "/CustomTemplate/customTemplateIndex"));
		} else {
			return $this->view($this->style . 'index/index');
		}
	}
	
	
	
	/**
	 * 删除设置页面打开cookie
	 */
	public function deleteClientCookie()
	{
	    Cookie::delete("default_client");
	    return AjaxReturn(1);
	}
	
	/**
	 * 设置页面打开cookie
	 */
	public function setClientCookie()
	{

	    $client = isset($this->params['client']) ? $this->params['client'] : "";
	    Cookie::set("default_client", $client);
	    $cookie = isset($this->params['default_client']) ? $this->params['default_client'] : "";
	    if ($cookie != "") {
	        return AjaxReturn(1);
	    }
	    return AjaxReturn(0);
	}
	
	/**
	 * 错误页
	 */
	public function errorTemplate()
	{
	    return $this->view($this->style . 'index/error');
	}
	
	/**
	 * 店铺首页
	 */
	public function shopIndex(){
	    $source_uid = input('source_uid', 0);
	    $fx_promoter = new NfxPromoter();
	    $promoter_info = $fx_promoter->getPromoterDetailByUid($source_uid);
	    if(empty($promoter_info)) $this->redirect('wap/index/index');
	    $this->assign('title', $promoter_info['promoter_shop_name'].'的店铺');
	    $this->assign('promoter_info', $promoter_info);
	    return $this->view($this->style . 'index/shopIndex');
	}
}