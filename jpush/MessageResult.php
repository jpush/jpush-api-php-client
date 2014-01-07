<?php
class MessageResult
{
	//code
	private $code;
	//message
	private $message;
	
	private $msgId;
	
	private $sendno;
	
	//设置返回信息
    public function setResult($code, $message)
	{
	    $this->code = $code;
		$this->message = $message;
	}
	
	//传入json串
	public function setResultStr($message)
	{
	    //echo $message.'<br/>';
	    $mesObj = json_decode($message);
		$this->code = $mesObj->errcode;
		$this->message = $mesObj->errmsg;
		if($mesObj->errcode == 0)
		{
		    $this->msgId = $mesObj->msg_id;
		    $this->sendno = $mesObj->sendno;		
		}
	}
	
	public function getCode()
	{
	    return $this->code;
	}
	
	public function getMessage()
	{
	    return $this->message;
	}
	
	public function getSendno()
	{
	    return $this->sendno;
	}
	
	public function getMesId()
	{
	    return $this->msgId;
	}
}