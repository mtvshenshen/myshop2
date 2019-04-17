<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:37:"template/web\default\goods\lists.html";i:1554120195;s:54:"D:\phpStudy\WWW\niushop\template\web\default\base.html";i:1554112520;}*/ ?>
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
    
<link rel="stylesheet" href="/template/web/default/public/css/goods_list.css">

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
$params = input();

$params['page_index'] = input('page_index', 1);
unset($params['action']);

$data = api('System.Goods.goodsListByConditions', $params);
$data = $data['data'];
$goods_list = $data['goods_list']; // 商品列表
$total_count = $goods_list['total_count']; // 总条数

$screen_brand = $data['category_brands']; // 品牌筛选项
$screen_spec = $data['goods_spec_array']; // 规格筛选项
$screen_attr = $data['attr_or_spec']; // 属性筛选项

$selected_spec = $data['spec_array']; // 已选择的规格
$selected_attr = $data['attr_array']; // 已选择的属性

$sales_goods_list = api("System.Goods.saleGoodsList",['page_size'=>3]);//销量排行
$sales_goods_list = $sales_goods_list['data'];

$new_goods_list = api("System.Goods.newGoodsList",['page_size'=>3,'category_id'=>$params['category_id']]);//销量排行
$new_goods_list = $new_goods_list['data'];
 ?>

