<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:38:"template/wap\default\goods\detail.html";i:1554091139;s:54:"D:\phpStudy\WWW\niushop\template\wap\default\base.html";i:1553848818;}*/ ?>
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
	
<!--<link rel="stylesheet" href="/template/wap/default/public/plugin/swiper/css/swiper.min.css"/>-->
<!--<script src="/template/wap/default/public/plugin/swiper/js/swiper.min.js"></script>-->
<link rel="stylesheet" href="/template/wap/default/public/plugin/swipeslider/css/swipeslider.css"/>
<script src="/template/wap/default/public/plugin/swipeslider/js/swipeslider.js"></script>
<link href="/public/static/video/css/video-js.min.css" rel="stylesheet" type="text/css">
<script src="/public/static/video/js/video.min.js"></script>
<!--图片放大滑动插件-->
<!--<link rel="stylesheet" href="/template/wap/default/public/js/photoSwipe/photoswipe.css">-->
<!--<link rel="stylesheet" href="/template/wap/default/public/js/photoSwipe/default-skin.css">-->
<!--<script src="/template/wap/default/public/js/photoSwipe/photoswipe.js"></script>-->
<!--<script src="/template/wap/default/public/js/photoSwipe/photoswipe-ui-default.js"></script>-->
<!--<script type="text/javascript" src="/template/wap/default/public/js/touchslider.js"></script>-->
<link rel="stylesheet" href="/template/wap/default/public/css/goods_detail.css"/>

</head>
<body>
<?php 
	//默认图片
	$default_images = api("System.Config.defaultImages");
	$default_images = $default_images['data'];
	$default_goods_img = $default_images["value"]["default_goods_img"];//默认商品图片
	$default_headimg = $default_images["value"]["default_headimg"];//默认用户头像
 
	
	$goods_detail = $data['goods_detail'];
	
	//判断用户是否收藏该商品
	if(!empty($uid)){
		$whether_collection = api("System.Goods.whetherCollection",['fav_id'=>$goods_id,'fav_type'=>'goods']);
		$whether_collection = $whether_collection['data'];
	}
	
	//商家服务
	$merchant_service_list = api('System.Config.merchantService');
	$merchant_service_list = $merchant_service_list['data'];

	//客服
	$custom_service_config = api("System.Config.customService");
	$custom_service_config = $custom_service_config['data'];

	//检测当前是否是微信浏览器
	$is_weixin = api("System.Config.isWeixin");
	$is_weixin = $is_weixin['data'];

	//获取微信分享相关票据
	$share_ticket = api('System.Wchat.getShareTicket', []);
	$share_ticket = $share_ticket['data'];

 ?>
