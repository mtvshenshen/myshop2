// 订单操作
function operation(no, order_id, event){
	switch(no){
		case 'pay'://支付
			pay(order_id);
			break;
		case 'close'://订单关闭
			orderClose(order_id);
			break;
		case 'getdelivery'://订单收货
			getdelivery(order_id);
			break;
		case 'delete_order'://删除订单
			delete_order(order_id, event);
			break;
		case 'logistics' ://查看物流
			logistics(order_id);
			break;
		case 'pay_presell' : //预定金支付
			pay_presell(order_id);
			break;
		case 'member_pickup' : // 订单提货 	
			member_pickup(order_id);
			break;
	}
}

// 去支付
function pay(order_id){
	window.location.href = __URL(SHOPMAIN+"/order/orderPay?id="+order_id);
}

// 预定金支付
function pay_presell(order_id){
	window.location.href = __URL(SHOPMAIN+"/order/orderPresellPay?id="+order_id);
}

// 查看物流
function logistics(order_id){
	window.location.href = __URL(SHOPMAIN+ "/member/logistics?order_id="+order_id);
}

// 删除订单
function delete_order(order_id, event){
	api('System.Order.deleteOrder', {order_id : order_id}, function(res){
		if(res.data > 0){
			show('删除成功');
			$(event).parents('tbody').remove();
		} else {
			show(res.message);
		}
	})
}

// 订单收货
function getdelivery(order_id){
	api('System.Order.orderTakeDelivery', {order_id : order_id}, function(res){
		if(res.data > 0){
			show('订单收货成功');
			location.reload();
		} else {
			show(res.message);
		}
	})
}

// 订单关闭
function orderClose(order_id){
	api('System.Order.orderClose', {order_id : order_id}, function(res){
		if(res.data > 0){
			location.reload();
		} else {
			show(res.message);
		}
	})
}

// 取消退款
function cancleRefund(order_id ,order_goods_id){
	api("System.Order.cancelOrderRefund",{ "order_id" : order_id, "order_goods_id" : order_goods_id },function (res) {
		if(res.data > 0){
			show('退款取消成功！');
			location.reload();
		}
	}, false);
}

// 订单提货
function member_pickup(order_id){
	api('System.Order.getPickupQecode', {order_id : order_id}, function(res){
		if(res['code'] > 0){
			if(res.data.path != ""){
				$(".pickup-code-layer .layer-wrap img").attr('src', __IMG(res.data.path));
				$(".pickup-code-layer").show();
			}else{
				show('提货码生成失败！');
			}
		}else{
			show(data["message"]);
		}
	})
}