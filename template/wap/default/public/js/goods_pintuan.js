$(function(){
	getPageList(1);
})
var is_load = false;
function getPageList(page){
	//设置选中效果
	$("#page").val(page);//当前页
	if(is_load){
		return false;
	}
	is_load = true;
	var condition = {
		'npg.is_open' : 1
	};
	api('NsPintuan.Pintuan.goodsList', {"page":page, condition : JSON.stringify(condition)}, function(res) {
		var data = res.data;
		$("#page_count").val(data['page_count']);//总页数
		is_load = false;
		if(page == 1){
			var html = '';
		}else if(page > 1){
			var html = $('.spelling-block').html();
		}
		if(data['data'].length==0){
			html += '<div class="nothing-data" align="center"><img src="'+WAPIMG+'/goods/wap_nodata.png"/><div>没有找到您想要的拼团商品…</div></div>';
		}else{
			html += '<ul>';
			for(var i=0;i<data['data'].length;i++){
				var curr = data['data'][i];
				html += '<li onclick="location.href=\'' + __URL(APPMAIN+"/goods/detail?goods_id=" + curr.goods_id) + '\'">';
					html += '<div>';
						html += '<img src="'+__IMG(curr.pic_cover_mid)+'" class="lazy_load" />';
					html += '</div>';
					
					html += '<footer>';
						html += '<p>' + curr.goods_name + '</p>';
						html += '<div>	<span class="tuangou-money">￥' + curr.tuangou_money + '</span><br>';
						html += '<span class="original-money">单买价&nbsp;' + curr.promotion_price + '元</span><button class="ns-bg-color">去拼单&nbsp;&gt;</button></div>';
						html += '';
					html += '</footer>';
				html += '</li>';
			}
			html += '</ul>';
		}
		$('.spelling-block').html(html);
	})
}
//滑动到底部加载
$(window).scroll(function(){
	var totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
	var content_box_height = parseFloat($(".spelling-block").height());
	if(totalheight - content_box_height >= 45){
		if(!is_load){
			var page = parseInt($("#page").val()) + 1;//页数
			var total_page_count = $("#page_count").val(); // 总页数
			if(page > total_page_count){
				return false;
			}else{
				getPageList(page);
			}
		}
	}
});