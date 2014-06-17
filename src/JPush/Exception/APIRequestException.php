<?php
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-6-16
 * Time: 下午10:30
 */

namespace JPush\Exception;


class APIRequestException extends \Exception {
    public $httpCode;
    public $code;
    public $message;
    public $json;

    public $rateLimitLimit;
    public $rateLimitRemaining;
    public $rateLimitReset;

    public $response;

    private static $expected_keys = array('code', 'message');
    public static function fromResponse($response) {
        $exc = new APIRequestException();
        $payload = json_decode($response->raw_body, true);
        if ($payload != null) {
            $error = $payload['error'];
            foreach (self::$expected_keys as $key) {
                if (array_key_exists($key, $error)) {
                    $exc->$key = $error[$key];
                }
            }
        }
        $exc->json = $response->raw_body;
        $exc->response = $response->raw_body;
        $exc->httpCode = $response->code;
        $headers = $response->headers;
        if (!is_null($headers)) {
            $exc->rateLimitLimit = $headers['x-rate-limit-limit'];
            $exc->rateLimitRemaining = $headers['x-rate-limit-remaining'];
            $exc->rateLimitReset = $headers['x-rate-limit-reset'];
        }

        return $exc;
    }

} 