<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:37:"template/wap\default\member\info.html";i:1553831803;s:54:"D:\phpStudy\WWW\niushop\template\wap\default\base.html";i:1553848818;}*/ ?>
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
	
<link rel="stylesheet" type="text/css" href="/template/wap/default/public/css/member_info.css">

</head>
<body>
<?php 
	//默认图片
	$default_images = api("System.Config.defaultImages");
	$default_images = $default_images['data'];
	$default_goods_img = $default_images["value"]["default_goods_img"];//默认商品图片
	$default_headimg = $default_images["value"]["default_headimg"];//默认用户头像
 ?>

<header class="ns-header">
	<a  class="go-back" href="javascript:backPage();"><i class="icon-angle-left"></i></a>
	<!-- <a class="ns-operation">操作</a> -->
	<h1><?php echo $title; ?></h1>
</header>
<div></div>


<?php 
	$defaultImages = api("System.Config.defaultImages");
	$defaultImages = $defaultImages['data'];
	$default_goods_img = $defaultImages["value"]["default_goods_img"];//默认商品图片
	$default_headimg   = $defaultImages["value"]["default_headimg"];//默认用户头像
	$member_info = api("System.Member.memberDetail");
	$member_info = $member_info['data'];
	$qq_openid   = $member_info['user_info']['qq_openid'];
	if (!empty($member_info['user_info']['user_headimg'])) {
		$member_img = $member_info['user_info']['user_headimg'];
	} elseif (!empty($member_info['user_info']['qq_openid'])) {
		$member_img = $member_info['user_info']['qq_info_array']['figureurl_qq_1'];
	} elseif (!empty($member_info['user_info']['wx_openid'])) {
		$member_img = '0';
	} else {
		$member_img = '0';
	}
 ?>

<div class="personal-complete">
	<div class="personal-complete-tip" id="personal-tip"></div>
	<div class="personal-center center" id="divInfo">
		<ul class="side-nav" id="list">
			<li>
				<div class="cont-value">
					<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/modifyface'); ?>">
						<?php if($member_img != '' and $member_img != '0'): ?>
							<span class="value tou-xiang val"><img src="<?php echo __IMG($member_img); ?>" /></span>
						<?php else: ?>
							<span class="value tou-xiang"><img src="<?php echo __IMG($default_headimg); ?>" /></span>
						<?php endif; ?>
					</a>
				</div>
			</li>
			<li isnew="False">
				<a href="javascript:void(0)">
					<div class="title">
						<i></i>
						<span class="text"><?php echo lang('account_number'); ?></span>
					</div>
					<div class="cont-value">
						<i></i><span class="value value1"><?php echo $member_info['user_info']['user_name']; ?></span>
					</div>
				</a>
			</li>
			<li isnew="False">
				<a href="javascript:void(0)">
					<div class="title">
						<i></i>
						<span class="text" tage="nickname"><?php echo lang('member_nickname'); ?></span>
					</div>
					<div class="cont-value">
						<i class="arrow"></i><span class="value value1"  id="nickname"><?php echo $member_info['user_info']['nick_name']; ?></span>
					</div>
				</a>
			</li>
			<li isnew="False">
				<a href="javascript:void(0)">
					<div class="title">
						<i></i>
						<span class="text" tage="password"><?php echo lang('password'); ?></span>
					</div>
					<div class="cont-value">
						<i class="arrow"></i><span class="value set-a"  id="password"><?php echo lang('member_modify'); ?></span>
					</div>
				</a>
			</li>
			<li isnew="False">
				<a href="javascript:void(0)">
					<div class="title">
						<i></i>
						<span class="text" tage="mobilephone"><?php echo lang('member_phone'); ?></span>
					</div>
					<div class="cont-value">
						<i class="arrow"></i>
						<?php if($member_info['user_info']['user_tel'] != ''): ?>
							<span class="value" id="mobilephone"><?php echo $member_info['user_info']['user_tel']; ?>&nbsp;</span>
						<?php else: ?>
							<span class="value set-a" id="mobilephone"><?php echo lang('bind_mobile_phone_number'); ?></span>
						<?php endif; ?>
					</div>
				</a>
			</li>
			<li isnew="False">
				<a href="javascript:void(0)">
					<div class="title">
						<i></i>
					<span class="text" tage="email"><?php echo lang('mailbox'); ?></span>
					</div>
					<div class="cont-value">
						<i class="arrow"></i><span class="value" id="email_no"><?php echo $member_info['user_info']['user_email']; ?>&nbsp;</span>
						<input type="hidden" id="oldEmail" value="<?php echo $member_info['user_info']['user_email']; ?>">
					</div>
				</a>
			</li>
			<li isnew="False">
				<a href="javascript:void(0)">
					<div class="title">
						<i></i>
					<span class="text" tage="qqno">关联账号</span>
					</div>
					<div class="cont-value">
						<i class="arrow"></i><span class="value" id="qqno">&nbsp;</span>
					</div>
				</a>
			</li>
			<!-- <li class="border-bottom-none">
				<a href="javascript:void(0)">
					<div class="title">
						<i></i>
					<span class="text" tage="three-bind"><?php echo lang('third_party_account_binding'); ?></span>
					</div>
					<div class="cont-value">
						<i class="arrow"></i>
						<span class="value" id="threeBindno">
							<img src="/template/wap/default/public/img/member/personalData_qq.png" alt=""  class="imgs"/>
						</span>
					</div>
				</a>
			</li> -->
		</ul>
	</div>
	<div class="button-submit" id="logoutBtn">
		<a id="logout" href="javascript:void(0)"><button class="btn primary ns-bg-color" onclick="logout()" ><?php echo lang('member_log_out'); ?></button></a>
	</div>
