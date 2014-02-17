<?php
class ReceiveResult
{
	//code
	private $errcode;
	//message
	private $errmsg;
	
	private $dataStr;
	
	private $responseContent;
	
	//传入json串
	public function setResultStr($rs, $errcode)
	{
	    $status = explode(" ",$rs["header"][0]);
	    if($errcode ==200 && $status[1] == 200)
		{
		    //var_dump( $rs["header"]);
			$this->errcode = $errcode;
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
		    //var_dump( $this->responseContent);
			$this->dataStr = $rs["body"];
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
	    //echo $rs.'<br/>';
		//echo $dataArry;
	}
	
	public function isOK()
	{
	    return $this->errcode == 200;
	}
	
	public function getResultStr()
	{
	    return $this->dataStr;
	}
	
	public function getResponseContent()
	{
	    return $this->responseContent;
	}
}