<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:37:"template/admin\Member\memberList.html";i:1555403122;s:48:"D:\phpStudy\WWW\niushop\template\admin\base.html";i:1553915410;s:65:"D:\phpStudy\WWW\niushop\template\admin\controlCommonVariable.html";i:1552613506;s:52:"D:\phpStudy\WWW\niushop\template\admin\urlModel.html";i:1552613544;s:54:"D:\phpStudy\WWW\niushop\template\admin\pageCommon.html";i:1552613506;s:54:"D:\phpStudy\WWW\niushop\template\admin\openDialog.html";i:1552613504;}*/ ?>
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
	
<link rel="stylesheet" type="text/css" href="/template/admin/public/css/member_list.css" />
<script type="text/javascript" src="/public/static/My97DatePicker/WdatePicker.js"></script>
<style type="text/css">
#account_update .modal-header ul li{
    display: inline-block;
    width: 100px;
    text-align: center;
}
#account_update .modal-header ul li:hover{
	cursor:pointer;
}
.modal-header .close {
    position: absolute;
    right: 20px;
}
.account_active{
	border-bottom: 2px solid #00A0DE;
}
.table-class tr td:nth-child(4){
	color: #F79136;
	text-align: right;
}
.table-class tr td:nth-child(5){
	color: #00A0DE;
	text-align: right;	
}

