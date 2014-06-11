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

    private $expected_keys = array('sendno', 'msg_id');

    function __construct($response) {
        $payload = json_decode($response, true);

        foreach ($this->expected_keys as $key) {
            if (array_key_exists($key, $payload)) {
                $this->$key = $payload[$key];
            } else {
                $this->ok = false;
                $this->response = $response;
                return;
            }
        }

        $this->payload = $payload;
        $this->response = $response;
    }
} 