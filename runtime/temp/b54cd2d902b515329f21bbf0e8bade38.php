<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:45:"template/wap\default\member\account_edit.html";i:1553831802;s:54:"D:\phpStudy\WWW\niushop\template\wap\default\base.html";i:1553848818;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta name="renderer" content="webkit"/>
	<meta http-equiv="X-UA-COMPATIBLE" content="IE=edge,chrome=1"/>
	<meta content="text/html; charset=UTF-8">
	<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<?php 
	$seoconfig = api("System.Config.seo", []);
	$seoconfig = $seoconfig['data'];
	 ?>
	<title><?php if($title_before != ''): ?><?php echo $title_before; ?>&nbsp;-&nbsp;<?php endif; ?><?php echo $platform_shopname; if($seoconfig['seo_title'] != ''): ?>-<?php echo $seoconfig['seo_title']; endif; ?></title>
	<meta name="keywords" content="<?php echo $seoconfig['seo_meta']; ?>"/>
	<meta name="description" content="<?php echo $seoconfig['seo_desc']; ?>"/>
	<link rel="shortcut icon" type="image/x-icon" href="/public/static/images/favicon.ico" media="screen"/>
	<link type="text/css" rel="stylesheet" href="/public/static/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="/template/wap/default/public/css/normalize.css"/>
	<link rel="stylesheet" href="/template/wap/default/public/plugin/mzui/css/mzui.css"/>
	<link rel="stylesheet" href="/template/wap/default/public/plugin/mescroll/css/mescroll.css"/>
	<link rel="stylesheet" href="/template/wap/default/public/css/common.css"/>
	<link type="text/css" rel="stylesheet" href="/template/wap/default/public/css/theme.css">
	<script src="/template/wap/default/public/plugin/mzui/lib/jquery/jquery-3.2.1.min.js"></script>
	<script src="/template/wap/default/public/plugin/mzui/js/mzui.js"></script>
	<script src="/template/wap/default/public/plugin/mescroll/js/mescroll.js"></script>
	<script src="/public/static/js/jquery.cookie.js"></script>
	<script src="/template/wap/default/public/js/common.js"></script>
	<script>
		var APPMAIN = 'http://127.0.0.1:8080/index.php/wap';
		var SHOPMAIN = "http://127.0.0.1:8080/index.php";
		var STATIC = "/public/static";
		var WAPIMG = "/template/wap/default/public/img";
		var WAPPLUGIN = "/template/wap/default/public/plugin";
		var UPLOAD = "";
		var DEFAULT_HEAD_IMG = "<?php echo $default_headimg; ?>";
		var uid = "<?php echo $uid; ?>";
	</script>
	
<link rel="stylesheet" type="text/css" href="/template/wap/default/public/css/member_account.css">

</head>
<body>
<?php 
	//默认图片
	$default_images = api("System.Config.defaultImages");
	$default_images = $default_images['data'];
	$default_goods_img = $default_images["value"]["default_goods_img"];//默认商品图片
	$default_headimg = $default_images["value"]["default_headimg"];//默认用户头像
 ?>

<header class="ns-header">
	<a  class="go-back" href="javascript:history.go(-1);"><i class="icon-angle-left"></i></a>
	<!-- <a class="ns-operation">操作</a> -->
	<h1><?php echo $title; ?></h1>
</header>
<div></div>


<?php 
	$balanceConfig = api("System.Config.balanceWithdraw", []);
	$balanceConfig = $balanceConfig['data'];
	$withdraw_account = $balanceConfig['value']['withdraw_account'];
	$id = request()->get('id', 0);
	if($id) {
		$result = api('System.Member.accountDetail', ['id' => $id]);
		$result = $result['data'];
	}
 ?>
