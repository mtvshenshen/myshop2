<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:39:"template/wap\default\order\payment.html";i:1553831803;s:54:"D:\phpStudy\WWW\niushop\template\wap\default\base.html";i:1553848818;}*/ ?>
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
	
<link rel="stylesheet" href="/template/wap/default/public/css/payment.css">
<link rel="stylesheet" href="//at.alicdn.com/t/font_1087048_ti88xqkwo0p.css">

</head>
<body>
<?php 
	//默认图片
	$default_images = api("System.Config.defaultImages");
	$default_images = $default_images['data'];
	$default_goods_img = $default_images["value"]["default_goods_img"];//默认商品图片
	$default_headimg = $default_images["value"]["default_headimg"];//默认用户头像
 
// 订单创建所需数据

$params = [];
$params['order_type'] = !empty($create_data['order_type']) ? $create_data['order_type'] : 0;
$params['goods_sku_list'] = !empty($create_data['goods_sku_list']) ? $create_data['goods_sku_list'] : '';
$params['promotion_type'] = !empty($create_data['promotion_type']) ? $create_data['promotion_type'] : 0;
$params['promotion_info'] = !empty($create_data['promotion_info']) ? $create_data['promotion_info'] : [];

$buyer_ip = request()->ip();

$data = api("System.Order.orderDataCollation", ['data' => json_encode($params)]);
$data = $data['data'];

$is_virtual = $data['is_virtual']; // 是否是虚拟商品

 if(empty($data) || (($data instanceof \think\Collection || $data instanceof \think\Paginator ) && $data->isEmpty())): ?>
<script type="text/javascript">
	if(window.sessionStorage){
		sessionStorage.setItem('errorMsg', JSON.stringify({title : '订单创建页发生错误！', message : '未获取到创建订单所需数据。'}));
	}
	location.href = "<?php echo __URL('http://127.0.0.1:8080/index.php/wap/index/errorTemplate'); ?>";
</script>
<?php echo exit(); endif; ?>

