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

use InvalidArgumentException;

class JPushClient {
    const PUSH_URL = 'https://api.jpush.cn/v3/push';
    const REPORT_URL = 'https://report.jpush.cn/v2/received';
    const USER_AGENT = 'JPush-API-PHP-Client';
    conST CONNECT_TIMEOUT = 5;

    public $appKey;
    public $masterSecret;

    public function __construct($appKey, $masterSecret)
    {
        if (is_null($appKey) || is_null($masterSecret)) {
            throw new InvalidArgumentException("appKey and masterSecret must be set.");
        }

        if (!is_string($appKey) || !is_string($masterSecret)) {
            throw new InvalidArgumentException("Invalid appKey or masterSecret");
        }
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

    public function sendPush($data) {
        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        return $this->sendPost(self::PUSH_URL, $data, $header);
    }

    public function sendGet($url, $data=null, $header) {
        $logger = JPushLog::getLogger();
        $logger->debug("Send Get", array(
            "method" => 'GET',
            "uri" => $url,
            "headers" => $header,
            "body" => $data));

        $request = Request::get($url)
            ->authenticateWith($this->appKey, $this->masterSecret)
            ->timeout(self::CONNECT_TIMEOUT)
            ->addHeaders($header);

        if (!is_null($data)) {
            $request->body($data);
        }
        return $request->send();
    }

    public function sendPost($url, $data, $header) {
        $logger = JPushLog::getLogger();
        $logger->debug("Send Post", array(
            "method" => 'POST',
            "uri" => $url,
            "headers" => $header,
            "body" => $data));

        $response = Request::post($url)
            ->authenticateWith($this->appKey, $this->masterSecret)
            ->body($data)
            ->addHeaders($header)
            ->timeout(self::CONNECT_TIMEOUT)
            ->send();
        return $response;
    }







} 