<?php

include_once "NativeHttpClient.php";

/**
 * 推送逻辑类
 * @author xiezefan@126.com
 *
 */
class PushClient {
    private $PUSH_API_URL = "https://api.jpush.cn/v3/push";
    private $PUSH_METHOD = "POST";

    public function sendPush($payload, $autoCode) {
        $data_string = json_encode($payload->toJSON());
        //请求头信息
        $header = 'Authorization: Basic ' . $autoCode;
        $context = array('http' => array('method' => $this->PUSH_METHOD,  'header' => $header, 'content' => $data_string));
        $stream_context = stream_context_create($context);

        //请求
        $httpClient = new NativeHttpClient();
        try {
            $rs = $httpClient->sendRequest($this->PUSH_API_URL, $stream_context);
            return $rs["body"];
        } catch (Exception $e) {
            return  json_encode(array("code"=>"400", "message"=>"Maybe connect error. Retry laster."));
        }
        return $rs["body"];
    }

}

?>