.edit-group{border-bottom: 1px solid #ebebeb;margin-bottom:10px;    padding-bottom: 13px;}
.edit-group label{font-weight:normal;}
.edit-group-title{height:15px;line-height:15px;width:140px;margin-top:3px;margin-bottom:3px;color:#00A0DE;}
.edit-group-button{border: 1px solid #bbb;height: 26px;line-height: 24px;padding: 0 5px;}
.clear {
	clear: both;
}
.label-bg {
    height: 20px;
    font-size: 12px;
    text-align: center;
    background-color: #FF6600;
    color: #fff;
    border-radius: 5px;
    padding: 1px 3px;
    margin-right: 3px;
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
			


<table class="mytable">

	<tr>
		<th style="text-align: left;width: 20%;">
			<button class="btn-common" onclick="add_user()" >添加会员</button>
		</th>
		<th style="width:50%;" class="default-condition"> 
			<input type="text" id ='search_text' placeholder="手机号/邮箱/会员昵称" class="input-common middle" />
			<!-- 更多搜索按钮 -->
			<button onclick="searchData()" value="搜索" class="btn-common" >搜索</button>
			<button onclick="openSeniorSearch('.default-condition')" value="搜索" class="btn-common" >高级搜索</button>
			<button onclick="dataExcel()" value="导出数据" class="btn-common"  >导出数据</button>
		</th>
	</tr>
</table>

<!-- 高级搜索 -->
<div class="nui-condition">
	<div class="c-item-column">
		<label for="">搜索内容：</label>
		<input type="text" id ='search_text' placeholder="手机号/邮箱/会员昵称" class="input-common middle" />
	</div>
	<div class="c-item-column">
		<label for="">会员等级：</label>
		<select id="level_name" class="select-common middle">
			<option value ="">请选择会员等级</option>
			<?php if(is_array($level_list['data']) || $level_list['data'] instanceof \think\Collection || $level_list['data'] instanceof \think\Paginator): $i = 0; $__LIST__ = $level_list['data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<option value ="<?php echo $vo['level_id']; ?>"><?php echo $vo['level_name']; ?></option>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</select>
	</div>
	
<!-- 	<div class="c-item-column"> -->
<!-- 		<label for="">会员标签：</label> -->
<!-- 		<select id="label_name" class="select-common middle"> -->
<!-- 			<option value ="">请选择会员标签</option> -->
<!-- 			<?php if(is_array($label_list['data']) || $label_list['data'] instanceof \think\Collection || $label_list['data'] instanceof \think\Paginator): if( count($label_list['data'])==0 ) : echo "" ;else: foreach($label_list['data'] as $key=>$vo): ?> -->
<!-- 			<option value="<?php echo $vo['id']; ?>"><?php echo $vo['label_name']; ?></option> -->
<!-- 			<?php endforeach; endif; else: echo "" ;endif; ?> -->
<!-- 		</select> -->
<!-- 	</div> -->
	<div class="c-item-column">
		<label for="">会员标签：</label>
		<input type="text" placeholder="请选择会员标签" id="selectMemberLabel"  onfocus="selectMemberLabel();" is_show="false" data-html="true" class="input-common middle" title="<h6 class='edit-group-title'>选择会员标签</h6>" data-container="body" data-placement="bottom"  data-trigger="manual" data-content="<div class='edit-group' style='max-width:auto;'>
			<?php foreach($label_list['data'] as $vo): ?>
					<p>
					<label class='checkbox-inline' style='display:inline-block;width: 100%;'>
					<input type='checkbox' value='<?php echo $vo['id']; ?>' onchange='clickMemberLabel(this);'><span><?php echo $vo['label_name']; ?></span>&nbsp;&nbsp;&nbsp;
					</label>
					<div class='clear'></div>
				<?php endforeach; ?>
			</div></div>
			<button class='btn-common btn-small' onclick='confirm();'>确认</button>
			<button class='btn btn-small' onclick='hideGroup()'>取消</button>
			">
	</div>
	
	<br />

	<div class="c-item-column">
		<label for="">注册时间：</label>
		<input type="text" id="startDate" class="input-common middle" placeholder="请选择开始日期" onclick="WdatePicker()" />
		&nbsp;-&nbsp;
		<input type="text" id="endDate" placeholder="请选择结束日期" class="input-common middle" onclick="WdatePicker()" />
	</div>
	<br />
	<div class="c-operation">
		<button onclick="searchData()"  value="搜索" class="btn-common" >搜索</button>
		<button onclick="dataExcel()"  value="搜索" class="btn-common-white" >导出</button>
		
		<a href="javascript:clearCondition();">清空筛选条件</a>
	</div>
	<a href="javascript:retractSeniorSearch();" class="retract">收起↑</a>
</div>



<table class="table-class">
	<colgroup>
	<col style="width: 2%;">
	<col style="width: 21%;">
	<col style="width: 7%;">
	<col style="width: 10%;">
	<col style="width: 10%;">
	<col style="width: 20%;">
	<col style="width: 6%;">
	<col style="width: 20%;">
	</colgroup>
	<thead>
		<tr align="center">
			<th><!-- <i class="checkbox-common"><input type="checkbox" onclick="CheckAll(this)"></i> --></th>
			<th style="text-align:left;">会员</th>
			<th style="text-align:left;">会员等级</th>
			<th style="text-align:right;">积分</th>
			<th style="text-align:right;">账户余额</th>
			<th>注册&登录</th>
			<th>状态</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody id="productTbody">
	
	</tbody>
</table>

<!-- 账户调整 -->
<div class="modal fade hide" id="account_update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<ul class="account_ul">
					<li class="account_active">
						<h3>调整积分</h3>
					</li>
					<li>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3>调整余额</h3>
					</li>
				</ul>
			</div>
			<div class="account-point">
				<div class="modal-body">
					<div class="modal-infp-style">
						<table>
							<tr>
								<td>当前积分</td>
								<td colspan='3' id="current_point" class="input-common"></td>
							</tr>
							<tr>
								<td>调整积分</td>
								<td colspan='3'>
									<input type="number" id="point" class="input-common harf"><em class="unit">分</em>
									<p class="hint">输入负数表示为减少</p>
								</td>
							</tr>
							<tr>
								<td>备注</td>
								<td colspan='3'><textarea id="remark_point" class="textarea-common"></textarea></td>
							</tr>
						</table>
						
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="point_id" />
					<button class="btn-common btn-big" onclick="addAccount(1)">保存</button>
					<button class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
				</div>
			</div>
			
			<div class="account-balance"  style="display: none;">
				<div class="modal-body">
					<div class="modal-infp-style">
						<table>
							<tr>
								<td>当前余额</td>
								<td colspan='3' id="current_balance" class="input-common" ></td>
							</tr>
							<tr>
								<td>调整金额</td>
								<td colspan='3'>
									<input type="number" id="balance" class="input-common harf" /><em class="unit">元</em>
									<p class="hint">输入负数表示为减少</p>
								</td>
							</tr>
							<tr>
								<td>备注</td>
								<td colspan='3'><textarea id="remark_balance" class="textarea-common"></textarea></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="balance_id" />
					<button class="btn-common btn-big" onclick="addAccount(2)">保存</button>
					<button class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- 添加会员 -->
<div class="modal fade hide" id="add_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>添加会员</h3>
			</div>
			<div class="modal-body">
				<div class="modal-infp-style">
					<table class="modal-tab">
						<tr>
							<td style="width:20%;"><span class="required">*</span>用户名</td>
							<td colspan='3'>
								<input type="text" id="username" class="input-common" />
								<span id="usernameyz"></span>
								<input type="hidden" value="不存在" id="isset_username" class="input-common" />
							</td>
						</tr>
						<tr>
							<td><span class="required">*</span>登录密码</td>
							<td colspan='3'><input type="password" id="password" class="input-common"></td>
						</tr>
						<tr>
							<td style="width:22%;"><span class="required">*</span>昵称</td>
							<td colspan='3'>
								<input type="text" id="nickname" class="input-common" />
							</td>
						</tr>
						<tr>
							<td>会员等级</td>
							<td colspan='3'>
								<?php if($level_list['data']): ?>
								<select id="member_level" class="select-common">
									<?php if(is_array($level_list['data']) || $level_list['data'] instanceof \think\Collection || $level_list['data'] instanceof \think\Paginator): if( count($level_list['data'])==0 ) : echo "" ;else: foreach($level_list['data'] as $key=>$vo): ?>
									<option value="<?php echo $vo['level_id']; ?>"><?php echo $vo['level_name']; ?></option>
									<?php endforeach; endif; else: echo "" ;endif; ?>
								</select>
								<?php else: ?>
								<span>暂无会员等级</span>
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<td>会员标签</td>
							<td colspan='3'>
								<?php if($label_list['data']): ?>
								<select id="member_label" class="select-common">
									<?php if(is_array($label_list['data']) || $label_list['data'] instanceof \think\Collection || $label_list['data'] instanceof \think\Paginator): if( count($label_list['data'])==0 ) : echo "" ;else: foreach($label_list['data'] as $key=>$vo): ?>
									<option value="<?php echo $vo['id']; ?>"><?php echo $vo['label_name']; ?></option>
									<?php endforeach; endif; else: echo "" ;endif; ?>
								</select>
								<?php else: ?>
								<span>暂无会员标签</span>
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<td>手机号码</td>
							<td colspan='3'><input type="text" id="telephone" class="input-common"/><span id="telephoneyz"></span></td>
						</tr>
						<tr>
							<td>邮箱地址</td>
							<td colspan='3'><input type="text" id="member_email" class="input-common" /><span id="member_emailyz"></span></td>
						</tr>
						<tr>
							<td>性别</td>
							<td>
							<label class="radio inline normal"><i class="radio-common selected"><input type="radio" checked="checked" name="sex" value="1"/></i>
							<span>男</span></label>
							<label class="radio inline normal"><i class="radio-common"><input name="sex" type="radio" value="2"/></i>
							<span>女</span></label>
							<label class="radio inline normal"><i class="radio-common"><input name="sex" type="radio" value="0"/></i>
							<span>保密</span></label>
							</td>
						</tr>
						<tr>
							<td>账户状态</td>
							<td>
							<label  class="radio inline normal"><i class="radio-common selected"><input type="radio" checked="checked" name="status" value="1"/></i>
							<span>正常</span></label>
							<label  class="radio inline normal"><i class="radio-common"><input name="status" type="radio" value="0"/></i>
							<span>锁定</span></label>
							</td>
						</tr>
					</table>
				</div>
			</div>
			
			<div class="modal-footer">
				<button class="btn-common btn-big" onclick="addUser()">保存</button>
				<button class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
	
</div>

<input type="hidden" id="modify_uid"/>
<!-- 修改会员 -->
<div class="modal fade hide" id="modify_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-dialog" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title" id="myModalLabel">编辑会员</h3>
			</div>
			<div class="modal-body" style="min-height: 360px;">
				<div class="modal-infp-style">
					<table class="modal-tab">
						<tr style="height: 32px;">
							<td style="width:20%"><span class="required">*</span>用户名</td>
							<td colspan='3'>
<!-- 								<span id="modify_username"></span> -->
								<input type="text" id="modify_username" class="input-common" />
								<span id="modify_usernameyz"></span>
								<input type="hidden" value="不存在" id="modify_isset_username"/>
							</td>
						</tr>
						<tr>
							<td style="width:20%">昵称</td>
							<td colspan='3'><input type="text" id="modify_nickname" class="input-common"/></td>
						</tr>
						<tr>
							<td>会员等级</td>
							<td colspan='3' style="padding-bottom: 0;">
								<p>
									<?php if($level_list['data']): ?>
									<select id="modify_member_level" class="select-common">
										<?php if(is_array($level_list['data']) || $level_list['data'] instanceof \think\Collection || $level_list['data'] instanceof \think\Paginator): if( count($level_list['data'])==0 ) : echo "" ;else: foreach($level_list['data'] as $key=>$vo): ?>
										<option value="<?php echo $vo['level_id']; ?>"><?php echo $vo['level_name']; ?></option>
										<?php endforeach; endif; else: echo "" ;endif; ?>
									</select>
									<?php else: ?>
									<span>暂无会员等级</span>
									<?php endif; ?>
								</p>
							</td>
						</tr>
						<tr>
							<td>会员标签</td>
							<td colspan='3'>
								<?php if($label_list['data']): ?>
								<select id="modify_member_label" class="select-common">
									<?php if(is_array($label_list['data']) || $label_list['data'] instanceof \think\Collection || $label_list['data'] instanceof \think\Paginator): if( count($label_list['data'])==0 ) : echo "" ;else: foreach($label_list['data'] as $key=>$vo): ?>
									<option value="<?php echo $vo['id']; ?>"><?php echo $vo['label_name']; ?></option>
									<?php endforeach; endif; else: echo "" ;endif; ?>
								</select>
								<?php else: ?>
								<span>暂无会员标签</span>
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<td>手机号码</td>
							<td colspan='3'><input type="text" id="modify_telephone" value="" class="input-common"/><span id="modify_telephoneyz"></td>
						</tr>
						<tr>
							<td>邮箱地址</td>
							<td colspan='3'><input type="text" id="modify_member_email" class="input-common"/><span id="modify_member_emailyz"></td>
						</tr>
				
						<tr>
							<td>性别</td>
							<td id="sex">
							<label class="radio inline normal"><i class="radio-common"><input type="radio" checked="checked" name="sex" value="1"/></i>
							<span>男</span></label>
							<label class="radio inline normal"><i class="radio-common"><input name="sex" type="radio" value="2"/></i>
							<span>女</span></label>
							<label class="radio inline normal"><i class="radio-common"><input name="sex" type="radio" value="0"/></i>
							<span>保密</span></label>
							</td>
						</tr>
						<tr>
							<td>账户状态</td>
							<td  id="status">
							<label  class="radio inline normal"><i class="radio-common"><input type="radio" checked="checked" name="status" value="1"/></i>
							<span>正常</span></label>
							<label  class="radio inline normal"><i class="radio-common"><input name="status" type="radio" value="0"/></i>
							<span>锁定</span></label>
							</td>
						</tr>
					</table>
				</div>
			</div>
			
			<div class="modal-footer">
				<input type="hidden" id="modify_username_hidden" />
				<input type="hidden" name="" id="hidden_old_username" value="">
				<button class="btn-common btn-big" onclick="modifyUser()" id="butSubmit"  >保存</button>
				<button class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
	
</div>

<!-- 修改会员密码 -->
<div class="modal fade hide" id="modify_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 id="myModalLabel">重置密码</h3>
			</div>
			<div class="modal-body">
				<div class="modal-infp-style">
					<table class="modal-tab">
						<tr>
							<td style="width:20%">密码</td>
							<td colspan='3'><input type="text" id="modify_passwords" class="input-common"/></td>
						</tr>
					</table>
				</div>
			</div>
			
			<div class="modal-footer">
				<input type="hidden" id="modify_userid" />
				<button class="btn-common btn-big" onclick="modifypassword()">保存</button>
				<button class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
	
</div>
<!-- 修改标签名称 -->
<div class="modal fade hide" id="modify_tab" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">修改标签</h4>
			</div>
			<div class="modal-body">
				<div class="modal-infp-style">
					<table class="modal-tab">
						<tr>
							<td style="width:20%">标签名称</td>
							<td colspan='3' class="c-item-column" style="position: relative;">
								<input type="text" placeholder="请选择会员标签" id="addSelectMemberLabel"  onfocus="addSelectMemberLabel();" is_show="false" data-html="true" class="input-common middle" title="<h6 class='edit-group-title'>选择会员标签</h6>" data-container="body" data-placement="bottom"  data-trigger="manual" data-content="<div class='edit-group' style='max-width:auto;'>
			<?php foreach($label_list['data'] as $vo): ?>
					<p>
					<label class='checkbox-inline' style='display:inline-block;width: 100%;'>
					<input type='checkbox' value='<?php echo $vo['id']; ?>' onchange='addclickMemberLabel(this);'><span><?php echo $vo['label_name']; ?></span>&nbsp;&nbsp;&nbsp;
					</label>
					<div class='clear'></div>
				<?php endforeach; ?>
			</div></div>
			<button class='btn-common btn-small' onclick='confirm();'>确认</button>
			<button class='btn btn-small' onclick='hideGroup()'>取消</button>
			">
								
							</td>
						</tr>
					</table>
				</div>
			</div>
			
			<div class="modal-footer">
				<input type="hidden" id="modify_userid" />
				<button class="btn btn-primary" onclick="saveMemberLabel()">保存</button>
				<button class="btn" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
</div>

<!--账户详情-->
<div class="modal fade hide" id="member_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>账户详情</h3>
			</div>
			<div class="modal-body">
				<div class="modal-infp-style">
					<table class="modal-tab">
						<tr>
							<td>用户名</td>
							<td>admin</td>
						</tr>
						<tr>
							<td>昵称</td>
							<td>admin</td>
						</tr>
						<tr>
							<td>手机号</td>
							<td>15</td>
						</tr>
						<tr>
							<td>邮箱</td>
							<td>admin</td>
						</tr>
						<tr>
							<td>会员标签</td>
							<td>admin</td>
						</tr>
						<tr>
							<td>会员等级</td>
							<td>admin</td>
						</tr>
						<tr>
							<td>QQ号</td>
							<td>admin</td>
						</tr>
						<tr>
							<td>账户状态</td>
							<td>a</td>
						</tr>
						<tr>
							<td>性别</td>
							<td>a</td>
						</tr>
						<tr>
							<td>注册时间</td>
							<td>a</td>
						</tr>
						<tr>
							<td>近期登录时间</td>
							<td>a</td>
						</tr>
					</table>
				</div>
			</div>
			
			<div class="modal-footer">
				<button class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>

</div>
<input type="hidden" id="selectMemberLabelId">
<input type="hidden" id="addSelectMemberLabelId">

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
function LoadingInfo(page_index) {
	var search_text = $("#search_text").val();
	var levelid = $("#level_name").val();
	var label_id = $("#selectMemberLabelId").val();
	var start_date = $("#startDate").val();
	var end_date = $("#endDate").val();
	var status = $("#status_search").val();
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/member/memberlist'); ?>",
		data : {
			"page_index" : page_index, "page_size" : $("#showNumber").val(), "search_text" : search_text,"levelid":levelid, 
			"start_date" : start_date, "end_date" : end_date, "status" : status, "label_id" :label_id
		},
		success : function(data) {
			if (data["data"].length > 0) {
				$(".table-class tbody").empty();
				for (var i = 0; i < data["data"].length; i++) {
					var html = '';
					html += '<tr align="center">';
					html += '<td><!--<i class="checkbox-common"><input name="sub" type="checkbox" value="'+ data["data"][i]["uid"]+'"></i>--></td>';
					html += '<td align="left" class="member-basics">';
					if(data["data"][i]["user_headimg"] ==""){
						html += '<img src="<?php echo __IMG($default_headimg); ?>" class="head-portrait"/>';
					}else{
						html += '<img src="'+__IMG(data["data"][i]["user_headimg"])+'" class="head-portrait"/>';
					}
					html += '<div style="float:left;" class="member-div">';
					html += '<label style="float:none;width:100%;margin-top:3px;"';
					if(data["data"][i]["nick_name"] == '' || data["data"][i]["nick_name"] == null){
						html += '<a href="'+__URL('http://127.0.0.1:8080/index.php/admin/member/memberdetail?member_id='+ data['data'][i]['uid'])+'" style="margin-left:0px;">匿名用户</a>';
					}else{
						html += '<a href="'+__URL('http://127.0.0.1:8080/index.php/admin/member/memberdetail?member_id='+ data['data'][i]['uid'])+'" style="margin-left:0px;">'+data["data"][i]["nick_name"]+'</a>';
					}
					var label_name_str = '';
					if(data['data'][i]['label_arr'] != '')
					html += '<br>';
					$.each(data['data'][i]['label_arr'], function(obj, e) {
						label_name_str += e.label_name+';';
						html += '<span style="" class="label-bg">'+e.label_name+'</span>';
					})
					
					html += '</label>'
					
					html += '</div>';
					html += '<div class="msg_member">';
						html += '<p><span>会员ID：</span>'+data["data"][i]["uid"]+'</p>';
						html += '<p><span>会员账号：</span>'+(data["data"][i]["user_name"] == '' ? '--' : data["data"][i]["user_name"])+'</p>';
						html += '<p><span>会员昵称：</span>'+(data["data"][i]["nick_name"] == '' ? '匿名用户' : data["data"][i]["nick_name"])+'</p>';
						
						html += '<p><span>手机号码：</span>'+(data["data"][i]["user_tel"] == '' ? '--' : data["data"][i]["user_tel"])+'</p>';
						html += '<p><span>会员邮箱：</span>'+(data["data"][i]["user_email"] == '' ? '--' : data["data"][i]["user_email"])+'</p>';
					html += '<span class="transform-left"></span></div></td>';
					if(data["data"][i]["level_name"]==null || data["data"][i]["level_name"]==undefined){
						html += '<td >--</td>';
					}else{
						html += '<td style="text-align:left;">' + data["data"][i]["level_name"] + '</td>';
					}
					html += '<td style="text-align:right;">' + data["data"][i]["point"] + '</td>';
					html += '<td style="text-align:right;">'+'¥'+ data["data"][i]["balance"] +'</td>';
					html += '<td>' +'注册时间 : '+ timeStampTurnTime(data["data"][i]["reg_time"]) +'<br>'+'最后登录 : '+ timeStampTurnTime(data["data"][i]["current_login_time"])+'</td>';
					html += data["data"][i]["user_status"] == 0 ? '<td style="color:red;">锁定</td>' : '<td style="color:green;">正常</td>';
					html += '<td>';
					// html += '<a href="javascript:accountDetail(' + data['data'][i]['uid'] + ');">账户详情</a><br/>';
					
					html += '<a href="'+__URL('http://127.0.0.1:8080/index.php/admin/member/memberdetail?member_id='+ data['data'][i]['uid'])+'">详情</a>&nbsp;&nbsp;';
					if(data["data"][i]["is_system"] != 1){
						if(data["data"][i]["user_status"] == 0){
							html += '<a onclick="unlockuser('+ data["data"][i]["uid"]+')">解锁&nbsp;&nbsp;</a>';
						}else{
							html += '<a onclick="lockuser('+ data["data"][i]["uid"]+')">锁定&nbsp;&nbsp;</a>';
						}
						// html += '<a onclick="modify_password('+ data["data"][i]["uid"]+')">重置密码</a><br/>';
						// html += '<a href="'+__URL('http://127.0.0.1:8080/index.php/admin/member/newpath?member_id='+ data['data'][i]['uid'])+'">查看足迹</a>';
						html += '<a onclick="modify_user('+ data["data"][i]["uid"]+')">修改&nbsp;&nbsp;</a><br/>';
						// html += '<a onclick="delete_user('+ data["data"][i]["uid"]+')">删除</a><br/>';
						
					}
					html += '<a onclick="modify_password('+ data["data"][i]["uid"]+')">重置密码</a>';
					html += '<a onclick="account_update('+ data["data"][i]["uid"]+','+ data["data"][i]["point"] +','+data["data"][i]["balance"]+')">账户调整</a>&nbsp;&nbsp;';
					html += '<a onclick="modify_tab('+ data["data"][i]["uid"]+', \''+label_name_str+'\', \''+data['data'][i]['member_label']+'\')">修改标签</a>';
					if(data["data"][i]["user_shop"] == 0){
						html += '<a onclick="modify_shop('+ data["data"][i]["uid"]+', \''+data["data"][i]["user_shop"]+'\')">允许开店</a>';
					}else{
						
						html += '<a onclick="modify_shop('+ data["data"][i]["uid"]+', \''+data["data"][i]["user_shop"]+'\')">禁止开店</a>';
					}
					
					html += '</td>';
					html += '</tr>';
					$(".table-class tbody").append(html);
				}
			} else {
				var html = '<tr align="center"><td colspan="9">暂无符合条件的数据记录</td></tr>';
				$(".table-class tbody").html(html);
			}
			initPageData(data["page_count"],data['data'].length,data['total_count']);
			$("#pageNumber").html(pagenumShow(jumpNumber,$("#page_count").val(),<?php echo $pageshow; ?>));
		}
	});
}
	
//全选
function CheckAll(event){
	var checked = event.checked;
	$("#productTbody input[type = 'checkbox']").prop("checked",checked);
	if(checked) $(".table-class tbody input[type = 'checkbox']").parent().addClass("selected");
	else $(".table-class tbody input[type = 'checkbox']").parent().removeClass("selected");
}

function searchData(){
	$(".more-search-container").slideUp();
	LoadingInfo(1);
}
	
//锁定会员
function lockuser(uid){
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/member/memberlock'); ?>",
		data : { "id" : uid },
		success : function(data) {
			if (data["code"] > 0) {
				LoadingInfo(getCurrentIndex(uid,'#productTbody'));
				showTip(data['message'],'success');
			}else{
				showTip(data['message'],'error');
			}
		}
	});
}

//解锁会员
function unlockuser(uid){
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/member/memberunlock'); ?>",
		data : { "id" : uid },
		success : function(data) {
			if (data["code"] > 0) {
				LoadingInfo(getCurrentIndex(uid,'#productTbody'));
				showTip(data['message'],'success');
			}else{
				showTip(data['message'],'error');
			}
		}
	});
}
	
