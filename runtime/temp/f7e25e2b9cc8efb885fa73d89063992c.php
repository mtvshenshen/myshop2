<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:38:"template/web\default\goods\detail.html";i:1554114639;s:54:"D:\phpStudy\WWW\niushop\template\web\default\base.html";i:1554112520;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<?php 

//默认图片
$default_images = api("System.Config.defaultImages");
$default_images = $default_images['data'];
$default_goods_img = $default_images["value"]["default_goods_img"];//默认商品图片
$default_headimg = $default_images["value"]["default_headimg"];//默认用户头像

//版权信息
$copy_right = api("System.Config.copyRight");
$copy_right = $copy_right['data'];

//商品分类
$goods_category_one = api("System.Goods.goodsCategoryTree");
$goods_category_one = $goods_category_one['data'];

//SEO配置
$seo_config = api("System.Config.seo");
$seo_config = $seo_config['data'];

 ?>
    <meta name="renderer" content="webkit" />
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge,chrome=1"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="renderer" content="webkit">
    <title><?php if($title_before != ''): ?><?php echo $title_before; ?>&nbsp;-&nbsp;<?php endif; ?><?php echo $title; if($seo_config['seo_title'] != ''): ?>&nbsp;-&nbsp;<?php echo $seo_config['seo_title']; endif; ?></title>
    <meta name="keywords" content="<?php echo $seo_config['seo_meta']; ?>" />
    <meta name="description" content="<?php echo $seo_config['seo_desc']; ?>"/>
    <link rel="shortcut icon" type="image/x-icon" href="/public/static/images/favicon.ico" media="screen"/>
    <link type="text/css" rel="stylesheet" href="/public/static/font-awesome/css/font-awesome.css">
    <link type="text/css" rel="stylesheet" href="/template/web/default/public/plugin/zui/css/zui.css">
    <link type="text/css" rel="stylesheet" href="/template/web/default/public/plugin/zui/css/zui-theme.css">
    <link type="text/css" rel="stylesheet" href="/template/web/default/public/css/normalize.css">
    <link type="text/css" rel="stylesheet" href="/template/web/default/public/css/common.css">
    <link type="text/css" rel="stylesheet" href="/template/web/default/public/css/theme.css">
    <script type="text/javascript" src="/template/web/default/public/plugin/zui/lib/jquery/jquery.js"></script>
    <script type="text/javascript" src="/template/web/default/public/plugin/zui/js/zui.js"></script>
    <script type="text/javascript" src="/template/web/default/public/plugin/zui/js/zui.lite.js"></script>
    <script src="/template/web/default/public/js/common.js"></script>
    <script type="text/javascript">
        var SHOPMAIN = 'http://127.0.0.1:8080/index.php';
        var APPMAIN = 'http://127.0.0.1:8080/index.php/wap';
        var UPLOAD = '';
		var WEBIMG = "/template/web/default/public/img";
		var DEFAULT_GOODS_IMG = "<?php echo __IMG($default_goods_img); ?>";
    </script>
    
<link type="text/css" rel="stylesheet" href="/template/web/default/public/css/goods_detail.css">
<script type="text/javascript" src="/template/web/default/public/js/jquery.fly.min.js"></script>
<link href="/public/static/video/css/video-js.min.css" rel="stylesheet" type="text/css">
<script src="/public/static/video/js/video.min.js"></script>

</head>
<body>


<?php 
//logo右侧的广告图
$logo_right_nav = api('System.Shop.advDetail', ['ap_keyword' => 'PC_INDEX_RIGHT_LOGO', 'export_type' => 'template']);
$logo_right_nav = $logo_right_nav['data'];

//导航
$navigation_list = api("System.Shop.shopNavigationList", ["page_index"=>1, "page_size"=>10, "type"=>1, "order"=>"sort"]);
$navigation_list = $navigation_list['data'];

//热门关键词搜索
$hot_keys = api("System.Config.hotSearch");
$hot_keys = $hot_keys['data'];

//默认关键词搜索
$default_keywords = api("System.Shop.defaultkeywords");
$default_keywords = $default_keywords['data'];

 ?>
<header class="ns-header">
    <div class="top-bar ns-border-color-gray">
        <div class="w1200 clearfix">
            <div class="pull-left">
                <?php if($member_detail): ?>
                <a href="<?php echo __URL('http://127.0.0.1:8080/index.php/member/index'); ?>" class="ns-text-color"><?php echo $member_detail['user_info']['nick_name']; ?></a>
                <a href="javascript:logout();">退出</a>
                <?php else: ?>
                <a href="<?php echo __URL('http://127.0.0.1:8080/index.php/login/index'); ?>" class="ns-text-color">登录</a>
                <a href="<?php echo __URL('http://127.0.0.1:8080/index.php/login/register'); ?>">注册</a>
                <?php endif; ?>
            </div>
            <ul class="pull-right">
                <li><a target="_blank" href="<?php echo __URL('http://127.0.0.1:8080/index.php/member/index'); ?>"><?php echo lang('member_center'); ?></a></li>
                <li><a target="_blank" href="<?php echo __URL('http://127.0.0.1:8080/index.php/member/order'); ?>">我的订单</a></li>
                <li><a target="_blank" href="<?php echo __URL('http://127.0.0.1:8080/index.php/member/footprint'); ?>">我的浏览</a></li>
                <li><a target="_blank" href="<?php echo __URL('http://127.0.0.1:8080/index.php/member/collection'); ?>"><?php echo lang('member_baby_collection'); ?></a></li>
                <li><a target="_blank" href="<?php echo __URL('http://127.0.0.1:8080/index.php/help/index'); ?>"><?php echo lang('shop_help_center'); ?></a></li>
                <li><a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap'); ?>" class="menu-hd wap-nav"><?php echo lang('mobile_terminal'); ?></a></li>
                <li class="focus">
                    <a href="javascript:;" target="_blank"><?php echo lang('attention_mall'); ?></a>
                    <div class="ns-border-color-gray">
                        <span></span>
                        <a target="_top"><img src="<?php echo __IMG($web_info['web_qrcode']); ?>" alt="<?php echo lang('official_wechat'); ?>"></a>
                        <p><?php echo lang('concerned_official_wechat'); ?></p>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="w1200 middle">
        <a class="ns-logo" href="<?php echo __URL('http://127.0.0.1:8080/index.php'); ?>">
            <img src="<?php echo __IMG($web_info['logo']); ?>"/>
        </a>

        <?php if(!(empty($logo_right_nav) || (($logo_right_nav instanceof \think\Collection || $logo_right_nav instanceof \think\Paginator ) && $logo_right_nav->isEmpty()))): ?>
        <div class="ns-logo-right">
            <?php echo $logo_right_nav; ?>
        </div>
        <?php endif; ?>

        <div class="ns-search">
            <div class="clearfix">
                <input class="ns-border-color ns-text-color-black" type="text" id="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $default_keywords; ?>" data-search-words="<?php echo $default_keywords; ?>">
                <button class="btn btn-primary" type="button"><?php echo lang('search'); ?></button>
            </div>
            <?php if(!(empty($hot_keys) || (($hot_keys instanceof \think\Collection || $hot_keys instanceof \think\Paginator ) && $hot_keys->isEmpty()))): ?>
            <div class="keyword">
                <?php if(is_array($hot_keys) || $hot_keys instanceof \think\Collection || $hot_keys instanceof \think\Paginator): $i = 0; $__LIST__ = $hot_keys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$hot_key): $mod = ($i % 2 );++$i;?>
                <a href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/lists','keyword='.$hot_key); ?>" title="<?php echo $hot_key; ?>"><?php echo $hot_key; ?></a>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <div class="ns-cart ns-border-color-gray">
            <div class="cart common-text-color">
                <i class="icon icon-shopping-cart"></i>
                <span>我的购物车</span>
                <em class="shopping-amount common-bg-color">0</em>
            </div>
            <div class="list ns-border-color-gray"></div>
        </div>
    </div>

    <nav class="w1200 clearfix">
        <div class="category">
            <div class="all">
                <a href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/category'); ?>" title="查看全部商品分类"><i class="icon icon-list-ul"></i>全部商品分类</a>
            </div>
            <ul>
                <?php foreach($goods_category_one as $k=>$vo): if($k < 13): ?>
                <li>
                    <div class="item-left">
                        <a href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/lists','category_id='.$vo['category_id']); ?>" title="<?php echo $vo['category_name']; ?>"><?php echo $vo['category_name']; ?></a>
                        <?php if($vo['count'] >0): ?>
                        <i class="icon icon-chevron-right"></i>
                        <?php endif; ?>
                    </div>
                    <?php if(!(empty($vo['child_list']) || (($vo['child_list'] instanceof \think\Collection || $vo['child_list'] instanceof \think\Paginator ) && $vo['child_list']->isEmpty()))): ?>
                    <div class="child ns-border-color-gray">
                        <?php foreach($vo['child_list'] as $vo2): ?>
                        <dl class="clearfix">
                            <dt><a href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/lists','category_id='.$vo2['category_id']); ?>" target="_blank" title="<?php echo $vo2['category_name']; ?>"><?php echo $vo2['category_name']; ?></a></dt>
                            <div class="line ns-bg-color-gray"></div>
                        </dl>
                        <?php if(!(empty($vo2['child_list']) || (($vo2['child_list'] instanceof \think\Collection || $vo2['child_list'] instanceof \think\Paginator ) && $vo2['child_list']->isEmpty()))): foreach($vo2['child_list'] as $vo3): ?>
                        <dd>
                            <?php if(!(empty($vo3['category_pic']) || (($vo3['category_pic'] instanceof \think\Collection || $vo3['category_pic'] instanceof \think\Paginator ) && $vo3['category_pic']->isEmpty()))): ?>
                            <img src="<?php echo __IMG($vo3['category_pic']); ?>">
                            <?php endif; ?>
                            <a href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/lists','category_id='.$vo3['category_id']); ?>" target="_blank" title="<?php echo $vo3['category_name']; ?>"><?php echo $vo3['category_name']; ?></a>
                        </dd>
                        <?php endforeach; endif; endforeach; ?>
                    </div>
                    <?php endif; ?>
                </li>
                <?php endif; endforeach; ?>
            </ul>
        </div>
        <?php if(!(empty($navigation_list['data']) || (($navigation_list['data'] instanceof \think\Collection || $navigation_list['data'] instanceof \think\Paginator ) && $navigation_list['data']->isEmpty()))): ?>
        <ul class="menu">
            <?php if(is_array($navigation_list['data']) || $navigation_list['data'] instanceof \think\Collection || $navigation_list['data'] instanceof \think\Paginator): if( count($navigation_list['data'])==0 ) : echo "" ;else: foreach($navigation_list['data'] as $k=>$nav): ?>
            <li>
                <?php if($nav['nav_type'] == 0): ?>
                <a class="ns-border-color-hover" <?php if($nav['is_blank'] == 1): ?>target="_blank"<?php endif; ?> href="<?php echo __URL('http://127.0.0.1:8080/index.php'.$nav['nav_url']); ?>" title="<?php echo $nav['nav_title']; ?>"><?php echo $nav['nav_title']; ?></a>
                <?php else: ?>
                <a class="ns-border-color-hover" <?php if($nav['is_blank'] == 1): ?>target="_blank"<?php endif; ?> href="<?php echo $nav['nav_url']; ?>" title="<?php echo $nav['nav_title']; ?>"><?php echo $nav['nav_title']; ?></a>
                <?php endif; ?>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <?php endif; ?>
    </nav>

