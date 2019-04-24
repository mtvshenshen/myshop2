<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:38:"template/wap\default\member\index.html";i:1556071726;s:54:"D:\phpStudy\WWW\niushop\template\wap\default\base.html";i:1553848818;}*/ ?>
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
	
<link rel="stylesheet" type="text/css" href="/template/wap/default/public/css/member_index.css">

</head>
<body>
<?php 
	//默认图片
	$default_images = api("System.Config.defaultImages");
	$default_images = $default_images['data'];
	$default_goods_img = $default_images["value"]["default_goods_img"];//默认商品图片
	$default_headimg = $default_images["value"]["default_headimg"];//默认用户头像
 
	$member_detail 	   = api('System.Member.memberDetail');
	$member_info  	   = $member_detail['data'];

    $promoter_info = [];
    if(addon_is_exit('Nsfx')){
		$promoter_info = api('Nsfx.Distribution.promoterDetail');
		$promoter_info = $promoter_info['data'];
	}

	$integralconfig    = api("System.Config.pointReward", []);
	$integralconfig    = $integralconfig['data'];
	$isSign 	 	   = api("System.Member.isSignin", []);
	$isSign 		   = $isSign['data'];
	$defaultImages 	   = api("System.Config.defaultImages");
	$defaultImages     = $defaultImages['data'];
	$default_headimg   = $defaultImages["value"]["default_headimg"];//默认用户头像
	$default_goods_img = $defaultImages["value"]["default_goods_img"];//默认商品图片
	$coupon_count = api("System.Member.couponNum");
	$coupon_count = $coupon_count['data'];
 ?>
