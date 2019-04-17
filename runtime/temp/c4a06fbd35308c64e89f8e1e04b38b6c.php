<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:37:"template/web\default\index\index.html";i:1554082367;s:54:"D:\phpStudy\WWW\niushop\template\web\default\base.html";i:1554112520;}*/ ?>
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
    
<link rel="stylesheet" href="/template/web/default/public/css/index.css"  />

</head>
<body>

<?php   
    //首页顶部广告图
    $top_list = api('System.Shop.advDetail', ['ap_keyword' => 'PC_INDEX_TOP', 'export_type' => 'data']); 
 if(!(empty($top_list['data']) || (($top_list['data'] instanceof \think\Collection || $top_list['data'] instanceof \think\Paginator ) && $top_list['data']->isEmpty()))): if(is_array($top_list['data']['advs']) || $top_list['data']['advs'] instanceof \think\Collection || $top_list['data']['advs'] instanceof \think\Paginator): if( count($top_list['data']['advs'])==0 ) : echo "" ;else: foreach($top_list['data']['advs'] as $k=>$vo): ?>
<div class="top-active" style="background-color:<?php echo $vo['background']; ?>;">
	<div class="top-active-wrap">
		<a href="<?php echo __URL($vo['adv_url']); ?>" target="_blank" style="width: <?php echo $top_list['data']['ap_width']; ?>px;height: <?php echo $top_list['data']['ap_height']; ?>px;"><img src="<?php echo __IMG($vo['adv_image']); ?>" "/></a>
		<a href="javascript:$('.close-i').parents('.top-active').remove();" title="关闭"><i class="close-i">x</i></a>
	</div>
</div>
<?php endforeach; endif; else: echo "" ;endif; ?>
<!-- </div> -->
<?php endif; 
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
$banner_list = api('System.Shop.advDetail', ['ap_keyword' => 'PC_INDEX_SWIPER', 'export_type' => 'data']);
 ?>