</header>


<div class="ns-main w1200">
    
<?php 
	$goods_detail = $data['goods_detail'];

	//判断用户是否收藏该商品
	if(!empty($uid)){
		$whether_collection = api("System.Goods.whetherCollection",['fav_id'=>$goods_id,'fav_type'=>'goods']);
		$whether_collection = $whether_collection['data'];
	}

	//商家服务
	$merchant_service_list = api('System.Config.merchantService');
	$merchant_service_list = $merchant_service_list['data'];

 ?>
<ol class="breadcrumb">
	<li><a href="<?php echo __URL('http://127.0.0.1:8080/index.php'); ?>"><?php echo lang('home_page'); ?></a></li>
	<?php if(!(empty($goods_detail['parent_category_name']) || (($goods_detail['parent_category_name'] instanceof \think\Collection || $goods_detail['parent_category_name'] instanceof \think\Paginator ) && $goods_detail['parent_category_name']->isEmpty()))): foreach($goods_detail['parent_category_name'] as $vo): ?>
	<li><a href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/lists','category_id='.$vo['category_id']); ?>"><?php echo $vo['category_name']; ?></a></li>
	<?php endforeach; endif; ?>
	<li class="active"><?php echo $goods_detail['goods_name']; ?></li>
</ol>

<div class="goods-detail">
	
	<div class="preview-wrap">
		
		<div id="magnifier-wrap">
			<div class="magnifier-main">
				<img class="mag-target-img" src="<?php echo __IMG($goods_detail['img_list'][0]['pic_cover_big']); ?>" data-src="<?php echo __IMG($goods_detail['img_list'][0]['pic_cover_big']); ?>">
			</div>
			<?php if(!(empty($goods_detail['goods_video_address']) || (($goods_detail['goods_video_address'] instanceof \think\Collection || $goods_detail['goods_video_address'] instanceof \think\Paginator ) && $goods_detail['goods_video_address']->isEmpty()))): ?>
			<i class="icon icon-play-circle"></i>
			<?php endif; ?>
			<span class="spec-left-btn icon icon-caret-left"></span>
			<span class="spec-right-btn icon icon-caret-right on"></span>
			<div class="spec-items">
				<ul>
					<?php if(!(empty($goods_detail['sku_picture_list']) || (($goods_detail['sku_picture_list'] instanceof \think\Collection || $goods_detail['sku_picture_list'] instanceof \think\Paginator ) && $goods_detail['sku_picture_list']->isEmpty()))): ?>
					<!-- 显示sku组图 -->
					<?php if(is_array($goods_detail['sku_picture_list']) || $goods_detail['sku_picture_list'] instanceof \think\Collection || $goods_detail['sku_picture_list'] instanceof \think\Paginator): if( count($goods_detail['sku_picture_list'])==0 ) : echo "" ;else: foreach($goods_detail['sku_picture_list'] as $key=>$img): if(is_array($img['album_picture_list']) || $img['album_picture_list'] instanceof \think\Collection || $img['album_picture_list'] instanceof \think\Paginator): if( count($img['album_picture_list'])==0 ) : echo "" ;else: foreach($img['album_picture_list'] as $k=>$p): ?>
						<li <?php if($k==0): ?>class="on"<?php endif; ?>>
							<img src="<?php echo __IMG($p['pic_cover_micro']); ?>" data-lsrc="<?php echo __IMG($p['pic_cover_big']); ?>" data-maxsrc="<?php echo __IMG($p['pic_cover_big']); ?>" data-picture-id="<?php echo $p['pic_id']; ?>" data-pic-cover="<?php echo __IMG($p['pic_cover']); ?>"/>
						</li>
						<?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; else: ?>
					<!-- 显示商品组图 -->
					<?php if(is_array($goods_detail['img_list']) || $goods_detail['img_list'] instanceof \think\Collection || $goods_detail['img_list'] instanceof \think\Paginator): if( count($goods_detail['img_list'])==0 ) : echo "" ;else: foreach($goods_detail['img_list'] as $k=>$img): ?>
					<li <?php if($k==0): ?>class="on"<?php endif; ?>>
						<img src="<?php echo __IMG($img['pic_cover_micro']); ?>" data-lsrc="<?php echo __IMG($img['pic_cover_big']); ?>" data-maxsrc="<?php echo __IMG($img['pic_cover_big']); ?>" data-picture-id="<?php echo $img['pic_id']; ?>" data-pic-cover="<?php echo __IMG($img['pic_cover']); ?>" />
					</li>
					<?php endforeach; endif; else: echo "" ;endif; endif; ?>
				</ul>
			</div>
			<?php if(!(empty($goods_detail['goods_video_address']) || (($goods_detail['goods_video_address'] instanceof \think\Collection || $goods_detail['goods_video_address'] instanceof \think\Paginator ) && $goods_detail['goods_video_address']->isEmpty()))): ?>
			<video id="video" class="video-js vjs-default-skin" controls preload="none" poster="<?php echo __IMG($goods_detail['img_list'][0]['pic_cover_big']); ?>" data-setup="{}">
				<source src="<?php echo __IMG($goods_detail['goods_video_address']); ?>" type='video/mp4' />
			</video>
			<?php endif; ?>
		</div>
		
		<div class="share-collect">
			<!--<a href="javascript:;">-->
				<!--<i class="fa fa-share-alt" aria-hidden="true"></i>-->
				<!--<span>分享</span>-->
			<!--</a>-->
			<?php if($whether_collection>0): ?>
			<a href="javascript:;" class="js-collect-goods">
				<i class="icon icon-star ns-text-color"></i>
				<span class="ns-text-color" data-collects="<?php echo $goods_detail['collects']; ?>"><?php echo lang('member_cancel'); ?>（<?php echo $goods_detail['collects']; ?><?php echo lang('goods_popularity'); ?>）</span>
			</a>
			<?php else: ?>
			<a href="javascript:;" class="js-collect-goods">
				<i class="icon icon-star"></i>
				<span data-collects="<?php echo $goods_detail['collects']; ?>"><?php echo lang('goods_collection_goods'); ?>（<?php echo $goods_detail['collects']; ?><?php echo lang('goods_popularity'); ?>）</span>
			</a>
			<?php endif; ?>
		</div>
	</div>
	
	<div class="basic-info-wrap">
		
		<h1><?php echo $goods_detail['goods_name']; ?></h1>
		<?php if(!(empty($goods_detail['introduction']) || (($goods_detail['introduction'] instanceof \think\Collection || $goods_detail['introduction'] instanceof \think\Paginator ) && $goods_detail['introduction']->isEmpty()))): ?>
		<p class="desc ns-text-color"><?php echo $goods_detail['introduction']; ?></p>
		<?php endif; if($goods_detail['promotion_detail']['group_buy']): ?>
		<div class="discount-banner ns-bg-color">
			<i class="discount-icon"></i>
			<div class="activity-name"><?php echo $goods_detail['promotion_detail']['group_buy']['data']['group_name']; ?></div>
			<div class="surplus-time" data-value="<?php echo $goods_detail['promotion_detail']['group_buy']['data']['end_time']; ?>">
				<span><?php echo lang('goods_distance_ends'); ?></span>
				<span id="day"><i>00</i>:</span>
				<span id="hour"><i>00</i>:</span>
				<span id="min"><i>00</i>:</span>
				<span id="second"><i>00</i></span>
			</div>
		</div>
		<?php elseif($goods_detail['promotion_detail']['discount_detail']): ?>
		<div class="discount-banner ns-bg-color">
			<i class="discount-icon"></i>
			<div class="activity-name"><?php echo $goods_detail['promotion_detail']['discount_detail']['discount_name']; ?></div>
			<div class="surplus-time" data-value="<?php echo $goods_detail['promotion_detail']['discount_detail']['end_time']; ?>">
				<span><?php echo lang('goods_distance_ends'); ?></span>
				<span id="day"><i>00</i>:</span>
				<span id="hour"><i>00</i>:</span>
				<span id="min"><i>00</i>:</span>
				<span id="second"><i>00</i></span>
			</div>
		</div>
		<?php endif; ?>
		
		<div class="item-block">
			
			<div class="item-line promotion-price">
				<!--是否为预售不同的显示方式-->
				<?php if($goods_detail['is_open_presell'] == 1): ?>
				<dl class="item-line">
					<dt><?php echo lang('goods_deposit'); ?></dt>
					<dd>
						<em class="yuan ns-text-color">¥</em>
						<span class="price ns-text-color"><?php echo $goods_detail['presell_price']; ?></span>
						<?php if($goods_detail['point_exchange_type']==1 && $goods_detail['point_exchange']>0): ?>
						<!--积分加现金-->
						<span class="label ns-text-color">+<?php echo $goods_detail['point_exchange']; ?><?php echo lang('goods_integral'); ?></span>
						<?php endif; if(!empty($goods_detail['goods_unit'])): ?>
						<span class="label ns-text-color">/<?php echo $goods_detail['goods_unit']; ?></span>
						<?php endif; ?>
					</dd>
				</dl>
				<dl class="item-line">
					<dt><?php echo lang('goods_selling_price'); ?></dt>
					<dd>
						<em class="yuan ns-text-color">¥</em>
						<span class="price ns-text-color" data-price="<?php echo $goods_detail['promotion_price']; ?>"><?php echo $goods_detail['promotion_price']; ?></span>
						<?php if(!empty($goods_detail['goods_unit'])): ?>
						<span class="label ns-text-color">/<?php echo $goods_detail['goods_unit']; ?></span>
						<?php endif; ?>
					</dd>
				</dl>
				<?php elseif($goods_detail['promotion_detail']['group_buy']): ?>
				<dl class="item-line">
					<dt>团购价</dt>
					<dd>
						<em class="yuan ns-text-color">¥</em>
						<span class="price ns-text-color"><?php echo $goods_detail['promotion_detail']['group_buy']['data']['price_array'][0]['group_price']; ?></span>
						<?php if(!empty($goods_detail['goods_unit'])): ?>
						<span class="label ns-text-color">/<?php echo $goods_detail['goods_unit']; ?></span>
						<?php endif; ?>
					</dd>
				</dl>
				<?php elseif($goods_detail['point_exchange_type'] == 2 || $goods_detail['point_exchange_type'] == 3): ?>
				<dl class="item-line">
					<dt>积分兑换</dt>
					<dd>
						<span class="price ns-text-color"><?php echo $goods_detail['point_exchange']; ?></span>
						<span class="label ns-text-color"><?php echo lang('goods_integral'); ?></span>
					</dd>
				</dl>
				<?php elseif($goods_detail['is_show_member_price'] == 1): ?>
				<dl class="item-line">
					<dt><?php echo lang('goods_membership_price'); ?></dt>
					<dd>
						<em class="yuan ns-text-color">¥</em>
						<span class="price ns-text-color"><?php echo $goods_detail['member_price']; ?></span>
						<?php if($goods_detail['point_exchange_type']==1 && $goods_detail['point_exchange']>0): ?>
						<!--积分加现金-->
						<span class="label ns-text-color">+<?php echo $goods_detail['point_exchange']; ?><?php echo lang('goods_integral'); ?></span>
						<?php endif; if(!empty($goods_detail['goods_unit'])): ?>
						<span class="label ns-text-color">/<?php echo $goods_detail['goods_unit']; ?></span>
						<?php endif; ?>
					</dd>
				</dl>
				<?php else: ?>
				<dl class="item-line">
					<dt><?php echo lang('goods_selling_price'); ?></dt>
					<dd>
						<em class="yuan ns-text-color">¥</em>
						<span class="price ns-text-color"><?php echo $goods_detail['promotion_price']; ?></span>
						<?php if($goods_detail['point_exchange_type']==1 && $goods_detail['point_exchange']>0): ?>
						<!--积分加现金-->
						<span class="label ns-text-color">+<?php echo $goods_detail['point_exchange']; ?><?php echo lang('goods_integral'); ?></span>
						<?php endif; if(!empty($goods_detail['goods_unit'])): ?>
						<span class="label ns-text-color">/<?php echo $goods_detail['goods_unit']; ?></span>
						<?php endif; ?>
					</dd>
				</dl>
				<?php endif; if(!(empty($goods_detail['goods_coupon_list']) || (($goods_detail['goods_coupon_list'] instanceof \think\Collection || $goods_detail['goods_coupon_list'] instanceof \think\Paginator ) && $goods_detail['goods_coupon_list']->isEmpty()))): ?>
				<dl class="item-line">
					<dt>优惠券</dt>
					<dd>
						<div class="coupon-list">
							<?php if(is_array($goods_detail['goods_coupon_list']) || $goods_detail['goods_coupon_list'] instanceof \think\Collection || $goods_detail['goods_coupon_list'] instanceof \think\Paginator): if( count($goods_detail['goods_coupon_list'])==0 ) : echo "" ;else: foreach($goods_detail['goods_coupon_list'] as $k=>$v): if($k < 3): if($v['at_least'] > 0): ?>
							<span class="item ns-text-color" onclick="coupon_receive(this,<?php echo $v['coupon_type_id']; ?>)" data-money="<?php echo $v['money']; ?>" data-at-least="<?php echo $v['at_least']; ?>" data-start-time="<?php echo date('Y.m.d',$v['start_time']); ?>"  data-end-time="<?php echo date('Y.m.d',$v['end_time']); ?>" data-max-fetch="<?php echo $v['max_fetch']; ?>" data-receive-quantity="<?php echo $v['receive_quantity']; ?>">满<?php echo rtrim(rtrim($v['at_least'], '0'), '.'); ?>减<?php echo rtrim(rtrim($v['money'], '0'), '.'); ?></span>
							<?php else: ?>
							<span class="item ns-text-color" onclick="coupon_receive(this,<?php echo $v['coupon_type_id']; ?>)" data-money="<?php echo $v['money']; ?>" data-at-least="<?php echo $v['at_least']; ?>" data-start-time="<?php echo date('Y.m.d',$v['start_time']); ?>"  data-end-time="<?php echo date('Y.m.d',$v['end_time']); ?>" data-max-fetch="<?php echo $v['max_fetch']; ?>" data-receive-quantity="<?php echo $v['receive_quantity']; ?>"><?php echo rtrim(rtrim($v['money'], '0'), '.'); ?>元无门槛券</span>
							<?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</dd>
				</dl>
				<?php endif; ?>
				
				<div class="statistical pull-right">
					<ul>
						<li>
							<p><?php echo lang('goods_cumulative_evaluation'); ?></p>
							<a href="#" class="ns-text-color js-evaluate-count">0</a>
						</li>
						<li>
							<p><?php echo lang('goods_cumulative_sales'); ?></p>
							<a href="#" class="ns-text-color" title="<?php echo $goods_detail['sales']; ?>"><?php echo $goods_detail['sales']; ?></a>
						</li>
					</ul>
				</div>
				
				<?php if($goods_detail['goods_type'] == 1): ?>
				
				<!-- 实物商品 -->
				<?php if($goods_detail['mansong_name'] != '' || $goods_detail['baoyou_name'] != ''): ?>
				<dl class="item-line">
					<dt><?php echo lang('goods_shop_activities'); ?></dt>
					<?php if($goods_detail['mansong_name'] != ''): ?>
					<dd><i class="i-activity-flag ns-text-color ns-border-color"><?php echo lang('goods_manjian'); ?></i><?php echo $goods_detail['mansong_name']; ?></dd>
					<?php endif; if($goods_detail['baoyou_name'] != ''): ?>
					<dd><i class="i-activity-flag ns-text-color ns-border-color"><?php echo lang('goods_free_shipping'); ?></i><?php echo $goods_detail['baoyou_name']; ?></dd>
					<?php endif; ?>
				</dl>
				<?php endif; else: ?>
				
					<!-- 虚拟商品 -->
					<?php if($goods_detail['mansong_name'] != ''): ?>
					<dl class="item-line">
						<dt><?php echo lang('goods_shop_activities'); ?></dt>
						<dd><i class="i-activity-flag ns-text-color ns-border-color"><?php echo lang('goods_manjian'); ?></i><?php echo $goods_detail['mansong_name']; ?></dd>
					</dl>
					<?php endif; endif; ?>
			</div>
		</div>
		
		<?php if($goods_detail['give_point'] != 0): ?>
		<dl class="item-line gift-point">
			<dt><?php echo lang('goods_gift_points'); ?></dt>
			<dd>
				<strong id="give_point" class="ns-text-color"><?php echo $goods_detail['give_point']; ?>&nbsp;<?php echo lang('points'); ?></strong>
			</dd>
		</dl>
		<?php endif; if(in_array(($goods_detail['point_exchange_type']), explode(',',"0,2"))): if($goods_detail['integral_balance'] > 0): ?>
		<dl class="item-line">
			<dt>积分抵现</dt>
			<dd>
				<span>积分可抵 <b><?php echo $goods_detail['integral_balance']; ?></b> 元</span>
			</dd>
		</dl>
		<?php endif; endif; if($goods_detail['max_buy']!=0): ?>
		<!-- 限购 -->
		<dl class="item-line">
			<dt><?php echo lang('goods_quantity_purchased'); ?></dt>
			<dd>
				<span><?php echo $goods_detail['max_buy']; if(empty($goods_detail['goods_unit'])): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?></span>
			</dd>
		</dl>
		<?php endif; if($goods_detail['min_buy']!=0): ?>
		<!-- 最小购买数量 -->
		<dl class="item-line">
			<dt><?php echo lang('minimum_purchase_quantity'); ?></dt>
			<dd>
				<span><?php echo $goods_detail['min_buy']; if(empty($goods_detail['goods_unit'])): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?></span>
			</dd>
		</dl>
		<?php endif; if($goods_detail['goods_type'] == 1): ?>
		<dl class="item-line delivery">
			<dt><?php echo lang('goods_delivery_to'); ?></dt>
			<dd>
				<div class="region-selected">
					<span>请选择地址</span>
					<i class="icon icon-angle-down"></i>
				</div>
				<div class="region-list">
					<ul class="nav nav-tabs ns-border-color">
						<li class="active"><a data-tab href="#tab_provinces"><span>请选择省</span><i class="icon icon-angle-down"></i></a></li>
						<li><a data-tab href="#tab_city"><span>请选择市</span><i class="icon icon-angle-down"></i></a></li>
						<li><a data-tab href="#tab_district"><span>请选择区/县</span><i class="icon icon-angle-down"></i></a></li>
						<!--<li><a data-tab href="#tab_area"><span>请选择街道</span><i class="icon icon-angle-down"></i></a></li>-->
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_provinces">
							<ul class="province clearfix"></ul>
						</div>
						<div class="tab-pane" id="tab_city">
							<ul class="city clearfix"></ul>
						</div>
						<div class="tab-pane" id="tab_district">
							<ul class="district clearfix"></ul>
						</div>
						<!--<div class="tab-pane " id="tab_area">-->
							<!--<ul class="town clearfix">-->
								<!--<li class="active"><a href="javascript:;">街道</a></li>-->
							<!--</ul>-->
						<!--</div>-->
					</div>
				</div>
				<span class="status js-shipping-name"><?php if($detail['shipping_fee'] == 0): ?>可配送 快递：免邮<?php else: ?>快递费：￥<?php echo $detail['shipping_fee']; endif; ?></span>
			</dd>
		</dl>
		<?php endif; if($goods_detail['is_open_presell'] != 0): ?>
		<!-- 发货时间 -->
		<dl class="item-line">
			<dt><?php echo lang('goods_delivery_time'); ?></dt>
			<dd>
				<?php if($goods_detail['presell_delivery_type'] == 1): ?>
				<span><?php echo getTimeStampTurnTime($goods_detail['presell_time']); ?>发货</span>
				<?php else: ?>
				<span>付款<?php echo $goods_detail['presell_day']; ?>天后发货</span>
				<?php endif; ?>
			</dd>
		</dl>
		<?php endif; if(!(empty($goods_detail['goods_ladder_preferential_list']) || (($goods_detail['goods_ladder_preferential_list'] instanceof \think\Collection || $goods_detail['goods_ladder_preferential_list'] instanceof \think\Paginator ) && $goods_detail['goods_ladder_preferential_list']->isEmpty()))): ?>
		<dl class="item-line">
			<dt>阶梯优惠</dt>
			<dd>
				<?php if(is_array($goods_detail['goods_ladder_preferential_list']) || $goods_detail['goods_ladder_preferential_list'] instanceof \think\Collection || $goods_detail['goods_ladder_preferential_list'] instanceof \think\Paginator): if( count($goods_detail['goods_ladder_preferential_list'])==0 ) : echo "" ;else: foreach($goods_detail['goods_ladder_preferential_list'] as $key=>$vo): ?>
				满<span class="ns-text-color text18"><?php echo $vo['quantity']; ?></span><?php if(empty($goods_detail['goods_unit'])): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?>，每<?php if(empty($goods_detail['goods_unit'])): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?>降<span class="ns-text-color text18"><?php echo $vo['price']; ?></span>元
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</dd>
		</dl>
		<?php endif; ?>
		
		<dl class="item-line service">
			<dt>服务</dt>
			<dd>
				<span>由<a href="javascript:;" class="ns-text-color"><?php echo $title; ?></a>发货并提供售后服务</span>
			</dd>
		</dl>
		
		<hr class="divider"/>
		<div class="sku-list">
			<?php if(is_array($goods_detail['spec_list']) || $goods_detail['spec_list'] instanceof \think\Collection || $goods_detail['spec_list'] instanceof \think\Paginator): if( count($goods_detail['spec_list'])==0 ) : echo "" ;else: foreach($goods_detail['spec_list'] as $k=>$spec): ?>
			<dl class="item-line">
				<dt><?php echo $spec['spec_name']; ?></dt>
				<dd>
					<ul>
						<?php if(is_array($spec['value']) || $spec['value'] instanceof \think\Collection || $spec['value'] instanceof \think\Paginator): if( count($spec['value'])==0 ) : echo "" ;else: foreach($spec['value'] as $key=>$spec_value): ?>
						<li data-spec-value-name="<?php echo $spec_value['spec_value_name']; ?>" data-id="<?php echo $spec_value['spec_id']; ?>:<?php echo $spec_value['spec_value_id']; ?>" <?php if($spec_value['disabled']): ?>class="disabled"<?php endif; ?>>
							<?php switch($spec_value['spec_show_type']): case "1": ?>
								<a href="javascript:;" title="<?php echo $spec_value['spec_value_name']; ?>" class="ns-border-color-hover <?php if($spec_value['selected']): ?>selected<?php endif; ?>">
									<span><?php echo $spec_value['spec_value_name']; ?></span>
									<i class="icon icon-check-sign ns-text-color"></i>
								</a>
								<?php break; case "2": ?>
								<!-- 颜色 -->
								<a href="javascript:;" title="<?php echo $spec_value['spec_value_name']; ?>" class="ns-border-color-hover <?php if($spec_value['selected']): ?>selected<?php endif; ?>">
									<span><?php if(!(empty($spec_value['spec_value_data']) || (($spec_value['spec_value_data'] instanceof \think\Collection || $spec_value['spec_value_data'] instanceof \think\Paginator ) && $spec_value['spec_value_data']->isEmpty()))): ?><b style="background: <?php echo $spec_value['spec_value_data']; ?>;"></b><?php endif; ?><?php echo $spec_value['spec_value_name']; ?></span>
									<i class="icon icon-check-sign ns-text-color"></i>
								</a>
								<?php break; case "3": ?>
								<a href="javascript:;" title="<?php echo $spec_value['spec_value_name']; ?>" class="ns-border-color-hover <?php if($spec_value['selected']): ?>selected<?php endif; ?>">
									<?php if($spec_value['spec_value_data'] == ''): ?>
									<span><?php echo $spec_value['spec_value_name']; ?></span>
									<?php else: ?>
									<img src="<?php echo __IMG($spec_value['spec_value_data']); ?>" width="40" height="40">
									<span data-show-big-pic="<?php echo __IMG($spec_value['spec_value_data_big_src']); ?>" data-picture-id="<?php echo $spec_value['picture_id']; ?>"><?php echo $spec_value['spec_value_name']; ?></span>
									<?php endif; ?>
									<i class="icon icon-check-sign ns-text-color"></i>
								</a>
								<?php break; endswitch; ?>
						</li>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</dd>
			</dl>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		
		<div class="buy-number">
			<dl class="item-line">
				<dt><?php echo lang('goods_number'); ?></dt>
				<dd>
					<div class="num-wrap">
						<input type="text" <?php if($goods_detail['stock']==0): ?>class="disabled" readonly="readonly"<?php endif; ?>
						value="<?php if($goods_detail['stock']>0): if($goods_detail['min_buy']>0): ?><?php echo $goods_detail['min_buy']; else: ?>1<?php endif; else: ?>0<?php endif; ?>"
						id="buy_number" data-min-buy="<?php if($goods_detail['min_buy'] !=0): ?><?php echo $goods_detail['min_buy']; else: ?>1<?php endif; ?>" data-max-buy="<?php if($goods_detail['max_buy']==0 || $goods_detail['max_buy']>$goods_detail['stock']): ?><?php echo $goods_detail['stock']; else: ?><?php echo $goods_detail['max_buy']; endif; ?>" data-sale-unit="<?php if($goods_detail['sale_unit']): ?><?php echo $goods_detail['sale_unit']; else: ?><?php echo lang('goods_piece'); endif; ?>">
						<div class="operation">
							<span onselectstart="return false;" class="increase <?php if($goods_detail['stock']==0): ?>disabled<?php endif; ?>" data-operator="+">+</span>
							<span onselectstart="return false;" class="decrease <?php if($goods_detail['stock']==0): ?>disabled<?php endif; ?>" data-operator="-">-</span>
						</div>
					</div>
					<span class="unit"><?php if(empty($goods_detail['goods_unit'])): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?></span>
					<?php if($goods_detail['is_stock_visible'] == 1): ?>
					<span class="inventory"><?php echo lang('goods_stock'); ?><?php echo $goods_detail['stock']; if(empty($goods_detail['goods_unit'])): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?></span>
					<?php endif; if($goods_detail['max_buy']!=0): ?>
					<!-- 限购 -->
					<em>(<?php echo lang('goods_restriction_per_person'); ?><?php echo $goods_detail['max_buy']; if(empty($goods_detail['goods_unit'])): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?>)</em>
					<?php endif; if($goods_detail['goods_purchase_restriction']['code'] == 0): ?>
					<div class="ns-text-color"><?php echo lang('goods_restriction_per_person'); ?><?php echo $goods_detail['max_buy']; if(empty($goods_detail['goods_unit'])): ?><?php echo lang('goods_piece'); else: ?><?php echo $goods_detail['goods_unit']; endif; ?>，<?php echo lang('goods_exceeded_the_limit_number'); ?></div>
					<?php endif; ?>
					
				</dd>
			</dl>
		</div>
		
		<dl class="item-line buy-btn">
			<dt></dt>
			<dd>
				<?php if($goods_detail['is_open_presell'] == 1): ?>
				<button class="btn btn-primary js-buy-now" type="button" <?php if($goods_detail['stock'] ==0): ?>disabled<?php endif; ?>><?php echo lang('goods_immediate_reservation'); ?></button>
				<?php else: if($goods_detail['state'] == 1): ?>
						<!-- 限购判断 -->
						<!--<?php if($goods_detail['goods_purchase_restriction']['code'] == 0): ?>purchase-restriction<?php endif; ?>-->
						<button class="btn btn-primary js-buy-now ns-bg-color-goods ns-text-color" type="button" <?php if($goods_detail['stock'] ==0): ?>disabled<?php endif; ?>><?php if($goods_detail['integral_flag'] == 1): ?><?php echo lang('goods_exchange'); else: ?><?php echo lang('goods_buy_now'); endif; ?></button>
						<?php if($goods_detail['goods_type'] == 1 && $goods_detail['integral_flag'] == 0 && !$goods_detail['promotion_detail']['group_buy']): ?>
							<!--只有普通商品可以加入购物车-->
							<!--<?php if($goods_detail['goods_purchase_restriction']['code'] == 0): ?>purchase-restriction<?php endif; ?>-->
							<button class="btn btn-primary js-add-cart" type="button" <?php if($goods_detail['stock'] ==0): ?>disabled<?php endif; ?>><i class="icon icon-shopping-cart"></i><?php echo lang('goods_add_cart'); ?></button>
						<?php endif; else: ?>
						<button class="btn btn-primary" type="button" disabled><?php echo lang('goods_laid_off'); ?></button>
					<?php endif; endif; if($goods_detail['QRcode'] != ''): ?>
				<a href="javascript:;" class="go-phone">
					<img src="/template/web/default/public/img/goods/qrcode.png"/>
					<div class="qrcode-wrap">
						<img src="<?php echo __IMG($goods_detail['QRcode']); ?>" alt="<?php echo lang('goods_code_picture'); ?>" width="100" height="100">
					</div>
				</a>
				<?php endif; ?>
				
			</dd>
		</dl>
	
		<?php if($merchant_service_list): ?>
		<!-- 商家服务 -->
		<dl class="item-line merchant-service">
			<dt><?php echo lang('merchant_service'); ?></dt>
			<?php if(is_array($merchant_service_list) || $merchant_service_list instanceof \think\Collection || $merchant_service_list instanceof \think\Paginator): if( count($merchant_service_list)==0 ) : echo "" ;else: foreach($merchant_service_list as $key=>$vo): ?>
			<dd>
				<span title="<?php echo $vo['describe']; ?>"><?php echo $vo['title']; ?></span>
			</dd>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</dl>
		<?php endif; ?>
		
	</div>
	
	<div class="clearfix"></div>
	
	<!-- 搭配套餐 -->
	<?php if(!(empty($goods_detail['promotion_detail']['combo_package']) || (($goods_detail['promotion_detail']['combo_package'] instanceof \think\Collection || $goods_detail['promotion_detail']['combo_package'] instanceof \think\Paginator ) && $goods_detail['promotion_detail']['combo_package']->isEmpty()))): ?>
	<article class="combo-package-promotion">
		<nav>
			<ul>
				<?php if(is_array($goods_detail['promotion_detail']['combo_package']['data']) || $goods_detail['promotion_detail']['combo_package']['data'] instanceof \think\Collection || $goods_detail['promotion_detail']['combo_package']['data'] instanceof \think\Paginator): if( count($goods_detail['promotion_detail']['combo_package']['data'])==0 ) : echo "" ;else: foreach($goods_detail['promotion_detail']['combo_package']['data'] as $k=>$vo): ?>
				<li class="ns-text-color-hover ns-border-color-hover <?php if($k == 0): ?>selected<?php endif; ?>" data-combo-id="<?php echo $vo['id']; ?>"><?php echo $vo['combo_package_name']; ?></li>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</nav>
		<?php if(is_array($goods_detail['promotion_detail']['combo_package']['data']) || $goods_detail['promotion_detail']['combo_package']['data'] instanceof \think\Collection || $goods_detail['promotion_detail']['combo_package']['data'] instanceof \think\Paginator): if( count($goods_detail['promotion_detail']['combo_package']['data'])==0 ) : echo "" ;else: foreach($goods_detail['promotion_detail']['combo_package']['data'] as $k=>$vo): ?>
		<div class="tab-content" <?php if($k > 0): ?>style="display:none"<?php endif; ?> data-combo-id="<?php echo $vo['id']; ?>">
		<div class="master">
			<div class="p-list">
				<div class="p-img">
					<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/detail','goods_id='.$vo['main_goods']['goods_id']); ?>" target="_blank">
						<img src="<?php echo __IMG($vo['main_goods']['pic_cover_mid']); ?>" width="130" height="130" alt="" title="<?php echo $vo['main_goods']['goods_name']; ?>">
					</a>
				</div>
				<div class="p-name">
					<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/detail','goods_id='.$vo['main_goods']['goods_id']); ?>" target="_blank"><?php echo $vo['main_goods']['goods_name']; ?></a>
				</div>
				<div class="p-price">
					<strong class="ns-text-color">￥<?php echo $vo['main_goods']['price']; ?></strong>
				</div>
				<i class="plus"></i>
			</div>
		</div>
		<div class="collocations">
			<ul>
				<?php if(is_array($vo['goods_array']) || $vo['goods_array'] instanceof \think\Collection || $vo['goods_array'] instanceof \think\Paginator): if( count($vo['goods_array'])==0 ) : echo "" ;else: foreach($vo['goods_array'] as $key=>$to): ?>
				<li data-push="2" class="p-list">
					<div class="p-img">
						<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/detail','goods_id='.$to['goods_id']); ?>" target="_blank">
							<img src="<?php echo __IMG($to['pic_cover_mid']); ?>" title="<?php echo $to['goods_name']; ?>" width="130" height="130">
						</a>
					</div>
					<div class="p-name">
						<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/detail','goods_id='.$to['goods_id']); ?>" target="_blank" title="<?php echo $to['goods_name']; ?>"><?php echo $to['goods_name']; ?></a>
					</div>
					<div class="p-price">
						<strong class="ns-text-color">￥<?php echo $to['price']; ?></strong>
					</div>
				</li>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
		<div class="results">
			<div class="p-price">
				<p>
					<span>原价</span>
					<s>￥<?php echo $vo['original_price']; ?></s>
				</p>
				<p>
					<span>节省</span>
					<span>￥<?php echo $vo['save_the_price']; ?></span>
				</p>
				<p>
					<span>套餐价</span>
					<strong class="ns-text-color">￥<?php echo $vo['combo_package_price']; ?></strong>
				</p>
			</div>
				<?php if($vo['main_goods']['stock'] > 0): ?>
				<button class="btn btn-primary combo-package-promotion-buy" type="button" data-combo-id="<?php echo $vo['id']; ?>" data-curr-id="<?php echo $vo['main_goods']['goods_id']; ?>">立即购买</button>
				<?php else: ?>
				<button class="btn btn-primary" type="button" disabled>立即购买</button>
				<?php endif; ?>
				<i class="equal"></i>
			</div>
		</div>
		<?php endforeach; endif; else: echo "" ;endif; ?>
	</article>
	<?php endif; ?>

	<div class="content-wrap">
		<div class="recommend-product">
			<aside class="hot-product">
				<h3>商品精选</h3>
				<ul></ul>
			</aside>
			
			<aside class="ranking-list">
				<h3>热销排行榜</h3>
				<ul class="nav nav-tabs ns-border-color">
					<li class="active ns-bg-color-hover ns-border-color-hover"><a data-tab href="#tab_sale_ranking"><?php echo lang('goods_sales_volume'); ?></a></li>
					<li class="ns-bg-color-hover ns-border-color-hover"><a data-tab href="#tab_collect_ranking"><?php echo lang('goods_collection_number'); ?></a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_sale_ranking">
						<ul></ul>
					</div>
					<div class="tab-pane" id="tab_collect_ranking">
						<ul></ul>
					</div>
				</div>
			</aside>
		</div>
		
		<article class="detail-wrap">
			<ul class="nav nav-tabs ns-border-color">
				<li class="active ns-bg-color-hover ns-border-color-hover"><a data-tab href="#tab_detail"><?php echo lang('goods_commodity_details'); ?></a></li>
				<li class="ns-bg-color-hover ns-border-color-hover"><a data-tab href="#tab_attr"><?php echo lang('goods_commodity_attribute'); ?></a></li>
				<li class="ns-bg-color-hover ns-border-color-hover"><a data-tab href="#tab_evaluate"><?php echo lang('goods_cumulative_evaluation'); ?>(<em class="evaluate-count js-evaluate-count">0</em>)</a></li>
				<li class="ns-bg-color-hover ns-border-color-hover"><a data-tab href="#tab_consult"><?php echo lang('goods_purchase_consultation'); ?></a></li>
			</ul>
			
			<div class="tab-content">
				<div class="tab-pane active" id="tab_detail"><?php echo $goods_detail['description']; ?></div>
				<div class="tab-pane" id="tab_attr">
					
					<!-- 规格参数 -->
					<ul class="parameter2 p-parameter-list">
						<?php if(!(empty($goods_detail['goods_attribute_list']) || (($goods_detail['goods_attribute_list'] instanceof \think\Collection || $goods_detail['goods_attribute_list'] instanceof \think\Paginator ) && $goods_detail['goods_attribute_list']->isEmpty()))): foreach($goods_detail['goods_attribute_list'] as $vo): if(!(empty($vo['attr_value_name']) || (($vo['attr_value_name'] instanceof \think\Collection || $vo['attr_value_name'] instanceof \think\Paginator ) && $vo['attr_value_name']->isEmpty()))): ?>
								<li title="<?php echo $vo['attr_value']; ?>：<?php echo $vo['attr_value_name']; ?>"><?php echo $vo['attr_value']; ?>：<?php echo $vo['attr_value_name']; ?></li>
								<?php endif; endforeach; endif; ?>
					</ul>
					
				</div>
				<div class="tab-pane" id="tab_evaluate">
					<h3><?php echo lang('goods_commodity_evaluation'); ?></h3>
					<div class="evaluate-wrap">
						<nav class="rating-type">
							<ul>
								<li data-type="0"><a href="#none" class="selected ns-text-color-hover">全部评价(<em class="js-evaluate-count">0</em>)</a></li>
								<li data-type="4"><a href="#none">晒图(<em class="js-evaluate-imgs-count">0</em>)</a></li>
								<li data-type="1"><a href="#none"><?php echo lang('goods_praise'); ?>(<em class="js-evaluate-praise-count">0</em>)</a></li>
								<li data-type="2"><a href="#none"><?php echo lang('goods_comments'); ?>(<em class="js-evaluate-center-count">0</em>)</a></li>
								<li data-type="3"><a href="#none"><?php echo lang('goods_bad'); ?>(<em class="js-evaluate-bad-count">0</em>)</a></li>
							</ul>
						</nav>
						<div class="evaluate-list">
							<ul></ul>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab_consult">
					
					<div class="ns-consult-wrap">
						<div class="ns-consult-tips">
							<i></i>
							<p><?php echo lang('goods_text'); ?>！</p>
						</div>
						<div class="ncs-cosult-askbtn">
							<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/consult','goods_id='.$goods_id.'#askQuestion'); ?>" target="_blank" class="btn btn-white"><?php echo lang('goods_need_consult'); ?></a>
						</div>
					</div>
					
					<ul class="consult-nav ns-border-color">
						<li class="selected ns-text-color-hover" data-type="0"><?php echo lang('whole'); ?></li>
						<li data-type="1"><?php echo lang('goods_commodity_consultation'); ?></li>
						<li data-type="2"><?php echo lang('goods_payment_problem'); ?></li>
						<li data-type="3"><?php echo lang('goods_invoice_and_warranty'); ?></li>
					</ul>
					
					<div class="consult-list js-consult">
						<ul></ul>
						<div class="more-consult">
							<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/consult','goods_id='.$goods_id); ?>" target="_blank"><?php echo lang('goods_view_all_consultation'); ?>&gt;&gt;</a>
						</div>
					</div>
					
				</div>
			</div>
		</article>
		
	</div>

