<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:41:"template/admin\Config\goodsRecommend.html";i:1554114292;s:48:"D:\phpStudy\WWW\niushop\template\admin\base.html";i:1553915410;s:65:"D:\phpStudy\WWW\niushop\template\admin\controlCommonVariable.html";i:1552613506;s:52:"D:\phpStudy\WWW\niushop\template\admin\urlModel.html";i:1552613544;s:68:"D:\phpStudy\WWW\niushop\template\admin\Config\goodsSelectDialog.html";i:1553303637;s:54:"D:\phpStudy\WWW\niushop\template\admin\pageCommon.html";i:1552613506;s:54:"D:\phpStudy\WWW\niushop\template\admin\openDialog.html";i:1552613504;}*/ ?>
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
	
<style  type="text/css">
input[type="radio"]{margin-top:6px;}
.total{width: 100%;overflow: hidden;}
.total label {float:left;text-align: left;font-size: 15px; width:10%;overflow:hidden;color:#666;font-weight: normal;line-height: 32px;margin-bottom:0px}
.total label input {margin: 0 5px 0 0;}
.mTop{margin-top: 5px;}
.goods-item {
    width: 7%;
    float: left;
    margin-left: 1%;
}
.goods-img {
	width: 100%;
	height: 70px;
}
.goos-title{
	float:left;
	margin-left:10px;
}
.goods-item {
	position: relative;
    border: 1px solid #d3d3d3;
	margin-bottom:20px;
    overflow: hidden;
}
.goods-name {
    position: absolute;
    bottom: 0;
    background: rgba(0,0,0,.5);
    color: #fff;
    width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
	height: 27px;
    line-height: 30px;
	padding: 0 10px;
    box-sizing: border-box;
}
.clear {
	clear: both;
}
.goods-list {
	float:left;
	width: 1000px;
	margin-top: 10px;
}
.CommodityMum{
	margin-left:25px;
	margin-right:15px;
	border-left:1px solid #e1e7f1; 
	padding-left:15px;
}
.CommoditySource{
	padding-left:15px; 
	border-left:1px solid #e1e7f1;
	margin-left:15px;
}
.CommodityEditor{
	position: absolute;
	font-size: 12px;
	right: 65px;
	border: none;
	background-color: #fff;
	color: #00a0de;
}
.Delete{
	position: absolute;
	font-size: 12px;
	right: 20px;
	border: none;
	background-color: #fff;
	color: #ccc;
}
.upload-btn-common>em {
	line-height: 30px;
	height: 30px;
}
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
			
<div class="space-10"></div>
<div class="set-style">
	<dd>
		<button class="btn-common" onclick="open_Goods_Select_List()">添加</button>
		<span class="select-tip"></span>
		<p class="error"></p>
	</dd>
</div>
<div class="set-style">
	<div class='select-goods'>
		<!-- 所有决定商品弹框内容的条件和存放商品id的隐藏域 -->
		<span id="goods-condition">
			<input type="hidden" name="type" value="2"/>
			<input type="hidden" name="stock" value="1"/>
			<input type="hidden" name="goods_type" value="1"/>
			<input type="hidden" name="is_have_sku" value="1"/>
			<input type="hidden" name="state" value="1"/>
			<input type="hidden" id="goods_id_array" value="">
			<input type="hidden" id="range_type" value="">
			<input type="hidden" id="is_show_select" value="1">
			<input type="hidden" id="action" value="">
		</span>
		<style>
.table-class tr th{padding:5px;}
.table-class tr td{text-align: center;}
input[type="radio"]{margin-top:6px;}
.total{width: 100%;overflow: hidden;}
.total label {float:left;text-align: left;font-size: 15px; width:10%;overflow:hidden;color:#666;font-weight: normal;line-height: 32px;margin-bottom:0}
.total label input {margin: 0 5px 0 0;}
input[name='discount']{vertical-align:-1px;width:60px;}
.select-tip{margin-left:10px;}
.layui-layer-iframe{border:4px solid #f8f8f8;border-top:0;}
.goods-iframe{    width: 915px;height: 550px;border: 0;}
.hide {display: none!important;}
.select-type-item {display: inline-block;    margin-left: 18px;}
.goodsCategory{width: 159px;height: 300px;border: 1px solid #CCCCCC;position: absolute;z-index: 100;background: #fff;left:0;display: none;overflow-y: auto;top: 31px;}
	.goodsCategory::-webkit-scrollbar{width: 3px;}
	.goodsCategory::-webkit-scrollbar-track{-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);border-radius: 10px;background-color: #fff;}
	.goodsCategory::-webkit-scrollbar-thumb{height: 20px;border-radius: 10px;-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);background-color: #ccc;}
	.goodsCategory ul{height: 280px;margin-top: -2px;margin-left: 0;}
	.goodsCategory ul li{text-align: left;padding:0 10px;line-height: 30px;}
	.goodsCategory ul li i{float: right;line-height: 30px;}
	.goodsCategory ul li:hover{cursor: pointer;}
	.goodsCategory ul li:hover,.goodsCategory ul li.selected{background: #0059d6;color: #fff;}
	.goodsCategory ul li span{width: 120px;display: inline-block;white-space: nowrap;text-overflow: ellipsis;overflow: hidden;vertical-align: middle;font-size:12px;}
	.two{left: 161px;border-left:0;}
	.three{left: 322px;width: 159px;border-left:0;}
	.selectGoodsCategory{width: 218px;height: 45px;border:1px solid #CCCCCC;position: absolute;z-index: 100;left: 0;margin-top: 299px;border-collapse: collapse;background: #fff;display: none;}
	.selectGoodsCategory a{display: block;height: 30px;width: 100px;text-align: center;color: #fff;line-height: 30px;margin:8px;background: #00A0DE;text-decoration:none;}
	.right-indent:after{content:'';display:inline-block;width:20%;}

.layui-layer-content dl dt{
    font-size: 12px;
    line-height: 32px;
    vertical-align: top;
    text-align: right;
    display: inline-block;
    width: 13%;
    padding: 5px 0 5px 0;
    font-weight: normal;
	width: 130px !important;
}
.layui-layer-content dl dd {
    font-size: 12px;
    line-height: 30px;
    vertical-align: top;
    letter-spacing: normal;
    word-spacing: normal;
    display: inline-block;
    width: 75%;
    padding: 5px 0 5px 0;
    /* line-height: 1; */
}
.set-style {
    padding-top: 15px;
}
.btn-common.btn-small {
	display: none;
}
</style>
<!-- 弹出框的样式 -->
<link rel="stylesheet" type="text/css" href="/template/admin/public/css/defau.css">
<!-- 插件js -->
<script src="/template/admin/public/js/art_dialog.source.js"></script>
<script src="/template/admin/public/js/iframe_tools.source.js"></script>
<!-- 调用插件的js -->
<script src="/template/admin/public/js/material_managedialog.js"></script>


<!-- 选择分类 -->
<div class="select-layer set-style" style="display: none">
	<dl class="type-name">
		<dt>推荐名称：</dt>
		<dd>
			<p><input id="recommend_name" type="text" min="0" value="" class="input-common harf"></p>
			<p class="error">请输入名称</p>
		</dd>
	</dl>

	<dl style="">
		<dt>商品来源：</dt>
		<dd>
			<div class="total" id="">
				<label for="select-type-label" class="in">
					<i class="radio-common">
						<input type="radio" value="1" name="select-type"   id="select-type-label">
					</i>
					<span>标签</span>
				</label>
				<label for="select-type-category" class="">
					<i class="radio-common ">
						<input type="radio" value="2" name="select-type" id="select-type-category" >
					</i>
					<span>分类</span>
				</label>
				<label for="select-type-brand" class="in">
					<i class="radio-common">
						<input type="radio" value="3" name="select-type" id="select-type-brand">
					</i>
					<span>品牌</span>
				</label>
				<label for="select-type-recommend" class="in">
					<i class="radio-common">
						<input type="radio" value="4" name="select-type" id="select-type-recommend" >
					</i>
					<span>推荐</span>
				</label>
				<label for="select-type-customize" class="in">
					<i class="radio-common ">
						<input type="radio" value="7" name="select-type" id="select-type-customize">
					</i>
					<span>自定义</span>
				</label>
			</div>
		</dd>
	</dl>
	
	<div style="height:1px;"> </div>
	<!-- 标签 -->
	<dl class="select-type-label select-type-item hide">
		<dt>产品标签：</dt>
		<dd>
			<select class="row-no-radius select-common" id="goods-label">
				<option value="">请选择</option>
				<?php foreach($group_list as $k => $v): ?>
				<option value="<?php echo $v['group_id']; ?>"><?php echo $v['group_name']; ?></option>
				<?php endforeach; ?>
			</select>
			<p class="error">请选择标签</p>
		</dd>
	</dl>	
	
	<!-- 分类 -->
	<dl class="select-type-category select-type-item hide">
		<dt>产品分类：</dt>
		<dd>
			<div style="display: inline-block;position: relative;">
				<input type="text"  value="" placeholder="请选择商品分类" id="goodsCategoryOne" is_show="false" class="input-common" >
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
				<input type="hidden" id="category_id_3" value="">
			</div>
			<p class="error">请选择标签</p>
		</dd>
	</dl>	
	
	
	<!-- 品牌 -->
	<dl class="select-type-brand select-type-item hide">
		<dt>产品品牌：</dt>
		<dd>
			<select class="row-no-radius select-common" id="goods-brand">
				<option value="">请选择</option>
				<?php foreach($brand_list as $k => $v): ?>
				<option value="<?php echo $v['brand_id']; ?>" ><?php echo $v['brand_name']; ?></option>
				<?php endforeach; ?>
			</select>
			<p class="error">请选择品牌</p>
		</dd>
	</dl>	
	<!-- 推荐 -->
	<dl class="select-type-recommend select-type-item <?php if($recommend_list['data'][0]['type'] != 4 && $recommend_list['data'][0]['type'] != 5 && $recommend_list['data'][0]['type'] != 6): ?> hide<?php endif; ?>">
		<dt>产品推荐：</dt>
		<dd>
			<select class="row-no-radius select-common" id="goods-recommend">
				<option value="">请选择</option>
				<option value="6" >热卖</option>
				<option value="5" >推荐</option>
				<option value="4" >新品</option>
			</select>
			<p class="error">请选择推荐类型</p>
		</dd>
	</dl>	
		
	<dl class="show-num hide">
		<dt>显示数量：</dt>
		<dd>
			<p><input id="show_num" type="number" min="0" value="" onkeyup="value=value.replace(/[^\d+(\.\d+)?]/g,'')" class="input-common harf"></p>
			<p class="error">请输入显示数量</p>
		</dd>
	</dl>
		
	<!-- 自定义-->
	<div class="select-type-customize select-type-item hide">
		 <iframe class="goods-iframe" src="http://127.0.0.1:8080/index.php/admin/config/goodsSelectList"></iframe>
	</div>
</div>

<script>

$(function() {
	//公共下拉框
	$('.select-common').selectric();
	//公共复选框点击切换样式
	$(".checkbox-common").live("click",function(){
		var checkbox = $(this).children("input");
		if(checkbox.is(":checked")) $(this).addClass("selected");
		else $(this).removeClass("selected");
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
})

//商品id数组
var BatchSend = [];
//加载次数
var load_num = 1;
//layer索引
var layer_index = 1;

$(function(){
	//对某些特殊页面进行特殊操作
	var action = $("#action").val();
	if(action == 'discount'){
		$("#action-th").html('折扣')
	}else if(action == 'package'){
		$(".select-tip").html('组合套餐商品不能少于两种不能多于六种');
	}
	refreshSelectGoods();
	//如果是修改 初始化商品id数组
	var goods_id_array = $("#goods_id_array").val();
	if(goods_id_array != ''){
		BatchSend = goods_id_array.split(",");
	}
});

//刷新选择的商品
function refreshSelectGoods(){
	var goods_id_array = $("#goods_id_array").val();
	if(goods_id_array.length > 0){
		$.ajax({
			type : "post",
			url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/getSelectGoodslist'); ?>",
			data : {
				"goods_id_array" : goods_id_array,
				"type" : "selected"
			},
			async : false,
			success : function(data) {
				var html = '';
				var action = $("#action").val();
				if (data["data"].length > 0) {
					for (var i = 0; i < data["data"].length; i++) {
						
						html += '<tr>';
							html += '<i class="checkbox-common"><input value="' + data["data"][i]["goods_id"] + '"  type="hidden"></i>';

							html += '<td style="text-align:left;">' + data["data"][i]["goods_name"] + '</td>';

							html += '<td class="goods_price">' + data["data"][i]["price"] + '</td>';
							
							html += '<td>' + data["data"][i]["stock"]  + '</td>';
							
							if(action == "discount"){
								var selected_data = $("#selected_data").val();
								if(selected_data != undefined){
									selected_data = JSON.parse(selected_data);
									if(data["data"][i]["goods_id"] in selected_data){
										var discount = selected_data[data["data"][i]["goods_id"]];
									}else{
										var discount = 9.99;
									}
									html += '<td><input type="number" name="discount" class="input-common short" onchange="discount(this);" goodsid="'+ data["data"][i]["goods_id"] +'" value="'+ discount +'"><em class="unit">折</em></td>';
								}else{
									html += '<td><input type="number" name="discount" class="input-common short" onchange="discount(this);" goodsid="'+ data["data"][i]["goods_id"] +'" value="9.99"><em class="unit">折</em></td>';
								}
							}else{
								html += '<td></td>';
							}
							
							html += '<td><label for=""><i class="fa fa-times" aria-hidden="true fa-2x" onclick="cancelSelect(' + data["data"][i]["goods_id"] + ',this)"></i></label></td>';

						html += '</tr>';
					}
				} 
				$(".goods-list .table-class tbody").html(html);
				load_num ++;
				$(".error").hide();
				if(action == 'package'){
					calculate_original_price();
				}
			}
		})
	}else{
		$(".goods-list .table-class tbody").html("");
	}
}

/*
 * 打开选择商品列表弹窗
 */
function open_Goods_Select_List(obj){
	//编辑选中
	var select_type = $(obj).attr('type');
	if(select_type) {
		if(select_type == 1) {
			//标签
			$('#select-type-label').attr('checked', 'true');
			$('#select-type-label').parents('.radio-common').addClass('selected');
			$('#select-type-label').click();
			$('#recommend_name').val($(obj).attr('data-name'));
			$('#show_num').val($(obj).attr('data-num'));
			$('.select-type-label select').val($(obj).attr('data-id'));
			$('.select-common').selectric();
		}else if(select_type == 2) {
			//分类
			$('#select-type-category').attr('checked', 'true');
			$('#select-type-category').parents('.radio-common').addClass('selected');
			$('#select-type-category').click();
			$('#recommend_name').val($(obj).attr('data-name'));
			$('#show_num').val($(obj).attr('data-num'));
			$('#goodsCategoryOne').val($(obj).attr('data-type-name'));
		}else if(select_type == 3) {
			//品牌
			$('#select-type-brand').attr('checked', 'true');
			$('#select-type-brand').parents('.radio-common').addClass('selected');
			$('#select-type-brand').click();
			$('#recommend_name').val($(obj).attr('data-name'));
			$('#show_num').val($(obj).attr('data-num'));
			$('.select-type-brand select').val($(obj).attr('data-id'));
			$('.select-common').selectric();
		}else if(select_type == 4 || select_type == 5 || select_type == 6) {
			console.log(select_type);
			//新品，精品，热卖
			$('#select-type-recommend').attr('checked', 'true');
			$('#select-type-recommend').parents('.radio-common').addClass('selected');
			$('#select-type-recommend').click();
			$('#recommend_name').val($(obj).attr('data-name'));
			$('#show_num').val($(obj).attr('data-num'));
			$('.select-type-recommend select').val(select_type);
			$('.select-common').selectric();
		}else if(select_type == 7) {
			//自定义
			$('#recommend_name').val($(obj).attr('data-name'));
			$('#select-type-customize').attr('checked', 'true');
			$('#select-type-customize').parents('.radio-common').addClass('selected');
			$('#select-type-customize').click();
		}
		$('#hidden_recommend_id').val($(obj).attr('data-recommend-id'));
	}else {
		$('#hidden_recommend_id').val(0);
		//标签
		$('#select-type-label').attr('checked', 'true');
		$('#select-type-label').parents('.radio-common').addClass('selected');
		$('#select-type-label').click();
		$('#recommend_name').val('');
		$('#show_num').val('0');
	}
	
	
// 	决定商品是单选还是多选
	var type = $("#goods-condition input[name='type']").val();
	
	var obj = {};
	//库存  1:库存大于零   不传则无限制
	obj.stock = $("#goods-condition input[name='stock']").val();
	//商品类型 in查询
	obj.goods_type = $("#goods-condition input[name='goods_type']").val();
	// 是否拥有sku 1：正常  0：没有sku
	obj.is_have_sku = $("#goods-condition input[name='is_have_sku']").val();
	// 商品状态 in查询
	obj.state = $("#goods-condition input[name='state']").val();
	
	var data = '';
	for(var prop in obj){
		data += prop + ':' + obj[prop] + ',';
	}

	var goods_id_array = $(obj).attr('goods_id_array');
	layer_index = layer.open({
		type : 1,
		title: '商品推荐',
		shadeClose: true,
		shade: 0.8,
		area: ['960px', '470px'],
		content: $('.select-layer'),
		btn: ['确认'],
		yes: function(index, layero){
			save();
		 }
	});
	
}

/*
 * 获取选择数据的回调
 */
function GoodsCallBack(goods_id_array){
	$("#goods_id_array").val(goods_id_array);
	BatchSend = goods_id_array.split(",");
// 	refreshSelectGoods();
// 	layer.close(layer_index);
}

//商品取消选择
function cancelSelect(goods_id,event){
	for(var i = 0; i < BatchSend.length; i++){
		if(BatchSend[i] == goods_id){
			BatchSend.splice(i,1);
		}
	}
  	$("#goods_id_array").val(BatchSend.toString());
  	$(event).parents('tr').remove();
  	$(".error").hide();
  	
  	var action = $("#action").val();
  	if(action == 'package'){
		calculate_original_price();
	}
}

$('.total label').click(function() {
	$('.select-type-item').addClass('hide');
	var id = $(this).find('input').attr('id');
	$('.'+id).removeClass('hide');
	if(id == 'select-type-customize') {
		$('.show-num').addClass('hide');
	}else {
		$('.show-num').removeClass('hide');
	}
})

/*
 * 商品分类选择
 */
$("#goodsCategoryOne").click(function(){
	var isShow = $("#goodsCategoryOne").attr('is_show');
	if(isShow == "false"){
		$(".one").show();
		$(".selectGoodsCategory").css({
			'width' : 159,
			'right' : 580
		}).show();
		$("#goodsCategoryOne").attr('is_show','true');
		$(".js-mask-category").show();
	}else{
		$(".one").hide();
		$(".two").hide();
		$(".three").hide();
		$(".selectGoodsCategory").css({
			'width' : 159,
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
					'width' : 319,
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
					'width' : 480,
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

</script>
	</div>
</div>
<?php foreach($recommend_list['data'] as $k => $v): ?>
<div class="recommend_list" style="border:1px solid #e1e7f1; margin-top:10px;;">
	<dd style="border-bottom:1px solid #e1e7f1; background-color:#f3f7fd; margin-left:0;padding:6px 0; position:relative;">
		<span style="border-left:3px solid #00a0de;padding-left:3px;margin-left:15px;"><?php echo $v['recommend_name']; ?></span>
		<span class="CommodityMum">商品数量：
			<?php if($recommend_list['data'] != '' && $v['type'] == 7): ?>
				<?php echo count($v['goods_list']); else: ?>
				<?php echo $v['show_num']; endif; ?>
		</span>
		<span class="CommoditySource">商品来源:</span>
		<span style="background-color:#e3e9f3;font-size:12px; margin-left:3px;border-radius:3px;padding:1px 4px;color:#a5a5a5;"><?php echo $v['name']; ?></span>
		<?php if($v['type'] == 7): ?>
		<button class="CommodityEditor"  data-recommend-id="<?php echo $v['id']; ?>" data-type-name="" data-id="<?php echo $v['alis_id']; ?>" data-num="<?php echo $v['show_num']; ?>" data-name="<?php echo $v['recommend_name']; ?>" goods_id_array="<?php echo $v['goods_id_array']; ?>" type="<?php echo $v['type']; ?>" onclick="open_Goods_Select_List(this)">商品编辑</button>
		<?php elseif($v['type'] == 2): ?>
		<button class="CommodityEditor"  data-recommend-id="<?php echo $v['id']; ?>" data-type-name="<?php echo $v['type_name']['category_names']; ?>" data-id="<?php echo $v['alis_id']; ?>" data-num="<?php echo $v['show_num']; ?>" data-name="<?php echo $v['recommend_name']; ?>" goods_id_array="" type="<?php echo $v['type']; ?>" onclick="open_Goods_Select_List(this)" type="<?php echo $v['type']; ?>" onclick="open_Goods_Select_List(this)">商品编辑</button>
		<?php else: ?>
		<button class="CommodityEditor"  data-recommend-id="<?php echo $v['id']; ?>" data-type-name="" data-id="<?php echo $v['alis_id']; ?>" data-num="<?php echo $v['show_num']; ?>" data-name="<?php echo $v['recommend_name']; ?>" goods_id_array="" type="<?php echo $v['type']; ?>" onclick="open_Goods_Select_List(this)">商品编辑</button>
		<?php endif; ?>
		<button class="Delete" data-recommend-id="<?php echo $v['id']; ?>" data-type-name="" data-id="<?php echo $v['alis_id']; ?>" data-num="<?php echo $v['show_num']; ?>" data-name="<?php echo $v['recommend_name']; ?>" goods_id_array="" type="<?php echo $v['type']; ?>" onclick="deleteRecommend('<?php echo $v['id']; ?>')">删除</button>
		
	</dd>
	<dl>
		<dd style="margin-left: 31px;margin-top:20px;">
			<span style="vertical-align:top;">条幅： &nbsp;&nbsp;</span>
			<div style="display:inline-block;";>
				<div class="upload-btn-common" >
					<div>
						<input class="input-file" data-id="<?php echo $v['id']; ?>" name="file_upload" data-k="<?php echo $k; ?>" id="recommend_img_<?php echo $k; ?>" type="file" onchange="imgUpload(this);">
						<input type="hidden" class="default_recommend_img" id="default_recommend_img_<?php echo $k; ?>" value="<?php echo $v['img']; ?>" />
					</div>
						<input type="text" id="text_default_recommend_img_<?php echo $k; ?>" class="input-common" readonly="readonly" value="<?php if($v['img']): ?><?php echo $v['img']; endif; ?>" />
						<em>上传</em>
						
						<img id="preview_default_recommend_img_<?php echo $k; ?>" src="/public/static/blue/img/upload-common-select.png" <?php if($v['img']): ?>data-src="<?php echo __IMG($v['img']); ?>"<?php endif; ?> data-html="true" data-container="body" data-placement="top" data-trigger="manual"/>
		
				</div>
				<p class="hint">
					<span>建议使用<i class="important-note">宽280</i>像素-<i class="important-note">高50</i>像素内的<i class="important-note">GIF</i>或<i class="important-note">PNG</i>透明图片</span>
				</p>
			</div>
			
		</dd>
	</dl>
	<span class="goos-title">商品内容：</span>
	<div class="goods-list">
		<?php foreach($v['goods_list'] as $key => $val): ?>
		<div class="goods-item">
			<?php if($v['type'] == 7): ?> 
			<img class="goods-img" src="<?php echo __IMG($val['pic_cover_small']); ?>" onerror="javascript:this.src='/template/admin/public/images/recommend_default.png';">
			<?php else: ?>
			<img class="goods-img" src="<?php echo __IMG($val['pic_cover_mid']); ?>" onerror="javascript:this.src='/template/admin/public/images/recommend_default.png';">
			<?php endif; ?>
			<div class="goods-name"><?php echo $val['goods_name']; ?></div>
		</div>
		<?php endforeach; ?>
	</div>
	<div class="clear"></div>
</div>

<?php endforeach; ?>

<input type="hidden" id="hidden_recommend_id">
<input type="hidden" id="coupon_type_id" value="<?php echo $coupon_type_info['coupon_type_id']; ?>"/>
<script src="/public/static/js/ajax_file_upload.js" type="text/javascript"></script>
<script src="/public/static/js/file_upload.js" type="text/javascript"></script>
<script>
var flag = false;//防止重复提交
function save() {
	var type = $('input[name="select-type"]:checked').val();
	var input_id = $('input[name="select-type"]:checked').attr('id');
	var id = $('.'+input_id).find('select').val();
	var num = $('.show-num input').val();
	var hidden_recommend_id = $('#hidden_recommend_id').val();
	var recommend_name = $('#recommend_name').val();
	if(type == 4) {
		type = $('#goods-recommend').val();	
	}
	if(type == 2) {
		//分类id
		if($('#category_id_1').val()) id = $('#category_id_1').val();
		if($('#category_id_2').val()) id = $('#category_id_2').val();
		if($('#category_id_3').val()) id = $('#category_id_3').val();
	}
	
	if(type == 7) {
		var goods_id_array = $("#goods_id_array").val();
		data = {
			'type' : type,
			'alis_id' : goods_id_array,
			'recommend_id' : hidden_recommend_id,
			'recommend_name' : recommend_name,
		} 
	}else if(type == 4 || type == 5 || type == 6) {
		data = {
				'type' : type,
				'alis_id' : 0,
				'num' : num,
				'recommend_name' : recommend_name,
				'recommend_id' : hidden_recommend_id
			} 
	}else {
		data = {
			'type' : type,
			'alis_id' : id,
			'num' : num,
			'recommend_name' : recommend_name,
			'recommend_id' : hidden_recommend_id
		} 
	}
	if(flag) return;
	flag = true;
	$.ajax({
		type : "post",
		url : "http://127.0.0.1:8080/index.php/admin/Config/goodsRecommend",
		data : data,
		success : function(data) {
		 	layer.close(layer_index);
			if (data["code"] > 0) {
				showMessage('success', data["message"]);
				location.reload();
			}else{
				showMessage('error', data["message"]);
				flag = false;
			}
		}
	});
}

function deleteRecommend(id){
	if(flag) return;
	flag = true;
	$.ajax({
		type : "post",
		url : "http://127.0.0.1:8080/index.php/admin/Config/delgoodsRecommend",
		data : {'id' : id},
		success : function(data) {
		 	layer.close(layer_index);
			if (data > 0) {
				showMessage('success', data["message"]);
				location.reload();
			}else{
				showMessage('error', data["message"]);
				flag = false;
			}
		}
	});
}

function imgUpload(event) {
//图片上传
	var fileid = $(event).attr("id");
	var id = $(event).next().attr("id");
	var data = { 'file_path' : "config" };
	uploadFile({
		url: __URL(ADMINMAIN + '/config/uploadimage'),
		fileId: fileid,
		data : data,
		callBack: function (res) {
			if(res.code){
				var k = $(event).attr('data-k');
				var id = $(event).next().attr("id");
				$("#default_recommend_img_" + k).val(res.data.path);
				$("#text_default_recommend_img_" + k).val(res.data.path);
				$("#preview_default_recommend_img_"+ k).attr("data-src",__IMG(res.data.path));
				var id = $(event).attr('data-id');
				saveRecommendImg(id, res.data.path);
			}else{
				showTip(res.message,"error");
			}
		}
	});
}


//条幅保存
function saveRecommendImg(id, img) {
	$.ajax({
		type:"post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/config/saveRecommendImg'); ?>",
		data : { "id" : id, 'img' : img },
		success : function(data){
			if(data['code'] > 0){
				showTip(data.message,"success");
			}else{
				showTip(data.message,"error");
			}
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

</body>
</html>