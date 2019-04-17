<?php if (!defined('THINK_PATH')) exit(); /*a:11:{s:35:"template/admin\Goods\goodsList.html";i:1553847869;s:48:"D:\phpStudy\WWW\niushop\template\admin\base.html";i:1553915410;s:65:"D:\phpStudy\WWW\niushop\template\admin\controlCommonVariable.html";i:1552613506;s:52:"D:\phpStudy\WWW\niushop\template\admin\urlModel.html";i:1552613544;s:68:"D:\phpStudy\WWW\niushop\template\admin\Goods\goodsThreeCategory.html";i:1552613508;s:70:"D:\phpStudy\WWW\niushop\template\admin\Goods\batchProcessingModal.html";i:1552613508;s:72:"D:\phpStudy\WWW\niushop\template\admin\Goods\setMemberDiscountModal.html";i:1553735536;s:62:"D:\phpStudy\WWW\niushop\template\admin\Goods\goodsSkuEdit.html";i:1553944414;s:54:"D:\phpStudy\WWW\niushop\template\admin\pageCommon.html";i:1552613506;s:54:"D:\phpStudy\WWW\niushop\template\admin\openDialog.html";i:1552613504;s:61:"D:\phpStudy\WWW\niushop\template\admin\Goods\goodsAction.html";i:1553759847;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
	<meta name="renderer" content="webkit" />
	<meta http-equiv="X-UA-COMPATIBLE" content="IE=edge,chrome=1"/>
	<?php if($frist_menu['module_name']=='首页'): ?>
	<title><?php echo $title_name; ?> - 商家管理</title>
	<?php else: ?>
		<title><?php echo $title_name; ?> - <?php echo $frist_menu['module_name']; ?>管理</title>
	<?php endif; ?>
	<link rel="shortcut icon" type="image/x-icon" href="/public/static/images/favicon.ico" media="screen"/>
	<link rel="stylesheet" type="text/css" href="/public/static/blue/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="/public/static/blue/css/ns_blue_common.css" />
	<link rel="stylesheet" type="text/css" href="/public/static/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="/public/static/simple-switch/css/simple.switch.three.css" />
	<link rel="stylesheet" type="text/css" href="/template/admin/public/css/selectric.css" />
	<style>
	.Switch_FlatRadius.On span.switch-open{background-color: #00A0DE;border-color: #00A0DE;}
	#copyright_meta a{color:#333;}
	.fa-wechat-applet:before{content:'';display:inline-block;width:20px;height:20px;background:#FFF url(/public/static/images/wechat_applet.png) no-repeat;background-size: 100%;}
	</style>
	<script src="/public/static/js/jquery-1.8.1.min.js"></script>
	<script src="/public/static/blue/bootstrap/js/bootstrap.js"></script>
	<script src="/public/static/bootstrap/js/bootstrapSwitch.js"></script>
	<script src="/public/static/simple-switch/js/simple.switch.js"></script>
	<script src="/public/static/js/jquery.unobtrusive-ajax.min.js"></script>
	<script src="/public/static/js/common.js"></script>
	<script src="/public/static/js/seller.js"></script>
	<script src="/public/static/js/load_task.js"></script>
	<script src="/public/static/js/load_bottom.js" type="text/javascript"></script>
	<script src="/template/admin/public/js/layer/layer.js"></script>
	<script src="/template/admin/public/js/jquery-ui.min.js"></script>
	<script src="/template/admin/public/js/ns_tool.js"></script>
	<script src="/template/admin/public/js/jquery.selectric.js"></script>
	<link rel="stylesheet" type="text/css" href="/public/static/blue/css/ns_table_style.css">
	<script>
	/**
	 * Niushop商城系统 - 团队十年电商经验汇集巨献!
	 * ========================================================= Copy right
	 * 2015-2025 山西牛酷信息科技有限公司, 保留所有权利。
	 * ---------------------------------------------- 官方网址:
	 * http://www.niushop.com.cn 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用。
	 * 任何企业和个人不允许对程序代码以任何形式任何目的再发布。
	 * =========================================================
	 * 
	 * @author : 小学生王永杰 
	 * @date : 2016年12月16日 16:17:13
	 * @version : v1.0.0.0 商品发布中的第二步，编辑商品信息
	 */
	var PLATFORM_NAME = "<?php echo $title_name; ?>";
	var ADMINIMG = "/template/admin/public/images";//后台图片请求路径
	var ADMINMAIN = "http://127.0.0.1:8080/index.php/admin";//后台请求路径
	var SHOPMAIN = "http://127.0.0.1:8080/index.php";//PC端请求路径
	var APPMAIN = "http://127.0.0.1:8080/index.php/wap";//手机端请求路径
	var UPLOAD = "";//上传文件根目录
	var PAGESIZE = "<?php echo $pagesize; ?>";//分页显示页数
	var ROOT = "";//根目录
	var ADDONS = "/addons";
	var STATIC = "/public/static";
	
	function api(method, param,callback, async) {
		// async true为异步请求 false为同步请求
		var async = async != undefined ? async : true;
		$.ajax({
			type: 'post',
			url: __URL(APPMAIN + "/index/ajaxapi"),
			dataType: "JSON",
			async: async,
			data: { method : method, param: JSON.stringify(param)},
			success: function (res) {
				if (callback) callback(res);
			}
		});
	}
</script>
	
