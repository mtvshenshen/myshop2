<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:42:"template/wap\default\member\footprint.html";i:1553831803;s:54:"D:\phpStudy\WWW\niushop\template\wap\default\base.html";i:1553848818;}*/ ?>
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
	
<link rel="stylesheet" type="text/css" href="/template/wap/default/public/css/member_footprint.css">

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


<div class="new-my-path">
	<nav></nav>
	<div class="list"></div>
</div>



<input type="hidden" id="niushop_rewrite_model" value="<?php echo rewrite_model(); ?>">
<input type="hidden" id="niushop_url_model" value="<?php echo url_model(); ?>">
<input type="hidden" value="<?php echo $uid; ?>" id="uid"/>
<input type="hidden" id="hidden_shop_name" value="<?php echo $web_info['title']; ?>">

<script type="text/javascript">
var category_id = '';
$(function(){
	LoadingInfo();
});
function LoadingInfo(){
	api('System.Member.footprint', {"page_index" : 1, "page_size" : 0, 'category_id':category_id}, function(res) {
		var data = res.data;
		var list = data['data'];
		var html = '';
		var day = '';
		var list_html = '';
			list_html += '<ul>';
		for(var i = 0;i < list.length;i++){
			if(list[i]['goods_info']["goods_name"] != undefined){
				list_html += '<li>';
					if(list[i]['day'] != day){
						day = list[i]['day'];
						list_html += '<div class="date">'+ list[i]['month'] +'月'+ list[i]['day'] +'日</div>';
					}
					list_html += '<div class="right">';
						list_html += '<div class="img-block" onclick="location.href=\''+ __URL(APPMAIN+'/goods/detail?goods_id=' + list[i]['goods_id']) +'\'">';
							if(list[i]['goods_info']['picture_info'] != null){
								list_html += '<img src="'+ __IMG(list[i]['goods_info']['picture_info']['pic_cover']) +'" class="lazy_load J_LazyLoad"  alt=""  >';
							}else{
								list_html += '<img src="<?php echo __IMG($default_goods_img); ?>" class="lazy_load J_LazyLoad"  alt=""  >';
							}
						list_html += '</div>';
						list_html += '<div class="content-block">';
							list_html += '<a href="'+ __URL(APPMAIN+'/goods/detail?goods_id=' + list[i]['goods_id']) +'" class="goods-name">'+ list[i]['goods_info']['goods_name'] +'</a>';
							if(list[i]['goods_info']['point_exchange_type'] == 0 || list[i]['goods_info']['point_exchange_type'] == 2){
								list_html += '<span class="price">￥'+ list[i]['goods_info']['promotion_price'] +'</span>';
							}else{
								if(list[i]['goods_info']['point_exchange_type'] == 1 && list[i]['goods_info']['promotion_price'] > 0){
									list_html += '<span class="price">￥'+ list[i]['goods_info']['promotion_price'] +'+'+ list[i]['goods_info']['point_exchange']+'积分</span>';
								}else{
									list_html += '<span class="price">'+ list[i]['goods_info']['point_exchange'] +'积分</span>';
								}
							}
							list_html += '<a href="javascript:delMyPath('+ list[i]['browse_id'] +');" class="del ns-text-color">删除</a>';
						list_html += '</div>';
					list_html += '</div>';
				list_html += '</li>';
			}
		}
		list_html += '</ul>';
		$(".new-my-path .list").html(list_html);
		if(!category_id){
			var cate = data['category_list'];
			var html = '';
				html += '<ul>';
					html += '<li data-category-id="" class="selected ns-text-color-hover ns-border-color-hover" onclick="select_cate(this)">全部宝贝</li>';
					for(var i = 0;i < cate.length;i++){
						html += '<li data-category-id="'+ cate[i]['category_id'] + '" onclick="select_cate (this)" class="ns-text-color-hover ns-border-color-hover">' + cate[i]['category_name'] + '</li>';
					}
				html += '</ul>';
			$(".new-my-path nav").html(html);
		}
	});
}

function delMyPath(id){
	api('System.Member.deleteFootprint', {"type" : 'browse_id', "value" : id}, function(res) {
		if(res.data > 0){
			LoadingInfo();
		}
	})
}
function select_cate(event){
	$(event).addClass("selected").siblings().removeClass("selected");
	category_id = $(event).attr('data-category-id');
	LoadingInfo();
}
</script>

</body>
</html>