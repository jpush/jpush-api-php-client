<?php
/**
 * 字符串加密
 * @author xinxin@jpush.cn
 *
 */
class NativeHttpClient {
    private $PUSH_API_URL = "https://api.jpush.cn/v3/push";

    public function push($baseUrl, $data) {
        
        $data_string = json_encode($data);
        $ch = curl_init('http://api.local/rest/users');                                                                        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                       
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(   'Content-Type: application/json',  'Content-Length: ' . strlen($data_string))                                                                         
);                              
    }
}

?>