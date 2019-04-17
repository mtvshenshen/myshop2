var lang = {};
$(function() {

	langApi(["account_cannot_be_empty","password_cannot_empty","verification_code_cannot_be_null","member_enter_correct_phone_format","please_enter_verification_code","current_phone_number_not_registered_yet","send_successfully","dynamic_error_code","get_validation_code","post_resend","phone_number_cannot_empty","dynamic_code_cannot_be_empty"],function(res){
		lang = res;
	});

	$('.nk-cell span').click(function() {
		$('.nk-cell span').removeClass('ns-text-color ns-border-color');
		$(this).addClass('ns-text-color ns-border-color');
	});

	$('.right_login_user').click(function() {
		$("#username").val("");
	});

	$('.right_login_pass').click(function() {
		$("#password").val("");
		$("#password_mobile").val("");
	});

	$('.right_login_mobile').click(function() {
		$("#mobile").val("");
	});

	//找回密码弹窗
	$('#msgback').click(function(){
		$('#mask-layer-login').show();
		$('#layui-layer').show();
	});

	$('#mask-layer-login').click(function(){
		$('#mask-layer-login').hide();
		$('#layui-layer').hide();
	});
});

var member_sub = false;
function check(){
	var username = $("#username").val();
	var password = $("#password").val();
	var login_captcha = $("#login_captcha").val();
	if(username == ''){
		toast(lang.account_cannot_be_empty);
		return false;
	}else if(password == ''){
		toast(lang.password_cannot_empty);
		return false;
	}
	if(login_captcha == ''){
		toast(lang.verification_code_cannot_be_null);
		return false;
	}
	if(login_captcha != '' && login_captcha != undefined){
		var vertification_error = false;
		api("System.Login.checkCaptcha", {vertification : login_captcha}, function(res){
			if(res.data.code < 0){
				toast(res.data.message);
				vertification_error = true;
				$(".verifyimg").click();
			}
		}, false);
		if(vertification_error) return;
	}

	if(member_sub) return;
	member_sub = true;
	api("System.Login.login",{ username : username, password : password},function (res) {
		var data = res.data;
		if(data["code"] >= 0 ){
			$.ajax({
				type: 'post',
				url: __URL(APPMAIN + "/login/index"),
				dataType: "JSON",
				data: {token: data.token},
				success: function (code) {
					if (code == 1) {
						toast("登录成功",__URL(APPMAIN+"/member/index"));
					} else {
						toast("登录失败");
						member_sub = false;
					}
				}
			});
		}else{
			member_sub = false;
			toast(data["message"]);
			$(".verifyimg").attr("src",__URL(SHOPMAIN + "/captcha"));
		}
	});
}

//发送验证码
function sendOutCode(){
	var mobile = $("#mobile").val();
	var vertification = $("#captcha").val();
	//验证手机号格式是否正确
	if(mobile.search(regex.mobile) == -1){
		$("#mobile").trigger("focus");
		toast(lang.member_enter_correct_phone_format);
		return false;
	}
	if(vertification == ''){
		$("#captcha").trigger("focus");
		toast(lang.please_enter_verification_code);
		return false;
	}
	//验证手机号是否已经注册
	api("System.Member.checkMobile",{ mobile : mobile },function (res) {
		var data = res.data;
		if(!data){
			toast(lang.current_phone_number_not_registered_yet);
			$("#mobile_is_has").val(0);
		}else{
			$("#mobile_is_has").val(1);
			//判断输入的验证码是否正确
			api("System.Login.sendRegisterMobileCode",{ "mobile":mobile},function (res) {
				var data = res.data;
				if(data.code==0){
					toast(lang.send_successfully);
					time();
				}else{
					toast(data.message);
					$(".verifyimg").attr("src",__URL(SHOPMAIN + "/captcha"));
				}
			});
		}
	});
}

var wait=120;
function time() {
    if (wait == 0) {
    	$("#sendOutCode").removeAttr("disabled").css({ "border" : "1px solid #FF5073", "color" : "#ff6a88" }).val(lang.get_validation_code);
        wait = 120;
    } else {
    	$("#sendOutCode").attr("disabled", 'disabled').css({ "border" : "1px solid #ccc", "color" : "#ccc" }).val(wait+"s"+ lang.post_resend);
        wait--;
        setTimeout(function() {
            time();
        },
        1000);
    }
}

var mobile_sub = false;
function check_mobile(){
	var mobile = $("#mobile").val();
	var captcha = $("#captcha").val();
	var sms_captcha = $("#sms_captcha").val();
	var mobile_is_has = $("#mobile_is_has").val();
	if(mobile == ''){
		$("#mobile").trigger("focus");
		toast(lang.phone_number_cannot_empty);
		return false;
	}else if(mobile.search(regex.mobile) == -1){
		$("#mobile").trigger("focus");
		toast(lang.member_enter_correct_phone_format);
		return false;
	}else if(mobile_is_has == 0){
		toast(lang.current_phone_number_not_registered_yet);
		return false;
	}else if(sms_captcha == ''){
		toast(lang.dynamic_code_cannot_be_empty);
		return false;
	}
	if(captcha == ''){
		toast(lang.verification_code_cannot_be_null);
		return false;
	}
	if(captcha != '' && captcha != undefined){
		var vertification_error = false;
		api("System.Login.checkCaptcha", {vertification : captcha}, function(res){
			if(res.data.code < 0){
				toast(res.data.message);
				vertification_error = true;
				$(".verifyimg").click();
			}
		}, false);
		if(vertification_error) return;
	}

	if(mobile_sub) return;
	mobile_sub = true;
	api("System.Login.mobileLogin",{"mobile" : mobile, "sms_captcha" : sms_captcha },function (res) {
		var data = res.data;
		if(data["code"] > 0 ){
			$.ajax({
				type: 'post',
				url: __URL(APPMAIN + "/login/index"),
				dataType: "JSON",
				data: {token: data.token},
				success: function (code) {
					if (code == 1) {
						toast('登录成功', __URL(APPMAIN+"/member/index"));
					} else {
						mobile_sub = false;
						toast("登录失败");
					}
				}
			});
		}else if(data["code"] == -10){
			mobile_sub = false;
			toast(lang.dynamic_error_code);
		}else{
			mobile_sub = false;
			toast(data.message);
		}
	});
}
function loginType(obj, type) {
	if(type == 1) {
		$('#account_login').hide();
		$('#mobile_login').show();
		$('#nk_text1').show();
		$('#nk_text2').hide();
		$('#msgback').show();
		$(".js-login-type").text("账户登录");
	}else {
		$('#msgback').hide();
		$('#account_login').show();
		$('#mobile_login').hide();
		$('#nk_text1').hide();
		$('#nk_text2').show();
		$(".js-login-type").text("手机号登录");
	}
}