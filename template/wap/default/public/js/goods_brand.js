var lang_data = {};
$(function(){
	langApi(["hot_sale",
		"position_is",
		"goods_new",
		"competitive_products",
		"goods_no_goods_you_want"], function (res) {
		lang_data = res;
	});
	$('.sliding ul li').eq(0).click();
});
var is_load = false;
function showCategorySecond(brand_id,obj,page_index){
	//设置选中效果
	if(obj != null){
		if($(obj).length!=0){
			$("#slider li").removeClass("ns-text-color");
			$(obj).addClass("ns-text-color");
		}
	}
	$("#page").val(page_index);//当前页
	$('#brand_id').val(brand_id);
	if(is_load) return;
	is_load = true;
	
	var condition = {
		"ng.brand_id" : brand_id,
		"ng.state" : 1
	};

	api('System.Goods.goodsList', {condition : condition, "page_index":page_index}, function(res){
		if(res.code == 0){
			var data = res.data;
			$("#page_count").val(data['page_count']);//总页数
			is_load = false;
			if(data['data'].length==0){
				$('.tablelist-append').html('<p style="color:#939393;text-align:center;margin-top:100px;"><img src="'+WAPIMG+'/goods/wap_nodata.png" height="60" style="margin-bottom:20px;"><br>Sorry！'+lang_data.goods_no_goods_you_want+'…</p>');
			}else{
				if(page_index == 1){
					var html = '';
				}else if(page_index > 1){
					var html = $('.tablelist-append').html();
				}
				for(var i=0;i<data['data'].length;i++){
					var item = data['data'][i];
					html+='<div class="product single_item info">'+'<li>'+'<div class="item">'+'<div class="item-tag-box">'+'<!--'+lang_data.hot_sale+'icon'+lang_data.position_is+'：0px 0px，'+lang_data.goods_new+'icon'+lang_data.position_is+'：0px -35px，'+lang_data.competitive_products+'icon'+lang_data.position_is+'：0px -70px-->'+'</div>'+'<div class="item-pic">'+'<a href="'+__URL(APPMAIN+'/goods/detail?goods_id='+item.goods_id)+'">'+'<img src="'+__IMG(item.pic_cover_small)+'" class="lazy_load" alt="'+item.goods_name+'" style="display: block;max-width:100%;max-height:100%;">'+'</a>'+'</div>'+'<dl>'+'<dt>'+'<a href="'+__URL(APPMAIN+'/goods/detail?goods_id='+item.goods_id)+'">';
										if(item.group_name != null){
											html += '<i class="goods-tab ns-bg-color">'+item.group_name+'</i>';
										}
										html += item.goods_name+'</a>'+'</dt>'+'<dd class="ns-text-color">'+'<i>'+item.display_price+'</i>';
										if(item.shipping_fee == 0){
											html += '<i class="shipping-fee ns-text-color ns-border-color">包邮</i>';
										}
									html += '</dd>'+'</dl>'+'</div>'+'</li>'+'</div>';
				}
				$('.tablelist-append').html(html);
			}
		}else{
			toast(res.message);
		}
	})
}
//滑动到底部加载
$(window).scroll(function(){
	var totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
	var content_box_height = parseFloat($(".tablelist-append").height());
	if(totalheight - content_box_height >= 100){
		if(!is_load){
			var page = parseInt($("#page").val()) + 1;//页数
			var total_page_count = $("#page_count").val(); // 总页数
			var brand_id = $("#brand_id").val();
			if(page > total_page_count){
				return false;
			}else{
				showCategorySecond(brand_id,null,page);
			}
		}
	}
})


var swiper = new Swiper('.swiper-container', {
    pagination: '.swiper-pagination',
});