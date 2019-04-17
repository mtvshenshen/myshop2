$(function () {
	$("body").css("min-height", window.screen.height - 45);
	$(".mask-layer-bg,.mask-layer-invite-friends").click(function () {
		$(".mask-layer-bg,.mask-layer-invite-friends").hide();
	});
	$("#invite_friends,#share_friends").click(function () {
		$(".mask-layer-bg,.mask-layer-invite-friends").show();
	});
	//分享
	$.ajax({
		type: "post",
		data: {"shop_id": "{$shop_id}", "flag": "bragain", "launch_id": "{$launch_id}"},
		url: __URL(APPMAIN + "/goods/getShareContents"),
		success: function (data) {
			wx.config({
				debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
				appId: $("#appId").val(), // 必填，公众号的唯一标识
				timestamp: $("#jsTimesTamp").val(), // 必填，生成签名的时间戳
				nonceStr: $("#jsNonceStr").val(), // 必填，生成签名的随机串
				signature: $("#jsSignature").val(),// 必填，签名，见附录1
				jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ', 'onMenuShareWeibo'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
			});
			wx.ready(function () {
				var title = data['share_title'];
				var share_contents = data['share_contents'] + '\r\n';
				var share_nick_name = data['share_nick_name'] + '\r\n';
				var desc2 = share_contents + share_nick_name + "收藏热度：★★★★★";
				var share_url = data['share_url'];
				var img_url = data['share_img'];
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
						api('System.Member.shareReward', {"share": true, "share_url": share_url}, function () {
						});
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
						api('System.Member.shareReward', {"share": true, "share_url": share_url}, function () {
						});
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
						api('System.Member.shareReward', {"share": true, "share_url": share_url}, function () {
						});
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
						api('System.Member.shareReward', {"share": true, "share_url": share_url}, function () {
						});
					},
					cancel: function (res) {
						//alert('已取消');
					},
					fail: function (res) {
						//alert(JSON.stringify(res));
					}
				});
			});
		}
	});
});

commonCountDown($(".bargain-info time").attr("data-end-time"), $(".bargain-info time"));

function jump_goods(goods_id, bargain_id) {
	window.location.href = __URL(APPMAIN + '/goods/detail?goods_id=' + goods_id + '&bargain_id=' + bargain_id);
}

function jump_bargain() {
	window.location.href = __URL(APPMAIN + '/goods/bargain');
}

var flag = true;

function friend_brafain(launch_id) {
	if ($("#uid").val() == null || $("#uid").val() == "") {
		window.location.href = __URL(APPMAIN + "/login");
		return;
	}
	if (flag) {
		api('NsBargain.Bargain.helpBargain', {'launch_id': launch_id}, function (res) {
			if (res.code == 0) {
				if (res.data.data == "-9001") {
					$(".friend_brafain").attr("onclick", "jump_bargain()").text("寻找砍价商品");
					toast("当前砍价已结束");
					flag = false;
				} else if (res.data.data == "-9002") {
					$(".friend_brafain").attr("onclick", "jump_bargain()").text("我也要砍价商品");
					toast("您已参加过当前砍价");
					flag = false;
				} else if (res.data.data > 0) {
					flag = false;
					toast("帮好友砍价成功");
					location.href = __URL(APPMAIN + '/goods/bargainlaunch?launch_id=' + launch_id);
				} else {
					toast("砍价失败");
				}
			} else {
				toast("砍价失败");
			}
		}, false)
	}
}

function commonCountDown(time, obj) {
	if (null != time && "" != time) {
		var sys_second = (time - $("#ms_time").val());///1000;
		if (sys_second > 1) {
			sys_second -= 1;
			var day = Math.floor((sys_second / 3600) / 24);
			var hour = Math.floor((sys_second / 3600) % 24);
			var minute = Math.floor((sys_second / 60) % 60);
			var second = Math.floor(sys_second % 60);
			var s_hour = hour < 10 ? "0" + hour : hour;
			var s_minute = minute < 10 ? "0" + minute : minute;
			var s_second = second < 10 ? "0" + second : second;
			var s_day = day > 0 ? day + "天" : "";
			var str = s_day + s_hour + ":" + s_minute + ":" + s_second;
			obj.text(str);
		} else {
			obj.parent().text("砍价已结束");
		}
		var timer = setInterval(function () {
			if (sys_second > 1) {
				sys_second -= 1;
				var day = Math.floor((sys_second / 3600) / 24);
				var hour = Math.floor((sys_second / 3600) % 24);
				var minute = Math.floor((sys_second / 60) % 60);
				var second = Math.floor(sys_second % 60);
				var s_hour = hour < 10 ? "0" + hour : hour;
				var s_minute = minute < 10 ? "0" + minute : minute;
				var s_second = second < 10 ? "0" + second : second;
				var s_day = day > 0 ? day + "天" : "";
				var str = s_day + s_hour + ":" + s_minute + ":" + s_second;
				obj.text(str);
			} else {
				obj.parent().text("砍价已结束");
				clearInterval(timer);
			}
		}, 1000);
	}
}