function Cart(){
	this.cart_id = [];
	this.init();
}

//初始化
Cart.prototype.init = function(){
	this.updateData();
};

//更新数据
Cart.prototype.updateData = function(){
	var arr = [];
	$(".list-item input[type='checkbox']:checked").each(function(i,v){
		var data = {
			"cart_id" : $(v).val(),
			"price" : $(v).parents(".list-item").find(".price span").attr("data-value"),
			"num" : $(v).parents(".list-item").find(".num").attr("data-value"),
			"sku_id" : $(v).parents(".list-item").find("[name='sku_id']").val()
		};
		arr.push(data);
	});
	this.cart_id = arr;

	//更新价格
	var total_price = 0;
	if(this.cart_id.length > 0){
		$(this.cart_id).each(function(i,v){
			var unit_price = Math.floor(v.price * v.num * 100) / 100;
			$("#subtotal_" + v.cart_id).text("￥" + unit_price);
			total_price += unit_price;
		})
	}

	total_price = Math.floor(total_price * 100) / 100;
	$(".foot-right .total-price").text("￥" + total_price);
};

//复选框的单选和全选
Cart.prototype.checked = function(event,type){
	if(type == "one"){
		if($(event).is(':checked')) $(event).parents(".list-item").css("background-color", "#fff4e8");
		else $(event).parents(".list-item").css("background-color", "#fff");

		//当单选按钮全部选中
		if($(".list-item input[type='checkbox']:checked").length == $(".list-item input[type='checkbox']").length)
			$(".cart-foot input[type='checkbox'],.cart-check input[type='checkbox']").prop("checked", true);
		else
			$(".cart-foot input[type='checkbox'],.cart-check input[type='checkbox']").prop("checked", false);
	}else if(type == "all"){
		var sign = $(event).is(':checked');

		$(".cart-list input[type='checkbox']").prop("checked", sign);
		if(sign){
			$(".list-item").css("background-color", "#fff4e8");
		}else{
			$(".list-item").css("background-color", "#fff");
		}
	}
	this.updateData();
};

//改变数量
Cart.prototype.changeNumber = function(event,type){
	if($(event).parents(".list-item").find("input[type='checkbox']").is(':checked')){
		var _this = this;
			numObj = $(event).parent(".item-counter").find(".num"),
			num = parseInt(numObj.val()),
			min_buy = numObj.attr("min"),
			max_buy = numObj.attr("max"),
			cart_id = $(event).parents(".list-item").find("input[type=checkbox]").val(),
			old_num = parseInt(numObj.attr('data-value')),
			reg=/^[1-9]\d*$|^0$/;
		if(type == "change"){
			if(num > max_buy){
				num = max_buy;
			}else if(num <= min_buy && min_buy > 0){
				num = min_buy;
			}else if(num <= 0 && min_buy == 0){
				num = 1;
			}
			if(reg.test(num)){
				show("输入的格式不正确");
				numObj.val(old_num);
				return;
			}
		}else{
			/*减数量*/
			if($(event).prop("class") == 'reduce'){
				if(num > min_buy && min_buy > 0|| num > 1  && min_buy == 0){
					num--;
				}else{
					return;
				}
			}
			/*加数量*/
			else if($(event).prop("class") == 'plus'){
				if(num < max_buy){
					num++;
				}else{
					return;
				}
			}
		}
		api('System.Goods.modifyCartNum', {"cart_id" : cart_id, "num" : num}, function(res){
			if (res.data > 0) {
				numObj.val(num);
				numObj.attr("data-value", num);
				_this.updateData();
			}else{
				show("操作失败")
			}
		})
	}else{
		show("请选中该商品")
	}
};

//删除购物车
Cart.prototype.deleteCart = function(event,type){
	var _this = this;
	switch(type){
		case"one":
			var cart_id = $(event).parents(".list-item").find("input[type='checkbox']").val();
			api('System.Goods.deleteCart', {"cart_id_array": cart_id}, function(res){
				var data = res.data;
				if(data > 0){
					if($('.cart-body .list-item').length == 1) {
						location.reload();
					}else {
						$(event).parents(".list-item").remove();
						_this.updateData();
					}
				}else{
					show("删除失败");
				}
			});
			break;
		case"selected":
			var arr = [];
			$(this.cart_id).each(function(i,v){
				arr.push(v.cart_id);
			});
			api('System.Goods.deleteCart', {"cart_id_array": arr.toString()}, function(res){
				var data = res.data;
				if(data > 0){
					if($('.cart-body .list-item').length >0) {
						$('.cart-body .list-item input[type="checkbox"]:checked').each(function(){
							$(this).parents(".list-item").remove();
						});
						_this.updateData();
					}else {
						location.reload();
					}
				}else{
					show("删除失败");
				}
			});
			break;
		case"all":
			var arr = [];
			$(this.cart_id).each(function(i,v){
				arr.push(v.cart_id);
			});
			api('System.Goods.deleteCart', {"cart_id_array": arr.toString()}, function(res){
				var data = res.data;
				if(data > 0){
					location.reload();
				}else{
					show("删除失败");
				}
			});
			break;
	}
};

//结算
Cart.prototype.Settlement = function(){
	if(this.cart_id.length > 0){
		var arr = [];
		$(this.cart_id).each(function(i,v){
			arr.push(v.sku_id + ':' + v.num);
		});
		var data = JSON.stringify({
			order_type: 1,
			goods_sku_list: arr.join(','),
			order_tag : 2
		});

		$.ajax({
			type: 'post',
			url: __URL(SHOPMAIN + "/order/addOrderCreateData"),
			dataType: "JSON",
			data: {data: data},
			success: function (res) {
				location.href = __URL(SHOPMAIN + "/member/payment");
			}
		});
	}else{
		show("您还没有选择商品哦")
	}
};

var cart = new Cart();