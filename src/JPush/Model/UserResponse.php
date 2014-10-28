<?php

namespace JPush\Model;

use JPush\Exception\APIRequestException;

class UserResponse {
    public $isOk = false;
    public $json;
    public $response;

    function __construct($response)
    {
        if ($response->code !== 200) {
            throw APIRequestException::fromResponse($response);
        }

        $payload = json_decode($response->raw_body, true);
        $this->process($payload);
        $this->json = $response->raw_body;
        $this->response = $response;
        $this->isOk = true;
    }

    public $time_unit;
    public $start;
    public $duration;
    public $items;

    private $response_keys = array('time_unit', 'start', 'duration', 'items');
    private $item_keys = array('time', 'android', 'ios');
    private $android_keys = array('new', 'online', 'active');
    private $ios_keys = array('new', 'active');

    private function process($resData) {
        foreach($this->response_keys as $key) {
            if (array_key_exists($key, $resData)) {
                if ($key == 'items') {
                    $this->$key = $this->processItem($resData[$key]);
                } else {
                    $this->$key = $resData[$key];
                }
            }
        }
    }


    private function processAndroid($androidDate) {
        $android = array();
        foreach ($this->android_keys as $key) {
            if (array_key_exists($key, $androidDate)) {
                $android[$key] = $androidDate[$key];
            }
        }
        return $android;
    }

    private function processIos($iosDate) {
        $ios = array();

        foreach ($this->ios_keys as $key) {
            if (array_key_exists($key, $iosDate)) {
                $ios[$key] = $iosDate[$key];
            }
        }
        return $ios;
    }

    private function processItem($item_arr) {
        $items = array();
        foreach ($item_arr as $item) {
            $_item = array();
            foreach ($this->item_keys as $key) {
                if (array_key_exists($key, $item)) {
                    if ($key == 'android') {
                        $_item['android'] = $this->processAndroid($item[$key]);
                    } else if ($key == 'ios') {
                        $_item['ios'] = $this->processIos($item[$key]);
                    } else if ($key == 'time'){
                        $_item['time'] = $item['time'];
                    }

                }
            }
            array_push($items, $_item);
        }

        return $items;
    }
} 