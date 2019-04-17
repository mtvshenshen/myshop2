$(function(){
    showCategorySecond(1);
});

var is_load = false;
function showCategorySecond(page){
    //设置选中效果
    $("#page").val(page);//当前页
    if(is_load){
        return false;
    }
    is_load = true;

    api('NsBargain.Bargain.bargainList', {"page_index":page}, function(res){
    	console.log(res);
        if(res.code == 0){
            var data = res.data;
            $("#page_count").val(data['page_count']);//总页数
            is_load = false;
            if(page == 1){
                var html = '';
            }else if(page > 1){
                var html = $('.spelling-block').html();
            }
            if(data['data'].length==0){
                html += '<div class="nothing-data" align="center"><img src="'+WAPIMG+'/goods/wap_nodata.png"/><div>没有找到您想要的砍价商品…</div></div>';
            }else{
                html += '<ul>';
                for(var i=0;i<data['data'].length;i++){
                    var curr = data['data'][i];
                    html += '<li onclick="location.href=\'' + __URL(APPMAIN+"/goods/detail?goods_id=" + curr.goods_id) + '&bargain_id=' + curr.bargain_id+'\'">';
                        html += '<div>';
                            html += '<a href="javascript:;">';
                            html += '<img src="'+__IMG(curr.pic_cover_mid)+'" class="lazy_load" />';
                            html += '</a>';
                        html += '</div>';
                        html += '<footer>';
                            html += '<p>' + curr.goods_name + '</p>';
                            html += '<div>  <span class="tuangou-money ns-text-color">￥' + curr.promotion_price + '</span><br>';
                            html += '<button class="ns-bg-color">去砍价&nbsp;&gt;</button></div>';
                            html += '';
                        html += '</footer>';
                    html += '</li>';
                }
                html += '</ul>';
            }
            $('.spelling-block').html(html);
        }else{
            toast(res.message);
        }
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
                showCategorySecond(page);
            }
        }
    }
});