<article class="product">
	<div class="product-top-bar">
		<div class="top-bar-flex">
			
			<div class="left-btn">
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/index/index'); ?>" class="back-link">
					<svg t="1533609583435" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1035" xmlns:xlink="http://www.w3.org/1999/xlink" width="200" height="200">
						<path d="M369.728 512l384.768-384.704a48.64 48.64 0 0 0 0.896-68.8 48.64 48.64 0 0 0-68.736 0.96L269.44 476.736a48.704 48.704 0 0 0-11.136 17.344c-1.024 2.304-1.024 4.736-1.472 7.04-0.896 3.648-2.048 7.168-2.048 10.88 0 3.712 1.152 7.232 1.984 10.88 0.512 2.368 0.512 4.8 1.472 7.04a48.704 48.704 0 0 0 11.136 17.344l417.216 417.28a48.576 48.576 0 0 0 68.736 0.96 48.576 48.576 0 0 0-0.896-68.736L369.728 512z" p-id="1036"></path>
					</svg>
					<span>返回</span>
				</a>
			</div>
			
			<ul class="header-nav">
				<li data-flag="goods" class="active">商品</li>
				<li data-flag="evaluation">评价</li>
				<li data-flag="details">详情</li>
			</ul>
			
			<div class="right-btn">
				<?php if($is_weixin == 1): ?>
				<a href="javascript:document.getElementById('share_img').style.display='block';" style="display: none">
					<i class="fa fa-share" aria-hidden="true"></i>
				</a>
				<?php else: endif; ?>
				<a href="javascript:;" class="js-collection" data-whether-collection="<?php echo $whether_collection; ?>">
					<?php if($whether_collection > 0): ?>
					<i class="fa fa-heart" aria-hidden="true"></i>
					<?php else: ?>
					<i class="fa fa-heart-o" aria-hidden="true"></i>
					<?php endif; ?>
					<span>收藏</span>
				</a>
				
			</div>
			
		</div>
	</div>
	
	<div class="go-top">
		<img src="/template/wap/default/public/img/goods/go_top_for_detail.png" />
		<span>顶部</span>
	</div>
	
	<?php if(!(empty($goods_detail['goods_video_address']) || (($goods_detail['goods_video_address'] instanceof \think\Collection || $goods_detail['goods_video_address'] instanceof \think\Paginator ) && $goods_detail['goods_video_address']->isEmpty()))): ?>
	<div class="goods-alter">
		<span class="goods-alter-image on">图片</span>
		<span class="goods-alter-video">视频</span>
	</div>
	<?php endif; ?>
	
	<!--<div class="product-media swiper-container">-->
		<!--<div class="swiper-wrapper">-->
			<!--<?php if(is_array($goods_detail['img_list']) || $goods_detail['img_list'] instanceof \think\Collection || $goods_detail['img_list'] instanceof \think\Paginator): if( count($goods_detail['img_list'])==0 ) : echo "" ;else: foreach($goods_detail['img_list'] as $key=>$img_list): ?>-->
			<!--<div class="swiper-slide">-->
				<!--<a href="#">-->
					<!--<img alt="<?php echo lang('goods_picture'); ?>" src="<?php echo __IMG($img_list['pic_cover_mid']); ?>"/>-->
				<!--</a>-->
			<!--</div>-->
			<!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
		<!--</div>-->
		<!---->
		<!--<div class="swiper-pagination"></div>-->
	<!--</div>-->
	
	<div class="product-media swipslider">
		<ul class="sw-slides">
			<?php if(is_array($goods_detail['img_list']) || $goods_detail['img_list'] instanceof \think\Collection || $goods_detail['img_list'] instanceof \think\Paginator): if( count($goods_detail['img_list'])==0 ) : echo "" ;else: foreach($goods_detail['img_list'] as $key=>$img_list): ?>
			<div class="sw-slide">
				<a href="#">
					<img alt="<?php echo lang('goods_picture'); ?>" src="<?php echo __IMG($img_list['pic_cover_big']); ?>"/>
				</a>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
	
	<?php if(!(empty($goods_detail['goods_video_address']) || (($goods_detail['goods_video_address'] instanceof \think\Collection || $goods_detail['goods_video_address'] instanceof \think\Paginator ) && $goods_detail['goods_video_address']->isEmpty()))): ?>
	<div class="video-wrap">
		<video id="video" class="video-js vjs-default-skin" controls preload="none" poster="<?php echo __IMG($goods_detail['img_list'][0]['pic_cover_big']); ?>" data-setup="{}">
			<source src="<?php echo __IMG($goods_detail['goods_video_address']); ?>" type='video/mp4' />
		</video>
	</div>
	<?php endif; if($goods_detail['promotion_detail']['pintuan']): ?>
	
	<!--拼团-->
	<div class="promotion-pintuan">
		<div class="price-info">
			<div class="pintuan-money"><i class="yen">¥</i><?php echo $goods_detail['promotion_detail']['pintuan']['data']['tuangou_money']; ?></div>
			<div class="promotion-price">
				<del>¥ <?php echo $goods_detail['promotion_price']; ?></del>
				<span><?php echo $goods_detail['sales']; if(empty($goods_detail['goods_unit'])): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?>已售</span>
			</div>
		</div>
		<div class="pintuan-type-name"><?php echo $goods_detail['promotion_detail']['pintuan']['data']['tuangou_type_info']['type_name']; ?></div>
	</div>
	<?php if(!(empty($goods_detail['promotion_detail']['pintuan']['data']['tuangou_content_json']['colonel_content']) || (($goods_detail['promotion_detail']['pintuan']['data']['tuangou_content_json']['colonel_content'] instanceof \think\Collection || $goods_detail['promotion_detail']['pintuan']['data']['tuangou_content_json']['colonel_content'] instanceof \think\Paginator ) && $goods_detail['promotion_detail']['pintuan']['data']['tuangou_content_json']['colonel_content']->isEmpty()))): ?>
	<p class="pintuan-content ns-text-color"><?php echo $goods_detail['promotion_detail']['pintuan']['data']['tuangou_content_json']['colonel_content']; ?></p>
	<?php endif; ?>
	<div class="blank-line"></div>
	
	<?php elseif($goods_detail['promotion_detail']['bargain'] && $bargain_id): ?>
	
	<!--砍价-->
	<div class="product-discount">
		<div class="price-info">
			<div class="actprice"><i class="yen">¥</i><?php if($goods_detail['promotion_price'] < $goods_detail['member_price']): ?><?php echo $goods_detail['promotion_price']; else: ?><?php echo $goods_detail['member_price']; endif; ?></div>
			<div class="origprice">
				<span class="oprice"><del>¥ <?php echo $goods_detail['promotion_price']; ?></del></span>
				<span class="actual_sale"><?php echo $goods_detail['sales']; if(empty($goods_detail['goods_unit'])): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?>已售</span>
			</div>
		</div>
		
		<div class="countdown">
			<div class="txt" data-value="<?php echo $goods_detail['promotion_detail']['bargain']['data']['end_time']; ?>"><?php echo lang('distance_ends'); ?></div>
			<div class="clockrun">
				<span class="num" id="day">00</span><span class="dot">:</span>
				<span class="num" id="hour">00</span><span class="dot">:</span>
				<span class="num" id="min">00</span><span class="dot">.</span>
				<span class="num" id="second">00</span>
			</div>
		</div>
	</div>
	
	<?php elseif($goods_detail['promotion_detail']['group_buy']): ?>
	
	<!--团购-->
	<div class="product-discount">
		<div class="price-info">
			<div class="actprice"><i class="yen">¥</i><?php echo $goods_detail['promotion_detail']['group_buy']['data']['price_array'][0]['group_price']; ?></div>
			<div class="origprice">
				<span class="oprice"><del>¥ <?php echo $goods_detail['promotion_price']; ?></del></span>
				<span class="actual_sale"><?php echo $goods_detail['sales']; if(empty($goods_detail['goods_unit'])): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?>已售</span>
			</div>
		</div>
		
		<div class="countdown">
			<div class="txt" data-value="<?php echo $goods_detail['promotion_detail']['group_buy']['data']['end_time']; ?>"><?php echo lang('distance_ends'); ?></div>
			<div class="clockrun">
				<span class="num" id="day">00</span><span class="dot">:</span>
				<span class="num" id="hour">00</span><span class="dot">:</span>
				<span class="num" id="min">00</span><span class="dot">.</span>
				<span class="num" id="second">00</span>
			</div>
		</div>
	</div>
	
	<?php elseif($goods_detail['promotion_detail']['discount_detail']): ?>
	
	<!--限时折扣-->
	<div class="product-discount">
		<div class="price-info">
			<div class="actprice"><i class="yen">¥</i><?php if($goods_detail['is_show_member_price'] == 1): ?><?php echo $goods_detail['member_price']; else: ?><?php echo $goods_detail['promotion_price']; endif; ?></div>
			<div class="origprice">
				<span class="oprice"><del>¥ <?php echo $goods_detail['price']; ?></del></span>
				<span class="actual_sale"><?php echo $goods_detail['sales']; if(empty($goods_detail['goods_unit'])): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?>已售</span>
			</div>
		</div>
		
		<div class="countdown">
			<div class="txt" data-value="<?php echo $goods_detail['promotion_detail']['discount_detail']['end_time']; ?>"><?php echo lang('distance_ends'); ?></div>
			<div class="clockrun">
				<span class="num" id="day">00</span><span class="dot">:</span>
				<span class="num" id="hour">00</span><span class="dot">:</span>
				<span class="num" id="min">00</span><span class="dot">.</span>
				<span class="num" id="second">00</span>
			</div>
		</div>
	</div>
	<?php endif; ?>
	
	<div class="product-name-wrap">
		<div class="product-name-block have-share">
			<?php if(is_array($goods_detail['goods_group_list']) || $goods_detail['goods_group_list'] instanceof \think\Collection || $goods_detail['goods_group_list'] instanceof \think\Paginator): $i = 0; $__LIST__ = $goods_detail['goods_group_list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<i class="product-label"><?php echo $vo['group_name']; ?> <?php echo $detail['product_label']['label_name']; ?></i>
			<?php endforeach; endif; else: echo "" ;endif; ?>
			<span id="product-name"><?php echo $goods_detail['goods_name']; ?> <?php echo $goods_detail['sku_name']; ?></span>
			<div class="product-share" onclick="document.getElementById('share_img').style.display='block';">
				<img src="/template/wap/default/public/img/goods/share.png"/>
				<span><?php echo lang('share'); ?></span>
			</div>
		</div>
	</div>
	
	<?php if(!(empty($goods_detail['introduction']) || (($goods_detail['introduction'] instanceof \think\Collection || $goods_detail['introduction'] instanceof \think\Paginator ) && $goods_detail['introduction']->isEmpty()))): ?>
	<p class="product-introduction"><?php echo $goods_detail['introduction']; ?></p>
	<?php endif; if(!$goods_detail['promotion_detail']): ?>
	<!--普通商品显示-->
	<div class="product-price">
		<div class="real-price">
			<?php if($goods_detail['is_open_presell'] == 1): ?>
			
				<!--预售-->
				<span class="price"><?php echo lang('goods_deposit'); ?>¥<?php echo $goods_detail['presell_price']; ?></span>
			
			<?php elseif($goods_detail['point_exchange_type'] == 2 || $goods_detail['point_exchange_type'] == 3): ?>
			
				<!--积分-->
				<span class="price"><?php echo $goods_detail['point_exchange']; ?><?php echo lang('goods_integral'); ?></span>
			
			<?php elseif($goods_detail['is_show_member_price'] == 1): ?>
			
				<i class="price-symbol">¥</i>
				<span class="price"><?php echo $goods_detail['member_price']; if($goods_detail['point_exchange_type']==1 && $goods_detail['point_exchange']>0): ?>+<?php echo $goods_detail['point_exchange']; ?><?php echo lang('goods_integral'); endif; ?></span>
				<!--积分加现金-->
			
				<?php if(!empty($goods_detail['goods_unit'])): ?>
				<span class="ns-text-color">/<?php echo $goods_detail['goods_unit']; ?></span>
				<?php endif; else: ?>
			
				<i class="price-symbol">¥</i>
				<span class="price"><?php echo $goods_detail['promotion_price']; if($goods_detail['point_exchange_type']==1 && $goods_detail['point_exchange']>0): ?>+<?php echo $goods_detail['point_exchange']; ?><?php echo lang('goods_integral'); endif; ?></span>
				<!--积分加现金-->
				<?php if(!empty($goods_detail['goods_unit'])): ?>
				<span class="ns-text-color">/<?php echo $goods_detail['goods_unit']; ?></span>
				<?php endif; endif; ?>
			
			<!--<span class="icon-text">$detail['product_label']['label_name']}</span>-->
			
		</div>
		
		<?php if($goods_detail['market_price'] > 0): ?>
			<div class="original-price">
				<label>原价:</label>
				<span>¥<?php echo $goods_detail['market_price']; ?></span>
			</div>
		<?php endif; ?>
		
	</div>
	<?php endif; ?>
	
	<div class="blank-line"></div>
	
	<?php if($goods_detail['promotion_detail']['pintuan'] && $goods_detail['promotion_detail']['pintuan']['data']['tuangou_group_count']==0): ?>
	
		<!--参与其他拼团-->
		<?php 
		$pintuan_list = api('NsPintuan.Pintuan.pintuanList', ['page_index' => 1, 'page_size' => 0,'condition'=>"goods_id=$goods_id and status=1",'order' => 'create_time desc']);
		$pintuan_list = $pintuan_list['data'];
		 if($pintuan_list['data']): ?>
		<div class="spelling-block">
			<ul>
				<?php if(is_array($pintuan_list['data']) || $pintuan_list['data'] instanceof \think\Collection || $pintuan_list['data'] instanceof \think\Paginator): if( count($pintuan_list['data'])==0 ) : echo "" ;else: foreach($pintuan_list['data'] as $k=>$vo): ?>
				<li>
					<div class="user-logo">
						<?php if($vo['group_user_head_img']): ?>
						<img src="<?php echo __IMG($vo['group_user_head_img']); ?>"/>
						<?php else: ?>
						<img src="<?php echo __IMG($default_headimg); ?>"/>
						<?php endif; ?>
					</div>
					<span class="user-name"><?php echo $vo['group_name']; ?></span>
					<button data-group-id="<?php echo $vo['group_id']; ?>" data-poor-num="<?php echo $vo['poor_num']; ?>" data-end-time="<?php echo $vo['end_time']; ?>">去拼单</button>
					<div class="info">
						<span>还差<strong><?php echo $vo['poor_num']; ?>人</strong>拼成</span>
						<br/>
						<input type="hidden" id="spelling_end_time<?php echo $k; ?>" value="<?php echo $vo['end_time']; ?>"/>
						<time id="remaining_time<?php echo $k; ?>">剩余:00:00:00</time>
					</div>
				</li>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
		<?php endif; ?>
	
		<div class="mask-layer-bg"></div>
		<div class="mask-layer-spelling">
			<h3>参与<strong></strong>的拼单</h3>
			<p>仅剩<strong>1</strong>个名额，<time>00:00:00后结束</time></p>
			<img class="mask-layer-spelling-close" src="/template/wap/default/public/img/goods/mask_layer_spelling_close.png"/>
			<div class="user-list">
				<ul>
					<li>
						<span class="boss">拼主</span>
						<img src="/template/wap/default/public/img/goods/member_default.png"/>
					</li>
					<li>
						<img src="/template/wap/default/public/img/goods/spelling_who.png"/>
					</li>
				</ul>
			</div>
			<button>参与拼单</button>
		</div>
		
		<div class="blank-line"></div>
	<?php endif; if(!(empty($goods_detail['goods_coupon_list']) || (($goods_detail['goods_coupon_list'] instanceof \think\Collection || $goods_detail['goods_coupon_list'] instanceof \think\Paginator ) && $goods_detail['goods_coupon_list']->isEmpty()))): ?>
	<div class="product-coupon">
		<i class="flag">优惠券</i>
		<span class="coupon-tip">领取优惠劵</span>
		<span class="get-coupon">领取</span>
	</div>
	<div class="product-coupon-popup-layer">
		<h3 class="tax-title">优惠券</h3>
		<div class="coupon-body">
			<?php if(is_array($goods_detail['goods_coupon_list']) || $goods_detail['goods_coupon_list'] instanceof \think\Collection || $goods_detail['goods_coupon_list'] instanceof \think\Paginator): if( count($goods_detail['goods_coupon_list'])==0 ) : echo "" ;else: foreach($goods_detail['goods_coupon_list'] as $key=>$vo): ?>
			<div class="item <?php if($vo['max_fetch'] != 0 && $vo['receive_quantity'] > $vo['max_fetch']): ?>receive<?php endif; ?>" data-max-fetch="<?php echo $vo['max_fetch']; ?>" data-receive-quantity="<?php echo $vo['receive_quantity']; ?>" data-coupon-id="<?php echo $vo['coupon_type_id']; ?>">
				<div class="main">
					<div class="price">
						<i>¥</i>
						<span><?php echo $vo['money']; ?></span>
					</div>
					<?php if($vo['at_least'] > 0): ?>
					<div class="sub">满<?php echo $vo['at_least']; ?>使用</div>
					<?php else: ?>
					<div class="sub">无门槛优惠券</div>
					<?php endif; ?>
					<div class="sub">有效期 <?php echo date("Y.m.d",$vo['start_time']); ?>-<?php echo date("Y.m.d",$vo['end_time']); ?></div>
				</div>
				<div class="tax-split"></div>
				<div class="tax-operator"><?php if($vo['max_fetch'] != 0 && $vo['receive_quantity'] > $vo['max_fetch']): ?>已领取<?php else: ?>立即领取<?php endif; ?></div>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		<div class="confirm">确定</div>
	</div>
	<div class="blank-line"></div>
	<?php endif; ?>

	<div class="product-sales-freight-area">
		<span class="postage js-shipping-fee-name">快递:&nbsp;<?php if($detail['shipping_fee'] == 0): ?>免邮<?php else: ?>¥<?php echo $detail['shipping_fee']; endif; ?></span>
		<span class="sales">销量:&nbsp;<?php echo $goods_detail['sales']; if($goods_detail['goods_unit']): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?></span>
		<span class="delivery">点击量：<?php echo $goods_detail['clicks']; ?></span>
	</div>
	
	<div class="blank-line"></div>
	
	<?php if($goods_detail['mansong_name'] != ''): ?>
	<div class="product-mansong">
		<i><?php echo lang('member_full'); ?><?php echo lang('member_reduce'); ?></i>
		<span class="sales"><?php echo $goods_detail['mansong_name']; ?></span>
	</div>
	<div class="blank-line"></div>
	<?php endif; ?>
	
	<!-- 阶梯优惠 -->
	<?php if(!(empty($goods_detail['goods_ladder_preferential_list']) || (($goods_detail['goods_ladder_preferential_list'] instanceof \think\Collection || $goods_detail['goods_ladder_preferential_list'] instanceof \think\Paginator ) && $goods_detail['goods_ladder_preferential_list']->isEmpty()))): ?>
	<div class="product-ladder-preferential">
		<i><?php echo lang('ladder_preferential'); ?></i>
		<span>满<b class="ns-text-color"><?php echo $goods_detail['goods_ladder_preferential_list'][0]['quantity']; ?></b><?php if(empty($goods_detail['goods_unit'])): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?>,每<?php if(empty($goods_detail['goods_unit'])): ?>件<?php else: ?><?php echo $goods_detail['goods_unit']; endif; ?>降<b class="ns-text-color"><?php echo $goods_detail['goods_ladder_preferential_list'][0]['price']; ?></b>元</span>
		<div class="icon">
			<svg t="1516605784224" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1221" xmlns:xlink="http://www.w3.org/1999/xlink" width="13" height="13">
				<path d="M393.390114 512.023536l347.948667-336.348468c20.50808-19.85828 20.50808-51.997258 0-71.792093-20.507056-19.826558-53.778834-19.826558-74.28589 0L281.990954 476.135164c-20.476357 19.826558-20.476357 51.981908 0 71.746044l385.061936 372.236839c10.285251 9.91379 23.728424 14.869662 37.173644 14.869662 13.446243 0 26.889417-4.956895 37.112246-14.901385 20.50808-19.826558 20.50808-51.919487 0-71.746044L393.390114 512.023536" p-id="1222"></path>
			</svg>
		</div>
	</div>
	
	<div class="product-ladder-preferential-popup-layer">
		<h3 class="tax-title"><?php echo lang('ladder_preferential'); ?></h3>
		<ul>
			<?php if(is_array($goods_detail['goods_ladder_preferential_list']) || $goods_detail['goods_ladder_preferential_list'] instanceof \think\Collection || $goods_detail['goods_ladder_preferential_list'] instanceof \think\Paginator): if( count($goods_detail['goods_ladder_preferential_list'])==0 ) : echo "" ;else: foreach($goods_detail['goods_ladder_preferential_list'] as $key=>$vo): ?>
			<li>
				<span class="mark_title"><?php echo lang("ladder_preferential"); ?></span>
				<span>满<b style="color: red;"><?php echo $vo['quantity']; ?></b><?php if(empty($goods_detail['goods_unit'])): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?>,每<?php if(empty($goods_detail['goods_unit'])): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?>降<b style="color: red;"><?php echo $vo['price']; ?></b>元</span>
			</li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
		<div class="confirm js-confirm">确定</div>
	</div>
	
	<div class="blank-line"></div>
	<?php endif; if($goods_detail['max_buy']>0): ?>
	<!--最大购买量-->
	<div class="product-baoyou">
		<i><?php echo lang('goods_quantity_purchased'); ?></i>
		<span><?php echo $goods_detail['max_buy']; if(empty($goods_detail['goods_unit'])): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?></span>
	</div>
	<div class="blank-line"></div>
	<?php endif; if($goods_detail['min_buy']>0): ?>
	<!--最小购买量-->
	<div class="product-baoyou">
		<i><?php echo lang('minimum_purchase_quantity'); ?></i>
		<span><?php echo $goods_detail['min_buy']; if(empty($goods_detail['goods_unit'])): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?></span>
	</div>
	<div class="blank-line"></div>
	<?php endif; ?>
	
	<!-- 实物商品参加包邮活动 -->
	<?php if($goods_detail['goods_type'] == 1 && $goods_detail['baoyou_name'] != ''): ?>
	<div class="product-baoyou">
		<i><?php echo lang('goods_free_shipping'); ?></i>
		<span><?php echo $goods_detail['baoyou_name']; ?></span>
	</div>
	<div class="blank-line"></div>
	<?php endif; ?>
	
	<!--赠送积分-->
	<?php if($goods_detail['give_point'] != 0): ?>
	<div class="product-give-point">
		<i><?php echo lang('goods_gift_points'); ?></i>
		<span><?php echo $goods_detail['give_point']; ?><?php echo lang('minutes'); ?></span>
	</div>
	<div class="blank-line"></div>
	<?php endif; ?>
	
	<!-- 积分抵现 -->
	<?php if($integral_balance > 0): ?>
	<div class="product-point-for-now">
		<span>购买本商品积分可抵<?php echo $integral_balance; ?>元</span>
	</div>
	<div class="blank-line"></div>
	<?php endif; if($goods_detail['is_open_presell'] == 1): ?>
	<div class="product-presell-delivery-time">
		<span><?php echo lang('goods_delivery_time'); ?></span>
		<?php if($goods_detail['presell_delivery_type'] == 1): ?>
		<span><?php echo getTimeStampTurnTime($goods_detail['presell_time']); ?>发货</span>
		<?php else: ?>
		<span>付款<?php echo $goods_detail['presell_day']; ?>后发货</span>
		<?php endif; ?>
	</div>
	<div class="blank-line"></div>
	<?php endif; ?>
	
	<div class="product-service">
		<span>服务</span>
		<span>由<?php echo $title; ?>发货并提供售后服务</span>
	</div>
	<div class="blank-line"></div>
	
	<!-- 商家服务 -->
	<?php if(count($merchant_service_list) > 0): ?>
	<div class="product-merchants-service">
		<div class="service-list">
			<ul>
				<?php if(is_array($merchant_service_list) || $merchant_service_list instanceof \think\Collection || $merchant_service_list instanceof \think\Paginator): if( count($merchant_service_list)==0 ) : echo "" ;else: foreach($merchant_service_list as $k=>$vo): if($k < 4): ?>
				<li><?php echo $vo['title']; ?></li>
				<?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
		<div class="icon">
			<svg t="1516605784224" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1221" xmlns:xlink="http://www.w3.org/1999/xlink" width="13" height="13">
				<path d="M393.390114 512.023536l347.948667-336.348468c20.50808-19.85828 20.50808-51.997258 0-71.792093-20.507056-19.826558-53.778834-19.826558-74.28589 0L281.990954 476.135164c-20.476357 19.826558-20.476357 51.981908 0 71.746044l385.061936 372.236839c10.285251 9.91379 23.728424 14.869662 37.173644 14.869662 13.446243 0 26.889417-4.956895 37.112246-14.901385 20.50808-19.826558 20.50808-51.919487 0-71.746044L393.390114 512.023536" p-id="1222"></path>
			</svg>
		</div>
	</div>
	
	<div class="product-merchants-service-popup-layer">
		<h3 class="tax-title"><?php echo lang('merchant_service'); ?></h3>
		<dl>
			<?php if(!(empty($merchant_service_list) || (($merchant_service_list instanceof \think\Collection || $merchant_service_list instanceof \think\Paginator ) && $merchant_service_list->isEmpty()))): if(is_array($merchant_service_list) || $merchant_service_list instanceof \think\Collection || $merchant_service_list instanceof \think\Paginator): if( count($merchant_service_list)==0 ) : echo "" ;else: foreach($merchant_service_list as $key=>$vo): ?>
			<dt>
				<img src="<?php echo __IMG($vo['pic']); ?>">
				<span><?php echo $vo['title']; ?></span>
			</dt>
			<dd><?php echo $vo['describe']; ?></dd>
			<?php endforeach; endif; else: echo "" ;endif; endif; ?>
		</dl>
		<div class="confirm js-confirm">确定</div>
	</div>
	
	<div class="blank-line"></div>
	<?php endif; ?>
	
	<!-- 商品属性 -->
	<?php if($goods_detail['goods_attribute_list']): ?>
	<div class="product-attribute">
		<div class="l">属性</div>
		<div class="r"><?php echo $goods_detail["goods_attribute_list"][0]['attr_value']; ?>&nbsp;<?php echo $goods_detail["goods_attribute_list"][0]['attr_value_name']; ?>...</div>
		<div class="icon">
			<svg t="1516605784224" class="icon-viewall" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1221" xmlns:xlink="http://www.w3.org/1999/xlink" width="13" height="13">
				<path d="M393.390114 512.023536l347.948667-336.348468c20.50808-19.85828 20.50808-51.997258 0-71.792093-20.507056-19.826558-53.778834-19.826558-74.28589 0L281.990954 476.135164c-20.476357 19.826558-20.476357 51.981908 0 71.746044l385.061936 372.236839c10.285251 9.91379 23.728424 14.869662 37.173644 14.869662 13.446243 0 26.889417-4.956895 37.112246-14.901385 20.50808-19.826558 20.50808-51.919487 0-71.746044L393.390114 512.023536" p-id="1222"></path>
			</svg>
		</div>
	</div>
	<div class="product-attribute-popup-layer">
		<div class="product-attribute-body">
			<h2>基础信息</h2>
			<table>
				<tbody>
				<?php foreach($goods_detail["goods_attribute_list"] as $vo): if(!(empty($vo['attr_value_name']) || (($vo['attr_value_name'] instanceof \think\Collection || $vo['attr_value_name'] instanceof \think\Paginator ) && $vo['attr_value_name']->isEmpty()))): ?>
				<tr>
					<th><?php echo $vo['attr_value']; ?></th>
					<td><?php echo $vo['attr_value_name']; ?></td>
				</tr>
				<?php endif; endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class="confirm js-confirm">确定</div>
	</div>
	<div class="blank-line"></div>
	<?php endif; if($goods_detail['goods_type'] == 1): ?>
	<!-- 商品组合套餐，普通商品才能使用 -->
	<?php if(!(empty($goods_detail['promotion_detail']['combo_package']) || (($goods_detail['promotion_detail']['combo_package'] instanceof \think\Collection || $goods_detail['promotion_detail']['combo_package'] instanceof \think\Paginator ) && $goods_detail['promotion_detail']['combo_package']->isEmpty()))): ?>
	<div class="product-combo" onclick="location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/combo','goods_id='.$goods_detail['promotion_detail']['combo_package']['data'][0]['main_goods']['goods_id']); ?>'">
		<span><?php echo lang("combo_package"); ?></span>
		<div class="icon">
			<svg t="1516605784224" class="icon-viewall" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1221" xmlns:xlink="http://www.w3.org/1999/xlink" width="13" height="13">
				<path d="M393.390114 512.023536l347.948667-336.348468c20.50808-19.85828 20.50808-51.997258 0-71.792093-20.507056-19.826558-53.778834-19.826558-74.28589 0L281.990954 476.135164c-20.476357 19.826558-20.476357 51.981908 0 71.746044l385.061936 372.236839c10.285251 9.91379 23.728424 14.869662 37.173644 14.869662 13.446243 0 26.889417-4.956895 37.112246-14.901385 20.50808-19.826558 20.50808-51.919487 0-71.746044L393.390114 512.023536" p-id="1222"></path>
			</svg>
		</div>
	</div>
	<div class="combo-goods-wrap">
		<div class="goods">
			<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/detail','goods_id='.$goods_detail['promotion_detail']['combo_package']['data'][0]['main_goods']['goods_id']); ?>">
				<img src="<?php echo __IMG($goods_detail['promotion_detail']['combo_package']['data'][0]['main_goods']['pic_cover_mid']); ?>">
				<p>¥<?php echo $goods_detail['promotion_detail']['combo_package']['data'][0]['main_goods']['price']; ?></p>
			</a>
		</div>
		<i class="fa fa-plus" aria-hidden="true"></i>
		<?php if(is_array($goods_detail['promotion_detail']['combo_package']['data'][0]['goods_array']) || $goods_detail['promotion_detail']['combo_package']['data'][0]['goods_array'] instanceof \think\Collection || $goods_detail['promotion_detail']['combo_package']['data'][0]['goods_array'] instanceof \think\Paginator): if( count($goods_detail['promotion_detail']['combo_package']['data'][0]['goods_array'])==0 ) : echo "" ;else: foreach($goods_detail['promotion_detail']['combo_package']['data'][0]['goods_array'] as $k=>$vo): if($k < 2): ?>
		<div class="goods">
			<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/detail','goods_id='.$vo['goods_id']); ?>">
				<img src="<?php echo __IMG($vo['pic_cover_mid']); ?>">
				<p>¥<?php echo $vo['price']; ?></p>
			</a>
		</div>
		<?php endif; endforeach; endif; else: echo "" ;endif; ?>
	</div>
	<div class="blank-line"></div>
	<?php endif; endif; ?>
	
	<!-- 商品评价 -->
	<div class="product-evaluation-main">
		<div class="product-evaluation-title">
			<span>商品评价 (<em class="js-evaluate-count">0</em>)</span>
			<div class="view-more">
				<span>查看全部</span>
				<svg t="1516605784224" class="icon-viewall" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1221" xmlns:xlink="http://www.w3.org/1999/xlink" width="13" height="13">
					<path d="M393.390114 512.023536l347.948667-336.348468c20.50808-19.85828 20.50808-51.997258 0-71.792093-20.507056-19.826558-53.778834-19.826558-74.28589 0L281.990954 476.135164c-20.476357 19.826558-20.476357 51.981908 0 71.746044l385.061936 372.236839c10.285251 9.91379 23.728424 14.869662 37.173644 14.869662 13.446243 0 26.889417-4.956895 37.112246-14.901385 20.50808-19.826558 20.50808-51.919487 0-71.746044L393.390114 512.023536" p-id="1222"></path>
				</svg>
			</div>
		</div>
		
		<ul class="product-evaluation-ul js-product-evaluation">
			<li>全部评价(<em class="js-evaluate-count">0</em>)</li>
			<li>晒图(<em class="js-evaluate-imgs-count">0</em>)</li>
			<li><?php echo lang('goods_praise'); ?>(<em class="js-evaluate-praise-count">0</em>)</li>
			<li><?php echo lang('goods_comments'); ?>(<em class="js-evaluate-center-count">0</em>)</li>
			<li><?php echo lang('goods_bad'); ?>(<em class="js-evaluate-bad-count">0</em>)</li>
		</ul>
		
		<div class="product-comments js-first-evaluate">
			<div class="user">
				<img src="<?php echo __IMG($default_headimg); ?>">
				<span></span>
			</div>
			<div class="product-content"></div>
			<div class="date"></div>
		</div>
		
		<div class="mui-cover">
			<header>
				<h1>评价</h1>
				<a class="back"></a>
			</header>
			<div class="body">
				<div class="review-content">
					<ul class="filter">
						<li class="comment-filter-none current" data-type="0">全部评价(<b class="js-evaluate-count">0</b>)</li>
						<li class="comment-filter-img" data-type="4">晒图(<b class="js-evaluate-imgs-count">0</b>)</li>
						<li class="tag-product" data-type="1" ><?php echo lang('goods_praise'); ?>(<b class="js-evaluate-praise-count">0</b>)</li>
						<li class="tag-product" data-type="2"><?php echo lang('goods_comments'); ?>(<b class="js-evaluate-center-count">0</b>)</li>
						<li class="comment-filter-append" data-type="3"><?php echo lang('goods_bad'); ?>(<b class="js-evaluate-bad-count">0</b>)</li>
					</ul>
					<div class="mescroll" id="evaluation_list_mescroll">
						<ul class="evaluation-list"></ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="blank-line"></div>
	
	<div class="product-details"><?php echo $goods_detail['description']; ?></div>
	
	<div class="copyright">
		<div class="ft-copyright">
			<img src="/template/wap/default/public/img/logo_copy.png" id="copyright_logo_wap">
			<a href="javascript:;" target="_blank" id="copyright_companyname"></a>
		</div>
		<?php echo $web_info['third_count']; ?>
	</div>
	
	<div class="product-bottom-bar">
		<div style="height:50px;"></div>
		<div class="bottom-btn">
			
			<?php if($goods_detail['state'] == 1): ?>
				<div class="left-operation">
					<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap'); ?>">
						<img src="/template/wap/default/public/img/goods/go_home.png"/>
						<span><?php echo lang("home_page"); ?></span>
					</a>
					<a href="<?php echo $custom_service_config['value']['service_addr']; ?>">
						<img src="/template/wap/default/public/img/goods/kefux.png"/>
						<span><?php echo lang('united_states_customer_service'); ?></span>
					</a>
					<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/cart'); ?>" class="shopping-cart-flag <?php if($carcount>0): ?>buy-cart-msg<?php endif; ?>">
						<img src="/template/wap/default/public/img/goods/goods_cart.png"/>
						<span><?php echo lang('goods_cart'); ?></span>
					</a>
				</div>
				<div class="right-operation">
					<?php if($goods_detail['promotion_detail']['bargain'] && $bargain_id): ?>
					
					<!--砍价-->
					<a href="javascript:;" class="red" data-tag="bargain"><?php echo lang('goods_start_bargain'); ?></a>
					
					<?php elseif($goods_detail['promotion_detail']['pintuan']): ?>
					
						<!--拼团-->
						<?php if($goods_detail['promotion_detail']['pintuan']['data']['tuangou_group_count'] == 0): ?>
					
						<a href="javascript:;" class="orange pintuan" data-tag="buy_now" data-top-permissions="1" data-order-type="1">
							<span class="goods-price">¥<?php if($goods_detail['promotion_price'] < $goods_detail['member_price']): ?><?php echo $goods_detail['promotion_price']; else: ?><?php echo $goods_detail['member_price']; endif; ?></span>
							<br>
							<span><?php echo lang('goods_alone_purchase'); ?></span>
						</a>
						<a href="javascript:;" class="red pintuan" data-tag="buy_now" data-order-type="4">
							<span class="goods-price">¥<?php echo $goods_detail['promotion_detail']['pintuan']['data']['tuangou_money']; ?></span>
							<br>
							<span class="click-font"><?php echo lang('goods_start_share'); ?></span>
						</a>
						<?php else: ?>
					
						<a href="javascript:;" class="red pintuan" data-tag="buy_now" data-order-type="4">
							<span class="goods-price">¥<?php echo $goods_detail['promotion_detail']['pintuan']['data']['tuangou_money']; ?></span>
							<br>
							<span class="click-font"><?php echo lang('join_together'); ?></span>
						</a>
					
						<?php endif; elseif($goods_detail['is_open_presell'] == 1): ?>
					
						<!--预售-->
						<a href="javascript:;" class="red" data-tag="buy_now"><?php echo lang('goods_immediate_reservation'); ?></a>
					
					<?php else: if($goods_detail['goods_type'] == 1 && $goods_detail['integral_flag'] == 0 && !$goods_detail['promotion_detail']['group_buy']): ?>
						<!--只有普通商品可以加入购物车-->
						<a href="javascript:;" class="orange" data-tag="add_cart"><?php echo lang('goods_add_cart'); ?></a>
						<?php endif; ?>
					
						<a href="javascript:;" class="red" data-tag="buy_now"><?php if($goods_detail['integral_flag'] == 1): ?><?php echo lang('goods_exchange'); else: ?><?php echo lang('goods_buy_now'); endif; ?></a>
					
					<?php endif; ?>
					
				</div>
		
			<?php else: ?>
			<div class="product-sold-out"><?php echo lang('goods_laid_off'); ?></div>
			<?php endif; ?>
			
		</div>
		
		<div class="widgets-cover">
			<div class="cover-content">
				<div class="sku-wrap">
					<div class="header">
						<div class="img-wrap">
							<img src="<?php echo __IMG($goods_detail['img_list'][0]['pic_cover_small']); ?>"  alt="选中的产品图" class="js-thumbnail">
						</div>
						<div class="main">
							<div class="price-wrap">
								<?php if($goods_detail['promotion_detail']['pintuan']): ?>
								
									<!--拼团-->
									<span class="price">¥<?php echo $goods_detail['promotion_detail']['pintuan']['data']['tuangou_money']; ?></span>
								
								<?php elseif($goods_detail['promotion_detail']['group_buy']): ?>
								
									<!--团购-->
									<span class="price">¥<?php echo $goods_detail['promotion_detail']['group_buy']['data']['price_array'][0]['group_price']; ?></span>
								
								<?php elseif($goods_detail['is_open_presell'] == 1): ?>
								
									<!--预售-->
									<span class="price"><?php echo lang('goods_deposit'); ?>¥<?php echo $goods_detail['presell_price']; ?></span>
								
								<?php elseif($goods_detail['point_exchange_type'] == 2 || $goods_detail['point_exchange_type'] == 3): ?>
								
									<!--积分-->
									<span class="price"><?php echo $goods_detail['point_exchange']; ?><?php echo lang('goods_integral'); ?></span>
								
								<?php elseif($goods_detail['is_show_member_price'] == 1): ?>
								
									<!--显示会员价格-->
									<span class="price">¥<?php echo $goods_detail['member_price']; if($goods_detail['point_exchange_type']==1 && $goods_detail['point_exchange']>0): ?>+<?php echo $goods_detail['point_exchange']; ?><?php echo lang('goods_integral'); endif; ?></span>
									<!--积分加现金-->
								
								<?php else: ?>
								
									<span class="price">¥<?php echo $goods_detail['promotion_price']; if($goods_detail['point_exchange_type']==1 && $goods_detail['point_exchange']>0): ?>+<?php echo $goods_detail['point_exchange']; ?><?php echo lang('goods_integral'); endif; ?></span>
									<!--积分加现金-->
								
								<?php endif; ?>
								
							</div>
							<?php if($goods_detail['is_stock_visible'] == 1): ?>
							<div class="stock"><?php echo lang('goods_stock'); ?><?php echo $goods_detail['stock']; if(empty($goods_detail['goods_unit'])): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?></div>
							<?php endif; ?>
							<div class="sku-info">请选择：<span>-</span></div>
						</div>
						<a class="sku-close"><img src="/template/wap/default/public/img/goods/close.png"/></a>
					</div>
					
					<div class="body">
						<div class="body-item">
							<?php if(is_array($goods_detail['spec_list']) || $goods_detail['spec_list'] instanceof \think\Collection || $goods_detail['spec_list'] instanceof \think\Paginator): if( count($goods_detail['spec_list'])==0 ) : echo "" ;else: foreach($goods_detail['spec_list'] as $k=>$spec): ?>
							<ul class="sku-list-wrap">
								<li>
									<h2><?php echo $spec['spec_name']; ?></h2>
									<div class="items">
										<?php if(is_array($spec['value']) || $spec['value'] instanceof \think\Collection || $spec['value'] instanceof \think\Paginator): if( count($spec['value'])==0 ) : echo "" ;else: foreach($spec['value'] as $child_k=>$spec_value): ?>
										<span class="<?php if($spec_value['selected']): ?>selected<?php endif; if($spec_value['disabled']): ?> disabled<?php endif; ?>"
										data-spec-value-name="<?php echo $spec_value['spec_value_name']; ?>" data-id="<?php echo $spec_value['spec_id']; ?>:<?php echo $spec_value['spec_value_id']; ?>" data-picture-id="<?php echo $spec_value['picture']; ?>"><?php echo $spec_value['spec_value_name']; ?></span>
										<?php endforeach; endif; else: echo "" ;endif; ?>
									</div>
								</li>
							</ul>
							<?php endforeach; endif; else: echo "" ;endif; ?>
							<div class="number-wrap">
								<div class="number-line">
									<label for="buy_number"><?php echo lang('member_quantity_purchased'); ?></label>
									<?php if($goods_detail['max_buy'] > 0): ?>
									<span class="limit-txt">(每人限购<?php echo $goods_detail['max_buy']; if(empty($goods_detail['goods_unit'])): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?>)</span>
									<?php endif; ?>
									<div class="number">
										<button class="decrease <?php if($goods_detail['stock']==0): ?>disabled<?php endif; ?>" data-operator="-">-</button>
										<input type="number" id="buy_number" <?php if($goods_detail['stock']==0): ?>class="disabled" readonly="readonly"<?php endif; ?>
										value="<?php if($goods_detail['stock']>0): if($goods_detail['min_buy']>0): ?><?php echo $goods_detail['min_buy']; else: ?>1<?php endif; else: ?>0<?php endif; ?>"
										data-min-buy="<?php if($goods_detail['min_buy'] !=0): ?><?php echo $goods_detail['min_buy']; else: ?>2<?php endif; ?>"
										data-max-buy="<?php if($goods_detail['max_buy']==0 || $goods_detail['max_buy']>$goods_detail['stock']): ?><?php echo $goods_detail['stock']; else: ?><?php echo $goods_detail['max_buy']; endif; ?>"
										data-sale-unit="<?php if($goods_detail['sale_unit']): ?><?php echo $goods_detail['sale_unit']; else: ?><?php echo lang('goods_piece'); endif; ?>">
										<button class="increase <?php if($goods_detail['stock']==0): ?>disabled<?php endif; ?>" data-operator="+">+</button>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="footer js-submit <?php if($goods_detail['stock'] ==0): ?>disabled<?php endif; ?>">确定</div>
				</div>
			
				<!--砍价需要用到-->
				<?php if($goods_detail['promotion_detail']['bargain'] && $bargain_id): 
				$address_list = api('System.Member.memberAddressList');
				$address_list = $address_list['data'];
				$pickup_list = api("System.Shop.pickupPointList");
				$pickup_list= $pickup_list['data'];
				 ?>
				<div class="bargain-address">
					<nav>
						<ul>
							<li class="selected ns-border-color-hover ns-text-color-hover" data-type="logistics">选择物流配送</li>
							<li data-type="pickup">选择自提配送</li>
						</ul>
					</nav>
					<ul data-type="logistics">
						<?php if(!(empty($address_list['data']) || (($address_list['data'] instanceof \think\Collection || $address_list['data'] instanceof \think\Paginator ) && $address_list['data']->isEmpty()))): if(is_array($address_list['data']) || $address_list['data'] instanceof \think\Collection || $address_list['data'] instanceof \think\Paginator): if( count($address_list['data'])==0 ) : echo "" ;else: foreach($address_list['data'] as $k=>$vo): ?>
						<li data-id="<?php echo $vo['id']; ?>">
							<div><?php echo lang('member_consignee'); ?>：<?php echo $vo['consigner']; ?>&nbsp;<?php echo $vo['mobile']; ?></div>
							<div><?php echo lang('member_delivery_address'); ?>：<?php echo $vo['address_info']; ?>-<?php echo $vo['address']; ?></div>
						</li>
						<?php endforeach; endif; else: echo "" ;endif; endif; ?>
						<li>
							<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/addressedit?flag=9&id='.$goods_id.'&bargain_id='.$bargain_id); ?>"><?php echo lang('member_new_delivery_address'); ?></a>
						</li>
					</ul>
					<ul data-type="pickup" style="display: none;">
						<?php if($pickup_list['total_count']>0): if(is_array($pickup_list['data']) || $pickup_list['data'] instanceof \think\Collection || $pickup_list['data'] instanceof \think\Paginator): if( count($pickup_list['data'])==0 ) : echo "" ;else: foreach($pickup_list['data'] as $key=>$vo): ?>
						<li data-id="<?php echo $vo['id']; ?>">
							<div>自提点：<?php echo $vo['name']; ?></div>
							<div class="address-detail">提货地址：<?php echo $vo['province_name']; ?> <?php echo $vo['city_name']; ?> <?php echo $vo['district_name']; ?> <?php echo $vo['address']; ?></div>
						</li>
						<?php endforeach; endif; else: echo "" ;endif; else: ?>
						<li>
							<div>商家未配置自提地址</div>
						</li>
						<?php endif; ?>
					</ul>
					
				</div>
				<?php endif; ?>
			
			</div>
		</div>
	
	</div>
	
	<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true" style="display: none">
		<div class="pswp__bg"></div>
		<!-- Slides wrapper with overflow:hidden. -->
		<div class="pswp__scroll-wrap">
			<div class="pswp__container">
				<div class="pswp__item"></div>
				<div class="pswp__item"></div>
				<div class="pswp__item"></div>
			</div>
			<!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
			<div class="pswp__ui pswp__ui--hidden">
				<div class="pswp__top-bar">
					<!--  Controls are self-explanatory. Order can be changed. -->
					<div class="pswp__counter"></div>
					<!--关闭窗口-->
					<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
					<!--分享-->
					<!-- <button class="pswp__button pswp__button--share" title="Share"></button> -->
					<!--全屏-->
					<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
					<!--放大缩小-->
					<button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
					<!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
					<!-- element will get class pswp__preloader--active when preloader is running -->
					<div class="pswp__preloader">
						<div class="pswp__preloader__icn">
							<div class="pswp__preloader__cut">
								<div class="pswp__preloader__donut"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
					<div class="pswp__share-tooltip"></div>
				</div>
				<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
				<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
				<div class="pswp__caption">
					<div class="pswp__caption__center"></div>
				</div>
			</div>
		</div>
	</div>

