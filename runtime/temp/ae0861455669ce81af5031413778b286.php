<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:40:"template/wap\default\member\address.html";i:1553831802;s:54:"D:\phpStudy\WWW\niushop\template\wap\default\base.html";i:1553848818;}*/ ?>
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
	$flag = request()->get('flag', '');
	$url = request()->get('url', '');
 ?>
<input type="hidden" id="ref_url" value="<?php echo $pre_url; ?>">
<input type="hidden" value="<?php echo $flag; ?>" id="hidden_flag" />
<section class="head">
	<?php if($flag==1): ?>
	<a class="head_back" id="backoutapp" href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/index'); ?>"><i class="icon-back"></i></a>
	<?php elseif($flag==4): ?>
	<a class="head_back" id="backoutapp"  href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/PintuanOrder/paymentorder'); ?>"><i class="icon-back"></i></a>
	<?php else: ?>
	<a class="head_back" id="backoutapp"  href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/order/payment'); ?>"><i class="icon-back"></i></a>
	<?php endif; ?>
	<!-- <div class="head-title"><?php echo lang('my_delivery_address'); ?></div>  -->
</section>
<?php 
 	 // 固定的   接口名    属性名
 	 $applet_member = api("System.Member.memberAddressList");
 	 $list = $applet_member['data'];
 ?>
<ul class="side-nav address" id="ul">
	<?php if(is_array($list['data']) || $list['data'] instanceof \think\Collection || $list['data'] instanceof \think\Paginator): if( count($list['data'])==0 ) : echo "" ;else: foreach($list['data'] as $k=>$address): if($address['is_default'] == '1'): ?>
	<li id="<?php echo $address['id']; ?>" class="current">
	<?php else: ?>
	<li id="<?php echo $address['id']; ?>" class="no-current">
	<?php endif; ?>
	<div style="background: url('/template/wap/default/public/img/member/border_order_top.png');height: 2px;"></div>
		<div class="div-simply">
			<span class="payStatus"><?php echo lang('member_receiving_information'); ?>：</span>
			<span class="payStatus"><span class="name"><?php echo $address['consigner']; ?>&nbsp;&nbsp;</span></span>
			<div class="div-simply-div">
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/addressEdit?id='.$address['id'].'&flag='.$flag.'&url='.$url); ?>" class="div-simply-div">【<?php echo lang('member_modify'); ?>】</a>
				<?php if(count($list) > 1): ?>
					<a href="javascript:void(0);" onclick="address_delete(<?php echo $address['id']; ?>,<?php echo $address['is_default']; ?>);" class="div-simply-div">【<?php echo lang('goods_delete'); ?>】</a>
				<?php endif; ?>
			</div>
		</div>
		<div class="div-simply" onclick='selectAddress(<?php echo $address['id']; ?>,this)'>
			<span class="payStatus"><?php echo lang('member_phone_number'); ?>：</span>
			<span class="payStatus"><span class="mobile"><?php echo $address['mobile']; ?></span></span>
		</div>
		<a href="javascript:void(0)" class="classnone" style="padding: 5px;" id="mo" onclick='selectAddress(<?php echo $address['id']; ?>,this)'>
			<span class="payStatus"><?php echo lang('member_detailed_address'); ?>：</span>
			<span class="address"><?php echo $address['address_info']; ?>&nbsp;<?php echo $address['address']; ?></span>
			<span class="payStatus" style="float: right; line-height: 20px;"><i class="icon-success"></i></span>
		</a>
	</li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
<?php if(count($list['data']) == 0): ?>
<img src="/template/wap/default/public/img/member_none_address.png" class="condition-img">
<div class="addr-box">
	<p class="addr-tip"><?php echo lang('you_have_not_added_your_shipping_address_yet_add_one'); ?>!</p>
