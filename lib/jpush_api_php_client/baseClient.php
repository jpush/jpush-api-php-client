<?php
include_once 'httpPostClient.php';

class BaseClent
{
	private $API_URL = "http://api.jpush.cn:8800/v2/push";
	
	public function __construct()
	{
	}
	


	/**
	 *
	 * @param int    $sendno  * 发送编号（最大支持32位正整数(即 4294967295 )）。
	 * @param String $app_key * 待发送的应用程序(appKey)，只能填一个。
	 * @param int    $receiver_type * 接收者类型。value: 2、指定的 tag。3、指定的 alias。4、广播：对 app_key 下的所有用户推送消息。
	 * @param String $receiver_value   发送范围值  tag:支持多达 10 个，使用 "," 间隔。alias:支持多达 1000 个，使用 "," 间隔。广播：不需要填
	 * @param String $verification_code * 验证串，用于校验发送的合法性
	 * @param int    $msg_type * 发送消息的类型：１、通知２、自定义消息（只有 Android 支持）
	 * @param String $msg_content * 发送消息的内容
	 * @param String $send_description 描述此次发送调用。
	 * @param String $platform  * 目标用户终端手机的平台类型，如： android, ios 多个请使用逗号分隔。
	 * @param int    $time_to_live 从消息推送时起，保存离线的时长。秒为单位。最多支持10天（864000秒）。 0 表示该消息不保存离线。
	 * @param String $override_msg_id 待覆盖的上一条消息的 ID。
	 */
	public function send($sendno, $app_key, $receiver_type, $receiver_value, $verification_code,
			$msg_type, $msg_content, $send_description, $platform, $time_to_live, $override_msg_id)
	{
		$params = $this->getParams($sendno, $app_key, $receiver_type, $receiver_value, $verification_code,
			          $msg_type, $msg_content, $send_description, $platform, $time_to_live, $override_msg_id);
	    $httpPostClient = new HttpPostClient();
		return $httpPostClient->request_post($this->API_URL, $params);
	}
	
	private function getParams($sendno, $app_key, $receiver_type, $receiver_value, $verification_code,
			$msg_type, $msg_content, $send_description, $platform, $time_to_live, $override_msg_id)
	{
		$params =  "app_key=".$app_key."&receiver_type=".$receiver_type.
		           "&receiver_value=".$receiver_value."&verification_code=".$verification_code.
		           "&msg_type=".$msg_type."&msg_content=".$msg_content."&send_description=".$send_description.
		           "&send_description=".$send_description."&platform=".$platform.
		           "&time_to_live=".$time_to_live."&override_msg_id=".$override_msg_id."&sendno=".$sendno;
		//echo $params."\n";
		return $params;	
	}
}
?>