//添加会员弹出
function add_user(){
	$("#add_user").modal("show");
}

//修改选项标签
function modify_tab(uid, label_name_str, id){
	$("#modify_tab").modal("show");
	$("#modify_uid").val(uid);
	$('#addSelectMemberLabel').val(label_name_str);
	$('#addSelectMemberLabelId').val(id);
}
//是否允许开店
function modify_shop(uid,user_shop){
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/member/memberShop'); ?>",
		data : { "id" : uid ,'user_shop' : user_shop},
		success : function(data) {
			showTip('修改成功','success');window.location.reload(); 
		}
	});	
}
//积分充值
function recharge_point(uid,point){
	$("#recharge_point").modal("show");
	$("#point_id").val(uid);
	$("#current_point").text(point);
}
//余额充值
function recharge_balance(uid,balance){
	$("#recharge_balance").modal("show");
	$("#balance_id").val(uid);
	$("#current_balance").text(balance);
}
// 账户调整
function account_update(uid,point,balance){
	$("#point_id,#balance_id").val(uid);
	$("#current_point").text(point);
	$("#current_balance").text(balance);
	$("#account_update").modal("show");
}
$(".account_ul li").each(function(i){
	$(".account_ul li").eq(i).click(function(){
		$(".account_ul li").eq(i).addClass('account_active').siblings(".account_ul li").removeClass('account_active');
		if(i==0){
			// 积分
			$(".account-point").show();
			$(".account-balance").hide();
		}else if(i==1){
			// 余额
			$(".account-point").hide();
			$(".account-balance").show();
		}
	})
	
});

