<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:31:"template/admin\Index\index.html";i:1553737038;s:48:"D:\phpStudy\WWW\niushop\template\admin\base.html";i:1553915410;s:65:"D:\phpStudy\WWW\niushop\template\admin\controlCommonVariable.html";i:1552613506;s:52:"D:\phpStudy\WWW\niushop\template\admin\urlModel.html";i:1552613544;s:54:"D:\phpStudy\WWW\niushop\template\admin\pageCommon.html";i:1552613506;s:54:"D:\phpStudy\WWW\niushop\template\admin\openDialog.html";i:1552613504;}*/ ?>
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
	
<link rel="stylesheet" type="text/css" href="/template/admin/public/css/dashboard.css">
<link rel="stylesheet" type="text/css" href="/public/static/blue/css/ns_index.css">
<script src="/template/admin/public/js/highcharts.js"></script>
<script src="/template/admin/public/js/exporting.js"></script>
<script src="/template/admin/public/js/index.js"></script>
<script src="/template/admin/public/js/jquery.timers.js"></script>

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
		
		
<div class="ns-notice">
	<nav>
		<ul>
			<li>网站名称：<span><?php echo $title_name; ?></span></li>
			<li>当前版本：<span><?php echo $niu_version; ?></span></li>
			<li>最后登录时间：<span><?php echo getTimeStampTurnTime($user_info['last_login_time'] ); ?></span></li>
			<li>最后登录IP：<span><?php echo $user_info['last_login_ip']; ?></span></li>
<!-- 			<li class="nav" style="display:none;"> -->
<!-- 				<strong></strong> -->
<!-- 				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/admin'); ?>"><?php echo $title_name; ?></a> -->
<!-- 				<?php if($frist_menu['module_name'] != ''): ?> -->
<!-- 				<i class="fa fa-angle-right"></i> -->
<!-- 				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/admin/'.$frist_menu['url']); ?>"><?php echo $frist_menu['module_name']; ?></a> -->
<!-- 				<?php endif; ?> -->
<!-- 				<?php if($secend_menu['module_name'] != ''): ?> -->
<!-- 				<i class="fa fa-angle-right"></i> -->
<!-- 					需要加跳转链接用这个：http://127.0.0.1:8080/index.php/admin/<?php echo $secend_menu['url']; ?> -->
<!-- 					<a href="javascript:;"><?php echo $secend_menu['module_name']; ?></a> -->
<!-- 				<?php endif; ?> -->
<!-- 			</li> -->
		</ul>
	</nav>
</div>
<div style="height:40px;"></div>

		
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
			
			<div class="right-side-operation hide">
				<ul>
					
					
				</ul>
			</div>
		</div>
		
		<!-- 操作提示 -->
		
		
		<div class="ns-main">
			
<div class="statistical">
	<ul>
		<li>
			<div class="left">
				<img src="/public/static/blue/img/order_amount.png" />
			</div>
			<div class="right">
				<strong class="js-order-amount">0.00</strong>
				<p>今日订单总金额(元)</p>
			</div>
		</li>
		<li>
			<div class="left">
				<img src="/public/static/blue/img/focus_number.png" />
			</div>
			<div class="right">
				<strong class="js-weixin-fans-count">0</strong>
				<p>关注人数(个)</p>
			</div>
		</li>
		<li>
			<div class="left">
				<img src="/public/static/blue/img/goods_release.png" />
			</div>
			<div class="right">
				<strong class="js-goods-release-count">0</strong>
				<p>商品发布(个)</p>
			</div>
		</li>
		<li>
			<div class="left">
				<img src="/public/static/blue/img/order_total.png" />
			</div>
			<div class="right">
				<strong class="js-order-total">0</strong>
				<p>订单总数(笔)</p>
			</div>
		</li>
		<li>
			<div class="left">
				<img src="/public/static/blue/img/month_sales.png" />
			</div>
			<div class="right">
				<strong class="js-month-sales">0</strong>
				<p>本月销量(笔)</p>
			</div>
		</li>
		<li>
			<div class="left">
				<img src="/public/static/blue/img/finish_count.png" />
			</div>
			<div class="right">
				<strong class="js-order-finish-count">0</strong>
				<p>已完成交易(笔)</p>
			</div>
		</li>
	</ul>