<div class="panel memberhead ">
	 <div class="member-head ns-bg-color">
	 	<div class="member-edit"><img src="/template/wap/default/public/img/member/member-icon-edit.png" onclick="location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/info?shop_id='.$shop_id); ?>'"></div>
	 	<div class="member-head-top">
		 	<div class="member-headimg">
		 		<?php if($member_info['user_info']['user_headimg'] == ''): ?>
					<img src="<?php echo __IMG($default_headimg); ?>" />
				<?php else: ?>
					<img src="<?php echo __IMG($member_info['user_info']['user_headimg']); ?>"/>
				<?php endif; ?>
		 	</div>
		 	<div class="member-name"><?php echo $member_info["user_info"]['nick_name']; ?></div>
		 	<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/qrcode&shop_id='.$shop_id); ?>">
		 	<div class="member-qrcode"><img src="/template/wap/default/public/img/member/member-icon-qrcode.png"></div>
		 	
		 	</a>
		 	<div class="clear"></div>
	 	</div>
	 	<div class="member-head-bottom">
	 		<!-- 签到 -->
	 		<?php if($member_info['level_name']): ?>
	 		<div class="head-bottom-level">
	 			<img class="member-icon" src="/template/wap/default/public/img/member/member-icon-level.png">
	 			<span><?php echo $member_info['level_name']; ?></span>
	 		</div>
	 		<?php endif; if($integralconfig['sign_integral'] == 1): ?>
	 		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/signin?shop_id='.$shop_id); ?>">
		 		<div class="head-bottom-sign">
		 			<div class="head-sign">
			 			<img class="member-icon" src="/template/wap/default/public/img/member/member-icon-sign.png">
			 			<?php if($isSign == 0): ?>
			 			<span class="sign-text" onclick="signIn();"><?php echo lang('sign_in'); ?></span>
						<?php else: ?>
			 			<span class="sign-text" onclick="signIn();"><?php echo lang('signed_in'); ?></span>
						<?php endif; ?>
		 			</div>
		 		</div>
		 	</a>
			<?php endif; ?>
	 		<div class="clear"></div>
	 	</div>
	 </div>
	 
	 <div class="member-account">
	 	<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/balance&shop_id='.$shop_id); ?>">
		 	<div class="member-account-item">
		 		<div class="member-account-num ns-text-color-black"><?php echo $member_info['balance']; ?></div>
		 		<div class="member-account-text">余额</div>
		 	</div>
	 	</a>
	 	<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/point&shop_id='.$shop_id); ?>">
	 	<div class="member-account-item">
	 		<div class="member-account-num ns-text-color-black"><?php echo $member_info['point']; ?></div>
	 		<div class="member-account-text">积分</div>
	 	</div>
	 	</a>
	 	<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/coupon&shop_id='.$shop_id); ?>">
	 	<div class="member-account-item">
	 		<div class="member-account-num ns-text-color-black"><?php echo $coupon_count; ?></div>
	 		<div class="member-account-text">优惠券</div>
	 	</div>
	 	</a>
	 </div>
	 
	 <div class="member-order">
	 	<div class="member-order-head">
	 		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/order/lists?shop_id='.$shop_id); ?>">
	 		<div class="ns-text-color-black order-head-left">全部订单</div>
	 		<div class="order-head-right">查看全部订单<img src="/template/wap/default/public/img/member/member-icon-next.png"></div>
	 		</a>
	 		<div class="clear"></div>
	 	</div>
	 	<div class="member-order-list">
	 		<?php 
				$order_status_num = api("System.Order.orderCount",['order_status' => 0]);
				$wait_pay = $order_status_num['data'];
	 		 ?>
	 		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/order/lists?status=0&shop_id='.$shop_id); ?>">
			 	<div class="member-order-item">
			 		<?php if($wait_pay > 0): ?>
			 		<div class="order-num ns-bg-color"><?php echo $wait_pay; ?></div>
					<?php elseif($wait_pay > 99): ?>
				 		<div class="order-num ns-bg-color">99+</div>
					<?php endif; ?>
			 		<div class="order-icon"><img src="/template/wap/default/public/img/member/order-icon-0.png"></div>
			 		<div class="order-texr"><?php echo lang('member_pending_payment'); ?></div>
		 		</div>
	 		</a>
	 		
	 		<?php 
				$order_status_num = api("System.Order.orderCount",['order_status' => 1]);
				$wait_delivery = $order_status_num['data'];
	 		 ?>
	 		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/order/lists?status=1&shop_id='.$shop_id); ?>">
			 	<div class="member-order-item">
			 		<?php if($wait_delivery > 0): ?>
				 		<div class="order-num ns-bg-color"><?php echo $wait_delivery; ?></div>
			        <?php elseif($wait_delivery > 99): ?>
				 		<div class="order-num ns-bg-color">99+</div>
			        <?php endif; ?>
			 		<div class="order-icon"><img src="/template/wap/default/public/img/member/order-icon-1.png"></div>
			 		<div class="order-texr"><?php echo lang('member_shipment_pending'); ?></div>
		 		</div>
	 		</a>
	 		
	 		<?php 
				$order_status_num = api("System.Order.orderCount",['order_status' => 2]);
				$wait_recieved = $order_status_num['data'];
	 		 ?>
	 		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/order/lists?status=2&shop_id='.$shop_id); ?>">
			 	<div class="member-order-item">
			 		<?php if($wait_recieved > 0): ?>
			 		<div class="order-num ns-bg-color"><?php echo $wait_recieved; ?></div>
			        <?php elseif($wait_recieved > 99): ?>
			 		<div class="order-num ns-bg-color">99+</div>
			        <?php endif; ?>
			 		<div class="order-icon"><img src="/template/wap/default/public/img/member/order-icon-2.png"></div>
			 		<div class="order-texr"><?php echo lang('member_goods_received'); ?></div>
		 		</div>
	 		</a>
	 		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/order/lists?status=3&shop_id='.$shop_id); ?>">
			 	<div class="member-order-item">
			 		<div class="order-icon"><img src="/template/wap/default/public/img/member/order-icon-3.png"></div>
			 		<div class="order-texr"><?php echo lang('member_received_goods'); ?></div>
		 		</div>
	 		</a>
	 		
	 		<?php 
				$order_status_num = api("System.Order.orderCount",['order_status' => -1]);
				$refunding = $order_status_num['data'];
	 		 ?>
	 		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/order/lists?status=-1&shop_id='.$shop_id); ?>">
			 	<div class="member-order-item">
			 		<?php if($refunding > 0): ?>
			 		<div class="order-num ns-bg-color"><?php echo $refunding; ?></div>
			        <?php elseif($refunding > 99): ?>
			 		<div class="order-num ns-bg-color">99+</div>
			        <?php endif; ?>
			 		<div class="order-icon"><img src="/template/wap/default/public/img/member/order-icon-4.png"></div>
			 		<div class="order-texr"><?php echo lang('refund_after_sale'); ?></div>
		 		</div>
	 		</a>
	 		<div class="clear"></div>
	 	</div>
	 </div>
	 
	 <?php if(NS_VERSION == NS_VER_B2C_FX && !empty($promoter_info)): ?>
	 <div class="member-promotion">
 		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/DistributionShop/usershopgoods'); ?>">
	 	<div class="promotion-item">
	 		<img src="/template/wap/default/public/img/member/promotion-img1.png">
	 	</div>
	 	</a>
 		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/DistributionShop/userShopQrcode?shop_id='.$shop_id); ?>">
		 	<div class="promotion-item">
		 		<img src="/template/wap/default/public/img/member/promotion-img2.png">
		 	</div>
	 	</a>
	 	<div class="clear"></div>
	 </div>
	 <?php endif; ?>
	 