//充值
function addAccount(type){
	var curr_obj = "";
	if(type == 1){
		var id = $("#point_id").val();
		var num = $("#point").val();
		var current_point = $("#current_point").text();
		var point = (parseInt(current_point) + parseInt(num));
		if(num == ''){
			showTip('积分不能为空','warning');
			return false;
		}
		var text = $("#remark_point").val();
		if(parseInt(point) < 0){
			showTip('积分不能为负数','warning');
			return false;
		}
	}else{
		var id = $("#balance_id").val();
		var num = $("#balance").val();
		var current_balance = $("#current_balance").text();
		var balance = (parseInt(current_balance) + parseInt(num));
		if(num == ''){
			showTip('余额不能为空','warning');
			return false;
		}
		var text = $("#remark_balance").val();
		if(parseInt(balance) < 0){
			showTip('余额不能为负数','warning');
			return false;
		}
	}
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/member/addmemberaccount'); ?>",
		data : {
			"id" : id,
			"type" : type,
			"num" : num,
			"text" : text
		},
		success : function(data) {
			if (data["code"] > 0) {
				LoadingInfo(getCurrentIndex(id,'#productTbody'));
				showTip(data['message'],'success');
				$("#account_update").modal("hide");
			}else{
				showTip(data['message'],'error');
			}
		}
	});
}

