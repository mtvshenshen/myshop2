<?php
/**
 * Article.php
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

namespace app\web\controller;

/**
 * 文章控制器
 */
class Article extends BaseWeb
{
	/**
	 * 文章列表
	 */
	public function lists()
	{
		$page_index = request()->get('page_index', 1);
		$class_id = request()->get('class_id', '');
		$pid = request()->get('pid', '');
		$condition = [];
		if (!empty($class_id)) {
			$condition = [
				'nca.class_id' => $pid
			];
		}
		
		$this->assign('page_index', $page_index);
		$this->assign('class_id', $class_id);
		$this->assign('pid', $pid);
		$this->assign('condition', $condition);
		$this->assign("title_before", "文章列表");
		return $this->view($this->style . 'article/lists');
	}
	
	/**
	 * 文章详情
	 */
	public function detail()
	{
		$article_id = request()->get('article_id', 0);
		if (empty($article_id)) {
			$this->error("文章信息不存在");
		}
		
		$class_id = request()->get('class_id', '');
		$pid = request()->get('pid', '');
		$this->assign("article_id", $article_id);
		$this->assign('class_id', $class_id);
		$this->assign('pid', $pid);
		
		$this->assign("title_before", "文章详情");
		return $this->view($this->style . 'article/detail');
	}
}