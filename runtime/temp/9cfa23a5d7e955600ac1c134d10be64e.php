<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:37:"template/wap\default\index\index.html";i:1554114519;s:54:"D:\phpStudy\WWW\niushop\template\wap\default\base.html";i:1553848818;}*/ ?>
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
	
<link rel="stylesheet" href="/template/wap/default/public/css/index.css"/>
<link rel="stylesheet" href="/template/wap/default/public/css/liMarquee.css">
<link rel="stylesheet" href="/template/wap/default/public/plugin/swiper/css/swiper.min.css"/>
<script src="/template/wap/default/public/plugin/swiper/js/swiper.min.js"></script>

</head>
<body>
<?php 
	//默认图片
	$default_images = api("System.Config.defaultImages");
	$default_images = $default_images['data'];
	$default_goods_img = $default_images["value"]["default_goods_img"];//默认商品图片
	$default_headimg = $default_images["value"]["default_headimg"];//默认用户头像
 
	$page_layout = api("System.Config.wapPageLayout");
	$page_layout = $page_layout['data'];
	if(!empty($page_layout)){
		$page_layout = json_decode($page_layout,true);
	}else{
		$page_layout = array( [ "tag" => "follow-wechat", "isVisible" => true ], [ "tag" => "banner", "isVisible" => true ], [ "tag" => "search", "isVisible" => true ], [ "tag" => "nav", "isVisible" => true ],
				[ "tag" => "notice", "isVisible" => true ], [ "tag" => "coupons", "isVisible" => true ], [ "tag" => "games", "isVisible" => true ], [ "tag" => "discount", "isVisible" => true ],
				[ "tag" => "games", "isVisible" => true ], [ "tag" => "spell-group", "isVisible" => true ], [ "tag" => "adv", "isVisible" => true ], [ "tag" => "goods", "isVisible" => true ],
				[ "tag" => "bottom", "isVisible" => true ]);
	}
 ?>
