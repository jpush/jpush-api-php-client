<?php
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-6-11
 * Time: 上午9:23
 */

namespace JPush\Model;


class PushResponse {
    public $sendno;
    public $msg_id;
    public $payload;
    public $response;
    public $ok = true;
    public $error;

    private $expected_keys = array('sendno', 'msg_id');

    function __construct($response)
    {
        if ($response['code'] !== 200) {
            $this->ok = false;
            $this->response = $response;
            $this->error = new Error($response);
            return;
        }
        $payload = json_decode($response['body'], true);

        foreach ($this->expected_keys as $key) {
            if (array_key_exists($key, $payload)) {
                $this->$key = $payload[$key];
            }
        }

        $this->payload = $payload;
        $this->response = $response;
    }
} 