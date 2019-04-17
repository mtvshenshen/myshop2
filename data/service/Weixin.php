<?php
/**
 * Weixin.php
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
 * @date : 2015.4.24
 * @version : v1.0.0.0
 */

namespace data\service;

use data\extend\WchatOauth;
use data\model\UserModel;
use data\model\WeixinAuthModel;
use data\model\WeixinDefaultReplayModel;
use data\model\WeixinFansModel;
use data\model\WeixinFollowReplayModel;
use data\model\WeixinKeyReplayModel;
use data\model\WeixinMediaItemModel;
use data\model\WeixinMediaModel;
use data\model\WeixinMenuModel;
use data\model\WeixinOneKeySubscribeModel;
use data\model\WeixinQrcodeTemplateModel;
use data\model\WeixinUserMsgModel;
use data\model\WeixinUserMsgReplayModel;
use data\service\BaseService;
use think\Request;
use data\model\NfxShopMemberAssociationModel;
use think\Cache;

class Weixin extends BaseService
{
	
	/**
	 * 获取微信菜单列表
	 *
	 * @param unknown $instance_id
	 * @param unknown $pid
	 * 当pid=''查询全部
	 */
	public function getWeixinMenuList($instance_id, $pid = '')
	{
		$cache = Cache::tag('weixin_menu')->get('getWeixinMenuList' . '_' . $instance_id . '_' . $pid);
		if (!empty($cache)) return $cache;
		
		$weixin_menu = new WeixinMenuModel();
		if ($pid == '') {
			$list = $weixin_menu->pageQuery(1, 0, [
				'instance_id' => $instance_id
			], 'sort', '*');
		} else {
			$list = $weixin_menu->pageQuery(1, 0, [
				'instance_id' => $instance_id,
				'pid' => $pid
			], 'sort', '*');
		}
		Cache::tag('weixin_menu')->set('getWeixinMenuList' . '_' . $instance_id . '_' . $pid, $list['data']);
		return $list['data'];
		// TODO Auto-generated method stub
	}
	
	/**
	 * 添加微信菜单
	 *
	 * @param unknown $indtance_id
	 * @param unknown $menu_name
	 * @param unknown $ico
	 * @param unknown $pid
	 * @param unknown $menu_event_type
	 * @param unknown $menu_event_url
	 * @param unknown $sort
	 */
	public function addWeixinMenu($instance_id, $menu_name, $ico, $pid, $menu_event_type, $menu_event_url, $media_id, $sort)
	{
		Cache::tag('weixin_menu')->set('getWeixinMenuList' . '_' . $instance_id . '_' . $pid, null);
		
		$weixin_menu = new WeixinMenuModel();
		$data = array(
			'instance_id' => $instance_id,
			'menu_name' => $menu_name,
			'ico' => $ico,
			'pid' => $pid,
			'menu_event_type' => $menu_event_type,
			'menu_event_url' => $menu_event_url,
			'media_id' => $media_id,
			'sort' => $sort,
			'create_date' => time()
		);
		$weixin_menu->save($data);
		return $weixin_menu->menu_id;
		// TODO Auto-generated method stub
	}
	
	/**
	 * 修改微信菜单
	 *
	 * @param unknown $menu_id
	 * @param unknown $instance_id
	 * @param unknown $menu_name
	 * @param unknown $ico
	 * @param unknown $pid
	 * @param unknown $menu_event_type
	 * @param unknown $menu_event_url
	 * @param unknown $sort
	 */
	public function updateWeixinMenu($menu_id, $instance_id, $menu_name, $ico, $pid, $menu_event_type, $menu_event_url, $media_id)
	{
		Cache::tag('weixin_menu')->set('getWeixinMenuList' . '_' . $instance_id . '_' . $pid, null);
		
		$weixin_menu = new WeixinMenuModel();
		$data = array(
			'instance_id' => $instance_id,
			'menu_name' => $menu_name,
			'ico' => $ico,
			'pid' => $pid,
			'menu_event_type' => $menu_event_type,
			'menu_event_url' => $menu_event_url,
			'media_id' => $media_id,
			'modify_date' => time()
		);
		$retval = $weixin_menu->save($data, [
			"menu_id" => $menu_id
		]);
		return $retval;
		// TODO Auto-generated method stub
	}
	
	/**
	 * 修改菜单排序
	 *
	 * @param unknown $menu_id_arr
	 * @param unknown $sort
	 */
	public function updateWeixinMenuSort($menu_id_arr)
	{
		Cache::clear('weixin_menu');
		
		$weixin_menu = new WeixinMenuModel();
		$retval = 0;
		foreach ($menu_id_arr as $k => $v) {
			$data = array(
				'sort' => $k + 1,
				'modify_date' => time()
			);
			$retval += $weixin_menu->save($data, [
				"menu_id" => $v
			]);
		}
		return $retval;
	}
	
	/**
	 * 修改菜单名称
	 *
	 * @param unknown $menu_id
	 * @param unknown $menu_name
	 */
	public function updateWeixinMenuName($menu_id, $menu_name)
	{
		Cache::clear('weixin_menu');
		
		$weixin_menu = new WeixinMenuModel();
		$retval = $weixin_menu->save([
			"menu_name" => $menu_name
		], [
			"menu_id" => $menu_id
		]);
		return $retval;
	}
	
	/**
	 * 修改跳转链接
	 *
	 * @param unknown $menu_id
	 * @param unknown $menu_eventurl
	 */
	public function updateWeixinMenuUrl($menu_id, $menu_event_url)
	{
		Cache::clear('weixin_menu');
		
		$weixin_menu = new WeixinMenuModel();
		$retval = $weixin_menu->save([
			"menu_event_url" => $menu_event_url
		], [
			"menu_id" => $menu_id
		]);
		return $retval;
	}
	
	/**
	 * 修改菜单类型，1：文本，2：单图文，3：多图文
	 *
	 * @param unknown $menu_id
	 * @param unknown $menu_event_type
	 */
	public function updateWeixinMenuEventType($menu_id, $menu_event_type)
	{
		Cache::clear('weixin_menu');
		$weixin_menu = new WeixinMenuModel();
		
		$retval = $weixin_menu->save([
			"menu_event_type" => $menu_event_type
		], [
			"menu_id" => $menu_id
		]);
		return $retval;
	}
	
	/**
	 * 修改图文消息
	 *
	 * @param unknown $menu_id
	 * @param unknown $media_id
	 * @param unknown $menu_event_type
	 */
	public function updateWeiXinMenuMessage($menu_id, $media_id, $menu_event_type)
	{
		Cache::clear('weixin_menu');
		
		$weixin_menu = new WeixinMenuModel();
		$retval = $weixin_menu->save([
			"media_id" => $media_id,
			"menu_event_type" => $menu_event_type
		], [
			"menu_id" => $menu_id
		]);
		return $retval;
	}
	
	/**
	 * 添加微信菜单点击数
	 *
	 * @param unknown $menu_id
	 */
	public function addMenuHits($menu_id)
	{
		
		// TODO Auto-generated method stub
	}
	
	/**
	 * 获取微信菜单详情
	 *
	 * @param unknown $menu_id
	 */
	public function getWeixinMenuDetail($menu_id)
	{
		$weixin_menu = new WeixinMenuModel();
		$data = $weixin_menu->get($menu_id);
		return $data;
		// TODO Auto-generated method stub
	}
	
