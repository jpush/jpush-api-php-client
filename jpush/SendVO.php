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
	private $sendno = 1;  
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
	
	private $apnsProduction;
	
	
	/**
	 * 构造函数
	 * @param Array $initparams
	 * @param Array $params
	 * @param Array $extras
	 */
	public function __construct($initparams, $params, $extras)
	{
		$this->app_key        = $initparams["app_key"];
		$this->masterSecret   = $initparams["masterSecret"];
		$this->time_to_live   = $initparams["timeToLive"];
		$this->apnsProduction = $initparams["apnsProduction"];
		$this->receiver_type  = $params["receiver_type"];
		
		$apnsProduction = 0;
		if($initparams["apnsProduction"] == true)
		{
		    $apnsProduction = 1;
		}
		if($initparams["platform"] == '')
		{		    
		    $this->platform = 'android,ios';
		}
		else
		{
		     $this->platform = $initparams["platform"];		
		}
		$this->msg_type       = $params["mes_type"];
		
		$content_str = '';
		$content = '';
		if ($params["mes_type"] == 1)
		{
		    $mes_title = "";
		    $mes_content = $params["notificationContent"];
		    $content = array('n_title'=>$mes_title, 'n_content'=>$mes_content, 'n_extras'=>$extras);
		}
		else if($params["mes_type"] == 2)
		{   
		    $mes_title = $params["msgTitle"];
		    $mes_content = $params["msgContent"];
		    $content = array('title'=>$mes_title, 'message'=>$mes_content, 'extras'=>$extras);
		}
		$content_str = json_encode($content);
		$this->msg_content = $content_str;
		
		if(array_key_exists("receiver_value",$params) && is_string($params["receiver_value"]))
		{
		     $this->receiver_value = $params["receiver_value"];
		}
		if(array_key_exists("sendno",$params) && is_int($params["sendno"]))
		{
		     $this->sendno = $params["sendno"];
		}
		
		if(array_key_exists("send_description",$params) && is_string($params["send_description"]))
		{
		     $this->send_description = $params["send_description"];
		}
		
		if(array_key_exists("override_msg_id",$params) && is_string($params["override_msg_id"]))
		{
		     $this->override_msg_id = $params["override_msg_id"];
		}
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
		"&time_to_live=".$this->time_to_live."&override_msg_id=".$this->override_msg_id."&sendno=".$this->sendno."&apnsProduction=".$this->apnsProduction;
		//echo $params.'<br/>';
		return $params;
	}
}