</div>

<!-- 第三方绑定 -->
<form class="mt-55 mlr-15" id="edit">
	<div class="three-bind">
		<ul>
			<?php if(!(empty($member_info['user_info']['wx_openid']) || (($member_info['user_info']['wx_openid'] instanceof \think\Collection || $member_info['user_info']['wx_openid'] instanceof \think\Paginator ) && $member_info['user_info']['wx_openid']->isEmpty()))): ?>
			<li>
				<img src="/template/wap/default/public/img/member/wechat-icon.png" />
				<a href="javascript:;">
					<span>微信</span>
					<div><span class="wei-span">已绑定</span><span class="right-border">&nbsp;</span></div>
				</a>
			</li>
			<?php else: ?>
			<li>
				<img src="/template/wap/default/public/img/member/wechat-icon.png" />
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/oauthlogin?type=WCHAT'); ?>">
					<span>微信</span>
					<div><span class="wei-span"><?php echo lang('member_no_bound'); ?></span><span class="right-border">&nbsp;</span></div>
				</a>
			</li>
			<?php endif; if(!(empty($member_info['user_info']['qq_openid']) || (($member_info['user_info']['qq_openid'] instanceof \think\Collection || $member_info['user_info']['qq_openid'] instanceof \think\Paginator ) && $member_info['user_info']['qq_openid']->isEmpty()))): ?>
			<li>
				<img src="/template/wap/default/public/img/member/qq-icon.png" />
				<a href="javascript:;">
					<span>QQ</span>
					<div><span class="wei-span">已绑定</span><span class="right-border">&nbsp;</span></div>
				</a>
			</li>
			<?php else: ?>
			<li>
				<img src="/template/wap/default/public/img/member/qq-icon.png" />
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/oauthlogin?type=QQLOGIN'); ?>">
					<span>QQ</span>
					<div><span class="wei-span"><?php echo lang('member_no_bound'); ?></span><span class="right-border">&nbsp;</span></div>
				</a>
			</li>
			<?php endif; ?>
		</ul>
	</div>
</form>
<!-- 密码修改 -->
<form class="mt-55 mlr-15 mlr-16" id="editpassword" action="javascript:;">
	<div><span><?php echo lang('current_password'); ?>：</span>
		<input type="text" id="oldpassword"  class="inputs" placeholder="<?php echo lang('dreambox'); ?>" onfocus="$(this).attr('type','password')">
	</div>
	<div><span><?php echo lang('member_new_password'); ?>：</span>
		<input type="text" id="newpassword" class="texts" placeholder="<?php echo lang('member_new_password'); ?>" onfocus="$(this).attr('type','password')"/>
		<span><?php echo lang('confirm_new_password'); ?>：</span><input type="text" id="newpassword2" placeholder="<?php echo lang('confirm_new_password'); ?>" onfocus="$(this).attr('type','password')">
	</div>
