<?php
class SendVO
{
	//appkey
	private $app_key;
	//密匙
	private $masterSecret;
	//离线时长int    $time_to_live 从消息推送时起，保存离线的时长。秒为单位。最多支持10天（864000秒）。 0 表示该消息不保存离线。
	private $time_to_live ;
	//send no
	private $sendno;  
	//int    $receiver_type * 接收者类型。value: 2、指定的 tag。3、指定的 alias。4、广播：对 app_key 下的所有用户推送消息。
	private $receiver_type;
	// String $receiver_value   发送范围值  tag:支持多达 10 个，使用 "," 间隔。alias:支持多达 1000 个，使用 "," 间隔。广播：不需要填
	private $receiver_value; 
	//String $verification_code * 验证串，用于校验发送的合法性
	private $verification_code;
	//int    $msg_type * 发送消息的类型：１、通知２、自定义消息（只有 Android 支持）
	private $msg_type;
	//String $msg_content * 发送消息的内容
	private $msg_content; 
	// String $send_description 描述此次发送调用。
	private $send_description;
	//String $platform  * 目标用户终端手机的平台类型，如： android, ios 多个请使用逗号分隔。
	private $platform;
	//String $override_msg_id 待覆盖的上一条消息的 ID
	private $override_msg_id;
	
	/**
	 * 构造函数
	 * @param unknown $app_key
	 * @param unknown $masterSecret
	 * @param unknown $timeToLive
	 * @param unknown $tag
	 * @param unknown $alias
	 * @param unknown $sendno
	 * @param unknown $send_description
	 * @param unknown $mes_title
	 * @param unknown $mes_content
	 * @param unknown $platform
	 * @param string $extras
	 * @param string $override_msg_id
	 */
	public function __construct($app_key, $masterSecret, $timeToLive, $mes_type, $receiver_type, $receiver_value, $sendno, $send_description,
			$mes_title, $mes_content, $platform, $extras='',$override_msg_id='')
	{
		$this->app_key = $app_key;
		$this->masterSecret = $masterSecret;
		$this->time_to_live = $timeToLive;
		$this->receiver_type = $receiver_type;
		$this->receiver_value = $receiver_value;
		
		$content_str = '';
		if ($mes_type == 1)
		{
		    $content = array('n_title'=>$mes_title, 'n_content'=>$mes_content, 'n_extras'=>$extras);
		    $content_str = json_encode($content);
		}
		else if($mes_type == 2)
		{
		    $content = array('title'=>$mes_title, 'message'=>$mes_content, 'extras'=>$extras);
		    $content_str = json_encode($content);
		}
		$this->msg_content = $content_str;
		
		$this->msg_type = $mes_type;
		$this->sendno = $sendno;
		$this->send_description = $send_description;
		$this->platform = $platform;
		$this->override_msg_id = $override_msg_id;
	}
	
	/**
	 * 获取需要加密的字符串
	 * @return string
	 */
	public function getVerification_code()
	{

		return $this->sendno.$this->receiver_type.$this->receiver_value.$this->masterSecret;
	}
	
	/**
	 * 设置加密字符串
	 * @param unknown $verificationCode
	 */
	public function setVerification_code($verificationCode)
	{
		$this->verification_code = $verificationCode;
	}
	
	/**
	 * 获取参数
	 */
	public function getParams()
	{

		$params =  "app_key=".$this->app_key."&receiver_type=".$this->receiver_type.
		"&receiver_value=".$this->receiver_value."&verification_code=".$this->verification_code.
		"&msg_type=".$this->msg_type."&msg_content=".$this->msg_content."&send_description=".$this->send_description.
		"&send_description=".$this->send_description."&platform=".$this->platform.
		"&time_to_live=".$this->time_to_live."&override_msg_id=".$this->override_msg_id."&sendno=".$this->sendno;
		return $params;
	}
}