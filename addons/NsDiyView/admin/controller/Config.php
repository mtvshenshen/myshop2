<?php
/**
 * Config.php
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
namespace addons\NsDiyView\admin\controller;

use addons\NsDiyView\data\service\Config as WebConfig;
use data\service\GoodsCategory;
use app\admin\controller\BaseController;

/**
 * 网站设置模块控制器
 *
 * @author Administrator
 *        
 */
class Config extends BaseController
{
    
	public $addon_view_path;
	
	public function __construct()
	{
		parent::__construct();
		$this->addon_view_path = ADDON_DIR . '/NsDiyView/template/';
	}


  

    /**
     * 根据文件夹选择xml配置文件集合
     * @param unknown $folder
     *            文件夹：shop(pc端),wap(手机端)
     */
    public function getTemplateXmlList($folder)
    {
        $file_path = str_replace("\\", "/", ROOT_PATH . 'template/' . $folder);
        $config_list = $this->getfiles($file_path);
        return $config_list;
    }

    /**
     * 根据文件夹获取整理后的模板集合
     *
     * @param unknown $folder
     *            文件夹：shop(pc端),wap(手机端)
     */
    public function getCollatingTemplateList($folder)
    {
        $config_list = $this->getTemplateXmlList($folder);
        
        $xmlTag = array(
            'folder',
            'theme',
            'preview',
            'introduce'
        );
        switch ($folder) {
            case "shop":
                
                // XML标签配置，PC端专属属性
                array_push($xmlTag, "bgcolor");
                break;
            case "wap":
                break;
        }
        $xml = new \DOMDocument();
        $template_list = array();
        $template_count = count($config_list); // 模板数量
                                               
        // $not_readable_list = array(); // 文件不可读数量
                                               
        // $not_writeable_list = array(); // 文件不可写数量
        
        foreach ($config_list as $k => $config) {
            if ($config['is_readable']) {
                
                // 获取xml文件内容
                $xml_txt = fopen($config['xml_path'], "r,w");
                $xml_str = fread($xml_txt, filesize($config['xml_path'])); // 指定读取大小，这里把整个文件内容读取出来
                $xml_text = str_replace("\r\n", "<br />", $xml_str);
                $xml->loadXML($xml_text);
                $template = $xml->getElementsByTagName('template'); // 最外层节点
                foreach ($template as $p) {
                    foreach ($xmlTag as $x) {
                        $node = $p->getElementsByTagName($x);
                        $template_list[$k][$x] = $node->item(0)->nodeValue;
                    }
                }
            }
        
        $this->assign("template_count", $template_count);
        $this->assign("template_list", $template_list);
    }
    }

    /**
     * 更新当前选中的模板,修改对应的XML文件，存到数据库中
     * @param post提交或传参 $type
     *            类型：shop、wap
     * @param post提交或传参 $folder
     *            文件夹：shop、wap
     * @return unknown[]
     */
    public function updateTemplateUse($type, $folder)
    {
        $res = 0; // 返回值
        if (empty($type) || empty($folder)) {
            return AjaxReturn($res);
        }
        $config = new WebConfig();
        if ($type == "shop") {
            $res = $config->setUsePCTemplate($this->instance_id, $folder);
        } elseif ($type == "wap") {
            $res = $config->setUseWapTemplate($this->instance_id, $folder);
        }
        return AjaxReturn($res);
    }


    /**
     * 根据路径查询配置文件集合
     * 创建时间：2017年9月4日 09:52:21
     * @param unknown $path            
     */
    function getfiles($path)
    {
        try {
            
            $config_list = array();
            
            $k = 0;
            if ($dh = opendir($path)) {
                while (($file = readdir($dh)) !== false) {
                    if ((is_dir($path . "/" . $file)) && $file != "." && $file != "..") {
                        // 当前目录问文件夹
                        $xml_path = $path . '/' . $file . '/config.xml';
                        $xml_path = str_replace("\\", "/", $xml_path);
                        $config_list[$k]['xml_path'] = $xml_path; // XML文件路径
                        $config_list[$k]['is_readable'] = is_readable($xml_path); // 是否可读
                                                                                  
                        // $config_list[$k]['is_writable'] = is_writable($xml_path); // 是否可写
                        $k ++;
                    }
                }
                closedir($dh);
            }
            $config_list = array_merge($config_list);
        } catch (\Exception $e) {
            echo $e;
        }
        return $config_list;
    }

