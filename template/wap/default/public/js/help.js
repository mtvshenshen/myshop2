function showChild(obj,id){
	$(".custom-tag-list-side-menu li a").removeClass("selected ns-text-color ns-border-color");
	$(obj).addClass("selected ns-text-color ns-border-color");
	$(".two-list-menu").show();
	$("#grouGoods_listmask").show();
	$("#two_menu li[pid]").hide();
	$("#two_menu li[pid='"+id+"']").show();
}
$('.custom-tag-list .mask').click(function(){
	$(this).hide();
	$('.two-list-menu').hide();
});
//通过文章ID获取文章内容
 function getgoodlist(id){
	$('#grouGoods_listmask').hide();
	$('.two-list-menu').hide();
	$('.two-list-menu li[id]').hide();
	$platform_help_document = api("System.Shop.helpInfo",{ id : id },function(res){
		var data= res.data;
		var html = '';
		html+='<p>'+data['page_count']+'</p>';
		if(data['total_count']==''){
			html+='<p>{:lang("no_relevant_content")}</p>';
		}else{
			html+='<p>'+data['total_count']+'</p>';
		}
		$('#good_list').html(html);

	});
}