</div>

<div class="goods-prompt">
	<h3>
		<i class="i-circular"></i>店铺及商品提示<span>您需要关注的店铺信息以及待处理事项</span>
	</h3>
	<div class="goods-state a-line">
		<ul>
			<li>
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/goodslist','state=1'); ?>">
					<strong class="goods_sale_count">0</strong>
					<span>出售中</span>
				</a>
			</li>
			<li>
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/goodslist','state=0'); ?>">
					<strong class="goods_audit_count">0</strong>
					<span>仓库中</span>
				</a>
			</li>
			<li>
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/admin/saleservice/consultlist?type=to_reply'); ?>">
					<strong class="goods_consult_count">0</strong>
					<span>待回复咨询</span>
				</a>
			</li>
			<li>
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/admin/member/usercommissionwithdrawlist'); ?>">
					<strong class="member_balance_withdraw">0</strong>
					<span>会员提现审核</span>
				</a>
			</li>
			<li>
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/goodslist','stock_warning=1'); ?>">
					<strong class="stock_early_warning">0</strong>
					<span>库存预警</span>
				</a>
			</li>
		</ul>
	</div>
</div>

<div class="merchants-help">
	<h3>
		<i class="i-circular"></i>插件管理<span>您需要的插件</span>
	</h3>
	<div class="merchants-use">
		<ul>
			
			<li>
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/admin/extend/addonslist'); ?>">
					<img src="/public/static/blue/img/addons_management.png" />
					<span>插件管理</span>
				</a>
			</li>
			
			<li>
				<?php if(addon_is_exit('NsPintuan') == 1): ?>
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/NsPintuan/admin/tuangou/pintuanlist'); ?>">
					<img src="/public/static/blue/img/grouping.png" />
				<?php else: ?>
				<a href="javascript:;">
					<img src="/public/static/blue/img/grouping_1.png" />
				<?php endif; ?>
					<span>拼团</span>
				</a>
			</li>
			
			<li>
				<?php if(addon_is_exit('NsBargain') == 1): ?>
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/NsBargain/admin/bargain/index'); ?>">
					<img src="/public/static/blue/img/bargain-down.png" />
				<?php else: ?>
				<a href="javascript:;">
					<img src="/public/static/blue/img/bargain-down_1.png" />
				<?php endif; ?>
					<span>砍价</span>
				</a>
			</li>
			
			<li>
				<?php if(addon_is_exit('Nsfx') == 1): ?>
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/Nsfx/admin/Distribution/promoterList'); ?>">
					<img src="/public/static/blue/img/distribution.png" />
				<?php else: ?>
				<a href="javascript:;">
					<img src="/public/static/blue/img/distribution_1.png" />
				<?php endif; ?>
					<span>分销</span>
				</a>
			</li>
			
			<li>
				<?php if(addon_is_exit('NsO2o') == 1): ?>
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/NsAnalysis/admin/account/shopgoodssaleslist'); ?>">
					<img src="/public/static/blue/img/data-analysis.png" />
				<?php else: ?>
				<a href="javascript:;">
					<img src="/public/static/blue/img/data-analysis_1.png" />
				<?php endif; ?>
					<span>数据分析</span>
				</a>
			</li>
		</ul>
	</div>
</div>

<div class="goods-prompt">
	<h3>
		<i class="i-circular"></i>交易提示<span>您需要立即处理的交易订单</span>
	</h3>
	<div class="goods-state a-line order">
		<ul>
			<li>
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/admin/order/orderlist?status=0'); ?>">
					<strong class="daifukuan">0</strong>
					<span>待付款</span>
				</a>
			</li>
			<li>
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/admin/order/orderlist?status=1'); ?>">
					<strong class="daifahuo">0</strong>
					<span>待发货</span>
				</a>
			</li>
			<li>
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/admin/order/orderlist?status=2'); ?>">
					<strong class="yifahuo">0</strong>
					<span>已发货</span>
				</a>
			</li>
			<li>
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/admin/order/orderlist?status=3'); ?>">
					<strong class="yishouhuo">0</strong>
					<span>已收货</span>
				</a>
			</li>
			<li>
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/admin/order/orderlist?status=4'); ?>">
					<strong class="yiwancheng">0</strong>
					<span>已完成</span>
				</a>
			</li>
			<!-- <li>
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/admin/order/orderlist?status=5'); ?>">
					<strong class="yiguanbi">0</strong>
					<span>已关闭</span>
				</a>
			</li> -->
			<li>
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/admin/order/orderlist?status=-1'); ?>">
					<strong class="tuikuanzhong">0</strong>
					<span>退款中</span>
				</a>
			</li>
			<li>
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/admin/order/customerServiceList'); ?>">
					<strong class="customer">0</strong>
					<span>售后待处理</span>
				</a>
			</li>
