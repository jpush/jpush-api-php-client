<?php
include_once 'httpPostClient.php';
include_once 'secretEncode.php';
include_once 'receivedVO.php';
include_once 'sendVO.php';
/**
 * 发送逻辑
 * @author xinxin
 *
 */
class BaseClient
{
	private $SEND_API_URL = "http://api.jpush.cn:8800/v2/push";
	private $RECEIVE_API_URL = "https://report.jpush.cn/v2/received";
	
	/**
	 * 构造函数
	 */
	public function __construct()
	{
		
	}
	
	/**
	 * 发送主体
	 * @param SendVO    $sendVO  发送信息对象
	 */
	public function send($sendVO)
	{
		//加密字符串
		$secretEncode = new SecretEncode();
		$verificationCode = $secretEncode->getMD5Encode($sendVO->getVerification_code());
		$sendVO->setVerification_code($verificationCode);
		
		//获取参数
		$params = $sendVO->getParams();
		//echo "*********".$params."\n ###";
		
        $context = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Connection:Keep-Alive'.
            	'\r\n'.'Charset: UTF-8' .
            	'\r\n'.'Content-type: application/x-www-form-urlencoded'.
                '\r\n'.'Content-length:' . strlen($params) + 8,
                'content' => $params)
        );
        
        //echo $post_string;
        
        $stream_context = stream_context_create($context);
		//echo $stream_context."\n";
	    $httpPostClient = new HttpPostClient();
		return $httpPostClient->request_post($this->SEND_API_URL, $stream_context);
	}

	/**
	 * 获取消息接收数量信息
	 * @param unknown $receivedVO
	 * 备注：发送采用https需要修改php.ini打开extension=php_openssl.dll
	 * 
	 */
	public function getReceivedData($receivedVO)
	{
		//加密字符串
		$secretEncode = new SecretEncode();
		$authStr = $secretEncode->getBase64Encode($receivedVO->getAuthStr());
		$receivedVO->setAuth($authStr);
		
		//url
		$url = $this->RECEIVE_API_URL."?".$receivedVO->getParams();
		
		//请求头信息
		$context = array(
				'http' => array(
						'method' => 'GET',
						'header' => 'Connection:Keep-Alive'.
						'\r\n'.'Charset: UTF-8' .
						'\r\n'.'Authorization: Basic '.$receivedVO->getAuth().
						'\r\n'.'Content-type: application/x-www-form-urlencoded'.
				'\r\n')
		);
		echo $context;
		$stream_context = stream_context_create($context);
		//echo $stream_context;
		$httpPostClient = new HttpPostClient();
		return $httpPostClient->request_get($url, $stream_context);
	}

}
?>