<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:31:"template/admin\Login\login.html";i:1552613549;s:52:"D:\phpStudy\WWW\niushop\template\admin\urlModel.html";i:1552613544;s:65:"D:\phpStudy\WWW\niushop\template\admin\controlCommonVariable.html";i:1552613506;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="renderer" content="webkit" />
	<meta http-equiv="X-UA-COMPATIBLE" content="IE=edge,chrome=1"/>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title><?php echo $title_name; ?></title>
	<meta name="keywords" content="<?php echo $title_name; ?>" />
	<meta name="description" content="<?php echo $title_name; ?>" />
	<meta name="author" content="<?php echo $title_name; ?>网站" />
	<link rel="shortcut  icon" type="image/x-icon" href="/public/static/images/favicon.ico" media="screen"/>
	<script src="/public/static/js/jquery-1.8.1.min.js"></script>
	<script src="/public/static/bootstrap/js/bootstrap.js"></script>
	<link href="/template/admin/public/css/new_member_login.css" rel="stylesheet" type="text/css" />
	<script src="/public/static/js/load_bottom.js" type="text/javascript"></script>
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
<div class="admin-login-box">
	<div class="login-content-area">
		<div class="w1100">
			<div class="left-logo-area">
	<!-- 			<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/index'); ?>" class="logo-img"> -->
	<!-- 				<img src="/template/admin/public/images/login-logo.png" alt="" /> -->
	<!-- 			</a> -->
				
				<img src="/template/admin/public/images/login-img.png" alt="" />
			</div>
			<div class="right-login-area">
				<form action="javascript:;">
					<div class="login-logo"><img src="/template/admin/public/images/login-logo-icon.png"></div>
					<div class="tip_info">
						<div class="prompt_information" id="hint">
							账号密码错误
						</div>
					</div>
					<!-- 用户名 -->
					<div class="user-name-box">
						<div class="username_bg" ></div>
						<input type="text" placeholder="请输入账号" id="txtName"/>
					</div>
					<!-- 密码框 -->
					<div class="password-box">
						<div class="password_bg" ></div>
						<input type="password" placeholder="请输入密码" id="txtPWD"/>
					</div>
					<!-- 验证码 -->
					<div class="verification-code-box" <?php if(!$is_need_verification): ?>style="display:none;"<?php endif; ?>>
						<input type="text" placeholder="请输入验证码" id="vertification"/>
						<div class="verification-code-img">
							<img id="verify_img" src="<?php echo __URL('http://127.0.0.1:8080/index.php/captcha'); ?>" alt="captcha" onclick="this.src='<?php echo __URL('http://127.0.0.1:8080/index.php/captcha?tag=1'); ?>'+'&send='+Math.random()" />
						</div>
					</div>
					<input type="button" value="登录" class="sub_login" onclick="btnlogin();" />
				</form>
			</div>
		</div>
	</div>
	<div class="txt" id="bottom_copyright">
		<p><span id="copyright_desc"></span>
		<br><a href="http://www.niushop.com.cn" target="_blank" style="text-decoration: none;color:#666;" id="copyright_companyname"></a>&nbsp;&nbsp;&nbsp;&nbsp;
			<label id="copyright_meta"></label>
		</p>
	</div>
</div>
<script>
	$(function(){
		ini_margin_top();
	})

	window.onresize = function(){
		ini_margin_top();
	}
	function ini_margin_top(){
		var admin_login_box_height = $(".admin-login-box").height();
		var login_content_area_height = 590;
		//console.log(admin_login_box_height);
		//console.log(login_content_area_height);
		var margin_top = (admin_login_box_height - login_content_area_height)/2;
		$(".login-content-area").css("margin", margin_top+"px auto 0 auto");
		if(admin_login_box_height < 800){
			$(".txt").hide();
		}else{
			$(".txt").show();
		}
	}
	// enter 键登录
	document.onkeypress = function() {
		var iKeyCode = -1;
		if (arguments[0]) {
			iKeyCode = arguments[0].which;
		} else {
			iKeyCode = event.keyCode;
		}
		if (iKeyCode == 13) {
			// 登录
			$(".sub_login").click();
		}
	}
	//键盘tab
	$(document).keyup(function(e){
        var key =  e.which;
        if(key == 9){
        	check_is_focus();
        }
    });

	$("body").click(function(){
		check_is_focus();
	})

	function check_is_focus(){
		if($("#txtName").is(":focus")){
			$("#txtName").parent("div").css("border-color","#0072D3");
		}else{
			$("#txtName").parent("div").css("border-color","#D9D9D8");
		}
		if($("#txtPWD").is(":focus")){
			$("#txtPWD").parent("div").css("border-color","#0072D3");
		}else{
			$("#txtPWD").parent("div").css("border-color","#D9D9D8");
		}
		if($("#vertification").is(":focus")){
			$("#vertification").parent("div").css("border-color","#0072D3");
		}else{
			$("#vertification").parent("div").css("border-color","#D9D9D8");
		}
	}

	// 登陆 登录时 登录按钮"变暗"
	function btnlogin() {
		ClearCookie(); //登录时清除之前的cookie
		if ($("#txtName").val() == "") {
			$("#hint").css("display", "block").text("请输入账号");
			$("#txtName").focus();
			return false;
		} else if ($("#txtPWD").val() == "") {
			$("#hint").css("display", "block").text("请输入密码");
			$("#txtPWD").focus();
			return false;
		}
		var userName = $('#txtName').val();
		var password = $('#txtPWD').val();
		var vertification = $("#vertification").val();

		if(!$(".verification-code-box").is(":hidden")){
			if($("#vertification").val() == undefined || $("#vertification").val() == ""){
				$("#hint").css("display", "block").text("请输入验证码");
				$("#vertification").focus();
				return false;
			}
		}

		// 后台验证
		$.post(__URL("http://127.0.0.1:8080/index.php/admin/login/login"), {
			"userName" : userName,
			"password" : password,
			"vertification" : vertification
		}, function(data) {
			if (data['code'] > 0) {
				$("#hint").css("display", "none");
				$(".sub_login").attr("disabled", "disabled");
				window.location.href = __URL("http://127.0.0.1:8080/index.php/admin");
			} else {
				var error_num = <?php echo $login_verify_code['error_num']; ?>;
				if(error_num != 0 && data['error_num'] >= error_num){
					$(".verification-code-box").show();
					$("#verify_img").attr("src",'<?php echo __URL('http://127.0.0.1:8080/index.php/captcha?tag=1'); ?>&send='+Math.random());
				}
				$("#txtValidate").val("");
				$("#hint").text(data['message']).show(); //  用户名密码提示
			}
		});
	}

	function ClearCookie() {
		var expires = new Date();
		expires.setTime(expires.getTime() - 1000);
		document.cookie = "appCode='';path=/;expires=" + expires.toGMTString() + "";
		document.cookie = "roleID='';path=/;expires=" + expires.toGMTString() + "";
		document.cookie = "parentMenuID='';path=/;expires=" + expires.toGMTString() + "";
		document.cookie = "currentMenuName='';path=/;expires=" + expires.toGMTString() + "";
	}
</script>
</body>
</html>