$(function () {
	
	$(".sidebar .content-wrap .menu ul li").mouseover(function () {
		$(this).addClass('active ns-border-color ns-text-color').siblings().removeClass('active ns-border-color ns-text-color');
		$(".sidebar .content-wrap .item").eq($(this).index()).show().siblings(".item").hide();
	});
});

//时间显示
function discountTimeShow(interval){
	
	var day = Math.floor((interval / 3600) / 24);
	var hour = Math.floor((interval / 3600) % 24);
	var minute = Math.floor((interval / 60) % 60);
	var second = Math.floor(interval % 60);
	
	if(day > 0){
		$("#db_discount .db-discount-time").addClass('show-day');
	}else{
		$("#db_discount .db-discount-time").removeClass('show-day');
	}
	
	if(day < 10) day = '0' + day;
	if(hour < 10) hour = '0' + hour;
	if(minute < 10) minute = '0' + minute;
	if(second < 10) second = '0' + second;
	
	$("#db_discount .time.day span").html(day);
	$("#db_discount .time.hour span").html(hour);
	$("#db_discount .time.minute span").html(minute);
	$("#db_discount .time.second span").html(second);
}

//倒计时函数
function countDown(){
	var timer = setInterval(function(){
		var self = $("#db_discount");
		var end_time = self.attr("data-end_time"); //结束时间字符串
		var start_time = self.attr("data-start_time"); //开始时间字符串
		var DATE = new Date();
		var current_time = Math.round(DATE.getTime() / 1000);
		
		if(end_time == '' || start_time == '') return;
		
		//未开始 统计距离开始还有多少时间
		if(current_time < start_time){
			var interval = start_time - current_time;
			$("#db_discount .db-discount-desc").html('距离下一场开始还有');
			discountTimeShow(interval);
		//进行中 统计距离结束还有多少时间	
		}else if(current_time >= start_time && current_time < end_time){
			var interval = end_time - current_time;
			$("#db_discount .db-discount-desc").html('距离本场结束还有');
			discountTimeShow(interval);
		//已结束 不进行统计 	
		}
		
	}, 1000);
}

//启动倒计时
countDown();


//首页左侧楼层定位
$(function() {
	if ($(".floor-item")) {
		var elevatorfloor = $(".catetop-lift .lift-list");
		$.each($('.floor-item'), function(i, v) {
			var short_name = $.trim($(v).find('[floor-block-name]').text());
			var $el = $("<div class='catetop-lift-item'><span>"+short_name+"</span></div>")
			elevatorfloor.append($el);
		});

		var conTop = 0;
		var conTopEnd = 0;
		var floor_top_array = new Array();//记录楼层位置
		var floor_height_array = new Array();//记录楼层的高度
		$(".floor-item").each(function(){
			floor_top_array.push($(this).offset().top);
			var floor_height = 0;
			if($(this).height()>400){
				floor_height = parseFloat($(this).height()/2);
			}else if($(this).height()>=266){
				floor_height = parseFloat($(this).height()-30);//30是补差
			}else if($(this).height()>=266){
				floor_height = parseFloat($(this).height());
			}
			floor_height_array.push(floor_height);
		});
		
		if ($(".floor-item").length > 0) {
			conTop = $(".floor-item:eq(0)").offset().top-($(".floor-item:eq(0)").height()/2);
			conTopEnd = $(".floor-item:eq(" + ($(".floor-item").length-1) + ")").offset().top;
		}
		$(window).scroll(function() {
			var scrt = $(window).scrollTop();
			if (scrt > conTop){
				$(".lift-list").show("fast", function() {
					$(".lift-list").css({
						"-webkit-transform": "scale(1)",
						"-moz-transform": "scale(1)",
						"transform": "scale(1)",
						"opacity": "1"
					});
				}).css({
					"visibility": "visible"
				});
				
			}else {

				$(".lift-list").css({
					"-webkit-transform": "scale(1.2)",
					"-moz-transform": "scale(1.2)",
					"transform": "scale(1.2)",
					"opacity": "0"
				});
				$(".lift-list").css({
					"visibility": "hidden"
				});
			}

			if (conTopEnd !=0 && scrt >=conTopEnd) {
				console.log(1);
				$(".lift-list").css({
					"-webkit-transform": "scale(1.2)",
					"-moz-transform": "scale(1.2)",
					"transform": "scale(1.2)",
					"opacity": "0"
				});
				$(".lift-list").css({
					"visibility": "hidden"
				});
			}
			
			setTab();
		});
		
		$(".catetop-lift-item").on("click", function() {
			var index = $(".catetop-lift-item").index(this);
			$("html,body").stop().animate({
				scrollTop: floor_top_array[index]-55 + "px"
			}, 400);
		});
		
		$(".elevator-floor a.fsbacktotop").click(function() {
			$("html,body").stop().animate({
				scrollTop: 0
			}, 400)
		});
		
		/**
		 * 设置左侧定位楼层选中
		 */
		function setTab() {
			
			var scrollTop = $(window).scrollTop();
			var temp_arr = new Array();
			var smooth_height = $(".lift-list .catetop-lift-item").height()+30;
			for(var i=floor_top_array.length-1;i>=0;i--){
				if(scrollTop+smooth_height >= floor_top_array[i]-floor_height_array[i]){
					$(".lift-list .catetop-lift-item").eq(i).addClass("ns-bg-color").siblings().removeClass("ns-bg-color");
					break;
				}

			}
		}
	}
});
