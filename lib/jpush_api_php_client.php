<?php
include_once 'jpush_api_php_client/baseClient.php';

class BaseClent
{
	
	/**
	 * 
	 * @var unknown
	 */
	private $masterSecret;
	private $app_key ;
	private $timeToLive ;
	
	/**
	 * 构造函数
	 * @param String $appKey
	 * @param String $masterSecret
	 * @param int $timeToLive
	 */
	public function __construct($app_key, $masterSecret, $timeToLive)
	{
		$this->app_key = $app_key;
		$this->masterSecret = $masterSecret;
		$this->timeToLive = $timeToLive;
	}
	
	/**
	 * 
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
			$mes_title, $mes_content, $perform, $extras,$override_msg_id='')
	{
		$mes_type = 1;
		$msg_content = $this->getContent($mes_title, $mes_content, $mes_type, $extras);
		$receiver_value = tag
		$baseClent = new BaseClent();
		$receiver_type = 2;
		$msg_type = 1;
		$verification_code = $this->getVerification_code($sendno, $receiver_type, $receiver_value);
		$return_str = $baseClent->send($sendno, $app_key, $receiver_type, $receiver_value, $verification_code,
			$msg_type, $msg_content, $send_description, $platform, $this->time_to_live, $override_msg_id);
	    echo $return_str;
	}

	/**
	 *
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
			$mes_title, $mes_content, $perform, $extras)
	{
		$mes_type = 2;
		$msg_content = $this->getContent($mes_title, $mes_content, $mes_type, $extras);
		$receiver_value = tag
		$baseClent = new BaseClent();
		$receiver_type = 2;
		$msg_type = 1;
		$verification_code = $this->getVerification_code($sendno, $receiver_type, $receiver_value);
		$return_str = $baseClent->send($sendno, $app_key, $receiver_type, $receiver_value, $verification_code,
			$msg_type, $msg_content, $send_description, $platform, $this->time_to_live, $override_msg_id);
	    echo $return_str;
	 
	}

	/**
	 *
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
			$mes_title, $mes_content, $perform, $extras)
	{
		$mes_type = 1;
		$msg_content = $this->getContent($mes_title, $mes_content, $mes_type, $extras);
		$receiver_value = tag
		$baseClent = new BaseClent();
		$receiver_type = 2;
		$msg_type = 1;
		$verification_code = $this->getVerification_code($sendno, $receiver_type, $receiver_value);
		$return_str = $baseClent->send($sendno, $app_key, $receiver_type, $receiver_value, $verification_code,
			$msg_type, $msg_content, $send_description, $platform, $this->time_to_live, $override_msg_id);
	    echo $return_str;
	 
	}

	/**
	 *
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
			$mes_title, $mes_content, $perform, $extras)
	{
		$mes_type =2;
		$msg_content = $this->getContent($mes_title, $mes_content, $mes_type, $extras);
		$receiver_value = tag
		$baseClent = new BaseClent();
		$receiver_type = 2;
		$msg_type = 1;
		$verification_code = $this->getVerification_code($sendno, $receiver_type, $receiver_value);
		$return_str = $baseClent->send($sendno, $app_key, $receiver_type, $receiver_value, $verification_code,
			$msg_type, $msg_content, $send_description, $platform, $this->time_to_live, $override_msg_id);
	    echo $return_str;
	 
	}

	/**
	 *
	 * @param Strng $app_key
	 * @param int $sendno
	 * @param Strng $send_description
	 * @param Strng $mes_title
	 * @param Strng $mes_content
	 * @param Strng $perform
	 * @param Strng $extras
	 */
	public  function sendNotificationByAppkey($app_key, $sendno, $send_description, 
			$mes_title, $mes_content, $perform, $extras)
	{
		$mes_type = 1;
		$msg_content = $this->getContent($mes_title, $mes_content, $mes_type, $extras);
		$receiver_value = tag
		$baseClent = new BaseClent();
		$receiver_type = 2;
		$msg_type = 1;
		$verification_code = $this->getVerification_code($sendno, $receiver_type, $receiver_value);
		$return_str = $baseClent->send($sendno, $app_key, $receiver_type, $receiver_value, $verification_code,
			$msg_type, $msg_content, $send_description, $platform, $this->time_to_live, $override_msg_id);
	    echo $return_str;
	 
	}

	/**
	 *
	 * @param Strng $app_key
	 * @param int $sendno
	 * @param Strng $send_description
	 * @param Strng $mes_title
	 * @param Strng $mes_content
	 * @param Strng $perform
	 * @param Strng $extras
	 */
	public  function sendCustomMesByAppkey($app_key, $sendno, $send_description, 
			$mes_title, $mes_content, $perform, $extras)
	{
		$mes_type = 2;
		$msg_content = $this->getContent($mes_title, $mes_content, $mes_type, $extras);
		$receiver_value = tag
		$baseClent = new BaseClent();
		$receiver_type = 2;
		$msg_type = 1;
		$verification_code = $this->getVerification_code($sendno, $receiver_type, $receiver_value);
		$return_str = $baseClent->send($sendno, $app_key, $receiver_type, $receiver_value, $verification_code,
			$msg_type, $msg_content, $send_description, $platform, $this->time_to_live, $override_msg_id);
	    echo $return_str;
	 
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
		return $content_str;
	}
	
	
	private function getVerification_code($sendno, $receiver_type, $receiver_value)
	{
		$verification_str = $sendno.$receiver_type.$receiver_value.$this->$masterSecret;
		$verification_str = md5($verification_str);
		return $verification_str;
	}
}
?>