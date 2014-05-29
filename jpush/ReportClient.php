<?php

include_once 'NativeHttpClient.php';
/**
 * 获取统计信息逻辑类
 * @author xiezefan@126.com
 *
 */
class ReportClient {
    private $RECEIVE_API_URL = "https://report.jpush.cn/v2/received";
    private $RECEIVE_METHOD = "GET";
    private $CHATSET = "UTF-8";

    public function send($data, $autoCode) {
        $url = $this->RECEIVE_API_URL . "?msg_ids=" . $data;
        $header = 'Authorization:' . $autoCode;
        //请求头信息
        $context = array('http' => array('method' => $this->RECEIVE_METHOD,  'header' => $header));
        $stream_context = stream_context_create($context);

        //请求
        $httpClient = new NativeHttpClient();

        try {
            $rs = $httpClient->sendRequest($url, $stream_context);
            return $rs["body"];
        } catch (Exception $e) {
            //return  json_encode(array("code"=>"400", "message"=>"Maybe connect error. Retry laster."));
            error_log("Maybe connect error. Retry later.");
        }
    }
}

?>