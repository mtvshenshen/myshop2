<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:41:".\template\web\default\block\style_1.html";i:1553832838;}*/ ?>
<style>
    .floor{
        margin-top: 20px;
        width: 1200px;
        height: 665px;
        position: relative;
    }
    .floor .color-mark {
        display: inline-block;
        background-color: #333;
        width: 5px;
        height: 18px;
        vertical-align: middle;
    }
    .floor-name {
        display: inline-block;
        vertical-align: middle;
        font-size: 18px;
        color: #000;
        height: 28px;
    }
    .floor-name .floor-title {
        margin-left: 10px;
        margin-right: 10px;
        vertical-align: middle;
    }
    .floor-sub-name {
        display: inline-block;
        font-size: 14px;
        color: #000;
        margin-left: 10px;
        line-height: 24px;
        height: 18px;
    }
    .line-body {
        width: 100%;
        height: 618px;
        margin-top: 10px;
        overflow: hidden;
    }
    .line-body .hot-word-con {
        position: absolute;
        top: 0;
        right: 0;
        width: 800px;
        text-align: right;
    }
    .line-body .hot-word {
        display: inline-block;
        height: 20px;
        line-height: 20px;
        margin: 5px 10px;
        font-size: 14px;
        border: none;
        border-bottom: 1px solid #f5f5f5;
        color:#000;
    }
    .line-body .hot-word:hover {
        border-bottom: 1px solid #000;
        color:#000 !important;
    }
    .line-body .big-banner-con-2 {
        float: left;
        position: relative;
        width: 235px;
        height: 618px;
    }
    .line-body .big-banner-con-2 a{
        display: block;
        position: relative;
    }
    .line-body .big-banner-con-2 img,.line-body .big-banner-con-2 .img-skeleton-screen {
        display: block;
        width: 100%;
        height: 618px;
        -webkit-transition: opacity .3s ease-out;
        -moz-transition: opacity .3s ease-out;
        -o-transition: opacity .3s ease-out;
        transition: opacity .3s ease-out;
    }

    .line-body .big-banner-con-2:hover img {
        opacity: .7;
        filter: alpha(opacity=70);
    }

    .line-body .banner-detail {
        position: absolute;
        vertical-align: middle;
        bottom: 20%;
        width: 218px;
        height: 64px;
    }

    .line-body .banner-detail .left-title-wrap {
        background: rgba(0,0,0,.9);
        width: 70px;
        height: 64px;
        overflow: hidden;
        color: #FFF;
        text-align: center;
        display: table-cell;
        vertical-align: middle;
    }
    .line-body .banner-detail .left-title-wrap .left-title {
        display: inline-block;
        vertical-align: middle;
        line-height: 24px;
        font-size: 18px;
        width: 36px;
        overflow: hidden;
    }
    .line-body .banner-detail .right-title-wrap {
        left: 70px;
        top: 0;
        position: absolute;
        background: rgba(0,0,0,.6);
        overflow: hidden;
        width: 128px;
        height: 64px;
        color: #FFF;
        vertical-align: middle;
    }
    .line-body .banner-detail .right-title-wrap .right-title-absolute {
        margin-top: 8px;
        margin-left: 14px;
    }
    .line-body .banner-detail .right-title-wrap .right-title-absolute .right-title {
        display: block;
        line-height: 24px;
        font-size: 18px;
    }
    .line-body .detail-wrap {
        background-image: linear-gradient(-180deg,rgba(0,0,0,0) 4%,rgba(0,0,0,.36) 100%);
        width: 100%;
        height: 60px;
        position: absolute;
        bottom: 0;
        left: 0;
    }
    .line-body .detail-wrap .floor-arrow-big {
        position: absolute;
        bottom: 15px;
        right: 15px;
        width: 32px;
        height: 32px;
    }

    .line-body .middle-column-con {
        /*width: 964px;*/
        height: 618px;
        /*float: left;*/
        overflow: hidden;
        margin-left: 245px;
    }
    .line-body .grid.one-grid-price {
        width: 230px;
        height: 295px;
        margin-left: 9px;
        margin-top: 10px;
        text-align: center;
    }
    .line-body .grid.one-grid-price:nth-child(4n+1){
        margin-left: 0;
    }
    .line-body .grid {
        float: left;
        display: block;
        position: relative;
        background-color: unset;
    }
    .line-body .grid:hover .floor-item-content-wrap.border {
        border: 1px solid #FF0036;
    }
    .line-body .floor-item-content-wrap {
        width: 228px;
        padding-top: 20px;
        border: 1px solid unset;
    }
    .line-body .grid.one-grid-price img,.line-body .grid.one-grid-price .floor-item-img {
        width: 185px;
        height: 185px;
        margin: 0 auto;
    }
    .line-body .grid img {
        z-index: 1;
        -o-transition: right .3s;
        -moz-transition: right .3s;
        -webkit-transition: right .3s;
        -ms-transition: right .3s;
        transition: right .3s;
    }
    
    .skeleton-screen{
        background-color: #f0f3ef !important;
    }
    .floor-item-title {
        width: 185px;
        height: 40px;
        font-size: 14px;
        color: #333;
        line-height: 20px;
        overflow: hidden;
        margin: 8px auto;
    }
    .floor-price {
        font-size: 18px;
        color: #FF0036;
        line-height: 18px;
        height: 18px;
        margin: 10px auto;
        width: 185px;
    }
