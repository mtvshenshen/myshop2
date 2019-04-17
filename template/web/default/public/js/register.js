//初始化语言包
var register_data = [];

//防止重复发生检验码
var is_click = false;

//等待校验码时间单位：秒
var wait = 120;

$(function () {
	
	lang(["user_name_already_exists", "mailbox", "get_mailbox_check_code", "mailbox_check_code", "member_enter_email_address", "get_sms_check_code", "sms_check_code", "member_phone_number", "member_enter_your_phone_number", "please_enter_your_user_name", "password_must_contain_symbols", "password_must_have_lowercase_letters", "password_must_have_uppercase_letters", "password_must_contain_numbers", "user_name_length", "minimum_password_length", "password_cannot_includ_chinese_characters", "password_cannot_empty", "user_name_already_exists", "two_password_not_same", "have_not_agreed_registration_agreement", "username_cannot_includ_chinese_characters", "user_name", "user_name_canno_be_mailbox", "user_name_canno_be_phone", "such_characters", "phone_has_been_registered", "mailbox_has_been_registered", "member_enter_correct_phone_format", "member_enter_correct_email_format", "send_successfully", "mailbox_number_has_been_registered", "post_resend", "get_validation_code", "two_input_is_inconsistent", "sms_verification_code_error", "mailbox_checksum_error"], function (res) {
		register_data = res;
	});
	
	$(".nav-tabs > li:first").addClass("active");
	
	$(".nav-tabs > li").click(function () {
		var type = $(this).data("type");
		
		//切换注册方式，要清空账户
		$("#account").removeClass("ns-border-color").val("");
		$("#account_verify").hide();
		switch (type) {
			case "general":
				$(".check-code").hide();
				$(".js-label").text(register_data.user_name + "：");
				$("#account").attr("placeholder", register_data.please_enter_your_user_name);
				break;
			case "mobile":
				$(".check-code").show();
				$(".js-label").text(register_data.member_phone_number + "：");
				$("#account").attr("placeholder", register_data.member_enter_your_phone_number);
				$(".check-code-name").text(register_data.sms_check_code);
				$(".check-code-btn").text(register_data.get_sms_check_code);
				break;
			case "email":
				$(".check-code").show();
				$(".js-label").text(register_data.mailbox + "：");
				$("#account").attr("placeholder", register_data.member_enter_email_address);
				$(".check-code-name").text(register_data.mailbox_check_code);
				$(".check-code-btn").text(register_data.get_mailbox_check_code);
				break
		}
	});
	
	$("#account").change(function () {
		verify(true);
	});
	
	$("#btn_submit").click(function () {
		var account = $("#account").val();
		var password = $("#password").val();
		var verify_code = $("#verify_code").val();
		var code = $("#code").val();
		var type = $(".nav-tabs > li.active").data("type");
		var flag = false;
		if (verify()) {
			if (flag) return;
			flag = true;
			switch (type) {
				case "general":
					//普通
					api("System.Login.usernameRegister", {
						"username": account,
						"password": password
					}, function (res) {
						var data = res.data;
						if (data.code > 0) {
							$.ajax({
								type: 'post',
								url: __URL(SHOPMAIN + "/login/index"),
								dataType: "JSON",
								async : false,
								data: {token: data.token},
								success: function (code) {
									if (code == 1) {
										location.href = __URL(SHOPMAIN + "/index/index");
									}
								}
							});
						} else {
							show(data.message);
							flag = false;
						}
					});
					break;
				case "mobile":
					//手机
					if ($("#hidden_notice_mobile").val() == 1) {
						var check = false;
						api("System.Login.CheckRegisterMobileCode", {'send_param': code}, function (res) {
							var data = res.data;
							if (data['code'] != 0) {
								show(register_data.sms_verification_code_error);
								check = true;
							}
						}, false);
						if (check) {
							flag = false;
							return false;
						}
					}
					api("System.Login.mobileRegister", {
						mobile: account,
						password: password,
						mobile_code: code
					}, function (res) {
						var data = res.data;
						if (data.code > 0) {
							$.ajax({
								type: 'post',
								url: __URL(SHOPMAIN + "/login/index"),
								dataType: "JSON",
								async : false,
								data: {token: data.token},
								success: function (code) {
									if (code == 1) {
										location.href = __URL(SHOPMAIN + "/index/index");
									}
								}
							});
						} else {
							show(data.message);
							flag = false;
						}
					});
					break;
				case "email":
					//邮箱
					
					if ($("#hidden_notice_email").val() == 1) {
						var check = false;
						api("System.Login.CheckRegisterEmailCode", {'send_param': code}, function (res) {
							var data = res.data;
							if (data['code'] != 0) {
								show(register_data.mailbox_checksum_error);
								check = true;
							}
						}, false);
						if (check) {
							flag = false;
							return false;
						}
					}
					
					api("System.Login.emailRegister", {
						"email": account,
						"password": password,
						"email_code": code,
					}, function (res) {
						var data = res.data;
						if (data.code > 0) {
							$.ajax({
								type: 'post',
								url: __URL(SHOPMAIN + "/login/index"),
								dataType: "JSON",
								async : false,
								data: {token: data.token},
								success: function (code) {
									if (code == 1) {
										location.href = __URL(SHOPMAIN + "/index/index");
									}
								}
							});
						} else {
							show(data.message);
							flag = false;
						}
					});
					break
			}
		}
		
	});
	
	$("#sendOutCode").click(function () {
		var account = $("#account").val();
		var type = $(".nav-tabs > li.active").data("type");
		
		if (is_click) return;
		
		if (type == "mobile") {
			if (account.search(regex.mobile) == -1) {
				show('请输入正确的手机号');
				return;
			}
			
			// 验证码
			if ($("#hidden_verify_pc").val() == 1) {
				var verify_code = $("#verify_code").val();
				if (verify_code == "") {
					$('#verify_code').addClass("ns-border-color").focus();
					$("#code_error").addClass("ns-text-color").text("请输入验证码");
					return false;
				} else {
					var vertification_error = false;
					api("System.Login.checkCaptcha", {vertification : $('#verify_code').val()}, function(res){
						if(res.data.code < 0){
							show(res.data.message);
							vertification_error = true;
						}
					}, false);

					if(vertification_error) {
						$('#verify_code').addClass("ns-border-color").focus();
						$("#code_error").addClass("ns-text-color").text("验证码错误");
						$(".verifyimg").attr("src", __URL(SHOPMAIN + '/captcha?tag=1&send=' + Math.random()));
						return false;
					}else{
						$('#verify_code').removeClass("ns-border-color");
						$("#code_error").text("");
					}
				}
			}
			
			
			is_click = true;

			api("System.Login.sendRegisterMobileCode", {
				"mobile": account
			}, function (res) {
				var data = res.data;
				if (data["code"] == 0) {
					$("#account_verify").text(register_data.send_successfully).show();
					time();
				} else {
					show(data["message"]);
					$(".verifyimg").attr("src", __URL(SHOPMAIN + '/captcha?tag=1&send=' + Math.random()));
					is_click = false;
				}
			});
		} else if (type == "email") {
			if (account.search(regex.email) == -1) {
				show('请输入正确的邮箱');
				return;
			}
			// 验证码
			if ($("#hidden_verify_pc").val() == 1) {
				var verify_code = $("#verify_code").val();
				if (verify_code == "") {
					$('#verify_code').addClass("ns-border-color").focus();
					$("#code_error").addClass("ns-text-color").text("请输入验证码");
					return false;
				} else {
					var vertification_error = false;
					api("System.Login.checkCaptcha", {vertification : $('#verify_code').val()}, function(res){
						if(res.data.code < 0){
							show(res.data.message);
							vertification_error = true;
						}
					}, false);

					if(vertification_error) {
						$('#verify_code').addClass("ns-border-color").focus();
						$("#code_error").addClass("ns-text-color").text("验证码错误");
						$(".verifyimg").attr("src", __URL(SHOPMAIN + '/captcha?tag=1&send=' + Math.random()));
						return false;
					}else{
						$('#verify_code').removeClass("ns-border-color");
						$("#code_error").text("");
					}
				}
			}
			
			
			is_click = true;

			api("System.Login.sendRegisterEmailCode", {
				"email": account,
			}, function (res) {
				var data = res.data;
				if (data['code'] == 0) {
					$("#account_verify").text(register_data.send_successfully).show();
					time();
				} else {
					show(data["message"]);
					$(".verifyimg").attr("src", __URL(SHOPMAIN + '/captcha?tag=1&send=' + Math.random()));
					is_click = false;
				}
			});
		}
	});
});

