var isClick = false;

var memberInfoOperation = {
	field: {},
	url: {
		'password': 'System.Member.modifyPassword',
		'mobile': 'System.Member.modifyMobile',
		'email': 'System.Member.modifyemail',
	},
	confirm: function (event) {
		this.getFieldValue(event);
		
		if (this.verification(1)) {
			if (isClick) return;
			isClick = true;
			this.submit();
		}
	},
	// 表单提交
	submit: function () {
		var self = this;
		
		api(self.url[self.type], self.field, function (res) {
			sendCodeId = 0;
			isClick = false;
			if (res.code >= 0) {
				location.href = __URL(SHOPMAIN + '/member/security');
			}else{
				show(res.message);
			}
		});
	},
	// 数据验证
	verification: function (is_submit) {
		var self = this,
			field = this.field;
		
		if (self.type == 'password') {
			if (field.old_password == '') {
				show('请输入原密码');
				return false;
			}
			if (field.new_password == '') {
				show('请输入新密码');
				return false;
			}
			if (field.re_new_password != field.new_password) {
				show('两次输入的密码不一致');
				return false;
			}
		}	
		
		if (self.type == 'mobile') {
			if (field.mobile == '') {
				show('手机号不能为空');
				return false;
			} else if (field.mobilephone.search(regex.mobile) == -1) {
				show('手机号格式不正确');
				return false;
			}
			
			if (is_submit) {
				if (field.code == '') {
					show('请输入动态码');
					return false;
				}
			}
		}
		
		if (self.type == 'email') {
			if (field.email == '') {
				show('邮箱不能为空');
				return false;
			} else if (field.email.search(regex.email) == -1) {
				show('邮箱格式不正确');
				return false;
			}
			if (is_submit) {
				if (field.code == '') {
					show('请输入动态码');
					return false;
				}
			}
		}

		if (field.captcha == '') {
			show('请输入验证码');
			return false;
		}
		
		return true;
	},
	// 获取表单数据
	getFieldValue: function (event) {
		var self = this;
		
		var formObj = $(event).parents('.form-horizontal');
		
		if (formObj.find('[name]').length > 0) {
			
			formObj.find('[name]').each(function () {
				var name = $(this).attr('name'),
					value = $(this).val();
				self['field'][name] = value;
			})
		}
	},
	// 发送短信验证码
	sendSmsCaptcha: function (event) {
		this.getFieldValue(event);
		
		var mobile_name = $("input[name='mobile']").val();
		var mobile_code = $("input[name='captcha']").val();
		if (mobile_name == '') {
			show('手机号不能为空');
			return false;
		} else if (mobile_name.search(regex.mobile) == -1) {
			show('手机号格式不正确');
			return false;
		}
		
		if(mobile_code == ''){
			show('请输入验证码');
			return false;
		}
		
		api("System.Login.checkCaptcha", {vertification : mobile_code}, function(res){
			if(res.data.code < 0){
				show(res.data.message);
				$(".verifyimg").attr("src", __URL(SHOPMAIN + '/captcha?tag=1&send=' + Math.random()));
				vertification_error = true;
			}else{
				api('System.Member.sendBindCode', {
					"mobile": mobile_name,
					"type": "mobile"
				}, function (res) {
					if (res.data.code >= 0) {
						sendCodeId = res.data;
						countDown(event);
					} else {
						show(res.data.message);
					}
				}, false)
			}
		}, false);
	},
	// 发送邮箱验证码
	sendEmailCaptcha: function (event) {
		this.getFieldValue(event);
		
		var email_name = $("input[name='email']").val();
		var email_code = $("input[name='captcha']").val();
		if (email_name == '') {
			show('邮箱不能为空');
			return false;
		} else if (email_name.search(regex.email) == -1) {
			show('邮箱格式不正确');
			return false;
		}
		
		if(email_code == ''){
			show('请输入验证码');
			return false;
		}
		
		api("System.Login.checkCaptcha", {vertification : email_code}, function(res){
			if(res.data.code < 0){
				show(res.data.message);
				$(".verifyimg").attr("src", __URL(SHOPMAIN + '/captcha?tag=1&send=' + Math.random()));
				vertification_error = true;
			}else{
				api('System.Member.sendBindCode', {
					"email": email_name,
					"type": "email"
				}, function (res) {
					if (res.data.code >= 0) {
						sendCodeId = res.data;
						countDown(event);
					} else {
						show(res.data.message);
					}
				}, false)
			}
		}, false);
	}
};

// 倒计时
function countDown(chageObj, oldText, time) {
	var time = time != undefined ? time : 120,
		oldText = oldText != undefined ? oldText : '获取动态码',
		text = time + 's后重新获取';
	
	if (time > 0) {
		$(chageObj).text(text).addClass('disabled');
		time -= 1;
		setTimeout(function () {
			countDown(chageObj, oldText, time);
		}, 1000);
	} else {
		$(chageObj).text(oldText).removeClass('disabled');
	}
}