<link rel="stylesheet" type="text/css" href="/template/admin/public/css/product.css">
<script type="text/javascript" src="/public/static/My97DatePicker/WdatePicker.js"></script>
<style type="text/css">
#productTbody tr:hover i.edit-sign{opacity: 1}
#productTbody td{padding:5px;font-size:12px;}
#productTbody td:first-child{border-left: 1px solid #E1E6F0;}
#productTbody td:last-child{border-right: 1px solid #E1E6F0;}
#productTbody tr:last-child td{border-bottom:1px solid #E1E6F0;}
/* .tr-title td{border-top: 1px solid #E1E6F0;} */
.a-pro-view-img {float: left;}
.thumbnail-img {width: 60px;margin-right: 10px;height: 60px;}
.cell i {display: block;}
.remodal-bg.with-red-theme.remodal-is-opening,.remodal-bg.with-red-theme.remodal-is-opened {filter: none;}
.remodal-overlay.with-red-theme {background-color: #f44336;}
.remodal.with-red-theme {background: #fff;}
input[type="radio"], input[type="checkbox"] {margin: -1px 5px 0 0;}
.edit-group{border-bottom: 1px solid #ebebeb;margin-bottom:10px;}
.edit-group label{font-weight:normal;}
.edit-group-title{height:15px;line-height:15px;width:140px;margin-top:3px;margin-bottom:3px;color:#00A0DE;}
.edit-group-button{border: 1px solid #bbb;height: 26px;line-height: 24px;padding: 0 5px;}
.group-button-bg{background: #3283fa;color: #fff;}
.div-pro-view-name {width: 100%;min-height: 60px;}
i.hot,i.recommend,i.new{font-size:12px;margin-right:5px;font-style:normal;color:#fff;background-color:#FF6600;border-radius:2px;padding:1px 4px;position: relative;top:-5px;}
.icon-qrcode:before {content: "\f029";}
[class^="icon-"]:before, [class*=" icon-"]:before {text-decoration: inherit;display: inline-block;speak: none;}
[class^="icon-"], [class*=" icon-"] {font-family: FontAwesome;font-weight: normal;font-style: normal;text-decoration: inherit;-webkit-font-smoothing: antialiased;}

input[type=number] {-moz-appearance:textfield;}
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {-webkit-appearance: none;margin: 0;}
input, textarea, .uneditable-input {width: 147px;}
.table th, .table td {vertical-align: middle;}
.recommendBox{width: 360px;display: inline-block;float: right;}
.introduction_box{width: 360px;display: inline-block;float: right;}
.tab-content{overflow: visible;}
.editGoodsIntroduction{display: inline-block;border:1px dashed #fff;padding: 0;width: 341px;line-height: 25px;max-height: 60px;overflow: hidden;text-overflow: ellipsis;height: 25px;}
.editGoodsIntroduction:hover{border-color: #ddd;cursor: pointer;}
.editGoodsIntroduction + input{padding: 0 5px;width: 350px;line-height: 25px;height: 25px;background: #EEF7FF;display: none;margin:0 0 10px !important;}
.editGoodsIntroduction>a{margin-left:0 !important;}
.goods-fields-sort{cursor:pointer;}
.goods-fields-sort span{
	    width: 11px;
    display: inline-block;
    margin-left: 0px;
    vertical-align: middle;
    position: absolute;
    font-size: 12px;
}
.more-search{line-height: 20px;background: #fff;outline: none;font-size: 17px;}
.interval{width: 2px;display: inline-block;}
.ns-main{margin-top: 0;}
.btn-common-white,.btn-common{outline: none;line-height: 20px;display: inline-block;}
@media screen and (max-width:1260px) {
	a.btn-common{margin-bottom:5px !important;}
}

/* 商品规格项展示 */
.table-class tbody td a{margin-left: 0px;}
.single-goods-sku{
	height: 1px;
}
.single-goods-sku .single-item{
	float: left;
	border-left: 1px dashed #E1E6F0;
	min-width: 110px;
	padding: 10px;
}
.single-goods-sku .single-item:FIRST-CHILD {
	border-left:0px;
}
.single-goods-sku .single-item .hold-img{
	height: 60px;
    border: 1px solid #E1E6F0;
    padding: 5px;
}
.hold-img img{max-width: 100%;max-height: 100%;}
.single-goods-sku .single-item p{
	margin: 0px;
    width: 100px;
    display:block;
	white-space:nowrap;
	overflow:hidden;
	text-overflow:ellipsis;
}
.single-goods-sku .single-item p.spec-title{
    margin-top: 5px;
}
.single-item .row-term p{width: 100px; text-align: left; }
.single-item .row-term p .row-title{
	display: inline-block;
	text-align: left;
}
.single-item .hold-btn{
    text-align: left;
    padding-left: 5px;
}
.goods-sku-click{display: inline-block;float: left;margin: 23px 10px;}
.fx-radio-block{margin:0;}
.div-flag-style{
    display: inline-block;
    margin: 0 20px;
    position: relative;
    cursor: pointer;
}

/* 二维码 */
.QRcode{
    position: absolute;
    width: 110px;
    top: 21px;
    left: 0px;
    z-index: 10;
    border: 1px solid rgb(230, 233, 240);
    background: rgb(255, 255, 255);
    padding: 5px;
    display: none;
}
.QRcode p{margin: 0px}

.goods-type{width: 650px;margin: 10% auto;}
.goods-type .type-title{
	font-size: 23px;
    font-weight: 100;
    text-align: center;
    margin-bottom: 40px;
}
.goods-type .item-type{   
	width: 47%;
    border: 1px solid #e6e9f0;
    display: inline-block;
    margin: 20px 1%;
    padding: 30px 0px 30px 30px;
    box-sizing: border-box;
	cursor: pointer;
	height: 120px;
}
.goods-type .item-type:hover{background: #f5f7fa;}
.goods-type .item-type div{display: inline-block;float: left;}
.goods-type .item-type div.item-content{margin-left: 10px; width: 206px;}
.goods-type .item-type div.item-content p{margin-bottom: 0px;}
.goods-type .item-type div.item-content p.name{margin-top: 2px;}
.goods-type .item-type div.item-content p.description{color: #999;
    font-size: 12px;
    margin-top: 7px;}
</style>

	</head>
<body>
<input type="hidden" id="niushop_rewrite_model" value="<?php echo rewrite_model(); ?>">
<input type="hidden" id="niushop_url_model" value="<?php echo url_model(); ?>">
<input type="hidden" id="niushop_admin_model" value="<?php echo admin_model(); ?>">
<script>
function __URL(url){
	url = url.replace('http://127.0.0.1:8080/index.php', '');
	url = url.replace('http://127.0.0.1:8080/index.php/wap', 'wap');
	url = url.replace('http://127.0.0.1:8080/index.php/admin', $("#niushop_admin_model"));
	if(url == ''|| url == null){
		return 'http://127.0.0.1:8080/index.php';
	}else{
		var str=url.substring(0, 1);
		if(str=='/' || str=="\\"){
			url=url.substring(1, url.length);
		}
		if($("#niushop_rewrite_model").val()==1 || $("#niushop_rewrite_model").val()==true){
			return 'http://127.0.0.1:8080/index.php/'+url;
		}
		var action_array = url.split('?');
		//检测是否是pathinfo模式
		url_model = $("#niushop_url_model").val();
		if(url_model==1 || url_model==true){
			var base_url = 'http://127.0.0.1:8080/index.php/'+action_array[0];
			var tag = '?';
		}else{
			var base_url = 'http://127.0.0.1:8080/index.php?s=/'+ action_array[0];
			var tag = '&';
		}
		if(action_array[1] != '' && action_array[1] != null){
			return base_url + tag + action_array[1];
		}else{
			return base_url;
		}
	}
}

//处理图片路径
function __IMG(img_path){
	var path = "";
	if(img_path != undefined && img_path != ""){
		if(img_path.indexOf("http://") == -1 && img_path.indexOf("https://") == -1){
			path = UPLOAD+"\/"+img_path;
		}else{
			path = img_path;
		}
	}
	return path;
}
</script>
<article class="ns-base-article">

	<header class="ns-base-header">
		<div class="ns-logo" onclick="location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/admin'); ?>';"></div>
		<div class="ns-search">
			<div class="nav-menu js-nav">
				<img src="/public/static/blue/img/nav_menu.png" title="导航管理" />
			</div>
			<div class="ns-navigation-management">
				<div class="ns-navigation-title">
					<h4>导航管理</h4>
					<span>x</span>
				</div>
				<div style="height:40px;"></div>
				<?php if(is_array($nav_list) || $nav_list instanceof \think\Collection || $nav_list instanceof \think\Paginator): if( count($nav_list)==0 ) : echo "" ;else: foreach($nav_list as $key=>$nav): ?>
				<dl>
					<dt><?php echo $nav['data']['module_name']; ?></dt>
					<?php if(is_array($nav['sub_menu']) || $nav['sub_menu'] instanceof \think\Collection || $nav['sub_menu'] instanceof \think\Paginator): if( count($nav['sub_menu'])==0 ) : echo "" ;else: foreach($nav['sub_menu'] as $key=>$nav_sub): ?>
					<dd>
						<?php if($nav_sub['module'] == 'admin'): ?>
						<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/admin/'.$nav_sub['url']); ?>"><?php echo $nav_sub['module_name']; ?></a>
						<?php else: ?>
						<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/'.$nav_sub['module'].'/admin/'.$nav_sub['url']); ?>"><?php echo $nav_sub['module_name']; ?></a>
						<?php endif; ?>
						
					</dd>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</dl>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
			<div class="ns-search-block">
				<i class="fa fa-search" title="搜索"></i>
				<span>搜索</span>
				<div class="mask-layer-search">
					<input type="text" id="search_goods" placeholder="搜索" />
					<a href="javascript:search();"><img src="/public/static/blue/img/enter.png"/></a>
				</div>
			</div>
		</div>
		<nav>
			<ul>
				<?php if(is_array($headlist) || $headlist instanceof \think\Collection || $headlist instanceof \think\Paginator): if( count($headlist)==0 ) : echo "" ;else: foreach($headlist as $key=>$per): if(strtoupper($per['module_id']) == $headid): if($per['module'] == 'admin'): ?>
					<li class="selected" onclick="location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/admin/'.$per['url']); ?>';">
					<?php else: ?>
					<li class="selected" onclick="location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/'.$per['module'].'/admin/'.$per['url']); ?>';">
					<?php endif; ?>
				
					<span><?php echo $per['module_name']; ?></span>
					<?php if($per['module_id'] == 10000): ?>
						<span class="is-upgrade"></span>
					<?php endif; ?>
				</li>
				
				<?php else: if($per['module'] == 'admin'): ?>
					<li  onclick="location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/admin/'.$per['url']); ?>';">
					<?php else: ?>
					<li  onclick="location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/'.$per['module'].'/admin/'.$per['url']); ?>';">
					<?php endif; ?>
				
					<span><?php echo $per['module_name']; ?></span>
					<?php if($per['module_id'] == 10000): ?>
						<span class="is-upgrade"></span>
					<?php endif; ?>
				</li>
				<?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</nav>
		<div class="ns-base-tool">
			<div class="ns-help">
				<div class="logo">
				<?php if($user_headimg != ''): ?>
				<img src="<?php echo __IMG($user_headimg); ?>"/>
				<?php else: ?>
				<img src="/public/static/blue/img/user_admin_blue.png" >
				<?php endif; ?>
				</div>
				<span><?php echo $user_name; ?></span>
				<i class="fa fa-angle-down"></i>
				<ul>
					<li onclick="window.open('<?php echo __URL('http://127.0.0.1:8080/index.php'); ?>')">
						<img src="/public/static/blue/img/admin-icon-home.png"/>
						<a href="javascript:;" target= _blank data-toggle="modal" title="商城首页">首页</a>
					</li>
					<div class="line"></div>
					<li title="清理缓存" onclick="delcache()">
						<img src="/public/static/blue/img/admin-icon-cache.png"/>
						<a href="javascript:;">清理缓存</a>
					</li>
					<div class="line"></div>
					<li title="修改密码" onclick="editpassword()">
						<img src="/public/static/blue/img/admin-icon-pwd.png"/>
						<a href="#edit-password" data-toggle="modal" title="修改密码">修改密码</a>
					</li>
					<div class="line"></div>
					<li title="加入收藏" onclick="addFavorite()">
						<img src="/public/static/blue/img/admin-icon-collect.png"/>
						<a href="javascript:;">加入收藏</a>
					</li>
					<li title="退出登录" class="admin-exit" onclick="window.location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/admin/login/logout'); ?>'">
						<a href="javascript:;">退出登录</a>
						<img src="/public/static/blue/img/admin-icon-close.png" />
					</li>
				</ul>
			</div>
		</div>
	</header>
	
	<aside class="ns-base-aside">
		<div class="ns-main-block">
			
			<h3 style="margin-top:50px;">
				<?php if(is_array($headlist) || $headlist instanceof \think\Collection || $headlist instanceof \think\Paginator): if( count($headlist)==0 ) : echo "" ;else: foreach($headlist as $key=>$per): if(strtoupper($per['module_id']) == $headid): ?>
					<span class="<?php echo $per['module_name']; ?>"><?php echo $per['module_name']; ?></span>
					<i class="fa fa-caret-down"></i>
				<?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</h3>
			
			<nav>
				<ul>
					<?php if(is_array($leftlist) || $leftlist instanceof \think\Collection || $leftlist instanceof \think\Paginator): if( count($leftlist)==0 ) : echo "" ;else: foreach($leftlist as $key=>$leftitem): if(strtoupper($leftitem['module_id']) == $second_menu_id): if($leftitem['module'] == 'admin'): ?>
						<li class="selected" onclick="location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/admin/'.$leftitem['url']); ?>';" title="<?php echo $leftitem['module_name']; ?>"><?php echo $leftitem['module_name']; ?></li>
						<?php else: ?>
						<li class="selected" onclick="location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/'.$leftitem['module'].'/admin/'.$leftitem['url']); ?>';" title="<?php echo $leftitem['module_name']; ?>"><?php echo $leftitem['module_name']; ?></li>
						<?php endif; else: if($leftitem['module'] == 'admin'): ?>
						<li onclick="location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/admin/'.$leftitem['url']); ?>';" title="<?php echo $leftitem['module_name']; ?>"><?php echo $leftitem['module_name']; ?></li>
						<?php else: ?>
						<li onclick="location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/'.$leftitem['module'].'/admin/'.$leftitem['url']); ?>';" title="<?php echo $leftitem['module_name']; ?>"><?php echo $leftitem['module_name']; ?></li>
						<?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
					<!-- 快捷菜单列表 -->
					<?php if($is_show_shortcut_menu == 1): if(is_array($shortcut_menu_list) || $shortcut_menu_list instanceof \think\Collection || $shortcut_menu_list instanceof \think\Paginator): $i = 0; $__LIST__ = $shortcut_menu_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;if($menu['module'] == 'admin'): ?>
						<li onclick="location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/admin/'.$menu['url']); ?>';" title="<?php echo $menu['module_name']; ?>"><?php echo $menu['module_name']; ?></li>
						<?php else: ?>
						<li onclick="location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/'.$menu['module'].'/admin/'.$menu['url']); ?>';" title="<?php echo $menu['module_name']; ?>"><?php echo $menu['module_name']; ?></li>
						<?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>
				</ul>
				<!-- 快捷菜单设置按钮 -->
				<?php if($is_show_shortcut_menu == 1): ?>
				<div class="shortcut-menu" onclick="show_shortcut_menu()">
					<span></span>
					常用功能
				</div>
				<?php endif; ?>
			</nav>
			
			<div style="height:50px;"></div>
			
			<div id="bottom_copyright">
				<footer>
					<img id="copyright_logo"/>
<!-- 					<p> -->
<!-- 						<span id="copyright_desc"></span> -->
<!-- 						<br/> -->
<!-- 						<a id="copyright_companyname" style="color: #333" target="_blank"></a> -->
<!-- 						<br/> -->
<!-- 						<span id="copyright_meta"></span> -->
<!-- 					</p> -->
				</footer>
			</div>
		</div>
	</aside>
	
	<section class="ns-base-section">
		
		
		
		<div style="position:relative;margin:0;">
			<!-- 面包屑导航 -->
			<?php if(!isset($is_index)): ?>
			<div class="breadcrumb-nav">
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/admin'); ?>"><?php echo $title_name; ?></a>
					<?php if($frist_menu['module_name'] != ''): ?>
					<i class="fa fa-angle-right"></i>
						<?php if($frist_menu['module'] == 'admin'): ?>
						<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/admin/'.$frist_menu['url']); ?>"><?php echo $frist_menu['module_name']; ?></a>
						<?php else: ?>
						
						<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/'.$frist_menu['module'].'/admin/'.$frist_menu['url']); ?>"><?php echo $frist_menu['module_name']; ?></a>
						
						<?php endif; endif; if($secend_menu['module_name'] != ''): ?>
					<i class="fa fa-angle-right"></i>
					<!-- 需要加跳转链接用这个：http://127.0.0.1:8080/index.php/admin/<?php echo $secend_menu['url']; ?> -->
					<a href="javascript:;" style="color:#999;"><?php echo $secend_menu['module_name']; ?></a>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			<!-- 三级导航菜单 -->
			
				<?php if(count($child_menu_list) > 1): ?>
				<nav class="ns-third-menu">
					<ul>
					<?php if(is_array($child_menu_list) || $child_menu_list instanceof \think\Collection || $child_menu_list instanceof \think\Paginator): if( count($child_menu_list)==0 ) : echo "" ;else: foreach($child_menu_list as $k=>$child_menu): if($child_menu['active'] == '1'): if(!(empty($child_menu['module']) || (($child_menu['module'] instanceof \think\Collection || $child_menu['module'] instanceof \think\Paginator ) && $child_menu['module']->isEmpty()))): ?>
									<li class="selected" onclick="location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/'.$child_menu['module'].'/admin/'.$child_menu['url']); ?>';"><?php echo $child_menu['menu_name']; ?></li>
								<?php else: ?>
									<li class="selected" onclick="location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/admin/'.$child_menu['url']); ?>';"><?php echo $child_menu['menu_name']; ?></li>
								<?php endif; else: if(!(empty($child_menu['module']) || (($child_menu['module'] instanceof \think\Collection || $child_menu['module'] instanceof \think\Paginator ) && $child_menu['module']->isEmpty()))): ?>
									<li onclick="location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/'.$child_menu['module'].'/admin/'.$child_menu['url']); ?>';"><?php echo $child_menu['menu_name']; ?></li>
								<?php else: ?>
									<li onclick="location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/admin/'.$child_menu['url']); ?>';"><?php echo $child_menu['menu_name']; ?></li>
								<?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</nav>
				<?php endif; ?>
			
			<div class="right-side-operation hide">
				<ul>
					
					
<!-- 					<?php if($warm_prompt_is_show == 'show'): ?>style="display:none;"<?php endif; ?> style="display:block;" -->
					<li>
						<a class="js-open-warmp-prompt " href="javascript:;" data-menu-desc=''><i class="fa fa-question-circle"></i>&nbsp;提示</a>
						<div class="popover">
							<div class="arrow"></div>
							<div class="popover-content">
								<div>
									<?php if($secend_menu['desc']): ?>
									<h4>操作提示</h4>
									<p><?php echo $secend_menu['desc']; ?></p>
									<hr/>
									<?php endif; ?>
									<h4>功能提示</h4>
									<p class="function-prompts"></p>
								</div>
							</div>
						</div>
					</li>
					
				</ul>
			</div>
		</div>
		
		<!-- 操作提示 -->
		
<!-- 		<?php if($warm_prompt_is_show == 'hidden'): ?>style="display:none;"<?php endif; ?> -->
		<div class="ns-warm-prompt" style="display:none;">
			<div class="alert alert-info">
				<button type="button" class="close">&times;</button>
				<h4>
<!-- 					{1block name="alert_info"} -->
<!-- 					<i class="fa fa-info-circle"></i> -->
<!-- 					<span class="operating-hints">操作提示</span> -->
<!-- 						<?php if($secend_menu['desc']): ?> -->
<!-- 						<span><?php echo $secend_menu['desc']; ?></span> -->
<!-- 						<?php endif; ?> -->
<!-- 					{1/block} -->
				</h4>
			</div>
		</div>
		
		
		<div class="ns-main">
			
<div class="js-mask-category" style="display:none;background: rgba(0,0,0,0);position:fixed;width:100%;height:100%;top:0;left:0;right:0;bottom:0;z-index:90;"></div>
<table class="mytable">
	<tr>
		<th align="left">
			<a class="btn-common" href="javascript:addGoods();">发布商品</a>
			<a class="btn-common-white" href="javascript:batchDelete()">批量删除</a>
			<a class="btn-common-white upstore" href="javascript:goodsIdCount('online')">上架</a>
			<a class="btn-common-white downstore" href="javascript:goodsIdCount('offline')">下架</a>
			<a class="btn-common-white recommend" href="javascript:ShowRecommend()" data-html="true" id="setRecommend" title="推荐"
			data-container="body" data-placement="bottom"  data-trigger="manual"
			data-content="<div class='edit-group' id='recommendType'>
				<label class='checkbox-inline'><i class='checkbox-common'><input type='checkbox' value='1' /></i> 热卖 </label>
				<label class='checkbox-inline'><i class='checkbox-common'><input type='checkbox' value='2' /></i> 精品 </label>
				<label class='checkbox-inline'><i class='checkbox-common'><input type='checkbox' value='3' /></i> 新品 </label>
				</div>
				<button class='btn-common btn-small' onclick='setRecommend();'>保存</button>
				<button class='btn btn-small' onclick='hideSetRecommend()'>取消</button>
				"
			>推荐</a>
			<a data-html="true" class="btn-common-white fun-a category" href="javascript:goodsGroupIdCount();" id="editGroup" title="修改商品标签" data-container="body" data-placement="bottom"  data-trigger="manual"
				data-content="<div class='edit-group' id='goodsChecked' style='max-width:auto;'>
					<?php foreach($goods_group as $vo): ?>
					<label class='checkbox-inline'>
					<i class='checkbox-common'><input type='checkbox' value='<?php echo $vo['group_id']; ?>'></i>
					<span><?php echo $vo['group_name']; ?></span>&nbsp;&nbsp;&nbsp;
				</label>
				<?php foreach($vo['sub_list']['data'] as $vs): ?>
				<label style='display:inline-block;'>
					<input type='checkbox' value='<?php echo $vs['group_id']; ?>'><?php echo $vs['group_name']; ?>
					</label>
					<?php endforeach; endforeach; ?>
				</div>
				<button class='btn-common btn-small' onclick='goodsGroupUpdate();'>保存</button>
				<button class='btn btn-small' onclick='hideEditGroup()'>取消</button>
				">
				商品标签</a>
			<a href="javascript:batchUpdateGoodsQrcode();;" class="btn-common-white fun-a category" title="更新二维码">更新二维码</a>
			<a href="javascript:;" id="batchProcessing"  class="btn-common-white" title="批量设置商品信息">批量处理</a>
			<a href="javascript:;" id="setMemberDiscount"  class="btn-common-white" title="批量设置会员折扣">设置折扣</a>
			
			
			<?php if(addon_is_exit('Nsfx')): ?>
				<!-- 商品分销设置 -->
				<a class="btn-common" href="javascript:void(0)"onclick="goodsIdDistribution('open')">开启分销</a>
				<a class="btn-common-white" href="javascript:void(0)" onclick="goodsIdDistribution('off')">关闭分销</a>
				<a class="btn-common-white" href="javascript:void(0)" onclick="setGoodsDistribution('',3)">分销设定(总)</a>
				
				<a class="btn-common-white fun-a category" href="javascript:void(0)" onclick="showGoodsGoodsDistributionGroupCount();"  data-html="true" href="javascript:void(0)" id="goodsDistributionGroup" title="商品分销修改"  
      					data-container="body" data-placement="bottom"  data-trigger="manual"
      					data-content="<div class='edit-group' id='distributionGoodsChecked' style='max-width:auto;'>
					<?php foreach($goods_group as $vo): ?> 
					  <p>
					  	<label class='checkbox-inline'  >
					  	<i class='checkbox-common'>
				    	<input type='checkbox' name='check_<?php echo $vo['group_id']; ?>' value='<?php echo $vo['group_id']; ?>'>
				  		</i>
				  		<span><?php echo $vo['group_name']; ?></span>&nbsp;&nbsp;&nbsp;
				  	</label>
				  	
				  </p>
				  
				<?php endforeach; ?>
				</div>							
				<button class='btn-common btn-small' onclick=setGoodsDistribution('',2);>确认</button>
				<button class='btn btn-small' onclick='hideGoodsGoodsDistributionGroupCount()'>取消</button>
				" >分销设定(标签)</a>
			<?php endif; ?>
			<input type='hidden' id='goods_type_ids'/>
		</th>
		<th style="position: relative;" class="default-condition">
			<span class="interval"></span>
			<span>商品名称：</span>
			<input id="goods_name" class="input-medium input-common middle" type="text" value="<?php echo $search_info; ?>" placeholder="要搜索的商品名称" >	
			<span class="interval"></span>
			<span class="interval"></span>
			<button onclick="searchData()" class="btn-common">搜索</button>
			<button onclick="openSeniorSearch('.default-condition')" value="搜索" class="btn-common" >高级搜索</button>
			
		</th>
	</tr>
</table>

<!-- 高级搜索 -->
<div class="nui-condition">
	<div class="c-item-column">
		<label for="">商品名称：</label>
		<input id="goods_name" class="input-medium input-common middle" type="text" value="<?php echo $search_info; ?>" placeholder="要搜索的商品名称" >
	</div>
	
	<div class="c-item-column">
		<label for="">商品编码：</label>
		<input id="goods_code" class="input-medium input-common middle" type="text" placeholder="要搜索的商品编码"/>
	</div>
	
	<div class="c-item-column">
		<label for="">供货商：</label>
		<select id="supplier_id" class="select-common middle">
			<option value="">全部</option>
			<?php if(!(empty($supplier_list) || (($supplier_list instanceof \think\Collection || $supplier_list instanceof \think\Paginator ) && $supplier_list->isEmpty()))): if(is_array($supplier_list) || $supplier_list instanceof \think\Collection || $supplier_list instanceof \think\Paginator): $i = 0; $__LIST__ = $supplier_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<option value="<?php echo $vo['supplier_id']; ?>"><?php echo $vo['supplier_name']; ?></option>
			<?php endforeach; endif; else: echo "" ;endif; endif; ?>
		</select>
	</div>
	<br />
	<div class="c-item-column">
		<label for="">商品类型：</label>
		<select id="goods_type" class="select-common middle" >
			<option value="all">全部</option>
			<?php if(is_array($goods_type_list) || $goods_type_list instanceof \think\Collection || $goods_type_list instanceof \think\Paginator): $i = 0; $__LIST__ = $goods_type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<option value="<?php echo $vo['id']; ?>"><?php echo $vo['title']; ?></option>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</select>
	</div>
	
	<div class="c-item-column">
		<label for="">商品标签：</label>
		<input type="text" placeholder="请选择商品标签" id="selectGoodsLabel"  onfocus="selectGoodsLabel();" is_show="false" data-html="true" class="input-common middle" title="<h6 class='edit-group-title'>选择商品标签</h6>" data-container="body" data-placement="bottom"  data-trigger="manual" data-content="<div class='edit-group' style='max-width:auto;'>
			<?php foreach($goods_group as $vo): ?>
					<p>
					<label class='checkbox-inline' style='display:inline-block;'>
					<input type='checkbox' value='<?php echo $vo['group_id']; ?>' onchange='clickGoodsLabel(this);'><span><?php echo $vo['group_name']; ?></span>&nbsp;&nbsp;&nbsp;
					</label>
				<?php endforeach; ?>
			</div></div>
			<button class='btn-common btn-small' onclick='confirm();'>确认</button>
			<button class='btn btn-small' onclick='hideGroup()'>取消</button>
			">
	</div>
	
	<div class="c-item-column">
		<label for="">商品分类：</label>
		<style>
.goodsCategory{width: 148px;height: 300px;border: 1px solid #CCCCCC;position: absolute;z-index: 100;background: #fff;right: 0;display: none;overflow-y: auto;top: 31px;}
.goodsCategory::-webkit-scrollbar{width: 3px;}
.goodsCategory::-webkit-scrollbar-track{-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);border-radius: 10px;background-color: #fff;}
.goodsCategory::-webkit-scrollbar-thumb{height: 20px;border-radius: 10px;-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);background-color: #ccc;}
.goodsCategory ul{height: 280px;margin-top: -2px;margin-left: 0;}
.goodsCategory ul li{text-align: left;padding:0 10px;line-height: 30px;}
.goodsCategory ul li i{float: right;line-height: 30px;}
.goodsCategory ul li:hover{cursor: pointer;}
.goodsCategory ul li:hover,.goodsCategory ul li.selected{background: #00A0DE;color: #fff;}
.goodsCategory ul li span{width: 110px;display: inline-block;white-space: nowrap;text-overflow: ellipsis;overflow: hidden;vertical-align: middle;font-size:12px;}
.two{left: 150px;border-left:0;}
.three{left: 299px;width: 148px;border-left:0;}
.selectGoodsCategory{width: 218px;height: 45px;border:1px solid #CCCCCC;position: absolute;z-index: 100;left: 0;margin-top: 299px;border-collapse: collapse;background: #fff;display: none;}
.selectGoodsCategory a{display: block;height: 30px;width: 100px;text-align: center;color: #fff;line-height: 30px;margin:8px;background: #00A0DE;text-decoration:none;}
</style>


<div style="display: inline-block;position: relative;">
<input type="text" placeholder="请选择商品分类" id="goodsCategoryOne" is_show="false" class="input-common middle">
	<div class="goodsCategory one">
		<ul>
			<?php if(is_array($oneGoodsCategory) || $oneGoodsCategory instanceof \think\Collection || $oneGoodsCategory instanceof \think\Paginator): $i = 0; $__LIST__ = $oneGoodsCategory;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<li class="js-category-one" category_id="<?php echo $vo['category_id']; ?>">
				<span><?php echo $vo['category_name']; ?></span>
				<?php if($vo['is_parent'] == 1): ?>
					<i class="fa fa-angle-right fa-lg"></i>
				<?php endif; ?>
			</li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
	<div class="goodsCategory two" style="border-left:0;">
		<ul id="goodsCategoryTwo"></ul>
	</div>
	<div class="goodsCategory three">
		<ul id="goodsCategoryThree"></ul>
	</div>
	<div class="selectGoodsCategory">
		<a href="javascript:;" id="confirmSelect" style="float:right;">确认选择</a>
	</div>
	<input type="hidden" id="category_id_1">
	<input type="hidden" id="category_id_2">
	<input type="hidden" id="category_id_3">
</div>

<script>
$("#goodsCategoryOne").click(function(){
	var isShow = $("#goodsCategoryOne").attr('is_show');
	if(isShow == "false"){
		$(".one").show();
		$(".selectGoodsCategory").css({
			'width' : 148,
			'right' : 580
		}).show();
		$("#goodsCategoryOne").attr('is_show','true');
		$(".js-mask-category").show();
	}else{
		$(".one").hide();
		$(".two").hide();
		$(".three").hide();
		$(".selectGoodsCategory").css({
			'width' : 148,
			'right' : 580
		}).hide();
		$("#goodsCategoryOne").attr('is_show','false');
	}
});

$(".js-mask-category").click(function(){
	$(".one").hide();
	$(".selectGoodsCategory").hide();
	$(".two").hide();
	$(".three").hide();
	$("#goodsCategoryOne").attr('is_show', 'false');
	$(this).hide();
});

$(".js-category-one").click(function(){
	parentId = $(this).attr("category_id");
	category_name = $(this).text();
	$(".one ul li").not($(this)).removeClass("selected");
	$(this).addClass("selected");
	$("#goodsCategoryOne").val($.trim(category_name)+">");
	$("#category_id_1").val(parentId);
	$("#category_id_2").val('');
	$("#category_id_3").val('');
	$.ajax({
		type : 'post',
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/getcategorybyparentajax'); ?>",
		data : {"parentId":parentId},
		success : function(data){
			if(data.length>0){
				var html = '';
				for (var i = 0; i < data.length; i++) {
					html += '<li class="js-category-two" category_id="'+data[i]['category_id']+'">'+data[i]['category_name'];
					if(data[i]['is_parent'] == 1){
						html += '<i class="fa fa-angle-right fa-lg"></i>';
					}
					html += '</li>';
				}
				$("#goodsCategoryTwo").html(html);
				$(".two").show();
				$(".selectGoodsCategory").css({
					'width' : 297,
					'right' : 361
				});
			}else{
				$(".one").hide();
				$(".two").hide();
				$(".js-mask-category").hide();
				$(".selectGoodsCategory").hide();
				$("#goodsCategoryOne").attr('is_show', 'false');
			}
			$(".three").hide();
		}
	});
	return false;
});

$(".js-category-two").live("click",function(event){
	var parentId = $(this).attr("category_id");
	var category_name = $(this).text();
	$(".two ul li").not($(this)).removeClass("selected");
	$(this).addClass("selected");
	var goodsCategoryOne = $("#goodsCategoryOne").val();
	$("#goodsCategoryOne").val(goodsCategoryOne+''+category_name+'>');
		$("#category_id_2").val(parentId);
	$("#category_id_3").val('');
	$.ajax({
		type : 'post',
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/getcategorybyparentajax'); ?>",
		data : {"parentId":parentId},
		success : function(data){
			if(data.length>0){
				var html = '';
				for (var i = 0; i < data.length; i++) {
					html += '<li onclick="goodsCategoryThree(this);" category_id="'+data[i]['category_id']+'">'+data[i]['category_name']+'<i class="fa fa-angle-right fa-lg"></i></li>';
				}
				$("#goodsCategoryThree").html(html);
				$(".three").show();
				$(".selectGoodsCategory").css({
					'width' : 446,
					'right' : 162
				});
			}else{
				$(".one").hide();
				$(".two").hide();
				$(".three").hide();
				$(".selectGoodsCategory").hide();
				$(".js-mask-category").hide();
				$("#goodsCategoryOne").attr('is_show', 'false');
			}
		}
	});
	event.stopPropagation();
});

function goodsCategoryThree(obj){
	var parentId = $(obj).attr("category_id");
	var category_name = $(obj).text();
	$(".three ul li").not($(obj)).removeClass("selected");
	$(obj).addClass("selected");
	var goodsCategoryOne = $("#goodsCategoryOne").val();
	$("#goodsCategoryOne").val(goodsCategoryOne+''+category_name).attr('is_show','false');
	$("#category_id_3").val(parentId);
	$(".one").hide();
	$(".two").hide();
	$(".three").hide();
	$(".js-mask-category").hide();
	$(".selectGoodsCategory").css({
		'width' : 218,
		'right' : 580
	}).hide();
}

$("#confirmSelect").click(function(){
	$(".one").hide();
	$(".two").hide();
	$(".three").hide();
	$(".selectGoodsCategory").hide().css({
		'width' : 218,
		'right' : 580
	});
})
</script>
	</div>
	<br />
	
	<div class="c-operation">
		<button onclick="searchData()"  value="搜索" class="btn-common" >搜索</button>
		<a href="javascript:clearCondition();">清空筛选条件</a>
	</div>
	<a href="javascript:retractSeniorSearch();" class="retract">收起↑</a>
</div>

<div id="myTabContent" class="tab-content">
	<div class="tab-pane active">
		<table class="table-class">
			<colgroup>
				<col style="width: 2%;">
				<col style="width: 25%;">

			</colgroup>
			<thead>
				<tr>
					<th>
						<i class="checkbox-common">
							<input onclick="CheckAll(this)" type="checkbox" id="check_all">
						</i>
					</th>
					<th align="left">商品名称</th>
					<?php if(addon_is_exit('Nsfx')): ?>
						<th align="left" >三级分销</th>
					<?php endif; ?>
					<th class="goods-fields-sort" data-field="price" style="text-align: right;">价格(元)<span class="desc">↓</span></th>
					<th class="goods-fields-sort" data-field="stock" style="text-align: right;">总库存<span class="desc">↓</span></th>
					<th class="goods-fields-sort" data-field="sales" style="text-align: right;">销量<span class="desc">↓</span></th>
					<th>商品类型</th>
					<th class="goods-fields-sort" data-field="sort" style="text-align: center;">排序<span class="desc">↓</span></th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody id="productTbody" style="border: 0;">
				
			</tbody>
		</table>
	</div>
	<input type="hidden" id="state" value="<?php echo $state; ?>"/>
	<input type="hidden" id="selectGoodsLabelId">
	<input type="hidden" id="stock_warning" value="<?php echo $stock_warning; ?>">
</div>
<input type="hidden" id="hidden_sort_rule" />

<!-- 批量处理弹出框 -->
<!-- 功能说明：批量处理弹出框 -->
<link rel="stylesheet" type="text/css" href="/template/admin/public/css/plugin/jquery.searchableSelect.css"/>
<style type="text/css">
	.modal{
		border-radius: 0;
		width: 700px;
	}
	#batch_processing .modal .modal-body{
		padding: 15px 10px!important;
		height:400px;
		overflow-y: visible;
	}
	#batch_processing .modal-header h3 {
	    font-size: 16px;
	}
	#batch_processing .tip_info{
		padding: 5px;
	    color: #3a87ad;
		background-color: #d9edf7;
    	border: 1px solid #bce8f1;
	}
	#batch_processing .tip_info p{
		margin:0;
		line-height: 1.5;
		font-size: 13px;
	}
	#batch_processing .setting-item{
		margin: 10px 0;
		width: 100%;
	}
	#batch_processing .setting-item dl{
		width: 100%;
	    margin: 0;
	}
	#batch_processing .setting-item dl dt,#batch_processing .setting-item dl dd{
	    line-height: 45px;
	    display: inline-block;
	    float: left;
	    margin: 0;
	    text-align: left;
	    font-weight: normal;
	    font-size: 13px;
	}
	#batch_processing .setting-item dl dt{
		width: 20%;
	}
	#batch_processing .setting-item dl dd{
	    width: 80%;
	}
	#batch_processing .setting-item dl dd label{
		display: inline-block;
		margin-right: 20px;
	}
	#batch_processing .setting-item dl dd .num{
		width: 60px;
		border-radius: 0;
		margin-bottom: 0;
	}
	#batch_processing .setting-item dl dd .info{
		color: #BBB;
	}
	#batch_processing .setting-item dl dd .select{
	    border-radius: 0;
	    width: 30%;
	    margin-right: 4%;
	    margin-bottom: 0;
	    outline: none;
	}
	#batch_processing .setting-item dl dd .select:last-child{
		margin-right: 0;
	}
	.searchable-select-holder{
		border-radius: 0;
		padding: 4px 20px 4px 6px;
	}
</style>
<div class="modal fade hide" id="batch_processing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>批量处理</h3>
			</div>
			<div class="modal-body">
				<div class="tip_info">
					<p>1、如果未设置任何选择，则商品保持原状不变。</p>
					<p>2、设置商品库存，将作用于所选商品的所有规格项。</p>
				</div>
				<div class="setting-item">
					<dl>
						<dt>商品分类</dt>
						<dd id="Js_goods_category">
							<select class="select-common middle" id="batch_catrgory_one">
								<option value="0">请选择一级分类</option>
								<?php if(is_array($oneGoodsCategory) || $oneGoodsCategory instanceof \think\Collection || $oneGoodsCategory instanceof \think\Paginator): $i = 0; $__LIST__ = $oneGoodsCategory;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
									<option value="<?php echo $vo['category_id']; ?>"><?php echo $vo['category_name']; ?></option>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
							<select class="select-common middle" id="batch_catrgory_two">
								<option value="0">请选择二级分类</option>
							</select>
							<select class="select-common middle" style="width: 150px;" id="batch_catrgory_three">
								<option value="0">请选择三级分类</option>	
							</select>
						</dd>
					</dl>
					<dl>
						<dt>销售价:</dt>
						<dd id="price">
							<label>
								<i class="radio-common selected">
									<input type="radio" checked name="price" value="1">
								</i>
								<span>增加</span>
							</label>
							<label>
								<i class="radio-common">
									<input type="radio" name="price" value="0">
								</i>
								<span>减少</span>
							</label>
							<input type="number" name="" value="0" class="num input-common short" min='0' max="9999.99">
							<span class="info">销售价增加N元或减少N元</span>
						</dd>
					</dl>
					<dl>
						<dt>市场价:</dt>
						<dd id="market_price">
							<label>
								<i class="radio-common selected">
									<input type="radio" checked name="market_price" value="1">
								</i>
								<span>增加</span>
							</label>
							<label>
								<i class="radio-common">
									<input type="radio" name="market_price" value="0">
								</i>
								<span>减少</span>
							</label>
							<input type="number" name="" value="0" class="num input-common short" min='0' max="9999.99">
							<span class="info">市场价增加N元或减少N元</span>
						</dd>
					</dl>
					<dl>
						<dt>成本价:</dt>
						<dd id="cost_price">
							<label>
								<i class="radio-common selected">
									<input type="radio" checked name="cost_price" value="1">
								</i>
								<span>增加</span>
							</label>
							<label>
								<i class="radio-common">
									<input type="radio" name="cost_price" value="0">
								</i>
								<span>减少</span>
							</label>
							<input type="number" name="" value="0" class="num input-common short" min='0' max="9999.99"/>
							<span class="info">成本价增加N元或减少N元</span>
						</dd>
					</dl>
					<dl>
						<dt>库存:</dt>
						<dd id="stock">
							<label>
								<i class="radio-common selected">
									<input type="radio" checked name="stock" value="1">
								</i>
								<span>增加</span>
							</label>
							<label>
								<i class="radio-common">
									<input type="radio" name="stock" value="0">
								</i>
								<span>减少</span>
							</label>
							<input type="number" name="" value="0" class="num input-common short" min='0' max="99999">
							<span class="info">库存增加N件或减少N件</span>
						</dd>
					</dl>
					<dl>
						<dt>商品品牌:</dt>
						<dd id="stock" class="js-brand-block">
							<div>
							<select id="brand_id" style="display: none;" class="middle"></select>
							</div>
						</dd>
					</dl>
				</div>
			</div>
			
			<div class="modal-footer">
				<button class="btn-common btn-big" onclick="save();">保存</button>
				<button class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
	
</div>
<script src="/template/admin/public/js/plugin/jquery.searchableSelect.js"></script>
<script type="text/javascript">
var curr_searchable_select = null;
$(function(){
	//可搜索的商品品牌下拉选项框
	curr_searchable_select = $('#brand_id').searchableSelect();
	getGoodsBrandList();

	$(".searchable-select-input").live("keyup",function(){
		if($(this).val().length>100){
			showTip("查询限制在100个字符以内","warning");
			return;
		}
		if($(this).attr("data-value") != $(this).val()){
			$(this).attr("data-value",$(this).val());
			getGoodsBrandList($(".searchable-select-holder").text(),$(this).val());
		}
	});
});

//查询商品品牌列表
function getGoodsBrandList(brand_name,search_name){
	var page_index = 1;
	var page_size = 20;
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/getGoodsBrandList'); ?>",
		data : { "page_index" : page_index, "page_size" : page_size, "brand_name" : brand_name, "search_name" : search_name, "brand_id" : $("#hidden_goods_brand_id").val() },
		success : function(res){
			var html = '<option value="0">请选择商品品牌</option>';
			if(res.total_count>0){
				for(var i=0;i<res['data'].length;i++){
					html += '<option value="' + res['data'][i].brand_id + '">' + res['data'][i].brand_name + '</option>';
				}
			}
			$("#brand_id").html(html);
			//更新搜索结果
			$(".js-brand-block .searchable-select-items .searchable-select-item").remove();
			curr_searchable_select.buildItems();
		}
	});
}

