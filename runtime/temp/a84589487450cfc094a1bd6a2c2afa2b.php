<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:40:"template/wap\default\member\account.html";i:1553831802;s:54:"D:\phpStudy\WWW\niushop\template\wap\default\base.html";i:1553848818;}*/ ?>
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
	
<link rel="stylesheet" type="text/css" href="/template/wap/default/public/css/member_account.css">

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
	<a  class="go-back" href="javascript:history.go(-1);"><i class="icon-angle-left"></i></a>
	<!-- <a class="ns-operation">操作</a> -->
	<h1><?php echo $title; ?></h1>
</header>
<div></div>


<?php 
	$account_list = api("System.Member.accountQuery", []);
	$account_list = $account_list['data'];
 ?>
<ul class="side-nav address" id="ul">
	<?php if(is_array($account_list) || $account_list instanceof \think\Collection || $account_list instanceof \think\Paginator): if( count($account_list)==0 ) : echo "" ;else: foreach($account_list as $key=>$vo): if($vo['is_default'] == '1'): ?>
	<li id="<?php echo $vo['id']; ?>" class="current">
	<?php else: ?>
	<li id="<?php echo $vo['id']; ?>">
	<?php endif; ?>
		<div class="imgs"></div>
		<div class="div-simply">	
			<span class="pay-status"><?php echo lang('member_full_name'); ?>：</span> 
			<span class="pay-status"><span class="name"><?php echo $vo['realname']; ?>&nbsp;&nbsp;</span></span>
			<div class="divs">
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/accountedit?shop_id='.$shop_id.'&id='.$vo['id']); ?>" style="display: inline-block; float: right;">【<?php echo lang('member_modify'); ?>】</a>
				<?php if(count($account_list) != 1): ?>
				<a href="javascript:void(0);" onclick="account_delete(<?php echo $vo['id']; ?>);" style="display: inline-block;">【<?php echo lang('goods_delete'); ?>】</a>
				<?php else: ?>
				<a href="javascript:void(0);" onclick="account_delete(<?php echo $vo['id']; ?>);" style="display: none; float: right;">【<?php echo lang('goods_delete'); ?>】</a>
				<?php endif; ?>
			</div>
		</div>
		<a href="javascript:void(0)" id="mo" onclick='checkAccount(<?php echo $vo['id']; ?>,this)'>
			<div class="div-simply">
				<span class="pay-status"><?php echo lang('member_account_type'); ?>：</span> <span class="pay-status"><span><?php echo $vo['account_type_name']; ?></span></span>
			</div>
			<div class="div-simply">
				<span class="pay-status"><?php echo lang('member_phone_number'); ?>：</span> <span class="pay-status"><span><?php echo $vo['mobile']; ?></span></span>
			</div> 
			<?php switch($vo['account_type']): case "1": ?>
			<div class="div-simply" >
				<span class="pay-status"><?php echo lang('cash_account'); ?>：</span> <span class="pay-status"><span><?php echo $vo['account_number']; ?></span></span>
			</div>
			<div class="div-simply" >
				<span class="pay-status"><?php echo lang('member_sub_branch_information'); ?>：</span>
				<span><?php echo $vo['branch_bank_name']; ?></span>
<!-- 				<span class="pay-status" style="float: right; line-height: 20px;margin-right: 15px;"> -->
<!-- 					<i class="icon-success"></i> -->
<!-- 				</span> -->
			</div>
			<?php break; case "2": ?>
			<!-- 微信 -->
			<?php break; case "3": ?>
			<div class="div-simply" >
				<span class="pay-status"><?php echo lang('cash_account'); ?>：</span> <span class="pay-status"><span><?php echo $vo['account_number']; ?></span></span>
			</div>
			<?php break; endswitch; ?>
		</a>
	</li> 
	<?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
<?php if(count($account_list) == 0): ?>
<!-- <img src="/template/<?php echo $style; ?>/public/images/adds.png" style="margin: 0 auto; display: block; margin-top: 10px; height: 100px;"> -->
<img src="/template/wap/default/public/img/login/member_none_account.png" style="margin: 10px auto 0; display: block;">
<div class="addr-box">
	<span class="iconfont address-icon"></span>
	<p class="addr-tip"><?php echo lang('you_have_not_added_your_account_yet_add_one'); ?>!</p>
</div>
<?php endif; ?>
<button class="btn-save ns-bg-color" onclick="window.location.href=__URL(APPMAIN+'/member/accountedit?shop_id='+'<?php echo $shop_id; ?>');"><?php echo lang('new_account'); ?></button>

<input type="hidden" value="<?php echo $shop_id; ?>" id="shop_id"/>



<input type="hidden" id="niushop_rewrite_model" value="<?php echo rewrite_model(); ?>">
<input type="hidden" id="niushop_url_model" value="<?php echo url_model(); ?>">
<input type="hidden" value="<?php echo $uid; ?>" id="uid"/>
<input type="hidden" id="hidden_shop_name" value="<?php echo $web_info['title']; ?>">

<script>
var flag = <?php echo $flag; ?>;
</script>
<script src="/template/wap/default/public/js/member_account.js"></script>

</body>
</html>