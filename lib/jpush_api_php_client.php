<?php
include_once 'jpush_api_php_client/baseClient.php';

/**
 * Jpush客户端
 * @author xinxin@jpush.cn
 * 
 */
class JpushClient
{
	
	//密匙
	private $masterSecret;
	//离线市场
	private $time_to_live ;
	
	/**
	 * 构造函数
	 * @param String $appKey
	 * @param String $masterSecret
	 * @param int $timeToLive
	 */
	public function __construct($masterSecret, $timeToLive)
	{
		$this->masterSecret = $masterSecret;
		$this->time_to_live = $timeToLive;
	}
	
	/**
	 * 通过tag发送通知
	 * @param Strng $tag
	 * @param Strng $app_key
	 * @param int $sendno
	 * @param Strng $send_description
	 * @param Strng $mes_title
	 * @param Strng $mes_content
	 * @param Strng $perform
	 * @param Strng $extras
	 */
	public  function sendNotificationByTag($tag, $app_key, $sendno, $send_description, 
			$mes_title, $mes_content, $platform, $extras='',$override_msg_id='')
	{
		$mes_type = 1;
		$msg_content = $this->getContent($mes_title, $mes_content, $mes_type, $extras);
		$receiver_value = $tag;
		$baseClent = new BaseClent();
		$receiver_type = 2;
		$verification_code = $this->getVerification_code($sendno, $receiver_type, $receiver_value);
		$return_str = $baseClent->send($sendno, $app_key, $receiver_type, $receiver_value, $verification_code,
			$mes_type, $msg_content, $send_description, $platform, $this->time_to_live, $override_msg_id);
	    return $return_str;
	}

	/**
	 * 通过tag发送自定义消息
	 * @param Strng $tag
	 * @param Strng $app_key
	 * @param int $sendno
	 * @param Strng $send_description
	 * @param Strng $mes_title
	 * @param Strng $mes_content
	 * @param Strng $perform
	 * @param Strng $extras
	 */
	public  function sendCustomMesByTag($tag, $app_key, $sendno, $send_description, 
			$mes_title, $mes_content, $platform, $extras='',$override_msg_id='')
	{
		$mes_type = 2;
		$msg_content = $this->getContent($mes_title, $mes_content, $mes_type, $extras);
		$receiver_value = $tag;
		$baseClent = new BaseClent();
		$receiver_type = 2;
		$verification_code = $this->getVerification_code($sendno, $receiver_type, $receiver_value);
		$return_str = $baseClent->send($sendno, $app_key, $receiver_type, $receiver_value, $verification_code,
			$mes_type, $msg_content, $send_description, $platform, $this->time_to_live, $override_msg_id);
	    return $return_str;
	 
	}

	/**
	 * 通过alias发送通知
	 * @param Strng $alias
	 * @param Strng $app_key
	 * @param int $sendno
	 * @param Strng $send_description
	 * @param Strng $mes_title
	 * @param Strng $mes_content
	 * @param Strng $perform
	 * @param Strng $extras
	 */
	public  function sendNotificationByAlias($alias, $app_key, $sendno, $send_description, 
			$mes_title, $mes_content, $platform, $extras='',$override_msg_id='')
	{
		$mes_type = 1;
		$msg_content = $this->getContent($mes_title, $mes_content, $mes_type, $extras);
		$receiver_value = $alias;
		$baseClent = new BaseClent();
		$receiver_type = 3;
		$verification_code = $this->getVerification_code($sendno, $receiver_type, $receiver_value);
		$return_str = $baseClent->send($sendno, $app_key, $receiver_type, $receiver_value, $verification_code,
			$mes_type, $msg_content, $send_description, $platform, $this->time_to_live, $override_msg_id);
	    return $return_str;
	 
	}

