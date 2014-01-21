<?php
class MessageResult
{
	//code
	private $code;
	//message
	private $message;
	
	private $msgId;
	
	private $sendno;
	
	private $responseContent;
	
	//设置返回信息
    public function setResult($code, $message)
	{
	    $this->code = $code;
		$this->message = $message;
	}
	
	//传入json串
	public function setResultStr($rs, $code)
	{
	    $status = explode(" ",$rs["header"][0]);
		if($code==200 && $status[1] == 200)
		{		
			$mesObj = json_decode($rs["body"]);
			$this->code = $mesObj->errcode;
			$this->message = $mesObj->errmsg;
			//var_dump( $rs["header"]);
			$limit = "";$remaining = "";$reset= "";
			foreach($rs["header"] as $header)
			{
			    $headerArry = explode(":", $header);
			    if($headerArry[0] == "X-Rate-Limit-Limit")
				{
				    $limit = $headerArry[1];				
				}
			    else if($headerArry[0] == "X-Rate-Limit-Remaining")
				{
				    $remaining = $headerArry[1];				
				}
			    else if($headerArry[0] == "X-Rate-Limit-Reset")
				{
				    $reset = $headerArry[1];				
				}			
			}
			$this->responseContent = array("X-Rate-Limit-Limit"=>$limit,
										   "X-Rate-Limit-Remaining"=>$remaining,
										   "X-Rate-Limit-Reset"=>$reset);
			if($mesObj->errcode == 0)
			{
				$this->msgId = $mesObj->msg_id;
				$this->sendno = $mesObj->sendno;
			}	
		}
		else
		{
			$this->code = $status[1];
			switch ($status[1])
			{
			case 400:
			    $this->message = "Your request params is invalid. Please check them according to docs.";
			  break;  
			case 401:
			    $this->message = "Authentication failed! Please check authentication params according to docs.";
			  break;
			case 403:
			    $this->message = "Request is forbidden! Maybe your appkey is listed in blacklist?";
			  break;
			case 429:
			    $this->message = "Too many requests! Please review your appkey's request quota.";
			  break;
			default:
			    $this->message = "error new add.";	
			}
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
	
	public function getResponseContent()
	{
	    return $this->responseContent;
	}
}