<?php
/**
 * Member.php
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

use data\service\Config;
use think\Request;
use think\Session;
use think\Db;
use think\Model;
/**
 * 会员
 *
 *
 */
class Member extends BaseWap
{
	
	public $notice;
	
	public $login_verify_code;
	
	public function __construct()
	{
		parent::__construct();
		$this->checkLogin();
		// 是否开启验证码
		$web_config = new Config();
		$this->login_verify_code = $web_config->getLoginVerifyCodeConfig($this->instance_id);
		$this->assign("login_verify_code", $this->login_verify_code["value"]);
		// 是否开启通知
		$instance_id = 0;
		$noticeMobile = $web_config->getNoticeMobileConfig($instance_id);
		$noticeEmail = $web_config->getNoticeEmailConfig($instance_id);
		$this->notice['noticeEmail'] = $noticeEmail[0]['is_use'];
		$this->notice['noticeMobile'] = $noticeMobile[0]['is_use'];
		$this->assign("notice", $this->notice);
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
	 * 用户首页
	 */
	public function index()
	{
		$this->assign("title_before", "会员中心");
		return $this->view($this->style . 'member/index');
	}
	
	/**
	 * 会员地址管理
	 */
	public function address()
	{
		$this->assign('title', "收货地址");
		$this->assign("title_before", "收货地址");
		return $this->view($this->style . "member/address");
	}
	
	/**
	 * 编辑地址
	 */
	public function addressEdit()
	{
		if (!empty($_SESSION['address_pre_url'])) {
			$pre_url = $_SESSION['address_pre_url'];
		} else {
			$pre_url = '';
		}
		$this->assign("pre_url", $pre_url);
		$this->assign("title_before", "编辑收货地址");
		$this->assign('title', "编辑收货地址");
		return $this->view($this->style . "member/address_edit");
	}
	
	/**
	 * 店铺积分流水
	 */
	public function point()
	{
		$this->assign("title_before", "店铺积分流水");
		$this->assign('title', "店铺积分流水");
		return $this->view($this->style . 'member/point');
	}
	
	/**
	 * 会员余额
	 */
	public function balance()
	{
		$this->assign('title', "我的余额");
		$this->assign('title_before', "我的余额");
		return $this->view($this->style . 'member/balance');
	}
	
	/**
	 * 余额提现记录
	 */
	public function withdrawal()
	{
		$this->assign('title', "提现记录");
		$this->assign('title_before', "提现记录");
		return $this->view($this->style . 'member/withdrawal');
	}
	
	/**
	 * 会员优惠券
	 */
	public function coupon()
	{
		$this->assign('title', "我的优惠券");
		$this->assign('title_before', "我的优惠券");
		return $this->view($this->style . "member/coupon");
	}
	
	/**
	 * 会员个人资料主界面
	 */
	public function info()
	{
		$_SESSION['bund_pre_url'] = Request::instance()->domain() . $_SERVER['REQUEST_URI'];
		$this->assign('title', "个人资料");
		$this->assign('title_before', "个人资料");
		return $this->view($this->style . "member/info");
	}

	/**
	 * 会员申请开店页面 2019.4.22
	 */
	public function kaidian()
	{
		return $this->view($this->style . "member/kaidian");
	}
	/**
	 * 开店员佣金订单表
	 */
	public function user_shop()
	{
		return $this->view($this->style . "order/user_shop");
	}
	/**
	 * 开店员佣金订单表
	 */
	public function user_shopd()
	{
		return $this->view($this->style . "order/user_shopd");
	}	
	/**
	 * 开店员我的下级
	 */
	public function shop_user()
	{


		$users = Db::table('sys_user')->where(['par_id'=>$this->uid])->order("reg_time desc")->select();
		$this->assign('users', $users);
		return $this->view($this->style . "order/shop_user");
	}


	/**
	 * 会员申请开店页面
	 */
	public function kaidianshenqing()
	{
		$uid = $this->uid;
		$retval = 0;
		if (!empty($uid)) {
				Db::execute('update sys_user set user_shop_agree=1 where uid='.$uid);
		}
		return AjaxReturn($retval);	
	}	
	/**
	 * 开店员佣金转余额页面
	 */
	public function zhuan()
	{
		return $this->view($this->style . "member/user_shop_zhuan");
	}		
	/**
	 * 积分兑换余额
	 *
	 * @return \think\response\View
	 */
	public function exchange()
	{
		$this->assign('title', "积分兑换");
		$this->assign('title_before', "积分兑换");
		return $this->view($this->style . "member/exchange");
	}
	
	/**
	 * 账户列表
	 * 2017年3月13日10:52:59
	 */
	public function account()
	{
		$flag = request()->get('flag', 0); // 标识，1：从会员中心的提现账号进来，0：从申请提现进来
		$_SESSION['account_flag'] = $flag;
		$this->assign('flag', $flag);
		$this->assign('title', "我的账户列表");
		$this->assign('title_before', "我的账户列表");
		
		return $this->view($this->style . "member/account");
	}
	
	/**
	 * 编辑账户
	 * 2017年3月13日10:53:06
	 */
	public function accountEdit()
	{
		$this->assign('title', "编辑账户");
		$this->assign('title_before', "编辑账户");
		return $this->view($this->style . "member/account_edit");
	}
	
	/**
	 * 用户充值余额
	 */
	public function recharge()
	{
		$this->assign('title', "充值余额");
		$this->assign('title_before', "充值余额");
		return $this->view($this->style . "member/recharge");
	}
	
	/**
	 * 申请提现
	 */
	public function applyWithdrawal()
	{
		$this->assign('title', "申请提现");
		$this->assign('title_before', "申请提现");
		return $this->view($this->style . "member/apply_withdrawal");
	}
	
	
	/**
	 * 更改用户头像
	 */
	public function modifyFace()
	{
		$this->assign('title', "修改头像");
		$this->assign('title_before', "修改头像");
		$img_md5 = md5(time() . "niuku");
		session::set("niuku", $img_md5);
		$this->assign("niuku", $img_md5);
		return $this->view($this->style . "member/modify_face");
	}
	
	/**
	 * 我的收藏
	 */
	public function collection()
	{
		$this->assign('title', "我的收藏");
		$this->assign('title_before', "我的收藏");
		return $this->view($this->style . 'member/collection');
	}
	
	/**
	 * 我的足迹
	 */
	public function footprint()
	{
		$this->assign('title', "我的足迹");
		$this->assign('title_before', "我的足迹");
		return $this->view($this->style . "member/footprint");
	}
	
	/**
	 * 我的中奖记录
	 *
	 * @return \think\response\View
	 */
	public function winning()
	{
		$this->assign('title', "中奖记录");
		$this->assign('title_before', "中奖记录");
		return $this->view($this->style . "member/winning");
	}
	
	/**
	 * 领取奖品
	 */
	public function receivePrize()
	{
		$this->assign('title', "奖品领取");
		$this->assign('title_before', "奖品领取");
		return $this->view($this->style . "member/receive_prize");
	}
	
	public function bargain()
	{
		if (addon_is_exit('NsBargain') == 0) {
			return $this->error('未查找到该插件');
		}
		$this->assign('title', "我的砍价");
		$this->assign('title_before', "我的砍价");
		return $this->view($this->style . "member/bargain");
	}
	
	/**
	 * 图片上传
	 */
	public function uploadImage()
	{
		if (!empty($_FILES)) {
			$res = api("System.Upload.uploadImage", [ 'file_path' => "wap_member" ]);
			return json_encode($res['data']);
		}
	}
	
	/**
	 * 会员等级
	 */
	public function level()
	{
		$this->assign('title', "等级说明");
		$this->assign('title_before', "等级说明");
		return $this->view($this->style . "member/level");
	}
	
	/**
	 * 会员签到
	 */
	public function signIn()
	{
	    $this->assign('title', "签到有礼");
	    $this->assign("title_before", "签到有礼");
	    return $this->view($this->style . "member/signin");
	}
}