</div>
<?php endif; ?>
<button class="btn-save ns-bg-color" onclick="window.location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/wap/Member/addressEdit?flag='.$flag.'&url='.$url); ?>';"><?php echo lang('member_new_delivery_address'); ?></button>
<?php if($is_weixin_browser): ?><button class="btn-getaddress ns-bg-color">一键获取微信地址</button><?php endif; ?>
<!-- <script language="javascript" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"> </script> -->
<script language="javascript" src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"> </script>
<input type="hidden" id="appId" value="<?php echo $signPackage['appId']; ?>">
<input type="hidden" id="jsTimesTamp" value="<?php echo $signPackage['jsTimesTamp']; ?>">
<input type="hidden" id="jsNonceStr"  value="<?php echo $signPackage['jsNonceStr']; ?>">
<input type="hidden" id="jsSignature" value="<?php echo $signPackage['jsSignature']; ?>">



<input type="hidden" id="niushop_rewrite_model" value="<?php echo rewrite_model(); ?>">
<input type="hidden" id="niushop_url_model" value="<?php echo url_model(); ?>">
<input type="hidden" value="<?php echo $uid; ?>" id="uid"/>
<input type="hidden" id="hidden_shop_name" value="<?php echo $web_info['title']; ?>">

<script type="text/javascript">
function selectAddress(id,obj){
	var ref_url = '<?php echo $url; ?>';//$("#ref_url").val();
	var flag = "<?php echo $flag; ?>";
	api("System.Member.modifyAddressDefault" , {"id" : id}, function(data){
		var data = data['data'];
		if (data > 0) {
			$(".side-nav li").removeClass("current");
			$(obj).parent().addClass("current");
			//选择银行的时候也用到了，但是单店版没有
			if(flag == "1"){
				return;
			}else if(flag == "2"){
				window.location.href = __URL(APPMAIN+"/member/toReceiveThePrize");
				return;
			}
			if(ref_url == 'cart'){
				window.location.href = __URL(APPMAIN+"/order/payment");
			}else{
				window.location.reload();
			}
		}else{
			toast(res["message"]);
		}
	})
}
function address_delete(id,is_default){
	if(is_default == 1){
		toast("<?php echo lang('the_default_address_cannot_be_deleted'); ?>");
		return;
	}
	api("System.Member.addressDelete", {"id" : id}, function(res){
		if (res["code"] == 0) {
			toast("<?php echo lang('member_delete_successfully'); ?>");
			window.location.reload();
		} else {
			toast(res["outmessage"]);
		}
	})
}
wx.config({
	debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
	appId: $("#appId").val(), // 必填，公众号的唯一标识
	timestamp: $("#jsTimesTamp").val(), // 必填，生成签名的时间戳
	nonceStr:  $("#jsNonceStr").val(), // 必填，生成签名的随机串
	signature: $("#jsSignature").val(),// 必填，签名，见附录1
	jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ', 'onMenuShareWeibo', 'openAddress'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
});
$(".btn-getaddress").click(function(){
	wx.ready(function(){
		wx.checkJsApi({
		    jsApiList: ['openAddress'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
		    success: function(res) {
		    	if(!res.checkResult.openAddress){
		    		toast("该公众号不支持该接口");
		    	}
		    }
		});
		wx.openAddress({
			success: function (res) {
				if(res.errMsg == 'openAddress:ok'){
					var parmas = {
						"consigner" : res.userName, // 收货人姓名,
						"mobile" : res.telNumber, // 手机号
						"province" : res.provinceName, // 省
						"city" : res.cityName, // 市
						"district" : res.countryName, // 县
						"address" : res.detailInfo, // 详细地址
						"zip_code" : res.postalCode // 邮编
					};
					api("System.Member.addWeixinAddress", parmas, function(data){
						var data = data['data'];
						if(data["code"] > 0){
							toast("获取成功");
						}else{
							toast("获取失败");
						}
					})		
				}else{
					toast("请检测公众号");
				}
			}
		});
	});
})
</script>

</body>
</html>