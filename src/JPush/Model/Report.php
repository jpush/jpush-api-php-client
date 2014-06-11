<?php
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-6-11
 * Time: 上午10:15
 */

namespace JPush\Model;


class Report {
    public $android_received;
    public $ios_apns_sent;
    public $msg_id;

    private $expected_keys = array('android_received', 'ios_apns_sent', 'msg_id');


    function __construct($received)
    {
        foreach ($this->expected_keys as $key) {
            if (array_key_exists($key, $received)) {
                $this->$key = $received[$key];
            }
        }
    }


} 