</form>
<!-- 手机号绑定 -->
<form class="mt-55 mlr-15 mlr-17" id="edit_mobile">
	<div>
		<span><?php echo lang('cell_phone_number'); ?></span>
		<input type="text" id="mobile" placeholder="<?php echo lang('please_enter_your_cell_phone_number'); ?>" value='<?php echo $member_info['user_info']['user_tel']; ?>'/>
		<input type="hidden" id="oldMobile" value="<?php echo $member_info['user_info']['user_tel']; ?>">
	</div>
	<?php if($login_verify_code['pc'] == 1): ?>
	<div>
		<span><?php echo lang('member_verification_code'); ?></span>
		<input type="text" id="input_mobile_code" placeholder="<?php echo lang('please_enter_verification_code'); ?>" style="max-width: 32%;min-width: 30%;"/>
		<img id="verify_img" src="<?php echo __URL('http://127.0.0.1:8080/index.php/captcha'); ?>" alt="captcha" onclick="this.src='<?php echo __URL('http://127.0.0.1:8080/index.php/captcha?tag=1'); ?>'+'&send='+Math.random()" />
	</div>
	<?php endif; if($notice['noticeMobile'] == 1): ?>
	<div>
		<span><?php echo lang('mobile_phone_dynamic_code'); ?></span>
		<input type="text" id="mobile_code" placeholder="<?php echo lang('please_enter_the_mobile_phone_dynamic_code'); ?>" style="max-width: 32%;min-width: 30%;"/>
		<input type="button" class="send-out-code ns-text-color ns-border-color" id="send_mobile" value="<?php echo lang('get_dynamic_code'); ?>" style="height: 30px;margin-left: 20px;line-height: 30px;">
	</div>
	<?php endif; ?>
</form>
<!-- 修改昵称 -->
<form class="mt-55 mlr-15 mlr-18" id="edit_nick_name">
	<div><span><?php echo lang('member_nickname'); ?></span>
		<input type="text" id="input_nick_name" placeholder="<?php echo lang('please_enter_your_nickname'); ?>" value='<?php echo $member_info['user_info']['nick_name']; ?>'/>
	</div>
</form>
<!-- 修改邮箱 -->
<form class="mt-55 mlr-15 mlr-19" id="edit_email">
	<div><span><?php echo lang('mailbox'); ?></span>
		<input type="text" id="email" placeholder="<?php echo lang('please_enter_the_mailbox'); ?>" value='<?php echo $member_info['user_info']['user_email']; ?>'/>
	</div>
	<?php if($login_verify_code['pc'] == 1): ?>
	<div>
		<span><?php echo lang('member_verification_code'); ?></span>
		<input type="text" id="input_email_code" placeholder="<?php echo lang('please_enter_verification_code'); ?>" style="max-width: 32%;min-width: 30%;" />
		<img id="verify_img" src="<?php echo __URL('http://127.0.0.1:8080/index.php/captcha'); ?>" alt="captcha" onclick="this.src='<?php echo __URL('http://127.0.0.1:8080/index.php/captcha?tag=1'); ?>'+'&send='+Math.random()" />
	</div>
	<?php endif; if($notice['noticeEmail'] == 1): ?>
	<div>
		<span><?php echo lang('member_mailbox_authentication_code'); ?></span>
		<input type="text" id="email_code"  placeholder="<?php echo lang('member_enter_mailbox_verification_code'); ?>" style="max-width: 32%;min-width: 30%;" />
		<input type="button" class="send-out-code ns-text-color ns-border-color" id="send_email" value="<?php echo lang('get_validation_code'); ?>" style="height: 30px;margin-left: 20px;line-height: 30px;">
	</div>
	<?php endif; ?>
</form>
<div id="saveBtn"class="button-submit buttons">
	<a href="javascript:void(0)" onclick="btnsave()">
		<button class="ns-bg-color"><?php echo lang('member_preservation'); ?></button>
	</a>
</div>



<input type="hidden" id="niushop_rewrite_model" value="<?php echo rewrite_model(); ?>">
<input type="hidden" id="niushop_url_model" value="<?php echo url_model(); ?>">
<input type="hidden" value="<?php echo $uid; ?>" id="uid"/>
<input type="hidden" id="hidden_shop_name" value="<?php echo $web_info['title']; ?>">