<!-- 主体页面 -->
<div data-page="main" id="app">
	<header class="ns-header">
		<a class="go-back" href="javascript:history.go(-1);"><i class="icon-angle-left"></i></a>
		<h1><?php echo $title; ?></h1>
	</header>
	<div class="h50"></div>
	
	<?php if($is_virtual == '0'): ?>
		<!-- start 收货地址 start -->
		<?php if(!(empty($data['address']) || (($data['address'] instanceof \think\Collection || $data['address'] instanceof \think\Paginator ) && $data['address']->isEmpty()))): ?>
		<div class="address-wrap">
			<ul class="address" data-value="<?php echo $data['address']['id']; ?>">
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/address?url=cart'); ?>">
					<li class="clearfix">
						<span class="name">收货人信息：<?php echo $data['address']['consigner']; ?></span>
						<span class="tel"><?php echo $data['address']['mobile']; ?></span>
					</li>
					<li class="address-detail">收货地址：<?php echo $data['address']['address_info']; ?></li>
				</a>
			</ul>	
		</div>
		<?php else: ?>
		<div class="empty-address">
			<i class="add-icon"></i>
			<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/address?url=cart'); ?>">新增收货地址</a>
		</div>
		<?php endif; ?>
		<div class="dividing-line"></div>
		<!-- end 收货地址 end -->
	<?php endif; ?>

	<!-- start 购买的商品 start -->
	<div class="goods-wrap">
		<?php if($data['order_type'] == 6): ?>
			<!-- 预售订单 -->
			<?php if(is_array($data['goods_sku_array']) || $data['goods_sku_array'] instanceof \think\Collection || $data['goods_sku_array'] instanceof \think\Paginator): if( count($data['goods_sku_array'])==0 ) : echo "" ;else: foreach($data['goods_sku_array'] as $key=>$product_item): ?>
			<div class="goods-item clearfix">
				<div class="goods-img">
					<img src="<?php echo __IMG($product_item['goods_picture_info']['pic_cover_small']); ?>" alt="">
				</div>
				<div class="goods-info">
					<div class="goods-name" >
						<strong><?php echo $product_item['goods_info']['goods_name']; ?></strong>
					</div>
					<p class="sku-name"><?php echo $product_item['goods_sku_info']['sku_name']; ?></p>
				</div>
				<div class="goods-buy-info">
					<div class="price ns-text-color"><span class="unit">￥</span><?php echo $product_item['presell_price']; ?></div>
					<div class="tail-money">尾款：<span class="ns-text-color">￥<?php echo sprintf("%.2f", ($product_item['sku_price'] - $product_item['presell_price'])); ?></span></div>
					<div class="buy-num">x<?php echo $product_item['num']; ?></div>
				</div>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; elseif($data['promotion_type'] == 4): ?>
			<!-- 积分兑换 -->
			<?php if(is_array($data['goods_sku_array']) || $data['goods_sku_array'] instanceof \think\Collection || $data['goods_sku_array'] instanceof \think\Paginator): if( count($data['goods_sku_array'])==0 ) : echo "" ;else: foreach($data['goods_sku_array'] as $key=>$product_item): ?>
			<div class="goods-item clearfix">
				<div class="goods-img">
					<img src="<?php echo __IMG($product_item['goods_picture_info']['pic_cover_small']); ?>" alt="">
				</div>
				<div class="goods-info">
					<div class="goods-name">
						<strong><?php echo $product_item['goods_info']['goods_name']; ?></strong>
					</div>
					<p class="sku-name"><?php echo $product_item['goods_sku_info']['sku_name']; ?></p>
				</div>
				<div class="goods-buy-info">
					<?php if($product_item['goods_info']['point_exchange_type'] == 1): ?>
						<!-- 积分+现金 -->
						<div class="price ns-text-color"><span class="unit">￥</span><?php echo $product_item['sku_price']; ?></div>
						<div class="price ns-text-color"><span class="unit">+</span><?php echo $product_item['goods_info']['point_exchange']; ?><span class="point">积分</span></div>
					<?php else: ?>
						<div class="price ns-text-color"><?php echo $product_item['goods_info']['point_exchange']; ?>积分</div>
					<?php endif; ?>
					<div class="buy-num">x<?php echo $product_item['num']; ?></div>
				</div>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; else: if(is_array($data['goods_sku_array']) || $data['goods_sku_array'] instanceof \think\Collection || $data['goods_sku_array'] instanceof \think\Paginator): if( count($data['goods_sku_array'])==0 ) : echo "" ;else: foreach($data['goods_sku_array'] as $key=>$product_item): ?>
			<div class="goods-item clearfix">
				<div class="goods-img">
					<img src="<?php echo __IMG($product_item['goods_picture_info']['pic_cover_small']); ?>" alt="">
				</div>
				<div class="goods-info">
					<div class="goods-name" >
						<strong><?php echo $product_item['goods_info']['goods_name']; ?></strong>
					</div>
					<p class="sku-name"><?php echo $product_item['goods_sku_info']['sku_name']; ?></p>
				</div>
				<div class="goods-buy-info">
					<div class="price ns-text-color"><span class="unit">￥</span><?php echo $product_item['sku_price']; ?></div>
					<div class="buy-num">x<?php echo $product_item['num']; ?></div>
				</div>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; endif; if(!(empty($data['gift_array']) || (($data['gift_array'] instanceof \think\Collection || $data['gift_array'] instanceof \think\Paginator ) && $data['gift_array']->isEmpty()))): if(is_array($data['gift_array']) || $data['gift_array'] instanceof \think\Collection || $data['gift_array'] instanceof \think\Paginator): if( count($data['gift_array'])==0 ) : echo "" ;else: foreach($data['gift_array'] as $key=>$product_item): ?>
			<div class="goods-item clearfix">
				<div class="goods-img">
					<img src="<?php echo __IMG($product_item['goods_picture_info']['pic_cover_small']); ?>" alt="">
				</div>
				<div class="goods-info">
					<div class="goods-name" >
						<mark class="gift-mark ns-bg-color">赠品</mark>
						<strong><?php echo $product_item['goods_info']['goods_name']; ?></strong>
					</div>
					<p class="sku-name"><?php echo $product_item['goods_sku_info']['sku_name']; ?></p>
				</div>
				<div class="goods-buy-info">
					<div class="price ns-text-color"><span class="unit">￥</span><?php echo $product_item['sku_price']; ?></div>
					<div class="buy-num">x<?php echo $product_item['num']; ?></div>
				</div>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; endif; ?>
	</div>
	<div class="dividing-line"></div>
	<!-- end 购买的商品 end -->

	<?php if($is_virtual == '1'): ?>
	<!-- start 手机号码 start -->
	<div class="option-item account-cont">
		<label>手机号码</label>
		<input type="text" name="mobile" maxlength="11" placeholder="请输入手机号">
	</div>
	<!-- end 手机号码 end -->
	<?php endif; if(!(empty($data['pay_type']) || (($data['pay_type'] instanceof \think\Collection || $data['pay_type'] instanceof \think\Paginator ) && $data['pay_type']->isEmpty()))): ?>
	<!-- start 支付方式 start -->
	<div class="option-item" onclick="picker.show('pay-type');">
		<label>支付方式</label>
		<span class="arrow-right <?php if(count($data['pay_type']) == 1): ?>no<?php endif; ?>" v-text="payTypeName"><?php echo $data['pay_type'][0]['type_name']; ?></span>
	</div>
	<!-- end 支付方式 end -->
	<?php else: ?>
	<!-- start 支付方式 start -->
	<div class="option-item">
		<label>支付方式</label>
		<span class="arrow-right no">商家未配置支付方式</span>
	</div>
	<!-- end 支付方式 end -->
	<?php endif; if($is_virtual == '0'): if(!(empty($data['express_type']) || (($data['express_type'] instanceof \think\Collection || $data['express_type'] instanceof \think\Paginator ) && $data['express_type']->isEmpty()))): ?>
		<!-- start 配送方式 start -->
		<div class="shipping-type" onclick="page.show('delivery')">
			<div class="clearfix">
				<label>配送服务</label>
				<span class="arrow-right" v-text="shippingInfo.shippingType">物流配送</span>
			</div>
			<div class="other-info clearfix">
				<span class="key pull-left" v-text="shippingInfo.leftCont">送货时间</span>
				<span class="value pull-right" v-text="shippingInfo.rightCont">工作日、双休日与节假日均可送货</span>
			</div>
		</div>
		<!-- end 配送方式 end -->
		<?php endif; endif; if(!(empty($data['coupon_list']) || (($data['coupon_list'] instanceof \think\Collection || $data['coupon_list'] instanceof \think\Paginator ) && $data['coupon_list']->isEmpty()))): ?>
	<!-- start 优惠券 start -->
	<div class="option-item" onclick="page.show('coupon');">
		<label>优惠券</label>
		<span class="arrow-right ns-text-color" v-html="couponCont">已使用1张，可抵扣￥<span><?php echo $data['coupon_list'][0]['money']; ?></span></span>
	</div>
	<!-- end 优惠券 end -->
	<?php endif; if($is_virtual == '0'): if(!(empty($data['invoice_info']) || (($data['invoice_info'] instanceof \think\Collection || $data['invoice_info'] instanceof \think\Paginator ) && $data['invoice_info']->isEmpty()))): ?>
		<!-- start 发票信息 start -->
		<div class="option-item" onclick="page.show('invoice')">
			<label>发票信息<span style=""></span></label>
			<span class="arrow-right" v-text="isNeedInvoice ? '需要发票' : '不需要发票'">不需要发票</span>
		</div>
		<!-- end 发票信息 end -->
		<?php endif; endif; if($data['max_use_point'] > 0): ?>
	<div class="option-item point">
		<label>积分抵现<span class="desc ns-text-color">本次最大可用<?php echo $data['max_use_point']; ?>积分</span></label>
		<input type="number" class="use-point" value="0" data-max-available="<?php echo $data['max_use_point']; ?>">
	</div>
	<?php endif; ?>

	<div class="option-item">
		<label>买家留言<span style=""></span></label>
		<textarea class="user-message" placeholder="给卖家留言"></textarea>
	</div>

	<!-- start 订单计算信息 start -->
	<div class="dividing-line"></div>
	<div class="buy-section">
		<ul>
			<?php if($data['order_type'] == '6'): ?>
			<li class="clearfix">
				<span class="text pull-left">付款</span>
				<span class="price pull-right presell-pay-type">
					<ul class="clearfix">
						<li class="selected" data-value="0">
							<i class="iconfont iconchecked ns-text-color"></i>
							<span>定金</span>
						</li>
						<li data-value="1">
							<i class="iconfont iconcheckbox"></i>
							<span>全款</span>
						</li>
					</ul>
				</span>
			</li>
			<?php endif; ?>
			<li class="clearfix">
				<span class="text pull-left">商品金额</span>
				<span class="price pull-right ns-text-color">
					<em class="unit">￥</em><span v-text="goodsMoney">0.00</span>
				</span>
			</li>
			<?php if($is_virtual == '0'): ?>
			<li class="clearfix">
				<span class="text pull-left">运费</span>
				<span class="price pull-right ns-text-color">
					<em class="unit">￥</em><span v-text="shippingMoney">0.00</span>
				</span>
			</li>
			<?php endif; ?>
			<li class="clearfix">
				<span class="text pull-left">优惠金额</span>
				<span class="price pull-right ns-text-color">
					<em class="unit">￥</em><span v-text="promotionMoney">0.00</span>
				</span>
			</li>
			<li class="clearfix" v-show="isNeedInvoice">
				<span class="text pull-left">税费</span>
				<span class="price pull-right ns-text-color">
					<em class="unit">￥</em><span v-text="taxMoney">0.00</span>
				</span>
			</li>

			<?php if($data['max_use_point'] > 0): ?>
			<li class="clearfix">
				<span class="text pull-left">积分抵现</span>
				<span class="price pull-right ns-text-color">
					<em class="unit">￥</em><span v-text="pointMoney">0.00</span>
				</span>
			</li>
			<?php endif; if($data['promotion_type'] == '4'): ?>
			<li class="clearfix">
				<span class="text pull-left">兑换所需积分</span>
				<span class="price pull-right ns-text-color">
					<span><?php echo $data['total_buy_point']; ?></span><em class="unit">积分</em>
				</span>
			</li>
			<?php endif; ?>
		</ul>
		<p class="total-price">
			<strong>应付：</strong><span class="ns-text-color">￥<span v-text="payMoney">0.00</span></span>
		</p>
		<a href="javascript:order.submit();" class="submit-order-btn ns-bg-color">提交订单</a>
	</div>
	<!-- end 订单计算信息 end -->
