<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:37:"template/wap\default\login\login.html";i:1554098906;s:54:"D:\phpStudy\WWW\niushop\template\wap\default\base.html";i:1553848818;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta name="renderer" content="webkit"/>
	<meta http-equiv="X-UA-COMPATIBLE" content="IE=edge,chrome=1"/>
	<meta content="text/html; charset=UTF-8">
	<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<?php 
	$seoconfig = api("System.Config.seo", []);
	$seoconfig = $seoconfig['data'];
	 ?>
	<title><?php if($title_before != ''): ?><?php echo $title_before; ?>&nbsp;-&nbsp;<?php endif; ?><?php echo $platform_shopname; if($seoconfig['seo_title'] != ''): ?>-<?php echo $seoconfig['seo_title']; endif; ?></title>
	<meta name="keywords" content="<?php echo $seoconfig['seo_meta']; ?>"/>
	<meta name="description" content="<?php echo $seoconfig['seo_desc']; ?>"/>
	<link rel="shortcut icon" type="image/x-icon" href="/public/static/images/favicon.ico" media="screen"/>
	<link type="text/css" rel="stylesheet" href="/public/static/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="/template/wap/default/public/css/normalize.css"/>
	<link rel="stylesheet" href="/template/wap/default/public/plugin/mzui/css/mzui.css"/>
	<link rel="stylesheet" href="/template/wap/default/public/plugin/mescroll/css/mescroll.css"/>
	<link rel="stylesheet" href="/template/wap/default/public/css/common.css"/>
	<link type="text/css" rel="stylesheet" href="/template/wap/default/public/css/theme.css">
	<script src="/template/wap/default/public/plugin/mzui/lib/jquery/jquery-3.2.1.min.js"></script>
	<script src="/template/wap/default/public/plugin/mzui/js/mzui.js"></script>
	<script src="/template/wap/default/public/plugin/mescroll/js/mescroll.js"></script>
	<script src="/public/static/js/jquery.cookie.js"></script>
	<script src="/template/wap/default/public/js/common.js"></script>
	<script>
		var APPMAIN = 'http://127.0.0.1:8080/index.php/wap';
		var SHOPMAIN = "http://127.0.0.1:8080/index.php";
		var STATIC = "/public/static";
		var WAPIMG = "/template/wap/default/public/img";
		var WAPPLUGIN = "/template/wap/default/public/plugin";
		var UPLOAD = "";
		var DEFAULT_HEAD_IMG = "<?php echo $default_headimg; ?>";
		var uid = "<?php echo $uid; ?>";
	</script>
	
<link rel="stylesheet" href="/template/wap/default/public/css/login.css">

</head>
<body>
<?php 
	//默认图片
	$default_images = api("System.Config.defaultImages");
	$default_images = $default_images['data'];
	$default_goods_img = $default_images["value"]["default_goods_img"];//默认商品图片
	$default_headimg = $default_images["value"]["default_headimg"];//默认用户头像
 
	$wap_login_info = api("System.Login.loginConfig");
	$wap_login_info = $wap_login_info['data'];
	$wap_login_info['login_count'] = 0;
	if($wap_login_info['login_config']['qq_login_config']['is_use'] == 1) {
		$wap_login_info['login_count'] += 1;
	}
		 
	if($wap_login_info['login_config']['wchat_login_config']['is_use'] == 1) {
		$wap_login_info['login_count'] += 1;
	}
		
 ?>
