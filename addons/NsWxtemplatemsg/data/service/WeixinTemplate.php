<?php
/**
 * WeixinTemplate.php
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
namespace addons\NsWxtemplatemsg\data\service;

use data\service\BaseService;
use data\extend\WchatOauth;
use addons\NsWxtemplatemsg\data\model\SysAddonsWeixinTemplateMsgModel;


/**
 * 微信模板消息
 */
class WeixinTemplate extends BaseService
{
    
    /**
     * 获取模板消息设置列表
     */
    public function getList()
    {
        $weixin_template_model = new SysAddonsWeixinTemplateMsgModel();
        $list = $weixin_template_model->getQuery([], '*', '');
        return $list;
    }
    
    /**
     * 获取模板消息设置列表
     */
    public function getInfo($condition)
    {
        $weixin_template_model = new SysAddonsWeixinTemplateMsgModel();
        $info = $weixin_template_model->getInfo($condition);
        return $info;
    }
    /**
     * 根据模板编号 获取 模板id
     */
    public function getTemplateIdByTemplateNo($template_no)
    {
        $wchat = new WchatOauth();
        $json = $wchat->templateID($template_no);
        $array = json_decode($json, true);
        $template_id = '';
        if ($array) {
            $template_id = $array['template_id'];
        }
        return $template_id;
    }
    
    /**
     * 设置模板消息是否启用
     */
    public function changeIsEnable($id, $is_enable)
    {
       $weixin_template_model = new SysAddonsWeixinTemplateMsgModel();
       $res = $weixin_template_model->save(['is_enable' => $is_enable], [ 'id' => $id]);
        return $res;
    }
    
    /**
     * 获取模板id
     * @return boolean|number
     */
    public function emptyTemplateId()
    {
        $weixin_template_model = new SysAddonsWeixinTemplateMsgModel();
        $res = $weixin_template_model->save(['template_id' => ''], ['instance_id' => $this->instance_id]);
        return $res;
    }
}