</div>

<?php if($is_virtual == '0'): if(!(empty($data['invoice_info']) || (($data['invoice_info'] instanceof \think\Collection || $data['invoice_info'] instanceof \think\Paginator ) && $data['invoice_info']->isEmpty()))): ?>
	<!-- start 发票选择页 start -->
	<div data-page="invoice">
		<header class="ns-header">
			<a class="go-back" href="javascript:page.hide();"><i class="icon-angle-left"></i></a>
			<h1>发票信息</h1>
		</header>
		<div class="h50"></div>

		<div class="invoice-wrap">
			<div class="available-invoice">
				<span>是否需要发票</span>
				<span class="invoice-checkbox"> 
					<input type="checkbox" class="switch-checkbox" id="is-need-invoice">
					<label for="is-need-invoice" class="switch-label">
			            <span class="switch-circle"></span>
			        </label>
			    </span>
			</div>
			<div class="dividing-line hide"></div>
			<div class="invoice-form hide">
				<div class="form-group clearfix">
					<label>发票抬头</label>
					<input type="text" placeholder="请输入发票抬头" name="invoice_title">
				</div>
				<div class="form-group clearfix">
					<label>纳税人识别号</label>
					<input type="text" placeholder="请输入纳税人识别号" name="taxpayer_identification_number">
				</div>
				<div class="form-group clearfix">
					<label>发票内容</label>
				</div>		
				<ul class="invoice-cont-list">
					<?php if(!(empty($data['invoice_info']['order_invoice_content_list']) || (($data['invoice_info']['order_invoice_content_list'] instanceof \think\Collection || $data['invoice_info']['order_invoice_content_list'] instanceof \think\Paginator ) && $data['invoice_info']['order_invoice_content_list']->isEmpty()))): if(is_array($data['invoice_info']['order_invoice_content_list']) || $data['invoice_info']['order_invoice_content_list'] instanceof \think\Collection || $data['invoice_info']['order_invoice_content_list'] instanceof \think\Paginator): if( count($data['invoice_info']['order_invoice_content_list'])==0 ) : echo "" ;else: foreach($data['invoice_info']['order_invoice_content_list'] as $k=>$vo): if($k == '0'): ?>
							<li class="selected">
								<i class="iconfont iconchecked ns-text-color"></i>
							<?php else: ?>
							<li>
								<i class="iconfont iconcheckbox"></i>
							<?php endif; ?>
								<span><?php echo $vo; ?></span>
							</li>
						<?php endforeach; endif; else: echo "" ;endif; endif; ?>
				</ul>
			</div>
			<p class="tishi"><i class="iconfont icontishi"></i> 需要发票需加收<?php echo $data['invoice_info']['order_invoice_tax']; ?>%的税费</p>
		</div>
			
		<div class="invoice-bottom">
			<a href="javascript:page.confirm()" class="invoice-confirm-btn ns-bg-color">确定</a>
		</div>
	</div>
	<!-- end 发票页 end -->
	<?php endif; if(!(empty($data['express_type']) || (($data['express_type'] instanceof \think\Collection || $data['express_type'] instanceof \think\Paginator ) && $data['express_type']->isEmpty()))): ?>
	<!-- 配送服务页 -->
	<div data-page="delivery">
		<header class="ns-header">
			<a class="go-back" href="javascript:page.hide();"><i class="icon-angle-left"></i></a>
			<h1>配送服务</h1>
		</header>
		<div class="h50"></div>

		<div class="delivery-wrap">
			<h3 class="title">配送方式</h3>
			<ul class="clearfix shipping-type-list">
				<?php if(is_array($data['express_type']) || $data['express_type'] instanceof \think\Collection || $data['express_type'] instanceof \think\Paginator): if( count($data['express_type'])==0 ) : echo "" ;else: foreach($data['express_type'] as $k=>$vo): ?>
				<li <?php if($k == '0'): ?>class="selected ns-text-color ns-border-color"<?php endif; ?> data-value="<?php echo $vo['type_id']; ?>"><?php echo $vo['type_name']; ?></li>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
			<div class="dividing-line"></div>

			<div class="panel logistics <?php if($data['express_type'][0]['type_id'] != 1): ?>hide<?php endif; ?>">
				<?php if(!(empty($data['express_company_list']) || (($data['express_company_list'] instanceof \think\Collection || $data['express_company_list'] instanceof \think\Paginator ) && $data['express_company_list']->isEmpty()))): ?>
				<h3 class="v2-title">物流公司</h3>
				<ul class="express-company-list">
					<?php if(is_array($data['express_company_list']) || $data['express_company_list'] instanceof \think\Collection || $data['express_company_list'] instanceof \think\Paginator): if( count($data['express_company_list'])==0 ) : echo "" ;else: foreach($data['express_company_list'] as $k=>$vo): if($k == '0'): ?>
						<li class="selected" data-value="<?php echo $vo['co_id']; ?>">
							<i class="iconfont iconchecked ns-text-color"></i>
							<span><?php echo $vo['company_name']; ?></span>
						</li>
						<?php else: ?>
						<li data-value="<?php echo $vo['co_id']; ?>">
							<i class="iconfont iconcheckbox"></i>
							<span><?php echo $vo['company_name']; ?></span>
						</li>
						<?php endif; endforeach; endif; else: echo "" ;endif; ?>
				</ul>
				<?php endif; ?>
				<div class="shipping-time" onclick="picker.show('shipping-time');">
					<span class="pull-left">配送时间： <time>工作日、双休日与节假日均可送货</time></span><i class="fa fa-pencil"></i>
				</div>
			</div>

			<div class="panel pickup-point <?php if($data['express_type'][0]['type_id'] != 2): ?>hide<?php endif; ?>">
				<?php if(!(empty($data['pickup_point_list']) || (($data['pickup_point_list'] instanceof \think\Collection || $data['pickup_point_list'] instanceof \think\Paginator ) && $data['pickup_point_list']->isEmpty()))): ?>
				<h3 class="v2-title">自提点</h3>
				<ul class="pickup-point-list"> 
					<?php if(is_array($data['pickup_point_list']) || $data['pickup_point_list'] instanceof \think\Collection || $data['pickup_point_list'] instanceof \think\Paginator): if( count($data['pickup_point_list'])==0 ) : echo "" ;else: foreach($data['pickup_point_list'] as $k=>$vo): if($k == '0'): ?>
						<li class="clearfix selected" data-value="<?php echo $vo['id']; ?>">
							<i class="iconfont iconchecked ns-text-color"></i>
						<?php else: ?>
						<li class="clearfix" data-value="<?php echo $vo['id']; ?>">
							<i class="iconfont iconcheckbox"></i>
						<?php endif; ?>
							<div class="pickup-point-info">
								<h5 class="name"><?php echo $vo['name']; ?></h5>
								<p class="address"><?php echo $vo['province_name']; ?> <?php echo $vo['city_name']; ?> <?php echo $vo['district_name']; ?> <?php echo $vo['address']; ?></p>
							</div>
						</li>
						<div class="line"></div>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
				<?php endif; ?>
			</div>

			<p class="distribution-time hide"><?php echo $data['distribution_time']; ?></p>

		</div>

		<div class="delivery-bottom">
			<a href="javascript:page.confirm();" class="delivery-confirm-btn ns-bg-color">确定</a>
		</div>
		
	</div>
	<!-- end 配送服务页 end -->
	<?php endif; endif; if(!(empty($data['coupon_list']) || (($data['coupon_list'] instanceof \think\Collection || $data['coupon_list'] instanceof \think\Paginator ) && $data['coupon_list']->isEmpty()))): ?>
