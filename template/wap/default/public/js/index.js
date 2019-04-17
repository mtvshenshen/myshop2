var lang = {};
$(function () {
	$('body').append('<div id="search_goods"></div><div id="detail"></div>');
	$('.custom-search-input').keyup(function(){
		var search = $(this).val();
	});
	
	$('.custom-search-button').click(function(){
		var searchCont = $('.custom-search-input').val();
		searchCont = searchCont.replace(/</g, "&lt;").replace(/>/g, "&gt;"); 
		if(searchCont != ''){
			if($.cookie("searchRecordWap") != undefined){
				var arr = eval($.cookie("searchRecordWap"));
			}else{
				var arr = new Array();
			}
			if(arr.length >0 ){
				if($.inArray(searchCont, arr)< 0){
					arr.push(searchCont);
				}
			}else{
				arr.push(searchCont);
			}
			$.cookie("searchRecordWap",JSON.stringify(arr));

			location.href = __URL(APPMAIN + '/goods/lists?keyword=' + searchCont);
		}
	});
	
	langApi(["days","activity_over"],function (res) {
		lang = res;
	});
	
	//点击关注弹出公众号二维码
	$(".foucs-on-block button").click(function () {
		$(".wechat-popup").show();
		$(".mask").show();
	});
	$(".foucs-on-block .mask").click(function () {
		$(".wechat-popup").hide();
		$(".mask").hide();
	});
	
	init();
	
	function init(){
		
		//获取分享内容
		getShareContents();
		
		var notice_count = $("#hidden_notice_count").val();
		if(notice_count){
			
			var notice_index = 0;
			var notice_autoTimer = 0;//全局变量目的实现左右点击同步
			
			//当公告数量大于1个时进行滚动垂直滚动，等于1个时横向滚动
			if(notice_count>1){
				
				//自动轮播
				if($(".dowebok-block ul li").length>1){
					$(".dowebok-block ul li:eq(0)").clone(true).appendTo($(".dowebok-block ul"));//克隆第一个放到最后(实现无缝滚动)
					var liHeight = $(".dowebok-block li").height();//一个li的高度
					//获取li的总高度再减去一个li的高度(再减二个Li是因为克隆了多出了一个Li的高度)
					var li_sum = $(".dowebok-block ul li").length;
					$(".dowebok-block ul").height(liHeight);//给ul赋值高度
					notice_autoTimer = setInterval(function(){
						
						notice_index++;
						
						if(notice_index > Number(li_sum) -1) {
							notice_index = 0;
						}
						$(".dowebok-block ul").stop().animate({
							
							top: -notice_index * liHeight
							
						},500,function(){
							if(notice_index == Number(li_sum) -1) {
								$(".dowebok-block ul").css({top:0});
								notice_index = 0;
							}
							
						});
						
					},5000);
				}
				
			}else{
				$('.dowebok').liMarquee({
					hoverstop: false
				});
			}
		}
	
		updateEndTime();
		
	}
	
	
		
	//获取分享内容
	function getShareContents() {
		
		$.ajax({
			type: "post",
			url: __URL(APPMAIN + "/index/getShareContents"),
			data: { "flag": "shop"},
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
			}
		});
	}
	
});

//跳转到电脑端
function locationShop(){
	$.ajax({
		type: 'post',
		url: __URL(APPMAIN + "/index/setClientCookie"),
		dataType: "JSON",
		data: {client: "web"},
		success: function (res) {
			if(res.data>0){
				location.href= __URL(SHOPMAIN);
			}
		}
	});
}

var is_have = true;
function coupon_receive(event,coupon_type_id){
	var info = new Array();
	info['maxFetch'] = $(event).attr("data-max-fetch");
	info['receivedNum'] = $(event).attr("data-received-num");
	
	if(is_have){
		is_have = false;
		api("System.Member.getCoupon",{ 'coupon_type_id' : coupon_type_id, "scenario_type" : 2 },function (res) {
			if(res.code >= 0){
				toast('领取成功');
				is_have = true;
				var received_num = parseInt(info['receivedNum']) + 1; // 该用户已领取数
				$(event).attr("data-received-num", received_num);
				
				if(info['maxFetch'] > 0 && received_num >= info['maxFetch']){
					$(event).find(".get").text("已领取");
					$(event).addClass("received");
				}
			}else if(res.code == -9999){
				toast(res.message, __URL(APPMAIN + "/login/index"));
			}else{
				toast(res.message);
				is_have = true;
			}
		});
	}
}

//倒计时函数
function updateEndTime() {
	var date = new Date();
	var time = date.getTime(); //当前时间距1970年1月1日之间的毫秒数
	
	$(".remaining_time").each(function(i) {
		var endDate = this.getAttribute("endTime"); //结束时间字符串
		
		//转换为时间日期类型
		var endDate1 = eval('new Date(' + endDate.replace(/\d+(?=-[^-]+$)/, function(a) {
			return parseInt(a, 10) - 1;
		}).match(/\d+/g) + ')');
		
		var endTime = endDate1.getTime(); //结束时间毫秒数
		
		var lag = (endTime - time) / 1000; //当前时间和结束时间之间的秒数
		if (lag > 0) {
			var second = Math.floor(lag % 60);
			var minite = Math.floor((lag / 60) % 60);
			var hour = Math.floor((lag / 3600) % 24);
			var day = Math.floor((lag / 3600) / 24);

			second = second < 10 ? '0' + second : second;
			minite = minite < 10 ? '0' + minite : minite;
			hour = hour < 10 ? '0' + hour : hour;
			day = day < 10 ? '0' + day : day;
			$(this).find(".day").html(day + lang.days);
			$(this).find(".hours").html(hour);
			$(this).find(".min").html(minite);
			$(this).find(".seconds").html(second);
		} else{
			$(this).html(lang.activity_over + "！");
		}
	});
	setTimeout("updateEndTime()", 1000);
}

var swiper = new Swiper('.swiper-container', {
    pagination: '.swiper-pagination',
});

document.onkeydown=function(event){
	e = event ? event :(window.event ? window.event : null);
	if(e.keyCode==13){
		var search = $('.custom-search-input').val();
		var shop_id = $('#hidden_shop_id').val();
		location.href= __URL(APPMAIN+"/goods/lists?search_name="+search+"&shop_id="+shop_id);
	}
};

//加入购物车
function CartGoodsInfo(goodid,state){
	var uid=$('#uid').val();
	if(uid == undefined || uid == ''){
		window.location.href=__URL(APPMAIN+"/login/index");
	}else{
		if(state == 1){
			$.ajax({
				type:"post",
				url: __URL(APPMAIN+"/goods/joincartinfo"),
				async:false,
				data:{'goods_id':goodid},
				dataType:'html',
				success:function(data){
					$('#detail').html(data);
					$("#s_buy").slideDown(300);
					$(".motify").css("opacity",0).fadeIn().fadeOut();
				}
			});
		}else{
			var state_msg_arr = "";//'商品状态 0下架，1正常，10违规（禁售）'
			switch(state){
			case 0:
				state_msg = "该商品已下架";
				break;
			case 10:
				state_msg = "该商品违规（禁售）";
				break;
			}
			toast(state_msg);
		}
	}
}