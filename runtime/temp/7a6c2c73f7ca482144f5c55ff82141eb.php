<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:42:"template/wap\default\pay\callback_wap.html";i:1553831803;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
<title><?php echo lang('pay'); ?></title>
<link type="text/css" rel="stylesheet" href="/template/wap/default/public/css/pay/callback_wap.css">
<script src="/template/wap/default/public/plugin/mzui/lib/jquery/jquery-3.2.1.min.js"></script>
<script src="/template/wap/default/public/js/common.js"></script>
</head>
<body>
<?php if($status==-1): ?>
<div class="on-wechat">
<img src="/template/wap/default/public/css/pay/other_view.png" class="other-view "/>
</div>
<?php else: ?>
<article>
	<?php if($status==1): ?>
		<div class="pay-block">
			<img src="/template/wap/default/public/img/pay/pay_success.png"/>
		</div>
		<h3><?php echo lang('the_payment_successful'); ?></h3>
		<?php if(!(empty($order_no) || (($order_no instanceof \think\Collection || $order_no instanceof \think\Paginator ) && $order_no->isEmpty()))): ?>
		<p><?php echo lang('order_number'); ?><?php echo $order_no; ?></p>
		<?php endif; else: ?>
		<div class="pay-block">
			<img src="/template/wap/default/public/img/pay/pay_error.png"/>
		</div>
		<h3><?php echo lang('payment_failed'); ?></h3>
		<?php if(!(empty($order_no) || (($order_no instanceof \think\Collection || $order_no instanceof \think\Paginator ) && $order_no->isEmpty()))): ?>
		<p class="ns-text-color-black"><?php echo lang('order_number'); ?><?php echo $order_no; ?></p>
		<?php endif; endif; ?>
	<button onclick="enterOrderList()"><?php echo lang('access_member_center'); ?></button>
<?php endif; ?>
</article>
<script>
var APPMAIN = 'http://127.0.0.1:8080/index.php/wap',
	SHOPMAIN = 'http://127.0.0.1:8080/index.php';
	
$(document).ready(function(e) {
	var counter = 0;
	if (window.history && window.history.pushState) {
		$(window).on('popstate', function () {
			window.history.pushState('forward', null, '#');
			window.history.forward(1);
			if($(window).width()<768){
				//手机端
				location.href = __URL(APPMAIN+'/member');
			}else{
				//PC端
				location.href = __URL(SHOPMAIN+'/member');
			}
		});
	}
	window.history.pushState('forward', null, '#'); //在IE中必须得有这两行
	window.history.forward(1);
});
function enterOrderList(){
	if($(window).width()<768){
		//手机端
		location.href = __URL(APPMAIN+'/member');
	}else{
		//PC端
		location.href = __URL(SHOPMAIN+'/member');
	}
}
</script>
</body>
</html>