<?php
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-6-11
 * Time: 上午10:15
 */

namespace JPush\Model;


class MessageAndroid {
    public $received;
    public $target;
    public $online_push;
    public $click;

    private $expected_keys = array('received', 'target', 'online_push', 'click');


    function __construct($received)
    {
        foreach ($this->expected_keys as $key) {
            if (array_key_exists($key, $received)) {
                $this->$key = $received[$key];
            }
        }
    }


} 