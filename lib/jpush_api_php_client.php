<?php
include_once 'jpush_api_php_client/baseClient.php';
include_once 'jpush_api_php_client/secretEncode.php';
include_once 'jpush_api_php_client/receivedVO.php';
include_once 'jpush_api_php_client/sendVO.php';

/**
 * Jpush客户端
 * @author xinxin@jpush.cn
 * 
 */
class JpushClient
{
	//appkey
	private $app_key;
	//密匙
	private $masterSecret;
	//离线时长
	private $time_to_live ;
	
	/**
	 * 构造函数
	 * @param String $appKey
	 * @param String $masterSecret
	 * @param int $timeToLive
	 */
	public function __construct($app_key, $masterSecret, $timeToLive=0)
	{
		$this->app_key      = $app_key;
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
	public  function sendNotificationByTag($tag, $sendno, $send_description, 
			$mes_title, $mes_content, $platform, $extras='',$override_msg_id='')
	{
		$mes_type = 1;
		$receiver_type = 2;
		
		//设置对象参数
		$sendVO = new SendVO($this->app_key, $this->masterSecret, $this->time_to_live,$mes_type,$receiver_type, $tag, 
				$sendno, $send_description,	$mes_title, $mes_content, $platform, $extras='',$override_msg_id='');
				
		//发送通知 Or自定义消息
		$baseClient = new BaseClient();
		//echo $sendVO->getParams();
		$return_str = $baseClient->send($sendVO);
		
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
	public  function sendCustomMesByTag($tag, $sendno, $send_description, 
			$mes_title, $mes_content, $platform, $extras='',$override_msg_id='')
	{
		$mes_type = 2;
		$receiver_type = 2;
		
		//设置对象参数
		$sendVO = new SendVO($this->app_key, $this->masterSecret, $this->time_to_live,$mes_type,$receiver_type, $tag, 
				$sendno, $send_description,	$mes_title, $mes_content, $platform, $extras='',$override_msg_id='');
				
		//发送通知 Or自定义消息
		$baseClient = new BaseClient();
		$return_str = $baseClient->send($sendVO);
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
	public  function sendNotificationByAlias($alias, $sendno, $send_description, 
			$mes_title, $mes_content, $platform, $extras='',$override_msg_id='')
	{
		$mes_type = 1;
		$receiver_type = 3;
		
		//设置对象参数
		$sendVO = new SendVO($this->app_key, $this->masterSecret, $this->time_to_live,$mes_type,$receiver_type, $alias, 
				$sendno, $send_description,	$mes_title, $mes_content, $platform, $extras='',$override_msg_id='');
				
		//发送通知 Or自定义消息
		$baseClient = new BaseClient();
		$return_str = $baseClient->send($sendVO);
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
	public  function sendCustomMesByAlias($alias, $sendno, $send_description, 
			$mes_title, $mes_content, $platform, $extras='',$override_msg_id='')
	{
		$mes_type =2;
		$receiver_type = 3;
		
		//设置对象参数
		$sendVO = new SendVO($this->app_key, $this->masterSecret, $this->time_to_live,$mes_type,$receiver_type, $alias, 
				$sendno, $send_description,	$mes_title, $mes_content, $platform, $extras='',$override_msg_id='');
				
		//发送通知 Or自定义消息
		$baseClient = new BaseClient();
		$return_str = $baseClient->send($sendVO);
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
	public  function sendNotificationByAppkey($sendno, $send_description, 
			$mes_title, $mes_content, $platform, $extras='',$override_msg_id='')
	{
		$mes_type = 1;
		$receiver_type = 4;
		
		//设置对象参数
		$sendVO = new SendVO($this->app_key, $this->masterSecret, $this->time_to_live,$mes_type,$receiver_type, '', 
				$sendno, $send_description,	$mes_title, $mes_content, $platform, $extras='',$override_msg_id='');
				
		//发送通知 Or自定义消息
		$baseClient = new BaseClient();
		$return_str = $baseClient->send($sendVO);
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
	public  function sendCustomMesByAppkey($sendno, $send_description, 
			$mes_title, $mes_content, $platform, $extras='',$override_msg_id='')
	{
		$mes_type = 2;
		$receiver_type = 4;
		
		//设置对象参数
		$sendVO = new SendVO($this->app_key, $this->masterSecret, $this->time_to_live,$mes_type,$receiver_type, '', 
				$sendno, $send_description,	$mes_title, $mes_content, $platform, $extras='',$override_msg_id='');
				
		//发送通知 Or自定义消息
		$baseClient = new BaseClient();
		$return_str = $baseClient->send($sendVO);
	    return $return_str;
	 
	}
	
	/**
	 * 
	 * @param String $app_key
	 * @param String $msg_ids  msg_id以，连接
	 */
	public function getReceivedApi($msg_ids)
	{
		$receivedVO = new ReceivedVO($this->app_key, $this->masterSecret, $msg_ids);
		$baseClient = new BaseClient();
	    return $baseClient->getReceivedData($receivedVO);
	}
}
?>