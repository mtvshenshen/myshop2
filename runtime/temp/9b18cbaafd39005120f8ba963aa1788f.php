<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:37:"template/wap\default\order\lists.html";i:1555999126;s:54:"D:\phpStudy\WWW\niushop\template\wap\default\base.html";i:1553848818;}*/ ?>
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
	
	<link rel="stylesheet" type="text/css" href="/template/wap/default/public/css/order_list.css">

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
	<a  class="go-back" href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/member/index'); ?>"><i class="icon-angle-left"></i></a>
	<!-- <a class="ns-operation">操作</a> -->
	<h1><?php echo $title; ?></h1>
</header>
<div></div>


<?php 
	$status = request()->get('status', 'all');
	$order_status = api('System.Order.orderStatus', ['order_type' => $order_type]);
	$order_status = $order_status['data'];
	$order_type = api('System.Order.orderType');
	$order_type = $order_type['data'];
 ?>
<div class="main myorder">
	<div class="cf-container">
		<ul class="cf-content">
            <li class="cf-tab-item ns-border-color-hover  ns-text-color-black ns-text-color-hover" statusid="all"><a href="javascript:GetDataList('all',1);" ><?php echo lang('whole'); ?></a></li>
            <?php if(is_array($order_status) || $order_status instanceof \think\Collection || $order_status instanceof \think\Paginator): if( count($order_status)==0 ) : echo "" ;else: foreach($order_status as $key=>$vo): ?>
	            <li class="cf-tab-item ns-border-color-hover ns-text-color-hover ns-text-color-black" statusid="<?php echo $vo['status_id']; ?>"><a href="javascript:GetDataList('<?php echo $vo['status_id']; ?>');" ><?php echo $vo['status_name']; ?></a></li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
	</div>
	<div class="tabs-content">
		<div class="content active" id="list_content"></div>
	</div>
    <div id="pay" style="display: none"></div>
    <input type="hidden" name="status_hidden" id="status_hidden" value="<?php echo $status; ?>"/>
    <input type="hidden" name="shop_id" id="shop_id" value="<?php echo $shop_id; ?>"/>
	<input type="hidden" id="page_count"><!-- 总页数 -->
	<input type="hidden" id="page" value="1"><!-- 当前页数 -->
	<input type="hidden" id="status" value="all">
</div>




<input type="hidden" id="niushop_rewrite_model" value="<?php echo rewrite_model(); ?>">
<input type="hidden" id="niushop_url_model" value="<?php echo url_model(); ?>">
<input type="hidden" value="<?php echo $uid; ?>" id="uid"/>
<input type="hidden" id="hidden_shop_name" value="<?php echo $web_info['title']; ?>">

<script src="/template/wap/default/public/js/order.js"></script>
<script>
$(function(){
	$('.cf-container .cf-tab-item').click(function(){
		$('.cf-container .cf-tab-item').removeClass('selected');
		$(this).addClass('selected');
		$('#status_hidden').val($(this).attr('statusid'));
	});
	var status_hidden=$('#status_hidden').val();
	GetDataList(status_hidden,1);
	$('.cf-container .cf-tab-item').each(function(){
		if($(this).attr("statusid") == status_hidden){
			$(this).addClass('selected');
		}
	});
});

