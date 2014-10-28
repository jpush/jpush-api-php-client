<?php

namespace JPush;

use Httpful\Request;
use Httpful\Exception\ConnectionErrorException;
use JPush\Exception\APIConnectionException;
use JPush\Model\PushPayload;
use JPush\Model\ReportResponse;
use JPush\Model\MessageResponse;
use JPush\Model\UserResponse;

use InvalidArgumentException;

class JPushClient {
    const PUSH_URL = 'https://api.jpush.cn/v3/push';
    const REPORT_URL = 'https://report.jpush.cn/v2/received';
    const VALIDATE_URL = 'https://api.jpush.cn/v3/push/validate';
    const MESSAGES_URL = 'https://report.jpush.cn/v3/messages';
    const USERS_URL = 'https://report.jpush.cn/v3/users';
    const USER_AGENT = 'JPush-API-PHP-Client';
    const CONNECT_TIMEOUT = 5;
    const READ_TIMEOUT = 30;
    const DEFAULT_MAX_RETRY_TIMES = 3;

    public $appKey;
    public $masterSecret;
    public $retryTimes;

    public function __construct($appKey, $masterSecret, $retryTimes=self::DEFAULT_MAX_RETRY_TIMES)
    {
        if (is_null($appKey) || is_null($masterSecret)) {
            throw new InvalidArgumentException("appKey and masterSecret must be set.");
        }

        if (!is_string($appKey) || !is_string($masterSecret)) {
            throw new InvalidArgumentException("Invalid appKey or masterSecret");
        }
        $this->appKey = $appKey;
        $this->masterSecret = $masterSecret;
        $this->retryTimes = $retryTimes;
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
        $response = $this->request($url, null, $header, 'GET');
        return new ReportResponse($response);
    }

    public function messages($msg_id) {
        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        $url = self::MESSAGES_URL . '?msg_ids=' . $msg_id;
        $response = $this->request($url, null, $header, 'GET');
        return new MessageResponse($response);
    }

    public function users($time_unit, $start, $duration) {
        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        $url = self::USERS_URL . '?time_unit=' . $time_unit . '&start=' . $start . '&duration=' . $duration;
        $response = $this->request($url, null, $header, 'GET');
        return new UserResponse($response);
    }



    public function sendPush($data) {
        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        return $this->request(self::PUSH_URL, $data, $header, 'POST');
    }

    public function sendValidate($data) {
        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        return $this->request(self::VALIDATE_URL, $data, $header, 'POST');
    }

    public function request($url, $data, $header, $method='POST') {
        $logger = JPushLog::getLogger();
        $logger->debug("Send " . $method, array(
            "method" => $method,
            "uri" => $url,
            "headers" => $header,
            "body" => $data));

        $request = null;
        if ($method === 'POST') {
            $request = Request::post($url);
        } else {
            $request = Request::get($url);
        }

        if (!is_null($data)) {
            $request->body($data);
        }

        $request->addHeaders($header)
            ->authenticateWith($this->appKey, $this->masterSecret)
            ->timeout(self::READ_TIMEOUT);

        $response = null;
        for ($retryTimes=0;;$retryTimes++) {
            try {
                $response = $request->send();
                break;
            } catch (ConnectionErrorException $e) {
                if (strpos($e->getMessage(),'28')) {
                    throw new APIConnectionException("Response timeout. Your request has probably be received by JPUsh Server,please check that whether need to be pushed again.", true);
                }
                if ($retryTimes >= $this->retryTimes) {
                    throw new APIConnectionException("Connect timeout. Please retry later.");
                } else {
                    $logger->debug("Retry again send " . $method, array(
                        "method" => $method,
                        "uri" => $url,
                        "headers" => $header,
                        "body" => $data,
                        "retryTimes" => $retryTimes + 1));
                }
            }
        }
        return $response;

    }







} 