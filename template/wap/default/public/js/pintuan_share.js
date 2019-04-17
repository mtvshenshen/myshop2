$(function(){
	$(".mask-layer-bg,.mask-layer-invite-friends").click(function(){
		$(".mask-layer-bg,.mask-layer-invite-friends").hide();
	});
	$("#invite_friends").click(function(){
		$(".mask-layer-bg,.mask-layer-invite-friends").show();
	});
	
	wx.config({
		debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
		appId: $("#appId").val(), // 必填，公众号的唯一标识
		timestamp: $("#jsTimesTamp").val(), // 必填，生成签名的时间戳
		nonceStr:  $("#jsNonceStr").val(), // 必填，生成签名的随机串
		signature: $("#jsSignature").val(),// 必填，签名，见附录1
		jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ', 'onMenuShareWeibo'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
	});
	wx.ready(function() {
		var title = "{$info['share_content']['share_title']}";
		var share_contents = "{$info['share_content']['share_contents']}"+'\r\n';
		var share_nick_name = "{$info['share_content']['share_nick_name']}"+'\r\n';
		var desc2 = share_contents+ share_nick_name + "收藏热度：★★★★★";
		var share_url = "{$info['share_content']['share_url']}";
		var img_url = "{$info['share_logo']}";
		wx.onMenuShareAppMessage({
			title: title,
			desc: desc2,
			link: share_url,
			imgUrl: img_url,
			trigger: function (res) {
				//alert('用户点击发送给朋友');
			},
			success: function (res) {
				//alert('已分享213');
				api('System.Member.shareReward', {"share" : true,"share_url":share_url}, function() {});
			},
			cancel: function (res) {
				//alert('已取消');
			},
			fail: function (res) {
				//alert(JSON.stringify(res));
			}
		});
		// 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口
		wx.onMenuShareTimeline({
			title: title,
			link: share_url,
			imgUrl: img_url,
			trigger: function (res) {
				// alert('用户点击分享到朋友圈');
			},
			success: function (res) {
				//alert('已分享');
				api('System.Member.shareReward', {"share" : true,"share_url":share_url}, function() {});
			},
			cancel: function (res) {
				//alert('已取消');
			},
			fail: function (res) {
				// alert(JSON.stringify(res));
			}
		});
		
		// 2.3 监听“分享到QQ”按钮点击、自定义分享内容及分享结果接口
		wx.onMenuShareQQ({
			title: title,
			desc: desc2,
			link: share_url,
			imgUrl: img_url,
			trigger: function (res) {
				//alert('用户点击分享到QQ');
			},
			complete: function (res) {
				//alert(JSON.stringify(res));
			},
			success: function (res) {
				//alert('已分享');
				api('System.Member.shareReward', {"share" : true,"share_url":share_url}, function() {});
			},
			cancel: function (res) {
				//alert('已取消');
			},
			fail: function (res) {
				//alert(JSON.stringify(res));
			}
		});
		
		// 2.4 监听“分享到微博”按钮点击、自定义分享内容及分享结果接口
		wx.onMenuShareWeibo({
			title: title,
			desc: desc2,
			link: share_url,
			imgUrl: img_url,
			trigger: function (res) {
				//alert('用户点击分享到微博');
			},
			complete: function (res) {
				//alert(JSON.stringify(res));
			},
			success: function (res) {
				//alert('已分享');
				api('System.Member.shareReward', {"share" : true,"share_url":share_url}, function() {});
			},
			cancel: function (res) {
				//alert('已取消');
			},
			fail: function (res) {
				//alert(JSON.stringify(res));
			}
		});
	});
});
commonCountDown($(".order-detail-wating-share time").attr("data-end-time"),$(".order-detail-wating-share time"));
function commonCountDown(time,obj){
	if(null != time && "" != time){
		var sys_second = (time-$("#ms_time").val());///1000;
		if(sys_second>1){
			sys_second -= 1;
			var day = Math.floor((sys_second / 3600) / 24);
			var hour = Math.floor((sys_second / 3600) % 24);
			var minute = Math.floor((sys_second / 60) % 60);
			var second = Math.floor(sys_second % 60);
			var s_hour = hour<10?"0"+hour:hour;
			var s_minute = minute<10?"0"+minute:minute;
			var s_second = second<10?"0"+second:second;
			var str = s_hour + ":" + s_minute + ":" + s_second;
			obj.text(str);
		}else{
			obj.text("拼单已结束");
		}
		var timer = setInterval(function(){
			if (sys_second > 1) {
				sys_second -= 1;
				var day = Math.floor((sys_second / 3600) / 24);
				var hour = Math.floor((sys_second / 3600) % 24);
				var minute = Math.floor((sys_second / 60) % 60);
				var second = Math.floor(sys_second % 60);
				var s_hour = hour<10?"0"+hour:hour;
				var s_minute = minute<10?"0"+minute:minute;
				var s_second = second<10?"0"+second:second;
				var str = s_hour + ":" + s_minute + ":" + s_second;
				obj.text(str);
			} else { 
				obj.text("拼单已结束");
				clearInterval(timer);
			}
		}, 1000);
	}
}