$(function() {

	//默认进入帮助中心，打开第一个分类下的第一个文章
	if($("#hidden_id").val() == ''){
		if($(".help .category > ul li:first ul li").length>0){
			$(".help .category > ul li:first ul").show();
			$(".help .category > ul li:first ul li:first a").addClass("ns-text-color");
		}
	}

	$(".help .category>ul li div").click(function(){
		console.log(this)
		$(".help .category>ul li ul").slideUp('fast');
		var children = $(this).next();
		if (children.is(":visible")) {
			$(this).parent('li').parent('ul').find('i').removeClass('icon-sort-down').addClass('icon-sort-down');
			$(this).find('i').addClass('icon-sort-down').removeClass('icon-sort-up');
			children.slideUp('fast');
		} else {
			$(this).parent('li').parent('ul').find('i').removeClass('icon-sort-up').addClass('icon-sort-down');
			$(this).find('i').addClass('icon-sort-up').removeClass('icon-sort-down');
			children.slideDown('fast');
		}
	});
});

//分页
$('#myPager').pager({
	linkCreator: function(page, pager) {
		return __URL(SHOPMAIN+"/article/lists?page_index="+page);
	}
});
