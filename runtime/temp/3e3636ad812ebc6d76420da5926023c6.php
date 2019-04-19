<?php if (!defined('THINK_PATH')) exit(); /*a:9:{s:50:"addons/NsGoods/template/admin/Goods/editGoods.html";i:1555639684;s:48:"D:\phpStudy\WWW\niushop\template\admin\base.html";i:1553915410;s:65:"D:\phpStudy\WWW\niushop\template\admin\controlCommonVariable.html";i:1552613506;s:52:"D:\phpStudy\WWW\niushop\template\admin\urlModel.html";i:1552613544;s:65:"D:\phpStudy\WWW\niushop\template\admin\Goods\controlGoodsSku.html";i:1554119515;s:69:"D:\phpStudy\WWW\niushop\template\admin\Goods\controlGoodsPresell.html";i:1552613508;s:62:"D:\phpStudy\WWW\niushop\template\admin\Goods\fileAlbumImg.html";i:1553854072;s:54:"D:\phpStudy\WWW\niushop\template\admin\pageCommon.html";i:1552613506;s:54:"D:\phpStudy\WWW\niushop\template\admin\openDialog.html";i:1552613504;}*/ ?>
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
	
<!-- 编辑商品时，用到的JS、CSS资源 -->
<!-- 编辑商品，公共CSS、JS文件引用 -->
<link rel="stylesheet" type="text/css" href="/template/admin/public/css/product.css">
<!-- 选择商品图，弹出框的样式 -->
<link rel="stylesheet" type="text/css" href="/template/admin/public/css/defau.css">
<link href='/template/admin/public/css/select_category_next.css' rel='stylesheet' type='text/css'>
<link href="/template/admin/public/css/goods/editgoods.css" rel="stylesheet" type="text/css">
<link href="/public/static/blue/css/goods/add_goods.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/template/admin/public/css/plugin/video-js.css">

<script type="text/javascript" charset="utf-8" src="/template/admin/public/js/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/template/admin/public/js/ueditor/ueditor.all.js"></script>
<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="/template/admin/public/js/ueditor/zh-cn.js"></script>

<script src="/template/admin/public/js/image_common.js" type="text/javascript"></script>
<script src="/template/admin/public/js/kindeditor-min.js" type="text/javascript"></script>

<!--  用  验证商品输入信息-->
<script src="/template/admin/public/js/jscommon.js" type="text/javascript"></script>

<!-- 用 ，加载数据-->
<script src="/template/admin/public/js/art_dialog.source.js"></script>
<script src="/template/admin/public/js/iframe_tools.source.js"></script>

<!-- 我的图片 -->
<script src="/template/admin/public/js/material_managedialog.js"></script>
<script src="/public/static/js/ajax_file_upload.js" type="text/javascript"></script>
<script src="/public/static/js/file_upload.js" type="text/javascript"></script>
<script src='/template/admin/public/js/goods/init_address.js'></script>

<script src="/template/admin/public/js/goods/goods.js"></script>
<script src="/template/admin/public/js/goods/goods_sku.js"></script>

<script type="text/javascript" src="/template/admin/public/js/plugin/jquery.toTop.min.js"></script>
<script src="/public/static/js/BootstrapMenu.min.js"></script>

<!-- 可搜索的下拉选项框 -->
<link rel="stylesheet" type="text/css" href="/template/admin/public/css/plugin/jquery.searchableSelect.css"/>
<script src="/template/admin/public/js/plugin/jquery.searchableSelect.js"></script>
<script type="text/javascript" src="/public/static/My97DatePicker/WdatePicker.js"></script>

<script src="/template/admin/public/js/plugin/videojs-ie8.min.js"></script>
<script src="/template/admin/public/js/plugin/video.min.js"></script>
<script src="/template/admin/public/js/goods/drag-arrange.js"></script>

<script>
var goods_attribute_list = eval('<?php echo $goods_info['goods_attribute_list']; ?>');
</script>

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
			
<input type="hidden" value="<?php echo $goods_info['state']; ?>" id ="goodsstate"/>
<input type="hidden" value="<?php echo $goods_type; ?>" id ="goods_type"/>
<input type="hidden" value="<?php echo $goods_id; ?>" id = "goods_id"/>

