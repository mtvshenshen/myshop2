<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:40:"template/wap\default\goods\category.html";i:1554082366;s:54:"D:\phpStudy\WWW\niushop\template\wap\default\base.html";i:1553848818;}*/ ?>
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
	
<link rel="stylesheet" href="/template/wap/default/public/css/goods_category.css">

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
$goods_category_list = api('System.Goods.goodsCategoryList');
$goods_category_list = $goods_category_list['data'];
// 模板类型
$category_template = $show_type['template'];
// 模板样式
$category_style = $show_type['style'];
// 分类图显示
$category_is_img = $show_type['is_img'];
// Class 样式
$more_list_class = $category_template == 3 ? 'more-list' : '';
$none_img_class = $category_is_img == 0 ? 'none-img' : '';
 if(!(empty($goods_category_list) || (($goods_category_list instanceof \think\Collection || $goods_category_list instanceof \think\Paginator ) && $goods_category_list->isEmpty()))): ?>
<div class="goods-category-list">

    <!--------- 一级分类 --------->
    <ul class="first-level">
        <?php if(is_array($goods_category_list) || $goods_category_list instanceof \think\Collection || $goods_category_list instanceof \think\Paginator): if( count($goods_category_list)==0 ) : echo "" ;else: foreach($goods_category_list as $index=>$vo): ?>
        <li class="first-item">
            <div class="first-caetgroy-name <?php if($index == 0): ?>active<?php endif; ?>" data-id="<?php echo $vo['category_id']; ?>" onclick="chooseCategory(this)">
                <label><?php echo $vo['category_name']; ?></label>
            </div>

            <!--------- 二级分类 --------->
            <?php if($category_template > 1): ?>
            <ul class="second-level <?php if($index != 0): ?>hidden<?php endif; ?> category-box-<?php echo $vo['category_id']; ?>">
                <?php if(!(empty($vo['child_list']) || (($vo['child_list'] instanceof \think\Collection || $vo['child_list'] instanceof \think\Paginator ) && $vo['child_list']->isEmpty()))): if(is_array($vo['child_list']) || $vo['child_list'] instanceof \think\Collection || $vo['child_list'] instanceof \think\Paginator): if( count($vo['child_list'])==0 ) : echo "" ;else: foreach($vo['child_list'] as $key=>$vo1): ?>
                <li class="<?php echo $more_list_class; ?> <?php echo $none_img_class; ?>">
                    <?php if($category_template == 2): if($category_is_img == 1): ?>
                    <div class="img-common" onclick="moreGoodsList(<?php echo $vo1['category_id']; ?>)">
                        <!--<img class="lazy-load" src="<?php echo __IMG($default_goods_img); ?>" data-original="<?php echo __IMG($vo1['category_pic']); ?>">--> <!-- 懒加载 -->
                        <img class="lazy-load" src="<?php echo __IMG($vo1['category_pic']); ?>" >
                    </div>
                    <?php endif; ?>
                    <span class="category-name" onclick="moreGoodsList(<?php echo $vo1['category_id']; ?>)"><?php echo $vo1['category_name']; ?></span>
                    <?php endif; ?>

                    <!--------- 三级分类 --------->
                    <?php if($category_template == 3): ?>
                    <div class="category-title" onclick="moreGoodsList(<?php echo $vo1['category_id']; ?>)">
                        <label><?php echo $vo1['category_name']; ?></label>
                    </div>

                    <ul class="third-level">
                        <?php if(!(empty($vo1['child_list']) || (($vo1['child_list'] instanceof \think\Collection || $vo1['child_list'] instanceof \think\Paginator ) && $vo1['child_list']->isEmpty()))): if(is_array($vo1['child_list']) || $vo1['child_list'] instanceof \think\Collection || $vo1['child_list'] instanceof \think\Paginator): if( count($vo1['child_list'])==0 ) : echo "" ;else: foreach($vo1['child_list'] as $key=>$vo2): ?>
                        <li  onclick="moreGoodsList(<?php echo $vo2['category_id']; ?>)">
                            <?php if($category_is_img == 1): ?>
                            <div class="img-common">
                                <!--<img class="lazy-load" src="<?php echo __IMG($default_goods_img); ?>" data-original="<?php echo __IMG($vo2['category_pic']); ?>">--> <!-- 懒加载 -->
                                <img class="lazy-load" src="<?php echo __IMG($vo2['category_pic']); ?>">
                            </div>
                            <?php endif; ?>
                            <span class="category-name"><?php echo $vo2['category_name']; ?></span>
                        </li>
                        <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                    </ul>
                    <?php endif; ?>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; else: ?>
                <div class='empty-category child'>
                	<img src='/template/wap/default/public/img/goods/empty.png'/><br/>
                	该分类下无子分类
                </div>
                <?php endif; ?>
            </ul>
            <?php endif; ?>
        </li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
    <div class="mask-layer"></div>
    <!-- 分类商品列表 -->
    <div class='goods-list' id="goods_list">

    </div>
    <!-- 总页数 -->
    <input type="hidden" id="page_count">
    <!-- 当前页数 -->
    <input type="hidden" id="page" value="1">

