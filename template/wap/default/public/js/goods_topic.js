$(function(){
	$('.defaualt').eq(0).click();
})
var is_load = false;
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