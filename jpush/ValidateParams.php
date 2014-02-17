<?php
class ValidateParams
{
    //初始化参数
    private $initparams;

	/**
	 * 构造函数
	 */
	public function __construct($initparams)
	{
	    $this->initparams = $initparams;
	}

	/**
	 * 验证通知参数
	 * @return string
	 */
	public function validateNotification($notificationContent, $notificationParams, $extras, $msgResult)
	{
	    $flag = true;
	    if(is_array($notificationParams) && is_string($notificationContent) && is_array($extras))
		{			
			if(!$this->validateParams($notificationParams, $msgResult))
			{
	            $flag = false;			
			}		
		}
		else
		{
	        $flag = false;
		    $msgResult.setResult(1003,"The parameters of sendNotification are not valid.");	
		}
		
		return $flag;
	}

	/**
	 * 验证自定义消息参数
	 * @return string
	 */
	public function validateCustomMessage($msgTitle, $msgContent, $notificationParams, $extras, $msgResult)
	{
	    $flag = true;
	    if(is_array($notificationParams) && is_string($msgTitle) && is_string($msgContent) && is_array($extras))
		{			
			if(!$this->validateParams($notificationParams, $msgResult))
			{
	            $flag = false;			
			}		
		}
		else
		{
	        $flag = false;
		    $msgResult.setResult(1003,"The parameters of sendCustomMessage are not valid.");	
		}
		
		return $flag;
	}
	
	
	private function validateParams($paramsArray, $msgResult)
	{		 
		 if(!is_string($this->initparams["app_key"]) && empty($this->initparams["app_key"]))
		 {
		      $msgResult.setResult(1003,"The parameter of appkey  is not valid.");
			  return false;		 
		 }
		 if(!is_string($this->initparams["masterSecret"]) && empty($this->initparams["masterSecret"]))
		 {
		      $msgResult.setResult(1003,"The parameter of masterSecret  is not valid.");
			  return false;		 
		 }
		 if(!is_int($this->initparams["timeToLive"]))
		 {
		      $msgResult.setResult(1003,"The parameter of timeToLive  is not valid.");
			  return false;		 
		 }
		 if(!is_bool($this->initparams["apnsProduction"]))
		 {
		      $msgResult.setResult(1003,"The parameter of apnsProduction  is not valid.");
			  return false;		 
		 }
		 
	     if(!array_key_exists("receiver_type",$paramsArray))
		 {
		      $msgResult.setResult(1002,"Receiver type is required.");
			  return false;
		 }		 
		 
	     if(!(array_key_exists("receiver_type",$paramsArray) && is_int($paramsArray["receiver_type"])))
		 {
		      $msgResult.setResult(1003,"The parameter of receiver-type  is not valid.");
			  return false;
		 }
		 
	     if(!(array_key_exists("receiver_value",$paramsArray) && is_string($paramsArray["receiver_value"])))
		 {
		      $msgResult.setResult(1003,"The parameter of receiver_value  is not valid.");
			  return false;
		 }
		 
	     if(!(array_key_exists("sendno",$paramsArray) && is_int($paramsArray["sendno"])))
		 {
		      $msgResult.setResult(1003,"The parameter of sendno  is not valid.");
			  return false;
		 }
		 
	     if(!(array_key_exists("send_description",$paramsArray) && is_string($paramsArray["send_description"])))
		 {
		      $msgResult.setResult(1003,"The parameter of send_description  is not valid.");
			  return false;
		 }
		 
	     if(!(array_key_exists("override_msg_id",$paramsArray) && is_string($paramsArray["override_msg_id"])))
		 {
		      $msgResult.setResult(1003,"The parameter of override_msg_id  is not valid.");
			  return false;
		 }
		 return true;
	}
}