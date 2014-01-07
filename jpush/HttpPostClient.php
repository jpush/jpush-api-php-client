<?php
class HttpPostClient
{
private $API_URL = "http://api.jpush.cn:8800/v2/push";

    /**
     * httpRequest
     */
    function request_tools($remote_server, $stream_context)
    {
        $data = file_get_contents($remote_server, false, $stream_context);
        return $data;
    }
}
?>