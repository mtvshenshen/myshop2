<?php
/**
 * Article.php
 *
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

namespace data\service;

use data\service\BaseService as BaseService;
use data\model\NcCmsArticleModel;
use data\model\NcCmsArticleClassModel;
use data\model\NcCmsArticleViewModel;
use data\model\NcCmsCommentModel;
use data\model\NcCmsCommentViewModel;
use data\model\NcCmsTopicModel;
use think\Cache;


/**
 * 文章服务层
 * @author Administrator
 *
 */
class Article extends BaseService
{
	
	/**
	 * 获取文章列表
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 */
	public function getArticleList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$data = array( $page_index, $page_size, $condition, $order );
		$data = json_encode($data);
		
		$cache = Cache::tag("article")->get("getArticleList" . $data);
		if (empty($cache)) {
			$articleview = new NcCmsArticleViewModel();
			//查询该分类以及子分类下的文章列表
			if (!empty($condition['nca.class_id'])) {
				$article_class = new NcCmsArticleClassModel();
				$article_class_array = $article_class->getQuery([
					"class_id|pid" => $condition['nca.class_id']
				], "class_id", "");
				$new_article_class_array = array();
				foreach ($article_class_array as $v) {
					$new_article_class_array[] = $v["class_id"];
				}
				$condition["nca.class_id"] = array( "in", $new_article_class_array );
			}
			$list = $articleview->getViewList($page_index, $page_size, $condition, $order);
			Cache::tag("article")->set("getArticleList" . $data, $list);
			return $list;
		} else {
			return $cache;
		}
	}
	
	/**
	 * 获取文章详情
	 * @param int $article_id
	 */
	public function getArticleDetail($article_id)
	{
		$cache = Cache::tag("article")->get("getArticleDetail" . $article_id);
		if (empty($cache)) {
			$article = new NcCmsArticleModel();
			$data = $article->get($article_id);
			Cache::tag("article")->set("getArticleDetail" . $article_id, $data);
			return $data;
		} else {
			return $cache;
		}
		
	}
	
	/**
	 * 文章分类列表
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 */
	public function getArticleClass($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$data = array( $page_index, $page_size, $condition, $order );
		$data = json_encode($data);
		$cache = Cache::tag("article")->get("getArticleClass" . $data);
		if (empty($cache)) {
			$article_class = new NcCmsArticleClassModel();
			$list = $article_class->pageQuery($page_index, $page_size, $condition, $order, '*');
			Cache::tag("article")->set("getArticleClass" . $data, $list);
			return $list;
		} else {
			return $cache;
		}
		
	}
	
	/**
	 * 获取文章分类详情
	 * @param unknown $class_id
	 */
	public function getArticleClassDetail($class_id)
	{
		$cache = Cache::tag("article")->get("getArticleClassDetail" . $class_id);
		if (empty($cache)) {
			$article_class = new NcCmsArticleClassModel();
			$list = $article_class->get($class_id);
			Cache::tag("article")->set("getArticleClassDetail" . $class_id, $list);
			return $list;
		} else {
			return $cache;
		}
		
	}
	
	/**
	 * 添加文章
	 * @param unknown $title
	 * @param unknown $class_id
	 * @param unknown $short_title
	 * @param unknown $source
	 * @param unknown $url
	 * @param unknown $author
	 * @param unknown $summary
	 * @param unknown $content
	 * @param unknown $image
	 * @param unknown $keyword
	 * @param unknown $article_id_array
	 * @param unknown $click
	 * @param unknown $sort
	 * @param unknown $commend_flag
	 * @param unknown $comment_flag
	 * @param unknown $status
	 * @param unknown $attachment_path
	 * @param unknown $tag
	 * @param unknown $comment_count
	 * @param unknown $share_count
	 */
	public function addArticle($title, $class_id, $short_title, $source, $url, $author, $summary, $content, $image, $keyword, $article_id_array, $click, $sort, $commend_flag, $comment_flag, $status, $attachment_path, $tag, $comment_count, $share_count)
	{
		Cache::clear("article");
		$member = new Member();
		$user_info = $member->getUserInfoDetail($this->uid);
		$article = new NcCmsArticleModel();
		$data = array(
			'title' => $title,
			'class_id' => $class_id,
			'short_title' => $short_title,
			'source' => $source,
			'url' => $url,
			'author' => $author,
			'summary' => $summary,
			'content' => $content,
			'image' => $image,
			'keyword' => $keyword,
			'article_id_array' => $article_id_array,
			'click' => $click,
			'sort' => $sort,
			'commend_flag' => $commend_flag,
			'comment_flag' => $comment_flag,
			'status' => $status,
			'attachment_path' => $attachment_path,
			'tag' => $tag,
			'comment_count' => $comment_count,
			'share_count' => $share_count,
			'publisher_name' => $user_info["user_name"],
			'uid' => $this->uid,
			'public_time' => time(),
			'create_time' => time()
		);
		$article->save($data);
		$data['article_id'] = $article->article_id;
		hook("articleSaveSuccess", $data);
		$retval = $article->article_id;
		return $retval;
	}
	
	/**
	 * 修改文章
	 * @param unknown $article_id
	 * @param unknown $title
	 * @param unknown $class_id
	 * @param unknown $short_title
	 * @param unknown $source
	 * @param unknown $url
	 * @param unknown $author
	 * @param unknown $summary
	 * @param unknown $content
	 * @param unknown $image
	 * @param unknown $keyword
	 * @param unknown $article_id_array
	 * @param unknown $click
	 * @param unknown $sort
	 * @param unknown $commend_flag
	 * @param unknown $comment_flag
	 * @param unknown $status
	 * @param unknown $attachment_path
	 * @param unknown $tag
	 * @param unknown $comment_count
	 * @param unknown $share_count
	 */
	public function updateArticle($article_id, $title, $class_id, $short_title, $source, $url, $author, $summary, $content, $image, $keyword, $article_id_array, $click, $sort, $commend_flag, $comment_flag, $status, $attachment_path, $tag, $comment_count, $share_count)
	{
		Cache::clear("article");
		$member = new Member();
		$user_info = $member->getUserInfoDetail($this->uid);
		$article = new NcCmsArticleModel();
		$data = array(
			'title' => $title,
			'class_id' => $class_id,
			'short_title' => $short_title,
			'source' => $source,
			'url' => $url,
			'author' => $author,
			'summary' => $summary,
			'content' => $content,
			'image' => $image,
			'keyword' => $keyword,
			'article_id_array' => $article_id_array,
			'click' => $click,
			'sort' => $sort,
			'commend_flag' => $commend_flag,
			'comment_flag' => $comment_flag,
			'status' => $status,
			'attachment_path' => $attachment_path,
			'tag' => $tag,
			'comment_count' => $comment_count,
			'share_count' => $share_count,
			'publisher_name' => $user_info["user_name"],
			'uid' => $this->uid,
			'modify_time' => time()
		);
		$retval = $article->save($data, [ 'article_id' => $article_id ]);
		$data['article_id'] = $article_id;
		hook("articleSaveSuccess", $data);
		return $retval;
	}
	
	/**
	 * 添加文章分类
	 * @param unknown $name
	 * @param unknown $sort
	 */
	public function addAritcleClass($name, $sort, $pid)
	{
		Cache::clear("article");
		$article_class = new NcCmsArticleClassModel();
		$data = array(
			'name' => $name,
			'pid' => $pid,
			'sort' => $sort
		);
		$retval = $article_class->save($data);
		return $retval;
	}
	
	/**
	 * 修改文章分类
	 * @param unknown $class_id
	 * @param unknown $name
	 * @param unknown $sort
	 */
	public function updateArticleClass($class_id, $name, $sort, $pid)
	{
		Cache::clear("article");
		$article_class = new NcCmsArticleClassModel();
		$data = array(
			'name' => $name,
			'pid' => $pid,
			'sort' => $sort
		);
		$retval = $article_class->save($data, [ 'class_id' => $class_id ]);
		return $retval;
	}
	
	/**
	 * 修改文章排序
	 * @param unknown $article_id
	 * @param unknown $sort
	 */
	public function modifyArticleSort($article_id, $sort)
	{
		Cache::clear("article");
		$article = new NcCmsArticleModel();
		$data = array(
			'sort' => $sort
		);
		$retval = $article->save($data, [ 'article_id' => $article_id ]);
		return $retval;
	}
	
	/**
	 * 修改文章分类排序
	 * @param unknown $class_id
	 * @param unknown $sort
	 */
	public function modifyArticleClassSort($class_id, $sort)
	{
		Cache::clear("article");
		$article_class = new NcCmsArticleClassModel();
		$data = array(
			'sort' => $sort
		);
		$retval = $article_class->save($data, [ 'class_id' => $class_id ]);
		return $retval;
	}
	
	/**
	 * 删除文章分类（如果文章分类已被使用那就不可删除）
	 * @param int $class_id
	 */
	public function deleteArticleClass($class_id)
	{
		Cache::clear("article");
		$article_class = new NcCmsArticleClassModel();
		$retval = $article_class->destroy($class_id);
		return $retval;
	}
	
	/**
	 * 删除文章
	 * @param unknown $article_id
	 */
	public function deleteArticle($article_id)
	{
		Cache::clear("article");
		$article = new NcCmsArticleModel();
		$condition['article_id'] = [ 'in', $article_id ];
		$retval = $article->destroy($condition);
		return $retval;
	}
	
	/**
	 *  文章分类使用次数
	 * @param unknown $class_id
	 */
	public function articleClassUseCount($class_id)
	{
		$article = new NcCmsArticleModel();
		$is_class_count = $article->viewCount($article, [ 'class_id' => $class_id ]);
		return $is_class_count;
	}
	
	/**
	 * 文章评论列表
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 */
	public function getCommentList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$commentview = new NcCmsCommentViewModel();
		$list = $commentview->getViewList($page_index, $page_size, $condition, $order);
		return $list;
	}
	
	/**
	 * 查看评论详情
	 * @param int $comment_id
	 */
	public function getCommentDetail($comment_id)
	{
		$comment = new NcCmsCommentModel();
		$data = $comment->get($comment_id);
		return $data;
	}
	
	/**
	 * 删除评论
	 * @param int $comment_id
	 */
	public function deleteComment($comment_id)
	{
		$comment = new NcCmsCommentModel();
		$retval = $comment->destroy($comment_id);
		return $retval;
	}
	
	/**
	 * 获取文章分类
	 */
	public function getArticleClassQuery()
	{
		$cache = Cache::tag("article")->get("getArticleClassQuery");
		if (empty($cache)) {
			$list = $this->getArticleClass(1, 0, 'pid=0', 'sort');
			foreach ($list["data"] as $k => $v) {
				$second_list = $this->getArticleClass(1, 0, 'pid=' . $v['class_id'], 'sort');
				$list["data"][ $k ]['child_list'] = $second_list['data'];
			}
			Cache::tag("article")->set("getArticleClassQuery", $list);
			return $list;
		} else {
			return $cache;
		}
		
	}
	
	/**
	 * 添加专题
	 * @param unknown $instance_id
	 * @param unknown $title
	 * @param unknown $image
	 * @param unknown $content
	 */
	public function addTopic($instance_id, $title, $image, $content, $status)
	{
		Cache::clear("article");
		$topic = new NcCmsTopicModel();
		$data = array(
			'instance_id' => $instance_id,
			'title' => $title,
			'image' => $image,
			'content' => $content,
			'status' => $status,
			'create_time' => time()
		);
		$retval = $topic->save($data);
		return $retval;
	}
	
	/**
	 * 专题列表
	 * (non-PHPdoc)
	 */
	public function getTopicList($page_index = 1, $page_size = 0, $condition = '', $order = '', $field = '*')
	{
		$data = array( $page_index, $page_size, $condition, $order, $field );
		$data = json_encode($data);
		$cache = Cache::tag("article")->get("getTopicList" . $data);
		if (!empty($cache)) {
			return $cache;
		}
		$topic = new NcCmsTopicModel();
		$list = $topic->pageQuery($page_index, $page_size, $condition, $order, $field);
		Cache::tag("article")->set("getTopicList" . $data, $list);
		return $list;
	}
	
	/**
	 * 获取详情
	 * (non-PHPdoc)
	 */
	public function getTopicDetail($topic_id)
	{
		$cache = Cache::tag("article")->get("getTopicDetail" . $topic_id);
		if (!empty($cache)) {
			return $cache;
		}
		$topic = new NcCmsTopicModel();
		$list = $topic->get($topic_id);
		Cache::tag("article")->set("getTopicDetail" . $topic_id, $list);
		return $list;
	}
	
	/**
	 * 修改专题
	 * @param unknown $instance_id
	 * @param unknown $topic_id
	 * @param unknown $title
	 * @param unknown $image
	 * @param unknown $content
	 * @param unknown $status
	 */
	public function updateTopic($instance_id, $topic_id, $title, $image, $content, $status)
	{
		Cache::clear("article");
		$topic = new NcCmsTopicModel();
		$data = array(
			'instance_id' => $instance_id,
			'title' => $title,
			'image' => $image,
			'content' => $content,
			'status' => $status,
			'modify_time' => time()
		);
		$retval = $topic->save($data, [ 'topic_id' => $topic_id ]);
		return $retval;
	}
	
	/**
	 * 删除专题
	 * @param unknown $instance_id
	 * @param unknown $topic_id
	 */
	public function deleteTopic($topic_id)
	{
		Cache::clear("article");
		$topic = new NcCmsTopicModel();
		$retval = $topic->destroy($topic_id);
		return $retval;
	}
	
	/**
	 * 文章分类修改单个字符
	 * (non-PHPdoc)
	 */
	public function cmsField($class_id, $sort, $name)
	{
		Cache::clear("article");
		$article_class = new NcCmsArticleClassModel();
		$data = array(
			$sort => $name,
		);
		$retval = $article_class->save($data, [ 'class_id' => $class_id ]);
		return $retval;
		// TODO Auto-generated method stub
	}
	
	/**
	 * 增加文章点击量
	 * @param unknown $article_id
	 */
	public function updateArticleClickNum($article_id)
	{
		Cache::clear("article");
		$article_class = new NcCmsArticleModel();
		$article_class->where([ "article_id" => $article_id ])->setInc("click", 1);
	}
	

	/**
	 * 查询最*的一条
	 * @param unknown $condition
	 * @param string $order
	 * @return string
	 */
	public function getArticleFirst($condition, $order = ""){
	    $article_class = new NcCmsArticleModel();
	    $data = $article_class->getFirstData($condition, $order);
	    return $data;
	    
	}
}