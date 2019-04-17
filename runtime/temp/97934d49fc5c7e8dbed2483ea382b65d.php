<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:37:"template/wap\default\index\error.html";i:1553831802;s:54:"D:\phpStudy\WWW\niushop\template\wap\default\base.html";i:1553848818;}*/ ?>
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
	
<style>
body{background: #fff}	
.error-container .error-img{margin-top: 50px;text-align: center;}
.error-container .error-img img{height: 260px;}
.error-container .error-message{text-align: center;}
.error-container .error-message h3.title{font-size: 30px;margin-top: 10px;margin-bottom: 15px;padding: 0 20px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;}
.error-container .error-message .reason p.reason-title{color: #666;font-size: 14px;line-height: 25px;}
.error-container .error-message .reason p.text{color: #666;font-size: 14px;line-height: 25px;margin-bottom: 15px;padding: 0 20px;}
.error-container .operation a{display: inline-block;color: #fff;width: 130px;height: 34px;text-align: center;line-height: 34px;margin-right: 5px;}
.error-container .operation a.gray{color: #777};
</style>

</head>
<body>
<?php 
	//默认图片
	$default_images = api("System.Config.defaultImages");
	$default_images = $default_images['data'];
	$default_goods_img = $default_images["value"]["default_goods_img"];//默认商品图片
	$default_headimg = $default_images["value"]["default_headimg"];//默认用户头像
 ?>


<div class="error-container">
	<div class="error-img">
		<img src="/template/wap/default/public/img/error_img.png">
	</div>
	<div class="error-message">
		 <h3 class="title">哎呀！页面找不到了！</h3>
		 <div class="reason">
			 <p class="reason-title">可能原因：</p>
			 <p class="text">网站可能正在维护或者是程序错误</p>
		 </div>
		 <div class="operation">
	 		<a href="javascript:jump('home');" class="ns-bg-color">返回首页</a>
	 		<a href="javascript:jump('back');" class="gray">返回前页</a>
		 </div>
	</div>
</div>



<input type="hidden" id="niushop_rewrite_model" value="<?php echo rewrite_model(); ?>">
<input type="hidden" id="niushop_url_model" value="<?php echo url_model(); ?>">
<input type="hidden" value="<?php echo $uid; ?>" id="uid"/>
<input type="hidden" id="hidden_shop_name" value="<?php echo $web_info['title']; ?>">

<script type="text/javascript">
	window.onload = function(){
		var title = "哎呀！页面找不到了！",
			reason = '网站可能正在维护或者是程序错误';

		if(window.sessionStorage && sessionStorage.errorMsg != undefined){
			var errorMsg = JSON.parse(sessionStorage.errorMsg);
			if(errorMsg.title != undefined && errorMsg.title != ''){
				title = errorMsg.title;
			}	
			if(errorMsg.message != undefined && errorMsg.message != ''){
				reason = errorMsg.message;
			}	
		}

		$(".error-message .title").text(title);
		$(".error-message .reason .text").text(reason);
	}

	function jump(type){
		if(window.sessionStorage){
			sessionStorage.removeItem('errorMsg');
		}
		if(type == 'home') location.href = "<?php echo __URL('http://127.0.0.1:8080/index.php/wap'); ?>";
		if(type == 'back') window.history.back(-1);
	}
</script>

</body>
</html>