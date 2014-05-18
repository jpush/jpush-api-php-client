<?php
/**
 * Http请求类
 * @author xiezefan@126.com
 */
class NativeHttpClient {

    public function sendRequest($url, $content) {
        $data = @file_get_contents($url, false, $content);
        $rs = array("header"=>$http_response_header,"body"=>$data);
        return $rs;
    }
}

?>