function checkUserName(username){
	var flag = true;
	$.ajax({
		type: "GET",
		url: "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/member/check_username'); ?>",
		async : false,
		data: {"username":username},
		success: function(data){
			if(data){
				flag = false;
				$("#username").css("border","1px solid red");
				$("#usernameyz").css("color","red").text("用户名已存在");
				$("#isset_username").attr("value","存在");
			}
		} 
	});
	return flag;
}

function checkMobile(mobile){
	var flag = false;
	$.ajax({
		type: "post",
		url: "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/member/checkUserInfoIsExist'); ?>",
		async : false,
		data: {"info":mobile,"type":"mobile"},
		success: function(data){
			if(data){
				flag = true;
			}
		} 
	});
	return flag;
}

function checkEmail(email){
	var flag = false;
	$.ajax({
		type: "post",
		url: "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/member/checkUserInfoIsExist'); ?>",
		async : false,
		data: {"info":email,"type":"email"},
		success: function(data){
			if(data){
				flag = true;
			}
		} 
	});
	return flag;
}

//添加会员
function addUser(){
	var username = $("#username").val();
	var nickname = $("#nickname").val();
	var password = $("#password").val();
	var level_name = $("#member_level").val();
	var member_label = $("#member_label").val();
	var tel = $("#telephone").val();
	var email = $("#member_email").val();
	var sex = $("input[name='sex']:checked").val();
	var status = $("input[name='status']:checked").val();
	
	if (username == '') {
		showTip('用户名不能为空','warning');
		return;
	}
	if(!checkUserName(username)){
		showTip('用户名已存在','warning');
		return;
	}

	if (password == null || password.length < 6) {
		showTip('密码必须不小于6位！','warning');
		return;
	}
	if (nickname == '') {
		showTip('昵称不能为空','warning');
		return;
	}
	if(tel.length > 0){
		if(!(/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/.test(tel))){ 
			showTip("手机号码有误，请重填",'warning');
			return; 
		}
		if(checkMobile(tel)){
			showTip('该手机号码已存在','warning');
			return; 
		}
	}
	if(email.length > 0){
		if(!(/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/.test(email))){ 
			showTip('邮箱错误,请重填','warning');
			return; 
		}
		if(checkEmail(email)){
			showTip('该邮箱已存在','warning');
			return; 
		}
	}
	$.ajax({
		type : "post",
		url : __URL("http://127.0.0.1:8080/index.php/admin/member/addmember"),
		data : {
			'username' : username,
			'nickname' :nickname,
			'password' : password,
			'level_name' : level_name,
			'member_label' : member_label,
			'tel' : tel,
			'email' : email,
			'sex' : sex,
			'status' : status
		},
		success : function(data) {
			if (data['code'] > 0) {
				showTip(data['message'],'success');
				$("#add_user").modal("hide");
				LoadingInfo(getCurrentIndex(1,'#productTbody'));
			} else {
				showTip(data['message'],'error');
				flag = false;
			}
		}
	});
}
//修改会员弹出
function modify_user(uid){
	var id = parseInt(uid);
	$("#modify_user").modal("show");
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/member/getmemberdetail'); ?>",
		data : { 'uid':id, },
		success : function(data) {
			//alert(JSON.stringify(data['user_name']));
			$("#modify_uid").val(data.uid);
			if(data['user_name']!=''){
				$("#modify_username,#hidden_old_username").val(data.user_name);
				$("#modify_username").attr('disabled',true);
			}else{
				$("#hidden_old_username").val("");
				$("#modify_username").attr('disabled',false).val("");
			}
			
			$("#modify_nickname").val(data.nick_name);
			//$("#modify_password").val(data.user_password);
			$("#modify_username_hidden").val(data.user_name);
			$("#modify_telephone").attr("old-value", data.user_tel).val(data.user_tel);
			$("#modify_member_email").attr("old-value", data.user_email).val(data.user_email);

			//$("#modify_member_level").find("option[value="+data.member.member_level+"]").attr("selected",true);
			$("#modify_member_level").val(data.member.member_level).selectric();
			$("#modify_member_label").val(data.member.member_label).selectric();
			$("#sex").find("input[value="+data.sex+"]").attr("checked",true);
			$("#status").find("input[value="+data.user_status+"]").attr("checked",true);
			
			$("#modify_user").find("input[name='status']").parent().removeClass("selected");
			$("#modify_user").find("input[name='sex']").parent().removeClass("selected");
			$("#sex").find("input[value="+data.sex+"]").parent().addClass("selected");
			$("#status").find("input[value="+data.user_status+"]").parent().addClass("selected");
		}
	});
}