<!-- 2019.4.16++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

	  <div class="member-order">
	 	<div class="member-order-head">
	 		
	 		<div class="ns-text-color-black order-head-left">
	 			<?php if($member_info['user_info']['user_shop'] == 1 && $member_info['user_info']['user_shop_agree'] == 1): ?>
	 			<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/user_shop?shop_id='.$shop_id); ?>">
	 			我的店铺(点击查看佣金订单记录)
	 			</a>
	 			<?php else: ?>
	 			我的店铺
	 			<?php endif; ?>
	 		</div>
	 		<?php if($member_info['user_info']['user_shop'] == 0 && $member_info['user_info']['user_shop_agree'] == 1): ?>
	 		<div class="order-head-right">开店审核中</div>
	 		<?php endif; if($member_info['user_info']['user_shop'] == 0 && $member_info['user_info']['user_shop_agree'] == 0): ?>
	 			<div class="order-head-right"><a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/kaidian?shop_id='.$shop_id); ?>">立即申请开店<img src="/template/wap/default/public/img/member/member-icon-next.png"></a></div>
	 		<?php endif; ?> 		
	 		<div class="clear"></div>
	 	</div>
	 	<?php if($member_info['user_info']['user_shop'] == 1 && $member_info['user_info']['user_shop_agree'] == 1): ?>
 	 	<div class="member-order-head">
	 		我的店铺连接(长按复制)
	 		<input type="text" value="<?php echo __URL('http://127.0.0.1:8080/index.php/wap?user_shop_id='.$member_info['user_info']['uid']); ?>" style="width: 100%;">
	 	</div>
	 	<?php endif; if($member_info['user_info']['user_shop'] == 1 && $member_info['user_info']['user_shop_agree'] == 1): 
				$shopInfo 	   = api('System.Member.shopInfo');
				$shop_data   = $shopInfo['data'];
			 ?>
	 	<div class="member-order-list member-promotion">
	 		<a href="">
			 	<div class="member-order-item">
			 		<div class="order-icon ns-text-color-black">￥<?php echo $shop_data['commossion_total']; ?></div>
			 		<div class="order-texr">累计佣金</div>
		 		</div>
	 		</a>
	 		<a href="">
			 	<div class="member-order-item">
			 		<div class="order-icon ns-text-color-black">￥<?php echo $shop_data['commission_ke']; ?></div>
			 		<div class="order-texr">佣金余额</div>
		 		</div>
	 		</a>
	 		<a href="">
			 	<div class="member-order-item">
			 		<div class="order-icon ns-text-color-black">￥<?php echo $shop_data['commission_cash']; ?></div>
			 		<div class="order-texr">佣金转钱包金额</div>
		 		</div>
	 		</a>
	 		<div class="clear"></div>
	 	</div>
	 	<?php endif; ?>
	 </div>