</article>
<?php if(is_array($goods_detail['sku_list']) || $goods_detail['sku_list'] instanceof \think\Collection || $goods_detail['sku_list'] instanceof \think\Paginator): if( count($goods_detail['sku_list'])==0 ) : echo "" ;else: foreach($goods_detail['sku_list'] as $k=>$sku): ?>
<input type="hidden" name="goods_sku" value="<?php echo $sku['attr_value_items']; ?>" data-picture="<?php echo $sku['picture']; ?>" data-stock="<?php echo $sku['stock']; ?>" <?php if($sku['promote_price'] < $sku['member_price']): ?>data-price="<?php echo $sku['promote_price']; ?>" <?php else: ?>data-price="<?php echo $sku['member_price']; ?>"<?php endif; ?> data-promotion-price="<?php echo $sku['promote_price']; ?>" data-member-price="<?php echo $sku['member_price']; ?>" data-sku-id="<?php echo $sku['sku_id']; ?>" data-sku-name="<?php echo $sku['sku_name']; ?>" data-original-price="<?php echo $sku['market_price']; ?>"/>
<?php endforeach; endif; else: echo "" ;endif; ?>
<input type="hidden" id="goods_ladder_preferential_list" value='<?php echo json_encode($goods_detail['goods_ladder_preferential_list']); ?>'>
<input type="hidden" id="hidden_picture_id" value="<?php if($goods_detail['sku_picture']>0): ?><?php echo $goods_detail['sku_picture']; else: ?><?php echo $goods_detail['picture']; endif; ?>" />
<input type="hidden" id="hidden_province" value="<?php echo $user_location['province']; ?>" />
<input type="hidden" id="hidden_city" />
<input type="hidden" id="hidden_goods_type" value="<?php echo $goods_detail['goods_type']; ?>" />
<input type="hidden" id="current_time" value="<?php echo $goods_detail['current_time']; ?>"/>
<input type="hidden" id="hidden_min_buy" value="<?php if($goods_detail['min_buy'] !=0): ?><?php echo $goods_detail['min_buy']; else: ?>1<?php endif; ?>">