</style>
<div class="floor floor-item">
    <i class="color-mark"></i>
    <div class="floor-name" data-block-type="text" data-block-name="left_title">
        <div class="floor-title">
            <span floor-block-name="text"><?php if($data['text']['left_title']['value']): ?><?php echo $data['text']['left_title']['value']; else: ?>户外出行<?php endif; ?></span>
            <div class="floor-sub-name"></div>
        </div>
    </div>
    <div class="line-body">
        <div class="hot-word-con" data-block-type="product_category" data-block-name="top_category">
            <?php if($data['product_category']['top_category']): if(is_array($data['product_category']['top_category']) || $data['product_category']['top_category'] instanceof \think\Collection || $data['product_category']['top_category'] instanceof \think\Paginator): if( count($data['product_category']['top_category'])==0 ) : echo "" ;else: foreach($data['product_category']['top_category'] as $key=>$vo): ?>
            <a class="hot-word" target="_blank" href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/lists?category_id='.$vo['category_id']); ?>"><?php echo $vo['category_name']; ?></a>
            <?php endforeach; endif; else: echo "" ;endif; else: ?>
            <!--<a class="hot-word" target="_blank" href="javascript:;">商品分类</a>-->
            <?php endif; ?>
        </div>
        
        <div class="floor-main">
            <div class="big-banner-con-2">
                
                <a data-block-type="adv" data-block-name="left_adv" target="_blank" href="<?php if($data['adv']['left_adv']['link']!=''): ?><?php echo __URL($data['adv']['left_adv']['link']); else: ?>javascript:;<?php endif; ?>">
                
                    <?php if($data['adv']['left_adv']['img_src'] != ''): ?>
                        <img src="<?php echo __img($data['adv']['left_adv']['img_src']); ?>">
                    <?php else: ?>
                        <div class="img-skeleton-screen skeleton-screen"></div>
                    <?php endif; ?>
                
                    <div class="banner-detail">
                        <div class="left-title-wrap" data-block-type="text" data-block-name="sub_title">
                            <span class="left-title"><?php if($data['text']['sub_title']['value']): ?><?php echo $data['text']['sub_title']['value']; else: ?>运动户外<?php endif; ?></span>
                        </div>
                        <div class="right-title-wrap">
                            <div class="right-title-absolute">
                                <span class="right-title" data-block-type="text" data-block-name="jieri"><?php if($data['text']['jieri']['value']): ?><?php echo $data['text']['jieri']['value']; else: ?>双11狂欢<?php endif; ?></span>
                                <span class="right-title" data-block-type="text" data-block-name="jianquan"><?php if($data['text']['jianquan']['value']): ?><?php echo $data['text']['jianquan']['value']; else: ?>领券立减<?php endif; ?></span>
                            </div>
                        </div>
                    </div>
                
 
                </a>

            </div>

            <div class="middle-column-con" data-block-type="product" data-block-name="middle">
                <?php if($data['product']['middle']): if(is_array($data['product']['middle']) || $data['product']['middle'] instanceof \think\Collection || $data['product']['middle'] instanceof \think\Paginator): if( count($data['product']['middle'])==0 ) : echo "" ;else: foreach($data['product']['middle'] as $key=>$product): ?>
                <a class="grid one-grid-price" href="<?php echo __URL('http://127.0.0.1:8080/index.php/goods/detail?goods_id='.$product['goods_id']); ?>" target="_blank">
                    <div class="floor-item-content-wrap border">
                        <?php if($product['pic_cover_small'] != ''): ?>
                        <img class="floor-item-img" src="<?php echo __img($product['pic_cover_small']); ?>">
                        <?php else: ?>
                        <img class="floor-item-img" src="/template/web/default/public/img/discount_product_default.png">
                        <?php endif; ?>
                        <div class="floor-item-title"><?php echo $product['goods_name']; ?></div>
                        <div class="floor-price">￥<?php echo $product['price']; ?></div>
                    </div>
                </a>
                <?php endforeach; endif; else: echo "" ;endif; else: for($i=0;$i<8;$i++){  ?>
                <a class="grid one-grid-price" href="javascript:;">
                    <div class="floor-item-content-wrap">
                        <div class="floor-item-img skeleton-screen"></div>
                        <div class="floor-item-title skeleton-screen"></div>
                        <div class="floor-price skeleton-screen"></div>
                    </div>
                </a>
                <?php  };  endif; ?>

            </div>

        </div>

    </div>
</div>