<!-- 2019.4.16++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
	 
	 <?php if(addon_is_exit('NsPintuan') == 1 && addon_is_exit('NsPresell') == 1): ?>
 	  <div class="member-order">
	 	<div class="member-order-head">
	 		<div class="ns-text-color-black order-head-left">订单中心</div>
	 		<div class="clear"></div>
	 	</div>
	 	<div class="member-order-list member-order-center">
		 	<?php 
	   		 $pintuan_order_num = api('System.Order.orderCount', ['order_type' => 4]);
		 	 ?>
	 		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/order/lists?order_type=4&shop_id='.$shop_id); ?>">
			 	<div class="member-order-item">
			 		<div class="order-icon ns-text-color-black"><?php echo !empty($pintuan_order_num['data'])?$pintuan_order_num['data'] : 0; ?></div>
			 		<div class="order-texr">拼团订单</div>
		 		</div>
	 		</a>

	 		<?php 
		    $yushou_order_num = api('System.Order.orderCount', ['is_virtual' => 6]);
	 		 ?>
	 		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/order/lists?order_type=6&shop_id='.$shop_id); ?>">
			 	<div class="member-order-item">
			 		<div class="order-icon ns-text-color-black"><?php echo !empty($yushou_order_num['data'])?$yushou_order_num['data'] : 0; ?></div>
			 		<div class="order-texr">预售订单</div>
		 		</div>
	 		</a>
	 		<div class="clear"></div>
	 	</div>
	 </div>
	 <?php endif; ?>
	 
	 <div class="member-nav-list">
	 	<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/info?shop_id='.$shop_id); ?>">
		 	<div class="member-nav-item">
		 		<div class="member-nav-left">
		 			<img src="/template/wap/default/public/img/member/member-icon-info.png"> 
		 			<span class="ns-text-color-black">个人资料</span>
		 		</div>
		 		<div class="member-nav-right"><img src="/template/wap/default/public/img/member/member-icon-next.png"></div>
		 		<div class="clear"></div>
		 	</div>
	 	</a>
	 	<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/address?shop_id='.$shop_id); ?>">
		 	<div class="member-nav-item">
		 		<div class="member-nav-left">
		 			<img src="/template/wap/default/public/img/member/member-icon-addr.png"> 
		 			<span class="ns-text-color-black">收货地址</span>
		 		</div>
		 		<div class="member-nav-right"><img src="/template/wap/default/public/img/member/member-icon-next.png"></div>
		 		<div class="clear"></div>
		 	</div>
	 	</a>
	 </div>
	 
	 <div class="member-nav-list">
		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/account?shop_id='.$shop_id); ?>">
		 	<div class="member-nav-item">
		 		<div class="member-nav-left">
		 			<img src="/template/wap/default/public/img/member/member-icon-withdraw.png"> 
		 			<span class="ns-text-color-black">提现账号</span>
		 		</div>
		 		<div class="member-nav-right"><img src="/template/wap/default/public/img/member/member-icon-next.png"></div>
		 		<div class="clear"></div>
		 	</div>
	 	</a>
<!-- 		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/login/qrcode'); ?>">
		 	<div class="member-nav-item">
		 		<div class="member-nav-left">
		 			<img src="/template/wap/default/public/img/member/member-icon-share.png"> 
		 			<span class="ns-text-color-black">推广二维码</span>
		 		</div>
		 		<div class="member-nav-right"><img src="/template/wap/default/public/img/member/member-icon-next.png"></div>
		 		<div class="clear"></div>
		 	</div>
	 	</a> -->
		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/coupon?shop_id='.$shop_id); ?>">
		 	<div class="member-nav-item">
		 		<div class="member-nav-left">
		 			<img src="/template/wap/default/public/img/member/member-icon-coupon.png"> 
		 			<span class="ns-text-color-black">优惠券</span>
		 		</div>
		 		<div class="member-nav-right"><img src="/template/wap/default/public/img/member/member-icon-next.png"></div>
		 		<div class="clear"></div>
		 	</div>
	 	</a>
	 </div>
	 
	 <div class="member-nav-list">
	 	<?php if(addon_is_exit('NsPintuan')): ?>
	 	<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/pintuan/lists'); ?>">
		 	<div class="member-nav-item">
		 		<div class="member-nav-left">
		 			<img src="/template/wap/default/public/img/member/member-icon-pintuan.png"> 
		 			<span class="ns-text-color-black">我的拼单</span>
		 		</div>
		 		<div class="member-nav-right"><img src="/template/wap/default/public/img/member/member-icon-next.png"></div>
		 		<div class="clear"></div>
		 	</div>
	 	</a>
	 	<?php endif; if(addon_is_exit('NsBargain')): ?>
	 	<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/bargain'); ?>">
		 	<div class="member-nav-item">
		 		<div class="member-nav-left">
		 			<img src="/template/wap/default/public/img/member/member-icon-bargain.png"> 
		 			<span class="ns-text-color-black">我的砍价</span>
		 		</div>
		 		<div class="member-nav-right"><img src="/template/wap/default/public/img/member/member-icon-next.png"></div>
		 		<div class="clear"></div>
		 	</div>
	 	</a>
	 	<?php endif; ?>
		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/Verification/code?shop_id='.$shop_id); ?>">
		 	<div class="member-nav-item">
		 		<div class="member-nav-left">
		 			<img src="/template/wap/default/public/img/member/member-icon-code.png"> 
		 			<span class="ns-text-color-black">虚拟码</span>
		 		</div>
		 		<div class="member-nav-right"><img src="/template/wap/default/public/img/member/member-icon-next.png"></div>
		 		<div class="clear"></div>
		 	</div>
	 	</a>
		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/winning?shop_id='.$shop_id); ?>">
		 	<div class="member-nav-item">
		 		<div class="member-nav-left">
		 			<img src="/template/wap/default/public/img/member/member-icon-winning.png"> 
		 			<span class="ns-text-color-black">中奖记录</span>
		 		</div>
		 		<div class="member-nav-right"><img src="/template/wap/default/public/img/member/member-icon-next.png"></div>
		 		<div class="clear"></div>
		 	</div>
	 	</a>
	 	
		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/collection?shop_id='.$shop_id); ?>">
		 	<div class="member-nav-item">
		 		<div class="member-nav-left">
		 			<img src="/template/wap/default/public/img/member/member-icon-collect.png"> 
		 			<span class="ns-text-color-black">收藏</span>
		 		</div>
		 		<div class="member-nav-right"><img src="/template/wap/default/public/img/member/member-icon-next.png"></div>
		 		<div class="clear"></div>
		 	</div>
	 	</a>
	 	
		<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/footprint?shop_id='.$shop_id); ?>">
		 	<div class="member-nav-item">
		 		<div class="member-nav-left">
		 			<img src="/template/wap/default/public/img/member/member-icon-fot.png"> 
		 			<span class="ns-text-color-black">足迹</span>
		 		</div>
		 		<div class="member-nav-right"><img src="/template/wap/default/public/img/member/member-icon-next.png"></div>
		 		<div class="clear"></div>
		 	</div>
	 	</a>
	 </div>
	 