<!-- 优惠券选择 -->
<div data-page="coupon">
	<header class="ns-header">
		<a class="go-back" href="javascript:page.hide();"><i class="icon-angle-left"></i></a>
		<h1>优惠券</h1>
	</header>
	<div class="h50"></div>

	<div class="coupon-wrap">
		<ul class="coupon-list">
    		<?php if(is_array($data['coupon_list']) || $data['coupon_list'] instanceof \think\Collection || $data['coupon_list'] instanceof \think\Paginator): if( count($data['coupon_list'])==0 ) : echo "" ;else: foreach($data['coupon_list'] as $k=>$vo): if($k == '0'): ?>
				<li class="clearfix selected" data-value="<?php echo $vo['coupon_id']; ?>">
					<i class="iconfont iconchecked ns-text-color"></i>
				<?php else: ?>
				<li class="clearfix" data-value="<?php echo $vo['coupon_id']; ?>">
					<i class="iconfont iconcheckbox"></i>
				<?php endif; ?>
				<div class="coupon-info ns-text-color clearfix">
					<div class="coupon-left-view">
						<p class="money" data-value="<?php echo $vo['money']; ?>"><strong><?php echo round($vo['money']); ?></strong></p>
						<?php if($vo['at_least'] > 0): ?>
						<p class="at-last">满<?php echo $vo['at_least']; ?>元可用</p>
						<?php else: ?>
						<p class="at-last">无门槛券</p>
						<?php endif; ?>
					</div>
					<div class="coupon-right-view">
						<p class="limit"><i class="iconfont iconyouhuiquan"></i><?php if($vo['range_type']): ?>全部商品可用<?php else: ?>部分商品可用<?php endif; ?></p>
						<p class="time-limit">有效期至<?php echo date("Y-m-d",$vo['end_time']); ?></p>
					</div>
				</div>
			</li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>

	<div class="coupon-bottom">
		<a href="javascript:page.confirm();" class="coupon-confirm-btn ns-bg-color">确定</a>
	</div>
