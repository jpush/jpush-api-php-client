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

    function __construct($received)
    {
        $this->android_received = $received['android_received'];
        $this->ios_apns_sent = $received['ios_apns_sent'];
        $this->msg_id = $received['msg_id'];
    }


} 