$("#Js_goods_category select").change(function(){
	var parentId = $(this).val();
	var _this = $(this);
	$.ajax({
		type : 'post',
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/getcategorybyparentajax'); ?>",
		data : {"parentId":parentId},
		success : function(data){
			if(data.length>0){
				var html = '';
				for (var i = 0; i < data.length; i++) {
					html += '<option value="'+ data[i]['category_id'] +'">' + data[i]['category_name'] + '</option>';
				}
				$(_this).parents(".selectric-wrapper").next(".selectric-wrapper").find("select").find("option[value !='0']").remove();
				$(_this).parents(".selectric-wrapper").next(".selectric-wrapper").find("select").find("option:first-child").after(html);
				$(_this).parents(".selectric-wrapper").next(".selectric-wrapper").find("select").selectric();
			}
		}
	})
});

var is_click = false;
function save(){
	var price = 0,
		market_price = 0,
		cost_price  = 0,
		stock = 0,
		catrgory_one = $("#batch_catrgory_one").val(),
		catrgory_two = $("#batch_catrgory_two").val(),
		catrgory_three = $("#batch_catrgory_three").val(),
		brand_id = $("#brand_id").val();
	//销售价
	if($("input[name='price']:checked").val() == 0){
		price -= parseFloat(parseFloat($("#price .num").val()).toFixed(2));
	}else{
		price += parseFloat(parseFloat($("#price .num").val()).toFixed(2));
	}
	//市场价
	if($("input[name='market_price']:checked").val() == 0){
		market_price -= parseFloat(parseFloat($("#market_price .num").val()).toFixed(2));
	}else{
		market_price += parseFloat(parseFloat($("#market_price .num").val()).toFixed(2));
	}
	//成本价
	if($("input[name='cost_price']:checked").val() == 0){
		cost_price -= parseFloat(parseFloat($("#cost_price .num").val()).toFixed(2));
	}else{
		cost_price += parseFloat(parseFloat($("#cost_price .num").val()).toFixed(2));
	}
	//库存
	if($("input[name='stock']:checked").val() == 0){
		stock -= parseInt($("#stock .num").val());
	}else{
		stock += parseInt($("#stock .num").val());
	}

	var goods_ids= [];
	$("#productTbody input[type='checkbox']:checked").each(function() {
		if (!isNaN($(this).val())) {
			goods_ids.push($(this).val());
		}
	});
	
	if(!is_click){
		is_click = true;
		$.ajax({
			type : "post",
			url : '<?php echo __URL("http://127.0.0.1:8080/index.php/admin/goods/batchProcessingGoods"); ?>',
			async : false,
			data : {
				"price" : price,
				"market_price" : market_price,
				"cost_price" : cost_price,
				"stock" : stock,
				"catrgory_one" : catrgory_one,
				"catrgory_two" : catrgory_two,
				"catrgory_three" : catrgory_three,
				"brand_id" : brand_id,
				"goods_ids" : goods_ids.toString()
			},
			success : function(data){
				if(data["code"] > 0){
					$("#batch_processing").modal("hide");
					showMessage("success",data["message"],location.href);
				}else{
					is_click = false;
					showMessage("error",data["message"]);
				}
			}
		})
	}
	
}
</script>
<!-- 设置会员折扣 -->
<style type="text/css">
.modal#set_member_discount{
	border-radius: 0;
	width: 500px;
}
.modal#set_member_discount .modal-body{
	text-align: center;
}
.modal#set_member_discount .modal-body dl{
	margin-top: 0;
	margin-bottom: 10px;
	width: 100%;
	overflow: hidden;
}
.modal#set_member_discount .modal-body dl:last-child{
	margin-bottom: 0;
}
.modal#set_member_discount .modal-body dl dt,.modal#set_member_discount .modal-body dl dd{
	display: inline-block;
	line-height: 30px;
}
.modal#set_member_discount .modal-body dl dt{
	width: 35%;
	text-align: right;
	font-weight: normal;
	float: left;
}
.modal#set_member_discount .modal-body dl dd{
	text-align: left;
	margin-left: 0;
	width: 63%;
	float: right;
}
</style>
<div class="modal fade hide" id="set_member_discount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>设置商品折扣</h3>
			</div>
			<div class="modal-body" id="member_discount">
				<?php if(is_array($level_list) || $level_list instanceof \think\Collection || $level_list instanceof \think\Paginator): if( count($level_list)==0 ) : echo "" ;else: foreach($level_list as $key=>$vo): ?>
					<dl>
						<dt><?php echo $vo['level_name']; ?></dt>
						<dd>
							<input class="input-common harf" type="number" data-level-id="<?php echo $vo['level_id']; ?>" maxlength="3"><em class="unit">%</em>
						</dd>
					</dl>
				<?php endforeach; endif; else: echo "" ;endif; ?>
				<dl>
					<dt>价格保留方式</dt>
					<dd>
						<label class="radio inline normal decimal_reservation_number">
							<i class="radio-common">
								<input type="radio" name="decimal-reservation-number" value="0">
							</i>
							<span>抹去角和分</span>
						</label>
						<label class="radio inline normal decimal_reservation_number">
							<i class="radio-common">
								<input type="radio" name="decimal-reservation-number" value="1">
							</i>
							<span>抹去分</span>
						</label>
					</dd>
				</dl>
			</div>
			<div class="modal-footer">
				<button class="btn-common btn-big" onclick="save_goods_discount();">保存</button>
				<button class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="curr_goods_id">	
