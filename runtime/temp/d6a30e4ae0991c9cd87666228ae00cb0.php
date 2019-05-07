<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:40:"template/wap\default\login\register.html";i:1557217176;s:54:"D:\phpStudy\WWW\niushop\template\wap\default\base.html";i:1553848818;}*/ ?>
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
	
<link rel="stylesheet" href="/template/wap/default/public/css/register.css">

</head>
<body>
<?php 
	//默认图片
	$default_images = api("System.Config.defaultImages");
	$default_images = $default_images['data'];
	$default_goods_img = $default_images["value"]["default_goods_img"];//默认商品图片
	$default_headimg = $default_images["value"]["default_headimg"];//默认用户头像
 
// 注册配置
$wap_register_info = api("System.Login.registerConfig");
$wap_register_info = $wap_register_info['data'];

//QQ配置
$qq_info = api("System.Config.qQLogin");
$qq_info = $qq_info['data'];

//微信配置
$wchat_info = api("System.Config.wchatLogin");
$wchat_info = $wchat_info['data'];

//消息通知配置
$notice = api("System.Config.noticeConfig");
$notice = $notice['data'];
 if(!(empty($wap_register_info) || (($wap_register_info instanceof \think\Collection || $wap_register_info instanceof \think\Paginator ) && $wap_register_info->isEmpty()))): ?>
