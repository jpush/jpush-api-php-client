<?php
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-6-9
 * Time: 下午1:49
 */

namespace JPush;

use JPush\Model\PushPayload;
use JPush\Model\ReportResponse;

class JPushClient {
    const PUSH_URL = 'https://api.jpush.cn/v3/push';
    const REPORT_URL = 'https://report.jpush.cn/v2/received';
    const USER_AGENT = 'JPush-API-PHP-Client';

    public $appKey;
    public $masterSecret;

    public function __construct($appKey, $masterSecret)
    {
        $this->appKey = $appKey;
        $this->masterSecret = $masterSecret;
    }

    public function push() {
        return new PushPayload($this);
    }

    public function report($msg_id) {
        $autoCode = $this->buildAutoCode();
        $userAgent = $this->buildUserAgent();
        $header = array($autoCode, $userAgent, 'Content-type: application/json');
        $url = self::REPORT_URL . '?msg_ids=' . $msg_id;
        $response = $this->request($url, null, $header, 'GET');
        return new ReportResponse($response);
    }


    public function buildAutoCode() {
        return 'Authorization: Basic ' . base64_encode($this->appKey . ':' . $this->masterSecret);
    }

    public function buildUserAgent() {
        return 'User-Agent: ' . self::USER_AGENT;
    }


    public function sendPush($data) {
        $autoCode = $this->buildAutoCode();
        $userAgent = $this->buildUserAgent();
        $header = array($autoCode, $userAgent, 'Content-type: application/json');

        return $this->request(self::PUSH_URL, $data, $header, 'POST');
    }


    public function request($url, $data, $header, $method = 'POST') {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        if ($method === 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        $body = curl_exec($curl);
        $httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        if (curl_errno($curl)) {
            $errnoMsg = 'Curl error: '.curl_error($curl);
            error_log($errnoMsg);
        }
        curl_close($curl);
        return array('code' => $httpCode, 'body' => $body);
    }





} 