//验证密码
function verifyPassword(password) {
	var is_true = 0;
	var min_length_str = $("#hidden_pwd_len").val();
	var min_length = 5;
	if ($.trim(min_length_str) != "") {
		min_length = parseInt(min_length_str);
	}
	if ($.trim(password) == "") {
		is_true = 1;
		$("#password").trigger("focus").addClass("ns-border-color");
		$("#password_verify").text(register_data.password_cannot_empty).show();
		return is_true;
	} else {
		$("#password").removeClass("ns-border-color");
		$("#password_verify").hide();
	}
	if (min_length > 0) {
		if (password.length < min_length) {
			is_true = 1;
			$("#password").trigger("focus").addClass("ns-border-color");
			$("#password_verify").text(register_data.minimum_password_length + min_length).show();
			return is_true;
		} else {
			$("#password").removeClass("ns-border-color");
			$("#password_verify").hide();
		}
		
	}
	
	var regex_str = $("#hidden_pwd_complexity").val();
	if ($.trim(regex_str) != "") {
		//验证是否包含数字
		if (regex_str.indexOf("number") >= 0) {
			var number_test = /[0-9]/;
			if (!number_test.test(password)) {
				is_true = 1;
				$("#password").trigger("focus").addClass("ns-border-color");
				$("#password_verify").text(register_data.password_must_contain_numbers).show();
				return is_true;
			} else {
				$("#password").removeClass("ns-border-color");
				$("#password_verify").hide();
			}
		}
		//验证是否包含小写字母
		if (regex_str.indexOf("letter") >= 0) {
			var letter_test = /[a-z]/;
			if (!letter_test.test(password)) {
				is_true = 1;
				$("#password").trigger("focus").addClass("ns-border-color");
				$("#password_verify").text(register_data.password_must_have_lowercase_letters).show();
				return is_true;
			} else {
				$("#password").removeClass("ns-border-color");
				$("#password_verify").hide();
			}
		}
		//验证是否包含大写字母
		if (regex_str.indexOf("upper_case") >= 0) {
			var upper_case_test = /[A-Z]/;
			if (!upper_case_test.test(password)) {
				is_true = 1;
				$("#password").trigger("focus").addClass("ns-border-color");
				$("#password_verify").text(register_data.password_must_have_uppercase_letters).show();
				return is_true;
			} else {
				$("#password").removeClass("ns-border-color");
				$("#password_verify").hide();
			}
		}
		//验证是否包含特殊字符
		if (regex_str.indexOf("symbol") >= 0) {
			var symbol_test = /[^A-Za-z0-9]/;
			if (!symbol_test.test(password)) {
				is_true = 1;
				$("#password").trigger("focus").addClass("ns-border-color");
				$("#password_verify").text(register_data.password_must_contain_symbols).show();
				return is_true;
			} else {
				$("#password").removeClass("ns-border-color");
				$("#password_verify").hide();
			}
		}
	}
	return is_true;
}

