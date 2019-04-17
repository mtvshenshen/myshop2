<?php
/**
 * Config.php
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

namespace app\api\controller;


use data\service\Config as ConfigService;
use data\service\Upgrade;
use data\service\WebSite;


/**
 * 配置
 */
class Config extends BaseApi
{
	
	/**
	 * 商家服务
	 */
	public function merchantService()
	{
		$config = new ConfigService();
		$instance_id = isset($this->params['instance_id']) ? $this->params['instance_id'] : $this->instance_id;
		$merchant_service_list = $config->getExistingMerchantService($instance_id);
		return $this->outMessage("", $merchant_service_list);
	}
	
	/**
	 * 默认图片
	 */
	public function defaultImages()
	{
		$config = new ConfigService();
		$defaultImages = $config->getDefaultImages($this->instance_id);
		return $this->outMessage("", $defaultImages);
	}
	
	/**
	 * 提现设置
	 */
	public function balanceWithdraw()
	{
		$config = new ConfigService();
		$balanceConfig = $config->getBalanceWithdrawConfig($this->instance_id);
		return $this->outMessage("", $balanceConfig);
	}
	
	/**
	 * 公告信息
	 */
	public function notice()
	{
		$config = new ConfigService();
		$instance_id = isset($this->params['instance_id']) ? $this->params['instance_id'] : $this->instance_id;
		$user_notice = $config->getUserNotice($instance_id);
		return $this->outMessage("", $user_notice);
	}
	
	/**
	 * 商家配置
	 */
	public function trade()
	{
		$config = new ConfigService();
		$instance_id = isset($this->params['instance_id']) ? $this->params['instance_id'] : $this->instance_id;
		$shopSet = $config->getShopConfig($instance_id);
		return $this->outMessage("", $shopSet);
	}
	
	/**
	 * seo设置
	 */
	public function seo()
	{
		$config = new ConfigService();
		$seoconfig = $config->getSeoConfig($this->instance_id);
		return $this->outMessage("", $seoconfig);
	}
	
	/**
	 * 商城热卖关键字
	 */
	public function hotSearch()
	{
		$config = new ConfigService();
		$instance_id = isset($this->params['instance_id']) ? $this->params['instance_id'] : $this->instance_id;
		$hot_keys = $config->getHotsearchConfig($instance_id);
		return $this->outMessage("", $hot_keys);
	}
	
	
	/**
	 * 登录验证码设置
	 */
	public function loginVerifyCode()
	{
		$config = new ConfigService();
		$instance_id = isset($this->params['instance_id']) ? $this->params['instance_id'] : $this->instance_id;
		$login_verify_code_1 = $config->getLoginVerifyCodeConfig($instance_id);
		return $this->outMessage("", $login_verify_code_1);
	}
	
	/**
	 * 第三方登录配置  QQ
	 */
	public function qQLogin()
	{
		$config = new ConfigService();
		$instance_id = isset($this->params['instance_id']) ? $this->params['instance_id'] : $this->instance_id;
		$qq_info = $config->getQQConfig($instance_id);
		return $this->outMessage("", $qq_info);
	}
	
	/**
	 * 第三方登录配置  微信
	 */
	public function wchatLogin()
	{
		$config = new ConfigService();
		$instance_id = isset($this->params['instance_id']) ? $this->params['instance_id'] : $this->instance_id;
		$Wchat_info = $config->getWchatConfig($instance_id);
		return $this->outMessage("", $Wchat_info);
	}
	
	/**
	 * 客服链接
	 */
	public function customService()
	{
		$config = new ConfigService();
		$instance_id = isset($this->params['instance_id']) ? $this->params['instance_id'] : $this->instance_id;
		$custom_service = $config->getCustomServiceConfig($instance_id);
		return $this->outMessage("", $custom_service);
	}
	
	/**
	 * 积分奖励
	 */
	public function pointReward()
	{
		$config = new ConfigService();
		$integral_config = $config->getIntegralConfig($this->instance_id);
		return $this->outMessage("", $integral_config);
	}
	
	/**
	 * 获取手机端首页排版
	 */
	public function wapPageLayout()
	{
		$config = new ConfigService();
		$instance_id = isset($this->params['instance_id']) ? $this->params['instance_id'] : $this->instance_id;
		$res = $config->getWapPageLayoutConfig($instance_id);
		return $this->outMessage("获取", $res);
	}
	
