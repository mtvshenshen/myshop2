<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:42:"template/admin\Config\goodsSelectList.html";i:1552613507;s:65:"D:\phpStudy\WWW\niushop\template\admin\controlCommonVariable.html";i:1552613506;s:52:"D:\phpStudy\WWW\niushop\template\admin\urlModel.html";i:1552613544;s:54:"D:\phpStudy\WWW\niushop\template\admin\pageCommon.html";i:1552613506;s:54:"D:\phpStudy\WWW\niushop\template\admin\openDialog.html";i:1552613504;}*/ ?>
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
	<link rel="shortcut  icon" type="image/x-icon" href="/template/admin/public/images/admin_icon.ico" media="screen"/>
	<link rel="stylesheet" type="text/css" href="/public/static/blue/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="/public/static/blue/css/ns_blue_common.css" />
	<link rel="stylesheet" type="text/css" href="/public/static/font-awesome/css/font-awesome.min.css" />
	<script src="/public/static/js/jquery-1.8.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/public/static/blue/css/ns_table_style.css">
	<script src="/public/static/blue/bootstrap/js/bootstrap.js"></script>
	<script src="/public/static/bootstrap/js/bootstrapSwitch.js"></script>
	<script src="/template/admin/public/js/art_dialog.source.js"></script>
	<script src="/template/admin/public/js/iframe_tools.source.js"></script>
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
	
	<style>
	.Switch_FlatRadius.On span.switch-open{background-color: #00A0DE;border-color: #00A0DE;}
	#copyright_meta a{color:#333;}
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

<table class="mytable">
	<tr>
<!-- 		<th width="20%" style="text-align:left;"><button class="btn-common btn-small" onclick="getSelectData()" style="margin:0 5px 0 0 !important;">确认选中</button></th> -->
		<th width="80%">
			<div style="display: inline-block;position: relative;">
				<input type="text" placeholder="请选择商品分类" id="goodsCategoryOne" value="" is_show="false" class="input-common" >
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
			<input type="text" id = 'search_text' placeholder="请输入商品名称" class="input-common" />
			
			<button class="btn-common-white more-search"><i class="fa fa-angle-down"></i></button>
			<span class="interval"></span>
			
			<button class="btn-common" onclick="searchData()">搜索</button>
			
			<!-- 更多搜索 -->
			<div class="more-search-container">
				<dl>
					<dt>商品编码：</dt>
					<dd>
						<input id="goods_code" class="input-medium input-common middle" type="text" placeholder="要搜索的商品编码"/>
					</dd>
				</dl>
				<dl>
					<dt>供货商：</dt>
					<dd>
						<select id="supplier_id" class="select-common middle">
							<option value="">全部</option>
							<?php if(!(empty($supplier_list) || (($supplier_list instanceof \think\Collection || $supplier_list instanceof \think\Paginator ) && $supplier_list->isEmpty()))): if(is_array($supplier_list) || $supplier_list instanceof \think\Collection || $supplier_list instanceof \think\Paginator): $i = 0; $__LIST__ = $supplier_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
							<option value="<?php echo $vo['supplier_id']; ?>"><?php echo $vo['supplier_name']; ?></option>
							<?php endforeach; endif; else: echo "" ;endif; endif; ?>
						</select>
					</dd>
				</dl>
				<dl>
					<dt>商品类型：</dt>
					<dd>
						<select id="goods_type" class="select-common middle" >
							<option value="all">全部</option>
							<option value="1">实物商品</option>
							<option value="0">虚拟商品</option>
						</select>
					</dd>
				</dl>
				<dl>
					<dt>商品标签：</dt>
					<dd>
						<input type="text" placeholder="请选择商品标签" id="selectGoodsLabel"  onfocus="selectGoodsLabel();" is_show="false" data-html="true" class="input-common middle" title="<h6 class='edit-group-title'>选择商品标签</h6>" data-container="body" data-placement="bottom"  data-trigger="manual" data-content="<div class='edit-group' style='max-width:auto;'>
							<?php foreach($goods_group as $vo): ?>
							<p>
							<label class='checkbox-inline' style='display:inline-block;'>
							<input type='checkbox' value='<?php echo $vo['group_id']; ?>' onchange='clickGoodsLabel(this);'><span><?php echo $vo['group_name']; ?></span>&nbsp;&nbsp;&nbsp;
							</label>
						<?php endforeach; ?>
						</div>
						<button class='btn-common btn-small' onclick='confirm();'>确认</button>
						<button class='btn btn-small' onclick='hideGroup()'>取消</button>
						">
					</dd>
				</dl>
				<dl>
					<dt></dt>
					<dd>
						<a href="javascript:;" onclick="searchData()" class="btn-common">完成</a>
					</dd>
				</dl>
			</div>
		</th>
	</tr>
</table>
<table class="table-class">
	<colgroup>
		<col style="width: 3%;">
		<col style="width: 60%;">
		<col style="width: 22%;">
		<col style="width: 15%;">
	</colgroup>
	<thead>
		<tr align="center">
			<th align="center">
				<?php if($type == 2): ?>
					<i class="checkbox-common"><input value="0" name="sub" type="checkbox"></i>
				<?php endif; ?>
			</th>
			<th align="left">商品名称</th>
			<th align="right" class="right-indent">价格</th>
			<th align="right" class="right-indent">库存</th>
		</tr>
	</thead>
	<tbody ></tbody>
</table>
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
<input type="hidden" id="type" value="<?php echo $type; ?>"/>
<input type="hidden" id="data" value='<?php echo $data; ?>'/>
<input type="hidden" id="selectGoodsLabelId">
<!-- 公共的操作提示弹出框 common-success：成功，common-warning：警告，common-error：错误，-->
<div class="common-tip-message js-common-tip">
	<div class="inner"></div>
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
<script>
//存放商品id的对象
var goods_id_array_str = '<?php echo $goods_id_array; ?>';
var goods_id_obj = [];
if(goods_id_array_str != ''){
	var goods_id_array = goods_id_array_str.split(",");
	for(i in goods_id_array){
		goods_id_obj[goods_id_array[i]] = goods_id_array[i];
	}
}

/*
 * 载入数据
 */
function LoadingInfo(page_index){
	var search_text = $("#search_text").val();
	var goodsCategoryText = $.trim($("#goodsCategoryOne").val());
	//商品分类id
	var category_id_1 = '';
	var category_id_2 = '';
	var category_id_3 = '';
	if(goodsCategoryText != ''){
		category_id_1 = $("#category_id_1").val();
		category_id_2 = $("#category_id_2").val();
		category_id_3 = $("#category_id_3").val();
	}
	var goods_code = $("#goods_code").val();//商品编码
	var selectGoodsLabelId = $("#selectGoodsLabelId").val();//商品标签
	var supplier_id = $("#supplier_id").val();//供货商
	var goods_type = $("#goods_type").val();//商品类型
	var data = 'stock:1,goods_type:1,is_have_sku:1,state:1';
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/config/goodsSelectList'); ?>",
		data : {
			"page_index" : page_index,
			"page_size" : 8,
			"goods_name":search_text,
			"type" : "select",
			"category_id_1" : category_id_1,
			"category_id_2" : category_id_2,
			"category_id_3" : category_id_3,
			"selectGoodsLabelId" : selectGoodsLabelId,
			"supplier_id" : supplier_id,
			"code":goods_code,
			'goods_type' : goods_type,
			"data" : data
		},
		success : function(data) {
			if (data["data"].length > 0) {
				$(".table-class tbody").empty();
				for (var i = 0; i < data["data"].length; i++) {
					var html = '';
					//已经勾选过的要让一直保持选中状态
					var selected = '',checked = '';
					for(var key in goods_id_obj){
						if(goods_id_obj[key] == data["data"][i]["goods_id"]){
							selected = 'selected';
							checked = 'checked';
						}
					}
					html += '<tr align="center">';
						html += '<td>';
								html += '<i class="checkbox-common '+ selected +'"><input value="' + data["data"][i]["goods_id"] + '" name="sub" data-state="'+data["data"][i]["state"]+'" type="checkbox" '+ checked +'></i>';
						html += '</td>';

						html += '<td align="left">' + data["data"][i]["goods_name"] + '</td>';

						html += '<td align="right" class="right-indent">' + data["data"][i]["price"] + '</td>';
						
						html += '<td align="right" class="right-indent">' + data["data"][i]["stock"]  + '</td>';

					html += '</tr>';
					$(".table-class tbody").append(html);
				}
			} else {
				var html = '<tr align="center"><td colspan="4" style="text-align: center;font-weight: normal;color: #999;">暂无符合条件的数据记录</td></tr>';
				$(".table-class tbody").html(html);
			}
			$("#showNumber").val('8').parent().hide();
			initPageData(data["page_count"],data['data'].length,data['total_count']);
			$("#pageNumber").html(pagenumShow(jumpNumber,$("#page_count").val(),<?php echo $pageshow; ?>));
		}
	});
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

