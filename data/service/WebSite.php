<?php
/**
 * WebSite.php
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

use data\service\BaseService as BaseService;
use data\model\WebSiteModel as WebSiteModel;
use data\model\WebStyleModel as WebStyleModel;
use data\model\AuthGroupModel as AuthGroupModel;
use data\model\InstanceModel as InstanceModel;
use data\model\InstanceTypeModel;
use data\model\UserModel;
use data\model\AdminUserModel;
use think\Session;
use data\model\SysUrlRouteModel;
use think\Cache;
use data\model\SysModel;
use data\model\BaseModel;

class WebSite extends BaseService
{
	
	private $website;
	
	private $module;
	
	public function __construct()
	{
		parent::__construct();
		$this->website = new WebSiteModel();
		$this->module = new SysModel();
	}
	
	/**
	 * 获取版本号
	 */
	public function getVersion()
	{
	}
	
	/**
	 * 获取网站信息
	 *
	 * @param string $field
	 */
	public function getWebSiteInfo()
	{
		$cache = Cache::tag('website')->get('getWebSiteInfo');
		if (!empty($cache)) return $cache;
		
		$info = $this->website->getInfo('');
		Cache::tag('website')->set('getWebSiteInfo', $info);
		
		return $info;
	}
	
	/**
	 * 修改网站信息
	 * @param unknown $title
	 * @param unknown $logo
	 * @param unknown $web_desc
	 * @param unknown $key_words
	 * @param unknown $web_icp
	 * @param unknown $web_style_pc
	 * @param unknown $web_qrcode
	 * @param unknown $web_url
	 * @param unknown $web_phone
	 * @param unknown $web_email
	 * @param unknown $web_qq
	 * @param unknown $web_weixin
	 * @param unknown $web_address
	 * @param unknown $third_count
	 * @param unknown $web_popup_title
	 * @param unknown $web_wechat_share_logo
	 * @param unknown $web_gov_record
	 * @param unknown $web_gov_record_url
	 * @return boolean
	 */
	function updateWebSite($title, $logo, $web_desc, $key_words, $web_icp, $web_style_pc, $web_qrcode, $web_url, $web_phone, $web_email, $web_qq, $web_weixin, $web_address, $third_count, $web_popup_title, $web_wechat_share_logo, $web_gov_record, $web_gov_record_url)
	{
		$data = array(
			'title' => $title,
			'logo' => $logo,
			'web_desc' => $web_desc,
			'key_words' => $key_words,
			'web_icp' => $web_icp,
			'style_id_pc' => $web_style_pc,
			'web_qrcode' => $web_qrcode,
			'web_url' => $web_url,
			'web_phone' => $web_phone,
			'web_email' => $web_email,
			'web_qq' => $web_qq,
			'web_weixin' => $web_weixin,
			'web_address' => $web_address,
			'third_count' => $third_count,
			'modify_time' => time(),
			'web_popup_title' => $web_popup_title,
			'web_wechat_share_logo' => $web_wechat_share_logo,
			'web_gov_record' => $web_gov_record,
			'web_gov_record_url' => $web_gov_record_url
		);
		$this->website = new WebSiteModel();
		$res = $this->website->save($data, [
			"website_id" => 1
		]);
		if ($res) {
			Cache::tag('website')->set('getWebSiteInfo', null);
		}
		return $res;
	}
	
	/**
	 * 添加系统模块
	 * @param unknown $module_name
	 * @param unknown $controller
	 * @param unknown $method
	 * @param unknown $pid
	 * @param unknown $url
	 * @param unknown $is_menu
	 * @param unknown $is_dev
	 * @param unknown $sort
	 * @param unknown $module_picture
	 * @param unknown $desc
	 * @param unknown $icon_class
	 * @param unknown $is_control_auth
	 */
	public function addSytemModule($module_name, $controller, $method, $pid, $url, $is_menu, $is_dev, $sort, $module_picture, $desc, $icon_class, $is_control_auth)
	{
		Cache::clear('module');
		// 查询level
		if ($pid == 0) {
			$level = 1;
		} else {
			$level = $this->getSystemModuleInfo($pid, $field = 'level')['level'] + 1;
		}
		$data = array(
			'module_name' => $module_name,
			'module' => \think\Request::instance()->module(),
			'controller' => $controller,
			'method' => $method,
			'pid' => $pid,
			'level' => $level,
			'url' => $url,
			'is_menu' => $is_menu,
			"is_control_auth" => $is_control_auth,
			'is_dev' => $is_dev,
			'sort' => $sort,
			'module_picture' => $module_picture,
			'desc' => $desc,
			'create_time' => time(),
			'icon_class' => $icon_class
		);
		$mod = new SysModel();
		$res = $mod->save($data);
		$this->updateUserModule();
		return $res;
	}
	
	
	/**
	 * 安装模块菜单
	 * @param unknown $module_name
	 * @param unknown $module
	 * @param unknown $controller
	 * @param unknown $method
	 * @param unknown $pid
	 * @param unknown $is_menu
	 * @param unknown $is_dev
	 * @param unknown $sort
	 * @param unknown $module_picture
	 * @param unknown $desc
	 * @param unknown $icon_class
	 * @param unknown $is_control_auth
	 */
	public function installModule($module_name, $module, $controller, $method, $pid, $is_menu, $is_dev, $sort, $module_picture, $desc, $icon_class, $is_control_auth)
	{
		Cache::clear('module');
		// 查询level
		if ($pid == 0) {
			$level = 1;
		} else {
			$level = $this->getSystemModuleInfo($pid, $field = 'level')['level'] + 1;
		}
		$data = array(
			'module_name' => $module_name,
			'module' => $module,
			'controller' => $controller,
			'method' => $method,
			'pid' => $pid,
			'level' => $level,
			'url' => $controller . '/' . $method,
			'is_menu' => $is_menu,
			"is_control_auth" => $is_control_auth,
			'is_dev' => $is_dev,
			'sort' => $sort,
			'module_picture' => $module_picture,
			'desc' => $desc,
			'create_time' => time(),
			'icon_class' => $icon_class
		);
		$mod = new SysModel();
		$res = $mod->save($data);
		$this->updateUserModule();
		if ($res > 0) {
			return $mod->module_id;
		} else {
			return 0;
		}
	}
	
	/**
	 * 修改系统模块
	 * @param unknown $module_id
	 * @param unknown $module_name
	 * @param unknown $controller
	 * @param unknown $method
	 * @param unknown $pid
	 * @param unknown $url
	 * @param unknown $is_menu
	 * @param unknown $is_dev
	 * @param unknown $sort
	 * @param unknown $module_picture
	 * @param unknown $desc
	 * @param unknown $icon_class
	 * @param unknown $is_control_auth
	 */
	public function updateSystemModule($module_id, $module_name, $controller, $method, $pid, $url, $is_menu, $is_dev, $sort, $module_picture, $desc, $icon_class, $is_control_auth)
	{
		Cache::clear('module');
		// 查询level
		if ($pid == 0) {
			$level = 1;
		} else {
			$level = $this->getSystemModuleInfo($pid, $field = 'level')['level'] + 1;
		}
		$data = array(
			'module_id' => $module_id,
			'module_name' => $module_name,
			'module' => \think\Request::instance()->module(),
			'controller' => $controller,
			'method' => $method,
			'pid' => $pid,
			'level' => $level,
			'url' => $url,
			'is_menu' => $is_menu,
			"is_control_auth" => $is_control_auth,
			'is_dev' => $is_dev,
			'sort' => $sort,
			'module_picture' => $module_picture,
			'desc' => $desc,
			'modify_time' => time(),
			'icon_class' => $icon_class
		);
		$mod = new SysModel();
		$res = $mod->allowField(true)->save($data, [
			'module_id' => $module_id
		]);
		$this->updateUserModule();
		return $res;
	}
	
	/**
	 * 删除系统模块
	 *
	 * @param unknown $module_id
	 */
	public function deleteSystemModule($module_id_array)
	{
		Cache::clear('module');
		$sub_list = $this->getModuleListByParentId($module_id_array);
		if (!empty($sub_list)) {
			$res = SYSTEM_DELETE_FAIL;
		} else {
			$res = $this->module->destroy($module_id_array);
		}
		$this->updateUserModule();
		return $res;
	}
	
	/**
	 * 清除菜单
	 */
	private function updateUserModule()
	{
		Cache::clear('module');
	}
	
	/**
	 * 获取系统模块
	 *
	 * @param unknown $module_id
	 */
	public function getSystemModuleInfo($module_id, $field = '*')
	{
		$cache = Cache::tag('module')->get('getSystemModuleInfo' . $module_id . $field);
		if (!empty($cache)) return $cache;
		
		$res = $this->module->getInfo(array(
			'module_id' => $module_id
		), $field);
		Cache::tag('module')->set('getSystemModuleInfo' . $module_id . $field, $res);
		
		return $res;
	}
	
	/**
	 * 修改系统模块 单个字段
	 *
	 * @param unknown $module_id
	 * @param unknown $order
	 */
	public function ModifyModuleField($module_id, $field_name, $field_value)
	{
		Cache::clear('module');
		$res = $this->module->ModifyTableField('module_id', $module_id, $field_name, $field_value);
		$this->updateUserModule();
		return $res;
	}
	
	/**
	 * 获取系统模块列表
	 *
	 * @param unknown $where
	 * @param unknown $order
	 * @param unknown $page_size
	 * @param unknown $page_index
	 */
	public function getSystemModuleList($page_index = 1, $page_size = 0, $condition = '', $order = '', $field = '*')
	{
		$cache = Cache::tag('module')->get('getSystemModuleList' . json_encode([ $page_index, $page_size, $condition, $order, $field ]));
		if (!empty($cache)) return $cache;
		
		// 针对开发者模式处理
		if (!config('app_debug')) {
			if (is_array($condition)) {
				$condition = array_merge($condition, [
					'is_dev' => 0
				]);
			} else {
				if (!empty($condition)) {
					$condition = $condition . ' and is_dev=0 ';
				} else {
					$condition = 'is_dev=0';
				}
			}
		}
		$res = $this->module->pageQuery($page_index, $page_size, $condition, $order, $field);
		Cache::tag('module')->set('getSystemModuleList' . json_encode([ $page_index, $page_size, $condition, $order, $field ]), $res);
		return $res;
	}
	
	/**
	 * 根据当前实例查询权限列表
	 *
	 * @param unknown $instanceid
	 */
	public function getInstanceModuleQuery()
	{
		// 单用户查询全部
		$condition_module = array(
			'is_control_auth' => 1
		);
		$moduelList = $this->getSystemModuleList(1, 0, $condition_module, 'sort asc');
		return $moduelList['data'];
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 */
	public function addSystemInstance($uid, $instance_name, $type)
	{
		$instance = new InstanceModel();
		$instance->startTrans();
		try {
			$instance_model = new InstanceModel();
			// 创建实例
			$data_instance = array(
				'instance_name' => $instance_name,
				'instance_typeid' => $type,
				'create_time' => time()
			);
			$instance_model->save($data_instance);
			$instance_id = $instance_model->instance_id;
			// 查询实例权限
			$instance_type_model = new InstanceTypeModel();
			$instance_type_info = $instance_type_model->get($type);
			// 创建管理员组
			$data_group = array(
				'instance_id' => $instance_id,
				'group_name' => '管理员组',
				'is_system' => 1,
				'module_id_array' => $instance_type_info['type_module_array'],
				'create_time' => time()
			);
			$user_group = new AuthGroupModel();
			$user_group->save($data_group);
			// 调整用户属性
			$user = new UserModel();
			$user->save([
				'is_system' => 1,
				'instance_id' => $instance_id
			], [
				'uid' => $uid
			]);
			// 添加后台用户
			$user_admin = new AdminUserModel();
			$data_admin = array(
				'uid' => $uid,
				'admin_name' => '',
				'group_id_array' => $user_group->group_id
			);
			$user_admin->save($data_admin);
			$instance->commit();
			Cache::clear('instance');
			return $instance_id;
		} catch (\Exception $e) {
			$instance->rollback();
			return $e->getMessage();
		}
	}
	
	/**
	 * 修改系统实例
	 */
	public function updateSystemInstance()
	{
	}
	
	/**
	 * 获取系统实例
	 *
	 * @param unknown $instance_id
	 */
	public function getSystemInstance($instance_id)
	{
		$cache = Cache::tag('instance')->get('getSystemInstance' . $instance_id);
		if (!empty($cache)) return $cache;
		
		$instance = new InstanceModel();
		$info = $instance->get($instance_id);
		
		Cache::tag('instance')->set('getSystemInstance' . $instance_id, $info);
		return $info;
	}
	
	/**
	 * 查询系统实例列表
	 *
	 * @param unknown $where
	 * @param unknown $order
	 * @param unknown $page_size
	 * @param unknown $page_index
	 */
	public function getSystemInstanceList($page_index = 1, $page_size = 0, $condition = '', $order = '', $field = '*')
	{
		$cache = Cache::tag('instance')->get('getSystemInstanceList' . json_encode([ $page_index, $page_size, $condition, $order, $field ]));
		if (!empty($cache)) return $cache;
		
		$instance = new InstanceModel();
		$instance_list = $instance->pageQuery($page_index, $page_size, $condition, $order, $field);
		if (!empty($instance_list['data'])) {
			foreach ($instance_list['data'] as $k => $v) {
				$instance_type = new InstanceTypeModel();
				$type_name = $instance_type->getInfo([
					'instance_typeid' => $v['instance_typeid']
				], 'type_name');
				if (!empty($type_name['type_name'])) {
					$v['type_name'] = $type_name['type_name'];
				} else {
					$v['type_name'] = '';
				}
				$instance_list['data'][ $k ] = $v;
			}
		}
		Cache::tag('instance')->set('getSystemInstanceList' . json_encode([ $page_index, $page_size, $condition, $order, $field ]), $instance_list);
		return $instance_list;
	}
	
	/**
	 * 通过控制器方法查询模块
	 * @param unknown $controller
	 * @param unknown $action
	 * @return \data\model\unknown
	 */
	public function getModuleIdByModule($controller, $action)
	{
		$cache = Cache::tag('module')->get('getModuleIdByModule' . $controller . $action);
		if (!empty($cache)) return $cache;
		
		$res = $this->module->getModuleIdByModule($controller, $action);
		Cache::tag('module')->set('getModuleIdByModule' . $controller . $action, $res);
		return $res;
	}
	
	/**
	 * 查询权限节点的根节点
	 *
	 * @param unknown $module_id
	 */
	public function getModuleRoot($module_id)
	{
		$cache = Cache::tag('module')->get('getModuleRoot' . $module_id);
		if (!empty($cache)) return $cache;
		
		$root_id = $this->module->getModuleRoot($module_id);
		Cache::tag('module')->set('getModuleRoot' . $module_id, $root_id);
		return $root_id;
	}
	
	/**
	 * 获取系统模块列表
	 *
	 * @param string $tpye
	 *            0 debug模式 1 部署模式
	 */
	public function getModuleListTree($type = 0)
	{
		$cache = Cache::tag('module')->get('getModuleListTree');
		if (!empty($cache)) return $cache;
		
		$list = $this->module->order('pid,sort')->select();
		$new_list = $this->list_tree($list);
		Cache::tag('module')->set('getModuleListTree', $new_list);
		return $new_list;
	}
	
	/**
	 * 数组转化为树
	 *
	 * @param unknown $list
	 * @param string $p_id
	 * @return multitype:boolean
	 */
	private function list_tree($list, $p_id = '0')
	{
		$tree = array();
		foreach ($list as $row) {
			if ($row['pid'] == $p_id) {
				$tmp = $this->list_tree($list, $row['module_id']);
				if ($tmp) {
					$row['sub_menu'] = $tmp;
				} else {
					$row['leaf'] = true;
				}
				$tree[] = $row;
			}
		}
		Return $tree;
	}
	
	/**
	 * 查询模块的子项列表
	 * @param unknown $pid
	 */
	public function getModuleListByParentId($pid)
	{
		$cache = Cache::tag('module')->get('getModuleListByParentId' . $pid);
		if (!empty($cache)) return $cache;
		
		$list = $this->getSystemModuleList(1, 0, 'pid=' . $pid);
		Cache::tag('module')->set('getModuleListByParentId' . $pid, $list['data']);
		return $list['data'];
	}
	
	/**
	 * 获取当前节点的根节点以及二级节点项(non-PHPdoc)
	 */
	public function getModuleRootAndSecondMenu($module_id)
	{
		$cache = Cache::tag('module')->get('getModuleRootAndSecondMenu' . $module_id);
		if (!empty($cache)) return $cache;
		
		$count = $this->module->where([
			'module_id' => $module_id
		])
			->count();
		if ($count == 0) {
			$result = array(
				0,
				0
			);
		}
		$info = $this->module->getInfo([
			'module_id' => $module_id,
			'pid' => array(
				'neq',
				0
			)
		], 'pid, level');
		if (empty($info)) {
			$result = array(
				$module_id,
				0
			);
		} else {
			if ($info['level'] == 2) {
				$result = array(
					$info['pid'],
					$module_id
				);
			} else {
				$pid = $info['pid'];
				while ($pid != 0) {
					$module = $this->module->getInfo([
						'module_id' => $pid,
						'pid' => array(
							'neq',
							0
						)
					], 'pid, module_id, level');
					if ($module['level'] == 2) {
						$pid = 0;
						$result = array(
							$module['pid'],
							$module['module_id']
						);
					} else {
						$pid = $module['pid'];
					}
				}
			}
		}
		
		Cache::tag('module')->set('getModuleRootAndSecondMenu' . $module_id, $result);
		return $result;
	}
	
	/**
	 * 获取网站样式
	 * @return string
	 */
	public function getWebStyle()
	{
		$config_style = ''; // 根据用户实例从数据库中获取样式，以及项目
		$style = \think\Request::instance()->module() . '/' . $config_style;
		return $style;
	}
	
	/**
	 * 获取样式列表
	 * @param unknown $condition
	 * @return unknown
	 */
	public function getWebStyleList($condition)
	{
		$webstyle = new WebStyleModel();
		$style_list = $webstyle->getQuery($condition, '*', '');
		return $style_list;
	}
	
	/**
	 * 获取网站信息
	 */
	public function getWebDetail()
	{
		$cache = Cache::tag('module')->get('getWebDetail');
		if (!empty($cache)) return $cache;
		
		$web_info = $this->website->getInfo(array(
			"website_id" => 1
		));
		Cache::tag('module')->set('getWebDetail', $web_info);
		return $web_info;
	}
	
	/**
	 * 获取路由规则列表
	 * @param number $page_index
	 * @param number $page_size
	 * @param string $condition
	 * @param string $order
	 * @return multitype:number unknown
	 */
	public function getUrlRouteList($page_index = 1, $page_size = 0, $condition = '', $order = '')
	{
		$cache = Cache::tag('route')->get('getUrlRouteList' . json_encode([ $page_index, $page_size, $condition, $order ]));
		if (!empty($cache)) return $cache;
		
		$url_route_model = new SysUrlRouteModel();
		$route_list = $url_route_model->pageQuery($page_index, $page_size, $condition, $order, '*');
		
		Cache::tag('route')->set('getUrlRouteList' . json_encode([ $page_index, $page_size, $condition, $order ]), $route_list);
		return $route_list;
	}
	
	/**
	 * 获取路由
	 *
	 * @return Ambigous <mixed, \think\cache\Driver, boolean>
	 */
	public function getUrlRoute()
	{
	    Cache::clear('route');
		$cache = Cache::tag('route')->get('getUrlRoute');
		if (!empty($cache)) return $cache;
		
		$url_route_model = new SysUrlRouteModel();
		$route_list = $url_route_model->pageQuery(1, 0, [
			'is_open' => 1
		], '', 'rule,route');
		
		Cache::tag('route')->set('getUrlRoute', $route_list);
		return $route_list;
	}
	
	/**
	 * 添加路由规则
	 * @param unknown $rule
	 * @param unknown $route
	 * @param unknown $is_open
	 * @param number $route_model
	 * @param unknown $remark
	 */
	public function addUrlRoute($rule, $route, $is_open, $route_model = 1, $remark)
	{
		Cache::clear('route');
		$data = array(
			"rule" => $rule,
			"route" => $route,
			"is_open" => $is_open,
			"route_model" => $route_model,
			"is_system" => 0,
			"remark" => $remark
		);
		
		$url_route_model = new SysUrlRouteModel();
		$res = $url_route_model->save($data);
		return $res;
	}
	
	/**
	 * 修改路由规则
	 * @param unknown $routeid
	 * @param unknown $rule
	 * @param unknown $route
	 * @param unknown $is_open
	 * @param number $route_model
	 * @param unknown $remark
	 */
	public function updateUrlRoute($routeid, $rule, $route, $is_open, $route_model = 1, $remark)
	{
		Cache::clear('route');
		$data = array(
			"rule" => $rule,
			"route" => $route,
			"is_open" => $is_open,
			"route_model" => $route_model,
			"remark" => $remark
		);
		$url_route_model = new SysUrlRouteModel();
		$res = $url_route_model->save($data, [
			"routeid" => $routeid
		]);
		return $res;
	}
	
	/**
	 * 获取路由信息
	 * @param unknown $routeid
	 */
	public function getUrlRouteDetail($routeid)
	{
		$cache = Cache::tag('route')->get('getUrlRouteDetail' . $routeid);
	
		if (!empty($cache)) return $cache;
		
		$url_route_model = new SysUrlRouteModel();
		$res = $url_route_model->get($routeid);

		
		Cache::tag('route')->set('getUrlRouteDetail' . $routeid, $res);
		return $res;
	}
	
	/**
	 * 检测路由规则是否存在
	 * @param unknown $type
	 * @param unknown $value
	 */
	public function url_route_if_exists($type, $value)
	{
		$cache = Cache::tag('route')->get('url_route_if_exists' . $type . $value);
		if (!empty($cache)) return $cache;
		
		$is_exists = false;
		$url_route_model = new SysUrlRouteModel();
		if ($type == "rule") {
			$count = $url_route_model->getCount([
				"rule" => trim($value)
			]);
			if ($count > 0) {
				$is_exists = true;
			}
		} else
			if ($type == "route") {
				$count = $url_route_model->getCount([
					"route" => trim($value)
				]);
				if ($count > 0) {
					$is_exists = true;
				}
			}
		Cache::tag('route')->set('url_route_if_exists' . $type . $value, $is_exists);
		return $is_exists;
	}
	
	/**
	 * 删除路由规则
	 */
	public function delete_url_route($routeid)
	{
	    Cache::clear('route');
		$url_route_model = new SysUrlRouteModel();
		$res = $url_route_model->destroy([
			"routeid" => array(
				"in",
				$routeid
			),
			"is_system" => 0
		]);
		
		return $res;
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 */
	public function updateVisitWebSite($web_style_admin, $visit_pattern, $web_status, $wap_status, $close_reason)
	{
		$data = array(
			'style_id_admin' => $web_style_admin,
			'url_type' => $visit_pattern,
			'web_status' => $web_status,
			'wap_status' => $wap_status,
			'close_reason' => $close_reason,
			'modify_time' => time()
		);
		$this->website = new WebSiteModel();
		$res = $this->website->save($data, [
			"website_id" => 1
		]);
		Cache::clear('website');
		return $res;
	}
	
	/**
	 * 修改一键关注设置
	 * (non-PHPdoc)
	 *
	 */
	public function updateKeyConcernConfig($is_show_follow)
	{
		$data = array(
			'modify_time' => time(),
			'is_show_follow' => $is_show_follow
		);
		$this->website = new WebSiteModel();
		$res = $this->website->save($data, [
			"website_id" => 1
		]);
		Cache::clear('website');
		return $res;
	}
}