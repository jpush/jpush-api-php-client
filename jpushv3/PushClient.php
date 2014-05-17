<?php
/**
 * 推送类
 * @author xiezefan@126.com
 *
 */
class PushClient {
    private $PUSH_API_URL = "https://api.jpush.cn/v3/push";
    private $PUSH_METHOD = "POST";
    private $CHATSET = "UTF-8";

    public function send($data, $autoCode) {
        $data_string = json_encode($data); 
        $ch = curl_init($this->PUSH_API_URL);                                                                        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->PUSH_METHOD);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string),
            'Authorization:' . $autoCode,
            'Connection:Keep-Alive',
            'Accept-Charset:' . $this->CHATSET,
            'Charset:' . $this->CHATSET)); 
        $result = curl_exec($ch); 
        curl_close($ch); 
        return $result;                                                             
                       
    }
}

?>