<script>
	var lang_member_info = {
		account_number : "<?php echo lang('account_number'); ?>",
		password : "<?php echo lang('password'); ?>",
		change_password : "<?php echo lang('change_password'); ?>",
		member_phone : "<?php echo lang('member_phone'); ?>",
		member_nickname : "<?php echo lang('member_nickname'); ?>",
		mailbox : "<?php echo lang('mailbox'); ?>",
		please_enter_the_mailbox : "<?php echo lang('please_enter_the_mailbox'); ?>!",
		third_party_account_binding : "<?php echo lang('third_party_account_binding'); ?>",
		member_real_name : "<?php echo lang('member_real_name'); ?>",
		wechat : "<?php echo lang('wechat'); ?>",
		member_personal_data : "<?php echo lang('member_personal_data'); ?>",
		please_enter_the_original_password : "<?php echo lang('please_enter_the_original_password'); ?>",
		please_enter_6_20_new_passwords : "<?php echo lang('please_enter_6_20_new_passwords'); ?>",
		the_two_password_is_inconsistent : "<?php echo lang('the_two_password_is_inconsistent'); ?>",
		original_password_error : "<?php echo lang('original_password_error'); ?>",
		consistent_with_the_original_mobile_phone_number_without_modification : "<?php echo lang('consistent_with_the_original_mobile_phone_number_without_modification'); ?>",
		mobile_phones_must_not_be_empty : "<?php echo lang('mobile_phones_must_not_be_empty'); ?>",
		phone_is_not_right_format : "<?php echo lang('phone_is_not_right_format'); ?>",
		please_enter_verification_code : "<?php echo lang('please_enter_verification_code'); ?>",
		the_phone_number_already_exists : "<?php echo lang('the_phone_number_already_exists'); ?>",
		member_enter_mobile_verification_code : "<?php echo lang('member_enter_mobile_verification_code'); ?>",
		can_not_be_empty : "<?php echo lang('can_not_be_empty'); ?>",
		consistent_with_the_original_mailbox_no_change_required : "<?php echo lang('consistent_with_the_original_mailbox_no_change_required'); ?>",
		mailbox_cannot_be_empty : "<?php echo lang('mailbox_cannot_be_empty'); ?>",
		mailbox_already_exists : "<?php echo lang('mailbox_already_exists'); ?>",
		member_enter_mailbox_verification_code : "<?php echo lang('member_enter_mailbox_verification_code'); ?>",
		unable_to_change : "<?php echo lang('unable_to_change'); ?>",
		consistent_with_the_original_nickname_without_modification : "<?php echo lang('consistent_with_the_original_nickname_without_modification'); ?>",
		member_nicknames_cannot_empty : "<?php echo lang('member_nicknames_cannot_empty'); ?>",
		mailbox_format_is_incorrect : "<?php echo lang('mailbox_format_is_incorrect'); ?>",
		get_validation_code : "<?php echo lang('get_validation_code'); ?>",
		post_resend : "<?php echo lang('post_resend'); ?>",
		please_enter_member_name : ":lang('please_enter_member_name')}",
		please_enter_your_cell_phone_number : "<?php echo lang('please_enter_your_cell_phone_number'); ?>!",
		please_enter_your_nickname : "<?php echo lang('please_enter_your_nickname'); ?>",
		bind_mobile_phone_number : "<?php echo lang('bind_mobile_phone_number'); ?>",
		modify_nickname : "<?php echo lang('modify_nickname'); ?>",
		member_enter_your_real_name : "<?php echo lang('member_enter_your_real_name'); ?>!",
		please_enter_qq_number : "<?php echo lang('please_enter_qq_number'); ?>",
		please_enter_a_micro_signal : "<?php echo lang('please_enter_a_micro_signal'); ?>",
	};
    var notice_mobile = "<?php echo $notice['noticeMobile']; ?>";
    var pc ="<?php echo $login_verify_code['pc']; ?>";
	var notice_email ="<?php echo $notice['noticeEmail']; ?>"
</script>
<script src="/template/wap/default/public/js/member_info.js"></script>

</body>
</html>