<?php if($goods_detail['is_open_presell'] == 1): ?>
<input type="hidden" id="hidden_order_type" value="6">
<?php else: ?>
<input type="hidden" id="hidden_order_type" value="1">
<?php endif; if($goods_detail['promotion_detail']['group_buy']): ?>
<input type="hidden" id="hidden_promotion_type" value="2" />
<?php elseif($goods_detail['integral_flag'] == 1): ?>
<input type="hidden" id="hidden_promotion_type" value="4" />
<?php else: ?>
<input type="hidden" id="hidden_promotion_type" value="0" />
<?php endif; if($goods_detail['goods_type'] == 1): ?>
<script type="text/javascript" src="/template/web/default/public/js/ns_select_region.js"></script>
<?php endif; ?>

</div>

<footer class="ns-footer">
    <div class="w1200">
        <?php 

        //商城服务
        $merchant_service_list = api("System.Config.merchantService");
        $merchant_service_list = $merchant_service_list['data'];

        //帮助中心
        $platform_help_class = api("System.Shop.helpClassList");
        $platform_help_class = $platform_help_class['data'];

        //帮助中心
        $platform_help_document = api("System.Shop.helpInfo");
        $platform_help_document = $platform_help_document['data'];

        //友情链接
        $link_list = api("System.Shop.shopLinkList");
        $link_list = $link_list['data']['data'];

        //客服链接配置
        $custom_service = api("System.Config.customService");
        $custom_service = $custom_service['data'];
        if (empty($custom_service)) {
        $custom_service['id'] = '';
        $custom_service['value']['service_addr'] = '';
        }else if($custom_service['value']['checked_num'] == 1){
        $custom_service['value']['service_addr'] =  $custom_service['value']['meiqia_service_addr'];
        }else if($custom_service['value']['checked_num'] == 2){
        $custom_service['value']['service_addr'] =  $custom_service['value']['kf_service_addr'];
        }else if($custom_service['value']['checked_num'] == 3){
        $custom_service['value']['service_addr'] = 'http://wpa.qq.com/msgrd?v=3&uin='.$custom_service['value']['qq_service_addr'].'&site=qq&menu=yes';
        }
         if(!(empty($merchant_service_list) || (($merchant_service_list instanceof \think\Collection || $merchant_service_list instanceof \think\Paginator ) && $merchant_service_list->isEmpty()))): ?>
        <div class="service ns-border-color-gray">
            <ul class="w1200 clearfix">
                <?php if(is_array($merchant_service_list) || $merchant_service_list instanceof \think\Collection || $merchant_service_list instanceof \think\Paginator): if( count($merchant_service_list)==0 ) : echo "" ;else: foreach($merchant_service_list as $k=>$vo): ?>
                <li class="ns-border-color-gray" style="width: <?php echo 100/count($merchant_service_list)-1?>%">
                    <?php if($vo['pic'] == ''): ?>
                    <i class="ico ico-service ns-bg-color-gray"></i>
                    <?php else: ?>
                    <i class="ico ico-service" style="background: url('<?php echo __IMG($vo['pic']); ?>') no-repeat;"></i>
                    <?php endif; ?>
                    <p><?php echo $vo['title']; ?></p>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <?php endif; ?>
        <div class="help w1200 clearfix">
            <div class="pull-left list">
                <?php if(!(empty($platform_help_class['data']) || (($platform_help_class['data'] instanceof \think\Collection || $platform_help_class['data'] instanceof \think\Paginator ) && $platform_help_class['data']->isEmpty()))): ?>
                <div class="wrap">
                    <?php if(is_array($platform_help_class['data']) || $platform_help_class['data'] instanceof \think\Collection || $platform_help_class['data'] instanceof \think\Paginator): if( count($platform_help_class['data'])==0 ) : echo "" ;else: foreach($platform_help_class['data'] as $key=>$class_vo): ?>
                    <dl>
                        <dt><?php echo $class_vo['class_name']; ?></dt>
                        <?php if(is_array($platform_help_document['data']) || $platform_help_document['data'] instanceof \think\Collection || $platform_help_document['data'] instanceof \think\Paginator): if( count($platform_help_document['data'])==0 ) : echo "" ;else: foreach($platform_help_document['data'] as $key=>$document_vo): if($class_vo['class_id'] == $document_vo['class_id']): ?>
                        <dd><a href="<?php echo __URL('http://127.0.0.1:8080/index.php/help/index','id='.$document_vo['id']); ?>" title="<?php echo $document_vo['title']; ?>" target="_blank"><?php echo $document_vo['title']; ?></a></dd>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </dl>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <?php endif; if(!(empty($link_list) || (($link_list instanceof \think\Collection || $link_list instanceof \think\Paginator ) && $link_list->isEmpty()))): ?>
                <div class="friendship-links clearfix">
                    <span><?php echo lang('friendship_link'); ?> : </span>
                    <div class="links-wrap-h">
                        <?php if(is_array($link_list) || $link_list instanceof \think\Collection || $link_list instanceof \think\Paginator): if( count($link_list)==0 ) : echo "" ;else: foreach($link_list as $key=>$vo): ?>
                        <a href="<?php echo $vo['link_url']; ?>" title="<?php echo $vo['link_title']; ?>" <?php if($vo['is_blank'] == 1): ?>target="_blank_"<?php endif; ?>><?php echo $vo['link_title']; ?></a>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="contact-us">
                <h3><?php echo lang('hotline'); ?></h3>
                <span class="phone common-text-color"><?php echo $web_info['web_phone']; ?></span>
                <a href="<?php echo $custom_service['value']['service_addr']; ?>" target="_blank" title="<?php echo lang('contact_customer_service'); ?>"><?php echo lang('consulting_customer_service'); ?></a>
            </div>

        </div>

        <?php if(!(empty($copy_right) || (($copy_right instanceof \think\Collection || $copy_right instanceof \think\Paginator ) && $copy_right->isEmpty()))): ?>
        <div class="ns-copyright">
            <?php if($copy_right['is_load']>0): ?>
            <p><?php echo $copy_right['bottom_info']['copyright_desc']; ?></p>
            <?php else: ?>
            <p>Copyright © 2015-2019 NiuShop开源商城&nbsp;版权所有 保留一切权利</p>
            <?php endif; ?>
            <p>
                <a href="javascript:;" target="_blank"><?php echo $web_info['third_count']; ?></a>
                <?php if($copy_right['is_load']>0): ?>
                <a href="<?php echo __URL($copy_right['bottom_info']['copyright_link']); ?>" target="_blank"><?php echo $copy_right['bottom_info']['copyright_companyname']; ?></a>
                <?php else: ?>
                <a href="http://www.niushop.com.cn" target="_blank">山西牛酷信息科技有限公司 提供技术支持</a>
                <?php endif; if(!(empty($copy_right['bottom_info']['copyright_meta']) || (($copy_right['bottom_info']['copyright_meta'] instanceof \think\Collection || $copy_right['bottom_info']['copyright_meta'] instanceof \think\Paginator ) && $copy_right['bottom_info']['copyright_meta']->isEmpty()))): ?>
                <span>备案号：<?php echo $copy_right['bottom_info']['copyright_meta']; ?></span>
                <?php endif; ?>
            </p>
            <?php if(!(empty($copy_right['bottom_info']['web_gov_record']) || (($copy_right['bottom_info']['web_gov_record'] instanceof \think\Collection || $copy_right['bottom_info']['web_gov_record'] instanceof \think\Paginator ) && $copy_right['bottom_info']['web_gov_record']->isEmpty()))): ?>
            <a href="<?php if($copy_right['bottom_info']['web_gov_record_url']): ?>$copy_right['bottom_info']['web_gov_record_url']<?php else: ?>javascript:;<?php endif; ?>" target="_blank">
            <img src="/public/static/images/gov_record.png" alt="公安备案">
            <span><?php echo $copy_right['bottom_info']['web_gov_record']; ?></span>
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