//重置密码弹出
function modify_password(uid){
	$("#modify_password").modal("show");
	$("#modify_userid").val(uid);
}

//修改密码提交
function modifypassword(){
	var uid = $("#modify_userid").val();
	var password = $("#modify_passwords").val(); 
	if (password == null || password.length < 6) {
		showTip('密码必须不小于6位！','warning');
		return false;
	}
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/member/updatememberpassword'); ?>",
		data : {
			'uid':uid,
			'user_password' :password
		},
		success : function(data) {
			if (data['code'] > 0) {
				showTip('修改成功','success');
				LoadingInfo(getCurrentIndex(uid,'#productTbody'));
				$("#modify_password").modal("hide");
			} else {
				showTip('修改失败','error');
				flag = false;
			}
		}
	});
}

function delete_user(uid){
	$( "#dialog" ).dialog({
		buttons: {
			"确定": function() {
				$.ajax({
					type : "post",
					url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/member/deletemember'); ?>",
					data : { "uid" : uid.toString() },
					dataType : "json",
					success : function(data) {
						if(data["code"] > 0 ){
							LoadingInfo(getCurrentIndex(uid.toString(),'#productTbody'));
							showTip(data["message"],'success');
							$("#chek_all").prop("checked", false);
						}else{
							showTip(data["message"],'error');
						}
					}
				});
				$(this).dialog('close');
			},
			"取消,#f5f5f5,#666": function() {
				$(this).dialog('close');
			},
		},
		contentText:"删除会员同时会删除会员相关账户信息，确定要删除吗？",
	});
}

