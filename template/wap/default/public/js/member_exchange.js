$(function(){
    $('.content>p.buttom>#duih').click(function(){
        $(this).attr('disabled','disabled');
        var flag=true;
        var msg="";
        var amount=$('#amount');
        if(amount.val()==''){
            msg=lang_member_exchange.the_points_need_to_be_redeemed_are_not_null;
            flag=false;
        }else if(Number(amount.val())>Number(conponSum)){
            msg=lang_member_exchange.the_points_you_need_to_redeem_cannot_be_greater_than_the_points_you_have;
            amount.val(conponSum);
            flag=false;
        }else if(Number(amount.val())<0){
            msg=lang_member_exchange.the_points_required_to_be_redeemed_shall_not_be_less_than_0;
            amount.val(0);
            flag=false;
        }
        if(!flag){
            toast(msg);
            amount.focus();
            $(this).removeAttr('disabled');
            return false;
        }
        api("System.Member.pointExchangeBalance", {'amount':amount.val(),'shop_id':shopid}, function(data){
            var data = data['data'];
            if(data['code']>0){
                toast(lang_member_exchange.redeem_successfully);
                setTimeout(function(){
                    location.href=__URL(APPMAIN+'/member/point?shop_id='.$shop_id)
                },1000);
            }else{
                $(this).removeAttr('disabled');
                toast(data['message']);
            }
        })
    })
})