<script type="text/javascript">
	var is_sub = false;
	function save_goods_discount(){
		var member_discount_arr = [];
		$("#member_discount dl dd input[type='number']").each(function(){
			var discount = parseInt($(this).val());
			if(discount > 100){
				showMessage("error","商品折扣最大百分比为100,请重新设置");
				return;
			}
			if(discount != NaN && discount > 0 && discount <= 100){
				var member_discount = {};
					member_discount.level_id = $(this).attr("data-level-id");
					member_discount.discount = discount;
				member_discount_arr.push(member_discount);
			}
		});

		var goods_ids= [];
		$("#productTbody input[type='checkbox']:checked").each(function() {
			if (!isNaN($(this).val())) {
				goods_ids.push($(this).val());
			}
		});
		
		if(goods_ids.length == 0 && $("#curr_goods_id").val() > 0){
			goods_ids.push($("#curr_goods_id").val());
		}
		var decimal_reservation_number = $("input[name='decimal-reservation-number']:checked").val();
			decimal_reservation_number = decimal_reservation_number == undefined ? -1 : decimal_reservation_number;
			
		if(member_discount_arr.length > 0 && goods_ids.length > 0){
			if(is_sub) return;
			is_sub = true;
			$.ajax({
				type : "post",
				url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/setMemberDiscount'); ?>",
				data : {
					member_discount_arr : JSON.stringify(member_discount_arr),
					goods_ids : goods_ids.toString(),
					decimal_reservation_number : decimal_reservation_number
				},
				success : function(data){
					$("#set_member_discount").modal("hide");
					if(data["code"] > 0){
						showMessage("success",data["message"],location.href);
					}else{
						is_click = false;
						showMessage("error",data["message"]);
					}
				}
			})
		}else{
			$("#set_member_discount").modal("hide");
		}
	}

	$(".decimal_reservation_number").click(function(){
		$(this).siblings().find("i").removeClass("selected").find("input[type='checkbox']").prop('checked', false);
	});

	// 查看折扣
	function showMemberDiscount(goods_id){
		$("#curr_goods_id").val(goods_id);
		$.ajax({
			type : "post",
			url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/showMemberDiscountAjax'); ?>",
			data : {
				goods_id : goods_id,
			},
			success : function(data){
				if(data['discount_list'].length > 0){
					for (var i = 0; i < data['discount_list'].length; i++) {
						var discount_info = data['discount_list'][i];
						$("input[data-level-id='"+discount_info['level_id']+"']").val(discount_info['discount']);
					}
				}
				if(data['decimal_reservation_number'] >= 0){
					$('input[name="decimal-reservation-number"]').prop("checked", false).parent().removeClass("selected");
					$('input[name="decimal-reservation-number"][value="'+data['decimal_reservation_number']+'"]').prop("checked", true).parent().addClass("selected");
				}
			}
		});
		$("#set_member_discount").modal("show");
	}

	$('#set_member_discount').on('hidden.bs.modal', function (e) {
		$("#curr_goods_id").val("");
		$("#member_discount").find('input[data-level-id]').val("");
		$("#member_discount").find('input[name="decimal-reservation-number"]').prop("checked", false).parent().removeClass("selected");
	})
</script>