<!-- 			<li style="display: none;"> -->
<!-- 				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/admin/order/orderlist?status=-2'); ?>"> -->
<!-- 					<strong class="yituikuan">0</strong> -->
<!-- 					<span>已退款</span> -->
<!-- 				</a> -->
<!-- 			</li> -->
		</ul>
	</div>
</div>

<div class="sales">
	<h3>
		<i class="i-circular"></i>销售情况统计<span>按周期统计商家店铺的订单量和订单金额</span>
	</h3>

	<table>
		<tr>
			<td rowspan="3" align="left" style="background: #f6f6f6;text-align: center;">昨日销量</td>
		</tr>
		<tr>
			<td style=" border-top: 1px solid #f6f6f6;">
				<span>订单量(件)</span>
				<strong class="yesterday_goods">0</strong>
			</td>
		</tr>
		<tr>
			<td>
				<span>订单金额(元)</span>
				<strong class="yesterday_money">0</strong>
			</td>
		</tr>

		<tr style="height: 10px;"></tr>

		<tr>
			<td rowspan="3" align="left" style="background: #f6f6f6;text-align: center;">本月销量</td>
		</tr>
		<tr>
			<td style=" border-top: 1px solid #f6f6f6;">
				<span>订单量(件)</span>
				<strong class="month_goods">0</strong>
			</td>
		</tr>
		<tr>
			<td>
				<span>订单金额(元)</span>
				<strong class="month_money">0</strong>
			</td>
		</tr>
	</table>
</div>

<div class="charts">
	<h3>
		<i class="i-circular"></i>订单总数统计<span><i></i>订单数量</span>
	</h3>
	<div id="orderCharts"></div>
</div>

<div class="sales-ranking">
	<h3>
		<i class="i-circular"></i>单品销售排名<span>按周期统计商家店铺的订单量和订单金额</span>
	</h3>
	<table>
		<colgroup>
			<col width="15%">
			<col width="70%">
			<col width="15%">
		</colgroup>
		<tr>
			<td>排行</td>
			<td style="text-align: left;">商品信息</td>
			<td>销量</td>
		</tr>
		<?php if(is_array($goods_list) || $goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator): if( count($goods_list)==0 ) : echo "" ;else: foreach($goods_list as $key=>$goods_info): ?>
		<tr>
			<td>
				<?php if($key == 0): ?>
				<span class="frist">
				<?php elseif($key == 1): ?>
				<span class="second">
				<?php elseif($key == 2): ?>
				<span class="third">
				<?php else: ?>
				<span>
				<?php endif; ?><?php echo $key+1; ?></span>
			</td>
			<td title="<?php echo $goods_info['goods_name']; ?>" style="text-align: left;">
				<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/detail','goods_id='.$goods_info['goods_id']); ?>" target="_blank"><?php echo strlen($goods_info["goods_name"])>20 ? mb_substr($goods_info["goods_name"],0,20,'utf-8')."...":$goods_info["goods_name"]; ?></a>
			</td>
			<td>
				<?php if($key == 0): ?>
				<span class="frist">
				<?php elseif($key == 1): ?>
				<span class="second">
				<?php elseif($key == 2): ?>
				<span class="third">
				<?php else: ?><span>
				<?php endif; ?><?php echo $goods_info['real_sales']; ?></span>
			</td>
		</tr>
		<?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
