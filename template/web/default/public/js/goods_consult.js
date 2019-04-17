var submiting = false;

//操作处理开始
var OperateHandle = function () {
    function _bindEvent() {
        //咨询列表切换卡

        //显示隐藏咨询类型信息
        $("[nc_type='consultClassRadio']").first().attr("checked","checked");
        $("[nc_type='consultClassIntroduce']").hide();
        $("[nc_type='consultClassIntroduce']").first().show();

        $("[nc_type='consultClassRadio']").click(function () {
            $("[nc_type='consultClassIntroduce']").hide();
            $("#consultClassIntroduce"+$(this).val()).show();
        });

        //验证码
        $("#consultCaptchaHide").click(function(){
            $(".code").fadeOut("slow");
        });
        $("#consultCaptcha").focus(function(){
            $(".code").fadeIn("fast");
        });

        $("#consultSubmit").click(function(){
          var goods_id=$('#goods_id').val();
          var goods_name=$('#goods_name').val();
          var ct_id=$('[name="classId"]:checked').val();
          var consult_content=$('#consultContent').val();
          var random_code=$('#consultCaptcha').val();
          if(consult_content==""){
            show('咨询信息不可为空!');
            return false;
          }
          if(consult_content.length>200){
			  show('咨询信息超出最大限制');
			  return false;
		  }
          if(random_code==""){
            show('验证码不可为空!');
            return false;
          }
            if($("#is_sub").val()=='true'){
                $("#is_sub").val("false");
                $("#consultSubmit").css({"background-color":"", "border-color":""});
                api('System.Goods.addGoodsConsult', {"goods_id":goods_id,"goods_name":goods_name, "ct_id":ct_id,"consult_content":consult_content,"random_code":random_code,"shop_name" : $("#hidden_shop_name").val() }, function(res) {
               if(res.data>0){
                 show('咨询信息发布成功！');
                 location.href=__URL(SHOPMAIN+"/goods/consult?goods_id="+goods_id);
               }else if(res.data==-1){
                 show(res['message']);
                 changeCaptcha();
               }else {
                 show(res['message']);
                 changeCaptcha();
               }
                })
            }
        });

        //更换验证码
        $('#consultCaptchaImage').click(function(){
            changeCaptcha();
        });
        $('[nc_type="consultCaptchaChange"]').click(function(){
            changeCaptcha();
        });

        $('#consultCaptcha').keyup(function(){
          if($(this).val().length==4){
            $("#is_sub").val("true");
            $("#consultSubmit").attr("style","background-color:#F59C1A !important;border-color:#F59C1A !important;");
          }
        });

        //字符个数动态计算
        $("#consultContent").charCount({
            allowed: 200,
            warning: 10,
            counterContainerID:'consultCharCount',
            firstCounterText:'还可以输入',
            endCounterText:'字',
            errorCounterText:'已经超出',
        });
    }

    //外部可调用
    return {
        bindEvent: _bindEvent
    }
}();
//操作处理结束

//更换验证码
function changeCaptcha() {
    $('#consultCaptchaImage').attr('src', SHOPMAIN + '/goods/random?t=' + Math.random());
    $('#consultCaptcha').select();
}

$(function () {
    //页面绑定事件
    OperateHandle.bindEvent();
});

//分页
var str = location.href;
var str_num = str.split("&");
var goods_id = $('#goods_id').val();
if(typeof(str_num[1])=='undefined'){
  $('#myPager').pager({
    linkCreator: function(page, pager) {
      return __URL(SHOPMAIN+"/goods/consult?goods_id="+goods_id+"&page="+page);
    }
  });
}else{
  $('#myPager').pager({
    linkCreator: function(page, pager) {
      return __URL(SHOPMAIN+"/goods/consult?goods_id="+goods_id+"&page="+page+"&"+str_num[2]);
    }
  });
}



(function($) {

	$.fn.charCount = function(options){

		// default configuration properties
		var defaults = {
			allowed: 140,
			warning: 25,
			css: 'counter',
			counterElement: 'span',
			counterContainerID:'',
			cssWarning: 'warning',
			cssExceeded: 'exceeded',
			firstCounterText: '',
			endCounterText: '',
			errorCounterText: '',
			errortype: 'positive'	// positive or negative
		};
		var options = $.extend(defaults, options);

		function calculate(obj){
			var count = $(obj).val().length;
			var counterText = options.firstCounterText;
			var _css = '';
			containerObj = $("#"+options.counterContainerID);
			var available = options.allowed - count;
			if(available <= options.warning && available >= 0){
				_css = options.cssWarning;
			}
			if(available < 0){
				if (options.errortype == 'positive')available = -available;
				counterText = options.errorCounterText;
				_css = options.cssExceeded;
			} else {
				counterText = options.firstCounterText;
			}
			$(containerObj).children().html(counterText +'<em class="'+ _css +'">'+ available +'</em>'+ options.endCounterText);
		};
		this.each(function() {
			$("#"+options.counterContainerID).append('<'+ options.counterElement +' class="' + options.css + '"></'+ options.counterElement +'>');
			calculate(this);
			$(this).keyup(function(){calculate(this)});
			$(this).change(function(){calculate(this)});
			$(this).focus(function(){calculate(this)});
		});
	};

})(jQuery);