<div class="content">
	
	<div class="nk-top  clearFloat">
		<?php if((strpos($wap_register_info['reg_config']['register_info'],'mobile') !== false) && (strpos($wap_register_info['reg_config']['register_info'],'plain') !== false)): ?>
		<div  class='nk-cell active'>
			<span class="ns-text-color ns-border-color"><?php echo lang('account_registration'); ?></span>
		</div>
		<div class="nk-cell">
			<span><?php echo lang('mobile_phone_registration'); ?></span>
		</div>
		<?php elseif((strpos($wap_register_info['reg_config']['register_info'],'mobile') !== false) && (strpos($wap_register_info['reg_config']['register_info'],'plain') === false)): ?>
		<div class="nk-cell-one active">
			<span class="ns-text-color ns-border-color"><?php echo lang('mobile_phone_registration'); ?></span>
		</div>
		<?php elseif((strpos($wap_register_info['reg_config']['register_info'],'mobile') === false) && (strpos($wap_register_info['reg_config']['register_info'],'plain') !== false)): ?>
		<div  class='nk-cell-one active'>
			<span class="ns-text-color ns-border-color"><?php echo lang('account_registration'); ?></span>
		</div>
		<?php endif; ?>
	</div>
	<div class="log-wp">
		<?php if(strpos($wap_register_info['reg_config']['register_info'],'plain') !== false): ?>
		<div id="nk_text1">
			<div class="log-cont">
				<label class="login-txt" for="username"><span><?php echo lang('account_number'); ?></span><input type="text" name="username" id="username" placeholder="<?php echo lang('enter_your_account_number'); ?>"></label>
			</div>
			<div class="log-cont">
				<label for="password"><span><?php echo lang('password'); ?></span><input type="password" name="password" id="password" placeholder="<?php echo lang('please_input_password'); ?>" ></label>
			</div>
			<div class="log-cont">
				<label for="cfpassword"><span><?php echo lang('member_confirm_password'); ?></span><input type="password" name="cfpassword" id="cfpassword" placeholder="<?php echo lang('confirm_password'); ?>"></label>
			</div>
			<?php if($wap_register_info['code_config']['value']['pc'] == 1): ?>
			<div class="nk-cont">
				<label><span><?php echo lang('member_verification_code'); ?></span>
					<input class="account-verification " type="text" name="captcha" id="register_captcha"  placeholder="<?php echo lang('please_enter_verification_code'); ?>">
					<img class="verifyimg" src=" <?php echo __URL('http://127.0.0.1:8080/index.php/captcha'); ?>" onclick="this.src='<?php echo __URL('http://127.0.0.1:8080/index.php/captcha'); ?>'"  alt="captcha" />
				</label>
			</div>
			<?php endif; ?>
			<div class="log-protocol">
		        <input type="checkbox" id="register_protocol">
		        <label class="ns-text-color-black">我已阅读并同意<a class="ns-text-color protocol_model">《注册协议》</a></label>
		    </div>
			
			<button id="login-button" class="lang-btn primary" onclick="register_member()"><?php echo lang('register'); ?></button>
			<a class="lang-btn register-immediately" href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/index'); ?>"><?php echo lang('existing_account'); ?>,<?php echo lang('logon_immediately'); ?></a>
		</div>
		<?php endif; if(strpos($wap_register_info['reg_config']['register_info'],'mobile') !== false): if(strpos($wap_register_info['reg_config']['register_info'],'plain') === false): ?>
				<div id="nk_text2" >
			<?php else: ?>
				<div id="nk_text2">
			<?php endif; ?>
				<div class="nk-cont">
					<label><span class="handset"><?php echo lang('cell_phone_number'); ?></span><input type="text" name="mobile" id="mobile" placeholder="<?php echo lang('please_enter_your_cell_phone_number'); ?>" onchange="check_mobile_is_has();"></label>
				</div>
				<?php if($wap_register_info['code_config']['value']['pc'] == 1): ?>
				<div class="nk-cont">
					<label>
						<span class="verification"><?php echo lang('member_verification_code'); ?></span>
						<input type="text" name="captcha" id="captcha"  placeholder="<?php echo lang('please_enter_verification_code'); ?>">
						<img class="verifyimg" src=" <?php echo __URL('http://127.0.0.1:8080/index.php/captcha'); ?>" onclick="this.src='<?php echo __URL('http://127.0.0.1:8080/index.php/captcha'); ?>'" alt="captcha" />
					</label>
				</div>
				<?php endif; if($notice['noticeEmail'] != 0): ?>
				<div class="nk-cont">
					<label>
						<span class="verification"><?php echo lang('dynamic_code'); ?></span>
						<input type="text" name="motify" placeholder="<?php echo lang('please_enter_the_mobile_phone_dynamic_code'); ?>" id="verify_code">
						<input type="button" id="sendOutCode" class="ns-text-color ns-border-color" value="<?php echo lang('get_dynamic_code'); ?>">
					</label>
				</div>
				<?php endif; ?>
				<div class="log-cont">
					<label for="password"><span class="handset-pwd"><?php echo lang('password'); ?></span><input type="password" name="password" id="password_mobile" placeholder="<?php echo lang('please_enter_your_account_password'); ?>"></label>
				</div>
				<div class="log-cont">
					<label for="cfpassword"><span><?php echo lang('member_confirm_password'); ?></span><input class="handset-cfpaw" type="password" name="cfpassword" id="cfpassword_mobile" placeholder="<?php echo lang('please_confirm_the_account_password'); ?>"></label>
				</div>
				
				<div class="log-protocol">
			        <input type="checkbox" id="protocol">
			        <label class="ns-text-color-black">我已阅读并同意<a class="ns-text-color protocol_model">《注册协议》</a></label>
		   		</div>
				
				<button id="login-button-mobile" class="lang-btn primary" onclick="register_mobile()"><?php echo lang('register'); ?></button>
				<a class="lang-btn register-immediately" href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/index'); ?>"><?php echo lang('existing_account'); ?>,<?php echo lang('logon_immediately'); ?></a>
			</div>
			<?php endif; if($wap_register_info['login_count'] != 0): ?>
			<img src="/template/wap/default/public/img/login/assistant_member.png" class="assistant-member"/>
			<?php endif; if($qq_info['is_use'] != 1): ?>
			<div>
				<?php if($qq_info['is_use'] == 1): ?>
				<div class="<?php if($wap_register_info['loginCount'] == 1): ?>login-wei<?php elseif($wap_register_info['login_count'] == 2): ?>login-wei-two<?php elseif($wap_register_info['login_count'] == 3): ?>login-wei-three<?php endif; ?>">
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/oauthlogin?type=QQLOGIN'); ?>">
					<img src="/template/wap/default/public/img/login/qq.png"/>
					<span>QQ</span>
				</a>
			</div>
			<?php endif; if($wchat_info['is_use'] == 1): ?>
			<div class="<?php if($wap_register_info['login_count'] == 1): ?>login-wei<?php elseif($wap_register_info['login_count'] == 2): ?>login-wei-two<?php else: ?>login-wei-three<?php endif; ?> login-wechet">
			<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/oauthlogin?type=WCHAT'); ?>">
				<img src="/template/wap/default/public/img/login/weixin.png"/><br/>
				<span><?php echo lang('wechat'); ?></span>
			</a>
		</div>
		<?php endif; ?>
		<div class="<?php if($wap_register_info['login_count'] == 1): ?>login-wei<?php elseif($wap_register_info['login_count'] == 2): ?>login-wei-two<?php elseif($wap_register_info['login_count'] == 3): ?>login-wei-three<?php endif; ?> dis-no">
		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/wchatOauth'); ?>">
			<img src="/template/wap/default/public/img/login/weibo.png"/>
			<span ><?php echo lang('microblog'); ?></span>
		</a>
	</div>