<div class="space-10"></div>
<div class="ncsc-form-goods">
	<nav class="goods-nav">
		<ul>
			<li class="selected" data-c="block-basic-setting"><a href="javascript:;">基础设置</a></li>
			<!-- 如果不是虚拟商品点卡才可编辑商品规格 -->
			<li data-c="block-goods-type"><a href="javascript:;">商品属性</a></li>
			<li data-c="block-photo-video-setting"><a href="javascript:;">媒体设置</a></li>
			<li data-c="block-goods-detail-setting"><a href="javascript:;">商品详情</a></li>
			<?php if($is_presell): ?><li data-c="block-presell-setting"><a href="javascript:;">预售设置</a></li><?php endif; ?>
			<li data-c="block-point-setting"><a href="javascript:;">积分设置</a></li>
			<?php if(!(empty($level_list) || (($level_list instanceof \think\Collection || $level_list instanceof \think\Paginator ) && $level_list->isEmpty()))): ?><li data-c="block-discount-setting"><a href="javascript:;">折扣设置</a></li><?php endif; ?>
			<li data-c="block-ladder-setting"><a href="javascript:;">阶梯优惠</a></li>
		</ul>
	</nav>
	<!-- 基础设置 -->
	<div class="block-basic-setting">
		<h4 class="h4-title"><span></span>基础信息</h4>
		<dl>
			<dt><i class="required">*</i>商品名称：</dt>
			<dd>
				<input class="productname input-common long" type="text" id="txtProductTitle" placeholder="请输入商品名称，不能超过60个字符" <?php if($goods_info): ?>value="<?php echo $goods_info['goods_name']; ?>"<?php endif; ?> oninput='if(value.length>60){value=value.slice(0,60);$(this).next().text("商品名称不能超过60个字符").show();}else{$(this).next().hide();}'/>
				<span class="help-inline">请填写商品名称</span>
			</dd>
		</dl>
		<dl>
			<dt><i class="required">*</i>商品分类：</dt>
			<?php if($goods_info): ?>
			<dd id="tbcNameCategory" data-flag="category" cid="<?php echo $goods_info['category_id']; ?>" data-attr-id="<?php echo $goods_info['goods_attribute_id']; ?>" cname="<?php echo $goods_info['category_name']; ?>" data-goods-id="<?php echo $goods_info['goods_id']; ?>">
				<span class="category-text"><?php echo $goods_info['category_name']; ?></span>
			<?php else: ?>
			<dd id="tbcNameCategory" data-flag="category" data-goods-id="0" cid="" data-attr-id="" cname="">
				<span class="category-text"></span>
			<?php endif; ?>
				<button class="category-button">选择</button>
				<span><label class="error"><i class="icon-exclamation-sign"></i>商品分类不能为空</label></span>
				<span class="help-inline">请选择商品分类</span>
			</dd>
		</dl>
		
		<dl>
			<dt>商品促销语：</dt>
			<dd>
				<input class="productname input-common long" type="text" id="txtIntroduction" placeholder="请输入促销语，不能超过100个字符" <?php if($goods_info): ?>value="<?php echo $goods_info['introduction']; ?>"<?php endif; ?> oninput='if(value.length>100){value=value.slice(0,100);$(this).next().text("促销语不能超过100个字符").show();}else{$(this).next().hide();}'/>
				<span class="help-inline">请输入商品促销语，不能超过100个字符</span>
			</dd>
		</dl>
		<dl>
			<dt>关键词：</dt>
			<dd>
				<input class="productname input-common" type="text" id="txtKeyWords" placeholder="商品关键词用于SEO搜索" <?php if($goods_info): ?>value="<?php echo $goods_info['keywords']; ?>"<?php endif; ?> oninput='if(value.length>40){value=value.slice(0,40);$(this).next().text("商品关键词不能超过40个字符").show();}'/>
				<span class="help-inline">请输入商品促销语，不能超过40个字符</span>
			</dd>
		</dl>
		<dl>
			<dt>商品单位：</dt>
			<dd>
				<input class="productname input-common" type="text" id="goodsUnit" placeholder="请输入商品单位" <?php if($goods_info): ?>value="<?php echo $goods_info['goods_unit']; ?>"<?php endif; ?> oninput='if(value.length>10){value=value.slice(0,10);$(this).next().text("商品单位不能超过10个字符").show();}'/>
				<span class="help-inline">请输入商品单位，不能超过10个字符</span>
			</dd>
		</dl>
		<dl>
			<dt>商品标签：</dt>
			<dd>
				<div class="group-text-check-box">
					<div class="controls product-category-position">
						<?php if(!empty($group_list)): if($goods_info['group_id_array'] != ''): ?>
								<select class="select-common" multiple id="goods_group" size="1">
									<option value="0" disabled>请选择商品标签</option>
									<?php foreach($group_list as $k=>$v): if(in_array(($v['group_id']), is_array($goods_info['group_id_array'])?$goods_info['group_id_array']:explode(',',$goods_info['group_id_array']))): ?>
										<option value="<?php echo $v['group_id']; ?>" selected><?php echo $v['group_name']; ?></option>
										<?php else: ?>
										<option value="<?php echo $v['group_id']; ?>"><?php echo $v['group_name']; ?></option>
										<?php endif; endforeach; ?>
								</select>
							<?php else: ?>
								<select class="select-common" multiple id="goods_group" size="1">
									<option value="0" disabled>请选择商品标签</option>	
									<?php foreach($group_list as $k=>$v): ?>
										<option value="<?php echo $v['group_id']; ?>"><?php echo $v['group_name']; ?></option>
									<?php endforeach; ?>
								</select>
							<?php endif; else: ?>
							<span class="span-error" style="display:block;">暂无可选的商品标签</span>
						<?php endif; ?>
					</div>
				</div>
			</dd>
		</dl>
		
		<dl style="overflow: inherit;">
			<dt>商品品牌：</dt>
			<dd class="js-brand-block">
				<div class="controls brand-controls">
					<select id="brand_id" class="select-common-ajax" >
						<option value="0">请选择商品品牌</option>
					</select>
					<input type="hidden" id = "hidden_brand_id" value="<?php echo $goods_info['brand_id']; ?>"/>
					<input type="text" id="selected_brand_name" style="padding:0;margin:0;opacity: 0;position: absolute;"/>
					<p class="hint">可输入品牌名或品牌首字母来搜索品牌</p>
				</div>
			</dd>
		</dl>
		
		<dl>
			<dt>供货商：</dt>
			<dd>
				<select id="supplierSelect" class="select-common">
					<option value="0">请选择供货商</option>
					<?php if(is_array($supplier_list) || $supplier_list instanceof \think\Collection || $supplier_list instanceof \think\Paginator): if( count($supplier_list)==0 ) : echo "" ;else: foreach($supplier_list as $key=>$sup): if($goods_info): if($sup['supplier_id'] == $goods_info['supplier_id']): ?>
						<option value="<?php echo $sup['supplier_id']; ?>" selected="selected"><?php echo $sup['supplier_name']; ?></option>
						<?php else: ?>
						<option value="<?php echo $sup['supplier_id']; ?>"><?php echo $sup['supplier_name']; ?></option>
						<?php endif; else: ?>
						<option value="<?php echo $sup['supplier_id']; ?>"><?php echo $sup['supplier_name']; ?></option>
					<?php endif; endforeach; endif; else: echo "" ;endif; ?>
				</select>
				<span class="help-inline">请选择供货商</span>
			</dd>
		</dl>
		<dl>
			<dt>基础销量：</dt>
			<dd>
				<input type="number" class="span1 input-common harf" id="BasicSales" placeholder="0" <?php if($goods_info): ?>value="<?php echo $goods_info['sales']; ?>"<?php endif; ?> 
				/><em class="unit">件</em>
				<span class="help-inline">基础销量必须是数字，且不能为负数</span>
			</dd>
		</dl>
		<dl>
			<dt>基础点击数：</dt>
			<dd>
				<input type="number" class="span1 input-common harf" id="BasicPraise" placeholder="0" <?php if($goods_info): ?>value="<?php echo $goods_info['clicks']; ?>"<?php endif; ?> 
				/><em class="unit">次</em>
				<span class="help-inline">基础点击数必须是数字，且不能为负数</span>
			</dd>
		</dl>
		<dl>
			<dt>基础分享数：</dt>
			<dd>
				<input type="number" class="span1 input-common harf" id="BasicShare" placeholder="0" <?php if($goods_info): ?>value="<?php echo $goods_info['shares']; ?>"<?php endif; ?> 
				/><em class="unit">次</em>
				<span class="help-inline">基础分享数必须是数字，且不能为负数</span>
			</dd>
		</dl>
		<dl>
			<dt>商家编码：</dt>
			<dd>
				<input type="text" class="input-common" id="txtProductCodeA" placeholder="请输入商家编码" <?php if($goods_info): ?>value="<?php echo $goods_info['code']; ?>"<?php endif; ?>/>
				<span class="help-inline">请输入商家编码，不能超过40个字符</span>
			</dd>
		</dl>
		<dl>
			<dt>生产日期：</dt>
			<dd>
				<input type="text" class="input-common" id="production_date" onclick="WdatePicker()" <?php if($goods_info): if($goods_info["production_date"] != 0): ?>value="<?php echo date('Y-m-d',$goods_info['production_date']); ?>"<?php endif; endif; ?>>
			</dd>
		</dl>
		<dl>
			<dt>保质期天数：</dt>
			<dd>
				<input type="number" class="goods-stock input-common harf" id="shelf_life" value="<?php if($goods_info): ?><?php echo $goods_info['shelf_life']; else: ?>0<?php endif; ?>"
				/><em class="unit">天</em>
				<span class="help-inline">请输入保质期天数，必须是整数</span>
			</dd>
		</dl>

		<dl>
			<dt><i class="required">*</i>总库存：</dt>
			<dd>
				<input type="number" class="goods-stock input-common harf" id="txtProductCount" min="0" value="<?php if($goods_info): ?><?php echo $goods_info['stock']; else: ?>0<?php endif; ?>" 
				/><em class="unit">件</em>
				<span class="help-inline">请输入总库存数量，必须是大于0的整数</span>
			</dd>
		</dl>
		<dl>
			<dt><i class="required">*</i>库存预警：</dt>
			<dd>
				<input type="number" class="goods-stock input-common harf" id="txtMinStockLaram" min="0" value="<?php if($goods_info): ?><?php echo $goods_info['min_stock_alarm']; else: ?>0<?php endif; ?>" 
				/><em class="unit">件</em>
				<span class="help-inline">请输入库存预警数，必须是大于0的整数</span>
				<p class="hint">设置最低库存预警值。当库存低于预警值时商家中心商品列表页库存列红字提醒。<br>0为不预警。</p>
			</dd>
		</dl>

		<dl>
			<dt><i class="required">*</i>库存显示：</dt>
			<dd>
				<div class="controls">
					<?php if($goods_info): if($goods_info['is_stock_visible']  == 1): ?>
						<label class="radio inline normal">
							<i class="radio-common selected">
								<input type="radio" name="stock" checked="checked" value="1" />
							</i>
							<span>是</span>
						</label>
						<label class="radio inline normal">
							<i class="radio-common">
								<input type="radio" name="stock" value="0" />
							</i>
							<span>否</span>
						</label>
						<?php else: ?>
						<label class="radio inline normal">
							<i class="radio-common">
								<input type="radio" name="stock"  value="1" />
							</i>
							<span>是</span>
						</label>
						<label class="radio inline normal">
							<i class="radio-common selected">
								<input type="radio" name="stock" value="0" checked="checked" />
							</i>
							<span>否</span>
						</label>
						<?php endif; else: ?>
						<label class="radio inline normal">
							<i class="radio-common selected">
								<input type="radio" name="stock" checked="checked" value="1" />
							</i>
							<span>是</span>
						</label>
						<label class="radio inline normal">
							<i class="radio-common">
								<input type="radio" name="stock" value="0" />
							</i>
							<span>否</span>
						</label>
					<?php endif; ?>
					<span class="help-inline">请选择库存是否显示</span>
				</div>
			</dd>
		</dl>
		<dl>
			<dt><i class="required">*</i>是否上架：</dt>
			<dd>
				<div class="controls">
					<?php if($goods_info): if($goods_info['state'] == 1): ?>
						<label class="radio inline normal">
							<i class="radio-common selected">
								<input type="radio" name="state" value="1" checked="checked" />
							</i>
							<span>立刻上架</span>
						</label>
						<label class="radio inline normal">
							<i class="radio-common">
								<input type="radio" name="state" value="0" />
							</i>
							<span>放入仓库</span>
						</label>
						<?php else: ?>
						<label class="radio inline normal">
							<i class="radio-common">
								<input type="radio" name="state" value="1" />
							</i>
							<span>立刻上架</span>
						</label>
						<label class="radio inline normal">
							<i class="radio-common selected">
								<input type="radio" name="state" value="0" checked="checked" />
							</i>
							<span>放入仓库</span>
						</label>
						<?php endif; else: ?>
						<label class="radio inline normal">
							<i class="radio-common selected">
								<input type="radio" name="state" value="1" checked="checked" />
							</i>
							<span>立刻上架</span>
						</label>
						<label class="radio inline normal">
							<i class="radio-common">
								<input type="radio" name="state" value="0" />
							</i>
							<span>放入仓库</span>
						</label>
					<?php endif; ?>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>商品所在地：</dt>
			<dd>
				<select id="provinceSelect" class="select-common middle" onchange="getProvince(this,'#citySelect',-1)">
					<option value="0">请选择省</option>
				</select>
				<input type="hidden" id = "province_id" value = "<?php echo $goods_info['province_id']; ?>"/>
				<select id="citySelect" value = "<?php echo $goods_info['city_id']; ?>" class="select-common middle">
					<option value="0">请选择市</option>
				</select>
				<input type="hidden" id = "city_id" value = "<?php echo $goods_info['city_id']; ?>"/>
			</dd>
		</dl>
		
		<h4 class="h4-title"><span></span>购买信息</h4>
		<dl>
			<dt><i class="required">*</i>商品规格：</dt>
			<dd>
				<div class="controls">
					 
					<label class="radio inline normal">
						<?php if($spec_arr_count > 0): ?> 
						<i class="radio-common">
							<input type="radio" name="sku_type"  value="0"  />
						</i>
						<?php else: ?>
						<i class="radio-common selected">
							<input type="radio" name="sku_type"  value="0" checked="checked" />
						</i>
						<?php endif; ?>
						<span>统一规格</span>
					</label>
					<label class="radio inline normal">
						<?php if($spec_arr_count > 0): ?> 
						<i class="radio-common selected">
							<input type="radio" name="sku_type" value="1" checked="checked"/>
						</i>
						<?php else: ?>
						<i class="radio-common ">
							<input type="radio" name="sku_type" value="1"/>
						</i>
						<?php endif; ?>
						<span>多规格</span>
					</label>
					<span class="help-inline">请选择库存是否显示</span>
				</div>
			</dd>
		</dl>
		
		<link rel="stylesheet" type="text/css" href="/template/admin/public/css/anticon.css">