</article>

<?php if(is_array($goods_detail['sku_picture_list']) || $goods_detail['sku_picture_list'] instanceof \think\Collection || $goods_detail['sku_picture_list'] instanceof \think\Paginator): if( count($goods_detail['sku_picture_list'])==0 ) : echo "" ;else: foreach($goods_detail['sku_picture_list'] as $key=>$img): if(is_array($img['album_picture_list']) || $img['album_picture_list'] instanceof \think\Collection || $img['album_picture_list'] instanceof \think\Paginator): if( count($img['album_picture_list'])==0 ) : echo "" ;else: foreach($img['album_picture_list'] as $k=>$p): ?>
	<input type="hidden" id="spec_picture_id<?php echo $p['pic_id']; ?>" value="<?php echo __IMG($p['pic_cover_small']); ?>" />
	<?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; if(is_array($goods_detail['sku_list']) || $goods_detail['sku_list'] instanceof \think\Collection || $goods_detail['sku_list'] instanceof \think\Paginator): if( count($goods_detail['sku_list'])==0 ) : echo "" ;else: foreach($goods_detail['sku_list'] as $key=>$sku): ?>
<input name="product_sku" type="hidden" value="<?php echo $sku['attr_value_items']; ?>" data-picture="<?php echo $sku['picture']; ?>" data-default-img="<?php echo __IMG($sku['sku_img_main']['pic_cover_small']); ?>" data-sku-id="<?php echo $sku['sku_id']; ?>" data-stock="<?php echo $sku['stock']; ?>"
<?php if($sku['promote_price'] < $sku['member_price']): ?>data-price="<?php echo $sku['promote_price']; ?>" <?php else: ?>data-price="<?php echo $sku['member_price']; ?>"<?php endif; ?> data-sku-name="<?php echo $sku['sku_name']; ?>">
<?php endforeach; endif; else: echo "" ;endif; ?>