<style type="text/css">
#goods_sku_edit{width: 1000px;left: 38.5%;}
#goods_sku_edit .input-common.middle{
	    width: 100px !important;
}
</style>
<div class="modal fade " id="goods_sku_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>修改价格库存</h3>
			</div>
			<div class="modal-body">
				<table class="table table-config-bordered">
					<thead>
						<tr >
							<th>规格名</th>
							<th>销售价<span style="color: #ff5050; font-size: 12px;">*</span></th>
							<th>市场价</th>
							<th>成本价</th>
							<th>当前库存</th>
							<th>增加/删减<span style="color: #ff5050; font-size: 12px;">*</span></th>
							<th>实际库存</th>
						</tr>
					</thead>
					<tbody id = "goods_sku_data">
						
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn-common btn-big" onclick="save_goods_sku();">保存</button>
				<button class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
/**
 * 商品规格对话框显示
 */
var sel_goods_id = 0;
function goodsSkuDialogShow(goods_id, goods_type){
	sel_goods_id = goods_id;
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/getGoodsSkuList'); ?>",
		data : {goods_id},
		success : function(data){
			var h = '';
			for(var i = 0; i < data.length; i++){
				var sku_name = data[i]['sku_name'];
				if(data[i]['sku_name'] == ''){
					sku_name = '--';
				}
				h += `<tr sku_id = "${data[i]['sku_id']}">
						<td>${sku_name}</td>
						<td><input type="number" class="input-common middle" name="sku_price" value="${data[i]['price']}"/></td>
						<td><input type="number" class="input-common middle" name="market_price" value="${data[i]['market_price']}"/></td>
						<td><input type="number" class="input-common middle" name="cost_price" value="${data[i]['cost_price']}"/></td>
						<td name = "stock">${data[i]['stock']}</td>`;
		
					h += `<td><input type="number" class="input-common middle" name="stock_num" placeholder="0" onkeyup = "stockOperation(this)"/></td>`;
				h += `<td><input type="number" class="input-common middle" name="actual_stock" value="${data[i]['stock']}" disabled="disabled"/></td>
					</tr>`;	
			}
			$('#goods_sku_data').html(h);
		}
		
	})
	$("#goods_sku_edit").modal("show");
}

/**
 * 库存计算操作
 */
function stockOperation(even){
	obj = $(even);
	var stock = obj.parent().prev().text();
	var o_v = obj.val();
	stock = Number(stock) + Number(o_v);
	obj.parents('tr').find('[name="actual_stock"]').val(stock);

}

/**
 * 保存sku信息
 */
function save_goods_sku(){
	
	var arr = new Array();
	$('#goods_sku_edit tr').each(function(){
		obj = new Object();
		obj.sku_id = $(this).attr('sku_id');
		obj.price = $(this).find('[name = "sku_price"]').val();
		obj.market_price = $(this).find('[name = "market_price"]').val();
		obj.cost_price = $(this).find('[name = "cost_price"]').val();
		obj.stock = $(this).find('[name = "actual_stock"]').val();
		arr.push(obj);
	})
	
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/editGoodsSku'); ?>",
		data : {"sku_data":JSON.stringify(arr), "goods_id":sel_goods_id},
		success : function(data){
			if(data['code'] > 0){
				
				LoadingInfo(getCurrentIndex(sel_goods_id,'#productTbody','tr[class="tr-title"]'));
				$("#goods_sku_edit").modal("hide");
				showTip(data['message'],"success");
			}else{
				showTip(data['message'],"error");
			}
		}
	})
}

function goodsSkuDetailsList(clisk_obj, goods_id, goods_img){
	
	current_obj = $(clisk_obj);
	obj = $(clisk_obj).parents('tr').next('.single-goods-sku');
	current_obj.html('[-]');
	
	if(obj.html() != ''){
		obj.html('');
		current_obj.text('[+]'); 
		return;
	}
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/goodsSkuDetailsList'); ?>",
		data : {"goods_id":goods_id},
		success : function(data){
		
			var h = '<td align="center" colspan="10">';
			for(var i = 0; i<data.length; i++){
				
				sku_img = data[i]['pic_cover'] == '' ? goods_img : data[i]['pic_cover']; 
				h += `<div class="single-item">
							<div class="hold-img">
								<img src="${__IMG(sku_img)}" alt="" />
							</div>
							<p class="spec-title"><a href="" title ="${data[i]['sku_name']}">${data[i]['sku_name']}</a></p>
							<div class = "row-term">
								<p><span class="row-title">价格：</span><span class="price-value">￥${data[i]['price']}</span></p>
								<p><span class="row-title">库存：</span><span class="stock-value">${data[i]['stock']}</span></p>
							</div>
						</div>`;
			}
			h += '</td>';
			obj.html(h);
		}
	})
}
</script>

			<script type="text/javascript" src="/public/static/js/jquery.cookie.js"></script>
<script src="/public/static/js/page.js"></script>
<div class="page" id="turn-ul" style="display: none;">
	<div class="pagination">
		<ul>
			<li class="according-number">每页显示<input type="text" class="input-medium" id="showNumber" value="<?php echo $pagesize; ?>" data-default="<?php echo $pagesize; ?>" autocomplete="off"/>条</li>
			<li><a id="beginPage" class="page-disable" style="border: 1px solid #dddddd;">首页</a></li>
			<li><a id="prevPage" class="page-disable">上一页</a></li>
			<li id="pageNumber"></li>
			<li id="JslastPage">
				
			</li>
			<li><a id="nextPage">下一页</a></li>
			<li><a id="lastPage">末页</a></li>
			<li class="total-data">共0条</li>
			<!-- <li class="page-count">共0页</li> -->
			<li class="according-number">
				跳<input type="text" class="input-medium"  id="skipPage" data-curr-page="1"/>页
			</li>
		</ul>
	</div>
</div>
<input type="hidden" id="page_count" />
<input type="hidden" id="page_size" />
<script>
/**
 * 保存当前的页面
 * 创建时间：2017年8月30日 19:29:20
 */
function savePage(index){
	var json = { page_index : index, show_number : $("#showNumber").val(), url :  window.location.href };
	$.cookie('page_cookie',JSON.stringify(json),{ path: '/' });
 	//console.log(json);
}

$(function() {
	try{
		
		$("#turn-ul").show();//显示分页
		var history_url = "";
		var json = { page_index : 1, show_number : <?php echo $pagesize; ?>, url :  window.location.href };
		var history_json = "";//用于临时保存分页数据
		if($.cookie('page_cookie') != undefined && $.cookie('page_cookie') != "" && $.cookie('page_cookie') != '""'){
			
			var cookie = eval("(" + $.cookie('page_cookie') + ")");
			if(cookie !=undefined && cookie != ""){
				json.page_index = cookie.page_index;
				if(cookie.show_number != undefined && cookie.show_number != "") json.show_number = cookie.show_number;
				else json.show_number = <?php echo $pagesize; ?>;
				history_url = cookie.url;
				history_json = cookie;
			}
			
		}else{
			
			savePage(json.page_index);
			
		}
		if(history_url != undefined && history_url != "" && history_url != json.url && json.page_index != 1){
			
			//如果页面发生了跳转，还原操作
			json.page_index = 1;
			json.show_number = <?php echo $pagesize; ?>;
			json.url = history_url;
 			//console.log("如果页面发生了跳转，还原操作");
			$.cookie('page_cookie',JSON.stringify(json),{ path: '/' });
		}

 		//console.log($.cookie('page_cookie'));
		$("#showNumber").val(json.show_number);
		if(json.page_index != 1) jumpNumber = json.page_index;
		LoadingInfo(json.page_index);//通过此方法调用分页类
		
	}catch(e){
		
		$("#turn-ul").hide();
		//当前页面没有分页，进行还原操作
		$.cookie('page_cookie',JSON.stringify(history_json),{ path: '/' });
//		console.error(e);
 		//console.log("当前页面没有分页，进行还原操作");
 		//console.log($.cookie('page_cookie'));
	}
	
	//首页
	$("#beginPage").click(function() {
		if(jumpNumber!=1){
			jumpNumber = 1;
			LoadingInfo(1);
			savePage(1);
			changeClass("begin");
		}
		return false;
	});

	//上一页
	$("#prevPage").click(function() {
		var obj = $(".currentPage");
		var index = parseInt(obj.text()) - 1;
		if (index > 0) {
			obj.removeClass("currentPage");
			obj.prev().addClass("currentPage");
			jumpNumber = index;
			LoadingInfo(index);
			savePage(index);
			//判断是否是第一页
			if (index == 1) {
				changeClass("prev");
			} else {
				changeClass();
			}
		}
		return false;
	});

	//下一页
	$("#nextPage").click(function() {
		var obj = $(".currentPage");
		//当前页加一（下一页）
		var index = parseInt(obj.text()) + 1;
		if (index <= $("#page_count").val()) {
			jumpNumber = index;
			LoadingInfo(index);
			savePage(index);
			obj.removeClass("currentPage");
			obj.next().addClass("currentPage");
			//判断是否是最后一页
			if (index == $("#page_count").val()) {
				changeClass("next");
			} else {
				changeClass();
			}
		}
		return false;
	});

	//末页
	$("#lastPage").click(function() {
		jumpNumber = $("#page_count").val();
		if(jumpNumber>1){
			LoadingInfo(jumpNumber);
			savePage(jumpNumber);
			$("#pageNumber a:eq("+ (parseInt($("#page_count").val()) - 1) + ")").text($("#page_count").val());
			changeClass("next");
		}
		return false;
	});

	//每页显示页数
	$("#showNumber").blur(function(){
		if(isNaN($(this).val())){
			$("#showNumber").val(20);
			jumpNumber = 1;
			LoadingInfo(jumpNumber);
			savePage(jumpNumber);
			return;
		}
		if($(this).val().indexOf(".") != -1){
			var index = $(this).val().indexOf(".");
			$("#showNumber").val($(this).val().substr(0,index));
			jumpNumber = 1;
			LoadingInfo(jumpNumber);
			savePage(jumpNumber);
			return;
		}
		if(parseInt($(this).val())<=0){
			jumpNumber = 1;
			LoadingInfo(jumpNumber);
			savePage(jumpNumber);
			return;
		}
		//页数没有变化的话，就不要再执行查询
		if(parseInt($(this).val()) != $(this).attr("data-default")){
// 			jumpNumber = 1;//设置每页显示的页数，并且设置到第一页
			$(this).attr("data-default",$(this).val());
			LoadingInfo(jumpNumber);
			savePage(jumpNumber);
		}
		return false;
	}).keyup(function(event){
		if(event.keyCode == 13){
			if(isNaN($(this).val())){
				$("#showNumber").val(20);
				jumpNumber = 1;
				LoadingInfo(jumpNumber);
				savePage(jumpNumber);
			}
			//页数没有变化的话，就不要再执行查询
			if(parseInt($(this).val()) != $(this).attr("data-default")){
// 				jumpNumber = 1;//设置每页显示的页数，并且设置到第一页
				$(this).attr("data-default",$(this).val());
				//总数据数量
				var total_count = parseInt($(".total-data").attr("data-total-count"));
				//计算用户输入的页数是否超过当前页数
				var curr_count = Math.ceil(total_count/parseInt($(this).val()));
				if( curr_count !=0 && curr_count < jumpNumber){
					jumpNumber = curr_count;//输入的页数超过了，没有那么多
				}
				LoadingInfo(jumpNumber);
				savePage(jumpNumber);
			}
		}
		return false;
	});

	// 跳转到某页
	$("#skipPage").blur(function(){
		if(isNaN($(this).val()) || $(this).val().length == 0){
			$("#showNumber").val(20);
			jumpNumber = 1;
			LoadingInfo(jumpNumber);
			savePage(jumpNumber);
			return;
		}
		if(parseInt($(this).val())<=0){
			jumpNumber = 1;
			LoadingInfo(jumpNumber);
			savePage(jumpNumber);
			return;
		}
		if(parseInt($(this).val()) > $("#page_count").val()){
			jumpNumber = $("#page_count").val();
			LoadingInfo(jumpNumber);
			savePage(jumpNumber);
			$(this).val(jumpNumber);
			return;
		}
		if(parseInt($(this).val()) == parseInt($(this).attr("data-curr-page"))){
			return;
		}
		jumpNumber = $(this).val();
		LoadingInfo(jumpNumber);
		savePage(jumpNumber);
	}).keyup(function(event){
		if(event.keyCode == 13){
			if(isNaN($(this).val())){
				$("#showNumber").val(20);
				jumpNumber = 1;
				LoadingInfo(jumpNumber);
				savePage(jumpNumber);
			}
			if(parseInt($(this).val())<=0){
				jumpNumber = 1;
				LoadingInfo(jumpNumber);
				savePage(jumpNumber);
				return;
			}
			if(parseInt($(this).val()) > $("#page_count").val()){
				jumpNumber = $("#page_count").val();
				LoadingInfo(jumpNumber);
				savePage(jumpNumber);
				$(this).val(jumpNumber);
				return;
			}
			if(parseInt($(this).val()) == parseInt($(this).attr("data-curr-page"))){
				return;
			}
			jumpNumber = $(this).val();
			LoadingInfo(jumpNumber);
			savePage(jumpNumber);
		}
		return false;
	});
});

//跳转页面
function JumpForPage(obj) {
	jumpNumber = $(obj).text();
	LoadingInfo($(obj).text());
	savePage($(obj).text());
	$(".currentPage").removeClass("currentPage");
	$(obj).addClass("currentPage");
	if (jumpNumber == 1) {
		changeClass("prev");
	} else if (jumpNumber < parseInt($("#page_count").val())) {
		changeClass();
	} else if (jumpNumber == parseInt($("#page_count").val())) {
		changeClass("next");
	}
}
</script>
		</div>
		
	</section>
	
</article>

<!-- 公共的操作提示弹出框 common-success：成功，common-warning：警告，common-error：错误，-->
<div class="common-tip-message js-common-tip">
	<div class="tip-container">
		<span class="inner"></span>
	</div>
</div>

<!--修改密码弹出框 -->
<div id="edit-password" class="modal hide fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="width:562px;top:50%;margin-top:-180.5px;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3>修改密码</h3>
	</div>
	<div class="modal-body">
		<form class="form-horizontal">
			<div class="control-group">
				<label class="control-label" for="pwd0" style="width: 160px;"><span class="color-red">*</span>原密码</label>
				<div class="controls" style="margin-left: 180px;">
					<input type="password" id="pwd0" placeholder="请输入原密码" class="input-common" />
					<span class="help-block"></span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="pwd1" style="width: 160px;"><span class="color-red">*</span>新密码</label>
				<div class="controls" style="margin-left: 180px;">
					<input type="password" id="pwd1" placeholder="请输入新密码" class="input-common" />
					<span class="help-block"></span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="pwd2" style="width: 160px;"><span class="color-red">*</span>再次输入密码</label>
				<div class="controls" style="margin-left: 180px;">
					<input type="password" id="pwd2" placeholder="请输入确认密码" class="input-common" />
					<span class="help-block"></span>
				</div>
			</div>
			<div style="text-align: center; height: 20px;" id="show"></div>
		</form>
	</div>
	<div class="modal-footer">
		<button class="btn-common btn-big" onclick="submitPassword()" style="display:inline-block;">保存</button>
		<button class="btn-common-cancle btn-big" data-dismiss="modal" aria-hidden="true">关闭</button>
	</div>