<style type="text/css">
.table-class tr th{width: 60px !important;}
.sku_spec_list{}
.sku_spec_list .spec-item{margin: 0px 0px 10px;border: 1px solid;border-style: dashed;border-color:transparent;}
.sku_spec_list .spec-item:hover{border-color: rgba(153, 153, 153, 0.54);}
.sku_spec_list .spec-head{background: #f5f7fa;overflow: hidden; line-height: 40px;}
.spec-head>div{float: left;}
.spec-head>div.spec-1-l{width: 20px;text-align: center;background: #E0E6F2;cursor: all-scroll;}
.spec-head>div.spec-1-c>div{float: left; padding: 0px 0px 0px 8px;}
.spec-head>a.spec-1-r{float: right;margin-right: 10px;}
.spec-1-c>div.c-input-text{position: relative;}
.spec-1-c>div.c-input-text input{border-radius: 0px;border-color: #eceef1;box-shadow: none;font-size: 12px;}
.spec-1-c>div.c-input-text .bg-primary{
    position: absolute;
    top: 8px;
    right: 8px;
    font-size: 18px;
    line-height: 15px;
    cursor: pointer;
    color: #999;
}

.spec-content{
	    display: block;
    overflow: hidden;
    padding: 10px 0px 0px 84px;
}
.spec-content .spec-value-item{
    position: relative;
    display: inline-block;
    float: left;
    margin: 0px 10px 5px 0px;
    padding: 0px 0px;
    min-width: 28px;
    cursor: all-scroll;
}
.spec-content .spec-value-item .value-item-affiliate{
    float: left;
    margin-right: 5px;
    height: 30px;
    width: 30px;
	cursor: pointer;
}
.spec-content .spec-value-item .value-item-affiliate span{
    background: red;
    height: 16px;
    width: 16px;
	display: block;
}
.spec-content .spec-value-item .value-item-affiliate .affiliate_img{
	left: 0px;
    margin-left: 0px;
    border: 1px solid #eceef1;
    padding: 6px 6px;
    box-sizing: border-box;
    display: block;
    text-align: center;
    width: 100%;
}
.spec-content .spec-value-item .value-item-affiliate img{
	height: 16px;
    margin-left:0px;
	display: block;
}
.spec-content .spec-value-item .input_div{
    float: left;
    position: relative;
}
.spec-content .spec-value-item .input_div span{
    color: transparent;
    display: inline-block;
    min-width: 30px;
	padding: 0px 8px;
}
.spec-content .spec-value-item .input_div input{
	position: absolute;
    right: 0px;
    top: 0px;
}
.spec-content .spec-value-item:hover i{display: inline-block;}
.spec-content .spec-value-item input{
    width: 100%;
    border-radius: 0px;
    border-color: #eceef1;
    box-shadow: none;
    color: #5e6166;
    box-sizing: border-box;
    height: 30px;
    font-size: 12px;
    left: 0px;
	text-align: center;
	cursor: all-scroll;
}
.spec-content .spec-value-item>i{
	display: none;
 position: absolute;
   right: -8px;
    top: -8px;
    line-height: 16px;
    cursor: pointer;
    color: #fff;
    border-radius: 15px;
    background: rgba(0, 0, 0, 0.3);
    width: 16px;
    text-align: center;
    font-style: inherit;
    font-size: 12px;
}
.spec-value-add{margin-left: 84px;}
.layui-layer-prompt textarea.layui-layer-input{box-shadow: none;}
.hide-spec-value-width{display: inline-block; color: transparent;}
.table-class tr th{border: 1px solid #E1E6F0;padding: 0px;}

.table-class tr th:nth-last-child(1),.table-class tr th:nth-last-child(2),.table-class tr th:nth-last-child(3),.table-class tr th:nth-last-child(4),.table-class tr th:nth-last-child(5),.table-class tr th:nth-last-child(6),.table-class tr th:nth-last-child(7){
	width:10%;
	max-width: 100px;
}

.table-class tr td .input-common.middle{
	text-align:center;
	width:62% !important;
	min-width: 35px;
}
.table-class tr td{padding: 3px 0px;}

/* sku图片 */
.goods-info-img-upload {
    zoom: 1;
    font-size: 12px;
    overflow: hidden;
    display: block;
    float: left;
	padding-left: 8px;
}
.ant-upload-select-picture-card {
    border: 1px dashed #d9d9d9;
    width: 50px;
    height: 50px;
    border-radius: 2px;
    background-color: #fbfbfb;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.3s ease;
    display: -webkit-box;
    margin: 8px;
}
.ant-upload.ant-upload-select-picture-card > .ant-upload {
    display: block;
    width: 100%;
    height: 100%;
    padding: 15px 0;
    box-sizing: border-box;
}
.anticon {
    display: inline-block;
    font-style: normal;
    vertical-align: baseline;
    text-align: center;
    text-transform: none;
    text-rendering: auto;
    line-height: 1;
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
.anticon-plus:before {
    content: "+";
    font-size: 22px;
    color: #999;
}
.anticon:before {
    display: block;
    font-family: "anticon" !important;
}

.goods-info-img-upload .ant-upload-list-item {
    width: 50px;
    height: 50px;
    padding: 0;
    margin: 8px 8px 8px 0;
    border-radius: 2px;
    border: 1px solid #d9d9d9;
    overflow: hidden;
    position: relative;
    transition: background-color 0.3s ease;
    float: left;
}

.goods-info-img-upload .ant-upload-list-item .ant-upload-list-item-thumbnail {
    line-height: 46px;
    display: block;
    height: 100%;
    text-align: center;
    position: static;
    top: 8px;
    left: 8px;
}

.goods-info-img-upload .ant-upload-list-item:before {
    content: ' ';
    position: absolute;
    z-index: 1;
    background-color: #808080;
    transition: all 0.3s ease;
    opacity: 0;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
}

.goods-info-img-upload .ant-upload-list-item:hover:before {
    opacity: .8;
}

.goods-info-img-upload .ant-upload-list-item:hover .anticon-eye-o,
.goods-info-img-upload .ant-upload-list-item:hover .anticon-delete {
    opacity: 1;
}

.goods-info-img-upload .ant-upload-list-item:hover .anticon-eye-o:hover,
.goods-info-img-upload .ant-upload-list-item:hover .anticon-delete:hover {
    color: #fff;
}

.goods-info-img-upload .ant-upload-list-item .ant-upload-list-item-thumbnail img {
    width: auto;
    height: auto;
    max-width: 100%;
    max-height: 100%;
    display: inline-block;
    vertical-align: middle;
    overflow: hidden;
    border-radius: 2px;
}
</style>
<dl class="sku_type_2">
	<dt></dt>
	<dd>
		<div class="sku_spec_list" >
		</div>
		<button class="btn-common" name = "add_spec_item">添加规格</button>
	</dd>
</dl>
<dl class="sku_type_2" >
	<dt><div class="hide-spec-value-width"></div></dt>
	<dd>
		<div class="block-goods-sku" style="display: block;">
			<div class="volume-set-sku-info">
				<span>批量设置：</span>
				<a href="javascript:;" data-tag="sku-price">销售价</a>
				<a href="javascript:;" data-tag="market-price">市场价</a>
				<a href="javascript:;" data-tag="cost-price">成本价</a>
				<a href="javascript:;" data-tag="stock-num">库存</a>
				<?php if($goods_type == 'NsGoods'): ?>
				<a href="javascript:;" data-tag="volume">体积</a>
				<a href="javascript:;" data-tag="weight">重量</a>
				<?php endif; ?>
				<input type="text" class="input-common middle">
				<button class="btn-common">确定</button>
				<button class="btn-common-cancle">取消</button>
			</div>
			<div class="goods-sku-list">
				<table class="table-class">
					<thead></thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</dd>
</dl>

<script type="text/javascript">
var h, l, t_obj, obj, l_obj;

var goods_spec_format = StringTransference('<?php echo $goods_info['goods_spec_format']; ?>', {" " : "&nbsp;"});
var sku_list = eval('<?php echo $goods_info['sku_list']; ?>');//SKU数据

var spec_item_arr = new Array();
let sku_spec_obj = $('.sku_spec_list');
spec_item = function(){
	
	l = $('.spec-item').length;
	var spec_id, spec_name ='', spec_show_type = 1;
	if(spec_item_arr.length == 0){
		spec_id = -(($(".js-sku-list-popup li").length-1) + Math.floor(new Date().getSeconds()) + Math.floor(new Date().getMilliseconds()));
	}else{
		spec_id = spec_item_arr['spec_id'];
		spec_name = spec_item_arr['spec_name'];
		spec_show_type = spec_item_arr['spec_show_type'];
	}
	
	if(l > 3){layer.msg('规格项最多为4项！');return;}
	h = `<div class="spec-item" >
			<div class="spec-head">
				<div class="spec-1-l">
					<img src="/template/admin/public/images/sku_spec_1.png" alt="" draggable="false">
				</div>
				<div class="spec-1-c">
					<div class="c-title">规格项：</div>
					<div class="c-input-text">
						<input type="text" placeholder="请输入规格名称" name = "spec_name" spec_id = ${spec_id} value = "${spec_name}">
						<span class="bg-primary" onclick="edit_sku_popup(this)">...</span>
					</div><div class="c-spec-img">`;
	h +=`		</div></div>
				<a href="javascript:;" class ="spec-1-r" sku-data-generate onclick = "spec_del(this, 'spec-item')">删除</a>
			</div>
			<div class = "spec-content">`;
		if(spec_item_arr != ''){
			for(value_item of spec_item_arr['value']){
				
				h += `<div class="spec-value-item" title ="${value_item.spec_value_name}">`;
				if(spec_show_type == 2){
					
					if(value_item.spec_value_data == ''){
						h += `<div class="value-item-affiliate upload-btn-common"> <div class="affiliate_img"><img src="/template/admin/public/images/spec_value_item_affiliate.png" alt=""></div></div>`;	
					}else{
						h += `<div class="value-item-affiliate upload-btn-common"> <div class="affiliate_img"><img src="${__IMG(value_item.spec_value_data)}" alt="" src_path = "${value_item.spec_value_data}"></div></div>`;	
					}
				}else if(spec_show_type == 3){
					h += `<div class ="value-item-affiliate"><input type="color" class="input-common-color" value="${value_item.spec_value_data }"></div>`;
				}

				h += `<div class="input_div"><span>${value_item.spec_value_name}</span><input type="text" value = "${value_item.spec_value_name}"  name="spec_value" spec_value_id = "${value_item.spec_value_id}" /></div>
				 		<i onclick = "spec_del(this, 'spec-value-item')" sku-data-generate>×</i>
				 	</div>`;
			}	
		}
			
 	h +=`</div>
			<a href="javascript:;" class="spec-value-add" onclick="spec_value_item(this)">+添加规格值</a>
		</div>`;
		
	sku_spec_obj.append(h);if(l==0){spec_value_subsidiry(spec_show_type);} //加载附属值选项
	
};

//加载附属值选项
spec_value_subsidiry = function(spec_show_type){
	
	var subsidiary_arr = [];
	obj = {};obj.value = 1;obj.name = '无';subsidiary_arr.push(obj);
	obj = {};obj.value = 2;obj.name = '图片';subsidiary_arr.push(obj);
	obj = {};obj.value = 3;obj.name = '颜色';subsidiary_arr.push(obj);
	h = '';
	for(subsidiary_item of subsidiary_arr){
		h +=`<label class="radio inline normal spec_value_subsidiary">`;
		
		if(spec_show_type == subsidiary_item.value){
			h +=`<i class="radio-common selected">
				<input type="radio" name="spec_value_subsidiary" value="${subsidiary_item.value}" checked="checked" />
				</i>`;
		}else{
			h +=`<i class="radio-common">
				<input type="radio" name="spec_value_subsidiary" value="${subsidiary_item.value}"/>
			</i>`;
		}
			
		h +=`	<span>${subsidiary_item.name}</span>
			</label>`;
	}
	$('.sku_spec_list .spec-item:gt(0) .c-spec-img').html('');
	$('.sku_spec_list .spec-item:eq(0) .c-spec-img').html(h);
	
	$('.sku_spec_list .spec-item:gt(0) .value-item-affiliate').remove();
};

spec_value_item = function(e){

	t_obj = $(e).parent().children('.spec-content');
	spec_id = $(e).parent().find('[name="spec_name"]').attr('spec_id');
	spec_name = $(e).parent().find('[name="spec_name"]').val();
	spec_show_type = $(e).parent().find('[name="spec_value_subsidiary"]:checked').val();
   	layer.prompt({title: '输入规格值，多个换行即可', formType: 2}, function(text, index){
   		 
   		  if(text != ''){
   			  v = text.replace(/\n/g,",");
   			  arr = v.split(',');
   			  for(ele of arr){
   				if(ele=='')continue;
   				if(t_obj.find(`[title ="${ele}"]`).length > 0)continue;
   				
   				spec_value_id = -(spec_id + Math.floor(new Date().getSeconds()) + Math.floor(new Date().getMilliseconds()));
   				
  			 	h = `<div class="spec-value-item" title ="${ele}">`;
  			 	
  			 	if(spec_show_type == 2){
  			 		h += `<div class="value-item-affiliate upload-btn-common"> <div class="affiliate_img"><img src="/template/admin/public/images/spec_value_item_affiliate.png" alt=""></div></div>`;
  			 	}else if(spec_show_type == 3){
  			 		h += `<div class ="value-item-affiliate"><input type="color" class="input-common-color" value="#000000"></div>`;
  			 	}
		  			h+=`<div class="input_div"><span>${ele}</span><input type="text" value = "${ele}"  name="spec_value" spec_value_id = "-${spec_value_id}" /></div>
		  		 		<i onclick = "spec_del(this, 'spec-value-item')" sku-data-generate>×</i>
		  		 	</div>`;
	  		 	t_obj.append(h);
	  		 	
	  		 	//如果是在现有的规格上的话添加
	  		 	if(spec_id > 0){
	  		 		obj_value = {spec_id : spec_id,
			  				spec_name : spec_name,
			  				spec_show_type : 1,
			  				spec_value_id : spec_value_id,
			  				spec_value_name : ele,
			  				spec_value_data : ""};
		  		 	add_original_sku(obj_value);
	  		 	}
   			  }
   		  }
   		sku_table_generate();
   		layer.close(index);
	});
};

//弹出框规格添加值
add_original_sku = function(obj_value){
	obj = $(`.original-sku-list li[data-spec-id="${obj_value.spec_id}"]`);
	var spec_value_json = eval(obj.attr("data-spec-value-json"));
	spec_value_json.push(obj_value);

	obj.attr("data-spec-value-json",JSON.stringify(spec_value_json));
	obj.attr("data-spec-value-length",spec_value_json.length);
};

//执行删除
spec_del = function(e, p_name){
	t_obj = $(e).parents('.'+p_name);
	t_obj.remove();
};

sku_spec_list = function(){
	
	var obj = {};
	var arr = [];
	$('.sku_spec_list .spec-item').each(function(){
		
		obj = {};
		obj.spec_name = $(this).find('[name="spec_name"]').val();
		obj.spec_id = $(this).find('[name="spec_name"]').attr('spec_id');
		obj.spec_show_type = $(this).find('[name="spec_value_subsidiary"]:checked').val();
		obj.spec_show_type = typeof(obj.spec_show_type) == 'undefined' ? 1 : obj.spec_show_type;
		var l_arr = [];
		$(this).find('.spec-value-item').each(function(){
			
			l_obj = {};
			l_obj.spec_id = obj.spec_id;
			l_obj.spec_name = obj.spec_name;
			l_obj.spec_value_name = $(this).find('[name="spec_value"]').val();
			l_obj.spec_value_id = $(this).find('[name="spec_value"]').attr('spec_value_id');
			l_obj.spec_show_type = obj.spec_show_type;
			
			//根据不同的类型取不同的附属值
			if(obj.spec_show_type == 1){
				l_obj.spec_value_data = '';	
			}else if(obj.spec_show_type == 2){
				var src_path = $(this).find('.affiliate_img img').attr('src_path');
				l_obj.spec_value_data = typeof(src_path) == 'undefined' ? '' :src_path;
			}else if(obj.spec_show_type = 3){
				l_obj.spec_value_data = $(this).find('.input-common-color').val();
			}
			
			l_arr.push(l_obj);
		});
		
		//如果值为空的话规格名也不取
		if(l_arr.length > 0){
			obj.value = l_arr;
			arr.push(obj);
		}
		
	});
	
	return arr;
};

get_sku_arr = function(){
	
	var arr = sku_spec_list();
	var prop_value_arr = [];
	for(var ele_1 of arr){
		var item_prop_arr = [];
		if(prop_value_arr.length > 0){
			
			for(var ele_2 of prop_value_arr){
				
				for(var ele_3 of ele_1['value']){
					
					obj = {};
					obj.sku_name = `${ele_2.sku_name}♀${ele_3.spec_value_name}`;
					obj.sku_spec_name = `${ele_2.sku_spec_name},${ele_1['spec_name']}:${ele_3.spec_value_name}`;
					obj.sku_id = `${ele_2.sku_id};${ele_1['spec_id']}:${ele_3.spec_value_id}`;
					item_prop_arr.push(obj);
				}
			}
		}else{
			for(var ele_3 of ele_1['value']){
				
				obj = {};
				obj.sku_id = `${ele_1['spec_id']}:${ele_3.spec_value_id}`;
				obj.sku_name = ele_3.spec_value_name;
				obj.sku_spec_name = `${ele_1['spec_name']}:${ele_3.spec_value_name}`;
				item_prop_arr.push(obj);
			}
		}

		prop_value_arr = item_prop_arr.length > 0 ? item_prop_arr : prop_value_arr; 
	}

	return prop_value_arr;
};

sku_table_data = function(){
	
	var sku_str = "";
	$('.goods-sku-list tbody tr').each(function(){
		var obj = $(this);
		var sku_id = obj.attr('skuid'); 
		
		if(sku_str != ""){
			sku_str +="§";
		}
		
		var sku_img = new Array();
		obj.find('.ant-upload-list-item').each(function(){
			sku_img.push($(this).attr('id'));
		})
		//体积
		var volume = 0;
		if(obj.find('[name="volume"]').length > 0){
			obj.find('[name="volume"]').val()
		}
		//重量
		var weight = 0;
		if(obj.find('[name="weight"]').length > 0){
			obj.find('[name="weight"]').val()
		}
		sku_str += sku_id +"¦"+obj.find('[name="sku_price"]').val()+"¦"+obj.find('[name="market_price"]').val()+"¦"+obj.find('[name="cost_price"]').val()+"¦"+obj.find('[name="stock_num"]').val()+"¦"+obj.find('[name="code"]').val()+"¦"+volume+"¦"+weight+"¦"+sku_img.toString();
	});
	return sku_str;
};

//规格重新排序
spec_sort = function(type){
	
	if(type == 'spec_name')spec_value_subsidiry(1);
	sku_table_generate();
};

var sku_table_obj = $('.goods-sku-list table');

sku_table_generate = function(){
	
	$(".spec-item").unbind().arrangeable();
	$(".spec-value-item").unbind().arrangeable();
	arr = sku_spec_list();
	var colspan = arr.length;
	colspan = colspan == 0 ? 1 : colspan;
	rowspan = colspan == 1 ? 1 : 2;
	//SKU表格头部
	var head_h = `<tr><th align="center" colspan="${colspan}" style = "min-width:100px;">商品规格</th>
					<th rowspan="${rowspan}" style = "min-width:120px;"><span>sku图片</span></th>
					<th rowspan="${rowspan}" style = "max-width:80px;"><span>销售价</span></th>
					<th rowspan="${rowspan}" style = "max-width:80px;"><span>市场价</span></th>
					<th rowspan="${rowspan}" style = "max-width:80px;"><span>成本价</span></th>
					<th rowspan="${rowspan}" style = "max-width:80px;"><span>库存</span></th>
					<?php if($goods_type == 'NsGoods'): ?>
					<th rowspan="${rowspan}" style = "max-width:80px;"><span>体积</span></th>
					<th rowspan="${rowspan}" style = "max-width:80px;"><span>重量</span></th>
					<?php endif; ?>
					<th rowspan="${rowspan}" style = "max-width:80px;"><span>编码</span></th>
				 </tr>`;
		if(colspan > 1){
			head_h += `<tr>`;
			for(ele of arr){
				head_h += `<th>${ele.spec_name}</th>`;
			}
			head_h +=`</tr>`;
		}
	
	sku_table_obj.children('thead').html(head_h);
	
	updateSpecObjData();
	arr = get_sku_arr();

	html = '';
	for(var ele of arr){
		html += '<tr skuid="'+ele.sku_id+'" title = "'+ele.sku_spec_name+'">';	
// 		html += '<td>'+ele.sku_spec_name+'</td>';
		//sku图片
		html += '<td>';
			html += '<div class="goods-info-img-upload" name="sku_imgs"></div>';
			html += '<div class="ant-upload ant-upload-select-picture-card upload-btn-common" sign="sku_img"><span class="ant-upload ant-upload-disabled"><i class="anticon anticon-plus"></i></span></div>';
		html += '</td>';
		//销售价格
		html += '<td>';
			html += '<input type="text" class="input-common middle js-price" maxlength="10" name="sku_price" value="0.00"  />';
			html += '<span class="help-inline" >销售价最小为 0.01</span>';
		html += '</td>';
		
		//市场价格
		html += '<td>';
			html += '<input type="text" class="input-common middle js-market-price" maxlength="10" name="market_price" value="0.00"/>';
			html += '<span class="help-inline" >市场价最小为 0.01</span>';
		html += '</td>';
		
		//成本价格
		html += '<td>';
			html += '<input type="text" class="input-common middle js-cost-price" maxlength="10" name="cost_price" value="0.00"/>';
			html += '<span class="help-inline" >成本价最小为 0.01</span>';
		html += '</td>';
		
		//库存
		html += '<td>';
			html += '<input type="text" class="input-common middle js-stock-num" maxlength="9" name="stock_num" value="0" onkeyup="inputKeyUpNumberValue(this);" onafterpaste="inputAfterPasteNumberValue(this);"/>';
			html += '<span class="help-inline" >库存不能为空</span>';
		html += '</td>';
		<?php if($goods_type == 'NsGoods'): ?>
		//体积
		html += '<td>';
			html += '<input type="text" class="input-common middle js-volume" maxlength="9" name="volume" value="0" onkeyup="inputKeyUpNumberValue(this);"/>';
			html += '<span class="help-inline">体积不能为空</span>';
		html += '</td>';

		//重量
		html += '<td>';
			html += '<input type="text" class="input-common middle js-weight" maxlength="9" name="weight" value="0" onkeyup="inputKeyUpNumberValue(this);"/>';
			html += '<span class="help-inline">重量不能为空</span>';
		html += '</td>';
        <?php endif; ?>
		//商品编码
		html += '<td><input type="text" class="input-common middle js-code" name="code" value=""/></td>';
		
		html += '</tr>';
	}
	$('.goods-sku-list tbody').html(html);
	sku_table_left(arr.length);

};

sku_table_left = function(r_c){

	var html_arr = [];
	var arr = sku_spec_list();
	var c_n = 1;
	
	for(var x = arr.length-1; x >= 0 ; x--){
	
		for(var i = 0; i < r_c;){
			for(ele of arr[x]['value']){
				sku_table_obj.find('tbody tr:eq('+i+')').prepend('<td rowspan="'+c_n+'">'+ele.spec_value_name+'</td>');
				i = i + c_n;
			}
		}	
		c_n = c_n * arr[x]['value'].length;
	}

};

spec_name_rows = function(row){
	
	var rows_num = 1;
	$('.spec-item').each(function(i, value){
		
		if(i >= row){
			rows_num *= $(this).find('[name="spec_value"]').length;
		}
	});
	
	return rows_num;
};

$(function(){
	
	//添加规格项
	$('[name = "add_spec_item"]').click(function(){
		sku_spec_obj.append(spec_item());
		$('.spec-item').arrangeable();	
	});

	//那些属性点击时调用表格重新成功
	$('[sku-data-generate]').live('click', function(){
		
		updateSpecObjData();
		sku_table_generate();
	});
	$('[name="spec_value"],[name="spec_name"]').live('keyup', function(){
	
		if($(this).attr('name') == 'spec_value'){
			$(this).prev('span').text($(this).val());
		}

		sku_table_generate();
	});
	
	//添加规格附属值 如：图片、颜色
	$('[name="spec_value_subsidiary"]').live('click', function(){
		obj = $(this);
		v = $(this).val();
		
		obj.parents('.spec-item').find('.spec-value-item').children('.value-item-affiliate').remove();
		if(v == 2){
			obj.parents('.spec-item').find('.spec-value-item').each(function(){
				$(this).prepend(`<div class ="value-item-affiliate upload-btn-common"> <div class ='affiliate_img'><img src="/template/admin/public/images/spec_value_item_affiliate.png" alt="" /></div></div>`);
			})
		}else if(v == 3){
			obj.parents('.spec-item').find('.spec-value-item').each(function(){
				$(this).prepend(`<div class ="value-item-affiliate"><input type="color" class="input-common-color" value="#000000"></div>`);
			})
		}
	});

	//编辑页初始化数据
	if(goods_spec_format != ''){
		goods_spec_arr = JSON.parse(goods_spec_format);
		
		//选择规格类型 单规格|多规格
		if(goods_spec_arr.length > 0){
			 
			$("input[name='sku_type']").trigger('change'); 
		}
		//如果是多规格就加载规格
		for(ele of goods_spec_arr){
			
			spec_item_arr = ele;
			spec_item();
		}
		
		spec_item_arr = [];
		if(sku_list.length > 0){
			sku_table_generate();
			for(sku_item of sku_list){
				obj = $(`.goods-sku-list tbody tr[skuid = "${sku_item.attr_value_items}"]`);
			
				obj.find('[name="sku_price"]').val(sku_item['price']);
				obj.find('[name="market_price"]').val(sku_item['market_price']);
				obj.find('[name="cost_price"]').val(sku_item['cost_price']);
				obj.find('[name="stock_num"]').val(sku_item['stock']);
				obj.find('[name="code"]').val(sku_item['code']);
				obj.find('[name="volume"]').val(sku_item['volume']);
				obj.find('[name="weight"]').val(sku_item['weight']);
				
				for(picture_item of sku_item['picture_list']){
					var h = `<div class="ant-upload-list-item" id="${picture_item['pic_id']}">
							 	<a href="javascript:void(0)" class="ant-upload-list-item-thumbnail"><img src="${picture_item['pic_cover']}" ></a>
								<span><a href="javascript:;"><i title="图片预览" class="anticon anticon-eye-o" name = "img_click" img_src="${picture_item['pic_cover']}"></i></a>
								<a href="javascript:;"><i title="删除图片" class="anticon anticon-delete" name = "img_delete" del_class="ant-upload-list-item"></i></a></span>
							</div>`;
					obj.find('.goods-info-img-upload').append(h);
				}
			}
			eachInput();
			//修改商品时默认选中
// 			if($sku_goods_picture.length > 0 ){
// 				var default_spec_id = $sku_goods_picture[0]["spec_id"];
// 				$(".sku-picture-span[spec_id="+ default_spec_id +"]").click();
// 			}
		}
	}
	
})
</script>
		
		<dl class="sku_type_1">
			<dt>市场价格：</dt>
			<dd>
				<input class="goods_price input-common harf" type="number" id="txtProductMarketPrice" <?php if($goods_info): ?>value="<?php echo $goods_info['market_price']; ?>"<?php endif; ?> min="0" placeholder="0.00" 
				/><em class="unit">元</em>
				<span class="help-inline">商品市场价格必须是数字，且不能为负数</span>
			</dd>
		</dl>
		<dl class="sku_type_1">
			<dt><i class="required">*</i>销售价格：</dt>
			<dd>
				<input class="goods_price input-common harf" type="number" id="txtProductSalePrice" <?php if($goods_info): ?>value="<?php echo $goods_info['price']; ?>"<?php else: ?> value = "0.00"<?php endif; ?> min="0" placeholder="0.00" 
				/><em class="unit">元</em>
				<span class="help-inline">商品销售价不能为空，且不能为负数（计算利润用）</span>
			</dd>
		</dl>
		<dl class="sku_type_1">
			<dt><i class="required">*</i>成本价格：</dt>
			<dd>
				<input class="goods_price input-common harf" type="number" id="txtProductCostPrice" <?php if($goods_info): ?>value="<?php echo $goods_info['cost_price']; ?>"<?php endif; ?> min="0" placeholder="0.00" 
				/><em class="unit">元</em>
				<span class="help-inline">商品成本价不能为空，且不能为负数</span>
			</dd>
		</dl>
		
		<dl>
			<dt><i class="required">*</i>运费：</dt>
			<dd>
				<div class="controls">
				
					<?php if($goods_info): if($goods_info['shipping_fee'] == 0): ?>
							<label class="radio inline normal">
								<i class="radio-common selected">
									<input type="radio" name="fare" value="0" checked="checked" />
								</i>
								<span>免邮</span>
							</label>
							<label class="radio inline normal">
								<i class="radio-common">
									<input type="radio" name="fare" value="1">
								</i>
								<span>买家承担运费</span>
							</label>
						<?php else: ?>
							<label class="radio inline normal">
								<i class="radio-common">
									<input type="radio" name="fare" value="0" >
								</i>
								<span>免邮</span>
							</label>
							<label class="radio inline normal">
								<i class="radio-common selected">
									<input type="radio" name="fare" value="1" checked="checked" />
								</i>
								<span>买家承担运费</span>
							</label>
						<?php endif; else: ?>
						<label class="radio inline normal">
							<i class="radio-common selected">
								<input type="radio" name="fare" value="0" checked="checked" />
							</i>
							<span>免邮</span>
						</label>
						<label class="radio inline normal">
							<i class="radio-common">
								<input type="radio" name="fare" value="1" />
							</i>
							<span>买家承担运费</span>
						</label>
					<?php endif; ?>
					<span class="help-inline">请选择运费类型</span>
				</div>
			</dd>
		</dl>
		
		<?php if($goods_info): if($goods_info['shipping_fee']  == 0): ?>
			<dl id="valuation-method" style=" display:none;">
				<dt><i class="required">*</i>计价方式：</dt>
				<dd>
					<label class="radio inline normal">
						<i class="radio-common selected">
							<input type="radio" name="shipping_fee_type" value="3" checked="checked" />
						</i>
						<span>计件</span>
					</label>
					<label class="radio inline normal">
						<i class="radio-common">
							<input type="radio" name="shipping_fee_type" value="2" />
						</i>
						<span>体积</span>
					</label>
					<label class="radio inline normal">
						<i class="radio-common">
							<input type="radio" name="shipping_fee_type" value="1" />
						</i>
						<span>重量</span>
					</label>
				</dd>
			</dl>
			<dl id="commodity-weight" style=" display:none;">
				<dt><i class="required">*</i>商品重量：</dt>
				<dd>
					<input type="number" class="goods-stock input-common" id="goods_weight" min="0" value="0" 
					/><em class="unit">公斤</em>
					<span class="help-inline">商品重量不能为空</span>
				</dd>
			</dl>
			<dl id="commodity-volume" style=" display:none;">
				<dt><i class="required">*</i>商品体积：</dt>
				<dd>
					<input type="number" class="goods-stock input-common" id="goods_volume" min="0" value="0" 
					/><em class="unit">立方米</em>
					<span class="help-inline">商品体积不能为空</span>
				</dd>
			</dl>
			<dl id="express_Company" style="display: none;">
				<dt>物流公司：</dt>
				<dd>
					<select id="expressCompany" class="select-common">
						<option value="0">请选择物流公司</option>
						<?php if(is_array($expressCompanyList) || $expressCompanyList instanceof \think\Collection || $expressCompanyList instanceof \think\Paginator): if( count($expressCompanyList)==0 ) : echo "" ;else: foreach($expressCompanyList as $key=>$vo): ?>
						<option value="<?php echo $vo['co_id']; ?>"><?php echo $vo['company_name']; ?></option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</dd>
			</dl>
			<?php else: ?>
			
			<dl id="valuation-method">
				<dt><i class="required">*</i>计价方式：</dt>
				<dd>
					<?php if($goods_info['shipping_fee_type'] == 3): ?>
					<label class="radio inline normal">
						<i class="radio-common selected">
							<input type="radio" name="shipping_fee_type" value="3" checked="checked" />
						</i>
						<span>计件</span>
					</label>
					<label class="radio inline normal">
						<i class="radio-common">
							<input type="radio" name="shipping_fee_type" value="2" />
						</i>
						<span>体积</span>
					</label>
					<label class="radio inline normal">
						<i class="radio-common">
							<input type="radio" name="shipping_fee_type" value="1" />
						</i>
						<span>重量</span>
					</label>
					<?php elseif($goods_info['shipping_fee_type'] == 2): ?>
					<label class="radio inline normal">
						<i class="radio-common">
							<input type="radio" name="shipping_fee_type" value="3" />
						</i>
						<span>计件</span>
					</label>
					<label class="radio inline normal">
						<i class="radio-common selected">
							<input type="radio" name="shipping_fee_type" value="2" checked="checked" />
						</i>
						<span>体积</span>
					</label>
					<label class="radio inline normal">
						<i class="radio-common">
							<input type="radio" name="shipping_fee_type" value="1" />
						</i>
						<span>重量</span>
					</label>
					<?php else: ?>
					<label class="radio inline normal">
						<i class="radio-common">
							<input type="radio" name="shipping_fee_type" value="3" />
						</i>
						<span>计件</span>
					</label>
					<label class="radio inline normal">
						<i class="radio-common">
							<input type="radio" name="shipping_fee_type" value="2" />
						</i>
						<span>体积</span>
					</label>
					<label class="radio inline normal">
						<i class="radio-common selected">
							<input type="radio" name="shipping_fee_type" value="1" checked="checked" />
						</i>
						<span>重量</span>
					</label>
					<?php endif; ?>
				</dd>
			</dl>
			
			<dl id="commodity-weight">
				<dt><i class="required">*</i>商品重量：</dt>
				<dd>
					<input type="number" class="goods-stock input-common" id="goods_weight" min="0" value="<?php echo $goods_info['goods_weight']; ?>" 
					/><em class="unit">公斤</em>
					<span class="help-inline">商品重量必须大于0</span>
				</dd>
			</dl>
			
			<dl id="commodity-volume">
				<dt><i class="required">*</i>商品体积：</dt>
				<dd>
					<input type="number" class="goods-stock input-common" id="goods_volume" min="0" value="<?php echo $goods_info['goods_volume']; ?>" 
					/><em class="unit">立方米</em>
					<span class="help-inline">商品体积必须大于0</span>
				</dd>
			</dl>
			<dl id="express_Company">
				<dt>物流公司：</dt>
				<dd>
					<select id="expressCompany" class="select-common">
						<option value="0">请选择物流公司</option>
						<?php if(is_array($expressCompanyList) || $expressCompanyList instanceof \think\Collection || $expressCompanyList instanceof \think\Paginator): if( count($expressCompanyList)==0 ) : echo "" ;else: foreach($expressCompanyList as $key=>$vo): ?>
						<option value="<?php echo $vo['co_id']; ?>" <?php if($goods_info['shipping_fee_id'] == $vo['co_id']): ?>selected<?php endif; ?>><?php echo $vo['company_name']; ?></option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</dd>
			</dl>
			<?php endif; else: ?>
		<dl id="valuation-method" style="display: none">
			<dt><i class="required">*</i>计价方式：</dt>
			<dd>
				<label class="radio inline normal">
					<i class="radio-common selected">
						<input type="radio" name="shipping_fee_type" value="3" checked="checked" />
					</i>
					<span>计件</span>
				</label>
				<label class="radio inline normal">
					<i class="radio-common">
						<input type="radio" name="shipping_fee_type" value="2" />
					</i>
					<span>体积</span>
				</label>
				<label class="radio inline normal">
					<i class="radio-common">
						<input type="radio" name="shipping_fee_type" value="1" />
					</i>
					<span>重量</span>
				</label>
			</dd>
		</dl>
		<dl id="commodity-weight" style="display: none">
			<dt><i class="required">*</i>商品重量：</dt>
			<dd>
				<input type="number" class="goods-stock input-common harf" id="goods_weight" min="0" value="0" 
				/><em class="unit">公斤</em>
				<span class="help-inline">商品重量必须大于0</span>
			</dd>
		</dl>
		<dl id="commodity-volume" style="display: none">
			<dt><i class="required">*</i>商品体积：</dt>
			<dd>
				<input type="number" class="goods-stock input-common harf" id="goods_volume" min="0" value="0" 
				/><em class="unit">立方米</em>
				<span class="help-inline">商品体积必须大于0</span>
			</dd>
		</dl>
		<dl id="express_Company" style="display: none;">
			<dt>物流公司：</dt>
			<dd>
				<select id="expressCompany" class="select-common">
					<option value="0">请选择物流公司</option>
					<?php if(is_array($expressCompanyList) || $expressCompanyList instanceof \think\Collection || $expressCompanyList instanceof \think\Paginator): if( count($expressCompanyList)==0 ) : echo "" ;else: foreach($expressCompanyList as $key=>$vo): ?>
					<option value="<?php echo $vo['co_id']; ?>"><?php echo $vo['company_name']; ?></option>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
			</dd>
		</dl>
		<?php endif; ?>
		
		<dl>
			<dt>每人限购：</dt>
			<dd>
				<div class="controls">
					<input type="number" class="input-mini input-common harf" min="0" placeholder="0" id="PurchaseSum" <?php if($goods_info): ?>value="<?php echo $goods_info['max_buy']; ?>"<?php endif; ?> 
					/><em class="unit">件</em>
					<p class="hint notice" >输入0表示不限购</p>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>最少购买数：</dt>
			<dd>
				<div class="controls">
					<input type="number" class="input-mini input-common harf" min="1" placeholder="0" id="minBuy" <?php if($goods_info): ?>value="<?php echo $goods_info['min_buy']; ?>"<?php endif; ?>
					/><em class="unit">件</em>
					<span class="help-inline">最少购买数必须是大于0的整数</span>
				</div>
			</dd>
		</dl>
		
	</div>

	<!-- start 预售设置 start -->
	<div class="block-presell-setting goods-block-hide">
		<div id="presell_set" <?php if(empty($is_presell)): ?> style="display:none" <?php endif; ?>>
			<?php if($is_presell == 1): ?>
<h4 class="h4-title"><span></span>预售设置</h4>
<dl>
	<dt>是否支持预售：</dt>
	<dd>
		<label class="radio inline normal">
			<i class="radio-common <?php if($goods_info['is_open_presell'] == 1): ?>selected<?php endif; ?>"><input type="radio" name="open_presell"  value="1" <?php if($goods_info['is_open_presell'] == 1): ?>checked="checked"<?php endif; ?>></i>
			<span>是</span>
		</label>
		<label class="radio inline normal">
			<i class="radio-common <?php if($goods_info['is_open_presell'] == 0): ?>selected<?php endif; ?>">
				<input type="radio" name="open_presell" value="0" <?php if($goods_info['is_open_presell'] == 0): ?>checked="checked"<?php endif; ?>>
			</i>
			<span>否</span>
		</label>
	</dd>
	
</dl>
<?php else: ?>
<dl class="presell hide">
	<dt>是否支持预售：</dt>
	<dd>
		<label class="radio inline normal">
			<i class="radio-common <?php if($goods_info['is_open_presell'] == 1): ?>selected<?php endif; ?>"><input type="radio" name="open_presell"  value="1" <?php if($goods_info['is_open_presell'] == 1): ?>checked="checked"<?php endif; ?>></i>
			<span>是</span>
		</label>
		<label class="radio inline normal">
			<i class="radio-common <?php if($goods_info['is_open_presell'] == 0): ?>selected<?php endif; ?>">
				<input type="radio" name="open_presell" value="0" <?php if($goods_info['is_open_presell'] == 0): ?>checked="checked"<?php endif; ?>>
			</i>
			<span>否</span>
		</label>
	</dd>
	
</dl>
<?php endif; ?>
<dl class="presell hide">
	<dt>预售金额：</dt>
	<dd>
		<input class="goods_price input-common harf" type="number" id="presell_price" min="0" placeholder="0.00" value="<?php echo $goods_info['presell_price']; ?>"><em class="add-on">元</em>
		<span class="help-inline">预售金额必须是数字，且不能为负数</span>
	</dd>
	
</dl>
<dl class="presell hide">
	<dt>预售发货方式：</dt>
	<dd>
		<label class="radio inline normal">
			<i class="radio-common <?php if($goods_info['presell_delivery_type'] == 1): ?>selected<?php endif; ?>"><input type="radio" name="presell_delivery_type"  value="1" <?php if($goods_info['presell_delivery_type'] == 1): ?>checked="checked"<?php endif; ?>></i>
			<span>按照预售发货时间</span>
		</label>
		<label class="radio inline normal">
			<i class="radio-common <?php if($goods_info['presell_delivery_type'] == 2 || $goods_info['presell_delivery_type'] == '' || $goods_info['presell_delivery_type'] == 0): ?>selected<?php endif; ?>">
				<input type="radio" name="presell_delivery_type" value="2" <?php if($goods_info['presell_delivery_type'] == 2): ?>checked="checked"<?php endif; ?>>
			</i>
			<span>按照预售发货天数</span>
		</label>
	</dd>
	
</dl>
<dl class="presell hide">
	<dt>预售发货时间：</dt>
	<dd>
		<input type="text" class="input-common" id="presell_time" value="<?php echo $goods_info['presell_time']; ?>" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss',minDate: '%y-%M-#{%d+1}' })">&nbsp;开始发货
	</dd>
</dl>
<dl class="presell hide">
	<dt>预售发货时间：</dt>
	<dd>
		付款成功&nbsp;<input type="number" value="<?php echo $goods_info['presell_day']; ?>" class="span1 input-common short" id="presell_day" placeholder="0">&nbsp;天后发货
	</dd>
</dl>
		</div>
	</div>
	<!-- end 预售设置 end -->

	<!-- start 积分设置 start -->
	<div class="block-point-setting goods-block-hide">
		<h4 class="h4-title"><span></span>积分设置</h4>
		<dl id="integral_balance">
			<dt>最大可使用积分：</dt>
			<dd>
				<input type="number" class="input-common harf" id="max_use_point" value="<?php echo $goods_info['max_use_point']; ?>" onchange="integrationChange(this);"
				/><em class="unit">分</em>
				<p class="hint">设置购买时积分抵现最大可使用积分数，0为不可使用 </span></p>
			</dd>
		</dl>
		<dl>
			<dt>积分兑换设置：</dt>
			<dd>
				<label class="radio inline normal">
					<i class="radio-common <?php if($goods_info['point_exchange_type'] == 0): ?>selected<?php endif; ?>">
						<input type="radio" name="integralSelect" <?php if($goods_info['point_exchange_type'] == 0): ?>checked<?php endif; ?> value="0">
					</i>
					<span>非积分兑换</span>
				</label>
				<label class="radio inline normal">
					<i class="radio-common <?php if($goods_info['point_exchange_type'] == 1): ?>selected<?php endif; ?>">
						<input type="radio" name="integralSelect" <?php if($goods_info['point_exchange_type'] == 1): ?>checked<?php endif; ?> value="1">
					</i>
					<span>积分加现金购买</span>
				</label>
				<label class="radio inline normal">
					<i class="radio-common <?php if($goods_info['point_exchange_type'] == 2): ?>selected<?php endif; ?>">
						<input type="radio" name="integralSelect" <?php if($goods_info['point_exchange_type'] == 2): ?>checked<?php endif; ?> value="2">
					</i>
					<span>积分兑换或直接购买</span>
				</label>
				<label class="radio inline normal">
					<i class="radio-common <?php if($goods_info['point_exchange_type'] == 3): ?>selected<?php endif; ?>">
						<input type="radio" name="integralSelect" <?php if($goods_info['point_exchange_type'] == 3): ?>checked<?php endif; ?> value="3">
					</i>
					<span>只支持积分兑换</span>
				</label>
			</dd>
		</dl>
		<dl>
			<dt>兑换所需积分：</dt>
			<dd>
				<input type="number" class="input-common harf" id="integration_available_use" value="<?php if($goods_info['point_exchange']): ?><?php echo $goods_info['point_exchange']; else: ?>0<?php endif; ?>" onchange="integrationChange(this);"
				/><em class="unit">分</em>
				<span class="help-inline">请设置积分</span>
			</dd>
		</dl>
		<dl>
			<dt>购买赠送积分：</dt>
			<dd>
				<label class="radio inline normal">
					<i class="radio-common <?php if($goods_info['integral_give_type'] == 0): ?>selected<?php endif; ?>">
						<input type="radio" name="integral_give_type" <?php if($goods_info['integral_give_type'] == 0): ?>checked<?php endif; ?> value="0">
					</i>
					<span>赠送固定积分</span>
				</label>
				<label class="radio inline normal">
					<i class="radio-common <?php if($goods_info['integral_give_type'] == 1): ?>selected<?php endif; ?>">
						<input type="radio" name="integral_give_type" <?php if($goods_info['integral_give_type'] == 1): ?>checked<?php endif; ?> value="1">
					</i>
					<span>按比率赠送积分</span>
				</label>
			</dd>
		</dl>
		<dl>
			<dt></dt>
			<dd>
				<div class="controls" <?php if($goods_info['integral_give_type'] != 0): ?>style="display: none;"<?php endif; ?>>
					<input id="integration_available_give" class="input-mini input-common harf" placeholder="0" min="0" type="number" onchange="integrationChange(this);" value="<?php if($goods_info && $goods_info['integral_give_type'] == 0): ?><?php echo $goods_info['give_point']; else: ?>0<?php endif; ?>" 
					/><em class="unit">分</em>
					<span class="help-inline">请设置积分</span>
				</div>
				<div class="controls" <?php if($goods_info['integral_give_type'] != 1): ?>style="display: none;"<?php endif; ?>>
					<input id="integration_available_give_ratio" class="input-mini input-common harf" placeholder="0" min="0" max="100" type="number" onchange="integrationChange(this);" value="<?php if($goods_info && $goods_info['integral_give_type'] == 1): ?><?php echo $goods_info['give_point']; else: ?>0<?php endif; ?>" 
					/><em class="unit">%</em>
					<span class="help-inline">请设置积分</span>
				</div>
			</dd>
		</dl>
	</div>
	<!-- end 积分设置 end -->

	<!-- start 折扣设置 start -->
	<div class="block-discount-setting goods-block-hide">
		<?php if(!(empty($level_list) || (($level_list instanceof \think\Collection || $level_list instanceof \think\Paginator ) && $level_list->isEmpty()))): ?>
			<h4 class="h4-title"><span></span>折扣设置</h4>
			<?php if(is_array($level_list) || $level_list instanceof \think\Collection || $level_list instanceof \think\Paginator): if( count($level_list)==0 ) : echo "" ;else: foreach($level_list as $key=>$vo): ?>
				<dl>
					<dt><?php echo $vo['level_name']; ?>：</dt>
					<dd>
						<div class="controls">
							<input class="input-common harf" name="member_discount" placeholder="0" min="0" type="number" value="<?php echo $vo['discount']; ?>" data-level-id="<?php echo $vo['level_id']; ?>"/><em class="unit">%</em>
						</div>
					</dd>
				</dl>
			<?php endforeach; endif; else: echo "" ;endif; ?>
			<dl>
				<dt>价格保留方式：</dt>
				<dd>
					<label class="radio inline normal decimal_reservation_number">
						<i class="radio-common <?php if($level_list[0]['decimal_reservation_number'] == 0): ?>selected<?php endif; ?>">
							<input type="radio" name="decimal-reservation-number" value="0" <?php if($level_list[0]['decimal_reservation_number'] == 0): ?>checked<?php endif; ?>>
						</i>
						<span>抹去角和分</span>
					</label>
					<label class="radio inline normal decimal_reservation_number">
						<i class="radio-common <?php if($level_list[0]['decimal_reservation_number'] == 1): ?>selected<?php endif; ?>">
							<input type="radio" name="decimal-reservation-number" value="1" <?php if($level_list[0]['decimal_reservation_number'] == 1): ?>checked<?php endif; ?>>
						</i>
						<span>抹去分</span>
					</label>
				</dd>
			</dl>
		<?php endif; ?>
	</div>
	<!-- end 折扣设置 end -->

	<div class="block-goods-type goods-block-hide">
		
		<h4 class="h4-title"><span></span>基础信息</h4>
		
		<dl>
			<dt>商品类型：</dt>
			<dd>
				<select id="goods_attribute_id" class="select-common">
					<option value="0">请选择商品类型</option>
					<?php if(is_array($goods_attribute_list) || $goods_attribute_list instanceof \think\Collection || $goods_attribute_list instanceof \think\Paginator): if( count($goods_attribute_list)==0 ) : echo "" ;else: foreach($goods_attribute_list as $key=>$attribute): if($goods_info): if($goods_info['goods_attribute_id'] == $attribute['attr_id']): ?>
						<option value="<?php echo $attribute['attr_id']; ?>" selected="selected"><?php echo $attribute['attr_name']; ?></option>
						<?php else: ?>
						<option value="<?php echo $attribute['attr_id']; ?>"><?php echo $attribute['attr_name']; ?></option>
						<?php endif; else: if($goods_attr_id == $attribute['attr_id']): ?>
						<option value="<?php echo $attribute['attr_id']; ?>" selected="selected"><?php echo $attribute['attr_name']; ?></option>
						<?php else: ?>
						<option value="<?php echo $attribute['attr_id']; ?>"><?php echo $attribute['attr_name']; ?></option>
						<?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
				</select>
				<span class="help-inline">请选择商品类型</span>
			</dd>
		</dl>
		
		<h4 class="h4-title hide js-goods-attribute-block" ><span></span>商品属性：</h4>
		<div class="goods-sku-attribute-block js-goods-attribute-block">
			<table class="goods-sku-attribute js-goods-sku-attribute"></table>
		</div>
	</div>
	
	<!-- 图片视频设置 -->
	<div class="block-photo-video-setting goods-block-hide">
		
		<div class="goods-photos">
			<h4 class="h4-title"><span></span>商品图片</h4>
			<dl>
				<dt>图片上传：</dt>
				<dd>
<!-- 			（第一张图片将作为商品主图，支持同时上传多张图片,多张图片之间可随意调整位置；支持jpg、gif、png格式上传或从图片空间中选择，建议使用尺寸800x800像素以上、大小不超过1M的正方形图片，上传后的图片将会自动保存在图片空间的默认分类中。） -->
					
					<div id="goods_picture_box" class="controls">
						<div class="goodspic-uplaod">
							<div class='img-box' style="min-height:160px;">
								<?php if($goods_info): if(count($goods_info['img_temp_array']) > 0): foreach($goods_info["img_temp_array"]  as $vo): ?>
											<div class="upload-thumb draggable-element">
												<img src="<?php echo __IMG($vo['pic_cover']); ?>" />
												<input type="hidden" class="upload_img_id" value="<?php echo $vo['pic_id']; ?>" />
												<div class="black-bg hide">
													<div class="off-box">&times;</div>
												</div>
											</div>
										<?php endforeach; else: ?>
										<div class="upload-thumb" id="default_uploadimg">
											<img src="/template/admin/public/images/album/default_goods_image_240.gif" />
										</div>
									<?php endif; else: ?>
								<div class="upload-thumb" id="default_uploadimg">
									<img src="/template/admin/public/images/album/default_goods_image_240.gif">
								</div>
								<?php endif; ?>
							</div>
							<div class="clear"></div>
							<span class="img-error">最少需要一张图片作为商品主图</span>
							<p class="hint">第一张图片将作为商品主图,支持同时上传多张图片,多张图片之间可随意调整位置；支持jpg、gif、png格式上传或从图片空间中选择，建议使用尺寸800x800像素以上、大小不超过1M的正方形图片，上传后的图片将会自动保存在图片空间的默认分类中。</p>
							<div class="handle" style="margin-top: 5px;">
								<div class="ncsc-upload-btn" style="margin-left:0;">
									<a href="javascript:void(0);">
										<span>
											<input style="cursor:pointer;font-size:0;" type="file" id="fileupload" hidefocus="true" class="input-file" name="file_upload"multiple="multiple" />
										</span>
										<p>图片上传</p>
									</a>
								</div>
								<a class="ncsc-btn mt5" id="img_box" nctype="show_image" href="javascript:void(0);">从图片空间选择</a>
							</div>
						</div>
					</div>
					<span class="help-inline">最少需要一张图片作为商品主图</span>
				</dd>
			</dl>
		</div>
		
		<div class="goods-video">
			<h4 class="h4-title"><span></span>展示视频</h4>
			<dl>
				<dt>视频上传：</dt>
				<dd style="padding:0;">
					<div class="goodspic-uplaod" style="overflow: hidden;position:relative;">
				
						<div class="video-thumb">
							<?php if($goods_info): ?>
								<video id="my-video" class="video-js vjs-big-play-centered" controls 
									<?php if(empty($goods_info['goods_video_address'])): ?> poster="/public/static/blue/img/goods_video_upload_bg.png" <?php else: ?> poster="" <?php endif; ?>
									 src="<?php echo __IMG($goods_info['goods_video_address']); ?>">
									<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that</p>
								</video>
								<span class="del-video <?php if(empty($goods_info['goods_video_address'])): ?> hide <?php endif; ?>" onclick="del_video(this)"></span>
							<?php else: ?>
								<video id="my-video" class="video-js vjs-big-play-centered" controls poster="/public/static/blue/img/goods_video_upload_bg.png" preload="auto">
									<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that</p>
								</video>
								<span class="del-video hide" onclick="del_video()"></span>
							<?php endif; ?>
						</div>
						<input class="input-file" name="file_upload" id="videoupload" type="file" onchange="fileUpload_video(this);" title="视频上传" style="position: absolute;left: 0;width: 290px;height: 140px;opacity: 0;cursor: pointer;z-index:10;" />
					</div>
				</dd>
			</dl>
			
			<dl>
				<dt>输入网址：</dt>
				<dd>
					<input type="text" id="video_url" class="input-common" style="width: 290px !important;" placeholder="在此输入外链视频地址" <?php if($goods_info): ?>value="<?php echo $goods_info['goods_video_address']; ?>"<?php endif; ?> />
					<span style="display: block;margin-top: 5px;">注意事项：</span>
					<ul style="color:#FF6600;">
						<li>1、检查upload文件夹是否有读写权限。</li>
						<li>2、PHP默认上传限制为2MB，需要在php.ini配置文件中修改“post_max_size”和“upload_max_filesize”的大小。</li>
						<li>3、视频支持手动输入外链视频地址或者上传本地视频文件</li>
						<li>4、必须上传.mp4视频格式</li>
						<li>5、视频文件大小不能超过500MB</li>
					</ul>
				</dd>
			</dl>
		</div>
		
		<style>
.upload-thumb{display:block !important;float:left;width:147px !important;height:147px !important;position:relative;border:1px solid #e5e5e5;}
.upload-thumb img{width:100%;height:100%;}
.img-box, .sku-img-box{overflow:hidden;}
.off-box, .sku-off-box{position:absolute;width:18px;height:18px;right:0;top:0;line-height: 18px;background-color:#FFF;cursor:pointer;text-align: center;}
.black-bg{position:absolute;right:0;top:0;left:0;bottom:0;background-color:rgba(0,0,0,0.3);}
.img-error{color:red;height:25px;line-height:25px;display:none;}
</style>
<script src="/public/static/js/ajax_file_upload.js" type="text/javascript"></script>
<script type="text/javascript" src="/public/static/js/jquery.ui.widget.js" charset="utf-8"></script>
<script type="text/javascript" src="/public/static/js/jquery.fileupload.js" charset="utf-8"></script>
<input type="hidden" id="album_id" value="<?php echo $detault_album_id; ?>"/>
<script type="text/javascript">
var dataAlbum;
$(function() {
	//给图片更换位置事件
	$('.draggable-element').arrangeable();
	
	var album_id = $("#album_id").val();
	dataAlbum = {
		"album_id" : album_id,
		"thumb_type" : "big,mid,small,thumb",
		'file_path' : "goods"
	};
	
	// ajax 上传图片
	var upload_num = 0; // 上传图片成功数量
	$('#fileupload').fileupload({
		url: "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/imagetoalbum'); ?>",
		dataType: 'json',
		formData:dataAlbum,
		add: function (e,data) {
			$("#goods_picture_box .img-error").hide();
			$("#goods_picture_box #default_uploadimg").remove();
			//显示上传图片框
			var html = "";
			$.each(data.files, function (index, file) {
				html +='<div class="upload-thumb draggable-element"  nstype="' + file.name + '">';
					html +='<img nstype="goods_image" src="/template/admin/public/images/album/uoload_ing.gif">';
					html +='<input type="hidden" class="upload_img_id" nstype="goods_image" />';
					html +='<div class="black-bg hide">';
					html +='<div class="off-box">&times;</div>';
					html +='</div>';
				html +='</div>';
			});
			$(html).appendTo('#goods_picture_box .img-box');
			//模块可拖动事件
			$('#goods_picture_box .draggable-element').arrangeable();
			data.submit();
		},
		done: function (e,data) {
			var param = data.result;
			$this = $('#goods_picture_box div[nstype="' + param.data.file_name + "." + param.data.file_ext + '"]');
			if(param.code > 0){
				$this.removeAttr("nstype");
				$this.children("img").attr("src",__IMG(param.data.path));
				$this.children("input[type='hidden']").val(param.data.pic_id);
			}else{
				$this.remove();
				if($("#goods_picture_box .img-box .upload-thumb").length == 0){
					var img_html ='<div class="upload-thumb" id="default_uploadimg">';
					img_html +='<img src="/template/admin/public/images/album/default_goods_image_240.gif">';
					img_html +='</div>';
					$("#goods_picture_box .img-box").append(img_html);
				}
				$("#goods_picture_box .img-error").html("请检查您的上传参数配置或上传的文件是否有误，<a href='<?php echo __URL('http://127.0.0.1:8080/index.php/admin/config/uploadtype'); ?>' target='_blank' style='text-decoration: underline;'>去设置</a>").show();
			}
		}
	});

	//图片幕布出现
	$(".draggable-element").live('mouseenter',function(){
		$(this).children(".black-bg").show();
	});

	//图片幕布消失
	$(".draggable-element").live('mouseleave',function(){
		$(this).children(".black-bg").hide();
	});

	//sku图片幕布出现
	$(".sku-draggable-element").live('mouseenter',function(){
		$(this).children(".black-bg").show();
	});

	//sku图片幕布消失
	$(".sku-draggable-element").live('mouseleave',function(){
		$(this).children(".black-bg").hide();
	});

	//删除页面图片元素
	$(".off-box").live('click',function(){
		if($(".img-box .upload-thumb").length == 1){
			var html = "";
			html +='<div class="upload-thumb" id="default_uploadimg">';
			html +='<img nstype="goods_image" src="/template/admin/public/images/album/default_goods_image_240.gif">';
			html +='<input type="hidden" name="image_path" id="image_path" nstype="goods_image" value="">';
			html +='</div>';
			$(html).appendTo('.img-box');
		}
		$(this).parent().parent().remove();
	});
	
	$(".sku-off-box").live('click',function(){
		if($(this).parent().parent().parent().find(".sku-img-box .upload-thumb").length == 1){
			var html = "";
			html +='<div class="upload-thumb" id="default_uploadimg">';
			html +='<img nstype="goods_image" src="/template/admin/public/images/album/default_goods_image_240.gif">';
			html +='<input type="hidden" name="image_path" id="image_path" nstype="goods_image" value="">';
			html +='</div>';
			$(html).appendTo('.sku-img-box');
		}
		$(this).parent().parent().remove();
	});

});

//sku图片上传
function file_upload(obj){
	var spec_id = $(obj).attr("spec_id");
	var spec_value_id = $(obj).attr("spec_value_id");
	$('.sku-draggable-element'+spec_id+'-'+spec_value_id).arrangeable();
	//sku图片上传
	$(obj).fileupload({
		url: "<?php echo __URL('http://127.0.0.1:8080/index.php/wap/upload/photoalbumupload'); ?>",
		dataType: 'json',
		formData:dataAlbum,
		add: function (e,data) {
			var box_obj = $(this).parent().parent().parent().parent().parent().parent().parent().parent();
			var spec_id = box_obj.attr("spec_id");
			var spec_value_id = box_obj.attr("spec_value_id");
			box_obj.find(".img-error").hide();
			box_obj.find("#sku_default_uploadimg").remove();
			//显示上传图片框
			var html = "";
			$.each(data.files, function (index, file) {
				html +='<div class="upload-thumb sku-draggable-element'+ spec_id +'-'+ spec_value_id +' sku-draggable-element"  nstype="' + file.name + '">';
				html +='<img nstype="goods_image" src="/template/admin/public/images/album/uoload_ing.gif">';
				html +='<input type="hidden"  class="sku_upload_img_id" nstype="goods_image" spec_id="" spec_value_id="" value="">';
				html +='<div class="black-bg hide">';
				html +='<div class="sku-off-box">&times;</div>';
				html +='</div>';
				html +='</div>';
			});
			box_obj.find('.sku-img-box').append(html);
			//模块可拖动事件
			$('.sku-draggable-element'+spec_id+'-'+ spec_value_id ).arrangeable();
			data.submit();
		},
		done: function (e,data) {
			var box_obj = $(this).parent().parent().parent().parent().parent().parent().parent().parent();
			var spec_id = box_obj.attr("spec_id");
			var spec_value_id = box_obj.attr("spec_value_id");
			var param = data.result;
			$this = box_obj.find('div[nstype="' + param.origin_file_name + '"]');
			if(param.state > 0){
				$this.removeAttr("nstype");
				$this.children("img").attr("src",__IMG(param.file_name));
				$this.children("input[type='hidden']").val(param.file_id);
				$this.children("input[type='hidden']").attr("spec_id", spec_id);
				$this.children("input[type='hidden']").attr("spec_value_id", spec_value_id);
				//将上传的规格图片记录
				for(var i = 0; i < $sku_goods_picture.length ; i ++ ){
					if($sku_goods_picture[i].spec_id == spec_id && $sku_goods_picture[i].spec_value_id == spec_value_id){
						$sku_goods_picture[i]["sku_picture_query"].push({"pic_id":param.file_id, "pic_cover_mid":param.file_name});
					}
				}
			}else{
				$this.remove();
				if(box_obj.find(".upload-thumb").length == 0){
					var img_html ='<div class="upload-thumb" id="default_uploadimg">';
						img_html +='<img src="/template/admin/public/images/album/default_goods_image_240.gif">';
						img_html +='</div>';
						box_obj.find(".sku-img-box").append(img_html);
				}
				box_obj.find(".img-error").html("请检查您的上传参数配置或上传的文件是否有误，<a href='<?php echo __URL('http://127.0.0.1:8080/index.php/admin/config/uploadtype'); ?>' target='_blank' style='text-decoration: underline;'>去设置</a>").show();
			}
		}
	});
}
</script>
	</div>
	
	<!-- 详情设置 -->
	<div class="block-goods-detail-setting goods-block-hide">
	
		<div class="controls" id="discripContainer">
			<textarea id="tareaProductDiscrip" name="discripArea" style="height: 500px; width: 800px; display: none;"></textarea>
			<script id="editor" type="text/plain" style="width: 100%; height: 500px;"></script>
			<span class="help-inline">请填写商品描述</span>
		</div>
	</div>
	
	<div class="block-template-setting goods-block-hide">
	
		<!-- 模板设置 -->
		<h4 class="h4-title"><span></span>模板设置</h4>
		<dl>
			<dt>电脑端：</dt>
			<dd>
				<?php echo $template_url['pc_template_url']; ?>&nbsp;<input type="text" class="input-common harf" name="" id="pc_custom_template" value="<?php echo $goods_info['pc_custom_template']; ?>" style="width: 80px;" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')">&nbsp;.html
				<p class="hint">用户自定义模板必须存放在<?php echo $template_url['pc_template_url']; ?>下，模板名只能由英文组成，默认不填写</p>
			</dd>
		</dl>
		<dl>
			<dt>手机端：</dt>
			<dd>
				<?php echo $template_url['wap_template_url']; ?>&nbsp;<input type="text" class="input-common harf" name="" id="wap_custom_template" value="<?php echo $goods_info['wap_custom_template']; ?>" style="width: 80px;" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')">&nbsp;.html
				<p class="hint">用户自定义模板必须存放在<?php echo $template_url['wap_template_url']; ?>下，模板名只能由英文组成，默认不填写</p>
			</dd>
		</dl>
	</div>
	
	<div class="block-ladder-setting goods-block-hide">
		<dl>
				<dt>阶梯优惠：</dt>
				<dd>
					<p class="hint notice" >设置商品阶梯优惠，当购买数量达到所设数量时，商品单价 = 商品销售价 - 优惠价格</p>
					<div class="ladder_preference_content">
						<div>
							<span class="label-title">数量</span><span class="label-title" style="margin-left: 30px;">优惠价格</span>
						</div>
						<?php if(!(empty($ladder_preferential) || (($ladder_preferential instanceof \think\Collection || $ladder_preferential instanceof \think\Paginator ) && $ladder_preferential->isEmpty()))): if(is_array($ladder_preferential) || $ladder_preferential instanceof \think\Collection || $ladder_preferential instanceof \think\Paginator): if( count($ladder_preferential)==0 ) : echo "" ;else: foreach($ladder_preferential as $key=>$vo): ?>
							<div class="ladder_preference">
								<input type="number" class="input-common short ladder" value="<?php echo $vo['quantity']; ?>">
								<input type="number" class="input-common short preference" value="<?php echo $vo['price']; ?>">
								<a href="javascript:;" class="delete_preference">删除</a></div>
							<?php endforeach; endif; else: echo "" ;endif; endif; ?>
						<div id="ladder_preference"></div>
					</div>
					<div class="add_ladder_preference"><i class="fa fa-plus" aria-hidden="true"></i></div>
				</dd>
			</dl>
	</div>
	<div class="js-mask-category" style="position: fixed; width: 100%; height: 100%; top: 0px; left: 0px; right: 0px; bottom: 0px; z-index: 90; display: none; background: rgba(0, 0, 0, 0);"></div>
	
</div>

<div class="edit-sku-popup-mask-layer"></div>
<div class="edit-sku-popup">
	<header>
		<h3>选择规格</h3>
		<span>×</span>
	</header>
	<div class="edit-sku-popup-body">
		<aside>
			<p>选择规格 [单选]</p>
			<!-- 原始规格 -->
			<div class="original-sku">
				<div class="attribute">
				
				<?php if(is_array($goods_attribute_list) || $goods_attribute_list instanceof \think\Collection || $goods_attribute_list instanceof \think\Paginator): if( count($goods_attribute_list)==0 ) : echo "" ;else: foreach($goods_attribute_list as $key=>$attribute): ?>
					<div class="attribute-item" attr_id = "<?php echo $attribute['attr_id']; ?>">
						<p class="item-name"><?php echo $attribute['attr_name']; ?><span>▴</span></p>
						<ul class="original-sku-list">
							<?php if(is_array($goods_spec_list) || $goods_spec_list instanceof \think\Collection || $goods_spec_list instanceof \think\Paginator): $i = 0; $__LIST__ = $goods_spec_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods_spec): $mod = ($i % 2 );++$i;if(in_array(($goods_spec['spec_id']), is_array($attribute['spec_id_array'])?$attribute['spec_id_array']:explode(',',$attribute['spec_id_array']))): ?>
							<li title="<?php echo $goods_spec['spec_des']; ?>" data-spec-id="<?php echo $goods_spec['spec_id']; ?>" data-spec-value-json='<?php echo json_encode($goods_spec['values']); ?>' data-spec-name="<?php echo $goods_spec['spec_name']; ?>" data-show-type="<?php echo $goods_spec['show_type']; ?>" data-spec-value-length="<?php echo count($goods_spec['values']); ?>"><span><?php echo $goods_spec['spec_name']; ?></span><span style='display: none;'>[<?php echo count($goods_spec['values']); ?>]</span></li>
							<?php endif; endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</div>
				<?php endforeach; endif; else: echo "" ;endif; ?>
				
				<div class="attribute-item" attr_id = "0">
						<p class="item-name">其他<span>▴</span></p>
						<ul class="original-sku-list">
							<?php if(is_array($rests_goods_spec_list) || $rests_goods_spec_list instanceof \think\Collection || $rests_goods_spec_list instanceof \think\Paginator): $i = 0; $__LIST__ = $rests_goods_spec_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods_spec): $mod = ($i % 2 );++$i;?>
							<li title="<?php echo $goods_spec['spec_des']; ?>" data-spec-id="<?php echo $goods_spec['spec_id']; ?>" data-spec-value-json='<?php echo json_encode($goods_spec['values']); ?>' data-spec-name="<?php echo $goods_spec['spec_name']; ?>" data-show-type="<?php echo $goods_spec['show_type']; ?>" data-spec-value-length="<?php echo count($goods_spec['values']); ?>"><span><?php echo $goods_spec['spec_name']; ?></span><span style='display: none;'>[<?php echo count($goods_spec['values']); ?>]</span></li>
							<?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</div>
				</div>
			</div>
		</aside>
		<article>
			<p>选择规格值 [可多选]</p>
			<div class="sku-value">
				
				<p class="empty-info">请选择左侧规格列表</p>
				
				<div class="sku-value-list">
					<label>
						<i class="checkbox-common">
							<input class="margin-small-right" id="checkAll" type="checkbox">
						</i>
						<span>全选</span>
					</label>
					<div class="add-sku-value-input">
						<input type="text" class="input-common" placeholder="输入规格值名称(回车保存)" />
					</div>
					<ul></ul>
				</div>
				
			</div>
		</article>
	</div>
	
	<footer>
		<span class="box-spec-bottom">注意：改变规格会删除现有的有的商品规格数据，并生成新的规格数据。</span>
		<button class="btn-common btn-big btn-top" onclick="sku_popup_spec_generate()">确定</button>
		<button class="btn-common-cancle btn-big btn-bottom">取消</button>
	</footer>
</div>

<div class="point-card-inventory-management-popup">
	<div class="point-card-inventory-management-body">
	</div>
	<footer></footer>
</div>

<div style="height: 50px;" class="h50"></div>
<div class="btn-submit ncsc-form-goods" style="text-align: left;">
	<dl>
		<dt></dt>
		<dd style="padding: 0;">
			<button class="btn-common" id="btnSave" type="button" onClick="SubmitProductInfo(0,'http://127.0.0.1:8080/index.php/admin','http://127.0.0.1:8080/index.php')">保存</button>
			<button class="btn-common" id="btnSavePreview" type="button" onClick="SubmitProductInfo(1,'http://127.0.0.1:8080/index.php/admin','http://127.0.0.1:8080/index.php')">保存并预览</button>
		</dd>
	</dl>
</div>

<script type="text/javascript">
var ue = UE.getEditor('editor');
ue.ready(function() {
	ue.setContent('<?php echo $goods_info['description']; ?>', false);
});
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