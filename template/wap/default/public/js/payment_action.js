var vue = new Vue({
	el : '#app',
	data : {
		isNeedInvoice : false, // 是否需要发票
		taxMoney : '0.00', // 税费
		totalMoney : '0.00', // 总金额
		point : 0, // 使用积分数
		shippingMoney : '0.00', // 运费
		promotionMoney : '0.00', // 优惠金额
		goodsMoney : '0.00', // 商品金额
		payMoney : '0.00', // 实际支付金额
		pointMoney : '0.00', // 积分抵现金额
		couponMoney : '0.00', // 优惠券优惠金额
		payTypeName : $('[v-text="payTypeName"]').text(),
	}
})

$(function(){
	// 是否需要发票
	$('#is-need-invoice').click(function(event) {
		if($(this).is(':checked')){
			$(this).parents('.invoice-wrap').find('.invoice-form').removeClass('hide');
		}else{
			$(this).parents('.invoice-wrap').find('.invoice-form').addClass('hide');
		}
	});

	// 选择配送方式
	$('.delivery-wrap .shipping-type-list li').click(function(event) {
		$(this).attr('class', 'selected ns-text-color ns-border-color').siblings('li').attr('class', '');
		var type = $(this).attr('data-value');
		$('.delivery-wrap .panel').addClass('hide');
		switch (type) {
			case '1':
				$('.delivery-wrap .logistics').removeClass('hide');
			break;
			case '2':
				$('.delivery-wrap .pickup-point').removeClass('hide');
			break;
		}
	});

	// 物流公司选择 自提点选择 支付方式选择
	$('.express-company-list li,.pickup-point-list li,.pay-type-list li').click(function(){
		$(this).addClass('selected').siblings('li').removeClass('selected');
		$(this).parent('ul').find('i.iconfont').attr('class', 'iconfont iconcheckbox');
		$(this).find('i.iconfont').attr('class', 'iconfont iconchecked ns-text-color');
	})

	$('')
})

