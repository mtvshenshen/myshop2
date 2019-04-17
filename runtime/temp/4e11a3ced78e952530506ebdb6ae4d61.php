<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"D:\phpStudy\WWW\niushop/application/common/view/public/error_tmpl.html";i:1552613388;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title><?php echo lang('jump_hint'); ?></title>
<link rel="stylesheet" type="text/css"
	href="/public/static/css/seller_center.css"></link>
</head>
<body>
    <div class="jump-message-comtent">
        <div class="system-message">
            <img src="/public/static/images/error_message.png" alt="" />
            <ul>
                <?php switch ($code) {case 0:?>
                    <li class="error-msg"><?php echo(strip_tags($msg));?></li>
                <?php } ?>
                <li class="jump-wait-meg"><?php echo lang('page_automation'); ?> <a id="href" href="<?php echo($url);?>"><?php echo lang('jump'); ?></a> <?php echo lang('waiting_time'); ?>： <b id="wait"><?php echo($wait);?></b></li>
            </ul>
        </div>
    </div>
    <script type="text/javascript">
        (function(){
            var wait = document.getElementById('wait'),
                href = document.getElementById('href').href;
            var interval = setInterval(function(){
                var time = --wait.innerHTML;
                if(time <= 0) {
                    location.href = href;
                    clearInterval(interval);
                };
            }, 1000);
        })();
    </script>
</body>
</html>