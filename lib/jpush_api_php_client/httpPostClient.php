<?php
class HttpPostClient
{
private $API_URL = "http://api.jpush.cn:8800/v2/push";

    /**
     * Post提交
     * 使用方法：
     * $post_string = "app=request&version=beta";
     * request_by_other('http://facebook.cn/restServer.php',$post_string);
     */
    function request_post($remote_server, $stream_context)
    {
        //echo $stream_context;
        $data = file_get_contents($remote_server, false, $stream_context);
        return $data;
    }

    /**
     * get提交
     * 使用方法：
     * $post_string = "app=request&version=beta";
     * request_by_other('http://facebook.cn/restServer.php',$post_string);
     */
    function request_get($remote_server, $stream_context)
    {
        //echo $stream_context;
        $data = file_get_contents($remote_server, false, $stream_context);
        return $data;
    }
    
    function requestHttps($url,$timeout=30,$header=array())
    {
    	if(!function_exists('curl_init'))
    	{
    		throw new RuntimeException('server not install curl');    		
    	}
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_HEADER, true);
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    	if(!empty($header)) 
    	{
    	     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    	}
    	$data = curl_exec($ch);
    	list($header, $data)= explode("\r\n\r\n", $data);
    	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    	if($http_code == 301 || $http_code == 302){
    		$matches= array();
    	    preg_match('/Location:(.*?)\n/',$header,$matches);
    	    $url= trim(array_pop($matches));
    	    curl_setopt($ch, CURLOPT_URL,$url);
    	    curl_setopt($ch, CURLOPT_HEADER, false);
    	    $data= curl_exec($ch);
    	}
    	if($data == false){
    	    curl_close($ch);
    	}
    	@curl_close($ch);
    	return $data;
    }

}
//$httpPostClient = new HttpPostClient();
//echo $httpPostClient->request_by_other("http://api.jpush.cn:8800/v2/push","")
?>