<?php
include_once 'Push.php';
include_once 'ReportRecevied.php';
include_once 'SecretEncode.php';
include_once 'ReceivedVO.php';
include_once 'SendVO.php';
include_once 'MessageResult.php';
include_once 'ValidateParams.php';
include_once 'ReceiveResult.php';

/**
 * Jpush客户端
 * @author xinxin@jpush.cn
 * 
 */
class JPushClient
{	
    //初始化参数
	private $initparams;
		
	/**
	 * 构造函数
	 * @param String $appKey
	 * @param String $masterSecret
	 * @param int    $timeToLive
	 * @param String $platform      取值范围  (android,ios）
	 * @param String $apnsProduction
	 */
	public function __construct($app_key, $masterSecret, $timeToLive=0, $platform='', $apnsProduction=false)
	{
		$this->initparams = array("app_key" => $app_key, 
		                          "masterSecret" => $masterSecret, 
								  "timeToLive" => $timeToLive, 
								  "platform" => $platform, 
								  "apnsProduction" => $apnsProduction);
	}
	
	/**
	 * 发送通知
	 * @notificationContent Strng 通知内容
	 * @param Strng $notificationParams 
	 * @param Array $notificationParams = array("receiver_type" => 1,     *
	 *                                          "receiver_value" => "",
	 *                                          "sendno" => 1,
	 *                                          "send_description" => "",
	 *                                          "override_msg_id" => "")
	 * @param Array $extras
	 *  
	 * @return MessageResult $msgResult   错误信息对象
	 */
	public function sendNotification($notificationContent, $notificationParams, $extras)
	{	
	    //初始化返回对象
	    $msgResult = new MessageResult();
		
		//验证参数
		$validate = new ValidateParams($this->initparams);
		if(!$validate->validateNotification($notificationContent, $notificationParams, $extras, $msgResult))
		{
		     return $msgResult;
		}
		
		//设置对象参数
		$notificationParams["notificationContent"] = $notificationContent;
		$notificationParams["mes_type"] = 1;
		
		$sendVO = new SendVO($this->initparams ,$notificationParams, $extras);
		
		//发送通知
		$pushClient = new Push();
		
		$pushClient->pushMsg($sendVO, $msgResult);
		
	    return $msgResult;	    
	}
	
	
	/**
	 * 发送通知
	 * @notificationContent Strng 通知内容
	 * @param Strng $msgTitle 
	 * @param Strng $msgContent 
	 * @param Array $customMessageParams = array("receiver_type" => 1,     *
	 *                                          "receiver_value" => "",
	 *                                          "sendno" => 1,
	 *                                          "send_description" => "",
	 *                                          "override_msg_id" => "")
	 * @param Array $extras
	 *  
	 * @return MessageResult $msgResult   错误信息对象
	 */
	public function sendCustomMessage($msgTitle, $msgContent, $customMessageParams, $extras)
	{
	    //初始化返回对象
	    $msgResult = new MessageResult();
		
		//验证参数
		$validate = new ValidateParams($this->initparams);
		if(!$validate->validateCustomMessage($msgTitle, $msgContent, $customMessageParams, $extras, $msgResult))
		{
		     return $msgResult;
		}
		
		//设置对象参数
		$customMessageParams["msgTitle"] = $msgTitle;
		$customMessageParams["msgContent"] = $msgContent;
		$customMessageParams["mes_type"] = 2;
		
		$sendVO = new SendVO($this->initparams ,$customMessageParams, $extras);
		
		//发送通知
		$pushClient = new Push();
		
		$pushClient->pushMsg($sendVO, $msgResult);
		
	    return $msgResult;	    
	}
	
	/**
	 * 
	 * @param String $app_key
	 * @param String $msg_ids  msg_id以，连接
	 */
	public function getReportReceiveds($msg_ids)
	{
		$receivedVO = new ReceivedVO($this->initparams, $msg_ids);
		$revResult = new ReceiveResult();
		//echo $revResult;
		$revClient = new ReportRecevied();
		$revClient->getReceivedData($receivedVO, $revResult);
		//echo $revResult;
		return $revResult;
	}

}
?>