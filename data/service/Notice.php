<?php
/**
 * Config.php
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

/**
 * 系统配置业务层
 */
use data\service\BaseService as BaseService;
use data\model\NoticeRecordsModel;
use think\Log;
use think\Cache;

class Notice extends BaseService
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 添加通知记录
	 * @param unknown $shop_id
	 * @param unknown $uid
	 * @param unknown $send_type
	 * @param unknown $send_account
	 * @param unknown $notice_title
	 * @param unknown $notice_context
	 */
	public function createNoticeRecords($shop_id, $uid, $send_type, $send_account, $notice_title, $notice_context, $records_type, $send_config, $is_send)
	{
		$notice_records_model = new NoticeRecordsModel();
		$condition = array(
			"shop_id" => $shop_id,
			"uid" => $uid,
			"send_type" => $send_type,
			"send_account" => $send_account,
			"send_config" => $send_config,
			"records_type" => $records_type,
			"notice_title" => $notice_title,
			"notice_context" => $notice_context,
			"is_send" => $is_send,
			"send_message" => "",
			"create_date" => time()
		);
		$insert_id = $notice_records_model->save($condition);
		Cache::clear('notice');
		return $insert_id;
	}
	
	/**
	 * 发送通知
	 */
	public function sendNoticeRecords()
	{
		$notice_records_model = new NoticeRecordsModel();
		$condition = array(
			"is_send" => 0
		);
		
		$notice_list = $notice_records_model->getQuery($condition, "*", "");
		foreach ($notice_list as $notice_obj) {
			$send_type = $notice_obj["send_type"];
			if ($send_type == 1) {
				// 短信发送
				$this->noticeSmsSend($notice_obj["id"], $notice_obj["send_account"], $notice_obj["send_config"], $notice_obj["notice_context"]);
			} else {
				// 邮件发送
				$this->noticeEmailSend($notice_obj["id"], $notice_obj["send_account"], $notice_obj["send_config"], $notice_obj["notice_title"], $notice_obj["notice_context"]);
			}
		}
	}
	
	/**
	 * 发送短信
	 *
	 * @param unknown $notice_id
	 * @param unknown $send_account
	 * @param unknown $send_config
	 * @param unknown $notice_params
	 */
	private function noticeSmsSend($notice_id, $send_account, $send_config, $notice_params)
	{
		$send_config = json_decode($send_config, true);
		$appkey = $send_config["appkey"];
		$secret = $send_config["secret"];
		$signName = $send_config["signName"];
		$template_code = $send_config["template_code"];
		$sms_type = $send_config["sms_type"];
		
		$result = hook('smssend', [
			'signName' => $signName,
			'smsParam' => $notice_params,
			'mobile' => $send_account,
			'code' => $template_code
		]);
		$result = arrayFilter($result);
		$result = $result[0];
		if ($result["code"] == 0) {
			$status = 1;
		} else {
			$status = -1;
		}
		$notice_records_model = new NoticeRecordsModel();
		$ret = $notice_records_model->save([
			"is_send" => $status,
			"send_message" => $result["message"],
			"send_date" => time()
		], [
			"id" => $notice_id
		]);
		Cache::clear('notice');
		return $ret;
	}
	
	/**
	 * 处理短信返回值
	 *
	 * @param unknown $result
	 * @param unknown $sms_type
	 * @return number[]|string[]|unknown[]|NULL[]|mixed[]
	 */
	private function dealAliSmsResult($result, $sms_type)
	{
		$deal_result = array();
		try {
			if ($sms_type == 0) {
				// 旧用户发送
				if (!empty($result)) {
					if (!isset($result->result)) {
						$result = json_decode(json_encode($result), true);
						// 发送失败
						$deal_result["code"] = $result["code"];
						$deal_result["message"] = $result["sub_msg"];
					} else {
						// 发送成功
						$deal_result["code"] = 0;
						$deal_result["message"] = "发送成功";
					}
				}
			} else {
				// 新用户发送
				if (!empty($result)) {
					if ($result->Code == "OK") {
						// 发送成功
						$deal_result["code"] = 0;
						$deal_result["message"] = "发送成功";
					} else {
						// 发送失败
						$deal_result["code"] = -1;
						$deal_result["message"] = $result->Message;
					}
				}
			}
		} catch (\Exception $e) {
			$deal_result["code"] = -1;
			$deal_result["message"] = "发送失败!";
		}
		
		return $deal_result;
	}
	
	/**
	 * 邮件发送
	 *
	 * @param unknown $notice_id
	 * @param unknown $send_account
	 * @param unknown $send_config
	 * @param unknown $notice_title
	 * @param unknown $notice_context
	 */
	private function noticeEmailSend($notice_id, $send_account, $send_config, $notice_title, $notice_context)
	{
		$send_config = json_decode($send_config, true);
		$email_host = $send_config["email_host"];
		$email_id = $send_config["email_id"];
		$email_pass = $send_config["email_pass"];
		$email_port = $send_config["email_port"];
		$email_is_security = $send_config["email_is_security"];
		$email_addr = $send_config["email_addr"];
		$shopName = $send_config["shopName"];
		$result = emailSend($email_host, $email_id, $email_pass, $email_port, $email_is_security, $email_addr, $send_account, $notice_title, $notice_context, $shopName);
		if ($result) {
			$send_message = "发送成功";
			$status = 1;
		} else {
			$status = -1;
			$send_message = "发送失败";
		}
		$notice_records_model = new NoticeRecordsModel();
		$ret = $notice_records_model->save([
			"is_send" => $status,
			"send_message" => $send_message,
			"send_date" => time()
		], [
			"id" => $notice_id
		]);
		Cache::clear('notice');
		return $ret;
	}
	
	/**
	 * 获取通知记录
	 *
	 * @param number $page_index
	 * @param number $page_size
	 * @param unknown $condition
	 * @param string $order
	 * @param string $field
	 * @return multitype:number unknown
	 */
	public function getNoticeRecordsList($page_index = 1, $page_size = 0, $condition = array(), $order = '', $field = "*")
	{
		$cache = Cache::tag('notice')->get('getNoticeRecordsList' . json_encode([ $page_index, $page_size, $condition, $order, $field ]));
		
		if (!empty($cache)) return $cache;
		
		$notice_records_model = new NoticeRecordsModel();
		$list = $notice_records_model->pageQuery($page_index, $page_size, $condition, $order, $field);
		
		foreach ($list['data'] as $k => $v) {
			$user_service = new User();
			$user_info = $user_service->getUserInfoByUid($v['uid']);
			$list['data'][ $k ]['user_name'] = $user_info['nick_name'];
		}
		
		Cache::tag('notice')->set('getNoticeRecordsList' . json_encode([ $page_index, $page_size, $condition, $order, $field ]), $list);
		
		return $list;
	}
	
	/**
	 * 获取通知记录详情
	 *
	 * @param unknown $condition
	 */
	public function getNotifyRecordsDetail($condition = array())
	{
		$cache = Cache::tag('notice')->get('getNotifyRecordsDetail' . json_encode($condition));
		
		if (!empty($cache)) return $cache;
		
		$notice_records_model = new NoticeRecordsModel();
		$detail = $notice_records_model->getInfo($condition);
		
		$user_service = new User();
		$user_info = $user_service->getUserInfoByUid($detail['uid']);
		$detail['user_name'] = $user_info['nick_name'];
		
		Cache::tag('notice')->set('getNotifyRecordsDetail' . json_encode($condition), $detail);
		
		return $detail;
	}
	
	/**
	 * 创建验证码发送记录
	 */
	public function createVerificationCodeRecords($shop_id, $uid, $send_type, $send_account, $send_config, $records_type, $notice_title, $notice_context, $send_message, $is_send)
	{
		$notice_records_model = new NoticeRecordsModel();
		$data = array(
			"shop_id" => $shop_id,
			"uid" => $uid,
			"send_type" => $send_type,
			"send_account" => $send_account,
			"send_config" => $send_config,
			"records_type" => $records_type,
			"notice_title" => $notice_title,
			"notice_context" => $notice_context,
			"is_send" => $is_send,
			"send_message" => $send_message,
			"create_date" => time(),
			"send_date" => time()
		);
		$insert_id = $notice_records_model->save($data);
		Cache::clear('notice');
		return $insert_id;
	}
	
	/**
	 * 检测动态码
	 * @param unknown $record_id
	 * @param unknown $account
	 * @param unknown $code
	 */
	public function checkDynamicCode($record_id, $account, $code){
	    $record_data = $this->getNotifyRecordsDetail(['id' => $record_id]);
	    
	    if(empty($record_data)){
	        return ['code' => -1, 'message' => '未获取到验证记录'];
	    }else{
	        $send_content = json_decode($record_data['notice_context']);
	        if($account != $record_data['send_account']) return ['code' => -1, 'message' => '该账号与验证时账号不一致！'];
	        if($code != $send_content['number']){
	            return ['code' => -1, 'message' => '动态码错误'];
	        }else{
	            return ['code' => 1, 'message' => '验证通过'];
	        }
	    }
	}
}