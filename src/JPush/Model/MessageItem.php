<?php
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-6-11
 * Time: 上午10:15
 */

namespace JPush\Model;


class MessageItem {
    public $msg_id;
    public $android;
    public $ios;

    private $expected_keys = array('received', 'target', 'online_push', 'click');


    function __construct($received)
    {
        foreach ($this->expected_keys as $key) {
            if (array_key_exists($key, $received)) {
                $this->$key = $received[$key];
            }
        }

        if (array_key_exists('msg_id', $received)) {
            $this->msg_id = $received['msg_id'];
        } else {
            $this->msg_id = null;
        }

        if (array_key_exists('android', $received)) {
            $this->android = new MessageAndroid($received['android']);
        } else {
            $this->android = null;
        }

        if (array_key_exists('ios', $received)) {
            $this->ios = new MessageIOS($received['ios']);
        }
    }


} 