<?php
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-6-11
 * Time: 下午2:04
 */

namespace JPush\Model;


class Error {
    public $code;
    public $message;

    private $expected_keys = array('code', 'message');

    function __construct($response)
    {
        $payload = json_decode($response['body'], true);
        $error = $payload['error'];
        foreach ($this->expected_keys as $key) {
            if (array_key_exists($key, $error)) {
                $this->$key = $error[$key];
            }
        }
    }


} 