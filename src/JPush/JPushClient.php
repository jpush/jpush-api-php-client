<?php
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-6-9
 * Time: 下午1:49
 */

namespace JPush;

use Httpful\Request;
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
        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        $url = self::REPORT_URL . '?msg_ids=' . $msg_id;
        $response = $this->sendGet($url, null, $header);
        return new ReportResponse($response);
    }


    public function buildAutoCode() {
        return 'Authorization: Basic ' . base64_encode($this->appKey . ':' . $this->masterSecret);
    }

    public function buildUserAgent() {
        return 'User-Agent: ' . self::USER_AGENT;
    }


    public function sendPush($data) {
        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        return $this->sendPost(self::PUSH_URL, $data, $header);
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

    public function sendGet($url, $data=null, $header) {
        $request = Request::get($url)
            ->authenticateWith($this->appKey, $this->masterSecret)
            ->addHeaders($header);
        if (!is_null($data)) {
            $request->body($data);
        }
        return $request->send();
    }

    public function sendPost($url, $data, $header) {
        $response = Request::post($url)
            ->authenticateWith($this->appKey, $this->masterSecret)
            ->body($data)
            ->addHeaders($header)
            ->send();
        return $response;
    }







} 