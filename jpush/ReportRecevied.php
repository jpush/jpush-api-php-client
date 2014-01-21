<?php
include_once 'HttpPostClient.php';
include_once 'SecretEncode.php';
include_once 'ReceivedVO.php';
/**
 * 发送逻辑
 * @author xinxin
 *
 */
class ReportRecevied
{	
	// receive address
	private $RECEIVE_API_URL = "https://report.jpush.cn/v2/received";

	/**
	 * 获取消息接收数量信息
	 * @param unknown $receivedVO
	 * 备注：发送采用https需要修改php.ini打开extension=php_openssl.dll
	 * 
	 */
	public function getReceivedData($receivedVO, $revResult)
	{
	    //echo "1111";
		//加密字符串
		$secretEncode = new SecretEncode();
		
		$authStr = $secretEncode->getBase64Encode($receivedVO->getAuthStr());
		$receivedVO->setAuth($authStr);
		
		//url
		$url = $this->RECEIVE_API_URL."?".$receivedVO->getParams();
		
		$header = 'Authorization: Basic '.$receivedVO->getAuth();
		
		//请求头信息
		$context = array(
				'http' => array(
						'method' => 'GET',
						'header' => $header)
		);
		$stream_context = stream_context_create($context);
		//echo $stream_context;
		$httpPostClient = new HttpPostClient();
		$code = 200;
		try
		{
		    $rs = $httpPostClient->request_tools($url, $stream_context);
            //echo $rs;		
		}
		catch(Exception $e)
		{	
		    echo $e;
		    $code =404;
		}
		//echo $rs["body"];
		$revResult->setResultStr($rs, $code);
		//echo $revResult->getResultStr();
		return $revResult;
	}

}
?>