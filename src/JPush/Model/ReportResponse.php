<?php

namespace JPush\Model;


class ReportResponse {
    public $ok = true;
    public $payload;
    public $response;
    public $received_list;
    public $error;

    function __construct($response)
    {
        if ($response['code'] !== 200) {
            $this->ok = false;
            $this->response = $response;
            $this->error = new Error($response);
            return;
        }
        $payload = json_decode($response['body'], true);
        $received_list = array();
        foreach($payload as $received) {
            array_push($received_list, new Report($received));
        }

        $this->received_list = $received_list;
        $this->payload = $payload;
        $this->response = $response;
    }


} 