<form class="form-info">
	<input type="hidden" value="<?php echo $id; ?>" id="account_id"/>
	<div class="div-item">
		<span class="ns-text-color-black"><?php echo lang('member_full_name'); ?></span>
		<input type="text" placeholder="<?php echo lang('member_enter_your_real_name'); ?>" id="realname" value="<?php echo $result['realname']; ?>"/>
	</div>
	<div class="div-item">
		<span class="ns-text-color-black"><?php echo lang('cell_phone_number'); ?></span>
		<input type="text" placeholder="<?php echo lang('member_enter_your_phone_number'); ?>" id="mobile" value="<?php echo $result['mobile']; ?>"/>
	</div>
	<div class="div-item">
		<span class="ns-text-color-black"><?php echo lang('member_account_type'); ?></span>
		<select id="account_type">
			<?php if(is_array($withdraw_account) || $withdraw_account instanceof \think\Collection || $withdraw_account instanceof \think\Paginator): if( count($withdraw_account)==0 ) : echo "" ;else: foreach($withdraw_account as $key=>$vo): if($vo['is_checked']): ?>
			<option value="<?php echo $vo['value']; ?>" data-account-type-name="<?php echo $vo['name']; ?>" <?php if($result['account_type'] == $vo['value']): ?>selected="selected"<?php endif; ?>><?php echo $vo['name']; ?></option>
			<?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</select>
	</div>
	
	<div class="div-item" data-flag="branch_bank_name" <?php if($result['account_type'] != 1 && $result['account_type'] != null): ?>style="display:none;"<?php endif; ?>>
		<span class="ns-text-color-black"><?php echo lang('member_sub_branch_information'); ?></span>
		<input type="text" placeholder="<?php echo lang('member_input_sub_branch_information'); ?>" id="branch_bank_name" value="<?php echo $result['branch_bank_name']; ?>"/>
	</div>
	<div class="div-item" data-flag="account_number" <?php if($result['account_type'] == 2): ?>style="display:none;"<?php endif; ?>>
		<span class="ns-text-color-black"><?php echo lang('cash_account'); ?></span>
		<input type="text" placeholder="<?php echo lang('please_enter_your_cash_account'); ?>" id="account_number" value="<?php echo $result['account_number']; ?>"/>
	</div>
	<input type="hidden" value="<?php echo $shop_id; ?>" id="shop_id"/>
</form>
<button onclick="update()" class="btn-save primary"><?php echo lang('member_modify'); ?></button>



<input type="hidden" id="niushop_rewrite_model" value="<?php echo rewrite_model(); ?>">
<input type="hidden" id="niushop_url_model" value="<?php echo url_model(); ?>">
<input type="hidden" value="<?php echo $uid; ?>" id="uid"/>
<input type="hidden" id="hidden_shop_name" value="<?php echo $web_info['title']; ?>">

<script type="text/javascript">
$(function(){
	$("#account_type").change(function(){
		console.log(parseInt($("#account_type").find("option:selected").val()));
		switch(parseInt($("#account_type").find("option:selected").val())){
			case 1:
				//银行卡
				$(".div-item[data-flag='branch_bank_name']").show();
				$(".div-item[data-flag='account_number']").show();
				break;
			case 2:	
				//微信
				$(".div-item[data-flag='branch_bank_name']").hide();
				$(".div-item[data-flag='account_number']").hide();
				break;
			case 3:
				//支付宝
				$(".div-item[data-flag='branch_bank_name']").hide();
				$(".div-item[data-flag='account_number']").show();
				break;
		}
	});
});
function update(){
	var shop_id = $("#shop_id").val();
	var id = $("#account_id").val();
	var realname = $("#realname").val();
	var mobile = $("#mobile").val();
	var account_type = $("#account_type").val();
	var account_type_name = $("#account_type").find("option:selected").attr("data-account-type-name");
	var account_number = $("#account_number").val();
	var branch_bank_name = $("#branch_bank_name").val();
	if(realname==''){
		toast("<?php echo lang('member_name_cannot_empty'); ?>");
		$("#realname").focus();
		return false;
	}
	if(!(/^1[3|4|5|7|8][0-9]{9}$/.test(mobile))){
		toast("<?php echo lang('member_phone_not_correct'); ?>");
		$("#mobile").focus();
		return false;
	}
	if(parseInt(account_type) == 1){
		if(branch_bank_name==''){
			toast("<?php echo lang('member_branch_cannot_empty'); ?>");
			$("#branch_bank_name").focus();
			return false;
		}
	}
	if(parseInt(account_type) != 2){
		if(account_number==''){
			toast("<?php echo lang('member_bank_cannot_empty'); ?>");
			$("#account_number").focus();
			return false;
		}
		if(account_number.length>30){
			toast("<?php echo lang('member_bank_max_length'); ?>");
			$("#account_number").focus();
			return false;
		}
	}
	switch(parseInt(account_type)){
	case 2:
		//微信不需要这些数据
		account_number = "";
		branch_bank_name = "";
		break;
	case 3:
		//支付宝不需要这些数据
		branch_bank_name = "";
		break;
	}
	var data = {
		"id":id,
		"realname":realname,
		"mobile":mobile,
		"account_type" : account_type,
		'account_type_name' : account_type_name,
		"account_number":account_number,
		"branch_bank_name":branch_bank_name
	};
	if(id != 0) {
		var url = 'System.Member.updateAccount';
	}else {
		var url = 'System.Member.addAccount';
		delete data['id'];
	}
	
	api(url, data, function(res) {
		if(res.data>0){
			window.location.href = __URL(APPMAIN+"/member/account?shop_id="+shop_id);
		}else{
			toast("<?php echo lang('unable_to_change'); ?>");
		}
	})
}
</script>

</body>
</html>