</div>
<?php else: ?>
<div class='empty-category'>
	<img src='/template/wap/default/public/img/goods/empty.png'/><br/>
	暂无商品分类
</div>
<?php endif; ?>

<script>
    var is_load = true;
    var template_type = <?php echo $category_template; ?>;
    $(function () {
        if (template_type == 1) {
            loadGoodsList(1);
        }
        // 商品列表分页加载
        $('#goods_list').scroll(function () {
            if ($('#goods_list .goods-item').length != undefined && $('#goods_list .goods-item').length > 3 && is_load) {
                var length = $('#goods_list .goods-item').length;
                var obj = $($('#goods_list .goods-item')[length - 1]);
                var scroll_top = obj.offset().top;
                var scrollHeight = $(document).height() - 95;
                var obj_height = obj.height();
                if (scroll_top <= scrollHeight - obj_height / 2) {
                    var page = parseInt($("#page").val()) + 1;//页数
                    var total_page_count = $("#page_count").val(); // 总页数

                    if (page > total_page_count) {
                        return false;
                    } else {
                        loadGoodsList(page);
                    }
                }
            }
        })
    })

    /**
     * 错误图片处理
     * @param obj
     */
    function imgError(obj) {
        if (obj.src != "<?php echo __IMG($default_goods_img); ?>") {
            obj.src = "<?php echo __IMG($default_goods_img); ?>";
        } else {
            $(obj).attr('onerror', '');
        }
    }

    /**
     * 选择一级分类
     * @param id
     * @param get_goods_flag
     */
    function chooseCategory(obj) {
        var id = $('.first-level .first-caetgroy-name.active').attr('data-id');
        var obj_id = $(obj).attr('data-id');

        // 已选中该分类不触发选中效果
        if (id != obj_id) {
            if ($(obj).hasClass('first-caetgroy-name')) {
                $('.first-caetgroy-name').not(obj).removeClass('active');
            } else {
                $('.category-name').not(obj).removeClass('active');
            }
            $(obj).addClass('active');
            // 判断模板类型
            if (template_type == 1) {
                // 加载商品列表
                is_load = true;
                $('#goods_list').html('');
                // $('#goods_list')[0].scrollTop = 0;
                loadGoodsList(1);
            } else {
                // 加载分类列表
                $('.mask-layer').show();
                $('.category-box-' + obj_id).removeClass('hidden');
                $('.second-level').not('.category-box-' + obj_id).addClass('hidden');
            }
        }
    }

    /**
     * 加载一级分类商品列表
     * @param page
     */
    function loadGoodsList(page) {
        // 当前页未加载完毕，不允许加载下一页
        if (is_load) {
            is_load = false;
            // 当前选中分类ID
            var id = $('.first-level .first-caetgroy-name.active').attr('data-id');
            if (id == undefined || id == null || id == '') {
            	return false;
            }
            // 请求商品列表接口
            api("System.Goods.goodsList", {'page_index': page, 'condition': {'ng.category_id': id}}, function (res) {
                var data = res.data;

                $("#page_count").val(data['page_count']);
                $("#page").val(page);
                var list_html = "";
                if (page > 1) {
                    // 不是第一页进行分页加载
                    list_html = $('#goods_list').html();
                }
                if (data['data'].length > 0) {
                    for (var i = 0; i < data['data'].length; i++) {
                        var item = data['data'][i];
                        list_html += '<a href="' + __URL(APPMAIN + '/goods/detail?goods_id=' + item['goods_id']) + '" class="goods-item">';
                        list_html += '<div class="img-common goods-img">';
                        list_html += '<img src="' + item.pic_cover_small + '"/>';
                        list_html += '</div>';
                        list_html += '<div class="goods-info">';
                        list_html += '<span class="goods-name">' + item.goods_name + '</span>';
                        list_html += '<span class="price">￥' + item.promotion_price + '</span>';
                        list_html += '</div>';
                        list_html += '</a>';
                    }
                } else {
                    list_html += '<p class="no-coupon"><img src="' + WAPIMG + '/wap_nodata.png" height="100"><br>Sorry！没有找到您想要的商品……</p>';
                }
                is_load = true;
                $('#goods_list').html(list_html);
            });
        }
    }

    /**
     * 跳转商品列表页
     * @param id
     */
    function moreGoodsList(id) {
        location.href = __URL(APPMAIN + '/goods/lists?category_id=' + id);
    }

</script>


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

</body>
</html>