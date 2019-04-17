<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:37:"template/wap\default\pay\wap_pay.html";i:1553831804;s:54:"D:\phpStudy\WWW\niushop\template\wap\default\base.html";i:1553848818;}*/ ?>
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
	
<link rel="stylesheet" href="/template/wap/default/public/css/pay/get_pay_value.css"/>

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


<div class="head-info">
	<div class="head-pay">支付金额</div>
	<div class="head-pay-value">￥<?php echo $need_pay_money; ?></div>
</div>
<div class="available-balance">
	<span>可用余额：￥<?php echo $member_balance; ?>元</span>
	<span class="balance_checkbox"> 
		<input type="checkbox" class="switch_checkbox" id="is_use_balance" checked>
		<label for="is_use_balance" class="switch_label">
            <span class="switch_circle"></span>
        </label>
    </span>
</div>
<?php 
	$pay_config = api("System.Pay.getPayConfig");// 支付方式配置
	$pay_config = $pay_config['data'];
 $un_num = '0'; if(!(empty($pay_config) || (($pay_config instanceof \think\Collection || $pay_config instanceof \think\Paginator ) && $pay_config->isEmpty()))): ?>
<div class="pay-type-item">
	<div class="codes">
			<?php if(is_array($pay_config) || $pay_config instanceof \think\Collection || $pay_config instanceof \think\Paginator): if( count($pay_config)==0 ) : echo "" ;else: foreach($pay_config as $key=>$pay_item): if($pay_item['is_use']): ?>
				<div class="pay-type" data-url="<?php echo __URL($pay_item['pay_url'] . '?no=' . $pay_value['out_trade_no']); ?>">
					<img src="/template/wap/default/public/img/pay/<?php echo $pay_item['h5_icon']; ?>" class="wchat-photo">
					<span class="pay-title"><?php echo lang($pay_item['lang']); ?></span>
					<span class="pay-check"><img src="/template/wap/default/public/img/pay/hgou.png"></span>
				</div>
				<?php else: $un_num += 1; endif; endforeach; endif; else: echo "" ;endif; else: ?>
		<div class="not-pay-type">商家未配置支付方式</div>
	</div>
</div>
<?php endif; ?>

<input type="hidden" id="out_trade_no" value="<?php echo $pay_value['out_trade_no']; ?>">
<input type="hidden" name="" id="member_balance" value="<?php echo $member_balance; ?>">
<input type="hidden" name="" id="need_pay_money" value="<?php echo $need_pay_money; ?>">
<input type="hidden" name="" id="pay_money" value="<?php echo $pay_value['pay_money']; ?>">

<?php if($un_num == count($pay_config)): ?>
	<div class="not-pay-type">商家未配置支付方式</div>
<?php else: ?>
	<section class="s-btn">
		<a class="alipay" onclick="subOrder()"><?php echo lang('confirm_payment'); ?></a>
	</section>
<?php endif; ?>
<style>
.footer {
	margin: 0;
	padding: 0;
	min-height: 1px;
	text-align: center;
	line-height: 16px;
	/*background-color: #f8f8f8;*/
}
.ft-copyright {
	padding: 10px 0 10px;
	margin: 0 15px;
	font-size: 12px;
}
.ft-copyright img {
	width: 110px;
	display: block;
	margin: 0 auto;
}
.ft-copyright a{
	color: #ccc;
}
</style>
<div class="footer">
	<div class="copyright" id="bottom_copyright">
		<div class="ft-copyright">
			<img src="/template/wap/default/public/img/logo_copy.png" id="copyright_logo_wap">
			<a href="javascript:;" target="_blank" id="copyright_companyname"></a>
		</div>
		<?php echo $web_info['third_count']; ?>
	</div>
</div>

<script>
$("#is_use_balance").change(function(){
	var member_balance = $("#member_balance").val(),
		need_pay_money = $("#need_pay_money").val(),
		pay_money = $("#pay_money").val(),
		pay_type = $("#pay_type").val();
	if($(this).is(":checked")){
		$(".head-pay-value").text("￥"+need_pay_money);
		if(need_pay_money == 0 && pay_type == -1){
			$(".alipay").show();
		}
	}else{
		$(".head-pay-value").text("￥"+pay_money);
		if(need_pay_money == 0 && pay_type == -1){
			$(".alipay").hide();
		}
	}
})
var __IMG__ = '/template/wap/default/public/img';

$(function(){
	$('.pay-type:eq(0)').addClass('active');
	$('.pay-type:eq(0) .pay-check').html("<img src='" + __IMG__ + "/pay/segou.png'>");
});

var is_sub = false;
function subOrder(){
	if(is_sub) return;
	is_sub = true;
	var is_use_balance = $("#is_use_balance").is(":checked") ? 1 : 0;
	var out_trade_no = $("#out_trade_no").val();
	$.ajax({
		url : __URL(APPMAIN+'/pay/pay'),
		type : "post",
		data : {
			"out_trade_no" : out_trade_no,
			"is_use_balance" : is_use_balance
		},
		success : function(data){
			if(data['code'] == 0){
				calculate();
			}else if(data['code'] == 1){
				location.href = __URL(APPMAIN + '/pay/callback?msg=1&out_trade_no=' + out_trade_no);
			}else if(data['code'] < 0){
				toast(data['message']);
			}
		}
	})
}
function calculate() {
	var pay_type = $("#pay_type").val();
	var out_trade_no = $("#out_trade_no").val();
	var need_pay_money = $("#need_pay_money").val();
	var is_use_balance = $("#is_use_balance").is(":checked") ? 1 : 0;
	var pay_url = $('.pay-type.active').attr('data-url');

	if (pay_url != undefined) {
		window.location.href = pay_url;
	}else{
		toast("<?php echo lang('choose_payment_method'); ?>");
	}
}
$(".alipay").click(function(){
	window.webkit.messageHandlers.calculate.postMessage(null);
})

$('.pay-type').click(function(){
	$(this).addClass('active').siblings('.pay-type').removeClass('active');
	$(this).find('.pay-check').html("<img src='" + __IMG__ + "/pay/segou.png'>");
	$(this).siblings('.pay-type').find('.pay-check').html("<img src='" + __IMG__ + "/pay/hgou.png'>");
})

var payStatus = window.setInterval("payStatu()", 2000);
function payStatu(){
	$.ajax({
		type : "post",
		url : __URL(APPMAIN+'/pay/wchatPayStatu'),
		data : {
			out_trade_no : "<?php echo $pay_value['out_trade_no']; ?>"
		},
		success : function(data){
			if(data['code'] > 0){
				location.href=__URL(APPMAIN+'/pay/wchatPayResult?out_trade_no=<?php echo $pay_value["out_trade_no"]; ?>&msg=1');
				clearInterval(payStatus);
			}
		}
	})
}
</script>



<input type="hidden" id="niushop_rewrite_model" value="<?php echo rewrite_model(); ?>">
<input type="hidden" id="niushop_url_model" value="<?php echo url_model(); ?>">
<input type="hidden" value="<?php echo $uid; ?>" id="uid"/>
<input type="hidden" id="hidden_shop_name" value="<?php echo $web_info['title']; ?>">

</body>
</html>