<div class="w1210 selector">
	<?php if(!empty($params['brand_name']) || !empty($selected_spec) || !empty($selected_attr) || !empty($params['min_price'])): ?>
	<!-- start 已选 start -->
	<div class="selector-line">
		<div class="wrap clearfix">
	 		<div class="key">已选：</div>
	 		<div class="value selected">
	 			<ul class="clearfix">
	 				<!-- 取消品牌 -->
	 				<?php if(!empty($params['brand_name'])): ?>
	 				<li class="ns-border-color-hover" data-type="brand"><span>品牌：</span><span class="ns-text-color"><?php echo $params['brand_name']; ?></span><i class="ns-bg-color-hover">×</i></li>
	 				<?php endif; ?>
					<!-- 取消价格 -->
					<?php if(!empty($params['min_price'])): ?>
					<li class="ns-border-color-hover" data-type="price"><span>价格：</span><span class="ns-text-color"><?php echo round($params['min_price']); ?>-<?php echo round($params['max_price']); ?></span><i class="ns-bg-color-hover">×</i></li>
	 				<?php endif; ?>
	 				<!-- 取消规格 -->
	 				<?php if(!empty($selected_spec)): if(is_array($selected_spec) || $selected_spec instanceof \think\Collection || $selected_spec instanceof \think\Paginator): if( count($selected_spec)==0 ) : echo "" ;else: foreach($selected_spec as $key=>$vo): ?>
 						<li class="ns-border-color-hover" data-type="spec" data-spec="<?php echo $vo[0]; ?>" data-spec-value="<?php echo $vo[1]; ?>"><span><?php echo $vo[2]; ?>：</span><span class="ns-text-color"><?php echo $vo[3]; ?></span><i class="ns-bg-color-hover">×</i></li>
	 					<?php endforeach; endif; else: echo "" ;endif; endif; ?>
	 				<!-- 取消属性 -->
	 				<?php if(!empty($selected_attr)): if(is_array($selected_attr) || $selected_attr instanceof \think\Collection || $selected_attr instanceof \think\Paginator): if( count($selected_attr)==0 ) : echo "" ;else: foreach($selected_attr as $key=>$vo): ?>
 						<li class="ns-border-color-hover" data-type="attr" data-attr-value="<?php echo $vo[0]; ?>" data-attr-value-name="<?php echo $vo[1]; ?>" data-attr-value-id="<?php echo $vo[2]; ?>"><span><?php echo $vo[0]; ?>：</span><span class="ns-text-color"><?php echo $vo[1]; ?></span><i class="ns-bg-color-hover">×</i></li>
	 					<?php endforeach; endif; else: echo "" ;endif; endif; ?>
	 			</ul>
	 		</div>
		</div>
	</div>
	<!-- end 已选 end -->
	<?php endif; if(!isset($params['brand_name'])): if(!(empty($screen_brand) || (($screen_brand instanceof \think\Collection || $screen_brand instanceof \think\Paginator ) && $screen_brand->isEmpty()))): ?>
	<!-- start 品牌筛选 start -->
		<div class="wrap clearfix">
	 		<div class="key">品牌：</div>
		 	<div class="value brand">
				<ul class="clearfix all-show">
					<?php if(is_array($screen_brand) || $screen_brand instanceof \think\Collection || $screen_brand instanceof \think\Paginator): if( count($screen_brand)==0 ) : echo "" ;else: foreach($screen_brand as $key=>$vo): ?>
						<li class="ns-border-color-hover" brand-id="<?php echo $vo['brand_id']; ?>" brand-name="<?php echo $vo['brand_name']; ?>">
							<a href="javascript:;" title="360" class="ns-border-color-hover ns-text-color">
								<i></i>
								<?php if(!(empty($vo['brand_pic']) || (($vo['brand_pic'] instanceof \think\Collection || $vo['brand_pic'] instanceof \think\Paginator ) && $vo['brand_pic']->isEmpty()))): ?>
								<img src="<?php echo __IMG($vo['brand_pic']); ?>" width="102" height="36">
								<?php endif; ?>
								<?php echo $vo['brand_name']; ?>
							</a>
						</li>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
				<div class="confirm-select">
					<button class="btn cancel-multiple-selection">取消</button>
					<button class="btn btn-primary">确认</button>
				</div>
		 	</div>
		 	<div class="operation">
		 		<?php if(count($screen_brand) > 12): ?><a href="javascript:;" class="more-btn">更多</a><?php endif; ?>
			 	<a href="javascript:;" class="multiple-selection-btn">多选</a>
		 	</div>
		</div>
		<!-- end 品牌筛选 end -->
		<?php endif; endif; if(!(empty($screen_spec) || (($screen_spec instanceof \think\Collection || $screen_spec instanceof \think\Paginator ) && $screen_spec->isEmpty()))): ?>
	<!-- start 规格筛选 start -->
		<?php if(is_array($screen_spec) || $screen_spec instanceof \think\Collection || $screen_spec instanceof \think\Paginator): if( count($screen_spec)==0 ) : echo "" ;else: foreach($screen_spec as $key=>$vo): if(!(empty($vo['values']) || (($vo['values'] instanceof \think\Collection || $vo['values'] instanceof \think\Paginator ) && $vo['values']->isEmpty()))): ?>
			<div class="selector-line">
				<div class="wrap clearfix">
			 		<div class="key"><?php echo $vo['spec_name']; ?>：</div>
				 	<div class="value line spec">
				 		<ul class="clearfix">
							<?php if(is_array($vo['values']) || $vo['values'] instanceof \think\Collection || $vo['values'] instanceof \think\Paginator): if( count($vo['values'])==0 ) : echo "" ;else: foreach($vo['values'] as $key=>$so): ?>
			 					<li spec-id="<?php echo $vo['spec_id']; ?>" spec-value-id="<?php echo $so['spec_value_id']; ?>"><a href="javascript:;"><?php echo $so['spec_value_name']; ?></a></li>
							<?php endforeach; endif; else: echo "" ;endif; ?>
				 		</ul>
			 		</div>
			 		<div class="operation">
				 		<?php if(count($vo['values']) > 12): ?><a href="javascript:;" class="more-btn">更多</a><?php endif; ?>
				 	</div>
		 		</div>
			</div>
			<?php endif; endforeach; endif; else: echo "" ;endif; ?>
	<!-- end 规格筛选 end -->
	<?php endif; if(!(empty($screen_attr) || (($screen_attr instanceof \think\Collection || $screen_attr instanceof \think\Paginator ) && $screen_attr->isEmpty()))): ?>
	<!-- start 属性筛选 start -->
		<?php if(is_array($screen_attr) || $screen_attr instanceof \think\Collection || $screen_attr instanceof \think\Paginator): if( count($screen_attr)==0 ) : echo "" ;else: foreach($screen_attr as $key=>$vo): if(!(empty($vo['value_items']) || (($vo['value_items'] instanceof \think\Collection || $vo['value_items'] instanceof \think\Paginator ) && $vo['value_items']->isEmpty()))): ?>
			<div class="selector-line">
				<div class="wrap clearfix">
			 		<div class="key"><?php echo $vo['attr_value_name']; ?>：</div>
				 	<div class="value line attr">
				 		<ul class="clearfix">
			 				<?php if(is_array($vo['value_items']) || $vo['value_items'] instanceof \think\Collection || $vo['value_items'] instanceof \think\Paginator): if( count($vo['value_items'])==0 ) : echo "" ;else: foreach($vo['value_items'] as $key=>$ao): ?>
			 				<li attr-value="<?php echo $vo['attr_value_name']; ?>" attr-value-name="<?php echo $ao; ?>" attr-value-id="<?php echo $vo['attr_value_id']; ?>"><a href="javascript:;"><?php echo $ao; ?></a></li>
			 				<?php endforeach; endif; else: echo "" ;endif; ?>
				 		</ul>
			 		</div>
			 		<div class="operation">
				 		<?php if(count($vo['value_items']) > 13): ?><a href="javascript:;" class="more-btn">更多</a><?php endif; ?>
				 	</div>
		 		</div>
			</div>
			<?php endif; endforeach; endif; else: echo "" ;endif; ?>
	<!-- end 属性筛选 end -->
	<?php endif; ?>

	<!-- start 价格筛选 start -->
	<div class="selector-line hide">
		<div class="wrap clearfix">
	 		<div class="key">价格：</div>
		 	<div class="value line price">
		 		<ul class="clearfix">
		 			<li min-price="100" max-price="500"><a href="javascript:;">100-500</a></li>
		 		</ul>
	 		</div>
	 		<div class="operation">
		 		<a href="javascript:;" class="more-btn">更多</a>
		 	</div>
 		</div>
	</div>
	<!-- end 价格筛选 end -->