</div>
<div class="charts">
	<h3>
		<i class="i-circular"></i>关注人数统计<span><i></i>关注人数</span>
	</h3>
	<div id="focusCharts"></div>
</div>
<div class="system-config">
	<h3>
		<i class="fa fa-cog"></i>系统信息
	</h3>
	<table>
		<colgroup>
			<col width="15%">
			<col width="40%">
			<col width="15%">
			<col width="30%">
		</colgroup>
		<tr>
			<td>服务器操作系统</td>
			<td><?php echo $system_config['os']; ?></td>
			<td>服务器域名</td>
			<td><?php echo $system_config['dns']; ?>:<?php echo $system_config['port']; ?></td>
		</tr>
		<tr>
			<td>服务器环境</td>
			<td><?php echo $system_config['server_software']; ?></td>
			<td>PHP版本</td>
			<td><?php echo $system_config['php_version']; ?></td>
		</tr>
		<tr>
			<td>文件上传限制</td>
			<td><?php echo $system_config['upload_max_filesize']; ?></td>
			<td>GD版本</td>
			<td><?php echo $system_config['gd_version']; ?></td>
		</tr>
		<tr>
			<td>sockets开启</td>
			<td><?php if($system_config['sockets'] == true): ?>已开启<?php else: ?><span style="color:red;">未开启，邮箱功能将无法正常使用</span><?php endif; ?></td>
			<td>curl支持</td>
			<td><?php if($system_config['curl'] == true): ?>支持<?php else: ?><span style="color:red;">不支持，微信和支付宝等功能将无法正常使用</span><?php endif; ?></td>
		</tr>
		<tr>
			<td>openssl开启</td>
			<td><?php if($system_config['openssl'] == true): ?>已开启<?php else: ?><span style="color:red;">未开启，不支持https</span><?php endif; ?></td>
			<td>upload目录权限</td>
			<td><?php if($system_config['upload_dir_jurisdiction'] == 1): ?>可读可写<?php else: ?><span style="color:red;">不可读不可写，会造成图片无法上传和访问</span><?php endif; ?></td>
		</tr>
		<tr>
			<td>runtime目录权限</td>
			<td><?php if($system_config['runtime_dir_jurisdiction'] == 1): ?>可读可写<?php else: ?><span style="color:red;">不可读不可写，会造成编译文件缓存文件无法生成读取，是网站访问出错</span><?php endif; ?></td>
			<td>fileinfo开启</td>
			<td><?php if($system_config['fileinfo'] == true): ?>已开启<?php else: ?><span style="color:red;">未开启，将无法获取上传文件类型，导致上传图片失败</span><?php endif; ?></td>
		</tr>
	</table>
</div>
<!-- 快捷菜单 -->
<div class="modal fade hide" id="set_shortcut_menu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:1200px;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3>常用功能设置</h3>
	</div>
	<div class="modal-body">
		<ul class="menu-box">
			<?php if(is_array($nav_list) || $nav_list instanceof \think\Collection || $nav_list instanceof \think\Paginator): $i = 0; $__LIST__ = $nav_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$one): $mod = ($i % 2 );++$i;?>
			<li>
				<h4><?php echo $one['data']['module_name']; ?></h4>
				<div>
					<?php if(is_array($one['sub_menu']) || $one['sub_menu'] instanceof \think\Collection || $one['sub_menu'] instanceof \think\Paginator): $i = 0; $__LIST__ = $one['sub_menu'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$two): $mod = ($i % 2 );++$i;?>
					<p>
						<?php if(in_array($two['module_id'],$selected_ids)): ?>
						<i class="checkbox-common selected"><input type="checkbox" value="<?php echo $two['module_id']; ?>" checked/></i>
						<?php else: ?>
						<i class="checkbox-common"><input type="checkbox" value="<?php echo $two['module_id']; ?>"/></i>
						<?php endif; ?>
						<span><?php echo $two['module_name']; ?></span>
					</p>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
			</li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
	<div class="modal-footer">
		<button class="btn-common btn-big" onclick="set_shortcut_menu()" >保存</button>
		<button class="btn-common-cancle btn-big" data-dismiss="modal" aria-hidden="true">关闭</button>
	</div>
</div>

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