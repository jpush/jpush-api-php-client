<?php
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-6-11
 * Time: 上午9:23
 */

namespace JPush\Model;

use JPush\Exception\APIRequestException;

class PushResponse {
    public $isOk = false;
    public $sendno;
    public $msg_id;
    public $json;
    public $response;
    private $expected_keys = array('sendno', 'msg_id');

    function __construct($response)
    {
        if ($response->code !== 200) {
            throw APIRequestException::fromResponse($response);
        }
        $payload = json_decode($response->raw_body, true);

        foreach ($this->expected_keys as $key) {
            if (array_key_exists($key, $payload)) {
                $this->$key = $payload[$key];
            }
        }

        $this->json = $response->raw_body;
        $this->response = $response;
        $this->isOk = true;
    }
} 