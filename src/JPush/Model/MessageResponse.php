<?php

namespace JPush\Model;

use JPush\Exception\APIRequestException;

class MessageResponse {
    public $isOk = false;
    public $json;
    public $response;
    public $received_list;

    function __construct($response)
    {
        if ($response->code !== 200) {
            throw APIRequestException::fromResponse($response);
        }
        $payload = json_decode($response->raw_body, true);
        $received_list = array();
        foreach($payload as $received) {
            array_push($received_list, new MessageItem($received));
        }

        $this->received_list = $received_list;
        $this->json = $response->raw_body;
        $this->response = $response;
        $this->isOk = true;
    }


} 