<?php
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-6-11
 * Time: 上午10:15
 */

namespace JPush\Model;


class MessageIOS {
    public $apns_send;
    public $apns_target;
    public $click;

    private $expected_keys = array('apns_sent', 'apns_target', 'click');

    function __construct($received)
    {
        foreach ($this->expected_keys as $key) {
            if (array_key_exists($key, $received)) {
                $this->$key = $received[$key];
            }
        }
    }


} 