</div>

<ol class="breadcrumb">
	<li><a href="<?php echo __URL('http://127.0.0.1:8080/index.php'); ?>"><?php echo lang('home_page'); ?></a></li>
	<li class="active"><?php echo $data['current_category']['category_name']; ?></li>
</ol>

<div class="w1210 clearfix product-main">
	<aside>
		<?php if(!(empty($new_goods_list) || (($new_goods_list instanceof \think\Collection || $new_goods_list instanceof \think\Paginator ) && $new_goods_list->isEmpty()))): ?>
        <h4>新品推荐</h4>
        <ul>
        	<?php if(is_array($new_goods_list) || $new_goods_list instanceof \think\Collection || $new_goods_list instanceof \think\Paginator): if( count($new_goods_list)==0 ) : echo "" ;else: foreach($new_goods_list as $key=>$vo): ?>
            <li>
                <a target="_blank" href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/detail?goods_id='.$vo['goods_id']); ?>" class="p-img">
                    <img src="<?php echo __IMG($vo['pic_cover_mid']); ?>">
                </a>
                <a target="_blank" href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/detail?goods_id='.$vo['goods_id']); ?>" class="p-name"><?php echo $vo['goods_name']; ?></a>
                <div class="p-price ns-text-color">￥<?php echo $vo['promotion_price']; ?></div>
                <div class="p-review">已有<a href="javascript:;" target="_blank"><?php echo $vo['sales']; ?></a>人购买</div>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <?php endif; if(!(empty($sales_goods_list) || (($sales_goods_list instanceof \think\Collection || $sales_goods_list instanceof \think\Paginator ) && $sales_goods_list->isEmpty()))): ?>
        <h4>销量排行</h4>
        <ul>
        	<?php if(is_array($sales_goods_list) || $sales_goods_list instanceof \think\Collection || $sales_goods_list instanceof \think\Paginator): if( count($sales_goods_list)==0 ) : echo "" ;else: foreach($sales_goods_list as $key=>$vo): ?>
            <li>
                <a target="_blank" href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/detail?goods_id='.$vo['goods_id']); ?>" class="p-img">
                    <img src="<?php echo __IMG($vo['pic_cover_mid']); ?>">
                </a>
                <a target="_blank" href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/detail?goods_id='.$vo['goods_id']); ?>" class="p-name"><?php echo $vo['goods_name']; ?></a>
                <div class="p-price ns-text-color">￥<?php echo $vo['promotion_price']; ?></div>
                <div class="p-review">已有<a href="javascript:;" target="_blank"><?php echo $vo['sales']; ?></a>人购买</div>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <?php endif; ?>
    </aside>

	<article>
		<div class="filter">
            <div class="f-line top">
                <div class="f-sort">
                    <a href="javascript:;" data-type="default" data-sort="asc" <?php if(empty($params['order']) || $params['order'] == 'default'): ?>class="curr"<?php endif; ?>>
                        <span>综合</span>
                    </a>
                    <a href="javascript:;" data-type="sales" <?php if($params['sort'] == 'asc'): ?>data-sort="desc"<?php else: ?>data-sort="asc"<?php endif; if($params['order'] == 'sales'): ?>class="curr"<?php endif; ?>>
                        <span>销量</span>
                    </a>
                    <a href="javascript:;" data-type="price" <?php if($params['sort'] == 'asc'): ?>data-sort="desc"<?php else: ?>data-sort="asc"<?php endif; if($params['order'] == 'price'): ?>class="curr"<?php endif; ?>>
                        <span>价格</span>
                    </a>
                    <a href="javascript:;" data-type="is_new" <?php if($params['sort'] == 'asc'): ?>data-sort="desc"<?php else: ?>data-sort="asc"<?php endif; if($params['order'] == 'is_new'): ?>class="curr"<?php endif; ?>>
                        <span>新品</span>
                    </a>
                </div>

				<div class="f-price">
					<div class="price-form">
						<input type="text" class="form-control" placeholder="￥" onkeyup="this.value = positiveInteger(this.value)" onchange="this.value = positiveInteger(this.value)">
						<span>-</span>
						<input type="text" class="form-control" placeholder="￥" onkeyup="this.value = positiveInteger(this.value)" onchange="this.value = positiveInteger(this.value)">
					</div>
					<div class="price-operation clearfix">
						<a href="javascript:;" class="pull-left empty">清空</a>
						<a href="javascript:;" class="btn pull-right confirm">确定</a>
					</div>
				</div>

            </div>
            <div class="f-line address">
                <!--<div class="f-store">-->
                    <!--<div class="delivery-location">配送至</div>-->
                    <!--<div class="area">-->
                        <!--<div class="curr-area-text"><span>山西晋中市榆次区张庆乡</span><i class="icon icon-angle-down"></i></div>-->
                        <!--<div class="area-content-wrap">-->
                            <!--<div class="area-tab">-->
                                <!--<a title="山西" class="area-title province-title curr">请选择</a>-->
                                <!--<a title="晋中市" class="area-title dis-no"><span>晋中市</span><i class="icon icon-angle-down"></i></a>-->
                                <!--<a title="榆次区" class="area-title dis-no"><span>榆次区</span><i class="icon icon-angle-down"></i></a>-->
                                <!--<a class="area-title dis-no" title="张庆乡"><span>张庆乡</span><i class="icon icon-angle-down"></i></a>-->
                            <!--</div>-->
                            <!--<div>-->
                                <!--<ul class="area-list province"><li><a href="javascript:checkArea('this',1, 110000, '北京市');">北京市</a></li><li></ul>-->
                                <!--<ul class="area-list city dis-no"><li class="curr"><a href="javascript:void(0)">太原市</a></li></ul>-->
	                            <!--<ul class="area-list district dis-no"><li class="curr"><a href="javascript:void(0)">榆次区</a></li></ul>-->
                                <!--<ul class="area-list dis-no"><li class="curr"><a href="javascript:void(0)">张庆乡</a></li></ul>-->
                            <!--</div>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
                <div class="f-feature">
                    <ul>
                        <li>
                            <a href="javascript:;" data-type="jxsyh" <?php if($params['jxsyh'] == 1): ?>class="selected ns-text-color" data-status="0"<?php else: ?>data-status="1"<?php endif; ?>>
                                <i></i>
                                <span>仅显示有货</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" data-type="fee" <?php if($params['fee'] == 1): ?>class="selected ns-text-color" data-status="0"<?php else: ?>data-status="1"<?php endif; ?>>
                                <i></i>
                                <span>仅显示包邮</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="f-search dis-no">
                    <input type="text" class="form-control" placeholder="在结果中搜索">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">确定</button>
                    </span>
                </div>
            </div>
        </div>

		<div class="product-list">
		    <ul class="clearfix">
		    	<?php if(is_array($goods_list['data']) || $goods_list['data'] instanceof \think\Collection || $goods_list['data'] instanceof \think\Paginator): if( count($goods_list['data'])==0 ) : echo "" ;else: foreach($goods_list['data'] as $key=>$vo): ?>
		        <li data-index="0">
		            <div class="p-img" data-index="0">
		                <a target="_blank" href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/detail?goods_id='.$vo['goods_id']); ?>">
		                    <img src="<?php echo __IMG($vo['pic_cover_mid']); ?>">
	                    </a>
		            </div>
		            <div class="p-scroll">
		                <span class="ps-prev disabled" data-operation="prev" data-index="0">
		                    <i class="icon icon-caret-left"></i>
		                </span>
		                <span class="ps-next" data-operation="next" data-index="0">
		                    <i class="icon icon-caret-right"></i>
		                </span>
		                <div class="ps-wrap">
		                    <ul class="ps-main">
	                    	 	<li class="ps-item curr" data-index="0" data-max-src="<?php echo __IMG($vo['pic_cover_mid']); ?>">
		                            <img src="<?php echo __IMG($vo['pic_cover_small']); ?>">
		                        </li>
		                    </ul>
		                </div>
		            </div>
		            <div class="p-price ns-text-color">
		                <i><?php echo $vo['display_price']; ?></i>
		            </div>
		            <div class="p-name">
		                <a target="_blank" href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/detail?goods_id='.$vo['goods_id']); ?>"><?php echo $vo['goods_name']; ?></a></div>
		            <div class="p-commit">
		            	已有<a target="_blank" href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/detail?goods_id='.$vo['goods_id']); ?>"><?php echo $vo['sales']; ?></a>人购买
		            </div>
		            <div class="p-icons">
		            	<?php if($vo['is_hot']): ?> <i class="icons icons-hot">热卖</i> <?php endif; if($vo['is_new']): ?> <i class="icons icons-new">新品</i> <?php endif; if($vo['is_recommend']): ?> <i class="icons icons-recommend">精品</i> <?php endif; ?>
		            </div>
		        </li>
				<?php endforeach; endif; else: echo "" ;endif; ?>
	        </ul>
        </div>

        <!-- 分页 -->
		<ul class="pager" data-ride="pager" data-elements="prev,nav,next,total_page_text,goto" data-rec-per-page="<?php echo $page_size; ?>" data-page="<?php echo $params['page_index']; ?>" data-rec-total="<?php echo $total_count; ?>" id="myPager"></ul>
	</article>
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

<script>
	<?php if(!(empty($params) || (($params instanceof \think\Collection || $params instanceof \think\Paginator ) && $params->isEmpty()))): ?>var Params = '<?php echo json_encode($params); ?>';<?php else: ?> var Params = '';<?php endif; ?>
	var oldParams = {};
	if(Params != '') oldParams = JSON.parse(Params);
</script>
<script src="/template/web/default/public/js/goods_list.js"></script>
<script>
$('#myPager').pager({
	linkCreator: function(page, pager) {
		return urlBindParams(paramsUnique({page_index : page}, oldParams));
	}
});
</script>

</body>
</html>