////修改会员
function modifyUser(){
	var uid = $("#modify_uid").val();
	var nickname = $("#modify_nickname").val();
	var username = $("#modify_username").val();

	var tel = $("#modify_telephone").val();
	var old_tel = $("#modify_telephone").attr("old-value");

	var email = $("#modify_member_email").val();
	var old_email = $("#modify_member_email").attr("old-value");

	var level_name = $("#modify_member_level").val();
	var member_label = $("#modify_member_label").val();
	var sex = $("input[name='sex']:checked").val();
	var status = $("input[name='status']:checked").val();
	
	if(nickname == ""){
		showTip("昵称不能为空","warning");
		$("#modify_nickname").focus();
		return;
	}
	
	if (username == '') {
		showTip('用户名不能为空','warning');
		return;
	}

	if(tel.length > 0){
		if(!(/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/.test(tel))){ 
			showTip("手机号码有误，请重填",'warning');
			return false; 
		}
		if(tel != old_tel){
			if(checkMobile(tel)){
				showTip('该手机号码已存在','warning');
				return; 
			}
		}
	}
	 if(email.length > 0){
		if(!(/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/.test(email))){ 
			showTip('邮箱错误,请重填','warning');
			return false; 
		}
		if(email != old_email){
			if(checkEmail(email)){
				showTip('该邮箱已存在','warning');
				return; 
			}
		}
	}

	var user_data = {
		'uid':uid,
		'nick_name' : nickname,
		'level_name' : level_name,
		'member_label' : member_label,
		'tel' : tel,
		'email' : email,
		'sex' : sex,
		'status' : status
	};

	if($("#hidden_old_username").val() == ""){
		user_data.user_name = username;
	}

	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/member/updatemember'); ?>",
		data : user_data,
		success : function(data) {
			if (data['code'] > 0) {
				showTip(data['message'],'success');
				LoadingInfo(getCurrentIndex(uid,'#productTbody'));
				$("#modify_user").modal("hide");
			} else {
				showTip(data['message'],'error');
				flag = false;
			}
		}
	});
}
//批量删除
function batchDelete() {
	var uid= [];
	$("#productTbody input[type='checkbox']:checked").each(function() {
		if (!isNaN($(this).val())) {
			uid.push($(this).val());
		}
	});
	if(uid.length ==0){
		$( "#dialog" ).dialog({
			buttons: {
				"确定,#0059d6,#fff": function() {
					$(this).dialog('close');
				}
			},
			contentText:"请选择需要操作的记录",
			title:"消息提醒",
		});
		return false;
	}
	delete_user(uid);
}