<input type="hidden" id="hidden_stock" value="<?php echo $goods_detail['stock']; ?>"/>
<input type="hidden" id="current_time" value="<?php echo $goods_detail['current_time']; ?>"/>
<input type="hidden" id="hidden_goods_type" value="<?php echo $goods_detail['goods_type']; ?>" />
<input type="hidden" id="hidden_default_picture_id" value="<?php echo $goods_detail['picture']; ?>" />
<input type="hidden" id="hidden_default_img" value="<?php echo __IMG($goods_detail['img_list'][0]['pic_cover_small']); ?>" />
<input type="hidden" id="hidden_picture_id" value="<?php if($goods_detail['sku_picture']>0): ?><?php echo $goods_detail['sku_picture']; else: ?><?php echo $goods_detail['picture']; endif; ?>" />
<input type="hidden" id="hidden_point_exchange" value="<?php echo $goods_detail['point_exchange']; ?>" />
<input type="hidden" id="hidden_point_exchange_type" value="<?php echo $goods_detail['point_exchange_type']; ?>" />

<?php if($goods_detail['promotion_detail']['bargain'] && $bargain_id): ?>
<input type="hidden" id="hidden_order_type" value="7">
<?php elseif($goods_detail['promotion_detail']['pintuan']): ?>
<input type="hidden" id="hidden_order_type" value="4">
<?php elseif($goods_detail['is_open_presell'] == 1): ?>
<input type="hidden" id="hidden_order_type" value="6">
<?php else: ?>
<input type="hidden" id="hidden_order_type" value="1">
<?php endif; if($goods_detail['promotion_detail']['bargain'] && $bargain_id): ?>
<input type="hidden" id="hidden_promotion_type" value="3" />
<?php elseif($goods_detail['promotion_detail']['pintuan']): ?>
<input type="hidden" id="hidden_promotion_type" value="0" />
<?php elseif($goods_detail['promotion_detail']['group_buy']): ?>
<input type="hidden" id="hidden_promotion_type" value="2" />
<?php elseif($goods_detail['integral_flag'] == 1): ?>
<input type="hidden" id="hidden_promotion_type" value="4" />
<?php else: ?>
<input type="hidden" id="hidden_promotion_type" value="0" />
<?php endif; ?>

