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
    function request_post($remote_server, $post_string)
    {
        $context = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Connection:Keep-Alive'.
            	'\r\n'.'Charset: UTF-8' .
            	'\r\n'.'Content-type: application/x-www-form-urlencoded'.
                '\r\n'.'Content-length:' . strlen($post_string) + 8,
                'content' => $post_string)
        );
        //echo $post_string;
        $stream_context = stream_context_create($context);
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
    function request_get($remote_server, $auth)
    {
        $context = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'Connection:Keep-Alive'.
            	'\r\n'.'Charset: UTF-8' .
            	'\r\n'.'Authorization: Basic '.$auth.
            	'\r\n'.'Content-type: application/x-www-form-urlencoded'.
                '\r\n')
        );
        //echo $post_string;
        $stream_context = stream_context_create($context);
        //echo $stream_context;
        $data = file_get_contents($remote_server, false, $stream_context);
        return $data;
    }
    

}
//$httpPostClient = new HttpPostClient();
//echo $httpPostClient->request_by_other("http://api.jpush.cn:8800/v2/push","")
?>