</div>

<link rel="stylesheet" type="text/css" href="/template/admin/public/css/jquery-ui-private.css">
<script>
var platform_shopname= '<?php echo $web_popup_title; ?>';
</script>
<script type="text/javascript" src="/template/admin/public/js/jquery-ui-private.js" charset="utf-8"></script>
<script type="text/javascript" src="/template/admin/public/js/jquery.timers.js"></script>
<div id="dialog"></div>
<script type="text/javascript">
function showMessage(type, message,url,time){
	if(url == undefined){
		url = '';
	}
	if(time == undefined){
		time = 2;
	}
	//成功之后的跳转
	if(type == 'success'){
		$( "#dialog").dialog({
			buttons: {
				"确定,#00A0DE,#fff": function() {
					$(this).dialog('close');
				}
			},
			contentText:message,
			time:time,
			timeHref: url,
			msgType : type
		});
	}
	//失败之后的跳转
	if(type == 'error'){
		$( "#dialog").dialog({
			buttons: {
				"确定,#00A0DE,#fff": function() {
					$(this).dialog('close');
				}
			},
			time:time,
			contentText:message,
			timeHref: url,
			msgType : type
		});
	}
}

function showConfirm(content){
	$( "#dialog").dialog({
		buttons: {
			"确定": function() {
				$(this).dialog('close');
				return 1;
			},
			"取消,#f5f5f5,#666": function() {
				$(this).dialog('close');
				return 0;
			}
		},
		contentText:content,
	});
}
</script>
<script src="/template/admin/public/js/ns_common_base.js"></script>
<script src="/public/static/blue/js/ns_common_blue.js"></script>
<script>
$(function(){
	
	$(".ns-third-menu ul .btn-more").toggle(
		function(){
			$(".ns-third-menu ul").animate({height:"84px"},300);
		},
		function(){
			$(".ns-third-menu ul").animate({height:"42px"},300);
		}
	);
	
	//公共下拉框
	$('.select-common').selectric();
	
	//公共复选框点击切换样式
	$(".checkbox-common").live("click",function(){
		var checkbox = $(this).children("input");
		if(checkbox.is(":checked")) $(this).addClass("selected");
		else $(this).removeClass("selected");
	});
	
	//鼠标浮上查看预览上传的图片
	$(".upload-btn-common>img,#preview_adv").live("mouseover",function(){
		var curr = $(this);
		var src = curr.attr("data-src");
		if(src){
			//alert(src);
			var contents = '<img src="'+src+'" style="width: 100px;height: auto;display:block;margin:0 auto;">';
			//鼠标每次浮上图片时，要销毁之前的事件绑定
			curr.popover("destroy");
			
			//重新配置弹出框内容
			curr.popover({ content : contents });

			//显示
			curr.popover("show");
		}
	});
	
	//鼠标离开隐藏预览上传的图片
	$(".upload-btn-common>img,#preview_adv").live("mouseout",function(){
		var curr = $(this);
		//隐藏
		if($(".popover.top").is(":visible") && curr.attr("data-src")) curr.popover("hide");
	});

	//公共单选框点击切换样式
	$(".radio-common").live("click",function(){
		var radio = $(this).children("input");
		var name = radio.attr("name");
		if(radio.is(":checked")){
			$(".radio-common>input[type='radio'][name='" + name + "']").parent().removeClass("selected");
			$(this).addClass("selected");
		}else{
			$(this).removeClass("selected");
		}
	});

	//顶部导航管理显示隐藏
	$(".ns-navigation-title>span").click(function(){
		$(".ns-navigation-management").slideUp(400);
	});
	
	$(".js-nav").toggle(function(){
		$(".ns-navigation-management").slideDown(400);
	},function(){
		$(".ns-navigation-management").slideUp(400);
	});
	
	//搜索展开
	$(".ns-search-block").hover(function(){
		if($(this).children(".mask-layer-search").is(":hidden")) $(this).children(".mask-layer-search").fadeIn(300);
	},function(){
		if($(this).children(".mask-layer-search").is(":visible")) $(this).children(".mask-layer-search").fadeOut(300);
	});
	
	$(".ns-base-tool .ns-help").hover(function(){
		if($(this).children("ul").is(":hidden")) $(this).children("ul").fadeIn(250);
	},function(){
		if($(this).children("ul").is(":visible")) $(this).children("ul").fadeOut(250);
	});
	
});

function addFavorite() {
	var url = window.location;
	var title = document.title;
	var ua = navigator.userAgent.toLowerCase();
	if (ua.indexOf("360se") > -1) {
		alert("由于360浏览器功能限制，请按 Ctrl+D 手动收藏！");
	}else if (ua.indexOf("msie 8") > -1) {
		window.external.AddToFavoritesBar(url, title); //IE8
	}
	else if (document.all) {
		try{
			window.external.addFavorite(url, title);
		}catch(e){
			alert('您的浏览器不支持,请按 Ctrl+D 手动收藏!');
		}
	}else if (window.sidebar) {
		window.sidebar.addPanel(title, url, "");
	}else {
		alert('您的浏览器不支持,请按 Ctrl+D 手动收藏!');
	}
}

$('.ns-base-tool .ns-help ul li').hover(function(){
	var old_img = $(this).find('img').attr('src');
	var img = old_img.replace('.png', "_check.png");
	$(this).find('img').attr('src', img);
},function() {
	var old_img = $(this).find('img').attr('src');
	var img = old_img.replace('_check.png', ".png");
	$(this).find('img').attr('src', img);
	
})

var primary_selector_v = '.default-condition';
var primary_selector_h = '';
//高级搜索
function openSeniorSearch(primary_selector){
	
	primary_selector_h = $(primary_selector).html();
	$(primary_selector).html('');
	$('.nui-condition').show();
	primary_selector_v = primary_selector;
}
//清除高级筛选条件
function clearCondition(){
	$('.nui-condition').find('input').val('');
	$('.nui-condition').find('select').val('');
	$('.select-common').selectric();
}
//收起高级筛选
function retractSeniorSearch(){
	
	$(primary_selector_v).html(primary_selector_h);
	$('.nui-condition').hide();
}

</script>

<script type="text/javascript">

$(function(){
	$(".js-update-goods-name,.js-update-introduction").live("blur",function(){
		var up_type = $(this).attr("data-up-type");
		var goods_id = $(this).attr("data-goods-id");
		var editContent = $(this).val();
		if(editContent == ""){
			if(up_type == "goods_name"){
				showTip("商品名不可为空","warning");
				$(this).focus();
				return false;
			}
		}
		var $self = $(this);
		$.ajax({
			type : "post",
			url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/ajaxEditGoodsNameOrIntroduction'); ?>",
			data : {
				"goods_id" : goods_id,
				"up_type" : up_type,
				"up_content" : editContent
			},
			success : function(data){
				if(data['code'] > 0){
					$self.prev(".editGoodsIntroduction").children("a").text(editContent);
				}
				$self.hide();
				$self.prev(".editGoodsIntroduction").show();
			}
		});
	}).live("keyup",function(event){
		if(event.keyCode == 13) $(this).blur();
	});
	
	//排序规则
	$(".goods-fields-sort").click(function(){
		
		var field = $(this).attr("data-field");
		var sort_rule = $(this).attr("data-field");
		$(this).siblings().css("color","#333333").find("span").removeClass("desc selected").addClass("desc");
		$(this).css("color","#00A0DE");
		if($(this).find("span").hasClass("desc") && $(this).find("span").hasClass("selected")){
			$(this).find("span").removeClass("desc").addClass("selected asc").text('↑');
			sort_rule += ",a";
		}else if(($(this).find("span").hasClass("asc") && $(this).find("span").hasClass("selected")) || $(this).find("span").hasClass("desc")){
			$(this).find("span").removeClass("asc").addClass("selected desc").text('↓');
			sort_rule += ",d";
		}
		$("#hidden_sort_rule").val(sort_rule);
		LoadingInfo(1);
	});
	

});

function searchData(){
	$(".more-search-container").slideUp();
	LoadingInfo(1);
}

//隐藏商品分组
function hideEditGroup(){
	$("#editGroup").popover("hide");
}

function hideSetRecommend(){
	$("#setRecommend").popover("hide");
}