	/**
	 * 通过alias发送自定义消息
	 * @param Strng $alias
	 * @param Strng $app_key
	 * @param int $sendno
	 * @param Strng $send_description
	 * @param Strng $mes_title
	 * @param Strng $mes_content
	 * @param Strng $perform
	 * @param Strng $extras
	 */
	public  function sendCustomMesByAlias($alias, $app_key, $sendno, $send_description, 
			$mes_title, $mes_content, $platform, $extras='',$override_msg_id='')
	{
		$mes_type =2;
		$msg_content = $this->getContent($mes_title, $mes_content, $mes_type, $extras);
		$receiver_value = $alias;
		$baseClent = new BaseClent();
		$receiver_type = 3;
		$verification_code = $this->getVerification_code($sendno, $receiver_type, $receiver_value);
		$return_str = $baseClent->send($sendno, $app_key, $receiver_type, $receiver_value, $verification_code,
			$mes_type, $msg_content, $send_description, $platform, $this->time_to_live, $override_msg_id);
	    return $return_str;
	 
	}

	/**
	 * 发送广播通知
	 * @param Strng $app_key
	 * @param int $sendno
	 * @param Strng $send_description
	 * @param Strng $mes_title
	 * @param Strng $mes_content
	 * @param Strng $perform
	 * @param Strng $extras
	 */
	public  function sendNotificationByAppkey($app_key, $sendno, $send_description, 
			$mes_title, $mes_content, $platform, $extras='',$override_msg_id='')
	{
		$mes_type = 1;
		$msg_content = $this->getContent($mes_title, $mes_content, $mes_type, $extras);
		$receiver_value = '';
		$baseClent = new BaseClent();
		$receiver_type = 4;
		$verification_code = $this->getVerification_code($sendno, $receiver_type, $receiver_value);
		$return_str = $baseClent->send($sendno, $app_key, $receiver_type, $receiver_value, $verification_code,
			$mes_type, $msg_content, $send_description, $platform, $this->time_to_live, $override_msg_id);
	    return $return_str;
	 
	}

	/**
	 * 发送广播自定义消息
	 * @param Strng $app_key
	 * @param int $sendno
	 * @param Strng $send_description
	 * @param Strng $mes_title
	 * @param Strng $mes_content
	 * @param Strng $perform
	 * @param Strng $extras
	 */
	public  function sendCustomMesByAppkey($app_key, $sendno, $send_description, 
			$mes_title, $mes_content, $platform, $extras='',$override_msg_id='')
	{
		$mes_type = 2;
		$msg_content = $this->getContent($mes_title, $mes_content, $mes_type, $extras);
		$receiver_value = '';
		$baseClent = new BaseClent();
		$receiver_type = 4;
		$verification_code = $this->getVerification_code($sendno, $receiver_type, $receiver_value);
		$return_str = $baseClent->send($sendno, $app_key, $receiver_type, $receiver_value, $verification_code,
			$mes_type, $msg_content, $send_description, $platform, $this->time_to_live, $override_msg_id);
	    return $return_str;
	 
	}
	
	/**
	 * 
	 * @param String $app_key
	 * @param String $msg_ids  msg_id以，连接
	 */
	public function getReceivedApi($app_key, $msg_ids)
	{
		$baseClent = new BaseClent();
		$auth = $baseClent->getBase64_code($app_key, $this->masterSecret);
	    return $baseClent->getReceiedData($auth, $msg_ids, $app_key);
	}
	
	/**
	 * 消息发送体
	 * @param String $mes_title
	 * @param String $mes_content
	 * @param int $mes_type
	 * @param String $extras
	 * @return string
	 */
	private function getContent($mes_title, $mes_content, $mes_type, $extras)
	{
		//echo "mes_title=".$mes_title."mes_content=".$mes_content."mes_type=".$mes_type."extras=".$extras;
		$content_str = '';
		if($mes_type == 1)
		{
		    $content = array('n_title'=>$mes_title, 'n_content'=>$mes_content, 'n_extras'=>$extras);
		    $content_str = json_encode($content);
		}
		else if($mes_type == 2)
		{
		    $content = array('title'=>$mes_title, 'message'=>$mes_content, 'extras'=>$extras);
		    $content_str = json_encode($content);
		}		
		//echo $content_str;
		return $content_str;
	}
	
	
	/**
	 * 获取验证字符串_md5加密
	 * @param int $sendno
	 * @param int $receiver_type
	 * @param String $receiver_value
	 * @return String
	 */
	private function getVerification_code($sendno, $receiver_type, $receiver_value)
	{
		$verification_str = $sendno.$receiver_type.$receiver_value.$this->masterSecret;
		$verification_str = md5($verification_str);
		return $verification_str;
	}
}
?>