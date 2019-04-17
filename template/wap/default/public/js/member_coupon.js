var lang = {};
$(function(){
	langApi(["unused",
		"used",
		"expire"], function (res) {
		lang = res;
	});
    $('.cf-container .cf-tab-item').click(function(){
        $('.cf-container .cf-tab-item').removeClass('selected ns-text-color-hover ns-border-color-hover ');
        $(this).addClass('selected ns-text-color-hover ns-border-color-hover');
    });
    getMemberCounponList(1);
});
function getMemberCounponList(type){
    api("System.Member.coupon", {"type" : type}, function(data){
        var data = data['data'];
        var listhtml='';
        if(data.length>0){
            for(var i=0;i<data.length;i++){
                var money = data[i]['money'] != null ? data[i]['money'] : "";
                var coupon_code = data[i]['coupon_code'] != null ? data[i]['coupon_code'] : "";
                var coupon_name = data[i]['coupon_name'] != null ? data[i]['coupon_name'] : "";
                var start_time = data[i]['start_time'] != null ? data[i]['start_time'] : "";
                var end_time = data[i]['end_time'] != null ? data[i]['end_time'] : "";
                var at_least = data[i]['at_least'];
                if(type != 1){
                    listhtml += '<div class="coupon-item used">';
                }else{
                    listhtml += '<div class="coupon-item ns-bg-color">';
                }
                listhtml += '<div class="coupon-type">';
                listhtml += '</div>';
                listhtml += '<section>';
                listhtml += '<div class="coupon-title"><i>￥</i><em>'+ money +'</em></div>';
                listhtml += '<div class="coupon-time">'+start_time+' 至 '+end_time+'</div>';
                listhtml += '</section>';
                listhtml += '</div>';
                listhtml += '<div class="coupon-desc">';
                listhtml += '满'+at_least+'元可用';
                listhtml += '</div>';
            }
        }else{
            listhtml += '<div class="coupon-empty">';
            listhtml += '<p class="text-center">您还没有';
            switch(type){
                case 1:
                    listhtml +=lang.unused;
                    break;
                case 2:
                    listhtml += lang.used;
                    break;
                case 3:
                    listhtml += lang.expire;
                    break;
            }
            listhtml += '优惠券</p>';
            listhtml += '</div>';
        }
        $('.com-content .coupon-contianer').html(listhtml);
    })
}