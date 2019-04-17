function checkAccount(id,obj){
    api("System.Member.modityAccountDefault", {"id" : id}, function(data){
        var res = data['data'];
        toast(data.message);
        if (res > 0) {
            $(".side-nav.address").children("li").removeClass("current");
            $(obj).parent().parent("li").addClass("current");
            if(flag==0){
                window.location.href=__URL(APPMAIN+"/member/applywithdrawal");
            }
            if(flag==2){
                window.location.href=__URL(APPMAIN+"/distribution/toWithdraw");
            }
        }
    })
}
function account_delete(id){
    api("System.Member.deleteAccount", {"id" : id}, function(data){
        var res = data['data'];
        toast(res.message);
        if (res == 1) {
            window.location.reload();
        }
    })
}