</footer>

<?php if($default_client): ?>
<div class="go-mobile" onclick="locationWap()" id="go_mobile">
    <img src="/template/web/default/public/img/go_mobile.png"/>
</div>
<?php endif; ?>

<aside class="right-sidebar">
    <div class="toolbar">
        <div class='menu'>
            <a href="<?php echo __URL('http://127.0.0.1:8080/index.php/member/index'); ?>">
                <div class="item-icon-box">
                    <i class="icon icon-user"></i>
                </div>
                <div class="text ns-bg-color">会员中心</div>
            </a>
            <a href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/cart'); ?>" class="js-sidebar-cart-trigger">
                <div class="item-icon-box">
                    <i class="icon icon-shopping-cart"></i>
                    <span class="sidebar-num ns-bg-color">0</span>
                </div>
                <div class="text ns-bg-color">购物车</div>
            </a>
            <a href="<?php echo __URL('http://127.0.0.1:8080/index.php/member/footprint'); ?>">
                <div class="item-icon-box">
                    <i class="icon icon-heart-empty"></i>
                </div>
                <div class="text ns-bg-color">我的足迹</div>
            </a>
            <a href="<?php echo __URL('http://127.0.0.1:8080/index.php/member/collection'); ?>">
                <div class="item-icon-box">
                    <i class="icon icon-time "></i>
                </div>
                <div class="text ns-bg-color">我的收藏</div>
            </a>
            <a href="javascript:;">
                <div class="item-icon-box">
                    <i class="icon icon-qrcode"></i>
                </div>
                <div class="text ns-bg-color qrcode ns-border-color-gray">
                    <img src="<?php echo __IMG($web_info['web_qrcode']); ?>">
                </div>
            </a>
        </div>
        <div class="menu back-top">
            <a href="javascript:;">
                <div class="item-icon-box">
                    <i class="icon icon-angle-up"></i>
                </div>
                <div class="text ns-bg-color">顶部</div>
            </a>
        </div>
    </div>
