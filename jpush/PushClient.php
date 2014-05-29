<?php

include_once "NativeHttpClient.php";

/**
 * 推送逻辑类
 * @author xiezefan@126.com
 *
 */
class PushClient {
    private $PUSH_API_URL = "https://api.jpush.cn/v3/push";

    public function sendPush($payload, $autoCode) {
        $data_string = json_encode($payload->toJSON());
        $header = array('Authorization: Basic ' . $autoCode, 'Content-type: application/json');

        //请求
        $httpClient = new NativeHttpClient();
        try {
            return $httpClient->sendRequestByCurl($this->PUSH_API_URL, $data_string, $header);
        } catch (Exception $e) {
            error_log("Maybe connect error. Retry later.");
            //return  json_encode(array("code"=>"400", "message"=>"Maybe connect error. Retry later."));
        }
    }

}

?>