</div>
<?php elseif($wchat_info['is_use'] != 1): ?>
	<div>
		<?php if($qq_info['is_use'] == 1): ?>
		<div class="<?php if($wap_register_info['login_count'] == 1): ?>login-wei<?php elseif($wap_register_info['login_count'] == 2): ?>login-wei-two<?php elseif($wap_register_info['login_count'] == 3): ?>login-wei-three<?php endif; ?> login-wechet">
			<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/oauthlogin?type=QQLOGIN'); ?>" class="dis-bk">
				<img src="/template/wap/default/public/img/login/qq.png"/><br/>
				<span>QQ</span>
			</a>
		</div>
		<?php endif; if($wchat_info['is_use'] == 1): ?>
		<div class="<?php if($wap_register_info['login_count'] == 1): ?>login-wei<?php elseif($wap_register_info['login_count'] == 2): ?>login-wei-two<?php else: ?>login-wei-three<?php endif; ?>">
			<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/oauthlogin?type=WCHAT'); ?>">
				<img src="/template/wap/default/public/img/login/weixin.png" />
				<span><?php echo lang('wechat'); ?></span>
			</a>
		</div>
		<?php endif; ?>
		<div class="<?php if($wap_register_info['login_count'] == 1): ?>login-wei<?php elseif($wap_register_info['login_count'] == 2): ?>login-wei-two<?php elseif($wap_register_info['login_count'] == 3): ?>login-wei-three<?php endif; ?> dis-no">
			<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/'); ?>">
				<img src="/template/wap/default/public/img/login/weibo.png"/>
				<span ><?php echo lang('microblog'); ?></span>
			</a>
		</div>
	</div>
<?php else: ?>
	<div class="pic-centered">
	<?php if($qq_info['is_use'] == 1): ?>
		<div class="<?php if($wap_register_info['login_count'] == 1): ?>login-wei<?php elseif($wap_register_info['login_count'] == 2): ?>login-wei-two<?php else: ?>login-wei-three<?php endif; ?>" >
		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/oauthlogin?type=QQLOGIN'); ?>">
			<img src="/template/wap/default/public/img/login/qq.png"/>
			<span>QQ</span>
		</a>
	</div>
	<?php endif; if($wchat_info['is_use'] == 1): ?>
	<div class="<?php if($wap_register_info['login_count'] == 1): ?>login-wei<?php elseif($wap_register_info['login_count'] == 2): ?>login-wei-two<?php else: ?>login-wei-three<?php endif; ?>">
		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/oauthlogin?type=WCHAT'); ?>">
			<img src="/template/wap/default/public/img/login/weixin.png" />
			<span><?php echo lang('wechat'); ?></span>
		</a>
	</div>
	<?php endif; ?>
	<div class="<?php if($wap_register_info['login_count'] == 1): ?>login-wei<?php elseif($wap_register_info['login_count'] == 2): ?>login-wei-two<?php elseif($wap_register_info['login_count'] == 3): ?>login-wei-three<?php endif; ?> dis-no">
		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/wchatOauth'); ?>">
			<img src="/template/wap/default/public/img/login/weibo.png"/>
			<span ><?php echo lang('microblog'); ?></span>
		</a>
	</div>
	</div>
<?php endif; ?>
</div>
</div>
<div class="footer" id="rigister_copyright">
	<div class="copyright">
		<div class="ft-copyright">
			<a href="http://www.niushop.com.cn" target="_blank" >山西牛酷信息科技有限公司&nbsp;提供技术支持</a>
		</div>
	</div>
</div>
<input type="hidden" id="mobile_is_has" value="1">

<!-- 注册协议 -->
<?php 
	$info = api('System.Login.registerAgreement', []);
	$info = $info['data'];
 ?>
<div class="protocol-loading">
	<div class="loading-box">
		<div class="loading-title"><?php echo $info['title']; ?></div>
		<div class="loading-content"><?php echo $info['content']; ?></div>
		<div class="loading-footer">
			<button class="primary close">确定</button>
		</div>
	</div>
</div>

</div>
<?php else: ?>
<script>location.href = __URL(APPMAIN + "/login/index");</script>
<?php endif; ?>



<input type="hidden" id="niushop_rewrite_model" value="<?php echo rewrite_model(); ?>">
<input type="hidden" id="niushop_url_model" value="<?php echo url_model(); ?>">
<input type="hidden" value="<?php echo $uid; ?>" id="uid"/>
<input type="hidden" id="hidden_shop_name" value="<?php echo $web_info['title']; ?>">

<script>
	var mobile_is_use = "<?php echo $wap_register_info['login_config']['mobile_config']['is_use']; ?>";
	var min_length_str = "<?php echo $wap_register_info['reg_config']['pwd_len']; ?>";
	var regex_str = "<?php echo $wap_register_info['reg_config']['pwd_complexity']; ?>";
	var username_verify = "<?php echo $wap_register_info['reg_config']['name_keyword']; ?>";
	var uurl = "<?php echo $login_pre_url; ?>";console.log(uurl);
</script>
<script src="/template/wap/default/public/js/register.js"></script>

</body>
</html>