<div class="banner-wrap">
	<?php if(!(empty($banner_list["data"]) || (($banner_list["data"] instanceof \think\Collection || $banner_list["data"] instanceof \think\Paginator ) && $banner_list["data"]->isEmpty()))): ?>
	<div id="banner" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<?php if(is_array($banner_list['data']['advs']) || $banner_list['data']['advs'] instanceof \think\Collection || $banner_list['data']['advs'] instanceof \think\Paginator): if( count($banner_list['data']['advs'])==0 ) : echo "" ;else: foreach($banner_list['data']['advs'] as $k=>$vo): ?>
			<li data-target="#banner" data-slide-to="<?php echo $k; ?>" <?php if($k==0): ?>class="active"<?php endif; ?>></li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</ol>

		<div class="carousel-inner">
			<?php if(is_array($banner_list['data']['advs']) || $banner_list['data']['advs'] instanceof \think\Collection || $banner_list['data']['advs'] instanceof \think\Paginator): if( count($banner_list['data']['advs'])==0 ) : echo "" ;else: foreach($banner_list['data']['advs'] as $k=>$vo): ?>
			<div class="item <?php if($k==0): ?>active<?php endif; ?>" style="background-color:<?php echo $vo['background']; ?>">
				<?php if($vo['adv_image'] == ''): ?>
				<a href="javascript:;"><img alt="轮播图" src="/template/web/default/public/img/index/default_banner.png" ></a>
				<?php else: ?>
				<a href="<?php echo __URL($vo['adv_url']); ?>" target="_blank" style="width: <?php echo $banner_list['data']['ap_width']; ?>px;height: <?php echo $banner_list['data']['ap_height']; ?>px;line-height: <?php echo $banner_list['data']['ap_height']; ?>px;">
					<img alt="轮播图" src="<?php echo __IMG($vo['adv_image']); ?>"  onerror="this.src='/template/web/default/public/img/index/default_banner.png'">
				</a>
				<?php endif; ?>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</div>

		<a class="left carousel-control" href="#banner" data-slide="prev">
			<span class="icon icon-chevron-left"></span>
		</a>
		<a class="right carousel-control" href="#banner" data-slide="next">
			<span class="icon icon-chevron-right"></span>
		</a>
	</div>
	<?php endif; ?>
				
	<div class="sidebar">
		<div class="login-wrap">
			<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/member/index'); ?>" class="img-wrap">
				<?php if(!(empty($member_detail && $member_detail['user_info']['user_headimg']) || (($member_detail && $member_detail['user_info']['user_headimg'] instanceof \think\Collection || $member_detail && $member_detail['user_info']['user_headimg'] instanceof \think\Paginator ) && $member_detail && $member_detail['user_info']['user_headimg']->isEmpty()))): ?>
				<img alt="avatar" src="<?php echo __IMG($member_detail['user_info']['user_headimg']); ?>" class="img-circle">
				<?php else: ?>
				<img alt="avatar" src="/template/web/default/public/img/index/default_avatar.png" class="img-circle">
				<?php endif; ?>
			</a>
			<div class="operation">
				<?php if(!(empty($member_detail) || (($member_detail instanceof \think\Collection || $member_detail instanceof \think\Paginator ) && $member_detail->isEmpty()))): ?>
				<p><?php echo $member_detail['user_info']['nick_name']; ?></p>
				<div>
					<a href="javascript:logout()" class="ns-border-color ns-text-color"><?php echo lang('safe_exit'); ?></a>
				</div>
				<?php else: ?>
				<p>Hi,欢迎登录</p>
				<div>
					<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/login/index'); ?>" class="ns-border-color ns-text-color">登录</a>
					<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/login/register'); ?>" class="ns-border-color ns-text-color">注册</a>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<div class="content-wrap">
			<?php 
			$notice = api("System.Shop.shopNoticeList", ["page_size" => 5]);
			$notice = $notice['data'];
			$condition = [];
			$condition['status'] = 2;
			$article_list = api("System.Article.articleList", ['condition'=>$condition, "page_size" => 5]);
			$article_list = $article_list['data'];
			 ?>
			<div class="menu">
				<ul>
					<li class="active ns-border-color ns-text-color" type="notice">公告</li>
					<li type="article">最新资讯</li>
				</ul>
				<span class="notice-more"><a href="<?php echo __URL('http://127.0.0.1:8080/index.php/article/lists'); ?>" target="_blank">更多</a></span>
			</div>
			<?php if(!empty($notice['data'])): ?>
			<div class="item" data-type="notice" style="display: block;">
				<ul>
					<?php if(is_array($notice['data']) || $notice['data'] instanceof \think\Collection || $notice['data'] instanceof \think\Paginator): if( count($notice['data'])==0 ) : echo "" ;else: foreach($notice['data'] as $key=>$v): ?>
					<li><a href="<?php echo __URL('http://127.0.0.1:8080/index.php/notice/detail', 'id='.$v['id']); ?>" target="_blank" title="<?php echo $v["notice_title"]; ?>"><?php echo $v["notice_title"]; ?></a></li>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
			<?php else: ?>
			<div class="item" data-type="notice" style="display: block;">
				<ul>
					<li>暂无公告</li>
				</ul>
			</div>
			<?php endif; if(!empty($article_list['data'])): ?>
			<div class="item" data-type="article" style="display: none;">
				<ul>
					<?php if(is_array($article_list['data']) || $article_list['data'] instanceof \think\Collection || $article_list['data'] instanceof \think\Paginator): if( count($article_list['data'])==0 ) : echo "" ;else: foreach($article_list['data'] as $key=>$v): ?>
					<li><a href="<?php echo __URL('http://127.0.0.1:8080/index.php/article/detail', 'article_id='.$v['article_id']); ?>" target="_blank"><?php echo $v["title"]; ?></a></li>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
			<?php else: ?>
			<div class="item" data-type="article" style="display: none;">
				<ul>
					<li>暂无咨询</li>
				</ul>
			</div>
			<?php endif; ?>
		</div>
	</div>