</div>
<!-- 优惠券选择 -->
<?php endif; ?>


<!-- 遮罩 -->
<div class="shade hide" onclick="picker.hide();"></div>
<!-- start 支付方式选择 start -->
<div class="picker hide middle" data-picker="picker-pay-type">
	<div class="picker-head">
		<span class="title">支付方式</span>
		<i class="fa fa-close" onclick="picker.hide();"></i>	
	</div>
	<div class="picker-body pay">
		<ul class="pay-type-list">
			<?php if(!(empty($data['pay_type']) || (($data['pay_type'] instanceof \think\Collection || $data['pay_type'] instanceof \think\Paginator ) && $data['pay_type']->isEmpty()))): if(is_array($data['pay_type']) || $data['pay_type'] instanceof \think\Collection || $data['pay_type'] instanceof \think\Paginator): if( count($data['pay_type'])==0 ) : echo "" ;else: foreach($data['pay_type'] as $k=>$vo): if($k == '0'): ?>
					<li class="selected" data-value="<?php echo $vo['type_id']; ?>">
						<i class="iconfont iconchecked ns-text-color"></i>
						<span><?php echo $vo['type_name']; ?></span>
					</li>
					<?php else: ?>
					<li data-value="<?php echo $vo['type_id']; ?>">
						<i class="iconfont iconcheckbox"></i>
						<span><?php echo $vo['type_name']; ?></span>
					</li>
					<?php endif; ?>
				</li>
				<?php endforeach; endif; else: echo "" ;endif; endif; ?>
		</ul>
	</div>
	<div class="picker-foot">
		<a href="javascript:picker.hide();" class="confirm-btn ns-bg-color">确定</a>
	</div>