</aside>

<input type="hidden" id="hidden_default_headimg" value="<?php echo $default_headimg; ?>">
<input type="hidden" id="niushop_rewrite_model" value="<?php echo rewrite_model(); ?>">
<input type="hidden" id="niushop_url_model" value="<?php echo url_model(); ?>">
<input type="hidden" id="hidden_default_client" value="<?php echo $default_client; ?>">
<input type="hidden" id="hidden_shop_name" value="<?php echo $web_info['title']; ?>">
<script>
    var uid = "<?php echo $uid; ?>";
    var page_size = "<?php echo $page_size; ?>";
</script>

<script src="/template/web/default/public/js/magnifying_glass.js"></script>
<?php if(!(empty($goods_detail['goods_video_address']) || (($goods_detail['goods_video_address'] instanceof \think\Collection || $goods_detail['goods_video_address'] instanceof \think\Paginator ) && $goods_detail['goods_video_address']->isEmpty()))): ?>
<script>
var myPlayer = videojs('video');
$(function(){
	$("#magnifier-wrap .icon-play-circle").click(function () {
		$("#magnifier-wrap .video-js").show();
		$(this).hide();
		myPlayer.play();
	});
});
</script>
<?php endif; ?>
<script>
var goods_id = "<?php echo $goods_detail['goods_id']; ?>";
var sku_id = "<?php echo $goods_detail['sku_id']; ?>";
var goods_name = "<?php echo $goods_detail['goods_name']; ?>";
var whether_collection = "<?php echo $whether_collection; ?>";
var sku_name = "<?php echo $goods_detail['sku_name']; ?>";
var price = "<?php echo $goods_detail['price']; ?>";
var member_price = "<?php echo $goods_detail['member_price']; ?>";
var promotion_price = "<?php echo $goods_detail['promotion_price']; ?>";
var category_id = "<?php echo $goods_detail['category_id']; ?>";
var brand_id = "<?php echo $goods_detail['brand_id']; ?>";

