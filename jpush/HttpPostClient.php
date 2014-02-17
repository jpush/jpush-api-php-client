<?php
class HttpPostClient
{
private $API_URL = "http://api.jpush.cn:8800/v2/push";

    /**
     * httpRequest
     */
    function request_tools($remote_server, $stream_context)
    {
        $data = @file_get_contents($remote_server, false, $stream_context);
		//echo $http_response_header;
		$rs = array("header"=>$http_response_header,"body"=>$data);
		//echo $http_response_header;
        return $rs;
    }
}
?>