<!-- 	 <div class="member-nav-list"> -->
<!-- 	 	<div class="member-nav-item"> -->
<!-- 	 		<div class="member-nav-left"> -->
<!-- 	 			<img src="/template/wap/default/public/img/member/member-icon-join.png">  -->
<!-- 	 			<span class="ns-text-color-black">商家加盟</span> -->
<!-- 	 		</div> -->
<!-- 	 		<div class="member-nav-right"><img src="/template/wap/default/public/img/member/member-icon-next.png"></div> -->
<!-- 	 		<div class="clear"></div> -->
<!-- 	 	</div> -->
<!-- 	 </div> -->
	 
</div>
<div class="h50"></div>
<script type="text/javascript">
function signIn(){
	/* api("System.Member.signIn",{},function (res) {
		if(res.data > 0){
			toast('签到成功');
			$('.sign-text').text("<?php echo lang('signed_in'); ?>");
		}
	}) */
	
}
</script>


<?php 
	$data = api('System.Config.bottomNav', []);
	$nav_list = $data['data'];
	$nav_width = 100/count($nav_list['template_data']);
	$this_url = substr($_SERVER['PATH_INFO'], -10);
	$this_url = $this_url == '/wap' ? '/wap/index' : $this_url;
 if(strpos($nav_list['showPage'], $this_url) !== false): ?>
<div class="bottom-menu">
<?php else: ?>
<div class="bottom-menu" style="display: none">
<?php endif; ?>
	<ul>
		<?php foreach($nav_list['template_data'] as $k => $v): ?>
		<li class="selected" style="width:<?php echo $nav_width; ?>%">
			<a href="<?php echo __URL($v['href']); ?>">
				<?php if(strpos(__URL($v['href']), $this_url) !== false && $this_url != ''): ?>
				<div id="bottom_home">
					<img src="<?php echo __IMG($v['img_src_hover']); ?>" data-hover-src="<?php echo __IMG($v['img_src']); ?>">
				</div>
				<span data-hover-color="<?php echo $v['color']; ?>" style="color:<?php echo $v['color_hover']; ?>"><?php echo $v['menu_name']; ?></span>
				<?php else: ?>
				<div id="bottom_home">
					<img src="<?php echo __IMG($v['img_src']); ?>" data-hover-src="<?php echo __IMG($v['img_src_hover']); ?>">
				</div>
				<span data-hover-color="<?php echo $v['color_hover']; ?>" style="color:<?php echo $v['color']; ?>"><?php echo $v['menu_name']; ?></span>
				<?php endif; ?>
			</a>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
<div></div>


<input type="hidden" id="niushop_rewrite_model" value="<?php echo rewrite_model(); ?>">
<input type="hidden" id="niushop_url_model" value="<?php echo url_model(); ?>">
<input type="hidden" value="<?php echo $uid; ?>" id="uid"/>
<input type="hidden" id="hidden_shop_name" value="<?php echo $web_info['title']; ?>">

</body>
</html>