<div class="pay-layout">
<?php if(is_array($page_layout) || $page_layout instanceof \think\Collection || $page_layout instanceof \think\Paginator): if( count($page_layout)==0 ) : echo "" ;else: foreach($page_layout as $k=>$vo): if($vo['tag'] == 'follow-wechat'): if($vo['isVisible']): ?>
        <!--关注微信公众号，标识：是否显示顶部关注  0：[隐藏]，1：[显示]-->
            <?php if($is_subscribe == 1): ?>
            <div class="follow-wechat-account">
                <span class="mui-icon mui-icon-closeempty" onclick="$('.follow-wechat-account').hide();"></span>
                <div class="foucs-on-block">
                    <div class="foucs-block">
                        <?php if($source_img_url != ''): ?>
                        <img class="user-bg" src="<?php echo __IMG($source_img_url); ?>">
                        <?php else: ?>
                        <img class="user-bg" src="/template/wap/default/public/img/test.png">
                        <?php endif; ?>
                    </div>
                    <?php if($source_user_name != ''): ?>
                    <p><?php echo lang("i_am_your_best_friend"); ?><span><?php echo $source_user_name; ?></span>,<?php echo lang("recommended_to_you_business_from_now"); ?></p>
                    <?php else: ?>
                    <p><?php echo $platform_shopname; ?></p>
                    <?php endif; ?>
                    <button type="button" class="mui-btn"><?php echo lang("click_on_the_attention"); ?></button>
                    <div class="mask"></div>
                </div>
            </div>
            <?php endif; ?>
            <!-- 微信公众号弹出层 -->
            <div class="wechat-popup">
                <div>
                    <img src="<?php echo __IMG($web_info['web_qrcode']); ?>"/>
                    <p><?php echo lang("press_two_dimensional_code_public_concern_WeChat"); ?></p>
                </div>
            </div>
        <?php endif; elseif($vo['tag']=='banner'): if($vo['isVisible']): ?>
        <!--轮播图-->
            <?php 
            $plat_adv_list = api("System.Shop.advDetail",['ap_keyword' => 'WAP_INDEX_SWIPER', 'export_type' => 'data']);
             if(!(empty($plat_adv_list['data']) || (($plat_adv_list['data'] instanceof \think\Collection || $plat_adv_list['data'] instanceof \think\Paginator ) && $plat_adv_list['data']->isEmpty()))): ?>
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                    <?php if(is_array($plat_adv_list['data']['advs']) || $plat_adv_list['data']['advs'] instanceof \think\Collection || $plat_adv_list['data']['advs'] instanceof \think\Paginator): if( count($plat_adv_list['data']['advs'])==0 ) : echo "" ;else: foreach($plat_adv_list['data']['advs'] as $key=>$vo): ?>
                        <div class="swiper-slide">
                            <a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap' . $vo['adv_url']); ?>" style="height:<?php echo $plat_adv_list['data']['ap_height']; ?>px;line-height:<?php echo $plat_adv_list['data']['ap_height']; ?>px;">
                                <img src="<?php echo __IMG($vo['adv_image']); ?>" alt="<?php echo lang('carousel_figure'); ?>">
                            </a>
                        </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
           	<?php endif; endif; elseif($vo['tag']=='search'): if($vo['isVisible']): ?>
        <!-- 搜索栏 -->
        <div class="controlSearch">
            <div class="control-search-input">
                <button type="button" class="search-button custom-search-button"><?php echo lang('search'); ?></button>
                <input type="text" class="search-input custom-search-input" placeholder="<?php echo lang('search_goods'); ?>">
            </div>
        </div>
        <?php endif; elseif($vo['tag']=='nav'): if($vo['isVisible']): ?>
        <!--导航栏-->
            <?php 
            $navigation_list = api("System.Shop.shopNavigationList",['page_index'=>1,'page_size'=>0,'type'=>2,'is_show'=>1,'order' => 'sort desc']);
            $navigation_list = $navigation_list['data']['data'];
             if(!(empty($navigation_list) || (($navigation_list instanceof \think\Collection || $navigation_list instanceof \think\Paginator ) && $navigation_list->isEmpty()))): ?>
            <nav class="navi">
                <?php if(is_array($navigation_list) || $navigation_list instanceof \think\Collection || $navigation_list instanceof \think\Paginator): if( count($navigation_list)==0 ) : echo "" ;else: foreach($navigation_list as $key=>$vo): if($vo['nav_type'] == 0): ?>
                    <a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap'.$vo['nav_url']); ?>">
                    <?php else: ?>
                    <a href="<?php echo $vo['nav_url']; ?>">
                    <?php endif; ?>
                        <span>
                            <img src="<?php echo __IMG($vo['nav_icon']); ?>"><span class="ns-text-color-black"><?php echo $vo['nav_title']; ?></span>
                        </span>
                    </a>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </nav>
            <?php endif; endif; elseif($vo['tag']=='notice'): ?>
    
        <!-- 公告 -->
        <?php if($vo['isVisible']): 
            $notice = api("System.Shop.shopNoticeList");
            $notice = $notice['data']['data'];
             if(!(empty($notice) || (($notice instanceof \think\Collection || $notice instanceof \think\Paginator ) && $notice->isEmpty()))): ?>
            <input type="hidden" id="hidden_notice_count" value="<?php echo count($notice); ?>">
            <div class="hot">
                <div class="notice-img">
                    <img src="/template/wap/default/public/img/index/hot.png">
                </div>
                <div class="dowebok dowebok-block">
                    <ul style="position: relative;">
                        <?php if(is_array($notice) || $notice instanceof \think\Collection || $notice instanceof \think\Paginator): if( count($notice)==0 ) : echo "" ;else: foreach($notice as $key=>$vo): ?>
                        <a href="http://127.0.0.1:8080/index.php/wap/notice/detail?id=<?php echo $vo['id']; ?>"><li><?php echo $vo['notice_title']; ?></li></a>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>
            <?php endif; endif; elseif($vo['tag']=='coupons'): if($vo['isVisible']): ?>
        <!--优惠券-->
            <?php 
            $coupon_list = api("System.Member.canReceiveCouponQuery",['shop_id'=>$instance_id,'uid'=>$uid]);
            $coupon_list = $coupon_list['data'];
             if(!(empty($coupon_list) || (($coupon_list instanceof \think\Collection || $coupon_list instanceof \think\Paginator ) && $coupon_list->isEmpty()))): ?>
            <div class="coupon-container">
     
                <div  class="coupon-all">
                    <?php if(is_array($coupon_list) || $coupon_list instanceof \think\Collection || $coupon_list instanceof \think\Paginator): $i = 0; $__LIST__ = $coupon_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <div class="receive-coupons" data-max-fetch="<?php echo $vo['max_fetch']; ?>" data-received-num="<?php if(!empty($uid)): ?><?php echo $vo['received_num']; else: ?>0<?php endif; ?>" onclick="coupon_receive(this,<?php echo $vo['coupon_type_id']; ?>)">
                        <div class="coupon-left">
                        	<span class="money-number">￥<?php echo $vo['money']; ?></span>
                        	<p class="explanation">满<?php echo $vo['at_least']; ?>可用</p>
                        </div>
                        
                        <div class="get ns-text-color coupon-right">领取</div>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <?php endif; endif; elseif($vo['tag']=='games'): if($vo['isVisible']): ?>
        <!--游戏活动-->
            <?php 
            $game_list = api("System.Promotion.promotionGamesList",['condition'=>['status' => 1,"activity_images" => ["neq",""]],'order'=>'game_id desc']);
            $game_list = $game_list['data'];
             if(!empty($game_list["data"])): ?>
            <div class="promotion-game-content">
                <img src="/template/wap/default/public/img/index/promotion_game.png" alt="" class="promotion-game-adv">
                <?php if(!empty($game_list["data"])): ?>
                <ul class="gameList">
                    <?php if(is_array($game_list['data']) || $game_list['data'] instanceof \think\Collection || $game_list['data'] instanceof \think\Paginator): $i = 0; $__LIST__ = $game_list['data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <li><a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/game/index?gid='.$vo['game_id']); ?>"><img src="<?php echo __IMG($vo['activity_images']); ?>" alt=""></a></li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                <?php endif; ?>
            </div>
            <?php endif; endif; elseif($vo['tag']=='discount'): if($vo['isVisible']): ?>
        <!--限时折扣-->
            <?php 
            $discount_data = api("System.Goods.newestDiscount");
            $discount = $discount_data['data'];
             if(!empty($discount)): ?>
                <div class="group-list-box">
	                <div class="group-list-box-in">
	                    <div class="controltype" onclick="location.href='<?php echo __URL("http://127.0.0.1:8080/index.php/wap/goods/discount"); ?>'">
	                        <div class="title ns-text-color-black discount-title">
	                        	<img src="/template/wap/default/public/img/index/discoun_title.png" alt="" />
	                        </div>
	                        <div class="discount-title-right">
	                        	<time class="remaining_time" starttime="<?php echo date('Y-m-d H:i:s',$discount['start_time']); ?>" endtime="<?php echo date('Y-m-d H:i:s',$discount['end_time']); ?>">
                                      <span class="day">2</span>
                                      <span class="hours">19</span>
                                      <em>:</em>
                                      <span class="min">04</span>
                                      <em>:</em>
                                      <span class="seconds">59</span>
                                  </time>
	                        </div>
	                    </div>
	                    <div class="discount-list">
	                        <ul>
	                            <?php if(is_array($discount['goods_list']) || $discount['goods_list'] instanceof \think\Collection || $discount['goods_list'] instanceof \think\Paginator): $k = 0; $__LIST__ = $discount['goods_list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;if($k < 3): ?>
    	                            <li>
    	                            	 <div class="goods_pic">
    	                                    <a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/detail?goods_id='.$vo['goods_id']); ?>">
    	                                        <img src="<?php echo __IMG($vo['picture_info']['pic_cover_small']); ?>" alt="">
    	                                    </a>
    	                                </div>
    	                                <div class="goods_info">
    	                                    <a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/detail?goods_id='.$vo['goods_id']); ?>">
    	                                        <div class="goods_name"><?php echo $vo['goods_name']; ?></div>
    	                                        <span class="goods_price"><i>￥</i><?php echo $vo['promotion_price']; ?></span>
    	                                    </a>
    	                                </div>
    	                            </li>
                                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
	                        </ul>
	                    </div>
	                </div>
                </div>
            <?php endif; endif; elseif($vo['tag']=='spell-group'): if($vo['isVisible']): ?>
        <!--拼团推荐-->
            <?php if($is_support_pintuan == 1): 

            $pintuan_list = api("NsPintuan.Pintuan.goodsList",['page_size'=>5,'condition'=> json_encode(['npg.is_open' => 1, 'npg.is_show' => 1]),'order'=>'npg.create_time desc']);
            $pintuan_list = $pintuan_list['data'];
             if(!(empty($pintuan_list['data']) || (($pintuan_list['data'] instanceof \think\Collection || $pintuan_list['data'] instanceof \think\Paginator ) && $pintuan_list['data']->isEmpty()))): ?>
            <div class="spelling-block">
            	<div class="assemble_logo"><img src="/template/wap/default/public/img/index/assemble_logo.png" alt="" /></div>
                <header>
                    <div class="ns-text-color-black assemble_title"><img src="/template/wap/default/public/img/index/assemble_title.png" alt="" /></div>
                    <a class="assemble_title_right" href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/pintuan'); ?>">更多&nbsp;&gt;</a>
                </header>
                <ul>
                    <?php if(is_array($pintuan_list['data']) || $pintuan_list['data'] instanceof \think\Collection || $pintuan_list['data'] instanceof \think\Paginator): if( count($pintuan_list['data'])==0 ) : echo "" ;else: foreach($pintuan_list['data'] as $k=>$vo): ?>
                    <li onclick="location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/detail?goods_id='.$vo['goods_id']); ?>'">
                        <div>
                            <img src="<?php echo __IMG($vo['pic_cover_mid']); ?>" class="lazy_load pic">
                        </div>
                        <footer>
                            <p class="ns-text-color-black"><?php echo $vo['goods_name']; ?></p>
                            <div class="assemble-tag">
                            	<div class="already-num">已抢<?php echo $vo['sales']; ?>件</div>
                            	<div class="people-num"><?php echo $vo['tuangou_num']; ?>人团</div>
                            	<div class="people-num">包邮</div>
                            </div>
                            <div class="assemble-foot">
	                            <div class="assemble-foot-left">
	                            	 <div class="tuangou-money ns-text-color">￥<?php echo $vo['tuangou_money']; ?></div>
	                                <div class="original-money">单买价<?php echo $vo['promotion_price']; ?></div>
	                            </div>
                               <div class="assemble-foot-right">
                                	<div class="mui-btn mui-btn-danger primary">GO</div>
                                	<div class="goin">去拼团</div>
                                </div>
                            </div>
                        </footer>
                    </li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
            <?php endif; endif; endif; elseif($vo['tag']=='adv'): if($vo['isVisible']): ?>
        <!--广告位-->
        <?php endif; elseif($vo['tag']=='goods'): if($vo['isVisible']): ?>
        <!--推荐商品（新品 精品 热卖、楼层等推荐商品）-->
            <!--推荐商品（新品 精品 热卖、楼层等推荐商品）-->
			<?php 
				$new_goods_list = api("System.Goods.newGoodsList", ["page_size" => 4]);
				$new_goods_list = $new_goods_list['data'];
			 if(!(empty($new_goods_list) || (($new_goods_list instanceof \think\Collection || $new_goods_list instanceof \think\Paginator ) && $new_goods_list->isEmpty()))): ?>
			<!-- 新品 -->
			<div class="floor">
				<div class="assemble_logo"><img src="/template/wap/default/public/img/index/brand_special.png" alt="" /></div>
				<div class="category-name ">
					<div class="floor-list-title">
						<div class="floor-title-left">
							<div class="floor-title-left-first"></div>
							<div class="floor-title-left-second"></div>
						</div>
						<span class="floor-left-nav ns-text-color-black">新品</span>
						<div class="floor-title-right">
							<div class="floor-title-left-first"></div>
							<div class="floor-title-left-second"></div>
						</div>
					</div>
					<a class="floor-right-nav assemble_title_right" href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/goodslist?category_id='.$class['category_id']); ?>">更多&nbsp;&gt;</a>
				</div>
				<section class="members-goodspic">
					<ul>
						<?php if(is_array($new_goods_list) || $new_goods_list instanceof \think\Collection || $new_goods_list instanceof \think\Paginator): if( count($new_goods_list)==0 ) : echo "" ;else: foreach($new_goods_list as $k=>$list): ?>
						<li class="gooditem">
							<div class="imgs">
								<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>">
									<img src="<?php echo __IMG($list['pic_cover_mid']); ?>" >
								</a>
							</div>
							<div class="info">
								<p class="goods-title">
									<a class="ns-text-color-black" class="ns-text-color-black" href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>"><?php echo $list['goods_name']; ?></a>
								</p>
								<div class="goods-info">
									<span class="goods_price ns-text-color">
										<?php if(in_array(($list['point_exchange_type']), explode(',',"0,2"))): ?>
										<em>￥<?php echo $list['promotion_price']; ?></em>
										<?php else: if($list['point_exchange_type'] == 1 && $list['promotion_price'] > 0): ?>
												<em>￥<?php echo $list['promotion_price']; ?>+<?php echo $list['point_exchange']; ?>积分</em>
											<?php else: ?>
												<em><?php echo $list['point_exchange']; ?>积分</em>
											<?php endif; endif; ?>
									</span>
									<div class="add_cart" onclick="window.location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>'">
										<img src="/template/wap/default/public/img/index/add_cart.png" alt="" />
									</div>
								</div>
							</div>
						</li>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</section>
			</div>
			<?php endif; 
				$recommend_goods_list = api("System.Goods.recommendGoodsList", ["page_size" => 4]);
				$recommend_goods_list = $recommend_goods_list['data'];
			 if(!(empty($recommend_goods_list) || (($recommend_goods_list instanceof \think\Collection || $recommend_goods_list instanceof \think\Paginator ) && $recommend_goods_list->isEmpty()))): ?>
			<!-- 精品 -->
			<div class="floor">
				<div class="category-name">
					<div class="floor-list-title">
						<div class="floor-title-left">
							<div class="floor-title-left-first"></div>
							<div class="floor-title-left-second"></div>
						</div>
						<span class="floor-left-nav ns-text-color-black">精品</span>
						<div class="floor-title-right">
							<div class="floor-title-left-first"></div>
							<div class="floor-title-left-second"></div>
						</div>
					</div>
					<a class="floor-right-nav assemble_title_right" href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/lists?category_id='.$class['category_id']); ?>">更多&nbsp;&gt;</a> 
				</div>
				<section class="members-goodspic">
					<ul>
						<?php if(is_array($recommend_goods_list) || $recommend_goods_list instanceof \think\Collection || $recommend_goods_list instanceof \think\Paginator): if( count($recommend_goods_list)==0 ) : echo "" ;else: foreach($recommend_goods_list as $k=>$list): ?>
						<li class="gooditem">
							<div class="imgs">
								<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>">
									<img src="<?php echo __IMG($list['pic_cover_mid']); ?>" >
								</a>
							</div>
							<div class="info">
								<p class="goods-title">
									<a class="ns-text-color-black" href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>"><?php echo $list['goods_name']; ?></a>
								</p>
								<div class="goods-info">
								<span class="goods_price ns-text-color">
									<?php if(in_array(($list['point_exchange_type']), explode(',',"0,2"))): ?>
									<em>￥<?php echo $list['promotion_price']; ?></em>
									<?php else: if($list['point_exchange_type'] == 1 && $list['promotion_price'] > 0): ?>
											<em>￥<?php echo $list['promotion_price']; ?>+<?php echo $list['point_exchange']; ?>积分</em>
										<?php else: ?>
											<em><?php echo $list['point_exchange']; ?>积分</em>
										<?php endif; endif; ?>
								</span>
								<div class="add_cart" onclick="window.location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>'">
										<img src="/template/wap/default/public/img/index/add_cart.png" alt="" />
								</div>
								</div>
							</div>
						</li>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</section>
			</div>
			<?php endif; 
				$hot_goods_list = api("System.Goods.hotGoodsList", ["page_size" => 4]);
				$hot_goods_list = $hot_goods_list['data'];
			 if(!(empty($hot_goods_list) || (($hot_goods_list instanceof \think\Collection || $hot_goods_list instanceof \think\Paginator ) && $hot_goods_list->isEmpty()))): ?>
			<!-- 热卖 -->
			<div class="floor">
				<div class="category-name">
					<div class="floor-list-title">
						<div class="floor-title-left">
							<div class="floor-title-left-first"></div>
							<div class="floor-title-left-second"></div>
						</div>
						<span class="floor-left-nav ns-text-color-black">热卖</span>
						<div class="floor-title-right">
							<div class="floor-title-left-first"></div>
							<div class="floor-title-left-second"></div>
						</div>
					</div>
					<a class="floor-right-nav assemble_title_right" href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/lists?category_id='.$class['category_id']); ?>">更多&nbsp;&gt;</a>
				</div>
				<section class="members-goodspic">
					<ul>
						<?php if(is_array($hot_goods_list) || $hot_goods_list instanceof \think\Collection || $hot_goods_list instanceof \think\Paginator): if( count($hot_goods_list)==0 ) : echo "" ;else: foreach($hot_goods_list as $k=>$list): ?>
						<li class="gooditem">
							<div class="imgs">
								<a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>">
									<img src="<?php echo __IMG($list['pic_cover_mid']); ?>" >
								</a>
							</div>
							<div class="info">
								<p class="goods-title">
									<a class="ns-text-color-black" href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>"><?php echo $list['goods_name']; ?></a>
								</p>
								<div class="goods-info">
								<span class="goods_price ns-text-color">
									<?php if(in_array(($list['point_exchange_type']), explode(',',"0,2"))): ?>
									<em>￥<?php echo $list['promotion_price']; ?></em>
									<?php else: if($list['point_exchange_type'] == 1 && $list['promotion_price'] > 0): ?>
											<em>￥<?php echo $list['promotion_price']; ?>+<?php echo $list['point_exchange']; ?>积分</em>
										<?php else: ?>
											<em><?php echo $list['point_exchange']; ?>积分</em>
										<?php endif; endif; ?>
									
								</span>
									<div class="add_cart" onclick="window.location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>'">
										<img src="/template/wap/default/public/img/index/add_cart.png" alt="" />
									</div>
								</div>
							</div>
						</li>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</section>
			</div>
			<?php endif; 
            $block_list = api("System.Goods.goodsCategoryBlockWap");
            $block_list = $block_list['data'];
             ?>
            <!-- 楼层版块 -->
            <?php if(is_array($block_list['data']) || $block_list['data'] instanceof \think\Collection || $block_list['data'] instanceof \think\Paginator): if( count($block_list['data'])==0 ) : echo "" ;else: foreach($block_list['data'] as $key=>$class): if(!(empty($class['goods_list']) || (($class['goods_list'] instanceof \think\Collection || $class['goods_list'] instanceof \think\Paginator ) && $class['goods_list']->isEmpty()))): ?>
            <div class="floor">
            	<?php if($class['img']): ?>
             	<div class="assemble_logo"><img src="<?php echo __IMG($class['img']); ?>" alt="" /></div>
             	<?php endif; ?>
                <div class="category-name">
                    <span class="floor-left-nav ns-text-color-black"  style="float:none;"><i class="title-border" style=""></i><?php echo $class['recommend_name']; ?></span>
                    <a class="floor-right-nav assemble_title_right" href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/lists'); ?>">更多&nbsp;&gt;</a>
                </div>
                <section class="members-goodspic">
                    <ul>
                        <?php if(is_array($class['goods_list']) || $class['goods_list'] instanceof \think\Collection || $class['goods_list'] instanceof \think\Paginator): if( count($class['goods_list'])==0 ) : echo "" ;else: foreach($class['goods_list'] as $k=>$list): ?>
                        <li class="gooditem">
                            <div class="imgs">
                                <a href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>">
                                    <img src="<?php echo __IMG($list['pic_cover_small']); ?>" >
                                </a>
                            </div>
                            <div class="info">
                                <p class="goods-title">
                                    <a class="ns-text-color-black" href="<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>">
                                        <?php echo $list['goods_name']; ?>
                                    </a>
                                </p>
                                <div class="goods-info">
                                <span class="goods_price ns-text-color">
                                    <?php if(in_array(($list['point_exchange_type']), explode(',',"0,2"))): ?>
                                    <em>￥<?php echo $list['promotion_price']; ?></em>
                                    <?php else: if($list['point_exchange_type'] == 1 && $list['promotion_price'] > 0): ?>
                                            <em>￥<?php echo $list['promotion_price']; ?>+<?php echo $list['point_exchange']; ?>积分</em>
                                        <?php else: ?>
                                            <em><?php echo $list['point_exchange']; ?>积分</em>
                                        <?php endif; endif; ?>
                                </span>
                                	<div class="add_cart" onclick="window.location.href='<?php echo __URL('http://127.0.0.1:8080/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>'">
										<img src="/template/wap/default/public/img/index/add_cart.png" alt="" />
									</div>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </section>
            </div>
            <?php endif; endforeach; endif; else: echo "" ;endif; endif; endif; endforeach; endif; else: echo "" ;endif; ?>
</div>
<input type="hidden" value="<?php echo $shop_id; ?>" id="hidden_shop_id"/>
<input type="hidden" id="appId" value="<?php echo $signPackage['appId']; ?>">
<input type="hidden" id="jsTimesTamp" value="<?php echo $signPackage['jsTimesTamp']; ?>">
<input type="hidden" id="jsNonceStr"  value="<?php echo $signPackage['jsNonceStr']; ?>">
<input type="hidden" id="jsSignature" value="<?php echo $signPackage['jsSignature']; ?>">


<?php 
	$data = api('System.Config.bottomNav', []);
	$nav_list = $data['data'];
	$nav_width = 100/count($nav_list['template_data']);
	$this_url = substr($_SERVER['PATH_INFO'], -10);
	$this_url = $this_url == '/wap' ? '/wap/index' : $this_url;
 if(strpos($nav_list['showPage'], $this_url) !== false): ?>
<div class="bottom-menu">
<?php else: ?>
<div class="bottom-menu" style="display: none">
<?php endif; ?>
	<ul>
		<?php foreach($nav_list['template_data'] as $k => $v): ?>
		<li class="selected" style="width:<?php echo $nav_width; ?>%">
			<a href="<?php echo __URL($v['href']); ?>">
				<?php if(strpos(__URL($v['href']), $this_url) !== false && $this_url != ''): ?>
				<div id="bottom_home">
					<img src="<?php echo __IMG($v['img_src_hover']); ?>" data-hover-src="<?php echo __IMG($v['img_src']); ?>">
				</div>
				<span data-hover-color="<?php echo $v['color']; ?>" style="color:<?php echo $v['color_hover']; ?>"><?php echo $v['menu_name']; ?></span>
				<?php else: ?>
				<div id="bottom_home">
					<img src="<?php echo __IMG($v['img_src']); ?>" data-hover-src="<?php echo __IMG($v['img_src_hover']); ?>">
				</div>
				<span data-hover-color="<?php echo $v['color_hover']; ?>" style="color:<?php echo $v['color']; ?>"><?php echo $v['menu_name']; ?></span>
				<?php endif; ?>
			</a>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
<div></div>


<input type="hidden" id="niushop_rewrite_model" value="<?php echo rewrite_model(); ?>">
<input type="hidden" id="niushop_url_model" value="<?php echo url_model(); ?>">
<input type="hidden" value="<?php echo $uid; ?>" id="uid"/>
<input type="hidden" id="hidden_shop_name" value="<?php echo $web_info['title']; ?>">

<script language="javascript" src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"> </script>
<script src="/template/wap/default/public/js/jquery.liMarquee.js"></script>
<script src="/template/wap/default/public/js/index.js"></script>

</body>
</html>