function cancleDetail(order_id,order_goods_id){
	api("System.Order.cancelOrderRefund",{ "order_id" : order_id, "order_goods_id" : order_goods_id },function (res) {
		if(res.data > 0){
			show("{:lang('member_cancellation_refund_successful')}");
			location.href=__URL(SHOPMAIN + "/member/refund");
		}
	});
 }