</div>
<!-- end 支付方式选择 end -->

<!-- start 配送时间选择 start -->
<div class="picker hide big" data-picker="picker-shipping-time">
	<div class="picker-head">
		<span class="title">配送时间</span>
		<i class="fa fa-close" onclick="picker.hide();"></i>	
	</div>
	<div class="picker-body shipping">
		<div class="date-list">
			<?php 
  				$week_array = ['周日','周一','周二','周三','周四','周五','周六'];
  				$time_slot = !empty($data['time_slot']) ? $data['time_slot'] : [];
  			 ?>
			<div class="distribution-time-out">
				<?php if(!(empty($time_slot) || (($time_slot instanceof \think\Collection || $time_slot instanceof \think\Paginator ) && $time_slot->isEmpty()))): ?>
				<div class="tit">选择配送时间段</div>
				<div class="time-out-list clearfix">
					<?php if(is_array($time_slot) || $time_slot instanceof \think\Collection || $time_slot instanceof \think\Paginator): if( count($time_slot)==0 ) : echo "" ;else: foreach($time_slot as $k=>$vo): ?>
					<span <?php if($k == '0'): ?>class="selected ns-bg-color"<?php endif; ?>><?php echo $vo; ?></span>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
				<?php endif; ?>
				<div class="tit">选择配送时间</div>
				<ul class="clearfix shipping-time-list">
					<?php $__FOR_START_13012__=3;$__FOR_END_13012__=10;for($i=$__FOR_START_13012__;$i < $__FOR_END_13012__;$i+=1){ ?>
						<li data-time="<?php echo strtotime($i." day"); ?>"><?php echo date('Y-m-d', strtotime($i." day")); ?>&nbsp;<?php echo $week_array[date('w', strtotime($i." day"))]; ?></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- end 配送时间选择 end -->




<input type="hidden" id="niushop_rewrite_model" value="<?php echo rewrite_model(); ?>">
<input type="hidden" id="niushop_url_model" value="<?php echo url_model(); ?>">
<input type="hidden" value="<?php echo $uid; ?>" id="uid"/>
<input type="hidden" id="hidden_shop_name" value="<?php echo $web_info['title']; ?>">

<script>
var _params = {
	'order_type' : <?php echo $params['order_type']; ?>,
	'goods_sku_list' : '<?php echo $params['goods_sku_list']; ?>',
	'is_virtual' : <?php echo $is_virtual; ?>,
	'buyer_ip' : '<?php echo $buyer_ip; ?>',
	'promotion_type' : "<?php echo $params['promotion_type']; ?>",
	'promotion_info' : '<?php echo json_encode($params['promotion_info']); ?>'
}	
</script>
<script src="/public/static/js/vue.min.js"></script>
<script src="/template/wap/default/public/js/payment.js"></script>

</body>
</html>