$(function(){
	//如果退款原因是选择的其他就让用户自己写退款说明，"{:lang('member_other')}"
	$("#refund_reason").change(function(){
		if($(this).val()=="{:lang('member_other')}")
		{
			$('#description_dl').show();
		}else{
			$('#description_dl').hide();
		}
	});
});

//添加退货信息物流
function ExpressSave(){
	var LogisticsCompany=$("#LogisticsCompany").val();
	var ExpressNo=$("#ExpressNo").val();
	if(LogisticsCompany==""){
		$("#LogisticsCompany").focus();
		show("{:lang('member_logistics_companies_cannot_empty')}");
	}else if(ExpressNo==""){
		$("#ExpressNo").focus();
		show("{:lang('member_waybill_number_cannot_empty')}");
	}else{
		$.ajax({
			url: "{:__URL('SHOP_MAIN/order/orderCustomerRefund')}",
			type: "post",
			data: {"id":id ,"order_goods_id": order_goods_id, "refund_express_company": LogisticsCompany, "refund_shipping_no": ExpressNo},
			dataType: "json",
			success: function (response) {
				if(response.code>0){
					window.location.reload();
				}
			}
		});
	}
}

//保存再次申请退款信息
function btnSave() {
	var refund_require = $("#refund_require").val();
	var refund_reason = $("#refund_reason").val();
	var refund_money = $("#refund_money").val();//退款金额
	if($("#refund_money").val() == undefined) {
		var refund_money = 0;
	}
	var description = $("#description").val();//
	var maxRefundMoney = parseFloat($("#maxRefundMoney").val());

	if(refund_money == "" && refund_money !== 0){
		show("{:lang('member_please_enter_refund_amount')}");
		$("#refund_money").select();
		return false;
	}
	if(isNaN(refund_money)){
		show("{:lang('member_amount_not_entered_legally')}");
		$("#refund_money").select();
		return false;
	}
	if(refund_money < 0){
		show("{:lang('member_amount_should_not_negative')}");
		$("#refund_money").select();
		return false;
	}
	if (refund_money > maxRefundMoney) {
		$("#refund_money").select();
		show("{:lang('member_beyond_refund_amount')}");
		return false;
	}
	if (refund_money < 0 || refund_money > maxRefundMoney) {
		$("#refund_money").focus();
		show("{:lang('member_beyond_refund_amount')}");
		return false;
	}
	if($('#refund_reason').val() == "{:lang('member_other')}"){
		refund_reason = description;
		if(refund_reason == ""){
			show("{:lang('member_please_enter_refund_statement')}");
			return false;
		}
	}
	
	api("System.Order.applyOrderCustomer",{ "order_goods_id": order_goods_id, "refund_type": refund_require, "refund_money":refund_money, "refund_reason": refund_reason },function (res) {
		if(res.data>0){
			window.location.reload();
		}else{
			show(res.message);
		}
	});
}