	/**
	 * 公众号授权
	 *
	 * @param unknown $instance_id
	 * @param unknown $authorizer_appid
	 * @param unknown $authorizer_refresh_token
	 * @param unknown $authorizer_access_token
	 * @param unknown $func_info
	 * @param unknown $nick_name
	 * @param unknown $head_img
	 * @param unknown $user_name
	 * @param unknown $alias
	 * @param unknown $qrcode_url
	 */
	public function addWeixinAuth($instance_id, $authorizer_appid, $authorizer_refresh_token, $authorizer_access_token, $func_info, $nick_name, $head_img, $user_name, $alias, $qrcode_url)
	{
		Cache::clear('weixin');
		$weixin_auth = new WeixinAuthModel();
		$data = array(
			'instance_id' => $instance_id,
			'authorizer_appid' => $authorizer_appid,
			'authorizer_refresh_token' => $authorizer_refresh_token,
			'authorizer_access_token' => $authorizer_access_token,
			'func_info' => $func_info,
			'nick_name' => $nick_name,
			'head_img' => $head_img,
			'user_name' => $user_name,
			'alias' => $alias,
			'qrcode_url' => $qrcode_url,
			'auth_time' => time()
		);
		$count = $weixin_auth->where([
			'instance_id' => $instance_id
		])->count();
		if ($count == 0) {
			$weixin_auth = new WeixinAuthModel();
			$retval = $weixin_auth->save($data);
		} else {
			$weixin_auth = new WeixinAuthModel();
			$retval = $weixin_auth->save($data, [
				'instance_id' => $instance_id
			]);
		}
		
		return $retval;
		// TODO Auto-generated method stub
	}
	
	/**
	 * 用户关注添加粉丝信息
	 *
	 * @param unknown $instance_id
	 * @param unknown $nickname
	 * @param unknown $headimgurl
	 * @param unknown $sex
	 * @param unknown $language
	 * @param unknown $country
	 * @param unknown $province
	 * @param unknown $city
	 * @param unknown $district
	 * @param unknown $openid
	 * @param unknown $groupid
	 * @param unknown $is_subscribe
	 * @param unknown $memo
	 */
	public function addWeixinFans($source_uid, $instance_id, $nickname, $nickname_decode, $headimgurl, $sex, $language, $country, $province, $city, $district, $openid, $groupid, $is_subscribe, $memo, $unionid)
	{
		Cache::clear('weixin');
		if (empty($openid)) {
			return 1;
		}
		$weixin_fans = new WeixinFansModel();
		$count = $weixin_fans->where([
			'openid' => $openid
		])->count();
		if (!empty($this->uid)) {
			$uid = $this->uid;
		} else {
			$uid = 0;
		}
		$data = array(
			'uid' => $uid,
			'instance_id' => $instance_id,
			'nickname' => $nickname,
			'nickname_decode' => $nickname_decode,
			'headimgurl' => $headimgurl,
			'sex' => $sex,
			'language' => $language,
			'country' => $country,
			'province' => $province,
			'city' => $city,
			'district' => $district,
			'openid' => $openid,
			'groupid' => $groupid,
			'is_subscribe' => $is_subscribe,
			'update_date' => time(),
			'memo' => $memo,
			'unionid' => $unionid
		);
		if ($count == 0) {
			$weixin_fans = new WeixinFansModel();
			$data['source_uid'] = $source_uid;
			$data['subscribe_date'] = time();
			$retval = $weixin_fans->save($data);
		} else {
			if ($source_uid > 0) {
				$data['source_uid'] = $source_uid;
				$data['subscribe_date'] = time();
			}
			$weixin_fans = new WeixinFansModel();
			$retval = $weixin_fans->save($data, [
				'openid' => $openid
			]);
		}
		return $retval;
		// TODO Auto-generated method stub
	}
	
	/**
	 * 添加关注回复
	 *
	 * @param unknown $instance_id
	 * @param unknown $replay_media_id
	 * @param unknown $sort
	 */
	public function addFollowReplay($instance_id, $replay_media_id, $sort)
	{
		Cache::clear('weixin');
		
		$weixin_follow_replay = new WeixinFollowReplayModel();
		$data = array(
			'instance_id' => $instance_id,
			'reply_media_id' => $replay_media_id,
			'sort' => $sort,
			'create_time' => time()
		);
		$weixin_follow_replay->save($data);
		return $weixin_follow_replay->id;
		// TODO Auto-generated method stub
	}
	
	/**
	 * 添加默认回复
	 *
	 * @param unknown $instance_id
	 * @param unknown $replay_media_id
	 * @param unknown $sort
	 */
	public function addDefaultReplay($instance_id, $replay_media_id, $sort)
	{
		Cache::clear('weixin');
		
		$weixin_default_replay = new WeixinDefaultReplayModel();
		$data = array(
			'instance_id' => $instance_id,
			'reply_media_id' => $replay_media_id,
			'sort' => $sort,
			'create_time' => time()
		);
		$weixin_default_replay->save($data);
		return $weixin_default_replay->id;
	}
	
	/**
	 * 修改关注回复
	 *
	 * @param unknown $id
	 * @param unknown $instance_id
	 * @param unknown $replay_media_id
	 * @param unknown $sort
	 */
	public function updateFollowReplay($id, $instance_id, $replay_media_id, $sort)
	{
		Cache::clear('weixin');
		
		$weixin_follow_replay = new WeixinFollowReplayModel();
		$data = array(
			'instance_id' => $instance_id,
			'reply_media_id' => $replay_media_id,
			'sort' => $sort,
			'modify_time' => time()
		);
		$retval = $weixin_follow_replay->save($data, [
			'id' => $id
		]);
		return $retval;
		// TODO Auto-generated method stub
	}
	
	/**
	 * 修改默认回复
	 *
	 * @param unknown $id
	 * @param unknown $instance_id
	 * @param unknown $replay_media_id
	 * @param unknown $sort
	 */
	public function updateDefaultReplay($id, $instance_id, $replay_media_id, $sort)
	{
		Cache::clear('weixin');
		$weixin_default_replay = new WeixinDefaultReplayModel();
		$data = array(
			'instance_id' => $instance_id,
			'reply_media_id' => $replay_media_id,
			'sort' => $sort,
			'modify_time' => time()
		);
		$retval = $weixin_default_replay->save($data, [
			'id' => $id
		]);
		return $retval;
	}
	
	/**
	 * 添加关键字回复
	 *
	 * @param unknown $instance_id
	 * @param unknown $key
	 * @param unknown $match_type
	 * @param unknown $replay_media_id
	 * @param unknown $sort
	 */
	public function addKeyReplay($instance_id, $key, $match_type, $replay_media_id, $sort)
	{
		Cache::clear('weixin');
		
		$weixin_key_replay = new WeixinKeyReplayModel();
		$data = array(
			'instance_id' => $instance_id,
			'key' => $key,
			'match_type' => $match_type,
			'reply_media_id' => $replay_media_id,
			'sort' => $sort,
			'create_time' => time()
		);
		$weixin_key_replay->save($data);
		return $weixin_key_replay->id;
		// TODO Auto-generated method stub
	}
	
	/**
	 * 修改关键字回复
	 *
	 * @param unknown $id
	 * @param unknown $instance_id
	 * @param unknown $key
	 * @param unknown $match_type
	 * @param unknown $replay_media_id
	 * @param unknown $sort
	 */
	public function updateKeyReplay($id, $instance_id, $key, $match_type, $replay_media_id, $sort)
	{
		Cache::clear('weixin');
		
		$weixin_key_replay = new WeixinKeyReplayModel();
		$data = array(
			'instance_id' => $instance_id,
			'key' => $key,
			'match_type' => $match_type,
			'reply_media_id' => $replay_media_id,
			'sort' => $sort,
			'create_time' => time()
		);
		$retval = $weixin_key_replay->save($data, [
			'id' => $id
		]);
		return $retval;
		// TODO Auto-generated method stub
	}
	
	/**
	 * 获取关键词回复列表
	 *
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 */
	public function getKeyReplayList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$cache = Cache::tag('weixin')->get('getKeyReplayList' . json_encode([ $page_index, $page_size, $condition, $order ]));
		if (!empty($cache)) return $cache;
		
