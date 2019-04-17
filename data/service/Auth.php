<?php
/**
 * AuthGroup.php
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
use data\model\SysModel;
use think\Cache;
use think\Session;

class Auth extends BaseService
{
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 通过模块方法查询权限id
	 *
	 * @param unknown $controller
	 * @param unknown $action
	 * @return unknown
	 */
	public function getModuleIdByModule($controller, $action)
	{
		$cache = Cache::tag('module')->get('getModuleIdByModule' . '_' . $controller . '_' . $action);
		if (!empty($cache)) return $cache;
		$condition = array(
			'controller' => $controller,
			'method' => $action,
		);
		$sys_module = new SysModel();
		$count = $sys_module->where($condition)->count('module_id');
		if ($count > 1) {
			$condition = array(
				'controller' => $controller,
				'method' => $action,
				'pid' => array(
					'<>',
					0
				)
			);
		}
		$res = $sys_module->getInfo($condition);
		Cache::tag('module')->set('getModuleIdByModule' . '_' . $controller . '_' . $action, $res);
		return $res;
	}
	
	/**
	 * 查询权限节点的根节点
	 *
	 * @param unknown $module_id
	 */
	public function getModuleRoot($module_id)
	{
		$cache = Cache::tag('module')->get('getModuleRoot' . '_' . $module_id);
		if (!empty($cache)) return $cache;
		$root_id = $module_id;
		$sys_module = new SysModel();
		$pid = $sys_module->getInfo([
			'module_id' => $module_id
		], 'pid');
		$pid = $pid['pid'];
		if (empty($pid)) {
			return 0;
		}
		while ($pid != 0) {
			$module = $sys_module->getInfo([
				'module_id' => $pid
			], 'pid, module_id');
			$root_id = $module['module_id'];
			$pid = $module['pid'];
		}
		Cache::tag('module')->set('getModuleIdByModule' . '_' . $module_id, $root_id);
		return $root_id;
	}
	
	/**
	 * 通过权限id组查询权限列表
	 *
	 * @param unknown $list_id_arr
	 */
	public function getAuthList($pid)
	{
		$cache = Cache::tag('module')->get('getAuthList' . '_' . $pid);
		if (!empty($cache)) return $cache;
		$condition = array(
			'pid' => $pid,
			'is_menu' => 1
		);
		$sys_module = new SysModel();
		$list = $sys_module->where($condition)
			->order("sort")
			->column('module_id,module_name,module,controller,method,pid,url,is_menu,is_dev,icon_class,is_control_auth');
		Cache::tag('module')->set('getAuthList' . '_' . $pid, $list);
		return $list;
	}
	
	/**
	 * 通过权限id组查询权限列表
	 *
	 * @param unknown $list_id_arr
	 */
	public function getAuthListByModule($pid, $module_id_array)
	{
		$cache = Cache::tag('module')->get('getAuthListByModule' . '_' . $pid . '_' . $module_id_array);
		if (!empty($cache)) return $cache;
		$condition = array(
			'pid' => $pid,
			'module_id' => array( 'in', $module_id_array )
		);
		$sys_module = new SysModel();
		$list = $sys_module->where($condition)
			->order("sort")
			->column('module_id,module_name,module,controller,method,pid,url,is_menu,is_dev,icon_class,is_control_auth');
		Cache::tag('module')->set('getAuthListByModule' . '_' . $pid, $list);
		return $list;
	}
	
	/**
	 * 查询当前模块的上级ID
	 *
	 * @param unknown $module_id
	 */
	public function getModulePid($module_id)
	{
		$cache = Cache::tag('module')->get('getModulePid' . '_' . $module_id);
		if (!empty($cache)) return $cache;
		$sys_module = new SysModel();
		$pid = $sys_module->get($module_id);
		Cache::tag('module')->set('getModulePid' . '_' . $module_id, $pid['pid']);
		return $pid['pid'];
	}
	
	/**
	 * 获取不控制权限模块组
	 */
	private function getNoControlAuth()
	{
		$cache = Cache::tag('module')->get('getNoControlAuth');
		if (!empty($cache)) return $cache;
		$moudle = new SysModel();
		$list = $moudle->getQuery([
			"is_control_auth" => 0
		], "module_id", '');
		$str = "";
		foreach ($list as $v) {
			$str .= $v["module_id"] . ",";
		}
		Cache::tag('module')->set('getNoControlAuth', $str);
		return $str;
	}
	
	/**
	 * 查询权限组的id序列
	 * @param unknown $group_id
	 */
	public function getAuthGroupModuleList($group_id)
	{
		$auth_group = new AuthGroup();
		$auth_group_info = $auth_group->getSystemUserGroupDetail($group_id);
		$no_control_auth = $this->getNoControlAuth();
		return $auth_group_info['module_id_array'] . $no_control_auth;
	}
	
	
	/**
	 * 获取用户的权限子项
	 * @param unknown $moduleid（0标示根节点子项）
	 */
	public function getchildModuleQuery($moduleid)
	{
		$module_list = Cache::tag('module')->get('getchildModuleQuery' . '_' . $this->group_id . '_' . $moduleid);
		if (empty($module_list)) {
			if ($this->is_admin) {
				
				$list = $this->getAuthList($moduleid);
				$new_list = $list;
			} else {
				
				$list = $this->getAuthList($moduleid);
				$module_id_array = explode(',', $this->getAuthGroupModuleList($this->group_id));
				$new_list = array();
				if ($moduleid != 0) {
					
					foreach ($list as $k => $v) {
						if (in_array($list[ $k ]['module_id'], $module_id_array)) {
							
							$new_list[] = $list[ $k ];
						}
					}
				} else {
					
					foreach ($list as $k => $v) {
						$check_module_id = $this->getModuleIdByModule($v['controller'], $v['method']);
						$check_auth = $this->checkAuth($check_module_id);
						if ($check_auth == 0) {
							$sub_menu = $this->getchildModuleQuery($v['module_id']);
							if (!empty($sub_menu[0])) {
								$v['url'] = $sub_menu[0]['url'];
							}
						}
						if (in_array($list[ $k ]['module_id'], $module_id_array)) {
							$new_list[] = $v;
						}
					}
				}
			}
			$arrange_list = array();
			foreach ($new_list as $k => $v) {
				if ($v['is_dev'] == 0) {
					$arrange_list[] = $new_list[ $k ];
				}
			}
			Cache::tag('module')->set('getchildModuleQuery' . '_' . $this->group_id . '_' . $moduleid, $arrange_list);
			return $arrange_list;
			
		} else {
			return $module_list;
		}
	}
	
	/**
	 * 检测用户是否具有打开权限(non-PHPdoc)
	 */
	public function checkAuth($module_id)
	{
		if ($this->is_admin) {
			return 1;
		} else {
			$module_list = $this->getAuthGroupModuleList($this->group_id);
			if (strstr($module_list . ',', $module_id . ',')) {
				return 1;
			} else {
				return 0;
			}
		}
	}
	
}