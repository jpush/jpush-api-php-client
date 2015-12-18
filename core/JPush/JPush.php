<?php

require_once("./PushPayload.php");
require_once("./JPushException.php");

class JPush {
    CONST DISABLE_SOUND = "_disable_Sound";
    CONST DISABLE_BADGE = 0x10000;

    const PUSH_URL = 'https://api.jpush.cn/v3/push';
    const REPORT_URL = 'https://report.jpush.cn/v2/received';
    const VALIDATE_URL = 'https://api.jpush.cn/v3/push/validate';
    const MESSAGES_URL = 'https://report.jpush.cn/v3/messages';
    const USERS_URL = 'https://report.jpush.cn/v3/users';
    const DEVICES_URL = 'https://device.jpush.cn/v3/devices/{registration_id}';
    const ALL_TAGS_URL = 'https://device.jpush.cn/v3/tags/';
    const IS_IN_TAG_URL = 'https://device.jpush.cn/v3/tags/{tag}/registration_ids/{registration_id}';
    const TAG_URL = 'https://device.jpush.cn/v3/tags/{tag}';
    const ALIAS_URL = 'https://device.jpush.cn/v3/aliases/{alias}';

    const USER_AGENT = 'JPush-API-PHP-Client';
    const CONNECT_TIMEOUT = 5;
    const READ_TIMEOUT = 30;
    const DEFAULT_MAX_RETRY_TIMES = 3;
    const DEFAULT_LOG_FILE = "./jpush.log";

    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';

    private $appKey;
    private $masterSecret;
    private $retryTimes;
    private $logFile;


    public function __construct($appKey, $masterSecret, $retryTimes=self::DEFAULT_MAX_RETRY_TIMES, $logFile=self::DEFAULT_LOG_FILE) {
        if (is_null($appKey) || is_null($masterSecret)) {
            throw new InvalidArgumentException("appKey and masterSecret must be set.");
        }

        if (!is_string($appKey) || !is_string($masterSecret)) {
            throw new InvalidArgumentException("Invalid appKey or masterSecret");
        }
        $this->appKey = $appKey;
        $this->masterSecret = $masterSecret;
        if (!is_null($retryTimes)) {
            $this->retryTimes = $retryTimes;
        }
        $this->logFile = $logFile;
    }

    public function push() {
        return new PushPayload($this);
    }


    /**
     * 发送HTTP请求
     * @param $url string 请求的URL
     * @param $method int 请求的方法
     * @param null $body String POST请求的Body
     * @param int $times 当前重试的册数
     * @return array
     * @throws APIConnectionException
     */
    public function _request($url, $method, $body=null, $times=1) {
        $this->log("Send " . $method . " " . $url . ", body:" . $body . ", times:" . $times);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        // 设置User-Agent
        curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);
        // 连接建立最长耗时
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::CONNECT_TIMEOUT);
        // 请求最长耗时
        curl_setopt($ch, CURLOPT_TIMEOUT, self::READ_TIMEOUT);
        // 设置SSL版本
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
        curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
        // 设置Basic认证
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->appKey . ":" . $this->masterSecret);
        // 设置Post参数
        if ($method === self::HTTP_POST) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }
        // 设置headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Connection: Keep-Alive'
        ));

        // 执行请求
        $output = curl_exec($ch);
        // 解析Response
        $response = array();
        $errorCode = curl_errno($ch);
        if ($errorCode) {
            if ($errorCode === 28) {
                throw new APIConnectionException("Response timeout. Your request has probably be received by JPush Server,please check that whether need to be pushed again.", true);
            } else if ($errorCode === 56) {
                // resolve error[56 Problem (2) in the Chunked-Encoded data]
                throw new APIConnectionException("Response timeout, maybe cause by old CURL version. Your request has probably be received by JPush Server, please check that whether need to be pushed again.", true);
            } else if ($times >= $this->retryTimes) {
                throw new APIConnectionException("Connect timeout. Please retry later. Error:" . $errorCode . " " . curl_error($ch));
            } else {
                $this->log("Send " . $method . " " . $url . " fail, curl_code:" . $errorCode . ", body:" . $body . ", times:" . $times);
                $this->_request($url, $method, $body, ++$times);
            }
        } else {
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header_text = substr($output, 0, $header_size);
            $body = substr($output, $header_size);
            $headers = array();
            foreach (explode("\r\n", $header_text) as $i => $line) {
                if ($i === 0) {
                    $headers['http_code'] = $line;
                } else {
                    list ($key, $value) = explode(': ', $line);
                    $headers[$key] = $value;
                }
            }
            $response['headers'] = $headers;
            $response['body'] = $body;
            $response['http_code'] = $httpCode;
        }
        curl_close($ch);
        return $response;
    }

    public function log($content) {
        if (!is_null($this->logFile)) {
            error_log($content . "\r\n", 3, $this->logFile);
        }
    }



}