</div>

<!-- 推荐广告位 -->
<?php 
$recommend_list = api('System.Shop.advDetail', ['ap_keyword' => 'PC_INDEX_RECOMMEND', 'export_type' => 'data']);
 if(!(empty($recommend_list['data']['advs']) || (($recommend_list['data']['advs'] instanceof \think\Collection || $recommend_list['data']['advs'] instanceof \think\Paginator ) && $recommend_list['data']['advs']->isEmpty()))): ?>
<div class="w1200">
	<div class="adv-middle">
		<?php if(is_array($recommend_list['data']['advs']) || $recommend_list['data']['advs'] instanceof \think\Collection || $recommend_list['data']['advs'] instanceof \think\Paginator): if( count($recommend_list['data']['advs'])==0 ) : echo "" ;else: foreach($recommend_list['data']['advs'] as $k=>$v): ?>
		<div class="item">
			<a href="<?php echo $v['adv_url']; ?>" target="_blank">
				<img src="<?php echo __IMG($v['adv_image']); ?>">
			</a>
		</div>
		<?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
</div>
<?php endif; ?>

<!--限時折扣-->
<?php 
$discount_data = api("System.Goods.newestDiscount");
$discount = $discount_data['data'];

$discount_adv = api('System.Shop.advDetail', ['ap_keyword' => 'PC_INDEX_DISCOUNT', 'export_type' => 'data']);
 if(!(empty($discount) || (($discount instanceof \think\Collection || $discount instanceof \think\Paginator ) && $discount->isEmpty()))): ?>
<div class="w1200 discount-wrap">
	<div class="db-discount btn-primary" id="db_discount" onclick="window.open(__URL('http://127.0.0.1:8080/index.php/goods/discount'))" data-start_time="<?php echo $discount['start_time']; ?>" data-end_time="<?php echo $discount['end_time']; ?>">
		<div class="db-discount-english">FLASH DEALS</div>
		<div class="db-discount-chinese">限时秒杀</div>
		<i class="db-discount-icon"></i>
		<div class="db-discount-desc">本场距离结束还剩</div>
		<div class="db-discount-time clearfix">
			<div class="time day"><span>00</span></div>
			<div class="time hour"><span>00</span></div>
			<div class="time minute"><span>00</span></div>
			<div class="time second"><span>00</span></div>
		</div>
	</div>

	<aside>
		<?php if(!(empty($discount_adv) || (($discount_adv instanceof \think\Collection || $discount_adv instanceof \think\Paginator ) && $discount_adv->isEmpty()))): ?>
		<div id="discountAdv" class="carousel slide">
			<div class="carousel-inner">
				<?php if(is_array($discount_adv['data']['advs']) || $discount_adv['data']['advs'] instanceof \think\Collection || $discount_adv['data']['advs'] instanceof \think\Paginator): if( count($discount_adv['data']['advs'])==0 ) : echo "" ;else: foreach($discount_adv['data']['advs'] as $k=>$vo): ?>
					<a class="item <?php if($k == '0'): ?>active<?php endif; ?>" href="<?php echo __URL('http://127.0.0.1:8080/index.php'.$vo['adv_url']); ?>">
						<img src="<?php echo __IMG($vo['adv_image']); ?>" alt="" />
					</a>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
			<ol class="carousel-indicators">
				<?php if(is_array($discount_adv['data']['advs']) || $discount_adv['data']['advs'] instanceof \think\Collection || $discount_adv['data']['advs'] instanceof \think\Paginator): if( count($discount_adv['data']['advs'])==0 ) : echo "" ;else: foreach($discount_adv['data']['advs'] as $k=>$vo): ?>
			    <li data-target="#discountAdv" data-slide-to="<?php echo $k; ?>" class="carousel-spot <?php if($k == '0'): ?>active<?php endif; ?>"></li>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</ol>
		</div>
		<?php endif; ?>
	</aside>

	<div id="discountGoods" class="carousel slide" data-interval="false">
		<div class="carousel-inner">
			<?php if(is_array($discount['goods_list']) || $discount['goods_list'] instanceof \think\Collection || $discount['goods_list'] instanceof \think\Paginator): if( count($discount['goods_list'])==0 ) : echo "" ;else: foreach($discount['goods_list'] as $k=>$vo): if($k % 4 == 0 && $k == 0): ?><div class="item active"><?php endif; ?>
				<a class="sk_item_lk" href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/detail','goods_id='.$vo['goods_id']); ?>" target="_blank" title="<?php echo $vo['goods_name']; ?>">
					<div class="lazyimg lazyimg_loaded sk_item_img">
						<img src="<?php echo __IMG($vo['picture_info']['pic_cover_mid']); ?>" class="lazyimg_img">
					</div>
					<p class="sk_item_name"><?php echo $vo['goods_name']; ?></p>
					<div class="sk_item_price">
						<span class="mod_price sk_item_price_new"><i>¥</i><span><?php echo $vo['promotion_price']; ?></span></span>
						<span class="mod_price sk_item_price_origin"><i>¥</i><span><?php echo $vo['price']; ?></span></span>
					</div>
				</a>
				<?php if($k % 4 == 3 && $k != 0): ?>
					</div>
					<?php if($k != count($discount['goods_list']) -1): ?>
					<div class="item">
					<?php endif; endif; if($k == count($discount['goods_list']) -1): ?></div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
	
		</div>

	</div>
