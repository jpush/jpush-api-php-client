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

    public function sendRequestByCurl($url, $data, $header, $method = 'POST') {
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        if ($method === 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        }

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            //echo 'Errno'.curl_error($curl);//捕抓异常
            return json_encode(array("code"=>"400", "message"=>"Maybe connect error. Retry laster."));
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据

    }

    function vpost($url,$data,$cookie){ // 模拟提交数据函数

    }
}

?>