		$weixin_key_replay = new WeixinKeyReplayModel();
		$list = $weixin_key_replay->pageQuery($page_index, $page_size, $condition, $order, '*');
		Cache::tag('weixin')->set('getKeyReplayList' . json_encode([ $page_index, $page_size, $condition, $order ]), $list);
		
		return $list;
		// TODO Auto-generated method stub
	}
	
	/**
	 * 获取关注时回复列表
	 *
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 */
	public function getFollowReplayList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$cache = Cache::tag('weixin')->get('getFollowReplayList' . json_encode([ $page_index, $page_size, $condition, $order ]));
		if (!empty($cache)) return $cache;
		
		$weixin_follow_replay = new WeixinFollowReplayModel();
		$list = $weixin_follow_replay->pageQuery($page_index, $page_size, $condition, $order, '*');
		Cache::tag('weixin')->set('getFollowReplayList' . json_encode([ $page_index, $page_size, $condition, $order ]), $list);
		
		return $list;
		// TODO Auto-generated method stub
	}
	
	/**
	 * 获取默认回复列表
	 *
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 */
	public function getDefaultReplayList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$cache = Cache::tag('weixin')->get('getDefaultReplayList' . json_encode([ $page_index, $page_size, $condition, $order ]));
		if (!empty($cache)) return $cache;
		
		$weixin_default_replay = new WeixinDefaultReplayModel();
		$list = $weixin_default_replay->pageQuery($page_index, $page_size, $condition, $order, '*');
		Cache::tag('weixin')->set('getDefaultReplayList' . json_encode([ $page_index, $page_size, $condition, $order ]), $list);
		
		return $list;
	}
	
	/**
	 * 获取微信粉丝列表
	 *
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 */
	public function getWeixinFansList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$cache = Cache::tag('weixin')->get('getWeixinFansList' . json_encode([ $page_index, $page_size, $condition, $order ]));
		if (!empty($cache)) return $cache;
		
		$weixin_fans = new WeixinFansModel();
		$list = $weixin_fans->pageQuery($page_index, $page_size, $condition, $order, '*');
		Cache::tag('weixin')->set('getWeixinFansList' . json_encode([ $page_index, $page_size, $condition, $order ]), $list);
		
		return $list;
		// TODO Auto-generated method stub
	}
	
	/**
	 * 获取微信授权列表
	 *
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 */
	public function getWeixinAuthList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$cache = Cache::tag('weixin')->get('getWeixinAuthList' . json_encode([ $page_index, $page_size, $condition, $order ]));
		if (!empty($cache)) return $cache;
		
		$weixin_auth = new WeixinAuthModel();
		$list = $weixin_auth->pageQuery($page_index, $page_size, $condition, $order, '*');
		Cache::tag('weixin')->set('getWeixinAuthList' . json_encode([ $page_index, $page_size, $condition, $order ]), $list);
		
		return $list;
		// TODO Auto-generated method stub
	}
	
	/**
	 * 添加图文消息
	 *
	 * @param unknown $title
	 * @param unknown $instance_id
	 * @param unknown $type
	 * @param unknown $sort
	 * @param unknown $content
	 */
	public function addWeixinMedia($title, $instance_id, $type, $sort, $content)
	{
		Cache::clear('weixin');
		$weixin_media = new WeixinMediaModel();
		$weixin_media->startTrans();
		try {
			$data_media = array(
				'title' => $title,
				'instance_id' => $instance_id,
				'type' => $type,
				'sort' => $sort,
				'create_time' => time()
			);
			$weixin_media->save($data_media);
			$media_id = $weixin_media->media_id;
			if ($type == 1) {
				$this->addWeixinMediaItem($media_id, $title, '', '', '', '', '', '', 0);
			} else
				if ($type == 2) {
					$info = explode('`|`', $content);
					$this->addWeixinMediaItem($media_id, $info[0], $info[1], $info[2], $info[3], $info[4], $info[5], $info[6], 0);
				} else
					if ($type == 3) {
						$list = explode('`$`', $content);
						foreach ($list as $k => $v) {
							$arr = Array();
							$arr = explode('`|`', $v);
							$this->addWeixinMediaItem($media_id, $arr[0], $arr[1], $arr[2], $arr[3], $arr[4], $arr[5], $arr[6], 0);
						}
					}
			$weixin_media->commit();
			return 1;
		} catch (\Exception $e) {
			$weixin_media->rollback();
			return $e->getMessage();
		}
		// TODO Auto-generated method stub
	}
	
	/**
	 * 添加图文消息内容
	 *
	 * @param unknown $media_id
	 * @param unknown $title
	 * @param unknown $author
	 * @param unknown $cover
	 * @param unknown $show_cover_pic
	 * @param unknown $summary
	 * @param unknown $content
	 * @param unknown $content_source_url
	 * @param unknown $sort
	 */
	public function addWeixinMediaItem($media_id, $title, $author, $cover, $show_cover_pic, $summary, $content, $content_source_url, $sort)
	{
		Cache::clear('weixin');
		$weixin_media_item = new WeixinMediaItemModel();
		$data = array(
			'media_id' => $media_id,
			'title' => $title,
			'author' => $author,
			'cover' => $cover,
			'show_cover_pic' => $show_cover_pic,
			'summary' => $summary,
			'content' => $content,
			'content_source_url' => $content_source_url,
			'sort' => $sort
		);
		$retval = $weixin_media_item->save($data);
		return $retval;
		
		// TODO Auto-generated method stub
	}
	
	/**
	 * 获取微信图文消息列表
	 *
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 */
	public function getWeixinMediaList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$cache = Cache::tag('weixin')->get('getWeixinMediaList' . json_encode([ $page_index, $page_size, $condition, $order ]));
		if (!empty($cache)) return $cache;
		
		$weixin_media = new WeixinMediaModel();
		$list = $weixin_media->pageQuery($page_index, $page_size, $condition, $order, '*');
		if (!empty($list)) {
			foreach ($list['data'] as $k => $v) {
				$weixin_media_item = new WeixinMediaItemModel();
				$item_list = $weixin_media_item->getQuery([
					'media_id' => $v['media_id']
				], 'title', '');
				$list['data'][ $k ]['item_list'] = $item_list;
			}
		}
		Cache::tag('weixin')->set('getWeixinMediaList' . json_encode([ $page_index, $page_size, $condition, $order ]), $list);
		return $list;
		// TODO Auto-generated method stub
	}
	
	/**
	 * 获取图文消息详情，包括子
	 *
	 * @param unknown $media_id
	 */
	public function getWeixinMediaDetail($media_id)
	{
// 		$cache = Cache::tag('weixin')->get('getWeixinMediaDetail' . $media_id);
// 		if (!empty($cache)) return $cache;
		
		\think\Log::write('yyyyy');
		$weixin_media = new WeixinMediaModel();
		$weixin_media_info = $weixin_media->get($media_id);
		\think\Log::write('xxxx');
		\think\Log::write($weixin_media_info);
		if (!empty($weixin_media_info)) {
			$weixin_media_item = new WeixinMediaItemModel();
			$item_list = $weixin_media_item->getQuery([
				'media_id' => $media_id
			], '*', '');
			$weixin_media_info['item_list'] = $item_list;
		}
// 		Cache::tag('weixin')->set('getWeixinMediaDetail' . $media_id, $weixin_media_info);
		return $weixin_media_info;
	}
	
	/**
	 * 根据图文消息id查询
	 *
	 */
	public function getWeixinMediaDetailByMediaId($media_id)
	{
		$cache = Cache::tag('weixin')->get('getWeixinMediaDetailByMediaId' . $media_id);
		if (!empty($cache)) return $cache;
		
		$weixin_media_item = new WeixinMediaItemModel();
		$item_list = $weixin_media_item->getInfo([
			'id' => $media_id
		], '*');
		
		if (!empty($item_list)) {
			
			// 主表
			$weixin_media = new WeixinMediaModel();
			$weixin_media_info["media_parent"] = $weixin_media->getInfo([
				"media_id" => $item_list["media_id"]
			], "*");
			
			// 微信配置
			$weixin_auth = new WeixinAuthModel();
			$weixin_media_info["weixin_auth"] = $weixin_auth->getInfo([
				"instance_id" => $weixin_media_info["media_parent"]["instance_id"]
			], "*");
			
			$weixin_media_info["media_item"] = $item_list;
			
			// 更新阅读次数
			$res = $weixin_media_item->save([
				"hits" => ($item_list["hits"] + 1)
			], [
				"id" => $media_id
			]);
			Cache::tag('weixin')->set('getWeixinMediaDetailByMediaId' . $media_id, $weixin_media_info);
			return $weixin_media_info;
		}
		Cache::tag('weixin')->set('getWeixinMediaDetailByMediaId' . $media_id, null);
		return null;
	}
	
	/**
	 * 通过author_appid获取shopid
	 *
	 * @param unknown $author_appid
	 */
	public function getShopidByAuthorAppid($author_appid)
	{
		$cache = Cache::tag('weixin')->get('getShopidByAuthorAppid' . $author_appid);
		if (!empty($cache)) return $cache;
		
		$weixin_auth = new WeixinAuthModel();
		$instance_id = $weixin_auth->getInfo([
			'authorizer_appid' => $author_appid
		], 'instance_id');
		if (!empty($instance_id['instance_id'])) {
			$res = $instance_id['instance_id'];
		} else {
			$res = '';
		}
		
		Cache::tag('weixin')->set('getShopidByAuthorAppid' . $author_appid, $res);
		return $res;
	}
	
	/**
	 * 通过微信openID查询uid
	 *
	 * @param unknown $openid
	 */
	public function getWeixinUidByOpenid($openid)
	{
		$weixin_fans = new WeixinFansModel();
		$uid = $weixin_fans->getInfo([
			'openid' => $openid
		], 'uid');
		if (!empty($uid['uid'])) {
			return $uid['uid'];
		} else {
			return 0;
		}
	}
	
	/**
	 * 通过appid获取公众账号信息
	 *
	 * @param unknown $author_appid
	 */
	public function getWeixinInfoByAppid($author_appid)
	{
		$weixin_auth = new WeixinAuthModel();
		$info = $weixin_auth->getInfo([
			'authorizer_appid' => $author_appid
		], '*');
		return $info;
	}
	
	/**
	 * 取消关注
	 *
	 * @param unknown $instance_id
	 * @param unknown $openid
	 */
	public function WeixinUserUnsubscribe($instance_id, $openid)
	{
		$weixin_fans = new WeixinFansModel();
		$data = array(
			'is_subscribe' => 0,
			'unsubscribe_date' => time()
		);
		
		$retval = $weixin_fans->save($data, [
			'openid' => $openid
		]);
		return $retval;
	}
	
	/**
	 * 获取店铺微信授权信息
	 * @param unknown $instance_id
	 */
	public function getWeixinAuthInfo($instance_id)
	{
		$cache = Cache::tag('weixin')->get('getWeixinAuthInfo' . $instance_id);
		if (!empty($cache)) return $cache;
		
		$weixin_auth = new WeixinAuthModel();
		$data = $weixin_auth->getInfo([
			'instance_id' => $instance_id
		], '*');
		
		Cache::tag('weixin')->set('getWeixinAuthInfo' . $instance_id, $data);
		return $data;
	}
	
	/**
	 * 获取店铺微信菜单
	 * @param unknown $instance_id
	 * @return Ambigous <string, number>
	 */
	public function getInstanceWchatMenu($instance_id)
	{
		$cache = Cache::tag('weixin_menu')->get('getInstanceWchatMenu' . $instance_id);
		if (!empty($cache)) return $cache;
		
		$weixin_menu = new WeixinMenuModel();
		$foot_menu = $weixin_menu->getQuery([
			'instance_id' => $instance_id,
			'pid' => 0
		], '*', 'sort');
		if (!empty($foot_menu)) {
			foreach ($foot_menu as $k => $v) {
				$foot_menu[ $k ]['child'] = '';
				$second_menu = $weixin_menu->getQuery([
					'instance_id' => $instance_id,
					'pid' => $v['menu_id']
				], '*', 'sort');;
				if (!empty($second_menu)) {
					$foot_menu[ $k ]['child'] = $second_menu;
					$foot_menu[ $k ]['child_count'] = count($second_menu);
				} else {
					$foot_menu[ $k ]['child_count'] = 0;
				}
			}
		}
		
		Cache::tag('weixin_menu')->set('getInstanceWchatMenu' . $instance_id, $foot_menu);
		return $foot_menu;
	}
	
	/**
	 * 更新微信菜单
	 * @param unknown $instance_id
	 * @return mixed
	 */
	public function updateInstanceMenuToWeixin($instance_id)
	{
		$menu = array();
		$menu_list = $this->getInstanceWchatMenu($instance_id);
		if (!empty($menu_list)) {
			
			foreach ($menu_list as $k => $v) {
				if (!empty($v)) {
					$menu_item = array(
						'name' => ''
					);
					$menu_item['name'] = $v['menu_name'];
					
					// $menu_item['sub_menu'] = array();
					if (!empty($v['child'])) {
						
						foreach ($v['child'] as $k_child => $v_child) {
							if (!empty($v_child)) {
								$sub_menu = array();
								$sub_menu['name'] = $v_child['menu_name'];
								// $sub_menu['sub_menu'] = array();
								if ($v_child['menu_event_type'] == 1) {
									$sub_menu['type'] = 'view';
									$sub_menu['url'] = $v_child['menu_event_url'];
								} elseif ($v_child['menu_event_type'] == 4) {
									// 小程序
									$sub_menu['type'] = 'miniprogram';
									$sub_menu['appid'] = $v_child['appid'];
									$sub_menu['pagepath'] = $v_child['pagepath'];
									$sub_menu['url'] = $v_child['menu_event_url'];
								} else {
									$sub_menu['type'] = 'click';
									$sub_menu['key'] = $v_child['menu_id'];
								}
								
								$menu_item['sub_button'][] = $sub_menu;
							}
						}
					} else {
						if ($v['menu_event_type'] == 1) {
							$menu_item['type'] = 'view';
							$menu_item['url'] = $v['menu_event_url'];
						} elseif ($v['menu_event_type'] == 4) {
							// 小程序
							$menu_item['type'] = 'miniprogram';
							$menu_item['appid'] = $v['appid'];
							$menu_item['pagepath'] = $v['pagepath'];
							$menu_item['url'] = $v['menu_event_url'];
						} else {
							$menu_item['type'] = 'click';
							$menu_item['key'] = $v['menu_id'];
						}
					}
					$menu[] = $menu_item;
				}
			}
		}
		$menu_array = array();
		$menu_array['button'] = array();
		foreach ($menu as $k => $v) {
			$menu_array['button'][] = $v;
		}
		// 汉字不编码
		$menu_array = json_encode($menu_array);
		// 链接不转义
		$menu_array = preg_replace_callback("/\\\u([0-9a-f]{4})/i", create_function('$matches', 'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'), $menu_array);
		return $menu_array;
	}
	
	/**
	 * 获取图文消息微信结构
	 * @param unknown $media_info
	 */
	public function getMediaWchatStruct($media_info)
	{
		switch ($media_info['type']) {
			case "1":
				$contentStr = trim($media_info['title']);
				break;
			case "2":
				$pic_url = "";
				if (strstr($media_info['item_list'][0]['cover'], "http")) {
					$pic_url = $media_info['item_list'][0]['cover'];
				} else {
					$pic_url = Request::instance()->domain() . '/' . $media_info['item_list'][0]['cover'];
				}
				$contentStr[] = array(
					"Title" => $media_info['item_list'][0]['title'],
					"Description" => $media_info['item_list'][0]['summary'],
					"PicUrl" => $pic_url,
					"Url" => __URL(__URL__ . '/wap/wchat/message?media_id=' . $media_info['item_list'][0]['id'])
				);
				break;
			case "3":
				$contentStr = array();
				foreach ($media_info['item_list'] as $k => $v) {
					$pic_url = "";
					if (strstr($v['cover'], "http")) {
						$pic_url = $v['cover'];
					} else {
						$pic_url = Request::instance()->domain() . '/' . $v['cover'];
					}
					$contentStr[ $k ] = array(
						"Title" => $v['title'],
						"Description" => $v['summary'],
						"PicUrl" => $pic_url,
						"Url" => __URL(__URL__ . '/wap/wchat/message?media_id=' . $v['id'])
					);
				}
				break;
			default:
				$contentStr = "";
				break;
		}
		return $contentStr;
	}
	
	/**
	 * 获取关键字回复
	 *
	 * @param unknown $key_words
	 */
	public function getWhatReplay($instance_id, $key_words)
	{
		$weixin_key_replay = new WeixinKeyReplayModel();
		// 全部匹配
		$condition = array(
			'instance_id' => $instance_id,
			'key' => $key_words,
			'match_type' => 2
		);
		$info = $weixin_key_replay->getInfo($condition, '*');
		if (empty($info)) {
			// 模糊匹配
			$condition = array(
				'instance_id' => $instance_id,
				'key' => array(
					'LIKE',
					'%' . $key_words . '%'
				),
				'match_type' => 1
			);
			$info = $weixin_key_replay->getInfo($condition, '*');
		}
		if (!empty($info)) {
			$media_detail = $this->getWeixinMediaDetail($info['reply_media_id']);
			$content = $this->getMediaWchatStruct($media_detail);
			return $content;
		} else {
			return '';
		}
	}
	
	/**
	 * 获取关注回复
	 *
	 * @param unknown $instance_id
	 * @return unknown|string
	 */
	public function getSubscribeReplay($instance_id)
	{
		$cache = Cache::tag('weixin')->get('getSubscribeReplay' . $instance_id);
		if (!empty($cache)) return $cache;
		
		$weixin_flow_replay = new WeixinFollowReplayModel();
		$info = $weixin_flow_replay->getInfo([
			'instance_id' => $instance_id
		], '*');
		if (!empty($info)) {
			$media_detail = $this->getWeixinMediaDetail($info['reply_media_id']);
			$content = $this->getMediaWchatStruct($media_detail);
		} else {
			$content = '';
		}
		Cache::tag('weixin')->set('getSubscribeReplay' . $instance_id, $content);
		return $content;
	}
	
	/**
	 * 获取默认回复
	 * @param unknown $instance_id
	 * @return string
	 */
	public function getDefaultReplay($instance_id)
	{
		$cache = Cache::tag('weixin')->get('getDefaultReplay' . $instance_id);
		if (!empty($cache)) return $cache;
		
		$weixin_default_replay = new WeixinDefaultReplayModel();
		$info = $weixin_default_replay->getInfo([
			'instance_id' => $instance_id
		], '*');
		if (!empty($info)) {
			$media_detail = $this->getWeixinMediaDetail($info['reply_media_id']);
			$content = $this->getMediaWchatStruct($media_detail);
		} else {
			$content = '';
		}
		Cache::tag('weixin')->set('getDefaultReplay' . $instance_id, $content);
		return $content;
	}
	
	/**
	 * 获取会员 微信公众号二维码
	 *
	 */
	public function getUserWchatQrcode($uid, $instance_id)
	{
		$weixin_auth = new WchatOauth();
		$qrcode_url = $weixin_auth->ever_qrcode($uid);
		return $qrcode_url;
	}
	
	/**
	 * 获取推广二维码
	 * @param int $instance_id
	 * @param int $uid
	 */
	public function getWeixinQrcodeConfig($instance_id, $uid, $type = 1)
	{
		$cache = Cache::tag('weixin')->get('getWeixinQrcodeConfig' . '_' . $instance_id . '_' . $uid);
		if (!empty($cache)) return $cache;
		
		$user = new UserModel();
		$userinfo = $user->getInfo([
			"uid" => $uid
		]);
		$qrcode_template_id = $userinfo["qrcode_template_id"];
		$weixin_qrcode = new WeixinQrcodeTemplateModel();
		if ($qrcode_template_id == 0 || $qrcode_template_id == null) {
			$weixin_obj = $weixin_qrcode->getInfo([
				"instance_id" => $instance_id,
				"is_check" => 1,
			    'qrcode_type' => $type
			], "*");
		} else {
			$weixin_obj = $weixin_qrcode->getInfo([
				"instance_id" => $instance_id,
				"id" => $qrcode_template_id,
			    'qrcode_type' => $type
			], "*");
		}
		
		if (empty($weixin_obj)) {
			$weixin_obj = $weixin_qrcode->getInfo([
				"instance_id" => $instance_id,
				"is_remove" => 0,
			    'qrcode_type' => $type
			], "*");
		}
		Cache::tag('weixin')->set('getWeixinQrcodeConfig' . '_' . $instance_id . '_' . $uid, $weixin_obj);
		return $weixin_obj;
	}
	
	/**
	 * 修改推广二维码配置
	 * @param unknown $instance_id
	 * @param unknown $background
	 * @param unknown $nick_font_color
	 * @param unknown $nick_font_size
	 * @param unknown $is_logo_show
	 * @param unknown $header_left
	 * @param unknown $header_top
	 * @param unknown $name_left
	 * @param unknown $name_top
	 * @param unknown $logo_left
	 * @param unknown $logo_top
	 * @param unknown $code_left
	 * @param unknown $code_top
	 */
	public function updateWeixinQrcodeConfig($instance_id, $background, $nick_font_color, $nick_font_size, $is_logo_show, $header_left, $header_top, $name_left, $name_top, $logo_left, $logo_top, $code_left, $code_top)
	{
		Cache::clear('weixin');
		$weixin_qrcode = new WeixinQrcodeTemplateModel();
		$num = $weixin_qrcode->where([
			'instance_id' => $instance_id
		])->count();
		if ($num > 0) {
			$data = array(
				'background' => $background,
				'nick_font_color' => $nick_font_color,
				'nick_font_size' => $nick_font_size,
				'is_logo_show' => $is_logo_show,
				'header_left' => $header_left . 'px',
				'header_top' => $header_top . 'px',
				'name_left' => $name_left . 'px',
				'name_top' => $name_top . 'px',
				'logo_left' => $logo_left . 'px',
				'logo_top' => $logo_top . 'px',
				'code_left' => $code_left . 'px',
				'code_top' => $code_top . 'px'
			);
			$res = $weixin_qrcode->save($data, [
				'instance_id' => $instance_id
			]);
		} else {
			$data = array(
				'instance_id' => $instance_id,
				'background' => $background,
				'nick_font_color' => $nick_font_color,
				'nick_font_size' => $nick_font_size,
				'is_logo_show' => $is_logo_show,
				'header_left' => $header_left . 'px',
				'header_top' => $header_top . 'px',
				'name_left' => $name_left . 'px',
				'name_top' => $name_top . 'px',
				'logo_left' => $logo_left . 'px',
				'logo_top' => $logo_top . 'px',
				'code_left' => $code_left . 'px',
				'code_top' => $code_top . 'px'
			);
			$weixin_qrcode->save($data);
			$res = 1;
		}
		return $res;
		// TODO Auto-generated method stub
	}
	
	/**
	 * 修改图文消息
	 * @param unknown $media_id
	 * @param unknown $title
	 * @param unknown $instance_id
	 * @param unknown $type
	 * @param unknown $sort
	 * @param unknown $content
	 * @return number
	 */
	public function updateWeixinMedia($media_id, $title, $instance_id, $type, $sort, $content)
	{
		$weixin_media = new WeixinMediaModel();
		$weixin_media->startTrans();
		try {
			// 先修改 图文消息表
			$data_media = array(
				'title' => $title,
				'instance_id' => $instance_id,
				'type' => $type,
				'sort' => $sort,
				'create_time' => time()
			);
			$weixin_media->save($data_media, [
				'media_id' => $media_id
			]);
			// 修改 图文消息内容的时候 先删除了图文消息内容再添加一次
			$weixin_media_item = new WeixinMediaItemModel();
			$weixin_media_item->destroy([
				'media_id' => $media_id
			]);
			if ($type == 1) {
				$this->addWeixinMediaItem($media_id, $title, '', '', '', '', '', '', 0);
			} else
				if ($type == 2) {
					$info = explode('`|`', $content);
					$this->addWeixinMediaItem($media_id, $info[0], $info[1], $info[2], $info[3], $info[4], $info[5], $info[6], 0);
				} else
					if ($type == 3) {
						$list = explode('`$`', $content);
						foreach ($list as $k => $v) {
							$arr = Array();
							$arr = explode('`|`', $v);
							$this->addWeixinMediaItem($media_id, $arr[0], $arr[1], $arr[2], $arr[3], $arr[4], $arr[5], $arr[6], 0);
						}
					}
			$weixin_media->commit();
			Cache::clear('weixin');
			return 1;
		} catch (\Exception $e) {
			$weixin_media->rollback();
			return $e->getMessage();
		}
	}
	
	/**
	 * 删除图文消息
	 *
	 */
	public function deleteWeixinMedia($media_id)
	{
		Cache::clear('weixin');
		$weixin_media = new WeixinMediaModel();
		$res = $weixin_media->destroy([
			'media_id' => $media_id,
			'instance_id' => $this->instance_id
		]);
		if ($res) {
			$weixin_media_item = new WeixinMediaItemModel();
			$retval = $weixin_media_item->destroy([
				'media_id' => $media_id
			]);
		}
		
		return $res;
	}
	
	/**
	 * 删除图文消息详情下列表
	 */
	public function deleteWeixinMediaDetail($id)
	{
		Cache::clear('weixin');
		$weixin_media_item = new WeixinMediaItemModel();
		$res = $weixin_media_item->where("id=$id")->delete();
		return $res;
	}
	
	/**
	 * 删除微信自定义菜单
	 *
	 */
	public function deleteWeixinMenu($menu_id)
	{
		Cache::clear('weixin_menu');
		$weixin_menu = new WeixinMenuModel();
		$res = $weixin_menu->where("menu_id=$menu_id or pid=$menu_id")->delete();
		return $res;
	}
	
	/**
	 * 获取关注回复数据信息
	 * @param unknown $condition
	 */
	public function getFollowReplayDetail($condition)
	{
		$cache = Cache::tag('weixin')->get('getFollowReplayDetail' . json_encode($condition));
		if (!empty($cache)) return $cache;
		
		$weixin_follow_replay = new WeixinFollowReplayModel();
		$info = $weixin_follow_replay->get($condition);
		if ($info['reply_media_id'] > 0) {
			$info['media_info'] = $this->getWeixinMediaDetail($info['reply_media_id']);
		}
		
		Cache::tag('weixin')->set('getFollowReplayDetail' . json_encode($condition), $info);
		return $info;
	}
	
	/**
	 * 获取默认回复数据
	 * @param unknown $condition
	 * @return Ambigous <\think\static, unknown>
	 */
	public function getDefaultReplayDetail($condition)
	{
		$cache = Cache::tag('weixin')->get('getDefaultReplayDetail' . json_encode($condition));
		if (!empty($cache)) return $cache;
		
		$weixin_default_replay = new WeixinDefaultReplayModel();
		$info = $weixin_default_replay->get($condition);
		if ($info['reply_media_id'] > 0) {
			$info['media_info'] = $this->getWeixinMediaDetail($info['reply_media_id']);
		}
		Cache::tag('weixin')->set('getDefaultReplayDetail' . json_encode($condition), $info);
		return $info;
	}
	
	/**
	 * 删除关注回复
	 * @param unknown $instance_id
	 * @return number
	 */
	public function deleteFollowReplay($instance_id)
	{
		Cache::clear('weixin');
		$weixin_follow_replay = new WeixinFollowReplayModel();
		return $weixin_follow_replay->destroy([
			'instance_id' => $instance_id
		]);
	}
	
	/**
	 * 删除默认回复
	 * @param unknown $instance_id
	 */
	public function deleteDefaultReplay($instance_id)
	{
		Cache::clear('weixin');
		$weixin_default_replay = new WeixinDefaultReplayModel();
		return $weixin_default_replay->destroy([
			'instance_id' => $instance_id
		]);
	}
	
	/**
	 * 获取关键字回复信息
	 * @param unknown $id
	 * @return Ambigous <\think\static, unknown>
	 */
	public function getKeyReplyDetail($id)
	{
		$cache = Cache::tag('weixin')->get('getKeyReplyDetail' . $id);
		if (!empty($cache)) return $cache;
		
		$weixin_key_replay = new WeixinKeyReplayModel();
		$info = $weixin_key_replay->get($id);
		if ($info['reply_media_id'] > 0) {
			$info['media_info'] = $this->getWeixinMediaDetail($info['reply_media_id']);
		}
		Cache::tag('weixin')->set('getKeyReplyDetail' . $id, $info);
		return $info;
	}
	
	/**
	 * 删除关键字回复
	 * @param unknown $id
	 * @return number
	 */
	public function deleteKeyReplay($id)
	{
		Cache::clear('weixin');
		$weixin_key_replay = new WeixinKeyReplayModel();
		return $weixin_key_replay->destroy($id);
	}
	
	/**
	 * 得到店铺的推广二维码模板列表
	 */
	public function getWeixinQrcodeTemplate($shop_id, $type = 1)
	{
		$weixin_qrcode_template = new WeixinQrcodeTemplateModel();
		return $weixin_qrcode_template->all(array(
			"instance_id" => $shop_id,
			"is_remove" => 0,
		    "qrcode_type" => $type
		));
	}
	
	/**
	 * 将某个模板设置为最新默认模板
	 */
	public function modifyWeixinQrcodeTemplateCheck($shop_id, $id, $type)
	{
		Cache::clear('weixin');
		$weixin_qrcode_template = new WeixinQrcodeTemplateModel();
		$weixin_qrcode_template->where(array(
			"instance_id" => $shop_id,
		    'qrcode_type' => $type
		))->update(array(
			"is_check" => 0
		));
		$retval = $weixin_qrcode_template->where(array(
			"instance_id" => $shop_id,
			"id" => $id,
		    'qrcode_type' => $type
		))->update(array(
			"is_check" => 1
		));
		return $retval;
	}
	
	/**
	 * 添加店铺推广二维码
	 * @param unknown $instance_id
	 * @param unknown $background
	 * @param unknown $nick_font_color
	 * @param unknown $nick_font_size
	 * @param unknown $is_logo_show
	 * @param unknown $header_left
	 * @param unknown $header_top
	 * @param unknown $name_left
	 * @param unknown $name_top
	 * @param unknown $logo_left
	 * @param unknown $logo_top
	 * @param unknown $code_left
	 * @param unknown $code_top
	 * @param unknown $template_url
	 */
	public function addWeixinQrcodeTemplate($instance_id, $background, $nick_font_color, $nick_font_size, $is_logo_show, $header_left, $header_top, $name_left, $name_top, $logo_left, $logo_top, $code_left, $code_top, $template_url, $qrcode_type)
	{
		Cache::clear('weixin');
		$weixin_qrcode = new WeixinQrcodeTemplateModel();
		$data = array(
			'instance_id' => $instance_id,
			'background' => $background,
			'nick_font_color' => $nick_font_color,
			'nick_font_size' => $nick_font_size,
			'is_logo_show' => $is_logo_show,
			'header_left' => $header_left . 'px',
			'header_top' => $header_top . 'px',
			'name_left' => $name_left . 'px',
			'name_top' => $name_top . 'px',
			'logo_left' => $logo_left . 'px',
			'logo_top' => $logo_top . 'px',
			'code_left' => $code_left . 'px',
			'code_top' => $code_top . 'px',
			'template_url' => $template_url,
		    'qrcode_type' => $qrcode_type
		);
		$weixin_query = $weixin_qrcode->getQuery([
			"instance_id" => $instance_id,
			"is_check" => 1
		], "*", '');
		if (empty($weixin_query)) {
			$data["is_check"] = 1;
		}
		$res = $weixin_qrcode->save($data);
		return $weixin_qrcode->id;
	}
	
	/**
	 * 更新店铺推广二维码
	 * @param unknown $id
	 * @param unknown $instance_id
	 * @param unknown $background
	 * @param unknown $nick_font_color
	 * @param unknown $nick_font_size
	 * @param unknown $is_logo_show
	 * @param unknown $header_left
	 * @param unknown $header_top
	 * @param unknown $name_left
	 * @param unknown $name_top
	 * @param unknown $logo_left
	 * @param unknown $logo_top
	 * @param unknown $code_left
	 * @param unknown $code_top
	 * @param unknown $template_url
	 * @return boolean
	 */
	public function updateWeixinQrcodeTemplate($id, $instance_id, $background, $nick_font_color, $nick_font_size, $is_logo_show, $header_left, $header_top, $name_left, $name_top, $logo_left, $logo_top, $code_left, $code_top, $template_url)
	{
		Cache::clear('weixin');
		$weixin_qrcode = new WeixinQrcodeTemplateModel();
		$data = array(
			'instance_id' => $this->instance_id,
			'background' => $background,
			'nick_font_color' => $nick_font_color,
			'nick_font_size' => $nick_font_size,
			'is_logo_show' => $is_logo_show,
			'header_left' => $header_left . 'px',
			'header_top' => $header_top . 'px',
			'name_left' => $name_left . 'px',
			'name_top' => $name_top . 'px',
			'logo_left' => $logo_left . 'px',
			'logo_top' => $logo_top . 'px',
			'code_left' => $code_left . 'px',
			'code_top' => $code_top . 'px',
			'template_url' => $template_url,
		);
		
		$res = $weixin_qrcode->save($data, [
			'id' => $id
		]);
		return $res;
	}
	
	/**
	 * 删除模板
	 * (non-PHPdoc)
	 */
	public function deleteWeixinQrcodeTemplate($id, $instance_id)
	{
		Cache::clear('weixin');
		$weixin_qrcode_template = new WeixinQrcodeTemplateModel();
		$retval = $weixin_qrcode_template->where(array(
			"instance_id" => $instance_id,
			"id" => $id
		))->update(array(
			"is_remove" => 1
		));
		return $retval;
	}
	
	/**
	 * 查询单个模板的具体信息
	 */
	public function getDetailWeixinQrcodeTemplate($id)
	{
		$cache = Cache::tag('weixin')->get('getDetailWeixinQrcodeTemplate' . $id);
		if (!empty($cache)) return $cache;
		
		if ($id == 0) {
			$template_obj = array(
				"background" => "",
				"nick_font_color" => "#2B2B2B",
				"nick_font_size" => "23",
				"is_logo_show" => 1,
				"header_left" => "59px",
				"header_top" => "15px",
				"name_left" => "150px",
				"name_top" => "120px",
				"logo_top" => "100px",
				"logo_left" => "120px",
				"code_left" => "70px",
				"code_top" => "300px"
			);
		} else {
			$weixin_qrcode_template = new WeixinQrcodeTemplateModel();
			$template_obj = $weixin_qrcode_template->get($id);
		}
		Cache::tag('weixin')->set('getDetailWeixinQrcodeTemplate' . $id, $template_obj);
		return $template_obj;
	}
	
	/**
	 * 用户更换 自己的推广二维码
	 */
	public function updateMemberQrcodeTemplate($shop_id, $uid)
	{
		Cache::clear('weixin');
		$user = new UserModel();
		$userinfo = $user->getInfo([
			"uid" => $uid
		], "qrcode_template_id");
		$qrcode_template_id = $userinfo["qrcode_template_id"];
		$qrcode_template = new WeixinQrcodeTemplateModel();
		if ($qrcode_template_id == 0 || $qrcode_template_id == null) {
			$template_obj = $qrcode_template->getInfo([
				"instance_id" => $shop_id,
				"is_remove" => 0
			], "*");
		} else {
			$condition["id"] = array(
				">",
				$qrcode_template_id
			);
			$condition["instance_id"] = $shop_id;
			$condition["is_remove"] = 0;
			$template_obj = $qrcode_template->getInfo($condition, "*");
			if (empty($template_obj)) {
				$template_obj = $qrcode_template->getInfo([
					"instance_id" => $shop_id,
					"is_remove" => 0
				], "*");
			}
		}
		if (!empty($template_obj)) {
			$user->where(array(
				"uid" => $uid
			))->update(array(
				"qrcode_template_id" => $template_obj["id"]
			));
		}
	}
	
	/**
	 * 获取一键关注
	 * @param unknown $instance_id
	 * @return \think\static
	 */
	public function getInstanceOneKeySubscribe($instance_id)
	{
		$cache = Cache::tag('weixin')->get('getInstanceOneKeySubscribe' . $instance_id);
		if (!empty($cache)) return $cache;
		
		$weixin_subscribe = new WeixinOneKeySubscribeModel();
		$info = $weixin_subscribe->get($instance_id);
		if (empty($info)) {
			$data = array(
				'instance_id' => $instance_id,
				'url' => ''
			);
			$weixin_subscribe->save($data);
			$info = $weixin_subscribe->get($instance_id);
		}
		Cache::tag('weixin')->set('getInstanceOneKeySubscribe' . $instance_id, $info);
		return $info;
	}
	
	/**
	 * 获取一定条件下粉丝数量
	 * @param unknown $condition
	 */
	public function getWeixinFansCount($condition)
	{
		$cache = Cache::tag('weixin')->get('getWeixinFansCount' . json_encode($condition));
		if (!empty($cache)) return $cache;
		
		$weixin_fans = new WeixinFansModel();
		$count = $weixin_fans->where($condition)->count();
		
		Cache::tag('weixin')->set('getWeixinFansCount' . json_encode($condition), $count);
		return $count;
	}
	
	/**
	 * 获取会员关注微信信息(non-PHPdoc)
	 */
	public function getUserWeixinSubscribeData($uid, $instance_id)
	{
		$cache = Cache::tag('weixin')->get('getUserWeixinSubscribeData_' . $instance_id . '_' . $uid);
		if (!empty($cache)) return $cache;
		
		// 查询会员信息
		$user = new UserModel();
		$user_info = $user->getInfo([
			'uid' => $uid
		], 'wx_openid,wx_unionid');
		$fans_info = '';
		// 通过openid查询信息
		if (!empty($user_info['wx_openid'])) {
			$weixin_fans = new WeixinFansModel();
			$fans_info = $weixin_fans->getInfo([
				'openid' => $user_info['wx_openid']
			]);
		}
		if (empty($fans_info) && !empty($user_info['wx_unionid'])) {
			$weixin_fans = new WeixinFansModel();
			$fans_info = $weixin_fans->getInfo([
				'unionid' => $user_info['wx_unionid']
			]);
		}
		Cache::tag('weixin')->set('getUserWeixinSubscribeData_' . $instance_id . '_' . $uid, $fans_info);
		return $fans_info;
	}
	
	/**
	 * 通过微信openid获取粉丝表信息
	 * @param unknown $wx_openid
	 */
	public function getWeixinFansInfoByWxOpenid($wx_openid)
	{
		$cache = Cache::tag('weixin')->get('getWeixinFansInfoByWxOpenid' . $wx_openid);
		if (!empty($cache)) return $cache;
		
		$weixin_fans = new WeixinFansModel();
		$fans_info = $weixin_fans->getInfo([
			'openid' => $wx_openid
		]);
		
		Cache::tag('weixin')->set('getWeixinFansInfoByWxOpenid' . $wx_openid, $fans_info);
		return $fans_info;
	}
	
	/**
	 * 添加用户消息
	 * @param unknown $openid
	 * @param unknown $content
	 * @param unknown $msg_type
	 */
	public function addUserMessage($openid, $content, $msg_type)
	{
		Cache::clear('weixin');
		$weixin_user_msg = new WeixinUserMsgModel();
		$fans_model = new WeixinFansModel();
		$fans_info = $fans_model->getInfo([ 'openid' => $openid ], 'nickname,headimgurl,uid');
		if (!empty($fans_info)) {
			$data = array(
				'uid' => $fans_info['uid'],
				'openid' => $openid,
				'nickname' => $fans_info['nickname'],
				'headimgurl' => $fans_info['headimgurl'],
				'msg_type' => $msg_type,
				'content' => $content,
				'create_time' => time()
			);
			$weixin_user_msg->save($data);
			return $weixin_user_msg->msg_id;
		} else {
			return 0;
		}
	}
	
	/**
	 * 获取会员留言列表
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 * @return multitype:number unknown
	 */
	public function getUserMessageList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$cache = Cache::tag('weixin')->get('getUserMessageList' . json_encode([ $page_index, $page_size, $condition, $order ]));
		if (!empty($cache)) return $cache;
		
		$weixin_user_msg = new WeixinUserMsgModel();
		$list = $weixin_user_msg->pageQuery($page_index, $page_size, $condition, $order, '*');
		
		Cache::tag('weixin')->set('getUserMessageList' . json_encode([ $page_index, $page_size, $condition, $order ]), $list);
		return $list;
	}
	
	/**
	 * 添加微信客服消息
	 * @param unknown $msg_id
	 * @param unknown $replay_uid
	 * @param unknown $replay_type
	 * @param unknown $content
	 */
	public function addUserMessageReplay($msg_id, $replay_uid, $replay_type, $content)
	{
		Cache::clear('weixin');
		$weixin_user_msg_replay = new WeixinUserMsgReplayModel();
		$data = array(
			'msg_id' => $msg_id,
			'replay_uid' => $replay_uid,
			'replay_type' => $replay_type,
			'content' => $content,
			'replay_time' => time()
		);
		$weixin_user_msg_replay->save($data);
		return $weixin_user_msg_replay->replay_id;
	}
	
	/**
	 * 更新粉丝信息
	 * @param string $next_openid
	 * @return mixed
	 */
	public function UpdateWchatFansList($openid_array)
	{
		Cache::clear('weixin');
		$wchatOauth = new WchatOauth();
		$fans_list_info = $wchatOauth->get_fans_info_list($openid_array);
		//获取微信粉丝列表
		if (isset($fans_list_info["errcode"]) && $fans_list_info["errcode"] < 0) {
			return $fans_list_info;
		} else {
			foreach ($fans_list_info['user_info_list'] as $info) {
				$province = filterStr($info["province"]);
				$city = filterStr($info["city"]);
				$nickname = filterStr($info['nickname']);
				$nickname_decode = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $info['nickname']);
				$this->addWeixinFans(0, $this->instance_id, $nickname, $nickname_decode, $info["headimgurl"], $info["sex"], $info["language"], $info["country"], $province, $city, "", $info["openid"], $info["groupid"], $info["subscribe"], $info["remark"], $info["unionid"]);
			}
		}
		return array(
			'errcode' => '0',
			'errorMsg' => 'success'
		);
		
	}
	
	/**
	 * 获取微信所有openid
	 */
	public function getWeixinOpenidList()
	{
		$wchatOauth = new WchatOauth();
		$res = $wchatOauth->get_fans_list("");
		if (!empty($res['data'])) {
			$openid_list = $res['data']['openid'];
			$wchatOauth = new WchatOauth();
			while ($res['next_openid']) {
				$res = $wchatOauth->get_fans_list($res['next_openid']);
				if (!empty($res['data'])) {
					$openid_list = array_merge($openid_list, $res['data']['openid']);
				}
				
			}
			return array(
				'total' => $res['total'],
				'openid_list' => $openid_list,
				'errcode' => '0',
				'errorMsg' => ''
			);
			
		} else {
			if (!empty($res["errcode"])) {
				return array(
					'errcode' => $res['errcode'],
					'errorMsg' => $res['errmsg'],
					'total' => 0,
					'openid_list' => ''
				);
			} else {
				return array(
					'errcode' => '-400001',
					'errorMsg' => '当前无粉丝列表或者获取失败',
					'total' => 0,
					'openid_list' => ''
				);
			}
			
		}
		
	}
	
	/**
	 *
	 * @param unknown $menu_id
	 * @param unknown $type
	 * @param unknown $val
	 */
	public function updateMenuSmallProgramConfig($menu_id, $type, $val)
	{
		Cache::clear('weixin_menu');
		$weixin_menu = new WeixinMenuModel();
		$data = array();
		if ($type == "appid") {
			$data["appid"] = $val;
		} elseif ($type == "pagepath") {
			$data["pagepath"] = $val;
		}
		$retval = $weixin_menu->save($data, [ "menu_id" => $menu_id ]);
		return $retval;
	}
	
	public function userBoundParent($openid, $source_uid)
	{
		//判断当前扫码人是不是会员
		$user_model = new UserModel();
		$user_info = $user_model->getInfo([ 'wx_openid' => $openid ], '*');
		if (empty($user_info)) {
			//如果不是会员，检测fans表，如果没有上级，设定上级是对应的souce_uid,
			$fans_model = new WeixinFansModel();
			$fans_info = $fans_model->getInfo([ 'openid' => $openid ], '*');
			if (!empty($fans_info) && $fans_info['source_uid'] == 0) {
				$data = array(
					'source_uid' => $source_uid
				);
				$fans_model->save($data, [ 'openid' => $openid ]);
			}
			
		} else {
			//如果是会员，检测会员uid与souce_uid是不是相同，不相同的话，检测查询的会员上级是，promoter_id=0，查询对应souce_uid对应的promoter和股东，赋值
			if ($user_info['uid'] != $source_uid) {
				switch (NS_VERSION) {
					case NS_VER_B2C:
						break;
					case NS_VER_B2C_FX:
						$nfx_user = new NfxShopMemberAssociationModel();
						$nfx_user_info = $nfx_user->getInfo([ 'uid' => $user_info['uid'] ], '*');
						if ($nfx_user_info['promoter_id'] == 0) {
							$source_user_info = $nfx_user->getInfo([ 'uid' => $source_uid ], '*');
							if ($source_user_info['promoter_id'] != 0) {
								$data = array(
									'promoter_id' => $source_user_info['promoter_id'],
									'partner_id' => $source_user_info['partner_id']
								);
								$nfx_user->save($data, [ 'uid' => $user_info['uid'] ]);
							}
						}
				}
			}
		}
		return 1;
		
		
	}
}