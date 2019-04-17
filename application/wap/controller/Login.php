<?php
/**
 * Login.php
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

use data\extend\ThinkOauth;
use data\extend\WchatOauth;
use data\service\Config as WebConfig;
use data\service\Member;
use data\service\promotion\PromoteRewardRule;
use data\service\WebSite;
use data\service\Weixin;
use think\Cookie;
use think\Session;
use data\service\Config;
use think\Log;

/**
 * 前台用户登录
 *
 * @author Administrator
 *
 */
class Login extends BaseWap
{
	
	// 验证码配置
	public $login_verify_code;
	
	public function __construct()
	{
		parent::__construct();
		$this->init();
	}
	
	public function init()
	{
		
		// 是否开启验证码
		$web_config = new WebConfig();
		$this->login_verify_code = $web_config->getLoginVerifyCodeConfig($this->instance_id);
		if (!isset($this->login_verify_code['value']['error_num'])) {
			$this->login_verify_code['value']['error_num'] = 0;
		}
		$this->assign("login_verify_code", $this->login_verify_code["value"]);
		
		// 是否开启qq跟微信
		$qq_info = $web_config->getQQConfig($this->instance_id);
		$Wchat_info = $web_config->getWchatConfig($this->instance_id);
		$this->assign("qq_info", $qq_info);
		$this->assign("Wchat_info", $Wchat_info);
		
		$seoconfig = $web_config->getSeoConfig($this->instance_id);
		$this->assign("seoconfig", $seoconfig);
	}
	
	/**
	 * 判断wap端是否开启
	 */
	public function determineWapWhetherToOpen()
	{
		$this->web_site = new WebSite();
		if ($this->web_info['wap_status'] == 3 && $this->web_info['web_status'] == 1) {
			Cookie::set("default_client", "web");
			$this->redirect(__URL(\think\Config::get('view_replace_str.SHOP_MAIN') . "/web"));
		} elseif ($this->web_info['wap_status'] == 2) {
			webClose($this->web_info['close_reason']);
		} elseif (($this->web_info['wap_status'] == 3 && $this->web_info['web_status'] == 3) || ($this->web_info['wap_status'] == 3 && $this->web_info['web_status'] == 2)) {
			webClose($this->web_info['close_reason']);
		}
	}
	
