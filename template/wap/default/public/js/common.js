// 公共验证规则
var regex = {
	mobile: /^1([38][0-9]|4[579]|5[0-3,5-9]|6[6]|7[0135678]|9[89])\d{8}$/,
	email: /^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/,
	chinese_characters: /.*[\u4e00-\u9fa5]+.*$/
};

function api(method, param, callback, async) {
	// async true为异步请求 false为同步请求
	
	var async = async != undefined ? async : true;
	$.ajax({
		type: 'post',
		url: __URL(APPMAIN + "/index/ajaxapi"),
		dataType: "JSON",
		async: async,
		data: {method: method, param: JSON.stringify(param)},
		success: function (res) {
			if (callback) callback(res);
		}
	});
}

/**
 * 外部js获取语言包接口
 * 创建时间：2018年12月28日09:17:31
 */
function langApi(data, callback) {
	$.ajax({
		type: 'post',
		url: __URL(APPMAIN + "/index/langapi"),
		dataType: "JSON",
		async: false,
		data: {data: data.toString()},
		success: function (res) {
			if (callback) callback(res);
		}
	});
}

function __URL(url) {
	url = url.replace(SHOPMAIN, '');
	url = url.replace(APPMAIN, 'wap');
	if (url == '' || url == null) {
		return SHOPMAIN;
	} else {
		var str = url.substring(0, 1);
		if (str == '/' || str == "\\") {
			url = url.substring(1, url.length);
		}
		if ($("#niushop_rewrite_model").val() == 1 || $("#niushop_rewrite_model").val() == true) {
			return SHOPMAIN + '/' + url;
		}
		var action_array = url.split('?');
		//检测是否是pathinfo模式
		url_model = $("#niushop_url_model").val();
		if (url_model == 1 || url_model == true) {
			var base_url = SHOPMAIN + '/' + action_array[0];
			var tag = '?';
		} else {
			var base_url = SHOPMAIN + '?s=/' + action_array[0];
			var tag = '&';
		}
		if (action_array[1] != '' && action_array[1] != null) {
			return base_url + tag + action_array[1];
		} else {
			return base_url;
		}
	}
}

//处理图片路径
function __IMG(img_path) {
	var path = "";
	if (img_path != undefined && img_path != "") {
		if (img_path.indexOf("http://") == -1 && img_path.indexOf("https://") == -1) {
			path = UPLOAD + "\/" + img_path;
		} else {
			path = img_path;
		}
	}
	return path;
}

/**
 * 消息弹框
 *
 * @param msg    消息
 * @param duration    显示时长
 * @param url    跳转地址
 */
function toast(msg, url, duration) {
	var type = 'info';
	if (duration == undefined || duration == "") duration = "long";
	if (url) {
		setTimeout(function () {
			location.href = url;
		}, 1000);
	}
	new $.Display({
		display: 'messager',
		autoHide: 1500,
		placement: "center",
		closeButton: false
	}).show({
		content: msg,
		type: type,
	});
}


//时间戳转时间类型
function timeStampTurnTime(timeStamp) {
	if (timeStamp > 0) {
		var date = new Date();
		date.setTime(timeStamp * 1000);
		var y = date.getFullYear();
		var m = date.getMonth() + 1;
		m = m < 10 ? ('0' + m) : m;
		var d = date.getDate();
		d = d < 10 ? ('0' + d) : d;
		var h = date.getHours();
		h = h < 10 ? ('0' + h) : h;
		var minute = date.getMinutes();
		var second = date.getSeconds();
		minute = minute < 10 ? ('0' + minute) : minute;
		second = second < 10 ? ('0' + second) : second;
		return y + '-' + m + '-' + d + ' ' + h + ':' + minute + ':' + second;
	} else {
		return "";
	}
	
	//return new Date(parseInt(time_stamp) * 1000).toLocaleString().replace(/年|月/g, "/").replace(/日/g, " ");
}

/**
 * 遮罩层对象
 * 创建时间：2018年11月15日10:57:27  xxs
 * @param dom    在遮罩层之上的DOM
 * @param callback    点击遮罩层触发回调
 * @constructor
 */
function MaskLayer(dom, callback) {
	this.dom = $(dom);
	this.callback = callback;
	this.created();
}

MaskLayer.prototype = {
	id: "",
	zIndex: 19961213,
	created: function () {
		this.id = "js-" + genNonDuplicate(3);
		var h = '<div class="niu-mask-layer ' + this.id + '" style="display:none;position: fixed;top: 0;right: 0;bottom: 0;left: 0;z-index: ' + this.zIndex + ';background-color: rgba(0,0,0,.6);"></div>';
		$("body").append(h);
		if (this.callback) {
			var self = this;
			$("body").on("click", "." + this.id, function () {
				self.callback();
				self.hide();
			});
		}
	},
	show: function () {
		this.dom.css("z-index", ++this.zIndex);
		$("." + this.id).show();
		//防止遮罩层之下滑动
		ModalHelper.afterOpen();
	},
	hide: function () {
		this.dom.css("z-index", "");
		$("." + this.id).hide();
		ModalHelper.beforeClose();
	}
};


//解决遮罩层防止穿透问题
var ModalHelper = (function (bodyCls) {
	var scrollTop;
	return {
		afterOpen: function () {
			scrollTop = document.scrollingElement.scrollTop;
			document.body.classList.add(bodyCls);
			document.body.style.top = -scrollTop + 'px';
		},
		beforeClose: function () {
			document.body.classList.remove(bodyCls);
			// scrollTop lost after set position:fixed, restore it back.
			document.scrollingElement.scrollTop = scrollTop;
		}
	};
})('mask-layer-open');


/**
 * 上下拉刷新滚动列表
 * 创建时间：2018年11月24日14:47:25
 * @param id
 * @param load_list
 * @param page_size
 * @returns {MeScroll}
 * @constructor
 */
function ScrollList(id, load_list, page_size) {
	page_size = page_size || 15;
	
	var mescroll = new MeScroll(id, {
		down: {
			auto: false, //是否在初始化完毕之后自动执行下拉回调callback; 默认true
			callback: function () {
				//下拉刷新的回调
				load_list(1, false);
			}
		},
		up: {
			auto: true, //是否在初始化时以上拉加载的方式自动加载第一页数据; 默认false
			isBounce: true, //此处禁止ios回弹
			callback: function (page) {
				//上拉加载的回调 page = {num:1, size:10}; num:当前页 从1开始, size:每页数据条数
				load_list(page.num, true);
			},
			page: {
				num: 0,
				size: page_size
			},
			toTop: { //配置回到顶部按钮图标
				src: WAPPLUGIN + "/mescroll/img/mescroll_to_top.png"
			}
		},
		lazyLoad: {
			use: true, // 是否开启懒加载,默认false
			attr: 'lazy-url' // 标签中网络图的属性名 : <img imgurl='网络图  src='占位图''/>
		}
	});
	return mescroll;
}

function genNonDuplicate(len) {
	return Number(Math.random().toString().substr(3, len) + Date.now()).toString(36);
}