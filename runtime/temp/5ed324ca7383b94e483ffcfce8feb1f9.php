<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:45:"template/wap\default\member\address_edit.html";i:1554085664;s:54:"D:\phpStudy\WWW\niushop\template\wap\default\base.html";i:1553848818;}*/ ?>
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
	
<link rel="stylesheet" type="text/css" href="/template/wap/default/public/css/member_address.css">

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
	$id = request()->get('id', '');
	$flag = request()->get('flag', '');
	$pre_url = request()->get('url', '');
	
	if($id) {
		$address_info = api('System.Member.addressDetail', ['id' => $id]);
		$address_info = $address_info['data'];
	}
 ?>
<input type="hidden" id="ref_url" value="<?php echo $pre_url; ?>">
<input type="hidden" id="hidden_flag" value="<?php echo $flag; ?>" />
<input type="hidden" id="adressid" value="<?php echo !empty($address_info['id'])?$address_info['id'] : ''; ?>">
<input type="hidden" id="hidUrl" value="">
<input type="hidden" id="provinceid" value="<?php echo !empty($address_info['province'])?$address_info['province'] : -1; ?>">
<input type="hidden" id="cityid" value="<?php echo !empty($address_info['city'])?$address_info['city'] : -1; ?>">
<input type="hidden" id="districtid" value="<?php echo !empty($address_info['district'])?$address_info['district'] : -1; ?>">
<input type="hidden" value="-1" id="AddressID">
<form class="form-info">
	<div class="div-item">
		<span class="ns-text-color-black"><?php echo lang('member_full_name'); ?></span>
		<input type="text" placeholder="<?php echo lang('please_enter_the_recipient_name'); ?>" id="Name" value="<?php if(!(empty($address_info) || (($address_info instanceof \think\Collection || $address_info instanceof \think\Paginator ) && $address_info->isEmpty()))): ?><?php echo $address_info['consigner']; endif; ?>" />
	</div>
	<div class="div-item">
		<span class="ns-text-color-black"><?php echo lang('member_phone'); ?></span>
		<input type="text" placeholder="<?php echo lang('member_enter_your_phone_number'); ?>" id="Moblie" value="<?php if(!(empty($address_info) || (($address_info instanceof \think\Collection || $address_info instanceof \think\Paginator ) && $address_info->isEmpty()))): ?><?php echo $address_info['mobile']; endif; ?>" />
	</div>
	<div class="div-item">
		<span class="ns-text-color-black"><?php echo lang('member_fixed_telephone'); ?></span> <input type="text" id="phone" placeholder="<?php echo lang('member_fixed_telephone'); ?>（选填）" value="<?php if(!(empty($address_info) || (($address_info instanceof \think\Collection || $address_info instanceof \think\Paginator ) && $address_info->isEmpty()))): ?><?php echo $address_info['phone']; endif; ?>" />
	</div>
	<div class="div-item">
		<span class="ns-text-color-black"><?php echo lang('goods_province'); ?></span>
		<select id="seleAreaNext" onchange="GetProvince();">
			<option value=""><?php echo lang('member_select_province'); ?></option>
		</select>
	</div>
	<div class="div-item">
		<span class="ns-text-color-black"><?php echo lang('city'); ?></span>
		<select id="seleAreaThird" onchange="getSelCity();">
			<option value=""><?php echo lang('member_select_city'); ?></option>
		</select>
	</div>
	<div class="div-item">
		<span class="ns-text-color-black"><?php echo lang('county'); ?></span>
		<select id="seleAreaFouth">
			<option value="-1"><?php echo lang('goods_select_district_or_county'); ?></option>
		</select>
	</div>
	<div class="div-item">
		<span class="ns-text-color-black"><?php echo lang('member_detailed_address'); ?></span>
		<input type="text" placeholder="<?php echo lang('please_enter_detailed_address'); ?>" id="AddressInfo" value="<?php if(!(empty($address_info) || (($address_info instanceof \think\Collection || $address_info instanceof \think\Paginator ) && $address_info->isEmpty()))): ?><?php echo $address_info['address']; endif; ?>" />
	</div>
</form>
<button onclick="saveAddress()" class="btn-save primary"><?php echo lang('member_preservation'); ?></button>



<input type="hidden" id="niushop_rewrite_model" value="<?php echo rewrite_model(); ?>">
<input type="hidden" id="niushop_url_model" value="<?php echo url_model(); ?>">
<input type="hidden" value="<?php echo $uid; ?>" id="uid"/>
<input type="hidden" id="hidden_shop_name" value="<?php echo $web_info['title']; ?>">

<script src="/template/wap/default/public/js/address.js"></script>

</body>
</html>