</div>
<?php endif; ?>

<!--团购专区-->
<!-- <div class="w1200 group-buying-area">
	<ul>
		<li>
			<a class="group-lk" href="">
				<img class="group-img" src="https://img11.360buyimg.com/jdcms/s170x170_jfs/t27850/231/186597257/406098/297cf26/5b892c35N09de5057.jpg" class="lazyimg_img" alt="QCY T1 5.0真无线蓝牙耳机 Air分离式运动耳麦 运动跑步迷你隐形微型超小双耳入耳式 苹果/安卓手机通用 黑色">
				<div class="group-info">
					<p class="group_info_name">G.E GADOT 时尚女鞋靴 ins反光老爹鞋女潮百搭网红运动鞋子厚底学生超火复古智熏700v2 榻榻米 35</p>
					<div class="group_price">
						<i>¥</i>
						<span class="more_info_price_txt">298.00</span>
					</div>
				</div>
			</a>
		</li>
	</ul>
</div> -->
<!--楼层-->
<div class="w1200 catetop-floor-wp">
	<?php 
	    $block_list = api("System.Goods.goodsCategoryBlockPc");
	    echo $block_list['data'];
	 ?>

	<!--楼层监听-->
	<div class="catetop-lift" style="left: 170px; top: 50%;">
		<div class="lift-list">
<!-- 			<div class="catetop-lift-item"> -->
<!-- 				<span>限时抢购</span> -->
<!-- 			</div> -->
			 
<!-- 			<div class="catetop-lift-item lift-item-top"> -->
<!-- 			<span> -->
<!-- 				<i class="iconfont icon-up"></i> -->
<!-- 			</span> -->
<!-- 			</div> -->
		</div>
	</div>
</div>


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

<script src="/template/web/default/public/js/index.js"></script>
<script>
	window.onload=function () {
	$(".f-hd .extra .fgoods-hd ul li").mouseover(function () {
		$(".fgoods-list[data-id='" + $(this).data('id') + "']").show().siblings().hide();
		$(this).addClass("active");
	});

	return;
}
	
	function guanbi(){
		$(".top-active").css("display","none");
	}




</script>

</body>
</html>