//点击显示更多搜索
$(".more-search").click(function(){
	$(".more-search-container").slideToggle();
});

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

function searchData(){
	$(".more-search-container").slideUp();
	LoadingInfo(1);
	$(".one").hide();
	$(".two").hide();
	$(".three").hide();
	confirm();
}

/*
 * 获取选择结果
 */
function getSelectData(){
	var id_str = '';
	var id_arr = [];
	for(var prop in goods_id_obj){
		if(goods_id_obj[prop] != ''){
			id_arr.push(goods_id_obj[prop]);
		}
	}
	id_str = id_arr.toString();
	parent.GoodsCallBack(id_str);
}

/*
 * 1.选择类型切换 如果type的值为1，则变多选为单选
 * 2.组装商品id
 */
$(".table-class input[type='checkbox']").live('click',function(){
	var type = $("#type").val();
	var goods_id = $(this).val();
	var value = $(this).val();
	if(type == '1'){
		$(".table-class input[type='checkbox']").prop('checked',false);
		$(this).prop('checked',true);
		goods_id_obj = {};
		goods_id_obj[goods_id] = goods_id;
	}else{
		var checked = $(this).is(':checked');
		if(value > 0){
			if(checked){
				goods_id_obj[goods_id] = goods_id;
			}else{
				var index = goods_id_obj.indexOf(goods_id);
				if (index > -1) {
				    goods_id_obj.splice(index, 1);
				}
			}
		}else{
			if(checked){
				$(".table-class input[type='checkbox'][value!=0]").each(function(){
					goods_id_obj[$(this).val()] = $(this).val();
					$(this).prop("checked",true);
					$(this).parent().addClass("selected");
				});
			}else{
				$(".table-class input[type='checkbox'][value!=0]").each(function(){
					var curr_id = $(this).val();
					var index = goods_id_obj.indexOf(curr_id);
					if (index > -1) {
					    goods_id_obj.splice(index, 1);
					}
					$(this).prop("checked",false);
					$(this).parent().removeClass("selected");
				})
			}
			
		}
	}
	getSelectData();
});

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

$("#confirmSelect").click(function(){
	$(".one").hide();
	$(".two").hide();
	$(".three").hide();
	$(".selectGoodsCategory").hide().css({
		'width' : 218,
		'right' : 580
	});
});

$(".checkbox-common").live("click",function(){
	var checkbox = $(this).children("input");
	var type = $("#type").val();
	var _this = $(this);
	if(type == '1'){
		$(".table-class input[type='checkbox']").prop('checked',false).parent().removeClass("selected");
	 	checkbox.prop('checked',true).parent().addClass("selected");
	}else{
		if(checkbox.is(":checked")) _this.addClass("selected");
		else _this.removeClass("selected");
	}
});
</script>
</body>
</html>