<input type="hidden" id="hidden_tuangou_group_id" value="<?php echo $group_id; ?>">
<input type="hidden" id="hidden_bargain_id" value="<?php echo $bargain_id; ?>">

<!-- 分享弹框 -->
<div id="share_img" class="share_img" onclick="document.getElementById('share_img').style.display='none';">
	<p><img class="arrow" src="/template/wap/default/public/img/goods/goods_share.png"></p>
	<p style="margin-top:30px; margin-right:50px;">点击右上角</p>
	<p style="margin-right:50px;">将此商品分享给好友</p>
</div>

<input type="hidden" id="appId" value="<?php echo $share_ticket['appId']; ?>">
<input type="hidden" id="jsTimesTamp" value="<?php echo $share_ticket['jsTimesTamp']; ?>">
<input type="hidden" id="jsNonceStr"  value="<?php echo $share_ticket['jsNonceStr']; ?>">
<input type="hidden" id="jsSignature" value="<?php echo $share_ticket['jsSignature']; ?>">



<input type="hidden" id="niushop_rewrite_model" value="<?php echo rewrite_model(); ?>">
<input type="hidden" id="niushop_url_model" value="<?php echo url_model(); ?>">
<input type="hidden" value="<?php echo $uid; ?>" id="uid"/>
<input type="hidden" id="hidden_shop_name" value="<?php echo $web_info['title']; ?>">

<script language="javascript" src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"> </script>
<script>
var goods_id = "<?php echo $goods_id; ?>";
var sku_id = "<?php echo $goods_detail['sku_id']; ?>";
var goods_name = "<?php echo $goods_detail['goods_name']; ?>";
var sku_name = "<?php echo $goods_detail['sku_name']; ?>";
var price = "<?php echo $goods_detail['price']; ?>";
var top_permissions = 0;
var lang_goods_detail = {
	anonymous : '<?php echo lang("anonymous"); ?>',
	goods_shopkeeper_replies : '<?php echo lang("goods_shopkeeper_replies"); ?>',
	goods_stock : '<?php echo lang("goods_stock"); ?>',
	goods_piece : '<?php if(empty($goods_detail['goods_unit'])): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?>',
	goods_integral : "<?php echo lang('goods_integral'); ?>"
};
</script>
<script src="/template/wap/default/public/js/goods_detail.js"></script>

</body>
</html>