var lang_goods_detail = {
	goods_already_collected : "<?php echo lang('goods_already_collected'); ?>",
	goods_collection_goods : "<?php echo lang('goods_collection_goods'); ?>",
	goods_popularity : "<?php echo lang('goods_popularity'); ?>",
	goods_cancelled_collected : "<?php echo lang('goods_cancelled_collected'); ?>",
	member_cancel : "<?php echo lang('member_cancel'); ?>",
	reached_the_limit : "<?php echo lang('reached_the_limit'); ?>",
	congratulations_on_your_success : "<?php echo lang('congratulations_on_your_success'); ?>",
	has_brought_over : "<?php echo lang('has_brought_over'); ?>",
	no_comment_yet : "<?php echo lang('no_comment_yet'); ?>",
	anonymous : "<?php echo lang('anonymous'); ?>",
	goods_shopkeeper_replies : "<?php echo lang('goods_shopkeeper_replies'); ?>",
	goods_additional_evaluation : "<?php echo lang('goods_additional_evaluation'); ?>",
	goods_no_consultation_yet : "<?php echo lang('goods_no_consultation_yet'); ?>",
	goods_consulting_user : "<?php echo lang('goods_consulting_user'); ?>",
	goods_tourist : "<?php echo lang('goods_tourist'); ?>",
	goods_consulting_type : "<?php echo lang('goods_consulting_type'); ?>",
	goods_commodity_consultation : "<?php echo lang('goods_commodity_consultation'); ?>",
	goods_payment_problem : "<?php echo lang('goods_payment_problem'); ?>",
	goods_invoice_and_warranty : "<?php echo lang('goods_invoice_and_warranty'); ?>",
	goods_consultation_content : "<?php echo lang('goods_consultation_content'); ?>",
	goods_merchant_reply : "<?php echo lang('goods_merchant_reply'); ?>",
};
</script>
<script src="/template/web/default/public/js/goods_detail.js"></script>

</body>
</html>