var is_sub = false;
function Order(){
	var data = {
		order_type : _params.order_type, // 订单类型
		goods_sku_list : _params.goods_sku_list, // 购买商品规格
		is_virtual : _params.is_virtual, // 是否是虚拟商品
		buyer_ip : _params.buyer_ip, // 购买人ip
		user_money : 0, // 用户余额
		platform_money : 0, // 平台余额
		shipping_info : {}, // 配送信息
		buyer_invoice : '', // 发票信息
		buyer_message : '', // 买家留言 
		promotion_type : _params.promotion_type,
		coin : 0, // 购物币
		promotion_info : _params.promotion_info
	}

	this.getValue = function(){
		if(data.is_virtual == 0){
			data.shipping_info = {}; // 每次获取前先清空原数据
			data.shipping_info.shipping_type = $('.shipping-type-list li.selected').attr('data-value');
			if(data.shipping_info.shipping_type == 1){
				data.shipping_info.shipping_company_id = $('.express-company-list li.selected').attr('data-value') != undefined ? $('.express-company-list li.selected').attr('data-value') : 0;
				data.shipping_info.shipping_time = $('.shipping-time-list li.selected').attr('data-time');
				data.shipping_info.distribution_time_out = $('.time-out-list span').text();
			}else if(data.shipping_info.shipping_type == 2){
				data.shipping_info.pick_up_id = $('.pickup-point-info li.selected').attr('data-value') != undefined ? $('.pickup-point-info li.selected').attr('data-value') : 0;
			}
		}else{
			data.user_telephone = $('.account-cont [name="mobile"]').val();
		}
		if($('.invoice-cont .is-need-invoice li.active').attr('data-value') == 1){
			var invoiceFormObj = $('.invoice-cont .form-horizontal');
			data.buyer_invoice = invoiceFormObj.find('[name="invoice_title"]').val() + '$' + invoiceFormObj.find('li.active').text() + '$' + invoiceFormObj.find('[name="taxpayer_identification_number"]').val();
		}
		data.pay_type = $('.payment-type-cont li.active').attr('data-value');			
		data.buyer_message = $('.distribution-cont .user-message textarea').val();
		data.coupon_id = $('.discount-cont .coupon-item.active').attr('data-value') != undefined ? $('.discount-cont .coupon-item.active').attr('data-value') : 0;
		data.point = isNaN(parseInt($('.discount-cont .use-point').val())) ? 0 : parseInt($('.discount-cont .use-point').val());
		data.address_id = $('.address-cont li.active').attr('data-value') != undefined ? $('.address-cont li.active').attr('data-value') : 0;
	}

	// 订单计算
	this.calculate = function(){
		this.getValue();
		api('System.Order.orderCalculate', {'data' : JSON.stringify(data)}, function(res){
			if(res.code == 0){
				vue.taxMoney = parseFloat(res.data.tax_money).toFixed(2);
				vue.totalMoney = parseFloat(res.data.total_money).toFixed(2);
				vue.shippingMoney =parseFloat(res.data.shipping_money).toFixed(2);
				vue.promotionMoney = parseFloat(res.data.promotion_money).toFixed(2);
				vue.goodsMoney = parseFloat(res.data.goods_money).toFixed(2);
				vue.payMoney = parseFloat(res.data.pay_money).toFixed(2);
				vue.point = res.data.offset_money_array.point.num;
				vue.pointMoney = parseFloat(res.data.offset_money_array.point.offset_money).toFixed(2);
				vue.couponMoney = res.data.coupon_money;
				data.pay_money = res.data.pay_money;
			}else{
				show(res.message);
			}
		})
	}

	// 订单提交
	this.submit = function(){
		this.getValue();
		if(this.verify()){
			if(is_sub) return; is_sub = true;
			api('System.Order.orderCreate', {'data' : JSON.stringify(data)}, function(res){
				if (res.code == 0) {
					//如果实际付款金额为0，跳转到个人中心的订单界面中
					if(data.pay_money == 0){
						location.href = __URL(APPMAIN + '/pay/callback?msg=1&out_trade_no=' + res.data.out_trade_no);
					}else if(data.pay_type == 4){
						location.href = __URL(SHOPMAIN + '/member/orderlist');
					}else{
						window.location.href = __URL(APPMAIN + '/pay/pay?out_trade_no=' + res.data.out_trade_no);
					}
				}else{
					show(res.message);
					is_sub = false;
				}
			}, false)
		}
	}

	// 验证
	this.verify = function(){
		// 非虚拟商品
		if(data.is_virtual == 0){
			if(data.address_id == 0) { show('请先选择收货地址'); return false; }
			// 如果用户选择商家配送的话 不考虑配送方式有没有开启
			if(data.pay_type != 4){
				if(data.shipping_info.shipping_type == undefined) { show('商家未启用配送方式'); return false; }
			}
			if(data.shipping_info.shipping_type == 2 && data.shipping_info.pick_up_id == 0) { show('请先选择自提点'); return false; }
		}else{
			if(data.user_telephone.search(regex.mobile) == -1) { show('请输入正确的手机号'); return false; }
		}
		// 发票
		if($('.invoice-cont .is-need-invoice li.active').attr('data-value') == 1){
			if($('.invoice-cont [name="invoice_title"]').val().search(/[\S]+/)) { show('请填写发票抬头'); return false; }
			if($('.invoice-cont [name="taxpayer_identification_number"]').val().search(/[\S]+/)) { show('请输入纳税人识别号'); return false; }
		}
		return true;
	}	
}

function Page(){
	this.name;

	this.show = function(name){
		this.name = name;
		if($('[data-page="'+ name +'"]') != undefined){
			$('[data-page="main"]').hide(0, function(){
				$('[data-page="'+ name +'"]').show();
			});
		}
	}

	this.hide = function(){
		$('[data-page="'+ this.name +'"]').hide(0, function(){
			$('[data-page="main"]').show();
		});
	}
}

function Picker(){
	this.show = function(name){
		var contEl = $('[data-picker="picker-'+ name +'"]');
		if(contEl != undefined){
			$('.shade,[data-picker="picker-'+ name +'"]').removeClass('hide');
		}
	}

	this.hide = function(){
		$('.picker .cont').html('');
		$('.shade,.picker').addClass('hide');
	}
}

var page = new Page();
var picker = new Picker();
var order = new Order();
// Order.calculate();