var is_load = false;//防止重复加载
function GetDataList(status,page){
	if(page == undefined || page == "") page = 1;
	$("#page").val(page);//设置当前页
	$("#status").val(status);//保存当前状态
	if(is_load) return;
	is_load = true;
	api("System.Order.order",{ 'status':status,'shop_id':$('#shop_id').val(),"page":page },function (res) {
		var data = res.data;
		$("#page_count").val(data['page_count']);//总页数
		if(page == 1){
			var datahtml="";
		}else if(page > 1){
			var datahtml = $('#list_content').html();
		}
		if(data['data'].length==0){
			datahtml+='<div class="myorder-none" ><i class="icon-none"></i><span class="none_01"><?php echo lang("member_no_order_yet"); ?></span><span class="none_02"><?php echo lang("member_go_and_see"); ?></span><span class="none_03"><a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/lists'); ?>"><?php echo lang("member_look_around"); ?></a></span></div>';
		}else{
			for(var i=0;i<data['data'].length;i++){
				var ordersitem=data['data'][i];
				datahtml+='<div class="list-myorder">';
				datahtml+='<div class="ordernumber"><span class="order-num f12 ns-text-color-black">'+ordersitem['order_no']+'</span><span class="order-date f12" >'+timeStampTurnTime(ordersitem['create_time'])+'</span></div>';
				datahtml+='<ul class="ul-product">';
				for(var j=0;j<ordersitem['order_item_list'].length;j++){
					var goodsitem=ordersitem['order_item_list'][j];
					var gift_flag = ordersitem['order_item_list'][j]['gift_flag'];
					datahtml+='<li><a href="'+__URL('http://127.0.0.1:8080/index.php/wap/order/detail?orderId='+goodsitem['order_id'])+'">';
					datahtml+='<span class="pic">';
					datahtml+='<img src="'+__IMG(goodsitem['picture']['pic_cover_micro'])+'"></span>';
					datahtml+='<div class="text">';
					datahtml+='<span class="pro-name f12 ns-text-color-black">'+goodsitem['goods_name']+'</span>';
					if(gift_flag > 0){
						datahtml+='<div class="pro-pric"><span class="f12"><?php echo lang("goods_price"); ?>:</span><b class="f12 f-no ns-text-color-black">￥'+goodsitem['price']+'</b><i class="ns-bg-color gift-mark">赠品</i></div>';
					}else{
						datahtml+='<div class="pro-pric"><span class="f12"><?php echo lang("goods_price"); ?>:</span><b class="f12 f-no ns-text-color-black">￥'+goodsitem['price']+'</b></div>';
					}
					datahtml+='<div class="pro-pric margin0"><span class="f12"><?php echo lang("specifications"); ?>:</span><b class="f12 f-no ns-text-color-black">'+goodsitem['sku_name']+'</b></div>';
					datahtml+='<div class="pro-pric"><span class="f12"><?php echo lang("goods_number"); ?>:</span><b class="f12 f-no ns-text-color-black">'+goodsitem['num']+'<?php echo lang("goods_piece"); ?></b></div>';
					datahtml+='</div></a>';
					datahtml+='<div class="order-operating">';
					if(goodsitem['shipping_status']!=0){
						datahtml+='<div class="order-operating-left"><?php echo lang("consign"); ?></div>';
					}
					datahtml += '<div class="order-operating-right">';
					//非赠品才允许退款操作
					if(gift_flag == 0){
						if(ordersitem['payment_type']==4){
							if(ordersitem['is_refund']==1 && goodsitem['refund_status']==0 && ordersitem['order_status']==2){
								datahtml+='<input type="button" onclick="window.location.href=\''+__URL('http://127.0.0.1:8080/index.php/wap/Order/refundDetail?order_goods_id='+goodsitem['order_goods_id'])+'\'" class="order-operating-name ns-text-color-black"  value="<?php echo lang("list_of_refund_return"); ?>" />&nbsp;&nbsp;';
							}
						}else{
							if(ordersitem['is_refund']==1 && goodsitem['refund_status']==0){
								datahtml+='<input type="button" onclick="window.location.href=\''+__URL('http://127.0.0.1:8080/index.php/wap/Order/refundDetail?order_goods_id='+goodsitem['order_goods_id'])+'\'" class="order-operating-name ns-text-color-black" value="<?php echo lang("list_of_refund_return"); ?>" />&nbsp;&nbsp;';
							}else if(goodsitem['refund_status'] != 0) {
								if(goodsitem['refund_status'] != 5 && goodsitem['refund_status'] != -1 && goodsitem['refund_status'] != -2){
									datahtml+='<input type="button" onclick="cancleRefund('+ordersitem['order_id']+', '+ goodsitem['order_goods_id']+');" class="order-operating-name ns-text-color-black" value="取消退款">&nbsp;&nbsp;';
								}
							}
						}
					}
					if(ordersitem['order_status'] == 3  && goodsitem['customer_info'] == null){
						datahtml+='<a href=\''+__URL('http://127.0.0.1:8080/index.php/wap/Order/aftersale?order_goods_id='+goodsitem['order_goods_id'])+'\'"><span class="order-operating-item">申请售后</span></a>&nbsp;&nbsp;';
					}else if(ordersitem['order_status'] == 3 && goodsitem['customer_info']!=null){
						datahtml+='<a href=\''+__URL('http://127.0.0.1:8080/index.php/wap/Order/aftersale?order_goods_id='+goodsitem['order_goods_id'])+'\'"><span class="order-operating-item">查看售后</span></a>&nbsp;&nbsp;';
					}
					if(goodsitem['refund_status']!=0){
						datahtml+='<input type="button" onclick="window.location.href=\''+__URL('http://127.0.0.1:8080/index.php/wap/Order/refundDetail?order_goods_id='+goodsitem['order_goods_id'])+'\'" class="order-operating-name ns-text-color-black" value="'+goodsitem['status_name']+'" />&nbsp;&nbsp;';
					}
// 					if(ordersitem['order_status'] == 3 || ordersitem['order_status'] == 4){
// 						if(ordersitem['is_evaluate'] == 0){
// 							datahtml += '<a href="'+__URL('http://127.0.0.1:8080/index.php/wap/order/evaluationDetail?orderId='+goodsitem['order_id'])+'"><span class="order-operating-item"><?php echo lang("member_i_want_evaluate"); ?></span></a>';
// 						}else if(ordersitem['is_evaluate'] == 1){
// 							datahtml += '<a href="'+__URL('http://127.0.0.1:8080/index.php/wap/order/reviewEvaluateDetail?orderId='+goodsitem['order_id'])+'"><span class="order-operating-item"><?php echo lang("goods_additional_evaluation"); ?></span></a>';
// 						}
// 					}
					datahtml+='</div>';
					datahtml+='</div>';
					datahtml+='</li>';
				}
				datahtml+='</ul>';
				datahtml+='<div class="totle">';
				datahtml+='<span class="status ns-text-color">'+ordersitem['order_type_name']+'&nbsp;&nbsp;&nbsp;</span>';
				datahtml+='<span class="status">'+ordersitem['status_name']+'</span>';
				datahtml+='<span class="price ns-text-color">￥'+ordersitem['order_money']+'</span>';
				datahtml+='<span class="pric-lable"><?php echo lang("total_price"); ?></span>';
				datahtml+='<span class="prc-num"></span></div>';
				datahtml+='<div class="div-button">';
				if(ordersitem['member_operation']!=''){
					for(var x=0;x<ordersitem['member_operation'].length;x++){
						operationitem=ordersitem['member_operation'][x];
						datahtml+='<a href="javascript:void(0)" class="button [radius round]" style="background-color: '+operationitem['color']+';border: 1px solid '+operationitem['color']+';" onclick="operation(\''+operationitem['no']+'\','+ordersitem['order_id']+')">'+operationitem['name']+'</a>';
					}
				}
				if(ordersitem['order_status'] == 3 || ordersitem['order_status'] == 4){
					if(ordersitem['is_evaluate'] == 0){
						datahtml += '<a href="'+ __URL(APPMAIN + '/order/evaluate?orderid='+ ordersitem['order_id']) +'" class="button [radius round] ns-bg-color"><?php echo lang('member_i_want_evaluate'); ?></a>';
					}else if(ordersitem['is_evaluate'] == 1){
						datahtml += '<a href="'+ __URL(APPMAIN + '/order/evaluate?orderid='+ ordersitem['order_id']+'&again=1') +'" class="button [radius round] ns-bg-color"><?php echo lang('goods_additional_evaluation'); ?></a>';
					}
				}
				datahtml+='</div></div>';
			}
		}
		is_load = false;
		$('#list_content').html(datahtml);
	});
}

//滑动到底部加载
$(window).scroll(function(){
	var totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
	var content_box_height = parseFloat($("#list_content").height());
	if(totalheight - content_box_height >= 80){
		if(!is_load){
			var page = parseInt($("#page").val()) + 1;//页数
			var total_page_count = $("#page_count").val(); // 总页数
			var status = $('#status').val();
			if(page > total_page_count){
				return false;
			}else{
				GetDataList(status,page);
			}
		}
	}
})
 
</script>

</body>
</html>