function time() {
	if (wait == 0) {
		$("#sendOutCode").removeAttr("disabled").text(register_data.get_validation_code);
		wait = 120;
		is_click = false;
	} else {
		$("#sendOutCode").attr("disabled", 'disabled').text(wait + "s" + register_data.post_resend);
		wait--;
		setTimeout(function () {
			time()
		}, 1000);
	}
}

/**
 * 验证
 * @param verify_account 是否只验证account
 * @returns {boolean}
 */
function verify(verify_account) {
	
	var type = $(".nav-tabs > li.active").data("type");
	var account = $("#account").val();
	var password = $("#password").val();
	var repassword = $("#repassword").val();
	var verify_code = $("#verify_code").val();
	var exist = 0;//0 不存在 1 已存在
	var code = $("#code").val();
	switch (type) {
		case "general":
			//普通
			if (!(account.length >= 3 && account.length <= 16)) {
				$("#account").trigger("focus").addClass("ns-border-color");
				$("#account_verify").text(register_data.user_name_length).show();
				return false;
			} else if (/.*[\u4e00-\u9fa5]+.*$/.test(account)) {
				$("#account").trigger("focus").addClass("ns-border-color");
				$("#account_verify").text(register_data.username_cannot_includ_chinese_characters).show();
				return false;
			} else {
				$('#account').removeClass("ns-border-color");
				$("#account_verify").hide();
				api("System.Member.checkUsername", {"username": account}, function (res) {
					var data = res.data;
					if (data) {
						$("#account").addClass("ns-border-color");
						$("#account_verify").text(register_data.user_name_already_exists).show();
						exist = 1;
					}
				}, false);
			}
			
			if (exist == 1) return false;
			
			//排除要注册的关键词
			var username_verify = $("hidden_name_keyword").val();
			var usernme_verify_array = new Array();
			if ($.trim(username_verify) != "" && username_verify != undefined) {
				usernme_verify_array = username_verify.split(",");
			}
			usernme_verify_array.push(",");
			usernme_verify_array.push(" ");
			$.each(usernme_verify_array, function (k, v) {
				if (account.indexOf(v) >= 0) {
					$("#account").trigger("focus").addClass("ns-border-color");
					$("#account_verify").text(register_data.username_cannot_includ + v + register_data.such_characters).show();
					return false;
				}
			});
			
			break;
		case "mobile":
			//手机
			if (account.search(regex.mobile) == -1) {
				$("#account").trigger("focus").addClass("ns-border-color");
				$("#account_verify").text(register_data.member_enter_correct_phone_format).show();
				return false;
			} else {
				$("#account").trigger("focus").removeClass("ns-border-color");
				$("#account_verify").hide();
				api("System.Member.checkMobile", {"mobile": account}, function (res) {
					var data = res.data;
					if (data) {
						$("#account").addClass("ns-border-color");
						$("#account_verify").text(register_data.phone_has_been_registered).show();
						exist = 1;
					}
				}, false);
			}
			if (exist == 1) return false;
			break;
		case "email":
			//邮箱
			if (account.search(regex.email) == -1) {
				$("#account").trigger("focus").addClass("ns-border-color");
				$("#account_verify").text(register_data.member_enter_correct_email_format).show();
				return false;
			} else {
				$("#account").trigger("focus").removeClass("ns-border-color");
				$("#account_verify").hide();
				api("System.Member.checkEmail", {"email": account}, function (res) {
					var data = res.data;
					if (data) {
						$("#account").addClass("ns-border-color");
						$("#account_verify").text(register_data.mailbox_has_been_registered).show();
						exist = 1;
					}
				}, false);
			}
			if (exist == 1) return false;
			break
	}
	
	if (verify_account) return false;
	
	var is_password_true = verifyPassword(password);
	if (is_password_true > 0) return false;
	if (!(repassword == password)) {
		$("#repassword").trigger("focus").addClass("ns-border-color");
		$("#repassword_verify").text(register_data.two_password_not_same).show();
		return false;
	} else {
		$('#repassword').removeClass("ns-border-color");
		$("#repassword_verify").hide();
	}
	
	// 验证码
	if ($("#hidden_verify_pc").val() == 1 && type == 'general') {
		if (verify_code == "") {
			$('#verify_code').addClass("ns-border-color").focus();
			$("#code_error").addClass("ns-text-color").text("请输入验证码");
			return false;
		} else {
			var vertification_error = false;
			api("System.Login.checkCaptcha", {vertification : $('#verify_code').val()}, function(res){
				if(res.data.code < 0){
					show(res.data.message);
					vertification_error = true;
				}
			}, false);

			if(vertification_error) {
				$('#verify_code').addClass("ns-border-color").focus();
				$("#code_error").addClass("ns-text-color").text("验证码错误");
				$(".verifyimg").attr("src", __URL(SHOPMAIN + '/captcha?tag=1&send=' + Math.random()));
				return false;
			}else{
				$('#verify_code').removeClass("ns-border-color");
				$("#code_error").text("");
			}
		}
	}
	
	if (type == "mobile" || type == "email") {
		if ($("#hidden_notice_email").val() == 1 || $("#hidden_notice_mobile").val() == 1) {
			if (code.length != 6) {
				$("#code").trigger("focus").addClass("ns-border-color");
				show("校检码不正确");
				return false;
			}
		}
	}
	
	if (!$("#remember").prop("checked")) {
		show(register_data.have_not_agreed_registration_agreement);
		return false;
	}
	
	return true;
}


function agreementShow(){
	$('#myModal').modal();
}