function LoadingInfo(page_index) {
	
	var start_date = $("#startDate").val();
	var end_date = $("#endDate").val();
	var state = $("#state").val();
	var goods_name =$("#goods_name").val();
	var goods_code = $("#goods_code").val();
	var category_id_1 = $("#category_id_1").val();
	var category_id_2 = $("#category_id_2").val();
	var category_id_3 = $("#category_id_3").val();
	var selectGoodsLabelId = $("#selectGoodsLabelId").val();
	var supplier_id = $("#supplier_id").val();
	var stock_warning = $("#stock_warning").val();
	var goods_type = $("#goods_type").val() == null ? 'all' : $("#goods_type").val();
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/goodslist'); ?>",
		data : {
			"page_index" : page_index,
			"page_size" : $("#showNumber").val(),
			"start_date":start_date,
			"end_date":end_date,
			"state":state,
			"goods_name":goods_name,
			"code":goods_code,
			"category_id_1" : category_id_1,
			"category_id_2" : category_id_2,
			"category_id_3" : category_id_3,
			"selectGoodsLabelId" : selectGoodsLabelId,
			"supplier_id" : supplier_id,
			"stock_warning" : stock_warning,
			'sort_rule' : $("#hidden_sort_rule").val(),
			'goods_type' : goods_type
		},
		success : function(data) {

			if (data["data"].length > 0) {
				$("#productTbody").empty();
				for (var i = 0; i < data["data"].length; i++) {

					var html = '';
					html += '<tr class="tr-title">';
						html += '<td class="td-'+ data["data"][i]["goods_id"]+'" style="border-bottom:0;">';
// 							html += '<label style="text-align: center;vertical-align: middle;margin: 0 0 0 -1px;">';
// 								html += '<i class="checkbox-common"><input value="' + data["data"][i]["goods_id"] + '" name="sub" data-state="'+data["data"][i]["state"]+'" type="checkbox"></i>';
// 							html += '</label>';
						html += '</td>';

						html += '<td colspan="9" style="border-bottom:0;">';
							html += '<div style="display: inline-block; width: 100%;font-size:12px;color:#666;" class="pro-code">';
								html += '<span>商家编码'+'：' + data["data"][i]["code"] + '</span>';
								html += '<span class="pro-code" style="margin-left:10px;">创建时间：'+timeStampTurnTime(data["data"][i]["create_time"]);
									html += '<span class="div-flag-style">';
										html += '<i class="icon-qrcode"style="background: none; color: #555; font-size: 20px; margin-right: 0;"></i>';
										html += '<div class="QRcode">';
											html += '<p><img src="'+ __IMG(data["data"][i]["QRcode"])+'" style="width:110px;"></p>';
										html += '</div>';
									html += '</span>';
								html += '</span>';
							html += '</div>';
						html += '</td>';
					html += '</tr>';

					html += '<tr>';
						html += '<td align="center">';
							html += '<i class="checkbox-common"><input value="' + data["data"][i]["goods_id"] + '" name="sub" data-state="'+data["data"][i]["state"]+'" type="checkbox"></i>';
						html += '</td>';
						html += '<td colspan="1">';
							html += '<div style="width:450px;">';
								html += `<a href="javascript:;" onclick="goodsSkuDetailsList(this, ${data["data"][i]["goods_id"]},'${data["data"][i]["pic_cover_micro"]}')" class="goods-sku-click">[+]</a>`;
								html += '<a class="a-pro-view-img" href="'+__URL('http://127.0.0.1:8080/index.php/goods/detail?goods_id='+data["data"][i]["goods_id"])+'" target="_blank" style="height:70px;line-height:70px;text-align:center;">';
									html += '<img class="thumbnail-img" src="'+__IMG(data["data"][i]["pic_cover_micro"])+'">';
								html += '</a>';
								html += '<div class="div-pro-view-name">';
// 									html += '<span class="thumbnail-name" title='+ data["data"][i]["goods_name"]+'">';
										html += '<div class="editGoodsIntroduction" ondblclick="editGoodsInfo(this)">';
											html += '<a target="_blank" style="word-break:break-all;" href="'+__URL('http://127.0.0.1:8080/index.php/goods/detail?goods_id='+data["data"][i]["goods_id"])+'">' + data["data"][i]["goods_name"] + '</a>';
										html += '</div>';
										html += '<input class="js-update-goods-name input-common" style="width:350px!important;" data-goods-id ="' + data['data'][i]['goods_id'] + '" data-up-type="goods_name" type="text" value="'+data["data"][i]['goods_name']+'"/>';
// 									html += '</span>';
									html += '<br/>';

									if(data["data"][i]['introduction'] != '' && data["data"][i]['introduction'] != undefined){

									html += '<div class="editGoodsIntroduction" ondblclick="editGoodsInfo(this)">';
										html += '<span style="color:#999;font-size:12px;display:block;height:25px;overflow:hidden;text-decoration: none;">'+data["data"][i]['introduction']+'</span>';
									html += '</div>';
									html += '<input data-goods-id ="' + data['data'][i]['goods_id'] + '" data-up-type="introduction" class="js-update-introduction input-common" style="width:350px!important;" type="text" maxlength="60" value="'+data["data"][i]['introduction']+'"/>';

									}
									html += '<div style="position: relative;margin-left: 75px;">';
									html += data["data"][i]["is_hot"] == 1 ? '<i class="hot">热</i>' : '';
									html += data["data"][i]["is_recommend"] == 1 ? '<i class="recommend">精</i>' : '';
									html += data["data"][i]["is_new"] == 1 ? '<i class="new">新</i>' : '';
									if(data["data"][i]['goods_group_name'] != '' && data["data"][i]['goods_group_name'] != undefined){
										var tmp_array = data["data"][i]['goods_group_name'].split(",");
										$.each(tmp_array,function(k,v){
											if(v != ""){
												html += '<i style="color:#999;font-size:12px;margin-top:5px;padding:1px 4px;border-radius:3px;display:inline-block;color:#FFF;background-color:#FF6600;text-decoration: none;height:16px;line-height: 16px;overflow:hidden;margin-right:5px;text-align:center;font-style:normal;">'+v+'</i>';
											}
										});
									}
									
									if(data["data"][i]['shipping_fee'] == 0.00){
										html += '<i style="color:#999;font-size:12px;margin-top:5px;padding:1px 4px;border-radius:3px;display:inline-block;color:#FFF;background-color:#00A0DE;text-decoration: none;height:16px;line-height: 16px;overflow:hidden;margin-right:5px;text-align:center;font-style:normal;">免邮</i>';
									}
									html += '</div>';
								html += '</div>';
							html += '</div>';
						html += '</td>';

						
						<?php if(addon_is_exit('Nsfx')): ?>
						var is_open = data["data"][i]['distribution']['is_open'] == 1 ? "已开启" : "未开启";
						html += '<td style="">';
						html += '<p class="fx-radio-block"><span>是否开启分销：</span><span class="is_open">'+is_open+'</span></p>';
						html += '<p class="fx-radio-block"><span>分销佣金比率：</span><span class="is_open">'+data["data"][i]['distribution']['distribution_commission_rate'] +'%</span></p>';
						html += '<p class="fx-radio-block"><span>股东分红比率：</span><span class="is_open">'+data["data"][i]['distribution']['partner_commission_rate'] +'%</span></p>';
						html += '<p class="fx-radio-block"><span>区域分红比率：</span><span class="is_open">'+data["data"][i]['distribution']['regionagent_commission_rate'] +'%</span></p>';
						
	            		
						html += '</td>';
						<?php endif; ?>
						html += '<td style="text-align: right;">';
// 							if(data["data"][i]["price"] != data["data"][i]["promotion_price"]){
// 								html += '<div class="priceaddactive">';
// 									html += '<span class="price-lable">原&nbsp;&nbsp;&nbsp;价：</span>';
// 									html += '<span class="price-numble" style="color: #666;"id="moreChangePrice'+ data["data"][i]["goods_id"]+'">' + data["data"][i]["price"] + '</span>';
// 								html += '</div>';
// 							}
							html += '<div>';
								html += '<span class="price-numble"id="moreChangePrice'+ data["data"][i]["goods_id"]+'" style="color:#FF6600;">' + data["data"][i]["promotion_price"] + '</span>';
								html += '<i class = "edit-sign" onclick="goodsSkuDialogShow('+ data["data"][i]["goods_id"]+')"></i>';
							html += '</div>';
						html += '</td>';

						html += '<td style="text-align: right;">';
							html += '<div class="cell">';
								html += '<span class="pro-stock" style="color: #666;" id="moreChangeStock'+ data["data"][i]["goods_id"] + '">' + data["data"][i]["stock"] + '</span>';
								html += '<i class="edit-sign" onclick="goodsSkuDialogShow('+ data["data"][i]["goods_id"]+','+ data["data"][i]["goods_type"] +')"></i>';
							html += '</div>';
							
						html += '</td>';

						html += '<td style="text-align: right;">';
							html += '<div class="cell">';
								html += '<span class="pro-stock" style="color: #666;" id="moreChangeStock'+ data["data"][i]["goods_id"]+'">' + data["data"][i]["real_sales"] + '</span>';
							html += '</div>';
						html += '</td>';
						
						html += '<td style="text-align: center;">';
						html += '<span>'+data['data'][i]['type_config']['title']+'</span>';
						html += '</td>';

						html += '<td style="text-align: center;">';
							html += '<div class="cell">';
								html += '<input class="input-common input-common-sort" goods_id="' + data["data"][i]["goods_id"] + '"  value="' + data["data"][i]["sort"] + '" onchange="changeSort(this)"' + 'type="number" title="排序号数值越大，商城商品列表显示越靠前">';
							html += '</div>';
						html += '</td>';

						html += '<td>';
						html += '<div class="bs-docs-example tooltip-demo" style="text-align: center;">';
						html += '<a href="' + __URL("http://127.0.0.1:8080/index.php/admin/goods/editGoods?type="+ data["data"][i]["type_config"]['name'] +"&goods_id="+ data["data"][i]["goods_id"]) + '" title="编辑商品" >编辑 </a>';
						html += '<a href="javascript:copyGoodsDetail(' + data["data"][i]["goods_id"] + ');" title="复制商品" >复制 </a>';
						html += '<a href="javascript:deleteGoods(' + data["data"][i]["goods_id"] + ')" title="删除商品">删除 </a>';
						if(data["data"][i]["state"] == 1){
							html += '<br/><a href="javascript:modifyGoodsOnline('+data["data"][i]["goods_id"]+',\'offline\')">下架</a>';
						}else{
							html += '<br/><a href="javascript:modifyGoodsOnline('+data["data"][i]["goods_id"]+',\'online\')" style="color:#999;">上架</a>';
						}
						
						
						html += '<br/><a href="javascript:showMemberDiscount('+data["data"][i]["goods_id"]+')">设置会员折扣</a>';
						if(data['data'][i]['goods_type'] == 0){
							html += '<br/><a href="' + __URL("http://127.0.0.1:8080/index.php/admin/goods/virtualGoodsList?goods_id="+ data["data"][i]["goods_id"]) + '" title="虚拟商品管理" target="_blank" >虚拟商品管理</a>';
						}
						<?php if(addon_is_exit('Nsfx')): ?>
						
							html += '<br/><a href="javascript:setGoodsDistribution('+data["data"][i]["goods_id"]+', 1)">设置商品分销</a>';
							
						<?php endif; ?>
						html += '</div>';
						html += '</td>';
					html += '</tr><tr class="single-goods-sku"></tr>';
					$("#productTbody").append(html);
				}
			} else {
				var html = '<tr align="center"><td colspan="9" style="text-align: center;font-weight: normal;color: #999;">暂无符合条件的数据记录</td></tr>';
				$("#productTbody").html(html);
			}
			initPageData(data["page_count"],data['data'].length,data['total_count']);
			$("#pageNumber").html(pagenumShow(jumpNumber,$("#page_count").val(),<?php echo $pageshow; ?>));
			code();
		}
	});
}

//二维码
function code(){
	$(".div-flag-style").mouseover(function(){
		$(this).children('.QRcode').show();
	});
	$(".div-flag-style").mouseout(function(){
		$(this).children('.QRcode').hide();
	});
} 

//把值传过去即可
function updateGoodsDetail(goods_id) {
	window.location = __URL("http://127.0.0.1:8080/index.php/admin/goods/addgoods?step=2&goodsId="+ goods_id);
}

//全选
function CheckAll(event){
	var checked = event.checked;
	$("#productTbody input[type = 'checkbox']").prop("checked",checked);
	if(checked) $(".table-class tbody input[type = 'checkbox']").parent().addClass("selected");
	else $(".table-class tbody input[type = 'checkbox']").parent().removeClass("selected");
}

//商品上架id合计
function goodsIdCount(line){
	var goods_ids= "";
	$("#productTbody input[type='checkbox']:checked").each(function() {
		if (!isNaN($(this).val())) {
			var state = $(this).data("state");
//			if(line == "online"){
//				if(state == 1){
//					$( "#dialog" ).dialog({
//						buttons: {
//							"确定": function() {
//								$(this).dialog('close');
//							}
//						},
//						contentText:"记录中包含已上架记录",
//						title:"消息提醒",
//					});
//					return false;
//				}
//			}else{
//				if(state == 0){
//					$( "#dialog" ).dialog({
//						buttons: {
//							"确定": function() {
//								$(this).dialog('close');
//							}
//						},
//						contentText:"记录中包含已下架记录",
//						title:"消息提醒",
//					});
//				return false;
//				}
//			}
			goods_ids = $(this).val() + "," + goods_ids;
		}
	});
	goods_ids = goods_ids.substring(0, goods_ids.length - 1);
	if(goods_ids == ""){
		showTip("请选择需要操作的记录","warning");
		return false;
	}
	modifyGoodsOnline(goods_ids,line);
}

//商品上下架
function modifyGoodsOnline(goods_ids,line){
	if(line == "online"){
		var url = "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/Goods/modifygoodsonline'); ?>";
		var lingStr = "上架";
	}else{
		var url = "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/Goods/modifygoodsoffline'); ?>";
		var lingStr = "下架";
	}
	$.ajax({
		type : "post",
		url : url,
		data : { "goods_ids" : goods_ids },
		success : function(data) {
			if(data["code"] > 0 ){
				LoadingInfo(getCurrentIndex(goods_ids,'#productTbody','tr[class="tr-title"]'));
				showTip("商品"+lingStr+"成功","success");
			}
		}
	})
}

function batchDelete() {
	var goods_ids= new Array();
	$("#productTbody input[type='checkbox']:checked").each(function() {
		if (!isNaN($(this).val())) {
			goods_ids.push($(this).val());
		}
	});
	if(goods_ids.length ==0){
		showTip("请选择需要操作的记录","warning");
		return false;
	}
	deleteGoods(goods_ids);
}

function deleteGoods(goods_ids){
	$( "#dialog" ).dialog({
		buttons: {
			"确定": function() {
				$.ajax({
					type : "post",
					url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/deletegoods'); ?>",
					data : { "goods_ids" : goods_ids.toString() },
					dataType : "json",
					success : function(data) {
						if(data["code"] > 0 ){
							LoadingInfo(getCurrentIndex(goods_ids,'#productTbody','tr[class="tr-title"]'));
							showTip(data['message'],"success");
							$("#chek_all").prop("checked", false);
						}
					}
				});
				$(this).dialog('close');
			},
			"取消,#f5f5f5,#666": function() {
				$(this).dialog('close');
			},
		},
		contentText:"确定要删除吗？",
	});
}

//商品修改分组id合计
function goodsGroupIdCount(){
	var goods_ids= "";
	$("#productTbody input[type='checkbox']:checked").each(function() {
		if (!isNaN($(this).val())) {
			goods_ids = $(this).val() + "," + goods_ids;
		}
	});
	goods_ids = goods_ids.substring(0, goods_ids.length - 1);
	if(goods_ids == ""){
		showTip("请选择需要操作的记录","warning");
		return false;
	}
	$("#goods_type_ids").val(goods_ids);
	$("#editGroup").popover("show");
	$(".popover").css("max-width",'1000px');
}

//商品修改分组
function goodsGroupUpdate(){
	var goods_type = "";
	var goods_ids = $("#goods_type_ids").val();
	$("#goodsChecked input[type='checkbox']:checked").each(function(){
		if (!isNaN($(this).val())) {
			goods_type = $(this).val() + "," + goods_type;
		}
	});
	// if(goods_type == ""){
	//	showTip("请选择需要操作的记录","warning");
	// 	$( "#dialog" ).dialog({
	// 		buttons: {
	// 			"确定": function() {
	// 				$(this).dialog('close');
	// 			}
	// 		},
	// 		contentText:"请选择需要操作的记录",
	// 		title:"消息提醒",
	// 	});
	// 	return false;
	// }
	goods_type = goods_type.substring(0, goods_type.length - 1);
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/modifygoodsgroup'); ?>",
		data : { "goods_id" : goods_ids, "goods_type" : goods_type },
		success : function(data) {
			if(data["code"] > 0 ){
				$("#editGroup").popover("hide");
				LoadingInfo(getCurrentIndex(goods_ids,'#productTbody','tr[class="tr-title"]'));
				showTip(data['message'],"success");
			}
		}
	})
}

//显示 推荐选项
function ShowRecommend(){
	var goods_ids= "";
	$("#productTbody input[type='checkbox']:checked").each(function() {
		if (!isNaN($(this).val())) {
			goods_ids = $(this).val() + "," + goods_ids;
		}
	});
	goods_ids = goods_ids.substring(0, goods_ids.length - 1);
	if(goods_ids == ""){
		showTip("请选择需要操作的记录","warning");
		return false;
	}
	$("#goods_type_ids").val(goods_ids);
	$("#setRecommend").popover("show");
}

$("#recommendType label,#recommendType label input").live("click",function(){
// 	if($(this).children("input").is(":checked")){
// 		$(this).children("input").prop("checked",false);
// 	}else{
// 		$("#recommendType label input").prop("checked",false);
// 		$(this).children("input").prop("checked",true);
// 	}
});

//修改为  推荐 商品
function setRecommend(){
	var recommend_type = '';
	var goods_ids = $("#goods_type_ids").val();
	$("#recommendType input[type='checkbox']").each(function(){
		if ($(this).attr("checked") == 'checked') {
			var recommend_type_new = 1;
		}else{
			var recommend_type_new = 0;
		}
		recommend_type = recommend_type_new + "," + recommend_type;
	})
	if(recommend_type == ""){
		showTip("请选择需要操作的记录","warning");
		return false;
	}
	recommend_type = recommend_type.substring(0, recommend_type.length - 1);
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/modifygoodsrecommend'); ?>",
		data : {
			"goods_id" : goods_ids,
			"recommend_type" : recommend_type
		},
		success : function(data) {
			if(data["code"] > 0 ){
				$("#setRecommend").popover("hide");
				LoadingInfo(getCurrentIndex(goods_ids,'#productTbody','tr[class="tr-title"]'));
				showTip(data['message'],"success");
			} 
		}
	})
}

function copyGoodsDetail(goods_id){
	$( "#dialog" ).dialog({
		buttons: {
			"确定": function() {
				$.ajax({
					type : "post",
					url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/copygoods'); ?>",
					data : {"goods_id":goods_id},
					dataType : "json",
					success : function(data) {
						if(data["code"] > 0 ){
							LoadingInfo(getCurrentIndex(goods_id,'#productTbody','tr[class="tr-title"]'));
							showTip(data["message"],"success");
							$("#chek_all").prop("checked", false);
						}else{
							showTip(data["message"],"error");
						}
					}
				});
				$(this).dialog('close');
			},
			"取消,#f5f5f5,#666": function() {
				$(this).dialog('close');
			},
		},
		contentText:"确定要复制一条新的商品信息吗？",
	});
}

function changeSort(event){
	var sort = parseInt($(event).val());
	$(event).val(sort);
	var goods_id = $(event).attr("goods_id");
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/updateGoodsSortAjax'); ?>",
		data : { "sort" : sort, "goods_id" : goods_id },
		success : function(data){
			if(data.code>0){
				LoadingInfo(getCurrentIndex(goods_id,'#productTbody','tr[class="tr-title"]'));
				showTip(data.message,"success");
			}else{
				showTip(data.message,"error");
			}
		}
	})
}

