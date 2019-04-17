//初始化语言包
var login_data = {};
$(function () {
	
	lang(['enter_your_account_number', 'please_input_password', 'please_enter_verification_code'], function (res) {
		login_data = res;
	});
	
	document.onkeypress = function (e) {
		if (e.keyCode == 13) $("#btn_login").click();
	};
});

// 检验账号，密码和验证码是否是正确的
var is_flag = false;
function login() {
	var user_name = $.trim($('#user_name').val());
	var password = $.trim($('#password').val());
	var vertification = $.trim($('#vertification').val());
	if (user_name == null || user_name == "") {
		show(login_data.enter_your_account_number);
		$("#userName").focus();
		return;
	}
	if (password == null || password == "") {
		show(login_data.please_input_password);
		$("#password").focus();
		return;
	}
	if(is_flag) return false;
	is_flag = true;
	if ($("#hidden_verify_pc").val() == 1) {
		if (vertification == null || vertification == "") {
			show(login_data.please_enter_verification_code);
			$("#vertification").focus();
			return;
		}
		var vertification_error = false;
		api("System.Login.checkCaptcha", {vertification : vertification}, function(res){
			if(res.data.code < 0){
				show(res.data.message);
				$("#verify_img").attr("src", __URL(SHOPMAIN + '/captcha?tag=1&send=' + Math.random()));
				vertification_error = true;
				is_flag = false;
			}
		}, false);

		if(vertification_error) return;
	}
	
	api("System.Login.login", {
		"username": user_name,
		"password": password
	}, function (res) {
		var data = res.data;
		if (data['code'] < 0) {
			show(data['message']);
			$("#verify_img").attr("src", __URL(SHOPMAIN + '/captcha?tag=1&send=' + Math.random()));
			is_flag = false;
		} else {
			$.ajax({
				type: 'post',
				url: __URL(SHOPMAIN + "/login/index"),
				dataType: "JSON",
				data: {token: data.token},
				success: function (code) {
					if (code == 1) {
						location.href = __URL(SHOPMAIN + "/index/index");
					} else {
						show("登录失败");
						is_flag = false;
					}
				}
			});
		}
	});
}