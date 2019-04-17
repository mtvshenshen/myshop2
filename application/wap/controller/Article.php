<?php
/**
 * Articlecenter.php
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2015-2025 山西牛酷信息科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: http://www.niushop.com.cn
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用。
 * 任何企业和个人不允许对程序代码以任何形式任何目的再发布。
 * =========================================================
 * @author : niuteam
 * @date : 2015.1.17
 * @version : v1.0.0.0
 */

namespace app\wap\controller;

/**
 * 文章
 */
class Article extends BaseWap
{
	
	/**
	 * 首页
	 */
	public function lists()
	{
		$this->assign("title_before", "文章中心");
		$this->assign("title", lang('article_center'));
		return $this->view($this->style . 'article/lists');
	}
	
	/**
	 * 文章内容
	 */
	public function detail()
	{
		$this->assign("title_before", lang('article_content'));
		$this->assign("title", lang('article_content'));
		return $this->view($this->style . 'article/detail');
	}
}