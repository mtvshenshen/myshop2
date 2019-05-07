/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : niushop_b2c

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-04-26 13:13:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `nc_cms_article`
-- ----------------------------
DROP TABLE IF EXISTS `nc_cms_article`;
CREATE TABLE `nc_cms_article` (
  `article_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章编号',
  `title` varchar(255) NOT NULL COMMENT '文章标题',
  `class_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文章分类编号',
  `short_title` varchar(50) NOT NULL DEFAULT '' COMMENT '文章短标题',
  `source` varchar(50) NOT NULL DEFAULT '' COMMENT '文章来源',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '文章来源链接',
  `author` varchar(50) NOT NULL COMMENT '文章作者',
  `summary` varchar(140) NOT NULL DEFAULT '' COMMENT '文章摘要',
  `content` text NOT NULL COMMENT '文章正文',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '文章标题图片',
  `keyword` varchar(255) NOT NULL DEFAULT '' COMMENT '文章关键字',
  `article_id_array` varchar(255) NOT NULL DEFAULT '' COMMENT '相关文章',
  `click` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文章点击量',
  `sort` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '文章排序0-255',
  `commend_flag` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '文章推荐标志0-未推荐，1-已推荐',
  `comment_flag` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '文章是否允许评论1-允许，0-不允许',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '0-草稿、1-待审核、2-已发布、-1-回收站',
  `attachment_path` text NOT NULL COMMENT '文章附件路径',
  `tag` varchar(255) NOT NULL DEFAULT '' COMMENT '文章标签',
  `comment_count` int(10) unsigned NOT NULL COMMENT '文章评论数',
  `share_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文章分享数',
  `publisher_name` varchar(50) NOT NULL COMMENT '发布者用户名 ',
  `uid` int(10) unsigned NOT NULL COMMENT '发布者编号',
  `last_comment_time` int(11) DEFAULT '0' COMMENT '最新评论时间',
  `public_time` int(11) DEFAULT '0' COMMENT '发布时间',
  `create_time` int(11) DEFAULT '0' COMMENT '文章发布时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '文章修改时间',
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1 COMMENT='CMS文章表';

-- ----------------------------
-- Records of nc_cms_article
-- ----------------------------

-- ----------------------------
-- Table structure for `nc_cms_article_class`
-- ----------------------------
DROP TABLE IF EXISTS `nc_cms_article_class`;
CREATE TABLE `nc_cms_article_class` (
  `class_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类编号 ',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级分类',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1 COMMENT='cms文章分类表';

-- ----------------------------
-- Records of nc_cms_article_class
-- ----------------------------

-- ----------------------------
-- Table structure for `nc_cms_comment`
-- ----------------------------
DROP TABLE IF EXISTS `nc_cms_comment`;
CREATE TABLE `nc_cms_comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论编号',
  `text` varchar(2000) NOT NULL COMMENT '评论内容',
  `uid` int(10) unsigned NOT NULL COMMENT '评论人编号',
  `quote_comment_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论引用',
  `up` int(10) unsigned NOT NULL COMMENT '点赞数量',
  `comment_time` int(10) unsigned NOT NULL COMMENT '评论时间',
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1 COMMENT='CMS评论表';

-- ----------------------------
-- Records of nc_cms_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `nc_cms_topic`
-- ----------------------------
DROP TABLE IF EXISTS `nc_cms_topic`;
CREATE TABLE `nc_cms_topic` (
  `topic_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '专题编号',
  `instance_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `title` varchar(255) NOT NULL COMMENT '专题标题',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '专题封面',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '专题状态  0草稿  1发布',
  `content` text NOT NULL COMMENT '专题内容',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1 COMMENT='专题';

-- ----------------------------
-- Records of nc_cms_topic
-- ----------------------------

-- ----------------------------
-- Table structure for `nfx_commission_distribution`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_commission_distribution`;
CREATE TABLE `nfx_commission_distribution` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `serial_no` varchar(50) NOT NULL DEFAULT '' COMMENT '流水号',
  `shop_id` int(11) NOT NULL COMMENT '对应的店铺ID',
  `promoter_id` int(11) NOT NULL COMMENT '对应的推广员ID',
  `order_id` int(11) NOT NULL COMMENT '对应的订单ID',
  `order_goods_id` int(11) NOT NULL COMMENT '对应的订单项ID',
  `goods_money` decimal(10,2) NOT NULL COMMENT '订单项商品总金额实际卖价',
  `goods_cost` decimal(10,2) NOT NULL COMMENT '订单项商品总成本',
  `goods_return` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品利润',
  `promoter_level` int(11) NOT NULL COMMENT '对应推广员级次0本店1下级创造2下下级创造',
  `goods_commission_rate` decimal(10,2) NOT NULL COMMENT '商品对应拿出的利润比率',
  `commission_rate` decimal(10,2) NOT NULL COMMENT '获取的佣金比率',
  `commission_money` decimal(10,4) NOT NULL COMMENT '获取的佣金金额',
  `is_issue` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已经发放  0 未发放 1已发放',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1 COMMENT='推广员分销佣金';

-- ----------------------------
-- Records of nfx_commission_distribution
-- ----------------------------

-- ----------------------------
-- Table structure for `nfx_commission_partner`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_commission_partner`;
CREATE TABLE `nfx_commission_partner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `serial_no` varchar(50) NOT NULL DEFAULT '' COMMENT '流水号',
  `shop_id` int(11) NOT NULL COMMENT '对应的店铺ID',
  `partner_id` int(11) NOT NULL COMMENT '对应的股东ID',
  `partner_level` int(11) NOT NULL DEFAULT '0' COMMENT '获取佣金的股东等级',
  `order_partner_id` int(11) NOT NULL DEFAULT '0' COMMENT '产生订单的股东',
  `order_id` int(11) NOT NULL COMMENT '对应的订单ID',
  `order_goods_id` int(11) NOT NULL COMMENT '对应的订单项ID',
  `goods_return` decimal(10,4) NOT NULL COMMENT '商品利润',
  `goods_money` decimal(10,2) NOT NULL COMMENT '订单项商品总金额实际卖价',
  `goods_cost` decimal(10,2) NOT NULL COMMENT '订单项商品总成本',
  `goods_commission_rate` decimal(10,2) NOT NULL COMMENT '商品利润分成总比率',
  `commission_rate` decimal(10,2) NOT NULL COMMENT '获取的佣金比率',
  `commission_money` decimal(10,4) NOT NULL COMMENT '获取的佣金金额',
  `is_issue` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已经发放  0未发放 1已发放',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1 COMMENT='股东分红佣金';

-- ----------------------------
-- Records of nfx_commission_partner
-- ----------------------------

-- ----------------------------
-- Table structure for `nfx_commission_partner_global`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_commission_partner_global`;
CREATE TABLE `nfx_commission_partner_global` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `serial_no` varchar(255) NOT NULL DEFAULT '' COMMENT '单据编号',
  `records_id` int(11) NOT NULL DEFAULT '0' COMMENT '记录id',
  `shop_id` int(11) NOT NULL COMMENT '店铺ID',
  `partner_id` int(11) NOT NULL COMMENT '股东ID',
  `uid` int(11) NOT NULL COMMENT '股东会员ID',
  `yingye_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '时间段内分红的店铺总额',
  `shop_value` int(11) NOT NULL DEFAULT '0' COMMENT '店铺总分值',
  `partner_value` int(11) NOT NULL DEFAULT '0' COMMENT '股东分值',
  `partner_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '股东分红佣金比率(分值比率)',
  `fenhong_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分红金额',
  `start_time` int(11) DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) DEFAULT '0' COMMENT '结束时间',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1 COMMENT='全球分红佣金记录表';

-- ----------------------------
-- Records of nfx_commission_partner_global
-- ----------------------------

-- ----------------------------
-- Table structure for `nfx_commission_partner_global_records`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_commission_partner_global_records`;
CREATE TABLE `nfx_commission_partner_global_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(11) NOT NULL COMMENT '店铺ID',
  `fenhong_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分红总金额',
  `start_time` int(11) DEFAULT '0' COMMENT '分红开始时间',
  `end_time` int(11) DEFAULT '0' COMMENT '分红结束时间',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1 COMMENT='股东分红整体记录表';

-- ----------------------------
-- Records of nfx_commission_partner_global_records
-- ----------------------------

-- ----------------------------
-- Table structure for `nfx_commission_region_agent`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_commission_region_agent`;
CREATE TABLE `nfx_commission_region_agent` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '表主键',
  `shop_id` int(11) NOT NULL COMMENT '店铺id',
  `serial_no` varchar(50) NOT NULL DEFAULT '' COMMENT '流水号',
  `region_agent_id` int(11) NOT NULL COMMENT '区域代理ID',
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `promoter_id` int(11) NOT NULL COMMENT '推广员id',
  `order_id` int(11) NOT NULL COMMENT '对应的订单ID',
  `order_goods_id` int(11) NOT NULL COMMENT '对应的订单项ID',
  `goods_money` decimal(10,2) NOT NULL COMMENT '订单项商品总金额实际卖价',
  `goods_cost` decimal(10,2) NOT NULL COMMENT '订单项商品总成本',
  `goods_return` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品利润',
  `goods_commission_rate` decimal(10,2) DEFAULT '0.00' COMMENT '商品利润分成总比率',
  `commission_type` int(11) NOT NULL DEFAULT '0' COMMENT '代理级别1.省级2.市级3.区级',
  `commission_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '佣金比率',
  `commission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际佣金金额',
  `is_issue` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否发放  0未发放  1已发放',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1 COMMENT='区域代理佣金列表';

-- ----------------------------
-- Records of nfx_commission_region_agent
-- ----------------------------

-- ----------------------------
-- Table structure for `nfx_goods_commission_rate`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_goods_commission_rate`;
CREATE TABLE `nfx_goods_commission_rate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL COMMENT '商品ID',
  `is_open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用分销',
  `distribution_commission_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销佣金比率',
  `partner_commission_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '股东分红佣金比率',
  `global_commission_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '股东全球分红比率',
  `distribution_team_commission_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销团队分红佣金比率',
  `partner_team_commission_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '股东团队分红佣金比率',
  `regionagent_commission_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '区域代理分红佣金比率',
  `channelagent_commission_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '渠道代理分红佣金比率',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=136 COMMENT='商品佣金比率设置';

-- ----------------------------
-- Records of nfx_goods_commission_rate
-- ----------------------------

-- ----------------------------
-- Table structure for `nfx_partner`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_partner`;
CREATE TABLE `nfx_partner` (
  `partner_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '股东ID',
  `promoter_id` int(11) NOT NULL DEFAULT '0' COMMENT '推广员ID',
  `parent_partner` int(11) NOT NULL COMMENT '上级股东',
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `shop_id` int(11) NOT NULL COMMENT '店铺ID',
  `partner_level` int(11) NOT NULL COMMENT '股东等级',
  `is_audit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否审核通过',
  `is_lock` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否被冻结',
  `register_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  `audit_time` int(11) DEFAULT '0' COMMENT '审核通过时间',
  `lock_time` int(11) DEFAULT '0' COMMENT '冻结时间',
  PRIMARY KEY (`partner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2340 COMMENT='股东表';

-- ----------------------------
-- Records of nfx_partner
-- ----------------------------

-- ----------------------------
-- Table structure for `nfx_partner_level`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_partner_level`;
CREATE TABLE `nfx_partner_level` (
  `level_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '等级ID',
  `level_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '等级条件（团队销售额）',
  `level_name` varchar(50) NOT NULL DEFAULT '' COMMENT '等级名称',
  `commission_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '股东分红佣金比率',
  `global_value` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '全球分红分值',
  `global_weight` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '全球分红权重',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='股东等级';

-- ----------------------------
-- Records of nfx_partner_level
-- ----------------------------

-- ----------------------------
-- Table structure for `nfx_promoter`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_promoter`;
CREATE TABLE `nfx_promoter` (
  `promoter_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '推广员ID',
  `promoter_no` varchar(50) NOT NULL DEFAULT '' COMMENT '推广员编号',
  `parent_promoter` int(11) NOT NULL DEFAULT '0' COMMENT '上级推广员id',
  `uid` int(11) NOT NULL COMMENT '推广员对应会员ID',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `promoter_level` int(11) NOT NULL DEFAULT '0' COMMENT '推广员等级',
  `promoter_shop_name` varchar(255) NOT NULL DEFAULT '' COMMENT '推广员店铺名称',
  `commission_cash` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '已提现佣金',
  `commossion_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '佣金总额',
  `order_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '销售总额',
  `is_lock` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否被冻结',
  `is_audit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已审核',
  `qrcode` varchar(255) NOT NULL DEFAULT '' COMMENT '推广二维码',
  `memo` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `lock_time` int(11) DEFAULT '0' COMMENT '冻结时间',
  `audit_time` int(11) DEFAULT '0' COMMENT '审核通过时间',
  `regidter_time` int(11) DEFAULT '0' COMMENT '申请时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  `background_img` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺背景图',
  PRIMARY KEY (`promoter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1260 COMMENT='推广员表';

-- ----------------------------
-- Records of nfx_promoter
-- ----------------------------

-- ----------------------------
-- Table structure for `nfx_promoter_goods`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_promoter_goods`;
CREATE TABLE `nfx_promoter_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `promoter_id` int(11) NOT NULL DEFAULT '0' COMMENT '推广员id',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=348 COMMENT='推广员商品';

-- ----------------------------
-- Records of nfx_promoter_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `nfx_promoter_level`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_promoter_level`;
CREATE TABLE `nfx_promoter_level` (
  `level_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '等级ID',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `level_name` varchar(50) NOT NULL DEFAULT '' COMMENT '等级名称',
  `level_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '等级升级条件（销售额）',
  `level_0` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '本店销售佣金比率',
  `level_1` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '给上级的佣金比率',
  `level_2` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '给上上级的佣金比率',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4096 COMMENT='推广员等级';

-- ----------------------------
-- Records of nfx_promoter_level
-- ----------------------------
INSERT INTO `nfx_promoter_level` VALUES ('1', '0', '普通分销商', '0.00', '100.00', '0.00', '0.00', '0', '0');

-- ----------------------------
-- Table structure for `nfx_promoter_region_agent`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_promoter_region_agent`;
CREATE TABLE `nfx_promoter_region_agent` (
  `region_agent_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '表主键',
  `shop_id` int(11) NOT NULL COMMENT '店铺id',
  `promoter_id` int(11) NOT NULL COMMENT '推广员ID',
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `agent_type` int(11) NOT NULL DEFAULT '0' COMMENT '代理类型1.省代，2，市代3，区域代理',
  `agent_provinceid` int(11) NOT NULL DEFAULT '0' COMMENT '代理省份id',
  `agent_cityid` int(11) NOT NULL DEFAULT '0' COMMENT '代理市id',
  `agent_districtid` int(11) NOT NULL DEFAULT '0' COMMENT '代理区域id',
  `is_audit` int(11) NOT NULL DEFAULT '0' COMMENT '是否已经通过0.待审核1.通过-1.审核不通过2.取消',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '操作备注',
  `reg_time` int(11) DEFAULT '0' COMMENT '申请时间',
  `audit_time` int(11) DEFAULT '0' COMMENT '通过时间',
  `cancel_time` int(11) DEFAULT '0' COMMENT '取消时间',
  `real_name` varchar(50) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `agent_mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `agent_address` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  PRIMARY KEY (`region_agent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='推广员区域代理';

-- ----------------------------
-- Records of nfx_promoter_region_agent
-- ----------------------------

-- ----------------------------
-- Table structure for `nfx_shop_commission_withdraw_config`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_shop_commission_withdraw_config`;
CREATE TABLE `nfx_shop_commission_withdraw_config` (
  `shop_id` int(11) NOT NULL COMMENT '店铺Id',
  `min_cash_money` decimal(10,2) NOT NULL DEFAULT '100.00' COMMENT '最低提现金额为元',
  `div_money` decimal(10,2) NOT NULL DEFAULT '100.00' COMMENT '提现金额为的整数倍',
  PRIMARY KEY (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='佣金（体现条件）提现条件（交易完成后即可提现）';

-- ----------------------------
-- Records of nfx_shop_commission_withdraw_config
-- ----------------------------

-- ----------------------------
-- Table structure for `nfx_shop_config`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_shop_config`;
CREATE TABLE `nfx_shop_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `is_distribution_enable` tinyint(4) NOT NULL DEFAULT '0' COMMENT '分销是否启用  1开启  0关闭',
  `is_distribution_audit` tinyint(4) NOT NULL DEFAULT '0' COMMENT '推广员是否需要审核  0不审核  1审核',
  `is_regional_agent` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启区域代理  1开启  0关闭',
  `is_partner_enable` tinyint(4) NOT NULL DEFAULT '0' COMMENT '股东分红是否开启  1开启  0关闭',
  `is_global_enable` tinyint(4) NOT NULL DEFAULT '0' COMMENT '全球分红是否开启',
  `create_date` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_date` int(11) DEFAULT '0' COMMENT '修改时间',
  `is_distribution_start` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启推广员申请  1开启  0关闭',
  `is_distribution_set` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否将以前普通会员设置为推广员 1开启  0关闭',
  `distribution_use` tinyint(4) NOT NULL DEFAULT '0' COMMENT '分销佣金使用  0利润 1销售价格',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1820 COMMENT='店铺的分销配置表';

-- ----------------------------
-- Records of nfx_shop_config
-- ----------------------------
INSERT INTO `nfx_shop_config` VALUES ('1', '0', '1', '1', '0', '0', '0', '0', '0', '1', '0', '1');

-- ----------------------------
-- Table structure for `nfx_shop_member_association`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_shop_member_association`;
CREATE TABLE `nfx_shop_member_association` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '表主键',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `source_uid` int(11) NOT NULL DEFAULT '0' COMMENT '来源会员ID',
  `promoter_id` int(11) NOT NULL DEFAULT '0' COMMENT '自身推广员ID',
  `qrcode_template_id` int(11) NOT NULL DEFAULT '0' COMMENT '推广二维码模板ID',
  `partner_id` int(11) NOT NULL DEFAULT '0' COMMENT '自身股东id',
  `is_promoter` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否是推广员',
  `is_partner` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否是股东',
  `region_center_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否是区域代理',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=481 COMMENT='店铺会员关联表';

-- ----------------------------
-- Records of nfx_shop_member_association
-- ----------------------------

-- ----------------------------
-- Table structure for `nfx_shop_region_agent_config`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_shop_region_agent_config`;
CREATE TABLE `nfx_shop_region_agent_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL COMMENT '店铺ID',
  `is_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用',
  `province_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '省代比率',
  `city_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市代比率',
  `district_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '区代比率',
  `application_require_province` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '省级申请业绩条件',
  `application_require_city` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市代申请销售条件',
  `application_require_district` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '区代申请销售条件',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4096 COMMENT='分销区域代理设置';

-- ----------------------------
-- Records of nfx_shop_region_agent_config
-- ----------------------------
INSERT INTO `nfx_shop_region_agent_config` VALUES ('1', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0');

-- ----------------------------
-- Table structure for `nfx_shop_user`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_shop_user`;
CREATE TABLE `nfx_shop_user` (
  `promoter_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '推广员ID',
  `uid` int(11) NOT NULL COMMENT '推广员对应会员ID',
  `commission_dong` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '冻结金额',
  `commission_fan` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '未到账佣金',
  `commission_ke` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '可提现佣金',
  `commission_cash` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '已提现佣金',
  `commossion_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '佣金总额',
  `order_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '销售总额',
  `is_lock` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否被冻结',
  `is_audit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已审核',
  `memo` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `lock_time` int(11) DEFAULT '0' COMMENT '冻结时间',
  `audit_time` int(11) DEFAULT '0' COMMENT '审核通过时间',
  `regidter_time` int(11) DEFAULT '0' COMMENT '申请时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`promoter_id`,`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1260 COMMENT='推广员表';

-- ----------------------------
-- Records of nfx_shop_user
-- ----------------------------
INSERT INTO `nfx_shop_user` VALUES ('1', '4', '0.00', '0.00', '0.00', '10600.00', '480.00', '0.00', '0', '0', '', '1555553953', '1555553778', '0', '1555553953');
INSERT INTO `nfx_shop_user` VALUES ('2', '5', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '1', '0', '', '1555568550', '1555553939', '0', '1555568550');

-- ----------------------------
-- Table structure for `nfx_shop_user_distribution`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_shop_user_distribution`;
CREATE TABLE `nfx_shop_user_distribution` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `serial_no` varchar(50) NOT NULL DEFAULT '' COMMENT '流水号',
  `par_id` int(11) NOT NULL COMMENT '对应的推广员ID',
  `order_id` int(11) NOT NULL COMMENT '对应的订单ID',
  `order_goods_id` int(11) NOT NULL COMMENT '对应的订单项ID',
  `goods_money` decimal(10,2) NOT NULL COMMENT '订单项商品总金额实际卖价',
  `goods_cost` decimal(10,2) NOT NULL COMMENT '订单项商品总成本',
  `goods_return` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品利润',
  `goods_commission_rate` decimal(10,2) NOT NULL COMMENT '商品对应拿出的利润比率',
  `commission_rate` decimal(10,2) NOT NULL COMMENT '获取的佣金比率',
  `commission_money` decimal(10,4) NOT NULL COMMENT '获取的佣金金额',
  `is_issue` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已经发放  0 未发放 1已发放',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1 COMMENT='推广员分销佣金';

-- ----------------------------
-- Records of nfx_shop_user_distribution
-- ----------------------------
INSERT INTO `nfx_shop_user_distribution` VALUES ('1', '', '4', '4', '0', '200.00', '100.00', '100.00', '0.00', '40.00', '40.0000', '0', '1556005251', '0');
INSERT INTO `nfx_shop_user_distribution` VALUES ('2', '', '4', '5', '0', '500.00', '200.00', '300.00', '0.00', '40.00', '120.0000', '0', '1556005750', '0');
INSERT INTO `nfx_shop_user_distribution` VALUES ('3', '', '4', '7', '0', '1000.00', '800.00', '200.00', '0.00', '40.00', '320.0000', '0', '1556008000', '0');

-- ----------------------------
-- Table structure for `nfx_user_account`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_user_account`;
CREATE TABLE `nfx_user_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(11) NOT NULL COMMENT '店铺ID',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `commission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总佣金',
  `commission_cash` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '可提现佣金',
  `commission_withdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '已提现佣金',
  `commission_locked` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '冻结中的金额',
  `commission_promoter` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销佣金',
  `commission_partner` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '股东分红',
  `commission_partner_global` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '股东全球分红',
  `commission_region_agent` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '区域代理佣金',
  `commission_partner_team` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '股东团队分红',
  `commission_promoter_team` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '推广员团队分红',
  `commission_channelagent` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '渠道代理分红',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '最新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1170 COMMENT='用户店铺账户统计';

-- ----------------------------
-- Records of nfx_user_account
-- ----------------------------

-- ----------------------------
-- Table structure for `nfx_user_account_records`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_user_account_records`;
CREATE TABLE `nfx_user_account_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '表主键',
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID，0标示平台',
  `batchcode` varchar(50) NOT NULL DEFAULT '' COMMENT '流水号',
  `money` decimal(10,4) NOT NULL DEFAULT '0.0000' COMMENT '发生金额',
  `account_type` int(11) NOT NULL DEFAULT '0' COMMENT '发生方式',
  `type_alis_id` int(11) NOT NULL DEFAULT '0' COMMENT '发生相关ID',
  `is_display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `is_calculate` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否参与计算',
  `text` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=234 COMMENT='会员账户账单(佣金)';

-- ----------------------------
-- Records of nfx_user_account_records
-- ----------------------------

-- ----------------------------
-- Table structure for `nfx_user_account_type`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_user_account_type`;
CREATE TABLE `nfx_user_account_type` (
  `type_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '类型ID',
  `type_name` varchar(50) NOT NULL COMMENT '类型名称',
  `sign` tinyint(1) NOT NULL DEFAULT '1' COMMENT '佣金或支出',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=3276 COMMENT='会员账户获取或者减少类型';

-- ----------------------------
-- Records of nfx_user_account_type
-- ----------------------------
INSERT INTO `nfx_user_account_type` VALUES ('1', '分销佣金', '1');
INSERT INTO `nfx_user_account_type` VALUES ('2', '区域代理', '1');
INSERT INTO `nfx_user_account_type` VALUES ('3', '渠道代理', '1');
INSERT INTO `nfx_user_account_type` VALUES ('4', '股东分红', '1');
INSERT INTO `nfx_user_account_type` VALUES ('5', '全球分红', '1');
INSERT INTO `nfx_user_account_type` VALUES ('10', '提现', '2');

-- ----------------------------
-- Table structure for `nfx_user_bank_account`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_user_bank_account`;
CREATE TABLE `nfx_user_bank_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '会员id',
  `bank_type` varchar(50) NOT NULL DEFAULT '1' COMMENT '账号类型 1银行卡2支付宝',
  `branch_bank_name` varchar(50) DEFAULT NULL COMMENT '支行信息',
  `realname` varchar(50) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `account_number` varchar(50) NOT NULL DEFAULT '' COMMENT '银行账号',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  `is_default` int(11) NOT NULL DEFAULT '0' COMMENT '是否默认账号',
  `create_date` int(11) DEFAULT '0' COMMENT '创建日期',
  `modify_date` int(11) DEFAULT '0' COMMENT '修改日期',
  PRIMARY KEY (`id`),
  KEY `IDX_member_bank_account_uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='会员提现账号';

-- ----------------------------
-- Records of nfx_user_bank_account
-- ----------------------------

-- ----------------------------
-- Table structure for `nfx_user_commission_withdraw`
-- ----------------------------
DROP TABLE IF EXISTS `nfx_user_commission_withdraw`;
CREATE TABLE `nfx_user_commission_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL COMMENT '店铺编号',
  `withdraw_no` varchar(255) NOT NULL DEFAULT '' COMMENT '提现流水号',
  `uid` int(11) NOT NULL COMMENT '分销商id',
  `bank_name` varchar(50) NOT NULL COMMENT '提现银行名称',
  `account_number` varchar(50) NOT NULL COMMENT '提现银行账号',
  `realname` varchar(10) NOT NULL COMMENT '提现账户姓名',
  `mobile` varchar(20) NOT NULL COMMENT '手机',
  `cash` decimal(10,2) NOT NULL COMMENT '提现金额',
  `status` smallint(6) NOT NULL DEFAULT '0' COMMENT '当前状态 0已申请(等待处理) 1已同意 -1 已拒绝',
  `memo` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `ask_for_date` int(11) DEFAULT '0' COMMENT '提现日期',
  `payment_date` int(11) DEFAULT '0' COMMENT '到账日期',
  `modify_date` int(11) DEFAULT '0' COMMENT '修改日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4096 COMMENT='佣金提现记录表';

-- ----------------------------
-- Records of nfx_user_commission_withdraw
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_account`
-- ----------------------------
DROP TABLE IF EXISTS `ns_account`;
CREATE TABLE `ns_account` (
  `account_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '账户ID',
  `account_profit` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台的总营业额',
  `account_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台资金总余额',
  `account_return` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台利润总额',
  `account_deposit` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '保证金总额',
  `account_order` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商城订单总额',
  `account_withdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商城提现总额',
  `account_shop` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺总余额',
  `account_shop_withdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺总提现',
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='商城资金统计';

-- ----------------------------
-- Records of ns_account
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_account_assistant_records`
-- ----------------------------
DROP TABLE IF EXISTS `ns_account_assistant_records`;
CREATE TABLE `ns_account_assistant_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `serial_no` varchar(50) NOT NULL DEFAULT '' COMMENT '流水号',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '对应金额',
  `account_type` tinyint(1) NOT NULL COMMENT '账户类型',
  `type_alis_id` int(11) NOT NULL COMMENT '关联ID',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='招商员支付记录';

-- ----------------------------
-- Records of ns_account_assistant_records
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_account_order_records`
-- ----------------------------
DROP TABLE IF EXISTS `ns_account_order_records`;
CREATE TABLE `ns_account_order_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `serial_no` varchar(50) NOT NULL DEFAULT '' COMMENT '流水号',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '对应金额',
  `account_type` tinyint(1) NOT NULL COMMENT '账户类型',
  `type_alis_id` int(11) NOT NULL COMMENT '关联ID',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='金额账户记录';

-- ----------------------------
-- Records of ns_account_order_records
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_account_period`
-- ----------------------------
DROP TABLE IF EXISTS `ns_account_period`;
CREATE TABLE `ns_account_period` (
  `period_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '账户ID',
  `period_year` int(10) NOT NULL COMMENT '账期年份',
  `period_month` int(10) NOT NULL COMMENT '账期月份',
  `account_profit` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '账期总营业额',
  `account_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '账期总发生余额',
  `account_return` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '账期利润总额',
  `account_deposit` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '账期保证金总额',
  `account_order` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '账期订单总额',
  `account_withdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '账期店铺提现总额',
  `account_shop` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '账期店铺总发生额',
  `account_shop_withdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '账期店铺总提现额',
  `start_time` int(11) DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) DEFAULT '0' COMMENT '结束时间',
  PRIMARY KEY (`period_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='商城账期结算表';

-- ----------------------------
-- Records of ns_account_period
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_account_records`
-- ----------------------------
DROP TABLE IF EXISTS `ns_account_records`;
CREATE TABLE `ns_account_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '对应金额',
  `account_type` tinyint(1) NOT NULL COMMENT '账户类型',
  `type_alis_id` int(11) NOT NULL COMMENT '关联ID',
  `is_display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `is_calculate` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否参与计算',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1092 COMMENT='金额账户记录';

-- ----------------------------
-- Records of ns_account_records
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_account_return_records`
-- ----------------------------
DROP TABLE IF EXISTS `ns_account_return_records`;
CREATE TABLE `ns_account_return_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `return_type` int(11) NOT NULL DEFAULT '0' COMMENT '提成类型',
  `type_alis_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联id',
  `is_display` int(11) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `is_calculate` int(11) NOT NULL DEFAULT '0' COMMENT '是否计算',
  `remark` varchar(255) NOT NULL DEFAULT '0' COMMENT '备注',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=910 COMMENT='平台的利润的记录';

-- ----------------------------
-- Records of ns_account_return_records
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_account_withdraw_records`
-- ----------------------------
DROP TABLE IF EXISTS `ns_account_withdraw_records`;
CREATE TABLE `ns_account_withdraw_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `serial_no` varchar(50) NOT NULL DEFAULT '' COMMENT '流水号',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '对应金额',
  `account_type` tinyint(1) NOT NULL COMMENT '账户类型',
  `type_alis_id` int(11) NOT NULL COMMENT '关联ID',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='金额账户记录';

-- ----------------------------
-- Records of ns_account_withdraw_records
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_account_withdraw_user_records`
-- ----------------------------
DROP TABLE IF EXISTS `ns_account_withdraw_user_records`;
CREATE TABLE `ns_account_withdraw_user_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `serial_no` varchar(50) NOT NULL DEFAULT '' COMMENT '流水号',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '对应金额',
  `account_type` tinyint(1) NOT NULL COMMENT '账户类型',
  `type_alis_id` int(11) NOT NULL COMMENT '关联ID',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员提现记录表';

-- ----------------------------
-- Records of ns_account_withdraw_user_records
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_attribute`
-- ----------------------------
DROP TABLE IF EXISTS `ns_attribute`;
CREATE TABLE `ns_attribute` (
  `attr_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品属性ID',
  `attr_name` varchar(255) NOT NULL DEFAULT '' COMMENT '属性名称',
  `is_use` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否使用',
  `spec_id_array` varchar(255) NOT NULL DEFAULT '' COMMENT '关联规格',
  `sort` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  `brand_id_array` varchar(255) NOT NULL DEFAULT '' COMMENT '关联品牌',
  PRIMARY KEY (`attr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='商品相关属性';

-- ----------------------------
-- Records of ns_attribute
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_attribute_value`
-- ----------------------------
DROP TABLE IF EXISTS `ns_attribute_value`;
CREATE TABLE `ns_attribute_value` (
  `attr_value_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '属性值ID',
  `attr_value_name` varchar(50) NOT NULL DEFAULT '' COMMENT '属性值名称',
  `attr_id` int(11) NOT NULL COMMENT '属性ID',
  `value` varchar(1000) NOT NULL DEFAULT '' COMMENT '属性对应相关数据',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '属性对应输入类型1.直接2.单选3.多选',
  `sort` int(11) NOT NULL DEFAULT '1999' COMMENT '排序号',
  `is_search` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否使用',
  PRIMARY KEY (`attr_value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4096 COMMENT='商品属性值';

-- ----------------------------
-- Records of ns_attribute_value
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_cart`
-- ----------------------------
DROP TABLE IF EXISTS `ns_cart`;
CREATE TABLE `ns_cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '购物车id',
  `buyer_id` int(11) NOT NULL DEFAULT '0' COMMENT '买家id',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `shop_name` varchar(100) NOT NULL DEFAULT '' COMMENT '店铺名称',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `goods_name` varchar(200) NOT NULL COMMENT '商品名称',
  `sku_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品的skuid',
  `sku_name` varchar(200) NOT NULL DEFAULT '' COMMENT '商品的sku名称',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `num` smallint(5) NOT NULL DEFAULT '1' COMMENT '购买商品数量',
  `goods_picture` int(11) NOT NULL DEFAULT '0' COMMENT '商品图片',
  `bl_id` mediumint(8) NOT NULL DEFAULT '0' COMMENT '组合套装ID',
  PRIMARY KEY (`cart_id`),
  KEY `member_id` (`buyer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1170 COMMENT='购物车表';

-- ----------------------------
-- Records of ns_cart
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_click_fabulous`
-- ----------------------------
DROP TABLE IF EXISTS `ns_click_fabulous`;
CREATE TABLE `ns_click_fabulous` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `shop_id` int(11) NOT NULL COMMENT '店铺id',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `create_time` int(11) DEFAULT '0' COMMENT '点赞时间',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '点赞状态 0 未点赞 1 点赞',
  `number` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='商品点赞记录表';

-- ----------------------------
-- Records of ns_click_fabulous
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_combo_package_promotion`
-- ----------------------------
DROP TABLE IF EXISTS `ns_combo_package_promotion`;
CREATE TABLE `ns_combo_package_promotion` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `combo_package_name` varchar(100) NOT NULL DEFAULT '' COMMENT '组合套餐名称',
  `combo_package_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '组合套餐价格',
  `goods_id_array` varchar(255) NOT NULL COMMENT '参与组合套餐的商品集合',
  `is_shelves` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否上架（0:下架,1:上架）',
  `shop_id` int(11) NOT NULL COMMENT '店铺id',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `original_price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '原价,仅作参考商品原价所取为sku列表中最低价',
  `save_the_price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '节省价,仅作参考不参与实际计算',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='组合套餐促销';

-- ----------------------------
-- Records of ns_combo_package_promotion
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_consult`
-- ----------------------------
DROP TABLE IF EXISTS `ns_consult`;
CREATE TABLE `ns_consult` (
  `consult_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '咨询编号',
  `goods_id` int(11) unsigned DEFAULT '0' COMMENT '商品编号',
  `goods_name` varchar(100) NOT NULL COMMENT '商品名称',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '咨询发布者会员编号(0：游客)',
  `member_name` varchar(100) NOT NULL DEFAULT '' COMMENT '会员名称',
  `shop_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺编号',
  `shop_name` varchar(50) NOT NULL COMMENT '店铺名称',
  `ct_id` int(10) unsigned NOT NULL COMMENT '咨询类型',
  `consult_content` varchar(255) NOT NULL DEFAULT '' COMMENT '咨询内容',
  `consult_reply` varchar(255) NOT NULL DEFAULT '' COMMENT '咨询回复内容',
  `isanonymous` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0表示不匿名 1表示匿名',
  `consult_addtime` int(11) DEFAULT '0' COMMENT '咨询发布时间',
  `consult_reply_time` int(11) DEFAULT '0' COMMENT '咨询回复时间',
  PRIMARY KEY (`consult_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1638 COMMENT='咨询类型表';

-- ----------------------------
-- Records of ns_consult
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_consult_type`
-- ----------------------------
DROP TABLE IF EXISTS `ns_consult_type`;
CREATE TABLE `ns_consult_type` (
  `ct_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '咨询类型id',
  `ct_name` varchar(50) NOT NULL DEFAULT '' COMMENT '咨询类型名称',
  `ct_introduce` text NOT NULL COMMENT '咨询类型详细介绍',
  `ct_sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`ct_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='咨询类型表';

-- ----------------------------
-- Records of ns_consult_type
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_coupon`
-- ----------------------------
DROP TABLE IF EXISTS `ns_coupon`;
CREATE TABLE `ns_coupon` (
  `coupon_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '优惠券id',
  `coupon_type_id` int(11) NOT NULL COMMENT '优惠券类型id',
  `shop_id` int(11) NOT NULL COMMENT '店铺Id',
  `coupon_code` varchar(255) NOT NULL DEFAULT '' COMMENT '优惠券编码',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '领用人',
  `use_order_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券使用订单id',
  `create_order_id` int(11) NOT NULL DEFAULT '0' COMMENT '创建订单id(优惠券只有是完成订单发放的优惠券时才有值)',
  `money` decimal(10,2) NOT NULL COMMENT '面额',
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '优惠券状态 0未领用 1已领用（未使用） 2已使用 3已过期',
  `get_type` int(11) NOT NULL DEFAULT '0' COMMENT '获取方式1订单2.首页领取',
  `fetch_time` int(11) DEFAULT '0' COMMENT '领取时间',
  `use_time` int(11) DEFAULT '0' COMMENT '使用时间',
  `start_time` int(11) DEFAULT '0' COMMENT '有效期开始时间',
  `end_time` int(11) DEFAULT '0' COMMENT '有效期结束时间',
  PRIMARY KEY (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='优惠券表';

-- ----------------------------
-- Records of ns_coupon
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_coupon_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ns_coupon_goods`;
CREATE TABLE `ns_coupon_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_type_id` int(11) NOT NULL COMMENT '优惠券类型id',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=606 COMMENT='优惠券使用商品表';

-- ----------------------------
-- Records of ns_coupon_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_coupon_type`
-- ----------------------------
DROP TABLE IF EXISTS `ns_coupon_type`;
CREATE TABLE `ns_coupon_type` (
  `coupon_type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '优惠券类型Id',
  `shop_id` int(11) NOT NULL DEFAULT '1' COMMENT '店铺ID',
  `coupon_name` varchar(50) NOT NULL DEFAULT '' COMMENT '优惠券名称',
  `money` decimal(10,2) NOT NULL COMMENT '发放面额',
  `count` int(11) NOT NULL COMMENT '发放数量',
  `max_fetch` int(11) NOT NULL DEFAULT '0' COMMENT '每人最大领取个数 0无限制',
  `at_least` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '满多少元使用 0代表无限制',
  `need_user_level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '领取人会员等级',
  `range_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '使用范围0部分产品使用 1全场产品使用',
  `is_show` int(11) NOT NULL DEFAULT '0' COMMENT '是否允许首页显示0不显示1显示',
  `start_time` int(11) DEFAULT '0' COMMENT '有效日期开始时间',
  `end_time` int(11) DEFAULT '0' COMMENT '有效日期结束时间',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) DEFAULT '0' COMMENT '修改时间',
  `term_of_validity_type` int(1) NOT NULL DEFAULT '0' COMMENT '有效期类型 0固定时间 1领取之日起',
  `fixed_term` int(3) NOT NULL DEFAULT '1' COMMENT '领取之日起N天内有效',
  `get_num` int(11) NOT NULL DEFAULT '0' COMMENT '已领取数量',
  `is_end` int(11) NOT NULL DEFAULT '0' COMMENT '是否已经领取完',
  PRIMARY KEY (`coupon_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1365 COMMENT='优惠券类型表';

-- ----------------------------
-- Records of ns_coupon_type
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_customer_service`
-- ----------------------------
DROP TABLE IF EXISTS `ns_customer_service`;
CREATE TABLE `ns_customer_service` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `order_no` varchar(255) NOT NULL DEFAULT '' COMMENT '订单编号',
  `order_goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单项id',
  `goods_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品名称',
  `sku_id` int(11) NOT NULL DEFAULT '0' COMMENT 'skuID',
  `sku_name` varchar(50) NOT NULL DEFAULT '' COMMENT 'sku名称',
  `price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `goods_picture` int(11) NOT NULL DEFAULT '0' COMMENT '商品图片',
  `num` varchar(255) NOT NULL DEFAULT '' COMMENT '购买数量',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `buyer_id` int(11) NOT NULL DEFAULT '0' COMMENT '购买人ID',
  `order_type` int(11) NOT NULL COMMENT '订单类型',
  `refund_money` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '退款金额',
  `refund_way` varchar(255) NOT NULL DEFAULT '' COMMENT '退款方式  退款退货',
  `refund_reason` varchar(255) NOT NULL DEFAULT '' COMMENT '退款原因',
  `audit_status` int(11) NOT NULL DEFAULT '0' COMMENT '审核状态',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '申请时间',
  `audit_time` int(11) NOT NULL DEFAULT '0' COMMENT '审核时间',
  `order_from` varchar(255) NOT NULL DEFAULT '' COMMENT '订单来源',
  `receiver_province` varchar(255) NOT NULL DEFAULT '' COMMENT '收货人所在省',
  `receiver_city` varchar(255) NOT NULL DEFAULT '' COMMENT '收货人所在城市',
  `receiver_district` varchar(255) NOT NULL DEFAULT '' COMMENT '收货人所在街道',
  `receiver_address` varchar(255) NOT NULL DEFAULT '' COMMENT '收货人详细地址',
  `payment_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付类型。取值范围：...',
  `receiver_mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '收货人的手机号码',
  `shipping_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '订单配送方式',
  `goods_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品总价',
  `fixed_telephone` varchar(50) NOT NULL DEFAULT '' COMMENT '固定电话',
  `receiver_name` varchar(50) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '买家会员名称',
  `refund_shipping_code` varchar(255) NOT NULL DEFAULT '' COMMENT '退款物流单号',
  `refund_shipping_company` varchar(255) NOT NULL DEFAULT '' COMMENT '退款物流公司名称',
  `refund_balance_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单退款余额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2048 COMMENT='售后记录表';

-- ----------------------------
-- Records of ns_customer_service
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_customer_service_records`
-- ----------------------------
DROP TABLE IF EXISTS `ns_customer_service_records`;
CREATE TABLE `ns_customer_service_records` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `order_goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单商品表id',
  `refund_status` varchar(255) NOT NULL DEFAULT '' COMMENT '操作状态 流程状态(refund_status)  状态名称(refund_status_name)  操作时间1 买家申请  发起了退款申请,等待卖家处理2 等待买家退货  卖家已同意退款申请,等待买家退货3 等待卖家确认收货  买家已退货,等待卖家确认收货4 等待卖家确认退款  卖家同意退款0 退款已成功 卖家退款给买家，本次维权结束-1  退款已拒绝 卖家拒绝本次退款，本次维权结束-2 退款已关闭 主动撤销退款，退款关闭-3 退款申请不通过 拒绝了本次退款申请,等待买家修改',
  `action` varchar(255) NOT NULL DEFAULT '' COMMENT '退款操作内容描述',
  `action_way` tinyint(4) NOT NULL DEFAULT '0' COMMENT '操作方 1 买家 2 卖家',
  `action_userid` varchar(255) NOT NULL DEFAULT '0' COMMENT '操作人id',
  `action_username` varchar(255) NOT NULL DEFAULT '' COMMENT '操作人姓名',
  `action_time` int(11) NOT NULL DEFAULT '0' COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=744 COMMENT='售后操作记录表';

-- ----------------------------
-- Records of ns_customer_service_records
-- ----------------------------
INSERT INTO `ns_customer_service_records` VALUES ('1', '25', '1', '买家申请退款', '1', '8', 'qweqwe', '1555990305');
INSERT INTO `ns_customer_service_records` VALUES ('2', '25', '2', '等待买家退货', '2', '3', 'admin', '1555996462');
INSERT INTO `ns_customer_service_records` VALUES ('3', '25', '3', '等待卖家确认收货', '1', '8', 'qweqwe', '1555996469');
INSERT INTO `ns_customer_service_records` VALUES ('4', '25', '4', '等待卖家确认退款', '2', '3', 'admin', '1555996482');
INSERT INTO `ns_customer_service_records` VALUES ('5', '25', '5', '退款已成功', '2', '3', 'admin', '1555996514');
INSERT INTO `ns_customer_service_records` VALUES ('6', '28', '1', '买家申请退款', '1', '8', 'qweqwe', '1555998760');
INSERT INTO `ns_customer_service_records` VALUES ('7', '28', '2', '等待买家退货', '2', '3', 'admin', '1556001973');
INSERT INTO `ns_customer_service_records` VALUES ('8', '28', '3', '等待卖家确认收货', '1', '8', 'qweqwe', '1556001991');
INSERT INTO `ns_customer_service_records` VALUES ('9', '28', '4', '等待卖家确认退款', '2', '3', 'admin', '1556002012');
INSERT INTO `ns_customer_service_records` VALUES ('10', '28', '5', '退款已成功', '2', '3', 'admin', '1556002030');

-- ----------------------------
-- Table structure for `ns_express_company`
-- ----------------------------
DROP TABLE IF EXISTS `ns_express_company`;
CREATE TABLE `ns_express_company` (
  `co_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '表序号',
  `shop_id` int(11) NOT NULL COMMENT '商铺id',
  `company_name` varchar(50) NOT NULL DEFAULT '' COMMENT '物流公司名称',
  `express_no` varchar(20) NOT NULL DEFAULT '' COMMENT '物流编号',
  `is_enabled` int(11) NOT NULL DEFAULT '1' COMMENT '使用状态',
  `image` varchar(255) DEFAULT '' COMMENT '物流公司模版图片',
  `phone` varchar(50) NOT NULL DEFAULT '' COMMENT '联系电话',
  `orders` int(11) DEFAULT NULL,
  `express_logo` varchar(255) DEFAULT '' COMMENT '公司logo',
  `is_default` int(11) NOT NULL DEFAULT '0' COMMENT '是否设置为默认 0未设置 1 默认',
  `template_id` int(11) NOT NULL DEFAULT '0' COMMENT '安装的物流公司模板id',
  PRIMARY KEY (`co_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4096 COMMENT='物流公司';

-- ----------------------------
-- Records of ns_express_company
-- ----------------------------
INSERT INTO `ns_express_company` VALUES ('1', '0', '申通快递', 'shentong', '1', '', '95543', '0', 'upload/default/express/shentong.png', '1', '0');
INSERT INTO `ns_express_company` VALUES ('2', '0', '圆通速递', 'yuantong', '1', '', '95554', '1', 'upload/default/express/yuantong.png', '0', '0');
INSERT INTO `ns_express_company` VALUES ('3', '0', '中通快递', 'zhongtong', '1', '', '95311', '2', 'upload/default/express/zhongtong.png', '0', '0');
INSERT INTO `ns_express_company` VALUES ('4', '0', '韵达快运', 'yunda', '1', '', '95546', '3', 'upload/default/express/yunda.png', '0', '0');

-- ----------------------------
-- Table structure for `ns_express_shipping`
-- ----------------------------
DROP TABLE IF EXISTS `ns_express_shipping`;
CREATE TABLE `ns_express_shipping` (
  `sid` int(11) NOT NULL AUTO_INCREMENT COMMENT '运单模版id',
  `shop_id` int(11) NOT NULL COMMENT '店铺id',
  `template_name` varchar(255) NOT NULL DEFAULT '' COMMENT '模版名称',
  `co_id` int(11) NOT NULL DEFAULT '0' COMMENT '物流公司 id',
  `size_type` smallint(6) NOT NULL DEFAULT '1' COMMENT '尺寸类型 1像素px  2毫米mm',
  `width` smallint(6) NOT NULL DEFAULT '0' COMMENT '宽度',
  `height` smallint(6) NOT NULL DEFAULT '0' COMMENT '长度',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '快递单图片',
  PRIMARY KEY (`sid`),
  KEY `IDX_express_shipping_co_id` (`co_id`),
  KEY `IDX_express_shipping_shopId` (`shop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4096 COMMENT='运单模板';

-- ----------------------------
-- Records of ns_express_shipping
-- ----------------------------
INSERT INTO `ns_express_shipping` VALUES ('1', '0', '申通快递', '1', '1', '0', '0', '');
INSERT INTO `ns_express_shipping` VALUES ('2', '0', '圆通速递', '2', '1', '0', '0', '');
INSERT INTO `ns_express_shipping` VALUES ('3', '0', '中通快递', '3', '1', '0', '0', '');
INSERT INTO `ns_express_shipping` VALUES ('4', '0', '韵达快运', '4', '1', '0', '0', '');

-- ----------------------------
-- Table structure for `ns_express_shipping_items`
-- ----------------------------
DROP TABLE IF EXISTS `ns_express_shipping_items`;
CREATE TABLE `ns_express_shipping_items` (
  `sid` int(11) NOT NULL DEFAULT '0' COMMENT '运单模版id',
  `field_name` varchar(30) NOT NULL COMMENT '字段名称',
  `field_display_name` varchar(255) NOT NULL COMMENT '打印项名称',
  `is_print` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否打印',
  `x` int(11) NOT NULL DEFAULT '0' COMMENT 'x',
  `y` int(11) NOT NULL DEFAULT '0' COMMENT 'y',
  PRIMARY KEY (`sid`,`field_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=315 COMMENT='物流模板打印项';

-- ----------------------------
-- Records of ns_express_shipping_items
-- ----------------------------
INSERT INTO `ns_express_shipping_items` VALUES ('1', 'A1', '订单编号', '1', '10', '11');
INSERT INTO `ns_express_shipping_items` VALUES ('1', 'A10', '收件人邮编', '1', '10', '86');
INSERT INTO `ns_express_shipping_items` VALUES ('1', 'A11', '货到付款物流编号', '1', '10', '286');
INSERT INTO `ns_express_shipping_items` VALUES ('1', 'A12', '代收金额', '1', '10', '186');
INSERT INTO `ns_express_shipping_items` VALUES ('1', 'A13', '备注', '1', '10', '311');
INSERT INTO `ns_express_shipping_items` VALUES ('1', 'A2', '发件人公司', '1', '10', '36');
INSERT INTO `ns_express_shipping_items` VALUES ('1', 'A3', '发件人地址', '1', '10', '136');
INSERT INTO `ns_express_shipping_items` VALUES ('1', 'A4', '发件人姓名', '1', '10', '111');
INSERT INTO `ns_express_shipping_items` VALUES ('1', 'A5', '发件人电话', '1', '10', '211');
INSERT INTO `ns_express_shipping_items` VALUES ('1', 'A6', '发件人邮编', '1', '10', '236');
INSERT INTO `ns_express_shipping_items` VALUES ('1', 'A7', '收件人地址', '1', '10', '261');
INSERT INTO `ns_express_shipping_items` VALUES ('1', 'A8', '收件人姓名', '1', '10', '61');
INSERT INTO `ns_express_shipping_items` VALUES ('1', 'A9', '收件人电话', '1', '10', '161');
INSERT INTO `ns_express_shipping_items` VALUES ('2', 'A1', '订单编号', '1', '10', '11');
INSERT INTO `ns_express_shipping_items` VALUES ('2', 'A10', '收件人邮编', '1', '10', '86');
INSERT INTO `ns_express_shipping_items` VALUES ('2', 'A11', '货到付款物流编号', '1', '10', '286');
INSERT INTO `ns_express_shipping_items` VALUES ('2', 'A12', '代收金额', '1', '10', '186');
INSERT INTO `ns_express_shipping_items` VALUES ('2', 'A13', '备注', '1', '10', '311');
INSERT INTO `ns_express_shipping_items` VALUES ('2', 'A2', '发件人公司', '1', '10', '36');
INSERT INTO `ns_express_shipping_items` VALUES ('2', 'A3', '发件人地址', '1', '10', '136');
INSERT INTO `ns_express_shipping_items` VALUES ('2', 'A4', '发件人姓名', '1', '10', '111');
INSERT INTO `ns_express_shipping_items` VALUES ('2', 'A5', '发件人电话', '1', '10', '211');
INSERT INTO `ns_express_shipping_items` VALUES ('2', 'A6', '发件人邮编', '1', '10', '236');
INSERT INTO `ns_express_shipping_items` VALUES ('2', 'A7', '收件人地址', '1', '10', '261');
INSERT INTO `ns_express_shipping_items` VALUES ('2', 'A8', '收件人姓名', '1', '10', '61');
INSERT INTO `ns_express_shipping_items` VALUES ('2', 'A9', '收件人电话', '1', '10', '161');
INSERT INTO `ns_express_shipping_items` VALUES ('3', 'A1', '订单编号', '1', '10', '11');
INSERT INTO `ns_express_shipping_items` VALUES ('3', 'A10', '收件人邮编', '1', '10', '86');
INSERT INTO `ns_express_shipping_items` VALUES ('3', 'A11', '货到付款物流编号', '1', '10', '286');
INSERT INTO `ns_express_shipping_items` VALUES ('3', 'A12', '代收金额', '1', '10', '186');
INSERT INTO `ns_express_shipping_items` VALUES ('3', 'A13', '备注', '1', '10', '311');
INSERT INTO `ns_express_shipping_items` VALUES ('3', 'A2', '发件人公司', '1', '10', '36');
INSERT INTO `ns_express_shipping_items` VALUES ('3', 'A3', '发件人地址', '1', '10', '136');
INSERT INTO `ns_express_shipping_items` VALUES ('3', 'A4', '发件人姓名', '1', '10', '111');
INSERT INTO `ns_express_shipping_items` VALUES ('3', 'A5', '发件人电话', '1', '10', '211');
INSERT INTO `ns_express_shipping_items` VALUES ('3', 'A6', '发件人邮编', '1', '10', '236');
INSERT INTO `ns_express_shipping_items` VALUES ('3', 'A7', '收件人地址', '1', '10', '261');
INSERT INTO `ns_express_shipping_items` VALUES ('3', 'A8', '收件人姓名', '1', '10', '61');
INSERT INTO `ns_express_shipping_items` VALUES ('3', 'A9', '收件人电话', '1', '10', '161');
INSERT INTO `ns_express_shipping_items` VALUES ('4', 'A1', '订单编号', '1', '10', '11');
INSERT INTO `ns_express_shipping_items` VALUES ('4', 'A10', '收件人邮编', '1', '10', '86');
INSERT INTO `ns_express_shipping_items` VALUES ('4', 'A11', '货到付款物流编号', '1', '10', '286');
INSERT INTO `ns_express_shipping_items` VALUES ('4', 'A12', '代收金额', '1', '10', '186');
INSERT INTO `ns_express_shipping_items` VALUES ('4', 'A13', '备注', '1', '10', '311');
INSERT INTO `ns_express_shipping_items` VALUES ('4', 'A2', '发件人公司', '1', '10', '36');
INSERT INTO `ns_express_shipping_items` VALUES ('4', 'A3', '发件人地址', '1', '10', '136');
INSERT INTO `ns_express_shipping_items` VALUES ('4', 'A4', '发件人姓名', '1', '10', '111');
INSERT INTO `ns_express_shipping_items` VALUES ('4', 'A5', '发件人电话', '1', '10', '211');
INSERT INTO `ns_express_shipping_items` VALUES ('4', 'A6', '发件人邮编', '1', '10', '236');
INSERT INTO `ns_express_shipping_items` VALUES ('4', 'A7', '收件人地址', '1', '10', '261');
INSERT INTO `ns_express_shipping_items` VALUES ('4', 'A8', '收件人姓名', '1', '10', '61');
INSERT INTO `ns_express_shipping_items` VALUES ('4', 'A9', '收件人电话', '1', '10', '161');

-- ----------------------------
-- Table structure for `ns_express_shipping_items_library`
-- ----------------------------
DROP TABLE IF EXISTS `ns_express_shipping_items_library`;
CREATE TABLE `ns_express_shipping_items_library` (
  `Id` int(11) NOT NULL AUTO_INCREMENT COMMENT '物流模版打印项库ID',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `field_name` varchar(50) NOT NULL COMMENT '字段名',
  `field_display_name` varchar(50) NOT NULL COMMENT '字段显示名',
  `is_enabled` bit(1) NOT NULL DEFAULT b'1' COMMENT '是否启用',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1260 COMMENT='物流模版打印项库';

-- ----------------------------
-- Records of ns_express_shipping_items_library
-- ----------------------------
INSERT INTO `ns_express_shipping_items_library` VALUES ('1', '0', 'A1', '订单编号', '');
INSERT INTO `ns_express_shipping_items_library` VALUES ('2', '0', 'A2', '发件人公司', '');
INSERT INTO `ns_express_shipping_items_library` VALUES ('3', '0', 'A8', '收件人姓名', '');
INSERT INTO `ns_express_shipping_items_library` VALUES ('4', '0', 'A10', '收件人邮编', '');
INSERT INTO `ns_express_shipping_items_library` VALUES ('5', '0', 'A4', '发件人姓名', '');
INSERT INTO `ns_express_shipping_items_library` VALUES ('6', '0', 'A3', '发件人地址', '');
INSERT INTO `ns_express_shipping_items_library` VALUES ('7', '0', 'A9', '收件人电话', '');
INSERT INTO `ns_express_shipping_items_library` VALUES ('8', '0', 'A12', '代收金额', '');
INSERT INTO `ns_express_shipping_items_library` VALUES ('9', '0', 'A5', '发件人电话', '');
INSERT INTO `ns_express_shipping_items_library` VALUES ('10', '0', 'A6', '发件人邮编', '');
INSERT INTO `ns_express_shipping_items_library` VALUES ('11', '0', 'A7', '收件人地址', '');
INSERT INTO `ns_express_shipping_items_library` VALUES ('12', '0', 'A11', '货到付款物流编号', '');
INSERT INTO `ns_express_shipping_items_library` VALUES ('13', '0', 'A13', '备注', '');

-- ----------------------------
-- Table structure for `ns_gift_grant_records`
-- ----------------------------
DROP TABLE IF EXISTS `ns_gift_grant_records`;
CREATE TABLE `ns_gift_grant_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `gift_id` int(11) NOT NULL COMMENT '赠送活动ID',
  `goods_id` int(11) NOT NULL COMMENT '赠送商品ID',
  `goods_name` varchar(50) NOT NULL DEFAULT '' COMMENT '赠送商品名称',
  `goods_img` varchar(255) NOT NULL DEFAULT '' COMMENT '赠送商品图片',
  `num` int(11) NOT NULL DEFAULT '1' COMMENT '赠送数量',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '发放方式',
  `type_id` int(11) NOT NULL DEFAULT '0' COMMENT '发放相关ID',
  `memo` text NOT NULL COMMENT '备注',
  `create_time` int(11) DEFAULT '0' COMMENT '赠送时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='赠品发放记录';

-- ----------------------------
-- Records of ns_gift_grant_records
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods`;
CREATE TABLE `ns_goods` (
  `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品id(SKU)',
  `goods_name` varchar(100) NOT NULL DEFAULT '' COMMENT '商品名称',
  `shop_id` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '店铺id',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品分类id',
  `category_id_1` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '一级分类id',
  `category_id_2` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '二级分类id',
  `category_id_3` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '三级分类id',
  `brand_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '品牌id',
  `group_id_array` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺分类id 首尾用,隔开',
  `promotion_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '促销类型 0无促销，1团购，2限时折扣',
  `promote_id` int(11) NOT NULL DEFAULT '0' COMMENT '促销活动ID',
  `goods_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '商品类型 1实物商品 0虚拟商品',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '商品原价格',
  `promotion_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品促销价格',
  `cost_price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '成本价',
  `point_exchange_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '积分兑换类型 0 非积分兑换 1 只能积分兑换 ',
  `point_exchange` int(11) NOT NULL DEFAULT '0' COMMENT '积分兑换',
  `give_point` int(11) NOT NULL DEFAULT '0' COMMENT '购买商品赠送积分',
  `is_member_discount` int(1) NOT NULL DEFAULT '0' COMMENT '参与会员折扣',
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费 0为免运费',
  `shipping_fee_id` int(11) NOT NULL DEFAULT '0' COMMENT '售卖区域id 物流模板id  ns_order_shipping_fee 表id',
  `stock` int(10) NOT NULL DEFAULT '0' COMMENT '商品库存',
  `max_buy` int(11) NOT NULL DEFAULT '0' COMMENT '限购 0 不限购',
  `clicks` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品点击数量',
  `min_stock_alarm` int(11) NOT NULL DEFAULT '0' COMMENT '库存预警值',
  `sales` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '销售数量',
  `collects` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏数量',
  `star` tinyint(3) unsigned NOT NULL DEFAULT '5' COMMENT '好评星级',
  `evaluates` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评价数',
  `shares` int(11) NOT NULL DEFAULT '0' COMMENT '分享数',
  `province_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '一级地区id',
  `city_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '二级地区id',
  `picture` int(11) NOT NULL DEFAULT '0' COMMENT '商品主图',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '商品关键词',
  `introduction` varchar(255) NOT NULL DEFAULT '' COMMENT '商品简介，促销语',
  `description` text NOT NULL COMMENT '商品详情',
  `QRcode` varchar(255) NOT NULL DEFAULT '' COMMENT '商品二维码',
  `code` varchar(50) NOT NULL DEFAULT '' COMMENT '商家编号',
  `is_stock_visible` int(1) NOT NULL DEFAULT '0' COMMENT '页面不显示库存',
  `is_hot` int(1) NOT NULL DEFAULT '0' COMMENT '是否热销商品',
  `is_recommend` int(1) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `is_new` int(1) NOT NULL DEFAULT '0' COMMENT '是否新品',
  `is_pre_sale` int(11) DEFAULT '0',
  `is_bill` int(1) NOT NULL DEFAULT '0' COMMENT '是否开具增值税发票 1是，0否',
  `state` tinyint(3) NOT NULL DEFAULT '1' COMMENT '商品状态 0下架，1正常，10违规（禁售）',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `img_id_array` varchar(1000) DEFAULT NULL COMMENT '商品图片序列',
  `sku_img_array` varchar(1000) DEFAULT NULL COMMENT '商品sku应用图片列表  属性,属性值，图片ID',
  `match_point` float(10,2) DEFAULT NULL COMMENT '实物与描述相符（根据评价计算）',
  `match_ratio` float(10,2) DEFAULT NULL COMMENT '实物与描述相符（根据评价计算）百分比',
  `real_sales` int(10) NOT NULL DEFAULT '0' COMMENT '实际销量',
  `goods_attribute_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品类型',
  `goods_spec_format` text NOT NULL COMMENT '商品规格',
  `goods_weight` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '商品重量',
  `goods_volume` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '商品体积',
  `shipping_fee_type` int(11) NOT NULL DEFAULT '1' COMMENT '计价方式1.重量2.体积3.计件',
  `extend_category_id` varchar(255) DEFAULT NULL,
  `extend_category_id_1` varchar(255) DEFAULT NULL,
  `extend_category_id_2` varchar(255) DEFAULT NULL,
  `extend_category_id_3` varchar(255) DEFAULT NULL,
  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '供货商id',
  `sale_date` int(11) DEFAULT '0' COMMENT '上下架时间',
  `create_time` int(11) DEFAULT '0' COMMENT '商品添加时间',
  `update_time` int(11) DEFAULT '0' COMMENT '商品编辑时间',
  `min_buy` int(11) NOT NULL DEFAULT '0' COMMENT '最少买几件',
  `virtual_goods_type_id` int(11) DEFAULT '0' COMMENT '虚拟商品类型id',
  `production_date` int(11) NOT NULL DEFAULT '0' COMMENT '生产日期',
  `shelf_life` varchar(50) NOT NULL DEFAULT '' COMMENT '保质期',
  `goods_video_address` varchar(455) DEFAULT '' COMMENT '商品视频地址，不为空时前台显示视频',
  `pc_custom_template` varchar(255) NOT NULL DEFAULT '' COMMENT 'pc端商品自定义模板',
  `wap_custom_template` varchar(255) NOT NULL DEFAULT '' COMMENT 'wap端商品自定义模板',
  `max_use_point` int(11) NOT NULL DEFAULT '0' COMMENT '积分抵现最大可用积分数 0为不可使用',
  `is_open_presell` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否支持预售',
  `presell_time` int(11) NOT NULL DEFAULT '0' COMMENT '预售发货时间',
  `presell_day` int(11) NOT NULL DEFAULT '0' COMMENT '预售发货天数',
  `presell_delivery_type` int(11) NOT NULL DEFAULT '1' COMMENT '预售发货方式1. 按照预售发货时间 2.按照预售发货天数',
  `presell_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '预售金额',
  `goods_unit` varchar(20) NOT NULL DEFAULT '' COMMENT '商品单位',
  `decimal_reservation_number` int(2) NOT NULL DEFAULT '-1' COMMENT '价格保留方式 0去掉角和分 1去掉分',
  `integral_give_type` int(1) NOT NULL DEFAULT '0' COMMENT '积分赠送类型 0固定值 1按比率',
  PRIMARY KEY (`goods_id`),
  KEY `UK_ns_goods_category` (`brand_id`,`category_id`,`category_id_1`,`category_id_2`,`category_id_3`),
  KEY `UK_ns_goods_category_extend` (`extend_category_id`,`extend_category_id_1`,`extend_category_id_2`,`extend_category_id_3`,`goods_attribute_id`),
  KEY `UK_ns_goods_category_promote` (`group_id_array`,`promotion_price`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16554 COMMENT='商品表';

-- ----------------------------
-- Records of ns_goods
-- ----------------------------
INSERT INTO `ns_goods` VALUES ('1', '测试', '0', '3', '1', '2', '3', '0', '0', '0', '0', '1', '111.00', '300.00', '300.00', '100.00', '0', '0', '0', '0', '0.00', '0', '219', '0', '13', '1', '7', '0', '5', '0', '0', '0', '0', '1', '', '', '<p>12</p>', '', '', '1', '0', '0', '0', '0', '0', '1', '0', '1', '[]', null, null, '5', '0', '[]', '0.00', '0.00', '3', null, null, null, null, '0', '1555481540', '1555481540', '1555481563', '0', '0', '0', '0', '', '', '', '0', '0', '0', '0', '1', '0.00', '', '-1', '0');
INSERT INTO `ns_goods` VALUES ('2', '测试2', '0', '4', '1', '4', '0', '0', '0', '0', '0', '1', '0.00', '200.00', '200.00', '100.00', '0', '0', '0', '0', '0.00', '0', '106', '0', '16', '2', '19', '0', '5', '0', '0', '0', '0', '2', '', '', '<p>12</p>', '', '', '1', '0', '0', '0', '0', '0', '1', '0', '2', '[]', null, null, '7', '0', '[]', '0.00', '0.00', '3', null, null, null, null, '0', '1555489583', '1555489583', '0', '0', '0', '0', '0', '', '', '', '0', '0', '0', '0', '1', '0.00', '', '-1', '0');
INSERT INTO `ns_goods` VALUES ('3', '333', '0', '4', '1', '4', '0', '0', '0', '0', '0', '1', '0.00', '500.00', '500.00', '100.00', '0', '0', '0', '0', '0.00', '0', '108', '0', '6', '11', '14', '0', '5', '0', '0', '0', '0', '3', '', '', '<p>123</p>', '', '', '1', '0', '0', '0', '0', '0', '1', '0', '3', '[]', null, null, '3', '0', '[]', '0.00', '0.00', '3', null, null, null, null, '0', '1555639479', '1555639479', '0', '0', '0', '0', '0', '', '', '', '0', '0', '0', '0', '1', '0.00', '', '-1', '0');

-- ----------------------------
-- Table structure for `ns_goods_attribute`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_attribute`;
CREATE TABLE `ns_goods_attribute` (
  `attr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL COMMENT '商品ID',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `attr_value_id` int(11) NOT NULL COMMENT '属性值id',
  `attr_value` varchar(255) NOT NULL DEFAULT '' COMMENT '属性值名称',
  `attr_value_name` varchar(255) NOT NULL DEFAULT '' COMMENT '属性值对应数据值',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`attr_id`),
  KEY `UK_ns_goods_attribute_attr_value_id` (`attr_value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=315 COMMENT='商品属性表';

-- ----------------------------
-- Records of ns_goods_attribute
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_attribute_deleted`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_attribute_deleted`;
CREATE TABLE `ns_goods_attribute_deleted` (
  `attr_id` int(10) NOT NULL,
  `goods_id` int(11) NOT NULL COMMENT '商品ID',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `attr_value_id` int(11) NOT NULL COMMENT '属性值id',
  `attr_value` varchar(255) NOT NULL DEFAULT '' COMMENT '属性值名称',
  `attr_value_name` varchar(255) NOT NULL DEFAULT '' COMMENT '属性值对应数据值',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=315 COMMENT='商品属性回收站表';

-- ----------------------------
-- Records of ns_goods_attribute_deleted
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_attribute_value`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_attribute_value`;
CREATE TABLE `ns_goods_attribute_value` (
  `attr_value_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品属性值ID',
  `attr_id` int(11) NOT NULL COMMENT '商品属性ID',
  `attr_value` varchar(255) NOT NULL DEFAULT '' COMMENT '值名称',
  `is_visible` bit(1) NOT NULL DEFAULT b'1' COMMENT '是否可视',
  `sort` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT '0',
  PRIMARY KEY (`attr_value_id`),
  KEY `IDX_category_propvalues_c_pId` (`attr_id`),
  KEY `IDX_category_propvalues_orders` (`sort`),
  KEY `IDX_category_propvalues_value` (`attr_value`),
  KEY `UK_ns_goods_attribute_value_attr_value_id` (`attr_value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1092 COMMENT='商品规格值模版表';

-- ----------------------------
-- Records of ns_goods_attribute_value
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_brand`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_brand`;
CREATE TABLE `ns_goods_brand` (
  `brand_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `brand_name` varchar(100) NOT NULL COMMENT '品牌名称',
  `brand_initial` varchar(1) NOT NULL COMMENT '品牌首字母',
  `brand_pic` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',
  `brand_recommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '推荐，0为否，1为是，默认为0',
  `sort` int(11) DEFAULT NULL,
  `brand_category_name` varchar(50) NOT NULL DEFAULT '' COMMENT '类别名称',
  `category_id_array` varchar(1000) NOT NULL DEFAULT '' COMMENT '所属分类id组',
  `brand_ads` varchar(255) NOT NULL DEFAULT '' COMMENT '品牌推荐广告',
  `category_name` varchar(50) NOT NULL DEFAULT '' COMMENT '品牌所属分类名称',
  `category_id_1` int(11) NOT NULL DEFAULT '0' COMMENT '一级分类ID',
  `category_id_2` int(11) NOT NULL DEFAULT '0' COMMENT '二级分类ID',
  `category_id_3` int(11) NOT NULL DEFAULT '0' COMMENT '三级分类ID',
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1024 COMMENT='品牌表';

-- ----------------------------
-- Records of ns_goods_brand
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_browse`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_browse`;
CREATE TABLE `ns_goods_browse` (
  `browse_id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '浏览时间',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
  `add_date` varchar(255) NOT NULL DEFAULT '' COMMENT '添加日期 格式 Y-m-d',
  PRIMARY KEY (`browse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=91 COMMENT='商品足迹表';

-- ----------------------------
-- Records of ns_goods_browse
-- ----------------------------
INSERT INTO `ns_goods_browse` VALUES ('4', '1', '4', '1555489858', '3', '2019-04-17');
INSERT INTO `ns_goods_browse` VALUES ('9', '2', '4', '1555490106', '4', '2019-04-17');
INSERT INTO `ns_goods_browse` VALUES ('32', '2', '8', '1556007700', '4', '2019-04-23');
INSERT INTO `ns_goods_browse` VALUES ('33', '3', '8', '1556007709', '4', '2019-04-23');
INSERT INTO `ns_goods_browse` VALUES ('34', '1', '8', '1556007716', '3', '2019-04-23');

-- ----------------------------
-- Table structure for `ns_goods_category`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_category`;
CREATE TABLE `ns_goods_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL DEFAULT '',
  `short_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品分类简称 ',
  `pid` int(11) NOT NULL DEFAULT '0',
  `level` tinyint(4) NOT NULL DEFAULT '0',
  `is_visible` int(11) NOT NULL DEFAULT '1' COMMENT '是否显示  1 显示 0 不显示',
  `attr_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联商品类型ID',
  `attr_name` varchar(255) NOT NULL DEFAULT '' COMMENT '关联类型名称',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '分类关键字用于seo',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '分类描述用于seo',
  `sort` int(11) DEFAULT NULL,
  `category_pic` varchar(255) NOT NULL DEFAULT '' COMMENT '商品分类图片',
  `pc_custom_template` varchar(255) NOT NULL DEFAULT '' COMMENT 'pc端商品分类自定义模板',
  `wap_custom_template` varchar(255) NOT NULL DEFAULT '' COMMENT 'wap端商品分类自定义模板',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=244 COMMENT='商品分类表';

-- ----------------------------
-- Records of ns_goods_category
-- ----------------------------
INSERT INTO `ns_goods_category` VALUES ('1', '衣服', 'yf', '0', '1', '1', '0', '', '', '', '0', '', '', '');
INSERT INTO `ns_goods_category` VALUES ('2', '小', '', '1', '2', '1', '0', '', '', '', '0', '', '', '');
INSERT INTO `ns_goods_category` VALUES ('3', '笑笑', '', '2', '3', '1', '0', '', '', '', '0', '', '', '');
INSERT INTO `ns_goods_category` VALUES ('4', '大', '', '1', '2', '1', '0', '', '', '', '0', '', '', '');

-- ----------------------------
-- Table structure for `ns_goods_category_block`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_category_block`;
CREATE TABLE `ns_goods_category_block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '实例id',
  `category_name` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
  `category_alias` varchar(50) NOT NULL DEFAULT '' COMMENT '分类别名',
  `color` varchar(255) DEFAULT '#FFFFFF' COMMENT '颜色',
  `is_show` int(11) NOT NULL DEFAULT '1' COMMENT '是否显示 1显示 0 不显示',
  `is_show_lower_category` int(11) NOT NULL DEFAULT '0' COMMENT '是否显示下级分类',
  `is_show_brand` int(11) NOT NULL DEFAULT '0' COMMENT '是否显示品牌',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `ad_picture` varchar(255) NOT NULL DEFAULT '' COMMENT '广告图  {["title":"","subtitle":"","picture":"","url":"","background":""]}',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `short_name` varchar(255) DEFAULT '' COMMENT '分类简称',
  `goods_sort_type` int(11) NOT NULL DEFAULT '0' COMMENT '楼层商品排序方式 0默认按时间和排序号倒叙 1按发布时间排序 2按销量排序 3按排序号排序 4按人气排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='商品分类楼层表';

-- ----------------------------
-- Records of ns_goods_category_block
-- ----------------------------
INSERT INTO `ns_goods_category_block` VALUES ('1', '0', '衣服', '1', '衣服', '#FFFFFF', '1', '0', '0', '0', '', '1555481487', '0', '衣服', '0');

-- ----------------------------
-- Table structure for `ns_goods_comment`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_comment`;
CREATE TABLE `ns_goods_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `shop_id` int(11) NOT NULL COMMENT '店铺id',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `create_time` int(11) DEFAULT '0' COMMENT '评论创建时间',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '评论状态 0未评论 1已评论',
  `number` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='商品评论送积分记录表';

-- ----------------------------
-- Records of ns_goods_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_deleted`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_deleted`;
CREATE TABLE `ns_goods_deleted` (
  `goods_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品id(SKU)',
  `goods_name` varchar(100) NOT NULL DEFAULT '' COMMENT '商品名称',
  `shop_id` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '店铺id',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品分类id',
  `category_id_1` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '一级分类id',
  `category_id_2` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '二级分类id',
  `category_id_3` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '三级分类id',
  `brand_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '品牌id',
  `group_id_array` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺分类id 首尾用,隔开',
  `promotion_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '促销类型 0无促销，1团购，2限时折扣',
  `promote_id` int(11) NOT NULL DEFAULT '0' COMMENT '促销活动ID',
  `goods_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '实物或虚拟商品标志 1实物商品 0 虚拟商品 2 F码商品',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '商品原价格',
  `promotion_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品促销价格',
  `cost_price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '成本价',
  `point_exchange_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '积分兑换类型 0 非积分兑换 1 只能积分兑换 ',
  `point_exchange` int(11) NOT NULL DEFAULT '0' COMMENT '积分兑换',
  `give_point` int(11) NOT NULL DEFAULT '0' COMMENT '购买商品赠送积分',
  `is_member_discount` int(1) NOT NULL DEFAULT '0' COMMENT '参与会员折扣',
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费 0为免运费',
  `shipping_fee_id` int(11) NOT NULL DEFAULT '0' COMMENT '售卖区域id 物流模板id  ns_order_shipping_fee 表id',
  `stock` int(10) NOT NULL DEFAULT '0' COMMENT '商品库存',
  `max_buy` int(11) NOT NULL DEFAULT '0' COMMENT '限购 0 不限购',
  `clicks` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品点击数量',
  `min_stock_alarm` int(11) NOT NULL DEFAULT '0' COMMENT '库存预警值',
  `sales` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '销售数量',
  `collects` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏数量',
  `star` tinyint(3) unsigned NOT NULL DEFAULT '5' COMMENT '好评星级',
  `evaluates` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评价数',
  `shares` int(11) NOT NULL DEFAULT '0' COMMENT '分享数',
  `province_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '一级地区id',
  `city_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '二级地区id',
  `picture` int(11) NOT NULL DEFAULT '0' COMMENT '商品主图',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '商品关键词',
  `introduction` varchar(255) NOT NULL DEFAULT '' COMMENT '商品简介，促销语',
  `description` text NOT NULL COMMENT '商品详情',
  `QRcode` varchar(255) NOT NULL DEFAULT '' COMMENT '商品二维码',
  `code` varchar(50) NOT NULL DEFAULT '' COMMENT '商家编号',
  `is_stock_visible` int(1) NOT NULL DEFAULT '0' COMMENT '页面不显示库存',
  `is_hot` int(1) NOT NULL DEFAULT '0' COMMENT '是否热销商品',
  `is_recommend` int(1) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `is_new` int(1) NOT NULL DEFAULT '0' COMMENT '是否新品',
  `is_pre_sale` int(1) NOT NULL DEFAULT '0' COMMENT '是否预售',
  `is_bill` int(1) NOT NULL DEFAULT '0' COMMENT '是否开具增值税发票 1是，0否',
  `state` tinyint(3) NOT NULL DEFAULT '1' COMMENT '商品状态 0下架，1正常，10违规（禁售）',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `img_id_array` varchar(1000) DEFAULT NULL COMMENT '商品图片序列',
  `sku_img_array` varchar(1000) DEFAULT NULL COMMENT '商品sku应用图片列表  属性,属性值，图片ID',
  `match_point` float(10,2) DEFAULT NULL COMMENT '实物与描述相符（根据评价计算）',
  `match_ratio` float(10,2) DEFAULT NULL COMMENT '实物与描述相符（根据评价计算）百分比',
  `real_sales` int(10) NOT NULL DEFAULT '0' COMMENT '实际销量',
  `goods_attribute_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品类型',
  `goods_spec_format` text NOT NULL COMMENT '商品规格',
  `goods_weight` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '商品重量',
  `goods_volume` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '商品体积',
  `shipping_fee_type` int(11) NOT NULL DEFAULT '1' COMMENT '计价方式1.重量2.体积3.计件',
  `extend_category_id` varchar(255) DEFAULT NULL,
  `extend_category_id_1` varchar(255) DEFAULT NULL,
  `extend_category_id_2` varchar(255) DEFAULT NULL,
  `extend_category_id_3` varchar(255) DEFAULT NULL,
  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '供货商id',
  `sale_date` int(11) DEFAULT '0' COMMENT '上下架时间',
  `create_time` int(11) DEFAULT '0' COMMENT '商品添加时间',
  `update_time` int(11) DEFAULT '0' COMMENT '商品编辑时间',
  `min_buy` int(11) NOT NULL DEFAULT '0' COMMENT '最少买几件',
  `virtual_goods_type_id` int(11) DEFAULT '0' COMMENT '虚拟商品类型id',
  `production_date` int(11) NOT NULL DEFAULT '0' COMMENT '生产日期',
  `shelf_life` varchar(50) NOT NULL DEFAULT '' COMMENT '保质期',
  `goods_video_address` varchar(455) NOT NULL DEFAULT '' COMMENT '商品视频地址，不为空时前台显示视频',
  `pc_custom_template` varchar(255) NOT NULL DEFAULT '' COMMENT 'pc端商品自定义模板',
  `wap_custom_template` varchar(255) NOT NULL DEFAULT '' COMMENT 'wap端商品自定义模板',
  `max_use_point` int(11) NOT NULL DEFAULT '0' COMMENT '积分抵现最大可用积分数 0为不可使用',
  `is_open_presell` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否支持预售',
  `presell_time` int(11) NOT NULL DEFAULT '0' COMMENT '预售发货时间',
  `presell_day` int(11) NOT NULL DEFAULT '0' COMMENT '预售发货天数',
  `presell_delivery_type` int(11) NOT NULL DEFAULT '1' COMMENT '预售发货方式1. 按照预售发货时间 2.按照预售发货天数',
  `presell_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '预售金额',
  `goods_unit` varchar(20) NOT NULL DEFAULT '件' COMMENT '商品单位',
  `decimal_reservation_number` int(2) NOT NULL DEFAULT '-1' COMMENT '价格保留方式 0去掉角和分 1去掉分',
  `integral_give_type` int(1) NOT NULL DEFAULT '0' COMMENT '积分赠送类型 0固定值 1按比率'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='商品回收站表';

-- ----------------------------
-- Records of ns_goods_deleted
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_evaluate`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_evaluate`;
CREATE TABLE `ns_goods_evaluate` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评价ID',
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `order_no` bigint(20) unsigned NOT NULL COMMENT '订单编号',
  `order_goods_id` int(11) NOT NULL COMMENT '订单项ID',
  `goods_id` int(11) NOT NULL COMMENT '商品ID',
  `goods_name` varchar(100) NOT NULL COMMENT '商品名称',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `goods_image` varchar(255) NOT NULL DEFAULT '' COMMENT '商品图片',
  `shop_id` int(11) NOT NULL COMMENT '店铺ID',
  `shop_name` varchar(100) NOT NULL COMMENT '店铺名称',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '评价内容',
  `image` varchar(1000) NOT NULL DEFAULT '' COMMENT '评价图片',
  `explain_first` varchar(255) NOT NULL DEFAULT '' COMMENT '解释内容',
  `member_name` varchar(100) NOT NULL DEFAULT '' COMMENT '评价人名称',
  `uid` int(11) NOT NULL COMMENT '评价人编号',
  `is_anonymous` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0表示不是 1表示是匿名评价',
  `scores` tinyint(1) NOT NULL COMMENT '1-5分',
  `again_content` varchar(255) NOT NULL DEFAULT '' COMMENT '追加评价内容',
  `again_image` varchar(1000) NOT NULL DEFAULT '' COMMENT '追评评价图片',
  `again_explain` varchar(255) NOT NULL DEFAULT '' COMMENT '追加解释内容',
  `explain_type` int(11) DEFAULT '0' COMMENT '1好评2中评3差评',
  `is_show` int(1) DEFAULT '1' COMMENT '1显示 0隐藏',
  `addtime` int(11) DEFAULT '0' COMMENT '评价时间',
  `again_addtime` int(11) DEFAULT '0' COMMENT '追加评价时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1489 COMMENT='商品评价表';

-- ----------------------------
-- Records of ns_goods_evaluate
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_floor`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_floor`;
CREATE TABLE `ns_goods_floor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `instance_id` int(11) NOT NULL DEFAULT '1' COMMENT '实例ID',
  `value` text,
  `is_use` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否启用 1启用 0不启用',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `name` varchar(50) NOT NULL DEFAULT '',
  `pc_template` varchar(255) NOT NULL DEFAULT '' COMMENT 'PC端模板',
  `block_template` varchar(255) NOT NULL DEFAULT '' COMMENT '楼层模板',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=963 COMMENT='商品楼层';

-- ----------------------------
-- Records of ns_goods_floor
-- ----------------------------
INSERT INTO `ns_goods_floor` VALUES ('1', '0', '{\"text\":{\"left_title\":{},\"sub_title\":{},\"jieri\":{},\"jianquan\":{}},\"adv\":{\"left_adv\":{}},\"product\":{\"middle\":{\"product_source\":\"product_category\",\"source_value\":\"1\",\"page_size\":\"111\"}},\"product_category\":{\"top_category\":{}},\"brand\":{}}', '1', '1555481688', '0', '0', '测试', 'default', 'style_1.html');

-- ----------------------------
-- Table structure for `ns_goods_group`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_group`;
CREATE TABLE `ns_goods_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `group_name` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级id 最多2级',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '级别',
  `is_visible` int(1) NOT NULL DEFAULT '1' COMMENT '是否可视',
  `group_pic` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',
  `sort` int(11) DEFAULT NULL,
  `group_dec` varchar(500) NOT NULL DEFAULT '' COMMENT '标签描述',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=160 COMMENT='商品本店分类';

-- ----------------------------
-- Records of ns_goods_group
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_ladder_preferential`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_ladder_preferential`;
CREATE TABLE `ns_goods_ladder_preferential` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `goods_id` int(11) NOT NULL COMMENT '商品关联id',
  `quantity` int(11) NOT NULL COMMENT '数量',
  `price` decimal(10,2) NOT NULL COMMENT '优惠价格',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2730 COMMENT='商品阶梯优惠';

-- ----------------------------
-- Records of ns_goods_ladder_preferential
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_member_discount`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_member_discount`;
CREATE TABLE `ns_goods_member_discount` (
  `discount_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '折扣id',
  `level_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员级别',
  `goods_id` text NOT NULL COMMENT '商品id',
  `discount` int(2) NOT NULL DEFAULT '1' COMMENT '折扣',
  `decimal_reservation_number` int(2) NOT NULL DEFAULT '-1' COMMENT '价格保留方式 0去掉角和分 1去掉分',
  PRIMARY KEY (`discount_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1365 COMMENT='商品会员折扣';

-- ----------------------------
-- Records of ns_goods_member_discount
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_promotion`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_promotion`;
CREATE TABLE `ns_goods_promotion` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `label` varchar(255) NOT NULL DEFAULT '' COMMENT '商品优惠活动标签',
  `remark` varchar(2000) NOT NULL DEFAULT '' COMMENT '商品优惠活动描述',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '活动状态',
  `is_all` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否全场(全场活动产品id为0，单品活动无全场)',
  `promotion_addon` varchar(255) NOT NULL DEFAULT '' COMMENT '活动插件',
  `promotion_id` int(11) NOT NULL DEFAULT '0' COMMENT '活动id',
  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `is_goods_promotion` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否是针对产品单价活动',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=364 COMMENT='商品优惠活动列表';

-- ----------------------------
-- Records of ns_goods_promotion
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_sku`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_sku`;
CREATE TABLE `ns_goods_sku` (
  `sku_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '表序号',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品编号',
  `sku_name` varchar(500) NOT NULL DEFAULT '' COMMENT 'SKU名称',
  `attr_value_items` varchar(255) NOT NULL DEFAULT '' COMMENT '属性和属性值 id串 attribute + attribute value 表ID分号分隔',
  `attr_value_items_format` varchar(500) NOT NULL DEFAULT '' COMMENT '属性和属性值id串组合json格式',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `promote_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `cost_price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '成本价',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `picture` int(11) NOT NULL DEFAULT '0' COMMENT '如果是第一个sku编码, 可以加图片',
  `code` varchar(255) NOT NULL DEFAULT '' COMMENT '商家编码',
  `QRcode` varchar(255) NOT NULL DEFAULT '' COMMENT '商品二维码',
  `create_date` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_date` int(11) DEFAULT '0' COMMENT '修改时间',
  `weight` int(11) NOT NULL DEFAULT '0' COMMENT '重量 kg',
  `volume` int(11) NOT NULL DEFAULT '0' COMMENT '体积 m³',
  `sku_img_array` varchar(255) NOT NULL DEFAULT '' COMMENT 'sku图片序列',
  PRIMARY KEY (`sku_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=481 COMMENT='商品skui规格价格库存信息表';

-- ----------------------------
-- Records of ns_goods_sku
-- ----------------------------
INSERT INTO `ns_goods_sku` VALUES ('6', '2', '', '', '', '0.00', '200.00', '200.00', '100.00', '106', '0', '', '', '0', '1555641133', '0', '0', '');
INSERT INTO `ns_goods_sku` VALUES ('7', '1', '', '', '', '111.00', '300.00', '300.00', '100.00', '219', '0', '', '', '0', '1555641138', '0', '0', '');
INSERT INTO `ns_goods_sku` VALUES ('9', '3', '', '', '', '0.00', '500.00', '500.00', '100.00', '108', '0', '', '', '0', '1555641115', '0', '0', '');

-- ----------------------------
-- Table structure for `ns_goods_sku_deleted`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_sku_deleted`;
CREATE TABLE `ns_goods_sku_deleted` (
  `sku_id` int(11) NOT NULL DEFAULT '0' COMMENT '表序号',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品编号',
  `sku_name` varchar(500) NOT NULL DEFAULT '' COMMENT 'SKU名称',
  `attr_value_items` varchar(255) NOT NULL DEFAULT '' COMMENT '属性和属性值 id串 attribute + attribute value 表ID分号分隔',
  `attr_value_items_format` varchar(500) NOT NULL DEFAULT '' COMMENT '属性和属性值id串组合json格式',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `promote_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `cost_price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '成本价',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `picture` int(11) NOT NULL DEFAULT '0' COMMENT '如果是第一个sku编码, 可以加图片',
  `code` varchar(255) NOT NULL DEFAULT '' COMMENT '商家编码',
  `QRcode` varchar(255) NOT NULL DEFAULT '' COMMENT '商品二维码',
  `create_date` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_date` int(11) DEFAULT '0' COMMENT '修改时间',
  `weight` int(11) NOT NULL DEFAULT '0' COMMENT '重量 kg',
  `volume` int(11) NOT NULL DEFAULT '0' COMMENT '体积 m³'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1638 COMMENT='商品skui规格价格库存信息回收站表';

-- ----------------------------
-- Records of ns_goods_sku_deleted
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_sku_picture`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_sku_picture`;
CREATE TABLE `ns_goods_sku_picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `spec_id` int(11) NOT NULL DEFAULT '0' COMMENT '主规格id',
  `spec_value_id` int(11) NOT NULL DEFAULT '0' COMMENT '规格值id',
  `sku_img_array` varchar(1000) NOT NULL DEFAULT '' COMMENT '图片id 多个用逗号隔开',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4096 COMMENT='商品sku多图';

-- ----------------------------
-- Records of ns_goods_sku_picture
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_sku_picture_delete`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_sku_picture_delete`;
CREATE TABLE `ns_goods_sku_picture_delete` (
  `id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `spec_id` int(11) NOT NULL DEFAULT '0' COMMENT '主规格id',
  `spec_value_id` int(11) NOT NULL DEFAULT '0' COMMENT '规格值id',
  `sku_img_array` varchar(1000) NOT NULL DEFAULT '' COMMENT '图片id 多个用逗号隔开',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4096 COMMENT='商品sku多图';

-- ----------------------------
-- Records of ns_goods_sku_picture_delete
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_spec`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_spec`;
CREATE TABLE `ns_goods_spec` (
  `spec_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '属性ID',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `spec_name` varchar(255) NOT NULL DEFAULT '' COMMENT '属性名称',
  `is_visible` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可视',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `show_type` int(11) NOT NULL DEFAULT '1' COMMENT '展示方式 1 文字 2 颜色 3 图片',
  `create_time` int(11) DEFAULT '0' COMMENT '创建日期',
  `is_screen` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否参与筛选 0 不参与 1 参与',
  `spec_des` varchar(255) NOT NULL DEFAULT '' COMMENT '属性说明',
  `goods_id` int(11) DEFAULT '0' COMMENT '商品关联id',
  PRIMARY KEY (`spec_id`),
  KEY `IDX_category_props_categoryId` (`shop_id`),
  KEY `IDX_category_props_orders` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=3276 COMMENT='商品属性（规格）表';

-- ----------------------------
-- Records of ns_goods_spec
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_goods_spec_value`
-- ----------------------------
DROP TABLE IF EXISTS `ns_goods_spec_value`;
CREATE TABLE `ns_goods_spec_value` (
  `spec_value_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品属性值ID',
  `spec_id` int(11) NOT NULL COMMENT '商品属性ID',
  `spec_value_name` varchar(255) NOT NULL DEFAULT '' COMMENT '商品属性值名称',
  `spec_value_data` varchar(255) NOT NULL DEFAULT '' COMMENT '商品属性值数据',
  `is_visible` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可视',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(11) DEFAULT '0',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  PRIMARY KEY (`spec_value_id`),
  KEY `IDX_category_propvalues_c_pId` (`spec_id`),
  KEY `IDX_category_propvalues_orders` (`sort`),
  KEY `IDX_category_propvalues_value` (`spec_value_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1092 COMMENT='商品规格值模版表';

-- ----------------------------
-- Records of ns_goods_spec_value
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_member`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member`;
CREATE TABLE `ns_member` (
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `member_name` varchar(50) NOT NULL DEFAULT '' COMMENT '前台用户名',
  `member_level` int(11) NOT NULL DEFAULT '0' COMMENT '会员等级',
  `member_label` varchar(255) NOT NULL DEFAULT '' COMMENT '会员标签',
  `memo` varchar(1000) DEFAULT NULL COMMENT '备注',
  `reg_time` int(11) DEFAULT '0' COMMENT '注册时间',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=147 COMMENT='前台用户表';

-- ----------------------------
-- Records of ns_member
-- ----------------------------
INSERT INTO `ns_member` VALUES ('3', 'admin', '2', '', '', '2019');
INSERT INTO `ns_member` VALUES ('4', 'mtvjiao', '2', '', null, '1555394711');
INSERT INTO `ns_member` VALUES ('5', 'mtvjiao1', '2', '1', null, '1555395810');
INSERT INTO `ns_member` VALUES ('6', 'ceshi', '2', '', null, '1555568817');
INSERT INTO `ns_member` VALUES ('7', '123123', '2', '', null, '1555569340');
INSERT INTO `ns_member` VALUES ('8', 'qweqwe', '2', '', null, '1555569416');

-- ----------------------------
-- Table structure for `ns_member_account`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member_account`;
CREATE TABLE `ns_member_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '会员uid',
  `shop_id` int(11) NOT NULL COMMENT '店铺ID',
  `point` int(11) NOT NULL DEFAULT '0' COMMENT '会员积分',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `coin` int(11) NOT NULL DEFAULT '0' COMMENT '购物币',
  `member_cunsum` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员消费',
  `member_sum_point` int(11) NOT NULL DEFAULT '0' COMMENT '会员累计积分',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=3276 COMMENT='会员账户统计表';

-- ----------------------------
-- Records of ns_member_account
-- ----------------------------
INSERT INTO `ns_member_account` VALUES ('2', '8', '0', '0', '107900.00', '0', '3211.00', '0');
INSERT INTO `ns_member_account` VALUES ('3', '4', '0', '0', '500.00', '0', '0.00', '0');

-- ----------------------------
-- Table structure for `ns_member_account_records`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member_account_records`;
CREATE TABLE `ns_member_account_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `account_type` int(11) NOT NULL DEFAULT '1' COMMENT '账户类型1.积分2.余额3.购物币',
  `sign` smallint(6) NOT NULL DEFAULT '1' COMMENT '正负号',
  `number` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '数量',
  `from_type` smallint(6) NOT NULL DEFAULT '0' COMMENT '产生方式1.商城订单2.订单退还3.兑换4.充值5.签到6.分享7.注册8.提现9提现退还',
  `data_id` int(11) NOT NULL DEFAULT '0' COMMENT '相关表的数据ID',
  `text` varchar(255) NOT NULL DEFAULT '' COMMENT '数据相关内容描述文本',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=108 COMMENT='会员流水账表';

-- ----------------------------
-- Records of ns_member_account_records
-- ----------------------------
INSERT INTO `ns_member_account_records` VALUES ('1', '4', '0', '2', '1', '5000.00', '10', '0', '', '1555490075');
INSERT INTO `ns_member_account_records` VALUES ('2', '4', '0', '2', '0', '-222.00', '1', '0', '商城订单', '1555490120');
INSERT INTO `ns_member_account_records` VALUES ('3', '8', '0', '2', '1', '111111.00', '10', '0', '', '1555571064');
INSERT INTO `ns_member_account_records` VALUES ('4', '8', '0', '2', '0', '-111.00', '1', '0', '商城订单', '1555576350');
INSERT INTO `ns_member_account_records` VALUES ('5', '8', '0', '2', '0', '-700.00', '1', '0', '商城订单', '1555652966');
INSERT INTO `ns_member_account_records` VALUES ('6', '8', '0', '2', '0', '-500.00', '1', '0', '商城订单', '1555657654');
INSERT INTO `ns_member_account_records` VALUES ('7', '8', '0', '2', '0', '-200.00', '1', '0', '商城订单', '1555986423');
INSERT INTO `ns_member_account_records` VALUES ('8', '8', '0', '2', '0', '-300.00', '1', '0', '商城订单', '1555997473');
INSERT INTO `ns_member_account_records` VALUES ('9', '8', '0', '2', '0', '-200.00', '1', '0', '商城订单', '1555997509');
INSERT INTO `ns_member_account_records` VALUES ('10', '8', '0', '2', '0', '-300.00', '1', '0', '商城订单', '1555998174');
INSERT INTO `ns_member_account_records` VALUES ('11', '8', '0', '2', '0', '-200.00', '1', '0', '商城订单', '1556004852');
INSERT INTO `ns_member_account_records` VALUES ('12', '8', '0', '2', '0', '-500.00', '1', '0', '商城订单', '1556005326');
INSERT INTO `ns_member_account_records` VALUES ('13', '8', '0', '2', '1', '300.00', '2', '5', '订单退款', '1556005384');
INSERT INTO `ns_member_account_records` VALUES ('14', '8', '0', '2', '0', '-500.00', '1', '0', '商城订单', '1556005943');
INSERT INTO `ns_member_account_records` VALUES ('15', '8', '0', '2', '1', '500.00', '2', '6', '订单退款', '1556006088');
INSERT INTO `ns_member_account_records` VALUES ('16', '8', '0', '2', '0', '-1000.00', '1', '0', '商城订单', '1556007750');
INSERT INTO `ns_member_account_records` VALUES ('17', '8', '0', '2', '1', '500.00', '2', '7', '订单退款', '1556007888');
INSERT INTO `ns_member_account_records` VALUES ('18', '4', '0', '2', '1', '5000.00', '10', '0', '佣金转余额', '1556097113');
INSERT INTO `ns_member_account_records` VALUES ('19', '4', '0', '2', '1', '5000.00', '10', '0', '佣金转余额', '1556097309');
INSERT INTO `ns_member_account_records` VALUES ('20', '4', '0', '2', '1', '500.00', '10', '0', '佣金转余额', '1556097354');

-- ----------------------------
-- Table structure for `ns_member_balance_withdraw`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member_balance_withdraw`;
CREATE TABLE `ns_member_balance_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL COMMENT '店铺编号',
  `withdraw_no` varchar(255) NOT NULL DEFAULT '' COMMENT '提现流水号',
  `uid` int(11) NOT NULL COMMENT '会员id',
  `bank_name` varchar(50) NOT NULL COMMENT '提现银行名称',
  `account_number` varchar(50) NOT NULL COMMENT '提现银行账号',
  `realname` varchar(10) NOT NULL COMMENT '提现账户姓名',
  `mobile` varchar(20) NOT NULL COMMENT '手机',
  `cash` decimal(10,2) NOT NULL COMMENT '提现金额',
  `status` smallint(6) NOT NULL DEFAULT '0' COMMENT '当前状态 0已申请(等待处理) 1已同意 -1 已拒绝',
  `memo` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `ask_for_date` int(11) DEFAULT '0' COMMENT '提现日期',
  `payment_date` int(11) DEFAULT '0' COMMENT '到账日期',
  `modify_date` int(11) DEFAULT '0' COMMENT '修改日期',
  `transfer_type` int(11) NOT NULL DEFAULT '1' COMMENT '转账方式   1 线下转账  2线上转账',
  `transfer_name` varchar(50) NOT NULL DEFAULT '' COMMENT '转账银行名称',
  `transfer_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '转账金额',
  `transfer_status` int(11) DEFAULT '0' COMMENT '转账状态 0未转账 1已转账 -1转账失败',
  `transfer_remark` varchar(255) DEFAULT '' COMMENT '转账备注',
  `transfer_result` varchar(255) DEFAULT '' COMMENT '转账结果',
  `transfer_no` varchar(255) DEFAULT '' COMMENT '转账流水号',
  `transfer_account_no` varchar(255) DEFAULT '' COMMENT '转账银行账号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4096 COMMENT='会员余额提现记录表';

-- ----------------------------
-- Records of ns_member_balance_withdraw
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_member_bank_account`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member_bank_account`;
CREATE TABLE `ns_member_bank_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '会员id',
  `branch_bank_name` varchar(50) DEFAULT NULL COMMENT '支行信息',
  `realname` varchar(50) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `account_number` varchar(50) NOT NULL DEFAULT '' COMMENT '银行账号',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  `is_default` int(11) NOT NULL DEFAULT '0' COMMENT '是否默认账号',
  `create_date` int(11) DEFAULT '0' COMMENT '创建日期',
  `modify_date` int(11) DEFAULT '0' COMMENT '修改日期',
  `account_type` int(11) DEFAULT '1' COMMENT '账户类型，1：银行卡，2：微信，3：支付宝',
  `account_type_name` varchar(30) DEFAULT '银行卡' COMMENT '账户类型名称：银行卡，微信，支付宝',
  PRIMARY KEY (`id`),
  KEY `IDX_member_bank_account_uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='会员提现账号';

-- ----------------------------
-- Records of ns_member_bank_account
-- ----------------------------
INSERT INTO `ns_member_bank_account` VALUES ('1', '8', '', '123', '123123', '13566568956', '1', '1556008735', '1556008735', '3', '支付宝');

-- ----------------------------
-- Table structure for `ns_member_behavior_records`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member_behavior_records`;
CREATE TABLE `ns_member_behavior_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '会员id',
  `type` varchar(255) DEFAULT NULL COMMENT '行为操作：1 签到 2 点赞 3 分享 4 评论',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2048 COMMENT='会员行为记录表';

-- ----------------------------
-- Records of ns_member_behavior_records
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_member_express_address`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member_express_address`;
CREATE TABLE `ns_member_express_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '会员基本资料表ID',
  `consigner` varchar(255) NOT NULL DEFAULT '' COMMENT '收件人',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机',
  `phone` varchar(20) NOT NULL DEFAULT '' COMMENT '固定电话',
  `province` int(11) NOT NULL DEFAULT '0' COMMENT '省',
  `city` int(11) NOT NULL DEFAULT '0' COMMENT '市',
  `district` int(11) NOT NULL DEFAULT '0' COMMENT '区县',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `zip_code` varchar(6) NOT NULL DEFAULT '' COMMENT '邮编',
  `alias` varchar(50) NOT NULL DEFAULT '' COMMENT '地址别名',
  `is_default` int(11) NOT NULL DEFAULT '0' COMMENT '默认收货地址',
  PRIMARY KEY (`id`),
  KEY `IDX_member_express_address_uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2340 COMMENT='会员收货地址管理';

-- ----------------------------
-- Records of ns_member_express_address
-- ----------------------------
INSERT INTO `ns_member_express_address` VALUES ('1', '4', '爱爱爱', '13388556699', '', '1', '1', '17', '大楼111', '', '', '1');
INSERT INTO `ns_member_express_address` VALUES ('2', '8', '123', '15266666888', '', '19', '210', '1838', '大楼111', '', '', '1');

-- ----------------------------
-- Table structure for `ns_member_favorites`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member_favorites`;
CREATE TABLE `ns_member_favorites` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '记录ID',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `fav_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品或店铺ID',
  `fav_type` varchar(20) NOT NULL DEFAULT 'goods' COMMENT '类型:goods为商品,shop为店铺,默认为商品',
  `shop_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `shop_name` varchar(20) NOT NULL DEFAULT '' COMMENT '店铺名称',
  `shop_logo` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺logo',
  `goods_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_image` varchar(300) DEFAULT NULL,
  `log_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品收藏时价格',
  `log_msg` varchar(1000) NOT NULL DEFAULT '' COMMENT '收藏备注',
  `fav_time` int(11) DEFAULT '0' COMMENT '收藏时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='收藏表';

-- ----------------------------
-- Records of ns_member_favorites
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_member_gift`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member_gift`;
CREATE TABLE `ns_member_gift` (
  `gift_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `promotion_gift_id` int(11) NOT NULL COMMENT '赠品活动ID',
  `goods_id` int(11) NOT NULL COMMENT '赠品ID',
  `goods_name` varchar(255) NOT NULL DEFAULT '' COMMENT '赠品名称',
  `goods_picture` int(11) NOT NULL DEFAULT '0' COMMENT '赠品图片',
  `num` int(11) NOT NULL DEFAULT '1' COMMENT '赠品数量',
  `get_type` int(11) NOT NULL DEFAULT '1' COMMENT '获取方式',
  `get_type_id` int(11) NOT NULL COMMENT '获取方式对应ID',
  `desc` text NOT NULL COMMENT '说明',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`gift_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员赠品表';

-- ----------------------------
-- Records of ns_member_gift
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_member_label`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member_label`;
CREATE TABLE `ns_member_label` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '标签id',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `label_name` varchar(50) NOT NULL DEFAULT '' COMMENT '标签名称',
  `desc` varchar(255) NOT NULL DEFAULT '' COMMENT '标签描述',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='会员标签';

-- ----------------------------
-- Records of ns_member_label
-- ----------------------------
INSERT INTO `ns_member_label` VALUES ('1', '0', '允许开店', '', '1555397760');

-- ----------------------------
-- Table structure for `ns_member_level`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member_level`;
CREATE TABLE `ns_member_level` (
  `level_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '等级ID',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `level_name` varchar(50) NOT NULL DEFAULT '' COMMENT '等级名称',
  `min_integral` int(11) NOT NULL DEFAULT '0' COMMENT '累计积分',
  `goods_discount` decimal(3,2) NOT NULL DEFAULT '1.00' COMMENT '折扣率',
  `desc` varchar(1000) NOT NULL DEFAULT '' COMMENT '等级描述',
  `is_default` int(11) NOT NULL DEFAULT '0' COMMENT '是否是默认',
  `quota` int(11) NOT NULL DEFAULT '0' COMMENT '消费额度',
  `upgrade` int(11) NOT NULL DEFAULT '1' COMMENT '升级条件  1.累计积分 2.消费额度 3.同时满足',
  `relation` int(11) NOT NULL DEFAULT '1' COMMENT '1.或 2. 且',
  `buy_goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '购买商品id',
  `order_num` int(11) NOT NULL DEFAULT '0' COMMENT '购买量',
  `give_coupon` varchar(255) NOT NULL DEFAULT '' COMMENT '赠送优惠券  优惠券id:数量,优惠券id:数量',
  `give_point` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '赠送积分',
  `give_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '赠送余额',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '等级排序',
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='会员等级';

-- ----------------------------
-- Records of ns_member_level
-- ----------------------------
INSERT INTO `ns_member_level` VALUES ('2', '0', '普通会员', '0', '1.00', '', '1', '0', '1', '1', '0', '0', '', '0.00', '0.00', '0');

-- ----------------------------
-- Table structure for `ns_member_level_records`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member_level_records`;
CREATE TABLE `ns_member_level_records` (
  `records_id` int(11) NOT NULL AUTO_INCREMENT,
  `level_id` int(11) NOT NULL COMMENT '升级等级id',
  `level` int(11) NOT NULL COMMENT '升级级别',
  `level_name` varchar(50) NOT NULL DEFAULT '' COMMENT '等级名称',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`records_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2048 COMMENT='会员升级记录表';

-- ----------------------------
-- Records of ns_member_level_records
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_member_recharge`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member_recharge`;
CREATE TABLE `ns_member_recharge` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recharge_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `uid` varchar(255) NOT NULL COMMENT '用户uid',
  `out_trade_no` varchar(255) NOT NULL DEFAULT '' COMMENT '支付流水号',
  `create_time` varchar(255) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `is_pay` varchar(255) NOT NULL DEFAULT '0' COMMENT '是否支付',
  `status` varchar(255) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='会员充值余额记录';

-- ----------------------------
-- Records of ns_member_recharge
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_member_withdraw_setting`
-- ----------------------------
DROP TABLE IF EXISTS `ns_member_withdraw_setting`;
CREATE TABLE `ns_member_withdraw_setting` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(11) NOT NULL COMMENT '店铺id（单店版为0）',
  `withdraw_cash_min` decimal(10,2) NOT NULL COMMENT '最低提现金额',
  `withdraw_multiple` int(11) NOT NULL DEFAULT '0' COMMENT '提现倍数',
  `withdraw_poundage` int(100) DEFAULT '0' COMMENT '提现手续费比率',
  `withdraw_message` varchar(255) DEFAULT '' COMMENT '提现提示信息',
  `withdraw_account_type` varchar(255) DEFAULT NULL COMMENT '提现支持账号（目前只有银联卡）',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='会员提现设置';

-- ----------------------------
-- Records of ns_member_withdraw_setting
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_notice`
-- ----------------------------
DROP TABLE IF EXISTS `ns_notice`;
CREATE TABLE `ns_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '公告id',
  `notice_title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `notice_content` text NOT NULL COMMENT '公告内容',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='店铺公告表';

-- ----------------------------
-- Records of ns_notice
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_o2o_distribution_area`
-- ----------------------------
DROP TABLE IF EXISTS `ns_o2o_distribution_area`;
CREATE TABLE `ns_o2o_distribution_area` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '门店或者店铺id',
  `province_id` text COMMENT '省id',
  `city_id` text COMMENT '市id',
  `district_id` text COMMENT '区县id',
  `community_id` text COMMENT '社区乡镇id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配送区域管理';

-- ----------------------------
-- Records of ns_o2o_distribution_area
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_o2o_distribution_config`
-- ----------------------------
DROP TABLE IF EXISTS `ns_o2o_distribution_config`;
CREATE TABLE `ns_o2o_distribution_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '门店或者店铺id',
  `order_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `freight` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费',
  `is_start` int(11) NOT NULL DEFAULT '0' COMMENT '是否是起步价',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='配送费用设置';

-- ----------------------------
-- Records of ns_o2o_distribution_config
-- ----------------------------
INSERT INTO `ns_o2o_distribution_config` VALUES ('1', '0', '0.00', '0.00', '0');

-- ----------------------------
-- Table structure for `ns_o2o_distribution_user`
-- ----------------------------
DROP TABLE IF EXISTS `ns_o2o_distribution_user`;
CREATE TABLE `ns_o2o_distribution_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '配送人员姓名',
  `mobile` varchar(255) NOT NULL DEFAULT '' COMMENT '配送人员电话',
  `remark` text COMMENT '配送人员备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='配送人员管理';

-- ----------------------------
-- Records of ns_o2o_distribution_user
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_o2o_order_delivery`
-- ----------------------------
DROP TABLE IF EXISTS `ns_o2o_order_delivery`;
CREATE TABLE `ns_o2o_order_delivery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `express_no` varchar(255) NOT NULL DEFAULT '' COMMENT '订单编号',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `order_delivery_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '配送人员id',
  `order_delivery_user_name` varchar(255) NOT NULL DEFAULT '' COMMENT '配送人员姓名',
  `order_delivery_user_mobile` varchar(255) NOT NULL DEFAULT '' COMMENT '配送人员电话',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `remark` text NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='o2o订单配送';

-- ----------------------------
-- Records of ns_o2o_order_delivery
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_offpay_area`
-- ----------------------------
DROP TABLE IF EXISTS `ns_offpay_area`;
CREATE TABLE `ns_offpay_area` (
  `shop_id` int(11) DEFAULT NULL COMMENT '店铺Id',
  `province_id` text COMMENT '省Id组合',
  `city_id` text COMMENT '市Id组合',
  `district_id` text COMMENT '县Id组合'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='货到付款支持地区表';

-- ----------------------------
-- Records of ns_offpay_area
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_order`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order`;
CREATE TABLE `ns_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `order_no` varchar(255) DEFAULT '' COMMENT '订单编号',
  `out_trade_no` varchar(100) NOT NULL DEFAULT '0' COMMENT '外部交易号',
  `order_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '订单类型',
  `payment_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付类型。取值范围：\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\nWEIXIN (微信自有支付)\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\nWEIXIN_DAIXIAO (微信代销支付)\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\nALIPAY (支付宝支付)',
  `shipping_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '订单配送方式',
  `order_from` varchar(255) NOT NULL DEFAULT '' COMMENT '订单来源',
  `buyer_id` int(11) NOT NULL COMMENT '买家id',
  `user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '买家会员名称',
  `buyer_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '买家ip',
  `buyer_message` varchar(255) NOT NULL DEFAULT '' COMMENT '买家附言',
  `buyer_invoice` varchar(255) NOT NULL DEFAULT '' COMMENT '买家发票信息',
  `receiver_mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '收货人的手机号码',
  `receiver_province` int(11) NOT NULL COMMENT '收货人所在省',
  `receiver_city` int(11) NOT NULL COMMENT '收货人所在城市',
  `receiver_district` int(11) NOT NULL COMMENT '收货人所在街道',
  `receiver_address` varchar(255) NOT NULL DEFAULT '' COMMENT '收货人详细地址',
  `receiver_zip` varchar(6) NOT NULL DEFAULT '' COMMENT '收货人邮编',
  `receiver_name` varchar(50) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `shop_id` int(11) NOT NULL COMMENT '卖家店铺id',
  `shop_name` varchar(100) NOT NULL DEFAULT '' COMMENT '卖家店铺名称',
  `seller_star` tinyint(4) NOT NULL DEFAULT '0' COMMENT '卖家对订单的标注星标',
  `seller_memo` varchar(255) NOT NULL DEFAULT '' COMMENT '卖家对订单的备注',
  `consign_time_adjust` int(11) NOT NULL DEFAULT '0' COMMENT '卖家延迟发货时间',
  `goods_money` decimal(19,2) NOT NULL COMMENT '商品总价',
  `order_money` decimal(10,2) NOT NULL COMMENT '订单总价',
  `point` int(11) NOT NULL COMMENT '订单消耗积分',
  `point_money` decimal(10,2) NOT NULL COMMENT '订单消耗积分抵多少钱',
  `coupon_money` decimal(10,2) NOT NULL COMMENT '订单代金券支付金额',
  `coupon_id` int(11) NOT NULL COMMENT '订单代金券id',
  `user_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单余额支付金额',
  `user_platform_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '用户平台余额支付',
  `promotion_money` decimal(10,2) NOT NULL COMMENT '订单优惠活动金额',
  `shipping_money` decimal(10,2) NOT NULL COMMENT '订单运费',
  `pay_money` decimal(10,2) NOT NULL COMMENT '订单实付金额',
  `refund_money` decimal(10,2) NOT NULL COMMENT '订单退款金额',
  `coin_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '购物币金额',
  `give_point` int(11) NOT NULL COMMENT '订单赠送积分',
  `give_coin` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单成功之后返购物币',
  `order_status` tinyint(4) NOT NULL COMMENT '订单状态',
  `pay_status` tinyint(4) NOT NULL COMMENT '订单付款状态',
  `shipping_status` tinyint(4) NOT NULL COMMENT '订单配送状态',
  `review_status` tinyint(4) NOT NULL COMMENT '订单评价状态',
  `feedback_status` tinyint(4) NOT NULL COMMENT '订单维权状态',
  `is_evaluate` smallint(6) NOT NULL DEFAULT '0' COMMENT '是否评价 0为未评价 1为已评价 2为已追评',
  `tax_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping_company_id` int(11) NOT NULL DEFAULT '0' COMMENT '配送物流公司ID',
  `give_point_type` int(11) NOT NULL DEFAULT '1' COMMENT '积分返还类型 1 订单完成  2 订单收货 3  支付订单',
  `pay_time` int(11) DEFAULT '0' COMMENT '订单付款时间',
  `shipping_time` int(11) DEFAULT '0' COMMENT '买家要求配送时间',
  `sign_time` int(11) DEFAULT '0' COMMENT '买家签收时间',
  `consign_time` int(11) DEFAULT '0' COMMENT '卖家发货时间',
  `create_time` int(11) DEFAULT '0' COMMENT '订单创建时间',
  `finish_time` int(11) DEFAULT '0' COMMENT '订单完成时间',
  `is_deleted` int(1) NOT NULL DEFAULT '0' COMMENT '订单是否已删除',
  `operator_type` int(1) NOT NULL DEFAULT '0' COMMENT '操作人类型  1店铺  2用户',
  `operator_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作人id',
  `refund_balance_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单退款余额',
  `fixed_telephone` varchar(50) NOT NULL DEFAULT '' COMMENT '固定电话',
  `tuangou_group_id` int(11) NOT NULL DEFAULT '0' COMMENT '拼团id',
  `distribution_time_out` varchar(50) NOT NULL DEFAULT '' COMMENT '配送时间段',
  `is_virtual` int(11) NOT NULL DEFAULT '0' COMMENT '是否包含 虚拟商品   0 不包含  1  包含',
  `promotion_type` int(11) NOT NULL DEFAULT '0' COMMENT '营销活动类型',
  `promotion_id` int(11) NOT NULL DEFAULT '0' COMMENT '营销活动id',
  `par_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `UK_ns_order` (`buyer_id`,`order_no`,`order_status`,`pay_status`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=440 COMMENT='订单表';

-- ----------------------------
-- Records of ns_order
-- ----------------------------
INSERT INTO `ns_order` VALUES ('1', '2019042315310001', '155600472012651000', '1', '1', '1', '2', '8', 'qweqwe', '127.0.0.1', '', '', '15266666888', '19', '210', '1838', '广东省&nbsp;河源市&nbsp;紫金县&nbsp;大楼111', '', '123', '0', 'Niushop开源商城', '0', '', '0', '1000.00', '1000.00', '0', '0.00', '0.00', '0', '0.00', '0.00', '0.00', '0.00', '1000.00', '0.00', '0.00', '0', '0.00', '5', '0', '0', '0', '0', '0', '0.00', '0', '2', '0', '0', '0', '0', '1556004667', '0', '1', '2', '8', '0.00', '', '0', '07:00-09:0010:00-12:00', '0', '0', '0', '4');
INSERT INTO `ns_order` VALUES ('2', '2019042315320001', '155600491124551000', '1', '1', '1', '2', '8', 'qweqwe', '127.0.0.1', '', '', '15266666888', '19', '210', '1838', '广东省&nbsp;河源市&nbsp;紫金县&nbsp;大楼111', '', '123', '0', 'Niushop开源商城', '0', '', '0', '300.00', '300.00', '0', '0.00', '0.00', '0', '0.00', '0.00', '0.00', '0.00', '300.00', '0.00', '0.00', '0', '0.00', '5', '0', '0', '0', '0', '0', '0.00', '0', '2', '0', '0', '0', '0', '1556004766', '0', '0', '0', '0', '0.00', '', '0', '07:00-09:0010:00-12:00', '0', '0', '0', '4');
INSERT INTO `ns_order` VALUES ('3', '2019042315330001', '155600492857791000', '1', '1', '1', '2', '8', 'qweqwe', '127.0.0.1', '', '', '15266666888', '19', '210', '1838', '广东省&nbsp;河源市&nbsp;紫金县&nbsp;大楼111', '', '123', '0', 'Niushop开源商城', '0', '', '0', '200.00', '200.00', '0', '0.00', '0.00', '0', '0.00', '0.00', '0.00', '0.00', '200.00', '0.00', '0.00', '0', '0.00', '5', '0', '0', '0', '0', '0', '0.00', '0', '2', '0', '0', '0', '0', '1556004797', '0', '0', '0', '0', '0.00', '', '0', '07:00-09:0010:00-12:00', '0', '0', '0', '4');
INSERT INTO `ns_order` VALUES ('4', '2019042315330002', '155600483433871000', '1', '5', '1', '2', '8', 'qweqwe', '127.0.0.1', '', '', '15266666888', '19', '210', '1838', '广东省&nbsp;河源市&nbsp;紫金县&nbsp;大楼111', '', '123', '0', 'Niushop开源商城', '0', '', '0', '200.00', '200.00', '0', '0.00', '0.00', '0', '0.00', '200.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '4', '2', '2', '0', '0', '0', '0.00', '0', '2', '1556004852', '0', '1556005027', '1556004964', '1556004834', '1556005251', '0', '0', '0', '0.00', '', '0', '07:00-09:0010:00-12:00', '0', '0', '0', '4');
INSERT INTO `ns_order` VALUES ('5', '2019042315420001', '155600532245161000', '1', '5', '1', '2', '8', 'qweqwe', '127.0.0.1', '', '', '15266666888', '19', '210', '1838', '广东省&nbsp;河源市&nbsp;紫金县&nbsp;大楼111', '', '123', '0', 'Niushop开源商城', '0', '', '0', '500.00', '500.00', '0', '0.00', '0.00', '0', '0.00', '500.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '4', '2', '2', '0', '0', '0', '0.00', '0', '2', '1556005325', '0', '1556005397', '1556005384', '1556005322', '1556005750', '0', '0', '0', '300.00', '', '0', '07:00-09:0010:00-12:00', '0', '0', '0', '4');
INSERT INTO `ns_order` VALUES ('6', '2019042315520001', '155600594014111000', '1', '5', '1', '2', '8', 'qweqwe', '127.0.0.1', '', '', '15266666888', '19', '210', '1838', '广东省&nbsp;河源市&nbsp;紫金县&nbsp;大楼111', '', '123', '0', 'Niushop开源商城', '0', '', '0', '500.00', '500.00', '0', '0.00', '0.00', '0', '0.00', '500.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '5', '2', '1', '0', '0', '0', '0.00', '0', '2', '1556005943', '0', '0', '1556005968', '1556005940', '0', '0', '0', '0', '500.00', '', '0', '07:00-09:0010:00-12:00', '0', '0', '0', '4');
INSERT INTO `ns_order` VALUES ('7', '2019042316220001', '155600774740601000', '1', '5', '1', '2', '8', 'qweqwe', '127.0.0.1', '', '', '15266666888', '19', '210', '1838', '广东省&nbsp;河源市&nbsp;紫金县&nbsp;大楼111', '', '123', '0', 'Niushop开源商城', '0', '', '0', '1000.00', '1000.00', '0', '0.00', '0.00', '0', '0.00', '1000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '4', '2', '2', '0', '0', '0', '0.00', '0', '2', '1556007749', '0', '1556007911', '1556007888', '1556007747', '1556008000', '0', '0', '0', '500.00', '', '0', '07:00-09:0010:00-12:00', '0', '0', '0', '4');

-- ----------------------------
-- Table structure for `ns_order_action`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_action`;
CREATE TABLE `ns_order_action` (
  `action_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '动作id',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `action` varchar(255) NOT NULL DEFAULT '' COMMENT '动作内容',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '操作人id',
  `user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '操作人',
  `order_status` int(11) NOT NULL COMMENT '订单大状态',
  `order_status_text` varchar(255) NOT NULL DEFAULT '' COMMENT '订单状态名称',
  `action_time` int(11) DEFAULT '0' COMMENT '操作时间',
  PRIMARY KEY (`action_id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1706 COMMENT='订单操作表';

-- ----------------------------
-- Records of ns_order_action
-- ----------------------------
INSERT INTO `ns_order_action` VALUES ('1', '1', '创建订单', '0', 'mtvjiao', '0', '待付款', '1555489980');
INSERT INTO `ns_order_action` VALUES ('2', '2', '创建订单', '0', 'mtvjiao', '0', '待付款', '1555490110');
INSERT INTO `ns_order_action` VALUES ('3', '2', '订单支付', '0', 'mtvjiao', '1', '待发货', '1555490120');
INSERT INTO `ns_order_action` VALUES ('4', '1', '订单交易关闭', '0', '', '5', '已关闭', '1555547673');
INSERT INTO `ns_order_action` VALUES ('5', '3', '创建订单', '0', 'qweqwe', '0', '待付款', '1555574298');
INSERT INTO `ns_order_action` VALUES ('6', '2', '订单发货', '0', 'admin', '2', '已发货', '1555575534');
INSERT INTO `ns_order_action` VALUES ('8', '2', '交易完成', '0', '', '4', '已完成', '1555575642');
INSERT INTO `ns_order_action` VALUES ('9', '3', '订单支付', '0', 'qweqwe', '1', '待发货', '1555576350');
INSERT INTO `ns_order_action` VALUES ('10', '3', '订单发货', '0', 'admin', '2', '已发货', '1555576371');
INSERT INTO `ns_order_action` VALUES ('11', '4', '创建订单', '0', 'qweqwe', '0', '待付款', '1555641919');
INSERT INTO `ns_order_action` VALUES ('12', '5', '创建订单', '0', 'qweqwe', '0', '待付款', '1555641965');
INSERT INTO `ns_order_action` VALUES ('13', '6', '创建订单', '0', 'qweqwe', '0', '待付款', '1555642097');
INSERT INTO `ns_order_action` VALUES ('14', '7', '创建订单', '0', 'qweqwe', '0', '待付款', '1555642155');
INSERT INTO `ns_order_action` VALUES ('15', '8', '创建订单', '0', 'qweqwe', '0', '待付款', '1555642171');
INSERT INTO `ns_order_action` VALUES ('16', '9', '创建订单', '0', 'qweqwe', '0', '待付款', '1555642205');
INSERT INTO `ns_order_action` VALUES ('17', '4', '订单交易关闭', '0', '', '5', '已关闭', '1555652031');
INSERT INTO `ns_order_action` VALUES ('18', '5', '订单交易关闭', '0', '', '5', '已关闭', '1555652031');
INSERT INTO `ns_order_action` VALUES ('19', '6', '订单交易关闭', '0', '', '5', '已关闭', '1555652031');
INSERT INTO `ns_order_action` VALUES ('20', '7', '订单交易关闭', '0', '', '5', '已关闭', '1555652031');
INSERT INTO `ns_order_action` VALUES ('21', '8', '订单交易关闭', '0', '', '5', '已关闭', '1555652032');
INSERT INTO `ns_order_action` VALUES ('22', '9', '订单交易关闭', '0', '', '5', '已关闭', '1555652032');
INSERT INTO `ns_order_action` VALUES ('23', '10', '创建订单', '0', 'qweqwe', '0', '待付款', '1555652078');
INSERT INTO `ns_order_action` VALUES ('24', '11', '创建订单', '0', 'qweqwe', '0', '待付款', '1555652155');
INSERT INTO `ns_order_action` VALUES ('25', '12', '创建订单', '0', 'qweqwe', '0', '待付款', '1555652197');
INSERT INTO `ns_order_action` VALUES ('26', '13', '创建订单', '0', 'qweqwe', '0', '待付款', '1555652211');
INSERT INTO `ns_order_action` VALUES ('27', '13', '订单支付', '0', 'qweqwe', '1', '待发货', '1555652965');
INSERT INTO `ns_order_action` VALUES ('28', '13', '订单发货', '0', 'admin', '2', '已发货', '1555652993');
INSERT INTO `ns_order_action` VALUES ('29', '10', '订单交易关闭', '0', '', '5', '已关闭', '1555656900');
INSERT INTO `ns_order_action` VALUES ('30', '11', '订单交易关闭', '0', '', '5', '已关闭', '1555656900');
INSERT INTO `ns_order_action` VALUES ('31', '12', '订单交易关闭', '0', '', '5', '已关闭', '1555656900');
INSERT INTO `ns_order_action` VALUES ('34', '3', '订单收货', '0', 'qweqwe', '3', '已收货', '1555656983');
INSERT INTO `ns_order_action` VALUES ('35', '3', '交易完成', '0', '', '4', '已完成', '1555657516');
INSERT INTO `ns_order_action` VALUES ('36', '14', '创建订单', '0', 'qweqwe', '0', '待付款', '1555657652');
INSERT INTO `ns_order_action` VALUES ('37', '14', '订单支付', '0', 'qweqwe', '1', '待发货', '1555657654');
INSERT INTO `ns_order_action` VALUES ('38', '13', '订单收货', '0', 'qweqwe', '3', '已收货', '1555665609');
INSERT INTO `ns_order_action` VALUES ('39', '14', '订单发货', '0', 'admin', '2', '已发货', '1555665650');
INSERT INTO `ns_order_action` VALUES ('40', '14', '订单收货', '0', 'admin', '3', '已收货', '1555665657');
INSERT INTO `ns_order_action` VALUES ('41', '13', '交易完成', '0', '', '4', '已完成', '1555982309');
INSERT INTO `ns_order_action` VALUES ('42', '14', '交易完成', '0', '', '4', '已完成', '1555982309');
INSERT INTO `ns_order_action` VALUES ('43', '15', '创建订单', '0', 'qweqwe', '0', '待付款', '1555986420');
INSERT INTO `ns_order_action` VALUES ('44', '15', '订单支付', '0', 'qweqwe', '1', '待发货', '1555986423');
INSERT INTO `ns_order_action` VALUES ('45', '15', '订单发货', '0', 'admin', '2', '已发货', '1555986443');
INSERT INTO `ns_order_action` VALUES ('46', '15', '订单收货', '0', 'qweqwe', '3', '已收货', '1555986589');
INSERT INTO `ns_order_action` VALUES ('47', '15', '交易完成', '0', '', '4', '已完成', '1555989393');
INSERT INTO `ns_order_action` VALUES ('48', '16', '创建订单', '0', 'qweqwe', '0', '待付款', '1555997470');
INSERT INTO `ns_order_action` VALUES ('49', '16', '订单支付', '0', 'qweqwe', '1', '待发货', '1555997472');
INSERT INTO `ns_order_action` VALUES ('50', '17', '创建订单', '0', 'qweqwe', '0', '待付款', '1555997507');
INSERT INTO `ns_order_action` VALUES ('51', '17', '订单支付', '0', 'qweqwe', '1', '待发货', '1555997509');
INSERT INTO `ns_order_action` VALUES ('52', '17', '订单发货', '0', 'admin', '2', '已发货', '1555997525');
INSERT INTO `ns_order_action` VALUES ('53', '17', '订单收货', '0', 'qweqwe', '3', '已收货', '1555997538');
INSERT INTO `ns_order_action` VALUES ('54', '17', '交易完成', '0', '', '4', '已完成', '1555997591');
INSERT INTO `ns_order_action` VALUES ('55', '16', '订单发货', '0', 'admin', '2', '已发货', '1555997795');
INSERT INTO `ns_order_action` VALUES ('56', '16', '订单收货', '0', 'qweqwe', '3', '已收货', '1555997801');
INSERT INTO `ns_order_action` VALUES ('57', '16', '交易完成1', '0', '', '4', '已完成', '1555997912');
INSERT INTO `ns_order_action` VALUES ('58', '18', '创建订单', '0', 'qweqwe', '0', '待付款', '1555998172');
INSERT INTO `ns_order_action` VALUES ('59', '18', '订单支付', '0', 'qweqwe', '1', '待发货', '1555998174');
INSERT INTO `ns_order_action` VALUES ('60', '18', '订单发货', '0', 'admin', '2', '已发货', '1555998186');
INSERT INTO `ns_order_action` VALUES ('61', '18', '订单收货', '0', 'qweqwe', '3', '已收货', '1555998344');
INSERT INTO `ns_order_action` VALUES ('62', '1', '创建订单', '0', 'qweqwe', '0', '待付款', '1556004667');
INSERT INTO `ns_order_action` VALUES ('63', '1', '订单交易关闭', '0', 'qweqwe', '5', '已关闭', '1556004742');
INSERT INTO `ns_order_action` VALUES ('64', '2', '创建订单', '0', 'qweqwe', '0', '待付款', '1556004766');
INSERT INTO `ns_order_action` VALUES ('65', '3', '创建订单', '0', 'qweqwe', '0', '待付款', '1556004797');
INSERT INTO `ns_order_action` VALUES ('66', '4', '创建订单', '0', 'qweqwe', '0', '待付款', '1556004834');
INSERT INTO `ns_order_action` VALUES ('67', '4', '订单支付', '0', 'qweqwe', '1', '待发货', '1556004852');
INSERT INTO `ns_order_action` VALUES ('68', '4', '订单发货', '0', 'admin', '2', '已发货', '1556004964');
INSERT INTO `ns_order_action` VALUES ('69', '4', '订单收货', '0', 'qweqwe', '3', '已收货', '1556005027');
INSERT INTO `ns_order_action` VALUES ('70', '4', '交易完成', '0', '', '4', '已完成', '1556005251');
INSERT INTO `ns_order_action` VALUES ('71', '5', '创建订单', '0', 'qweqwe', '0', '待付款', '1556005322');
INSERT INTO `ns_order_action` VALUES ('72', '5', '订单支付', '0', 'qweqwe', '1', '待发货', '1556005325');
INSERT INTO `ns_order_action` VALUES ('73', '5', '订单发货', '0', 'admin', '2', '已发货', '1556005343');
INSERT INTO `ns_order_action` VALUES ('74', '5', '订单发货', '0', 'admin', '2', '已发货', '1556005384');
INSERT INTO `ns_order_action` VALUES ('75', '5', '订单收货', '0', 'qweqwe', '3', '已收货', '1556005397');
INSERT INTO `ns_order_action` VALUES ('76', '5', '交易完成', '0', '', '4', '已完成', '1556005750');
INSERT INTO `ns_order_action` VALUES ('77', '6', '创建订单', '0', 'qweqwe', '0', '待付款', '1556005940');
INSERT INTO `ns_order_action` VALUES ('78', '6', '订单支付', '0', 'qweqwe', '1', '待发货', '1556005943');
INSERT INTO `ns_order_action` VALUES ('79', '6', '订单发货', '0', 'admin', '2', '已发货', '1556005968');
INSERT INTO `ns_order_action` VALUES ('80', '6', '订单交易关闭', '0', 'admin', '5', '已关闭', '1556006088');
INSERT INTO `ns_order_action` VALUES ('81', '7', '创建订单', '0', 'qweqwe', '0', '待付款', '1556007747');
INSERT INTO `ns_order_action` VALUES ('82', '7', '订单支付', '0', 'qweqwe', '1', '待发货', '1556007750');
INSERT INTO `ns_order_action` VALUES ('83', '7', '订单发货', '0', 'admin', '2', '已发货', '1556007767');
INSERT INTO `ns_order_action` VALUES ('84', '7', '订单发货', '0', 'admin', '2', '已发货', '1556007888');
INSERT INTO `ns_order_action` VALUES ('85', '7', '订单收货', '0', 'qweqwe', '3', '已收货', '1556007911');
INSERT INTO `ns_order_action` VALUES ('86', '7', '交易完成', '0', '', '4', '已完成', '1556008000');
INSERT INTO `ns_order_action` VALUES ('87', '2', '订单交易关闭', '0', '', '5', '已关闭', '1556008633');
INSERT INTO `ns_order_action` VALUES ('88', '3', '订单交易关闭', '0', '', '5', '已关闭', '1556008633');

-- ----------------------------
-- Table structure for `ns_order_customer_account_records`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_customer_account_records`;
CREATE TABLE `ns_order_customer_account_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `order_goods_id` int(11) NOT NULL COMMENT '订单项id',
  `refund_trade_no` varchar(55) NOT NULL COMMENT '退款交易号',
  `refund_money` decimal(10,2) NOT NULL COMMENT '退款金额',
  `refund_way` int(11) NOT NULL COMMENT '退款方式（1：微信，2：支付宝，10：线下）',
  `buyer_id` int(11) NOT NULL COMMENT '买家id',
  `refund_time` int(11) NOT NULL COMMENT '退款时间',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='订单售后账户记录';

-- ----------------------------
-- Records of ns_order_customer_account_records
-- ----------------------------
INSERT INTO `ns_order_customer_account_records` VALUES ('1', '25', '20190423131514613500', '0.00', '10', '8', '1555996514', '7777777777777777777777777777777');
INSERT INTO `ns_order_customer_account_records` VALUES ('2', '28', '20190423144710432583', '0.00', '10', '8', '1556002030', '7777777777777777777777');

-- ----------------------------
-- Table structure for `ns_order_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_goods`;
CREATE TABLE `ns_order_goods` (
  `order_goods_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单项ID',
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `goods_id` int(11) NOT NULL COMMENT '商品ID',
  `goods_name` varchar(100) NOT NULL COMMENT '商品名称',
  `sku_id` int(11) NOT NULL COMMENT 'skuID',
  `sku_name` varchar(50) NOT NULL COMMENT 'sku名称',
  `price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `cost_price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '商品成本价',
  `num` varchar(255) NOT NULL DEFAULT '0' COMMENT '购买数量',
  `adjust_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '调整金额',
  `goods_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品总价',
  `goods_picture` int(11) NOT NULL DEFAULT '0' COMMENT '商品图片',
  `shop_id` int(11) NOT NULL DEFAULT '1' COMMENT '店铺ID',
  `buyer_id` int(11) NOT NULL DEFAULT '0' COMMENT '购买人ID',
  `point_exchange_type` int(11) NOT NULL DEFAULT '0' COMMENT '积分兑换类型0.非积分兑换1.积分兑换',
  `goods_type` varchar(255) NOT NULL DEFAULT '1' COMMENT '商品类型',
  `promotion_id` int(11) NOT NULL DEFAULT '0' COMMENT '促销ID',
  `promotion_type_id` int(11) NOT NULL DEFAULT '0' COMMENT '促销类型',
  `order_type` int(11) NOT NULL DEFAULT '1' COMMENT '订单类型',
  `order_status` int(11) NOT NULL DEFAULT '0' COMMENT '订单状态',
  `give_point` int(11) NOT NULL DEFAULT '0' COMMENT '积分数量',
  `shipping_status` int(11) NOT NULL DEFAULT '0' COMMENT '物流状态',
  `refund_type` int(11) NOT NULL DEFAULT '1' COMMENT '退款方式',
  `refund_require_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '退款金额',
  `refund_reason` varchar(255) NOT NULL DEFAULT '' COMMENT '退款原因',
  `refund_shipping_code` varchar(255) NOT NULL DEFAULT '' COMMENT '退款物流单号',
  `refund_shipping_company` varchar(255) NOT NULL DEFAULT '0' COMMENT '退款物流公司名称',
  `refund_real_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际退款金额',
  `refund_status` int(1) NOT NULL DEFAULT '0' COMMENT '退款状态',
  `memo` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `is_evaluate` smallint(6) NOT NULL DEFAULT '0' COMMENT '是否评价 0为未评价 1为已评价 2为已追评',
  `refund_time` int(11) DEFAULT '0' COMMENT '退款时间',
  `refund_balance_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单退款余额',
  `tmp_express_company` varchar(255) NOT NULL DEFAULT '' COMMENT '批量打印时添加的临时物流公司',
  `tmp_express_company_id` int(11) NOT NULL DEFAULT '0' COMMENT '批量打印时添加的临时物流公司id',
  `tmp_express_no` varchar(50) NOT NULL DEFAULT '' COMMENT '批量打印时添加的临时订单编号',
  `gift_flag` int(11) DEFAULT '0' COMMENT '赠品标识，0:不是赠品，大于0：赠品id',
  `is_virtual` int(11) NOT NULL DEFAULT '0' COMMENT '是否包含 虚拟商品   0 不包含  1  包含',
  PRIMARY KEY (`order_goods_id`),
  KEY `UK_ns_order_goods` (`buyer_id`,`goods_id`,`order_id`,`promotion_id`,`sku_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=289 COMMENT='订单商品表';

-- ----------------------------
-- Records of ns_order_goods
-- ----------------------------
INSERT INTO `ns_order_goods` VALUES ('1', '1', '2', '测试2', '6', '', '200.00', '100.00', '1', '0.00', '200.00', '2', '0', '8', '0', '1', '0', '0', '1', '0', '0', '0', '1', '0.00', '', '', '0', '0.00', '0', '', '0', '0', '0.00', '', '0', '', '0', '0');
INSERT INTO `ns_order_goods` VALUES ('2', '1', '3', '333', '9', '', '500.00', '100.00', '1', '0.00', '500.00', '3', '0', '8', '0', '1', '0', '0', '1', '0', '0', '0', '1', '0.00', '', '', '0', '0.00', '0', '', '0', '0', '0.00', '', '0', '', '0', '0');
INSERT INTO `ns_order_goods` VALUES ('3', '1', '1', '测试', '7', '', '300.00', '100.00', '1', '0.00', '300.00', '1', '0', '8', '0', '1', '0', '0', '1', '0', '0', '0', '1', '0.00', '', '', '0', '0.00', '0', '', '0', '0', '0.00', '', '0', '', '0', '0');
INSERT INTO `ns_order_goods` VALUES ('4', '2', '1', '测试', '7', '', '300.00', '100.00', '1', '0.00', '300.00', '1', '0', '8', '0', '1', '0', '0', '1', '0', '0', '0', '1', '0.00', '', '', '0', '0.00', '0', '', '0', '0', '0.00', '', '0', '', '0', '0');
INSERT INTO `ns_order_goods` VALUES ('5', '3', '2', '测试2', '6', '', '200.00', '100.00', '1', '0.00', '200.00', '2', '0', '8', '0', '1', '0', '0', '1', '0', '0', '0', '1', '0.00', '', '', '0', '0.00', '0', '', '0', '0', '0.00', '', '0', '', '0', '0');
INSERT INTO `ns_order_goods` VALUES ('6', '4', '2', '测试2', '6', '', '200.00', '100.00', '1', '0.00', '200.00', '2', '0', '8', '0', '1', '0', '0', '1', '0', '0', '1', '1', '0.00', '', '', '0', '0.00', '0', '', '0', '0', '0.00', '', '0', '', '0', '0');
INSERT INTO `ns_order_goods` VALUES ('7', '5', '1', '测试', '7', '', '300.00', '100.00', '1', '0.00', '300.00', '1', '0', '8', '0', '1', '0', '0', '1', '0', '0', '1', '1', '0.00', '买/卖双方协商一致', '', '0', '0.00', '5', '', '0', '1556005353', '300.00', '', '0', '', '0', '0');
INSERT INTO `ns_order_goods` VALUES ('8', '5', '2', '测试2', '6', '', '200.00', '100.00', '1', '0.00', '200.00', '2', '0', '8', '0', '1', '0', '0', '1', '0', '0', '1', '1', '0.00', '', '', '0', '0.00', '0', '', '0', '0', '0.00', '', '0', '', '0', '0');
INSERT INTO `ns_order_goods` VALUES ('9', '6', '3', '333', '9', '', '500.00', '100.00', '1', '0.00', '500.00', '3', '0', '8', '0', '1', '0', '0', '1', '0', '0', '1', '2', '0.00', '买/卖双方协商一致', '77', '777', '0.00', '5', '', '0', '1556005990', '500.00', '', '0', '', '0', '0');
INSERT INTO `ns_order_goods` VALUES ('10', '7', '2', '测试2', '6', '', '200.00', '100.00', '1', '0.00', '200.00', '2', '0', '8', '0', '1', '0', '0', '1', '0', '0', '1', '1', '0.00', '', '', '0', '0.00', '0', '', '0', '0', '0.00', '', '0', '', '0', '0');
INSERT INTO `ns_order_goods` VALUES ('11', '7', '3', '333', '9', '', '500.00', '100.00', '1', '0.00', '500.00', '3', '0', '8', '0', '1', '0', '0', '1', '0', '0', '1', '1', '0.00', '买/卖双方协商一致', '', '0', '0.00', '5', '', '0', '1556007782', '500.00', '', '0', '', '0', '0');
INSERT INTO `ns_order_goods` VALUES ('12', '7', '1', '测试', '7', '', '300.00', '100.00', '1', '0.00', '300.00', '1', '0', '8', '0', '1', '0', '0', '1', '0', '0', '1', '1', '0.00', '', '', '0', '0.00', '0', '', '0', '0', '0.00', '', '0', '', '0', '0');

-- ----------------------------
-- Table structure for `ns_order_goods_express`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_goods_express`;
CREATE TABLE `ns_order_goods_express` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `order_goods_id_array` varchar(255) NOT NULL COMMENT '订单项商品组合列表',
  `express_name` varchar(50) NOT NULL DEFAULT '' COMMENT '包裹名称  （包裹- 1 包裹 - 2）',
  `shipping_type` tinyint(4) NOT NULL COMMENT '发货方式1 需要物流 0无需物流',
  `express_company_id` int(11) NOT NULL COMMENT '快递公司id',
  `express_company` varchar(255) NOT NULL DEFAULT '' COMMENT '物流公司名称',
  `express_no` varchar(50) NOT NULL COMMENT '运单编号',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `user_name` varchar(50) NOT NULL COMMENT '用户名',
  `memo` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `shipping_time` int(11) DEFAULT '0' COMMENT '发货时间',
  PRIMARY KEY (`id`),
  KEY `UK_ns_order_goods_express` (`order_goods_id_array`,`order_id`,`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=606 COMMENT='商品订单物流信息表（多次发货）';

-- ----------------------------
-- Records of ns_order_goods_express
-- ----------------------------
INSERT INTO `ns_order_goods_express` VALUES ('1', '2', '2', '申通快递', '1', '1', '申通快递', '6666', '3', 'admin', '', '1555575534');
INSERT INTO `ns_order_goods_express` VALUES ('2', '3', '3', '圆通速递', '1', '2', '圆通速递', '123123123', '3', 'admin', '', '1555576371');
INSERT INTO `ns_order_goods_express` VALUES ('3', '13', '22,23', '圆通速递', '1', '2', '圆通速递', '666', '3', 'admin', '', '1555652993');
INSERT INTO `ns_order_goods_express` VALUES ('4', '14', '24', '圆通速递', '1', '2', '圆通速递', '123', '3', 'admin', '', '1555665650');
INSERT INTO `ns_order_goods_express` VALUES ('5', '15', '25', '申通快递', '1', '1', '申通快递', '123123', '3', 'admin', '', '1555986443');
INSERT INTO `ns_order_goods_express` VALUES ('6', '17', '27', '申通快递', '1', '1', '申通快递', '123', '3', 'admin', '', '1555997525');
INSERT INTO `ns_order_goods_express` VALUES ('7', '16', '26', '圆通速递', '1', '2', '圆通速递', '123', '3', 'admin', '', '1555997795');
INSERT INTO `ns_order_goods_express` VALUES ('8', '18', '28', '中通快递', '1', '3', '中通快递', '7777', '3', 'admin', '', '1555998186');
INSERT INTO `ns_order_goods_express` VALUES ('9', '5', '7,8', '中通快递', '1', '3', '中通快递', '78', '3', 'admin', '', '1556005343');
INSERT INTO `ns_order_goods_express` VALUES ('10', '6', '9', '韵达快运', '1', '4', '韵达快运', '123', '3', 'admin', '', '1556005968');
INSERT INTO `ns_order_goods_express` VALUES ('11', '7', '10,11,12', '中通快递', '1', '3', '中通快递', '000', '3', 'admin', '', '1556007767');

-- ----------------------------
-- Table structure for `ns_order_goods_promotion_details`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_goods_promotion_details`;
CREATE TABLE `ns_order_goods_promotion_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `sku_id` int(11) NOT NULL COMMENT '商品skuid',
  `promotion_type` varbinary(255) NOT NULL COMMENT '优惠类型规则ID（满减对应规则）',
  `promotion_id` int(11) NOT NULL COMMENT '优惠ID',
  `discount_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠的金额，单位：元，精确到小数点后两位',
  `used_time` int(11) DEFAULT '0' COMMENT '使用时间',
  PRIMARY KEY (`id`),
  KEY `IDX_ns_order_goods_promotion_d` (`order_id`,`promotion_id`,`sku_id`,`promotion_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='订单商品优惠详情';

-- ----------------------------
-- Records of ns_order_goods_promotion_details
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_order_payment`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_payment`;
CREATE TABLE `ns_order_payment` (
  `out_trade_no` varchar(30) NOT NULL COMMENT '支付单编号',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '执行支付的相关店铺ID（0平台）',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '订单类型1.商城订单2.交易商支付',
  `type_alis_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单类型关联ID',
  `pay_body` varchar(255) NOT NULL DEFAULT '' COMMENT '订单支付简介',
  `pay_detail` varchar(1000) NOT NULL DEFAULT '' COMMENT '订单支付详情',
  `pay_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态',
  `pay_type` int(11) NOT NULL DEFAULT '1' COMMENT '支付方式',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `pay_time` int(11) DEFAULT '0' COMMENT '支付时间',
  `trade_no` varchar(30) NOT NULL DEFAULT '' COMMENT '交易号，支付宝退款用，微信传入空',
  `original_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原始支付金额',
  `balance_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用余额',
  KEY `IDX_ns_order_payment` (`out_trade_no`,`pay_type`,`pay_status`,`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=963 COMMENT='订单支付表';

-- ----------------------------
-- Records of ns_order_payment
-- ----------------------------
INSERT INTO `ns_order_payment` VALUES ('155548998028681000', '0', '1', '1', 'Niushop开源商城-测试2', 'Niushop开源商城订单', '222.00', '0', '1', '1555489980', '0', '', '222.00', '0.00');
INSERT INTO `ns_order_payment` VALUES ('155549011080311000', '0', '1', '2', 'Niushop开源商城-测试2', 'Niushop开源商城订单', '0.00', '1', '5', '1555490110', '1555490120', '', '222.00', '222.00');
INSERT INTO `ns_order_payment` VALUES ('155557429811351000', '0', '1', '3', 'Niushop开源商城-测试', 'Niushop开源商城订单', '0.00', '1', '5', '1555574298', '1555576350', '', '111.00', '111.00');
INSERT INTO `ns_order_payment` VALUES ('155564191927251000', '0', '1', '4', 'Niushop开源商城-测试2等多件', 'Niushop开源商城订单', '700.00', '0', '1', '1555641919', '0', '', '700.00', '0.00');
INSERT INTO `ns_order_payment` VALUES ('155564196559541000', '0', '1', '5', 'Niushop开源商城-测试2等多件', 'Niushop开源商城订单', '700.00', '0', '1', '1555641965', '0', '', '700.00', '0.00');
INSERT INTO `ns_order_payment` VALUES ('155564209791501000', '0', '1', '6', 'Niushop开源商城-测试2等多件', 'Niushop开源商城订单', '700.00', '0', '1', '1555642097', '0', '', '700.00', '0.00');
INSERT INTO `ns_order_payment` VALUES ('155564215428521000', '0', '1', '7', 'Niushop开源商城-测试2等多件', 'Niushop开源商城订单', '700.00', '0', '1', '1555642155', '0', '', '700.00', '0.00');
INSERT INTO `ns_order_payment` VALUES ('155564217192201000', '0', '1', '8', 'Niushop开源商城-测试2等多件', 'Niushop开源商城订单', '700.00', '0', '1', '1555642171', '0', '', '700.00', '0.00');
INSERT INTO `ns_order_payment` VALUES ('155564220551611000', '0', '1', '9', 'Niushop开源商城-测试2等多件', 'Niushop开源商城订单', '700.00', '0', '1', '1555642205', '0', '', '700.00', '0.00');
INSERT INTO `ns_order_payment` VALUES ('155565207833151000', '0', '1', '10', 'Niushop开源商城-测试2等多件', 'Niushop开源商城订单', '700.00', '0', '1', '1555652078', '0', '', '700.00', '0.00');
INSERT INTO `ns_order_payment` VALUES ('155565215535981000', '0', '1', '11', 'Niushop开源商城-测试2等多件', 'Niushop开源商城订单', '700.00', '0', '1', '1555652155', '0', '', '700.00', '0.00');
INSERT INTO `ns_order_payment` VALUES ('155565219733731000', '0', '1', '12', 'Niushop开源商城-测试2等多件', 'Niushop开源商城订单', '700.00', '0', '1', '1555652197', '0', '', '700.00', '0.00');
INSERT INTO `ns_order_payment` VALUES ('155565221125131000', '0', '1', '13', 'Niushop开源商城-测试2等多件', 'Niushop开源商城订单', '0.00', '1', '5', '1555652211', '1555652965', '', '700.00', '700.00');
INSERT INTO `ns_order_payment` VALUES ('155565765211011000', '0', '1', '14', 'Niushop开源商城-333', 'Niushop开源商城订单', '0.00', '1', '5', '1555657652', '1555657654', '', '500.00', '500.00');
INSERT INTO `ns_order_payment` VALUES ('155598642065101000', '0', '1', '15', 'Niushop开源商城-测试2', 'Niushop开源商城订单', '0.00', '1', '5', '1555986420', '1555986423', '', '200.00', '200.00');
INSERT INTO `ns_order_payment` VALUES ('155599747037541000', '0', '1', '16', 'Niushop开源商城-测试', 'Niushop开源商城订单', '0.00', '1', '5', '1555997470', '1555997472', '', '300.00', '300.00');
INSERT INTO `ns_order_payment` VALUES ('155599750743961000', '0', '1', '17', 'Niushop开源商城-测试2', 'Niushop开源商城订单', '0.00', '1', '5', '1555997507', '1555997509', '', '200.00', '200.00');
INSERT INTO `ns_order_payment` VALUES ('155599817222761000', '0', '1', '18', 'Niushop开源商城-测试', 'Niushop开源商城订单', '0.00', '1', '5', '1555998172', '1555998174', '', '300.00', '300.00');
INSERT INTO `ns_order_payment` VALUES ('155600466763141000', '0', '1', '1', 'Niushop开源商城-测试2等多件', 'Niushop开源商城订单', '1000.00', '0', '1', '1556004667', '0', '', '1000.00', '0.00');
INSERT INTO `ns_order_payment` VALUES ('155600476616271000', '0', '1', '2', 'Niushop开源商城-测试', 'Niushop开源商城订单', '300.00', '0', '1', '1556004766', '0', '', '300.00', '0.00');
INSERT INTO `ns_order_payment` VALUES ('155600479745701000', '0', '1', '3', 'Niushop开源商城-测试2', 'Niushop开源商城订单', '200.00', '0', '1', '1556004797', '0', '', '200.00', '0.00');
INSERT INTO `ns_order_payment` VALUES ('155600483433871000', '0', '1', '4', 'Niushop开源商城-测试2', 'Niushop开源商城订单', '0.00', '1', '5', '1556004834', '1556004852', '', '200.00', '200.00');
INSERT INTO `ns_order_payment` VALUES ('155600532245161000', '0', '1', '5', 'Niushop开源商城-测试等多件', 'Niushop开源商城订单', '0.00', '1', '5', '1556005322', '1556005325', '', '500.00', '500.00');
INSERT INTO `ns_order_payment` VALUES ('155600594014111000', '0', '1', '6', 'Niushop开源商城-333', 'Niushop开源商城订单', '0.00', '1', '5', '1556005940', '1556005943', '', '500.00', '500.00');
INSERT INTO `ns_order_payment` VALUES ('155600774740601000', '0', '1', '7', 'Niushop开源商城-测试2等多件', 'Niushop开源商城订单', '0.00', '1', '5', '1556007747', '1556007749', '', '1000.00', '1000.00');

-- ----------------------------
-- Table structure for `ns_order_pickup`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_pickup`;
CREATE TABLE `ns_order_pickup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) NOT NULL DEFAULT '0' COMMENT '订单ID',
  `name` varchar(255) NOT NULL COMMENT '自提点名称',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '自提点地址',
  `contact` varchar(255) NOT NULL DEFAULT '' COMMENT '联系人',
  `phone` varchar(255) NOT NULL DEFAULT '' COMMENT '联系电话',
  `city_id` int(11) NOT NULL COMMENT '市ID',
  `province_id` int(11) NOT NULL COMMENT '省ID',
  `district_id` int(11) NOT NULL COMMENT '区县ID',
  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '供应门店ID',
  `longitude` varchar(255) NOT NULL DEFAULT '' COMMENT '经度',
  `latitude` varchar(255) NOT NULL DEFAULT '' COMMENT '维度',
  `buyer_name` varchar(50) NOT NULL DEFAULT '' COMMENT '提货人姓名',
  `buyer_mobile` varchar(255) NOT NULL DEFAULT '' COMMENT '提货人电话',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '提货备注信息',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `picked_up_code` varchar(50) NOT NULL DEFAULT '' COMMENT '自提码',
  `picked_up_time` int(11) NOT NULL DEFAULT '0' COMMENT '自提时间',
  `picked_up_status` int(1) NOT NULL DEFAULT '0' COMMENT '自提状态 0未自提 1已提货',
  `auditor_id` int(11) NOT NULL DEFAULT '0' COMMENT '审核人id',
  `picked_up_id` int(11) NOT NULL DEFAULT '0' COMMENT '自提点门店id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='订单自提点管理';

-- ----------------------------
-- Records of ns_order_pickup
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_order_presell`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_presell`;
CREATE TABLE `ns_order_presell` (
  `presell_order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `out_trade_no` varchar(100) NOT NULL DEFAULT '0' COMMENT '外部交易号',
  `payment_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付类型',
  `order_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单状态 0创建 1尾款待支付 2开始结尾款 ',
  `pay_time` int(11) NOT NULL DEFAULT '0' COMMENT '订单付款时间',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '订单创建时间',
  `operator_type` int(1) NOT NULL DEFAULT '0' COMMENT '操作人类型  1店铺  2用户',
  `operator_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作人id',
  `relate_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联id',
  `presell_time` int(11) NOT NULL DEFAULT '0' COMMENT '预售结束时间',
  `presell_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '预售金额',
  `presell_pay` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '预售支付金额',
  `platform_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台余额',
  `point` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单消耗积分',
  `point_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单消耗积分抵多少钱',
  `presell_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '预售金单价',
  `presell_delivery_type` int(11) NOT NULL DEFAULT '0' COMMENT '预售发货形式 1指定时间 2支付后天数',
  `presell_delivery_value` int(11) NOT NULL DEFAULT '0' COMMENT '预售发货时间 按形式 ',
  `presell_delivery_time` int(11) NOT NULL DEFAULT '0' COMMENT '预售发货具体时间（实则为结尾款时间）',
  `is_full_payment` int(11) NOT NULL DEFAULT '0' COMMENT '是否全款预定',
  PRIMARY KEY (`presell_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=420 COMMENT='预售订单表';

-- ----------------------------
-- Records of ns_order_presell
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_order_promotion_details`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_promotion_details`;
CREATE TABLE `ns_order_promotion_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `promotion_type_id` int(11) NOT NULL COMMENT '优惠类型规则ID（满减对应规则）',
  `promotion_id` int(11) NOT NULL COMMENT '优惠ID',
  `promotion_type` varchar(255) NOT NULL COMMENT '优惠类型',
  `promotion_name` varchar(50) NOT NULL COMMENT '该优惠活动的名称',
  `promotion_condition` varchar(255) NOT NULL DEFAULT '' COMMENT '优惠使用条件说明',
  `discount_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠的金额，单位：元，精确到小数点后两位',
  `used_time` int(11) DEFAULT '0' COMMENT '使用时间',
  PRIMARY KEY (`id`),
  KEY `UK_ns_order_promotion_details` (`order_id`,`promotion_id`,`promotion_type_id`,`promotion_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=364 COMMENT='订单优惠详情';

-- ----------------------------
-- Records of ns_order_promotion_details
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_order_refund`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_refund`;
CREATE TABLE `ns_order_refund` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `order_goods_id` int(11) NOT NULL COMMENT '订单商品表id',
  `refund_status` varchar(255) NOT NULL COMMENT '操作状态\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n流程状态(refund_status)	状态名称(refund_status_name)	操作时间\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n1	买家申请	发起了退款申请,等待卖家处理\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n2	等待买家退货	卖家已同意退款申请,等待买家退货\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n3	等待卖家确认收货	买家已退货,等待卖家确认收货\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n4	等待卖家确认退款	卖家同意退款\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n',
  `action` varchar(255) NOT NULL COMMENT '退款操作内容描述',
  `action_way` tinyint(4) NOT NULL DEFAULT '0' COMMENT '操作方 1 买家 2 卖家',
  `action_userid` varchar(255) NOT NULL DEFAULT '0' COMMENT '操作人id',
  `action_username` varchar(255) NOT NULL DEFAULT '' COMMENT '操作人姓名',
  `action_time` int(11) DEFAULT '0' COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=108 COMMENT='订单商品退货退款操作表';

-- ----------------------------
-- Records of ns_order_refund
-- ----------------------------
INSERT INTO `ns_order_refund` VALUES ('1', '7', '1', '买家申请退款', '1', '8', 'qweqwe', '1556005353');
INSERT INTO `ns_order_refund` VALUES ('2', '7', '4', '等待卖家确认退款', '2', '3', 'admin', '1556005372');
INSERT INTO `ns_order_refund` VALUES ('3', '7', '5', '退款已成功', '2', '3', 'admin', '1556005383');
INSERT INTO `ns_order_refund` VALUES ('4', '9', '1', '买家申请退款', '1', '8', 'qweqwe', '1556005990');
INSERT INTO `ns_order_refund` VALUES ('5', '9', '2', '等待买家退货', '2', '3', 'admin', '1556006010');
INSERT INTO `ns_order_refund` VALUES ('6', '9', '3', '等待卖家确认收货', '1', '8', 'qweqwe', '1556006049');
INSERT INTO `ns_order_refund` VALUES ('7', '9', '4', '等待卖家确认退款', '2', '3', 'admin', '1556006075');
INSERT INTO `ns_order_refund` VALUES ('8', '9', '5', '退款已成功', '2', '3', 'admin', '1556006087');
INSERT INTO `ns_order_refund` VALUES ('9', '11', '1', '买家申请退款', '1', '8', 'qweqwe', '1556007782');
INSERT INTO `ns_order_refund` VALUES ('10', '11', '4', '等待卖家确认退款', '2', '3', 'admin', '1556007853');
INSERT INTO `ns_order_refund` VALUES ('11', '11', '5', '退款已成功', '2', '3', 'admin', '1556007887');

-- ----------------------------
-- Table structure for `ns_order_refund_account_records`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_refund_account_records`;
CREATE TABLE `ns_order_refund_account_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `order_goods_id` int(11) NOT NULL COMMENT '订单项id',
  `refund_trade_no` varchar(55) NOT NULL COMMENT '退款交易号',
  `refund_money` decimal(10,2) NOT NULL COMMENT '退款金额',
  `refund_way` int(11) NOT NULL COMMENT '退款方式（1：微信，2：支付宝，10：线下）',
  `buyer_id` int(11) NOT NULL COMMENT '买家id',
  `refund_time` int(11) NOT NULL COMMENT '退款时间',
  `remark` varchar(255) DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=528 COMMENT='订单退款账户记录';

-- ----------------------------
-- Records of ns_order_refund_account_records
-- ----------------------------
INSERT INTO `ns_order_refund_account_records` VALUES ('1', '7', '20190423154303123236', '0.00', '10', '8', '1556005384', '8888888888888888888888888888888888888888888');
INSERT INTO `ns_order_refund_account_records` VALUES ('2', '9', '20190423155447826580', '0.00', '10', '8', '1556006087', '66');
INSERT INTO `ns_order_refund_account_records` VALUES ('3', '11', '20190423162447551126', '0.00', '10', '8', '1556007888', '订单编号:2019042316220001，退款方式为:[线下支付]，退款金额:0.00元，退款余额：500元');

-- ----------------------------
-- Table structure for `ns_order_shipping_fee`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_shipping_fee`;
CREATE TABLE `ns_order_shipping_fee` (
  `shipping_fee_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '运费模板ID',
  `shipping_fee_name` varchar(30) NOT NULL DEFAULT '' COMMENT '运费模板名称',
  `is_default` int(11) NOT NULL DEFAULT '0' COMMENT '是否是默认模板',
  `co_id` int(11) NOT NULL DEFAULT '0' COMMENT '物流公司ID',
  `shop_id` int(11) NOT NULL COMMENT '店铺ID',
  `province_id_array` text NOT NULL COMMENT '省ID组',
  `city_id_array` text NOT NULL COMMENT '市ID组',
  `weight_is_use` int(11) NOT NULL DEFAULT '1' COMMENT '是否启用重量运费',
  `weight_snum` decimal(8,2) NOT NULL DEFAULT '1.00' COMMENT '首重',
  `weight_sprice` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '首重运费',
  `weight_xnum` decimal(8,2) NOT NULL DEFAULT '1.00' COMMENT '续重',
  `weight_xprice` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '续重运费',
  `volume_is_use` int(11) NOT NULL DEFAULT '1' COMMENT '是否启用体积计算运费',
  `volume_snum` decimal(8,2) NOT NULL DEFAULT '1.00' COMMENT '首体积量',
  `volume_sprice` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '首体积运费',
  `volume_xnum` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '续体积量',
  `volume_xprice` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '续体积运费',
  `bynum_is_use` int(11) NOT NULL DEFAULT '1' COMMENT '是否启用计件方式运费',
  `bynum_snum` int(11) NOT NULL DEFAULT '0' COMMENT '首件',
  `bynum_sprice` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '首件运费',
  `bynum_xnum` int(11) NOT NULL DEFAULT '1' COMMENT '续件',
  `bynum_xprice` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '续件运费',
  `create_time` int(11) DEFAULT '0' COMMENT '创建日期',
  `update_time` int(11) DEFAULT '0' COMMENT '最后更新时间',
  `district_id_array` text COMMENT '区县ID组',
  PRIMARY KEY (`shipping_fee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4096 COMMENT='运费模板';

-- ----------------------------
-- Records of ns_order_shipping_fee
-- ----------------------------
INSERT INTO `ns_order_shipping_fee` VALUES ('1', '默认模板', '1', '1', '0', '', '', '1', '0.00', '0.00', '0.00', '0.00', '1', '0.00', '0.00', '0.00', '0.00', '1', '0', '0.00', '0', '0.00', '1553930562', '0', '');
INSERT INTO `ns_order_shipping_fee` VALUES ('2', '默认模板', '1', '2', '0', '', '', '1', '0.00', '0.00', '0.00', '0.00', '1', '0.00', '0.00', '0.00', '0.00', '1', '0', '0.00', '0', '0.00', '1553930574', '0', '');
INSERT INTO `ns_order_shipping_fee` VALUES ('3', '默认模板', '1', '3', '0', '', '', '1', '0.00', '0.00', '0.00', '0.00', '1', '0.00', '0.00', '0.00', '0.00', '1', '0', '0.00', '0', '0.00', '1553930583', '0', '');
INSERT INTO `ns_order_shipping_fee` VALUES ('4', '默认模板', '1', '4', '0', '', '', '1', '0.00', '0.00', '0.00', '0.00', '1', '0.00', '0.00', '0.00', '0.00', '1', '0', '0.00', '0', '0.00', '1553930592', '0', '');

-- ----------------------------
-- Table structure for `ns_order_shipping_fee_extend`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_shipping_fee_extend`;
CREATE TABLE `ns_order_shipping_fee_extend` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '售卖区域扩展ID',
  `shipping_fee_id` int(11) NOT NULL COMMENT '售卖区域ID',
  `province_id` varchar(8000) NOT NULL DEFAULT '0' COMMENT '省级地区ID组成的串，以，隔开，两端也有，',
  `city_id` varchar(8000) NOT NULL DEFAULT '0' COMMENT '市级地区ID组成的串，以，隔开，两端也有，',
  `snum` mediumint(8) unsigned NOT NULL DEFAULT '1' COMMENT '首件数量',
  `sprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '首件运费',
  `xnum` mediumint(8) unsigned NOT NULL DEFAULT '1' COMMENT '续件数量',
  `xprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '续件运费',
  `is_default` int(11) NOT NULL DEFAULT '0' COMMENT '是否默认 1 默认',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1820 COMMENT='售卖区域扩展表';

-- ----------------------------
-- Records of ns_order_shipping_fee_extend
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_order_shop_return`
-- ----------------------------
DROP TABLE IF EXISTS `ns_order_shop_return`;
CREATE TABLE `ns_order_shop_return` (
  `shop_id` int(11) NOT NULL,
  `shop_address` varchar(255) NOT NULL DEFAULT '' COMMENT '商家地址',
  `seller_name` varchar(50) NOT NULL DEFAULT '' COMMENT '收件人',
  `seller_mobile` varchar(30) NOT NULL DEFAULT '' COMMENT '收件人手机号',
  `seller_zipcode` varchar(20) NOT NULL DEFAULT '' COMMENT '邮编',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='店铺退货设置';

-- ----------------------------
-- Records of ns_order_shop_return
-- ----------------------------
INSERT INTO `ns_order_shop_return` VALUES ('0', '', '', '', '', '1555990255', '0');

-- ----------------------------
-- Table structure for `ns_picked_up_auditor`
-- ----------------------------
DROP TABLE IF EXISTS `ns_picked_up_auditor`;
CREATE TABLE `ns_picked_up_auditor` (
  `auditor_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '审核人id',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `pickup_id` int(11) NOT NULL DEFAULT '0' COMMENT '自提点门店id',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`auditor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='自提门店审核人表';

-- ----------------------------
-- Records of ns_picked_up_auditor
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_pickup_point`
-- ----------------------------
DROP TABLE IF EXISTS `ns_pickup_point`;
CREATE TABLE `ns_pickup_point` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `name` varchar(255) NOT NULL COMMENT '自提点名称',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '自提点地址',
  `contact` varchar(255) NOT NULL DEFAULT '' COMMENT '联系人',
  `phone` varchar(255) NOT NULL DEFAULT '' COMMENT '联系电话',
  `city_id` int(11) NOT NULL COMMENT '市ID',
  `province_id` int(11) NOT NULL COMMENT '省ID',
  `district_id` int(11) NOT NULL COMMENT '区县ID',
  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '供应门店ID',
  `longitude` varchar(255) NOT NULL DEFAULT '' COMMENT '经度',
  `latitude` varchar(255) NOT NULL DEFAULT '' COMMENT '维度',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4096 COMMENT='自提点管理';

-- ----------------------------
-- Records of ns_pickup_point
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_platform_adv`
-- ----------------------------
DROP TABLE IF EXISTS `ns_platform_adv`;
CREATE TABLE `ns_platform_adv` (
  `adv_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告自增标识编号',
  `ap_id` mediumint(8) unsigned NOT NULL COMMENT '广告位id',
  `adv_title` varchar(255) NOT NULL DEFAULT '' COMMENT '广告内容描述',
  `adv_url` text,
  `adv_image` varchar(1000) NOT NULL DEFAULT '' COMMENT '广告内容图片',
  `slide_sort` int(11) DEFAULT NULL,
  `click_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '广告点击率',
  `background` varchar(255) NOT NULL DEFAULT '#FFFFFF' COMMENT '背景色',
  `adv_code` text NOT NULL COMMENT '广告代码',
  `goods_id` int(11) DEFAULT '0' COMMENT '商品id',
  PRIMARY KEY (`adv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=265 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1170 COMMENT='广告表';

-- ----------------------------
-- Records of ns_platform_adv
-- ----------------------------
INSERT INTO `ns_platform_adv` VALUES ('239', '1051', '', '#', 'upload/default/adv_pc_index_top1.png', '0', '0', '#231FEF', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('240', '1052', '', '#', 'upload/default/adv_pc_index_right_logo1.png', '0', '0', '#ffffff', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('241', '1053', '', '#', 'upload/default/adv_pc_index_swiper1.png', '0', '0', '#F63331', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('242', '1054', '', '#', 'upload/default/adv_pc_index_recommend1.png', '0', '0', '#ffffff', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('243', '1054', '', '#', 'upload/default/adv_pc_index_recommend2.png', '0', '0', '#ffffff', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('244', '1054', '', '#', 'upload/default/adv_pc_index_recommend3.png', '0', '0', '#ffffff', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('245', '1054', '', '#', 'upload/default/adv_pc_index_recommend4.png', '0', '0', '#ffffff', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('246', '1056', '', '#', 'upload/default/adv_pc_discount_swiper1.png', '0', '0', '#ffb5ce', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('247', '1075', '', '#', 'upload/default/adv_pc_brand_swiper1.png', '0', '0', '#f6c699', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('248', '1076', '', '#', 'upload/default/adv_pc_point_swiper1.png', '0', '0', '#fc394d', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('249', '1102', '', '#', 'upload/default/adv_pc_point_center_section1.png', '0', '0', '#ffffff', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('250', '1103', '', '#', 'upload/default/adv_pc_login_swiper1.png', '0', '0', '#F63331', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('251', '6668', '', '#', 'upload/default/adv_pc_register1.png', '0', '0', '#ffffff', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('252', '6670', '', '#', 'upload/default/adv_pc_group_bay_swiper1.png', '0', '0', '#c235e5', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('253', '6671', '', '#', 'upload/default/adv_pc_topic_swiper1.png', '0', '0', '#faeadb', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('254', '6681', '', '#', 'upload/default/adv_pc_index_discount1.png', '0', '0', '#ffffff', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('255', '6681', '', '#', 'upload/default/adv_pc_index_discount2.png', '0', '0', '#ffffff', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('256', '6682', '', '#', 'upload/default/adv_pc_coupon_swiper1.png', '0', '0', '#ffffff', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('257', '1105', '', '#', 'upload/default/adv_wap_index_swiper1.png', '0', '0', '#ffffff', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('258', '1152', '', '#', 'upload/default/adv_wap_member1.png', '0', '0', '#ffffff', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('259', '1162', '', '#', 'upload/default/adv_wap_brand_swiper1.png', '0', '0', '#ffffff', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('260', '1163', '', '#', 'upload/default/adv_wap_discount_swiper1.png', '0', '0', '#ffffff', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('261', '1165', '', '#', 'upload/default/adv_wap_point_swiper1.png', '0', '0', '#ffffff', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('262', '6669', '', '#', 'upload/default/adv_wap_login_and_register1.png', '0', '0', '#ffffff', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('263', '6672', '', '#', 'upload/default/adv_wap_topic_swiper1.png', '0', '0', '#ffffff', '', '0');
INSERT INTO `ns_platform_adv` VALUES ('264', '6684', '', '#', 'upload/default/adv_wap_group_bay_swiper1.png', '0', '0', '#ffffff', '', '0');

-- ----------------------------
-- Table structure for `ns_platform_adv_position`
-- ----------------------------
DROP TABLE IF EXISTS `ns_platform_adv_position`;
CREATE TABLE `ns_platform_adv_position` (
  `ap_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告位置id',
  `ap_name` varchar(100) NOT NULL COMMENT '广告位置名',
  `ap_intro` varchar(255) NOT NULL COMMENT '广告位简介',
  `ap_class` smallint(1) unsigned NOT NULL COMMENT '广告类别：0图片1文字2幻灯3Flash',
  `ap_display` smallint(1) unsigned NOT NULL COMMENT '广告展示方式：0幻灯片1多广告展示2单广告展示',
  `is_use` smallint(1) unsigned NOT NULL COMMENT '广告位是否启用：0不启用1启用',
  `ap_height` int(10) NOT NULL COMMENT '广告位高度',
  `ap_width` int(10) NOT NULL COMMENT '广告位宽度',
  `ap_price` int(10) NOT NULL DEFAULT '0' COMMENT '广告位单价',
  `adv_num` int(10) NOT NULL DEFAULT '0' COMMENT '拥有的广告数',
  `click_num` int(10) NOT NULL DEFAULT '0' COMMENT '广告位点击率',
  `default_content` varchar(300) NOT NULL DEFAULT '',
  `ap_background_color` varchar(50) NOT NULL DEFAULT '#FFFFFF' COMMENT '广告位背景色 默认白色',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '广告位所在位置类型   1 pc端  2 手机端',
  `instance_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `is_del` int(11) DEFAULT '0',
  `ap_keyword` varchar(100) NOT NULL DEFAULT '' COMMENT '广告位关键字',
  `goods_id` int(11) DEFAULT '0' COMMENT '商品id，app内部跳转用',
  `layout` int(1) NOT NULL DEFAULT '1' COMMENT '图片展示布局',
  PRIMARY KEY (`ap_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6685 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1489 COMMENT='广告位表';

-- ----------------------------
-- Records of ns_platform_adv_position
-- ----------------------------
INSERT INTO `ns_platform_adv_position` VALUES ('1051', 'PC端首页最顶部广告位', 'PC端首页最顶部广告位', '0', '0', '1', '80', '1200', '0', '0', '0', '', '', '1', '0', '1', 'PC_INDEX_TOP', '0', '1');
INSERT INTO `ns_platform_adv_position` VALUES ('1052', 'PC端首页logo右侧小广告', 'PC端首页logo右侧小广告', '0', '0', '1', '22', '170', '0', '0', '0', '', '', '1', '0', '1', 'PC_INDEX_RIGHT_LOGO', '0', '1');
INSERT INTO `ns_platform_adv_position` VALUES ('1053', 'PC端首页轮播广告位', 'PC端首页轮播广告位', '0', '2', '1', '440', '1200', '0', '0', '0', '', '', '1', '0', '1', 'PC_INDEX_SWIPER', '0', '1');
INSERT INTO `ns_platform_adv_position` VALUES ('1054', 'PC端首页推荐广告位', 'PC端首页推荐广告位', '0', '0', '1', '140', '242', '0', '0', '0', '', '', '1', '0', '1', 'PC_INDEX_RECOMMEND', '0', '4');
INSERT INTO `ns_platform_adv_position` VALUES ('1056', 'PC端限时折扣轮播广告位', 'PC端限时折扣轮播广告位', '0', '2', '1', '440', '1200', '0', '0', '0', '', '', '1', '0', '1', 'PC_DISCOUNT_SWIPER', '0', '1');
INSERT INTO `ns_platform_adv_position` VALUES ('1075', 'PC端品牌专区广告位', 'PC端品牌专区广告位', '0', '2', '1', '440', '1210', '0', '0', '0', '', '', '1', '0', '1', 'PC_BRAND_SWIPER', '0', '1');
INSERT INTO `ns_platform_adv_position` VALUES ('1076', 'PC端积分中心轮播广告位', 'PC端积分中心轮播广告位', '0', '0', '1', '440', '1200', '0', '0', '0', '', '', '1', '0', '1', 'PC_POINT_SWIPER', '0', '1');
INSERT INTO `ns_platform_adv_position` VALUES ('1102', 'PC端积分中心中部广告位', 'PC端积分中心中部广告位', '0', '0', '1', '400', '1200', '0', '0', '0', '', '', '1', '0', '1', 'PC_POINT_CENTET_SECTION', '0', '1');
INSERT INTO `ns_platform_adv_position` VALUES ('1103', 'PC端登录页面轮播广告位', 'PC端登录页面轮播广告位', '0', '2', '1', '245', '1200', '0', '0', '0', 'upload/default/ADV_pc_login_swiper.png', '', '1', '0', '1', 'PC_LOGIN_SWIPER', '0', '1');
INSERT INTO `ns_platform_adv_position` VALUES ('1105', '手机端首页轮播广告位', '手机端首页轮播广告位', '0', '2', '1', '0', '0', '0', '0', '0', '', '', '2', '0', '1', 'WAP_INDEX_SWIPER', '0', '1');
INSERT INTO `ns_platform_adv_position` VALUES ('1152', '手机端会员中心广告位', '手机端会员中心广告位', '0', '2', '1', '0', '0', '0', '0', '0', '', '', '2', '0', '1', 'WAP_MEMBER', '0', '1');
INSERT INTO `ns_platform_adv_position` VALUES ('1162', '手机端品牌专区广告位', '手机端品牌专区广告位', '0', '2', '1', '0', '0', '0', '0', '0', '', '', '2', '0', '1', 'WAP_BRAND_SWIPER', '0', '1');
INSERT INTO `ns_platform_adv_position` VALUES ('1163', '手机端限时折扣专区广告位', '手机端限时折扣专区广告位', '0', '2', '1', '0', '0', '0', '0', '0', '', '', '2', '0', '1', 'WAP_DISCOUNT_SWIPER', '0', '1');
INSERT INTO `ns_platform_adv_position` VALUES ('1165', '手机端积分中心广告位', '手机端积分中心广告位', '0', '2', '1', '0', '0', '0', '0', '0', '', '', '2', '0', '1', 'WAP_POINT_SWIPER', '0', '1');
INSERT INTO `ns_platform_adv_position` VALUES ('6668', 'PC端注册页面广告位', 'PC端注册页面广告位', '0', '0', '1', '220', '420', '0', '0', '0', 'upload/default/ADV_pc_register.png', '', '1', '0', '1', 'PC_REGISTER', '0', '1');
INSERT INTO `ns_platform_adv_position` VALUES ('6669', '手机端登录注册广告位', '手机端登录注册广告位', '0', '2', '1', '0', '0', '0', '0', '0', 'upload/default/ADV_wap_login_and_register.png', '', '2', '0', '1', 'WAP_LOGIN_ADN_REGISTER', '0', '1');
INSERT INTO `ns_platform_adv_position` VALUES ('6670', 'PC端团购专区轮播广告位', 'PC端团购专区轮播广告位', '0', '0', '1', '440', '1200', '0', '0', '0', '', '', '1', '0', '1', 'PC_GROUP_BAY_SWIPER', '0', '1');
INSERT INTO `ns_platform_adv_position` VALUES ('6671', 'PC端专题活动轮播广告位', 'PC端专题活动轮播广告位', '0', '0', '1', '440', '1200', '0', '0', '0', '', '', '1', '0', '1', 'PC_TOPIC_SWIPER', '0', '1');
INSERT INTO `ns_platform_adv_position` VALUES ('6672', '手机端专题活动广告位', '手机端专题活动广告位', '0', '2', '1', '0', '0', '0', '0', '0', '', '', '2', '0', '1', 'WAP_TOPIC_SWIPER', '0', '1');
INSERT INTO `ns_platform_adv_position` VALUES ('6681', 'PC端首页限时折扣轮播图广告位', 'PC端首页限时折扣轮播图广告位', '0', '2', '1', '440', '1200', '0', '0', '0', '', '', '1', '0', '1', 'PC_INDEX_DISCOUNT', '0', '1');
INSERT INTO `ns_platform_adv_position` VALUES ('6682', 'PC端领券中心轮播图广告位', 'PC端领券中心轮播图广告位', '0', '2', '1', '406', '810', '0', '0', '0', '', '', '1', '0', '1', 'PC_COUPON_SWIPER', '0', '1');
INSERT INTO `ns_platform_adv_position` VALUES ('6684', '手机端团购专区轮播图广告位', '手机端团购专区轮播图广告位', '0', '2', '1', '0', '0', '0', '0', '0', '', '', '2', '0', '1', 'WAP_GROUP_BAY_SWIPER', '0', '1');

-- ----------------------------
-- Table structure for `ns_platform_block`
-- ----------------------------
DROP TABLE IF EXISTS `ns_platform_block`;
CREATE TABLE `ns_platform_block` (
  `block_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_display` smallint(4) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `block_color` varchar(255) NOT NULL COMMENT '颜色风格',
  `sort` int(11) DEFAULT NULL,
  `block_name` varchar(50) NOT NULL DEFAULT '' COMMENT '板块名称',
  `block_short_name` varchar(50) DEFAULT NULL COMMENT '板块简称',
  `recommend_ad_image_name` varchar(50) NOT NULL DEFAULT '' COMMENT '推荐单图广告位名称',
  `recommend_ad_image` int(11) NOT NULL DEFAULT '0' COMMENT '推荐单图广告位',
  `recommend_ad_slide_name` varchar(50) NOT NULL DEFAULT '' COMMENT '推荐幻灯广告位名称',
  `recommend_ad_slide` int(11) NOT NULL COMMENT '推荐幻灯广告位',
  `recommend_ad_images_name` varchar(255) NOT NULL DEFAULT '0' COMMENT '推荐多图广告位名称',
  `recommend_ad_images` int(11) NOT NULL DEFAULT '0' COMMENT '推荐多图广告位',
  `recommend_brands` varchar(255) NOT NULL DEFAULT '' COMMENT '推荐品牌',
  `recommend_categorys` varchar(255) NOT NULL DEFAULT '' COMMENT '推荐商品分类',
  `recommend_goods_category_name_1` varchar(50) NOT NULL DEFAULT '' COMMENT '推荐分类商品别名',
  `recommend_goods_category_1` int(11) NOT NULL DEFAULT '0' COMMENT '推荐显示商品分类',
  `recommend_goods_category_name_2` varchar(50) NOT NULL DEFAULT '' COMMENT '推荐分类商品别名',
  `recommend_goods_category_2` int(11) NOT NULL DEFAULT '0' COMMENT '推荐显示商品分类',
  `recommend_goods_category_name_3` varchar(50) NOT NULL DEFAULT '' COMMENT '推荐分类商品别名',
  `recommend_goods_category_3` int(11) NOT NULL DEFAULT '0' COMMENT '推荐显示商品分类',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `block_data` longtext COMMENT '板块数据',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`block_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2340 COMMENT='首页促销板块';

-- ----------------------------
-- Records of ns_platform_block
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_platform_goods_recommend`
-- ----------------------------
DROP TABLE IF EXISTS `ns_platform_goods_recommend`;
CREATE TABLE `ns_platform_goods_recommend` (
  `recommend_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `goods_id` int(11) NOT NULL COMMENT '推荐商品ID',
  `state` int(11) NOT NULL DEFAULT '1' COMMENT '推荐状态',
  `class_id` int(11) NOT NULL DEFAULT '1' COMMENT '推荐类型',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`recommend_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=442 COMMENT='平台商品推荐';

-- ----------------------------
-- Records of ns_platform_goods_recommend
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_platform_goods_recommend_class`
-- ----------------------------
DROP TABLE IF EXISTS `ns_platform_goods_recommend_class`;
CREATE TABLE `ns_platform_goods_recommend_class` (
  `class_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `class_name` varchar(50) NOT NULL DEFAULT '' COMMENT '类型名称',
  `class_type` int(11) NOT NULL DEFAULT '1' COMMENT '推荐模块1.系统固有模块2.平台增加模块',
  `is_use` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否使用',
  `sort` int(11) NOT NULL DEFAULT '255' COMMENT '排序号',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `show_type` int(11) NOT NULL DEFAULT '0' COMMENT '展示类型  0电脑端  1手机端',
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2340 COMMENT='店铺商品推荐类别';

-- ----------------------------
-- Records of ns_platform_goods_recommend_class
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_platform_help_class`
-- ----------------------------
DROP TABLE IF EXISTS `ns_platform_help_class`;
CREATE TABLE `ns_platform_help_class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '表主键',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '1.帮助类别2.会员协议类别3.开店协议类别',
  `class_name` varchar(50) NOT NULL DEFAULT '' COMMENT '类型名称',
  `parent_class_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序号',
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4096 COMMENT='平台说明类型';

-- ----------------------------
-- Records of ns_platform_help_class
-- ----------------------------
INSERT INTO `ns_platform_help_class` VALUES ('1', '1', '新手上路', '0', '1');
INSERT INTO `ns_platform_help_class` VALUES ('2', '1', '配送与支付', '0', '2');
INSERT INTO `ns_platform_help_class` VALUES ('3', '1', '会员中心', '0', '3');
INSERT INTO `ns_platform_help_class` VALUES ('4', '1', '服务保证', '0', '4');
INSERT INTO `ns_platform_help_class` VALUES ('5', '1', '联系我们', '0', '5');

-- ----------------------------
-- Table structure for `ns_platform_help_document`
-- ----------------------------
DROP TABLE IF EXISTS `ns_platform_help_document`;
CREATE TABLE `ns_platform_help_document` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '表主键',
  `uid` int(11) NOT NULL COMMENT '最后修改人ID',
  `class_id` int(11) NOT NULL COMMENT '所属说明类型ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '主题',
  `link_url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序号',
  `content` text NOT NULL COMMENT '内容',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modufy_time` int(11) DEFAULT '0' COMMENT '修改时间',
  `is_visibility` int(11) DEFAULT '1' COMMENT '是否可见',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1489 COMMENT='平台说明内容';

-- ----------------------------
-- Records of ns_platform_help_document
-- ----------------------------
INSERT INTO `ns_platform_help_document` VALUES ('2', '1', '2', '支付方式说明', '', '5', '<p>支付方式说明</p>', '', '0', '1493810155', '1');
INSERT INTO `ns_platform_help_document` VALUES ('3', '1', '3', '售后流程1', '', '1', '<p>sfdgfdsg</p>', '', '0', '1553074215', '1');
INSERT INTO `ns_platform_help_document` VALUES ('5', '1', '3', '资金管理', '', '6', '<p>资金管理</p>', '', '0', '1493964639', '1');
INSERT INTO `ns_platform_help_document` VALUES ('6', '2', '3', '我的收藏', '', '7', '<p>我的收藏</p>', '', '0', '1493809215', '1');
INSERT INTO `ns_platform_help_document` VALUES ('7', '2', '2', '货到付款区域', '', '3', '<p>货到付款区域</p>', '', '1487559901', '1493810113', '1');
INSERT INTO `ns_platform_help_document` VALUES ('8', '2', '2', '配送支付智能查询', '', '4', '<p>配送支付智能查询</p>', '', '1487559942', '1493810133', '1');
INSERT INTO `ns_platform_help_document` VALUES ('14', '1', '3', '我的订单', '', '8', '<p>我的订单</p>', '', '1493809066', '1497102958', '1');
INSERT INTO `ns_platform_help_document` VALUES ('18', '1', '1', '购物流程', '', '0', '<p><a href=\"http://nsqjb.niuteam.cn/index.php?s=/helpcenter/index&id=1\" title=\"购物流程\" target=\"_blank\" style=\"box-sizing: content-box; color: rgb(6, 137, 225); text-decoration: none; outline: none; cursor: pointer;\">购物流程<img src=\"/niushop_b2c_3/upload/ueditor/image/20190321/1553165235162048.png\" title=\"1553165235162048.png\" alt=\"shoptop.png\"/></a></p><p><br/></p>', '', '1550745560', '1553305015', '1');
INSERT INTO `ns_platform_help_document` VALUES ('21', '1', '1', '测试帮助', '', '0', '<p>1111222</p>', '', '1553165263', '1553165273', '1');

-- ----------------------------
-- Table structure for `ns_platform_link`
-- ----------------------------
DROP TABLE IF EXISTS `ns_platform_link`;
CREATE TABLE `ns_platform_link` (
  `link_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引id',
  `link_title` varchar(100) NOT NULL COMMENT '标题',
  `link_url` varchar(100) NOT NULL COMMENT '链接',
  `link_pic` varchar(100) NOT NULL COMMENT '图片',
  `link_sort` int(11) DEFAULT NULL,
  `is_blank` int(11) NOT NULL DEFAULT '1' COMMENT '是否新窗口打开 1.是 2.否',
  `is_show` int(11) NOT NULL DEFAULT '1' COMMENT '是否显示 1.是 2.否',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=50 COMMENT='友情链接表';

-- ----------------------------
-- Records of ns_platform_link
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_point_config`
-- ----------------------------
DROP TABLE IF EXISTS `ns_point_config`;
CREATE TABLE `ns_point_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(11) NOT NULL COMMENT '店铺ID',
  `is_open` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否启动',
  `convert_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '1积分对应金额',
  `desc` text NOT NULL COMMENT '积分说明',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='积分设置表';

-- ----------------------------
-- Records of ns_point_config
-- ----------------------------
INSERT INTO `ns_point_config` VALUES ('1', '0', '0', '0.00', '', '1555481593', '0');

-- ----------------------------
-- Table structure for `ns_promotion_bargain`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_bargain`;
CREATE TABLE `ns_promotion_bargain` (
  `bargain_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `bargain_name` varchar(50) NOT NULL DEFAULT '' COMMENT '活动名称',
  `shop_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺编号',
  `shop_name` varchar(50) NOT NULL DEFAULT '' COMMENT '店铺名称',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '活动状态(0-未发布/1-正常/3-关闭/4-结束)',
  `remark` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '活动开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '活动结束时间',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `bargain_min_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '可砍到商品价格最低比例',
  `bargain_min_number` int(11) NOT NULL DEFAULT '0' COMMENT '最少需要砍到的次数',
  `one_min_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '自己砍的最低价格的百分比',
  `one_max_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '自己砍的最高价格的百分比',
  PRIMARY KEY (`bargain_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='砍价活动表';

-- ----------------------------
-- Records of ns_promotion_bargain
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_bargain_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_bargain_goods`;
CREATE TABLE `ns_promotion_bargain_goods` (
  `bargain_goods_id` int(11) NOT NULL AUTO_INCREMENT,
  `bargain_id` int(11) NOT NULL DEFAULT '0' COMMENT '活动id',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `goods_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_picture` varchar(255) NOT NULL DEFAULT '' COMMENT '商品图片',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '活动状态',
  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `fictitious_sales` int(11) NOT NULL DEFAULT '0' COMMENT '虚拟销量',
  `sales` int(11) NOT NULL DEFAULT '0' COMMENT '真实销量',
  `partake_number` int(11) NOT NULL DEFAULT '0' COMMENT '参与人数',
  `bargain_min_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '可砍到最低价格百分比',
  `one_min_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '自己砍的最低价格的百分比',
  `one_max_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '自己砍的最高价格的百分比',
  `bargain_min_number` int(11) NOT NULL DEFAULT '0' COMMENT '最少需要砍到的次数',
  PRIMARY KEY (`bargain_goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='砍价商品表';

-- ----------------------------
-- Records of ns_promotion_bargain_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_bargain_launch`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_bargain_launch`;
CREATE TABLE `ns_promotion_bargain_launch` (
  `launch_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '发起人',
  `bargain_id` int(11) NOT NULL DEFAULT '0' COMMENT '活动id',
  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '发起时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `receiver_mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '收货人的手机号码',
  `receiver_province` int(11) NOT NULL COMMENT '收货人所在省',
  `receiver_city` int(11) NOT NULL COMMENT '收货人所在城市',
  `receiver_district` int(11) NOT NULL COMMENT '收货人所在街道',
  `receiver_address` varchar(255) NOT NULL DEFAULT '' COMMENT '收货人详细地址',
  `receiver_zip` varchar(6) NOT NULL DEFAULT '' COMMENT '收货人邮编',
  `receiver_name` varchar(50) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `goods_money` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `bargain_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '砍价金额',
  `surplus_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '剩余金额',
  `partake_number` int(11) NOT NULL DEFAULT '0' COMMENT '参与人数',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态 1活动时间 2活动结束 -1取消',
  `sku_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品规格id',
  `bargain_min_number` int(11) NOT NULL DEFAULT '0' COMMENT '最少需要砍到的次数',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `bargain_min_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '可砍到的最低金额',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `shipping_type` int(1) NOT NULL DEFAULT '1' COMMENT '配送方式 1物流配送 2自提配送',
  `pick_up_id` int(11) NOT NULL DEFAULT '0' COMMENT '自提点id',
  `bargain_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '有没有返回库存 0 （没有） 1（以反）',
  PRIMARY KEY (`launch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1820 COMMENT='砍价发起表';

-- ----------------------------
-- Records of ns_promotion_bargain_launch
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_bargain_partake`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_bargain_partake`;
CREATE TABLE `ns_promotion_bargain_partake` (
  `partake_id` int(11) NOT NULL AUTO_INCREMENT,
  `launch_id` int(11) NOT NULL DEFAULT '0' COMMENT '发起砍价的id',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '参与人',
  `bargain_money` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '砍掉的金额',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '参与时间',
  `partake_json` varchar(255) NOT NULL DEFAULT '' COMMENT '参与人的基础信息',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '说明',
  PRIMARY KEY (`partake_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=364 COMMENT='砍价参与表';

-- ----------------------------
-- Records of ns_promotion_bargain_partake
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_bundling`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_bundling`;
CREATE TABLE `ns_promotion_bundling` (
  `bl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '组合ID',
  `bl_name` varchar(50) NOT NULL COMMENT '组合名称',
  `shop_id` int(11) NOT NULL COMMENT '店铺id',
  `shop_name` varchar(100) NOT NULL COMMENT '店铺名称',
  `bl_price` decimal(10,2) NOT NULL COMMENT '商品组合价格',
  `shipping_fee_type` tinyint(1) NOT NULL COMMENT '运费承担方式 1卖家承担运费 2买家承担运费',
  `shipping_fee` decimal(10,2) NOT NULL COMMENT '运费',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '组合状态 0-关闭/1-开启',
  PRIMARY KEY (`bl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='组合销售活动表';

-- ----------------------------
-- Records of ns_promotion_bundling
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_bundling_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_bundling_goods`;
CREATE TABLE `ns_promotion_bundling_goods` (
  `bl_goods_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '组合商品id',
  `bl_id` int(11) NOT NULL COMMENT '组合id',
  `goods_id` int(10) unsigned NOT NULL COMMENT '商品id',
  `goods_name` varchar(50) NOT NULL COMMENT '商品名称',
  `goods_picture` varchar(100) NOT NULL COMMENT '商品图片',
  `bl_goods_price` decimal(10,2) NOT NULL COMMENT '商品组合价格',
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`bl_goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='组合销售活动商品表';

-- ----------------------------
-- Records of ns_promotion_bundling_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_discount`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_discount`;
CREATE TABLE `ns_promotion_discount` (
  `discount_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(11) NOT NULL DEFAULT '1' COMMENT '店铺ID',
  `shop_name` varchar(50) NOT NULL DEFAULT '' COMMENT '店铺名称',
  `discount_name` varchar(255) NOT NULL DEFAULT '' COMMENT '活动名称',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '活动状态(0-未发布/1-正常/3-关闭/4-结束)',
  `remark` text NOT NULL COMMENT '备注',
  `start_time` int(11) DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) DEFAULT '0' COMMENT '结束时间',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  `decimal_reservation_number` int(2) NOT NULL DEFAULT '-1' COMMENT '价格保留方式 0去掉角和分 1去掉分',
  PRIMARY KEY (`discount_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4096 COMMENT='限时折扣';

-- ----------------------------
-- Records of ns_promotion_discount
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_discount_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_discount_goods`;
CREATE TABLE `ns_promotion_discount_goods` (
  `discount_goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `discount_id` int(11) NOT NULL COMMENT '对应活动',
  `goods_id` int(11) NOT NULL COMMENT '商品ID',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `discount` decimal(10,2) NOT NULL COMMENT '活动折扣或者减现信息',
  `goods_name` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_picture` int(11) NOT NULL COMMENT '商品图片',
  `start_time` int(11) DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) DEFAULT '0' COMMENT '结束时间',
  `decimal_reservation_number` int(2) NOT NULL DEFAULT '-1' COMMENT '价格保留方式 0去掉角和分 1去掉分',
  PRIMARY KEY (`discount_goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=712 COMMENT='限时折扣商品列表';

-- ----------------------------
-- Records of ns_promotion_discount_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_full_mail`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_full_mail`;
CREATE TABLE `ns_promotion_full_mail` (
  `mail_id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `is_open` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启 0未开启 1已开启',
  `full_mail_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '包邮所需订单金额',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '更新时间',
  `no_mail_province_id_array` text NOT NULL COMMENT '不包邮省id组',
  `no_mail_city_id_array` text NOT NULL COMMENT '不包邮市id组',
  PRIMARY KEY (`mail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='满额包邮';

-- ----------------------------
-- Records of ns_promotion_full_mail
-- ----------------------------
INSERT INTO `ns_promotion_full_mail` VALUES ('1', '0', '0', '0.00', '0', '0', '', '');

-- ----------------------------
-- Table structure for `ns_promotion_games`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_games`;
CREATE TABLE `ns_promotion_games` (
  `game_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '游戏id',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '游戏活动名称',
  `game_type` int(11) NOT NULL DEFAULT '1' COMMENT '游戏类型',
  `member_level` varchar(255) NOT NULL DEFAULT '0' COMMENT '参与的会员等级0表示全部参与',
  `level_name` varchar(255) NOT NULL DEFAULT '' COMMENT '参与活动会员名称',
  `points` int(11) NOT NULL DEFAULT '0' COMMENT '参与一次扣除积分',
  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '活动开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '活动结束时间',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '活动状态 0未开始 1已开始 -1已结束 -2已关闭',
  `remark` varchar(1000) NOT NULL DEFAULT '' COMMENT '活动说明',
  `winning_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '中奖率',
  `no_winning_des` varchar(255) NOT NULL DEFAULT '' COMMENT '未中奖说明',
  `activity_images` varchar(255) DEFAULT '' COMMENT '活动图片，只有上传了活动图，才会在首页显示',
  `winning_list_display` int(11) NOT NULL DEFAULT '0' COMMENT '中奖名单是否显示 0不显示 1显示',
  `join_type` int(11) NOT NULL DEFAULT '0' COMMENT '参加类型 0 次/活动全过程 1 次/每天',
  `join_frequency` int(11) NOT NULL DEFAULT '1' COMMENT '根据类型计算参加次数',
  `winning_type` int(11) NOT NULL DEFAULT '0' COMMENT '中奖类型 0 次/活动全过程 1 次/每天',
  `winning_max` int(11) NOT NULL DEFAULT '1' COMMENT '根据类型计算中奖最大限制',
  PRIMARY KEY (`game_id`),
  KEY `IDX_ns_promotion_games_end_time` (`end_time`),
  KEY `IDX_ns_promotion_games_start_time` (`start_time`),
  KEY `IDX_ns_promotion_games_status` (`status`),
  KEY `IDX_ns_promotion_games_type` (`game_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='营销游戏（概率游戏）';

-- ----------------------------
-- Records of ns_promotion_games
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_games_winning_records`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_games_winning_records`;
CREATE TABLE `ns_promotion_games_winning_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) NOT NULL DEFAULT '0' COMMENT '会员id',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `is_use` int(11) NOT NULL DEFAULT '0' COMMENT '是否使用',
  `game_id` int(11) NOT NULL DEFAULT '0' COMMENT '活动id',
  `game_type` int(11) NOT NULL DEFAULT '1' COMMENT '游戏类型1.大转盘2.刮刮乐3.九宫格',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '奖励类型1.积分2.优惠券3.红包4.赠品...',
  `points` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '奖励积分',
  `hongbao` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '红包数（余额）',
  `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '奖励优惠券',
  `gift_id` int(11) NOT NULL DEFAULT '0' COMMENT '赠品id',
  `remark` varchar(1000) NOT NULL DEFAULT '' COMMENT '说明',
  `is_winning` smallint(1) NOT NULL DEFAULT '0' COMMENT '该次是否中奖 0未中奖  1中奖',
  `nick_name` varchar(50) NOT NULL DEFAULT '' COMMENT '会员昵称',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `rule_id` int(11) NOT NULL DEFAULT '0' COMMENT '奖项id',
  `associated_gift_record_id` int(11) DEFAULT '0' COMMENT '关联赠品记录id',
  PRIMARY KEY (`id`),
  KEY `IDX_ns_promotion_games_winning_records_coupon_id` (`coupon_id`),
  KEY `IDX_ns_promotion_games_winning_records_game_id` (`game_id`),
  KEY `IDX_ns_promotion_games_winning_records_gift_id` (`gift_id`),
  KEY `IDX_ns_promotion_games_winning_records_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=169 COMMENT='获奖记录';

-- ----------------------------
-- Records of ns_promotion_games_winning_records
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_game_rule`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_game_rule`;
CREATE TABLE `ns_promotion_game_rule` (
  `rule_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id',
  `game_id` int(11) NOT NULL DEFAULT '0' COMMENT '游戏id',
  `rule_num` int(11) NOT NULL DEFAULT '0' COMMENT '奖品数量',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '奖励类型1. 积分 2. 优惠券3.红包4.赠品...',
  `coupon_type_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券类型id',
  `points` int(11) NOT NULL DEFAULT '0' COMMENT '奖励积分数',
  `hongbao` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '奖励红包数',
  `gift_id` int(11) NOT NULL DEFAULT '0' COMMENT '赠品id',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '规则关键字',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `rule_name` varchar(50) NOT NULL DEFAULT '' COMMENT '奖励规则等级',
  `type_value` varchar(255) NOT NULL DEFAULT '' COMMENT '奖励的具体的对应信息名称',
  `remaining_number` int(11) DEFAULT '0' COMMENT '剩余奖品数量',
  PRIMARY KEY (`rule_id`),
  KEY `IDX_ns_promotion_game_rule_coupon_type_id` (`coupon_type_id`),
  KEY `IDX_ns_promotion_game_rule_game_id` (`game_id`),
  KEY `IDX_ns_promotion_game_rule_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=3276 COMMENT='游戏活动规则';

-- ----------------------------
-- Records of ns_promotion_game_rule
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_game_type`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_game_type`;
CREATE TABLE `ns_promotion_game_type` (
  `game_type` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) NOT NULL DEFAULT '' COMMENT '类型名称',
  `type_image` varchar(255) NOT NULL DEFAULT '' COMMENT '活动类型默认背景图',
  `type_ico` varchar(255) NOT NULL DEFAULT '' COMMENT '活动小图标',
  `type_des` varchar(255) NOT NULL DEFAULT '' COMMENT '活动介绍',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_complete` int(11) NOT NULL DEFAULT '0' COMMENT '是否完成',
  `game_text` text NOT NULL,
  PRIMARY KEY (`game_type`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1638 COMMENT='营销游戏类型';

-- ----------------------------
-- Records of ns_promotion_game_type
-- ----------------------------
INSERT INTO `ns_promotion_game_type` VALUES ('1', '签到', 'games/promotion_game_guaguale.png', 'games/a9823df5d5cf4d748e1aa4ee47dee075.png', '每日签到领取积分或奖励', '0', '0', '<div class=\"app-preview\">\r\n			<div class=\"app-header\"></div>\r\n			<div class=\"app-entry\">\r\n				<div class=\"app-config\">\r\n					<div class=\"app-field\">\r\n\r\n						<h1>刮刮卡</h1>\r\n\r\n					</div>\r\n				</div>\r\n				<div class=\"snapshot-wrap\">\r\n					<div>\r\n						<div class=\"apps-cards-wrap\">\r\n							<div class=\"apps-cards\">\r\n								<div class=\"logo\"></div>\r\n\r\n								<div class=\"scratch-wrap\">\r\n									<div class=\"result-area\">\r\n										<div class=\"face-area\"></div>\r\n										<div class=\"result-content-wap\">\r\n											<p class=\"result-title\">真遗憾，未中奖！</p>\r\n											<p class=\"result-content\"></p>\r\n										</div>\r\n									</div>\r\n									<div class=\"scratch-area\">\r\n										<div\r\n											style=\"position: relative; width: 255px; height: 145px; cursor: default;\"></div>\r\n									</div>\r\n								</div>\r\n\r\n								<div class=\"info-area\">\r\n									<ul class=\"activity-info\">\r\n										<li>1.活动有效时间：\r\n											<div class=\"activity-info-content\">\r\n												<span data-name=\"start_time\">无</span> 至 <span\r\n													data-name=\"end_time\">无</span>\r\n											</div>\r\n										</li>\r\n\r\n										<li>2.发行方：\r\n											<div class=\"activity-info-content\" data-name=\"team_name\">大转盘</div>\r\n										</li>\r\n\r\n										<p class=\"activity-note\">\r\n											备注：中奖积分请到<span class=\"snapshot-user-center\">会员主页</span>查看<br>\r\n											<span style=\"width: 3em; display: inline-block\"></span>中奖奖品请到我的奖品查看\r\n										</p>\r\n									</ul>\r\n								</div>\r\n								<div class=\"bottom-button-area\">\r\n									<div class=\"bottom-button\">我的奖品</div>\r\n									<div class=\"bottom-button\">进店逛逛</div>\r\n								</div>\r\n							</div>\r\n						</div>\r\n					</div>\r\n				</div>\r\n			</div>\r\n		</div>');
INSERT INTO `ns_promotion_game_type` VALUES ('2', '投票调查', 'games/promotion_game_guaguale.png', 'games/32b16300c47fdea92d1efdc87189e640.png', '创建在线投票调查页面', '1', '0', '');
INSERT INTO `ns_promotion_game_type` VALUES ('3', '刮刮卡', 'games/promotion_game_guaguale.png', 'games/b4c30bad203a9ad37c92b7c52d5d422d.png', '通过刮开卡片进行抽奖的玩法', '2', '1', '<div class=\"app-preview\">\r\n			<div class=\"app-header\"></div>\r\n			<div class=\"app-entry\">\r\n				<div class=\"app-config\">\r\n					<div class=\"app-field\">\r\n\r\n						<h1>刮刮卡</h1>\r\n\r\n					</div>\r\n				</div>\r\n				<div class=\"snapshot-wrap\">\r\n					<div>\r\n						<div class=\"apps-cards-wrap\">\r\n							<div class=\"apps-cards\">\r\n								<div class=\"logo\"></div>\r\n\r\n								<div class=\"scratch-wrap\">\r\n									<div class=\"result-area\">\r\n										<div class=\"face-area\"></div>\r\n										<div class=\"result-content-wap\">\r\n											<p class=\"result-title\">真遗憾，未中奖！</p>\r\n											<p class=\"result-content\"></p>\r\n										</div>\r\n									</div>\r\n									<div class=\"scratch-area\">\r\n										<div\r\n											style=\"position: relative; width: 255px; height: 145px; cursor: default;\"></div>\r\n									</div>\r\n								</div>\r\n\r\n								<div class=\"info-area\">\r\n									<ul class=\"activity-info\">\r\n										<li>1.活动有效时间：\r\n											<div class=\"activity-info-content\">\r\n												<span data-name=\"start_time\">无</span> 至 <span\r\n													data-name=\"end_time\">无</span>\r\n											</div>\r\n										</li>\r\n\r\n										<li>2.发行方：\r\n											<div class=\"activity-info-content\" data-name=\"team_name\">大转盘</div>\r\n										</li>\r\n\r\n										<p class=\"activity-note\">\r\n											备注：中奖积分请到<span class=\"snapshot-user-center\">会员主页</span>查看<br>\r\n											<span style=\"width: 3em; display: inline-block\"></span>中奖奖品请到我的奖品查看\r\n										</p>\r\n									</ul>\r\n								</div>\r\n								<div class=\"bottom-button-area\">\r\n									<div class=\"bottom-button\">我的奖品</div>\r\n									<div class=\"bottom-button\">进店逛逛</div>\r\n								</div>\r\n							</div>\r\n						</div>\r\n					</div>\r\n				</div>\r\n			</div>\r\n		</div>');
INSERT INTO `ns_promotion_game_type` VALUES ('4', '疯狂猜', '', 'games/c974f8863a1d61b2425eea388444ce3c.png', '回答问题，按答题情况给奖励', '3', '0', '');
INSERT INTO `ns_promotion_game_type` VALUES ('5', '生肖翻翻看', '', 'games/4c799b9f1a51e9edf57fa49229c814b5.png', '通过翻卡片进行抽奖的玩法', '4', '0', '');
INSERT INTO `ns_promotion_game_type` VALUES ('6', '分场次即时抽奖', '', 'games/cb1c557a9cab0117999b370dc7eaa7e1.png', '多个场次，⽴即抽奖', '5', '0', '');
INSERT INTO `ns_promotion_game_type` VALUES ('7', '幸运砸蛋', 'games/promotion_game_zadan.png', 'games/03aa1ac9b94e2b9c47f47360e98c25c0.png', '好运砸出来', '6', '1', '');
INSERT INTO `ns_promotion_game_type` VALUES ('8', '幸运大抽奖', 'games/promotion_game_dazhuanpan.png', 'games/57ebd7f399284e9eb7f2a779bec77362.png', '常见的转盘式抽奖玩法', '7', '1', '<div class=\"app-preview\">\r\n			<div class=\"app-header\"></div>\r\n			<div class=\"app-entry\">\r\n				<div class=\"app-config\">\r\n					<div class=\"app-field\">\r\n\r\n						<h1>幸运大抽奖</h1>\r\n\r\n					</div>\r\n				</div>\r\n				<div class=\"snapshot-wrap\">\r\n					<div>\r\n						<div class=\"apps-wheel-wrap\">\r\n							<div class=\"apps-wheel\">\r\n								<div class=\"logo\"></div>\r\n								<div class=\"wheel-wrap\">\r\n									<ul class=\"wheel\">\r\n										<li class=\"wheel-row-wrap\">\r\n											<ul class=\"wheel-row\">\r\n												<li class=\"wheel-block prize4\" data-index=\"0\">\r\n													<div class=\"wheel-icon\"></div>\r\n												</li>\r\n												<li class=\"wheel-block even prize-again\" data-index=\"1\">\r\n													<div class=\"wheel-icon\"></div>\r\n												</li>\r\n												<li class=\"wheel-block prize2\" data-index=\"2\">\r\n													<div class=\"wheel-icon\"></div>\r\n												</li>\r\n												<li class=\"wheel-block even prize3\" data-index=\"3\">\r\n													<div class=\"wheel-icon\"></div>\r\n												</li>\r\n											</ul>\r\n										</li>\r\n										<li class=\"wheel-row-wrap\">\r\n											<ul class=\"wheel-row wheel-sep-row\">\r\n												<li class=\"wheel-block even prize-again\" data-index=\"11\">\r\n													<div class=\"wheel-icon\"></div>\r\n												</li>\r\n												<li class=\"wheel-block prize-no\" data-index=\"4\">\r\n													<div class=\"wheel-icon\"></div>\r\n												</li>\r\n											</ul>\r\n										</li>\r\n										<li class=\"wheel-row-wrap\">\r\n											<ul class=\"wheel-row wheel-sep-row\">\r\n												<li class=\"wheel-block prize3\" data-index=\"10\">\r\n													<div class=\"wheel-icon\"></div>\r\n												</li>\r\n												<li class=\"wheel-block even prize1\" data-index=\"5\">\r\n													<div class=\"wheel-icon\"></div>\r\n												</li>\r\n											</ul>\r\n										</li>\r\n										<li class=\"wheel-row-wrap\">\r\n											<ul class=\"wheel-row\">\r\n												<li class=\"wheel-block even prize-no\" data-index=\"9\">\r\n													<div class=\"wheel-icon\"></div>\r\n												</li>\r\n												<li class=\"wheel-block prize2\" data-index=\"8\">\r\n													<div class=\"wheel-icon\"></div>\r\n												</li>\r\n												<li class=\"wheel-block even prize-again\" data-index=\"7\">\r\n													<div class=\"wheel-icon\"></div>\r\n												</li>\r\n												<li class=\"wheel-block prize4\" data-index=\"6\">\r\n													<div class=\"wheel-icon\"></div>\r\n												</li>\r\n											</ul>\r\n										</li>\r\n									</ul>\r\n									<div class=\"middle-button-area\">\r\n										<div class=\"middle-button js-start-btn\"></div>\r\n									</div>\r\n								</div>\r\n\r\n								<div class=\"info-area\">\r\n									<div class=\"view-prize\">查看奖品</div>\r\n									<ul class=\"activity-info\">\r\n										<li>1.活动有效时间：\r\n											<div class=\"activity-info-content\">\r\n												<span data-name=\"start_time\">2018-01-30 00:00:00</span> 至 <span\r\n													data-name=\"end_time\">2018-01-31 00:00:00</span>\r\n											</div>\r\n										</li>\r\n\r\n										<li>2.活动说明：\r\n											<div class=\"activity-info-content\" data-name=\"notice\">11</div>\r\n										</li>\r\n										<li>3.发行方：\r\n											<div class=\"activity-info-content\" data-name=\"team_name\">大转盘</div>\r\n										</li>\r\n\r\n									</ul>\r\n								</div>\r\n							</div>\r\n						</div>\r\n					</div>\r\n				</div>\r\n			</div>\r\n		</div>');
INSERT INTO `ns_promotion_game_type` VALUES ('9', '摇一摇', '', 'games/550ff65e15ef30d0d21db4dcad4ce49a.png', '让客户摇一摇，进行抽奖', '8', '0', '<div class=\"app-preview\">\r\n			<div class=\"app-header\"></div>\r\n			<div class=\"app-entry\">\r\n				<div class=\"app-config\">\r\n					<div class=\"app-field\">\r\n\r\n						<h1>摇一摇</h1>\r\n\r\n					</div>\r\n				</div>\r\n				<div class=\"snapshot-wrap\">\r\n					<div>\r\n						<div class=\"apps-shake-wrap\">\r\n							<div class=\"apps-shake\">\r\n								<div class=\"wheel-wrap\">\r\n									<div class=\"shake-box-container\">\r\n										<div class=\"shake-box disabled\">\r\n											<div class=\"cap cap-animate\"></div>\r\n											<div class=\"light\"></div>\r\n											<div class=\"btm\"></div>\r\n										</div>\r\n									</div>\r\n									<div class=\"desc-container\">\r\n										<div class=\"how-to-desc text-center\">摇动手机, 打开宝箱赢取奖品</div>\r\n									</div>\r\n								</div>\r\n\r\n								<div class=\"info-area\">\r\n									<ul class=\"activity-info\">\r\n										<li>1.活动有效时间：\r\n											<div class=\"activity-info-content\">\r\n												<span data-name=\"start_time\">未填</span> 至 <span\r\n													data-name=\"end_time\">未填</span>\r\n											</div>\r\n										</li>\r\n\r\n										<li>2.活动说明：\r\n											<div class=\"activity-info-content\" data-name=\"notice\">无</div>\r\n										</li>\r\n\r\n									</ul>\r\n								</div>\r\n							</div>\r\n						</div>\r\n					</div>\r\n				</div>\r\n			</div>\r\n		</div>');
INSERT INTO `ns_promotion_game_type` VALUES ('10', '水果机', '', 'games/e145b01457e0f0b5f77e18acee6acc05.png', '水果方格转盘抽奖', '9', '0', '');

-- ----------------------------
-- Table structure for `ns_promotion_gift`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_gift`;
CREATE TABLE `ns_promotion_gift` (
  `gift_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '赠品活动id ',
  `days` int(10) unsigned NOT NULL COMMENT '领取有效期(多少天)',
  `max_num` varchar(50) NOT NULL COMMENT '领取限制(次/人 (0表示不限领取次数))',
  `shop_id` varchar(100) NOT NULL COMMENT '店铺id',
  `gift_name` varchar(255) NOT NULL COMMENT '赠品活动名称',
  `start_time` int(11) DEFAULT '0' COMMENT '赠品有效期开始时间',
  `end_time` int(11) DEFAULT '0' COMMENT '赠品有效期结束时间',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`gift_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='赠品活动表';

-- ----------------------------
-- Records of ns_promotion_gift
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_gift_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_gift_goods`;
CREATE TABLE `ns_promotion_gift_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id ',
  `gift_id` int(10) unsigned NOT NULL COMMENT '赠品id ',
  `goods_id` int(10) unsigned NOT NULL COMMENT '商品id',
  `goods_name` varchar(50) NOT NULL COMMENT '商品名称',
  `goods_picture` varchar(100) NOT NULL COMMENT '商品图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='商品赠品表';

-- ----------------------------
-- Records of ns_promotion_gift_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_gift_grant_records`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_gift_grant_records`;
CREATE TABLE `ns_promotion_gift_grant_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL COMMENT '店铺id',
  `uid` int(11) NOT NULL COMMENT '会员id',
  `nick_name` varchar(50) NOT NULL DEFAULT '' COMMENT '会员昵称',
  `gift_id` int(11) NOT NULL COMMENT '礼品id',
  `gift_name` varchar(255) NOT NULL DEFAULT '' COMMENT '礼品名称',
  `goods_name` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_picture` int(11) NOT NULL DEFAULT '0' COMMENT '商品图id',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '领取类型1.满减2.游戏...',
  `type_name` varchar(50) NOT NULL DEFAULT '' COMMENT '类型名称',
  `relate_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联id（订单id）',
  `remark` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2730 COMMENT='赠品发放记录';

-- ----------------------------
-- Records of ns_promotion_gift_grant_records
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_group_buy`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_group_buy`;
CREATE TABLE `ns_promotion_group_buy` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) NOT NULL COMMENT '活动名称',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '活动开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '活动结束时间',
  `max_num` int(11) NOT NULL DEFAULT '0' COMMENT '最大购买量',
  `min_num` int(11) NOT NULL DEFAULT '0' COMMENT '最小购买量',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '活动信息',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `modify_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='团购活动表';

-- ----------------------------
-- Records of ns_promotion_group_buy
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_group_buy_ladder`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_group_buy_ladder`;
CREATE TABLE `ns_promotion_group_buy_ladder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '团购id',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
  `group_price` decimal(19,2) NOT NULL DEFAULT '0.00' COMMENT '团购价格',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='团购阶梯价';

-- ----------------------------
-- Records of ns_promotion_group_buy_ladder
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_mansong`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_mansong`;
CREATE TABLE `ns_promotion_mansong` (
  `mansong_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '满送活动编号',
  `mansong_name` varchar(50) NOT NULL COMMENT '活动名称',
  `shop_id` int(10) unsigned NOT NULL COMMENT '店铺编号',
  `shop_name` varchar(50) NOT NULL COMMENT '店铺名称',
  `status` tinyint(1) unsigned NOT NULL COMMENT '活动状态(0-未发布/1-正常/3-关闭/4-结束)',
  `remark` varchar(200) NOT NULL COMMENT '备注',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1.普通优惠  2.多级优惠',
  `range_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1全部商品 0部分商品',
  `start_time` int(11) DEFAULT '0' COMMENT '活动开始时间',
  `end_time` int(11) DEFAULT '0' COMMENT '活动结束时间',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`mansong_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1638 COMMENT='满就送活动表';

-- ----------------------------
-- Records of ns_promotion_mansong
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_mansong_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_mansong_goods`;
CREATE TABLE `ns_promotion_mansong_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `mansong_id` int(11) NOT NULL COMMENT '满减送ID',
  `goods_id` int(11) NOT NULL COMMENT '商品ID',
  `goods_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_picture` varchar(255) NOT NULL DEFAULT '' COMMENT '商品图片',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '活动状态',
  `start_time` int(11) DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) DEFAULT '0' COMMENT '结束时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1489 COMMENT='满减送商品';

-- ----------------------------
-- Records of ns_promotion_mansong_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_mansong_rule`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_mansong_rule`;
CREATE TABLE `ns_promotion_mansong_rule` (
  `rule_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则编号',
  `mansong_id` int(10) unsigned NOT NULL COMMENT '活动编号',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '级别价格(满多少)',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '减现金优惠金额（减多少金额）',
  `free_shipping` tinyint(4) NOT NULL DEFAULT '0' COMMENT '免邮费',
  `give_point` int(11) NOT NULL DEFAULT '0' COMMENT '送积分数量（0表示不送）',
  `give_coupon` int(11) NOT NULL DEFAULT '0' COMMENT '送优惠券的id（0表示不送）',
  `gift_id` int(11) NOT NULL COMMENT '礼品(赠品)id',
  PRIMARY KEY (`rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1170 COMMENT='满就送活动规则表';

-- ----------------------------
-- Records of ns_promotion_mansong_rule
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_topic`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_topic`;
CREATE TABLE `ns_promotion_topic` (
  `topic_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(11) NOT NULL DEFAULT '1' COMMENT '店铺ID',
  `shop_name` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺名称',
  `topic_name` varchar(255) NOT NULL DEFAULT '' COMMENT '活动名称',
  `keyword` varchar(500) NOT NULL DEFAULT '' COMMENT '专题关键字',
  `desc` varchar(1000) NOT NULL DEFAULT '' COMMENT '专题描述',
  `picture_img` varchar(255) NOT NULL DEFAULT '' COMMENT '图像地址',
  `scroll_img` varchar(255) NOT NULL DEFAULT '' COMMENT '条幅图片',
  `background_img` varchar(255) NOT NULL DEFAULT '' COMMENT '背景图',
  `background_color` varchar(255) NOT NULL DEFAULT '' COMMENT '背景色',
  `introduce` text NOT NULL COMMENT '专题介绍',
  `wap_topic_template` varchar(255) NOT NULL DEFAULT '' COMMENT '手机自定义模板',
  `pc_topic_template` varchar(255) NOT NULL DEFAULT '' COMMENT '电脑端模板',
  `is_head` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示头部0.不显示1.显示',
  `is_foot` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示底部',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-未发布/1-正常/3-关闭/4-结束',
  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4096 COMMENT='专题活动表';

-- ----------------------------
-- Records of ns_promotion_topic
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_topic_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_topic_goods`;
CREATE TABLE `ns_promotion_topic_goods` (
  `topic_goods_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `topic_id` int(11) NOT NULL COMMENT '对应专题活动',
  `goods_id` int(11) NOT NULL COMMENT '商品ID',
  `goods_name` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_picture` int(11) NOT NULL COMMENT '商品图片',
  PRIMARY KEY (`topic_goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1638 COMMENT='专题活动商品表';

-- ----------------------------
-- Records of ns_promotion_topic_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_promotion_tuangou`
-- ----------------------------
DROP TABLE IF EXISTS `ns_promotion_tuangou`;
CREATE TABLE `ns_promotion_tuangou` (
  `tuangou_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '团购主表id',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `tuangou_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '团购价格',
  `tuangou_num` int(11) NOT NULL DEFAULT '0' COMMENT '团购人数',
  `tuangou_time` int(11) NOT NULL DEFAULT '0' COMMENT '团购有效期',
  `tuangou_type` int(11) NOT NULL DEFAULT '0' COMMENT '团购类型',
  `tuangou_content_json` varchar(1000) NOT NULL DEFAULT '' COMMENT '团购内容json',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `is_open` int(11) NOT NULL DEFAULT '0' COMMENT '是否启用',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  `is_show` int(11) NOT NULL DEFAULT '0' COMMENT '是否首页显示',
  PRIMARY KEY (`tuangou_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1489 COMMENT='团购主表';

-- ----------------------------
-- Records of ns_promotion_tuangou
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_reward_rule`
-- ----------------------------
DROP TABLE IF EXISTS `ns_reward_rule`;
CREATE TABLE `ns_reward_rule` (
  `shop_id` int(10) unsigned NOT NULL,
  `sign_point` int(11) NOT NULL DEFAULT '0' COMMENT '签到送积分',
  `share_point` int(11) NOT NULL DEFAULT '0' COMMENT '分享送积分',
  `reg_member_self_point` int(11) NOT NULL DEFAULT '0' COMMENT '注册会员 自己获得的积分',
  `reg_member_one_point` int(11) NOT NULL DEFAULT '0' COMMENT '注册会员 上级获得的积分',
  `reg_member_two_point` int(11) NOT NULL DEFAULT '0' COMMENT '注册会员 上上级获得的积分',
  `reg_member_three_point` int(11) NOT NULL DEFAULT '0' COMMENT '注册会员 上上上级获得的积分',
  `reg_promoter_self_point` int(11) NOT NULL DEFAULT '0' COMMENT '成为推广员 自己获得的积分',
  `reg_promoter_one_point` int(11) NOT NULL DEFAULT '0' COMMENT '成为推广员 上级获得的积分',
  `reg_promoter_two_point` int(11) NOT NULL DEFAULT '0' COMMENT '成为推广员 上上级获得的积分',
  `reg_promoter_three_point` int(11) NOT NULL DEFAULT '0' COMMENT '成为推广员 上上上级获得的积分',
  `reg_partner_self_point` int(11) NOT NULL DEFAULT '0' COMMENT '成为股东 自己获得的积分',
  `reg_partner_one_point` int(11) NOT NULL DEFAULT '0' COMMENT '成为股东 上级获得的积分',
  `reg_partner_two_point` int(11) NOT NULL DEFAULT '0' COMMENT '成为股东 上上级获得的积分',
  `reg_partner_three_point` int(11) NOT NULL DEFAULT '0' COMMENT '成为股东 上上上级获得的积分',
  `into_store_coupon` int(11) NOT NULL DEFAULT '0' COMMENT '进店领用优惠券  存入优惠券id(coupon_id)',
  `share_coupon` int(11) NOT NULL DEFAULT '0' COMMENT '分享领用优惠券  存入优惠券id(coupon_id)',
  `click_point` int(11) NOT NULL DEFAULT '0' COMMENT '点赞送积分',
  `comment_point` int(11) NOT NULL DEFAULT '0' COMMENT '评论送积分',
  `reg_coupon` int(11) NOT NULL DEFAULT '0' COMMENT '注册送优惠券id',
  `click_coupon` int(11) NOT NULL DEFAULT '0' COMMENT '点赞送优惠券id',
  `comment_coupon` int(11) NOT NULL DEFAULT '0' COMMENT '评论送优惠券id',
  `sign_coupon` int(11) NOT NULL DEFAULT '0' COMMENT '签到送优惠券id',
  PRIMARY KEY (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='奖励规则表';

-- ----------------------------
-- Records of ns_reward_rule
-- ----------------------------
INSERT INTO `ns_reward_rule` VALUES ('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `ns_reward_rule` VALUES ('1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `ns_shop`
-- ----------------------------
DROP TABLE IF EXISTS `ns_shop`;
CREATE TABLE `ns_shop` (
  `shop_id` int(11) NOT NULL COMMENT '店铺索引id',
  `shop_name` varchar(50) NOT NULL COMMENT '店铺名称',
  `shop_type` int(11) NOT NULL COMMENT '店铺类型等级',
  `uid` int(11) NOT NULL COMMENT '会员id',
  `shop_group_id` int(11) NOT NULL COMMENT '店铺分类',
  `shop_company_name` varchar(50) DEFAULT NULL COMMENT '店铺公司名称',
  `province_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '店铺所在省份ID',
  `city_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '店铺所在市ID',
  `shop_address` varchar(100) NOT NULL DEFAULT '' COMMENT '详细地区',
  `shop_zip` varchar(10) NOT NULL DEFAULT '' COMMENT '邮政编码',
  `shop_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '店铺状态，0关闭，1开启，2审核中',
  `shop_close_info` varchar(255) DEFAULT NULL COMMENT '店铺关闭原因',
  `shop_sort` int(11) NOT NULL DEFAULT '0' COMMENT '店铺排序',
  `shop_logo` varchar(255) DEFAULT NULL COMMENT '店铺logo',
  `shop_banner` varchar(255) DEFAULT NULL COMMENT '店铺横幅',
  `shop_avatar` varchar(150) DEFAULT NULL COMMENT '店铺头像',
  `shop_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺seo关键字',
  `shop_description` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺seo描述',
  `shop_qq` varchar(50) DEFAULT NULL COMMENT 'QQ',
  `shop_ww` varchar(50) DEFAULT NULL COMMENT '阿里旺旺',
  `shop_phone` varchar(20) DEFAULT NULL COMMENT '商家电话',
  `shop_domain` varchar(50) DEFAULT NULL COMMENT '店铺二级域名',
  `shop_domain_times` tinyint(1) unsigned DEFAULT '0' COMMENT '二级域名修改次数',
  `shop_recommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '推荐，0为否，1为是，默认为0',
  `shop_credit` int(10) NOT NULL DEFAULT '0' COMMENT '店铺信用',
  `shop_desccredit` float NOT NULL DEFAULT '0' COMMENT '描述相符度分数',
  `shop_servicecredit` float NOT NULL DEFAULT '0' COMMENT '服务态度分数',
  `shop_deliverycredit` float NOT NULL DEFAULT '0' COMMENT '发货速度分数',
  `shop_collect` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺收藏数量',
  `shop_stamp` varchar(200) DEFAULT NULL COMMENT '店铺印章',
  `shop_printdesc` varchar(500) DEFAULT NULL COMMENT '打印订单页面下方说明文字',
  `shop_sales` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺销售额（不计算退款）',
  `shop_account` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺账户余额',
  `shop_cash` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺可提现金额',
  `shop_workingtime` varchar(100) DEFAULT NULL COMMENT '工作时间',
  `live_store_name` varchar(255) DEFAULT NULL COMMENT '商铺名称',
  `live_store_address` varchar(255) DEFAULT NULL COMMENT '商家地址',
  `live_store_tel` varchar(255) DEFAULT NULL COMMENT '商铺电话',
  `live_store_bus` varchar(255) DEFAULT NULL COMMENT '公交线路',
  `shop_vrcode_prefix` char(3) DEFAULT NULL COMMENT '商家兑换码前缀',
  `store_qtian` tinyint(1) DEFAULT '0' COMMENT '7天退换',
  `shop_zhping` tinyint(1) DEFAULT '0' COMMENT '正品保障',
  `shop_erxiaoshi` tinyint(1) DEFAULT '0' COMMENT '两小时发货',
  `shop_tuihuo` tinyint(1) DEFAULT '0' COMMENT '退货承诺',
  `shop_shiyong` tinyint(1) DEFAULT '0' COMMENT '试用中心',
  `shop_shiti` tinyint(1) DEFAULT '0' COMMENT '实体验证',
  `shop_xiaoxie` tinyint(1) DEFAULT '0' COMMENT '消协保证',
  `shop_huodaofk` tinyint(1) DEFAULT '0' COMMENT '货到付款',
  `shop_free_time` varchar(10) DEFAULT NULL COMMENT '商家配送时间',
  `shop_region` varchar(50) DEFAULT NULL COMMENT '店铺默认配送区域',
  `recommend_uid` int(11) NOT NULL DEFAULT '0' COMMENT '推荐招商员用户id',
  `shop_qrcode` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺公众号',
  `shop_create_time` int(11) DEFAULT '0' COMMENT '店铺时间',
  `shop_end_time` int(11) DEFAULT '0' COMMENT '店铺关闭时间',
  PRIMARY KEY (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='店铺数据表';

-- ----------------------------
-- Records of ns_shop
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_shop_account`
-- ----------------------------
DROP TABLE IF EXISTS `ns_shop_account`;
CREATE TABLE `ns_shop_account` (
  `shop_id` int(11) NOT NULL,
  `shop_profit` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺总营业额',
  `shop_total_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺入账总额',
  `shop_proceeds` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺收益总额',
  `shop_platform_commission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台抽取店铺利润总额',
  `shop_withdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺提现总额',
  `shop_point` int(11) NOT NULL DEFAULT '0' COMMENT '店铺发放的积分总额',
  `shop_point_use` int(11) NOT NULL DEFAULT '0' COMMENT '会员已使用多少积分',
  PRIMARY KEY (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2340 COMMENT='店铺账户表';

-- ----------------------------
-- Records of ns_shop_account
-- ----------------------------
INSERT INTO `ns_shop_account` VALUES ('0', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0');

-- ----------------------------
-- Table structure for `ns_shop_ad`
-- ----------------------------
DROP TABLE IF EXISTS `ns_shop_ad`;
CREATE TABLE `ns_shop_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `ad_image` varchar(255) NOT NULL DEFAULT '' COMMENT '广告图片',
  `link_url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `type` int(1) NOT NULL DEFAULT '0' COMMENT '类型 0 -- pc端  1-- 手机端 ',
  `background` varchar(255) NOT NULL DEFAULT '#FFFFFF' COMMENT '背景色',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=5461 COMMENT='店铺广告设置';

-- ----------------------------
-- Records of ns_shop_ad
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_shop_coin_records`
-- ----------------------------
DROP TABLE IF EXISTS `ns_shop_coin_records`;
CREATE TABLE `ns_shop_coin_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL COMMENT '店铺ID',
  `num` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '购物币数量',
  `account_type` int(11) NOT NULL DEFAULT '1' COMMENT '增加或减少类型',
  `type_alis_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联ID',
  `is_display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `text` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='店铺购物币记录';

-- ----------------------------
-- Records of ns_shop_coin_records
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_shop_express_address`
-- ----------------------------
DROP TABLE IF EXISTS `ns_shop_express_address`;
CREATE TABLE `ns_shop_express_address` (
  `express_address_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '物流地址id',
  `shop_id` int(11) NOT NULL COMMENT '商铺id',
  `contact` varchar(100) NOT NULL DEFAULT '' COMMENT '联系人',
  `mobile` varchar(50) NOT NULL DEFAULT '' COMMENT '手机',
  `phone` varchar(50) NOT NULL DEFAULT '' COMMENT '电话',
  `company_name` varchar(100) NOT NULL DEFAULT '' COMMENT '公司名称',
  `province` smallint(6) NOT NULL DEFAULT '0' COMMENT '所在地省',
  `city` smallint(6) NOT NULL DEFAULT '0' COMMENT '所在地市',
  `district` smallint(6) NOT NULL DEFAULT '0' COMMENT '所在地区县',
  `zipcode` varchar(6) NOT NULL DEFAULT '' COMMENT '邮编',
  `address` varchar(100) NOT NULL DEFAULT '' COMMENT '详细地址',
  `is_consigner` tinyint(2) NOT NULL DEFAULT '0' COMMENT '发货地址标记',
  `is_receiver` tinyint(2) NOT NULL DEFAULT '0' COMMENT '收货地址标记',
  `create_date` int(11) DEFAULT '0' COMMENT '创建日期',
  `modify_date` int(11) DEFAULT '0' COMMENT '修改日期',
  PRIMARY KEY (`express_address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1092 COMMENT='物流地址';

-- ----------------------------
-- Records of ns_shop_express_address
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_shop_group`
-- ----------------------------
DROP TABLE IF EXISTS `ns_shop_group`;
CREATE TABLE `ns_shop_group` (
  `shop_group_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分组ID',
  `group_name` varchar(50) NOT NULL DEFAULT '' COMMENT '分组名称',
  `group_sort` int(11) NOT NULL DEFAULT '1' COMMENT '分组排序号',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`shop_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2730 COMMENT='店铺分组表';

-- ----------------------------
-- Records of ns_shop_group
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_shop_navigation`
-- ----------------------------
DROP TABLE IF EXISTS `ns_shop_navigation`;
CREATE TABLE `ns_shop_navigation` (
  `nav_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(11) NOT NULL COMMENT '店铺ID',
  `nav_title` varchar(255) NOT NULL DEFAULT '' COMMENT '导航名称',
  `nav_url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `type` int(1) NOT NULL DEFAULT '1' COMMENT '1pc端  2手机端',
  `sort` int(11) NOT NULL COMMENT '排序号',
  `align` int(11) NOT NULL DEFAULT '1' COMMENT '横向所在位置1 左  2  右',
  `nav_type` int(11) DEFAULT '1',
  `is_blank` int(11) DEFAULT '0',
  `template_name` varchar(255) DEFAULT '',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  `nav_icon` text NOT NULL COMMENT '导航图标',
  `is_show` smallint(1) NOT NULL DEFAULT '1' COMMENT '是否显示 1显示 0不显示',
  `applet_nav` varchar(255) NOT NULL DEFAULT '' COMMENT '小程序导航信息',
  PRIMARY KEY (`nav_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1489 COMMENT='店铺导航管理';

-- ----------------------------
-- Records of ns_shop_navigation
-- ----------------------------
INSERT INTO `ns_shop_navigation` VALUES ('2', '0', '首页', '/index', '2', '11', '0', '0', '0', '首页', '1523414701', '1552631203', 'upload/default/index_logo.png', '1', '{\"title\":\"\\u9996\\u9875\",\"url\":\"\\/pages\\/index\\/index\",\"type\":1,\"is_template\":1}');
INSERT INTO `ns_shop_navigation` VALUES ('3', '0', '商品分类', '/goods/category', '2', '11', '0', '0', '0', '商品分类', '1523414701', '0', 'upload/default/catalogue_logo.png', '1', '{\"title\":\"\\u5546\\u54c1\\u5206\\u7c7b\",\"url\":\"\\/pages\\/goods\\/goodsclassificationlist\\/goodsclassificationlist\",\"type\":1,\"is_template\":1}');
INSERT INTO `ns_shop_navigation` VALUES ('4', '0', '限时折扣', '/goods/discount', '2', '2', '0', '0', '0', '限时折扣', '1523414701', '1553774165', 'upload/default/discount_logo.png', '1', '{\"title\":\"\\u5546\\u54c1\\u5206\\u7c7b\",\"url\":\"\\/pages\\/index\\/discount\\/discount\",\"type\":2,\"is_template\":1}');
INSERT INTO `ns_shop_navigation` VALUES ('5', '0', '品牌专区', '/goods/brand', '2', '3', '0', '0', '0', '品牌专区', '1523414701', '1553774528', 'upload/default/brandarea_logo.png', '1', '{\"title\":\"\\u54c1\\u724c\\u4e13\\u533a\",\"url\":\"\\/pages\\/goods\\/brandlist\\/brandlist\",\"type\":2,\"is_template\":1}');
INSERT INTO `ns_shop_navigation` VALUES ('7', '0', '会员中心', '/member/index', '2', '5', '0', '0', '0', '会员中心', '1523414701', '1553773781', 'upload/default/member_logo.png', '1', '{\"title\":\"\\u4f1a\\u5458\\u4e2d\\u5fc3\",\"url\":\"\\/pages\\/member\\/member\\/member\",\"type\":1,\"is_template\":1}');
INSERT INTO `ns_shop_navigation` VALUES ('9', '0', '专题活动', '/goods/topic', '2', '7', '0', '0', '0', '专题活动', '1523414701', '0', 'upload/default/thematic_log.png', '1', '{\"title\":\"\\u4e13\\u9898\\u6d3b\\u52a8\",\"url\":\"\\/pages\\/goods\\/promotiontopic\\/promotiontopic\",\"type\":2,\"is_template\":1}');
INSERT INTO `ns_shop_navigation` VALUES ('10', '0', '团购专区', '/goods/groupbuy', '2', '8', '0', '0', '0', '团购专区', '1523414701', '0', 'upload/default/groupbuy_logo.png', '1', '{\"title\":\"\\u56e2\\u8d2d\\u4e13\\u533a\",\"url\":\"\\/pages\\/goods\\/grouppurchasezone\\/grouppurchasezone\",\"type\":2,\"is_template\":1}');
INSERT INTO `ns_shop_navigation` VALUES ('11', '0', '购物车', '/goods/cart', '2', '9', '0', '0', '0', '购物车', '1523414701', '0', 'upload/default/cart_logo.png ', '1', '{\"title\":\"\\u8d2d\\u7269\\u8f66\",\"url\":\"\\/pages\\/goods\\/cart\\/cart\",\"type\":1,\"is_template\":1}');
INSERT INTO `ns_shop_navigation` VALUES ('12', '0', '文章中心', '/article/lists', '2', '0', '0', '0', '1', '文章中心', '1525257393', '1553773739', 'upload/default/articlecenter_logo.png', '1', '{\"title\":\"\\u6587\\u7ae0\\u4e2d\\u5fc3\",\"url\":\"\\/pagesother\\/pages\\/articlecenter\\/articlecenter\",\"type\":2,\"is_template\":1}');
INSERT INTO `ns_shop_navigation` VALUES ('22', '0', '领券中心', '/goods/coupon', '1', '1', '0', '0', '0', '领券中心', '1553046861', '1553081557', '', '1', '');
INSERT INTO `ns_shop_navigation` VALUES ('23', '0', '限时折扣', '/goods/discount', '1', '4', '0', '0', '0', '限时折扣', '1553046882', '1553163155', '', '1', '');
INSERT INTO `ns_shop_navigation` VALUES ('24', '0', '品牌专区', '/goods/brand', '1', '0', '0', '0', '0', '品牌列表', '1553046896', '1553046896', '', '1', '');
INSERT INTO `ns_shop_navigation` VALUES ('25', '0', '积分中心', '/goods/point', '1', '0', '0', '0', '0', '积分中心', '1553046906', '1553046906', '', '1', '');
INSERT INTO `ns_shop_navigation` VALUES ('27', '0', '团购专区', 'goods/groupbuy', '1', '3', '0', '0', '0', '团购专区', '1553046932', '1553156253', '', '1', '');
INSERT INTO `ns_shop_navigation` VALUES ('28', '0', '专题活动', 'goods/topic', '1', '2', '0', '0', '0', '专题活动', '1553046944', '1553156230', '', '1', '');

-- ----------------------------
-- Table structure for `ns_shop_navigation_template`
-- ----------------------------
DROP TABLE IF EXISTS `ns_shop_navigation_template`;
CREATE TABLE `ns_shop_navigation_template` (
  `template_id` int(11) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(50) NOT NULL DEFAULT '' COMMENT '模板名称',
  `template_url` varchar(255) NOT NULL DEFAULT '' COMMENT '访问路径',
  `is_use` int(11) NOT NULL DEFAULT '1' COMMENT '是否有效',
  `use_type` int(11) NOT NULL COMMENT '1 shop端 2wap端',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `applet_template` varchar(255) NOT NULL DEFAULT '' COMMENT '小程序模板信息',
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=5461 COMMENT='导航 的 系统默认模板';

-- ----------------------------
-- Records of ns_shop_navigation_template
-- ----------------------------
INSERT INTO `ns_shop_navigation_template` VALUES ('1', '首页', '/index', '1', '1', '1497706628', '');
INSERT INTO `ns_shop_navigation_template` VALUES ('2', '限时折扣', '/goods/discount', '1', '1', '1497706628', '');
INSERT INTO `ns_shop_navigation_template` VALUES ('3', '品牌列表', '/goods/brand', '1', '1', '1497706628', '');
INSERT INTO `ns_shop_navigation_template` VALUES ('4', '积分中心', '/goods/point', '1', '1', '1500862994', '');
INSERT INTO `ns_shop_navigation_template` VALUES ('6', '领券中心', '/goods/coupon', '1', '1', '1518088055', '');
INSERT INTO `ns_shop_navigation_template` VALUES ('7', '团购专区', 'goods/groupbuy', '1', '1', '1523414688', '');
INSERT INTO `ns_shop_navigation_template` VALUES ('8', '专题活动', 'goods/topic', '1', '1', '1523414688', '');
INSERT INTO `ns_shop_navigation_template` VALUES ('9', '首页', '/index', '1', '2', '1523414700', '{\"title\":\"\\u9996\\u9875\",\"url\":\"\\/pages\\/index\\/index\",\"type\":1,\"is_template\":1}');
INSERT INTO `ns_shop_navigation_template` VALUES ('10', '商品分类', '/goods/category', '1', '2', '1523414700', '{\"title\":\"\\u5546\\u54c1\\u5206\\u7c7b\",\"url\":\"\\/pages\\/goods\\/goodsclassificationlist\\/goodsclassificationlist\",\"type\":1,\"is_template\":1}');
INSERT INTO `ns_shop_navigation_template` VALUES ('11', '限时折扣', '/goods/discount', '1', '2', '1523414700', '{\"title\":\"\\u5546\\u54c1\\u5206\\u7c7b\",\"url\":\"\\/pages\\/index\\/discount\\/discount\",\"type\":2,\"is_template\":1}');
INSERT INTO `ns_shop_navigation_template` VALUES ('12', '品牌专区', '/goods/brand', '1', '2', '1523414700', '{\"title\":\"\\u54c1\\u724c\\u4e13\\u533a\",\"url\":\"\\/pages\\/goods\\/brandlist\\/brandlist\",\"type\":2,\"is_template\":1}');
INSERT INTO `ns_shop_navigation_template` VALUES ('14', '会员中心', '/member/index', '1', '2', '1523414700', '{\"title\":\"\\u4f1a\\u5458\\u4e2d\\u5fc3\",\"url\":\"\\/pages\\/member\\/member\\/member\",\"type\":1,\"is_template\":1}');
INSERT INTO `ns_shop_navigation_template` VALUES ('16', '专题活动', '/goods/topic', '1', '2', '1523414700', '{\"title\":\"\\u4e13\\u9898\\u6d3b\\u52a8\",\"url\":\"\\/pages\\/goods\\/promotiontopic\\/promotiontopic\",\"type\":2,\"is_template\":1}');
INSERT INTO `ns_shop_navigation_template` VALUES ('17', '团购专区', '/goods/groupbuy', '1', '2', '1523414700', '{\"title\":\"\\u56e2\\u8d2d\\u4e13\\u533a\",\"url\":\"\\/pages\\/goods\\/grouppurchasezone\\/grouppurchasezone\",\"type\":2,\"is_template\":1}');
INSERT INTO `ns_shop_navigation_template` VALUES ('18', '购物车', '/goods/cart', '1', '2', '1523414700', '{\"title\":\"\\u8d2d\\u7269\\u8f66\",\"url\":\"\\/pages\\/goods\\/cart\\/cart\",\"type\":1,\"is_template\":1}');
INSERT INTO `ns_shop_navigation_template` VALUES ('19', '文章中心', '/article/lists', '1', '2', '1525257392', '{\"title\":\"\\u6587\\u7ae0\\u4e2d\\u5fc3\",\"url\":\"\\/pagesother\\/pages\\/articlecenter\\/articlecenter\",\"type\":2,\"is_template\":1}');
INSERT INTO `ns_shop_navigation_template` VALUES ('21', '会员中心', '/member/index', '1', '1', '0', '');
INSERT INTO `ns_shop_navigation_template` VALUES ('22', '购物车', '/goods/cart', '1', '1', '0', '');
INSERT INTO `ns_shop_navigation_template` VALUES ('23', '会员中心', '/member/index', '1', '2', '0', '');
INSERT INTO `ns_shop_navigation_template` VALUES ('24', '购物车', '/goods/cart', '1', '2', '0', '');

-- ----------------------------
-- Table structure for `ns_shop_order_account_records`
-- ----------------------------
DROP TABLE IF EXISTS `ns_shop_order_account_records`;
CREATE TABLE `ns_shop_order_account_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL COMMENT '店铺ID',
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `order_no` varchar(255) NOT NULL DEFAULT '' COMMENT '订单编号',
  `order_goods_id` int(11) NOT NULL COMMENT '订单项ID',
  `goods_pay_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单项实际支付金额',
  `rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品平台佣金比率',
  `shop_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺获取金额',
  `platform_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台获取金额',
  `is_refund` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否产生退款',
  `refund_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际退款金额',
  `shop_refund_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺扣减余额',
  `platform_refund_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台扣减余额',
  `is_issue` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否已经结算',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=655 COMMENT='店铺针对订单的金额分配';

-- ----------------------------
-- Records of ns_shop_order_account_records
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_shop_recommend`
-- ----------------------------
DROP TABLE IF EXISTS `ns_shop_recommend`;
CREATE TABLE `ns_shop_recommend` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `recommend_name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `alis_id` varchar(1000) NOT NULL COMMENT '关联id组',
  `show_num` int(11) NOT NULL DEFAULT '0' COMMENT '显示数量 ',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '关联类型 1-标签 2-分类 3-品牌 4-推荐新品 5-精品 6- 热卖 7-商品',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `img` varchar(255) NOT NULL COMMENT '图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1489 COMMENT='商品推荐';

-- ----------------------------
-- Records of ns_shop_recommend
-- ----------------------------
INSERT INTO `ns_shop_recommend` VALUES ('1', '123', '3', '0', '2', '0', 'upload/config/2019041704241671160.jpg');
INSERT INTO `ns_shop_recommend` VALUES ('2', '123', '', '0', '3', '0', '');

-- ----------------------------
-- Table structure for `ns_shop_weixin_share`
-- ----------------------------
DROP TABLE IF EXISTS `ns_shop_weixin_share`;
CREATE TABLE `ns_shop_weixin_share` (
  `shop_id` int(11) NOT NULL,
  `goods_param_1` varchar(255) NOT NULL DEFAULT '' COMMENT '商品分享价格标示',
  `goods_param_2` varchar(255) NOT NULL DEFAULT '' COMMENT '商品分享内容',
  `shop_param_1` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺分享标题',
  `shop_param_2` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺分享主题',
  `shop_param_3` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺分享内容',
  `qrcode_param_1` varchar(255) NOT NULL DEFAULT '' COMMENT '二维码分享主题',
  `qrcode_param_2` varchar(255) NOT NULL DEFAULT '' COMMENT '二维码分享内容',
  PRIMARY KEY (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='店铺分享内容设置';

-- ----------------------------
-- Records of ns_shop_weixin_share
-- ----------------------------
INSERT INTO `ns_shop_weixin_share` VALUES ('0', '优惠价：', '全场正品', '欢迎打开', '分享赚佣金', '', '向您推荐', '注册有优惠');

-- ----------------------------
-- Table structure for `ns_supplier`
-- ----------------------------
DROP TABLE IF EXISTS `ns_supplier`;
CREATE TABLE `ns_supplier` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `supplier_name` varchar(50) NOT NULL DEFAULT '' COMMENT '供货商名称',
  `desc` varchar(1000) NOT NULL DEFAULT '' COMMENT '供货商描述',
  `linkman_tel` varchar(255) NOT NULL DEFAULT '' COMMENT '联系人电话',
  `linkman_name` varchar(50) NOT NULL DEFAULT '' COMMENT '联系人姓名',
  `linkman_address` varchar(255) NOT NULL DEFAULT '' COMMENT '联系人地址',
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='供货商表';

-- ----------------------------
-- Records of ns_supplier
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_tuangou_group`
-- ----------------------------
DROP TABLE IF EXISTS `ns_tuangou_group`;
CREATE TABLE `ns_tuangou_group` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_uid` int(11) NOT NULL DEFAULT '0' COMMENT '发起人id',
  `group_name` varchar(255) NOT NULL DEFAULT '' COMMENT '发起人名',
  `user_tel` varchar(255) NOT NULL DEFAULT '' COMMENT '团长联系方式',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '团购商品',
  `goods_name` varchar(50) NOT NULL DEFAULT '' COMMENT '拼团商品名称',
  `tuangou_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '团购商品价格',
  `tuangou_type` int(11) NOT NULL DEFAULT '1' COMMENT '团购类型',
  `tuangou_type_name` varchar(50) NOT NULL DEFAULT '' COMMENT '类型名称',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '团购基本价格',
  `tuangou_num` int(11) NOT NULL DEFAULT '0' COMMENT '团购人数',
  `real_num` int(11) NOT NULL DEFAULT '0' COMMENT '已参团人数',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '1进行中,2已完成,-1拼团失败',
  `is_recommend` int(11) NOT NULL DEFAULT '0' COMMENT '是否首页推荐',
  `group_user_head_img` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=390 COMMENT='拼团组合';

-- ----------------------------
-- Records of ns_tuangou_group
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_tuangou_type`
-- ----------------------------
DROP TABLE IF EXISTS `ns_tuangou_type`;
CREATE TABLE `ns_tuangou_type` (
  `type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) NOT NULL DEFAULT '' COMMENT '团购类型名称',
  `type_is_open` int(11) NOT NULL DEFAULT '0',
  `type_content_json` varchar(1000) NOT NULL DEFAULT '' COMMENT '类型json信息',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=5461 COMMENT='团购类型表';

-- ----------------------------
-- Records of ns_tuangou_type
-- ----------------------------
INSERT INTO `ns_tuangou_type` VALUES ('1', '秒杀团', '1', '');

-- ----------------------------
-- Table structure for `ns_verification_person`
-- ----------------------------
DROP TABLE IF EXISTS `ns_verification_person`;
CREATE TABLE `ns_verification_person` (
  `v_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`v_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='核销人员表';

-- ----------------------------
-- Records of ns_verification_person
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_virtual_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ns_virtual_goods`;
CREATE TABLE `ns_virtual_goods` (
  `virtual_goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `virtual_code` varbinary(255) NOT NULL COMMENT '虚拟码',
  `virtual_goods_name` varchar(255) NOT NULL COMMENT '虚拟商品名称',
  `money` decimal(10,2) NOT NULL COMMENT '虚拟商品金额',
  `buyer_id` int(11) NOT NULL COMMENT '买家id',
  `buyer_nickname` varchar(255) NOT NULL COMMENT '买家名称',
  `order_goods_id` int(11) NOT NULL COMMENT '关联订单项id',
  `order_no` varchar(255) NOT NULL COMMENT '订单编号',
  `validity_period` int(11) NOT NULL COMMENT '有效期/天(0表示不限制)',
  `start_time` int(11) NOT NULL COMMENT '有效期开始时间',
  `end_time` int(11) NOT NULL COMMENT '有效期结束时间',
  `use_number` int(11) NOT NULL COMMENT '使用次数',
  `confine_use_number` int(11) NOT NULL COMMENT '限制使用次数',
  `use_status` tinyint(1) NOT NULL COMMENT '使用状态(-1:已过期,0:未使用,1:已使用)',
  `shop_id` int(11) NOT NULL COMMENT '店铺id',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `sku_id` int(11) NOT NULL DEFAULT '0' COMMENT '规格id',
  PRIMARY KEY (`virtual_goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1365 COMMENT='虚拟商品列表(用户下单支成功后存放)';

-- ----------------------------
-- Records of ns_virtual_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_virtual_goods_group`
-- ----------------------------
DROP TABLE IF EXISTS `ns_virtual_goods_group`;
CREATE TABLE `ns_virtual_goods_group` (
  `virtual_goods_group_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '虚拟商品分组id',
  `virtual_goods_group_name` varchar(255) NOT NULL DEFAULT '' COMMENT '虚拟商品分组名称',
  `interfaces` varchar(1000) DEFAULT '' COMMENT '接口调用地址（JSON）',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`virtual_goods_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4096 COMMENT='虚拟商品分组表';

-- ----------------------------
-- Records of ns_virtual_goods_group
-- ----------------------------
INSERT INTO `ns_virtual_goods_group` VALUES ('1', '虚拟商品', '', '0', '0');

-- ----------------------------
-- Table structure for `ns_virtual_goods_type`
-- ----------------------------
DROP TABLE IF EXISTS `ns_virtual_goods_type`;
CREATE TABLE `ns_virtual_goods_type` (
  `virtual_goods_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '虚拟商品类型id',
  `virtual_goods_group_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联虚拟商品分组id',
  `validity_period` int(11) NOT NULL DEFAULT '0' COMMENT '有效期/天(0表示不限制)',
  `confine_use_number` int(11) NOT NULL DEFAULT '0' COMMENT '限制使用次数',
  `shop_id` int(11) NOT NULL COMMENT '店铺id',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `relate_goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联商品id',
  `value_info` varchar(1000) NOT NULL DEFAULT '' COMMENT '值详情',
  PRIMARY KEY (`virtual_goods_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=3276;

-- ----------------------------
-- Records of ns_virtual_goods_type
-- ----------------------------

-- ----------------------------
-- Table structure for `ns_virtual_goods_verification`
-- ----------------------------
DROP TABLE IF EXISTS `ns_virtual_goods_verification`;
CREATE TABLE `ns_virtual_goods_verification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '核销人员id',
  `virtual_goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户虚拟商品id',
  `action` varchar(255) NOT NULL DEFAULT '' COMMENT '动作内容',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '用户虚拟商品使用状态',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '核销次数',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `verification_name` varchar(50) NOT NULL DEFAULT '' COMMENT '核销员',
  `user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '虚拟商品所有者',
  `goods_name` varchar(50) NOT NULL DEFAULT '' COMMENT '虚拟商品名称',
  `buyer_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品所有人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='虚拟商品核销记录表';

-- ----------------------------
-- Records of ns_virtual_goods_verification
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_addons`
-- ----------------------------
DROP TABLE IF EXISTS `sys_addons`;
CREATE TABLE `sys_addons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL COMMENT '插件名或标识',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '中文名',
  `description` text COMMENT '插件描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `config` text COMMENT '配置',
  `author` varchar(40) DEFAULT '' COMMENT '作者',
  `version` varchar(20) DEFAULT '' COMMENT '版本号',
  `has_adminlist` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台列表',
  `has_addonslist` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有插件列表',
  `content` text NOT NULL COMMENT '详情',
  `config_hook` varchar(255) NOT NULL DEFAULT '' COMMENT '自定义配置文件钩子',
  `create_time` int(11) DEFAULT '0' COMMENT '安装时间',
  `ico` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=162 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=84 COMMENT='插件表';

-- ----------------------------
-- Records of sys_addons
-- ----------------------------
INSERT INTO `sys_addons` VALUES ('75', 'NsDiyView', '自定义模板', '该插件 支持手机自定义模板功能', '1', '', 'niushop', '1.0', '0', '0', '', '', '1551340708', 'addons/NsDiyView/ico.png');
INSERT INTO `sys_addons` VALUES ('76', 'NsAlisms', '阿里云短信', '支持阿里云短信配置与发送', '1', '', 'niushop', '1.0', '0', '0', '', '', '1551347533', 'addons/NsAlisms/ico.png');
INSERT INTO `sys_addons` VALUES ('71', 'NsWeixinpay', '微信支付', '该系统支持微信网页支付和扫码支付', '1', '', 'niushop', '1.0', '0', '0', '', '', '1547882911', 'addons/NsWeixinpay/ico.png');
INSERT INTO `sys_addons` VALUES ('72', 'NsAlipay', '支付宝', '该系统支持即时到账接口', '1', '', 'niushop', '1.0', '0', '0', '', '', '1547882912', 'addons/NsAlipay/ico.png');
INSERT INTO `sys_addons` VALUES ('148', 'NsGroupBuy', '团购', '该插件支持团购功能', '1', '', 'niushop', '1.0', '0', '0', '', '', '1553739597', 'addons/NsGroupBuy/ico.png');
INSERT INTO `sys_addons` VALUES ('94', 'NsWxtemplatemsg', '微信模板消息', '微信模板消息插件', '1', '', 'niushop', '1.0', '0', '0', '', '', '1550302198', 'addons/NsWxtemplatemsg/ico.png');
INSERT INTO `sys_addons` VALUES ('158', 'NsGoods', '普通商品', '提供店铺线上服务商品的交易', '1', '', 'niushop', '1.0', '0', '0', '', '', '1553846193', 'addons/NsGoods/ico.png');

-- ----------------------------
-- Table structure for `sys_addons_weixin_template_msg`
-- ----------------------------
DROP TABLE IF EXISTS `sys_addons_weixin_template_msg`;
CREATE TABLE `sys_addons_weixin_template_msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `instance_id` int(11) NOT NULL COMMENT '店铺id（单店版为0）',
  `template_no` varchar(55) NOT NULL COMMENT '模版编号',
  `template_id` varbinary(55) DEFAULT NULL COMMENT '微信模板消息的ID',
  `title` varchar(100) NOT NULL COMMENT '模版标题',
  `is_enable` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否启用',
  `headtext` varchar(255) NOT NULL COMMENT '头部文字',
  `bottomtext` varchar(255) NOT NULL COMMENT '底部文字',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4096 COMMENT='微信实例消息';

-- ----------------------------
-- Records of sys_addons_weixin_template_msg
-- ----------------------------
INSERT INTO `sys_addons_weixin_template_msg` VALUES ('1', '0', 'OPENTM203347141', '', '会员注册成功通知', '1', '恭喜，您已成功注册为会员！', '恭喜，您已成为会员，您将享受会员所有权利！');
INSERT INTO `sys_addons_weixin_template_msg` VALUES ('2', '0', 'OPENTM200444240', '', '订单提交成功通知', '1', '亲！您已成功创建订单，点击进入完成付款。', '感谢您的支持，我们将为您提供更好的服务。');
INSERT INTO `sys_addons_weixin_template_msg` VALUES ('3', '0', 'OPENTM201541214', '', '订单发货通知', '1', '亲，你的订单已发货', '请关注订单,注意查收');
INSERT INTO `sys_addons_weixin_template_msg` VALUES ('4', '0', 'OPENTM200444326', '', '订单付款成功通知', '1', '亲！您的订单已成功付款。', '');
INSERT INTO `sys_addons_weixin_template_msg` VALUES ('5', '0', 'OPENTM207103254', '', '退款申请', '1', '您已申请退款，我们将尽快处理您提交的退款申请。您可以在“退换货”中查看退款进度', '如您的退款有疑问，请联系我们的客服人员，帮助您解决处理！');
INSERT INTO `sys_addons_weixin_template_msg` VALUES ('6', '0', 'OPENTM205986235', '', '退款结果通知', '1', '亲，您的退款已处理。', '如您还有疑问，请与客服人员联系。');
INSERT INTO `sys_addons_weixin_template_msg` VALUES ('7', '0', 'OPENTM207292959', '', '提现申请提醒', '1', '亲，您的提现申请已提交', '我们将在1到3个工作日内处理完毕，请耐心等待。');
INSERT INTO `sys_addons_weixin_template_msg` VALUES ('8', '0', 'OPENTM400094285', '', '提现审核结果通知', '1', '亲，您提现申请已通过', '我们将在1到3个工作日内处理完毕，请耐心等待。');
INSERT INTO `sys_addons_weixin_template_msg` VALUES ('9', '0', 'OPENTM409846856', '', '申请通过通知', '1', '您的推广员申请已经通过', '如您还有疑问，请与客服人员联系。');
INSERT INTO `sys_addons_weixin_template_msg` VALUES ('10', '0', 'OPENTM409846856', '', '下级申请通过通知', '1', '您的下级推广员申请已经通过', '如您还有疑问，请与客服人员联系。');
INSERT INTO `sys_addons_weixin_template_msg` VALUES ('11', '0', 'OPENTM409846856', '', '下下级申请通过通知', '1', '您的下下级推广员申请已经通过', '如您还有疑问，请与客服人员联系。');
INSERT INTO `sys_addons_weixin_template_msg` VALUES ('12', '0', 'OPENTM201010537', '', '本店分销订单提成通知', '1', '亲，您已成功分销出一笔订单，继续努力哦', '');
INSERT INTO `sys_addons_weixin_template_msg` VALUES ('13', '0', 'OPENTM201010537', '', '下级分店分销订单提成通知', '1', '亲，您的下级推广员成功分销出一笔订单，继续努力哦', '');
INSERT INTO `sys_addons_weixin_template_msg` VALUES ('14', '0', 'OPENTM201010537', '', '下下级分店分销订单提成通知', '1', '亲，您的下下级推广员成功分销出一笔订单，继续努力哦', '');
INSERT INTO `sys_addons_weixin_template_msg` VALUES ('15', '0', 'OPENTM205041253', '', '余额充值成功通知', '1', '亲，您的余额已充值成功！如您还有疑问，请与客服人员联系。', '');
INSERT INTO `sys_addons_weixin_template_msg` VALUES ('16', '0', 'OPENTM410729522', '', '开团成功提醒', '1', '恭喜您开团成功，分享给好友参团成团更快。', '');
INSERT INTO `sys_addons_weixin_template_msg` VALUES ('17', '0', 'OPENTM414066517', '', '拼团参加成功提醒', '1', '恭喜您参团成功，分享给好友参团成团更快。', '');
INSERT INTO `sys_addons_weixin_template_msg` VALUES ('18', '0', 'OPENTM409367318', '', '拼团成功通知', '1', '恭喜您，您有一笔拼团订单已拼团成功，商家将尽快为您发货。', '');
INSERT INTO `sys_addons_weixin_template_msg` VALUES ('19', '0', 'OPENTM409367317', '', '拼团失败通知', '1', '很抱歉，您有一笔拼团订单因人数不足拼团失败。', '');

-- ----------------------------
-- Table structure for `sys_album_class`
-- ----------------------------
DROP TABLE IF EXISTS `sys_album_class`;
CREATE TABLE `sys_album_class` (
  `album_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '相册id',
  `shop_id` int(10) NOT NULL DEFAULT '1' COMMENT '店铺id',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级相册ID',
  `album_name` varchar(100) NOT NULL COMMENT '相册名称',
  `album_cover` varchar(255) NOT NULL DEFAULT '' COMMENT '相册封面',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为默认相册,1代表默认',
  `sort` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`album_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='相册表';

-- ----------------------------
-- Records of sys_album_class
-- ----------------------------
INSERT INTO `sys_album_class` VALUES ('30', '0', '0', '默认相册', '0', '1', '1', '1497064831');

-- ----------------------------
-- Table structure for `sys_album_picture`
-- ----------------------------
DROP TABLE IF EXISTS `sys_album_picture`;
CREATE TABLE `sys_album_picture` (
  `pic_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '相册图片表id',
  `shop_id` int(10) unsigned DEFAULT '1' COMMENT '所属实例id',
  `album_id` int(10) unsigned NOT NULL COMMENT '相册id',
  `is_wide` int(11) NOT NULL DEFAULT '0' COMMENT '是否宽屏',
  `pic_name` varchar(100) NOT NULL COMMENT '图片名称',
  `pic_tag` varchar(255) NOT NULL DEFAULT '' COMMENT '图片标签',
  `pic_cover` varchar(255) NOT NULL COMMENT '原图图片路径',
  `pic_size` varchar(255) NOT NULL COMMENT '原图大小',
  `pic_spec` varchar(100) NOT NULL COMMENT '原图规格',
  `pic_cover_big` varchar(255) NOT NULL DEFAULT '' COMMENT '大图路径',
  `pic_size_big` varchar(255) NOT NULL DEFAULT '0' COMMENT '大图大小',
  `pic_spec_big` varchar(100) NOT NULL DEFAULT '' COMMENT '大图规格',
  `pic_cover_mid` varchar(255) NOT NULL DEFAULT '' COMMENT '中图路径',
  `pic_size_mid` varchar(255) NOT NULL DEFAULT '0' COMMENT '中图大小',
  `pic_spec_mid` varchar(100) NOT NULL DEFAULT '' COMMENT '中图规格',
  `pic_cover_small` varchar(255) NOT NULL DEFAULT '' COMMENT '小图路径',
  `pic_size_small` varchar(255) NOT NULL DEFAULT '0' COMMENT '小图大小',
  `pic_spec_small` varchar(255) NOT NULL DEFAULT '' COMMENT '小图规格',
  `pic_cover_micro` varchar(255) NOT NULL DEFAULT '' COMMENT '微图路径',
  `pic_size_micro` varchar(255) NOT NULL DEFAULT '0' COMMENT '微图大小',
  `pic_spec_micro` varchar(255) NOT NULL DEFAULT '' COMMENT '微图规格',
  `upload_time` int(11) DEFAULT '0' COMMENT '图片上传时间',
  `upload_type` int(11) DEFAULT '1' COMMENT '图片外链',
  `domain` varchar(255) DEFAULT '' COMMENT '图片外链',
  `bucket` varchar(255) DEFAULT '' COMMENT '存储空间名称',
  PRIMARY KEY (`pic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=204 COMMENT='相册图片表';

-- ----------------------------
-- Records of sys_album_picture
-- ----------------------------
INSERT INTO `sys_album_picture` VALUES ('1', '0', '30', '0', '2019041702121435498', 'TIM图片20190408103706', 'upload/goods/2019041702121435498.jpg', '325381', '1440,1920', 'upload/goods/2019041702121435498_BIG.jpg', '72711', '700*700', 'upload/goods/2019041702121435498_MID.jpg', '25218', '360*360', 'upload/goods/2019041702121435498_SMALL.jpg', '13191', '240*240', 'upload/goods/2019041702121435498_THUMB.jpg', '1971', '60*60', '1555481535', '1', '', '');
INSERT INTO `sys_album_picture` VALUES ('2', '0', '30', '0', '2019041704260787353', 'TIM图片20190408103720', 'upload/goods/2019041704260787353.jpg', '227626', '1440,1920', 'upload/goods/2019041704260787353_BIG.jpg', '50557', '700*700', 'upload/goods/2019041704260787353_MID.jpg', '18802', '360*360', 'upload/goods/2019041704260787353_SMALL.jpg', '10104', '240*240', 'upload/goods/2019041704260787353_THUMB.jpg', '1739', '60*60', '1555489568', '1', '', '');
INSERT INTO `sys_album_picture` VALUES ('3', '0', '30', '0', '2019041910043408283', 'TIM图片20190418092249', 'upload/goods/2019041910043408283.jpg', '139064', '1440,1920', 'upload/goods/2019041910043408283_BIG.jpg', '37659', '700*700', 'upload/goods/2019041910043408283_MID.jpg', '15684', '360*360', 'upload/goods/2019041910043408283_SMALL.jpg', '9084', '240*240', 'upload/goods/2019041910043408283_THUMB.jpg', '1706', '60*60', '1555639474', '1', '', '');

-- ----------------------------
-- Table structure for `sys_applet_custom_template`
-- ----------------------------
DROP TABLE IF EXISTS `sys_applet_custom_template`;
CREATE TABLE `sys_applet_custom_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `template_name` varchar(250) DEFAULT '' COMMENT '自定义模板名称（暂时预留）',
  `template_data` longtext COMMENT '模板数据（JSON格式）',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间戳',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间戳',
  `is_enable` int(11) NOT NULL DEFAULT '0' COMMENT '是否启用 0 不启用 1 启用',
  `is_default` int(11) DEFAULT '0' COMMENT '是否为默认模板 0 不是 1 是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='小程序自定义模板';

-- ----------------------------
-- Records of sys_applet_custom_template
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_app_upgrade`
-- ----------------------------
DROP TABLE IF EXISTS `sys_app_upgrade`;
CREATE TABLE `sys_app_upgrade` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `app_type` varchar(255) NOT NULL COMMENT 'App类型，Android，IOS',
  `version_number` varchar(255) NOT NULL COMMENT '版本号',
  `title` varchar(255) DEFAULT '' COMMENT '标题',
  `download_address` varchar(255) NOT NULL COMMENT 'App下载地址',
  `update_log` varchar(255) DEFAULT '' COMMENT '更新日志',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='App升级表';

-- ----------------------------
-- Records of sys_app_upgrade
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_area`
-- ----------------------------
DROP TABLE IF EXISTS `sys_area`;
CREATE TABLE `sys_area` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(50) NOT NULL DEFAULT '',
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2048 COMMENT='全部区域表';

-- ----------------------------
-- Records of sys_area
-- ----------------------------
INSERT INTO `sys_area` VALUES ('1', '华东', '0');
INSERT INTO `sys_area` VALUES ('2', '华北', '0');
INSERT INTO `sys_area` VALUES ('3', '华南', '0');
INSERT INTO `sys_area` VALUES ('4', '华中', '0');
INSERT INTO `sys_area` VALUES ('5', '东北', '0');
INSERT INTO `sys_area` VALUES ('6', '西北', '0');
INSERT INTO `sys_area` VALUES ('7', '西南', '0');
INSERT INTO `sys_area` VALUES ('8', '港澳台', '0');

-- ----------------------------
-- Table structure for `sys_city`
-- ----------------------------
DROP TABLE IF EXISTS `sys_city`;
CREATE TABLE `sys_city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `province_id` int(11) NOT NULL DEFAULT '0',
  `city_name` varchar(255) NOT NULL DEFAULT '',
  `zipcode` varchar(6) NOT NULL DEFAULT '',
  `sort` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`city_id`),
  KEY `IDX_g_city_CityName` (`city_name`)
) ENGINE=InnoDB AUTO_INCREMENT=398 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=135;

-- ----------------------------
-- Records of sys_city
-- ----------------------------
INSERT INTO `sys_city` VALUES ('1', '1', '北京市', '100000', '1');
INSERT INTO `sys_city` VALUES ('2', '2', '天津市', '100000', '0');
INSERT INTO `sys_city` VALUES ('3', '3', '石家庄市', '050000', '0');
INSERT INTO `sys_city` VALUES ('4', '3', '唐山市', '063000', '0');
INSERT INTO `sys_city` VALUES ('5', '3', '秦皇岛市', '066000', '0');
INSERT INTO `sys_city` VALUES ('6', '3', '邯郸市', '056000', '0');
INSERT INTO `sys_city` VALUES ('7', '3', '邢台市', '054000', '0');
INSERT INTO `sys_city` VALUES ('8', '3', '保定市', '071000', '0');
INSERT INTO `sys_city` VALUES ('9', '3', '张家口市', '075000', '0');
INSERT INTO `sys_city` VALUES ('10', '3', '承德市', '067000', '0');
INSERT INTO `sys_city` VALUES ('11', '3', '沧州市', '061000', '0');
INSERT INTO `sys_city` VALUES ('12', '3', '廊坊市', '065000', '0');
INSERT INTO `sys_city` VALUES ('13', '3', '衡水市', '053000', '0');
INSERT INTO `sys_city` VALUES ('14', '4', '太原市', '030000', '0');
INSERT INTO `sys_city` VALUES ('15', '4', '大同市', '037000', '0');
INSERT INTO `sys_city` VALUES ('16', '4', '阳泉市', '045000', '0');
INSERT INTO `sys_city` VALUES ('17', '4', '长治市', '046000', '0');
INSERT INTO `sys_city` VALUES ('18', '4', '晋城市', '048000', '0');
INSERT INTO `sys_city` VALUES ('19', '4', '朔州市', '036000', '0');
INSERT INTO `sys_city` VALUES ('20', '4', '晋中市', '030600', '0');
INSERT INTO `sys_city` VALUES ('21', '4', '运城市', '044000', '0');
INSERT INTO `sys_city` VALUES ('22', '4', '忻州市', '034000', '0');
INSERT INTO `sys_city` VALUES ('23', '4', '临汾市', '041000', '0');
INSERT INTO `sys_city` VALUES ('24', '4', '吕梁市', '030500', '0');
INSERT INTO `sys_city` VALUES ('25', '5', '呼和浩特市', '010000', '0');
INSERT INTO `sys_city` VALUES ('26', '5', '包头市', '014000', '0');
INSERT INTO `sys_city` VALUES ('27', '5', '乌海市', '016000', '0');
INSERT INTO `sys_city` VALUES ('28', '5', '赤峰市', '024000', '0');
INSERT INTO `sys_city` VALUES ('29', '5', '通辽市', '028000', '0');
INSERT INTO `sys_city` VALUES ('30', '5', '鄂尔多斯市', '010300', '0');
INSERT INTO `sys_city` VALUES ('31', '5', '呼伦贝尔市', '021000', '0');
INSERT INTO `sys_city` VALUES ('32', '5', '巴彦淖尔市', '014400', '0');
INSERT INTO `sys_city` VALUES ('33', '5', '乌兰察布市', '011800', '0');
INSERT INTO `sys_city` VALUES ('34', '5', '兴安盟', '137500', '0');
INSERT INTO `sys_city` VALUES ('35', '5', '锡林郭勒盟', '011100', '0');
INSERT INTO `sys_city` VALUES ('36', '5', '阿拉善盟', '016000', '0');
INSERT INTO `sys_city` VALUES ('37', '6', '沈阳市', '110000', '0');
INSERT INTO `sys_city` VALUES ('38', '6', '大连市', '116000', '0');
INSERT INTO `sys_city` VALUES ('39', '6', '鞍山市', '114000', '0');
INSERT INTO `sys_city` VALUES ('40', '6', '抚顺市', '113000', '0');
INSERT INTO `sys_city` VALUES ('41', '6', '本溪市', '117000', '0');
INSERT INTO `sys_city` VALUES ('42', '6', '丹东市', '118000', '0');
INSERT INTO `sys_city` VALUES ('43', '6', '锦州市', '121000', '0');
INSERT INTO `sys_city` VALUES ('44', '6', '营口市', '115000', '0');
INSERT INTO `sys_city` VALUES ('45', '6', '阜新市', '123000', '0');
INSERT INTO `sys_city` VALUES ('46', '6', '辽阳市', '111000', '0');
INSERT INTO `sys_city` VALUES ('47', '6', '盘锦市', '124000', '0');
INSERT INTO `sys_city` VALUES ('48', '6', '铁岭市', '112000', '0');
INSERT INTO `sys_city` VALUES ('49', '6', '朝阳市', '122000', '0');
INSERT INTO `sys_city` VALUES ('50', '6', '葫芦岛市', '125000', '0');
INSERT INTO `sys_city` VALUES ('51', '7', '长春市', '130000', '0');
INSERT INTO `sys_city` VALUES ('52', '7', '吉林市', '132000', '0');
INSERT INTO `sys_city` VALUES ('53', '7', '四平市', '136000', '0');
INSERT INTO `sys_city` VALUES ('54', '7', '辽源市', '136200', '0');
INSERT INTO `sys_city` VALUES ('55', '7', '通化市', '134000', '0');
INSERT INTO `sys_city` VALUES ('56', '7', '白山市', '134300', '0');
INSERT INTO `sys_city` VALUES ('57', '7', '松原市', '131100', '0');
INSERT INTO `sys_city` VALUES ('58', '7', '白城市', '137000', '0');
INSERT INTO `sys_city` VALUES ('59', '7', '延边朝鲜族自治州', '133000', '0');
INSERT INTO `sys_city` VALUES ('60', '8', '哈尔滨市', '150000', '0');
INSERT INTO `sys_city` VALUES ('61', '8', '齐齐哈尔市', '161000', '0');
INSERT INTO `sys_city` VALUES ('62', '8', '鸡西市', '158100', '0');
INSERT INTO `sys_city` VALUES ('63', '8', '鹤岗市', '154100', '0');
INSERT INTO `sys_city` VALUES ('64', '8', '双鸭山市', '155100', '0');
INSERT INTO `sys_city` VALUES ('65', '8', '大庆市', '163000', '0');
INSERT INTO `sys_city` VALUES ('66', '8', '伊春市', '152300', '0');
INSERT INTO `sys_city` VALUES ('67', '8', '佳木斯市', '154000', '0');
INSERT INTO `sys_city` VALUES ('68', '8', '七台河市', '154600', '0');
INSERT INTO `sys_city` VALUES ('69', '8', '牡丹江市', '157000', '0');
INSERT INTO `sys_city` VALUES ('70', '8', '黑河市', '164300', '0');
INSERT INTO `sys_city` VALUES ('71', '8', '绥化市', '152000', '0');
INSERT INTO `sys_city` VALUES ('72', '8', '大兴安岭地区', '165000', '0');
INSERT INTO `sys_city` VALUES ('73', '9', '上海市', '200000', '0');
INSERT INTO `sys_city` VALUES ('74', '10', '南京市', '210000', '0');
INSERT INTO `sys_city` VALUES ('75', '10', '无锡市', '214000', '0');
INSERT INTO `sys_city` VALUES ('76', '10', '徐州市', '221000', '0');
INSERT INTO `sys_city` VALUES ('77', '10', '常州市', '213000', '0');
INSERT INTO `sys_city` VALUES ('78', '10', '苏州市', '215000', '0');
INSERT INTO `sys_city` VALUES ('79', '10', '南通市', '226000', '0');
INSERT INTO `sys_city` VALUES ('80', '10', '连云港市', '222000', '0');
INSERT INTO `sys_city` VALUES ('81', '10', '淮安市', '223200', '0');
INSERT INTO `sys_city` VALUES ('82', '10', '盐城市', '224000', '0');
INSERT INTO `sys_city` VALUES ('83', '10', '扬州市', '225000', '0');
INSERT INTO `sys_city` VALUES ('84', '10', '镇江市', '212000', '0');
INSERT INTO `sys_city` VALUES ('85', '10', '泰州市', '225300', '0');
INSERT INTO `sys_city` VALUES ('86', '10', '宿迁市', '223800', '0');
INSERT INTO `sys_city` VALUES ('87', '11', '杭州市', '310000', '0');
INSERT INTO `sys_city` VALUES ('88', '11', '宁波市', '315000', '0');
INSERT INTO `sys_city` VALUES ('89', '11', '温州市', '325000', '0');
INSERT INTO `sys_city` VALUES ('90', '11', '嘉兴市', '314000', '0');
INSERT INTO `sys_city` VALUES ('91', '11', '湖州市', '313000', '0');
INSERT INTO `sys_city` VALUES ('92', '11', '绍兴市', '312000', '0');
INSERT INTO `sys_city` VALUES ('93', '11', '金华市', '321000', '0');
INSERT INTO `sys_city` VALUES ('94', '11', '衢州市', '324000', '0');
INSERT INTO `sys_city` VALUES ('95', '11', '舟山市', '316000', '0');
INSERT INTO `sys_city` VALUES ('96', '11', '台州市', '318000', '0');
INSERT INTO `sys_city` VALUES ('97', '11', '丽水市', '323000', '0');
INSERT INTO `sys_city` VALUES ('98', '12', '合肥市', '230000', '0');
INSERT INTO `sys_city` VALUES ('99', '12', '芜湖市', '241000', '0');
INSERT INTO `sys_city` VALUES ('100', '12', '蚌埠市', '233000', '0');
INSERT INTO `sys_city` VALUES ('101', '12', '淮南市', '232000', '0');
INSERT INTO `sys_city` VALUES ('102', '12', '马鞍山市', '243000', '0');
INSERT INTO `sys_city` VALUES ('103', '12', '淮北市', '235000', '0');
INSERT INTO `sys_city` VALUES ('104', '12', '铜陵市', '244000', '0');
INSERT INTO `sys_city` VALUES ('105', '12', '安庆市', '246000', '0');
INSERT INTO `sys_city` VALUES ('106', '12', '黄山市', '242700', '0');
INSERT INTO `sys_city` VALUES ('107', '12', '滁州市', '239000', '0');
INSERT INTO `sys_city` VALUES ('108', '12', '阜阳市', '236100', '0');
INSERT INTO `sys_city` VALUES ('109', '12', '宿州市', '234100', '0');
INSERT INTO `sys_city` VALUES ('111', '12', '六安市', '237000', '0');
INSERT INTO `sys_city` VALUES ('112', '12', '亳州市', '236800', '0');
INSERT INTO `sys_city` VALUES ('113', '12', '池州市', '247100', '0');
INSERT INTO `sys_city` VALUES ('114', '12', '宣城市', '366000', '0');
INSERT INTO `sys_city` VALUES ('115', '13', '福州市', '350000', '0');
INSERT INTO `sys_city` VALUES ('116', '13', '厦门市', '361000', '0');
INSERT INTO `sys_city` VALUES ('117', '13', '莆田市', '351100', '0');
INSERT INTO `sys_city` VALUES ('118', '13', '三明市', '365000', '0');
INSERT INTO `sys_city` VALUES ('119', '13', '泉州市', '362000', '0');
INSERT INTO `sys_city` VALUES ('120', '13', '漳州市', '363000', '0');
INSERT INTO `sys_city` VALUES ('121', '13', '南平市', '353000', '0');
INSERT INTO `sys_city` VALUES ('122', '13', '龙岩市', '364000', '0');
INSERT INTO `sys_city` VALUES ('123', '13', '宁德市', '352100', '0');
INSERT INTO `sys_city` VALUES ('124', '14', '南昌市', '330000', '0');
INSERT INTO `sys_city` VALUES ('125', '14', '景德镇市', '333000', '0');
INSERT INTO `sys_city` VALUES ('126', '14', '萍乡市', '337000', '0');
INSERT INTO `sys_city` VALUES ('127', '14', '九江市', '332000', '0');
INSERT INTO `sys_city` VALUES ('128', '14', '新余市', '338000', '0');
INSERT INTO `sys_city` VALUES ('129', '14', '鹰潭市', '335000', '0');
INSERT INTO `sys_city` VALUES ('130', '14', '赣州市', '341000', '0');
INSERT INTO `sys_city` VALUES ('131', '14', '吉安市', '343000', '0');
INSERT INTO `sys_city` VALUES ('132', '14', '宜春市', '336000', '0');
INSERT INTO `sys_city` VALUES ('133', '14', '抚州市', '332900', '0');
INSERT INTO `sys_city` VALUES ('134', '14', '上饶市', '334000', '0');
INSERT INTO `sys_city` VALUES ('135', '15', '济南市', '250000', '0');
INSERT INTO `sys_city` VALUES ('136', '15', '青岛市', '266000', '0');
INSERT INTO `sys_city` VALUES ('137', '15', '淄博市', '255000', '0');
INSERT INTO `sys_city` VALUES ('138', '15', '枣庄市', '277100', '0');
INSERT INTO `sys_city` VALUES ('139', '15', '东营市', '257000', '0');
INSERT INTO `sys_city` VALUES ('140', '15', '烟台市', '264000', '0');
INSERT INTO `sys_city` VALUES ('141', '15', '潍坊市', '261000', '0');
INSERT INTO `sys_city` VALUES ('142', '15', '济宁市', '272100', '0');
INSERT INTO `sys_city` VALUES ('143', '15', '泰安市', '271000', '0');
INSERT INTO `sys_city` VALUES ('144', '15', '威海市', '265700', '0');
INSERT INTO `sys_city` VALUES ('145', '15', '日照市', '276800', '0');
INSERT INTO `sys_city` VALUES ('146', '15', '莱芜市', '271100', '0');
INSERT INTO `sys_city` VALUES ('147', '15', '临沂市', '276000', '0');
INSERT INTO `sys_city` VALUES ('148', '15', '德州市', '253000', '0');
INSERT INTO `sys_city` VALUES ('149', '15', '聊城市', '252000', '0');
INSERT INTO `sys_city` VALUES ('150', '15', '滨州市', '256600', '0');
INSERT INTO `sys_city` VALUES ('151', '15', '菏泽市', '255000', '0');
INSERT INTO `sys_city` VALUES ('152', '16', '郑州市', '450000', '0');
INSERT INTO `sys_city` VALUES ('153', '16', '开封市', '475000', '0');
INSERT INTO `sys_city` VALUES ('154', '16', '洛阳市', '471000', '0');
INSERT INTO `sys_city` VALUES ('155', '16', '平顶山市', '467000', '0');
INSERT INTO `sys_city` VALUES ('156', '16', '安阳市', '454900', '0');
INSERT INTO `sys_city` VALUES ('157', '16', '鹤壁市', '456600', '0');
INSERT INTO `sys_city` VALUES ('158', '16', '新乡市', '453000', '0');
INSERT INTO `sys_city` VALUES ('159', '16', '焦作市', '454100', '0');
INSERT INTO `sys_city` VALUES ('160', '16', '濮阳市', '457000', '0');
INSERT INTO `sys_city` VALUES ('161', '16', '许昌市', '461000', '0');
INSERT INTO `sys_city` VALUES ('162', '16', '漯河市', '462000', '0');
INSERT INTO `sys_city` VALUES ('163', '16', '三门峡市', '472000', '0');
INSERT INTO `sys_city` VALUES ('164', '16', '南阳市', '473000', '0');
INSERT INTO `sys_city` VALUES ('165', '16', '商丘市', '476000', '0');
INSERT INTO `sys_city` VALUES ('166', '16', '信阳市', '464000', '0');
INSERT INTO `sys_city` VALUES ('167', '16', '周口市', '466000', '0');
INSERT INTO `sys_city` VALUES ('168', '16', '驻马店市', '463000', '0');
INSERT INTO `sys_city` VALUES ('169', '17', '武汉市', '430000', '0');
INSERT INTO `sys_city` VALUES ('170', '17', '黄石市', '435000', '0');
INSERT INTO `sys_city` VALUES ('171', '17', '十堰市', '442000', '0');
INSERT INTO `sys_city` VALUES ('172', '17', '宜昌市', '443000', '0');
INSERT INTO `sys_city` VALUES ('173', '17', '襄阳市', '441000', '0');
INSERT INTO `sys_city` VALUES ('174', '17', '鄂州市', '436000', '0');
INSERT INTO `sys_city` VALUES ('175', '17', '荆门市', '448000', '0');
INSERT INTO `sys_city` VALUES ('176', '17', '孝感市', '432100', '0');
INSERT INTO `sys_city` VALUES ('177', '17', '荆州市', '434000', '0');
INSERT INTO `sys_city` VALUES ('178', '17', '黄冈市', '438000', '0');
INSERT INTO `sys_city` VALUES ('179', '17', '咸宁市', '437000', '0');
INSERT INTO `sys_city` VALUES ('180', '17', '随州市', '441300', '0');
INSERT INTO `sys_city` VALUES ('181', '17', '恩施土家族苗族自治州', '445000', '0');
INSERT INTO `sys_city` VALUES ('182', '17', '神农架林区', '442400', '0');
INSERT INTO `sys_city` VALUES ('183', '18', '长沙市', '410000', '0');
INSERT INTO `sys_city` VALUES ('184', '18', '株洲市', '412000', '0');
INSERT INTO `sys_city` VALUES ('185', '18', '湘潭市', '411100', '0');
INSERT INTO `sys_city` VALUES ('186', '18', '衡阳市', '421000', '0');
INSERT INTO `sys_city` VALUES ('187', '18', '邵阳市', '422000', '0');
INSERT INTO `sys_city` VALUES ('188', '18', '岳阳市', '414000', '0');
INSERT INTO `sys_city` VALUES ('189', '18', '常德市', '415000', '0');
INSERT INTO `sys_city` VALUES ('190', '18', '张家界市', '427000', '0');
INSERT INTO `sys_city` VALUES ('191', '18', '益阳市', '413000', '0');
INSERT INTO `sys_city` VALUES ('192', '18', '郴州市', '423000', '0');
INSERT INTO `sys_city` VALUES ('193', '18', '永州市', '425000', '0');
INSERT INTO `sys_city` VALUES ('194', '18', '怀化市', '418000', '0');
INSERT INTO `sys_city` VALUES ('195', '18', '娄底市', '417000', '0');
INSERT INTO `sys_city` VALUES ('196', '18', '湘西土家族苗族自治州', '416000', '0');
INSERT INTO `sys_city` VALUES ('197', '19', '广州市', '510000', '0');
INSERT INTO `sys_city` VALUES ('198', '19', '韶关市', '521000', '0');
INSERT INTO `sys_city` VALUES ('199', '19', '深圳市', '518000', '0');
INSERT INTO `sys_city` VALUES ('200', '19', '珠海市', '519000', '0');
INSERT INTO `sys_city` VALUES ('201', '19', '汕头市', '515000', '0');
INSERT INTO `sys_city` VALUES ('202', '19', '佛山市', '528000', '0');
INSERT INTO `sys_city` VALUES ('203', '19', '江门市', '529000', '0');
INSERT INTO `sys_city` VALUES ('204', '19', '湛江市', '524000', '0');
INSERT INTO `sys_city` VALUES ('205', '19', '茂名市', '525000', '0');
INSERT INTO `sys_city` VALUES ('206', '19', '肇庆市', '526000', '0');
INSERT INTO `sys_city` VALUES ('207', '19', '惠州市', '516000', '0');
INSERT INTO `sys_city` VALUES ('208', '19', '梅州市', '514000', '0');
INSERT INTO `sys_city` VALUES ('209', '19', '汕尾市', '516600', '1');
INSERT INTO `sys_city` VALUES ('210', '19', '河源市', '517000', '0');
INSERT INTO `sys_city` VALUES ('211', '19', '阳江市', '529500', '0');
INSERT INTO `sys_city` VALUES ('212', '19', '清远市', '511500', '0');
INSERT INTO `sys_city` VALUES ('213', '19', '东莞市', '511700', '0');
INSERT INTO `sys_city` VALUES ('214', '19', '中山市', '528400', '0');
INSERT INTO `sys_city` VALUES ('215', '19', '潮州市', '515600', '0');
INSERT INTO `sys_city` VALUES ('216', '19', '揭阳市', '522000', '0');
INSERT INTO `sys_city` VALUES ('217', '19', '云浮市', '527300', '0');
INSERT INTO `sys_city` VALUES ('218', '20', '南宁市', '530000', '0');
INSERT INTO `sys_city` VALUES ('219', '20', '柳州市', '545000', '0');
INSERT INTO `sys_city` VALUES ('220', '20', '桂林市', '541000', '0');
INSERT INTO `sys_city` VALUES ('221', '20', '梧州市', '543000', '0');
INSERT INTO `sys_city` VALUES ('222', '20', '北海市', '536000', '0');
INSERT INTO `sys_city` VALUES ('223', '20', '防城港市', '538000', '0');
INSERT INTO `sys_city` VALUES ('224', '20', '钦州市', '535000', '0');
INSERT INTO `sys_city` VALUES ('225', '20', '贵港市', '537100', '0');
INSERT INTO `sys_city` VALUES ('226', '20', '玉林市', '537000', '0');
INSERT INTO `sys_city` VALUES ('227', '20', '百色市', '533000', '0');
INSERT INTO `sys_city` VALUES ('228', '20', '贺州市', '542800', '0');
INSERT INTO `sys_city` VALUES ('229', '20', '河池市', '547000', '0');
INSERT INTO `sys_city` VALUES ('230', '20', '来宾市', '546100', '0');
INSERT INTO `sys_city` VALUES ('231', '20', '崇左市', '532200', '0');
INSERT INTO `sys_city` VALUES ('232', '21', '海口市', '570000', '0');
INSERT INTO `sys_city` VALUES ('233', '21', '三亚市', '572000', '0');
INSERT INTO `sys_city` VALUES ('234', '22', '重庆市', '400000', '0');
INSERT INTO `sys_city` VALUES ('235', '23', '成都市', '610000', '0');
INSERT INTO `sys_city` VALUES ('236', '23', '自贡市', '643000', '0');
INSERT INTO `sys_city` VALUES ('237', '23', '攀枝花市', '617000', '0');
INSERT INTO `sys_city` VALUES ('238', '23', '泸州市', '646100', '0');
INSERT INTO `sys_city` VALUES ('239', '23', '德阳市', '618000', '0');
INSERT INTO `sys_city` VALUES ('240', '23', '绵阳市', '621000', '0');
INSERT INTO `sys_city` VALUES ('241', '23', '广元市', '628000', '0');
INSERT INTO `sys_city` VALUES ('242', '23', '遂宁市', '629000', '0');
INSERT INTO `sys_city` VALUES ('243', '23', '内江市', '641000', '0');
INSERT INTO `sys_city` VALUES ('244', '23', '乐山市', '614000', '0');
INSERT INTO `sys_city` VALUES ('245', '23', '南充市', '637000', '0');
INSERT INTO `sys_city` VALUES ('246', '23', '眉山市', '612100', '0');
INSERT INTO `sys_city` VALUES ('247', '23', '宜宾市', '644000', '0');
INSERT INTO `sys_city` VALUES ('248', '23', '广安市', '638000', '0');
INSERT INTO `sys_city` VALUES ('249', '23', '达州市', '635000', '0');
INSERT INTO `sys_city` VALUES ('250', '23', '雅安市', '625000', '0');
INSERT INTO `sys_city` VALUES ('251', '23', '巴中市', '635500', '0');
INSERT INTO `sys_city` VALUES ('252', '23', '资阳市', '641300', '0');
INSERT INTO `sys_city` VALUES ('253', '23', '阿坝藏族羌族自治州', '624600', '0');
INSERT INTO `sys_city` VALUES ('254', '23', '甘孜藏族自治州', '626000', '0');
INSERT INTO `sys_city` VALUES ('255', '23', '凉山彝族自治州', '615000', '0');
INSERT INTO `sys_city` VALUES ('256', '24', '贵阳市', '55000', '0');
INSERT INTO `sys_city` VALUES ('257', '24', '六盘水市', '553000', '0');
INSERT INTO `sys_city` VALUES ('258', '24', '遵义市', '563000', '0');
INSERT INTO `sys_city` VALUES ('259', '24', '安顺市', '561000', '0');
INSERT INTO `sys_city` VALUES ('260', '24', '铜仁市', '554300', '0');
INSERT INTO `sys_city` VALUES ('261', '24', '黔西南布依族苗族自治州', '551500', '0');
INSERT INTO `sys_city` VALUES ('262', '24', '毕节市', '551700', '0');
INSERT INTO `sys_city` VALUES ('263', '24', '黔东南苗族侗族自治州', '551500', '0');
INSERT INTO `sys_city` VALUES ('264', '24', '黔南布依族苗族自治州', '550100', '0');
INSERT INTO `sys_city` VALUES ('265', '25', '昆明市', '650000', '0');
INSERT INTO `sys_city` VALUES ('266', '25', '曲靖市', '655000', '0');
INSERT INTO `sys_city` VALUES ('267', '25', '玉溪市', '653100', '0');
INSERT INTO `sys_city` VALUES ('268', '25', '保山市', '678000', '0');
INSERT INTO `sys_city` VALUES ('269', '25', '昭通市', '657000', '0');
INSERT INTO `sys_city` VALUES ('270', '25', '丽江市', '674100', '0');
INSERT INTO `sys_city` VALUES ('272', '25', '临沧市', '677000', '0');
INSERT INTO `sys_city` VALUES ('273', '25', '楚雄彝族自治州', '675000', '0');
INSERT INTO `sys_city` VALUES ('274', '25', '红河哈尼族彝族自治州', '654400', '0');
INSERT INTO `sys_city` VALUES ('275', '25', '文山壮族苗族自治州', '663000', '0');
INSERT INTO `sys_city` VALUES ('276', '25', '西双版纳傣族自治州', '666200', '0');
INSERT INTO `sys_city` VALUES ('277', '25', '大理白族自治州', '671000', '0');
INSERT INTO `sys_city` VALUES ('278', '25', '德宏傣族景颇族自治州', '678400', '0');
INSERT INTO `sys_city` VALUES ('279', '25', '怒江傈僳族自治州', '671400', '0');
INSERT INTO `sys_city` VALUES ('280', '25', '迪庆藏族自治州', '674400', '0');
INSERT INTO `sys_city` VALUES ('281', '26', '拉萨市', '850000', '0');
INSERT INTO `sys_city` VALUES ('282', '26', '昌都地区', '854000', '0');
INSERT INTO `sys_city` VALUES ('283', '26', '山南地区', '856000', '0');
INSERT INTO `sys_city` VALUES ('284', '26', '日喀则地区', '857000', '0');
INSERT INTO `sys_city` VALUES ('285', '26', '那曲地区', '852000', '0');
INSERT INTO `sys_city` VALUES ('286', '26', '阿里地区', '859100', '0');
INSERT INTO `sys_city` VALUES ('287', '26', '林芝地区', '860100', '0');
INSERT INTO `sys_city` VALUES ('288', '27', '西安市', '710000', '0');
INSERT INTO `sys_city` VALUES ('289', '27', '铜川市', '727000', '0');
INSERT INTO `sys_city` VALUES ('290', '27', '宝鸡市', '721000', '0');
INSERT INTO `sys_city` VALUES ('291', '27', '咸阳市', '712000', '0');
INSERT INTO `sys_city` VALUES ('292', '27', '渭南市', '714000', '0');
INSERT INTO `sys_city` VALUES ('293', '27', '延安市', '716000', '0');
INSERT INTO `sys_city` VALUES ('294', '27', '汉中市', '723000', '0');
INSERT INTO `sys_city` VALUES ('295', '27', '榆林市', '719000', '0');
INSERT INTO `sys_city` VALUES ('296', '27', '安康市', '725000', '0');
INSERT INTO `sys_city` VALUES ('297', '27', '商洛市', '711500', '0');
INSERT INTO `sys_city` VALUES ('298', '28', '兰州市', '730000', '0');
INSERT INTO `sys_city` VALUES ('299', '28', '嘉峪关市', '735100', '0');
INSERT INTO `sys_city` VALUES ('300', '28', '金昌市', '737100', '0');
INSERT INTO `sys_city` VALUES ('301', '28', '白银市', '730900', '0');
INSERT INTO `sys_city` VALUES ('302', '28', '天水市', '741000', '0');
INSERT INTO `sys_city` VALUES ('303', '28', '武威市', '733000', '0');
INSERT INTO `sys_city` VALUES ('304', '28', '张掖市', '734000', '0');
INSERT INTO `sys_city` VALUES ('305', '28', '平凉市', '744000', '0');
INSERT INTO `sys_city` VALUES ('306', '28', '酒泉市', '735000', '0');
INSERT INTO `sys_city` VALUES ('307', '28', '庆阳市', '744500', '0');
INSERT INTO `sys_city` VALUES ('308', '28', '定西市', '743000', '0');
INSERT INTO `sys_city` VALUES ('309', '28', '陇南市', '742100', '0');
INSERT INTO `sys_city` VALUES ('310', '28', '临夏回族自治州', '731100', '0');
INSERT INTO `sys_city` VALUES ('311', '28', '甘南藏族自治州', '747000', '0');
INSERT INTO `sys_city` VALUES ('312', '29', '西宁市', '810000', '0');
INSERT INTO `sys_city` VALUES ('313', '29', '海东市', '810600', '0');
INSERT INTO `sys_city` VALUES ('314', '29', '海北藏族自治州', '810300', '0');
INSERT INTO `sys_city` VALUES ('315', '29', '黄南藏族自治州', '811300', '0');
INSERT INTO `sys_city` VALUES ('316', '29', '海南藏族自治州', '813000', '0');
INSERT INTO `sys_city` VALUES ('317', '29', '果洛藏族自治州', '814000', '0');
INSERT INTO `sys_city` VALUES ('318', '29', '玉树藏族自治州', '815000', '0');
INSERT INTO `sys_city` VALUES ('319', '29', '海西蒙古族藏族自治州', '817000', '0');
INSERT INTO `sys_city` VALUES ('320', '30', '银川市', '750000', '0');
INSERT INTO `sys_city` VALUES ('321', '30', '石嘴山市', '753000', '0');
INSERT INTO `sys_city` VALUES ('322', '30', '吴忠市', '751100', '0');
INSERT INTO `sys_city` VALUES ('323', '30', '固原市', '756000', '0');
INSERT INTO `sys_city` VALUES ('324', '30', '中卫市', '751700', '0');
INSERT INTO `sys_city` VALUES ('325', '31', '乌鲁木齐市', '830000', '0');
INSERT INTO `sys_city` VALUES ('326', '31', '克拉玛依市', '834000', '0');
INSERT INTO `sys_city` VALUES ('327', '31', '吐鲁番地区', '838000', '0');
INSERT INTO `sys_city` VALUES ('328', '31', '哈密地区', '839000', '0');
INSERT INTO `sys_city` VALUES ('329', '31', '昌吉回族自治州', '831100', '0');
INSERT INTO `sys_city` VALUES ('330', '31', '博尔塔拉蒙古自治州', '833400', '0');
INSERT INTO `sys_city` VALUES ('331', '31', '巴音郭楞蒙古自治州', '841000', '0');
INSERT INTO `sys_city` VALUES ('332', '31', '阿克苏地区', '843000', '0');
INSERT INTO `sys_city` VALUES ('333', '31', '克孜勒苏柯尔克孜自治州', '835600', '0');
INSERT INTO `sys_city` VALUES ('334', '31', '喀什地区', '844000', '0');
INSERT INTO `sys_city` VALUES ('335', '31', '和田地区', '848000', '0');
INSERT INTO `sys_city` VALUES ('336', '31', '伊犁哈萨克自治州', '833200', '0');
INSERT INTO `sys_city` VALUES ('337', '31', '塔城地区', '834700', '0');
INSERT INTO `sys_city` VALUES ('338', '31', '阿勒泰地区', '836500', '0');
INSERT INTO `sys_city` VALUES ('339', '31', '石河子市', '832000', '0');
INSERT INTO `sys_city` VALUES ('340', '31', '阿拉尔市', '843300', '0');
INSERT INTO `sys_city` VALUES ('341', '31', '图木舒克市', '843900', '0');
INSERT INTO `sys_city` VALUES ('342', '31', '五家渠市', '831300', '0');
INSERT INTO `sys_city` VALUES ('343', '32', '香港岛', '000000', '0');
INSERT INTO `sys_city` VALUES ('344', '33', '澳门半岛', '000000', '0');
INSERT INTO `sys_city` VALUES ('345', '34', '高雄市', '000000', '0');
INSERT INTO `sys_city` VALUES ('346', '21', '白沙黎族自治县', '', '0');
INSERT INTO `sys_city` VALUES ('347', '21', '保亭黎族苗族自治县', '', '0');
INSERT INTO `sys_city` VALUES ('348', '34', '花莲县', '', '0');
INSERT INTO `sys_city` VALUES ('349', '19', '东沙群岛', '', '0');
INSERT INTO `sys_city` VALUES ('351', '32', '新界', '', '0');
INSERT INTO `sys_city` VALUES ('352', '16', '济源市', '', '0');
INSERT INTO `sys_city` VALUES ('353', '34', '嘉义县', '', '0');
INSERT INTO `sys_city` VALUES ('354', '34', '基隆市', '', '0');
INSERT INTO `sys_city` VALUES ('355', '34', '金门县', '', '0');
INSERT INTO `sys_city` VALUES ('356', '21', '东方市', '', '0');
INSERT INTO `sys_city` VALUES ('358', '34', '苗栗县', '', '0');
INSERT INTO `sys_city` VALUES ('359', '34', '南投县', '', '0');
INSERT INTO `sys_city` VALUES ('360', '34', '澎湖县', '', '0');
INSERT INTO `sys_city` VALUES ('361', '21', '陵水黎族自治县', '', '0');
INSERT INTO `sys_city` VALUES ('362', '34', '屏东县', '', '0');
INSERT INTO `sys_city` VALUES ('363', '34', '台北市', '', '0');
INSERT INTO `sys_city` VALUES ('364', '21', '琼中黎族苗族自治县', '', '0');
INSERT INTO `sys_city` VALUES ('365', '21', '三沙市', '', '0');
INSERT INTO `sys_city` VALUES ('366', '17', '仙桃市', '', '0');
INSERT INTO `sys_city` VALUES ('367', '21', '屯昌县', '', '0');
INSERT INTO `sys_city` VALUES ('368', '21', '万宁市', '', '0');
INSERT INTO `sys_city` VALUES ('369', '21', '文昌市', '', '0');
INSERT INTO `sys_city` VALUES ('370', '21', '五指山市', '', '0');
INSERT INTO `sys_city` VALUES ('371', '34', '彰化县', '', '0');
INSERT INTO `sys_city` VALUES ('372', '32', '九龙', '', '0');
INSERT INTO `sys_city` VALUES ('373', '33', '离岛', '', '0');
INSERT INTO `sys_city` VALUES ('374', '34', '嘉义市', '', '0');
INSERT INTO `sys_city` VALUES ('375', '21', '澄迈县', '', '0');
INSERT INTO `sys_city` VALUES ('376', '21', '定安县', '', '0');
INSERT INTO `sys_city` VALUES ('377', '34', '连江县', '', '0');
INSERT INTO `sys_city` VALUES ('378', '21', '乐东黎族自治县', '', '0');
INSERT INTO `sys_city` VALUES ('379', '17', '天门市', '', '0');
INSERT INTO `sys_city` VALUES ('380', '21', '琼海市', '', '0');
INSERT INTO `sys_city` VALUES ('381', '34', '台东县', '', '0');
INSERT INTO `sys_city` VALUES ('382', '34', '台中市', '', '0');
INSERT INTO `sys_city` VALUES ('383', '34', '新北市', '', '0');
INSERT INTO `sys_city` VALUES ('384', '34', '新竹县', '', '0');
INSERT INTO `sys_city` VALUES ('387', '17', '潜江市', '', '0');
INSERT INTO `sys_city` VALUES ('388', '21', '临高县', '', '0');
INSERT INTO `sys_city` VALUES ('390', '34', '桃园县', '', '0');
INSERT INTO `sys_city` VALUES ('391', '34', '云林县', '', '0');
INSERT INTO `sys_city` VALUES ('392', '21', '昌江黎族自治县', '', '0');
INSERT INTO `sys_city` VALUES ('394', '34', '台南市', '', '0');
INSERT INTO `sys_city` VALUES ('395', '21', '儋州市', '', '0');
INSERT INTO `sys_city` VALUES ('396', '34', '新竹市', '', '0');
INSERT INTO `sys_city` VALUES ('397', '25', '普洱市', '', '0');

-- ----------------------------
-- Table structure for `sys_config`
-- ----------------------------
DROP TABLE IF EXISTS `sys_config`;
CREATE TABLE `sys_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `instance_id` int(11) NOT NULL DEFAULT '1' COMMENT '实例ID',
  `key` varchar(255) NOT NULL DEFAULT '' COMMENT '配置项WCHAT,QQ,WPAY,ALIPAY...',
  `value` varchar(4000) DEFAULT NULL,
  `desc` varchar(1000) NOT NULL DEFAULT '' COMMENT '描述',
  `is_use` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否启用 1启用 0不启用',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=319 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=963 COMMENT='第三方配置表';

-- ----------------------------
-- Records of sys_config
-- ----------------------------
INSERT INTO `sys_config` VALUES ('12', '0', 'USERNOTICE', '', '', '1', '1487830081', '1497102938');
INSERT INTO `sys_config` VALUES ('14', '0', 'DEFAULTKEY', '', '', '1', '1487831788', '1553164170');
INSERT INTO `sys_config` VALUES ('17', '0', 'QQLOGIN', '{\"APP_KEY\":\"\",\"APP_SECRET\":\"\",\"AUTHORIZE\":\"http:\\/\\/localhost\",\"CALLBACK\":\"http:\\/\\/localhost\\/niushop_b2c_3\\/index.php?s=\\/wap\\/login\\/callback\"}', 'qq', '1', '1488350925', '1553758094');
INSERT INTO `sys_config` VALUES ('18', '0', 'WCHAT', '{\"APP_KEY\":\"\",\"APP_SECRET\":\"\",\"AUTHORIZE\":\"http:\\/\\/localhost\",\"CALLBACK\":\"http:\\/\\/localhost\\/niushop_b2c_3\\/index.php?s=\\/wap\\/login\\/callback\"}', '微信', '1', '1488350947', '1553224125');
INSERT INTO `sys_config` VALUES ('21', '0', 'ALIPAY', '{\"ali_partnerid\":\"\",\"ali_seller\":\"\",\"ali_key\":\"\"}', '', '1', '1488442697', '1553225422');
INSERT INTO `sys_config` VALUES ('22', '0', 'EMAILMESSAGE', '{\"email_host\":\"smtp.163.com\",\"email_port\":\"465\",\"email_addr\":\"yinongtx@163.com\",\"email_id\":\"yinongtx@163.com\",\"email_pass\":\"yntx123456\",\"email_is_security\":\"true\"}', '', '1', '1488524450', '1553224213');
INSERT INTO `sys_config` VALUES ('27', '0', 'WXOPENPLATFORM', '', '', '1', '1490845979', '1496903672');
INSERT INTO `sys_config` VALUES ('31', '0', 'COIN_CONFIG', '', '购物币现金转化关系', '1', '1492396593', '1496903672');
INSERT INTO `sys_config` VALUES ('38', '0', 'ORDER_BUY_CLOSE_TIME', '60', '订单自动关闭时间', '1', '1499391774', '1553824241');
INSERT INTO `sys_config` VALUES ('39', '0', 'ORDER_DELIVERY_COMPLETE_TIME', '0', '收货后多长时间自动完成', '1', '1499391779', '1553824241');
INSERT INTO `sys_config` VALUES ('40', '0', 'ORDER_AUTO_DELIVERY', '1', '订单多长时间自动完成', '1', '1499391781', '1553824241');
INSERT INTO `sys_config` VALUES ('42', '0', 'ORDER_INVOICE_TAX', '10', '发票税率', '1', '1499391786', '1553824241');
INSERT INTO `sys_config` VALUES ('43', '0', 'ORDER_INVOICE_CONTENT', '办公用品,商品明细', '发票内容', '1', '1499391789', '1553824241');
INSERT INTO `sys_config` VALUES ('44', '0', 'ORDER_SHOW_BUY_RECORD', '1', '是否显示购买记录', '1', '1499391791', '1553824241');
INSERT INTO `sys_config` VALUES ('45', '0', 'SEO_TITLE', '开源商城', '标题附加字', '1', '1496751194', '1553065447');
INSERT INTO `sys_config` VALUES ('46', '0', 'SEO_META', '商城,php', '商城关键词', '1', '1496751194', '1553065447');
INSERT INTO `sys_config` VALUES ('47', '0', 'SEO_DESC', '商城', '关键词描述', '1', '1496751194', '1553065447');
INSERT INTO `sys_config` VALUES ('48', '0', 'SEO_OTHER', '', '其他页头信息', '1', '1496751194', '1553065447');
INSERT INTO `sys_config` VALUES ('107', '0', 'ORDER_DELIVERY_PAY', '1', '是否开启货到付款', '1', '1496825466', '1553824241');
INSERT INTO `sys_config` VALUES ('116', '0', 'LOGINVERIFYCODE', '{\"platform\":0,\"admin\":\"0\",\"pc\":\"1\",\"error_num\":\"0\"}', '', '1', '1497085371', '1553313276');
INSERT INTO `sys_config` VALUES ('125', '0', 'WPAY', '{\"appid\":\"\",\"appkey\":\"\",\"mch_id\":\"\",\"mch_key\":\"\"}', '', '1', '1497087123', '1553564976');
INSERT INTO `sys_config` VALUES ('127', '0', 'SHOPWCHAT', '{\"appid\":\"\",\"appsecret\":\"\",\"token\":\"\"}', '', '1', '1497088090', '1553745506');
INSERT INTO `sys_config` VALUES ('128', '0', 'BUYER_SELF_LIFTING', '1', '是否开启买家自提', '1', '1498730475', '1553824241');
INSERT INTO `sys_config` VALUES ('129', '0', 'ORDER_SELLER_DISPATCHING', '1', '是否开启商家配送', '1', '1498730475', '1553824241');
INSERT INTO `sys_config` VALUES ('130', '0', 'SHOPPING_BACK_POINTS', '2', '购物返积分设置', '1', '1498730475', '1553824241');
INSERT INTO `sys_config` VALUES ('136', '0', 'MOBILEMESSAGE', '{\"appKey\":\"\",\"secretKey\":\"\",\"freeSignName\":\"\",\"user_type\":\"1\"}', '', '1', '1498894954', '1547716192');
INSERT INTO `sys_config` VALUES ('138', '0', 'UPLOAD_TYPE', '1', '上传方式 1 本地  2 七牛', '1', '1508490002', '0');
INSERT INTO `sys_config` VALUES ('139', '0', 'SERVICE_ADDR', '{\"service_addr\":\"\"}', '客服链接地址设置', '0', '1508490287', '1555385149');
INSERT INTO `sys_config` VALUES ('140', '0', 'ORDER_IS_LOGISTICS', '0', '是否允许选择物流', '1', '1508490596', '1553824241');
INSERT INTO `sys_config` VALUES ('141', '0', 'QINIU_CONFIG', ' {\"Accesskey\":\"\",\"Secretkey\":\"\",\"Bucket\":\"zkf-\",\"QiniuUrl\":\"http:\\/\\/plxkqx11h.bkt.clouddn.com\"}', '七牛云存储参数配置', '1', '1508490924', '0');
INSERT INTO `sys_config` VALUES ('142', '0', 'USE_WAP_TEMPLATE', 'default', '当前使用的手机端模板文件夹', '1', '1508500950', '1553839690');
INSERT INTO `sys_config` VALUES ('143', '0', 'IS_RECOMMEND', '{\"is_recommend\":\"\"}', '首页商城促销版块显示设置', '0', '1508500950', '0');
INSERT INTO `sys_config` VALUES ('144', '0', 'IS_CATEGORY', '{\"is_category\":\"1\"}', '首页商品分类是否显示设置', '1', '1508500950', '1532923857');
INSERT INTO `sys_config` VALUES ('145', '0', 'COPYRIGHT_LOGO', '', '版权logo', '1', '1508721501', '1553168891');
INSERT INTO `sys_config` VALUES ('146', '0', 'COPYRIGHT_META', '', '备案号', '1', '1508721501', '1553168891');
INSERT INTO `sys_config` VALUES ('147', '0', 'COPYRIGHT_LINK', '', '版权链接', '1', '1508721501', '1553168891');
INSERT INTO `sys_config` VALUES ('148', '0', 'COPYRIGHT_DESC', '', '版权信息', '1', '1508721501', '1553168891');
INSERT INTO `sys_config` VALUES ('149', '0', 'COPYRIGHT_COMPANYNAME', '', '公司名称', '1', '1508721502', '1553168891');
INSERT INTO `sys_config` VALUES ('150', '0', 'IMG_THUMB', '{\"thumb_type\":\"2\",\"upload_size\":\"\",\"upload_ext\":\"\"}', 'thumb_type(缩略)  3 居中裁剪 2 缩放后填充 4 左上角裁剪 5 右下角裁剪 6 固定尺寸缩放', '1', '1508842078', '0');
INSERT INTO `sys_config` VALUES ('151', '0', 'DEFAULT_IMAGE', '{\"default_goods_img\":\"upload/default/default_goods.png\",\"default_headimg\":\"upload/config/2019033010462810997.png\",\"default_cms_thumbnail\":\"\"}', '默认图片', '1', '0', '0');
INSERT INTO `sys_config` VALUES ('152', '0', 'UNIONPAY', '{\"merchant_number\":\"\",\"sign_cert_pwd\":\"\",\"certs_path\":\"\",\"log_path\":\"\",\"service_charge\":\"0\"}', '银联卡支付', '1', '1523414702', '1553740126');
INSERT INTO `sys_config` VALUES ('153', '0', 'WATER_CONFIG', '{\"watermark\":\"0\",\"transparency\":\"50\",\"waterPosition\":\"5\",\"imgWatermark\":\"\"}', '图片水印参数配置', '1', '1525258565', '0');
INSERT INTO `sys_config` VALUES ('154', '0', 'IS_OPEN_VIRTUAL_GOODS', '1', '是否开启虚拟商品', '1', '1525259381', '1553824241');
INSERT INTO `sys_config` VALUES ('155', '0', 'IS_OPEN_ORDER_DESIGNATED_DELIVERY_TIME', '0', '是否开启订单指定配送时间', '1', '1525259381', '1553824241');
INSERT INTO `sys_config` VALUES ('156', '0', 'IS_OPEN_O2O', '1', '是否开启本地配送', '1', '1525259381', '1553824242');
INSERT INTO `sys_config` VALUES ('157', '0', 'MERCHANT_SERVICE', '[{\"id\":0,\"title\":\"七天包退\",\"describe\":\"商家服务\",\"pic\":\"\"},{\"id\":1,\"title\":\"正品保障\",\"describe\":\"\",\"pic\":\"\"},{\"id\":2,\"title\":\"闪电配送\",\"describe\":\"\",\"pic\":\"\"}]', '商家服务', '1', '0', '1553164357');
INSERT INTO `sys_config` VALUES ('158', '0', 'Bargain', '{\"activity_time\":\"90\",\"bargain_max_number\":\"10\",\"cut_methods\":\"\",\"launch_cut_method\":\"\",\"propaganda\":\"\",\"rule\":\"\"}', '砍价配置信息', '1', '1525343575', '1553136692');
INSERT INTO `sys_config` VALUES ('159', '0', 'USE_PC_TEMPLATE', 'default', '当前使用的PC端模板文件夹', '1', '1553325862', '1553325862');
INSERT INTO `sys_config` VALUES ('160', '0', 'WITHDRAW_BALANCE', '{\"withdraw_cash_min\":\"5\",\"withdraw_multiple\":\"1\",\"withdraw_poundage\":\"0\",\"withdraw_message\":\"\",\"withdraw_account\":[{\"id\":\"bank_card\",\"name\":\"\\u94f6\\u884c\\u5361\",\"value\":1,\"is_checked\":0},{\"id\":\"wechat\",\"name\":\"\\u5fae\\u4fe1\",\"value\":2,\"is_checked\":1},{\"id\":\"alipay\",\"name\":\"\\u652f\\u4ed8\\u5b9d\",\"value\":3,\"is_checked\":1}]}', '会员余额提现设置', '1', '1525951016', '1556008700');
INSERT INTO `sys_config` VALUES ('161', '0', 'WAP_CUSTOM_TEMPLATE_IS_ENABLE', '0', '', '1', '1526713932', '1553251313');
INSERT INTO `sys_config` VALUES ('162', '0', 'ORDER_BALANCE_PAY', '1', '是否开启余额支付', '1', '1527322549', '1553824241');
INSERT INTO `sys_config` VALUES ('163', '0', 'ORDER_EXPRESS_MESSAGE', '{\"type\":\"1\",\"appid\":\"1340223\",\"appkey\":\"0ff22c35-0118-4b55-8f44-dee71b6866b0\",\"back_url\":\"\",\"customer\":\"\"}', '物流跟踪配置信息', '1', '1528184574', '1553741431');
INSERT INTO `sys_config` VALUES ('167', '0', 'DISTRIBUTION_TIME_SLOT', '[{\"start\":\"07\",\"end\":\"09\"},{\"start\":\"10\",\"end\":\"12\"}]', '配送时间时间段', '1', '1530073283', '1553824242');
INSERT INTO `sys_config` VALUES ('173', '0', 'DISTRIBUTION_TIME_CONFIG', '{\"morning_start\":\"00 : 00\",\"morning_end\":\"02 : 30\",\"afternoon_start\":\"12 : 00\",\"afternoon_end\":\"15 : 30\"}', '本地配送时间设置', '1', '1530774403', '0');
INSERT INTO `sys_config` VALUES ('174', '0', 'APP_WELCOME_PAGE_CONFIG', '', 'App欢迎页配置', '1', '1531207339', '1553510846');
INSERT INTO `sys_config` VALUES ('175', '0', 'WAP_CLASSIFIED_DISPLAY_MODE', '{\"template\":\"3\",\"style\":1,\"is_img\":\"1\"}', '手机端分类显示方式，1:缩略图模式，2：列表模式', '1', '1532923858', '1553307845');
INSERT INTO `sys_config` VALUES ('176', '0', 'SYSTEM_DEFAULT_EVALUATE', '{\"day\":\"0\",\"evaluate\":\"\\u7528\\u6237\\u672a\\u80fd\\u53ca\\u65f6\\u4f5c\\u51fa\\u8bc4\\u4ef7\\uff0c\\u7cfb\\u7edf\\u9ed8\\u8ba4\\u597d\\u8bc4\"}', '系统默认评价', '1', '1532945046', '1553824242');
INSERT INTO `sys_config` VALUES ('177', '0', 'ORIGINAL_ROAD_REFUND_SETTING_UNIONPAY', '{\"is_use\":1}', '', '1', '1533285059', '1553740126');
INSERT INTO `sys_config` VALUES ('178', '0', 'SHOPHOU_DAY_NUMBER', '0', '可以售后的时间段', '1', '1536144899', '1553824242');
INSERT INTO `sys_config` VALUES ('179', '0', 'ORIGINAL_ROAD_REFUND_SETTING_ALIPAY', '{\"is_use\":1}', '', '1', '1539308976', '1553485755');
INSERT INTO `sys_config` VALUES ('180', '0', 'TRANSFER_ACCOUNTS_SETTING_ALIPAY', '{\"is_use\":1}', '', '1', '1539308976', '1553485755');
INSERT INTO `sys_config` VALUES ('249', '0', 'REGISTER_INTEGRAL', '0', '注册送积分', '1', '1542687139', '1553672795');
INSERT INTO `sys_config` VALUES ('250', '0', 'SIGN_INTEGRAL', '0', '签到送积分', '1', '1542687139', '1553672795');
INSERT INTO `sys_config` VALUES ('251', '0', 'SHARE_INTEGRAL', '0', '分享送积分', '1', '1542687139', '1553672795');
INSERT INTO `sys_config` VALUES ('252', '0', 'SHARE_COUPON', '0', '分享送优惠券', '1', '1542687139', '1553672795');
INSERT INTO `sys_config` VALUES ('253', '0', 'SIGN_COUPON', '0', '签到送优惠券', '1', '1542687139', '1553672795');
INSERT INTO `sys_config` VALUES ('254', '0', 'REGISTER_COUPON', '0', '注册送优惠券', '1', '1542687139', '1553672795');
INSERT INTO `sys_config` VALUES ('255', '0', 'COMMENT_COUPON', '0', '评论送优惠券', '1', '1542687140', '1553672795');
INSERT INTO `sys_config` VALUES ('256', '0', 'CLICK_COUPON', '0', '点赞送优惠券', '1', '1542687140', '1553672795');
INSERT INTO `sys_config` VALUES ('257', '0', 'ORIGINAL_ROAD_REFUND_SETTING_WECHAT', '{\"is_use\":0,\"apiclient_cert\":\"\",\"apiclient_key\":\"\"}', '', '1', '1545890003', '1553564976');
INSERT INTO `sys_config` VALUES ('258', '0', 'TRANSFER_ACCOUNTS_SETTING_WECHAT', 'wechat', '', '1', '1545890003', '1553564976');
INSERT INTO `sys_config` VALUES ('265', '0', 'WAP_PAGE_LAYOUT', '\"[{\\\"tag\\\":\\\"follow-wechat\\\",\\\"name\\\":\\\"\\u5173\\u6ce8\\u5fae\\u4fe1\\u516c\\u4f17\\u53f7\\\",\\\"className\\\":\\\"item-follow-wechat-public-account\\\",\\\"isVisible\\\":true,\\\"url\\\":\\\"wchat\\/config\\\"},{\\\"tag\\\":\\\"banner\\\",\\\"name\\\":\\\"\\u8f6e\\u64ad\\u56fe\\\",\\\"className\\\":\\\"item-banner\\\",\\\"isVisible\\\":true,\\\"url\\\":\\\"system\\/updateshopadvposition?terminal=2&ap_id=1105\\\"},{\\\"tag\\\":\\\"search\\\",\\\"name\\\":\\\"\\u641c\\u7d22\\u680f\\\",\\\"className\\\":\\\"item-search\\\",\\\"isVisible\\\":true,\\\"url\\\":\\\"\\\"},{\\\"tag\\\":\\\"nav\\\",\\\"name\\\":\\\"\\u5bfc\\u822a\\u680f\\\",\\\"className\\\":\\\"item-nav\\\",\\\"isVisible\\\":true,\\\"url\\\":\\\"config\\/shopNavigationList?nav_type=2\\\"},{\\\"tag\\\":\\\"notice\\\",\\\"name\\\":\\\"\\u516c\\u544a\\\",\\\"className\\\":\\\"item-notice\\\",\\\"isVisible\\\":true,\\\"url\\\":\\\"config\\/userNotice\\\"},{\\\"tag\\\":\\\"coupons\\\",\\\"name\\\":\\\"\\u4f18\\u60e0\\u5238\\\",\\\"className\\\":\\\"item-coupons\\\",\\\"isVisible\\\":true,\\\"url\\\":\\\"promotion\\/coupontypelist\\\"},{\\\"tag\\\":\\\"games\\\",\\\"name\\\":\\\"\\u6e38\\u620f\\u6d3b\\u52a8\\\",\\\"className\\\":\\\"item-games\\\",\\\"isVisible\\\":true,\\\"url\\\":\\\"promotion\\/index\\\"},{\\\"tag\\\":\\\"discount\\\",\\\"name\\\":\\\"\\u9650\\u65f6\\u6298\\u6263\\\",\\\"className\\\":\\\"item-discount\\\",\\\"isVisible\\\":true,\\\"url\\\":\\\"promotion\\/getdiscountlist\\\"},{\\\"tag\\\":\\\"spell-group\\\",\\\"name\\\":\\\"\\u62fc\\u56e2\\u63a8\\u8350\\\",\\\"className\\\":\\\"item-spell-group\\\",\\\"isVisible\\\":true,\\\"url\\\":\\\"tuangou\\/pintuanlist\\\"},{\\\"tag\\\":\\\"adv\\\",\\\"name\\\":\\\"\\u5e7f\\u544a\\u4f4d\\\",\\\"className\\\":\\\"item-adv\\\",\\\"isVisible\\\":true,\\\"url\\\":\\\"system\\/shopadvpositionlist?terminal=2\\\"},{\\\"tag\\\":\\\"goods\\\",\\\"name\\\":\\\"\\u63a8\\u8350\\u5546\\u54c1\\\",\\\"className\\\":\\\"item-goods\\\",\\\"isVisible\\\":true,\\\"url\\\":\\\"config\\/goodsRecommend\\\"},{\\\"tag\\\":\\\"cube\\\",\\\"name\\\":\\\"\\u9b54\\u65b9\\\",\\\"className\\\":\\\"item-cube\\\",\\\"isVisible\\\":true,\\\"url\\\":\\\"config\\/shopCube\\\"},{\\\"tag\\\":\\\"bottom\\\",\\\"name\\\":\\\"\\u5e95\\u90e8\\u5bfc\\u822a\\\",\\\"className\\\":\\\"item-bottom\\\",\\\"isVisible\\\":true,\\\"url\\\":\\\"\\\"}]\"', '手机端首页排版', '1', '1548303565', '1550660424');
INSERT INTO `sys_config` VALUES ('266', '0', 'SHOPAPPLET', '', '', '1', '1548466794', '1553850037');
INSERT INTO `sys_config` VALUES ('267', '0', 'API_SECURE_CONFIG', '', '设置API安全', '1', '1549865564', '1553226008');
INSERT INTO `sys_config` VALUES ('268', '0', 'WAP_HOME_MAGIC_CUBE', '', '手机端首页魔方', '1', '1550630465', '1550717220');
INSERT INTO `sys_config` VALUES ('270', '0', 'ORIGINAL_ROAD_REFUND_BANBEN_ALIPAY', '{\"is_use\":1}', '', '1', '1552294701', '1552299798');
INSERT INTO `sys_config` VALUES ('271', '0', 'ALIPAY_NEW', '{\"app_id\":\"\",\"private_key\":\"\",\"public_key\":\"\",\"alipay_public_key\":\"\"}', '', '1', '1552296486', '1553485755');
INSERT INTO `sys_config` VALUES ('272', '0', 'REGISTRATION_AGREEMENT', '', '设置注册协议', '1', '1552637961', '1553155921');
INSERT INTO `sys_config` VALUES ('273', '0', 'PICKUPPOINT_FREIGHT', '', '自提点运费菜单配置', '1', '1553223554', '1553743314');
INSERT INTO `sys_config` VALUES ('274', '0', 'ALIPAY_STATUS', '{\"is_use\":1}', '', '1', '1553224352', '1553485755');
INSERT INTO `sys_config` VALUES ('275', '0', 'VERSION_ALIPAY', '{\"is_use\":\"1\"}', '', '1', '1553224352', '1553485755');
INSERT INTO `sys_config` VALUES ('317', '0', 'REGISTERANDVISIT', '{\"is_register\":\"1\",\"register_info\":\"plain\",\"name_keyword\":\"\",\"pwd_len\":\"5\",\"pwd_complexity\":\"\",\"terms_of_service\":\"\",\"is_requiretel\":0}', '', '1', '1554121696', '0');
INSERT INTO `sys_config` VALUES ('318', '0', 'MEMBER_LEVEL_CONFIG', '{\"type\":1}', '会员升级规则  1 累计积分 2 累计消费 3 购买次数 4 购买商品', '1', '1555394731', '0');

-- ----------------------------
-- Table structure for `sys_cron`
-- ----------------------------
DROP TABLE IF EXISTS `sys_cron`;
CREATE TABLE `sys_cron` (
  `cron_id` int(11) NOT NULL AUTO_INCREMENT,
  `cron_name` varchar(50) NOT NULL DEFAULT '' COMMENT '任务名称',
  `cron_desc` varchar(1000) NOT NULL DEFAULT '' COMMENT '任务简介',
  `cron_time` int(11) NOT NULL DEFAULT '0' COMMENT '执行周期数',
  `cron_period` int(11) NOT NULL DEFAULT '1' COMMENT '执行周期分',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `cron_hook` varchar(255) NOT NULL DEFAULT '' COMMENT '执行任务钩子',
  `cron_addon` varchar(255) NOT NULL DEFAULT '' COMMENT '任务插件',
  `cron_class_name` varchar(255) NOT NULL DEFAULT '' COMMENT '类名空间(针对钩子不存在情况)',
  `cron_function` varchar(255) NOT NULL DEFAULT '' COMMENT '执行方法',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `last_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后执行时间',
  `cron_result` text COMMENT '最后执行结果',
  PRIMARY KEY (`cron_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1092 COMMENT='计划任务表';

-- ----------------------------
-- Records of sys_cron
-- ----------------------------
INSERT INTO `sys_cron` VALUES ('1', '订单自动关闭', '系统每个一分钟执行订单自动关闭', '1', '1', '0', '', '', 'data\\service\\Events', 'ordersClose', '1', '1556098348', '1');
INSERT INTO `sys_cron` VALUES ('2', '订单自动收货', '系统每日执行订单自动收货', '1', '1440', '0', '', '', 'data\\service\\Events', 'autoDeilvery', '1', '1556071584', '1');
INSERT INTO `sys_cron` VALUES ('3', '订单自动完成', '系统自动执行订单自动完成', '1', '1', '0', '', '', 'data\\service\\Events', 'ordersComplete', '1', '1556098348', '1');
INSERT INTO `sys_cron` VALUES ('4', '满减送自动开启与关闭', '系统自动执行满减送自动开启与关闭', '1', '1', '0', '', '', 'data\\service\\Events', 'mansongOperation', '1', '1556098348', '1');
INSERT INTO `sys_cron` VALUES ('5', '限时折扣自动开启关闭', '限时折扣自动开启关闭', '1', '1', '0', '', '', 'data\\service\\Events', 'discountOperation', '1', '1556098348', '1');
INSERT INTO `sys_cron` VALUES ('6', '优惠券自动过期', '优惠券自动过期', '1', '1', '0', '', '', 'data\\service\\Events', 'autoCouponClose', '1', '1556098348', '1');
INSERT INTO `sys_cron` VALUES ('7', '团购自动关闭', '团购自动关闭', '1', '1', '0', '', 'NsGroupBuy', 'data\\service\\Events', 'autoGroupBuyClose', '1', '1556098348', '1');
INSERT INTO `sys_cron` VALUES ('8', '营销游戏自动开启与关闭', '营销游戏自动开启与关闭', '1', '1', '0', '', '', 'data\\service\\Events', 'autoPromotionGamesOperation', '1', '1556098348', '1');
INSERT INTO `sys_cron` VALUES ('9', '短信邮箱发送通知', '短信邮箱发送通知', '1', '60', '0', '', '', 'data\\service\\Notice', 'sendNoticeRecords', '1', '1556097615', '1');
INSERT INTO `sys_cron` VALUES ('10', '虚拟商品自动失效', '虚拟商品自动失效', '1', '1440', '0', '', '', 'data\\service\\Verification', 'virtualGoodsClose', '1', '1556071585', '1');
INSERT INTO `sys_cron` VALUES ('11', '拼团过期自动关闭', '拼团过期自动关闭', '1', '1', '0', '', 'NsPintuan', 'data\\service\\Events', 'pintuanGroupClose', '1', '1556098348', '0');
INSERT INTO `sys_cron` VALUES ('12', '砍价过期自动关闭', '砍价过期自动关闭', '1', '1', '0', '', 'NsBargain', 'data\\service\\Events', 'bargainOperation', '1', '1556098348', '0');
INSERT INTO `sys_cron` VALUES ('13', '预售订单自动到期', '预售订单自动到期', '1', '1', '0', '', '', 'data\\service\\Events', 'autoPresellOrder', '1', '1556098348', '1');
INSERT INTO `sys_cron` VALUES ('14', '商品活动记录变动', '商品活动记录变动', '1', '1', '0', '', '', 'data\\service\\Events', 'goodsPromotion', '1', '1556098348', '1');
INSERT INTO `sys_cron` VALUES ('15', '专题活动自动开启关闭', '专题活动自动开启关闭', '1', '1', '0', '', '', 'data\\service\\Events', 'autoTopicClose', '1', '1556098348', '1');

-- ----------------------------
-- Table structure for `sys_custom_template`
-- ----------------------------
DROP TABLE IF EXISTS `sys_custom_template`;
CREATE TABLE `sys_custom_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `template_name` varchar(250) DEFAULT NULL COMMENT '自定义模板名称（暂时预留）',
  `template_data` text NOT NULL COMMENT '模板数据（JSON格式）',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间戳',
  `modify_time` int(11) DEFAULT NULL COMMENT '修改时间戳',
  `is_enable` int(11) NOT NULL DEFAULT '0' COMMENT '是否启用 0 不启用 1 启用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='手机端自定义模板';

-- ----------------------------
-- Records of sys_custom_template
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_district`
-- ----------------------------
DROP TABLE IF EXISTS `sys_district`;
CREATE TABLE `sys_district` (
  `district_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) DEFAULT '0',
  `district_name` varchar(255) NOT NULL DEFAULT '',
  `sort` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`district_id`),
  KEY `IDX_g_district_DistrictName` (`district_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4442 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=50;

-- ----------------------------
-- Records of sys_district
-- ----------------------------
INSERT INTO `sys_district` VALUES ('1', '1', '东城区', '0');
INSERT INTO `sys_district` VALUES ('2', '1', '西城区', '0');
INSERT INTO `sys_district` VALUES ('5', '1', '朝阳区', '0');
INSERT INTO `sys_district` VALUES ('6', '1', '丰台区', '0');
INSERT INTO `sys_district` VALUES ('7', '1', '石景山区', '0');
INSERT INTO `sys_district` VALUES ('8', '1', '海淀区', '0');
INSERT INTO `sys_district` VALUES ('9', '1', '门头沟区', '0');
INSERT INTO `sys_district` VALUES ('10', '1', '房山区', '0');
INSERT INTO `sys_district` VALUES ('11', '1', '通州区', '0');
INSERT INTO `sys_district` VALUES ('12', '1', '顺义区', '0');
INSERT INTO `sys_district` VALUES ('13', '1', '昌平区', '0');
INSERT INTO `sys_district` VALUES ('14', '1', '大兴区', '0');
INSERT INTO `sys_district` VALUES ('15', '1', '怀柔区', '0');
INSERT INTO `sys_district` VALUES ('16', '1', '平谷区', '0');
INSERT INTO `sys_district` VALUES ('17', '1', '密云县', '0');
INSERT INTO `sys_district` VALUES ('18', '1', '延庆县', '0');
INSERT INTO `sys_district` VALUES ('19', '2', '和平区', '0');
INSERT INTO `sys_district` VALUES ('20', '2', '河东区', '0');
INSERT INTO `sys_district` VALUES ('21', '2', '河西区', '0');
INSERT INTO `sys_district` VALUES ('22', '2', '南开区', '0');
INSERT INTO `sys_district` VALUES ('23', '2', '河北区', '0');
INSERT INTO `sys_district` VALUES ('24', '2', '红桥区', '0');
INSERT INTO `sys_district` VALUES ('28', '2', '东丽区', '0');
INSERT INTO `sys_district` VALUES ('29', '2', '西青区', '0');
INSERT INTO `sys_district` VALUES ('30', '2', '津南区', '0');
INSERT INTO `sys_district` VALUES ('31', '2', '北辰区', '0');
INSERT INTO `sys_district` VALUES ('32', '2', '武清区', '0');
INSERT INTO `sys_district` VALUES ('33', '2', '宝坻区', '0');
INSERT INTO `sys_district` VALUES ('34', '2', '宁河县', '0');
INSERT INTO `sys_district` VALUES ('35', '2', '静海县', '0');
INSERT INTO `sys_district` VALUES ('36', '2', '蓟县', '0');
INSERT INTO `sys_district` VALUES ('37', '3', '长安区', '0');
INSERT INTO `sys_district` VALUES ('38', '3', '桥东区', '0');
INSERT INTO `sys_district` VALUES ('39', '3', '桥西区', '0');
INSERT INTO `sys_district` VALUES ('40', '3', '新华区', '0');
INSERT INTO `sys_district` VALUES ('41', '3', '井陉矿区', '0');
INSERT INTO `sys_district` VALUES ('42', '3', '裕华区', '0');
INSERT INTO `sys_district` VALUES ('43', '3', '井陉县', '0');
INSERT INTO `sys_district` VALUES ('44', '3', '正定县', '0');
INSERT INTO `sys_district` VALUES ('45', '3', '栾城县', '0');
INSERT INTO `sys_district` VALUES ('46', '3', '行唐县', '0');
INSERT INTO `sys_district` VALUES ('47', '3', '灵寿县', '0');
INSERT INTO `sys_district` VALUES ('48', '3', '高邑县', '0');
INSERT INTO `sys_district` VALUES ('49', '3', '深泽县', '0');
INSERT INTO `sys_district` VALUES ('50', '3', '赞皇县', '0');
INSERT INTO `sys_district` VALUES ('51', '3', '无极县', '0');
INSERT INTO `sys_district` VALUES ('52', '3', '平山县', '0');
INSERT INTO `sys_district` VALUES ('53', '3', '元氏县', '0');
INSERT INTO `sys_district` VALUES ('54', '3', '赵县', '0');
INSERT INTO `sys_district` VALUES ('55', '3', '辛集市', '0');
INSERT INTO `sys_district` VALUES ('56', '3', '藁城市', '0');
INSERT INTO `sys_district` VALUES ('57', '3', '晋州市', '0');
INSERT INTO `sys_district` VALUES ('58', '3', '新乐市', '0');
INSERT INTO `sys_district` VALUES ('59', '3', '鹿泉市', '0');
INSERT INTO `sys_district` VALUES ('60', '4', '路南区', '0');
INSERT INTO `sys_district` VALUES ('61', '4', '路北区', '0');
INSERT INTO `sys_district` VALUES ('62', '4', '古冶区', '0');
INSERT INTO `sys_district` VALUES ('63', '4', '开平区', '0');
INSERT INTO `sys_district` VALUES ('64', '4', '丰南区', '0');
INSERT INTO `sys_district` VALUES ('65', '4', '丰润区', '0');
INSERT INTO `sys_district` VALUES ('66', '4', '滦县', '0');
INSERT INTO `sys_district` VALUES ('67', '4', '滦南县', '0');
INSERT INTO `sys_district` VALUES ('68', '4', '乐亭县', '0');
INSERT INTO `sys_district` VALUES ('69', '4', '迁西县', '0');
INSERT INTO `sys_district` VALUES ('70', '4', '玉田县', '0');
INSERT INTO `sys_district` VALUES ('72', '4', '遵化市', '0');
INSERT INTO `sys_district` VALUES ('73', '4', '迁安市', '0');
INSERT INTO `sys_district` VALUES ('74', '5', '海港区', '0');
INSERT INTO `sys_district` VALUES ('75', '5', '山海关区', '0');
INSERT INTO `sys_district` VALUES ('76', '5', '北戴河区', '0');
INSERT INTO `sys_district` VALUES ('77', '5', '青龙满族自治县', '0');
INSERT INTO `sys_district` VALUES ('78', '5', '昌黎县', '0');
INSERT INTO `sys_district` VALUES ('79', '5', '抚宁县', '0');
INSERT INTO `sys_district` VALUES ('80', '5', '卢龙县', '0');
INSERT INTO `sys_district` VALUES ('81', '6', '邯山区', '0');
INSERT INTO `sys_district` VALUES ('82', '6', '丛台区', '0');
INSERT INTO `sys_district` VALUES ('83', '6', '复兴区', '0');
INSERT INTO `sys_district` VALUES ('84', '6', '峰峰矿区', '0');
INSERT INTO `sys_district` VALUES ('85', '6', '邯郸县', '0');
INSERT INTO `sys_district` VALUES ('86', '6', '临漳县', '0');
INSERT INTO `sys_district` VALUES ('87', '6', '成安县', '0');
INSERT INTO `sys_district` VALUES ('88', '6', '大名县', '0');
INSERT INTO `sys_district` VALUES ('89', '6', '涉县', '0');
INSERT INTO `sys_district` VALUES ('90', '6', '磁县', '0');
INSERT INTO `sys_district` VALUES ('91', '6', '肥乡县', '0');
INSERT INTO `sys_district` VALUES ('92', '6', '永年县', '0');
INSERT INTO `sys_district` VALUES ('93', '6', '邱县', '0');
INSERT INTO `sys_district` VALUES ('94', '6', '鸡泽县', '0');
INSERT INTO `sys_district` VALUES ('95', '6', '广平县', '0');
INSERT INTO `sys_district` VALUES ('96', '6', '馆陶县', '0');
INSERT INTO `sys_district` VALUES ('97', '6', '魏县', '0');
INSERT INTO `sys_district` VALUES ('98', '6', '曲周县', '0');
INSERT INTO `sys_district` VALUES ('99', '6', '武安市', '0');
INSERT INTO `sys_district` VALUES ('100', '7', '桥东区', '0');
INSERT INTO `sys_district` VALUES ('101', '7', '桥西区', '0');
INSERT INTO `sys_district` VALUES ('102', '7', '邢台县', '0');
INSERT INTO `sys_district` VALUES ('103', '7', '临城县', '0');
INSERT INTO `sys_district` VALUES ('104', '7', '内丘县', '0');
INSERT INTO `sys_district` VALUES ('105', '7', '柏乡县', '0');
INSERT INTO `sys_district` VALUES ('106', '7', '隆尧县', '0');
INSERT INTO `sys_district` VALUES ('107', '7', '任县', '0');
INSERT INTO `sys_district` VALUES ('108', '7', '南和县', '0');
INSERT INTO `sys_district` VALUES ('109', '7', '宁晋县', '0');
INSERT INTO `sys_district` VALUES ('110', '7', '巨鹿县', '0');
INSERT INTO `sys_district` VALUES ('111', '7', '新河县', '0');
INSERT INTO `sys_district` VALUES ('112', '7', '广宗县', '0');
INSERT INTO `sys_district` VALUES ('113', '7', '平乡县', '0');
INSERT INTO `sys_district` VALUES ('114', '7', '威县', '0');
INSERT INTO `sys_district` VALUES ('115', '7', '清河县', '0');
INSERT INTO `sys_district` VALUES ('116', '7', '临西县', '0');
INSERT INTO `sys_district` VALUES ('117', '7', '南宫市', '0');
INSERT INTO `sys_district` VALUES ('118', '7', '沙河市', '0');
INSERT INTO `sys_district` VALUES ('119', '8', '新市区', '0');
INSERT INTO `sys_district` VALUES ('120', '8', '北市区', '0');
INSERT INTO `sys_district` VALUES ('121', '8', '南市区', '0');
INSERT INTO `sys_district` VALUES ('122', '8', '满城县', '0');
INSERT INTO `sys_district` VALUES ('123', '8', '清苑县', '0');
INSERT INTO `sys_district` VALUES ('124', '8', '涞水县', '0');
INSERT INTO `sys_district` VALUES ('125', '8', '阜平县', '0');
INSERT INTO `sys_district` VALUES ('126', '8', '徐水县', '0');
INSERT INTO `sys_district` VALUES ('127', '8', '定兴县', '0');
INSERT INTO `sys_district` VALUES ('128', '8', '唐县', '0');
INSERT INTO `sys_district` VALUES ('129', '8', '高阳县', '0');
INSERT INTO `sys_district` VALUES ('130', '8', '容城县', '0');
INSERT INTO `sys_district` VALUES ('131', '8', '涞源县', '0');
INSERT INTO `sys_district` VALUES ('132', '8', '望都县', '0');
INSERT INTO `sys_district` VALUES ('133', '8', '安新县', '0');
INSERT INTO `sys_district` VALUES ('134', '8', '易县', '0');
INSERT INTO `sys_district` VALUES ('135', '8', '曲阳县', '0');
INSERT INTO `sys_district` VALUES ('136', '8', '蠡县', '0');
INSERT INTO `sys_district` VALUES ('137', '8', '顺平县', '0');
INSERT INTO `sys_district` VALUES ('138', '8', '博野县', '0');
INSERT INTO `sys_district` VALUES ('139', '8', '雄县', '0');
INSERT INTO `sys_district` VALUES ('140', '8', '涿州市', '0');
INSERT INTO `sys_district` VALUES ('141', '8', '定州市', '0');
INSERT INTO `sys_district` VALUES ('142', '8', '安国市', '0');
INSERT INTO `sys_district` VALUES ('143', '8', '高碑店市', '0');
INSERT INTO `sys_district` VALUES ('144', '9', '桥东区', '0');
INSERT INTO `sys_district` VALUES ('145', '9', '桥西区', '0');
INSERT INTO `sys_district` VALUES ('146', '9', '宣化区', '0');
INSERT INTO `sys_district` VALUES ('147', '9', '下花园区', '0');
INSERT INTO `sys_district` VALUES ('148', '9', '宣化县', '0');
INSERT INTO `sys_district` VALUES ('149', '9', '张北县', '0');
INSERT INTO `sys_district` VALUES ('150', '9', '康保县', '0');
INSERT INTO `sys_district` VALUES ('151', '9', '沽源县', '0');
INSERT INTO `sys_district` VALUES ('152', '9', '尚义县', '0');
INSERT INTO `sys_district` VALUES ('153', '9', '蔚县', '0');
INSERT INTO `sys_district` VALUES ('154', '9', '阳原县', '0');
INSERT INTO `sys_district` VALUES ('155', '9', '怀安县', '0');
INSERT INTO `sys_district` VALUES ('156', '9', '万全县', '0');
INSERT INTO `sys_district` VALUES ('157', '9', '怀来县', '0');
INSERT INTO `sys_district` VALUES ('158', '9', '涿鹿县', '0');
INSERT INTO `sys_district` VALUES ('159', '9', '赤城县', '0');
INSERT INTO `sys_district` VALUES ('160', '9', '崇礼县', '0');
INSERT INTO `sys_district` VALUES ('161', '10', '双桥区', '0');
INSERT INTO `sys_district` VALUES ('162', '10', '双滦区', '0');
INSERT INTO `sys_district` VALUES ('163', '10', '鹰手营子矿区', '0');
INSERT INTO `sys_district` VALUES ('164', '10', '承德县', '0');
INSERT INTO `sys_district` VALUES ('165', '10', '兴隆县', '0');
INSERT INTO `sys_district` VALUES ('166', '10', '平泉县', '0');
INSERT INTO `sys_district` VALUES ('167', '10', '滦平县', '0');
INSERT INTO `sys_district` VALUES ('168', '10', '隆化县', '0');
INSERT INTO `sys_district` VALUES ('169', '10', '丰宁满族自治县', '0');
INSERT INTO `sys_district` VALUES ('170', '10', '宽城满族自治县', '0');
INSERT INTO `sys_district` VALUES ('171', '10', '围场满族蒙古族自治县', '0');
INSERT INTO `sys_district` VALUES ('172', '11', '新华区', '0');
INSERT INTO `sys_district` VALUES ('173', '11', '运河区', '0');
INSERT INTO `sys_district` VALUES ('174', '11', '沧县', '0');
INSERT INTO `sys_district` VALUES ('175', '11', '青县', '0');
INSERT INTO `sys_district` VALUES ('176', '11', '东光县', '0');
INSERT INTO `sys_district` VALUES ('177', '11', '海兴县', '0');
INSERT INTO `sys_district` VALUES ('178', '11', '盐山县', '0');
INSERT INTO `sys_district` VALUES ('179', '11', '肃宁县', '0');
INSERT INTO `sys_district` VALUES ('180', '11', '南皮县', '0');
INSERT INTO `sys_district` VALUES ('181', '11', '吴桥县', '0');
INSERT INTO `sys_district` VALUES ('182', '11', '献县', '0');
INSERT INTO `sys_district` VALUES ('183', '11', '孟村回族自治县', '0');
INSERT INTO `sys_district` VALUES ('184', '11', '泊头市', '0');
INSERT INTO `sys_district` VALUES ('185', '11', '任丘市', '0');
INSERT INTO `sys_district` VALUES ('186', '11', '黄骅市', '0');
INSERT INTO `sys_district` VALUES ('187', '11', '河间市', '0');
INSERT INTO `sys_district` VALUES ('188', '12', '安次区', '0');
INSERT INTO `sys_district` VALUES ('189', '12', '广阳区', '0');
INSERT INTO `sys_district` VALUES ('190', '12', '固安县', '0');
INSERT INTO `sys_district` VALUES ('191', '12', '永清县', '0');
INSERT INTO `sys_district` VALUES ('192', '12', '香河县', '0');
INSERT INTO `sys_district` VALUES ('193', '12', '大城县', '0');
INSERT INTO `sys_district` VALUES ('194', '12', '文安县', '0');
INSERT INTO `sys_district` VALUES ('195', '12', '大厂回族自治县', '0');
INSERT INTO `sys_district` VALUES ('196', '12', '霸州市', '0');
INSERT INTO `sys_district` VALUES ('197', '12', '三河市', '0');
INSERT INTO `sys_district` VALUES ('198', '13', '桃城区', '0');
INSERT INTO `sys_district` VALUES ('199', '13', '枣强县', '0');
INSERT INTO `sys_district` VALUES ('200', '13', '武邑县', '0');
INSERT INTO `sys_district` VALUES ('201', '13', '武强县', '0');
INSERT INTO `sys_district` VALUES ('202', '13', '饶阳县', '0');
INSERT INTO `sys_district` VALUES ('203', '13', '安平县', '0');
INSERT INTO `sys_district` VALUES ('204', '13', '故城县', '0');
INSERT INTO `sys_district` VALUES ('205', '13', '景县', '0');
INSERT INTO `sys_district` VALUES ('206', '13', '阜城县', '0');
INSERT INTO `sys_district` VALUES ('207', '13', '冀州市', '0');
INSERT INTO `sys_district` VALUES ('208', '13', '深州市', '0');
INSERT INTO `sys_district` VALUES ('209', '14', '小店区', '0');
INSERT INTO `sys_district` VALUES ('210', '14', '迎泽区', '0');
INSERT INTO `sys_district` VALUES ('211', '14', '杏花岭区', '0');
INSERT INTO `sys_district` VALUES ('212', '14', '尖草坪区', '0');
INSERT INTO `sys_district` VALUES ('213', '14', '万柏林区', '0');
INSERT INTO `sys_district` VALUES ('214', '14', '晋源区', '0');
INSERT INTO `sys_district` VALUES ('215', '14', '清徐县', '0');
INSERT INTO `sys_district` VALUES ('216', '14', '阳曲县', '0');
INSERT INTO `sys_district` VALUES ('217', '14', '娄烦县', '0');
INSERT INTO `sys_district` VALUES ('218', '14', '古交市', '0');
INSERT INTO `sys_district` VALUES ('219', '15', '城区', '0');
INSERT INTO `sys_district` VALUES ('220', '15', '矿区', '0');
INSERT INTO `sys_district` VALUES ('221', '15', '南郊区', '0');
INSERT INTO `sys_district` VALUES ('222', '15', '新荣区', '0');
INSERT INTO `sys_district` VALUES ('223', '15', '阳高县', '0');
INSERT INTO `sys_district` VALUES ('224', '15', '天镇县', '0');
INSERT INTO `sys_district` VALUES ('225', '15', '广灵县', '0');
INSERT INTO `sys_district` VALUES ('226', '15', '灵丘县', '0');
INSERT INTO `sys_district` VALUES ('227', '15', '浑源县', '0');
INSERT INTO `sys_district` VALUES ('228', '15', '左云县', '0');
INSERT INTO `sys_district` VALUES ('229', '15', '大同县', '0');
INSERT INTO `sys_district` VALUES ('230', '16', '城区', '0');
INSERT INTO `sys_district` VALUES ('231', '16', '矿区', '0');
INSERT INTO `sys_district` VALUES ('232', '16', '郊区', '0');
INSERT INTO `sys_district` VALUES ('233', '16', '平定县', '0');
INSERT INTO `sys_district` VALUES ('234', '16', '盂县', '0');
INSERT INTO `sys_district` VALUES ('235', '17', '城区', '0');
INSERT INTO `sys_district` VALUES ('236', '17', '郊区', '0');
INSERT INTO `sys_district` VALUES ('237', '17', '长治县', '0');
INSERT INTO `sys_district` VALUES ('238', '17', '襄垣县', '0');
INSERT INTO `sys_district` VALUES ('239', '17', '屯留县', '0');
INSERT INTO `sys_district` VALUES ('240', '17', '平顺县', '0');
INSERT INTO `sys_district` VALUES ('241', '17', '黎城县', '0');
INSERT INTO `sys_district` VALUES ('242', '17', '壶关县', '0');
INSERT INTO `sys_district` VALUES ('243', '17', '长子县', '0');
INSERT INTO `sys_district` VALUES ('244', '17', '武乡县', '0');
INSERT INTO `sys_district` VALUES ('245', '17', '沁县', '0');
INSERT INTO `sys_district` VALUES ('246', '17', '沁源县', '0');
INSERT INTO `sys_district` VALUES ('247', '17', '潞城市', '0');
INSERT INTO `sys_district` VALUES ('248', '18', '城区', '0');
INSERT INTO `sys_district` VALUES ('249', '18', '沁水县', '0');
INSERT INTO `sys_district` VALUES ('250', '18', '阳城县', '0');
INSERT INTO `sys_district` VALUES ('251', '18', '陵川县', '0');
INSERT INTO `sys_district` VALUES ('252', '18', '泽州县', '0');
INSERT INTO `sys_district` VALUES ('253', '18', '高平市', '0');
INSERT INTO `sys_district` VALUES ('254', '19', '朔城区', '0');
INSERT INTO `sys_district` VALUES ('255', '19', '平鲁区', '0');
INSERT INTO `sys_district` VALUES ('256', '19', '山阴县', '0');
INSERT INTO `sys_district` VALUES ('257', '19', '应县', '0');
INSERT INTO `sys_district` VALUES ('258', '19', '右玉县', '0');
INSERT INTO `sys_district` VALUES ('259', '19', '怀仁县', '0');
INSERT INTO `sys_district` VALUES ('260', '20', '榆次区', '0');
INSERT INTO `sys_district` VALUES ('261', '20', '榆社县', '0');
INSERT INTO `sys_district` VALUES ('262', '20', '左权县', '0');
INSERT INTO `sys_district` VALUES ('263', '20', '和顺县', '0');
INSERT INTO `sys_district` VALUES ('264', '20', '昔阳县', '0');
INSERT INTO `sys_district` VALUES ('265', '20', '寿阳县', '0');
INSERT INTO `sys_district` VALUES ('266', '20', '太谷县', '0');
INSERT INTO `sys_district` VALUES ('267', '20', '祁县', '0');
INSERT INTO `sys_district` VALUES ('268', '20', '平遥县', '0');
INSERT INTO `sys_district` VALUES ('269', '20', '灵石县', '0');
INSERT INTO `sys_district` VALUES ('270', '20', '介休市', '0');
INSERT INTO `sys_district` VALUES ('271', '21', '盐湖区', '0');
INSERT INTO `sys_district` VALUES ('272', '21', '临猗县', '0');
INSERT INTO `sys_district` VALUES ('273', '21', '万荣县', '0');
INSERT INTO `sys_district` VALUES ('274', '21', '闻喜县', '0');
INSERT INTO `sys_district` VALUES ('275', '21', '稷山县', '0');
INSERT INTO `sys_district` VALUES ('276', '21', '新绛县', '0');
INSERT INTO `sys_district` VALUES ('277', '21', '绛县', '0');
INSERT INTO `sys_district` VALUES ('278', '21', '垣曲县', '0');
INSERT INTO `sys_district` VALUES ('279', '21', '夏县', '0');
INSERT INTO `sys_district` VALUES ('280', '21', '平陆县', '0');
INSERT INTO `sys_district` VALUES ('281', '21', '芮城县', '0');
INSERT INTO `sys_district` VALUES ('282', '21', '永济市', '0');
INSERT INTO `sys_district` VALUES ('283', '21', '河津市', '0');
INSERT INTO `sys_district` VALUES ('284', '22', '忻府区', '0');
INSERT INTO `sys_district` VALUES ('285', '22', '定襄县', '0');
INSERT INTO `sys_district` VALUES ('286', '22', '五台县', '0');
INSERT INTO `sys_district` VALUES ('287', '22', '代县', '0');
INSERT INTO `sys_district` VALUES ('288', '22', '繁峙县', '0');
INSERT INTO `sys_district` VALUES ('289', '22', '宁武县', '0');
INSERT INTO `sys_district` VALUES ('290', '22', '静乐县', '0');
INSERT INTO `sys_district` VALUES ('291', '22', '神池县', '0');
INSERT INTO `sys_district` VALUES ('292', '22', '五寨县', '0');
INSERT INTO `sys_district` VALUES ('293', '22', '岢岚县', '0');
INSERT INTO `sys_district` VALUES ('294', '22', '河曲县', '0');
INSERT INTO `sys_district` VALUES ('295', '22', '保德县', '0');
INSERT INTO `sys_district` VALUES ('296', '22', '偏关县', '0');
INSERT INTO `sys_district` VALUES ('297', '22', '原平市', '0');
INSERT INTO `sys_district` VALUES ('298', '23', '尧都区', '0');
INSERT INTO `sys_district` VALUES ('299', '23', '曲沃县', '0');
INSERT INTO `sys_district` VALUES ('300', '23', '翼城县', '0');
INSERT INTO `sys_district` VALUES ('301', '23', '襄汾县', '0');
INSERT INTO `sys_district` VALUES ('302', '23', '洪洞县', '0');
INSERT INTO `sys_district` VALUES ('303', '23', '古县', '0');
INSERT INTO `sys_district` VALUES ('304', '23', '安泽县', '0');
INSERT INTO `sys_district` VALUES ('305', '23', '浮山县', '0');
INSERT INTO `sys_district` VALUES ('306', '23', '吉县', '0');
INSERT INTO `sys_district` VALUES ('307', '23', '乡宁县', '0');
INSERT INTO `sys_district` VALUES ('308', '23', '大宁县', '0');
INSERT INTO `sys_district` VALUES ('309', '23', '隰县', '0');
INSERT INTO `sys_district` VALUES ('310', '23', '永和县', '0');
INSERT INTO `sys_district` VALUES ('311', '23', '蒲县', '0');
INSERT INTO `sys_district` VALUES ('312', '23', '汾西县', '0');
INSERT INTO `sys_district` VALUES ('313', '23', '侯马市', '0');
INSERT INTO `sys_district` VALUES ('314', '23', '霍州市', '0');
INSERT INTO `sys_district` VALUES ('315', '24', '离石区', '0');
INSERT INTO `sys_district` VALUES ('316', '24', '文水县', '0');
INSERT INTO `sys_district` VALUES ('317', '24', '交城县', '0');
INSERT INTO `sys_district` VALUES ('318', '24', '兴县', '0');
INSERT INTO `sys_district` VALUES ('319', '24', '临县', '0');
INSERT INTO `sys_district` VALUES ('320', '24', '柳林县', '0');
INSERT INTO `sys_district` VALUES ('321', '24', '石楼县', '0');
INSERT INTO `sys_district` VALUES ('322', '24', '岚县', '0');
INSERT INTO `sys_district` VALUES ('323', '24', '方山县', '0');
INSERT INTO `sys_district` VALUES ('324', '24', '中阳县', '0');
INSERT INTO `sys_district` VALUES ('325', '24', '交口县', '0');
INSERT INTO `sys_district` VALUES ('326', '24', '孝义市', '0');
INSERT INTO `sys_district` VALUES ('327', '24', '汾阳市', '0');
INSERT INTO `sys_district` VALUES ('328', '25', '新城区', '0');
INSERT INTO `sys_district` VALUES ('329', '25', '回民区', '0');
INSERT INTO `sys_district` VALUES ('330', '25', '玉泉区', '0');
INSERT INTO `sys_district` VALUES ('331', '25', '赛罕区', '0');
INSERT INTO `sys_district` VALUES ('332', '25', '土默特左旗', '0');
INSERT INTO `sys_district` VALUES ('333', '25', '托克托县', '0');
INSERT INTO `sys_district` VALUES ('334', '25', '和林格尔县', '0');
INSERT INTO `sys_district` VALUES ('335', '25', '清水河县', '0');
INSERT INTO `sys_district` VALUES ('336', '25', '武川县', '0');
INSERT INTO `sys_district` VALUES ('337', '26', '东河区', '0');
INSERT INTO `sys_district` VALUES ('338', '26', '昆都仑区', '0');
INSERT INTO `sys_district` VALUES ('339', '26', '青山区', '0');
INSERT INTO `sys_district` VALUES ('340', '26', '石拐区', '0');
INSERT INTO `sys_district` VALUES ('342', '26', '九原区', '0');
INSERT INTO `sys_district` VALUES ('343', '26', '土默特右旗', '0');
INSERT INTO `sys_district` VALUES ('344', '26', '固阳县', '0');
INSERT INTO `sys_district` VALUES ('345', '26', '达尔罕茂明安联合旗', '0');
INSERT INTO `sys_district` VALUES ('346', '27', '海勃湾区', '0');
INSERT INTO `sys_district` VALUES ('347', '27', '海南区', '0');
INSERT INTO `sys_district` VALUES ('348', '27', '乌达区', '0');
INSERT INTO `sys_district` VALUES ('349', '28', '红山区', '0');
INSERT INTO `sys_district` VALUES ('350', '28', '元宝山区', '0');
INSERT INTO `sys_district` VALUES ('351', '28', '松山区', '0');
INSERT INTO `sys_district` VALUES ('352', '28', '阿鲁科尔沁旗', '0');
INSERT INTO `sys_district` VALUES ('353', '28', '巴林左旗', '0');
INSERT INTO `sys_district` VALUES ('354', '28', '巴林右旗', '0');
INSERT INTO `sys_district` VALUES ('355', '28', '林西县', '0');
INSERT INTO `sys_district` VALUES ('356', '28', '克什克腾旗', '0');
INSERT INTO `sys_district` VALUES ('357', '28', '翁牛特旗', '0');
INSERT INTO `sys_district` VALUES ('358', '28', '喀喇沁旗', '0');
INSERT INTO `sys_district` VALUES ('359', '28', '宁城县', '0');
INSERT INTO `sys_district` VALUES ('360', '28', '敖汉旗', '0');
INSERT INTO `sys_district` VALUES ('361', '29', '科尔沁区', '0');
INSERT INTO `sys_district` VALUES ('362', '29', '科尔沁左翼中旗', '0');
INSERT INTO `sys_district` VALUES ('363', '29', '科尔沁左翼后旗', '0');
INSERT INTO `sys_district` VALUES ('364', '29', '开鲁县', '0');
INSERT INTO `sys_district` VALUES ('365', '29', '库伦旗', '0');
INSERT INTO `sys_district` VALUES ('366', '29', '奈曼旗', '0');
INSERT INTO `sys_district` VALUES ('367', '29', '扎鲁特旗', '0');
INSERT INTO `sys_district` VALUES ('368', '29', '霍林郭勒市', '0');
INSERT INTO `sys_district` VALUES ('369', '30', '东胜区', '0');
INSERT INTO `sys_district` VALUES ('370', '30', '达拉特旗', '0');
INSERT INTO `sys_district` VALUES ('371', '30', '准格尔旗', '0');
INSERT INTO `sys_district` VALUES ('372', '30', '鄂托克前旗', '0');
INSERT INTO `sys_district` VALUES ('373', '30', '鄂托克旗', '0');
INSERT INTO `sys_district` VALUES ('374', '30', '杭锦旗', '0');
INSERT INTO `sys_district` VALUES ('375', '30', '乌审旗', '0');
INSERT INTO `sys_district` VALUES ('376', '30', '伊金霍洛旗', '0');
INSERT INTO `sys_district` VALUES ('377', '31', '海拉尔区', '0');
INSERT INTO `sys_district` VALUES ('378', '31', '阿荣旗', '0');
INSERT INTO `sys_district` VALUES ('379', '31', '莫力达瓦达斡尔族自治旗', '0');
INSERT INTO `sys_district` VALUES ('380', '31', '鄂伦春自治旗', '0');
INSERT INTO `sys_district` VALUES ('381', '31', '鄂温克族自治旗', '0');
INSERT INTO `sys_district` VALUES ('382', '31', '陈巴尔虎旗', '0');
INSERT INTO `sys_district` VALUES ('383', '31', '新巴尔虎左旗', '0');
INSERT INTO `sys_district` VALUES ('384', '31', '新巴尔虎右旗', '0');
INSERT INTO `sys_district` VALUES ('385', '31', '满洲里市', '0');
INSERT INTO `sys_district` VALUES ('386', '31', '牙克石市', '0');
INSERT INTO `sys_district` VALUES ('387', '31', '扎兰屯市', '0');
INSERT INTO `sys_district` VALUES ('388', '31', '额尔古纳市', '0');
INSERT INTO `sys_district` VALUES ('389', '31', '根河市', '0');
INSERT INTO `sys_district` VALUES ('390', '32', '临河区', '0');
INSERT INTO `sys_district` VALUES ('391', '32', '五原县', '0');
INSERT INTO `sys_district` VALUES ('392', '32', '磴口县', '0');
INSERT INTO `sys_district` VALUES ('393', '32', '乌拉特前旗', '0');
INSERT INTO `sys_district` VALUES ('394', '32', '乌拉特中旗', '0');
INSERT INTO `sys_district` VALUES ('395', '32', '乌拉特后旗', '0');
INSERT INTO `sys_district` VALUES ('396', '32', '杭锦后旗', '0');
INSERT INTO `sys_district` VALUES ('397', '33', '集宁区', '0');
INSERT INTO `sys_district` VALUES ('398', '33', '卓资县', '0');
INSERT INTO `sys_district` VALUES ('399', '33', '化德县', '0');
INSERT INTO `sys_district` VALUES ('400', '33', '商都县', '0');
INSERT INTO `sys_district` VALUES ('401', '33', '兴和县', '0');
INSERT INTO `sys_district` VALUES ('402', '33', '凉城县', '0');
INSERT INTO `sys_district` VALUES ('403', '33', '察哈尔右翼前旗', '0');
INSERT INTO `sys_district` VALUES ('404', '33', '察哈尔右翼中旗', '0');
INSERT INTO `sys_district` VALUES ('405', '33', '察哈尔右翼后旗', '0');
INSERT INTO `sys_district` VALUES ('406', '33', '四子王旗', '0');
INSERT INTO `sys_district` VALUES ('407', '33', '丰镇市', '0');
INSERT INTO `sys_district` VALUES ('408', '34', '乌兰浩特市', '0');
INSERT INTO `sys_district` VALUES ('409', '34', '阿尔山市', '0');
INSERT INTO `sys_district` VALUES ('410', '34', '科尔沁右翼前旗', '0');
INSERT INTO `sys_district` VALUES ('411', '34', '科尔沁右翼中旗', '0');
INSERT INTO `sys_district` VALUES ('412', '34', '扎赉特旗', '0');
INSERT INTO `sys_district` VALUES ('413', '34', '突泉县', '0');
INSERT INTO `sys_district` VALUES ('414', '35', '二连浩特市', '0');
INSERT INTO `sys_district` VALUES ('415', '35', '锡林浩特市', '0');
INSERT INTO `sys_district` VALUES ('416', '35', '阿巴嘎旗', '0');
INSERT INTO `sys_district` VALUES ('417', '35', '苏尼特左旗', '0');
INSERT INTO `sys_district` VALUES ('418', '35', '苏尼特右旗', '0');
INSERT INTO `sys_district` VALUES ('419', '35', '东乌珠穆沁旗', '0');
INSERT INTO `sys_district` VALUES ('420', '35', '西乌珠穆沁旗', '0');
INSERT INTO `sys_district` VALUES ('421', '35', '太仆寺旗', '0');
INSERT INTO `sys_district` VALUES ('422', '35', '镶黄旗', '0');
INSERT INTO `sys_district` VALUES ('423', '35', '正镶白旗', '0');
INSERT INTO `sys_district` VALUES ('424', '35', '正蓝旗', '0');
INSERT INTO `sys_district` VALUES ('425', '35', '多伦县', '0');
INSERT INTO `sys_district` VALUES ('426', '36', '阿拉善左旗', '0');
INSERT INTO `sys_district` VALUES ('427', '36', '阿拉善右旗', '0');
INSERT INTO `sys_district` VALUES ('428', '36', '额济纳旗', '0');
INSERT INTO `sys_district` VALUES ('429', '37', '和平区', '0');
INSERT INTO `sys_district` VALUES ('430', '37', '沈河区', '0');
INSERT INTO `sys_district` VALUES ('431', '37', '大东区', '0');
INSERT INTO `sys_district` VALUES ('432', '37', '皇姑区', '0');
INSERT INTO `sys_district` VALUES ('433', '37', '铁西区', '0');
INSERT INTO `sys_district` VALUES ('434', '37', '苏家屯区', '0');
INSERT INTO `sys_district` VALUES ('435', '37', '东陵区', '0');
INSERT INTO `sys_district` VALUES ('437', '37', '于洪区', '0');
INSERT INTO `sys_district` VALUES ('438', '37', '辽中县', '0');
INSERT INTO `sys_district` VALUES ('439', '37', '康平县', '0');
INSERT INTO `sys_district` VALUES ('440', '37', '法库县', '0');
INSERT INTO `sys_district` VALUES ('441', '37', '新民市', '0');
INSERT INTO `sys_district` VALUES ('442', '38', '中山区', '0');
INSERT INTO `sys_district` VALUES ('443', '38', '西岗区', '0');
INSERT INTO `sys_district` VALUES ('444', '38', '沙河口区', '0');
INSERT INTO `sys_district` VALUES ('445', '38', '甘井子区', '0');
INSERT INTO `sys_district` VALUES ('446', '38', '旅顺口区', '0');
INSERT INTO `sys_district` VALUES ('447', '38', '金州区', '0');
INSERT INTO `sys_district` VALUES ('448', '38', '长海县', '0');
INSERT INTO `sys_district` VALUES ('449', '38', '瓦房店市', '0');
INSERT INTO `sys_district` VALUES ('450', '38', '普兰店市', '0');
INSERT INTO `sys_district` VALUES ('451', '38', '庄河市', '0');
INSERT INTO `sys_district` VALUES ('452', '39', '铁东区', '0');
INSERT INTO `sys_district` VALUES ('453', '39', '铁西区', '0');
INSERT INTO `sys_district` VALUES ('454', '39', '立山区', '0');
INSERT INTO `sys_district` VALUES ('455', '39', '千山区', '0');
INSERT INTO `sys_district` VALUES ('456', '39', '台安县', '0');
INSERT INTO `sys_district` VALUES ('457', '39', '岫岩满族自治县', '0');
INSERT INTO `sys_district` VALUES ('458', '39', '海城市', '0');
INSERT INTO `sys_district` VALUES ('459', '40', '新抚区', '0');
INSERT INTO `sys_district` VALUES ('460', '40', '东洲区', '0');
INSERT INTO `sys_district` VALUES ('461', '40', '望花区', '0');
INSERT INTO `sys_district` VALUES ('462', '40', '顺城区', '0');
INSERT INTO `sys_district` VALUES ('463', '40', '抚顺县', '0');
INSERT INTO `sys_district` VALUES ('464', '40', '新宾满族自治县', '0');
INSERT INTO `sys_district` VALUES ('465', '40', '清原满族自治县', '0');
INSERT INTO `sys_district` VALUES ('466', '41', '平山区', '0');
INSERT INTO `sys_district` VALUES ('467', '41', '溪湖区', '0');
INSERT INTO `sys_district` VALUES ('468', '41', '明山区', '0');
INSERT INTO `sys_district` VALUES ('469', '41', '南芬区', '0');
INSERT INTO `sys_district` VALUES ('470', '41', '本溪满族自治县', '0');
INSERT INTO `sys_district` VALUES ('471', '41', '桓仁满族自治县', '0');
INSERT INTO `sys_district` VALUES ('472', '42', '元宝区', '0');
INSERT INTO `sys_district` VALUES ('473', '42', '振兴区', '0');
INSERT INTO `sys_district` VALUES ('474', '42', '振安区', '0');
INSERT INTO `sys_district` VALUES ('475', '42', '宽甸满族自治县', '0');
INSERT INTO `sys_district` VALUES ('476', '42', '东港市', '0');
INSERT INTO `sys_district` VALUES ('477', '42', '凤城市', '0');
INSERT INTO `sys_district` VALUES ('478', '43', '古塔区', '0');
INSERT INTO `sys_district` VALUES ('479', '43', '凌河区', '0');
INSERT INTO `sys_district` VALUES ('480', '43', '太和区', '0');
INSERT INTO `sys_district` VALUES ('481', '43', '黑山县', '0');
INSERT INTO `sys_district` VALUES ('482', '43', '义县', '0');
INSERT INTO `sys_district` VALUES ('483', '43', '凌海市', '0');
INSERT INTO `sys_district` VALUES ('485', '44', '站前区', '0');
INSERT INTO `sys_district` VALUES ('486', '44', '西市区', '0');
INSERT INTO `sys_district` VALUES ('487', '44', '鲅鱼圈区', '0');
INSERT INTO `sys_district` VALUES ('488', '44', '老边区', '0');
INSERT INTO `sys_district` VALUES ('489', '44', '盖州市', '0');
INSERT INTO `sys_district` VALUES ('490', '44', '大石桥市', '0');
INSERT INTO `sys_district` VALUES ('491', '45', '海州区', '0');
INSERT INTO `sys_district` VALUES ('492', '45', '新邱区', '0');
INSERT INTO `sys_district` VALUES ('493', '45', '太平区', '0');
INSERT INTO `sys_district` VALUES ('494', '45', '清河门区', '0');
INSERT INTO `sys_district` VALUES ('495', '45', '细河区', '0');
INSERT INTO `sys_district` VALUES ('496', '45', '阜新蒙古族自治县', '0');
INSERT INTO `sys_district` VALUES ('497', '45', '彰武县', '0');
INSERT INTO `sys_district` VALUES ('498', '46', '白塔区', '0');
INSERT INTO `sys_district` VALUES ('499', '46', '文圣区', '0');
INSERT INTO `sys_district` VALUES ('500', '46', '宏伟区', '0');
INSERT INTO `sys_district` VALUES ('501', '46', '弓长岭区', '0');
INSERT INTO `sys_district` VALUES ('502', '46', '太子河区', '0');
INSERT INTO `sys_district` VALUES ('503', '46', '辽阳县', '0');
INSERT INTO `sys_district` VALUES ('504', '46', '灯塔市', '0');
INSERT INTO `sys_district` VALUES ('505', '47', '双台子区', '0');
INSERT INTO `sys_district` VALUES ('506', '47', '兴隆台区', '0');
INSERT INTO `sys_district` VALUES ('507', '47', '大洼县', '0');
INSERT INTO `sys_district` VALUES ('508', '47', '盘山县', '0');
INSERT INTO `sys_district` VALUES ('509', '48', '银州区', '0');
INSERT INTO `sys_district` VALUES ('510', '48', '清河区', '0');
INSERT INTO `sys_district` VALUES ('511', '48', '铁岭县', '0');
INSERT INTO `sys_district` VALUES ('512', '48', '西丰县', '0');
INSERT INTO `sys_district` VALUES ('513', '48', '昌图县', '0');
INSERT INTO `sys_district` VALUES ('514', '48', '调兵山市', '0');
INSERT INTO `sys_district` VALUES ('515', '48', '开原市', '0');
INSERT INTO `sys_district` VALUES ('516', '49', '双塔区', '0');
INSERT INTO `sys_district` VALUES ('517', '49', '龙城区', '0');
INSERT INTO `sys_district` VALUES ('518', '49', '朝阳县', '0');
INSERT INTO `sys_district` VALUES ('519', '49', '建平县', '0');
INSERT INTO `sys_district` VALUES ('520', '49', '喀喇沁左翼蒙古族自治县', '0');
INSERT INTO `sys_district` VALUES ('521', '49', '北票市', '0');
INSERT INTO `sys_district` VALUES ('522', '49', '凌源市', '0');
INSERT INTO `sys_district` VALUES ('523', '50', '连山区', '0');
INSERT INTO `sys_district` VALUES ('524', '50', '龙港区', '0');
INSERT INTO `sys_district` VALUES ('525', '50', '南票区', '0');
INSERT INTO `sys_district` VALUES ('526', '50', '绥中县', '0');
INSERT INTO `sys_district` VALUES ('527', '50', '建昌县', '0');
INSERT INTO `sys_district` VALUES ('528', '50', '兴城市', '0');
INSERT INTO `sys_district` VALUES ('529', '51', '南关区', '0');
INSERT INTO `sys_district` VALUES ('530', '51', '宽城区', '0');
INSERT INTO `sys_district` VALUES ('531', '51', '朝阳区', '0');
INSERT INTO `sys_district` VALUES ('532', '51', '二道区', '0');
INSERT INTO `sys_district` VALUES ('533', '51', '绿园区', '0');
INSERT INTO `sys_district` VALUES ('534', '51', '双阳区', '0');
INSERT INTO `sys_district` VALUES ('535', '51', '农安县', '0');
INSERT INTO `sys_district` VALUES ('536', '51', '九台市', '0');
INSERT INTO `sys_district` VALUES ('537', '51', '榆树市', '0');
INSERT INTO `sys_district` VALUES ('538', '51', '德惠市', '0');
INSERT INTO `sys_district` VALUES ('539', '52', '昌邑区', '0');
INSERT INTO `sys_district` VALUES ('540', '52', '龙潭区', '0');
INSERT INTO `sys_district` VALUES ('541', '52', '船营区', '0');
INSERT INTO `sys_district` VALUES ('542', '52', '丰满区', '0');
INSERT INTO `sys_district` VALUES ('543', '52', '永吉县', '0');
INSERT INTO `sys_district` VALUES ('544', '52', '蛟河市', '0');
INSERT INTO `sys_district` VALUES ('545', '52', '桦甸市', '0');
INSERT INTO `sys_district` VALUES ('546', '52', '舒兰市', '0');
INSERT INTO `sys_district` VALUES ('547', '52', '磐石市', '0');
INSERT INTO `sys_district` VALUES ('548', '53', '铁西区', '0');
INSERT INTO `sys_district` VALUES ('549', '53', '铁东区', '0');
INSERT INTO `sys_district` VALUES ('550', '53', '梨树县', '0');
INSERT INTO `sys_district` VALUES ('551', '53', '伊通满族自治县', '0');
INSERT INTO `sys_district` VALUES ('552', '53', '公主岭市', '0');
INSERT INTO `sys_district` VALUES ('553', '53', '双辽市', '0');
INSERT INTO `sys_district` VALUES ('554', '54', '龙山区', '0');
INSERT INTO `sys_district` VALUES ('555', '54', '西安区', '0');
INSERT INTO `sys_district` VALUES ('556', '54', '东丰县', '0');
INSERT INTO `sys_district` VALUES ('557', '54', '东辽县', '0');
INSERT INTO `sys_district` VALUES ('558', '55', '东昌区', '0');
INSERT INTO `sys_district` VALUES ('559', '55', '二道江区', '0');
INSERT INTO `sys_district` VALUES ('560', '55', '通化县', '0');
INSERT INTO `sys_district` VALUES ('561', '55', '辉南县', '0');
INSERT INTO `sys_district` VALUES ('562', '55', '柳河县', '0');
INSERT INTO `sys_district` VALUES ('563', '55', '梅河口市', '0');
INSERT INTO `sys_district` VALUES ('564', '55', '集安市', '0');
INSERT INTO `sys_district` VALUES ('566', '56', '抚松县', '0');
INSERT INTO `sys_district` VALUES ('567', '56', '靖宇县', '0');
INSERT INTO `sys_district` VALUES ('568', '56', '长白朝鲜族自治县', '0');
INSERT INTO `sys_district` VALUES ('570', '56', '临江市', '0');
INSERT INTO `sys_district` VALUES ('571', '57', '宁江区', '0');
INSERT INTO `sys_district` VALUES ('572', '57', '前郭尔罗斯蒙古族自治县', '0');
INSERT INTO `sys_district` VALUES ('573', '57', '长岭县', '0');
INSERT INTO `sys_district` VALUES ('574', '57', '乾安县', '0');
INSERT INTO `sys_district` VALUES ('576', '58', '洮北区', '0');
INSERT INTO `sys_district` VALUES ('577', '58', '镇赉县', '0');
INSERT INTO `sys_district` VALUES ('578', '58', '通榆县', '0');
INSERT INTO `sys_district` VALUES ('579', '58', '洮南市', '0');
INSERT INTO `sys_district` VALUES ('580', '58', '大安市', '0');
INSERT INTO `sys_district` VALUES ('581', '59', '延吉市', '0');
INSERT INTO `sys_district` VALUES ('582', '59', '图们市', '0');
INSERT INTO `sys_district` VALUES ('583', '59', '敦化市', '0');
INSERT INTO `sys_district` VALUES ('584', '59', '珲春市', '0');
INSERT INTO `sys_district` VALUES ('585', '59', '龙井市', '0');
INSERT INTO `sys_district` VALUES ('586', '59', '和龙市', '0');
INSERT INTO `sys_district` VALUES ('587', '59', '汪清县', '0');
INSERT INTO `sys_district` VALUES ('588', '59', '安图县', '0');
INSERT INTO `sys_district` VALUES ('589', '60', '道里区', '0');
INSERT INTO `sys_district` VALUES ('590', '60', '南岗区', '0');
INSERT INTO `sys_district` VALUES ('591', '60', '道外区', '0');
INSERT INTO `sys_district` VALUES ('592', '60', '香坊区', '0');
INSERT INTO `sys_district` VALUES ('594', '60', '平房区', '0');
INSERT INTO `sys_district` VALUES ('595', '60', '松北区', '0');
INSERT INTO `sys_district` VALUES ('596', '60', '呼兰区', '0');
INSERT INTO `sys_district` VALUES ('597', '60', '依兰县', '0');
INSERT INTO `sys_district` VALUES ('598', '60', '方正县', '0');
INSERT INTO `sys_district` VALUES ('599', '60', '宾县', '0');
INSERT INTO `sys_district` VALUES ('600', '60', '巴彦县', '0');
INSERT INTO `sys_district` VALUES ('601', '60', '木兰县', '0');
INSERT INTO `sys_district` VALUES ('602', '60', '通河县', '0');
INSERT INTO `sys_district` VALUES ('603', '60', '延寿县', '0');
INSERT INTO `sys_district` VALUES ('605', '60', '双城市', '0');
INSERT INTO `sys_district` VALUES ('606', '60', '尚志市', '0');
INSERT INTO `sys_district` VALUES ('607', '60', '五常市', '0');
INSERT INTO `sys_district` VALUES ('608', '61', '龙沙区', '0');
INSERT INTO `sys_district` VALUES ('609', '61', '建华区', '0');
INSERT INTO `sys_district` VALUES ('610', '61', '铁锋区', '0');
INSERT INTO `sys_district` VALUES ('611', '61', '昂昂溪区', '0');
INSERT INTO `sys_district` VALUES ('612', '61', '富拉尔基区', '0');
INSERT INTO `sys_district` VALUES ('613', '61', '碾子山区', '0');
INSERT INTO `sys_district` VALUES ('614', '61', '梅里斯达斡尔族区', '0');
INSERT INTO `sys_district` VALUES ('615', '61', '龙江县', '0');
INSERT INTO `sys_district` VALUES ('616', '61', '依安县', '0');
INSERT INTO `sys_district` VALUES ('617', '61', '泰来县', '0');
INSERT INTO `sys_district` VALUES ('618', '61', '甘南县', '0');
INSERT INTO `sys_district` VALUES ('619', '61', '富裕县', '0');
INSERT INTO `sys_district` VALUES ('620', '61', '克山县', '0');
INSERT INTO `sys_district` VALUES ('621', '61', '克东县', '0');
INSERT INTO `sys_district` VALUES ('622', '61', '拜泉县', '0');
INSERT INTO `sys_district` VALUES ('623', '61', '讷河市', '0');
INSERT INTO `sys_district` VALUES ('624', '62', '鸡冠区', '0');
INSERT INTO `sys_district` VALUES ('625', '62', '恒山区', '0');
INSERT INTO `sys_district` VALUES ('626', '62', '滴道区', '0');
INSERT INTO `sys_district` VALUES ('627', '62', '梨树区', '0');
INSERT INTO `sys_district` VALUES ('628', '62', '城子河区', '0');
INSERT INTO `sys_district` VALUES ('629', '62', '麻山区', '0');
INSERT INTO `sys_district` VALUES ('630', '62', '鸡东县', '0');
INSERT INTO `sys_district` VALUES ('631', '62', '虎林市', '0');
INSERT INTO `sys_district` VALUES ('632', '62', '密山市', '0');
INSERT INTO `sys_district` VALUES ('633', '63', '向阳区', '0');
INSERT INTO `sys_district` VALUES ('634', '63', '工农区', '0');
INSERT INTO `sys_district` VALUES ('635', '63', '南山区', '0');
INSERT INTO `sys_district` VALUES ('636', '63', '兴安区', '0');
INSERT INTO `sys_district` VALUES ('637', '63', '东山区', '0');
INSERT INTO `sys_district` VALUES ('638', '63', '兴山区', '0');
INSERT INTO `sys_district` VALUES ('639', '63', '萝北县', '0');
INSERT INTO `sys_district` VALUES ('640', '63', '绥滨县', '0');
INSERT INTO `sys_district` VALUES ('641', '64', '尖山区', '0');
INSERT INTO `sys_district` VALUES ('642', '64', '岭东区', '0');
INSERT INTO `sys_district` VALUES ('643', '64', '四方台区', '0');
INSERT INTO `sys_district` VALUES ('644', '64', '宝山区', '0');
INSERT INTO `sys_district` VALUES ('645', '64', '集贤县', '0');
INSERT INTO `sys_district` VALUES ('646', '64', '友谊县', '0');
INSERT INTO `sys_district` VALUES ('647', '64', '宝清县', '0');
INSERT INTO `sys_district` VALUES ('648', '64', '饶河县', '0');
INSERT INTO `sys_district` VALUES ('649', '65', '萨尔图区', '0');
INSERT INTO `sys_district` VALUES ('650', '65', '龙凤区', '0');
INSERT INTO `sys_district` VALUES ('651', '65', '让胡路区', '0');
INSERT INTO `sys_district` VALUES ('652', '65', '红岗区', '0');
INSERT INTO `sys_district` VALUES ('653', '65', '大同区', '0');
INSERT INTO `sys_district` VALUES ('654', '65', '肇州县', '0');
INSERT INTO `sys_district` VALUES ('655', '65', '肇源县', '0');
INSERT INTO `sys_district` VALUES ('656', '65', '林甸县', '0');
INSERT INTO `sys_district` VALUES ('657', '65', '杜尔伯特蒙古族自治县', '0');
INSERT INTO `sys_district` VALUES ('658', '66', '伊春区', '0');
INSERT INTO `sys_district` VALUES ('659', '66', '南岔区', '0');
INSERT INTO `sys_district` VALUES ('660', '66', '友好区', '0');
INSERT INTO `sys_district` VALUES ('661', '66', '西林区', '0');
INSERT INTO `sys_district` VALUES ('662', '66', '翠峦区', '0');
INSERT INTO `sys_district` VALUES ('663', '66', '新青区', '0');
INSERT INTO `sys_district` VALUES ('664', '66', '美溪区', '0');
INSERT INTO `sys_district` VALUES ('665', '66', '金山屯区', '0');
INSERT INTO `sys_district` VALUES ('666', '66', '五营区', '0');
INSERT INTO `sys_district` VALUES ('667', '66', '乌马河区', '0');
INSERT INTO `sys_district` VALUES ('668', '66', '汤旺河区', '0');
INSERT INTO `sys_district` VALUES ('669', '66', '带岭区', '0');
INSERT INTO `sys_district` VALUES ('670', '66', '乌伊岭区', '0');
INSERT INTO `sys_district` VALUES ('671', '66', '红星区', '0');
INSERT INTO `sys_district` VALUES ('672', '66', '上甘岭区', '0');
INSERT INTO `sys_district` VALUES ('673', '66', '嘉荫县', '0');
INSERT INTO `sys_district` VALUES ('674', '66', '铁力市', '0');
INSERT INTO `sys_district` VALUES ('676', '67', '向阳区', '0');
INSERT INTO `sys_district` VALUES ('677', '67', '前进区', '0');
INSERT INTO `sys_district` VALUES ('678', '67', '东风区', '0');
INSERT INTO `sys_district` VALUES ('679', '67', '郊区', '0');
INSERT INTO `sys_district` VALUES ('680', '67', '桦南县', '0');
INSERT INTO `sys_district` VALUES ('681', '67', '桦川县', '0');
INSERT INTO `sys_district` VALUES ('682', '67', '汤原县', '0');
INSERT INTO `sys_district` VALUES ('683', '67', '抚远县', '0');
INSERT INTO `sys_district` VALUES ('684', '67', '同江市', '0');
INSERT INTO `sys_district` VALUES ('685', '67', '富锦市', '0');
INSERT INTO `sys_district` VALUES ('686', '68', '新兴区', '0');
INSERT INTO `sys_district` VALUES ('687', '68', '桃山区', '0');
INSERT INTO `sys_district` VALUES ('688', '68', '茄子河区', '0');
INSERT INTO `sys_district` VALUES ('689', '68', '勃利县', '0');
INSERT INTO `sys_district` VALUES ('690', '69', '东安区', '0');
INSERT INTO `sys_district` VALUES ('691', '69', '阳明区', '0');
INSERT INTO `sys_district` VALUES ('692', '69', '爱民区', '0');
INSERT INTO `sys_district` VALUES ('693', '69', '西安区', '0');
INSERT INTO `sys_district` VALUES ('694', '69', '东宁县', '0');
INSERT INTO `sys_district` VALUES ('695', '69', '林口县', '0');
INSERT INTO `sys_district` VALUES ('696', '69', '绥芬河市', '0');
INSERT INTO `sys_district` VALUES ('697', '69', '海林市', '0');
INSERT INTO `sys_district` VALUES ('698', '69', '宁安市', '0');
INSERT INTO `sys_district` VALUES ('699', '69', '穆棱市', '0');
INSERT INTO `sys_district` VALUES ('700', '70', '爱辉区', '0');
INSERT INTO `sys_district` VALUES ('701', '70', '嫩江县', '0');
INSERT INTO `sys_district` VALUES ('702', '70', '逊克县', '0');
INSERT INTO `sys_district` VALUES ('703', '70', '孙吴县', '0');
INSERT INTO `sys_district` VALUES ('704', '70', '北安市', '0');
INSERT INTO `sys_district` VALUES ('705', '70', '五大连池市', '0');
INSERT INTO `sys_district` VALUES ('706', '71', '北林区', '0');
INSERT INTO `sys_district` VALUES ('707', '71', '望奎县', '0');
INSERT INTO `sys_district` VALUES ('708', '71', '兰西县', '0');
INSERT INTO `sys_district` VALUES ('709', '71', '青冈县', '0');
INSERT INTO `sys_district` VALUES ('710', '71', '庆安县', '0');
INSERT INTO `sys_district` VALUES ('711', '71', '明水县', '0');
INSERT INTO `sys_district` VALUES ('712', '71', '绥棱县', '0');
INSERT INTO `sys_district` VALUES ('713', '71', '安达市', '0');
INSERT INTO `sys_district` VALUES ('714', '71', '肇东市', '0');
INSERT INTO `sys_district` VALUES ('715', '71', '海伦市', '0');
INSERT INTO `sys_district` VALUES ('716', '72', '呼玛县', '0');
INSERT INTO `sys_district` VALUES ('717', '72', '塔河县', '0');
INSERT INTO `sys_district` VALUES ('718', '72', '漠河县', '0');
INSERT INTO `sys_district` VALUES ('719', '73', '黄浦区', '0');
INSERT INTO `sys_district` VALUES ('721', '73', '徐汇区', '0');
INSERT INTO `sys_district` VALUES ('722', '73', '长宁区', '0');
INSERT INTO `sys_district` VALUES ('723', '73', '静安区', '0');
INSERT INTO `sys_district` VALUES ('724', '73', '普陀区', '0');
INSERT INTO `sys_district` VALUES ('725', '73', '闸北区', '0');
INSERT INTO `sys_district` VALUES ('726', '73', '虹口区', '0');
INSERT INTO `sys_district` VALUES ('727', '73', '杨浦区', '0');
INSERT INTO `sys_district` VALUES ('728', '73', '闵行区', '0');
INSERT INTO `sys_district` VALUES ('729', '73', '宝山区', '0');
INSERT INTO `sys_district` VALUES ('730', '73', '嘉定区', '0');
INSERT INTO `sys_district` VALUES ('731', '73', '浦东新区', '0');
INSERT INTO `sys_district` VALUES ('732', '73', '金山区', '0');
INSERT INTO `sys_district` VALUES ('733', '73', '松江区', '0');
INSERT INTO `sys_district` VALUES ('734', '73', '青浦区', '0');
INSERT INTO `sys_district` VALUES ('736', '73', '奉贤区', '0');
INSERT INTO `sys_district` VALUES ('737', '73', '崇明县', '0');
INSERT INTO `sys_district` VALUES ('738', '74', '玄武区', '0');
INSERT INTO `sys_district` VALUES ('740', '74', '秦淮区', '0');
INSERT INTO `sys_district` VALUES ('741', '74', '建邺区', '0');
INSERT INTO `sys_district` VALUES ('742', '74', '鼓楼区', '0');
INSERT INTO `sys_district` VALUES ('744', '74', '浦口区', '0');
INSERT INTO `sys_district` VALUES ('745', '74', '栖霞区', '0');
INSERT INTO `sys_district` VALUES ('746', '74', '雨花台区', '0');
INSERT INTO `sys_district` VALUES ('747', '74', '江宁区', '0');
INSERT INTO `sys_district` VALUES ('748', '74', '六合区', '0');
INSERT INTO `sys_district` VALUES ('751', '75', '崇安区', '0');
INSERT INTO `sys_district` VALUES ('752', '75', '南长区', '0');
INSERT INTO `sys_district` VALUES ('753', '75', '北塘区', '0');
INSERT INTO `sys_district` VALUES ('754', '75', '锡山区', '0');
INSERT INTO `sys_district` VALUES ('755', '75', '惠山区', '0');
INSERT INTO `sys_district` VALUES ('756', '75', '滨湖区', '0');
INSERT INTO `sys_district` VALUES ('757', '75', '江阴市', '0');
INSERT INTO `sys_district` VALUES ('758', '75', '宜兴市', '0');
INSERT INTO `sys_district` VALUES ('759', '76', '鼓楼区', '0');
INSERT INTO `sys_district` VALUES ('760', '76', '云龙区', '0');
INSERT INTO `sys_district` VALUES ('762', '76', '贾汪区', '0');
INSERT INTO `sys_district` VALUES ('763', '76', '泉山区', '0');
INSERT INTO `sys_district` VALUES ('764', '76', '丰县', '0');
INSERT INTO `sys_district` VALUES ('765', '76', '沛县', '0');
INSERT INTO `sys_district` VALUES ('767', '76', '睢宁县', '0');
INSERT INTO `sys_district` VALUES ('768', '76', '新沂市', '0');
INSERT INTO `sys_district` VALUES ('769', '76', '邳州市', '0');
INSERT INTO `sys_district` VALUES ('770', '77', '天宁区', '0');
INSERT INTO `sys_district` VALUES ('771', '77', '钟楼区', '0');
INSERT INTO `sys_district` VALUES ('772', '77', '戚墅堰区', '0');
INSERT INTO `sys_district` VALUES ('773', '77', '新北区', '0');
INSERT INTO `sys_district` VALUES ('774', '77', '武进区', '0');
INSERT INTO `sys_district` VALUES ('775', '77', '溧阳市', '0');
INSERT INTO `sys_district` VALUES ('776', '77', '金坛市', '0');
INSERT INTO `sys_district` VALUES ('780', '78', '虎丘区', '0');
INSERT INTO `sys_district` VALUES ('781', '78', '吴中区', '0');
INSERT INTO `sys_district` VALUES ('782', '78', '相城区', '0');
INSERT INTO `sys_district` VALUES ('783', '78', '常熟市', '0');
INSERT INTO `sys_district` VALUES ('784', '78', '张家港市', '0');
INSERT INTO `sys_district` VALUES ('785', '78', '昆山市', '0');
INSERT INTO `sys_district` VALUES ('787', '78', '太仓市', '0');
INSERT INTO `sys_district` VALUES ('788', '79', '崇川区', '0');
INSERT INTO `sys_district` VALUES ('789', '79', '港闸区', '0');
INSERT INTO `sys_district` VALUES ('790', '79', '海安县', '0');
INSERT INTO `sys_district` VALUES ('791', '79', '如东县', '0');
INSERT INTO `sys_district` VALUES ('792', '79', '启东市', '0');
INSERT INTO `sys_district` VALUES ('793', '79', '如皋市', '0');
INSERT INTO `sys_district` VALUES ('795', '79', '海门市', '0');
INSERT INTO `sys_district` VALUES ('796', '80', '连云区', '0');
INSERT INTO `sys_district` VALUES ('797', '80', '新浦区', '0');
INSERT INTO `sys_district` VALUES ('798', '80', '海州区', '0');
INSERT INTO `sys_district` VALUES ('799', '80', '赣榆县', '0');
INSERT INTO `sys_district` VALUES ('800', '80', '东海县', '0');
INSERT INTO `sys_district` VALUES ('801', '80', '灌云县', '0');
INSERT INTO `sys_district` VALUES ('802', '80', '灌南县', '0');
INSERT INTO `sys_district` VALUES ('803', '81', '清河区', '0');
INSERT INTO `sys_district` VALUES ('805', '81', '淮阴区', '0');
INSERT INTO `sys_district` VALUES ('806', '81', '清浦区', '0');
INSERT INTO `sys_district` VALUES ('807', '81', '涟水县', '0');
INSERT INTO `sys_district` VALUES ('808', '81', '洪泽县', '0');
INSERT INTO `sys_district` VALUES ('809', '81', '盱眙县', '0');
INSERT INTO `sys_district` VALUES ('810', '81', '金湖县', '0');
INSERT INTO `sys_district` VALUES ('811', '82', '亭湖区', '0');
INSERT INTO `sys_district` VALUES ('812', '82', '盐都区', '0');
INSERT INTO `sys_district` VALUES ('813', '82', '响水县', '0');
INSERT INTO `sys_district` VALUES ('814', '82', '滨海县', '0');
INSERT INTO `sys_district` VALUES ('815', '82', '阜宁县', '0');
INSERT INTO `sys_district` VALUES ('816', '82', '射阳县', '0');
INSERT INTO `sys_district` VALUES ('817', '82', '建湖县', '0');
INSERT INTO `sys_district` VALUES ('818', '82', '东台市', '0');
INSERT INTO `sys_district` VALUES ('819', '82', '大丰市', '0');
INSERT INTO `sys_district` VALUES ('820', '83', '广陵区', '0');
INSERT INTO `sys_district` VALUES ('821', '83', '邗江区', '0');
INSERT INTO `sys_district` VALUES ('823', '83', '宝应县', '0');
INSERT INTO `sys_district` VALUES ('824', '83', '仪征市', '0');
INSERT INTO `sys_district` VALUES ('825', '83', '高邮市', '0');
INSERT INTO `sys_district` VALUES ('827', '84', '京口区', '0');
INSERT INTO `sys_district` VALUES ('828', '84', '润州区', '0');
INSERT INTO `sys_district` VALUES ('829', '84', '丹徒区', '0');
INSERT INTO `sys_district` VALUES ('830', '84', '丹阳市', '0');
INSERT INTO `sys_district` VALUES ('831', '84', '扬中市', '0');
INSERT INTO `sys_district` VALUES ('832', '84', '句容市', '0');
INSERT INTO `sys_district` VALUES ('833', '85', '海陵区', '0');
INSERT INTO `sys_district` VALUES ('834', '85', '高港区', '0');
INSERT INTO `sys_district` VALUES ('835', '85', '兴化市', '0');
INSERT INTO `sys_district` VALUES ('836', '85', '靖江市', '0');
INSERT INTO `sys_district` VALUES ('837', '85', '泰兴市', '0');
INSERT INTO `sys_district` VALUES ('839', '86', '宿城区', '0');
INSERT INTO `sys_district` VALUES ('840', '86', '宿豫区', '0');
INSERT INTO `sys_district` VALUES ('841', '86', '沭阳县', '0');
INSERT INTO `sys_district` VALUES ('842', '86', '泗阳县', '0');
INSERT INTO `sys_district` VALUES ('843', '86', '泗洪县', '0');
INSERT INTO `sys_district` VALUES ('844', '87', '上城区', '0');
INSERT INTO `sys_district` VALUES ('845', '87', '下城区', '0');
INSERT INTO `sys_district` VALUES ('846', '87', '江干区', '0');
INSERT INTO `sys_district` VALUES ('847', '87', '拱墅区', '0');
INSERT INTO `sys_district` VALUES ('848', '87', '西湖区', '0');
INSERT INTO `sys_district` VALUES ('849', '87', '滨江区', '0');
INSERT INTO `sys_district` VALUES ('850', '87', '萧山区', '0');
INSERT INTO `sys_district` VALUES ('851', '87', '余杭区', '0');
INSERT INTO `sys_district` VALUES ('852', '87', '桐庐县', '0');
INSERT INTO `sys_district` VALUES ('853', '87', '淳安县', '0');
INSERT INTO `sys_district` VALUES ('854', '87', '建德市', '0');
INSERT INTO `sys_district` VALUES ('855', '87', '富阳市', '0');
INSERT INTO `sys_district` VALUES ('856', '87', '临安市', '0');
INSERT INTO `sys_district` VALUES ('857', '88', '海曙区', '0');
INSERT INTO `sys_district` VALUES ('858', '88', '江东区', '0');
INSERT INTO `sys_district` VALUES ('859', '88', '江北区', '0');
INSERT INTO `sys_district` VALUES ('860', '88', '北仑区', '0');
INSERT INTO `sys_district` VALUES ('861', '88', '镇海区', '0');
INSERT INTO `sys_district` VALUES ('862', '88', '鄞州区', '0');
INSERT INTO `sys_district` VALUES ('863', '88', '象山县', '0');
INSERT INTO `sys_district` VALUES ('864', '88', '宁海县', '0');
INSERT INTO `sys_district` VALUES ('865', '88', '余姚市', '0');
INSERT INTO `sys_district` VALUES ('866', '88', '慈溪市', '0');
INSERT INTO `sys_district` VALUES ('867', '88', '奉化市', '0');
INSERT INTO `sys_district` VALUES ('868', '89', '鹿城区', '0');
INSERT INTO `sys_district` VALUES ('869', '89', '龙湾区', '0');
INSERT INTO `sys_district` VALUES ('870', '89', '瓯海区', '0');
INSERT INTO `sys_district` VALUES ('871', '89', '洞头县', '0');
INSERT INTO `sys_district` VALUES ('872', '89', '永嘉县', '0');
INSERT INTO `sys_district` VALUES ('873', '89', '平阳县', '0');
INSERT INTO `sys_district` VALUES ('874', '89', '苍南县', '0');
INSERT INTO `sys_district` VALUES ('875', '89', '文成县', '0');
INSERT INTO `sys_district` VALUES ('876', '89', '泰顺县', '0');
INSERT INTO `sys_district` VALUES ('877', '89', '瑞安市', '0');
INSERT INTO `sys_district` VALUES ('878', '89', '乐清市', '0');
INSERT INTO `sys_district` VALUES ('880', '90', '秀洲区', '0');
INSERT INTO `sys_district` VALUES ('881', '90', '嘉善县', '0');
INSERT INTO `sys_district` VALUES ('882', '90', '海盐县', '0');
INSERT INTO `sys_district` VALUES ('883', '90', '海宁市', '0');
INSERT INTO `sys_district` VALUES ('884', '90', '平湖市', '0');
INSERT INTO `sys_district` VALUES ('885', '90', '桐乡市', '0');
INSERT INTO `sys_district` VALUES ('886', '91', '吴兴区', '0');
INSERT INTO `sys_district` VALUES ('887', '91', '南浔区', '0');
INSERT INTO `sys_district` VALUES ('888', '91', '德清县', '0');
INSERT INTO `sys_district` VALUES ('889', '91', '长兴县', '0');
INSERT INTO `sys_district` VALUES ('890', '91', '安吉县', '0');
INSERT INTO `sys_district` VALUES ('891', '92', '越城区', '0');
INSERT INTO `sys_district` VALUES ('892', '92', '绍兴县', '0');
INSERT INTO `sys_district` VALUES ('893', '92', '新昌县', '0');
INSERT INTO `sys_district` VALUES ('894', '92', '诸暨市', '0');
INSERT INTO `sys_district` VALUES ('895', '92', '上虞市', '0');
INSERT INTO `sys_district` VALUES ('896', '92', '嵊州市', '0');
INSERT INTO `sys_district` VALUES ('897', '93', '婺城区', '0');
INSERT INTO `sys_district` VALUES ('898', '93', '金东区', '0');
INSERT INTO `sys_district` VALUES ('899', '93', '武义县', '0');
INSERT INTO `sys_district` VALUES ('900', '93', '浦江县', '0');
INSERT INTO `sys_district` VALUES ('901', '93', '磐安县', '0');
INSERT INTO `sys_district` VALUES ('902', '93', '兰溪市', '0');
INSERT INTO `sys_district` VALUES ('903', '93', '义乌市', '0');
INSERT INTO `sys_district` VALUES ('904', '93', '东阳市', '0');
INSERT INTO `sys_district` VALUES ('905', '93', '永康市', '0');
INSERT INTO `sys_district` VALUES ('906', '94', '柯城区', '0');
INSERT INTO `sys_district` VALUES ('907', '94', '衢江区', '0');
INSERT INTO `sys_district` VALUES ('908', '94', '常山县', '0');
INSERT INTO `sys_district` VALUES ('909', '94', '开化县', '0');
INSERT INTO `sys_district` VALUES ('910', '94', '龙游县', '0');
INSERT INTO `sys_district` VALUES ('911', '94', '江山市', '0');
INSERT INTO `sys_district` VALUES ('912', '95', '定海区', '0');
INSERT INTO `sys_district` VALUES ('913', '95', '普陀区', '0');
INSERT INTO `sys_district` VALUES ('914', '95', '岱山县', '0');
INSERT INTO `sys_district` VALUES ('915', '95', '嵊泗县', '0');
INSERT INTO `sys_district` VALUES ('916', '96', '椒江区', '0');
INSERT INTO `sys_district` VALUES ('917', '96', '黄岩区', '0');
INSERT INTO `sys_district` VALUES ('918', '96', '路桥区', '0');
INSERT INTO `sys_district` VALUES ('919', '96', '玉环县', '0');
INSERT INTO `sys_district` VALUES ('920', '96', '三门县', '0');
INSERT INTO `sys_district` VALUES ('921', '96', '天台县', '0');
INSERT INTO `sys_district` VALUES ('922', '96', '仙居县', '0');
INSERT INTO `sys_district` VALUES ('923', '96', '温岭市', '0');
INSERT INTO `sys_district` VALUES ('924', '96', '临海市', '0');
INSERT INTO `sys_district` VALUES ('925', '97', '莲都区', '0');
INSERT INTO `sys_district` VALUES ('926', '97', '青田县', '0');
INSERT INTO `sys_district` VALUES ('927', '97', '缙云县', '0');
INSERT INTO `sys_district` VALUES ('928', '97', '遂昌县', '0');
INSERT INTO `sys_district` VALUES ('929', '97', '松阳县', '0');
INSERT INTO `sys_district` VALUES ('930', '97', '云和县', '0');
INSERT INTO `sys_district` VALUES ('931', '97', '庆元县', '0');
INSERT INTO `sys_district` VALUES ('932', '97', '景宁畲族自治县', '0');
INSERT INTO `sys_district` VALUES ('933', '97', '龙泉市', '0');
INSERT INTO `sys_district` VALUES ('934', '98', '瑶海区', '0');
INSERT INTO `sys_district` VALUES ('935', '98', '庐阳区', '0');
INSERT INTO `sys_district` VALUES ('936', '98', '蜀山区', '0');
INSERT INTO `sys_district` VALUES ('937', '98', '包河区', '0');
INSERT INTO `sys_district` VALUES ('938', '98', '长丰县', '0');
INSERT INTO `sys_district` VALUES ('939', '98', '肥东县', '0');
INSERT INTO `sys_district` VALUES ('940', '98', '肥西县', '0');
INSERT INTO `sys_district` VALUES ('941', '99', '镜湖区', '0');
INSERT INTO `sys_district` VALUES ('944', '99', '鸠江区', '0');
INSERT INTO `sys_district` VALUES ('945', '99', '芜湖县', '0');
INSERT INTO `sys_district` VALUES ('946', '99', '繁昌县', '0');
INSERT INTO `sys_district` VALUES ('947', '99', '南陵县', '0');
INSERT INTO `sys_district` VALUES ('948', '100', '龙子湖区', '0');
INSERT INTO `sys_district` VALUES ('949', '100', '蚌山区', '0');
INSERT INTO `sys_district` VALUES ('950', '100', '禹会区', '0');
INSERT INTO `sys_district` VALUES ('951', '100', '淮上区', '0');
INSERT INTO `sys_district` VALUES ('952', '100', '怀远县', '0');
INSERT INTO `sys_district` VALUES ('953', '100', '五河县', '0');
INSERT INTO `sys_district` VALUES ('954', '100', '固镇县', '0');
INSERT INTO `sys_district` VALUES ('955', '101', '大通区', '0');
INSERT INTO `sys_district` VALUES ('956', '101', '田家庵区', '0');
INSERT INTO `sys_district` VALUES ('957', '101', '谢家集区', '0');
INSERT INTO `sys_district` VALUES ('958', '101', '八公山区', '0');
INSERT INTO `sys_district` VALUES ('959', '101', '潘集区', '0');
INSERT INTO `sys_district` VALUES ('960', '101', '凤台县', '0');
INSERT INTO `sys_district` VALUES ('962', '102', '花山区', '0');
INSERT INTO `sys_district` VALUES ('963', '102', '雨山区', '0');
INSERT INTO `sys_district` VALUES ('964', '102', '当涂县', '0');
INSERT INTO `sys_district` VALUES ('965', '103', '杜集区', '0');
INSERT INTO `sys_district` VALUES ('966', '103', '相山区', '0');
INSERT INTO `sys_district` VALUES ('967', '103', '烈山区', '0');
INSERT INTO `sys_district` VALUES ('968', '103', '濉溪县', '0');
INSERT INTO `sys_district` VALUES ('969', '104', '铜官山区', '0');
INSERT INTO `sys_district` VALUES ('970', '104', '狮子山区', '0');
INSERT INTO `sys_district` VALUES ('971', '104', '郊区', '0');
INSERT INTO `sys_district` VALUES ('972', '104', '铜陵县', '0');
INSERT INTO `sys_district` VALUES ('973', '105', '迎江区', '0');
INSERT INTO `sys_district` VALUES ('974', '105', '大观区', '0');
INSERT INTO `sys_district` VALUES ('976', '105', '怀宁县', '0');
INSERT INTO `sys_district` VALUES ('977', '105', '枞阳县', '0');
INSERT INTO `sys_district` VALUES ('978', '105', '潜山县', '0');
INSERT INTO `sys_district` VALUES ('979', '105', '太湖县', '0');
INSERT INTO `sys_district` VALUES ('980', '105', '宿松县', '0');
INSERT INTO `sys_district` VALUES ('981', '105', '望江县', '0');
INSERT INTO `sys_district` VALUES ('982', '105', '岳西县', '0');
INSERT INTO `sys_district` VALUES ('983', '105', '桐城市', '0');
INSERT INTO `sys_district` VALUES ('984', '106', '屯溪区', '0');
INSERT INTO `sys_district` VALUES ('985', '106', '黄山区', '0');
INSERT INTO `sys_district` VALUES ('986', '106', '徽州区', '0');
INSERT INTO `sys_district` VALUES ('987', '106', '歙县', '0');
INSERT INTO `sys_district` VALUES ('988', '106', '休宁县', '0');
INSERT INTO `sys_district` VALUES ('989', '106', '黟县', '0');
INSERT INTO `sys_district` VALUES ('990', '106', '祁门县', '0');
INSERT INTO `sys_district` VALUES ('991', '107', '琅琊区', '0');
INSERT INTO `sys_district` VALUES ('992', '107', '南谯区', '0');
INSERT INTO `sys_district` VALUES ('993', '107', '来安县', '0');
INSERT INTO `sys_district` VALUES ('994', '107', '全椒县', '0');
INSERT INTO `sys_district` VALUES ('995', '107', '定远县', '0');
INSERT INTO `sys_district` VALUES ('996', '107', '凤阳县', '0');
INSERT INTO `sys_district` VALUES ('997', '107', '天长市', '0');
INSERT INTO `sys_district` VALUES ('998', '107', '明光市', '0');
INSERT INTO `sys_district` VALUES ('999', '108', '颍州区', '0');
INSERT INTO `sys_district` VALUES ('1000', '108', '颍东区', '0');
INSERT INTO `sys_district` VALUES ('1001', '108', '颍泉区', '0');
INSERT INTO `sys_district` VALUES ('1002', '108', '临泉县', '0');
INSERT INTO `sys_district` VALUES ('1003', '108', '太和县', '0');
INSERT INTO `sys_district` VALUES ('1004', '108', '阜南县', '0');
INSERT INTO `sys_district` VALUES ('1005', '108', '颍上县', '0');
INSERT INTO `sys_district` VALUES ('1006', '108', '界首市', '0');
INSERT INTO `sys_district` VALUES ('1007', '109', '埇桥区', '0');
INSERT INTO `sys_district` VALUES ('1008', '109', '砀山县', '0');
INSERT INTO `sys_district` VALUES ('1009', '109', '萧县', '0');
INSERT INTO `sys_district` VALUES ('1010', '109', '灵璧县', '0');
INSERT INTO `sys_district` VALUES ('1011', '109', '泗县', '0');
INSERT INTO `sys_district` VALUES ('1017', '111', '金安区', '0');
INSERT INTO `sys_district` VALUES ('1018', '111', '裕安区', '0');
INSERT INTO `sys_district` VALUES ('1019', '111', '寿县', '0');
INSERT INTO `sys_district` VALUES ('1020', '111', '霍邱县', '0');
INSERT INTO `sys_district` VALUES ('1021', '111', '舒城县', '0');
INSERT INTO `sys_district` VALUES ('1022', '111', '金寨县', '0');
INSERT INTO `sys_district` VALUES ('1023', '111', '霍山县', '0');
INSERT INTO `sys_district` VALUES ('1024', '112', '谯城区', '0');
INSERT INTO `sys_district` VALUES ('1025', '112', '涡阳县', '0');
INSERT INTO `sys_district` VALUES ('1026', '112', '蒙城县', '0');
INSERT INTO `sys_district` VALUES ('1027', '112', '利辛县', '0');
INSERT INTO `sys_district` VALUES ('1028', '113', '贵池区', '0');
INSERT INTO `sys_district` VALUES ('1029', '113', '东至县', '0');
INSERT INTO `sys_district` VALUES ('1030', '113', '石台县', '0');
INSERT INTO `sys_district` VALUES ('1031', '113', '青阳县', '0');
INSERT INTO `sys_district` VALUES ('1032', '114', '宣州区', '0');
INSERT INTO `sys_district` VALUES ('1033', '114', '郎溪县', '0');
INSERT INTO `sys_district` VALUES ('1034', '114', '广德县', '0');
INSERT INTO `sys_district` VALUES ('1035', '114', '泾县', '0');
INSERT INTO `sys_district` VALUES ('1036', '114', '绩溪县', '0');
INSERT INTO `sys_district` VALUES ('1037', '114', '旌德县', '0');
INSERT INTO `sys_district` VALUES ('1038', '114', '宁国市', '0');
INSERT INTO `sys_district` VALUES ('1039', '115', '鼓楼区', '0');
INSERT INTO `sys_district` VALUES ('1040', '115', '台江区', '0');
INSERT INTO `sys_district` VALUES ('1041', '115', '仓山区', '0');
INSERT INTO `sys_district` VALUES ('1042', '115', '马尾区', '0');
INSERT INTO `sys_district` VALUES ('1043', '115', '晋安区', '0');
INSERT INTO `sys_district` VALUES ('1044', '115', '闽侯县', '0');
INSERT INTO `sys_district` VALUES ('1045', '115', '连江县', '0');
INSERT INTO `sys_district` VALUES ('1046', '115', '罗源县', '0');
INSERT INTO `sys_district` VALUES ('1047', '115', '闽清县', '0');
INSERT INTO `sys_district` VALUES ('1048', '115', '永泰县', '0');
INSERT INTO `sys_district` VALUES ('1049', '115', '平潭县', '0');
INSERT INTO `sys_district` VALUES ('1050', '115', '福清市', '0');
INSERT INTO `sys_district` VALUES ('1051', '115', '长乐市', '0');
INSERT INTO `sys_district` VALUES ('1052', '116', '思明区', '0');
INSERT INTO `sys_district` VALUES ('1053', '116', '海沧区', '0');
INSERT INTO `sys_district` VALUES ('1054', '116', '湖里区', '0');
INSERT INTO `sys_district` VALUES ('1055', '116', '集美区', '0');
INSERT INTO `sys_district` VALUES ('1056', '116', '同安区', '0');
INSERT INTO `sys_district` VALUES ('1057', '116', '翔安区', '0');
INSERT INTO `sys_district` VALUES ('1058', '117', '城厢区', '0');
INSERT INTO `sys_district` VALUES ('1059', '117', '涵江区', '0');
INSERT INTO `sys_district` VALUES ('1060', '117', '荔城区', '0');
INSERT INTO `sys_district` VALUES ('1061', '117', '秀屿区', '0');
INSERT INTO `sys_district` VALUES ('1062', '117', '仙游县', '0');
INSERT INTO `sys_district` VALUES ('1063', '118', '梅列区', '0');
INSERT INTO `sys_district` VALUES ('1064', '118', '三元区', '0');
INSERT INTO `sys_district` VALUES ('1065', '118', '明溪县', '0');
INSERT INTO `sys_district` VALUES ('1066', '118', '清流县', '0');
INSERT INTO `sys_district` VALUES ('1067', '118', '宁化县', '0');
INSERT INTO `sys_district` VALUES ('1068', '118', '大田县', '0');
INSERT INTO `sys_district` VALUES ('1069', '118', '尤溪县', '0');
INSERT INTO `sys_district` VALUES ('1070', '118', '沙县', '0');
INSERT INTO `sys_district` VALUES ('1071', '118', '将乐县', '0');
INSERT INTO `sys_district` VALUES ('1072', '118', '泰宁县', '0');
INSERT INTO `sys_district` VALUES ('1073', '118', '建宁县', '0');
INSERT INTO `sys_district` VALUES ('1074', '118', '永安市', '0');
INSERT INTO `sys_district` VALUES ('1075', '119', '鲤城区', '0');
INSERT INTO `sys_district` VALUES ('1076', '119', '丰泽区', '0');
INSERT INTO `sys_district` VALUES ('1077', '119', '洛江区', '0');
INSERT INTO `sys_district` VALUES ('1078', '119', '泉港区', '0');
INSERT INTO `sys_district` VALUES ('1079', '119', '惠安县', '0');
INSERT INTO `sys_district` VALUES ('1080', '119', '安溪县', '0');
INSERT INTO `sys_district` VALUES ('1081', '119', '永春县', '0');
INSERT INTO `sys_district` VALUES ('1082', '119', '德化县', '0');
INSERT INTO `sys_district` VALUES ('1083', '119', '金门县', '0');
INSERT INTO `sys_district` VALUES ('1084', '119', '石狮市', '0');
INSERT INTO `sys_district` VALUES ('1085', '119', '晋江市', '0');
INSERT INTO `sys_district` VALUES ('1086', '119', '南安市', '0');
INSERT INTO `sys_district` VALUES ('1087', '120', '芗城区', '0');
INSERT INTO `sys_district` VALUES ('1088', '120', '龙文区', '0');
INSERT INTO `sys_district` VALUES ('1089', '120', '云霄县', '0');
INSERT INTO `sys_district` VALUES ('1090', '120', '漳浦县', '0');
INSERT INTO `sys_district` VALUES ('1091', '120', '诏安县', '0');
INSERT INTO `sys_district` VALUES ('1092', '120', '长泰县', '0');
INSERT INTO `sys_district` VALUES ('1093', '120', '东山县', '0');
INSERT INTO `sys_district` VALUES ('1094', '120', '南靖县', '0');
INSERT INTO `sys_district` VALUES ('1095', '120', '平和县', '0');
INSERT INTO `sys_district` VALUES ('1096', '120', '华安县', '0');
INSERT INTO `sys_district` VALUES ('1097', '120', '龙海市', '0');
INSERT INTO `sys_district` VALUES ('1098', '121', '延平区', '0');
INSERT INTO `sys_district` VALUES ('1099', '121', '顺昌县', '0');
INSERT INTO `sys_district` VALUES ('1100', '121', '浦城县', '0');
INSERT INTO `sys_district` VALUES ('1101', '121', '光泽县', '0');
INSERT INTO `sys_district` VALUES ('1102', '121', '松溪县', '0');
INSERT INTO `sys_district` VALUES ('1103', '121', '政和县', '0');
INSERT INTO `sys_district` VALUES ('1104', '121', '邵武市', '0');
INSERT INTO `sys_district` VALUES ('1105', '121', '武夷山市', '0');
INSERT INTO `sys_district` VALUES ('1106', '121', '建瓯市', '0');
INSERT INTO `sys_district` VALUES ('1107', '121', '建阳市', '0');
INSERT INTO `sys_district` VALUES ('1108', '122', '新罗区', '0');
INSERT INTO `sys_district` VALUES ('1109', '122', '长汀县', '0');
INSERT INTO `sys_district` VALUES ('1110', '122', '永定县', '0');
INSERT INTO `sys_district` VALUES ('1111', '122', '上杭县', '0');
INSERT INTO `sys_district` VALUES ('1112', '122', '武平县', '0');
INSERT INTO `sys_district` VALUES ('1113', '122', '连城县', '0');
INSERT INTO `sys_district` VALUES ('1114', '122', '漳平市', '0');
INSERT INTO `sys_district` VALUES ('1115', '123', '蕉城区', '0');
INSERT INTO `sys_district` VALUES ('1116', '123', '霞浦县', '0');
INSERT INTO `sys_district` VALUES ('1117', '123', '古田县', '0');
INSERT INTO `sys_district` VALUES ('1118', '123', '屏南县', '0');
INSERT INTO `sys_district` VALUES ('1119', '123', '寿宁县', '0');
INSERT INTO `sys_district` VALUES ('1120', '123', '周宁县', '0');
INSERT INTO `sys_district` VALUES ('1121', '123', '柘荣县', '0');
INSERT INTO `sys_district` VALUES ('1122', '123', '福安市', '0');
INSERT INTO `sys_district` VALUES ('1123', '123', '福鼎市', '0');
INSERT INTO `sys_district` VALUES ('1124', '124', '东湖区', '0');
INSERT INTO `sys_district` VALUES ('1125', '124', '西湖区', '0');
INSERT INTO `sys_district` VALUES ('1126', '124', '青云谱区', '0');
INSERT INTO `sys_district` VALUES ('1127', '124', '湾里区', '0');
INSERT INTO `sys_district` VALUES ('1128', '124', '青山湖区', '0');
INSERT INTO `sys_district` VALUES ('1129', '124', '南昌县', '0');
INSERT INTO `sys_district` VALUES ('1130', '124', '新建县', '0');
INSERT INTO `sys_district` VALUES ('1131', '124', '安义县', '0');
INSERT INTO `sys_district` VALUES ('1132', '124', '进贤县', '0');
INSERT INTO `sys_district` VALUES ('1133', '125', '昌江区', '0');
INSERT INTO `sys_district` VALUES ('1134', '125', '珠山区', '0');
INSERT INTO `sys_district` VALUES ('1135', '125', '浮梁县', '0');
INSERT INTO `sys_district` VALUES ('1136', '125', '乐平市', '0');
INSERT INTO `sys_district` VALUES ('1137', '126', '安源区', '0');
INSERT INTO `sys_district` VALUES ('1138', '126', '湘东区', '0');
INSERT INTO `sys_district` VALUES ('1139', '126', '莲花县', '0');
INSERT INTO `sys_district` VALUES ('1140', '126', '上栗县', '0');
INSERT INTO `sys_district` VALUES ('1141', '126', '芦溪县', '0');
INSERT INTO `sys_district` VALUES ('1142', '127', '庐山区', '0');
INSERT INTO `sys_district` VALUES ('1143', '127', '浔阳区', '0');
INSERT INTO `sys_district` VALUES ('1144', '127', '九江县', '0');
INSERT INTO `sys_district` VALUES ('1145', '127', '武宁县', '0');
INSERT INTO `sys_district` VALUES ('1146', '127', '修水县', '0');
INSERT INTO `sys_district` VALUES ('1147', '127', '永修县', '0');
INSERT INTO `sys_district` VALUES ('1148', '127', '德安县', '0');
INSERT INTO `sys_district` VALUES ('1149', '127', '星子县', '0');
INSERT INTO `sys_district` VALUES ('1150', '127', '都昌县', '0');
INSERT INTO `sys_district` VALUES ('1151', '127', '湖口县', '0');
INSERT INTO `sys_district` VALUES ('1152', '127', '彭泽县', '0');
INSERT INTO `sys_district` VALUES ('1153', '127', '瑞昌市', '0');
INSERT INTO `sys_district` VALUES ('1154', '128', '渝水区', '0');
INSERT INTO `sys_district` VALUES ('1155', '128', '分宜县', '0');
INSERT INTO `sys_district` VALUES ('1156', '129', '月湖区', '0');
INSERT INTO `sys_district` VALUES ('1157', '129', '余江县', '0');
INSERT INTO `sys_district` VALUES ('1158', '129', '贵溪市', '0');
INSERT INTO `sys_district` VALUES ('1159', '130', '章贡区', '0');
INSERT INTO `sys_district` VALUES ('1160', '130', '赣县', '0');
INSERT INTO `sys_district` VALUES ('1161', '130', '信丰县', '0');
INSERT INTO `sys_district` VALUES ('1162', '130', '大余县', '0');
INSERT INTO `sys_district` VALUES ('1163', '130', '上犹县', '0');
INSERT INTO `sys_district` VALUES ('1164', '130', '崇义县', '0');
INSERT INTO `sys_district` VALUES ('1165', '130', '安远县', '0');
INSERT INTO `sys_district` VALUES ('1166', '130', '龙南县', '0');
INSERT INTO `sys_district` VALUES ('1167', '130', '定南县', '0');
INSERT INTO `sys_district` VALUES ('1168', '130', '全南县', '0');
INSERT INTO `sys_district` VALUES ('1169', '130', '宁都县', '0');
INSERT INTO `sys_district` VALUES ('1170', '130', '于都县', '0');
INSERT INTO `sys_district` VALUES ('1171', '130', '兴国县', '0');
INSERT INTO `sys_district` VALUES ('1172', '130', '会昌县', '0');
INSERT INTO `sys_district` VALUES ('1173', '130', '寻乌县', '0');
INSERT INTO `sys_district` VALUES ('1174', '130', '石城县', '0');
INSERT INTO `sys_district` VALUES ('1175', '130', '瑞金市', '0');
INSERT INTO `sys_district` VALUES ('1176', '130', '南康市', '0');
INSERT INTO `sys_district` VALUES ('1177', '131', '吉州区', '0');
INSERT INTO `sys_district` VALUES ('1178', '131', '青原区', '0');
INSERT INTO `sys_district` VALUES ('1179', '131', '吉安县', '0');
INSERT INTO `sys_district` VALUES ('1180', '131', '吉水县', '0');
INSERT INTO `sys_district` VALUES ('1181', '131', '峡江县', '0');
INSERT INTO `sys_district` VALUES ('1182', '131', '新干县', '0');
INSERT INTO `sys_district` VALUES ('1183', '131', '永丰县', '0');
INSERT INTO `sys_district` VALUES ('1184', '131', '泰和县', '0');
INSERT INTO `sys_district` VALUES ('1185', '131', '遂川县', '0');
INSERT INTO `sys_district` VALUES ('1186', '131', '万安县', '0');
INSERT INTO `sys_district` VALUES ('1187', '131', '安福县', '0');
INSERT INTO `sys_district` VALUES ('1188', '131', '永新县', '0');
INSERT INTO `sys_district` VALUES ('1189', '131', '井冈山市', '0');
INSERT INTO `sys_district` VALUES ('1190', '132', '袁州区', '0');
INSERT INTO `sys_district` VALUES ('1191', '132', '奉新县', '0');
INSERT INTO `sys_district` VALUES ('1192', '132', '万载县', '0');
INSERT INTO `sys_district` VALUES ('1193', '132', '上高县', '0');
INSERT INTO `sys_district` VALUES ('1194', '132', '宜丰县', '0');
INSERT INTO `sys_district` VALUES ('1195', '132', '靖安县', '0');
INSERT INTO `sys_district` VALUES ('1196', '132', '铜鼓县', '0');
INSERT INTO `sys_district` VALUES ('1197', '132', '丰城市', '0');
INSERT INTO `sys_district` VALUES ('1198', '132', '樟树市', '0');
INSERT INTO `sys_district` VALUES ('1199', '132', '高安市', '0');
INSERT INTO `sys_district` VALUES ('1200', '133', '临川区', '0');
INSERT INTO `sys_district` VALUES ('1201', '133', '南城县', '0');
INSERT INTO `sys_district` VALUES ('1202', '133', '黎川县', '0');
INSERT INTO `sys_district` VALUES ('1203', '133', '南丰县', '0');
INSERT INTO `sys_district` VALUES ('1204', '133', '崇仁县', '0');
INSERT INTO `sys_district` VALUES ('1205', '133', '乐安县', '0');
INSERT INTO `sys_district` VALUES ('1206', '133', '宜黄县', '0');
INSERT INTO `sys_district` VALUES ('1207', '133', '金溪县', '0');
INSERT INTO `sys_district` VALUES ('1208', '133', '资溪县', '0');
INSERT INTO `sys_district` VALUES ('1209', '133', '东乡县', '0');
INSERT INTO `sys_district` VALUES ('1210', '133', '广昌县', '0');
INSERT INTO `sys_district` VALUES ('1211', '134', '信州区', '0');
INSERT INTO `sys_district` VALUES ('1212', '134', '上饶县', '0');
INSERT INTO `sys_district` VALUES ('1213', '134', '广丰县', '0');
INSERT INTO `sys_district` VALUES ('1214', '134', '玉山县', '0');
INSERT INTO `sys_district` VALUES ('1215', '134', '铅山县', '0');
INSERT INTO `sys_district` VALUES ('1216', '134', '横峰县', '0');
INSERT INTO `sys_district` VALUES ('1217', '134', '弋阳县', '0');
INSERT INTO `sys_district` VALUES ('1218', '134', '余干县', '0');
INSERT INTO `sys_district` VALUES ('1219', '134', '鄱阳县', '0');
INSERT INTO `sys_district` VALUES ('1220', '134', '万年县', '0');
INSERT INTO `sys_district` VALUES ('1221', '134', '婺源县', '0');
INSERT INTO `sys_district` VALUES ('1222', '134', '德兴市', '0');
INSERT INTO `sys_district` VALUES ('1223', '135', '历下区', '0');
INSERT INTO `sys_district` VALUES ('1224', '135', '市中区', '0');
INSERT INTO `sys_district` VALUES ('1225', '135', '槐荫区', '0');
INSERT INTO `sys_district` VALUES ('1226', '135', '天桥区', '0');
INSERT INTO `sys_district` VALUES ('1227', '135', '历城区', '0');
INSERT INTO `sys_district` VALUES ('1228', '135', '长清区', '0');
INSERT INTO `sys_district` VALUES ('1229', '135', '平阴县', '0');
INSERT INTO `sys_district` VALUES ('1230', '135', '济阳县', '0');
INSERT INTO `sys_district` VALUES ('1231', '135', '商河县', '0');
INSERT INTO `sys_district` VALUES ('1232', '135', '章丘市', '0');
INSERT INTO `sys_district` VALUES ('1233', '136', '市南区', '0');
INSERT INTO `sys_district` VALUES ('1234', '136', '市北区', '0');
INSERT INTO `sys_district` VALUES ('1236', '136', '黄岛区', '0');
INSERT INTO `sys_district` VALUES ('1237', '136', '崂山区', '0');
INSERT INTO `sys_district` VALUES ('1238', '136', '李沧区', '0');
INSERT INTO `sys_district` VALUES ('1239', '136', '城阳区', '0');
INSERT INTO `sys_district` VALUES ('1240', '136', '胶州市', '0');
INSERT INTO `sys_district` VALUES ('1241', '136', '即墨市', '0');
INSERT INTO `sys_district` VALUES ('1242', '136', '平度市', '0');
INSERT INTO `sys_district` VALUES ('1244', '136', '莱西市', '0');
INSERT INTO `sys_district` VALUES ('1245', '137', '淄川区', '0');
INSERT INTO `sys_district` VALUES ('1246', '137', '张店区', '0');
INSERT INTO `sys_district` VALUES ('1247', '137', '博山区', '0');
INSERT INTO `sys_district` VALUES ('1248', '137', '临淄区', '0');
INSERT INTO `sys_district` VALUES ('1249', '137', '周村区', '0');
INSERT INTO `sys_district` VALUES ('1250', '137', '桓台县', '0');
INSERT INTO `sys_district` VALUES ('1251', '137', '高青县', '0');
INSERT INTO `sys_district` VALUES ('1252', '137', '沂源县', '0');
INSERT INTO `sys_district` VALUES ('1253', '138', '市中区', '0');
INSERT INTO `sys_district` VALUES ('1254', '138', '薛城区', '0');
INSERT INTO `sys_district` VALUES ('1255', '138', '峄城区', '0');
INSERT INTO `sys_district` VALUES ('1256', '138', '台儿庄区', '0');
INSERT INTO `sys_district` VALUES ('1257', '138', '山亭区', '0');
INSERT INTO `sys_district` VALUES ('1258', '138', '滕州市', '0');
INSERT INTO `sys_district` VALUES ('1259', '139', '东营区', '0');
INSERT INTO `sys_district` VALUES ('1260', '139', '河口区', '0');
INSERT INTO `sys_district` VALUES ('1261', '139', '垦利县', '0');
INSERT INTO `sys_district` VALUES ('1262', '139', '利津县', '0');
INSERT INTO `sys_district` VALUES ('1263', '139', '广饶县', '0');
INSERT INTO `sys_district` VALUES ('1264', '140', '芝罘区', '0');
INSERT INTO `sys_district` VALUES ('1265', '140', '福山区', '0');
INSERT INTO `sys_district` VALUES ('1266', '140', '牟平区', '0');
INSERT INTO `sys_district` VALUES ('1267', '140', '莱山区', '0');
INSERT INTO `sys_district` VALUES ('1268', '140', '长岛县', '0');
INSERT INTO `sys_district` VALUES ('1269', '140', '龙口市', '0');
INSERT INTO `sys_district` VALUES ('1270', '140', '莱阳市', '0');
INSERT INTO `sys_district` VALUES ('1271', '140', '莱州市', '0');
INSERT INTO `sys_district` VALUES ('1272', '140', '蓬莱市', '0');
INSERT INTO `sys_district` VALUES ('1273', '140', '招远市', '0');
INSERT INTO `sys_district` VALUES ('1274', '140', '栖霞市', '0');
INSERT INTO `sys_district` VALUES ('1275', '140', '海阳市', '0');
INSERT INTO `sys_district` VALUES ('1276', '141', '潍城区', '0');
INSERT INTO `sys_district` VALUES ('1277', '141', '寒亭区', '0');
INSERT INTO `sys_district` VALUES ('1278', '141', '坊子区', '0');
INSERT INTO `sys_district` VALUES ('1279', '141', '奎文区', '0');
INSERT INTO `sys_district` VALUES ('1280', '141', '临朐县', '0');
INSERT INTO `sys_district` VALUES ('1281', '141', '昌乐县', '0');
INSERT INTO `sys_district` VALUES ('1282', '141', '青州市', '0');
INSERT INTO `sys_district` VALUES ('1283', '141', '诸城市', '0');
INSERT INTO `sys_district` VALUES ('1284', '141', '寿光市', '0');
INSERT INTO `sys_district` VALUES ('1285', '141', '安丘市', '0');
INSERT INTO `sys_district` VALUES ('1286', '141', '高密市', '0');
INSERT INTO `sys_district` VALUES ('1287', '141', '昌邑市', '0');
INSERT INTO `sys_district` VALUES ('1288', '142', '市中区', '0');
INSERT INTO `sys_district` VALUES ('1289', '142', '任城区', '0');
INSERT INTO `sys_district` VALUES ('1290', '142', '微山县', '0');
INSERT INTO `sys_district` VALUES ('1291', '142', '鱼台县', '0');
INSERT INTO `sys_district` VALUES ('1292', '142', '金乡县', '0');
INSERT INTO `sys_district` VALUES ('1293', '142', '嘉祥县', '0');
INSERT INTO `sys_district` VALUES ('1294', '142', '汶上县', '0');
INSERT INTO `sys_district` VALUES ('1295', '142', '泗水县', '0');
INSERT INTO `sys_district` VALUES ('1296', '142', '梁山县', '0');
INSERT INTO `sys_district` VALUES ('1297', '142', '曲阜市', '0');
INSERT INTO `sys_district` VALUES ('1298', '142', '兖州市', '0');
INSERT INTO `sys_district` VALUES ('1299', '142', '邹城市', '0');
INSERT INTO `sys_district` VALUES ('1300', '143', '泰山区', '0');
INSERT INTO `sys_district` VALUES ('1301', '143', '岱岳区', '0');
INSERT INTO `sys_district` VALUES ('1302', '143', '宁阳县', '0');
INSERT INTO `sys_district` VALUES ('1303', '143', '东平县', '0');
INSERT INTO `sys_district` VALUES ('1304', '143', '新泰市', '0');
INSERT INTO `sys_district` VALUES ('1305', '143', '肥城市', '0');
INSERT INTO `sys_district` VALUES ('1306', '144', '环翠区', '0');
INSERT INTO `sys_district` VALUES ('1307', '144', '文登市', '0');
INSERT INTO `sys_district` VALUES ('1308', '144', '荣成市', '0');
INSERT INTO `sys_district` VALUES ('1309', '144', '乳山市', '0');
INSERT INTO `sys_district` VALUES ('1310', '145', '东港区', '0');
INSERT INTO `sys_district` VALUES ('1311', '145', '岚山区', '0');
INSERT INTO `sys_district` VALUES ('1312', '145', '五莲县', '0');
INSERT INTO `sys_district` VALUES ('1313', '145', '莒县', '0');
INSERT INTO `sys_district` VALUES ('1314', '146', '莱城区', '0');
INSERT INTO `sys_district` VALUES ('1315', '146', '钢城区', '0');
INSERT INTO `sys_district` VALUES ('1316', '147', '兰山区', '0');
INSERT INTO `sys_district` VALUES ('1317', '147', '罗庄区', '0');
INSERT INTO `sys_district` VALUES ('1318', '147', '河东区', '0');
INSERT INTO `sys_district` VALUES ('1319', '147', '沂南县', '0');
INSERT INTO `sys_district` VALUES ('1320', '147', '郯城县', '0');
INSERT INTO `sys_district` VALUES ('1321', '147', '沂水县', '0');
INSERT INTO `sys_district` VALUES ('1322', '147', '苍山县', '0');
INSERT INTO `sys_district` VALUES ('1323', '147', '费县', '0');
INSERT INTO `sys_district` VALUES ('1324', '147', '平邑县', '0');
INSERT INTO `sys_district` VALUES ('1325', '147', '莒南县', '0');
INSERT INTO `sys_district` VALUES ('1326', '147', '蒙阴县', '0');
INSERT INTO `sys_district` VALUES ('1327', '147', '临沭县', '0');
INSERT INTO `sys_district` VALUES ('1328', '148', '德城区', '0');
INSERT INTO `sys_district` VALUES ('1329', '148', '陵县', '0');
INSERT INTO `sys_district` VALUES ('1330', '148', '宁津县', '0');
INSERT INTO `sys_district` VALUES ('1331', '148', '庆云县', '0');
INSERT INTO `sys_district` VALUES ('1332', '148', '临邑县', '0');
INSERT INTO `sys_district` VALUES ('1333', '148', '齐河县', '0');
INSERT INTO `sys_district` VALUES ('1334', '148', '平原县', '0');
INSERT INTO `sys_district` VALUES ('1335', '148', '夏津县', '0');
INSERT INTO `sys_district` VALUES ('1336', '148', '武城县', '0');
INSERT INTO `sys_district` VALUES ('1337', '148', '乐陵市', '0');
INSERT INTO `sys_district` VALUES ('1338', '148', '禹城市', '0');
INSERT INTO `sys_district` VALUES ('1339', '149', '东昌府区', '0');
INSERT INTO `sys_district` VALUES ('1340', '149', '阳谷县', '0');
INSERT INTO `sys_district` VALUES ('1341', '149', '莘县', '0');
INSERT INTO `sys_district` VALUES ('1342', '149', '茌平县', '0');
INSERT INTO `sys_district` VALUES ('1343', '149', '东阿县', '0');
INSERT INTO `sys_district` VALUES ('1344', '149', '冠县', '0');
INSERT INTO `sys_district` VALUES ('1345', '149', '高唐县', '0');
INSERT INTO `sys_district` VALUES ('1346', '149', '临清市', '0');
INSERT INTO `sys_district` VALUES ('1347', '150', '滨城区', '0');
INSERT INTO `sys_district` VALUES ('1348', '150', '惠民县', '0');
INSERT INTO `sys_district` VALUES ('1349', '150', '阳信县', '0');
INSERT INTO `sys_district` VALUES ('1350', '150', '无棣县', '0');
INSERT INTO `sys_district` VALUES ('1351', '150', '沾化县', '0');
INSERT INTO `sys_district` VALUES ('1352', '150', '博兴县', '0');
INSERT INTO `sys_district` VALUES ('1353', '150', '邹平县', '0');
INSERT INTO `sys_district` VALUES ('1354', '151', '牡丹区', '0');
INSERT INTO `sys_district` VALUES ('1355', '151', '曹县', '0');
INSERT INTO `sys_district` VALUES ('1356', '151', '单县', '0');
INSERT INTO `sys_district` VALUES ('1357', '151', '成武县', '0');
INSERT INTO `sys_district` VALUES ('1358', '151', '巨野县', '0');
INSERT INTO `sys_district` VALUES ('1359', '151', '郓城县', '0');
INSERT INTO `sys_district` VALUES ('1360', '151', '鄄城县', '0');
INSERT INTO `sys_district` VALUES ('1361', '151', '定陶县', '0');
INSERT INTO `sys_district` VALUES ('1362', '151', '东明县', '0');
INSERT INTO `sys_district` VALUES ('1363', '152', '中原区', '0');
INSERT INTO `sys_district` VALUES ('1364', '152', '二七区', '0');
INSERT INTO `sys_district` VALUES ('1365', '152', '管城回族区', '0');
INSERT INTO `sys_district` VALUES ('1366', '152', '金水区', '0');
INSERT INTO `sys_district` VALUES ('1367', '152', '上街区', '0');
INSERT INTO `sys_district` VALUES ('1368', '152', '惠济区', '0');
INSERT INTO `sys_district` VALUES ('1369', '152', '中牟县', '0');
INSERT INTO `sys_district` VALUES ('1370', '152', '巩义市', '0');
INSERT INTO `sys_district` VALUES ('1371', '152', '荥阳市', '0');
INSERT INTO `sys_district` VALUES ('1372', '152', '新密市', '0');
INSERT INTO `sys_district` VALUES ('1373', '152', '新郑市', '0');
INSERT INTO `sys_district` VALUES ('1374', '152', '登封市', '0');
INSERT INTO `sys_district` VALUES ('1375', '153', '龙亭区', '0');
INSERT INTO `sys_district` VALUES ('1376', '153', '顺河回族区', '0');
INSERT INTO `sys_district` VALUES ('1377', '153', '鼓楼区', '0');
INSERT INTO `sys_district` VALUES ('1380', '153', '杞县', '0');
INSERT INTO `sys_district` VALUES ('1381', '153', '通许县', '0');
INSERT INTO `sys_district` VALUES ('1382', '153', '尉氏县', '0');
INSERT INTO `sys_district` VALUES ('1383', '153', '开封县', '0');
INSERT INTO `sys_district` VALUES ('1384', '153', '兰考县', '0');
INSERT INTO `sys_district` VALUES ('1385', '154', '老城区', '0');
INSERT INTO `sys_district` VALUES ('1386', '154', '西工区', '0');
INSERT INTO `sys_district` VALUES ('1388', '154', '涧西区', '0');
INSERT INTO `sys_district` VALUES ('1389', '154', '吉利区', '0');
INSERT INTO `sys_district` VALUES ('1390', '154', '洛龙区', '0');
INSERT INTO `sys_district` VALUES ('1391', '154', '孟津县', '0');
INSERT INTO `sys_district` VALUES ('1392', '154', '新安县', '0');
INSERT INTO `sys_district` VALUES ('1393', '154', '栾川县', '0');
INSERT INTO `sys_district` VALUES ('1394', '154', '嵩县', '0');
INSERT INTO `sys_district` VALUES ('1395', '154', '汝阳县', '0');
INSERT INTO `sys_district` VALUES ('1396', '154', '宜阳县', '0');
INSERT INTO `sys_district` VALUES ('1397', '154', '洛宁县', '0');
INSERT INTO `sys_district` VALUES ('1398', '154', '伊川县', '0');
INSERT INTO `sys_district` VALUES ('1399', '154', '偃师市', '0');
INSERT INTO `sys_district` VALUES ('1400', '155', '新华区', '0');
INSERT INTO `sys_district` VALUES ('1401', '155', '卫东区', '0');
INSERT INTO `sys_district` VALUES ('1402', '155', '石龙区', '0');
INSERT INTO `sys_district` VALUES ('1403', '155', '湛河区', '0');
INSERT INTO `sys_district` VALUES ('1404', '155', '宝丰县', '0');
INSERT INTO `sys_district` VALUES ('1405', '155', '叶县', '0');
INSERT INTO `sys_district` VALUES ('1406', '155', '鲁山县', '0');
INSERT INTO `sys_district` VALUES ('1407', '155', '郏县', '0');
INSERT INTO `sys_district` VALUES ('1408', '155', '舞钢市', '0');
INSERT INTO `sys_district` VALUES ('1409', '155', '汝州市', '0');
INSERT INTO `sys_district` VALUES ('1410', '156', '文峰区', '0');
INSERT INTO `sys_district` VALUES ('1411', '156', '北关区', '0');
INSERT INTO `sys_district` VALUES ('1412', '156', '殷都区', '0');
INSERT INTO `sys_district` VALUES ('1413', '156', '龙安区', '0');
INSERT INTO `sys_district` VALUES ('1414', '156', '安阳县', '0');
INSERT INTO `sys_district` VALUES ('1415', '156', '汤阴县', '0');
INSERT INTO `sys_district` VALUES ('1416', '156', '滑县', '0');
INSERT INTO `sys_district` VALUES ('1417', '156', '内黄县', '0');
INSERT INTO `sys_district` VALUES ('1418', '156', '林州市', '0');
INSERT INTO `sys_district` VALUES ('1419', '157', '鹤山区', '0');
INSERT INTO `sys_district` VALUES ('1420', '157', '山城区', '0');
INSERT INTO `sys_district` VALUES ('1421', '157', '淇滨区', '0');
INSERT INTO `sys_district` VALUES ('1422', '157', '浚县', '0');
INSERT INTO `sys_district` VALUES ('1423', '157', '淇县', '0');
INSERT INTO `sys_district` VALUES ('1424', '158', '红旗区', '0');
INSERT INTO `sys_district` VALUES ('1425', '158', '卫滨区', '0');
INSERT INTO `sys_district` VALUES ('1426', '158', '凤泉区', '0');
INSERT INTO `sys_district` VALUES ('1427', '158', '牧野区', '0');
INSERT INTO `sys_district` VALUES ('1428', '158', '新乡县', '0');
INSERT INTO `sys_district` VALUES ('1429', '158', '获嘉县', '0');
INSERT INTO `sys_district` VALUES ('1430', '158', '原阳县', '0');
INSERT INTO `sys_district` VALUES ('1431', '158', '延津县', '0');
INSERT INTO `sys_district` VALUES ('1432', '158', '封丘县', '0');
INSERT INTO `sys_district` VALUES ('1433', '158', '长垣县', '0');
INSERT INTO `sys_district` VALUES ('1434', '158', '卫辉市', '0');
INSERT INTO `sys_district` VALUES ('1435', '158', '辉县市', '0');
INSERT INTO `sys_district` VALUES ('1436', '159', '解放区', '0');
INSERT INTO `sys_district` VALUES ('1437', '159', '中站区', '0');
INSERT INTO `sys_district` VALUES ('1438', '159', '马村区', '0');
INSERT INTO `sys_district` VALUES ('1439', '159', '山阳区', '0');
INSERT INTO `sys_district` VALUES ('1440', '159', '修武县', '0');
INSERT INTO `sys_district` VALUES ('1441', '159', '博爱县', '0');
INSERT INTO `sys_district` VALUES ('1442', '159', '武陟县', '0');
INSERT INTO `sys_district` VALUES ('1443', '159', '温县', '0');
INSERT INTO `sys_district` VALUES ('1445', '159', '沁阳市', '0');
INSERT INTO `sys_district` VALUES ('1446', '159', '孟州市', '0');
INSERT INTO `sys_district` VALUES ('1447', '160', '华龙区', '0');
INSERT INTO `sys_district` VALUES ('1448', '160', '清丰县', '0');
INSERT INTO `sys_district` VALUES ('1449', '160', '南乐县', '0');
INSERT INTO `sys_district` VALUES ('1450', '160', '范县', '0');
INSERT INTO `sys_district` VALUES ('1451', '160', '台前县', '0');
INSERT INTO `sys_district` VALUES ('1452', '160', '濮阳县', '0');
INSERT INTO `sys_district` VALUES ('1453', '161', '魏都区', '0');
INSERT INTO `sys_district` VALUES ('1454', '161', '许昌县', '0');
INSERT INTO `sys_district` VALUES ('1455', '161', '鄢陵县', '0');
INSERT INTO `sys_district` VALUES ('1456', '161', '襄城县', '0');
INSERT INTO `sys_district` VALUES ('1457', '161', '禹州市', '0');
INSERT INTO `sys_district` VALUES ('1458', '161', '长葛市', '0');
INSERT INTO `sys_district` VALUES ('1459', '162', '源汇区', '0');
INSERT INTO `sys_district` VALUES ('1460', '162', '郾城区', '0');
INSERT INTO `sys_district` VALUES ('1461', '162', '召陵区', '0');
INSERT INTO `sys_district` VALUES ('1462', '162', '舞阳县', '0');
INSERT INTO `sys_district` VALUES ('1463', '162', '临颍县', '0');
INSERT INTO `sys_district` VALUES ('1465', '163', '湖滨区', '0');
INSERT INTO `sys_district` VALUES ('1466', '163', '渑池县', '0');
INSERT INTO `sys_district` VALUES ('1467', '163', '陕县', '0');
INSERT INTO `sys_district` VALUES ('1468', '163', '卢氏县', '0');
INSERT INTO `sys_district` VALUES ('1469', '163', '义马市', '0');
INSERT INTO `sys_district` VALUES ('1470', '163', '灵宝市', '0');
INSERT INTO `sys_district` VALUES ('1471', '164', '宛城区', '0');
INSERT INTO `sys_district` VALUES ('1472', '164', '卧龙区', '0');
INSERT INTO `sys_district` VALUES ('1473', '164', '南召县', '0');
INSERT INTO `sys_district` VALUES ('1474', '164', '方城县', '0');
INSERT INTO `sys_district` VALUES ('1475', '164', '西峡县', '0');
INSERT INTO `sys_district` VALUES ('1476', '164', '镇平县', '0');
INSERT INTO `sys_district` VALUES ('1477', '164', '内乡县', '0');
INSERT INTO `sys_district` VALUES ('1478', '164', '淅川县', '0');
INSERT INTO `sys_district` VALUES ('1479', '164', '社旗县', '0');
INSERT INTO `sys_district` VALUES ('1480', '164', '唐河县', '0');
INSERT INTO `sys_district` VALUES ('1481', '164', '新野县', '0');
INSERT INTO `sys_district` VALUES ('1482', '164', '桐柏县', '0');
INSERT INTO `sys_district` VALUES ('1483', '164', '邓州市', '0');
INSERT INTO `sys_district` VALUES ('1484', '165', '梁园区', '0');
INSERT INTO `sys_district` VALUES ('1485', '165', '睢阳区', '0');
INSERT INTO `sys_district` VALUES ('1486', '165', '民权县', '0');
INSERT INTO `sys_district` VALUES ('1487', '165', '睢县', '0');
INSERT INTO `sys_district` VALUES ('1488', '165', '宁陵县', '0');
INSERT INTO `sys_district` VALUES ('1489', '165', '柘城县', '0');
INSERT INTO `sys_district` VALUES ('1490', '165', '虞城县', '0');
INSERT INTO `sys_district` VALUES ('1491', '165', '夏邑县', '0');
INSERT INTO `sys_district` VALUES ('1492', '165', '永城市', '0');
INSERT INTO `sys_district` VALUES ('1493', '166', '浉河区', '0');
INSERT INTO `sys_district` VALUES ('1494', '166', '平桥区', '0');
INSERT INTO `sys_district` VALUES ('1495', '166', '罗山县', '0');
INSERT INTO `sys_district` VALUES ('1496', '166', '光山县', '0');
INSERT INTO `sys_district` VALUES ('1497', '166', '新县', '0');
INSERT INTO `sys_district` VALUES ('1498', '166', '商城县', '0');
INSERT INTO `sys_district` VALUES ('1499', '166', '固始县', '0');
INSERT INTO `sys_district` VALUES ('1500', '166', '潢川县', '0');
INSERT INTO `sys_district` VALUES ('1501', '166', '淮滨县', '0');
INSERT INTO `sys_district` VALUES ('1502', '166', '息县', '0');
INSERT INTO `sys_district` VALUES ('1503', '167', '川汇区', '0');
INSERT INTO `sys_district` VALUES ('1504', '167', '扶沟县', '0');
INSERT INTO `sys_district` VALUES ('1505', '167', '西华县', '0');
INSERT INTO `sys_district` VALUES ('1506', '167', '商水县', '0');
INSERT INTO `sys_district` VALUES ('1507', '167', '沈丘县', '0');
INSERT INTO `sys_district` VALUES ('1508', '167', '郸城县', '0');
INSERT INTO `sys_district` VALUES ('1509', '167', '淮阳县', '0');
INSERT INTO `sys_district` VALUES ('1510', '167', '太康县', '0');
INSERT INTO `sys_district` VALUES ('1511', '167', '鹿邑县', '0');
INSERT INTO `sys_district` VALUES ('1512', '167', '项城市', '0');
INSERT INTO `sys_district` VALUES ('1513', '168', '驿城区', '0');
INSERT INTO `sys_district` VALUES ('1514', '168', '西平县', '0');
INSERT INTO `sys_district` VALUES ('1515', '168', '上蔡县', '0');
INSERT INTO `sys_district` VALUES ('1516', '168', '平舆县', '0');
INSERT INTO `sys_district` VALUES ('1517', '168', '正阳县', '0');
INSERT INTO `sys_district` VALUES ('1518', '168', '确山县', '0');
INSERT INTO `sys_district` VALUES ('1519', '168', '泌阳县', '0');
INSERT INTO `sys_district` VALUES ('1520', '168', '汝南县', '0');
INSERT INTO `sys_district` VALUES ('1521', '168', '遂平县', '0');
INSERT INTO `sys_district` VALUES ('1522', '168', '新蔡县', '0');
INSERT INTO `sys_district` VALUES ('1523', '169', '江岸区', '0');
INSERT INTO `sys_district` VALUES ('1524', '169', '江汉区', '0');
INSERT INTO `sys_district` VALUES ('1525', '169', '硚口区', '0');
INSERT INTO `sys_district` VALUES ('1526', '169', '汉阳区', '0');
INSERT INTO `sys_district` VALUES ('1527', '169', '武昌区', '0');
INSERT INTO `sys_district` VALUES ('1528', '169', '青山区', '0');
INSERT INTO `sys_district` VALUES ('1529', '169', '洪山区', '0');
INSERT INTO `sys_district` VALUES ('1530', '169', '东西湖区', '0');
INSERT INTO `sys_district` VALUES ('1531', '169', '汉南区', '0');
INSERT INTO `sys_district` VALUES ('1532', '169', '蔡甸区', '0');
INSERT INTO `sys_district` VALUES ('1533', '169', '江夏区', '0');
INSERT INTO `sys_district` VALUES ('1534', '169', '黄陂区', '0');
INSERT INTO `sys_district` VALUES ('1535', '169', '新洲区', '0');
INSERT INTO `sys_district` VALUES ('1536', '170', '黄石港区', '0');
INSERT INTO `sys_district` VALUES ('1537', '170', '西塞山区', '0');
INSERT INTO `sys_district` VALUES ('1538', '170', '下陆区', '0');
INSERT INTO `sys_district` VALUES ('1539', '170', '铁山区', '0');
INSERT INTO `sys_district` VALUES ('1540', '170', '阳新县', '0');
INSERT INTO `sys_district` VALUES ('1541', '170', '大冶市', '0');
INSERT INTO `sys_district` VALUES ('1542', '171', '茅箭区', '0');
INSERT INTO `sys_district` VALUES ('1543', '171', '张湾区', '0');
INSERT INTO `sys_district` VALUES ('1544', '171', '郧县', '0');
INSERT INTO `sys_district` VALUES ('1545', '171', '郧西县', '0');
INSERT INTO `sys_district` VALUES ('1546', '171', '竹山县', '0');
INSERT INTO `sys_district` VALUES ('1547', '171', '竹溪县', '0');
INSERT INTO `sys_district` VALUES ('1548', '171', '房县', '0');
INSERT INTO `sys_district` VALUES ('1549', '171', '丹江口市', '0');
INSERT INTO `sys_district` VALUES ('1550', '172', '西陵区', '0');
INSERT INTO `sys_district` VALUES ('1551', '172', '伍家岗区', '0');
INSERT INTO `sys_district` VALUES ('1552', '172', '点军区', '0');
INSERT INTO `sys_district` VALUES ('1553', '172', '猇亭区', '0');
INSERT INTO `sys_district` VALUES ('1554', '172', '夷陵区', '0');
INSERT INTO `sys_district` VALUES ('1555', '172', '远安县', '0');
INSERT INTO `sys_district` VALUES ('1556', '172', '兴山县', '0');
INSERT INTO `sys_district` VALUES ('1557', '172', '秭归县', '0');
INSERT INTO `sys_district` VALUES ('1558', '172', '长阳土家族自治县', '0');
INSERT INTO `sys_district` VALUES ('1559', '172', '五峰土家族自治县', '0');
INSERT INTO `sys_district` VALUES ('1560', '172', '宜都市', '0');
INSERT INTO `sys_district` VALUES ('1561', '172', '当阳市', '0');
INSERT INTO `sys_district` VALUES ('1562', '172', '枝江市', '0');
INSERT INTO `sys_district` VALUES ('1563', '173', '襄城区', '0');
INSERT INTO `sys_district` VALUES ('1564', '173', '樊城区', '0');
INSERT INTO `sys_district` VALUES ('1566', '173', '南漳县', '0');
INSERT INTO `sys_district` VALUES ('1567', '173', '谷城县', '0');
INSERT INTO `sys_district` VALUES ('1568', '173', '保康县', '0');
INSERT INTO `sys_district` VALUES ('1569', '173', '老河口市', '0');
INSERT INTO `sys_district` VALUES ('1570', '173', '枣阳市', '0');
INSERT INTO `sys_district` VALUES ('1571', '173', '宜城市', '0');
INSERT INTO `sys_district` VALUES ('1572', '174', '梁子湖区', '0');
INSERT INTO `sys_district` VALUES ('1573', '174', '华容区', '0');
INSERT INTO `sys_district` VALUES ('1574', '174', '鄂城区', '0');
INSERT INTO `sys_district` VALUES ('1575', '175', '东宝区', '0');
INSERT INTO `sys_district` VALUES ('1576', '175', '掇刀区', '0');
INSERT INTO `sys_district` VALUES ('1577', '175', '京山县', '0');
INSERT INTO `sys_district` VALUES ('1578', '175', '沙洋县', '0');
INSERT INTO `sys_district` VALUES ('1579', '175', '钟祥市', '0');
INSERT INTO `sys_district` VALUES ('1580', '176', '孝南区', '0');
INSERT INTO `sys_district` VALUES ('1581', '176', '孝昌县', '0');
INSERT INTO `sys_district` VALUES ('1582', '176', '大悟县', '0');
INSERT INTO `sys_district` VALUES ('1583', '176', '云梦县', '0');
INSERT INTO `sys_district` VALUES ('1584', '176', '应城市', '0');
INSERT INTO `sys_district` VALUES ('1585', '176', '安陆市', '0');
INSERT INTO `sys_district` VALUES ('1586', '176', '汉川市', '0');
INSERT INTO `sys_district` VALUES ('1587', '177', '沙市区', '0');
INSERT INTO `sys_district` VALUES ('1588', '177', '荆州区', '0');
INSERT INTO `sys_district` VALUES ('1589', '177', '公安县', '0');
INSERT INTO `sys_district` VALUES ('1590', '177', '监利县', '0');
INSERT INTO `sys_district` VALUES ('1591', '177', '江陵县', '0');
INSERT INTO `sys_district` VALUES ('1592', '177', '石首市', '0');
INSERT INTO `sys_district` VALUES ('1593', '177', '洪湖市', '0');
INSERT INTO `sys_district` VALUES ('1594', '177', '松滋市', '0');
INSERT INTO `sys_district` VALUES ('1595', '178', '黄州区', '0');
INSERT INTO `sys_district` VALUES ('1596', '178', '团风县', '0');
INSERT INTO `sys_district` VALUES ('1597', '178', '红安县', '0');
INSERT INTO `sys_district` VALUES ('1598', '178', '罗田县', '0');
INSERT INTO `sys_district` VALUES ('1599', '178', '英山县', '0');
INSERT INTO `sys_district` VALUES ('1600', '178', '浠水县', '0');
INSERT INTO `sys_district` VALUES ('1601', '178', '蕲春县', '0');
INSERT INTO `sys_district` VALUES ('1602', '178', '黄梅县', '0');
INSERT INTO `sys_district` VALUES ('1603', '178', '麻城市', '0');
INSERT INTO `sys_district` VALUES ('1604', '178', '武穴市', '0');
INSERT INTO `sys_district` VALUES ('1605', '179', '咸安区', '0');
INSERT INTO `sys_district` VALUES ('1606', '179', '嘉鱼县', '0');
INSERT INTO `sys_district` VALUES ('1607', '179', '通城县', '0');
INSERT INTO `sys_district` VALUES ('1608', '179', '崇阳县', '0');
INSERT INTO `sys_district` VALUES ('1609', '179', '通山县', '0');
INSERT INTO `sys_district` VALUES ('1610', '179', '赤壁市', '0');
INSERT INTO `sys_district` VALUES ('1611', '180', '曾都区', '0');
INSERT INTO `sys_district` VALUES ('1612', '180', '广水市', '0');
INSERT INTO `sys_district` VALUES ('1613', '181', '恩施市', '0');
INSERT INTO `sys_district` VALUES ('1614', '181', '利川市', '0');
INSERT INTO `sys_district` VALUES ('1615', '181', '建始县', '0');
INSERT INTO `sys_district` VALUES ('1616', '181', '巴东县', '0');
INSERT INTO `sys_district` VALUES ('1617', '181', '宣恩县', '0');
INSERT INTO `sys_district` VALUES ('1618', '181', '咸丰县', '0');
INSERT INTO `sys_district` VALUES ('1619', '181', '来凤县', '0');
INSERT INTO `sys_district` VALUES ('1620', '181', '鹤峰县', '0');
INSERT INTO `sys_district` VALUES ('1625', '183', '芙蓉区', '0');
INSERT INTO `sys_district` VALUES ('1626', '183', '天心区', '0');
INSERT INTO `sys_district` VALUES ('1627', '183', '岳麓区', '0');
INSERT INTO `sys_district` VALUES ('1628', '183', '开福区', '0');
INSERT INTO `sys_district` VALUES ('1629', '183', '雨花区', '0');
INSERT INTO `sys_district` VALUES ('1630', '183', '长沙县', '0');
INSERT INTO `sys_district` VALUES ('1632', '183', '宁乡县', '0');
INSERT INTO `sys_district` VALUES ('1633', '183', '浏阳市', '0');
INSERT INTO `sys_district` VALUES ('1634', '184', '荷塘区', '0');
INSERT INTO `sys_district` VALUES ('1635', '184', '芦淞区', '0');
INSERT INTO `sys_district` VALUES ('1636', '184', '石峰区', '0');
INSERT INTO `sys_district` VALUES ('1637', '184', '天元区', '0');
INSERT INTO `sys_district` VALUES ('1638', '184', '株洲县', '0');
INSERT INTO `sys_district` VALUES ('1639', '184', '攸县', '0');
INSERT INTO `sys_district` VALUES ('1640', '184', '茶陵县', '0');
INSERT INTO `sys_district` VALUES ('1641', '184', '炎陵县', '0');
INSERT INTO `sys_district` VALUES ('1642', '184', '醴陵市', '0');
INSERT INTO `sys_district` VALUES ('1643', '185', '雨湖区', '0');
INSERT INTO `sys_district` VALUES ('1644', '185', '岳塘区', '0');
INSERT INTO `sys_district` VALUES ('1645', '185', '湘潭县', '0');
INSERT INTO `sys_district` VALUES ('1646', '185', '湘乡市', '0');
INSERT INTO `sys_district` VALUES ('1647', '185', '韶山市', '0');
INSERT INTO `sys_district` VALUES ('1648', '186', '珠晖区', '0');
INSERT INTO `sys_district` VALUES ('1649', '186', '雁峰区', '0');
INSERT INTO `sys_district` VALUES ('1650', '186', '石鼓区', '0');
INSERT INTO `sys_district` VALUES ('1651', '186', '蒸湘区', '0');
INSERT INTO `sys_district` VALUES ('1652', '186', '南岳区', '0');
INSERT INTO `sys_district` VALUES ('1653', '186', '衡阳县', '0');
INSERT INTO `sys_district` VALUES ('1654', '186', '衡南县', '0');
INSERT INTO `sys_district` VALUES ('1655', '186', '衡山县', '0');
INSERT INTO `sys_district` VALUES ('1656', '186', '衡东县', '0');
INSERT INTO `sys_district` VALUES ('1657', '186', '祁东县', '0');
INSERT INTO `sys_district` VALUES ('1658', '186', '耒阳市', '0');
INSERT INTO `sys_district` VALUES ('1659', '186', '常宁市', '0');
INSERT INTO `sys_district` VALUES ('1660', '187', '双清区', '0');
INSERT INTO `sys_district` VALUES ('1661', '187', '大祥区', '0');
INSERT INTO `sys_district` VALUES ('1662', '187', '北塔区', '0');
INSERT INTO `sys_district` VALUES ('1663', '187', '邵东县', '0');
INSERT INTO `sys_district` VALUES ('1664', '187', '新邵县', '0');
INSERT INTO `sys_district` VALUES ('1665', '187', '邵阳县', '0');
INSERT INTO `sys_district` VALUES ('1666', '187', '隆回县', '0');
INSERT INTO `sys_district` VALUES ('1667', '187', '洞口县', '0');
INSERT INTO `sys_district` VALUES ('1668', '187', '绥宁县', '0');
INSERT INTO `sys_district` VALUES ('1669', '187', '新宁县', '0');
INSERT INTO `sys_district` VALUES ('1670', '187', '城步苗族自治县', '0');
INSERT INTO `sys_district` VALUES ('1671', '187', '武冈市', '0');
INSERT INTO `sys_district` VALUES ('1672', '188', '岳阳楼区', '0');
INSERT INTO `sys_district` VALUES ('1673', '188', '云溪区', '0');
INSERT INTO `sys_district` VALUES ('1674', '188', '君山区', '0');
INSERT INTO `sys_district` VALUES ('1675', '188', '岳阳县', '0');
INSERT INTO `sys_district` VALUES ('1676', '188', '华容县', '0');
INSERT INTO `sys_district` VALUES ('1677', '188', '湘阴县', '0');
INSERT INTO `sys_district` VALUES ('1678', '188', '平江县', '0');
INSERT INTO `sys_district` VALUES ('1679', '188', '汨罗市', '0');
INSERT INTO `sys_district` VALUES ('1680', '188', '临湘市', '0');
INSERT INTO `sys_district` VALUES ('1681', '189', '武陵区', '0');
INSERT INTO `sys_district` VALUES ('1682', '189', '鼎城区', '0');
INSERT INTO `sys_district` VALUES ('1683', '189', '安乡县', '0');
INSERT INTO `sys_district` VALUES ('1684', '189', '汉寿县', '0');
INSERT INTO `sys_district` VALUES ('1685', '189', '澧县', '0');
INSERT INTO `sys_district` VALUES ('1686', '189', '临澧县', '0');
INSERT INTO `sys_district` VALUES ('1687', '189', '桃源县', '0');
INSERT INTO `sys_district` VALUES ('1688', '189', '石门县', '0');
INSERT INTO `sys_district` VALUES ('1689', '189', '津市市', '0');
INSERT INTO `sys_district` VALUES ('1690', '190', '永定区', '0');
INSERT INTO `sys_district` VALUES ('1691', '190', '武陵源区', '0');
INSERT INTO `sys_district` VALUES ('1692', '190', '慈利县', '0');
INSERT INTO `sys_district` VALUES ('1693', '190', '桑植县', '0');
INSERT INTO `sys_district` VALUES ('1694', '191', '资阳区', '0');
INSERT INTO `sys_district` VALUES ('1695', '191', '赫山区', '0');
INSERT INTO `sys_district` VALUES ('1696', '191', '南县', '0');
INSERT INTO `sys_district` VALUES ('1697', '191', '桃江县', '0');
INSERT INTO `sys_district` VALUES ('1698', '191', '安化县', '0');
INSERT INTO `sys_district` VALUES ('1699', '191', '沅江市', '0');
INSERT INTO `sys_district` VALUES ('1700', '192', '北湖区', '0');
INSERT INTO `sys_district` VALUES ('1701', '192', '苏仙区', '0');
INSERT INTO `sys_district` VALUES ('1702', '192', '桂阳县', '0');
INSERT INTO `sys_district` VALUES ('1703', '192', '宜章县', '0');
INSERT INTO `sys_district` VALUES ('1704', '192', '永兴县', '0');
INSERT INTO `sys_district` VALUES ('1705', '192', '嘉禾县', '0');
INSERT INTO `sys_district` VALUES ('1706', '192', '临武县', '0');
INSERT INTO `sys_district` VALUES ('1707', '192', '汝城县', '0');
INSERT INTO `sys_district` VALUES ('1708', '192', '桂东县', '0');
INSERT INTO `sys_district` VALUES ('1709', '192', '安仁县', '0');
INSERT INTO `sys_district` VALUES ('1710', '192', '资兴市', '0');
INSERT INTO `sys_district` VALUES ('1712', '193', '冷水滩区', '0');
INSERT INTO `sys_district` VALUES ('1713', '193', '祁阳县', '0');
INSERT INTO `sys_district` VALUES ('1714', '193', '东安县', '0');
INSERT INTO `sys_district` VALUES ('1715', '193', '双牌县', '0');
INSERT INTO `sys_district` VALUES ('1716', '193', '道县', '0');
INSERT INTO `sys_district` VALUES ('1717', '193', '江永县', '0');
INSERT INTO `sys_district` VALUES ('1718', '193', '宁远县', '0');
INSERT INTO `sys_district` VALUES ('1719', '193', '蓝山县', '0');
INSERT INTO `sys_district` VALUES ('1720', '193', '新田县', '0');
INSERT INTO `sys_district` VALUES ('1721', '193', '江华瑶族自治县', '0');
INSERT INTO `sys_district` VALUES ('1722', '194', '鹤城区', '0');
INSERT INTO `sys_district` VALUES ('1723', '194', '中方县', '0');
INSERT INTO `sys_district` VALUES ('1724', '194', '沅陵县', '0');
INSERT INTO `sys_district` VALUES ('1725', '194', '辰溪县', '0');
INSERT INTO `sys_district` VALUES ('1726', '194', '溆浦县', '0');
INSERT INTO `sys_district` VALUES ('1727', '194', '会同县', '0');
INSERT INTO `sys_district` VALUES ('1728', '194', '麻阳苗族自治县', '0');
INSERT INTO `sys_district` VALUES ('1729', '194', '新晃侗族自治县', '0');
INSERT INTO `sys_district` VALUES ('1730', '194', '芷江侗族自治县', '0');
INSERT INTO `sys_district` VALUES ('1731', '194', '靖州苗族侗族自治县', '0');
INSERT INTO `sys_district` VALUES ('1732', '194', '通道侗族自治县', '0');
INSERT INTO `sys_district` VALUES ('1733', '194', '洪江市', '0');
INSERT INTO `sys_district` VALUES ('1734', '195', '娄星区', '0');
INSERT INTO `sys_district` VALUES ('1735', '195', '双峰县', '0');
INSERT INTO `sys_district` VALUES ('1736', '195', '新化县', '0');
INSERT INTO `sys_district` VALUES ('1737', '195', '冷水江市', '0');
INSERT INTO `sys_district` VALUES ('1738', '195', '涟源市', '0');
INSERT INTO `sys_district` VALUES ('1739', '196', '吉首市', '0');
INSERT INTO `sys_district` VALUES ('1740', '196', '泸溪县', '0');
INSERT INTO `sys_district` VALUES ('1741', '196', '凤凰县', '0');
INSERT INTO `sys_district` VALUES ('1742', '196', '花垣县', '0');
INSERT INTO `sys_district` VALUES ('1743', '196', '保靖县', '0');
INSERT INTO `sys_district` VALUES ('1744', '196', '古丈县', '0');
INSERT INTO `sys_district` VALUES ('1745', '196', '永顺县', '0');
INSERT INTO `sys_district` VALUES ('1746', '196', '龙山县', '0');
INSERT INTO `sys_district` VALUES ('1748', '197', '荔湾区', '0');
INSERT INTO `sys_district` VALUES ('1749', '197', '越秀区', '0');
INSERT INTO `sys_district` VALUES ('1750', '197', '海珠区', '0');
INSERT INTO `sys_district` VALUES ('1751', '197', '天河区', '0');
INSERT INTO `sys_district` VALUES ('1753', '197', '白云区', '0');
INSERT INTO `sys_district` VALUES ('1754', '197', '黄埔区', '0');
INSERT INTO `sys_district` VALUES ('1755', '197', '番禺区', '0');
INSERT INTO `sys_district` VALUES ('1756', '197', '花都区', '0');
INSERT INTO `sys_district` VALUES ('1757', '197', '增城市', '0');
INSERT INTO `sys_district` VALUES ('1759', '198', '武江区', '0');
INSERT INTO `sys_district` VALUES ('1760', '198', '浈江区', '0');
INSERT INTO `sys_district` VALUES ('1761', '198', '曲江区', '0');
INSERT INTO `sys_district` VALUES ('1762', '198', '始兴县', '0');
INSERT INTO `sys_district` VALUES ('1763', '198', '仁化县', '0');
INSERT INTO `sys_district` VALUES ('1764', '198', '翁源县', '0');
INSERT INTO `sys_district` VALUES ('1765', '198', '乳源瑶族自治县', '0');
INSERT INTO `sys_district` VALUES ('1766', '198', '新丰县', '0');
INSERT INTO `sys_district` VALUES ('1767', '198', '乐昌市', '0');
INSERT INTO `sys_district` VALUES ('1768', '198', '南雄市', '0');
INSERT INTO `sys_district` VALUES ('1769', '199', '罗湖区', '0');
INSERT INTO `sys_district` VALUES ('1770', '199', '福田区', '0');
INSERT INTO `sys_district` VALUES ('1771', '199', '南山区', '0');
INSERT INTO `sys_district` VALUES ('1772', '199', '宝安区', '0');
INSERT INTO `sys_district` VALUES ('1773', '199', '龙岗区', '0');
INSERT INTO `sys_district` VALUES ('1774', '199', '盐田区', '0');
INSERT INTO `sys_district` VALUES ('1775', '200', '香洲区', '0');
INSERT INTO `sys_district` VALUES ('1776', '200', '斗门区', '0');
INSERT INTO `sys_district` VALUES ('1777', '200', '金湾区', '0');
INSERT INTO `sys_district` VALUES ('1778', '201', '龙湖区', '0');
INSERT INTO `sys_district` VALUES ('1779', '201', '金平区', '0');
INSERT INTO `sys_district` VALUES ('1780', '201', '濠江区', '0');
INSERT INTO `sys_district` VALUES ('1781', '201', '潮阳区', '0');
INSERT INTO `sys_district` VALUES ('1782', '201', '潮南区', '0');
INSERT INTO `sys_district` VALUES ('1783', '201', '澄海区', '0');
INSERT INTO `sys_district` VALUES ('1784', '201', '南澳县', '0');
INSERT INTO `sys_district` VALUES ('1785', '202', '禅城区', '0');
INSERT INTO `sys_district` VALUES ('1786', '202', '南海区', '0');
INSERT INTO `sys_district` VALUES ('1787', '202', '顺德区', '0');
INSERT INTO `sys_district` VALUES ('1788', '202', '三水区', '0');
INSERT INTO `sys_district` VALUES ('1789', '202', '高明区', '0');
INSERT INTO `sys_district` VALUES ('1790', '203', '蓬江区', '0');
INSERT INTO `sys_district` VALUES ('1791', '203', '江海区', '0');
INSERT INTO `sys_district` VALUES ('1792', '203', '新会区', '0');
INSERT INTO `sys_district` VALUES ('1793', '203', '台山市', '0');
INSERT INTO `sys_district` VALUES ('1794', '203', '开平市', '0');
INSERT INTO `sys_district` VALUES ('1795', '203', '鹤山市', '0');
INSERT INTO `sys_district` VALUES ('1796', '203', '恩平市', '0');
INSERT INTO `sys_district` VALUES ('1797', '204', '赤坎区', '0');
INSERT INTO `sys_district` VALUES ('1798', '204', '霞山区', '0');
INSERT INTO `sys_district` VALUES ('1799', '204', '坡头区', '0');
INSERT INTO `sys_district` VALUES ('1800', '204', '麻章区', '0');
INSERT INTO `sys_district` VALUES ('1801', '204', '遂溪县', '0');
INSERT INTO `sys_district` VALUES ('1802', '204', '徐闻县', '0');
INSERT INTO `sys_district` VALUES ('1803', '204', '廉江市', '0');
INSERT INTO `sys_district` VALUES ('1804', '204', '雷州市', '0');
INSERT INTO `sys_district` VALUES ('1805', '204', '吴川市', '0');
INSERT INTO `sys_district` VALUES ('1806', '205', '茂南区', '0');
INSERT INTO `sys_district` VALUES ('1807', '205', '茂港区', '0');
INSERT INTO `sys_district` VALUES ('1808', '205', '电白县', '0');
INSERT INTO `sys_district` VALUES ('1809', '205', '高州市', '0');
INSERT INTO `sys_district` VALUES ('1810', '205', '化州市', '0');
INSERT INTO `sys_district` VALUES ('1811', '205', '信宜市', '0');
INSERT INTO `sys_district` VALUES ('1812', '206', '端州区', '0');
INSERT INTO `sys_district` VALUES ('1813', '206', '鼎湖区', '0');
INSERT INTO `sys_district` VALUES ('1814', '206', '广宁县', '0');
INSERT INTO `sys_district` VALUES ('1815', '206', '怀集县', '0');
INSERT INTO `sys_district` VALUES ('1816', '206', '封开县', '0');
INSERT INTO `sys_district` VALUES ('1817', '206', '德庆县', '0');
INSERT INTO `sys_district` VALUES ('1818', '206', '高要市', '0');
INSERT INTO `sys_district` VALUES ('1819', '206', '四会市', '0');
INSERT INTO `sys_district` VALUES ('1820', '207', '惠城区', '0');
INSERT INTO `sys_district` VALUES ('1821', '207', '惠阳区', '0');
INSERT INTO `sys_district` VALUES ('1822', '207', '博罗县', '0');
INSERT INTO `sys_district` VALUES ('1823', '207', '惠东县', '0');
INSERT INTO `sys_district` VALUES ('1824', '207', '龙门县', '0');
INSERT INTO `sys_district` VALUES ('1825', '208', '梅江区', '0');
INSERT INTO `sys_district` VALUES ('1826', '208', '梅县', '0');
INSERT INTO `sys_district` VALUES ('1827', '208', '大埔县', '0');
INSERT INTO `sys_district` VALUES ('1828', '208', '丰顺县', '0');
INSERT INTO `sys_district` VALUES ('1829', '208', '五华县', '0');
INSERT INTO `sys_district` VALUES ('1830', '208', '平远县', '0');
INSERT INTO `sys_district` VALUES ('1831', '208', '蕉岭县', '0');
INSERT INTO `sys_district` VALUES ('1832', '208', '兴宁市', '0');
INSERT INTO `sys_district` VALUES ('1833', '209', '城区', '0');
INSERT INTO `sys_district` VALUES ('1834', '209', '海丰县', '0');
INSERT INTO `sys_district` VALUES ('1835', '209', '陆河县', '0');
INSERT INTO `sys_district` VALUES ('1836', '209', '陆丰市', '0');
INSERT INTO `sys_district` VALUES ('1837', '210', '源城区', '0');
INSERT INTO `sys_district` VALUES ('1838', '210', '紫金县', '0');
INSERT INTO `sys_district` VALUES ('1839', '210', '龙川县', '0');
INSERT INTO `sys_district` VALUES ('1840', '210', '连平县', '0');
INSERT INTO `sys_district` VALUES ('1841', '210', '和平县', '0');
INSERT INTO `sys_district` VALUES ('1842', '210', '东源县', '0');
INSERT INTO `sys_district` VALUES ('1843', '211', '江城区', '0');
INSERT INTO `sys_district` VALUES ('1844', '211', '阳西县', '0');
INSERT INTO `sys_district` VALUES ('1845', '211', '阳东县', '0');
INSERT INTO `sys_district` VALUES ('1846', '211', '阳春市', '0');
INSERT INTO `sys_district` VALUES ('1847', '212', '清城区', '0');
INSERT INTO `sys_district` VALUES ('1848', '212', '佛冈县', '0');
INSERT INTO `sys_district` VALUES ('1849', '212', '阳山县', '0');
INSERT INTO `sys_district` VALUES ('1850', '212', '连山壮族瑶族自治县', '0');
INSERT INTO `sys_district` VALUES ('1851', '212', '连南瑶族自治县', '0');
INSERT INTO `sys_district` VALUES ('1853', '212', '英德市', '0');
INSERT INTO `sys_district` VALUES ('1854', '212', '连州市', '0');
INSERT INTO `sys_district` VALUES ('1855', '215', '湘桥区', '0');
INSERT INTO `sys_district` VALUES ('1857', '215', '饶平县', '0');
INSERT INTO `sys_district` VALUES ('1858', '216', '榕城区', '0');
INSERT INTO `sys_district` VALUES ('1860', '216', '揭西县', '0');
INSERT INTO `sys_district` VALUES ('1861', '216', '惠来县', '0');
INSERT INTO `sys_district` VALUES ('1862', '216', '普宁市', '0');
INSERT INTO `sys_district` VALUES ('1863', '217', '云城区', '0');
INSERT INTO `sys_district` VALUES ('1864', '217', '新兴县', '0');
INSERT INTO `sys_district` VALUES ('1865', '217', '郁南县', '0');
INSERT INTO `sys_district` VALUES ('1866', '217', '云安县', '0');
INSERT INTO `sys_district` VALUES ('1867', '217', '罗定市', '0');
INSERT INTO `sys_district` VALUES ('1868', '218', '兴宁区', '0');
INSERT INTO `sys_district` VALUES ('1869', '218', '青秀区', '0');
INSERT INTO `sys_district` VALUES ('1870', '218', '江南区', '0');
INSERT INTO `sys_district` VALUES ('1871', '218', '西乡塘区', '0');
INSERT INTO `sys_district` VALUES ('1872', '218', '良庆区', '0');
INSERT INTO `sys_district` VALUES ('1873', '218', '邕宁区', '0');
INSERT INTO `sys_district` VALUES ('1874', '218', '武鸣县', '0');
INSERT INTO `sys_district` VALUES ('1875', '218', '隆安县', '0');
INSERT INTO `sys_district` VALUES ('1876', '218', '马山县', '0');
INSERT INTO `sys_district` VALUES ('1877', '218', '上林县', '0');
INSERT INTO `sys_district` VALUES ('1878', '218', '宾阳县', '0');
INSERT INTO `sys_district` VALUES ('1879', '218', '横县', '0');
INSERT INTO `sys_district` VALUES ('1880', '219', '城中区', '0');
INSERT INTO `sys_district` VALUES ('1881', '219', '鱼峰区', '0');
INSERT INTO `sys_district` VALUES ('1882', '219', '柳南区', '0');
INSERT INTO `sys_district` VALUES ('1883', '219', '柳北区', '0');
INSERT INTO `sys_district` VALUES ('1884', '219', '柳江县', '0');
INSERT INTO `sys_district` VALUES ('1885', '219', '柳城县', '0');
INSERT INTO `sys_district` VALUES ('1886', '219', '鹿寨县', '0');
INSERT INTO `sys_district` VALUES ('1887', '219', '融安县', '0');
INSERT INTO `sys_district` VALUES ('1888', '219', '融水苗族自治县', '0');
INSERT INTO `sys_district` VALUES ('1889', '219', '三江侗族自治县', '0');
INSERT INTO `sys_district` VALUES ('1890', '220', '秀峰区', '0');
INSERT INTO `sys_district` VALUES ('1891', '220', '叠彩区', '0');
INSERT INTO `sys_district` VALUES ('1892', '220', '象山区', '0');
INSERT INTO `sys_district` VALUES ('1893', '220', '七星区', '0');
INSERT INTO `sys_district` VALUES ('1894', '220', '雁山区', '0');
INSERT INTO `sys_district` VALUES ('1895', '220', '阳朔县', '0');
INSERT INTO `sys_district` VALUES ('1897', '220', '灵川县', '0');
INSERT INTO `sys_district` VALUES ('1898', '220', '全州县', '0');
INSERT INTO `sys_district` VALUES ('1899', '220', '兴安县', '0');
INSERT INTO `sys_district` VALUES ('1900', '220', '永福县', '0');
INSERT INTO `sys_district` VALUES ('1901', '220', '灌阳县', '0');
INSERT INTO `sys_district` VALUES ('1902', '220', '龙胜各族自治县', '0');
INSERT INTO `sys_district` VALUES ('1903', '220', '资源县', '0');
INSERT INTO `sys_district` VALUES ('1904', '220', '平乐县', '0');
INSERT INTO `sys_district` VALUES ('1906', '220', '恭城瑶族自治县', '0');
INSERT INTO `sys_district` VALUES ('1907', '221', '万秀区', '0');
INSERT INTO `sys_district` VALUES ('1909', '221', '长洲区', '0');
INSERT INTO `sys_district` VALUES ('1910', '221', '苍梧县', '0');
INSERT INTO `sys_district` VALUES ('1911', '221', '藤县', '0');
INSERT INTO `sys_district` VALUES ('1912', '221', '蒙山县', '0');
INSERT INTO `sys_district` VALUES ('1913', '221', '岑溪市', '0');
INSERT INTO `sys_district` VALUES ('1914', '222', '海城区', '0');
INSERT INTO `sys_district` VALUES ('1915', '222', '银海区', '0');
INSERT INTO `sys_district` VALUES ('1916', '222', '铁山港区', '0');
INSERT INTO `sys_district` VALUES ('1917', '222', '合浦县', '0');
INSERT INTO `sys_district` VALUES ('1918', '223', '港口区', '0');
INSERT INTO `sys_district` VALUES ('1919', '223', '防城区', '0');
INSERT INTO `sys_district` VALUES ('1920', '223', '上思县', '0');
INSERT INTO `sys_district` VALUES ('1921', '223', '东兴市', '0');
INSERT INTO `sys_district` VALUES ('1922', '224', '钦南区', '0');
INSERT INTO `sys_district` VALUES ('1923', '224', '钦北区', '0');
INSERT INTO `sys_district` VALUES ('1924', '224', '灵山县', '0');
INSERT INTO `sys_district` VALUES ('1925', '224', '浦北县', '0');
INSERT INTO `sys_district` VALUES ('1926', '225', '港北区', '0');
INSERT INTO `sys_district` VALUES ('1927', '225', '港南区', '0');
INSERT INTO `sys_district` VALUES ('1928', '225', '覃塘区', '0');
INSERT INTO `sys_district` VALUES ('1929', '225', '平南县', '0');
INSERT INTO `sys_district` VALUES ('1930', '225', '桂平市', '0');
INSERT INTO `sys_district` VALUES ('1931', '226', '玉州区', '0');
INSERT INTO `sys_district` VALUES ('1932', '226', '容县', '0');
INSERT INTO `sys_district` VALUES ('1933', '226', '陆川县', '0');
INSERT INTO `sys_district` VALUES ('1934', '226', '博白县', '0');
INSERT INTO `sys_district` VALUES ('1935', '226', '兴业县', '0');
INSERT INTO `sys_district` VALUES ('1936', '226', '北流市', '0');
INSERT INTO `sys_district` VALUES ('1937', '227', '右江区', '0');
INSERT INTO `sys_district` VALUES ('1938', '227', '田阳县', '0');
INSERT INTO `sys_district` VALUES ('1939', '227', '田东县', '0');
INSERT INTO `sys_district` VALUES ('1940', '227', '平果县', '0');
INSERT INTO `sys_district` VALUES ('1941', '227', '德保县', '0');
INSERT INTO `sys_district` VALUES ('1942', '227', '靖西县', '0');
INSERT INTO `sys_district` VALUES ('1943', '227', '那坡县', '0');
INSERT INTO `sys_district` VALUES ('1944', '227', '凌云县', '0');
INSERT INTO `sys_district` VALUES ('1945', '227', '乐业县', '0');
INSERT INTO `sys_district` VALUES ('1946', '227', '田林县', '0');
INSERT INTO `sys_district` VALUES ('1947', '227', '西林县', '0');
INSERT INTO `sys_district` VALUES ('1948', '227', '隆林各族自治县', '0');
INSERT INTO `sys_district` VALUES ('1949', '228', '八步区', '0');
INSERT INTO `sys_district` VALUES ('1950', '228', '昭平县', '0');
INSERT INTO `sys_district` VALUES ('1951', '228', '钟山县', '0');
INSERT INTO `sys_district` VALUES ('1952', '228', '富川瑶族自治县', '0');
INSERT INTO `sys_district` VALUES ('1953', '229', '金城江区', '0');
INSERT INTO `sys_district` VALUES ('1954', '229', '南丹县', '0');
INSERT INTO `sys_district` VALUES ('1955', '229', '天峨县', '0');
INSERT INTO `sys_district` VALUES ('1956', '229', '凤山县', '0');
INSERT INTO `sys_district` VALUES ('1957', '229', '东兰县', '0');
INSERT INTO `sys_district` VALUES ('1958', '229', '罗城仫佬族自治县', '0');
INSERT INTO `sys_district` VALUES ('1959', '229', '环江毛南族自治县', '0');
INSERT INTO `sys_district` VALUES ('1960', '229', '巴马瑶族自治县', '0');
INSERT INTO `sys_district` VALUES ('1961', '229', '都安瑶族自治县', '0');
INSERT INTO `sys_district` VALUES ('1962', '229', '大化瑶族自治县', '0');
INSERT INTO `sys_district` VALUES ('1963', '229', '宜州市', '0');
INSERT INTO `sys_district` VALUES ('1964', '230', '兴宾区', '0');
INSERT INTO `sys_district` VALUES ('1965', '230', '忻城县', '0');
INSERT INTO `sys_district` VALUES ('1966', '230', '象州县', '0');
INSERT INTO `sys_district` VALUES ('1967', '230', '武宣县', '0');
INSERT INTO `sys_district` VALUES ('1968', '230', '金秀瑶族自治县', '0');
INSERT INTO `sys_district` VALUES ('1969', '230', '合山市', '0');
INSERT INTO `sys_district` VALUES ('1971', '231', '扶绥县', '0');
INSERT INTO `sys_district` VALUES ('1972', '231', '宁明县', '0');
INSERT INTO `sys_district` VALUES ('1973', '231', '龙州县', '0');
INSERT INTO `sys_district` VALUES ('1974', '231', '大新县', '0');
INSERT INTO `sys_district` VALUES ('1975', '231', '天等县', '0');
INSERT INTO `sys_district` VALUES ('1976', '231', '凭祥市', '0');
INSERT INTO `sys_district` VALUES ('1977', '232', '秀英区', '0');
INSERT INTO `sys_district` VALUES ('1978', '232', '龙华区', '0');
INSERT INTO `sys_district` VALUES ('1979', '232', '琼山区', '0');
INSERT INTO `sys_district` VALUES ('1980', '232', '美兰区', '0');
INSERT INTO `sys_district` VALUES ('2000', '234', '万州区', '0');
INSERT INTO `sys_district` VALUES ('2001', '234', '涪陵区', '0');
INSERT INTO `sys_district` VALUES ('2002', '234', '渝中区', '0');
INSERT INTO `sys_district` VALUES ('2003', '234', '大渡口区', '0');
INSERT INTO `sys_district` VALUES ('2004', '234', '江北区', '0');
INSERT INTO `sys_district` VALUES ('2005', '234', '沙坪坝区', '0');
INSERT INTO `sys_district` VALUES ('2006', '234', '九龙坡区', '0');
INSERT INTO `sys_district` VALUES ('2007', '234', '南岸区', '0');
INSERT INTO `sys_district` VALUES ('2008', '234', '北碚区', '0');
INSERT INTO `sys_district` VALUES ('2011', '234', '渝北区', '0');
INSERT INTO `sys_district` VALUES ('2012', '234', '巴南区', '0');
INSERT INTO `sys_district` VALUES ('2013', '234', '黔江区', '0');
INSERT INTO `sys_district` VALUES ('2014', '234', '长寿区', '0');
INSERT INTO `sys_district` VALUES ('2016', '234', '潼南县', '0');
INSERT INTO `sys_district` VALUES ('2017', '234', '铜梁县', '0');
INSERT INTO `sys_district` VALUES ('2019', '234', '荣昌县', '0');
INSERT INTO `sys_district` VALUES ('2020', '234', '璧山县', '0');
INSERT INTO `sys_district` VALUES ('2021', '234', '梁平县', '0');
INSERT INTO `sys_district` VALUES ('2022', '234', '城口县', '0');
INSERT INTO `sys_district` VALUES ('2023', '234', '丰都县', '0');
INSERT INTO `sys_district` VALUES ('2024', '234', '垫江县', '0');
INSERT INTO `sys_district` VALUES ('2025', '234', '武隆县', '0');
INSERT INTO `sys_district` VALUES ('2026', '234', '忠县', '0');
INSERT INTO `sys_district` VALUES ('2027', '234', '开县', '0');
INSERT INTO `sys_district` VALUES ('2028', '234', '云阳县', '0');
INSERT INTO `sys_district` VALUES ('2029', '234', '奉节县', '0');
INSERT INTO `sys_district` VALUES ('2030', '234', '巫山县', '0');
INSERT INTO `sys_district` VALUES ('2031', '234', '巫溪县', '0');
INSERT INTO `sys_district` VALUES ('2032', '234', '石柱土家族自治县', '0');
INSERT INTO `sys_district` VALUES ('2033', '234', '秀山土家族苗族自治县', '0');
INSERT INTO `sys_district` VALUES ('2034', '234', '酉阳土家族苗族自治县', '0');
INSERT INTO `sys_district` VALUES ('2035', '234', '彭水苗族土家族自治县', '0');
INSERT INTO `sys_district` VALUES ('2040', '235', '锦江区', '0');
INSERT INTO `sys_district` VALUES ('2041', '235', '青羊区', '0');
INSERT INTO `sys_district` VALUES ('2042', '235', '金牛区', '0');
INSERT INTO `sys_district` VALUES ('2043', '235', '武侯区', '0');
INSERT INTO `sys_district` VALUES ('2044', '235', '成华区', '0');
INSERT INTO `sys_district` VALUES ('2045', '235', '龙泉驿区', '0');
INSERT INTO `sys_district` VALUES ('2046', '235', '青白江区', '0');
INSERT INTO `sys_district` VALUES ('2047', '235', '新都区', '0');
INSERT INTO `sys_district` VALUES ('2048', '235', '温江区', '0');
INSERT INTO `sys_district` VALUES ('2049', '235', '金堂县', '0');
INSERT INTO `sys_district` VALUES ('2050', '235', '双流县', '0');
INSERT INTO `sys_district` VALUES ('2051', '235', '郫县', '0');
INSERT INTO `sys_district` VALUES ('2052', '235', '大邑县', '0');
INSERT INTO `sys_district` VALUES ('2053', '235', '蒲江县', '0');
INSERT INTO `sys_district` VALUES ('2054', '235', '新津县', '0');
INSERT INTO `sys_district` VALUES ('2055', '235', '都江堰市', '0');
INSERT INTO `sys_district` VALUES ('2056', '235', '彭州市', '0');
INSERT INTO `sys_district` VALUES ('2057', '235', '邛崃市', '0');
INSERT INTO `sys_district` VALUES ('2058', '235', '崇州市', '0');
INSERT INTO `sys_district` VALUES ('2059', '236', '自流井区', '0');
INSERT INTO `sys_district` VALUES ('2060', '236', '贡井区', '0');
INSERT INTO `sys_district` VALUES ('2061', '236', '大安区', '0');
INSERT INTO `sys_district` VALUES ('2062', '236', '沿滩区', '0');
INSERT INTO `sys_district` VALUES ('2063', '236', '荣县', '0');
INSERT INTO `sys_district` VALUES ('2064', '236', '富顺县', '0');
INSERT INTO `sys_district` VALUES ('2065', '237', '东区', '0');
INSERT INTO `sys_district` VALUES ('2066', '237', '西区', '0');
INSERT INTO `sys_district` VALUES ('2067', '237', '仁和区', '0');
INSERT INTO `sys_district` VALUES ('2068', '237', '米易县', '0');
INSERT INTO `sys_district` VALUES ('2069', '237', '盐边县', '0');
INSERT INTO `sys_district` VALUES ('2070', '238', '江阳区', '0');
INSERT INTO `sys_district` VALUES ('2071', '238', '纳溪区', '0');
INSERT INTO `sys_district` VALUES ('2072', '238', '龙马潭区', '0');
INSERT INTO `sys_district` VALUES ('2073', '238', '泸县', '0');
INSERT INTO `sys_district` VALUES ('2074', '238', '合江县', '0');
INSERT INTO `sys_district` VALUES ('2075', '238', '叙永县', '0');
INSERT INTO `sys_district` VALUES ('2076', '238', '古蔺县', '0');
INSERT INTO `sys_district` VALUES ('2077', '239', '旌阳区', '0');
INSERT INTO `sys_district` VALUES ('2078', '239', '中江县', '0');
INSERT INTO `sys_district` VALUES ('2079', '239', '罗江县', '0');
INSERT INTO `sys_district` VALUES ('2080', '239', '广汉市', '0');
INSERT INTO `sys_district` VALUES ('2081', '239', '什邡市', '0');
INSERT INTO `sys_district` VALUES ('2082', '239', '绵竹市', '0');
INSERT INTO `sys_district` VALUES ('2083', '240', '涪城区', '0');
INSERT INTO `sys_district` VALUES ('2084', '240', '游仙区', '0');
INSERT INTO `sys_district` VALUES ('2085', '240', '三台县', '0');
INSERT INTO `sys_district` VALUES ('2086', '240', '盐亭县', '0');
INSERT INTO `sys_district` VALUES ('2087', '240', '安县', '0');
INSERT INTO `sys_district` VALUES ('2088', '240', '梓潼县', '0');
INSERT INTO `sys_district` VALUES ('2089', '240', '北川羌族自治县', '0');
INSERT INTO `sys_district` VALUES ('2090', '240', '平武县', '0');
INSERT INTO `sys_district` VALUES ('2091', '240', '江油市', '0');
INSERT INTO `sys_district` VALUES ('2094', '241', '朝天区', '0');
INSERT INTO `sys_district` VALUES ('2095', '241', '旺苍县', '0');
INSERT INTO `sys_district` VALUES ('2096', '241', '青川县', '0');
INSERT INTO `sys_district` VALUES ('2097', '241', '剑阁县', '0');
INSERT INTO `sys_district` VALUES ('2098', '241', '苍溪县', '0');
INSERT INTO `sys_district` VALUES ('2099', '242', '船山区', '0');
INSERT INTO `sys_district` VALUES ('2100', '242', '安居区', '0');
INSERT INTO `sys_district` VALUES ('2101', '242', '蓬溪县', '0');
INSERT INTO `sys_district` VALUES ('2102', '242', '射洪县', '0');
INSERT INTO `sys_district` VALUES ('2103', '242', '大英县', '0');
INSERT INTO `sys_district` VALUES ('2104', '243', '市中区', '0');
INSERT INTO `sys_district` VALUES ('2105', '243', '东兴区', '0');
INSERT INTO `sys_district` VALUES ('2106', '243', '威远县', '0');
INSERT INTO `sys_district` VALUES ('2107', '243', '资中县', '0');
INSERT INTO `sys_district` VALUES ('2108', '243', '隆昌县', '0');
INSERT INTO `sys_district` VALUES ('2109', '244', '市中区', '0');
INSERT INTO `sys_district` VALUES ('2110', '244', '沙湾区', '0');
INSERT INTO `sys_district` VALUES ('2111', '244', '五通桥区', '0');
INSERT INTO `sys_district` VALUES ('2112', '244', '金口河区', '0');
INSERT INTO `sys_district` VALUES ('2113', '244', '犍为县', '0');
INSERT INTO `sys_district` VALUES ('2114', '244', '井研县', '0');
INSERT INTO `sys_district` VALUES ('2115', '244', '夹江县', '0');
INSERT INTO `sys_district` VALUES ('2116', '244', '沐川县', '0');
INSERT INTO `sys_district` VALUES ('2117', '244', '峨边彝族自治县', '0');
INSERT INTO `sys_district` VALUES ('2118', '244', '马边彝族自治县', '0');
INSERT INTO `sys_district` VALUES ('2119', '244', '峨眉山市', '0');
INSERT INTO `sys_district` VALUES ('2120', '245', '顺庆区', '0');
INSERT INTO `sys_district` VALUES ('2121', '245', '高坪区', '0');
INSERT INTO `sys_district` VALUES ('2122', '245', '嘉陵区', '0');
INSERT INTO `sys_district` VALUES ('2123', '245', '南部县', '0');
INSERT INTO `sys_district` VALUES ('2124', '245', '营山县', '0');
INSERT INTO `sys_district` VALUES ('2125', '245', '蓬安县', '0');
INSERT INTO `sys_district` VALUES ('2126', '245', '仪陇县', '0');
INSERT INTO `sys_district` VALUES ('2127', '245', '西充县', '0');
INSERT INTO `sys_district` VALUES ('2128', '245', '阆中市', '0');
INSERT INTO `sys_district` VALUES ('2129', '246', '东坡区', '0');
INSERT INTO `sys_district` VALUES ('2130', '246', '仁寿县', '0');
INSERT INTO `sys_district` VALUES ('2131', '246', '彭山县', '0');
INSERT INTO `sys_district` VALUES ('2132', '246', '洪雅县', '0');
INSERT INTO `sys_district` VALUES ('2133', '246', '丹棱县', '0');
INSERT INTO `sys_district` VALUES ('2134', '246', '青神县', '0');
INSERT INTO `sys_district` VALUES ('2135', '247', '翠屏区', '0');
INSERT INTO `sys_district` VALUES ('2136', '247', '宜宾县', '0');
INSERT INTO `sys_district` VALUES ('2138', '247', '江安县', '0');
INSERT INTO `sys_district` VALUES ('2139', '247', '长宁县', '0');
INSERT INTO `sys_district` VALUES ('2140', '247', '高县', '0');
INSERT INTO `sys_district` VALUES ('2141', '247', '珙县', '0');
INSERT INTO `sys_district` VALUES ('2142', '247', '筠连县', '0');
INSERT INTO `sys_district` VALUES ('2143', '247', '兴文县', '0');
INSERT INTO `sys_district` VALUES ('2144', '247', '屏山县', '0');
INSERT INTO `sys_district` VALUES ('2145', '248', '广安区', '0');
INSERT INTO `sys_district` VALUES ('2146', '248', '岳池县', '0');
INSERT INTO `sys_district` VALUES ('2147', '248', '武胜县', '0');
INSERT INTO `sys_district` VALUES ('2148', '248', '邻水县', '0');
INSERT INTO `sys_district` VALUES ('2149', '248', '华蓥市', '0');
INSERT INTO `sys_district` VALUES ('2150', '249', '通川区', '0');
INSERT INTO `sys_district` VALUES ('2152', '249', '宣汉县', '0');
INSERT INTO `sys_district` VALUES ('2153', '249', '开江县', '0');
INSERT INTO `sys_district` VALUES ('2154', '249', '大竹县', '0');
INSERT INTO `sys_district` VALUES ('2155', '249', '渠县', '0');
INSERT INTO `sys_district` VALUES ('2156', '249', '万源市', '0');
INSERT INTO `sys_district` VALUES ('2157', '250', '雨城区', '0');
INSERT INTO `sys_district` VALUES ('2159', '250', '荥经县', '0');
INSERT INTO `sys_district` VALUES ('2160', '250', '汉源县', '0');
INSERT INTO `sys_district` VALUES ('2161', '250', '石棉县', '0');
INSERT INTO `sys_district` VALUES ('2162', '250', '天全县', '0');
INSERT INTO `sys_district` VALUES ('2163', '250', '芦山县', '0');
INSERT INTO `sys_district` VALUES ('2164', '250', '宝兴县', '0');
INSERT INTO `sys_district` VALUES ('2165', '251', '巴州区', '0');
INSERT INTO `sys_district` VALUES ('2166', '251', '通江县', '0');
INSERT INTO `sys_district` VALUES ('2167', '251', '南江县', '0');
INSERT INTO `sys_district` VALUES ('2168', '251', '平昌县', '0');
INSERT INTO `sys_district` VALUES ('2169', '252', '雁江区', '0');
INSERT INTO `sys_district` VALUES ('2170', '252', '安岳县', '0');
INSERT INTO `sys_district` VALUES ('2171', '252', '乐至县', '0');
INSERT INTO `sys_district` VALUES ('2172', '252', '简阳市', '0');
INSERT INTO `sys_district` VALUES ('2173', '253', '汶川县', '0');
INSERT INTO `sys_district` VALUES ('2174', '253', '理县', '0');
INSERT INTO `sys_district` VALUES ('2175', '253', '茂县', '0');
INSERT INTO `sys_district` VALUES ('2176', '253', '松潘县', '0');
INSERT INTO `sys_district` VALUES ('2177', '253', '九寨沟县', '0');
INSERT INTO `sys_district` VALUES ('2178', '253', '金川县', '0');
INSERT INTO `sys_district` VALUES ('2179', '253', '小金县', '0');
INSERT INTO `sys_district` VALUES ('2180', '253', '黑水县', '0');
INSERT INTO `sys_district` VALUES ('2181', '253', '马尔康县', '0');
INSERT INTO `sys_district` VALUES ('2182', '253', '壤塘县', '0');
INSERT INTO `sys_district` VALUES ('2183', '253', '阿坝县', '0');
INSERT INTO `sys_district` VALUES ('2184', '253', '若尔盖县', '0');
INSERT INTO `sys_district` VALUES ('2185', '253', '红原县', '0');
INSERT INTO `sys_district` VALUES ('2186', '254', '康定县', '0');
INSERT INTO `sys_district` VALUES ('2187', '254', '泸定县', '0');
INSERT INTO `sys_district` VALUES ('2188', '254', '丹巴县', '0');
INSERT INTO `sys_district` VALUES ('2189', '254', '九龙县', '0');
INSERT INTO `sys_district` VALUES ('2190', '254', '雅江县', '0');
INSERT INTO `sys_district` VALUES ('2191', '254', '道孚县', '0');
INSERT INTO `sys_district` VALUES ('2192', '254', '炉霍县', '0');
INSERT INTO `sys_district` VALUES ('2193', '254', '甘孜县', '0');
INSERT INTO `sys_district` VALUES ('2194', '254', '新龙县', '0');
INSERT INTO `sys_district` VALUES ('2195', '254', '德格县', '0');
INSERT INTO `sys_district` VALUES ('2196', '254', '白玉县', '0');
INSERT INTO `sys_district` VALUES ('2197', '254', '石渠县', '0');
INSERT INTO `sys_district` VALUES ('2198', '254', '色达县', '0');
INSERT INTO `sys_district` VALUES ('2199', '254', '理塘县', '0');
INSERT INTO `sys_district` VALUES ('2200', '254', '巴塘县', '0');
INSERT INTO `sys_district` VALUES ('2201', '254', '乡城县', '0');
INSERT INTO `sys_district` VALUES ('2202', '254', '稻城县', '0');
INSERT INTO `sys_district` VALUES ('2203', '254', '得荣县', '0');
INSERT INTO `sys_district` VALUES ('2204', '255', '西昌市', '0');
INSERT INTO `sys_district` VALUES ('2205', '255', '木里藏族自治县', '0');
INSERT INTO `sys_district` VALUES ('2206', '255', '盐源县', '0');
INSERT INTO `sys_district` VALUES ('2207', '255', '德昌县', '0');
INSERT INTO `sys_district` VALUES ('2208', '255', '会理县', '0');
INSERT INTO `sys_district` VALUES ('2209', '255', '会东县', '0');
INSERT INTO `sys_district` VALUES ('2210', '255', '宁南县', '0');
INSERT INTO `sys_district` VALUES ('2211', '255', '普格县', '0');
INSERT INTO `sys_district` VALUES ('2212', '255', '布拖县', '0');
INSERT INTO `sys_district` VALUES ('2213', '255', '金阳县', '0');
INSERT INTO `sys_district` VALUES ('2214', '255', '昭觉县', '0');
INSERT INTO `sys_district` VALUES ('2215', '255', '喜德县', '0');
INSERT INTO `sys_district` VALUES ('2216', '255', '冕宁县', '0');
INSERT INTO `sys_district` VALUES ('2217', '255', '越西县', '0');
INSERT INTO `sys_district` VALUES ('2218', '255', '甘洛县', '0');
INSERT INTO `sys_district` VALUES ('2219', '255', '美姑县', '0');
INSERT INTO `sys_district` VALUES ('2220', '255', '雷波县', '0');
INSERT INTO `sys_district` VALUES ('2221', '256', '南明区', '0');
INSERT INTO `sys_district` VALUES ('2222', '256', '云岩区', '0');
INSERT INTO `sys_district` VALUES ('2223', '256', '花溪区', '0');
INSERT INTO `sys_district` VALUES ('2224', '256', '乌当区', '0');
INSERT INTO `sys_district` VALUES ('2225', '256', '白云区', '0');
INSERT INTO `sys_district` VALUES ('2227', '256', '开阳县', '0');
INSERT INTO `sys_district` VALUES ('2228', '256', '息烽县', '0');
INSERT INTO `sys_district` VALUES ('2229', '256', '修文县', '0');
INSERT INTO `sys_district` VALUES ('2230', '256', '清镇市', '0');
INSERT INTO `sys_district` VALUES ('2231', '257', '钟山区', '0');
INSERT INTO `sys_district` VALUES ('2232', '257', '六枝特区', '0');
INSERT INTO `sys_district` VALUES ('2233', '257', '水城县', '0');
INSERT INTO `sys_district` VALUES ('2234', '257', '盘县', '0');
INSERT INTO `sys_district` VALUES ('2235', '258', '红花岗区', '0');
INSERT INTO `sys_district` VALUES ('2236', '258', '汇川区', '0');
INSERT INTO `sys_district` VALUES ('2237', '258', '遵义县', '0');
INSERT INTO `sys_district` VALUES ('2238', '258', '桐梓县', '0');
INSERT INTO `sys_district` VALUES ('2239', '258', '绥阳县', '0');
INSERT INTO `sys_district` VALUES ('2240', '258', '正安县', '0');
INSERT INTO `sys_district` VALUES ('2241', '258', '道真仡佬族苗族自治县', '0');
INSERT INTO `sys_district` VALUES ('2242', '258', '务川仡佬族苗族自治县', '0');
INSERT INTO `sys_district` VALUES ('2243', '258', '凤冈县', '0');
INSERT INTO `sys_district` VALUES ('2244', '258', '湄潭县', '0');
INSERT INTO `sys_district` VALUES ('2245', '258', '余庆县', '0');
INSERT INTO `sys_district` VALUES ('2246', '258', '习水县', '0');
INSERT INTO `sys_district` VALUES ('2247', '258', '赤水市', '0');
INSERT INTO `sys_district` VALUES ('2248', '258', '仁怀市', '0');
INSERT INTO `sys_district` VALUES ('2249', '259', '西秀区', '0');
INSERT INTO `sys_district` VALUES ('2250', '259', '平坝县', '0');
INSERT INTO `sys_district` VALUES ('2251', '259', '普定县', '0');
INSERT INTO `sys_district` VALUES ('2252', '259', '镇宁布依族苗族自治县', '0');
INSERT INTO `sys_district` VALUES ('2253', '259', '关岭布依族苗族自治县', '0');
INSERT INTO `sys_district` VALUES ('2254', '259', '紫云苗族布依族自治县', '0');
INSERT INTO `sys_district` VALUES ('2256', '260', '江口县', '0');
INSERT INTO `sys_district` VALUES ('2257', '260', '玉屏侗族自治县', '0');
INSERT INTO `sys_district` VALUES ('2258', '260', '石阡县', '0');
INSERT INTO `sys_district` VALUES ('2259', '260', '思南县', '0');
INSERT INTO `sys_district` VALUES ('2260', '260', '印江土家族苗族自治县', '0');
INSERT INTO `sys_district` VALUES ('2261', '260', '德江县', '0');
INSERT INTO `sys_district` VALUES ('2262', '260', '沿河土家族自治县', '0');
INSERT INTO `sys_district` VALUES ('2263', '260', '松桃苗族自治县', '0');
INSERT INTO `sys_district` VALUES ('2265', '261', '兴义市', '0');
INSERT INTO `sys_district` VALUES ('2266', '261', '兴仁县', '0');
INSERT INTO `sys_district` VALUES ('2267', '261', '普安县', '0');
INSERT INTO `sys_district` VALUES ('2268', '261', '晴隆县', '0');
INSERT INTO `sys_district` VALUES ('2269', '261', '贞丰县', '0');
INSERT INTO `sys_district` VALUES ('2270', '261', '望谟县', '0');
INSERT INTO `sys_district` VALUES ('2271', '261', '册亨县', '0');
INSERT INTO `sys_district` VALUES ('2272', '261', '安龙县', '0');
INSERT INTO `sys_district` VALUES ('2274', '262', '大方县', '0');
INSERT INTO `sys_district` VALUES ('2275', '262', '黔西县', '0');
INSERT INTO `sys_district` VALUES ('2276', '262', '金沙县', '0');
INSERT INTO `sys_district` VALUES ('2277', '262', '织金县', '0');
INSERT INTO `sys_district` VALUES ('2278', '262', '纳雍县', '0');
INSERT INTO `sys_district` VALUES ('2279', '262', '威宁彝族回族苗族自治县', '0');
INSERT INTO `sys_district` VALUES ('2280', '262', '赫章县', '0');
INSERT INTO `sys_district` VALUES ('2281', '263', '凯里市', '0');
INSERT INTO `sys_district` VALUES ('2282', '263', '黄平县', '0');
INSERT INTO `sys_district` VALUES ('2283', '263', '施秉县', '0');
INSERT INTO `sys_district` VALUES ('2284', '263', '三穗县', '0');
INSERT INTO `sys_district` VALUES ('2285', '263', '镇远县', '0');
INSERT INTO `sys_district` VALUES ('2286', '263', '岑巩县', '0');
INSERT INTO `sys_district` VALUES ('2287', '263', '天柱县', '0');
INSERT INTO `sys_district` VALUES ('2288', '263', '锦屏县', '0');
INSERT INTO `sys_district` VALUES ('2289', '263', '剑河县', '0');
INSERT INTO `sys_district` VALUES ('2290', '263', '台江县', '0');
INSERT INTO `sys_district` VALUES ('2291', '263', '黎平县', '0');
INSERT INTO `sys_district` VALUES ('2292', '263', '榕江县', '0');
INSERT INTO `sys_district` VALUES ('2293', '263', '从江县', '0');
INSERT INTO `sys_district` VALUES ('2294', '263', '雷山县', '0');
INSERT INTO `sys_district` VALUES ('2295', '263', '麻江县', '0');
INSERT INTO `sys_district` VALUES ('2296', '263', '丹寨县', '0');
INSERT INTO `sys_district` VALUES ('2297', '264', '都匀市', '0');
INSERT INTO `sys_district` VALUES ('2298', '264', '福泉市', '0');
INSERT INTO `sys_district` VALUES ('2299', '264', '荔波县', '0');
INSERT INTO `sys_district` VALUES ('2300', '264', '贵定县', '0');
INSERT INTO `sys_district` VALUES ('2301', '264', '瓮安县', '0');
INSERT INTO `sys_district` VALUES ('2302', '264', '独山县', '0');
INSERT INTO `sys_district` VALUES ('2303', '264', '平塘县', '0');
INSERT INTO `sys_district` VALUES ('2304', '264', '罗甸县', '0');
INSERT INTO `sys_district` VALUES ('2305', '264', '长顺县', '0');
INSERT INTO `sys_district` VALUES ('2306', '264', '龙里县', '0');
INSERT INTO `sys_district` VALUES ('2307', '264', '惠水县', '0');
INSERT INTO `sys_district` VALUES ('2308', '264', '三都水族自治县', '0');
INSERT INTO `sys_district` VALUES ('2309', '265', '五华区', '0');
INSERT INTO `sys_district` VALUES ('2310', '265', '盘龙区', '0');
INSERT INTO `sys_district` VALUES ('2311', '265', '官渡区', '0');
INSERT INTO `sys_district` VALUES ('2312', '265', '西山区', '0');
INSERT INTO `sys_district` VALUES ('2313', '265', '东川区', '0');
INSERT INTO `sys_district` VALUES ('2315', '265', '晋宁县', '0');
INSERT INTO `sys_district` VALUES ('2316', '265', '富民县', '0');
INSERT INTO `sys_district` VALUES ('2317', '265', '宜良县', '0');
INSERT INTO `sys_district` VALUES ('2318', '265', '石林彝族自治县', '0');
INSERT INTO `sys_district` VALUES ('2319', '265', '嵩明县', '0');
INSERT INTO `sys_district` VALUES ('2320', '265', '禄劝彝族苗族自治县', '0');
INSERT INTO `sys_district` VALUES ('2321', '265', '寻甸回族彝族自治县', '0');
INSERT INTO `sys_district` VALUES ('2322', '265', '安宁市', '0');
INSERT INTO `sys_district` VALUES ('2323', '266', '麒麟区', '0');
INSERT INTO `sys_district` VALUES ('2324', '266', '马龙县', '0');
INSERT INTO `sys_district` VALUES ('2325', '266', '陆良县', '0');
INSERT INTO `sys_district` VALUES ('2326', '266', '师宗县', '0');
INSERT INTO `sys_district` VALUES ('2327', '266', '罗平县', '0');
INSERT INTO `sys_district` VALUES ('2328', '266', '富源县', '0');
INSERT INTO `sys_district` VALUES ('2329', '266', '会泽县', '0');
INSERT INTO `sys_district` VALUES ('2330', '266', '沾益县', '0');
INSERT INTO `sys_district` VALUES ('2331', '266', '宣威市', '0');
INSERT INTO `sys_district` VALUES ('2332', '267', '红塔区', '0');
INSERT INTO `sys_district` VALUES ('2333', '267', '江川县', '0');
INSERT INTO `sys_district` VALUES ('2334', '267', '澄江县', '0');
INSERT INTO `sys_district` VALUES ('2335', '267', '通海县', '0');
INSERT INTO `sys_district` VALUES ('2336', '267', '华宁县', '0');
INSERT INTO `sys_district` VALUES ('2337', '267', '易门县', '0');
INSERT INTO `sys_district` VALUES ('2338', '267', '峨山彝族自治县', '0');
INSERT INTO `sys_district` VALUES ('2339', '267', '新平彝族傣族自治县', '0');
INSERT INTO `sys_district` VALUES ('2340', '267', '元江哈尼族彝族傣族自治县', '0');
INSERT INTO `sys_district` VALUES ('2341', '268', '隆阳区', '0');
INSERT INTO `sys_district` VALUES ('2342', '268', '施甸县', '0');
INSERT INTO `sys_district` VALUES ('2343', '268', '腾冲县', '0');
INSERT INTO `sys_district` VALUES ('2344', '268', '龙陵县', '0');
INSERT INTO `sys_district` VALUES ('2345', '268', '昌宁县', '0');
INSERT INTO `sys_district` VALUES ('2346', '269', '昭阳区', '0');
INSERT INTO `sys_district` VALUES ('2347', '269', '鲁甸县', '0');
INSERT INTO `sys_district` VALUES ('2348', '269', '巧家县', '0');
INSERT INTO `sys_district` VALUES ('2349', '269', '盐津县', '0');
INSERT INTO `sys_district` VALUES ('2350', '269', '大关县', '0');
INSERT INTO `sys_district` VALUES ('2351', '269', '永善县', '0');
INSERT INTO `sys_district` VALUES ('2352', '269', '绥江县', '0');
INSERT INTO `sys_district` VALUES ('2353', '269', '镇雄县', '0');
INSERT INTO `sys_district` VALUES ('2354', '269', '彝良县', '0');
INSERT INTO `sys_district` VALUES ('2355', '269', '威信县', '0');
INSERT INTO `sys_district` VALUES ('2356', '269', '水富县', '0');
INSERT INTO `sys_district` VALUES ('2357', '270', '古城区', '0');
INSERT INTO `sys_district` VALUES ('2358', '270', '玉龙纳西族自治县', '0');
INSERT INTO `sys_district` VALUES ('2359', '270', '永胜县', '0');
INSERT INTO `sys_district` VALUES ('2360', '270', '华坪县', '0');
INSERT INTO `sys_district` VALUES ('2361', '270', '宁蒗彝族自治县', '0');
INSERT INTO `sys_district` VALUES ('2372', '272', '临翔区', '0');
INSERT INTO `sys_district` VALUES ('2373', '272', '凤庆县', '0');
INSERT INTO `sys_district` VALUES ('2374', '272', '云县', '0');
INSERT INTO `sys_district` VALUES ('2375', '272', '永德县', '0');
INSERT INTO `sys_district` VALUES ('2376', '272', '镇康县', '0');
INSERT INTO `sys_district` VALUES ('2377', '272', '双江拉祜族佤族布朗族傣族自治县', '0');
INSERT INTO `sys_district` VALUES ('2378', '272', '耿马傣族佤族自治县', '0');
INSERT INTO `sys_district` VALUES ('2379', '272', '沧源佤族自治县', '0');
INSERT INTO `sys_district` VALUES ('2380', '273', '楚雄市', '0');
INSERT INTO `sys_district` VALUES ('2381', '273', '双柏县', '0');
INSERT INTO `sys_district` VALUES ('2382', '273', '牟定县', '0');
INSERT INTO `sys_district` VALUES ('2383', '273', '南华县', '0');
INSERT INTO `sys_district` VALUES ('2384', '273', '姚安县', '0');
INSERT INTO `sys_district` VALUES ('2385', '273', '大姚县', '0');
INSERT INTO `sys_district` VALUES ('2386', '273', '永仁县', '0');
INSERT INTO `sys_district` VALUES ('2387', '273', '元谋县', '0');
INSERT INTO `sys_district` VALUES ('2388', '273', '武定县', '0');
INSERT INTO `sys_district` VALUES ('2389', '273', '禄丰县', '0');
INSERT INTO `sys_district` VALUES ('2390', '274', '个旧市', '0');
INSERT INTO `sys_district` VALUES ('2391', '274', '开远市', '0');
INSERT INTO `sys_district` VALUES ('2393', '274', '屏边苗族自治县', '0');
INSERT INTO `sys_district` VALUES ('2394', '274', '建水县', '0');
INSERT INTO `sys_district` VALUES ('2395', '274', '石屏县', '0');
INSERT INTO `sys_district` VALUES ('2397', '274', '泸西县', '0');
INSERT INTO `sys_district` VALUES ('2398', '274', '元阳县', '0');
INSERT INTO `sys_district` VALUES ('2399', '274', '红河县', '0');
INSERT INTO `sys_district` VALUES ('2400', '274', '金平苗族瑶族傣族自治县', '0');
INSERT INTO `sys_district` VALUES ('2401', '274', '绿春县', '0');
INSERT INTO `sys_district` VALUES ('2402', '274', '河口瑶族自治县', '0');
INSERT INTO `sys_district` VALUES ('2404', '275', '砚山县', '0');
INSERT INTO `sys_district` VALUES ('2405', '275', '西畴县', '0');
INSERT INTO `sys_district` VALUES ('2406', '275', '麻栗坡县', '0');
INSERT INTO `sys_district` VALUES ('2407', '275', '马关县', '0');
INSERT INTO `sys_district` VALUES ('2408', '275', '丘北县', '0');
INSERT INTO `sys_district` VALUES ('2409', '275', '广南县', '0');
INSERT INTO `sys_district` VALUES ('2410', '275', '富宁县', '0');
INSERT INTO `sys_district` VALUES ('2411', '276', '景洪市', '0');
INSERT INTO `sys_district` VALUES ('2412', '276', '勐海县', '0');
INSERT INTO `sys_district` VALUES ('2413', '276', '勐腊县', '0');
INSERT INTO `sys_district` VALUES ('2414', '277', '大理市', '0');
INSERT INTO `sys_district` VALUES ('2415', '277', '漾濞彝族自治县', '0');
INSERT INTO `sys_district` VALUES ('2416', '277', '祥云县', '0');
INSERT INTO `sys_district` VALUES ('2417', '277', '宾川县', '0');
INSERT INTO `sys_district` VALUES ('2418', '277', '弥渡县', '0');
INSERT INTO `sys_district` VALUES ('2419', '277', '南涧彝族自治县', '0');
INSERT INTO `sys_district` VALUES ('2420', '277', '巍山彝族回族自治县', '0');
INSERT INTO `sys_district` VALUES ('2421', '277', '永平县', '0');
INSERT INTO `sys_district` VALUES ('2422', '277', '云龙县', '0');
INSERT INTO `sys_district` VALUES ('2423', '277', '洱源县', '0');
INSERT INTO `sys_district` VALUES ('2424', '277', '剑川县', '0');
INSERT INTO `sys_district` VALUES ('2425', '277', '鹤庆县', '0');
INSERT INTO `sys_district` VALUES ('2426', '278', '瑞丽市', '0');
INSERT INTO `sys_district` VALUES ('2428', '278', '梁河县', '0');
INSERT INTO `sys_district` VALUES ('2429', '278', '盈江县', '0');
INSERT INTO `sys_district` VALUES ('2430', '278', '陇川县', '0');
INSERT INTO `sys_district` VALUES ('2431', '279', '泸水县', '0');
INSERT INTO `sys_district` VALUES ('2432', '279', '福贡县', '0');
INSERT INTO `sys_district` VALUES ('2433', '279', '贡山独龙族怒族自治县', '0');
INSERT INTO `sys_district` VALUES ('2434', '279', '兰坪白族普米族自治县', '0');
INSERT INTO `sys_district` VALUES ('2435', '280', '香格里拉县', '0');
INSERT INTO `sys_district` VALUES ('2436', '280', '德钦县', '0');
INSERT INTO `sys_district` VALUES ('2437', '280', '维西傈僳族自治县', '0');
INSERT INTO `sys_district` VALUES ('2438', '281', '城关区', '0');
INSERT INTO `sys_district` VALUES ('2439', '281', '林周县', '0');
INSERT INTO `sys_district` VALUES ('2440', '281', '当雄县', '0');
INSERT INTO `sys_district` VALUES ('2441', '281', '尼木县', '0');
INSERT INTO `sys_district` VALUES ('2442', '281', '曲水县', '0');
INSERT INTO `sys_district` VALUES ('2443', '281', '堆龙德庆县', '0');
INSERT INTO `sys_district` VALUES ('2444', '281', '达孜县', '0');
INSERT INTO `sys_district` VALUES ('2445', '281', '墨竹工卡县', '0');
INSERT INTO `sys_district` VALUES ('2446', '282', '昌都县', '0');
INSERT INTO `sys_district` VALUES ('2447', '282', '江达县', '0');
INSERT INTO `sys_district` VALUES ('2448', '282', '贡觉县', '0');
INSERT INTO `sys_district` VALUES ('2449', '282', '类乌齐县', '0');
INSERT INTO `sys_district` VALUES ('2450', '282', '丁青县', '0');
INSERT INTO `sys_district` VALUES ('2451', '282', '察雅县', '0');
INSERT INTO `sys_district` VALUES ('2452', '282', '八宿县', '0');
INSERT INTO `sys_district` VALUES ('2453', '282', '左贡县', '0');
INSERT INTO `sys_district` VALUES ('2454', '282', '芒康县', '0');
INSERT INTO `sys_district` VALUES ('2455', '282', '洛隆县', '0');
INSERT INTO `sys_district` VALUES ('2456', '282', '边坝县', '0');
INSERT INTO `sys_district` VALUES ('2457', '283', '乃东县', '0');
INSERT INTO `sys_district` VALUES ('2458', '283', '扎囊县', '0');
INSERT INTO `sys_district` VALUES ('2459', '283', '贡嘎县', '0');
INSERT INTO `sys_district` VALUES ('2460', '283', '桑日县', '0');
INSERT INTO `sys_district` VALUES ('2461', '283', '琼结县', '0');
INSERT INTO `sys_district` VALUES ('2462', '283', '曲松县', '0');
INSERT INTO `sys_district` VALUES ('2463', '283', '措美县', '0');
INSERT INTO `sys_district` VALUES ('2464', '283', '洛扎县', '0');
INSERT INTO `sys_district` VALUES ('2465', '283', '加查县', '0');
INSERT INTO `sys_district` VALUES ('2466', '283', '隆子县', '0');
INSERT INTO `sys_district` VALUES ('2467', '283', '错那县', '0');
INSERT INTO `sys_district` VALUES ('2468', '283', '浪卡子县', '0');
INSERT INTO `sys_district` VALUES ('2469', '284', '日喀则市', '0');
INSERT INTO `sys_district` VALUES ('2470', '284', '南木林县', '0');
INSERT INTO `sys_district` VALUES ('2471', '284', '江孜县', '0');
INSERT INTO `sys_district` VALUES ('2472', '284', '定日县', '0');
INSERT INTO `sys_district` VALUES ('2473', '284', '萨迦县', '0');
INSERT INTO `sys_district` VALUES ('2474', '284', '拉孜县', '0');
INSERT INTO `sys_district` VALUES ('2475', '284', '昂仁县', '0');
INSERT INTO `sys_district` VALUES ('2476', '284', '谢通门县', '0');
INSERT INTO `sys_district` VALUES ('2477', '284', '白朗县', '0');
INSERT INTO `sys_district` VALUES ('2478', '284', '仁布县', '0');
INSERT INTO `sys_district` VALUES ('2479', '284', '康马县', '0');
INSERT INTO `sys_district` VALUES ('2480', '284', '定结县', '0');
INSERT INTO `sys_district` VALUES ('2481', '284', '仲巴县', '0');
INSERT INTO `sys_district` VALUES ('2482', '284', '亚东县', '0');
INSERT INTO `sys_district` VALUES ('2483', '284', '吉隆县', '0');
INSERT INTO `sys_district` VALUES ('2484', '284', '聂拉木县', '0');
INSERT INTO `sys_district` VALUES ('2485', '284', '萨嘎县', '0');
INSERT INTO `sys_district` VALUES ('2486', '284', '岗巴县', '0');
INSERT INTO `sys_district` VALUES ('2487', '285', '那曲县', '0');
INSERT INTO `sys_district` VALUES ('2488', '285', '嘉黎县', '0');
INSERT INTO `sys_district` VALUES ('2489', '285', '比如县', '0');
INSERT INTO `sys_district` VALUES ('2490', '285', '聂荣县', '0');
INSERT INTO `sys_district` VALUES ('2491', '285', '安多县', '0');
INSERT INTO `sys_district` VALUES ('2492', '285', '申扎县', '0');
INSERT INTO `sys_district` VALUES ('2493', '285', '索县', '0');
INSERT INTO `sys_district` VALUES ('2494', '285', '班戈县', '0');
INSERT INTO `sys_district` VALUES ('2495', '285', '巴青县', '0');
INSERT INTO `sys_district` VALUES ('2496', '285', '尼玛县', '0');
INSERT INTO `sys_district` VALUES ('2497', '286', '普兰县', '0');
INSERT INTO `sys_district` VALUES ('2498', '286', '札达县', '0');
INSERT INTO `sys_district` VALUES ('2499', '286', '噶尔县', '0');
INSERT INTO `sys_district` VALUES ('2500', '286', '日土县', '0');
INSERT INTO `sys_district` VALUES ('2501', '286', '革吉县', '0');
INSERT INTO `sys_district` VALUES ('2502', '286', '改则县', '0');
INSERT INTO `sys_district` VALUES ('2503', '286', '措勤县', '0');
INSERT INTO `sys_district` VALUES ('2504', '287', '林芝县', '0');
INSERT INTO `sys_district` VALUES ('2505', '287', '工布江达县', '0');
INSERT INTO `sys_district` VALUES ('2506', '287', '米林县', '0');
INSERT INTO `sys_district` VALUES ('2507', '287', '墨脱县', '0');
INSERT INTO `sys_district` VALUES ('2508', '287', '波密县', '0');
INSERT INTO `sys_district` VALUES ('2509', '287', '察隅县', '0');
INSERT INTO `sys_district` VALUES ('2510', '287', '朗县', '0');
INSERT INTO `sys_district` VALUES ('2511', '288', '新城区', '0');
INSERT INTO `sys_district` VALUES ('2512', '288', '碑林区', '0');
INSERT INTO `sys_district` VALUES ('2513', '288', '莲湖区', '0');
INSERT INTO `sys_district` VALUES ('2514', '288', '灞桥区', '0');
INSERT INTO `sys_district` VALUES ('2515', '288', '未央区', '0');
INSERT INTO `sys_district` VALUES ('2516', '288', '雁塔区', '0');
INSERT INTO `sys_district` VALUES ('2517', '288', '阎良区', '0');
INSERT INTO `sys_district` VALUES ('2518', '288', '临潼区', '0');
INSERT INTO `sys_district` VALUES ('2519', '288', '长安区', '0');
INSERT INTO `sys_district` VALUES ('2520', '288', '蓝田县', '0');
INSERT INTO `sys_district` VALUES ('2521', '288', '周至县', '0');
INSERT INTO `sys_district` VALUES ('2522', '288', '户县', '0');
INSERT INTO `sys_district` VALUES ('2523', '288', '高陵县', '0');
INSERT INTO `sys_district` VALUES ('2524', '289', '王益区', '0');
INSERT INTO `sys_district` VALUES ('2525', '289', '印台区', '0');
INSERT INTO `sys_district` VALUES ('2526', '289', '耀州区', '0');
INSERT INTO `sys_district` VALUES ('2527', '289', '宜君县', '0');
INSERT INTO `sys_district` VALUES ('2528', '290', '渭滨区', '0');
INSERT INTO `sys_district` VALUES ('2529', '290', '金台区', '0');
INSERT INTO `sys_district` VALUES ('2530', '290', '陈仓区', '0');
INSERT INTO `sys_district` VALUES ('2531', '290', '凤翔县', '0');
INSERT INTO `sys_district` VALUES ('2532', '290', '岐山县', '0');
INSERT INTO `sys_district` VALUES ('2533', '290', '扶风县', '0');
INSERT INTO `sys_district` VALUES ('2534', '290', '眉县', '0');
INSERT INTO `sys_district` VALUES ('2535', '290', '陇县', '0');
INSERT INTO `sys_district` VALUES ('2536', '290', '千阳县', '0');
INSERT INTO `sys_district` VALUES ('2537', '290', '麟游县', '0');
INSERT INTO `sys_district` VALUES ('2538', '290', '凤县', '0');
INSERT INTO `sys_district` VALUES ('2539', '290', '太白县', '0');
INSERT INTO `sys_district` VALUES ('2540', '291', '秦都区', '0');
INSERT INTO `sys_district` VALUES ('2542', '291', '渭城区', '0');
INSERT INTO `sys_district` VALUES ('2543', '291', '三原县', '0');
INSERT INTO `sys_district` VALUES ('2544', '291', '泾阳县', '0');
INSERT INTO `sys_district` VALUES ('2545', '291', '乾县', '0');
INSERT INTO `sys_district` VALUES ('2546', '291', '礼泉县', '0');
INSERT INTO `sys_district` VALUES ('2547', '291', '永寿县', '0');
INSERT INTO `sys_district` VALUES ('2548', '291', '彬县', '0');
INSERT INTO `sys_district` VALUES ('2549', '291', '长武县', '0');
INSERT INTO `sys_district` VALUES ('2550', '291', '旬邑县', '0');
INSERT INTO `sys_district` VALUES ('2551', '291', '淳化县', '0');
INSERT INTO `sys_district` VALUES ('2552', '291', '武功县', '0');
INSERT INTO `sys_district` VALUES ('2553', '291', '兴平市', '0');
INSERT INTO `sys_district` VALUES ('2554', '292', '临渭区', '0');
INSERT INTO `sys_district` VALUES ('2555', '292', '华县', '0');
INSERT INTO `sys_district` VALUES ('2556', '292', '潼关县', '0');
INSERT INTO `sys_district` VALUES ('2557', '292', '大荔县', '0');
INSERT INTO `sys_district` VALUES ('2558', '292', '合阳县', '0');
INSERT INTO `sys_district` VALUES ('2559', '292', '澄城县', '0');
INSERT INTO `sys_district` VALUES ('2560', '292', '蒲城县', '0');
INSERT INTO `sys_district` VALUES ('2561', '292', '白水县', '0');
INSERT INTO `sys_district` VALUES ('2562', '292', '富平县', '0');
INSERT INTO `sys_district` VALUES ('2563', '292', '韩城市', '0');
INSERT INTO `sys_district` VALUES ('2564', '292', '华阴市', '0');
INSERT INTO `sys_district` VALUES ('2565', '293', '宝塔区', '0');
INSERT INTO `sys_district` VALUES ('2566', '293', '延长县', '0');
INSERT INTO `sys_district` VALUES ('2567', '293', '延川县', '0');
INSERT INTO `sys_district` VALUES ('2568', '293', '子长县', '0');
INSERT INTO `sys_district` VALUES ('2569', '293', '安塞县', '0');
INSERT INTO `sys_district` VALUES ('2570', '293', '志丹县', '0');
INSERT INTO `sys_district` VALUES ('2572', '293', '甘泉县', '0');
INSERT INTO `sys_district` VALUES ('2573', '293', '富县', '0');
INSERT INTO `sys_district` VALUES ('2574', '293', '洛川县', '0');
INSERT INTO `sys_district` VALUES ('2575', '293', '宜川县', '0');
INSERT INTO `sys_district` VALUES ('2576', '293', '黄龙县', '0');
INSERT INTO `sys_district` VALUES ('2577', '293', '黄陵县', '0');
INSERT INTO `sys_district` VALUES ('2578', '294', '汉台区', '0');
INSERT INTO `sys_district` VALUES ('2579', '294', '南郑县', '0');
INSERT INTO `sys_district` VALUES ('2580', '294', '城固县', '0');
INSERT INTO `sys_district` VALUES ('2581', '294', '洋县', '0');
INSERT INTO `sys_district` VALUES ('2582', '294', '西乡县', '0');
INSERT INTO `sys_district` VALUES ('2583', '294', '勉县', '0');
INSERT INTO `sys_district` VALUES ('2584', '294', '宁强县', '0');
INSERT INTO `sys_district` VALUES ('2585', '294', '略阳县', '0');
INSERT INTO `sys_district` VALUES ('2586', '294', '镇巴县', '0');
INSERT INTO `sys_district` VALUES ('2587', '294', '留坝县', '0');
INSERT INTO `sys_district` VALUES ('2588', '294', '佛坪县', '0');
INSERT INTO `sys_district` VALUES ('2589', '295', '榆阳区', '0');
INSERT INTO `sys_district` VALUES ('2590', '295', '神木县', '0');
INSERT INTO `sys_district` VALUES ('2591', '295', '府谷县', '0');
INSERT INTO `sys_district` VALUES ('2592', '295', '横山县', '0');
INSERT INTO `sys_district` VALUES ('2593', '295', '靖边县', '0');
INSERT INTO `sys_district` VALUES ('2594', '295', '定边县', '0');
INSERT INTO `sys_district` VALUES ('2595', '295', '绥德县', '0');
INSERT INTO `sys_district` VALUES ('2596', '295', '米脂县', '0');
INSERT INTO `sys_district` VALUES ('2597', '295', '佳县', '0');
INSERT INTO `sys_district` VALUES ('2598', '295', '吴堡县', '0');
INSERT INTO `sys_district` VALUES ('2599', '295', '清涧县', '0');
INSERT INTO `sys_district` VALUES ('2600', '295', '子洲县', '0');
INSERT INTO `sys_district` VALUES ('2601', '296', '汉滨区', '0');
INSERT INTO `sys_district` VALUES ('2602', '296', '汉阴县', '0');
INSERT INTO `sys_district` VALUES ('2603', '296', '石泉县', '0');
INSERT INTO `sys_district` VALUES ('2604', '296', '宁陕县', '0');
INSERT INTO `sys_district` VALUES ('2605', '296', '紫阳县', '0');
INSERT INTO `sys_district` VALUES ('2606', '296', '岚皋县', '0');
INSERT INTO `sys_district` VALUES ('2607', '296', '平利县', '0');
INSERT INTO `sys_district` VALUES ('2608', '296', '镇坪县', '0');
INSERT INTO `sys_district` VALUES ('2609', '296', '旬阳县', '0');
INSERT INTO `sys_district` VALUES ('2610', '296', '白河县', '0');
INSERT INTO `sys_district` VALUES ('2611', '297', '商州区', '0');
INSERT INTO `sys_district` VALUES ('2612', '297', '洛南县', '0');
INSERT INTO `sys_district` VALUES ('2613', '297', '丹凤县', '0');
INSERT INTO `sys_district` VALUES ('2614', '297', '商南县', '0');
INSERT INTO `sys_district` VALUES ('2615', '297', '山阳县', '0');
INSERT INTO `sys_district` VALUES ('2616', '297', '镇安县', '0');
INSERT INTO `sys_district` VALUES ('2617', '297', '柞水县', '0');
INSERT INTO `sys_district` VALUES ('2618', '298', '城关区', '0');
INSERT INTO `sys_district` VALUES ('2619', '298', '七里河区', '0');
INSERT INTO `sys_district` VALUES ('2620', '298', '西固区', '0');
INSERT INTO `sys_district` VALUES ('2621', '298', '安宁区', '0');
INSERT INTO `sys_district` VALUES ('2622', '298', '红古区', '0');
INSERT INTO `sys_district` VALUES ('2623', '298', '永登县', '0');
INSERT INTO `sys_district` VALUES ('2624', '298', '皋兰县', '0');
INSERT INTO `sys_district` VALUES ('2625', '298', '榆中县', '0');
INSERT INTO `sys_district` VALUES ('2626', '300', '金川区', '0');
INSERT INTO `sys_district` VALUES ('2627', '300', '永昌县', '0');
INSERT INTO `sys_district` VALUES ('2628', '301', '白银区', '0');
INSERT INTO `sys_district` VALUES ('2629', '301', '平川区', '0');
INSERT INTO `sys_district` VALUES ('2630', '301', '靖远县', '0');
INSERT INTO `sys_district` VALUES ('2631', '301', '会宁县', '0');
INSERT INTO `sys_district` VALUES ('2632', '301', '景泰县', '0');
INSERT INTO `sys_district` VALUES ('2635', '302', '清水县', '0');
INSERT INTO `sys_district` VALUES ('2636', '302', '秦安县', '0');
INSERT INTO `sys_district` VALUES ('2637', '302', '甘谷县', '0');
INSERT INTO `sys_district` VALUES ('2638', '302', '武山县', '0');
INSERT INTO `sys_district` VALUES ('2639', '302', '张家川回族自治县', '0');
INSERT INTO `sys_district` VALUES ('2640', '303', '凉州区', '0');
INSERT INTO `sys_district` VALUES ('2641', '303', '民勤县', '0');
INSERT INTO `sys_district` VALUES ('2642', '303', '古浪县', '0');
INSERT INTO `sys_district` VALUES ('2643', '303', '天祝藏族自治县', '0');
INSERT INTO `sys_district` VALUES ('2644', '304', '甘州区', '0');
INSERT INTO `sys_district` VALUES ('2645', '304', '肃南裕固族自治县', '0');
INSERT INTO `sys_district` VALUES ('2646', '304', '民乐县', '0');
INSERT INTO `sys_district` VALUES ('2647', '304', '临泽县', '0');
INSERT INTO `sys_district` VALUES ('2648', '304', '高台县', '0');
INSERT INTO `sys_district` VALUES ('2649', '304', '山丹县', '0');
INSERT INTO `sys_district` VALUES ('2650', '305', '崆峒区', '0');
INSERT INTO `sys_district` VALUES ('2651', '305', '泾川县', '0');
INSERT INTO `sys_district` VALUES ('2652', '305', '灵台县', '0');
INSERT INTO `sys_district` VALUES ('2653', '305', '崇信县', '0');
INSERT INTO `sys_district` VALUES ('2654', '305', '华亭县', '0');
INSERT INTO `sys_district` VALUES ('2655', '305', '庄浪县', '0');
INSERT INTO `sys_district` VALUES ('2656', '305', '静宁县', '0');
INSERT INTO `sys_district` VALUES ('2657', '306', '肃州区', '0');
INSERT INTO `sys_district` VALUES ('2658', '306', '金塔县', '0');
INSERT INTO `sys_district` VALUES ('2660', '306', '肃北蒙古族自治县', '0');
INSERT INTO `sys_district` VALUES ('2661', '306', '阿克塞哈萨克族自治县', '0');
INSERT INTO `sys_district` VALUES ('2662', '306', '玉门市', '0');
INSERT INTO `sys_district` VALUES ('2663', '306', '敦煌市', '0');
INSERT INTO `sys_district` VALUES ('2664', '307', '西峰区', '0');
INSERT INTO `sys_district` VALUES ('2665', '307', '庆城县', '0');
INSERT INTO `sys_district` VALUES ('2666', '307', '环县', '0');
INSERT INTO `sys_district` VALUES ('2667', '307', '华池县', '0');
INSERT INTO `sys_district` VALUES ('2668', '307', '合水县', '0');
INSERT INTO `sys_district` VALUES ('2669', '307', '正宁县', '0');
INSERT INTO `sys_district` VALUES ('2670', '307', '宁县', '0');
INSERT INTO `sys_district` VALUES ('2671', '307', '镇原县', '0');
INSERT INTO `sys_district` VALUES ('2672', '308', '安定区', '0');
INSERT INTO `sys_district` VALUES ('2673', '308', '通渭县', '0');
INSERT INTO `sys_district` VALUES ('2674', '308', '陇西县', '0');
INSERT INTO `sys_district` VALUES ('2675', '308', '渭源县', '0');
INSERT INTO `sys_district` VALUES ('2676', '308', '临洮县', '0');
INSERT INTO `sys_district` VALUES ('2677', '308', '漳县', '0');
INSERT INTO `sys_district` VALUES ('2678', '308', '岷县', '0');
INSERT INTO `sys_district` VALUES ('2679', '309', '武都区', '0');
INSERT INTO `sys_district` VALUES ('2680', '309', '成县', '0');
INSERT INTO `sys_district` VALUES ('2681', '309', '文县', '0');
INSERT INTO `sys_district` VALUES ('2682', '309', '宕昌县', '0');
INSERT INTO `sys_district` VALUES ('2683', '309', '康县', '0');
INSERT INTO `sys_district` VALUES ('2684', '309', '西和县', '0');
INSERT INTO `sys_district` VALUES ('2685', '309', '礼县', '0');
INSERT INTO `sys_district` VALUES ('2686', '309', '徽县', '0');
INSERT INTO `sys_district` VALUES ('2687', '309', '两当县', '0');
INSERT INTO `sys_district` VALUES ('2688', '310', '临夏市', '0');
INSERT INTO `sys_district` VALUES ('2689', '310', '临夏县', '0');
INSERT INTO `sys_district` VALUES ('2690', '310', '康乐县', '0');
INSERT INTO `sys_district` VALUES ('2691', '310', '永靖县', '0');
INSERT INTO `sys_district` VALUES ('2692', '310', '广河县', '0');
INSERT INTO `sys_district` VALUES ('2693', '310', '和政县', '0');
INSERT INTO `sys_district` VALUES ('2694', '310', '东乡族自治县', '0');
INSERT INTO `sys_district` VALUES ('2695', '310', '积石山保安族东乡族撒拉族自治县', '0');
INSERT INTO `sys_district` VALUES ('2696', '311', '合作市', '0');
INSERT INTO `sys_district` VALUES ('2697', '311', '临潭县', '0');
INSERT INTO `sys_district` VALUES ('2698', '311', '卓尼县', '0');
INSERT INTO `sys_district` VALUES ('2699', '311', '舟曲县', '0');
INSERT INTO `sys_district` VALUES ('2700', '311', '迭部县', '0');
INSERT INTO `sys_district` VALUES ('2701', '311', '玛曲县', '0');
INSERT INTO `sys_district` VALUES ('2702', '311', '碌曲县', '0');
INSERT INTO `sys_district` VALUES ('2703', '311', '夏河县', '0');
INSERT INTO `sys_district` VALUES ('2704', '312', '城东区', '0');
INSERT INTO `sys_district` VALUES ('2705', '312', '城中区', '0');
INSERT INTO `sys_district` VALUES ('2706', '312', '城西区', '0');
INSERT INTO `sys_district` VALUES ('2707', '312', '城北区', '0');
INSERT INTO `sys_district` VALUES ('2708', '312', '大通回族土族自治县', '0');
INSERT INTO `sys_district` VALUES ('2709', '312', '湟中县', '0');
INSERT INTO `sys_district` VALUES ('2710', '312', '湟源县', '0');
INSERT INTO `sys_district` VALUES ('2711', '313', '平安县', '0');
INSERT INTO `sys_district` VALUES ('2712', '313', '民和回族土族自治县', '0');
INSERT INTO `sys_district` VALUES ('2714', '313', '互助土族自治县', '0');
INSERT INTO `sys_district` VALUES ('2715', '313', '化隆回族自治县', '0');
INSERT INTO `sys_district` VALUES ('2716', '313', '循化撒拉族自治县', '0');
INSERT INTO `sys_district` VALUES ('2717', '314', '门源回族自治县', '0');
INSERT INTO `sys_district` VALUES ('2718', '314', '祁连县', '0');
INSERT INTO `sys_district` VALUES ('2719', '314', '海晏县', '0');
INSERT INTO `sys_district` VALUES ('2720', '314', '刚察县', '0');
INSERT INTO `sys_district` VALUES ('2721', '315', '同仁县', '0');
INSERT INTO `sys_district` VALUES ('2722', '315', '尖扎县', '0');
INSERT INTO `sys_district` VALUES ('2723', '315', '泽库县', '0');
INSERT INTO `sys_district` VALUES ('2724', '315', '河南蒙古族自治县', '0');
INSERT INTO `sys_district` VALUES ('2725', '316', '共和县', '0');
INSERT INTO `sys_district` VALUES ('2726', '316', '同德县', '0');
INSERT INTO `sys_district` VALUES ('2727', '316', '贵德县', '0');
INSERT INTO `sys_district` VALUES ('2728', '316', '兴海县', '0');
INSERT INTO `sys_district` VALUES ('2729', '316', '贵南县', '0');
INSERT INTO `sys_district` VALUES ('2730', '317', '玛沁县', '0');
INSERT INTO `sys_district` VALUES ('2731', '317', '班玛县', '0');
INSERT INTO `sys_district` VALUES ('2732', '317', '甘德县', '0');
INSERT INTO `sys_district` VALUES ('2733', '317', '达日县', '0');
INSERT INTO `sys_district` VALUES ('2734', '317', '久治县', '0');
INSERT INTO `sys_district` VALUES ('2735', '317', '玛多县', '0');
INSERT INTO `sys_district` VALUES ('2737', '318', '杂多县', '0');
INSERT INTO `sys_district` VALUES ('2738', '318', '称多县', '0');
INSERT INTO `sys_district` VALUES ('2739', '318', '治多县', '0');
INSERT INTO `sys_district` VALUES ('2740', '318', '囊谦县', '0');
INSERT INTO `sys_district` VALUES ('2741', '318', '曲麻莱县', '0');
INSERT INTO `sys_district` VALUES ('2742', '319', '格尔木市', '0');
INSERT INTO `sys_district` VALUES ('2743', '319', '德令哈市', '0');
INSERT INTO `sys_district` VALUES ('2744', '319', '乌兰县', '0');
INSERT INTO `sys_district` VALUES ('2745', '319', '都兰县', '0');
INSERT INTO `sys_district` VALUES ('2746', '319', '天峻县', '0');
INSERT INTO `sys_district` VALUES ('2747', '320', '兴庆区', '0');
INSERT INTO `sys_district` VALUES ('2748', '320', '西夏区', '0');
INSERT INTO `sys_district` VALUES ('2749', '320', '金凤区', '0');
INSERT INTO `sys_district` VALUES ('2750', '320', '永宁县', '0');
INSERT INTO `sys_district` VALUES ('2751', '320', '贺兰县', '0');
INSERT INTO `sys_district` VALUES ('2752', '320', '灵武市', '0');
INSERT INTO `sys_district` VALUES ('2753', '321', '大武口区', '0');
INSERT INTO `sys_district` VALUES ('2754', '321', '惠农区', '0');
INSERT INTO `sys_district` VALUES ('2755', '321', '平罗县', '0');
INSERT INTO `sys_district` VALUES ('2756', '322', '利通区', '0');
INSERT INTO `sys_district` VALUES ('2757', '322', '盐池县', '0');
INSERT INTO `sys_district` VALUES ('2758', '322', '同心县', '0');
INSERT INTO `sys_district` VALUES ('2759', '322', '青铜峡市', '0');
INSERT INTO `sys_district` VALUES ('2760', '323', '原州区', '0');
INSERT INTO `sys_district` VALUES ('2761', '323', '西吉县', '0');
INSERT INTO `sys_district` VALUES ('2762', '323', '隆德县', '0');
INSERT INTO `sys_district` VALUES ('2763', '323', '泾源县', '0');
INSERT INTO `sys_district` VALUES ('2764', '323', '彭阳县', '0');
INSERT INTO `sys_district` VALUES ('2765', '324', '沙坡头区', '0');
INSERT INTO `sys_district` VALUES ('2766', '324', '中宁县', '0');
INSERT INTO `sys_district` VALUES ('2767', '324', '海原县', '0');
INSERT INTO `sys_district` VALUES ('2768', '325', '天山区', '0');
INSERT INTO `sys_district` VALUES ('2769', '325', '沙依巴克区', '0');
INSERT INTO `sys_district` VALUES ('2770', '325', '新市区', '0');
INSERT INTO `sys_district` VALUES ('2771', '325', '水磨沟区', '0');
INSERT INTO `sys_district` VALUES ('2772', '325', '头屯河区', '0');
INSERT INTO `sys_district` VALUES ('2773', '325', '达坂城区', '0');
INSERT INTO `sys_district` VALUES ('2775', '325', '乌鲁木齐县', '0');
INSERT INTO `sys_district` VALUES ('2776', '326', '独山子区', '0');
INSERT INTO `sys_district` VALUES ('2777', '326', '克拉玛依区', '0');
INSERT INTO `sys_district` VALUES ('2778', '326', '白碱滩区', '0');
INSERT INTO `sys_district` VALUES ('2779', '326', '乌尔禾区', '0');
INSERT INTO `sys_district` VALUES ('2780', '327', '吐鲁番市', '0');
INSERT INTO `sys_district` VALUES ('2781', '327', '鄯善县', '0');
INSERT INTO `sys_district` VALUES ('2782', '327', '托克逊县', '0');
INSERT INTO `sys_district` VALUES ('2783', '328', '哈密市', '0');
INSERT INTO `sys_district` VALUES ('2784', '328', '巴里坤哈萨克自治县', '0');
INSERT INTO `sys_district` VALUES ('2785', '328', '伊吾县', '0');
INSERT INTO `sys_district` VALUES ('2786', '329', '昌吉市', '0');
INSERT INTO `sys_district` VALUES ('2787', '329', '阜康市', '0');
INSERT INTO `sys_district` VALUES ('2789', '329', '呼图壁县', '0');
INSERT INTO `sys_district` VALUES ('2790', '329', '玛纳斯县', '0');
INSERT INTO `sys_district` VALUES ('2791', '329', '奇台县', '0');
INSERT INTO `sys_district` VALUES ('2792', '329', '吉木萨尔县', '0');
INSERT INTO `sys_district` VALUES ('2793', '329', '木垒哈萨克自治县', '0');
INSERT INTO `sys_district` VALUES ('2794', '330', '博乐市', '0');
INSERT INTO `sys_district` VALUES ('2795', '330', '精河县', '0');
INSERT INTO `sys_district` VALUES ('2796', '330', '温泉县', '0');
INSERT INTO `sys_district` VALUES ('2797', '331', '库尔勒市', '0');
INSERT INTO `sys_district` VALUES ('2798', '331', '轮台县', '0');
INSERT INTO `sys_district` VALUES ('2799', '331', '尉犁县', '0');
INSERT INTO `sys_district` VALUES ('2800', '331', '若羌县', '0');
INSERT INTO `sys_district` VALUES ('2801', '331', '且末县', '0');
INSERT INTO `sys_district` VALUES ('2802', '331', '焉耆回族自治县', '0');
INSERT INTO `sys_district` VALUES ('2803', '331', '和静县', '0');
INSERT INTO `sys_district` VALUES ('2804', '331', '和硕县', '0');
INSERT INTO `sys_district` VALUES ('2805', '331', '博湖县', '0');
INSERT INTO `sys_district` VALUES ('2806', '332', '阿克苏市', '0');
INSERT INTO `sys_district` VALUES ('2807', '332', '温宿县', '0');
INSERT INTO `sys_district` VALUES ('2808', '332', '库车县', '0');
INSERT INTO `sys_district` VALUES ('2809', '332', '沙雅县', '0');
INSERT INTO `sys_district` VALUES ('2810', '332', '新和县', '0');
INSERT INTO `sys_district` VALUES ('2811', '332', '拜城县', '0');
INSERT INTO `sys_district` VALUES ('2812', '332', '乌什县', '0');
INSERT INTO `sys_district` VALUES ('2813', '332', '阿瓦提县', '0');
INSERT INTO `sys_district` VALUES ('2814', '332', '柯坪县', '0');
INSERT INTO `sys_district` VALUES ('2815', '333', '阿图什市', '0');
INSERT INTO `sys_district` VALUES ('2816', '333', '阿克陶县', '0');
INSERT INTO `sys_district` VALUES ('2817', '333', '阿合奇县', '0');
INSERT INTO `sys_district` VALUES ('2818', '333', '乌恰县', '0');
INSERT INTO `sys_district` VALUES ('2819', '334', '喀什市', '0');
INSERT INTO `sys_district` VALUES ('2820', '334', '疏附县', '0');
INSERT INTO `sys_district` VALUES ('2821', '334', '疏勒县', '0');
INSERT INTO `sys_district` VALUES ('2822', '334', '英吉沙县', '0');
INSERT INTO `sys_district` VALUES ('2823', '334', '泽普县', '0');
INSERT INTO `sys_district` VALUES ('2824', '334', '莎车县', '0');
INSERT INTO `sys_district` VALUES ('2825', '334', '叶城县', '0');
INSERT INTO `sys_district` VALUES ('2826', '334', '麦盖提县', '0');
INSERT INTO `sys_district` VALUES ('2827', '334', '岳普湖县', '0');
INSERT INTO `sys_district` VALUES ('2828', '334', '伽师县', '0');
INSERT INTO `sys_district` VALUES ('2829', '334', '巴楚县', '0');
INSERT INTO `sys_district` VALUES ('2830', '334', '塔什库尔干塔吉克自治县', '0');
INSERT INTO `sys_district` VALUES ('2831', '335', '和田市', '0');
INSERT INTO `sys_district` VALUES ('2832', '335', '和田县', '0');
INSERT INTO `sys_district` VALUES ('2833', '335', '墨玉县', '0');
INSERT INTO `sys_district` VALUES ('2834', '335', '皮山县', '0');
INSERT INTO `sys_district` VALUES ('2835', '335', '洛浦县', '0');
INSERT INTO `sys_district` VALUES ('2836', '335', '策勒县', '0');
INSERT INTO `sys_district` VALUES ('2837', '335', '于田县', '0');
INSERT INTO `sys_district` VALUES ('2838', '335', '民丰县', '0');
INSERT INTO `sys_district` VALUES ('2839', '336', '伊宁市', '0');
INSERT INTO `sys_district` VALUES ('2840', '336', '奎屯市', '0');
INSERT INTO `sys_district` VALUES ('2841', '336', '伊宁县', '0');
INSERT INTO `sys_district` VALUES ('2842', '336', '察布查尔锡伯自治县', '0');
INSERT INTO `sys_district` VALUES ('2843', '336', '霍城县', '0');
INSERT INTO `sys_district` VALUES ('2844', '336', '巩留县', '0');
INSERT INTO `sys_district` VALUES ('2845', '336', '新源县', '0');
INSERT INTO `sys_district` VALUES ('2846', '336', '昭苏县', '0');
INSERT INTO `sys_district` VALUES ('2847', '336', '特克斯县', '0');
INSERT INTO `sys_district` VALUES ('2848', '336', '尼勒克县', '0');
INSERT INTO `sys_district` VALUES ('2849', '337', '塔城市', '0');
INSERT INTO `sys_district` VALUES ('2850', '337', '乌苏市', '0');
INSERT INTO `sys_district` VALUES ('2851', '337', '额敏县', '0');
INSERT INTO `sys_district` VALUES ('2852', '337', '沙湾县', '0');
INSERT INTO `sys_district` VALUES ('2853', '337', '托里县', '0');
INSERT INTO `sys_district` VALUES ('2854', '337', '裕民县', '0');
INSERT INTO `sys_district` VALUES ('2855', '337', '和布克赛尔蒙古自治县', '0');
INSERT INTO `sys_district` VALUES ('2856', '338', '阿勒泰市', '0');
INSERT INTO `sys_district` VALUES ('2857', '338', '布尔津县', '0');
INSERT INTO `sys_district` VALUES ('2858', '338', '富蕴县', '0');
INSERT INTO `sys_district` VALUES ('2859', '338', '福海县', '0');
INSERT INTO `sys_district` VALUES ('2860', '338', '哈巴河县', '0');
INSERT INTO `sys_district` VALUES ('2861', '338', '青河县', '0');
INSERT INTO `sys_district` VALUES ('2862', '338', '吉木乃县', '0');
INSERT INTO `sys_district` VALUES ('3500', '4', '曹妃甸区', '0');
INSERT INTO `sys_district` VALUES ('3501', '26', '白云鄂博矿区', '0');
INSERT INTO `sys_district` VALUES ('3502', '43', '北镇市', '0');
INSERT INTO `sys_district` VALUES ('3503', '60', '阿城区', '0');
INSERT INTO `sys_district` VALUES ('3504', '102', '博望区', '0');
INSERT INTO `sys_district` VALUES ('3505', '154', '瀍河回族区', '0');
INSERT INTO `sys_district` VALUES ('3506', '215', '潮安区', '0');
INSERT INTO `sys_district` VALUES ('3507', '365', '南沙群岛', '0');
INSERT INTO `sys_district` VALUES ('3508', '249', '达川区', '0');
INSERT INTO `sys_district` VALUES ('3509', '260', '碧江区', '0');
INSERT INTO `sys_district` VALUES ('3510', '397', '江城哈尼族彝族自治县', '0');
INSERT INTO `sys_district` VALUES ('3511', '322', '红寺堡区', '0');
INSERT INTO `sys_district` VALUES ('3512', '330', '阿拉山口市', '0');
INSERT INTO `sys_district` VALUES ('3513', '363', '北投区', '0');
INSERT INTO `sys_district` VALUES ('3514', '345', '阿莲区', '0');
INSERT INTO `sys_district` VALUES ('3515', '394', '安定区', '0');
INSERT INTO `sys_district` VALUES ('3516', '382', '北区', '0');
INSERT INTO `sys_district` VALUES ('3517', '355', '金城镇', '0');
INSERT INTO `sys_district` VALUES ('3518', '359', '草屯镇', '0');
INSERT INTO `sys_district` VALUES ('3519', '354', '安乐区', '0');
INSERT INTO `sys_district` VALUES ('3520', '396', '北区', '0');
INSERT INTO `sys_district` VALUES ('3521', '374', '东区', '0');
INSERT INTO `sys_district` VALUES ('3522', '383', '八里区', '0');
INSERT INTO `sys_district` VALUES ('3523', '371', '大同乡', '0');
INSERT INTO `sys_district` VALUES ('3524', '384', '宝山乡', '0');
INSERT INTO `sys_district` VALUES ('3525', '390', '八德市', '0');
INSERT INTO `sys_district` VALUES ('3526', '358', '大湖乡', '0');
INSERT INTO `sys_district` VALUES ('3527', '371', '北斗镇', '0');
INSERT INTO `sys_district` VALUES ('3528', '353', '阿里山乡', '0');
INSERT INTO `sys_district` VALUES ('3529', '391', '褒忠乡', '0');
INSERT INTO `sys_district` VALUES ('3530', '362', '长治乡', '0');
INSERT INTO `sys_district` VALUES ('3531', '381', '卑南乡', '0');
INSERT INTO `sys_district` VALUES ('3532', '348', '丰滨乡', '0');
INSERT INTO `sys_district` VALUES ('3533', '360', '白沙乡', '0');
INSERT INTO `sys_district` VALUES ('3534', '377', '北竿乡', '0');
INSERT INTO `sys_district` VALUES ('3535', '343', '东区', '0');
INSERT INTO `sys_district` VALUES ('3536', '372', '观塘区', '0');
INSERT INTO `sys_district` VALUES ('3537', '351', '北区', '0');
INSERT INTO `sys_district` VALUES ('3538', '352', '北海街道', '0');
INSERT INTO `sys_district` VALUES ('3539', '366', '陈场镇', '0');
INSERT INTO `sys_district` VALUES ('3540', '387', '白鹭湖管理区', '0');
INSERT INTO `sys_district` VALUES ('3541', '379', '白茅湖农场', '0');
INSERT INTO `sys_district` VALUES ('3542', '182', '红坪镇', '0');
INSERT INTO `sys_district` VALUES ('3543', '213', '常平镇', '0');
INSERT INTO `sys_district` VALUES ('3544', '214', '板芙镇', '0');
INSERT INTO `sys_district` VALUES ('3545', '233', '凤凰镇', '0');
INSERT INTO `sys_district` VALUES ('3546', '370', '畅好乡', '0');
INSERT INTO `sys_district` VALUES ('3547', '380', '彬村山华侨农场', '0');
INSERT INTO `sys_district` VALUES ('3548', '395', '白马井镇', '0');
INSERT INTO `sys_district` VALUES ('3549', '369', '抱罗镇', '0');
INSERT INTO `sys_district` VALUES ('3550', '368', '北大镇', '0');
INSERT INTO `sys_district` VALUES ('3551', '356', '板桥镇', '0');
INSERT INTO `sys_district` VALUES ('3552', '376', '定城镇', '0');
INSERT INTO `sys_district` VALUES ('3553', '367', '枫木镇', '0');
INSERT INTO `sys_district` VALUES ('3554', '375', '大丰镇', '0');
INSERT INTO `sys_district` VALUES ('3555', '388', '博厚镇', '0');
INSERT INTO `sys_district` VALUES ('3556', '346', '邦溪镇', '0');
INSERT INTO `sys_district` VALUES ('3557', '392', '叉河镇', '0');
INSERT INTO `sys_district` VALUES ('3558', '378', '抱由镇', '0');
INSERT INTO `sys_district` VALUES ('3559', '361', '本号镇', '0');
INSERT INTO `sys_district` VALUES ('3560', '347', '保城镇', '0');
INSERT INTO `sys_district` VALUES ('3561', '364', '吊罗山乡', '0');
INSERT INTO `sys_district` VALUES ('3562', '299', '镜铁区', '0');
INSERT INTO `sys_district` VALUES ('3563', '339', '北泉镇', '0');
INSERT INTO `sys_district` VALUES ('3564', '340', '阿拉尔农场', '0');
INSERT INTO `sys_district` VALUES ('3565', '341', '兵团四十九团', '0');
INSERT INTO `sys_district` VALUES ('3566', '342', '兵团一零二团', '0');
INSERT INTO `sys_district` VALUES ('3567', '57', '扶余市', '0');
INSERT INTO `sys_district` VALUES ('3568', '72', '呼中区', '0');
INSERT INTO `sys_district` VALUES ('3569', '74', '高淳区', '0');
INSERT INTO `sys_district` VALUES ('3570', '78', '姑苏区', '0');
INSERT INTO `sys_district` VALUES ('3571', '81', '淮安区', '0');
INSERT INTO `sys_district` VALUES ('3572', '153', '金明区', '0');
INSERT INTO `sys_district` VALUES ('3573', '180', '随县', '0');
INSERT INTO `sys_district` VALUES ('3574', '197', '从化市', '0');
INSERT INTO `sys_district` VALUES ('3575', '199', '大鹏新区', '0');
INSERT INTO `sys_district` VALUES ('3576', '216', '揭东区', '0');
INSERT INTO `sys_district` VALUES ('3577', '365', '西沙群岛', '0');
INSERT INTO `sys_district` VALUES ('3578', '251', '恩阳区', '0');
INSERT INTO `sys_district` VALUES ('3579', '256', '观山湖区', '0');
INSERT INTO `sys_district` VALUES ('3580', '265', '呈贡区', '0');
INSERT INTO `sys_district` VALUES ('3581', '397', '景东彝族自治县', '0');
INSERT INTO `sys_district` VALUES ('3582', '302', '麦积区', '0');
INSERT INTO `sys_district` VALUES ('3583', '325', '米东区', '0');
INSERT INTO `sys_district` VALUES ('3584', '363', '大安区', '0');
INSERT INTO `sys_district` VALUES ('3585', '345', '大寮区', '0');
INSERT INTO `sys_district` VALUES ('3586', '394', '安南区', '0');
INSERT INTO `sys_district` VALUES ('3587', '382', '北屯区', '0');
INSERT INTO `sys_district` VALUES ('3588', '355', '金湖镇', '0');
INSERT INTO `sys_district` VALUES ('3589', '359', '国姓乡', '0');
INSERT INTO `sys_district` VALUES ('3590', '354', '暖暖区', '0');
INSERT INTO `sys_district` VALUES ('3591', '396', '东区', '0');
INSERT INTO `sys_district` VALUES ('3592', '374', '西区', '0');
INSERT INTO `sys_district` VALUES ('3593', '383', '板桥区', '0');
INSERT INTO `sys_district` VALUES ('3594', '371', '钓鱼台', '0');
INSERT INTO `sys_district` VALUES ('3595', '384', '北埔乡', '0');
INSERT INTO `sys_district` VALUES ('3596', '390', '大溪镇', '0');
INSERT INTO `sys_district` VALUES ('3597', '358', '公馆乡', '0');
INSERT INTO `sys_district` VALUES ('3598', '371', '大城乡', '0');
INSERT INTO `sys_district` VALUES ('3599', '353', '鹿草乡', '0');
INSERT INTO `sys_district` VALUES ('3600', '391', '北港镇', '0');
INSERT INTO `sys_district` VALUES ('3601', '362', '潮州镇', '0');
INSERT INTO `sys_district` VALUES ('3602', '381', '长滨乡', '0');
INSERT INTO `sys_district` VALUES ('3603', '348', '凤林镇', '0');
INSERT INTO `sys_district` VALUES ('3604', '360', '七美乡', '0');
INSERT INTO `sys_district` VALUES ('3605', '377', '东引乡', '0');
INSERT INTO `sys_district` VALUES ('3606', '343', '南区', '0');
INSERT INTO `sys_district` VALUES ('3607', '372', '黄大仙区', '0');
INSERT INTO `sys_district` VALUES ('3608', '351', '大埔区', '0');
INSERT INTO `sys_district` VALUES ('3609', '352', '承留镇', '0');
INSERT INTO `sys_district` VALUES ('3610', '366', '畜禽良种场', '0');
INSERT INTO `sys_district` VALUES ('3611', '387', '高场办事处', '0');
INSERT INTO `sys_district` VALUES ('3612', '379', '沉湖管委会', '0');
INSERT INTO `sys_district` VALUES ('3613', '182', '九湖镇', '0');
INSERT INTO `sys_district` VALUES ('3614', '213', '茶山镇', '0');
INSERT INTO `sys_district` VALUES ('3615', '214', '大涌镇', '0');
INSERT INTO `sys_district` VALUES ('3616', '233', '国营立才农场', '0');
INSERT INTO `sys_district` VALUES ('3617', '370', '番阳镇', '0');
INSERT INTO `sys_district` VALUES ('3618', '380', '博鳌镇', '0');
INSERT INTO `sys_district` VALUES ('3619', '395', '大成镇', '0');
INSERT INTO `sys_district` VALUES ('3620', '369', '昌洒镇', '0');
INSERT INTO `sys_district` VALUES ('3621', '368', '大茂镇', '0');
INSERT INTO `sys_district` VALUES ('3622', '356', '八所镇', '0');
INSERT INTO `sys_district` VALUES ('3623', '376', '富文镇', '0');
INSERT INTO `sys_district` VALUES ('3624', '367', '国营中建农场', '0');
INSERT INTO `sys_district` VALUES ('3625', '375', '福山镇', '0');
INSERT INTO `sys_district` VALUES ('3626', '388', '波莲镇', '0');
INSERT INTO `sys_district` VALUES ('3627', '346', '打安镇', '0');
INSERT INTO `sys_district` VALUES ('3628', '392', '昌化镇', '0');
INSERT INTO `sys_district` VALUES ('3629', '378', '大安镇', '0');
INSERT INTO `sys_district` VALUES ('3630', '361', '光坡镇', '0');
INSERT INTO `sys_district` VALUES ('3631', '347', '国营金江农场', '0');
INSERT INTO `sys_district` VALUES ('3632', '364', '国营加钗农场', '0');
INSERT INTO `sys_district` VALUES ('3633', '299', '文殊镇', '0');
INSERT INTO `sys_district` VALUES ('3634', '339', '兵团一五二团', '0');
INSERT INTO `sys_district` VALUES ('3635', '340', '兵团八团', '0');
INSERT INTO `sys_district` VALUES ('3636', '341', '兵团四十四团', '0');
INSERT INTO `sys_district` VALUES ('3637', '342', '兵团一零三团', '0');
INSERT INTO `sys_district` VALUES ('3638', '2', '滨海新区', '0');
INSERT INTO `sys_district` VALUES ('3639', '56', '浑江区', '0');
INSERT INTO `sys_district` VALUES ('3640', '72', '加格达奇区', '0');
INSERT INTO `sys_district` VALUES ('3641', '85', '姜堰区', '0');
INSERT INTO `sys_district` VALUES ('3642', '98', '巢湖市', '0');
INSERT INTO `sys_district` VALUES ('3643', '102', '含山县', '0');
INSERT INTO `sys_district` VALUES ('3644', '127', '共青城市', '0');
INSERT INTO `sys_district` VALUES ('3645', '226', '福绵区', '0');
INSERT INTO `sys_district` VALUES ('3646', '228', '平桂管理区', '0');
INSERT INTO `sys_district` VALUES ('3647', '231', '江州区', '0');
INSERT INTO `sys_district` VALUES ('3648', '365', '中沙群岛的岛礁及其海域', '0');
INSERT INTO `sys_district` VALUES ('3649', '397', '景谷傣族彝族自治县', '0');
INSERT INTO `sys_district` VALUES ('3650', '278', '芒市', '0');
INSERT INTO `sys_district` VALUES ('3651', '306', '瓜州县', '0');
INSERT INTO `sys_district` VALUES ('3652', '313', '乐都区', '0');
INSERT INTO `sys_district` VALUES ('3653', '363', '大同区', '0');
INSERT INTO `sys_district` VALUES ('3654', '345', '大社区', '0');
INSERT INTO `sys_district` VALUES ('3655', '394', '安平区', '0');
INSERT INTO `sys_district` VALUES ('3656', '382', '大安区', '0');
INSERT INTO `sys_district` VALUES ('3657', '355', '金宁乡', '0');
INSERT INTO `sys_district` VALUES ('3658', '359', '中寮乡', '0');
INSERT INTO `sys_district` VALUES ('3659', '354', '七堵区', '0');
INSERT INTO `sys_district` VALUES ('3660', '396', '香山区', '0');
INSERT INTO `sys_district` VALUES ('3661', '383', '淡水区', '0');
INSERT INTO `sys_district` VALUES ('3662', '371', '冬山乡', '0');
INSERT INTO `sys_district` VALUES ('3663', '384', '芎林乡', '0');
INSERT INTO `sys_district` VALUES ('3664', '390', '大园乡', '0');
INSERT INTO `sys_district` VALUES ('3665', '358', '后龙镇', '0');
INSERT INTO `sys_district` VALUES ('3666', '371', '大村乡', '0');
INSERT INTO `sys_district` VALUES ('3667', '353', '布袋镇', '0');
INSERT INTO `sys_district` VALUES ('3668', '391', '莿桐乡', '0');
INSERT INTO `sys_district` VALUES ('3669', '362', '车城乡', '0');
INSERT INTO `sys_district` VALUES ('3670', '381', '成功镇', '0');
INSERT INTO `sys_district` VALUES ('3671', '348', '富里乡', '0');
INSERT INTO `sys_district` VALUES ('3672', '360', '湖西乡', '0');
INSERT INTO `sys_district` VALUES ('3673', '377', '莒光乡', '0');
INSERT INTO `sys_district` VALUES ('3674', '343', '湾仔', '0');
INSERT INTO `sys_district` VALUES ('3675', '372', '九龙城区', '0');
INSERT INTO `sys_district` VALUES ('3676', '351', '葵青区', '0');
INSERT INTO `sys_district` VALUES ('3677', '352', '大峪镇', '0');
INSERT INTO `sys_district` VALUES ('3678', '366', '豆河镇', '0');
INSERT INTO `sys_district` VALUES ('3679', '387', '高石碑镇', '0');
INSERT INTO `sys_district` VALUES ('3680', '379', '多宝镇', '0');
INSERT INTO `sys_district` VALUES ('3681', '182', '木鱼镇', '0');
INSERT INTO `sys_district` VALUES ('3682', '213', '大朗镇', '0');
INSERT INTO `sys_district` VALUES ('3683', '214', '东凤镇', '0');
INSERT INTO `sys_district` VALUES ('3684', '233', '国营南滨农场', '0');
INSERT INTO `sys_district` VALUES ('3685', '370', '国营畅好农场', '0');
INSERT INTO `sys_district` VALUES ('3686', '380', '大路镇', '0');
INSERT INTO `sys_district` VALUES ('3687', '395', '东成镇', '0');
INSERT INTO `sys_district` VALUES ('3688', '369', '东阁镇', '0');
INSERT INTO `sys_district` VALUES ('3689', '368', '地方国营六连林场', '0');
INSERT INTO `sys_district` VALUES ('3690', '356', '大田镇', '0');
INSERT INTO `sys_district` VALUES ('3691', '376', '国营金鸡岭农场', '0');
INSERT INTO `sys_district` VALUES ('3692', '367', '国营中坤农场', '0');
INSERT INTO `sys_district` VALUES ('3693', '375', '国营红光农场', '0');
INSERT INTO `sys_district` VALUES ('3694', '388', '调楼镇', '0');
INSERT INTO `sys_district` VALUES ('3695', '346', '阜龙乡', '0');
INSERT INTO `sys_district` VALUES ('3696', '392', '国营霸王岭林场', '0');
INSERT INTO `sys_district` VALUES ('3697', '378', '佛罗镇', '0');
INSERT INTO `sys_district` VALUES ('3698', '361', '国营吊罗山林业公司', '0');
INSERT INTO `sys_district` VALUES ('3699', '347', '国营三道农场', '0');
INSERT INTO `sys_district` VALUES ('3700', '364', '国营黎母山林业公司', '0');
INSERT INTO `sys_district` VALUES ('3701', '299', '新城镇', '0');
INSERT INTO `sys_district` VALUES ('3702', '339', '东城街道', '0');
INSERT INTO `sys_district` VALUES ('3703', '340', '兵团第一师水利水电工程处', '0');
INSERT INTO `sys_district` VALUES ('3704', '341', '兵团图木舒克市喀拉拜勒镇', '0');
INSERT INTO `sys_district` VALUES ('3705', '342', '兵团一零一团', '0');
INSERT INTO `sys_district` VALUES ('3706', '56', '江源区', '0');
INSERT INTO `sys_district` VALUES ('3707', '76', '铜山区', '0');
INSERT INTO `sys_district` VALUES ('3708', '90', '南湖区', '0');
INSERT INTO `sys_district` VALUES ('3709', '102', '和县', '0');
INSERT INTO `sys_district` VALUES ('3710', '199', '光明新区', '0');
INSERT INTO `sys_district` VALUES ('3711', '241', '利州区', '0');
INSERT INTO `sys_district` VALUES ('3712', '248', '前锋区', '0');
INSERT INTO `sys_district` VALUES ('3713', '250', '名山区', '0');
INSERT INTO `sys_district` VALUES ('3714', '397', '澜沧拉祜族自治县', '0');
INSERT INTO `sys_district` VALUES ('3715', '318', '玉树市', '0');
INSERT INTO `sys_district` VALUES ('3716', '363', '南港区', '0');
INSERT INTO `sys_district` VALUES ('3717', '345', '大树区', '0');
INSERT INTO `sys_district` VALUES ('3718', '394', '白河区', '0');
INSERT INTO `sys_district` VALUES ('3719', '382', '大肚区', '0');
INSERT INTO `sys_district` VALUES ('3720', '355', '金沙镇', '0');
INSERT INTO `sys_district` VALUES ('3721', '359', '竹山镇', '0');
INSERT INTO `sys_district` VALUES ('3722', '354', '仁爱区', '0');
INSERT INTO `sys_district` VALUES ('3723', '383', '贡寮区', '0');
INSERT INTO `sys_district` VALUES ('3724', '371', '壮围乡', '0');
INSERT INTO `sys_district` VALUES ('3725', '384', '峨眉乡', '0');
INSERT INTO `sys_district` VALUES ('3726', '390', '复兴乡', '0');
INSERT INTO `sys_district` VALUES ('3727', '358', '竹南镇', '0');
INSERT INTO `sys_district` VALUES ('3728', '371', '二林镇', '0');
INSERT INTO `sys_district` VALUES ('3729', '353', '大林镇', '0');
INSERT INTO `sys_district` VALUES ('3730', '391', '大埤乡', '0');
INSERT INTO `sys_district` VALUES ('3731', '362', '春日乡', '0');
INSERT INTO `sys_district` VALUES ('3732', '381', '池上乡', '0');
INSERT INTO `sys_district` VALUES ('3733', '348', '光复乡', '0');
INSERT INTO `sys_district` VALUES ('3734', '360', '马公市', '0');
INSERT INTO `sys_district` VALUES ('3735', '377', '南竿乡', '0');
INSERT INTO `sys_district` VALUES ('3736', '343', '中西区', '0');
INSERT INTO `sys_district` VALUES ('3737', '372', '深水埗区', '0');
INSERT INTO `sys_district` VALUES ('3738', '351', '离岛区', '0');
INSERT INTO `sys_district` VALUES ('3739', '352', '济水街道', '0');
INSERT INTO `sys_district` VALUES ('3740', '366', '干河街道', '0');
INSERT INTO `sys_district` VALUES ('3741', '387', '广华办事处', '0');
INSERT INTO `sys_district` VALUES ('3742', '379', '多祥镇', '0');
INSERT INTO `sys_district` VALUES ('3743', '182', '松柏镇', '0');
INSERT INTO `sys_district` VALUES ('3744', '213', '大岭山镇', '0');
INSERT INTO `sys_district` VALUES ('3745', '214', '东区街道', '0');
INSERT INTO `sys_district` VALUES ('3746', '233', '国营南田农场', '0');
INSERT INTO `sys_district` VALUES ('3747', '370', '毛道乡', '0');
INSERT INTO `sys_district` VALUES ('3748', '380', '国营东红农场', '0');
INSERT INTO `sys_district` VALUES ('3749', '395', '峨蔓镇', '0');
INSERT INTO `sys_district` VALUES ('3750', '369', '东郊镇', '0');
INSERT INTO `sys_district` VALUES ('3751', '368', '东澳镇', '0');
INSERT INTO `sys_district` VALUES ('3752', '356', '东方华侨农场', '0');
INSERT INTO `sys_district` VALUES ('3753', '376', '国营南海农场', '0');
INSERT INTO `sys_district` VALUES ('3754', '367', '南坤镇', '0');
INSERT INTO `sys_district` VALUES ('3755', '375', '国营金安农场', '0');
INSERT INTO `sys_district` VALUES ('3756', '388', '东英镇', '0');
INSERT INTO `sys_district` VALUES ('3757', '346', '国营白沙农场', '0');
INSERT INTO `sys_district` VALUES ('3758', '392', '国营红林农场', '0');
INSERT INTO `sys_district` VALUES ('3759', '378', '国营保国农场', '0');
INSERT INTO `sys_district` VALUES ('3760', '361', '国营岭门农场', '0');
INSERT INTO `sys_district` VALUES ('3761', '347', '国营新星农场', '0');
INSERT INTO `sys_district` VALUES ('3762', '364', '国营乌石农场', '0');
INSERT INTO `sys_district` VALUES ('3763', '299', '雄关区', '0');
INSERT INTO `sys_district` VALUES ('3764', '339', '红山街道', '0');
INSERT INTO `sys_district` VALUES ('3765', '340', '兵团第一师塔里木灌区水利管理处', '0');
INSERT INTO `sys_district` VALUES ('3766', '341', '兵团图木舒克市永安坝', '0');
INSERT INTO `sys_district` VALUES ('3767', '342', '军垦路街道', '0');
INSERT INTO `sys_district` VALUES ('3768', '72', '松岭区', '0');
INSERT INTO `sys_district` VALUES ('3769', '83', '江都区', '0');
INSERT INTO `sys_district` VALUES ('3770', '99', '三山区', '0');
INSERT INTO `sys_district` VALUES ('3771', '220', '临桂区', '0');
INSERT INTO `sys_district` VALUES ('3772', '221', '龙圩区', '0');
INSERT INTO `sys_district` VALUES ('3773', '397', '孟连傣族拉祜族佤族自治县', '0');
INSERT INTO `sys_district` VALUES ('3774', '302', '秦州区', '0');
INSERT INTO `sys_district` VALUES ('3775', '363', '内湖区', '0');
INSERT INTO `sys_district` VALUES ('3776', '345', '凤山区', '0');
INSERT INTO `sys_district` VALUES ('3777', '394', '北门区', '0');
INSERT INTO `sys_district` VALUES ('3778', '382', '大甲区', '0');
INSERT INTO `sys_district` VALUES ('3779', '355', '烈屿乡', '0');
INSERT INTO `sys_district` VALUES ('3780', '359', '集集镇', '0');
INSERT INTO `sys_district` VALUES ('3781', '354', '信义区', '0');
INSERT INTO `sys_district` VALUES ('3782', '383', '中和区', '0');
INSERT INTO `sys_district` VALUES ('3783', '371', '礁溪乡', '0');
INSERT INTO `sys_district` VALUES ('3784', '384', '关西镇', '0');
INSERT INTO `sys_district` VALUES ('3785', '390', '观音乡', '0');
INSERT INTO `sys_district` VALUES ('3786', '358', '卓兰镇', '0');
INSERT INTO `sys_district` VALUES ('3787', '371', '二水乡', '0');
INSERT INTO `sys_district` VALUES ('3788', '353', '大埔乡', '0');
INSERT INTO `sys_district` VALUES ('3789', '391', '东势乡', '0');
INSERT INTO `sys_district` VALUES ('3790', '362', '东港镇', '0');
INSERT INTO `sys_district` VALUES ('3791', '381', '达仁乡', '0');
INSERT INTO `sys_district` VALUES ('3792', '348', '花莲市', '0');
INSERT INTO `sys_district` VALUES ('3793', '360', '西屿乡', '0');
INSERT INTO `sys_district` VALUES ('3794', '372', '油尖旺区', '0');
INSERT INTO `sys_district` VALUES ('3795', '351', '荃湾区', '0');
INSERT INTO `sys_district` VALUES ('3796', '352', '克井镇', '0');
INSERT INTO `sys_district` VALUES ('3797', '366', '工业园区', '0');
INSERT INTO `sys_district` VALUES ('3798', '387', '浩口原种场', '0');
INSERT INTO `sys_district` VALUES ('3799', '379', '佛子山镇', '0');
INSERT INTO `sys_district` VALUES ('3800', '182', '宋洛乡', '0');
INSERT INTO `sys_district` VALUES ('3801', '213', '道滘镇', '0');
INSERT INTO `sys_district` VALUES ('3802', '214', '东升镇', '0');
INSERT INTO `sys_district` VALUES ('3803', '233', '国营南新农场', '0');
INSERT INTO `sys_district` VALUES ('3804', '370', '毛阳镇', '0');
INSERT INTO `sys_district` VALUES ('3805', '380', '国营东升农场', '0');
INSERT INTO `sys_district` VALUES ('3806', '395', '光村镇', '0');
INSERT INTO `sys_district` VALUES ('3807', '369', '东路镇', '0');
INSERT INTO `sys_district` VALUES ('3808', '368', '国营东和农场', '0');
INSERT INTO `sys_district` VALUES ('3809', '356', '东河镇', '0');
INSERT INTO `sys_district` VALUES ('3810', '376', '国营中瑞农场', '0');
INSERT INTO `sys_district` VALUES ('3811', '367', '南吕镇', '0');
INSERT INTO `sys_district` VALUES ('3812', '375', '国营西达农场', '0');
INSERT INTO `sys_district` VALUES ('3813', '388', '多文镇', '0');
INSERT INTO `sys_district` VALUES ('3814', '346', '国营邦溪农场', '0');
INSERT INTO `sys_district` VALUES ('3815', '392', '海南矿业联合有限公司', '0');
INSERT INTO `sys_district` VALUES ('3816', '378', '国营尖峰岭林业公司', '0');
INSERT INTO `sys_district` VALUES ('3817', '361', '国营南平农场', '0');
INSERT INTO `sys_district` VALUES ('3818', '347', '海南保亭热带作物研究所', '0');
INSERT INTO `sys_district` VALUES ('3819', '364', '国营阳江农场', '0');
INSERT INTO `sys_district` VALUES ('3820', '299', '峪泉镇', '0');
INSERT INTO `sys_district` VALUES ('3821', '339', '老街街道', '0');
INSERT INTO `sys_district` VALUES ('3822', '340', '兵团第一师幸福农场', '0');
INSERT INTO `sys_district` VALUES ('3823', '341', '兵团五十三团', '0');
INSERT INTO `sys_district` VALUES ('3824', '342', '青湖路街道', '0');
INSERT INTO `sys_district` VALUES ('3825', '74', '溧水区', '0');
INSERT INTO `sys_district` VALUES ('3826', '78', '吴江区', '0');
INSERT INTO `sys_district` VALUES ('3827', '98', '庐江县', '0');
INSERT INTO `sys_district` VALUES ('3828', '199', '龙华新区', '0');
INSERT INTO `sys_district` VALUES ('3829', '212', '清新区', '0');
INSERT INTO `sys_district` VALUES ('3830', '220', '荔浦县', '0');
INSERT INTO `sys_district` VALUES ('3831', '262', '七星关区', '0');
INSERT INTO `sys_district` VALUES ('3832', '397', '墨江哈尼族自治县', '0');
INSERT INTO `sys_district` VALUES ('3833', '275', '文山市', '0');
INSERT INTO `sys_district` VALUES ('3834', '363', '信义区', '0');
INSERT INTO `sys_district` VALUES ('3835', '345', '冈山区', '0');
INSERT INTO `sys_district` VALUES ('3836', '394', '北区', '0');
INSERT INTO `sys_district` VALUES ('3837', '382', '大里区', '0');
INSERT INTO `sys_district` VALUES ('3838', '355', '乌坵乡', '0');
INSERT INTO `sys_district` VALUES ('3839', '359', '鹿谷乡', '0');
INSERT INTO `sys_district` VALUES ('3840', '354', '中山区', '0');
INSERT INTO `sys_district` VALUES ('3841', '383', '金山区', '0');
INSERT INTO `sys_district` VALUES ('3842', '371', '罗东镇', '0');
INSERT INTO `sys_district` VALUES ('3843', '384', '横山乡', '0');
INSERT INTO `sys_district` VALUES ('3844', '390', '龟山乡', '0');
INSERT INTO `sys_district` VALUES ('3845', '358', '苗栗市', '0');
INSERT INTO `sys_district` VALUES ('3846', '371', '芳苑乡', '0');
INSERT INTO `sys_district` VALUES ('3847', '353', '东石乡', '0');
INSERT INTO `sys_district` VALUES ('3848', '391', '斗六市', '0');
INSERT INTO `sys_district` VALUES ('3849', '362', '枋寮乡', '0');
INSERT INTO `sys_district` VALUES ('3850', '381', '大武乡', '0');
INSERT INTO `sys_district` VALUES ('3851', '348', '卓溪乡', '0');
INSERT INTO `sys_district` VALUES ('3852', '360', '望安乡', '0');
INSERT INTO `sys_district` VALUES ('3853', '351', '沙田区', '0');
INSERT INTO `sys_district` VALUES ('3854', '352', '梨林镇', '0');
INSERT INTO `sys_district` VALUES ('3855', '366', '郭河镇', '0');
INSERT INTO `sys_district` VALUES ('3856', '387', '浩口镇', '0');
INSERT INTO `sys_district` VALUES ('3857', '379', '干驿镇', '0');
INSERT INTO `sys_district` VALUES ('3858', '182', '下谷坪土家族乡', '0');
INSERT INTO `sys_district` VALUES ('3859', '213', '东城街道', '0');
INSERT INTO `sys_district` VALUES ('3860', '214', '阜沙镇', '0');
INSERT INTO `sys_district` VALUES ('3861', '233', '海棠湾镇', '0');
INSERT INTO `sys_district` VALUES ('3862', '370', '南圣镇', '0');
INSERT INTO `sys_district` VALUES ('3863', '380', '国营东太农场', '0');
INSERT INTO `sys_district` VALUES ('3864', '395', '国营八一农场', '0');
INSERT INTO `sys_district` VALUES ('3865', '369', '冯坡镇', '0');
INSERT INTO `sys_district` VALUES ('3866', '368', '国营东兴农场', '0');
INSERT INTO `sys_district` VALUES ('3867', '356', '感城镇', '0');
INSERT INTO `sys_district` VALUES ('3868', '376', '翰林镇', '0');
INSERT INTO `sys_district` VALUES ('3869', '367', '坡心镇', '0');
INSERT INTO `sys_district` VALUES ('3870', '375', '加乐镇', '0');
INSERT INTO `sys_district` VALUES ('3871', '388', '国营红华农场', '0');
INSERT INTO `sys_district` VALUES ('3872', '346', '国营龙江农场', '0');
INSERT INTO `sys_district` VALUES ('3873', '392', '海尾镇', '0');
INSERT INTO `sys_district` VALUES ('3874', '378', '国营乐光农场', '0');
INSERT INTO `sys_district` VALUES ('3875', '361', '黎安镇', '0');
INSERT INTO `sys_district` VALUES ('3876', '347', '加茂镇', '0');
INSERT INTO `sys_district` VALUES ('3877', '364', '国营长征农场', '0');
INSERT INTO `sys_district` VALUES ('3878', '299', '长城区', '0');
INSERT INTO `sys_district` VALUES ('3879', '339', '石河子乡', '0');
INSERT INTO `sys_district` VALUES ('3880', '340', '兵团七团', '0');
INSERT INTO `sys_district` VALUES ('3881', '341', '兵团五十团', '0');
INSERT INTO `sys_district` VALUES ('3882', '342', '人民路街道', '0');
INSERT INTO `sys_district` VALUES ('3883', '72', '新林区', '0');
INSERT INTO `sys_district` VALUES ('3884', '99', '无为县', '0');
INSERT INTO `sys_district` VALUES ('3885', '173', '襄州区', '0');
INSERT INTO `sys_district` VALUES ('3886', '183', '望城区', '0');
INSERT INTO `sys_district` VALUES ('3887', '193', '零陵区', '0');
INSERT INTO `sys_district` VALUES ('3888', '234', '大足区', '0');
INSERT INTO `sys_district` VALUES ('3889', '241', '昭化区', '0');
INSERT INTO `sys_district` VALUES ('3890', '247', '南溪区', '0');
INSERT INTO `sys_district` VALUES ('3891', '260', '万山区', '0');
INSERT INTO `sys_district` VALUES ('3892', '397', '宁洱哈尼族彝族自治县', '0');
INSERT INTO `sys_district` VALUES ('3893', '363', '士林区', '0');
INSERT INTO `sys_district` VALUES ('3894', '345', '鼓山区', '0');
INSERT INTO `sys_district` VALUES ('3895', '394', '大内区', '0');
INSERT INTO `sys_district` VALUES ('3896', '382', '大雅区', '0');
INSERT INTO `sys_district` VALUES ('3897', '359', '名间乡', '0');
INSERT INTO `sys_district` VALUES ('3898', '354', '中正区', '0');
INSERT INTO `sys_district` VALUES ('3899', '383', '林口区', '0');
INSERT INTO `sys_district` VALUES ('3900', '371', '南澳乡', '0');
INSERT INTO `sys_district` VALUES ('3901', '384', '湖口乡', '0');
INSERT INTO `sys_district` VALUES ('3902', '390', '中坜市', '0');
INSERT INTO `sys_district` VALUES ('3903', '358', '南庄乡', '0');
INSERT INTO `sys_district` VALUES ('3904', '371', '芬园乡', '0');
INSERT INTO `sys_district` VALUES ('3905', '353', '番路乡', '0');
INSERT INTO `sys_district` VALUES ('3906', '391', '斗南镇', '0');
INSERT INTO `sys_district` VALUES ('3907', '362', '枋山乡', '0');
INSERT INTO `sys_district` VALUES ('3908', '381', '东河乡', '0');
INSERT INTO `sys_district` VALUES ('3909', '348', '吉安乡', '0');
INSERT INTO `sys_district` VALUES ('3910', '351', '屯门区', '0');
INSERT INTO `sys_district` VALUES ('3911', '352', '坡头镇', '0');
INSERT INTO `sys_district` VALUES ('3912', '366', '胡场镇', '0');
INSERT INTO `sys_district` VALUES ('3913', '387', '后湖管理区', '0');
INSERT INTO `sys_district` VALUES ('3914', '379', '横林镇', '0');
INSERT INTO `sys_district` VALUES ('3915', '182', '新华镇', '0');
INSERT INTO `sys_district` VALUES ('3916', '213', '东莞生态园', '0');
INSERT INTO `sys_district` VALUES ('3917', '214', '港口镇', '0');
INSERT INTO `sys_district` VALUES ('3918', '233', '河东区街道', '0');
INSERT INTO `sys_district` VALUES ('3919', '370', '水满乡', '0');
INSERT INTO `sys_district` VALUES ('3920', '380', '会山镇', '0');
INSERT INTO `sys_district` VALUES ('3921', '395', '国营蓝洋农场', '0');
INSERT INTO `sys_district` VALUES ('3922', '369', '公坡镇', '0');
INSERT INTO `sys_district` VALUES ('3923', '368', '国营新中农场', '0');
INSERT INTO `sys_district` VALUES ('3924', '356', '国营广坝农场', '0');
INSERT INTO `sys_district` VALUES ('3925', '376', '黄竹镇', '0');
INSERT INTO `sys_district` VALUES ('3926', '367', '屯城镇', '0');
INSERT INTO `sys_district` VALUES ('3927', '375', '金江镇', '0');
INSERT INTO `sys_district` VALUES ('3928', '388', '国营加来农场', '0');
INSERT INTO `sys_district` VALUES ('3929', '346', '金波乡', '0');
INSERT INTO `sys_district` VALUES ('3930', '392', '七叉镇', '0');
INSERT INTO `sys_district` VALUES ('3931', '378', '国营山荣农场', '0');
INSERT INTO `sys_district` VALUES ('3932', '361', '隆广镇', '0');
INSERT INTO `sys_district` VALUES ('3933', '347', '六弓乡', '0');
INSERT INTO `sys_district` VALUES ('3934', '364', '和平镇', '0');
INSERT INTO `sys_district` VALUES ('3935', '339', '向阳街道', '0');
INSERT INTO `sys_district` VALUES ('3936', '340', '兵团十二团', '0');
INSERT INTO `sys_district` VALUES ('3937', '341', '兵团五十一团', '0');
INSERT INTO `sys_district` VALUES ('3938', '37', '沈北新区', '0');
INSERT INTO `sys_district` VALUES ('3939', '79', '通州区', '0');
INSERT INTO `sys_district` VALUES ('3940', '99', '弋江区', '0');
INSERT INTO `sys_district` VALUES ('3941', '197', '萝岗区', '0');
INSERT INTO `sys_district` VALUES ('3942', '397', '思茅区', '0');
INSERT INTO `sys_district` VALUES ('3943', '293', '吴起县', '0');
INSERT INTO `sys_district` VALUES ('3944', '363', '松山区', '0');
INSERT INTO `sys_district` VALUES ('3945', '345', '湖内区', '0');
INSERT INTO `sys_district` VALUES ('3946', '394', '东区', '0');
INSERT INTO `sys_district` VALUES ('3947', '382', '东区', '0');
INSERT INTO `sys_district` VALUES ('3948', '359', '南投市', '0');
INSERT INTO `sys_district` VALUES ('3949', '383', '芦洲区', '0');
INSERT INTO `sys_district` VALUES ('3950', '371', '三星乡', '0');
INSERT INTO `sys_district` VALUES ('3951', '384', '竹北市', '0');
INSERT INTO `sys_district` VALUES ('3952', '390', '龙潭乡', '0');
INSERT INTO `sys_district` VALUES ('3953', '358', '三湾乡', '0');
INSERT INTO `sys_district` VALUES ('3954', '371', '福兴乡', '0');
INSERT INTO `sys_district` VALUES ('3955', '353', '中埔乡', '0');
INSERT INTO `sys_district` VALUES ('3956', '391', '二仑乡', '0');
INSERT INTO `sys_district` VALUES ('3957', '362', '高树乡', '0');
INSERT INTO `sys_district` VALUES ('3958', '381', '关山镇', '0');
INSERT INTO `sys_district` VALUES ('3959', '348', '瑞穗乡', '0');
INSERT INTO `sys_district` VALUES ('3960', '351', '西贡区', '0');
INSERT INTO `sys_district` VALUES ('3961', '352', '沁园街道', '0');
INSERT INTO `sys_district` VALUES ('3962', '366', '九合垸原种场', '0');
INSERT INTO `sys_district` VALUES ('3963', '387', '江汉石油管理局', '0');
INSERT INTO `sys_district` VALUES ('3964', '379', '黄潭镇', '0');
INSERT INTO `sys_district` VALUES ('3965', '182', '阳日镇', '0');
INSERT INTO `sys_district` VALUES ('3966', '213', '东坑镇', '0');
INSERT INTO `sys_district` VALUES ('3967', '214', '古镇镇', '0');
INSERT INTO `sys_district` VALUES ('3968', '233', '河西区街道', '0');
INSERT INTO `sys_district` VALUES ('3969', '370', '通什镇', '0');
INSERT INTO `sys_district` VALUES ('3970', '380', '嘉积镇', '0');
INSERT INTO `sys_district` VALUES ('3971', '395', '国营西联农场', '0');
INSERT INTO `sys_district` VALUES ('3972', '369', '国营东路农场', '0');
INSERT INTO `sys_district` VALUES ('3973', '368', '和乐镇', '0');
INSERT INTO `sys_district` VALUES ('3974', '356', '江边乡', '0');
INSERT INTO `sys_district` VALUES ('3975', '376', '雷鸣镇', '0');
INSERT INTO `sys_district` VALUES ('3976', '367', '乌坡镇', '0');
INSERT INTO `sys_district` VALUES ('3977', '375', '老城镇', '0');
INSERT INTO `sys_district` VALUES ('3978', '388', '和舍镇', '0');
INSERT INTO `sys_district` VALUES ('3979', '346', '南开乡', '0');
INSERT INTO `sys_district` VALUES ('3980', '392', '石碌镇', '0');
INSERT INTO `sys_district` VALUES ('3981', '378', '国营莺歌海盐场', '0');
INSERT INTO `sys_district` VALUES ('3982', '361', '群英乡', '0');
INSERT INTO `sys_district` VALUES ('3983', '347', '毛感乡', '0');
INSERT INTO `sys_district` VALUES ('3984', '364', '红毛镇', '0');
INSERT INTO `sys_district` VALUES ('3985', '339', '新城街道', '0');
INSERT INTO `sys_district` VALUES ('3986', '340', '兵团十六团', '0');
INSERT INTO `sys_district` VALUES ('3987', '341', '前海街道', '0');
INSERT INTO `sys_district` VALUES ('3988', '105', '宜秀区', '0');
INSERT INTO `sys_district` VALUES ('3989', '197', '南沙区', '0');
INSERT INTO `sys_district` VALUES ('3990', '199', '坪山新区', '0');
INSERT INTO `sys_district` VALUES ('3991', '397', '西盟佤族自治县', '0');
INSERT INTO `sys_district` VALUES ('3992', '274', '蒙自市', '0');
INSERT INTO `sys_district` VALUES ('3993', '363', '万华区', '0');
INSERT INTO `sys_district` VALUES ('3994', '345', '甲仙区', '0');
INSERT INTO `sys_district` VALUES ('3995', '394', '东山区', '0');
INSERT INTO `sys_district` VALUES ('3996', '382', '东势区', '0');
INSERT INTO `sys_district` VALUES ('3997', '359', '埔里镇', '0');
INSERT INTO `sys_district` VALUES ('3998', '383', '坪林区', '0');
INSERT INTO `sys_district` VALUES ('3999', '371', '苏澳镇', '0');
INSERT INTO `sys_district` VALUES ('4000', '384', '竹东镇', '0');
INSERT INTO `sys_district` VALUES ('4001', '390', '芦竹乡', '0');
INSERT INTO `sys_district` VALUES ('4002', '358', '三义乡', '0');
INSERT INTO `sys_district` VALUES ('4003', '371', '和美镇', '0');
INSERT INTO `sys_district` VALUES ('4004', '353', '竹崎乡', '0');
INSERT INTO `sys_district` VALUES ('4005', '391', '古坑乡', '0');
INSERT INTO `sys_district` VALUES ('4006', '362', '恒春镇', '0');
INSERT INTO `sys_district` VALUES ('4007', '381', '海端乡', '0');
INSERT INTO `sys_district` VALUES ('4008', '348', '寿丰乡', '0');
INSERT INTO `sys_district` VALUES ('4009', '351', '元朗区', '0');
INSERT INTO `sys_district` VALUES ('4010', '352', '邵原镇', '0');
INSERT INTO `sys_district` VALUES ('4011', '366', '龙华山办事处', '0');
INSERT INTO `sys_district` VALUES ('4012', '387', '积玉口镇', '0');
INSERT INTO `sys_district` VALUES ('4013', '379', '胡市镇', '0');
INSERT INTO `sys_district` VALUES ('4014', '213', '凤岗镇', '0');
INSERT INTO `sys_district` VALUES ('4015', '214', '横栏镇', '0');
INSERT INTO `sys_district` VALUES ('4016', '233', '吉阳镇', '0');
INSERT INTO `sys_district` VALUES ('4017', '380', '龙江镇', '0');
INSERT INTO `sys_district` VALUES ('4018', '395', '国营西培农场', '0');
INSERT INTO `sys_district` VALUES ('4019', '369', '国营罗豆农场', '0');
INSERT INTO `sys_district` VALUES ('4020', '368', '后安镇', '0');
INSERT INTO `sys_district` VALUES ('4021', '356', '三家镇', '0');
INSERT INTO `sys_district` VALUES ('4022', '376', '岭口镇', '0');
INSERT INTO `sys_district` VALUES ('4023', '367', '西昌镇', '0');
INSERT INTO `sys_district` VALUES ('4024', '375', '桥头镇', '0');
INSERT INTO `sys_district` VALUES ('4025', '388', '皇桐镇', '0');
INSERT INTO `sys_district` VALUES ('4026', '346', '七坊镇', '0');
INSERT INTO `sys_district` VALUES ('4027', '392', '十月田镇', '0');
INSERT INTO `sys_district` VALUES ('4028', '378', '黄流镇', '0');
INSERT INTO `sys_district` VALUES ('4029', '361', '三才镇', '0');
INSERT INTO `sys_district` VALUES ('4030', '347', '南林乡', '0');
INSERT INTO `sys_district` VALUES ('4031', '364', '黎母山镇', '0');
INSERT INTO `sys_district` VALUES ('4032', '340', '兵团十三团', '0');
INSERT INTO `sys_district` VALUES ('4033', '341', '齐干却勒街道', '0');
INSERT INTO `sys_district` VALUES ('4034', '153', '禹王台区', '0');
INSERT INTO `sys_district` VALUES ('4035', '397', '镇沅彝族哈尼族拉祜族自治县', '0');
INSERT INTO `sys_district` VALUES ('4036', '274', '弥勒市', '0');
INSERT INTO `sys_district` VALUES ('4037', '285', '双湖县', '0');
INSERT INTO `sys_district` VALUES ('4038', '363', '文山区', '0');
INSERT INTO `sys_district` VALUES ('4039', '345', '苓雅区', '0');
INSERT INTO `sys_district` VALUES ('4040', '394', '关庙区', '0');
INSERT INTO `sys_district` VALUES ('4041', '382', '丰原区', '0');
INSERT INTO `sys_district` VALUES ('4042', '359', '仁爱乡', '0');
INSERT INTO `sys_district` VALUES ('4043', '383', '平溪区', '0');
INSERT INTO `sys_district` VALUES ('4044', '371', '头城镇', '0');
INSERT INTO `sys_district` VALUES ('4045', '384', '尖石乡', '0');
INSERT INTO `sys_district` VALUES ('4046', '390', '平镇市', '0');
INSERT INTO `sys_district` VALUES ('4047', '358', '狮潭乡', '0');
INSERT INTO `sys_district` VALUES ('4048', '371', '花坛乡', '0');
INSERT INTO `sys_district` VALUES ('4049', '353', '六脚乡', '0');
INSERT INTO `sys_district` VALUES ('4050', '391', '虎尾镇', '0');
INSERT INTO `sys_district` VALUES ('4051', '362', '竹田乡', '0');
INSERT INTO `sys_district` VALUES ('4052', '381', '金峰乡', '0');
INSERT INTO `sys_district` VALUES ('4053', '348', '新城乡', '0');
INSERT INTO `sys_district` VALUES ('4054', '352', '思礼镇', '0');
INSERT INTO `sys_district` VALUES ('4055', '366', '毛嘴镇', '0');
INSERT INTO `sys_district` VALUES ('4056', '387', '老新镇', '0');
INSERT INTO `sys_district` VALUES ('4057', '379', '蒋场镇', '0');
INSERT INTO `sys_district` VALUES ('4058', '213', '高埗镇', '0');
INSERT INTO `sys_district` VALUES ('4059', '214', '黄圃镇', '0');
INSERT INTO `sys_district` VALUES ('4060', '233', '天涯镇', '0');
INSERT INTO `sys_district` VALUES ('4061', '380', '石壁镇', '0');
INSERT INTO `sys_district` VALUES ('4062', '395', '海头镇', '0');
INSERT INTO `sys_district` VALUES ('4063', '369', '国营南阳农场', '0');
INSERT INTO `sys_district` VALUES ('4064', '368', '礼纪镇', '0');
INSERT INTO `sys_district` VALUES ('4065', '356', '四更镇', '0');
INSERT INTO `sys_district` VALUES ('4066', '376', '龙河镇', '0');
INSERT INTO `sys_district` VALUES ('4067', '367', '新兴镇', '0');
INSERT INTO `sys_district` VALUES ('4068', '375', '仁兴镇', '0');
INSERT INTO `sys_district` VALUES ('4069', '388', '临城镇', '0');
INSERT INTO `sys_district` VALUES ('4070', '346', '青松乡', '0');
INSERT INTO `sys_district` VALUES ('4071', '392', '王下乡', '0');
INSERT INTO `sys_district` VALUES ('4072', '378', '尖峰镇', '0');
INSERT INTO `sys_district` VALUES ('4073', '361', '提蒙乡', '0');
INSERT INTO `sys_district` VALUES ('4074', '347', '三道镇', '0');
INSERT INTO `sys_district` VALUES ('4075', '364', '上安乡', '0');
INSERT INTO `sys_district` VALUES ('4076', '340', '兵团十四团', '0');
INSERT INTO `sys_district` VALUES ('4077', '341', '永安坝街道', '0');
INSERT INTO `sys_district` VALUES ('4078', '363', '中山区', '0');
INSERT INTO `sys_district` VALUES ('4079', '345', '林园区', '0');
INSERT INTO `sys_district` VALUES ('4080', '394', '官田区', '0');
INSERT INTO `sys_district` VALUES ('4081', '382', '和平区', '0');
INSERT INTO `sys_district` VALUES ('4082', '359', '水里乡', '0');
INSERT INTO `sys_district` VALUES ('4083', '383', '瑞芳区', '0');
INSERT INTO `sys_district` VALUES ('4084', '371', '五结乡', '0');
INSERT INTO `sys_district` VALUES ('4085', '384', '新丰乡', '0');
INSERT INTO `sys_district` VALUES ('4086', '390', '新屋乡', '0');
INSERT INTO `sys_district` VALUES ('4087', '358', '西湖乡', '0');
INSERT INTO `sys_district` VALUES ('4088', '371', '彰化市', '0');
INSERT INTO `sys_district` VALUES ('4089', '353', '梅山乡', '0');
INSERT INTO `sys_district` VALUES ('4090', '391', '口湖乡', '0');
INSERT INTO `sys_district` VALUES ('4091', '362', '佳冬乡', '0');
INSERT INTO `sys_district` VALUES ('4092', '381', '兰屿乡', '0');
INSERT INTO `sys_district` VALUES ('4093', '348', '秀林乡', '0');
INSERT INTO `sys_district` VALUES ('4094', '352', '天坛街道', '0');
INSERT INTO `sys_district` VALUES ('4095', '366', '沔城回族镇', '0');
INSERT INTO `sys_district` VALUES ('4096', '387', '龙湾镇', '0');
INSERT INTO `sys_district` VALUES ('4097', '379', '蒋湖农场', '0');
INSERT INTO `sys_district` VALUES ('4098', '213', '莞城街道', '0');
INSERT INTO `sys_district` VALUES ('4099', '214', '火炬开发区街道', '0');
INSERT INTO `sys_district` VALUES ('4100', '233', '崖城镇', '0');
INSERT INTO `sys_district` VALUES ('4101', '380', '潭门镇', '0');
INSERT INTO `sys_district` VALUES ('4102', '395', '和庆镇', '0');
INSERT INTO `sys_district` VALUES ('4103', '369', '会文镇', '0');
INSERT INTO `sys_district` VALUES ('4104', '368', '龙滚镇', '0');
INSERT INTO `sys_district` VALUES ('4105', '356', '天安乡', '0');
INSERT INTO `sys_district` VALUES ('4106', '376', '龙湖镇', '0');
INSERT INTO `sys_district` VALUES ('4107', '375', '瑞溪镇', '0');
INSERT INTO `sys_district` VALUES ('4108', '388', '南宝镇', '0');
INSERT INTO `sys_district` VALUES ('4109', '346', '荣邦乡', '0');
INSERT INTO `sys_district` VALUES ('4110', '392', '乌烈镇', '0');
INSERT INTO `sys_district` VALUES ('4111', '378', '九所镇', '0');
INSERT INTO `sys_district` VALUES ('4112', '361', '文罗镇', '0');
INSERT INTO `sys_district` VALUES ('4113', '347', '什玲镇', '0');
INSERT INTO `sys_district` VALUES ('4114', '364', '什运乡', '0');
INSERT INTO `sys_district` VALUES ('4115', '340', '兵团十团', '0');
INSERT INTO `sys_district` VALUES ('4116', '234', '合川区', '0');
INSERT INTO `sys_district` VALUES ('4117', '363', '中正区', '0');
INSERT INTO `sys_district` VALUES ('4118', '345', '六龟区', '0');
INSERT INTO `sys_district` VALUES ('4119', '394', '归仁区', '0');
INSERT INTO `sys_district` VALUES ('4120', '382', '后里区', '0');
INSERT INTO `sys_district` VALUES ('4121', '359', '信义乡', '0');
INSERT INTO `sys_district` VALUES ('4122', '383', '三重区', '0');
INSERT INTO `sys_district` VALUES ('4123', '371', '宜兰市', '0');
INSERT INTO `sys_district` VALUES ('4124', '384', '新埔镇', '0');
INSERT INTO `sys_district` VALUES ('4125', '390', '桃园市', '0');
INSERT INTO `sys_district` VALUES ('4126', '358', '泰安乡', '0');
INSERT INTO `sys_district` VALUES ('4127', '371', '竹塘乡', '0');
INSERT INTO `sys_district` VALUES ('4128', '353', '民雄乡', '0');
INSERT INTO `sys_district` VALUES ('4129', '391', '林内乡', '0');
INSERT INTO `sys_district` VALUES ('4130', '362', '九如乡', '0');
INSERT INTO `sys_district` VALUES ('4131', '381', '鹿野乡', '0');
INSERT INTO `sys_district` VALUES ('4132', '348', '太鲁阁', '0');
INSERT INTO `sys_district` VALUES ('4133', '352', '王屋镇', '0');
INSERT INTO `sys_district` VALUES ('4134', '366', '排湖风景区', '0');
INSERT INTO `sys_district` VALUES ('4135', '387', '潜江经济开发区', '0');
INSERT INTO `sys_district` VALUES ('4136', '379', '竟陵街道', '0');
INSERT INTO `sys_district` VALUES ('4137', '213', '横沥镇', '0');
INSERT INTO `sys_district` VALUES ('4138', '214', '民众镇', '0');
INSERT INTO `sys_district` VALUES ('4139', '233', '育才镇', '0');
INSERT INTO `sys_district` VALUES ('4140', '380', '塔洋镇', '0');
INSERT INTO `sys_district` VALUES ('4141', '395', '华南热作学院', '0');
INSERT INTO `sys_district` VALUES ('4142', '369', '锦山镇', '0');
INSERT INTO `sys_district` VALUES ('4143', '368', '南桥镇', '0');
INSERT INTO `sys_district` VALUES ('4144', '356', '新龙镇', '0');
INSERT INTO `sys_district` VALUES ('4145', '376', '龙门镇', '0');
INSERT INTO `sys_district` VALUES ('4146', '375', '文儒镇', '0');
INSERT INTO `sys_district` VALUES ('4147', '388', '新盈镇', '0');
INSERT INTO `sys_district` VALUES ('4148', '346', '细水乡', '0');
INSERT INTO `sys_district` VALUES ('4149', '378', '利国镇', '0');
INSERT INTO `sys_district` VALUES ('4150', '361', '新村镇', '0');
INSERT INTO `sys_district` VALUES ('4151', '347', '响水镇', '0');
INSERT INTO `sys_district` VALUES ('4152', '364', '湾岭镇', '0');
INSERT INTO `sys_district` VALUES ('4153', '340', '兵团十一团', '0');
INSERT INTO `sys_district` VALUES ('4154', '31', '扎赉诺尔区', '0');
INSERT INTO `sys_district` VALUES ('4155', '291', '杨陵区', '0');
INSERT INTO `sys_district` VALUES ('4156', '345', '路竹区', '0');
INSERT INTO `sys_district` VALUES ('4157', '394', '后壁区', '0');
INSERT INTO `sys_district` VALUES ('4158', '382', '龙井区', '0');
INSERT INTO `sys_district` VALUES ('4159', '359', '鱼池乡', '0');
INSERT INTO `sys_district` VALUES ('4160', '383', '三芝区', '0');
INSERT INTO `sys_district` VALUES ('4161', '371', '员山乡', '0');
INSERT INTO `sys_district` VALUES ('4162', '384', '五峰乡', '0');
INSERT INTO `sys_district` VALUES ('4163', '390', '杨梅市', '0');
INSERT INTO `sys_district` VALUES ('4164', '358', '铜锣乡', '0');
INSERT INTO `sys_district` VALUES ('4165', '371', '鹿港镇', '0');
INSERT INTO `sys_district` VALUES ('4166', '353', '朴子市', '0');
INSERT INTO `sys_district` VALUES ('4167', '391', '仑背乡', '0');
INSERT INTO `sys_district` VALUES ('4168', '362', '崁顶乡', '0');
INSERT INTO `sys_district` VALUES ('4169', '381', '绿岛乡', '0');
INSERT INTO `sys_district` VALUES ('4170', '348', '万荣乡', '0');
INSERT INTO `sys_district` VALUES ('4171', '352', '五龙口镇', '0');
INSERT INTO `sys_district` VALUES ('4172', '366', '彭场镇', '0');
INSERT INTO `sys_district` VALUES ('4173', '387', '泰丰办事处', '0');
INSERT INTO `sys_district` VALUES ('4174', '379', '净潭乡', '0');
INSERT INTO `sys_district` VALUES ('4175', '213', '洪梅镇', '0');
INSERT INTO `sys_district` VALUES ('4176', '214', '南朗镇', '0');
INSERT INTO `sys_district` VALUES ('4177', '380', '万泉镇', '0');
INSERT INTO `sys_district` VALUES ('4178', '395', '兰洋镇', '0');
INSERT INTO `sys_district` VALUES ('4179', '369', '龙楼镇', '0');
INSERT INTO `sys_district` VALUES ('4180', '368', '三更罗镇', '0');
INSERT INTO `sys_district` VALUES ('4181', '376', '新竹镇', '0');
INSERT INTO `sys_district` VALUES ('4182', '375', '永发镇', '0');
INSERT INTO `sys_district` VALUES ('4183', '346', '牙叉镇', '0');
INSERT INTO `sys_district` VALUES ('4184', '378', '千家镇', '0');
INSERT INTO `sys_district` VALUES ('4185', '361', '椰林镇', '0');
INSERT INTO `sys_district` VALUES ('4186', '347', '新政镇', '0');
INSERT INTO `sys_district` VALUES ('4187', '364', '营根镇', '0');
INSERT INTO `sys_district` VALUES ('4188', '340', '工业园区', '0');
INSERT INTO `sys_district` VALUES ('4189', '234', '江津区', '0');
INSERT INTO `sys_district` VALUES ('4190', '345', '茂林区', '0');
INSERT INTO `sys_district` VALUES ('4191', '394', '佳里区', '0');
INSERT INTO `sys_district` VALUES ('4192', '382', '南区', '0');
INSERT INTO `sys_district` VALUES ('4193', '383', '三峡区', '0');
INSERT INTO `sys_district` VALUES ('4194', '358', '通霄镇', '0');
INSERT INTO `sys_district` VALUES ('4195', '371', '埤头乡', '0');
INSERT INTO `sys_district` VALUES ('4196', '353', '水上乡', '0');
INSERT INTO `sys_district` VALUES ('4197', '391', '麦寮乡', '0');
INSERT INTO `sys_district` VALUES ('4198', '362', '来义乡', '0');
INSERT INTO `sys_district` VALUES ('4199', '381', '台东市', '0');
INSERT INTO `sys_district` VALUES ('4200', '348', '玉里镇', '0');
INSERT INTO `sys_district` VALUES ('4201', '352', '下冶镇', '0');
INSERT INTO `sys_district` VALUES ('4202', '366', '三伏潭镇', '0');
INSERT INTO `sys_district` VALUES ('4203', '387', '王场镇', '0');
INSERT INTO `sys_district` VALUES ('4204', '379', '九真镇', '0');
INSERT INTO `sys_district` VALUES ('4205', '213', '厚街镇', '0');
INSERT INTO `sys_district` VALUES ('4206', '214', '南区街道', '0');
INSERT INTO `sys_district` VALUES ('4207', '380', '阳江镇', '0');
INSERT INTO `sys_district` VALUES ('4208', '395', '木棠镇', '0');
INSERT INTO `sys_district` VALUES ('4209', '369', '蓬莱镇', '0');
INSERT INTO `sys_district` VALUES ('4210', '368', '山根镇', '0');
INSERT INTO `sys_district` VALUES ('4211', '375', '中兴镇', '0');
INSERT INTO `sys_district` VALUES ('4212', '346', '元门乡', '0');
INSERT INTO `sys_district` VALUES ('4213', '378', '万冲镇', '0');
INSERT INTO `sys_district` VALUES ('4214', '361', '英州镇', '0');
INSERT INTO `sys_district` VALUES ('4215', '364', '长征镇', '0');
INSERT INTO `sys_district` VALUES ('4216', '340', '金银川路街道', '0');
INSERT INTO `sys_district` VALUES ('4217', '345', '美浓区', '0');
INSERT INTO `sys_district` VALUES ('4218', '394', '将军区', '0');
INSERT INTO `sys_district` VALUES ('4219', '382', '南屯区', '0');
INSERT INTO `sys_district` VALUES ('4220', '383', '深坑区', '0');
INSERT INTO `sys_district` VALUES ('4221', '358', '头份镇', '0');
INSERT INTO `sys_district` VALUES ('4222', '371', '埔心乡', '0');
INSERT INTO `sys_district` VALUES ('4223', '353', '溪口乡', '0');
INSERT INTO `sys_district` VALUES ('4224', '391', '水林乡', '0');
INSERT INTO `sys_district` VALUES ('4225', '362', '里港乡', '0');
INSERT INTO `sys_district` VALUES ('4226', '381', '太麻里乡', '0');
INSERT INTO `sys_district` VALUES ('4227', '352', '玉泉街道', '0');
INSERT INTO `sys_district` VALUES ('4228', '366', '沙湖原种场', '0');
INSERT INTO `sys_district` VALUES ('4229', '387', '熊口管理区', '0');
INSERT INTO `sys_district` VALUES ('4230', '379', '卢市镇', '0');
INSERT INTO `sys_district` VALUES ('4231', '213', '黄江镇', '0');
INSERT INTO `sys_district` VALUES ('4232', '214', '南头镇', '0');
INSERT INTO `sys_district` VALUES ('4233', '380', '长坡镇', '0');
INSERT INTO `sys_district` VALUES ('4234', '395', '南丰镇', '0');
INSERT INTO `sys_district` VALUES ('4235', '369', '铺前镇', '0');
INSERT INTO `sys_district` VALUES ('4236', '368', '万城镇', '0');
INSERT INTO `sys_district` VALUES ('4237', '378', '莺歌海镇', '0');
INSERT INTO `sys_district` VALUES ('4238', '364', '中平镇', '0');
INSERT INTO `sys_district` VALUES ('4239', '340', '南口街道', '0');
INSERT INTO `sys_district` VALUES ('4240', '345', '弥陀区', '0');
INSERT INTO `sys_district` VALUES ('4241', '394', '六甲区', '0');
INSERT INTO `sys_district` VALUES ('4242', '382', '清水区', '0');
INSERT INTO `sys_district` VALUES ('4243', '383', '石碇区', '0');
INSERT INTO `sys_district` VALUES ('4244', '358', '头屋乡', '0');
INSERT INTO `sys_district` VALUES ('4245', '371', '埔盐乡', '0');
INSERT INTO `sys_district` VALUES ('4246', '353', '新港乡', '0');
INSERT INTO `sys_district` VALUES ('4247', '391', '四湖乡', '0');
INSERT INTO `sys_district` VALUES ('4248', '362', '林边乡', '0');
INSERT INTO `sys_district` VALUES ('4249', '381', '延平乡', '0');
INSERT INTO `sys_district` VALUES ('4250', '352', '轵城镇', '0');
INSERT INTO `sys_district` VALUES ('4251', '366', '沙湖镇', '0');
INSERT INTO `sys_district` VALUES ('4252', '387', '熊口镇', '0');
INSERT INTO `sys_district` VALUES ('4253', '379', '马湾镇', '0');
INSERT INTO `sys_district` VALUES ('4254', '213', '虎门港管委会', '0');
INSERT INTO `sys_district` VALUES ('4255', '214', '三角镇', '0');
INSERT INTO `sys_district` VALUES ('4256', '380', '中原镇', '0');
INSERT INTO `sys_district` VALUES ('4257', '395', '那大镇', '0');
INSERT INTO `sys_district` VALUES ('4258', '369', '潭牛镇', '0');
INSERT INTO `sys_district` VALUES ('4259', '368', '兴隆华侨农场', '0');
INSERT INTO `sys_district` VALUES ('4260', '378', '志仲镇', '0');
INSERT INTO `sys_district` VALUES ('4261', '340', '青松路街道', '0');
INSERT INTO `sys_district` VALUES ('4262', '345', '那玛夏区', '0');
INSERT INTO `sys_district` VALUES ('4263', '394', '柳营区', '0');
INSERT INTO `sys_district` VALUES ('4264', '382', '沙鹿区', '0');
INSERT INTO `sys_district` VALUES ('4265', '383', '石门区', '0');
INSERT INTO `sys_district` VALUES ('4266', '358', '苑里镇', '0');
INSERT INTO `sys_district` VALUES ('4267', '371', '伸港乡', '0');
INSERT INTO `sys_district` VALUES ('4268', '353', '太保市', '0');
INSERT INTO `sys_district` VALUES ('4269', '391', '西螺镇', '0');
INSERT INTO `sys_district` VALUES ('4270', '362', '麟洛乡', '0');
INSERT INTO `sys_district` VALUES ('4271', '366', '沙嘴街道', '0');
INSERT INTO `sys_district` VALUES ('4272', '387', '杨市办事处', '0');
INSERT INTO `sys_district` VALUES ('4273', '379', '麻洋镇', '0');
INSERT INTO `sys_district` VALUES ('4274', '213', '虎门镇', '0');
INSERT INTO `sys_district` VALUES ('4275', '214', '三乡镇', '0');
INSERT INTO `sys_district` VALUES ('4276', '395', '排浦镇', '0');
INSERT INTO `sys_district` VALUES ('4277', '369', '文城镇', '0');
INSERT INTO `sys_district` VALUES ('4278', '368', '长丰镇', '0');
INSERT INTO `sys_district` VALUES ('4279', '340', '托喀依乡', '0');
INSERT INTO `sys_district` VALUES ('4280', '345', '楠梓区', '0');
INSERT INTO `sys_district` VALUES ('4281', '394', '龙崎区', '0');
INSERT INTO `sys_district` VALUES ('4282', '382', '神冈区', '0');
INSERT INTO `sys_district` VALUES ('4283', '383', '双溪区', '0');
INSERT INTO `sys_district` VALUES ('4284', '358', '造桥乡', '0');
INSERT INTO `sys_district` VALUES ('4285', '371', '社头乡', '0');
INSERT INTO `sys_district` VALUES ('4286', '353', '义竹乡', '0');
INSERT INTO `sys_district` VALUES ('4287', '391', '台西乡', '0');
INSERT INTO `sys_district` VALUES ('4288', '362', '琉球乡', '0');
INSERT INTO `sys_district` VALUES ('4289', '366', '通海口镇', '0');
INSERT INTO `sys_district` VALUES ('4290', '387', '园林办事处', '0');
INSERT INTO `sys_district` VALUES ('4291', '379', '彭市镇', '0');
INSERT INTO `sys_district` VALUES ('4292', '213', '寮步镇', '0');
INSERT INTO `sys_district` VALUES ('4293', '214', '沙溪镇', '0');
INSERT INTO `sys_district` VALUES ('4294', '395', '三都镇', '0');
INSERT INTO `sys_district` VALUES ('4295', '369', '翁田镇', '0');
INSERT INTO `sys_district` VALUES ('4296', '340', '幸福路街道', '0');
INSERT INTO `sys_district` VALUES ('4297', '234', '南川区', '0');
INSERT INTO `sys_district` VALUES ('4298', '345', '内门区', '0');
INSERT INTO `sys_district` VALUES ('4299', '394', '麻豆区', '0');
INSERT INTO `sys_district` VALUES ('4300', '382', '石冈区', '0');
INSERT INTO `sys_district` VALUES ('4301', '383', '树林区', '0');
INSERT INTO `sys_district` VALUES ('4302', '371', '线西乡', '0');
INSERT INTO `sys_district` VALUES ('4303', '391', '土库镇', '0');
INSERT INTO `sys_district` VALUES ('4304', '362', '玛家乡', '0');
INSERT INTO `sys_district` VALUES ('4305', '366', '五湖渔场', '0');
INSERT INTO `sys_district` VALUES ('4306', '387', '运粮湖管理区', '0');
INSERT INTO `sys_district` VALUES ('4307', '379', '侨乡街道开发区', '0');
INSERT INTO `sys_district` VALUES ('4308', '213', '麻涌镇', '0');
INSERT INTO `sys_district` VALUES ('4309', '214', '神湾镇', '0');
INSERT INTO `sys_district` VALUES ('4310', '395', '王五镇', '0');
INSERT INTO `sys_district` VALUES ('4311', '369', '文教镇', '0');
INSERT INTO `sys_district` VALUES ('4312', '340', '中心监狱', '0');
INSERT INTO `sys_district` VALUES ('4313', '345', '鸟松区', '0');
INSERT INTO `sys_district` VALUES ('4314', '394', '南化区', '0');
INSERT INTO `sys_district` VALUES ('4315', '382', '太平区', '0');
INSERT INTO `sys_district` VALUES ('4316', '383', '汐止区', '0');
INSERT INTO `sys_district` VALUES ('4317', '371', '溪湖镇', '0');
INSERT INTO `sys_district` VALUES ('4318', '391', '元长乡', '0');
INSERT INTO `sys_district` VALUES ('4319', '362', '满州乡', '0');
INSERT INTO `sys_district` VALUES ('4320', '366', '西流河镇', '0');
INSERT INTO `sys_district` VALUES ('4321', '387', '渔洋镇', '0');
INSERT INTO `sys_district` VALUES ('4322', '379', '石河镇', '0');
INSERT INTO `sys_district` VALUES ('4323', '213', '南城街道', '0');
INSERT INTO `sys_district` VALUES ('4324', '214', '石岐区街道', '0');
INSERT INTO `sys_district` VALUES ('4325', '395', '新州镇', '0');
INSERT INTO `sys_district` VALUES ('4326', '369', '重兴镇', '0');
INSERT INTO `sys_district` VALUES ('4327', '345', '前金区', '0');
INSERT INTO `sys_district` VALUES ('4328', '394', '南区', '0');
INSERT INTO `sys_district` VALUES ('4329', '382', '潭子区', '0');
INSERT INTO `sys_district` VALUES ('4330', '383', '新店区', '0');
INSERT INTO `sys_district` VALUES ('4331', '371', '溪州乡', '0');
INSERT INTO `sys_district` VALUES ('4332', '362', '牡丹乡', '0');
INSERT INTO `sys_district` VALUES ('4333', '366', '杨林尾镇', '0');
INSERT INTO `sys_district` VALUES ('4334', '387', '张金镇', '0');
INSERT INTO `sys_district` VALUES ('4335', '379', '拖市镇', '0');
INSERT INTO `sys_district` VALUES ('4336', '213', '桥头镇', '0');
INSERT INTO `sys_district` VALUES ('4337', '214', '坦洲镇', '0');
INSERT INTO `sys_district` VALUES ('4338', '395', '洋浦经济开发区', '0');
INSERT INTO `sys_district` VALUES ('4339', '234', '綦江区', '0');
INSERT INTO `sys_district` VALUES ('4340', '345', '前镇区', '0');
INSERT INTO `sys_district` VALUES ('4341', '394', '楠西区', '0');
INSERT INTO `sys_district` VALUES ('4342', '382', '外埔区', '0');
INSERT INTO `sys_district` VALUES ('4343', '383', '新庄区', '0');
INSERT INTO `sys_district` VALUES ('4344', '371', '秀水乡', '0');
INSERT INTO `sys_district` VALUES ('4345', '362', '南州乡', '0');
INSERT INTO `sys_district` VALUES ('4346', '366', '张沟镇', '0');
INSERT INTO `sys_district` VALUES ('4347', '387', '周矶办事处', '0');
INSERT INTO `sys_district` VALUES ('4348', '379', '汪场镇', '0');
INSERT INTO `sys_district` VALUES ('4349', '213', '清溪镇', '0');
INSERT INTO `sys_district` VALUES ('4350', '214', '五桂山街道', '0');
INSERT INTO `sys_district` VALUES ('4351', '395', '雅星镇', '0');
INSERT INTO `sys_district` VALUES ('4352', '345', '桥头区', '0');
INSERT INTO `sys_district` VALUES ('4353', '394', '七股区', '0');
INSERT INTO `sys_district` VALUES ('4354', '382', '雾峰区', '0');
INSERT INTO `sys_district` VALUES ('4355', '383', '泰山区', '0');
INSERT INTO `sys_district` VALUES ('4356', '371', '田中镇', '0');
INSERT INTO `sys_district` VALUES ('4357', '362', '内埔乡', '0');
INSERT INTO `sys_district` VALUES ('4358', '366', '长倘口镇', '0');
INSERT INTO `sys_district` VALUES ('4359', '387', '周矶管理区', '0');
INSERT INTO `sys_district` VALUES ('4360', '379', '小板镇', '0');
INSERT INTO `sys_district` VALUES ('4361', '213', '企石镇', '0');
INSERT INTO `sys_district` VALUES ('4362', '214', '小榄镇', '0');
INSERT INTO `sys_district` VALUES ('4363', '395', '中和镇', '0');
INSERT INTO `sys_district` VALUES ('4364', '345', '茄萣区', '0');
INSERT INTO `sys_district` VALUES ('4365', '394', '仁德区', '0');
INSERT INTO `sys_district` VALUES ('4366', '382', '梧栖区', '0');
INSERT INTO `sys_district` VALUES ('4367', '383', '土城区', '0');
INSERT INTO `sys_district` VALUES ('4368', '371', '田尾乡', '0');
INSERT INTO `sys_district` VALUES ('4369', '362', '屏东市', '0');
INSERT INTO `sys_district` VALUES ('4370', '366', '赵西垸林场', '0');
INSERT INTO `sys_district` VALUES ('4371', '387', '竹根滩镇', '0');
INSERT INTO `sys_district` VALUES ('4372', '379', '杨林街道', '0');
INSERT INTO `sys_district` VALUES ('4373', '213', '沙田镇', '0');
INSERT INTO `sys_district` VALUES ('4374', '214', '西区街道', '0');
INSERT INTO `sys_district` VALUES ('4375', '345', '旗津区', '0');
INSERT INTO `sys_district` VALUES ('4376', '394', '善化区', '0');
INSERT INTO `sys_district` VALUES ('4377', '382', '乌日区', '0');
INSERT INTO `sys_district` VALUES ('4378', '383', '万里区', '0');
INSERT INTO `sys_district` VALUES ('4379', '371', '永靖乡', '0');
INSERT INTO `sys_district` VALUES ('4380', '362', '三地门乡', '0');
INSERT INTO `sys_district` VALUES ('4381', '366', '郑场镇', '0');
INSERT INTO `sys_district` VALUES ('4382', '387', '总口管理区', '0');
INSERT INTO `sys_district` VALUES ('4383', '379', '岳口镇', '0');
INSERT INTO `sys_district` VALUES ('4384', '213', '石碣镇', '0');
INSERT INTO `sys_district` VALUES ('4385', '345', '芩雅区', '0');
INSERT INTO `sys_district` VALUES ('4386', '394', '山上区', '0');
INSERT INTO `sys_district` VALUES ('4387', '382', '新社区', '0');
INSERT INTO `sys_district` VALUES ('4388', '383', '五股区', '0');
INSERT INTO `sys_district` VALUES ('4389', '371', '员林镇', '0');
INSERT INTO `sys_district` VALUES ('4390', '362', '狮子乡', '0');
INSERT INTO `sys_district` VALUES ('4391', '379', '渔薪镇', '0');
INSERT INTO `sys_district` VALUES ('4392', '213', '石龙镇', '0');
INSERT INTO `sys_district` VALUES ('4393', '345', '旗山区', '0');
INSERT INTO `sys_district` VALUES ('4394', '394', '下营区', '0');
INSERT INTO `sys_district` VALUES ('4395', '382', '西区', '0');
INSERT INTO `sys_district` VALUES ('4396', '383', '乌来区', '0');
INSERT INTO `sys_district` VALUES ('4397', '362', '新埤乡', '0');
INSERT INTO `sys_district` VALUES ('4398', '379', '皂市镇', '0');
INSERT INTO `sys_district` VALUES ('4399', '213', '石排镇', '0');
INSERT INTO `sys_district` VALUES ('4400', '345', '仁武区', '0');
INSERT INTO `sys_district` VALUES ('4401', '394', '西港区', '0');
INSERT INTO `sys_district` VALUES ('4402', '382', '西屯区', '0');
INSERT INTO `sys_district` VALUES ('4403', '383', '莺歌区', '0');
INSERT INTO `sys_district` VALUES ('4404', '362', '新园乡', '0');
INSERT INTO `sys_district` VALUES ('4405', '379', '张港镇', '0');
INSERT INTO `sys_district` VALUES ('4406', '213', '松山湖管委会', '0');
INSERT INTO `sys_district` VALUES ('4407', '345', '三民区', '0');
INSERT INTO `sys_district` VALUES ('4408', '394', '新化区', '0');
INSERT INTO `sys_district` VALUES ('4409', '382', '中区', '0');
INSERT INTO `sys_district` VALUES ('4410', '383', '永和区', '0');
INSERT INTO `sys_district` VALUES ('4411', '362', '泰武乡', '0');
INSERT INTO `sys_district` VALUES ('4412', '213', '塘厦镇', '0');
INSERT INTO `sys_district` VALUES ('4413', '345', '杉林区', '0');
INSERT INTO `sys_district` VALUES ('4414', '394', '新市区', '0');
INSERT INTO `sys_district` VALUES ('4415', '362', '万丹乡', '0');
INSERT INTO `sys_district` VALUES ('4416', '213', '望牛墩镇', '0');
INSERT INTO `sys_district` VALUES ('4417', '345', '桃源区', '0');
INSERT INTO `sys_district` VALUES ('4418', '394', '新营区', '0');
INSERT INTO `sys_district` VALUES ('4419', '362', '万峦乡', '0');
INSERT INTO `sys_district` VALUES ('4420', '213', '万江街道', '0');
INSERT INTO `sys_district` VALUES ('4421', '345', '田寮区', '0');
INSERT INTO `sys_district` VALUES ('4422', '394', '学甲区', '0');
INSERT INTO `sys_district` VALUES ('4423', '362', '雾台乡', '0');
INSERT INTO `sys_district` VALUES ('4424', '213', '谢岗镇', '0');
INSERT INTO `sys_district` VALUES ('4425', '234', '永川区', '0');
INSERT INTO `sys_district` VALUES ('4426', '345', '小港区', '0');
INSERT INTO `sys_district` VALUES ('4427', '394', '盐水区', '0');
INSERT INTO `sys_district` VALUES ('4428', '362', '盐埔乡', '0');
INSERT INTO `sys_district` VALUES ('4429', '213', '长安镇', '0');
INSERT INTO `sys_district` VALUES ('4430', '345', '新兴区', '0');
INSERT INTO `sys_district` VALUES ('4431', '394', '永康区', '0');
INSERT INTO `sys_district` VALUES ('4432', '213', '樟木头镇', '0');
INSERT INTO `sys_district` VALUES ('4433', '345', '燕巢区', '0');
INSERT INTO `sys_district` VALUES ('4434', '394', '玉井区', '0');
INSERT INTO `sys_district` VALUES ('4435', '213', '中堂镇', '0');
INSERT INTO `sys_district` VALUES ('4436', '345', '盐埕区', '0');
INSERT INTO `sys_district` VALUES ('4437', '394', '中西区', '0');
INSERT INTO `sys_district` VALUES ('4438', '345', '永安区', '0');
INSERT INTO `sys_district` VALUES ('4439', '394', '左镇区', '0');
INSERT INTO `sys_district` VALUES ('4440', '345', '梓官区', '0');
INSERT INTO `sys_district` VALUES ('4441', '345', '左营区', '0');

-- ----------------------------
-- Table structure for `sys_hooks`
-- ----------------------------
DROP TABLE IF EXISTS `sys_hooks`;
CREATE TABLE `sys_hooks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `description` text NOT NULL COMMENT '描述',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型  1 视图 2 控制器',
  `addons` varchar(255) NOT NULL DEFAULT '' COMMENT '钩子挂载的插件 ''，''分割',
  `status` tinyint(2) DEFAULT '1',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=216 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=66;

-- ----------------------------
-- Records of sys_hooks
-- ----------------------------
INSERT INTO `sys_hooks` VALUES ('23', 'login', '第三方登录', '1', 'Oauthlogin', '1', '1499327900');
INSERT INTO `sys_hooks` VALUES ('24', 'sms', '短信', '1', 'sms', '1', '1499487808');
INSERT INTO `sys_hooks` VALUES ('146', 'getOrderType', '获取订单类型', '1', '', '1', '1549875029');
INSERT INTO `sys_hooks` VALUES ('27', 'orderCreateSuccess', '订单创建成功', '2', 'NsWxtemplatemsg', '1', '1500025515');
INSERT INTO `sys_hooks` VALUES ('29', 'orderDeliverySuccess', '订单发货成功', '2', 'NsWxtemplatemsg', '1', '1500448695');
INSERT INTO `sys_hooks` VALUES ('30', 'orderPaySuccess', '订单付款成功', '2', 'NsWxtemplatemsg', '1', '1500448963');
INSERT INTO `sys_hooks` VALUES ('148', 'getOrderStatusInfo', '', '1', '', '1', '1551755837');
INSERT INTO `sys_hooks` VALUES ('32', 'orderRefundSuccess', '订单退款成功', '2', '', '1', '1500450437');
INSERT INTO `sys_hooks` VALUES ('96', 'payNotify', '', '1', '', '1', '1545810208');
INSERT INTO `sys_hooks` VALUES ('97', 'smsconfig', '', '1', 'NsAlisms', '1', '1545969717');
INSERT INTO `sys_hooks` VALUES ('34', 'userLoginSuccess', '用户登陆成功', '2', '', '1', '1500619318');
INSERT INTO `sys_hooks` VALUES ('35', 'userAddSuccess', '基础用户添加成功后', '2', '', '1', '1500619587');
INSERT INTO `sys_hooks` VALUES ('36', 'memberRegisterSuccess', '会员注册成功', '2', 'NsWxtemplatemsg', '1', '1500619688');
INSERT INTO `sys_hooks` VALUES ('37', 'memberLevelSaveSuccess', '会员等级保存成功', '2', '', '1', '1500620008');
INSERT INTO `sys_hooks` VALUES ('38', 'memberWithdrawApplyCreateSuccess', '会员提现申请创建成功', '2', 'NsWxtemplatemsg', '1', '1500620146');
INSERT INTO `sys_hooks` VALUES ('39', 'memberWithdrawAuditAgree', '会员提现审核通过', '2', 'NsWxtemplatemsg', '1', '1500620297');
INSERT INTO `sys_hooks` VALUES ('40', 'goodsSaveSuccess', '商品保存成功', '2', '', '1', '1500620784');
INSERT INTO `sys_hooks` VALUES ('41', 'goodsSaveBefore', '商品保存之前', '2', '', '1', '1500620803');
INSERT INTO `sys_hooks` VALUES ('42', 'goodsDeleteBefore', '商品删除之前', '2', '', '1', '1500621085');
INSERT INTO `sys_hooks` VALUES ('43', 'goodsDeleteSuccess', '商品删除成功', '2', '', '1', '1500621109');
INSERT INTO `sys_hooks` VALUES ('44', 'goodsOnlineSuccess', '商品上架成功', '2', '', '1', '1500621131');
INSERT INTO `sys_hooks` VALUES ('45', 'goodsOfflineSuccess', '商品下架成功', '2', '', '1', '1500621142');
INSERT INTO `sys_hooks` VALUES ('55', 'goodsCategorySaveSuccess', '商品分类保存成功', '2', '', '1', '1500621379');
INSERT INTO `sys_hooks` VALUES ('56', 'goodsCategoryDeleteSuccess', '商品分类删除成功', '2', '', '1', '1500621397');
INSERT INTO `sys_hooks` VALUES ('57', 'goodsBrandSaveSuccess', '商品品牌保存成功', '2', '', '1', '1500621414');
INSERT INTO `sys_hooks` VALUES ('58', 'goodsBrandDeleteSuccess', '商品品牌删除成功', '2', '', '1', '1500621428');
INSERT INTO `sys_hooks` VALUES ('59', 'goodsGroupSaveSuccess', '商品分组保存成功', '2', '', '1', '1500621441');
INSERT INTO `sys_hooks` VALUES ('60', 'goodsGroupDeleteSuccess', '商品分组删除成功', '2', '', '1', '1500621455');
INSERT INTO `sys_hooks` VALUES ('61', 'goodsSpecSaveSuccess', '商品规格保存成功', '2', '', '1', '1500621470');
INSERT INTO `sys_hooks` VALUES ('62', 'goodsSpecDeleteSuccess', '商品规格删除成功', '2', '', '1', '1500621483');
INSERT INTO `sys_hooks` VALUES ('63', 'goodsAttributeSaveSuccess', '商品类型保存成功', '2', '', '1', '1500621495');
INSERT INTO `sys_hooks` VALUES ('64', 'goodsAttributeDeleteSuccess', '商品类型删除成功', '2', '', '1', '1500621506');
INSERT INTO `sys_hooks` VALUES ('99', 'payInfo', '', '1', 'NsWeixinpay', '1', '1547882911');
INSERT INTO `sys_hooks` VALUES ('98', 'smssend', '', '1', 'NsAlisms', '1', '1545984549');
INSERT INTO `sys_hooks` VALUES ('80', 'orderCompleteSuccess', '', '1', '', '1', '1544433483');
INSERT INTO `sys_hooks` VALUES ('81', 'orderGoodsConfirmRefundSuccess', '', '1', 'NsWxtemplatemsg', '1', '1544433483');
INSERT INTO `sys_hooks` VALUES ('84', 'orderOnLinePaySuccess', '', '1', 'NsWxtemplatemsg', '1', '1545806564');
INSERT INTO `sys_hooks` VALUES ('85', 'orderOffLinePaySuccess', '', '1', 'NsWxtemplatemsg', '1', '1545806564');
INSERT INTO `sys_hooks` VALUES ('86', 'orderGoodsRefundAskforSuccess', '', '1', 'NsWxtemplatemsg', '1', '1545806564');
INSERT INTO `sys_hooks` VALUES ('136', 'getOrderStatus', '获取订单状态', '1', '', '1', '1549875029');
INSERT INTO `sys_hooks` VALUES ('95', 'payReturn', '', '1', '', '1', '1545810208');
INSERT INTO `sys_hooks` VALUES ('87', 'memberBalanceRechargeSuccess', '', '1', 'NsWxtemplatemsg', '1', '1545806564');
INSERT INTO `sys_hooks` VALUES ('88', 'promoterApplyCreateSuccess', '', '1', 'NsWxtemplatemsg', '1', '1545806564');
INSERT INTO `sys_hooks` VALUES ('89', 'promoterAuditAgreeSuccess', '', '1', 'NsWxtemplatemsg', '1', '1545806564');
INSERT INTO `sys_hooks` VALUES ('90', 'orderDistributionSuccess', '', '1', 'NsWxtemplatemsg', '1', '1545806564');
INSERT INTO `sys_hooks` VALUES ('91', 'openGroupNotice', '', '1', 'NsWxtemplatemsg', '1', '1545806564');
INSERT INTO `sys_hooks` VALUES ('92', 'addGroupNotice', '', '1', 'NsWxtemplatemsg', '1', '1545806564');
INSERT INTO `sys_hooks` VALUES ('93', 'groupBookingSuccessOrFail', '', '1', 'NsWxtemplatemsg', '1', '1545806564');
INSERT INTO `sys_hooks` VALUES ('94', 'payconfig', '', '1', 'NsWeixinpay,NsAlipay', '1', '1545810160');
INSERT INTO `sys_hooks` VALUES ('147', 'getOrderGoodsSkuArray', '', '1', 'NsGroupBuy', '1', '1550906502');
INSERT INTO `sys_hooks` VALUES ('149', 'orderCreate', '', '1', '', '1', '1551755837');
INSERT INTO `sys_hooks` VALUES ('150', 'orderCalculate', '', '1', '', '1', '1551755837');
INSERT INTO `sys_hooks` VALUES ('151', 'getGoodsRelationInfo', '', '1', '', '1', '1552277687');
INSERT INTO `sys_hooks` VALUES ('152', 'getOrderRelationInfo', '', '1', '', '1', '1552293317');
INSERT INTO `sys_hooks` VALUES ('153', 'orderPayVerify', '', '1', '', '1', '1552389826');
INSERT INTO `sys_hooks` VALUES ('154', 'orderCreateSuccessAction', '', '1', '', '1', '1552389826');
INSERT INTO `sys_hooks` VALUES ('155', 'orderPaySuccessAction', '', '1', '', '1', '1552389826');
INSERT INTO `sys_hooks` VALUES ('157', 'getOrderTypeInfo', '', '1', '', '1', '1552633417');
INSERT INTO `sys_hooks` VALUES ('156', 'dataCollation', '', '1', '', '1', '1552440968');
INSERT INTO `sys_hooks` VALUES ('215', 'getOrderPromotionArray', '', '1', '', '1', '1553136553');
INSERT INTO `sys_hooks` VALUES ('158', 'getOrderGoodsRefundMoney', '', '1', '', '1', '1552635274');
INSERT INTO `sys_hooks` VALUES ('159', 'getOrderGoodsRefundBanlance', '', '1', '', '1', '1552635274');
INSERT INTO `sys_hooks` VALUES ('160', 'getGoodsConfig', '', '1', 'NsGoods', '1', '1552902000');
INSERT INTO `sys_hooks` VALUES ('167', 'addGoods', '', '1', 'NsGoods', '1', '1552902179');
INSERT INTO `sys_hooks` VALUES ('162', 'editGoods', '', '1', 'NsGoods', '1', '1552902000');
INSERT INTO `sys_hooks` VALUES ('163', 'addGoodsSuccess', '', '1', 'NsGoods', '1', '1552902000');
INSERT INTO `sys_hooks` VALUES ('164', 'editGoodsSuccess', '', '1', 'NsGoods', '1', '1552902000');
INSERT INTO `sys_hooks` VALUES ('165', 'deleteGoodsSuccess', '', '1', 'NsGoods', '1', '1552902000');
INSERT INTO `sys_hooks` VALUES ('166', 'copyGoodsSuccess', '', '1', 'NsGoods', '1', '1552902000');
INSERT INTO `sys_hooks` VALUES ('212', 'getPromotionDetail', '营销活动详情', '1', 'NsGroupBuy', '1', '1553133442');
INSERT INTO `sys_hooks` VALUES ('213', 'getPromotionType', '', '1', 'NsGroupBuy', '1', '1553135007');
INSERT INTO `sys_hooks` VALUES ('214', 'getPromotionTypeInfo', '', '1', 'NsGroupBuy', '1', '1553135007');

-- ----------------------------
-- Table structure for `sys_instance`
-- ----------------------------
DROP TABLE IF EXISTS `sys_instance`;
CREATE TABLE `sys_instance` (
  `instance_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `instance_name` varchar(50) NOT NULL DEFAULT '' COMMENT '实例名',
  `instance_typeid` int(11) NOT NULL DEFAULT '2' COMMENT '实例类型ID',
  `qrcode` varchar(255) NOT NULL DEFAULT '' COMMENT '实例二维码',
  `remark` text COMMENT '实例简介',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`instance_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1365 COMMENT='系统实例表';

-- ----------------------------
-- Records of sys_instance
-- ----------------------------
INSERT INTO `sys_instance` VALUES ('19', 'Niushop开源商城', '1', '', '\'\'', '1477541018');

-- ----------------------------
-- Table structure for `sys_instance_type`
-- ----------------------------
DROP TABLE IF EXISTS `sys_instance_type`;
CREATE TABLE `sys_instance_type` (
  `instance_typeid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '实例类型ID',
  `type_name` varchar(50) NOT NULL DEFAULT '' COMMENT '实例类型名称',
  `type_module_array` text NOT NULL COMMENT '实例类型权限',
  `type_desc` text NOT NULL COMMENT '实例类型说明',
  `type_sort` int(11) NOT NULL DEFAULT '1' COMMENT '排序号',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`instance_typeid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='实例类型';

-- ----------------------------
-- Records of sys_instance_type
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_module`
-- ----------------------------
DROP TABLE IF EXISTS `sys_module`;
CREATE TABLE `sys_module` (
  `module_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '模块ID',
  `module_name` varchar(50) NOT NULL DEFAULT '' COMMENT '模块标题',
  `module` varchar(255) NOT NULL DEFAULT 'admin' COMMENT '项目名',
  `controller` varchar(255) NOT NULL DEFAULT '' COMMENT '控制器名',
  `method` varchar(255) NOT NULL DEFAULT '' COMMENT '方法名',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '上级模块ID',
  `level` int(11) NOT NULL DEFAULT '1' COMMENT '深度等级',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `is_menu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是菜单',
  `is_dev` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否仅开发者模式可见',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `desc` text COMMENT '模块描述',
  `module_picture` varchar(255) NOT NULL DEFAULT '' COMMENT '模块图片',
  `icon_class` varchar(255) NOT NULL DEFAULT '' COMMENT '矢量图class',
  `is_control_auth` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否控制权限',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0',
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12548 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=606 COMMENT='系统模块表';

-- ----------------------------
-- Records of sys_module
-- ----------------------------
INSERT INTO `sys_module` VALUES ('120', '授权管理', 'admin', 'upgrade', 'devolutioninfo', '218', '2', 'upgrade/devolutioninfo', '1', '0', '999', '\'\'', '', '', '1', '1477454152', '1530588751');
INSERT INTO `sys_module` VALUES ('121', '系统菜单', 'admin', 'system', 'modulelist', '531', '3', 'system/modulelist', '1', '1', '5', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2352&highlight=%E6%A8%A1%E5%9D%97%E5%88%97%E8%A1%A8\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2352&highlight=%E6%A8%A1%E5%9D%97%E5%88%97%E8%A1%A8</a>', '', '', '1', '0', null);
INSERT INTO `sys_module` VALUES ('122', '添加菜单', 'admin', 'system', 'addmodule', '531', '3', 'system/addmodule', '0', '0', '1', '添加模块', '', '', '1', '0', '1479976597');
INSERT INTO `sys_module` VALUES ('123', '修改菜单', 'admin', 'system', 'editmodule', '531', '3', 'system/editmodule', '0', '0', '2', '修改模块', '', '', '1', '0', '1479976646');
INSERT INTO `sys_module` VALUES ('124', '财务', 'admin', 'account', 'shopaccount', '0', '1', 'account/shopaccount', '1', '0', '9', '财务管理', '', '', '1', '0', '0');
INSERT INTO `sys_module` VALUES ('126', '用户管理', 'admin', 'auth', 'userlist', '218', '2', 'auth/userlist', '1', '0', '5', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2386&extra=page%3D1\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2386&extra=page%3D1</a>', '', '', '1', '0', '1484650663');
INSERT INTO `sys_module` VALUES ('127', '用户列表', 'admin', 'auth', 'userlist', '126', '3', 'auth/userlist', '0', '0', '1', null, '', '', '1', '0', null);
INSERT INTO `sys_module` VALUES ('128', '权限组', 'admin', 'auth', 'authgrouplist', '126', '3', 'auth/authgrouplist', '0', '0', '2', '用户组', '', '', '1', '0', '1479976919');
INSERT INTO `sys_module` VALUES ('129', '删除菜单', 'admin', 'system', 'delmodule', '531', '3', 'system/delmodule', '0', '0', '0', '模块列表', '', '', '1', '1477618350', '1479976723');
INSERT INTO `sys_module` VALUES ('133', '添加用户组', 'admin', 'auth', 'addusergroup', '128', '3', 'auth/addusergroup', '0', '0', '2', '用户组', '', '', '1', '1477628544', '1479977008');
INSERT INTO `sys_module` VALUES ('137', '会员', 'admin', 'member', 'memberlist', '0', '1', 'member/memberlist', '1', '0', '3', '', '', '', '1', '1477994717', '1493206725');
INSERT INTO `sys_module` VALUES ('139', '相册管理', 'admin', 'system', 'albumlist', '149', '2', 'system/albumlist', '1', '0', '10', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2312&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2312&extra=page%3D2</a>', '', '', '1', '1478158094', '1496819610');
INSERT INTO `sys_module` VALUES ('144', '编辑用户', 'admin', 'auth', 'edituser', '127', '3', 'auth/edituser', '0', '0', '5', '用户', '', '', '1', '1478837447', '1479976963');
INSERT INTO `sys_module` VALUES ('145', '会员列表', 'admin', 'member', 'memberlist', '137', '2', 'member/memberlist', '1', '0', '1', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2321&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2321&extra=page%3D2</a>', '', '', '1', '1478846113', '1478846203');
INSERT INTO `sys_module` VALUES ('149', '商品', 'admin', 'goods', 'goodslist', '0', '1', 'goods/goodslist', '1', '0', '1', '商品模块', '', '', '1', '1479268148', '1493973167');
INSERT INTO `sys_module` VALUES ('150', '商品列表', 'admin', 'goods', 'goodslist', '149', '2', 'goods/goodslist', '1', '0', '1', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2301&extra=page%3D3\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2301&extra=page%3D3</a>', '', '', '1', '1479268236', '1541411029');
INSERT INTO `sys_module` VALUES ('151', '商品发布', 'admin', 'goods', 'addgoods', '149', '2', 'goods/addgoods', '0', '0', '2', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2302&extra=page%3D3\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2302&extra=page%3D3</a>', '', '', '1', '1479268307', '1553581807');
INSERT INTO `sys_module` VALUES ('169', '图片管理', 'admin', 'system', 'albumpicturelist', '139', '3', 'system/albumpicturelist', '0', '0', '5', 'sfgsdf', '', '', '1', '1479464708', '1479976790');
INSERT INTO `sys_module` VALUES ('170', '添加运费模板', 'admin', 'express', 'transportationadd', '164', '3', 'express/transportationadd', '0', '0', '1', '添加运费模板', '', '', '1', '1479700610', '1484894376');
INSERT INTO `sys_module` VALUES ('171', '商品标签', 'admin', 'goods', 'goodsgrouplist', '149', '2', 'goods/goodsgrouplist', '1', '0', '5', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2307&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2307&extra=page%3D2</a>', '', '', '1', '1479873298', '1548412835');
INSERT INTO `sys_module` VALUES ('172', '添加商品标签', 'admin', 'goods', 'addgoodsgroup', '171', '3', 'goods/addgoodsgroup', '0', '0', '6', '添加商品分组', '', '', '1', '1479873424', '1479960243');
INSERT INTO `sys_module` VALUES ('176', '运费模板修改', 'admin', 'express', 'transportationedit', '164', '3', 'express/transportationedit', '0', '0', '6', 'sd', '', '', '1', '1480040625', null);
INSERT INTO `sys_module` VALUES ('179', '营销', 'admin', 'promotion', 'index', '0', '1', 'promotion/index', '1', '0', '4', '营销中心', '', '', '1', '1480491652', '1480491725');
INSERT INTO `sys_module` VALUES ('180', '优惠券', 'admin', 'promotion', 'coupontypelist', '534', '3', 'promotion/index', '1', '0', '1', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2315&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2315&extra=page%3D2</a>', '', '', '1', '1480491846', '1547774240');
INSERT INTO `sys_module` VALUES ('184', '订单', 'admin', 'order', 'orderlist', '0', '1', 'order/orderlist', '1', '0', '2', '订单列表', '', '', '1', '1480563137', null);
INSERT INTO `sys_module` VALUES ('185', '订单列表', 'admin', 'order', 'orderlist', '184', '2', 'order/orderlist', '1', '0', '1', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2314&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2314&extra=page%3D2</a>', '', '', '1', '1480563210', null);
INSERT INTO `sys_module` VALUES ('186', '添加优惠券', 'admin', 'promotion', 'addcoupontype', '534', '3', 'promotion/addcoupontype', '1', '0', '2', '添加优惠券类型', '', '', '1', '1480573171', null);
INSERT INTO `sys_module` VALUES ('187', '修改优惠券', 'admin', 'promotion', 'updatecoupontype', '534', '3', 'promotion/updatecoupontype', '1', '0', '3', '修改优惠券类型', '', '', '1', '1480904943', null);
INSERT INTO `sys_module` VALUES ('189', '物流公司', 'admin', 'express', 'expresscompany', '529', '3', 'express/expresscompany', '0', '0', '60', '物流公司', '', '', '1', '1481254866', '1484894344');
INSERT INTO `sys_module` VALUES ('190', '订单详情', 'admin', 'order', 'orderdetail', '185', '3', 'order/orderdetail', '0', '0', '1', '订单详情', '', '', '1', '1481258173', null);
INSERT INTO `sys_module` VALUES ('191', '添加物流公司', 'admin', 'express', 'addexpresscompany', '529', '3', 'express/addexpresscompany', '1', '0', '1', '添加物流公司', '', '', '1', '1481267828', null);
INSERT INTO `sys_module` VALUES ('192', '物流公司修改', 'admin', 'express', 'updateexpresscompany', '529', '3', 'express/updateexpresscompany', '1', '0', '2', '物流公司修改排序', '', '', '1', '1481271808', null);
INSERT INTO `sys_module` VALUES ('194', '退款详情', 'admin', 'order', 'orderrefunddetail', '185', '3', 'order/orderrefunddetail', '0', '0', '2', '退款详情', '', '', '1', '1481872074', null);
INSERT INTO `sys_module` VALUES ('195', '赠品', 'admin', 'promotion', 'giftlist', '534', '3', 'promotion/giftlist', '1', '0', '3', '', '', '', '1', '1482113074', '1547774311');
INSERT INTO `sys_module` VALUES ('196', '添加赠品', 'admin', 'promotion', 'addgift', '534', '3', 'promotion/addgift', '1', '0', '0', '添加赠品', '', '', '1', '1482113664', '1482117539');
INSERT INTO `sys_module` VALUES ('197', '修改赠品', 'admin', 'promotion', 'updategift', '534', '3', 'promotion/updategift', '1', '0', '0', '修改赠品', '', '', '1', '1482113715', '1482117558');
INSERT INTO `sys_module` VALUES ('198', '满减送', 'admin', 'promotion', 'mansonglist', '534', '3', 'promotion/mansonglist', '1', '0', '4', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2317&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2317&extra=page%3D2</a>', '', '', '1', '1482138580', '1547774336');
INSERT INTO `sys_module` VALUES ('199', '添加满减送', 'admin', 'promotion', 'addmansong', '534', '3', 'promotion/addmansong', '1', '0', '0', '满减送', '', '', '1', '1482140311', null);
INSERT INTO `sys_module` VALUES ('200', '编辑满减送', 'admin', 'promotion', 'updatemansong', '534', '3', 'promotion/updatemansong', '1', '0', '1', '编辑满减送', '', '', '1', '1482907059', null);
INSERT INTO `sys_module` VALUES ('201', '限时折扣', 'admin', 'promotion', 'getdiscountlist', '534', '3', 'promotion/getdiscountlist', '1', '0', '5', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2318&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2318&extra=page%3D2</a>', '', '', '1', '1483949283', '1547774354');
INSERT INTO `sys_module` VALUES ('202', '添加限时折扣', 'admin', 'promotion', 'adddiscount', '534', '3', 'promotion/adddiscount', '1', '0', '0', '添加限时折扣', '', '', '1', '1483951104', null);
INSERT INTO `sys_module` VALUES ('203', '修改限时折扣', 'admin', 'promotion', 'updatediscount', '534', '3', 'promotion/updatediscount', '1', '0', '1', '修改限时折扣', '', '', '1', '1483951151', '1483958451');
INSERT INTO `sys_module` VALUES ('210', '修改商品标签', 'admin', 'goods', 'updategoodsgroup', '171', '3', 'goods/updategoodsgroup', '0', '0', '2', '修改商品分组', '', '', '1', '1484120298', '1484125917');
INSERT INTO `sys_module` VALUES ('218', '设置', 'admin', 'config', 'webconfig', '0', '1', 'config/webconfig', '1', '0', '999', '店铺设置', '', '', '1', '1484617355', '1493348177');
INSERT INTO `sys_module` VALUES ('221', '支付配置', 'admin', 'config', 'paymentconfig', '11045', '3', 'config/paymentconfig', '0', '0', '2', '支付配置', '\'\'', '', '1', '1484623427', '1496820428');
INSERT INTO `sys_module` VALUES ('334', '商品咨询', 'admin', 'saleservice', 'consultlist', '149', '2', 'saleservice/consultlist', '1', '0', '8', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2310&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2310&extra=page%3D2</a>', '', '', '1', '1488875702', '1496392553');
INSERT INTO `sys_module` VALUES ('335', '微信', 'admin', 'wchat', 'wchatPromotion', '0', '1', 'wchat/wchatPromotion', '1', '0', '11', '微信', '', '', '1', '1488945338', '1493015492');
INSERT INTO `sys_module` VALUES ('336', '公众号管理', 'admin', 'wchat', 'config', '11990', '3', 'wchat/config', '0', '0', '10', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2326&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2326&extra=page%3D2</a>', '', '', '1', '1488945416', null);
INSERT INTO `sys_module` VALUES ('339', '微信菜单管理', 'admin', 'wchat', 'menu', '11990', '3', 'wchat/menu', '0', '0', '5', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2327&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2327&extra=page%3D2</a>', '', '', '1', '1489046481', null);
INSERT INTO `sys_module` VALUES ('340', '推广', 'admin', 'wchat', 'weixinqrcodetemplate', '11990', '3', 'wchat/weixinqrcodetemplate', '0', '0', '6', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2328&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2328&extra=page%3D2</a>', '', '', '1', '1489046596', '1490153341');
INSERT INTO `sys_module` VALUES ('341', '回复设置', 'admin', 'wchat', 'replayconfig', '11990', '3', 'wchat/replayconfig', '0', '0', '4', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2329&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2329&extra=page%3D2</a>', '', '', '1', '1489046662', null);
INSERT INTO `sys_module` VALUES ('342', '消息素材管理', 'admin', 'wchat', 'materialmessage', '11990', '3', 'wchat/materialmessage', '0', '0', '6', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2330&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2330&extra=page%3D2</a>', '', '', '1', '1489046731', null);
INSERT INTO `sys_module` VALUES ('343', '分享内容设置', 'admin', 'wchat', 'shareconfig', '11990', '3', 'wchat/shareconfig', '0', '0', '7', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2332&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2332&extra=page%3D2</a>', '', '', '1', '1489046804', null);
INSERT INTO `sys_module` VALUES ('359', '添加回复', 'admin', 'wchat', 'addorupdatekeyreplay', '341', '3', 'wchat/addorupdatekeyreplay', '1', '0', '1', '', '', '', '1', '1490236498', null);
INSERT INTO `sys_module` VALUES ('360', '添加用户', 'admin', 'auth', 'adduser', '127', '3', 'auth/adduser', '0', '0', '1', '添加用户', '', '', '1', '1490236731', null);
INSERT INTO `sys_module` VALUES ('361', '一键关注设置', 'admin', 'wchat', 'onekeysubscribe', '335', '2', 'wchat/onekeysubscribe', '0', '0', '6', '一键关注设置', '', '', '1', '1490318979', '1496386363');
INSERT INTO `sys_module` VALUES ('383', '添加广告位', 'admin', 'system', 'addshopadvposition', '533', '3', 'system/addshopadvposition', '0', '0', '0', '添加广告位', '', '', '1', '1490835009', null);
INSERT INTO `sys_module` VALUES ('387', '广告位编辑', 'admin', 'system', 'updateshopadvposition', '533', '3', 'system/updateshopadvposition', '1', '0', '0', '广告位编辑', '', '', '1', '1490851266', '1553137061');
INSERT INTO `sys_module` VALUES ('390', '促销版块', 'admin', 'system', 'goodsrecommendclass', '10004', '3', 'system/goodsrecommendclass', '0', '0', '10', '促销版块管理', '', '', '1', '1490861814', '1496320694');
INSERT INTO `sys_module` VALUES ('392', '首页楼层', 'admin', 'system', 'blocklist', '10004', '3', 'system/blocklist', '0', '0', '11', '', '', '', '1', '1490947012', '1496320711');
INSERT INTO `sys_module` VALUES ('394', '添加楼层', 'admin', 'system', 'addblock', '10004', '3', 'system/addblock', '0', '0', '0', '', '', '', '1', '1490948318', null);
INSERT INTO `sys_module` VALUES ('395', '楼层编辑', 'admin', 'system', 'updateblock', '10004', '3', 'system/updateblock', '0', '0', '0', '', '', '', '1', '1490948388', '1490952538');
INSERT INTO `sys_module` VALUES ('398', '个人资料', 'admin', 'auth', 'userdetail', '126', '2', 'auth/userdetail', '1', '0', '0', '个人资料', '', '', '0', '1491029995', '1494298490');
INSERT INTO `sys_module` VALUES ('409', '数据', 'admin', 'account', 'shopsalesaccount', '0', '1', 'account/shopsalesaccount', '1', '0', '10', '资产', '', '', '1', '1493281488', '1493974412');
INSERT INTO `sys_module` VALUES ('418', '网站设置', 'admin', 'config', 'webconfig', '528', '3', 'config/webconfig', '0', '0', '2', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2342&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2342&extra=page%3D2</a>', '', '', '1', '1492755047', null);
INSERT INTO `sys_module` VALUES ('419', '商品分类', 'admin', 'goods', 'goodscategorylist', '149', '2', 'goods/goodscategorylist', '1', '0', '3', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2303&extra=page%3D3\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2303&extra=page%3D3</a>', '', '', '1', '1492755701', null);
INSERT INTO `sys_module` VALUES ('420', '添加商品分类', 'admin', 'goods', 'addgoodscategory', '419', '3', 'goods/addgoodscategory', '1', '0', '2', '添加商品分类', '', '', '1', '1492755811', '1492755828');
INSERT INTO `sys_module` VALUES ('421', '修改商品分类', 'admin', 'goods', 'updategoodscategory', '419', '3', 'goods/updategoodscategory', '1', '0', '1', '修改商品分类', '', '', '1', '1492755920', null);
INSERT INTO `sys_module` VALUES ('422', '删除商品分类', 'admin', 'goods', 'deletegoodscategory', '419', '3', 'goods/deletegoodscategory', '1', '0', '2', '删除商品分类', '', '', '1', '1492755973', null);
INSERT INTO `sys_module` VALUES ('423', '商品品牌', 'admin', 'goods', 'goodsbrandlist', '149', '2', 'goods/goodsbrandlist', '1', '0', '4', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2304&extra=page%3D3\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2304&extra=page%3D3</a>', '', '', '1', '1492756038', null);
INSERT INTO `sys_module` VALUES ('424', '添加商品品牌', 'admin', 'goods', 'addgoodsbrand', '423', '3', 'goods/addgoodsbrand', '1', '0', '1', '添加商品品牌', '', '', '1', '1492756096', null);
INSERT INTO `sys_module` VALUES ('425', '修改商品品牌', 'admin', 'goods', 'updategoodsbrand', '423', '3', 'goods/updategoodsbrand', '1', '0', '4', '修改商品品牌', '', '', '1', '1492756169', null);
INSERT INTO `sys_module` VALUES ('427', '导航管理', 'admin', 'config', 'shopnavigationlist', '533', '3', 'config/shopnavigationlist', '1', '0', '2', '导航', '', '', '1', '1492761752', '1496320733');
INSERT INTO `sys_module` VALUES ('428', '添加导航', 'admin', 'config', 'addshopnavigation', '533', '3', 'config/addshopnavigation', '0', '0', '1', '添加导航', '', '', '0', '1492761909', null);
INSERT INTO `sys_module` VALUES ('429', '修改导航', 'admin', 'config', 'updateshopnavigation', '427', '3', 'config/updateshopnavigation', '0', '0', '2', '修改导航', '', '', '0', '1492762515', null);
INSERT INTO `sys_module` VALUES ('430', '友情链接', 'admin', 'config', 'linklist', '533', '3', 'config/linklist', '1', '0', '10', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2381&extra=page%3D1\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2381&extra=page%3D1</a>', '', '', '1', '1492765269', '1496320750');
INSERT INTO `sys_module` VALUES ('431', '文章管理', 'admin', 'cms', 'articlelist', '477', '2', 'cms/articlelist', '1', '0', '7', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2378&extra=page%3D1\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2378&extra=page%3D1</a>', '', '', '1', '1492782512', '1492782619');
INSERT INTO `sys_module` VALUES ('432', '文章列表', 'admin', 'cms', 'articlelist', '431', '3', 'cms/articlelist', '0', '0', '1', '文章列表', '', '', '1', '1492782808', '1492782837');
INSERT INTO `sys_module` VALUES ('433', '文章分类', 'admin', 'cms', 'articleclasslist', '431', '3', 'cms/articleclasslist', '0', '0', '2', '文章列表', '', '', '1', '1492782934', '1492782952');
INSERT INTO `sys_module` VALUES ('434', '评论列表', 'admin', 'cms', 'commentarticle', '431', '2', 'cms/commentarticle', '0', '0', '3', '评论列表', '', '', '1', '1492782991', '1497084797');
INSERT INTO `sys_module` VALUES ('436', '添加友情链接', 'admin', 'config', 'addlink', '533', '3', 'config/addlink', '0', '0', '1', '添加友情链接', '', '', '1', '1493190273', '1493190306');
INSERT INTO `sys_module` VALUES ('437', '编辑友情链接', 'admin', 'config', 'updatelink', '430', '3', 'config/updatelink', '0', '0', '2', '编辑友情链接', '', '', '1', '1493192018', null);
INSERT INTO `sys_module` VALUES ('439', '通知系统', 'admin', 'config', 'notifyindex', '528', '3', 'config/notifyindex', '0', '0', '26', 'messageConfig', '', '', '1', '1493194795', '1496722814');
INSERT INTO `sys_module` VALUES ('440', '帮助类型', 'admin', 'config', 'helpclass', '530', '3', 'config/helpclass', '0', '0', '10', '帮助类型', '', '', '1', '1493199934', '1496320786');
INSERT INTO `sys_module` VALUES ('441', '帮助内容', 'admin', 'config', 'helpdocument', '530', '3', 'config/helpdocument', '0', '0', '18', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2380&extra=page%3D1\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2380&extra=page%3D1</a>', '', '', '1', '1493201598', '1496320803');
INSERT INTO `sys_module` VALUES ('442', '添加帮助类型', 'admin', 'config', 'addhelpclass', '530', '3', 'config/addhelpclass', '0', '0', '1', '添加帮助类型', '', '', '1', '1493201673', null);
INSERT INTO `sys_module` VALUES ('443', '修改帮助内容', 'admin', 'config', 'updatedocument', '530', '3', 'config/updatedocument', '0', '0', '2', 'updateDocument.html', '', '', '1', '1493203409', null);
INSERT INTO `sys_module` VALUES ('444', '添加帮助内容', 'admin', 'config', 'adddocument', '530', '3', 'config/adddocument', '0', '0', '2', 'aaddDocument', '', '', '1', '1493205866', null);
INSERT INTO `sys_module` VALUES ('445', '首页公告', 'admin', 'config', 'usernotice', '477', '2', 'config/usernotice', '1', '0', '3', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2370&page=1&extra=#pid6025\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2370&page=1&extra=#pid6025</a>', '', '', '1', '1493206256', '1496321121');
INSERT INTO `sys_module` VALUES ('446', '积分抵现', 'admin', 'promotion', 'pointconfig', '534', '3', 'promotion/pointconfig', '1', '0', '1', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2316&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2316&extra=page%3D2</a>', '', '', '1', '1493206530', '1547774297');
INSERT INTO `sys_module` VALUES ('447', '微信粉丝', 'admin', 'member', 'weixinfanslist', '335', '2', 'member/weixinfanslist', '1', '0', '2', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2322&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2322&extra=page%3D2</a>', '', '', '1', '1493278702', null);
INSERT INTO `sys_module` VALUES ('450', '修改消息素材', 'admin', 'wchat', 'updatemedia', '342', '3', 'wchat/updatemedia', '1', '0', '1', '', '', '', '1', '1493282078', '1493282297');
INSERT INTO `sys_module` VALUES ('451', '添加消息素材', 'admin', 'wchat', 'addmedia', '342', '3', 'wchat/addmedia', '1', '0', '1', '', '', '', '1', '1493282371', null);
INSERT INTO `sys_module` VALUES ('452', '添加文章', 'admin', 'cms', 'addarticle', '431', '3', 'cms/addarticle', '0', '0', '4', '', '', '', '1', '1493287571', '1493289825');
INSERT INTO `sys_module` VALUES ('455', '修改文章', 'admin', 'cms', 'updatearticle', '431', '3', 'cms/updatearticle', '0', '0', '2', '', '', '', '1', '1493343780', null);
INSERT INTO `sys_module` VALUES ('456', '第三方登录', 'admin', 'config', 'partylogin', '528', '3', 'config/partylogin', '0', '0', '25', '', '', '', '1', '1493347646', '1496903436');
INSERT INTO `sys_module` VALUES ('459', '销售概况', 'admin', 'account', 'shopsalesaccount', '409', '2', 'account/shopsalesaccount', '1', '0', '1', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2387&extra=page%3D1\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2387&extra=page%3D1</a>', '', '', '1', '1493776001', '1493974321');
INSERT INTO `sys_module` VALUES ('467', '首页', 'admin', 'index', 'index', '0', '1', 'index/index', '1', '0', '0', '', '', '', '0', '1494485612', '1497071676');
INSERT INTO `sys_module` VALUES ('469', '满额包邮', 'admin', 'promotion', 'fullshipping', '534', '3', 'promotion/fullshipping', '1', '0', '6', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2320&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2320&extra=page%3D2</a>', '', '', '1', '1494928162', '1547774394');
INSERT INTO `sys_module` VALUES ('471', '商家地址', 'admin', 'order', 'returnsetting', '529', '3', 'order/returnsetting', '0', '0', '70', '退货设置', '', '', '1', '1496215760', '1496216046');
INSERT INTO `sys_module` VALUES ('472', '添加或修改', 'admin', 'order', 'addreturn', '529', '3', 'order/addreturn', '1', '0', '1', '添加退货', '', '', '1', '1496215892', '1496216067');
INSERT INTO `sys_module` VALUES ('474', '首页公告', 'admin', 'config', 'updatenotice', '10005', '3', 'config/updatenotice', '0', '0', '15', '公告', '', '', '1', '1496291567', '1496320766');
INSERT INTO `sys_module` VALUES ('477', '店铺', 'admin', 'config', 'diyview', '0', '1', 'config/diyview', '1', '0', '8', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2371&extra=page%3D1\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2371&extra=page%3D1</a>', '', '', '1', '1496303515', '1496821512');
INSERT INTO `sys_module` VALUES ('478', '商品评价', 'admin', 'goods', 'goodscomment', '149', '2', 'goods/goodscomment', '1', '0', '9', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2311&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2311&extra=page%3D2</a>', '', '', '1', '1496310914', null);
INSERT INTO `sys_module` VALUES ('479', '商品规格', 'admin', 'goods', 'goodsspeclist', '149', '2', 'goods/goodsspeclist', '1', '0', '6', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2306&extra=page%3D3\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2306&extra=page%3D3</a>', '', '', '1', '1496314078', '1536803499');
INSERT INTO `sys_module` VALUES ('480', '添加商品规格', 'admin', 'goods', 'addgoodsspec', '479', '3', 'goods/addgoodsspec', '0', '0', '1', '', '', '', '1', '1496368895', null);
INSERT INTO `sys_module` VALUES ('481', '修改商品规格', 'admin', 'goods', 'updategoodsspec', '479', '3', 'goods/updategoodsspec', '0', '0', '0', '', '', '', '1', '1496386955', null);
INSERT INTO `sys_module` VALUES ('482', '商品类型', 'admin', 'goods', 'attributelist', '149', '2', 'goods/attributelist', '1', '0', '7', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2309&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2309&extra=page%3D2</a>', '', '', '1', '1496392434', '1496392497');
INSERT INTO `sys_module` VALUES ('484', '添加商品类型', 'admin', 'goods', 'addattributeservice', '482', '3', 'goods/addattributeservice', '1', '0', '0', '', '', '', '1', '1496395497', '1536803444');
INSERT INTO `sys_module` VALUES ('485', '修改商品类型', 'admin', 'goods', 'updategoodsattribute', '482', '3', 'goods/updategoodsattribute', '0', '0', '0', '', '', '', '1', '1496396084', null);
INSERT INTO `sys_module` VALUES ('486', '地区管理', 'admin', 'config', 'areamanagement', '529', '3', 'config/areamanagement', '0', '0', '50', '', '', '', '1', '1496452390', null);
INSERT INTO `sys_module` VALUES ('487', '模板编辑', 'admin', 'express', 'expresstemplate', '529', '3', 'express/expresstemplate', '0', '0', '0', '', '', '', '1', '1496459993', null);
INSERT INTO `sys_module` VALUES ('488', '会员等级', 'admin', 'member', 'memberlevellist', '137', '2', 'member/memberlevellist', '1', '0', '2', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2323&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2323&extra=page%3D2</a>', '', '', '1', '1496462360', null);
INSERT INTO `sys_module` VALUES ('489', '添加等级', 'admin', 'member', 'addmemberlevel', '488', '3', 'member/addmemberlevel', '1', '0', '1', '添加等级', '', '', '1', '1496483895', null);
INSERT INTO `sys_module` VALUES ('490', '修改等级', 'admin', 'member', 'updatememberlevel', '488', '3', 'member/updatememberlevel', '1', '0', '0', '修改等级', '', '', '1', '1496483933', '1496485692');
INSERT INTO `sys_module` VALUES ('494', '购物设置', 'admin', 'config', 'shopset', '11045', '3', 'config/shopset', '0', '0', '1', '购物设置', '', '', '1', '1496716845', '1496717062');
INSERT INTO `sys_module` VALUES ('495', '邮件设置', 'admin', 'config', 'messageconfig', '439', '3', 'config/messageconfig', '0', '0', '0', '', '', '', '1', '1496731597', null);
INSERT INTO `sys_module` VALUES ('496', '短信设置', 'admin', 'config', 'messageconfig', '439', '3', 'config/messageconfig', '0', '0', '0', '', '', '', '1', '1496731636', null);
INSERT INTO `sys_module` VALUES ('497', '会员积分明细', 'admin', 'member', 'pointdetail', '145', '3', 'member/pointdetail', '0', '0', '0', '', '', '', '1', '1496739472', null);
INSERT INTO `sys_module` VALUES ('498', '会员余额明细', 'admin', 'member', 'accountdetail', '145', '3', 'member/accountdetail', '0', '0', '0', '', '', '', '1', '1496744512', null);
INSERT INTO `sys_module` VALUES ('499', 'seo设置', 'admin', 'config', 'seoconfig', '533', '3', 'config/seoconfig', '0', '0', '2', 'seo设置', '', '', '1', '1496750885', '1496751054');
INSERT INTO `sys_module` VALUES ('501', '微信支付', 'admin', 'config', 'payconfig', '221', '3', 'config/payconfig', '1', '0', '1', '微信支付', '', '', '1', '1496821450', null);
INSERT INTO `sys_module` VALUES ('502', '支付宝支付', 'admin', 'config', 'payaliconfig', '221', '3', 'config/payaliconfig', '1', '0', '2', '支付宝支付', '', '', '1', '1496821780', null);
INSERT INTO `sys_module` VALUES ('503', '会员提现设置', 'admin', 'config', 'memberwithdrawsetting', '11045', '3', 'config/memberwithdrawsetting', '1', '0', '3', '会员提现设置', '', '', '1', '1496821934', '1496822222');
INSERT INTO `sys_module` VALUES ('504', '余额提现', 'admin', 'member', 'usercommissionwithdrawlist', '124', '2', 'member/usercommissionwithdrawlist', '1', '0', '4', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2324&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2324&extra=page%3D2</a>', '', '', '1', '1496822171', '1496822242');
INSERT INTO `sys_module` VALUES ('506', '模板管理', 'admin', 'config', 'notifytemplate', '439', '3', 'config/notifytemplate', '0', '0', '0', '', '', '', '1', '1496886539', '1496974268');
INSERT INTO `sys_module` VALUES ('509', '会员积分', 'admin', 'member', 'pointlist', '124', '2', 'member/pointlist', '1', '0', '2', '', '', '', '1', '1496906007', '1496906222');
INSERT INTO `sys_module` VALUES ('510', '会员余额', 'admin', 'member', 'accountlist', '124', '2', 'member/accountlist', '1', '0', '3', '', '', '', '1', '1496906142', '1496906242');
INSERT INTO `sys_module` VALUES ('512', '微信登录', 'admin', 'config', 'loginconfig', '456', '3', 'config/loginconfig', '1', '0', '2', '微信登录', '', '', '1', '1496907149', '1496907569');
INSERT INTO `sys_module` VALUES ('513', 'qq登录', 'admin', 'config', 'loginconfig', '456', '3', 'config/loginconfig', '1', '0', '1', 'qq登录', '', '', '1', '1496907238', '1496907552');
INSERT INTO `sys_module` VALUES ('515', '欢迎页', 'admin', 'index', 'index', '467', '2', 'index/index', '1', '0', '0', '欢迎页', '', '', '0', '1496979062', null);
INSERT INTO `sys_module` VALUES ('518', '回收站列表', 'admin', 'goods', 'recyclelist', '150', '3', 'goods/recyclelist', '0', '0', '2', '', '', '', '1', '1497445996', '1497445996');
INSERT INTO `sys_module` VALUES ('519', '货到付款地区管理', 'admin', 'config', 'distributionareamanagement', '529', '3', 'config/distributionareamanagement', '0', '0', '24', '', '', '', '1', '1497706614', '1497706614');
INSERT INTO `sys_module` VALUES ('523', '物流跟踪设置', 'admin', 'config', 'expressmessage', '529', '3', 'config/expressmessage', '0', '0', '100', '', '', '', '1', '1498198990', '1498198990');
INSERT INTO `sys_module` VALUES ('524', '在线更新', 'admin', 'upgrade', 'onlineupdate', '120', '3', 'upgrade/onlineupdate', '1', '0', '1', '', '', '', '1', '1498733102', '1498733102');
INSERT INTO `sys_module` VALUES ('525', '运费模板列表', 'admin', 'express', 'freighttemplatelist', '529', '3', 'express/freighttemplatelist', '0', '0', '0', '', '', '', '1', '1498733102', '1498733102');
INSERT INTO `sys_module` VALUES ('526', '编辑运费模板', 'admin', 'express', 'freighttemplateedit', '529', '3', 'express/freighttemplateedit', '0', '0', '2', '', '', '', '1', '1498733102', '1498733102');
INSERT INTO `sys_module` VALUES ('527', '注册与访问', 'admin', 'config', 'registerAndVisit', '528', '3', 'config/registerandvisit', '0', '0', '20', '', '', '', '1', '1498874511', '1498874511');
INSERT INTO `sys_module` VALUES ('528', '基础设置', 'admin', 'config', 'webconfig', '218', '2', 'config/webconfig', '1', '0', '1', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2342&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2342&extra=page%3D2</a>', '', '', '1', '1499343015', '1499343015');
INSERT INTO `sys_module` VALUES ('529', '配送管理', 'admin', 'express', 'expresscompany', '218', '2', 'express/expresscompany', '1', '0', '3', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2350&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2350&extra=page%3D2</a>', '', '', '1', '1499343015', '1499343015');
INSERT INTO `sys_module` VALUES ('530', '站点帮助', 'admin', 'config', 'helpclass', '477', '2', 'config/helpdocument', '1', '0', '9', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2380&extra=page%3D1\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2380&extra=page%3D1</a>', '', '', '1', '1499343015', '1499343015');
INSERT INTO `sys_module` VALUES ('531', '系统工具', 'admin', 'extend', 'addonlist', '218', '2', 'extend/addonslist', '1', '0', '16', null, '', '', '1', '0', '0');
INSERT INTO `sys_module` VALUES ('532', '授权信息', 'admin', 'upgrade', 'devolutioninfo', '120', '3', 'upgrade/devolutioninfo', '1', '0', '2', '', '', '', '1', '1500862991', '1500862991');
INSERT INTO `sys_module` VALUES ('533', '店铺装修', 'admin', 'config', 'diyview', '477', '2', 'config/diyview', '1', '0', '1', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2373&extra=page%3D1\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2373&extra=page%3D1</a>', '', '', '1', '1500862990', '1500862990');
INSERT INTO `sys_module` VALUES ('534', '营销中心', 'admin', 'promotion', 'index', '179', '2', 'promotion/index', '1', '0', '0', '', '', '', '1', '1547723826', '0');
INSERT INTO `sys_module` VALUES ('535', '会员营销', 'admin', 'Promotion', 'memberPromotion', '179', '2', 'Promotion/memberPromotion', '1', '0', '1', '', '', '', '1', '1547724500', '0');
INSERT INTO `sys_module` VALUES ('536', '互动游戏', 'admin', 'Promotion', 'gamePromotion', '179', '2', 'Promotion/gamePromotion', '1', '0', '2', '', '', '', '1', '1547724537', '0');
INSERT INTO `sys_module` VALUES ('537', '优惠券发放记录', 'admin', 'promotion', 'couponGrantLog', '534', '3', 'promotion/couponGrantLog', '0', '0', '0', '', '', '', '1', '1523414699', '0');
INSERT INTO `sys_module` VALUES ('538', '赠品发放记录', 'admin', 'promotion', 'giftGrantRecordsList', '534', '3', 'config/merchantService', '0', '0', '0', '赠品发放记录', '', '', '1', '1518088077', '0');
INSERT INTO `sys_module` VALUES ('539', '组合套餐', 'admin', 'promotion', 'combopackagepromotionlist', '534', '3', 'promotion/combopackagepromotionlist', '1', '0', '6', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2319&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2319&extra=page%3D2</a>', '', '', '1', '1547195109', '1547774373');
INSERT INTO `sys_module` VALUES ('540', '会员奖励', 'admin', 'promotion', 'integral', '534', '3', 'promotion/integral', '0', '0', '1', '会员奖励', '', '', '1', '1547781290', '0');
INSERT INTO `sys_module` VALUES ('10001', '供货商', 'admin', 'member', 'supplierlist', '149', '2', 'member/supplierlist', '1', '0', '11', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2308&extra=page%3D2\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2308&extra=page%3D2</a>', '', '', '1', '1500609632', '1536803479');
INSERT INTO `sys_module` VALUES ('10002', '添加供货商', 'admin', 'member', 'addsupplier', '10001', '3', 'member/addsupplier', '1', '0', '0', '', '', '', '1', '1500609632', '1500609632');
INSERT INTO `sys_module` VALUES ('10003', '修改供货商', 'admin', 'member', 'updatesupplier', '10001', '3', 'member/updatesupplier', '1', '0', '1', '', '', '', '1', '1500609632', '1500609632');
INSERT INTO `sys_module` VALUES ('10005', '搜索', 'admin', 'config', 'searchconfig', '533', '3', 'config/searchconfig', '1', '0', '5', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2374&extra=page%3D1\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2374&extra=page%3D1</a>', '', '', '1', '1500862990', '1500862990');
INSERT INTO `sys_module` VALUES ('10006', '促销版块', 'admin', 'system', 'goodsrecommendclassmobile', '10005', '3', 'system/goodsrecommendclassmobile', '0', '0', '20', '', '', '', '1', '1500862990', '1500862990');
INSERT INTO `sys_module` VALUES ('10075', '商家通知', 'admin', 'config', 'businessnotifytemplate', '439', '3', 'config/businessnotifytemplate', '0', '0', '0', '', '', '', '1', '1505870490', '0');
INSERT INTO `sys_module` VALUES ('11009', '插件管理', 'admin', 'extend', 'addonslist', '531', '3', 'extend/addonslist', '1', '0', '3', '', '', '', '1', '1500633040', null);
INSERT INTO `sys_module` VALUES ('11010', '钩子管理', 'admin', 'extend', 'hookslist', '531', '3', 'extend/hookslist', '1', '0', '4', '', '', '', '1', '1500633096', null);
INSERT INTO `sys_module` VALUES ('11011', '插件列表', 'admin', 'extend', 'pluginlist', '11008', '2', 'extend/pluginlist', '0', '0', '3', '', '', '', '1', '1500633141', null);
INSERT INTO `sys_module` VALUES ('11012', '添加钩子', 'admin', 'extend', 'addhooks', '11010', '3', 'extend/addhooks', '1', '0', '0', '', '', '', '1', '1500633268', null);
INSERT INTO `sys_module` VALUES ('11013', '修改钩子', 'admin', 'extend', 'updatehooks', '11010', '3', 'extend/updatehooks', '1', '0', '0', '', '', '', '1', '1500633326', null);
INSERT INTO `sys_module` VALUES ('11014', '插件配置', 'admin', 'extend', 'pluginconfig', '11008', '2', 'extend/pluginconfig', '0', '0', '4', '', '', '', '1', '1500633368', null);
INSERT INTO `sys_module` VALUES ('11015', '插件配置', 'admin', 'extend', 'addonsconfig', '11008', '2', 'extend/addonsconfig', '0', '0', '5', '', '', '', '1', '1500633398', null);
INSERT INTO `sys_module` VALUES ('11017', '版权', 'admin', 'config', 'copyrightinfo', '533', '3', 'config/copyrightinfo', '0', '0', '8', '', '', '', '1', '1502444014', '1502444014');
INSERT INTO `sys_module` VALUES ('11018', '手机模板', 'admin', 'config', 'waptemplate', '10005', '3', 'config/waptemplate', '0', '0', '3', '', '', '', '1', '1502444015', '1502444015');
INSERT INTO `sys_module` VALUES ('11019', '客服', 'admin', 'config', 'customservice', '528', '3', 'config/customservice', '0', '0', '28', '', '', '', '1', '1504096769', '1504096769');
INSERT INTO `sys_module` VALUES ('11021', '手机端模板', 'admin', 'config', 'fixedtemplate', '533', '3', 'config/fixedtemplate', '0', '0', '2', '', '', '', '1', '1504096769', '1504096769');
INSERT INTO `sys_module` VALUES ('11023', '商品楼层', 'admin', 'block', 'goodsFloorBlock', '533', '3', 'block/goodsfloorblock', '1', '0', '3', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2372&extra=page%3D1\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2372&extra=page%3D1</a>', '', '', '1', '0', '0');
INSERT INTO `sys_module` VALUES ('11024', '电脑端模板', 'admin', 'config', 'pctemplate', '533', '3', 'config/pctemplate', '1', '0', '1', '', '', '', '1', '1505100371', '1505100371');
INSERT INTO `sys_module` VALUES ('11026', '数据库管理', 'admin', 'dbdatabase', 'databaselist', '531', '3', 'dbdatabase/databaselist', '1', '0', '4', '相关教程：<a href=\"http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2385&extra=page%3D1\" target=\"_blank\">http://bbs.niushop.com.cn/forum.php?mod=viewthread&tid=2385&extra=page%3D1</a>', '', '', '1', '1506132536', '0');
INSERT INTO `sys_module` VALUES ('11027', '数据库恢复', 'admin', 'dbdatabase', 'importdatalist', '531', '3', 'dbdatabase/importdatalist', '0', '0', '0', '', '', '', '1', '1506132758', '0');
INSERT INTO `sys_module` VALUES ('11028', 'SQL执行与导入', 'admin', 'dbdatabase', 'sqlfilequery', '11026', '3', 'dbdatabase/sqlfilequery', '0', '0', '0', '', '', '', '1', '1506132811', '0');
INSERT INTO `sys_module` VALUES ('11029', '添加首页公告', 'admin', 'config', 'addhomenotice', '445', '3', 'config/addhomenotice', '0', '0', '1', '', '', '', '1', '1508152805', '0');
INSERT INTO `sys_module` VALUES ('11030', '公告编辑', 'admin', 'config', 'updatehomenotice', '445', '3', 'config/updatehomenotice', '0', '0', '2', '', '', '', '1', '1508208576', '0');
INSERT INTO `sys_module` VALUES ('11031', '上传设置', 'admin', 'config', 'pictureuploadsetting', '528', '3', 'config/pictureuploadsetting', '0', '0', '21', '', '', '', '1', '1508152805', '0');
INSERT INTO `sys_module` VALUES ('11032', '系统更新', 'admin', 'upgrade', 'upgradePatch', '524', '3', 'upgrade/upgradepatch', '0', '0', '0', '', '', '', '1', '1508743778', '0');
INSERT INTO `sys_module` VALUES ('11033', '伪静态路由', 'admin', 'config', 'customPseudoStaticRule', '528', '3', 'config/customPseudoStaticRule', '0', '0', '24', '', '', '', '1', '1509941657', '0');
INSERT INTO `sys_module` VALUES ('11034', '编辑路由规则', 'admin', 'config', 'updateRoutingRule', '11033', '3', 'config/updateRoutingRule', '0', '0', '0', '', '', '', '1', '1509958647', '0');
INSERT INTO `sys_module` VALUES ('11035', '添加路由规则', 'admin', 'config', 'addRoutingRules', '11033', '3', 'config/addRoutingRules', '0', '0', '0', '', '', '', '1', '1509951666', '1509959648');
INSERT INTO `sys_module` VALUES ('11036', '广告位管理', 'admin', 'system', 'shopadvpositionlist', '533', '3', 'system/shopadvpositionlist', '0', '0', '0', '', '', '', '1', '1512793160', '0');
INSERT INTO `sys_module` VALUES ('11038', '编辑虚拟商品类型', 'admin', 'goods', 'editvirtualgoodstype', '11037', '3', 'goods/editvirtualgoodstype', '0', '0', '1', '', '', '', '1', '1512793168', '0');
INSERT INTO `sys_module` VALUES ('11045', '交易设置', 'admin', 'config', 'shopset', '218', '2', 'config/shopset', '1', '0', '2', '相关教程：<a href=\"http://bbs.niushop.com.cn/thread-2384-1-1.html\" target=\"_blank\">http://bbs.niushop.com.cn/thread-2384-1-1.html</a>\"', '', '', '1', '1518088071', '0');
INSERT INTO `sys_module` VALUES ('11046', '运营', 'admin', 'config', 'visitConfig', '528', '3', 'config/visitconfig', '1', '0', '2', '访问设置', '', '', '1', '1518088072', '0');
INSERT INTO `sys_module` VALUES ('11050', '用户操作日志', 'admin', 'Member', 'userOperationLogList', '126', '2', 'Member/userOperationLogList', '1', '0', '10', '用户操作日志', '', '', '1', '1518088072', '0');
INSERT INTO `sys_module` VALUES ('11051', '转账配置', 'admin', 'config', 'transferAccountsSetting', '11045', '3', 'config/transferAccountsSetting', '0', '0', '4', '转账配置', '', '', '1', '1518088072', '0');
INSERT INTO `sys_module` VALUES ('11053', '关注设置', 'admin', 'wchat', 'keyConcernConfig', '11990', '3', 'wchat/keyConcernConfig', '0', '0', '12', '一键关注设置', '', '', '1', '1518088072', '0');
INSERT INTO `sys_module` VALUES ('11054', '商家服务', 'admin', 'config', 'merchantService', '533', '3', 'config/merchantService', '0', '0', '0', '商家服务', '', '', '1', '1518088072', '0');
INSERT INTO `sys_module` VALUES ('11056', '互动游戏', 'admin', 'Promotion', 'promotionGamesList', '534', '3', 'Promotion/promotionGamesList', '1', '0', '10', '互动游戏', '', '', '1', '1518088077', '0');
INSERT INTO `sys_module` VALUES ('11057', '添加活动', 'admin', 'Promotion', 'addPromotionGame', '11056', '3', 'Promotion/Promotion/addPromotionGame', '1', '0', '1', '添加活动', '', '', '1', '1518088077', '0');
INSERT INTO `sys_module` VALUES ('11058', '活动类型', 'admin', 'Promotion', 'promotionGameTypeList', '11056', '3', 'Promotion/promotionGameTypeList', '1', '0', '2', '活动类型', '', '', '1', '1518088077', '0');
INSERT INTO `sys_module` VALUES ('11059', '修改互动游戏', 'admin', 'Promotion', 'updatePromotionGame', '11056', '3', 'Promotion/updatePromotionGame', '1', '0', '3', '修改互动游戏', '', '', '1', '1518088079', '0');
INSERT INTO `sys_module` VALUES ('11060', '游戏奖项', 'admin', 'Promotion', 'promotionGamesAwardList', '11056', '3', 'Promotion/promotionGamesAwardList', '1', '0', '4', '游戏奖项', '', '', '1', '1518088079', '0');
INSERT INTO `sys_module` VALUES ('11061', '获奖记录', 'admin', 'Promotion', 'promotionGamesAccessRecords', '11056', '3', 'Promotion/promotionGamesAccessRecords', '1', '0', '5', '获奖记录', '', '', '1', '1518088079', '0');
INSERT INTO `sys_module` VALUES ('11062', '佣金明细', 'admin', 'Commission', 'userAccountRecordsDetail', '1002', '3', 'Commission/userAccountRecordsDetail', '1', '0', '2', '佣金明细', '', '', '1', '1518088083', '0');
INSERT INTO `sys_module` VALUES ('11063', '会员足迹', 'admin', 'member', 'newpath', '145', '3', 'member/newpath', '0', '0', '0', '会员足迹', '', '', '1', '1523414667', '0');
INSERT INTO `sys_module` VALUES ('11067', '微信小程序管理', 'admin', 'wchat', 'appletConfig', '11990', '3', 'wchat/appletConfig', '0', '0', '6', '微信小程序管理', '', '', '1', '1523414671', '0');
INSERT INTO `sys_module` VALUES ('11068', '银联卡支付', 'admin', 'config', 'unionpayconfig', '11045', '3', 'config/unionpayconfig', '1', '0', '3', '银联卡支付', '', '', '1', '1523414671', '0');
INSERT INTO `sys_module` VALUES ('11069', '会员余额明细', 'admin', 'member', 'balancedetail', '145', '3', 'member/balancedetail', '1', '0', '0', '会员余额明细', '', '', '1', '1523414671', '0');
INSERT INTO `sys_module` VALUES ('11070', '通知记录', 'admin', 'config', 'notifylist', '528', '3', 'config/notifylist', '1', '0', '0', '', '', '', '1', '1523414671', '0');
INSERT INTO `sys_module` VALUES ('11074', '操作日志', 'admin', 'auth', 'authLog', '126', '3', 'auth/authLog', '0', '0', '5', '', '', '', '1', '1523414672', '0');
INSERT INTO `sys_module` VALUES ('11075', '发票管理', 'admin', 'order', 'invoiceList', '184', '2', 'order/invoiceList', '1', '0', '15', '', '', '', '1', '1523414672', '0');
INSERT INTO `sys_module` VALUES ('11078', '微信客服', 'admin', 'Wchat', 'fansMessageManage', '335', '2', 'Wchat/fansMessageManage', '1', '0', '3', '', '', '', '1', '1523414672', '0');
INSERT INTO `sys_module` VALUES ('11079', '粉丝留言', 'admin', 'wchat', 'fansMessageManage', '10156', '3', 'wchat/fansMessageManage', '1', '0', '1', '', '', '', '1', '1523414672', '0');
INSERT INTO `sys_module` VALUES ('11080', '群发消息', 'admin', 'Wchat', 'sendGroupMessage', '10156', '3', 'Wchat/sendGroupMessage', '1', '0', '2', '', '', '', '1', '1523414672', '0');
INSERT INTO `sys_module` VALUES ('11081', '售后服务', 'admin', 'Order', 'customerServiceList', '184', '2', 'Order/customerServiceList', '1', '0', '16', '售后服务', '', '', '1', '1523414699', '0');
INSERT INTO `sys_module` VALUES ('11082', '售后详情', 'admin', 'Order', 'orderCustomerDetail', '11081', '3', 'Order/orderCustomerDetail', '0', '0', '0', '售后详情', '', '', '1', '1523414699', '0');
INSERT INTO `sys_module` VALUES ('11086', '专题活动', 'admin', 'promotion', 'topiclist', '534', '3', 'promotion/topiclist', '1', '0', '12', '', '', '', '1', '1523414700', '1547774459');
INSERT INTO `sys_module` VALUES ('11087', '添加专题活动', 'admin', 'promotion', 'addtopic', '534', '3', 'promotion/addtopic', '0', '0', '0', '', '', '', '1', '1523414700', '0');
INSERT INTO `sys_module` VALUES ('11088', '修改专题活动', 'admin', 'promotion', 'updatetopic', '534', '3', 'promotion/updatetopic', '0', '0', '0', '', '', '', '1', '1523414700', '0');
INSERT INTO `sys_module` VALUES ('11090', '订单核销', 'admin', 'Verification', 'index', '184', '2', 'Verification/index', '1', '0', '80', '', '', '', '1', '1523414702', '0');
INSERT INTO `sys_module` VALUES ('11091', '核销人员', 'admin', 'Verification', 'index', '11090', '3', 'Verification/index', '1', '0', '1', '', '', '', '1', '1523414702', '0');
INSERT INTO `sys_module` VALUES ('11092', '核销记录', 'admin', 'Verification', 'virtualGoodsVerificationList', '11090', '3', 'Verification/virtualGoodsVerificationList', '1', '0', '2', '', '', '', '1', '1523414702', '0');
INSERT INTO `sys_module` VALUES ('11099', '虚拟商品管理', 'admin', 'goods', 'virtualGoodsList', '150', '3', 'goods/virtualGoodsList', '1', '0', '1', '虚拟商品管理', '', '', '1', '1523611854', '0');
INSERT INTO `sys_module` VALUES ('11108', 'App版本管理', 'admin', 'config', 'appUpgradeList', '528', '3', 'config/appUpgradeList', '0', '0', '11', '', '', '', '1', '1528698115', '1528701272');
INSERT INTO `sys_module` VALUES ('11110', '编辑App版本', 'admin', 'config', 'editAppUpgrade', '528', '3', 'config/editAppUpgrade', '0', '0', '1', '', '', '', '1', '1528700557', '0');
INSERT INTO `sys_module` VALUES ('11112', 'App欢迎页', 'admin', 'config', 'appWelcomePage', '477', '2', 'config/appWelcomePage', '1', '0', '11', '', '', '', '1', '1531205729', '0');
INSERT INTO `sys_module` VALUES ('11266', '短信配置', 'admin', 'Config', 'smsConfig', '528', '3', 'Config/smsConfig', '0', '0', '1', '短信配置', '', '', '1', '0', '0');
INSERT INTO `sys_module` VALUES ('11339', '拼团', 'admin', 'tuangou', 'pintuanlist', '534', '3', 'tuangou/pintuanlist', '1', '0', '11', '拼团设置', '', '', '1', '1547693688', '1547774440');
INSERT INTO `sys_module` VALUES ('11725', '分类显示', 'admin', 'Config', 'classifiedDisplayMode', '533', '3', 'Config/classifiedDisplayMode', '0', '0', '0', '分类显示', '', '', '1', '0', '0');
INSERT INTO `sys_module` VALUES ('11802', '微信支付', 'NsWeixinpay', 'Config', 'paywchatconfig', '494', '4', 'Config/paywchatconfig', '0', '0', '9', '微信支付', '', '', '1', '1547882911', '0');
INSERT INTO `sys_module` VALUES ('11803', '支付宝支付', 'NsAlipay', 'Config', 'payaliconfig', '494', '4', 'Config/payaliconfig', '0', '0', '9', '支付宝支付配置', '', '', '1', '1547882912', '0');
INSERT INTO `sys_module` VALUES ('11809', '自定义模板', 'NsDiyView', 'config', 'wapcustomTemplateList', '533', '3', 'config/wapcustomTemplateList', '1', '0', '11', '拼团设置', '', '', '1', '1551340708', '0');
INSERT INTO `sys_module` VALUES ('11810', '自定义模板设置', 'NsDiyView', 'config', 'wapCustomTemplateEdit', '533', '3', 'config/wapCustomTemplateEdit', '1', '0', '11', '自定义模板设置', '', '', '1', '1551340708', '0');
INSERT INTO `sys_module` VALUES ('11811', '自定义模板开启', 'NsDiyView', 'config', 'setIsEnableWapCustomTemplate', '533', '3', 'config/setIsEnableWapCustomTemplate', '1', '0', '11', '自定义模板开启', '', '', '1', '1551340708', '0');
INSERT INTO `sys_module` VALUES ('11812', '阿里云短信配置', 'NsAlisms', 'Config', 'alismsConfig', '528', '3', 'Config/alismsConfig', '0', '0', '9', '阿里云短信配置', '', '', '1', '1551347533', '0');
INSERT INTO `sys_module` VALUES ('11819', '编辑会员标签', 'admin', 'member', 'editmemberlabel', '11820', '3', 'member/editmemberlabel', '1', '0', '1', '', '', '', '1', '1548142855', '0');
INSERT INTO `sys_module` VALUES ('11820', '会员标签', 'admin', 'member', 'memberlabellist', '137', '2', 'member/memberlabellist', '1', '0', '3', '', '', '', '1', '1548142926', '0');
INSERT INTO `sys_module` VALUES ('11822', '首页排版', 'admin', 'config', 'pagelayout', '533', '3', 'config/pagelayout', '1', '0', '1', '首页排版', '', '', '1', '1548209475', '0');
INSERT INTO `sys_module` VALUES ('11825', '会员详情', 'admin', 'member', 'memberdetail', '145', '3', 'member/memberdetail', '1', '0', '8', '', '', '', '1', '1548213220', '0');
INSERT INTO `sys_module` VALUES ('11870', 'API安全', 'admin', 'config', 'apisecure', '528', '3', 'config/apisecure', '1', '0', '1', 'API安全', '', '', '1', '1549856528', '0');
INSERT INTO `sys_module` VALUES ('11990', '微信推广', 'admin', 'wchat', 'wchatPromotion', '335', '2', 'wchat/wchatPromotion', '1', '0', '1', '微信推广', '', '', '1', '1549879738', '0');
INSERT INTO `sys_module` VALUES ('11991', '添加自定义模板', 'admin', 'wchat', 'qrcode', '11990', '3', 'wchat/qrcode', '0', '0', '0', '添加自定义模板', '', '', '1', '1549879738', '0');
INSERT INTO `sys_module` VALUES ('12034', '模板消息', 'NsWxtemplatemsg', 'TempMsg', 'index', '335', '2', 'TempMsg/index', '1', '0', '7', '模板消息设置', '', '', '1', '1550302198', '0');
INSERT INTO `sys_module` VALUES ('12035', '商品推荐', 'admin', 'config', 'goodsRecommend', '533', '3', 'config/goodsRecommend', '0', '0', '0', '商品推荐', '', '', '1', '0', '0');
INSERT INTO `sys_module` VALUES ('12036', '首页魔方', 'admin', 'config', 'shopCube', '533', '3', 'config/shopCube', '0', '0', '0', '首页魔方', '', '', '1', '0', '0');
INSERT INTO `sys_module` VALUES ('12037', '商品推荐', 'admin', 'config', 'goodsRecommendType', '533', '3', 'config/goodsRecommendType', '0', '0', '0', '商品推荐', '', '', '1', '0', '0');
INSERT INTO `sys_module` VALUES ('12042', '财务状况', 'admin', 'account', 'shopaccount', '124', '2', 'account/shopaccount', '1', '0', '0', '财务状况', '', '', '1', '0', '0');
INSERT INTO `sys_module` VALUES ('12360', '充值订单', 'admin', 'order', 'rechargeorderlist', '184', '2', 'order/rechargeorderlist', '1', '0', '2', '', '', '', '0', '1552127171', '0');
INSERT INTO `sys_module` VALUES ('12387', '菜单设置', 'admin', 'Config', 'wapBottomType', '533', '3', 'Config/wapBottomType', '0', '0', '0', '手机端菜单设置', '', '', '1', '0', '0');
INSERT INTO `sys_module` VALUES ('12414', '分类展示', 'admin', 'Config', 'wapCateGoryType', '533', '3', 'Config/wapCateGoryType', '0', '0', '0', '分类展示', '', '', '1', '0', '0');
INSERT INTO `sys_module` VALUES ('12453', '注册协议', 'admin', 'member', 'registrationAgreement', '137', '2', 'member/registrationAgreement', '1', '0', '3', '注册协议', '', '', '1', '0', '0');
INSERT INTO `sys_module` VALUES ('12484', '页面风格', 'admin', 'Config', 'wapStyle', '533', '3', 'config/wapStyle', '0', '0', '0', '页面风格', '', '', '1', '0', '0');
INSERT INTO `sys_module` VALUES ('12488', '编辑商品', 'admin', 'Goods', 'editGoods', '150', '3', 'Goods/editGoods', '1', '1', '0', '', '', '', '1', '1553065829', '0');
INSERT INTO `sys_module` VALUES ('12491', '广告位编辑', 'admin', 'system', 'updateshopadvposition', '533', '3', 'system/updateshopadvposition', '1', '1', '0', '', '', '', '1', '1553135726', '1553135759');
INSERT INTO `sys_module` VALUES ('12501', '楼层编辑', 'admin', 'block', 'edit', '533', '3', 'block/edit', '0', '0', '0', '楼层编辑', '', '', '1', '0', '0');
INSERT INTO `sys_module` VALUES ('12543', '团购', 'NsGroupBuy', 'Promotion', 'groupBuyList', '534', '3', 'Promotion/groupBuyList', '1', '0', '13', '团购列表', '', '', '1', '1553739597', '0');
INSERT INTO `sys_module` VALUES ('12544', '添加团购', 'NsGroupBuy', 'Promotion', 'addGroupBuy', '534', '3', 'Promotion/addGroupBuy', '1', '0', '13', '添加团购', '', '', '1', '1553739597', '0');
INSERT INTO `sys_module` VALUES ('12545', '修改团购团购', 'NsGroupBuy', 'Promotion', 'updateGroupBuy', '534', '3', 'Promotion/updateGroupBuy', '1', '0', '13', '修改团购', '', '', '1', '1553739597', '0');
INSERT INTO `sys_module` VALUES ('12546', '会员开店申请', 'admin', 'member', 'shopAgree', '137', '2', 'member/shopAgree', '1', '1', '5', '', '', '', '1', '1555399889', '0');
INSERT INTO `sys_module` VALUES ('12547', '会员开店申请/统计', 'admin', 'member', 'shopAgree', '137', '2', 'member/shopAgree', '1', '0', '5', '', '', '', '1', '1555399943', '1555402909');

-- ----------------------------
-- Table structure for `sys_notice`
-- ----------------------------
DROP TABLE IF EXISTS `sys_notice`;
CREATE TABLE `sys_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shopid` int(11) NOT NULL COMMENT '店铺ID（单店版为0）',
  `notice_message` varchar(255) DEFAULT '' COMMENT '公告内容',
  `is_enable` tinyint(1) DEFAULT '0' COMMENT '是否启用（0：隐藏，1：显示）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='网站公告';

-- ----------------------------
-- Records of sys_notice
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_notice_records`
-- ----------------------------
DROP TABLE IF EXISTS `sys_notice_records`;
CREATE TABLE `sys_notice_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `send_type` int(11) NOT NULL DEFAULT '0' COMMENT '发送类型 1 短信发送  2邮箱发送',
  `send_account` varchar(255) NOT NULL DEFAULT '' COMMENT '发送账号',
  `send_config` text NOT NULL COMMENT '发送的配置信息',
  `records_type` int(11) NOT NULL DEFAULT '0' COMMENT '记录类型  1充值成功 2确认订单 3付款成功 4下单成功 5订单发货 6商家提醒退款订单 7 商家提醒订单提醒 8充值成功 9注册短信验证码 10注册邮箱验证码',
  `notice_title` varchar(255) NOT NULL DEFAULT '' COMMENT '通知标题',
  `notice_context` text NOT NULL COMMENT '通知内容',
  `is_send` varchar(255) NOT NULL DEFAULT '0' COMMENT '是否发送  0未发送   1发送成功  2发送失败',
  `send_message` varchar(255) NOT NULL DEFAULT '' COMMENT '发送返回结果',
  `create_date` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `send_date` int(11) NOT NULL DEFAULT '0' COMMENT '发送时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=525 COMMENT='通知记录';

-- ----------------------------
-- Records of sys_notice_records
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_notice_template`
-- ----------------------------
DROP TABLE IF EXISTS `sys_notice_template`;
CREATE TABLE `sys_notice_template` (
  `template_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '模板id',
  `template_type` varchar(50) NOT NULL DEFAULT '' COMMENT '模板类型',
  `instance_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `template_code` varchar(50) NOT NULL DEFAULT '' COMMENT '模板编号',
  `template_title` varchar(50) NOT NULL DEFAULT '' COMMENT '模板编号',
  `template_content` text NOT NULL COMMENT '模板名称',
  `sign_name` varchar(50) NOT NULL DEFAULT '' COMMENT '签名',
  `is_enable` int(11) NOT NULL DEFAULT '0' COMMENT '是否开启',
  `modify_time` int(11) DEFAULT '0' COMMENT '更新时间',
  `notify_type` varchar(255) NOT NULL DEFAULT '' COMMENT '通知人类型',
  `notification_mode` text NOT NULL COMMENT '通知方式',
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1170 COMMENT='通知模版设置';

-- ----------------------------
-- Records of sys_notice_template
-- ----------------------------
INSERT INTO `sys_notice_template` VALUES ('1', 'email', '0', 'refund_order', '', '<p>{订单金额}</p>', '', '1', '1553485039', 'business', '');
INSERT INTO `sys_notice_template` VALUES ('2', 'email', '0', 'order_remind', '订单提醒-商家通知', '<p>q{商场名称}1</p><p>{用户名称}2</p><p>{主订单号}3</p><p>{订单金额}4</p>', '', '1', '1553485039', 'business', '');
INSERT INTO `sys_notice_template` VALUES ('3', 'email', '0', 'recharge_success', '', '<p></p>', '', '1', '1553485039', 'business', '');
INSERT INTO `sys_notice_template` VALUES ('4', 'sms', '0', 'after_register', 'SMS_107420199', '', '牛酷科技', '0', '1553072228', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('5', 'sms', '0', 'register_validate', 'SMS_107420199', '', '牛酷科技', '1', '1553072229', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('6', 'sms', '0', 'recharge_success', '', '', '', '0', '1553072229', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('7', 'sms', '0', 'confirm_order', '', '', '', '0', '1553072229', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('8', 'sms', '0', 'pay_success', '', '', '', '0', '1553072229', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('9', 'sms', '0', 'create_order', '', '', '', '0', '1553072229', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('10', 'sms', '0', 'order_deliver', '', '', '', '0', '1553072229', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('11', 'sms', '0', 'forgot_password', 'SMS_107420199', '', '牛酷科技', '1', '1553072229', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('12', 'sms', '0', 'bind_mobile', '', '', '', '0', '1553072229', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('13', 'email', '0', 'after_register', '注册成功', '<p>【{商场名称}】尊敬的用户，{用户名称}先生/女士，您已成功注册为我商城会员。请点击链接<a href=\"http://www.baidu.com\" target=\"_self\">http://www.baidu.com</a>查看您的会员权1。</p><p><img src=\"http://img.baidu.com/hi/jx2/j_0015.gif\"/></p>', '', '1', '1553224252', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('14', 'email', '0', 'register_validate', '注册验证', '<p>{验证码}</p>', '', '1', '1553224253', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('15', 'email', '0', 'recharge_success', '111', '<p>2222</p>', '', '1', '1553224253', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('16', 'email', '0', 'confirm_order', '确认订单', '<p>{主订单号}</p><p>{订单金额}</p>', '', '1', '1553224253', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('17', 'email', '0', 'pay_success', '付款成功', '<p>{商场名称}1</p>', '', '1', '1553224253', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('18', 'email', '0', 'create_order', '下单成功', '<p>{商场名称}</p>', '', '1', '1553224253', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('19', 'email', '0', 'order_deliver', '订单发货', '<p>{商场名称}</p>', '', '1', '1553224253', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('20', 'email', '0', 'forgot_password', '找回密码', '<p>{验证码}</p>', '', '1', '1553224253', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('21', 'email', '0', 'bind_email', '邮箱绑定', '<p>{验证码}</p>', '', '1', '1553224253', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('22', 'sms', '0', 'refund_order', '', '', '', '0', '1553485061', 'business', '');
INSERT INTO `sys_notice_template` VALUES ('23', 'sms', '0', 'order_remind', '', '', '', '0', '1553485062', 'business', '');
INSERT INTO `sys_notice_template` VALUES ('24', 'sms', '0', 'recharge_success', '', '', '', '0', '1553485062', 'business', '');
INSERT INTO `sys_notice_template` VALUES ('25', 'email', '0', 'open_the_group', '开团通知（用户）', '<p><span style=\"color: rgb(51, 51, 51); font-family: Arial, 微软雅黑; font-size: 14px;\">【仅剩{剩余人数}个名额】我{拼团价}元拼了{商品名称}，等你来跟我一起拼。</span></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p>', '', '1', '1553224253', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('26', 'email', '0', 'add_the_group', '参团通知（用户）', '<p>参团通知用户&nbsp;</p><p>团购人数：{团购人数}</p><p>剩余时间：{剩余时间}<br/></p><p>发起时间：{发起时间}<br/></p><p>拼团类型：{拼团类型}</p>', '', '1', '1553224253', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('27', 'email', '0', 'group_booking_success', '拼团成功用户通知', '<p>拼团成功用户通知</p><p>{商场名称}</p><p>{用户名称}</p><p>{主订单号}</p><p>{拼团价}</p>', '', '1', '1553224253', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('28', 'email', '0', 'group_booking_fail', '', '', '', '0', '1553224253', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('29', 'email', '0', 'open_the_group_business', '开团商家通知', '<p>{用户名称}</p><p>{商品名称}</p><p>{主订单号}</p><p>{拼团价}</p><p>{剩余人数}</p><p>{团购人数}</p>', '', '1', '1553485039', 'business', '');
INSERT INTO `sys_notice_template` VALUES ('30', 'email', '0', 'group_booking_success_business', '拼团成功商家通知', '<p>拼团成功商家通知</p><p>{剩余时间}</p><p>{拼团类型}</p><p>{团长名称}</p>', '', '1', '1553485039', 'business', '');
INSERT INTO `sys_notice_template` VALUES ('31', 'email', '0', 'bargain_launch', '砍价发起用户通知', '<p>商城名称：{商场名称}</p><p>用户名称：{用户名称}</p><p>商品名称：{商品名称}</p><p>剩余时间：{剩余时间}</p><p>砍价金额：{砍价金额}</p>', '', '1', '1553224253', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('32', 'email', '0', 'bargain_success', '砍价成功用户通知', '<p style=\"white-space: normal;\">商城名称：{商场名称}</p><p style=\"white-space: normal;\">用户名称：{用户名称}</p><p style=\"white-space: normal;\">商品名称：{商品名称}</p><p style=\"white-space: normal;\">主订单号：{主订单号}</p><p style=\"white-space: normal;\">砍价金额：{砍价金额}</p><p><br/></p>', '', '1', '1553224253', 'user', '');
INSERT INTO `sys_notice_template` VALUES ('33', 'email', '0', 'bargain_launch_business', '砍价发起商家通知', '<p style=\"white-space: normal;\">商城名称：{商场名称}</p><p style=\"white-space: normal;\">用户名称：{用户名称}</p><p style=\"white-space: normal;\">商品名称：{商品名称}</p><p style=\"white-space: normal;\">剩余时间：{剩余时间}</p><p style=\"white-space: normal;\">砍价金额：{砍价金额}</p><p><br/></p>', '', '1', '1553485039', 'business', '');
INSERT INTO `sys_notice_template` VALUES ('34', 'email', '0', 'bargain_success_business', '砍价成功商家通知', '<p style=\"white-space: normal;\">商城名称：{商场名称}</p><p style=\"white-space: normal;\">用户名称：{用户名称}</p><p style=\"white-space: normal;\">商品名称：{商品名称}</p><p style=\"white-space: normal;\">主订单号：{主订单号}</p><p style=\"white-space: normal;\">砍价金额：{砍价金额}</p><p><br/></p><p><br/></p>', '', '1', '1553485039', 'business', '');

-- ----------------------------
-- Table structure for `sys_notice_template_item`
-- ----------------------------
DROP TABLE IF EXISTS `sys_notice_template_item`;
CREATE TABLE `sys_notice_template_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(50) NOT NULL DEFAULT '' COMMENT '项名称',
  `show_name` varchar(50) NOT NULL DEFAULT '' COMMENT '显示名称',
  `replace_name` varchar(50) NOT NULL DEFAULT '' COMMENT '替换字段名字',
  `type_ids` varchar(2000) NOT NULL COMMENT '关联type类型',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1820 COMMENT='通知模板项';

-- ----------------------------
-- Records of sys_notice_template_item
-- ----------------------------
INSERT INTO `sys_notice_template_item` VALUES ('1', '商场名称', '{商场名称}', 'shopname', 'after_register,recharge_success,create_order,pay_success,confirm_order,order_deliver,order_remind,refund_order,open_the_group,add_the_group,group_booking_success,group_booking_fail,open_the_group_business,group_booking_success_business,bargain_launch,bargain_success,bargain_launch_business,bargain_success_business', '0');
INSERT INTO `sys_notice_template_item` VALUES ('2', '用户名称', '{用户名称}', 'username', 'after_register,recharge_success,create_order,pay_success,confirm_order,order_deliver,order_remind,refund_order,open_the_group,add_the_group,group_booking_success,group_booking_fail,open_the_group_business,bargain_launch,bargain_success,bargain_launch_business,bargain_success_business', '1');
INSERT INTO `sys_notice_template_item` VALUES ('5', '商品名称', '{商品名称}', 'goodsname', 'order_deliver,open_the_group,add_the_group,group_booking_success,group_booking_fail,open_the_group_business,group_booking_success_business,open_the_group_business,group_booking_success_business,bargain_launch,bargain_success,bargain_launch_business,bargain_success_business', '4');
INSERT INTO `sys_notice_template_item` VALUES ('6', '商品规格', '{商品规格}', 'goodssku', 'order_deliver', '5');
INSERT INTO `sys_notice_template_item` VALUES ('7', '主订单号', '{主订单号}', 'orderno', 'create_order,pay_success,confirm_order,order_deliver,order_remind,refund_order,open_the_group,add_the_group,group_booking_success,group_booking_fail,open_the_group_business,bargain_success,bargain_success_business', '6');
INSERT INTO `sys_notice_template_item` VALUES ('8', '订单金额', '{订单金额}', 'ordermoney', 'create_order,pay_success,confirm_order,order_deliver,order_remind,refund_order', '7');
INSERT INTO `sys_notice_template_item` VALUES ('9', '商品金额', '{商品金额}', 'goodsmoney', 'create_order,pay_success,order_deliver', '8');
INSERT INTO `sys_notice_template_item` VALUES ('10', '验证码', '{验证码}', 'number', 'register_validate,forgot_password,bind_mobile,bind_email', '9');
INSERT INTO `sys_notice_template_item` VALUES ('11', '充值金额', '{充值金额}', 'rechargemoney', 'recharge_success', '0');
INSERT INTO `sys_notice_template_item` VALUES ('12', '物流公司', '{物流公司}', 'expresscompany', 'order_deliver', '0');
INSERT INTO `sys_notice_template_item` VALUES ('13', '快递编号', '{快递编号}', 'expressno', 'order_deliver', '0');
INSERT INTO `sys_notice_template_item` VALUES ('14', '拼团价', '{拼团价}', 'pintuanmoney', 'open_the_group,add_the_group,group_booking_success,group_booking_fail,open_the_group_business,group_booking_success_business', '0');
INSERT INTO `sys_notice_template_item` VALUES ('15', '剩余人数', '{剩余人数}', 'surplusnumber', 'open_the_group,add_the_group,open_the_group_business', '0');
INSERT INTO `sys_notice_template_item` VALUES ('16', '团购人数', '{团购人数}', 'totalnumber', 'open_the_group,add_the_group,group_booking_success,group_booking_fail,open_the_group_business,group_booking_success_business', '0');
INSERT INTO `sys_notice_template_item` VALUES ('17', '发起时间', '{发起时间}', 'launchtime', 'open_the_group,add_the_group,group_booking_success,group_booking_fail,open_the_group_business,group_booking_success_business', '0');
INSERT INTO `sys_notice_template_item` VALUES ('18', '剩余时间', '{剩余时间}', 'surplustime', 'open_the_group,add_the_group,open_the_group_business,bargain_launch,bargain_launch_business', '0');
INSERT INTO `sys_notice_template_item` VALUES ('19', '拼团类型', '{拼团类型}', 'groupbookingtype', 'open_the_group,add_the_group,group_booking_success,group_booking_fail,open_the_group_business,group_booking_success_business', '0');
INSERT INTO `sys_notice_template_item` VALUES ('20', '团长名称', '{团长名称}', 'headgroup', 'group_booking_success_business', '0');
INSERT INTO `sys_notice_template_item` VALUES ('21', '砍价金额', '{砍价金额}', 'bargainminmoney', ',bargain_launch,bargain_success,bargain_launch_business,bargain_success_business', '0');

-- ----------------------------
-- Table structure for `sys_notice_template_type`
-- ----------------------------
DROP TABLE IF EXISTS `sys_notice_template_type`;
CREATE TABLE `sys_notice_template_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(50) NOT NULL DEFAULT '' COMMENT '模板名称',
  `template_code` varchar(50) NOT NULL DEFAULT '' COMMENT '模板编号',
  `template_type` varchar(50) NOT NULL DEFAULT '' COMMENT '模板类型',
  `notify_type` varchar(255) NOT NULL DEFAULT '' COMMENT '通知人类型',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2340 COMMENT='通知模板类型';

-- ----------------------------
-- Records of sys_notice_template_type
-- ----------------------------
INSERT INTO `sys_notice_template_type` VALUES ('1', '注册成功', 'after_register', 'all', 'user');
INSERT INTO `sys_notice_template_type` VALUES ('2', '注册验证', 'register_validate', 'all', 'user');
INSERT INTO `sys_notice_template_type` VALUES ('3', '充值成功', 'recharge_success', 'all', 'user');
INSERT INTO `sys_notice_template_type` VALUES ('4', '确认订单', 'confirm_order', 'all', 'user');
INSERT INTO `sys_notice_template_type` VALUES ('5', '付款成功', 'pay_success', 'all', 'user');
INSERT INTO `sys_notice_template_type` VALUES ('6', '下单成功', 'create_order', 'all', 'user');
INSERT INTO `sys_notice_template_type` VALUES ('7', '订单发货', 'order_deliver', 'all', 'user');
INSERT INTO `sys_notice_template_type` VALUES ('8', '找回密码', 'forgot_password', 'all', 'user');
INSERT INTO `sys_notice_template_type` VALUES ('9', '手机绑定', 'bind_mobile', 'sms', 'user');
INSERT INTO `sys_notice_template_type` VALUES ('10', '邮箱绑定', 'bind_email', 'email', 'user');
INSERT INTO `sys_notice_template_type` VALUES ('11', '退款订单', 'refund_order', 'all', 'business');
INSERT INTO `sys_notice_template_type` VALUES ('12', '订单提醒', 'order_remind', 'all', 'business');
INSERT INTO `sys_notice_template_type` VALUES ('13', '充值成功', 'recharge_success', 'all', 'business');
INSERT INTO `sys_notice_template_type` VALUES ('14', '开团通知', 'open_the_group', 'all', 'user');
INSERT INTO `sys_notice_template_type` VALUES ('15', '参团通知', 'add_the_group', 'all', 'user');
INSERT INTO `sys_notice_template_type` VALUES ('16', '拼团成功', 'group_booking_success', 'all', 'user');
INSERT INTO `sys_notice_template_type` VALUES ('17', '拼团失败', 'group_booking_fail', 'all', 'user');
INSERT INTO `sys_notice_template_type` VALUES ('18', '开团通知', 'open_the_group_business', 'all', 'business');
INSERT INTO `sys_notice_template_type` VALUES ('19', '拼团成功', 'group_booking_success_business', 'all', 'business');
INSERT INTO `sys_notice_template_type` VALUES ('20', '砍价发起', 'bargain_launch', 'all', 'user');
INSERT INTO `sys_notice_template_type` VALUES ('21', '砍价成功', 'bargain_success', 'all', 'user');
INSERT INTO `sys_notice_template_type` VALUES ('23', '砍价发起', 'bargain_launch_business', 'all', 'business');
INSERT INTO `sys_notice_template_type` VALUES ('24', '砍价成功', 'bargain_success_business', 'all', 'business');

-- ----------------------------
-- Table structure for `sys_province`
-- ----------------------------
DROP TABLE IF EXISTS `sys_province`;
CREATE TABLE `sys_province` (
  `province_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_id` tinyint(4) NOT NULL DEFAULT '0',
  `province_name` varchar(255) NOT NULL DEFAULT '',
  `sort` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`province_id`),
  KEY `IDX_g_province_ProvinceName` (`province_name`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=481;

-- ----------------------------
-- Records of sys_province
-- ----------------------------
INSERT INTO `sys_province` VALUES ('1', '2', '北京市', '0');
INSERT INTO `sys_province` VALUES ('2', '2', '天津市', '0');
INSERT INTO `sys_province` VALUES ('3', '2', '河北省', '0');
INSERT INTO `sys_province` VALUES ('4', '2', '山西省', '0');
INSERT INTO `sys_province` VALUES ('5', '2', '内蒙古自治区', '0');
INSERT INTO `sys_province` VALUES ('6', '5', '辽宁省', '0');
INSERT INTO `sys_province` VALUES ('7', '5', '吉林省', '0');
INSERT INTO `sys_province` VALUES ('8', '5', '黑龙江省', '0');
INSERT INTO `sys_province` VALUES ('9', '1', '上海市', '0');
INSERT INTO `sys_province` VALUES ('10', '1', '江苏省', '0');
INSERT INTO `sys_province` VALUES ('11', '1', '浙江省', '0');
INSERT INTO `sys_province` VALUES ('12', '1', '安徽省', '0');
INSERT INTO `sys_province` VALUES ('13', '3', '福建省', '0');
INSERT INTO `sys_province` VALUES ('14', '1', '江西省', '0');
INSERT INTO `sys_province` VALUES ('15', '2', '山东省', '0');
INSERT INTO `sys_province` VALUES ('16', '4', '河南省', '0');
INSERT INTO `sys_province` VALUES ('17', '4', '湖北省', '0');
INSERT INTO `sys_province` VALUES ('18', '4', '湖南省', '0');
INSERT INTO `sys_province` VALUES ('19', '3', '广东省', '0');
INSERT INTO `sys_province` VALUES ('20', '3', '广西壮族自治区', '0');
INSERT INTO `sys_province` VALUES ('21', '3', '海南省', '0');
INSERT INTO `sys_province` VALUES ('22', '7', '重庆市', '0');
INSERT INTO `sys_province` VALUES ('23', '7', '四川省', '0');
INSERT INTO `sys_province` VALUES ('24', '7', '贵州省', '0');
INSERT INTO `sys_province` VALUES ('25', '7', '云南省', '0');
INSERT INTO `sys_province` VALUES ('26', '7', '西藏自治区', '0');
INSERT INTO `sys_province` VALUES ('27', '6', '陕西省', '0');
INSERT INTO `sys_province` VALUES ('28', '6', '甘肃省', '0');
INSERT INTO `sys_province` VALUES ('29', '6', '青海省', '0');
INSERT INTO `sys_province` VALUES ('30', '6', '宁夏回族自治区', '0');
INSERT INTO `sys_province` VALUES ('31', '6', '新疆维吾尔自治区', '0');
INSERT INTO `sys_province` VALUES ('32', '8', '香港特别行政区', '0');
INSERT INTO `sys_province` VALUES ('33', '8', '澳门特别行政区', '0');
INSERT INTO `sys_province` VALUES ('34', '8', '台湾省', '0');

-- ----------------------------
-- Table structure for `sys_shequ`
-- ----------------------------
DROP TABLE IF EXISTS `sys_shequ`;
CREATE TABLE `sys_shequ` (
  `shequ_id` int(11) NOT NULL AUTO_INCREMENT,
  `district_id` int(11) NOT NULL DEFAULT '0' COMMENT '区县id',
  `city_id` int(11) NOT NULL DEFAULT '0' COMMENT '市id',
  `shequ_name` varchar(255) NOT NULL DEFAULT '' COMMENT '社区名称',
  `longitude` varchar(255) NOT NULL DEFAULT '' COMMENT '经度',
  `latitude` varchar(255) NOT NULL DEFAULT '' COMMENT '纬度',
  PRIMARY KEY (`shequ_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='社区';

-- ----------------------------
-- Records of sys_shequ
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_shortcut_menu`
-- ----------------------------
DROP TABLE IF EXISTS `sys_shortcut_menu`;
CREATE TABLE `sys_shortcut_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属用户',
  `shop_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属店铺',
  `sort` int(11) NOT NULL DEFAULT '0',
  `module_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '模块id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=21 COMMENT='快捷菜单';

-- ----------------------------
-- Records of sys_shortcut_menu
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_url_route`
-- ----------------------------
DROP TABLE IF EXISTS `sys_url_route`;
CREATE TABLE `sys_url_route` (
  `routeid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rule` varchar(255) NOT NULL DEFAULT '' COMMENT '伪静态路由规则',
  `route` varchar(255) NOT NULL DEFAULT '' COMMENT '路由地址',
  `is_open` int(1) NOT NULL DEFAULT '1' COMMENT '是否启用',
  `is_system` int(1) NOT NULL DEFAULT '0' COMMENT '是否是系统默认',
  `route_model` tinyint(4) NOT NULL DEFAULT '1' COMMENT '配置伪静态使用的模块1.shop2.wap3.admin',
  `remark` text NOT NULL COMMENT '简介',
  PRIMARY KEY (`routeid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2340 COMMENT='系统伪静态路由';

-- ----------------------------
-- Records of sys_url_route
-- ----------------------------
INSERT INTO `sys_url_route` VALUES ('1', 'goods', 'web/goods/detail', '1', '1', '1', '');
INSERT INTO `sys_url_route` VALUES ('2', 'list', 'web/goods/lists', '1', '1', '1', '');
INSERT INTO `sys_url_route` VALUES ('3', 'brands', 'web/goods/brand', '1', '1', '1', '');
INSERT INTO `sys_url_route` VALUES ('4', 'integralcenter', 'web/goods/point', '1', '1', '1', '');
INSERT INTO `sys_url_route` VALUES ('5', 'discountingimg', 'web/goods/discount', '1', '1', '1', '');
INSERT INTO `sys_url_route` VALUES ('8', 'article', 'web/article/detail', '1', '1', '1', '文章详情');

-- ----------------------------
-- Table structure for `sys_user`
-- ----------------------------
DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE `sys_user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `instance_id` int(11) NOT NULL DEFAULT '0' COMMENT '实例信息',
  `user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `user_password` varchar(255) NOT NULL DEFAULT '' COMMENT '用户密码（MD5）',
  `user_status` int(11) NOT NULL DEFAULT '1' COMMENT '用户状态  用户状态默认为1',
  `user_headimg` varchar(255) NOT NULL DEFAULT '' COMMENT '用户头像',
  `is_system` int(1) NOT NULL DEFAULT '0' COMMENT '是否是系统后台用户 0 不是 1 是',
  `is_member` int(11) NOT NULL DEFAULT '0' COMMENT '是否是前台会员',
  `user_tel` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  `user_tel_bind` int(1) NOT NULL DEFAULT '0' COMMENT '手机号是否绑定 0 未绑定 1 绑定 ',
  `user_qq` varchar(255) DEFAULT '' COMMENT 'qq号',
  `qq_openid` varchar(255) NOT NULL DEFAULT '' COMMENT 'qq互联id',
  `qq_info` varchar(2000) NOT NULL DEFAULT '' COMMENT 'qq账号相关信息',
  `user_email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `user_email_bind` int(1) NOT NULL DEFAULT '0' COMMENT '是否邮箱绑定',
  `wx_openid` varchar(255) DEFAULT NULL COMMENT '微信用户openid',
  `wx_is_sub` int(1) NOT NULL DEFAULT '0' COMMENT '微信用户是否关注',
  `wx_info` varchar(2000) DEFAULT NULL COMMENT '微信用户信息',
  `other_info` varchar(255) DEFAULT NULL COMMENT '附加信息',
  `current_login_ip` varchar(255) DEFAULT NULL COMMENT '当前登录ip',
  `current_login_type` int(11) DEFAULT NULL COMMENT '当前登录的操作终端类型',
  `last_login_ip` varchar(255) DEFAULT NULL COMMENT '上次登录ip',
  `last_login_type` int(11) DEFAULT NULL COMMENT '上次登录的操作终端类型',
  `login_num` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `real_name` varchar(50) DEFAULT '' COMMENT '真实姓名',
  `sex` smallint(6) DEFAULT '0' COMMENT '性别 0保密 1男 2女',
  `location` varchar(255) DEFAULT '' COMMENT '所在地',
  `nick_name` varchar(50) DEFAULT '牛酷用户' COMMENT '用户昵称',
  `wx_unionid` varchar(255) NOT NULL DEFAULT '' COMMENT '微信unionid',
  `qrcode_template_id` int(11) NOT NULL DEFAULT '0' COMMENT '模板id',
  `wx_sub_time` int(11) DEFAULT '0' COMMENT '微信用户关注时间',
  `wx_notsub_time` int(11) DEFAULT '0' COMMENT '微信用户取消关注时间',
  `reg_time` int(11) DEFAULT '0' COMMENT '注册时间',
  `current_login_time` int(11) DEFAULT '0' COMMENT '当前登录时间',
  `last_login_time` int(11) DEFAULT '0' COMMENT '上次登录时间',
  `birthday` int(11) DEFAULT '0',
  `user_shop` int(1) unsigned zerofill NOT NULL DEFAULT '0',
  `user_shop_agree` int(1) unsigned zerofill NOT NULL,
  `user_shop_fen` int(3) unsigned zerofill NOT NULL,
  `par_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`uid`),
  KEY `IDX_sys_user` (`wx_openid`,`wx_unionid`,`user_name`,`user_password`,`user_tel`,`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=372 COMMENT='系统用户表';

-- ----------------------------
-- Records of sys_user
-- ----------------------------
INSERT INTO `sys_user` VALUES ('3', '0', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '1', '', '1', '1', '', '0', '', '', '', '', '0', null, '0', null, null, '127.0.0.1', '1', '127.0.0.1', '1', '5', '', '0', '', 'admin', '', '0', '0', '0', '2019', '1555982414', '1555637253', '0', '0', '0', '000', null);
INSERT INTO `sys_user` VALUES ('4', '0', 'mtvjiao', 'e10adc3949ba59abbe56e057f20f883e', '1', '', '0', '1', '', '0', '', '', '', '', '0', '', '0', '', '', '127.0.0.1', '1', '127.0.0.1', '1', '3', '', '1', '', 'jj', '', '0', '0', '0', '1555394710', '1556067537', '1555568414', '0', '1', '1', '040', null);
INSERT INTO `sys_user` VALUES ('5', '0', 'mtvjiao1', 'e10adc3949ba59abbe56e057f20f883e', '1', '', '0', '1', '', '0', '', '', '', '', '0', '', '0', '', '', '127.0.0.1', '1', '', '0', '1', '', '1', '', '123', '', '0', '0', '0', '1555395809', '1555398086', '1555395811', '0', '0', '1', '040', null);
INSERT INTO `sys_user` VALUES ('6', '0', 'cece', 'e10adc3949ba59abbe56e057f20f883e', '1', '', '0', '1', '', '0', '', '', '', '', '0', '', '0', '', '', null, null, null, null, '0', '', '0', '', 'cece', '', '0', '0', '0', '1555569214', '0', '0', '0', '0', '0', '000', null);
INSERT INTO `sys_user` VALUES ('7', '0', '123123', '4297f44b13955235245b2497399d7a93', '1', '', '0', '1', '', '0', '', '', '', '', '0', '', '0', '', '', '127.0.0.1', '1', '', '0', '1', '', '0', '', '123123', '', '0', '0', '0', '1555569339', '1555569340', '0', '0', '0', '0', '000', null);
INSERT INTO `sys_user` VALUES ('8', '0', 'qweqwe', '4297f44b13955235245b2497399d7a93', '1', '', '0', '1', '', '0', '', '', '', '', '0', '', '0', '', '', '127.0.0.1', '1', '127.0.0.1', '1', '3', '', '0', '', 'qweqwe', '', '0', '0', '0', '1555569415', '1555986399', '1555641889', '0', '0', '0', '000', '4');

-- ----------------------------
-- Table structure for `sys_user_admin`
-- ----------------------------
DROP TABLE IF EXISTS `sys_user_admin`;
CREATE TABLE `sys_user_admin` (
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT 'user用户ID',
  `admin_name` varchar(50) NOT NULL DEFAULT '' COMMENT '用户姓名',
  `group_id_array` int(11) NOT NULL DEFAULT '0' COMMENT '系统用户组',
  `is_admin` int(1) NOT NULL DEFAULT '0' COMMENT '是否是系统管理员组',
  `admin_status` int(11) DEFAULT '1' COMMENT '状态 默认为1',
  `desc` text COMMENT '附加信息',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=910 COMMENT='后台管理员表';

-- ----------------------------
-- Records of sys_user_admin
-- ----------------------------
INSERT INTO `sys_user_admin` VALUES ('3', '管理员', '3', '1', '1', null);

-- ----------------------------
-- Table structure for `sys_user_group`
-- ----------------------------
DROP TABLE IF EXISTS `sys_user_group`;
CREATE TABLE `sys_user_group` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `instance_id` int(11) NOT NULL DEFAULT '1' COMMENT '实例ID',
  `group_name` varchar(50) NOT NULL DEFAULT '' COMMENT '用户组名称',
  `group_status` int(11) NOT NULL DEFAULT '1' COMMENT '用户组状态',
  `is_system` int(1) NOT NULL DEFAULT '0' COMMENT '是否是系统用户组',
  `module_id_array` text NOT NULL COMMENT '系统模块ID组，用，隔开',
  `desc` text COMMENT '描述',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=963 COMMENT='系统用户组表';

-- ----------------------------
-- Records of sys_user_group
-- ----------------------------
INSERT INTO `sys_user_group` VALUES ('3', '0', '管理员组', '1', '1', '120,121,122,123,124,126,127,128,129,133,137,139,144,145,149,150,151,169,170,171,172,176,179,180,184,185,186,187,189,190,191,192,194,195,196,197,198,199,200,201,202,203,210,218,221,334,335,336,339,340,341,342,343,359,360,361,383,387,390,392,394,395,409,418,419,420,421,422,423,424,425,427,430,431,432,433,434,436,437,439,440,441,442,443,444,445,446,447,450,451,452,455,456,459,469,471,472,474,477,478,479,480,481,482,484,485,486,487,488,489,490,494,495,496,497,498,499,501,502,503,504,506,509,510,512,513,518,519,523,524,525,526,527,528,529,530,531,532,533,534,535,536,537,538,539,540,10001,10002,10003,10005,10006,10075,11009,11010,11011,11012,11013,11014,11015,11017,11018,11019,11021,11023,11024,11026,11027,11028,11029,11030,11031,11032,11033,11034,11035,11036,11038,11045,11046,11050,11051,11053,11054,11056,11057,11058,11059,11060,11061,11062,11063,11067,11068,11069,11070,11074,11075,11078,11079,11080,11081,11082,11086,11087,11088,11090,11091,11092,11099,11108,11110,11112,11266,11339,11725,11802,11803,11809,11810,11811,11812,11819,11820,11822,11825,11870,11990,11991,12034,12035,12036,12037,12042,12387,12414,12453,12484,12488,12491,12501,12543,12544,12545', null, '2019', '0');

-- ----------------------------
-- Table structure for `sys_user_log`
-- ----------------------------
DROP TABLE IF EXISTS `sys_user_log`;
CREATE TABLE `sys_user_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '操作用户ID',
  `user_name` varchar(255) NOT NULL DEFAULT '' COMMENT '用户名称',
  `is_system` int(11) NOT NULL DEFAULT '1' COMMENT '是否是后台操作',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '对应url',
  `controller` varchar(255) NOT NULL DEFAULT '' COMMENT '操作控制器',
  `method` varchar(255) NOT NULL DEFAULT '' COMMENT '操作方案',
  `data` text COMMENT '传输数据',
  `ip` varchar(255) DEFAULT NULL COMMENT 'ip地址',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=82 COMMENT='用户操作日志';

-- ----------------------------
-- Records of sys_user_log
-- ----------------------------
INSERT INTO `sys_user_log` VALUES ('1', '3', 'admin', '1', 'http://127.0.0.1:8080/index.php?s=/admin/login/login', '用户', '用户登录', '', '127.0.0.1', '1555384120');
INSERT INTO `sys_user_log` VALUES ('2', '3', 'admin', '1', 'http://127.0.0.1:8080/index.php?s=/admin/login/login', '用户', '用户登录', '', '127.0.0.1', '1555461650');
INSERT INTO `sys_user_log` VALUES ('3', '3', 'admin', '1', 'http://127.0.0.1:8080/index.php?s=/admin/goods/addgoodscategory', '商品', '添加商品分类', '添加商品分类:衣服', '127.0.0.1', '1555481488');
INSERT INTO `sys_user_log` VALUES ('4', '3', 'admin', '1', 'http://127.0.0.1:8080/index.php?s=/admin/goods/GoodsCreateOrUpdate', '商品', '添加商品', '添加商品:测试', '127.0.0.1', '1555481540');
INSERT INTO `sys_user_log` VALUES ('5', '3', 'admin', '1', 'http://127.0.0.1:8080/index.php?s=/admin/goods/batchAddgoodscategory', '商品', '添加商品分类', '添加商品分类:', '127.0.0.1', '1555481943');
INSERT INTO `sys_user_log` VALUES ('6', '3', 'admin', '1', 'http://127.0.0.1:8080/index.php?s=/admin/goods/batchAddgoodscategory', '商品', '添加商品分类', '添加商品分类:', '127.0.0.1', '1555481951');
INSERT INTO `sys_user_log` VALUES ('7', '3', 'admin', '1', 'http://127.0.0.1:8080/index.php?s=/admin/goods/GoodsCreateOrUpdate', '商品', '修改商品', '修改商品:测试', '127.0.0.1', '1555481969');
INSERT INTO `sys_user_log` VALUES ('8', '3', 'admin', '1', 'http://127.0.0.1:8080/index.php?s=/admin/goods/GoodsCreateOrUpdate', '商品', '添加商品', '添加商品:测试2', '127.0.0.1', '1555489583');
INSERT INTO `sys_user_log` VALUES ('9', '3', 'admin', '1', 'http://127.0.0.1:8080/index.php?s=/admin/goods/batchAddgoodscategory', '商品', '添加商品分类', '添加商品分类:', '127.0.0.1', '1555489808');
INSERT INTO `sys_user_log` VALUES ('10', '3', 'admin', '1', 'http://127.0.0.1:8080/index.php?s=/admin/goods/GoodsCreateOrUpdate', '商品', '修改商品', '修改商品:测试2', '127.0.0.1', '1555489823');
INSERT INTO `sys_user_log` VALUES ('11', '3', 'admin', '1', 'http://127.0.0.1:8080/index.php?s=/admin/goods/GoodsCreateOrUpdate', '商品', '修改商品', '修改商品:测试2', '127.0.0.1', '1555489909');
INSERT INTO `sys_user_log` VALUES ('12', '3', 'admin', '1', 'http://127.0.0.1:8080/index.php?s=/admin/login/login', '用户', '用户登录', '', '127.0.0.1', '1555547896');
INSERT INTO `sys_user_log` VALUES ('13', '3', 'admin', '1', 'http://127.0.0.1:8080/index.php?s=/admin/login/login', '用户', '用户登录', '', '127.0.0.1', '1555637253');
INSERT INTO `sys_user_log` VALUES ('14', '3', 'admin', '1', 'http://127.0.0.1:8080/index.php?s=/admin/goods/GoodsCreateOrUpdate', '商品', '修改商品', '修改商品:测试2', '127.0.0.1', '1555637309');
INSERT INTO `sys_user_log` VALUES ('15', '3', 'admin', '1', 'http://127.0.0.1:8080/index.php?s=/admin/goods/GoodsCreateOrUpdate', '商品', '修改商品', '修改商品:测试', '127.0.0.1', '1555637331');
INSERT INTO `sys_user_log` VALUES ('16', '3', 'admin', '1', 'http://127.0.0.1:8080/index.php?s=/admin/goods/GoodsCreateOrUpdate', '商品', '添加商品', '添加商品:333', '127.0.0.1', '1555639479');
INSERT INTO `sys_user_log` VALUES ('17', '3', 'admin', '1', 'http://127.0.0.1:8080/index.php?s=/admin/goods/GoodsCreateOrUpdate', '商品', '修改商品', '修改商品:333', '127.0.0.1', '1555641115');
INSERT INTO `sys_user_log` VALUES ('18', '3', 'admin', '1', 'http://127.0.0.1:8080/index.php?s=/admin/login/login', '用户', '用户登录', '', '127.0.0.1', '1555982414');

-- ----------------------------
-- Table structure for `sys_version_devolution`
-- ----------------------------
DROP TABLE IF EXISTS `sys_version_devolution`;
CREATE TABLE `sys_version_devolution` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `devolution_username` varchar(255) NOT NULL DEFAULT '' COMMENT '授权账户',
  `devolution_password` varchar(255) NOT NULL DEFAULT '' COMMENT '授权密码',
  `create_date` int(11) DEFAULT '0' COMMENT '更新时间',
  `devolution_code` varchar(255) NOT NULL DEFAULT '' COMMENT '授权码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='用户授权信息';

-- ----------------------------
-- Records of sys_version_devolution
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_version_patch`
-- ----------------------------
DROP TABLE IF EXISTS `sys_version_patch`;
CREATE TABLE `sys_version_patch` (
  `patch_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `patch_type` int(11) NOT NULL DEFAULT '1' COMMENT '补丁类型  1. B2C单用户商城 2.B2C 单用户分销商城 3 B2B2C多用户商城',
  `patch_type_name` varchar(50) NOT NULL DEFAULT '' COMMENT '补丁类型名称',
  `patch_release` varchar(50) NOT NULL DEFAULT '' COMMENT '补丁编号',
  `patch_name` varchar(255) NOT NULL DEFAULT '' COMMENT '补丁标题',
  `patch_no` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '版本号',
  `patch_file_name` varchar(50) NOT NULL DEFAULT '' COMMENT '补丁文件名称',
  `patch_log` text NOT NULL COMMENT '版本补丁更新日志',
  `patch_file_size` varchar(255) NOT NULL DEFAULT '' COMMENT '补丁文件大小',
  `is_up` int(11) NOT NULL DEFAULT '2' COMMENT '是否升级  1代表已升级  0未升级 2全部',
  `modify_date` int(11) DEFAULT '0' COMMENT '更新时间',
  `patch_download_url` varchar(255) NOT NULL DEFAULT '' COMMENT '更新地址',
  `is_new_update` int(11) NOT NULL DEFAULT '0' COMMENT '是否为最新的更新版本',
  `from_version` varchar(255) NOT NULL DEFAULT '' COMMENT '在多少版本之上升级',
  PRIMARY KEY (`patch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='版本补丁管理';

-- ----------------------------
-- Records of sys_version_patch
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_version_update_records`
-- ----------------------------
DROP TABLE IF EXISTS `sys_version_update_records`;
CREATE TABLE `sys_version_update_records` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `auth_no` varchar(255) NOT NULL DEFAULT '' COMMENT '授权码',
  `update_type` int(11) NOT NULL DEFAULT '1' COMMENT '更新方式1. 线下2.在线',
  `version` varchar(50) NOT NULL DEFAULT '' COMMENT '当前版本',
  `update_version` varchar(255) NOT NULL DEFAULT '' COMMENT '升级版本',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `version_type` varchar(255) NOT NULL DEFAULT 'b2c' COMMENT '升级版本',
  `remark` text NOT NULL COMMENT '更新说明',
  `is_complete` int(11) NOT NULL DEFAULT '0' COMMENT '是否更新完成',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='版本升级记录表';

-- ----------------------------
-- Records of sys_version_update_records
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_wap_block_temp`
-- ----------------------------
DROP TABLE IF EXISTS `sys_wap_block_temp`;
CREATE TABLE `sys_wap_block_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '唯一标识',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `template_data` varchar(8000) DEFAULT NULL COMMENT '模板数据（JSON格式）',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间戳',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间戳',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='手机端模块表';

-- ----------------------------
-- Records of sys_wap_block_temp
-- ----------------------------
INSERT INTO `sys_wap_block_temp` VALUES ('6', 'WAP_BOTTOM_TYPE', '0', '{\"is_text\":1,\"is_background\":0,\"color\":\"#000000\",\"color_hover\":\"#ff0036\",\"showPage\":\"APP_MAIN/index/index,APP_MAIN/goods/category,APP_MAIN/member/index,APP_MAIN/goods/cart,APP_MAIN/goods/groupbuy,APP_MAIN/goods/brandlist,\",\"template_data\":[{\"menu_name\":\"首页\",\"href\":\"APP_MAIN/index\",\"href_name\":\"首页\",\"img_src\":\"upload/default/wap_nav/nav_home.png\",\"img_src_hover\":\"upload/default/wap_nav/nav_home_select.png\",\"color\":\"#000000\",\"color_hover\":\"#ff0036\"},{\"menu_name\":\"商品分类\",\"href\":\"APP_MAIN/goods/category\",\"href_name\":\"商品分类\",\"img_src\":\"upload/default/wap_nav/nav_category.png\",\"img_src_hover\":\"upload/default/wap_nav/nav_category_select.png\",\"color\":\"#000000\",\"color_hover\":\"#ff0036\"},{\"menu_name\":\"购物车\",\"href\":\"APP_MAIN/goods/cart\",\"href_name\":\"购物车\",\"img_src\":\"upload/default/wap_nav/nav_cart.png\",\"img_src_hover\":\"upload/default/wap_nav/nav_cart_select.png\",\"color\":\"#000000\",\"color_hover\":\"#ff0036\"},{\"menu_name\":\"会员中心\",\"href\":\"APP_MAIN/member/index\",\"href_name\":\"会员中心\",\"img_src\":\"upload/default/wap_nav/nav_member.png\",\"img_src_hover\":\"upload/default/wap_nav/nav_member_select.png\",\"color\":\"#000000\",\"color_hover\":\"#ff0036\"}]}', '1552353289', '1553500468');
INSERT INTO `sys_wap_block_temp` VALUES ('8', 'WAP_STYLE', '0', '{\"id\":\"3\",\"main_color\":\"#64c5aa\",\"secondary_color\":\"#333\",\"img\":\"style-img-64c5aa.png\"}', '1552707946', '1552988197');

-- ----------------------------
-- Table structure for `sys_wap_custom_template`
-- ----------------------------
DROP TABLE IF EXISTS `sys_wap_custom_template`;
CREATE TABLE `sys_wap_custom_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `template_name` varchar(250) DEFAULT '' COMMENT '自定义模板名称（暂时预留）',
  `template_data` longtext COMMENT '模板数据（JSON格式）',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间戳',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间戳',
  `is_enable` int(11) NOT NULL DEFAULT '0' COMMENT '是否启用 0 不启用 1 启用',
  `is_default` int(11) DEFAULT '0' COMMENT '是否为默认模板 0 不是 1 是',
  `template_type` varchar(255) NOT NULL DEFAULT '' COMMENT '模板所属页面',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='手机端自定义模板';

-- ----------------------------
-- Records of sys_wap_custom_template
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_website`
-- ----------------------------
DROP TABLE IF EXISTS `sys_website`;
CREATE TABLE `sys_website` (
  `website_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '网站标题',
  `logo` varchar(255) NOT NULL DEFAULT '' COMMENT '网站logo',
  `web_desc` varchar(1000) NOT NULL DEFAULT '' COMMENT '网站描述',
  `key_words` varchar(255) NOT NULL DEFAULT '' COMMENT '网站关键字',
  `web_icp` varchar(255) NOT NULL DEFAULT '' COMMENT '网站备案号',
  `style_id_pc` int(10) NOT NULL DEFAULT '2' COMMENT '前台网站风格（1：热情洋溢模板，2：蓝色清爽版）',
  `web_address` varchar(255) NOT NULL DEFAULT '' COMMENT '网站联系地址',
  `web_qrcode` varchar(255) NOT NULL DEFAULT '' COMMENT '网站公众号二维码',
  `web_url` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺网址',
  `web_email` varchar(255) NOT NULL DEFAULT '' COMMENT '网站邮箱',
  `web_phone` varchar(255) NOT NULL DEFAULT '' COMMENT '网站联系方式',
  `web_qq` varchar(255) NOT NULL DEFAULT '' COMMENT '网站qq号',
  `web_weixin` varchar(255) NOT NULL DEFAULT '' COMMENT '网站微信号',
  `web_status` int(10) NOT NULL DEFAULT '1' COMMENT '网站运营状态1.开启 2.关闭 ',
  `third_count` text NOT NULL COMMENT '第三方统计',
  `close_reason` varchar(255) NOT NULL DEFAULT '' COMMENT '站点关闭原因',
  `wap_status` int(10) NOT NULL DEFAULT '1' COMMENT '手机端运营状态 1.开启2.关闭',
  `style_id_admin` int(10) DEFAULT '4' COMMENT '后台网站风格（3：旧模板，4：新模板）',
  `create_time` int(11) DEFAULT '0' COMMENT '网站创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '网站修改时间',
  `url_type` int(11) NOT NULL DEFAULT '0' COMMENT '网站访问模式',
  `web_popup_title` varchar(50) NOT NULL DEFAULT '' COMMENT '网站弹出框标题',
  `web_wechat_share_logo` varchar(255) NOT NULL DEFAULT '' COMMENT '微信分享logo',
  `web_gov_record` varchar(60) NOT NULL DEFAULT '' COMMENT '网站公安备案信息',
  `web_gov_record_url` varchar(255) NOT NULL DEFAULT '' COMMENT '网站公安备案跳转链接地址',
  `is_show_follow` smallint(1) NOT NULL DEFAULT '1' COMMENT 'wap端是否显示顶部关注',
  PRIMARY KEY (`website_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='网站信息表';

-- ----------------------------
-- Records of sys_website
-- ----------------------------
INSERT INTO `sys_website` VALUES ('1', 'Niushop开源商城', 'upload/config/2019041601395675653.jpg', 'Niushop开源商城', '', '', '1', '山西省太原市', 'public/static/images/default_img_url/qrcode.png', 'http://www.niushop.com.cn/', '', '400-886-7993', '', '', '1', '', '对不起，牛酷商城维护中，大家敬请期待...', '1', '0', '1477452112', '1555393232', '0', '', '', '', '', '0');

-- ----------------------------
-- Table structure for `sys_web_style`
-- ----------------------------
DROP TABLE IF EXISTS `sys_web_style`;
CREATE TABLE `sys_web_style` (
  `style_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `style_name` varchar(50) NOT NULL DEFAULT '' COMMENT '样式名称',
  `style_path` varchar(255) NOT NULL DEFAULT '' COMMENT '样式路径',
  `stye_img` varchar(255) NOT NULL DEFAULT '' COMMENT '样式图片路径',
  `desc` text COMMENT '备注',
  `type` int(11) DEFAULT '1' COMMENT '1：前台样式，2：后台样式',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`style_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='网站前台样式表';

-- ----------------------------
-- Records of sys_web_style
-- ----------------------------
INSERT INTO `sys_web_style` VALUES ('1', '热情洋溢', 'default', '', null, '1', '0', '0');
INSERT INTO `sys_web_style` VALUES ('2', '蓝色清爽', 'blue', '', null, '1', '0', '0');
INSERT INTO `sys_web_style` VALUES ('4', '简约版', 'adminblue', '', '', '2', '1500862991', '1500862991');

-- ----------------------------
-- Table structure for `sys_weixin_auth`
-- ----------------------------
DROP TABLE IF EXISTS `sys_weixin_auth`;
CREATE TABLE `sys_weixin_auth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `instance_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `authorizer_appid` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺的appid  授权之后不用刷新',
  `authorizer_refresh_token` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺授权之后的刷新token，每月刷新',
  `authorizer_access_token` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺的公众号token，只有2小时',
  `func_info` varchar(1000) NOT NULL DEFAULT '' COMMENT '授权项目',
  `nick_name` varchar(50) NOT NULL DEFAULT '' COMMENT '公众号昵称',
  `head_img` varchar(255) NOT NULL DEFAULT '' COMMENT '公众号头像url',
  `user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '公众号原始账号',
  `alias` varchar(255) NOT NULL DEFAULT '' COMMENT '公众号原始名称',
  `qrcode_url` varchar(255) NOT NULL DEFAULT '' COMMENT '公众号二维码url',
  `auth_time` int(11) DEFAULT '0' COMMENT '授权时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='店铺(实例)微信公众账号授权';

-- ----------------------------
-- Records of sys_weixin_auth
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_weixin_default_replay`
-- ----------------------------
DROP TABLE IF EXISTS `sys_weixin_default_replay`;
CREATE TABLE `sys_weixin_default_replay` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `instance_id` int(11) NOT NULL COMMENT '店铺id',
  `reply_media_id` int(11) NOT NULL COMMENT '回复媒体内容id',
  `sort` int(11) NOT NULL,
  `create_time` int(11) DEFAULT '0',
  `modify_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='关注时回复';

-- ----------------------------
-- Records of sys_weixin_default_replay
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_weixin_fans`
-- ----------------------------
DROP TABLE IF EXISTS `sys_weixin_fans`;
CREATE TABLE `sys_weixin_fans` (
  `fans_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '粉丝ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '会员编号ID',
  `source_uid` int(11) NOT NULL DEFAULT '0' COMMENT '推广人uid',
  `instance_id` int(11) NOT NULL COMMENT '店铺ID',
  `nickname` varchar(255) NOT NULL COMMENT '昵称',
  `nickname_decode` varchar(255) DEFAULT '',
  `headimgurl` varchar(500) NOT NULL DEFAULT '' COMMENT '头像',
  `sex` smallint(6) NOT NULL DEFAULT '1' COMMENT '性别',
  `language` varchar(20) NOT NULL DEFAULT '' COMMENT '用户语言',
  `country` varchar(60) NOT NULL DEFAULT '' COMMENT '国家',
  `province` varchar(255) NOT NULL DEFAULT '' COMMENT '省',
  `city` varchar(255) NOT NULL DEFAULT '' COMMENT '城市',
  `district` varchar(255) NOT NULL DEFAULT '' COMMENT '行政区/县',
  `openid` varchar(255) NOT NULL DEFAULT '' COMMENT '用户的标识，对当前公众号唯一     用户的唯一身份ID',
  `unionid` varchar(255) NOT NULL DEFAULT '' COMMENT '粉丝unionid',
  `groupid` int(11) NOT NULL DEFAULT '0' COMMENT '粉丝所在组id',
  `is_subscribe` bigint(1) NOT NULL DEFAULT '1' COMMENT '是否订阅',
  `memo` varchar(255) NOT NULL COMMENT '备注',
  `subscribe_date` int(11) DEFAULT '0' COMMENT '订阅时间',
  `unsubscribe_date` int(11) DEFAULT '0' COMMENT '解订阅时间',
  `update_date` int(11) DEFAULT '0' COMMENT '粉丝信息最后更新时间',
  PRIMARY KEY (`fans_id`),
  KEY `IDX_sys_weixin_fans` (`unionid`,`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1638 COMMENT='微信公众号获取粉丝列表';

-- ----------------------------
-- Records of sys_weixin_fans
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_weixin_follow_replay`
-- ----------------------------
DROP TABLE IF EXISTS `sys_weixin_follow_replay`;
CREATE TABLE `sys_weixin_follow_replay` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `instance_id` int(11) NOT NULL COMMENT '店铺id',
  `reply_media_id` int(11) NOT NULL COMMENT '回复媒体内容id',
  `sort` int(11) NOT NULL,
  `create_time` int(11) DEFAULT '0',
  `modify_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='关注时回复';

-- ----------------------------
-- Records of sys_weixin_follow_replay
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_weixin_functions_button`
-- ----------------------------
DROP TABLE IF EXISTS `sys_weixin_functions_button`;
CREATE TABLE `sys_weixin_functions_button` (
  `button_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `instance_id` int(11) NOT NULL COMMENT '实例',
  `button_name` varchar(50) NOT NULL DEFAULT '' COMMENT '模块名',
  `keyname` varchar(20) NOT NULL DEFAULT '' COMMENT '触发关键词',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '触发网址',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '触发次数',
  `is_enabled` int(1) NOT NULL DEFAULT '1' COMMENT '是否启用',
  `is_system` int(1) DEFAULT '0',
  `orders` int(11) NOT NULL DEFAULT '0' COMMENT '排序号',
  `create_time` int(11) DEFAULT '0' COMMENT '创建日期',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改日期',
  PRIMARY KEY (`button_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1489 COMMENT='微信功能按钮';

-- ----------------------------
-- Records of sys_weixin_functions_button
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_weixin_instance_msg`
-- ----------------------------
DROP TABLE IF EXISTS `sys_weixin_instance_msg`;
CREATE TABLE `sys_weixin_instance_msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `instance_id` int(11) NOT NULL COMMENT '店铺id（单店版为0）',
  `template_no` varchar(55) NOT NULL COMMENT '模版编号',
  `template_id` varbinary(55) DEFAULT NULL COMMENT '微信模板消息的ID',
  `title` varchar(100) NOT NULL COMMENT '模版标题',
  `is_enable` bit(1) DEFAULT b'0' COMMENT '是否启用',
  `headtext` varchar(255) NOT NULL COMMENT '头部文字',
  `bottomtext` varchar(255) NOT NULL COMMENT '底部文字',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4096 COMMENT='微信实例消息';

-- ----------------------------
-- Records of sys_weixin_instance_msg
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_weixin_key_replay`
-- ----------------------------
DROP TABLE IF EXISTS `sys_weixin_key_replay`;
CREATE TABLE `sys_weixin_key_replay` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `instance_id` int(11) NOT NULL COMMENT '店铺id',
  `key` varchar(255) NOT NULL COMMENT '关键词',
  `match_type` tinyint(4) NOT NULL COMMENT '匹配类型1模糊匹配2全部匹配',
  `reply_media_id` int(11) NOT NULL COMMENT '回复媒体内容id',
  `sort` int(11) NOT NULL,
  `create_time` int(11) DEFAULT '0',
  `modify_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='关键词回复';

-- ----------------------------
-- Records of sys_weixin_key_replay
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_weixin_media`
-- ----------------------------
DROP TABLE IF EXISTS `sys_weixin_media`;
CREATE TABLE `sys_weixin_media` (
  `media_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '图文消息id',
  `title` varchar(100) DEFAULT NULL,
  `instance_id` int(11) NOT NULL DEFAULT '0' COMMENT '实例id店铺id',
  `type` varchar(255) NOT NULL DEFAULT '1' COMMENT '类型1文本(项表无内容) 2单图文 3多图文',
  `sort` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) DEFAULT '0' COMMENT '创建日期',
  `modify_time` int(11) DEFAULT '0' COMMENT '修改日期',
  PRIMARY KEY (`media_id`),
  UNIQUE KEY `id` (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1170;

-- ----------------------------
-- Records of sys_weixin_media
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_weixin_media_item`
-- ----------------------------
DROP TABLE IF EXISTS `sys_weixin_media_item`;
CREATE TABLE `sys_weixin_media_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `media_id` int(11) NOT NULL COMMENT '图文消息id',
  `title` varchar(100) DEFAULT NULL,
  `author` varchar(50) NOT NULL COMMENT '作者',
  `cover` varchar(200) NOT NULL COMMENT '图文消息封面',
  `show_cover_pic` tinyint(4) NOT NULL DEFAULT '1' COMMENT '封面图片显示在正文中',
  `summary` text,
  `content` text NOT NULL COMMENT '正文',
  `content_source_url` varchar(200) NOT NULL DEFAULT '' COMMENT '图文消息的原文地址，即点击“阅读原文”后的URL',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序号',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '阅读次数',
  PRIMARY KEY (`id`),
  KEY `id` (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=712;

-- ----------------------------
-- Records of sys_weixin_media_item
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_weixin_menu`
-- ----------------------------
DROP TABLE IF EXISTS `sys_weixin_menu`;
CREATE TABLE `sys_weixin_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `instance_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `menu_name` varchar(50) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `ico` varchar(32) NOT NULL DEFAULT '' COMMENT '菜图标单',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父菜单',
  `menu_event_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1普通url 2 图文素材 3 功能 4小程序',
  `media_id` int(11) NOT NULL DEFAULT '0' COMMENT '图文消息ID',
  `menu_event_url` varchar(255) NOT NULL DEFAULT '' COMMENT '菜单url',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '触发数',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_date` int(11) DEFAULT '0' COMMENT '创建日期',
  `modify_date` int(11) DEFAULT '0' COMMENT '修改日期',
  `appid` varchar(255) NOT NULL DEFAULT '' COMMENT '小程序id',
  `pagepath` varchar(255) NOT NULL DEFAULT '' COMMENT '小程序页面路径',
  PRIMARY KEY (`menu_id`),
  KEY `IDX_biz_shop_menu_orders` (`sort`),
  KEY `IDX_biz_shop_menu_shopId` (`instance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1638 COMMENT='微设置->微店菜单';

-- ----------------------------
-- Records of sys_weixin_menu
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_weixin_msg_template`
-- ----------------------------
DROP TABLE IF EXISTS `sys_weixin_msg_template`;
CREATE TABLE `sys_weixin_msg_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `template_no` varchar(55) NOT NULL COMMENT '编号',
  `title` varchar(100) NOT NULL COMMENT '标题',
  `contents` varchar(255) NOT NULL DEFAULT '' COMMENT '内容示例',
  `template_id` varchar(55) DEFAULT '' COMMENT '模版id',
  `headtext` varchar(255) DEFAULT NULL COMMENT '头部文字',
  `bottomtext` varchar(255) DEFAULT NULL COMMENT '底部文字',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信消息模版';

-- ----------------------------
-- Records of sys_weixin_msg_template
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_weixin_qrcode_template`
-- ----------------------------
DROP TABLE IF EXISTS `sys_weixin_qrcode_template`;
CREATE TABLE `sys_weixin_qrcode_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '实例ID',
  `instance_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `background` varchar(255) NOT NULL DEFAULT '' COMMENT '背景图片',
  `nick_font_color` varchar(255) NOT NULL DEFAULT '#000' COMMENT '昵称字体颜色',
  `nick_font_size` smallint(6) NOT NULL DEFAULT '12' COMMENT '昵称字体大小',
  `is_logo_show` smallint(6) NOT NULL DEFAULT '1' COMMENT 'logo是否显示',
  `header_left` varchar(6) NOT NULL DEFAULT '0px' COMMENT '头部左边距',
  `header_top` varchar(6) NOT NULL DEFAULT '0px' COMMENT '头部上边距',
  `name_left` varchar(6) NOT NULL DEFAULT '0px' COMMENT '昵称左边距',
  `name_top` varchar(6) NOT NULL DEFAULT '0px' COMMENT '昵称上边距',
  `logo_left` varchar(6) NOT NULL DEFAULT '0px' COMMENT 'logo左边距',
  `logo_top` varchar(6) NOT NULL DEFAULT '0px' COMMENT 'logo上边距',
  `code_left` varchar(6) NOT NULL DEFAULT '0px' COMMENT '二维码左边距',
  `code_top` varchar(6) NOT NULL DEFAULT '0px' COMMENT '二维码上边距',
  `is_check` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否默认',
  `is_remove` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除  0未删除 1删除',
  `template_url` varchar(255) NOT NULL DEFAULT '' COMMENT '模板样式路径',
  `qrcode_type` int(11) NOT NULL DEFAULT '1' COMMENT '二维码类型 1-推广关注 2-推广店铺',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=5461 COMMENT='微信推广二维码模板管理';

-- ----------------------------
-- Records of sys_weixin_qrcode_template
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_weixin_user_msg`
-- ----------------------------
DROP TABLE IF EXISTS `sys_weixin_user_msg`;
CREATE TABLE `sys_weixin_user_msg` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `msg_type` varchar(255) NOT NULL,
  `content` text,
  `is_replay` int(11) NOT NULL DEFAULT '0' COMMENT '是否回复',
  `create_time` int(11) DEFAULT '0',
  `openid` varchar(255) NOT NULL DEFAULT '' COMMENT '粉丝openid',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `headimgurl` varchar(500) NOT NULL DEFAULT '' COMMENT '头像',
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信用户消息表';

-- ----------------------------
-- Records of sys_weixin_user_msg
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_weixin_user_msg_replay`
-- ----------------------------
DROP TABLE IF EXISTS `sys_weixin_user_msg_replay`;
CREATE TABLE `sys_weixin_user_msg_replay` (
  `replay_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `msg_id` int(11) NOT NULL,
  `replay_uid` int(11) NOT NULL COMMENT '当前客服uid',
  `replay_type` varchar(255) NOT NULL,
  `content` text,
  `replay_time` int(11) DEFAULT '0',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  PRIMARY KEY (`replay_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信用户消息回复表';

-- ----------------------------
-- Records of sys_weixin_user_msg_replay
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_wexin_onekeysubscribe`
-- ----------------------------
DROP TABLE IF EXISTS `sys_wexin_onekeysubscribe`;
CREATE TABLE `sys_wexin_onekeysubscribe` (
  `instance_id` int(11) NOT NULL COMMENT '实例ID',
  `url` varchar(300) NOT NULL DEFAULT '' COMMENT '一键关注url',
  PRIMARY KEY (`instance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2048 COMMENT='微信一键关注设置';

-- ----------------------------
-- Records of sys_wexin_onekeysubscribe
-- ----------------------------
INSERT INTO `sys_wexin_onekeysubscribe` VALUES ('0', '');