    /**
     * 手机端自定义模板列表
     *
     * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function wapCustomTemplateList()
    {
        $config = new WebConfig();
        if (request()->isAjax()) {
            $page_index = request()->post("page_index", 1);
            $page_size = request()->post("page_size", PAGESIZE);
            $template_name = request()->post("template_name", "");
            if (! empty($template_name)) {
                $condition["template_name"] = array(
                    "like",
                    "%" . $template_name . "%"
                );
            }
            $order = "id desc"; // is_default desc,modify_time desc
            $field = "id,shop_id,template_name,create_time,modify_time,is_enable,is_default, template_type";
            $custom_template_list = $config->getWapCustomTemplateList($page_index, $page_size, $condition, $order, $field);
            $diy_viewtype = $config->getdiyViewType();
            foreach ($custom_template_list['data'] as $k => $v) {
                $custom_template_list['data'][$k]['template_type_name'] = $diy_viewtype[$v['template_type']]['name'];
            }
            return $custom_template_list;
        }
        
        $is_enable = $config->getIsEnableWapCustomTemplate($this->instance_id); // 0 不启用 1 启用
        $this->assign("is_enable", $is_enable);
        
        $view_list = $config->getdiyViewType();
        $this->assign("view_list", $view_list);
        
        
        return view($this->addon_view_path . $this->style . "Config/wapCustomTemplateList.html");
    }

    /**
     * 编辑手机端自定义模板
     * 创建时间：2018年1月17日12:33:27
     *
     * @return Ambigous <\think\response\View, \think\response\$this, \think\response\View>
     */
    public function wapCustomTemplateEdit()
    {
        $config = new webConfig();
        $id = request()->get("id", 0);
        
        $custom_template_info = $config->getWapCustomTemplateById($id);
        if (empty($custom_template_info) && $id) {
            // 没有查询到数据，返回手机端自定义模板列表
            $this->redirect(__URL(\think\Config::get('view_replace_str.ADMIN_MAIN') . "/config/wapCustomTemplateList"));
        } else {
            $goods_category = new GoodsCategory();
            $goods_category_list = $goods_category->getCategoryTreeUseInShopIndex();
            $template_name = $custom_template_info['template_name'];
            if (empty($template_name)) {
                $template_name = "模板名称";
            }
            // 获取所有模板列表，排除自己
            $template_list = $config->getWapCustomTemplateList(1, 0, [
                "id" => [
                    "NEQ",
                    $id
                ]
            ], "modify_time desc", "id,template_name,template_data");
            
            $template_data = $custom_template_info['template_data'];
            
            $this->assign("id", $id);
            $this->assign("template_list", json_encode($template_list['data']));
            $this->assign("goods_category_list", json_encode($goods_category_list));
            $this->assign("template_name", $template_name);
            $this->assign("template_data", $template_data);
        }
        
        return view($this->addon_view_path . $this->style . "Config/wapCustomTemplateEdit.html");
    }

    /**
     * 根据主键id删除手机端自定义模板
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function deleteWapCustomTemplateById()
    {
        $id = request()->post("id", "");
        $config = new WebConfig();
        $res = $config->deleteWapCustomTemplateById($id);
        return AjaxReturn($res);
    }

    /**
     * 设置默认手机自定义模板
     * 创建时间：2018年1月17日12:20:20
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function setDefaultWapCustomTemplate()
    {
        $id = request()->post("id", "");
        $config = new WebConfig();
        $res = $config->setDefaultWapCustomTemplate($id);
        return AjaxReturn($res);
    }

    /**
     * 开启关闭手机端自定义模板
     * 创建时间：2018年1月17日12:24:23
     *
     * @return Ambigous <multitype:unknown, multitype:unknown unknown string >
     */
    public function setIsEnableWapCustomTemplate()
    {
        $is_enable = request()->post("is_enable", "");
        $config = new WebConfig();
        $res = $config->setIsEnableWapCustomTemplate($this->instance_id, $is_enable);
        return AjaxReturn($res);
    }

    /**
     * 添加手机端自定义模板
     * 创建时间2018年1月17日14:18:18
     */
    public function addWapCustomTemplate()
    {
        $res = 0;
        $template_name = request()->post("template_name", ""); // 自定义模板名称，预览
        $template_data = request()->post("template_data", ""); // 模板数据
        if (! empty($template_name) && ! empty($template_data)) {
            $config = new WebConfig();
            $res = $config->editWapCustomTemplate(0, $template_name, $template_data);
        }
        return AjaxReturn($res);
    }

    /**
     * 修改手机端自定义模板
     *
     * @param unknown $id            
     * @param unknown $shop_id            
     * @param unknown $template_name            
     * @param unknown $template_data            
     * @return boolean
     */
    public function updateWapCustomTemplate($id, $template_name, $template_data)
    {
        $res = 0;
        $id = request()->post("id", "");
        $template_name = request()->post("template_name", ""); // 自定义模板名称，预览
        $template_data = request()->post("template_data", ""); // 模板数据
        if (! empty($template_name) && ! empty($template_data)) {
            $config = new WebConfig();
            $res = $config->editWapCustomTemplate($id, $template_name, $template_data);
        }
        return AjaxReturn($res);
    }
    
    /**
     * 设置模板页面
     */
    public function setDiyView() 
    {
        $id = request()->post('id', 0);
        $diy_view_id = request()->post('diy_view_id', 0);
        if(!$id) return -1;
        $config = new WebConfig();
        $res = $config->setDiyView($diy_view_id, $id);
        return AjaxReturn($res);
    }
    
}