<?php

namespace JPush\Model;

use JPush\Exception\APIRequestException;

class DeviceResponse {
    public $isOk = false;
    public $json;
    public $response;
    public $body;

    function __construct($response)
    {
        if ($response->code !== 200) {
            throw APIRequestException::fromResponse($response);
        }

        if ($response->raw_body) {
            $this->body = json_decode($response->raw_body, true);
        } else {
            $this->body = null;
        }
        $this->json = $response->raw_body;
        $this->response = $response;
        $this->isOk = true;
    }


}