	/**
	 * 检测微信浏览器并且自动登录
	 */
	public function wchatLogin()
	{
		$this->determineWapWhetherToOpen();
		// 微信浏览器自动登录
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')) {
		    $config = new WebConfig();
		    $wchat_config = $config->getInstanceWchatConfig(0);
		    if (empty($wchat_config['value']['appid']) || empty($wchat_config['value']['appid'])) {
		        session('is_reload', 1);
		        $this->redirect(__URL(__URL__ . "/wap/login"));
		    }
		    
			if (empty($_SESSION['request_url'])) {
				$_SESSION['request_url'] = request()->url(true);
			}
			$domain_name = \think\Request::instance()->domain();
			if (!empty($_COOKIE[ $domain_name . "member_access_token" ])) {
				$token = json_decode($_COOKIE[ $domain_name . "member_access_token" ], true);
			} else {
				$wchat_oauth = new WchatOauth();
				$token = $wchat_oauth->get_member_access_token();
				if (!empty($token['access_token'])) {
					setcookie($domain_name . "member_access_token", json_encode($token));
				}
			}
			$wchat_oauth = new WchatOauth();
			if (!empty($token['openid'])) {
				if (!empty($token['unionid'])) {
					$wx_unionid = $token['unionid'];
					$retval = $this->user->wchatUnionLogin($wx_unionid);
					if ($retval == 1) {
						$this->user->refreshUserOpenid($token['openid'], $wx_unionid);
					} elseif ($retval == USER_LOCK) {
						$redirect = __URL(__URL__ . "/wap/login/lock");
						$this->redirect($redirect);
					} else {
						$retval = $this->user->wchatLogin($token['openid']);
						if ($retval == USER_NBUND) {
							$info = $wchat_oauth->get_oauth_member_info($token);
							
							$result = $this->user->registerMember('', '123456', '', '', '', '', $token['openid'], $info, $wx_unionid);
							if ($result) {
								// 注册成功送优惠券
								$Config = new WebConfig();
								$integralConfig = $Config->getIntegralConfig($this->instance_id);
								if ($integralConfig['register_coupon'] == 1) {
									$rewardRule = new PromoteRewardRule();
									$res = $rewardRule->getRewardRuleDetail($this->instance_id);
									if ($res['reg_coupon'] != 0) {
										$member = new Member();
										$member->memberGetCoupon($this->uid, $res['reg_coupon'], 2);
									}
								}
							}
						} elseif ($retval == USER_LOCK) {
							// 锁定跳转
							$redirect = __URL(__URL__ . "/wap/login/lock");
							$this->redirect($redirect);
						}
					}
				} else {
					$wx_unionid = '';
					$retval = $this->user->wchatLogin($token['openid']);
					if ($retval == USER_NBUND) {
						$info = $wchat_oauth->get_oauth_member_info($token);
						
						$result = $this->user->registerMember('', '123456', '', '', '', '', $token['openid'], $info, $wx_unionid);
						if ($result) {
							// 注册成功送优惠券
							$Config = new WebConfig();
							$integralConfig = $Config->getIntegralConfig($this->instance_id);
							if ($integralConfig['register_coupon'] == 1) {
								$rewardRule = new PromoteRewardRule();
								$res = $rewardRule->getRewardRuleDetail($this->instance_id);
								if ($res['reg_coupon'] != 0) {
									$member = new Member();
									$member->memberGetCoupon($this->uid, $res['reg_coupon'], 2);
								}
							}
						}
					} elseif ($retval == USER_LOCK) {
						// 锁定跳转
						$redirect = __URL(__URL__ . "/wap/login/lock");
						$this->redirect($redirect);
					}
				}
				
				if (!empty($_SESSION['login_pre_url'])) {
					$this->redirect($_SESSION['login_pre_url']);
				} else {
					$redirect = __URL(__URL__ . "/wap/member");
					$this->redirect($redirect);
				}
			}
		}
	}
	
	/**
	 * 登录界面
	 *
	 * @return array|int|\multitype|\think\response\View
	 */
	public function index()
	{
		if (request()->isAjax()) {
			$token = request()->post('token', "");
			if (!empty($token)) {
				session("niu_access_token", $token);
				$member_detail = api("System.Member.memberDetail");
				if ($member_detail['code'] == 0) {
					session("niu_member_detail", $member_detail['data']);
					return 1;
				} else {
					return 0;
				}
			}
		} else {
		    Session('is_reload', null);
			return $this->view($this->style . 'login/login');
		}
	}
	
	/**
	 * 微信绑定用户
	 */
	public function wchatBindMember($user_name, $password, $bind_message_info)
	{
		session::set("member_bind_first", null);
		if (!empty($bind_message_info)) {
			$config = new WebConfig();
			$register_and_visit = $config->getRegisterAndVisit(0);
			$register_config = json_decode($register_and_visit['value'], true);
			if (!empty($register_config) && $register_config["is_requiretel"] == 1 && $bind_message_info["is_bind"] == 1 && !empty($bind_message_info["token"])) {
				$token = $bind_message_info["token"];
				if (!empty($token['openid'])) {
					$this->user->updateUserWchat($user_name, $password, $token['openid'], $bind_message_info['info'], $bind_message_info['wx_unionid']);
					// 拉取用户头像
					$uid = $this->user->getCurrUserId();
					$url = str_replace('api.php', 'index.php', __URL(__URL__ . 'wap/login/updateUserImg?uid=' . $uid . '&type=wchat'));
					http($url, 1);
				}
			}
		}
	}
	
	/**
	 * 第三方登录登录
	 */
	public function oauthLogin()
	{
		$config = new WebConfig();
		$type = request()->get('type', '');
		if ($type == "WCHAT") {
			$config_info = $config->getWchatConfig($this->instance_id);
			if (empty($config_info["value"]["APP_KEY"]) || empty($config_info["value"]["APP_SECRET"])) {
				$this->error("当前系统未设置微信第三方登录!");
			}
			if (isWeixin()) {
				$this->wchatLogin();
				if (!empty($_SESSION['login_pre_url'])) {
					$this->redirect($_SESSION['login_pre_url']);
				} else {
					$redirect = __URL(__URL__ . "/wap/member/index");
					$this->redirect($redirect);
				}
			}
		} else if ($type == "QQLOGIN") {
			$config_info = $config->getQQConfig($this->instance_id);
			if (empty($config_info["value"]["APP_KEY"]) || empty($config_info["value"]["APP_SECRET"])) {
				$this->error("当前系统未设置QQ第三方登录!");
			}
		}
		$_SESSION['login_type'] = $type;
		
		$test = ThinkOauth::getInstance($type);
		$this->redirect($test->getRequestCodeURL());
	}
	
	/**
	 * qq登录返回
	 */
	public function callback()
	{
		$code = request()->get('code', '');
		if (empty($code))
			die();
		// 获取注册配置
		$webconfig = new WebConfig();
		$shop_id = 0;
		$register_and_visit = $webconfig->getRegisterAndVisit($shop_id);
		$register_config = json_decode($register_and_visit['value'], true);
		$loginBind = request()->get("loginBind", "");
		
		if ($_SESSION['login_type'] == 'QQLOGIN') {
			$qq = ThinkOauth::getInstance('QQLOGIN');
			$token = $qq->getAccessToken($code);
			if (!empty($token['openid'])) {
				if (!empty($_SESSION['bund_pre_url'])) {
					// 1.检测当前qqopenid是否已经绑定，如果已经绑定直接返回绑定失败
					$bund_pre_url = $_SESSION['bund_pre_url'];
					$_SESSION['bund_pre_url'] = '';
					$is_bund = $this->user->checkUserQQopenid($token['openid']);
					if ($is_bund == 0) {
						// 2.绑定操作
						$qq = ThinkOauth::getInstance('QQLOGIN', $token);
						$data = $qq->call('user/get_user_info');
						$_SESSION['qq_info'] = json_encode($data);
						// 执行用户信息更新user服务层添加更新绑定qq函数（绑定，解绑）
						$res = $this->user->bindQQ($token['openid'], json_encode($data));
						// 如果执行成功执行跳转
						
						if ($res) {
							$this->success('绑定成功', $bund_pre_url);
						} else {
							$this->error('绑定失败', $bund_pre_url);
						}
					} else {
						$this->error('该qq已经绑定', $bund_pre_url);
					}
				} else {
					$retval = $this->user->qqLogin($token['openid']);
					// 已经绑定
					if ($retval == 1) {
						if (!empty($_SESSION['login_pre_url'])) {
							$this->redirect($_SESSION['login_pre_url']);
						} else {
							if (request()->isMobile()) {
								$redirect = __URL(__URL__ . "/wap/member/index");
							} else {
								$redirect = __URL(__URL__ . "/member/index");
							}
							$this->redirect($redirect);
						}
					}
					if ($retval == USER_NBUND) {
						$qq = ThinkOauth::getInstance('QQLOGIN', $token);
						$data = $qq->call('user/get_user_info');
						$_SESSION['qq_info'] = json_encode($data);
						$_SESSION['qq_openid'] = $token['openid'];
						
						if ($register_config["is_requiretel"] == 1 && empty($loginBind)) {
							if (request()->isMobile()) {
								$this->redirect(__URL(__URL__ . "/wap/login/register_ext"));
							} else {
								$this->redirect(__URL(__URL__ . "/web/login/register_ext"));
							}
						}
						
						$result = $this->user->registerMember('', '123456', '', '', $token['openid'], json_encode($data), '', '', '');
						if ($result > 0) {
							// 注册成功送优惠券
							$Config = new WebConfig();
							$integralConfig = $Config->getIntegralConfig($this->instance_id);
							if ($integralConfig['register_coupon'] == 1) {
								$rewardRule = new PromoteRewardRule();
								$res = $rewardRule->getRewardRuleDetail($this->instance_id);
								if ($res['reg_coupon'] != 0) {
									$member = new Member();
									$retval = $member->memberGetCoupon($result, $res['reg_coupon'], 2);
								}
							}
							if (!empty($_SESSION['login_pre_url'])) {
								$this->redirect($_SESSION['login_pre_url']);
							} else {
								if (request()->isMobile()) {
									$redirect = __URL(__URL__ . "/wap/member/index");
								} else {
									$redirect = __URL(__URL__ . "/member/index");
								}
							}
							$this->redirect($redirect);
						}
					}
				}
			}
		} elseif ($_SESSION['login_type'] == 'WCHAT') {
			$wchat = ThinkOauth::getInstance('WCHAT');
			$token = $wchat->getAccessToken($code);
			if (!empty($token['unionid'])) {
				$retval = $this->user->wchatUnionLogin($token['unionid']);
				
				// 已经绑定
				if ($retval == 1) {
					if (!empty($_SESSION['login_pre_url'])) {
						$this->redirect($_SESSION['login_pre_url']);
					} else {
						if (request()->isMobile()) {
							$redirect = __URL(__URL__ . "/wap/member/index");
						} else {
							$redirect = __URL(__URL__ . "/member/index");
						}
						$this->redirect($redirect);
					}
				}
			}
			if ($retval == USER_NBUND) {
				// 2.绑定操作
				$wchat = ThinkOauth::getInstance('WCHAT', $token);
				$data = $wchat->call('sns/userinfo');
				
				$_SESSION['wx_info'] = json_encode($data);
				$_SESSION['wx_unionid'] = $token['unionid'];
				
				if ($register_config["is_requiretel"] == 1 && empty($loginBind)) {
					if (request()->isMobile()) {
						$this->redirect(__URL(__URL__ . "/wap/login/register_ext"));
					} else {
						$this->redirect(__URL(__URL__ . "/web/login/register_ext"));
					}
				} else {
					$result = $this->user->registerMember('', '123456', '', '', '', '', '', json_encode($data), $token['unionid']);
				}
				
				if ($result > 0) {
					// 注册成功送优惠券
					$Config = new WebConfig();
					$integralConfig = $Config->getIntegralConfig($this->instance_id);
					if ($integralConfig['register_coupon'] == 1) {
						$rewardRule = new PromoteRewardRule();
						$res = $rewardRule->getRewardRuleDetail($this->instance_id);
						if ($res['reg_coupon'] != 0) {
							$member = new Member();
							$retval = $member->memberGetCoupon($result, $res['reg_coupon'], 2);
						}
					}
					if (!empty($_SESSION['login_pre_url'])) {
						$this->redirect($_SESSION['login_pre_url']);
					} else {
						if (request()->isMobile()) {
							$redirect = __URL(__URL__ . "/wap/member/index");
						} else {
							$redirect = __URL(__URL__ . "/member/index");
						}
						$this->redirect($redirect);
					}
				}
			}
		}
	}
	
	/**
	 * 微信授权登录返回
	 */
	public function wchatCallBack()
	{
		$code = request()->get('code', '');
		if (empty($code))
			die();
		$wchat = ThinkOauth::getInstance('WCHATLOGIN');
		$token = $wchat->getAccessToken($code);
		$wchat = ThinkOauth::getInstance('WCHATLOGIN', $token);
		$data = $wchat->call('/sns/userinfo');
		var_dump($data);
	}
	
	/**
	 * 注册账户
	 */
	public function register()
	{
		$config = new Config();
		$reg_config_info = $config->getRegisterAndVisit(0);
		$reg_config = json_decode($reg_config_info["value"], true);
		if (trim($reg_config['register_info']) == "" || $reg_config['is_register'] == 0) {
			$this->error("抱歉,商城暂未开放注册!");
		}
		return $this->view($this->style . 'login/register');
	}
	
	/**
	 * 完善信息
	 *
	 * @return \think\response\View
	 */
	public function registerExt()
	{
		$this->assign("title", "完善信息");
		$this->assign("title_before", "完善信息");
		return $this->view($this->style . "login/register_ext");
	}
	
	/**
	 * 注册后登陆
	 */
	public function registerLogin()
	{
		if (request()->isAjax()) {
			$username = request()->post('username', '');
			$mobile = request()->post('mobile', '');
			$password = request()->post('password', '');
			if (!empty($username)) {
				$res = $this->user->login($username, $password);
			} else {
				$res = $this->user->login($mobile, $password);
			}
			$_SESSION['order_tag'] = ""; // 清空订单
			if ($res > 0) {
				if (!empty($_SESSION['login_pre_url'])) {
					$this->redirect($_SESSION['login_pre_url']);
				} else {
					
					$redirect = __URL(__URL__ . "/member/index");
					$this->redirect($redirect);
				}
			}
		}
	}
	
	/**
	 * 制作推广二维码
	 */
	function showUserQrcode()
	{
		$uid = request()->get('uid', 0);
		if (!is_numeric($uid)) {
			$this->error('无法获取到会员信息');
		}
		$instance_id = $this->instance_id;
		// 读取生成图片的位置配置
		$weixin = new Weixin();
		$data = $weixin->getWeixinQrcodeConfig($instance_id, $uid);
		$member_info = $this->user->getUserInfoByUid($uid);
		// 获取所在店铺信息
		$web = new WebSite();
		$shop_info = $web->getWebDetail();
		$shop_logo = $shop_info["logo"];
		
		// 查询并生成二维码
		$path = 'upload/qrcode/' . 'qrcode_' . $uid . '_' . $instance_id . '.png';
		
		if (!file_exists($path)) {
			$weixin = new Weixin();
			$url = $weixin->getUserWchatQrcode($uid, $instance_id);
			if ($url == WEIXIN_AUTH_ERROR) {
				exit();
			} else {
				getQRcode($url, 'upload/qrcode', "qrcode_" . $uid . '_' . $instance_id);
			}
		}
		// 定义中继二维码地址
		$thumb_qrcode = 'upload/qrcode/thumb_' . 'qrcode_' . $uid . '_' . $instance_id . '.png';
		$image = \think\Image::open($path);
		// 生成一个固定大小为360*360的缩略图并保存为thumb_....jpg
		$image->thumb(288, 288, \think\Image::THUMB_CENTER)->save($thumb_qrcode);
		// 背景图片
		$dst = $data["background"];
		if (!file_exists($dst)) {
			$dst = "public/static/images/qrcode_bg/qrcode_user_bg.png";
		}
		// 生成画布
		list ($max_width, $max_height) = getimagesize($dst);
		$dests = imagecreatetruecolor($max_width, $max_height);
		$dst_im = getImgCreateFrom($dst);
		imagecopy($dests, $dst_im, 0, 0, 0, 0, $max_width, $max_height);
		imagedestroy($dst_im);
		// 并入二维码
		// $src_im = imagecreatefrompng($thumb_qrcode);
		$src_im = getImgCreateFrom($thumb_qrcode);
		$src_info = getimagesize($thumb_qrcode);
		imagecopy($dests, $src_im, $data["code_left"] * 2, $data["code_top"] * 2, 0, 0, $src_info[0], $src_info[1]);
		imagedestroy($src_im);
		// 并入用户头像
		$user_headimg = $member_info["user_headimg"];
		// $user_headimg = "upload/user/1493363991571.png";
		if (!file_exists($user_headimg)) {
			$user_headimg = "public/static/images/qrcode_bg/head_img.png";
		}
		$src_im_1 = getImgCreateFrom($user_headimg);
		$src_info_1 = getimagesize($user_headimg);
		// imagecopy($dests, $src_im_1, $data['header_left'] * 2, $data['header_top'] * 2, 0, 0, $src_info_1[0], $src_info_1[1]);
		imagecopyresampled($dests, $src_im_1, $data['header_left'] * 2, $data['header_top'] * 2, 0, 0, 80, 80, $src_info_1[0], $src_info_1[1]);
		// imagecopy($dests, $src_im_1, $data['header_left'] * 2, $data['header_top'] * 2, 0, 0, $src_info_1[0], $src_info_1[1]);
		imagedestroy($src_im_1);
		
		// 并入网站logo
		if ($data['is_logo_show'] == '1') {
			// $shop_logo = $shop_logo;
			if (!file_exists($shop_logo)) {
				$shop_logo = "public/static/images/logo.png";
			}
			$src_im_2 = getImgCreateFrom($shop_logo);
			$src_info_2 = getimagesize($shop_logo);
			imagecopy($dests, $src_im_2, $data['logo_left'] * 2, $data['logo_top'] * 2, 0, 0, $src_info_2[0], $src_info_2[1]);
			imagedestroy($src_im_2);
		}
		// 并入用户姓名
		$rgb = hColor2RGB($data['nick_font_color']);
		$bg = imagecolorallocate($dests, $rgb['r'], $rgb['g'], $rgb['b']);
		$name_top_size = $data['name_top'] * 2 + $data['nick_font_size'];
		@imagefttext($dests, $data['nick_font_size'], 0, $data['name_left'] * 2, $name_top_size, $bg, "public/static/font/Microsoft.ttf", $member_info["nick_name"]);
		header("Content-type: image/jpeg");
		imagejpeg($dests);
	}
	
	/**
	 * 制作店铺二维码
	 */
	function showShopQrcode()
	{
		$uid = request()->get('uid', 0);
		if (!is_numeric($uid)) {
			$this->error('无法获取到会员信息');
		}
		$instance_id = $this->instance_id;
		if ($instance_id == 0) {
			$url = __URL(__URL__ . '/wap?source_uid=' . $uid);
		} else {
			$url = __URL(__URL__ . '/wap/web/index?shop_id=' . $instance_id . '&source_uid=' . $uid);
		}
		// 查询并生成二维码
		$path = 'upload/qrcode/' . 'shop_' . $uid . '_' . $instance_id . '.png';
		if (!file_exists($path)) {
			getQRcode($url, 'upload/qrcode', "shop_" . $uid . '_' . $instance_id);
		}
		
		// 定义中继二维码地址
		$thumb_qrcode = 'upload/qrcode/thumb_shop_' . 'qrcode_' . $uid . '_' . $instance_id . '.png';
		$image = \think\Image::open($path);
		// 生成一个固定大小为360*360的缩略图并保存为thumb_....jpg
		$image->thumb(260, 260, \think\Image::THUMB_CENTER)->save($thumb_qrcode);
		// 背景图片
		$dst = "public/static/images/qrcode_bg/shop_qrcode_bg.png";
		
		// $dst = "http://pic107.nipic.com/file/20160819/22733065_150621981000_2.jpg";
		// 生成画布
		list ($max_width, $max_height) = getimagesize($dst);
		$dests = imagecreatetruecolor($max_width, $max_height);
		$dst_im = getImgCreateFrom($dst);
		// if (substr($dst, - 3) == 'png') {
		// $dst_im = imagecreatefrompng($dst);
		// } elseif (substr($dst, - 3) == 'jpg') {
		// $dst_im = imagecreatefromjpeg($dst);
		// }
		imagecopy($dests, $dst_im, 0, 0, 0, 0, $max_width, $max_height);
		imagedestroy($dst_im);
		// 并入二维码
		// $src_im = imagecreatefrompng($thumb_qrcode);
		$src_im = getImgCreateFrom($thumb_qrcode);
		$src_info = getimagesize($thumb_qrcode);
		imagecopy($dests, $src_im, "94px" * 2, "170px" * 2, 0, 0, $src_info[0], $src_info[1]);
		imagedestroy($src_im);
		// 获取所在店铺信息
		
		$web = new WebSite();
		$shop_info = $web->getWebDetail();
		$shop_logo = $shop_info["logo"];
		$shop_name = $shop_info["title"];
		$shop_phone = $shop_info["web_phone"];
		$live_store_address = $shop_info["web_address"];
		
		// logo
		if (!file_exists($shop_logo)) {
			$shop_logo = "public/static/images/logo.png";
		}
		// if (substr($shop_logo, - 3) == 'png') {
		// $src_im_2 = imagecreatefrompng($shop_logo);
		// } elseif (substr($shop_logo, - 3) == 'jpg') {
		// $src_im_2 = imagecreatefromjpeg($shop_logo);
		// }
		$src_im_2 = getImgCreateFrom($shop_logo);
		$src_info_2 = getimagesize($shop_logo);
		imagecopy($dests, $src_im_2, "10px" * 2, "380px" * 2, 0, 0, $src_info_2[0], $src_info_2[1]);
		imagedestroy($src_im_2);
		// 并入用户姓名
		$rgb = hColor2RGB("#333333");
		$bg = imagecolorallocate($dests, $rgb['r'], $rgb['g'], $rgb['b']);
		$name_top_size = "430px" * 2 + "23";
		@imagefttext($dests, 23, 0, "10px" * 2, $name_top_size, $bg, "public/static/font/Microsoft.ttf", "店铺名称：" . $shop_name);
		@imagefttext($dests, 23, 0, "10px" * 2, $name_top_size + 50, $bg, "public/static/font/Microsoft.ttf", "电话号码：" . $shop_phone);
		@imagefttext($dests, 23, 0, "10px" * 2, $name_top_size + 100, $bg, "public/static/font/Microsoft.ttf", "店铺地址：" . $live_store_address);
		header("Content-type: image/jpeg");
		ob_clean();
		imagejpeg($dests);
	}
	
	/**
	 * 获取微信推广二维码
	 */
	public function qrcode()
	{
		$this->determineWapWhetherToOpen();
		$uid = request()->get('source_uid', 0);
		$this->assign('source_uid', $uid);
		if (!is_numeric($uid)) {
			$this->error('无法获取到会员信息');
		}
		
		$share_contents = $this->getShareContents($uid, 0, 'qrcode_my', '');
		$this->assign("share_contents", $share_contents);
		
		// 分享
		$ticket = $this->getShareTicket();
		$this->assign("signPackage", $ticket);
		
		$this->assign("title", '我的推广码');
		$this->assign("title_before", "我的推广码");
		return $this->view($this->style . "login/qrcode");
	}
	
	/**
	 * 生成个人店铺二维码
	 */
	public function QrcodeShop()
	{
		$this->determineWapWhetherToOpen();
		$uid = request()->get('source_uid', 0);
		$this->assign('source_uid', $uid);
		if (!is_numeric($uid)) {
			$this->error('无法获取到会员信息');
		}
		$share_contents = $this->getShareContents($uid, 0, 'qrcode_shop', '');
		$weisite = new WebSite();
		$weisite_info = $weisite->getWebSiteInfo();
		$info["logo"] = $weisite_info["logo"];
		$info["shop_name"] = $weisite_info["title"];
		$info["phone"] = $weisite_info["web_phone"];
		$info["address"] = $weisite_info["web_address"];
		$this->assign("info", $info);
		// 分享
		$ticket = $this->getShareTicket();
		$this->assign("share_contents", $share_contents);
		$this->assign("signPackage", $ticket);
		$this->assign("title", '店铺二维码');
		$this->assign("title_before", "店铺二维码");
		return $this->view($this->style . "login/qrcode_shop");
	}
	
	/**
	 * 获取分享相关票据
	 */
	public function getShareTicket()
	{
		// 获取票据
		if (isWeixin()) {
			//针对单店版获取微信票据
			$signPackage = api('System.Wchat.getShareTicket');
			$signPackage = $signPackage['data'];
			return $signPackage;
		} else {
			$signPackage = array(
				'appId' => '',
				'jsTimesTamp' => '',
				'jsNonceStr' => '',
				'ticket' => '',
				'jsSignature' => ''
			);
			return $signPackage;
		}
	}
	
	/**
	 * 用户锁定界面
	 *
	 * @return \think\response\View
	 */
	public function lock()
	{
		$this->assign("title", lang('user_locked'));
		$this->assign("title_before", lang('user_locked'));
		return $this->view($this->style . "login/lock");
	}
	
	/**
	 * http://b2c.niushop.com.cn/wap/login/appLogin?user_name=admin2017&password=123456789
	 *
	 * app 登陆
	 */
	public function appLogin()
	{
		$username = request()->post('user_name', '');
		$password = request()->post('password', '');
		$res = $this->user->login($username, $password);
		if ($res > 0) {
			if (!empty($_SESSION['login_pre_url'])) {
				$this->redirect($_SESSION['login_pre_url']);
			} else {
				$redirect = __URL(__URL__ . "/member/index");
				$this->redirect($redirect);
			}
		}
	}
	
	public function find()
	{
		$this->assign("title", '忘记密码');
		$this->assign("title_before", "忘记密码");
		return $this->view($this->style . "login/find");
	}
	
	/**
	 * 绑定账号
	 *
	 * @return \think\response\View
	 */
	public function bind()
	{
		$this->assign("title", "绑定账号");
		$this->assign("title_before", "绑定账号");
		return $this->view($this->style . "Login/bind");
	}
	
	/**
	 * 更新会员头像
	 */
	public function updateUserImg()
	{
	    $uid = request()->get('uid', '');
	    $type = request()->get('type', 'wchat');
	    $retval = $this->user->updateUserImg($uid, $type);
	    return $retval;
	}
}