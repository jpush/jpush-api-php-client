<?php

/**
 * 通知类
 */
class Notification {
    public $alert;
    public $ios;
    public $android;
    public $winphone;

    public function toJSON() {
        $rs = array();
        if (is_null($this->alert) === false) {
            $rs["alert"] = $this->alert;
        }
        if (is_null($this->ios) === false) {
            $rs["ios"] = $this->ios->toJSON();
        }
        if (is_null($this->android) === false) {
            $rs["android"] = $this->android->toJSON();
        }
        if (is_null($this->winphone) === false) {
            $rs["winphone"] = $this->winphone->toJSON();
        }
        return $rs;

    }



} 