/**
 * 会员数据导出
 */
function dataExcel(){
	var search_text = $("#search_text").val();
	var levelid = $("#level_name").val();
	var label_id = $("#label_name").val();
	$.ajax({
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/member/memberExcellist'); ?>",
		type : "post",
		data : {
			"search_text" : search_text,
			"levelid" : levelid,
			"label_id" : label_id
		},
		success : function (data){
			if(data['data'] != ""){
				window.location.href=__URL("http://127.0.0.1:8080/index.php/admin/member/memberDataExcel?search_text="+search_text+"&levelid="+levelid + "&label_id=" + label_id);
			}else{
				showTip("没有导出的会员数据",'error');
			}
		}
	});
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
function selectMemberLabel(){
	$("#selectMemberLabel").popover("show");
	$("#selectMemberLabelId").val('');
	$("#selectMemberLabel").val('');
}
function clickMemberLabel(event){
	var goods_label_id = $(event).val();
	var goods_label_name = $(event).next("span").text();
	var selectMemberLabelVal = $("#selectMemberLabel").val();
	var selectMemberLabelId = $("#selectMemberLabelId").val();
	if($(event).is(":checked")){
		$("#selectMemberLabelId").val(selectMemberLabelId+goods_label_id+',');
		$("#selectMemberLabel").val(selectMemberLabelVal+goods_label_name+';');
	}else{
		selectMemberLabelVal = selectMemberLabelVal.replace(goods_label_name+';','');
		selectMemberLabelId = selectMemberLabelId.replace(goods_label_id+',','');
		$("#selectMemberLabelId").val(selectMemberLabelId);
		$("#selectMemberLabel").val(selectMemberLabelVal);
	}
}
function hideGroup(){
	$("#selectMemberLabel").popover("hide");
	$("#selectMemberLabel").val('');
	$("#addSelectMemberLabel").popover("hide");
	$("#addSelectMemberLabel").val('');
}
function confirm(){
	$("#selectMemberLabel").popover("hide");
	$("#addSelectMemberLabel").popover("hide");
}
function addSelectMemberLabel(){
	$("#addSelectMemberLabel").popover("show");
	$("#addSelectMemberLabelId").val('');
	$("#addSelectMemberLabel").val('');
}
function addclickMemberLabel(event){
	var goods_label_id = $(event).val();
	var goods_label_name = $(event).next("span").text();
	var selectMemberLabelVal = $("#addSelectMemberLabel").val();
	var selectMemberLabelId = $("#addSelectMemberLabelId").val();
	if($(event).is(":checked")){
		$("#addSelectMemberLabelId").val(selectMemberLabelId+goods_label_id+',');
		$("#addSelectMemberLabel").val(selectMemberLabelVal+goods_label_name+';');
	}else{
		selectMemberLabelVal = selectMemberLabelVal.replace(goods_label_name+';','');
		selectMemberLabelId = selectMemberLabelId.replace(goods_label_id+',','');
		$("#addSelectMemberLabelId").val(selectMemberLabelId);
		$("#addSelectMemberLabel").val(selectMemberLabelVal);
	}
}

function saveMemberLabel() {
	var addSelectMemberLabel = $('#addSelectMemberLabelId').val();
	if(addSelectMemberLabelId == '') {
		showTip("请选择标签",'error');
		return;
	}
	var uid = $('#modify_uid').val();
	$.ajax({
		url: "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/member/updateMemberLabel'); ?>",
		type: 'post',
		data: {'uid' : uid, 'member_label' : addSelectMemberLabel},
		success: function (data) {
			if (data["code"] > 0) {
				showTip(data['message'],'success');
				$("#modify_tab").modal("hide");
				LoadingInfo(1);
			}else{
				showTip(data['message'],'error');
			}
		}
	})
	
}

</script>

</body>
</html>