	/**
	 * 获取首页魔方
	 */
	public function wapHomeMagicCube()
	{
		$config = new ConfigService();
		$instance_id = isset($this->params['instance_id']) ? $this->params['instance_id'] : $this->instance_id;
		$res = $config->getWapHomeMagicCubeConfig($instance_id);
		return $this->outMessage("获取首页魔方", $res);
	}
	
	/**
	 * 获取底部菜单
	 */
	public function bottomNav()
	{
		$config = new ConfigService();
		$data = $config->getWapBttomType($this->instance_id);
		$data = json_decode($data['template_data'], true);
		$show_page = explode(',', $data['showPage']);
		$show_page_n = '';
		foreach ($show_page as $k => $v) {
			if ($v) {
				$show_page_n .= __URL($v) . ',';
			}
		}
		$data['showPage'] = $show_page_n;
		return $this->outMessage('底部菜单', $data);
	}
	
	/**
	 * 版权
	 */
	public function copyRight()
	{
		$title = '底部加载';
		$upgrade = new Upgrade();
		$is_load = $upgrade->isLoadCopyRight();
		$website = new WebSite();
		$web_site_info = $website->getWebSiteInfo();
		$result = array(
			"is_load" => $is_load
		);
		$bottom_info = array();
		if ($is_load == 0) {
			$config = new ConfigService();
			$bottom_info = $config->getCopyrightConfig($this->instance_id);
		}
		if (!empty($web_site_info["web_icp"])) {
			$bottom_info['copyright_meta'] = $web_site_info["web_icp"];
		} else {
			$bottom_info['copyright_meta'] = '';
		}
		$bottom_info['web_gov_record'] = $web_site_info["web_gov_record"];
		$bottom_info['web_gov_record_url'] = $web_site_info["web_gov_record_url"];
		
		$result["bottom_info"] = $bottom_info;
		$result["default_logo"] = "/blue/img/logo.png";
		return $this->outMessage($title, $result);
	}
	
	/**
	 * 获取APP欢迎页配置
	 */
	public function getAppWelcomePageConfig()
	{
		$title = "获取App欢迎页配置";
		$config = new ConfigService();
		$res = $config->getAppWelcomePageConfig($this->instance_id);
		if (!empty($res['value']['welcome_page_picture'])) {
			if (strpos($res['value']['welcome_page_picture'], "http://") === false && strpos($res['value']['welcome_page_picture'], "https://") === false) {
				$res['value']['welcome_page_picture'] = getBaseUrl() . "/" . $res['value']['welcome_page_picture'];
			}
		}
		return $this->outMessage($title, $res['value']);
	}
	
	/**
	 * 获取最新版App信息
	 */
	public function getAppUpgradeInfo()
	{
		$title = "获取最新版App信息";
		$app_type = $this->get($this->params['app_type']);
		if (empty($app_type)) {
			return $this->outMessage($title, null, -1, "缺少字段app_type");
		}
		$config = new ConfigService();
		$res = $config->getLatestAppVersionInfo($app_type);
		if (!empty($res)) {
			if (!empty($res['download_address'])) {
				if (strpos($res['download_address'], "http://") === false && strpos($res['download_address'], "https://") === false) {
					$res['download_address'] = getBaseUrl() . "/" . $res['download_address'];
				}
			}
			return $this->outMessage($title, $res);
		} else {
			return $this->outMessage($title, null, -1, "暂无更新");
		}
	}
	
	/**
	 * 站点配置
	 */
	public function webSite()
	{
		$title = "获取站点配置";
		$web_config = new WebSite();
		$web_info = $web_config->getWebSiteInfo();
		return $this->outMessage($title, $web_info);
	}
	
	/**
	 * 通知配置
	 */
	public function noticeConfig()
	{
		$title = "查询通知是否开启";
		$web_config = new ConfigService();
		$noticeMobile = $web_config->getNoticeMobileConfig(0);
		$noticeEmail = $web_config->getNoticeEmailConfig(0);
		$notice['noticeEmail'] = $noticeEmail[0]['is_use'];
		$notice['noticeMobile'] = $noticeMobile[0]['is_use'];
		return $this->outMessage($title, $notice);
	}
	
	/**
	 * 虚拟商品配置
	 */
	public function virtualGoodsConfig()
	{
		$title = "查询虚拟商品配置";
		$web_config = new ConfigService();
		$is_open = $web_config->getIsOpenVirtualGoodsConfig(0);
		return $this->outMessage($title, $is_open);
	}
	
	/**
	 * 检测当前是否是微信浏览器
	 */
	public function isWeixin()
	{
		$is_weixin = isWeixin();
		return $this->outMessage("检测当前是否是微信浏览器", $is_weixin);
	}
	
}