//更新二维码
function batchUpdateGoodsQrcode(){
	var goods_ids= new Array();
	$("#productTbody input[type='checkbox']:checked").each(function() {
		if (!isNaN($(this).val())) {
			goods_ids.push($(this).val());
		}
	});
	if(goods_ids.length == 0){
		showTip("请至少选择一件商品","warning");
		return false;
	}
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/updateGoodsQrcode'); ?>",
		data : { "goods_id" : goods_ids.toString() },
		success : function(data){
			if (data["code"] > 0) {
				LoadingInfo(getCurrentIndex(goods_ids,'#productTbody','tr[class="tr-title"]'));
				showTip('二维码更新成功',"success");
			}else{
				showTip(data['message'],"error");
			}
		}
	})
}

function selectGoodsLabel(){
	$("#selectGoodsLabel").popover("show");
	$("#selectGoodsLabelId").val('');
	$("#selectGoodsLabel").val('');
}

function hideGroup(){
	$("#selectGoodsLabel").popover("hide");
	$("#selectGoodsLabel").val('');
}

function clickGoodsLabel(event){
	var goods_label_id = $(event).val();
	var goods_label_name = $(event).next("span").text();
	var selectGoodsLabelVal = $("#selectGoodsLabel").val();
	var selectGoodsLabelId = $("#selectGoodsLabelId").val();
	if($(event).is(":checked")){
		$("#selectGoodsLabelId").val(selectGoodsLabelId+goods_label_id+',');
		$("#selectGoodsLabel").val(selectGoodsLabelVal+goods_label_name+';');
	}else{
		selectGoodsLabelVal = selectGoodsLabelVal.replace(goods_label_name+';','');
		selectGoodsLabelId = selectGoodsLabelId.replace(goods_label_id+',','');
		$("#selectGoodsLabelId").val(selectGoodsLabelId);
		$("#selectGoodsLabel").val(selectGoodsLabelVal);
	}
}

function confirm(){
	$("#selectGoodsLabel").popover("hide");
}

function editGoodsInfo(event){
	$(event).hide();
	$(event).next("input").show().focus();
}

// 点击显示更多搜索
$(".more-search").on("click", function(e){
	$(".more-search-container").slideToggle();
	$(document).one("click", function(){
        $(".more-search-container").slideUp();
    });
    e.stopPropagation();
});

$(".more-search-container").on("click", function(e){
    e.stopPropagation();
});

// 批量处理弹出框
$("#batchProcessing").click(function(){
	var goods_ids= [];
	$("#productTbody input[type='checkbox']:checked").each(function() {
		if (!isNaN($(this).val())) {
			goods_ids.push($(this).val());
		}
	});
	if(goods_ids.length == 0){
		showTip("请至少选择一件商品","warning");
		return false;
	}
	$("#batch_processing").modal("show");
});

// 批量处理弹出框
$("#setMemberDiscount").click(function(){
	var goods_ids= [];
	$("#productTbody input[type='checkbox']:checked").each(function() {
		if (!isNaN($(this).val())) {
			goods_ids.push($(this).val());
		}
	});
	if(goods_ids.length == 0){
		showTip("请至少选择一件商品","warning");
		return false;
	}
	$("#set_member_discount").modal("show");
})

function addGoods(){
	<?php if(count($goods_type_list) == 0): ?>
		showTip("请先安装至少一种商品插件","warning");
	<?php elseif(count($goods_type_list) == 1): ?>
		type_info("<?php echo $goods_type_list[0]['name']; ?>");
	<?php else: ?>
		layer.open({
		  type: 1,
		  title: '',
		  area: ['700px', '400px'],
		  content: `<div class="goods-type">
			<h3 class="type-title">选择上货方式</h3>
			<?php if(is_array($goods_type_list) || $goods_type_list instanceof \think\Collection || $goods_type_list instanceof \think\Paginator): $i = 0; $__LIST__ = $goods_type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<div class="item-type" onclick="type_info('<?php echo $vo['name']; ?>')">
				<div class="item-img"><img src="<?php echo $vo['ico']; ?>" alt="" /></div>
				<div class="item-content">
					<p class = "name"><?php echo $vo['title']; ?></p>
					<p class = "description">（<?php echo $vo['description']; ?>）</p>
				</div>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</div>`
		  ,yes: function(index, layero){
			  layer.close(index);
		  }
		});
	<?php endif; ?>
}

type_info = function(type_name){
	location.href = __URL("http://127.0.0.1:8080/index.php/admin/goods/addGoods&type="+ type_name);
}
</script>

<?php if(addon_is_exit('Nsfx')): ?>
<style>
.set-style dl dt{
	width:200px !important;
}
.set-style dl dd{
	width:auto !important;
}
#queryGoodsCommissionRate .set-style dl dd{    line-height: 34px;}
</style>

<!-- 商品分销设置（Modal）开始 -->
<div class="modal fade hide" id="editGoodsCommissionRate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:500px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">商品分销设定</h4>
            </div>
            <div class="modal-body">
            	<div class="set-style">
            		<input type="hidden" id="distribution_type" value=""/>
            		<input type="hidden"  id="distribution_condition"  value=''/>
            		<dl>
						<dt>是否开启：</dt>
						<dd>
							<p id="is_open">
								<input  type="checkbox"  class="checkbox"/>
							</p>	
							<p class="error">请输入分销佣金比率</p>
						</dd>
					</dl>
            		<dl>
						<dt>分销佣金比率：</dt>
						<dd>
							<p><input name="" id="distribution_commission_rate" type="number"  class="input-common harf" value="" /><em class="unit">%</em></p>	
							<p class="error">请输入分销佣金比率</p>
						</dd>
					</dl>
						
					<dl >
						<dt>区域分销佣金比率：</dt>
						<dd>
							<p><input name="" id="regionagent_commission_rate" type="number" class="input-common harf"  value="" onkeyup="javascript:CheckInputIntFloat(this);"/><em class="unit">%</em></p>	
							<p class="error">请输入区域分销佣金比率</p>
						</dd>
					</dl>
					
					<dl>
						<dt>股东分红佣金比率：</dt>
						<dd>
							<p><input name="" id="partner_commission_rate" type="number" value="" class="input-common harf" /><em class="unit">%</em></p>	
							<p class="error">请输入股东分红佣金比率</p>
						</dd>
					</dl>
					<dl style="display:none;">
						<dt>分销团队分红佣金比率：</dt>
						<dd>
							<p><input name="" id="distribution_team_commission_rate" type="text" class="input-common harf"  value="" /><em class="unit">%</em></p>	
							<p class="error">请输入分销团队分红佣金比率</p>
						</dd>
					</dl>
					<dl style="display:none;">
						<dt>股东团队分红佣金比率：</dt>
						<dd>
							<p><input name="" id="partner_team_commission_rate" type="number" class="input-common harf"  value="" onkeyup="javascript:CheckInputIntFloat(this);"/><em class="unit">%</em></p>	
							<p class="error">股东团队分红佣金比率</p>
						</dd>
					</dl>
				
					<dl style="display:none;">
						<dt>渠道代理分红佣金比率：</dt>
						<dd>
							<p><input name="" id="channelagent_commission_rate" type="number" class="input-common harf"  value="" onkeyup="javascript:CheckInputIntFloat(this);"/><em class="unit">%</em></p>	
							<p class="error">请输入渠道代理分红佣金比率</p>
						</dd>
					</dl>        		            		
            	</div>
            </div>
            <div class="modal-footer">
            	<button type="button" class="btn-common btn-big" onclick="updateGoodsCommissionRate();">修改</button>
                <button type="button" class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<!-- 商品分销设置（Modal）结束 -->


<!-- 商品分销（Modal）开始 -->
<div class="modal fade hide" id="queryGoodsCommissionRate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:500px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">商品分销</h4>
            </div>
            <div class="modal-body">
            	<div class="set-style">
            		<dl>
						<dt>是否开启分销：</dt>
						<dd>
							<p>
								<span class="is_open"></span>
							</p>
						</dd>
					</dl>
            		<dl>
						<dt>分销佣金比率：</dt>
						<dd>
							<p>
								<span class="distribution_commission_rate"></span>
							</p>
						</dd>
					</dl>
					<dl >
						<dt>区域分销佣金比率：</dt>
						<dd>
							<p>
								<span class="regionagent_commission_rate"></span>
							</p>
						</dd>
					</dl>
					<dl>
						<dt>股东分红佣金比率：</dt>
						<dd>
							<p>
								<span class="partner_commission_rate"></span>
							</p>
						</dd>
					</dl>
					
            	</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<!-- 商品分销设置（Modal）结束 -->
<script>
/***********************************************分销操作 start **************************************************************************/


//显示商品分销设定 type 1单独设置 2总设置 3分组设置
function setGoodsDistribution(condition, type){
	$("#distribution_type").val(type);
	$("#distribution_condition").val(condition);
	if(type == 1){
		$.ajax({
			type : "post",
			url : "<?php echo __URL('http://127.0.0.1:8080/index.php/nsfx/admin/Distribution/getGoodsCommissionRateDetail'); ?>",
			data : {
				"goods_id" : condition
			},
			success : function(data) {
				if(data.is_open == 1){
					var html = '<input  type="checkbox"  class="checkbox" checked/>';
				}else{
					var html = '<input  type="checkbox"  class="checkbox" />';
				}
				$("#is_open").html(html);
				$(".checkbox").simpleSwitch({
					"theme": "FlatRadius"
				});
				$("#distribution_commission_rate").val(data.distribution_commission_rate);
				$("#partner_commission_rate").val(data.partner_commission_rate);
				$("#distribution_team_commission_rate").val(data.distribution_team_commission_rate);
				$("#partner_team_commission_rate").val(data.partner_team_commission_rate);
				$("#regionagent_commission_rate").val(data.regionagent_commission_rate);
				$("#channelagent_commission_rate").val(data.channelagent_commission_rate);
			}
		})	
	}else if(type == 2){
		
		var goods_type = "";
		$("#distributionGoodsChecked input[type='checkbox']:checked").each(function(){
			if (!isNaN($(this).val())) {
				goods_type = $(this).val() + "," + goods_type;
			}
		});

		goods_type = goods_type.substring(0, goods_type.length - 1);
		$("#distribution_condition").val(goods_type);
		hideGoodsGoodsDistributionGroupCount();
	}
	$("#editGoodsCommissionRate").modal("show");
}
/**
 * 查看分销设置
 */
function queryGoodsDistribution(goods_id){

	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/nsfx/admin/Distribution/getGoodsCommissionRateDetail'); ?>",
		data : {
			"goods_id" : goods_id
		},
		success : function(data) {
			$(".distribution_commission_rate").text(data.distribution_commission_rate+"%");
			$(".partner_commission_rate").text(data.partner_commission_rate+"%");
			$(".distribution_team_commission_rate").text(data.distribution_team_commission_rate+"%");
			$(".partner_team_commission_rate").text(data.partner_team_commission_rate+"%");
			$(".regionagent_commission_rate").text(data.regionagent_commission_rate+"%");
			$(".channelagent_commission_rate").text(data.channelagent_commission_rate+"%");
			if(data.is_open == 1){
				$(".is_open").text("已开启");
			}else{
				$(".is_open").text("已关闭");
			}
		}
	})	
	
	$("#queryGoodsCommissionRate").modal("show");
}
//修改商品分销设定
function updateGoodsCommissionRate(){
	
	
	var condition = $("#distribution_condition").val();
	var condition_type = $("#distribution_type").val();
	var distribution_commission_rate = $("#distribution_commission_rate").val();
	var partner_commission_rate = $("#partner_commission_rate").val();
	var distribution_team_commission_rate = $("#distribution_team_commission_rate").val();
	var partner_team_commission_rate = $("#partner_team_commission_rate").val();		
	var regionagent_commission_rate = $("#regionagent_commission_rate").val();
	var channelagent_commission_rate = $("#channelagent_commission_rate").val();
	var is_open = $("#is_open input").prop('checked') ? 1 : 0 ;
	var all = parseFloat(distribution_commission_rate) + parseFloat(partner_commission_rate) + parseFloat(distribution_team_commission_rate) + parseFloat(partner_team_commission_rate) + parseFloat(regionagent_commission_rate) + parseFloat(channelagent_commission_rate);
	if(all > 100){
		showMessage('error', "总和不能大于100%");
		return false;
	}
	$.ajax({
		type:"post",
		url:"<?php echo __URL('http://127.0.0.1:8080/index.php/nsfx/admin/Distribution/updateGoodsCommissionRate'); ?>",
		data:{
			'distribution_commission_rate':distribution_commission_rate,
			'partner_commission_rate':partner_commission_rate,
						'global_commission_rate':0,
			'distribution_team_commission_rate':distribution_team_commission_rate,
			'partner_team_commission_rate':partner_team_commission_rate,
			'regionagent_commission_rate':regionagent_commission_rate,
			'channelagent_commission_rate':channelagent_commission_rate,
			'condition':condition,
			'condition_type':condition_type,
			'is_open' : is_open
		},
		success:function (data) {
			$("#editGoodsCommissionRate").modal("hide");
			if (data["code"] > 0) {
				showMessage('success', data["message"]);
				LoadingInfo(1);
			}else{
				showMessage('error', data["message"]);
				LoadingInfo(1);
			}	
		}
	});
}

//商品修改分组id合计
function showGoodsGoodsDistributionGroupCount(){
	$("#goodsDistributionGroup").popover("show");
	$(".popover").css("max-width",'1000px');
}

/**
 * 隐藏商品分组
 */
function hideGoodsGoodsDistributionGroupCount(){
	$("#goodsDistributionGroup").popover("hide");
}



//商品上架id合计
function goodsIdDistribution(line){
	var goods_ids= "";
	$("#productTbody input[type='checkbox']:checked").each(function() {
		if (!isNaN($(this).val())) {
			goods_ids = $(this).val() + "," + goods_ids;
		}
	});
	goods_ids = goods_ids.substring(0, goods_ids.length - 1);
	if(goods_ids == ""){
		showTip("请选择需要操作的记录","warning");
		return false;
	}
	modifyGoodsDistribution(goods_ids,line);
}
//商品是否开启分销
function modifyGoodsDistribution(goods_ids,line){
	if(line == "open"){
		var is_open = 1;
		var lingStr = "开启分销";
	}else{
		var is_open = 0;
		var lingStr = "关闭分销";
	}
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/nsfx/admin/Distribution/modifyGoodsDistribution'); ?>",
		data : {
			"goods_ids" : goods_ids,
			"is_open":is_open
			
		},
		success : function(data) {
			if(data["code"] > 0 ){
				LoadingInfo(1);
				showTip(data['message'],"success");
			}
		}
	})
}


/***********************************************分销操作 end **************************************************************************/
</script>
<?php endif; ?>

</body>
</html>