<div class="content">
	<div class="log-wp">
	<div class="title ns-text-color-black js-login-type">账号登录</div>
		<div class="log-box">
			<div id="nk_text1">
				<div class="log-cont">
					<label class="log-txt" for="username">
						<span class="username"><?php echo lang("account_number"); ?></span>
						<input type="text" name="username" id="username" placeholder="<?php echo lang("enter_your_account_number"); ?>">
					</label>
				</div>
				<div class="log-cont">
					<label for="password"><span class="password"><?php echo lang("password"); ?></span>
					<input type="password" name="password" id="password" placeholder="<?php echo lang("please_input_password"); ?>">
					</label>
				</div>
				<?php if($wap_login_info['code_config']['value']['pc'] == 1): ?>
				<div class="log-cont">
					<label class="login-captcha">
						<span class="captcha-code">验证码</span>
						<input type="text" id="login_captcha" name="captcha" placeholder="请输入验证码" maxlength="4">
						<div class="verify">
							<img class="verifyimg" src="<?php echo __URL('http://127.0.0.1:8080/index.php/captcha'); ?>" onclick="this.src='<?php echo __URL('http://127.0.0.1:8080/index.php/captcha'); ?>'" alt="captcha">
						</div>
					</label>
				</div>
				<?php endif; ?>
				<button type="button" class="lang-btn primary" onclick="check()" ><?php echo lang("login"); ?></button>
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/register'); ?>">
					<button class="lang-btn ns-border-color ns-text-color register-immediately"><?php echo lang("register_immediately"); ?></button>
				</a>
			</div>
			<div id="nk_text2">
				<div class="nk-cont">
					<label> <?php echo lang("cell_phone_number"); ?>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="mobile" name="mobile" placeholder="<?php echo lang("please_enter_your_cell_phone_number"); ?>">
					</label>
				</div>
				<?php if($wap_login_info['code_config']['value']['pc'] == 1): ?>
				<div class="nk-cont">
					<label> <?php echo lang("member_verification_code"); ?>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="captcha" name="captcha" placeholder="<?php echo lang("please_enter_verification_code"); ?>">
					    <div class="verify"><img class="verifyimg" src=" <?php echo __URL('http://127.0.0.1:8080/index.php/captcha'); ?>" onclick="this.src='<?php echo __URL('http://127.0.0.1:8080/index.php/captcha'); ?>'"  alt="captcha" /></div>
					</label>
				</div>
				<?php endif; ?>
				<div class="nk-cont">
					<label><?php echo lang("dynamic_code"); ?>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="sms_captcha" name="sms_captcha" placeholder="<?php echo lang("please_enter_the_dynamic_code"); ?>">
						<input type="button" id="sendOutCode" class="ns-text-color ns-border-color" onclick="sendOutCode()" value="<?php echo lang("get_dynamic_code"); ?>">
					</label>
				</div>
				<input type="hidden" id="mobile_is_has" value="1">
				<button class="lang-btn primary" onclick="check_mobile()"><?php echo lang("login"); ?></button>
				<a class="lang-btn register-immediately ns-border-color ns-text-color " class="lang-btn"  href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/register'); ?>"><?php echo lang("register_immediately"); ?></a>

			</div>
			<div class="msg cl">
			    <a href="javascript:;" class="" id="msgback">忘记密码？</a>
			    <a href="javascript:;" class="" onclick="loginType(this, 1)" id="account_login">账号登录</a>
			    <?php if($wap_login_info['login_config']['mobile_config']['is_use'] == 1): ?>
			    <a href="javascript:;" class="" onclick="loginType(this, 2)" id="mobile_login">手机动态码登录</a>
			    <?php endif; ?>
			    <div class="clear"></div>
			</div>
			
		<?php if($wap_login_info['login_count'] != 0): ?>
		<div class="other-account">使用以下账号登录</div>
		<?php endif; if($wap_login_info['login_config']['qq_login_config']['is_use'] != 1): ?>
		<div>
			<?php if($wap_login_info['login_config']['qq_login_config']['is_use'] == 1): ?>
			<div class="<?php if($wap_login_info['login_count'] == 1): ?>login-wei<?php elseif($wap_login_info['login_count'] == 2): ?>login-wei-two<?php elseif($wap_login_info['login_count'] == 3): ?>login-wei-three<?php endif; ?>">
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/oauthlogin?type=QQLOGIN'); ?>">
					<img src="/template/wap/default/public/img/login/qq.png"/>
				</a>
			</div>
			<?php endif; if($wap_login_info['login_config']['wchat_login_config']['is_use'] == 1): ?>
			<div class="<?php if($wap_login_info['login_count'] == 1): ?>login-wei<?php elseif($wap_login_info['login_count'] == 2): ?>login-wei-two<?php else: ?>login-wei-three<?php endif; ?> login-wei-pic">
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/oauthlogin?type=WCHAT'); ?>" class="dis-bk">
					<img src="/template/wap/default/public/img/login/weixin.png"/><br/>
				</a>
			</div>
			<?php endif; ?>
			<div class="<?php if($wap_login_info['login_count'] == 1): ?>login-wei<?php elseif($wap_login_info['login_count'] == 2): ?>login-wei-two<?php elseif($wap_login_info['login_count'] == 3): ?>login-wei-three<?php endif; ?> dis-no">
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/wchatOauth'); ?>">
					<img src="/template/wap/default/public/img/login/weibo.png"/>
				</a>
			</div>
		</div>
		<?php elseif($wap_login_info['login_config']['wchat_login_config']['is_use'] != 1): ?>
		<div>
			<?php if($wap_login_info['login_config']['qq_login_config']['is_use'] == 1): ?>
			<div class="<?php if($wap_login_info['login_count'] == 1): ?>login-wei<?php elseif($wap_login_info['login_count'] == 2): ?>login-wei-two<?php elseif($wap_login_info['login_count'] == 3): ?>login-wei-three<?php endif; ?> login-wei-pic">
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/oauthlogin?type=QQLOGIN'); ?>" class="dis-bk">
				<img src="/template/wap/default/public/img/login/qq.png"/><br/>
				</a>
			</div>
			<?php endif; if($wap_login_info['login_config']['wchat_login_config']['is_use'] == 1): ?>
			<div class="<?php if($wap_login_info['login_count'] == 1): ?>login-wei<?php elseif($wap_login_info['login_count'] == 2): ?>login-wei-two<?php else: ?>login-wei-three<?php endif; ?>">
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/oauthlogin?type=WCHAT'); ?>">
					<img src="/template/wap/default/public/img/login/weixin.png" />
				</a>
			</div>
			<?php endif; ?>
			<div class="<?php if($wap_login_info['login_count'] == 1): ?>login-wei<?php elseif($wap_login_info['login_count'] == 2): ?>login-wei-two<?php elseif($wap_login_info['login_count'] == 3): ?>login-wei-three<?php endif; ?> dis-no">
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/wchatOauth'); ?>">
					<img src="/template/wap/default/public/img/login/weibo.png"/>
				</a>
			</div>
			
		</div>
		<?php else: ?>
		<div class="login-mode">
			<?php if($wap_login_info['login_config']['qq_login_config']['is_use'] == 1): ?>
			<div class="<?php if($wap_login_info['login_count'] == 1): ?>login-wei<?php elseif($wap_login_info['login_count'] == 2): ?>login-wei-two<?php else: ?>login-wei-three<?php endif; ?>">
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/oauthlogin?type=QQLOGIN'); ?>">
				<img src="/template/wap/default/public/img/login/qq.png"/>
				</a>
			</div>
			<?php endif; if($wap_login_info['login_config']['wchat_login_config']['is_use'] == 1): ?>
			<div class="<?php if($wap_login_info['login_count'] == 1): ?>login-wei<?php elseif($wap_login_info['login_count'] == 2): ?>login-wei-two<?php else: ?>login-wei-three<?php endif; ?>">
				<?php if($wap_login_info['is_wechat_browser']): ?>
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/oauthlogin?type=WCHAT'); ?>">
				<?php else: ?>
				<a href="javascript:;" onclick="toast('请在微信浏览器中进行此操作！');">
				<?php endif; ?>
					<img src="/template/wap/default/public/img/login/weixin.png" />
				</a>
			</div>
			<?php endif; ?>
		
			<div class="<?php if($wap_login_info['login_count'] == 1): ?>login-wei<?php elseif($wap_login_info['login_count'] == 2): ?>login-wei-two<?php elseif($wap_login_info['login_count'] == 3): ?>login-wei-three<?php endif; ?> dis-no" >
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/oauthlogin?type=WCHAT'); ?>">
					<img src="/template/wap/default/public/img/login/weibo.png"/>
				</a>
			</div>
		</div>
		<?php endif; ?>
		</div>
	</div>
	
	<div class="footer" id="login_copyright">
		<div class="copyright">
			<div class="ft-copyright">
				<a href="http://www.niushop.com.cn" target="_blank" >山西牛酷信息科技有限公司&nbsp;提供技术支持</a>
			</div>
		</div>
	</div>
	<!-- 找回密码弹窗 -->
	<div id="mask-layer-login" class="forget-password"></div>
	<div class="findback" id="layui-layer" type="page" times="100002" contype="string">
		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/Login/find','type=1'); ?>"><img src="/template/wap/default/public/img/login/phone.png"/><p>手机找回</p></a>
		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/Login/find','type=2'); ?>"><img src="/template/wap/default/public/img/login/email.png"/><p>邮箱找回</p></a>
		<div class="clear"></div>
	</div>
</div>



<input type="hidden" id="niushop_rewrite_model" value="<?php echo rewrite_model(); ?>">
<input type="hidden" id="niushop_url_model" value="<?php echo url_model(); ?>">
<input type="hidden" value="<?php echo $uid; ?>" id="uid"/>
<input type="hidden" id="hidden_shop_name" value="<?php echo $web_info['title']; ?>">

<script src="/template/wap/default/public/js/login.js"></script>

</body>
</html>