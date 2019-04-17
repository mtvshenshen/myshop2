<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:46:"template/admin\Goods\dialogSelectCategory.html";i:1552613508;s:65:"D:\phpStudy\WWW\niushop\template\admin\controlCommonVariable.html";i:1552613506;s:52:"D:\phpStudy\WWW\niushop\template\admin\urlModel.html";i:1552613544;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Niushop开源商城</title>
<link rel="stylesheet" type="text/css" href="/template/admin/public/css/product.css">
<script src="/public/static/js/jquery-1.8.1.min.js"></script>
<script src="/template/admin/public/js/art_dialog.source.js"></script>
<script src="/template/admin/public/js/iframe_tools.source.js"></script>
<link rel="stylesheet" type="text/css" href="/public/static/bootstrap/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="/public/static/css/common.css">
<link rel="stylesheet" type="text/css" href="/public/static/css/seller_center.css?n=6">
<link rel="stylesheet" type="text/css" href="/public/static/blue/css/ns_blue_common.css" />
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
<script>
function goodsAddCallBack(){
	var win = art.dialog.open.origin;
	
	var goodsid = "<?php echo $goodsid; ?>";
	var dialog_flag = "<?php echo $flag; ?>";
	var box_id = "<?php echo $box_id; ?>";
	/* var dis = $("#next_Page").attr("disabled");
	if (dis == "disabled") {
		return;
	} */
	var is_disbaled = $("#next_Page").hasClass('disabled');
	if(is_disbaled){
		win.location = "javascript:showTip('请选择完整的分类','warning')";
		return;
	}
	var quick_id = "";// 所选择的商品分类
	var goods_category_name = "";
	var selectSpan = $(".hasSelectedCategoryDiv span").last();
	var spanList = $(".hasSelectedCategoryDiv span");
	var count = spanList.length;
	for (var i = 1; i < count; i++) {
		var span = $(spanList[i]);
		var html = span.html();
		goods_category_name += html;
		quick_id += span.attr("cid") + ",";// 记录用户所选择的商品类目Id，用与在快速选择商品类目中显示
	}
	var goods_category_id = selectSpan.attr("cid");
	var goods_attr_id = selectSpan.attr("data-attr-id");//属性关联id
	quick_id = quick_id.substr(0, quick_id.length - 1);
	
	goods_category_name = goods_category_name.replace(/\s/g, "");
	
	// 判断当前所选择的商品分类与Cookie中的进行查询，是否存在，不存在则添加，
	var flag = true;// 标识，是否允许添加到Cookie中（防止出现重复数据）true:允许；flase：不允许
	if (goods_category_quick.length > 0) {
		for (var k = 0; k < goods_category_quick.length; k++) {
			if (quick_id == goods_category_quick[k]["quick_id"]) {
				flag = false;
				break;
			} else {
				flag = true;
			}
		}
	}
	// 允许添加到到Cookie中
	if (flag) {
		var json = {
			quick_name : $.trim(goods_category_name),
			quick_id : quick_id,
		};
		goods_category_quick.push(json);
		// alert("Cookie中没有，开始添加");
	} else {
		// alert("Cookie中已有，不进行重复添加操作");
	}
	$.ajax({
		url : "<?php echo __URL('http://127.0.0.1:8080/index.php/admin/goods/selectcategetdata'); ?>",
		type : "post",
// 		asysc : false,
		data : {
			"goods_category_id" : goods_category_id,
			"goods_category_name" : goods_category_name,
			"goods_category_quick" : JSON.stringify(goods_category_quick),
			"goods_attr_id" : goods_attr_id
		},
		success : function(res) {
		}
	});
	var win = art.dialog.open.origin;
	win.location = "javascript:addGoodsCallBack(" + goods_category_id + ",'" + goods_category_name + "'," + goods_attr_id + ","+goodsid+",'"+dialog_flag+"','"+ box_id +"')";
	art.dialog.close();
}

//取消退出
function no_select_back(){
	art.dialog.close();
}

</script>
</head>
<body style="background-color:#fff !important;">
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
<script type="text/javascript" src="/template/admin/public/js/goods/release_good_frist.js?n=7"></script>
<input type="hidden" value="<?php echo $category_select_ids; ?>" id="category_select_ids"/>
<input type="hidden" value="<?php echo $category_select_names; ?>" id="category_select_names"/>
<input type="hidden" value="<?php echo $category_extend_id; ?>" id="category_extend_id"/>
<div class="product-category">
	<div id="selectDiv" class="selectCat">
		<div class="sort_selector">
			<div class="sort_title">
				<span>您常用的商品分类：</span>
				<div class="text" id="commSelect">
					<div style="padding-left: 10px;">请选择</div>
					<div class="select_list" id="commListArea"></div>
				</div>
				<i class="icon-angle-down"></i>
			</div>
		</div>
		<div id="categoryDivContainer" class="categoryContainer">
			<div id="selectCategoryDiv1" class="selectCategoryDiv" >
<!-- 				<div class="category-search"> -->
<!-- 					<i class="icon-search-tabao"></i> -->
<!-- 					<input type="text" name="search_category" placeholder="输入名称" /> -->
<!-- 				</div> -->
				<div class="categorySet">
					<?php if(is_array($cateGoryList) || $cateGoryList instanceof \think\Collection || $cateGoryList instanceof \think\Paginator): if( count($cateGoryList)==0 ) : echo "" ;else: foreach($cateGoryList as $key=>$category): ?>
					<div class="categoryItem " id="<?php echo $category['category_id']; ?>" data-attr-id="<?php echo $category['attr_id']; ?>" onclick="ClickHasSubCategory(this)">
						<span class="span-left"><?php echo $category['category_name']; ?></span>
						<?php if($category['is_parent'] == 1): ?>
						<span class="span-right">&gt;</span>
						<?php endif; ?>
					</div>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
			</div>
			<div id="selectCategoryDiv2" class="selectCategoryDiv" ></div>
			<div id="selectCategoryDiv3" class="selectCategoryDiv" ></div>
		</div>
		<div class="cate-path">
			<div class="hasSelectedCategoryDiv">
				<span class="hasSelectedCategoryDivText">您当前选择的是：</span>
			</div>
		</div>
	</div>
	<div class="div-btn">
		<button class="btn-common btn-big disabled" onclick="goodsAddCallBack()" id="next_Page">保存</button>
		<button class="btn-common-cancle btn-big" onclick="no_select_back()">取消</button>
	</div>
</div>
</body>
</html>