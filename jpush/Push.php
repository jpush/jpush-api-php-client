<?php
include_once 'HttpPostClient.php';
include_once 'SecretEncode.php';
include_once 'SendVO.php';
/**
 * 发送逻辑
 * @author xinxin
 *
 */
class Push
{
    // send address
	private $SEND_API_URL = "http://api.jpush.cn:8800/v2/push";
				
	/**
	 * 发送主体
	 * @param SendVO    $sendVO  发送信息对象
	 */
	public function pushMsg($sendVO, $msgResult)
	{
		//加密字符串
		$secretEncode = new SecretEncode();
		$verificationCode = $secretEncode->getMD5Encode($sendVO->getVerification_code());
		$sendVO->setVerification_code($verificationCode);
		
		//获取参数
		$params = $sendVO->getParams();
		//echo "*********".$params."\n ###";
		
		$context = array();
        
		$context['http'] = array(
			'method' => 'POST',
			'header' => 'Content-type: application/x-www-form-urlencoded',
			'content' => $params);
                
        $stream_context = stream_context_create($context);
		//echo $stream_context."\n";
	    $httpPostClient = new HttpPostClient();
		$code = 200;
		try
		{
		    $rs = $httpPostClient->request_tools($this->SEND_API_URL, $stream_context);		
		}
		catch(Exception $e)
		{	
		    $code =404;
		}
		$msgResult->setResultStr($rs, $code);
		return 0;
	}

}
?>