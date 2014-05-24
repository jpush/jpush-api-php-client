<?php
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-5-23
 * Time: 上午10:24
 */

class IOSNotification {
    public $alert;
    public $sound;
    public $badge;
    public $extras;
    public $content_availabe;

    public function toJSON() {
        $rs = array();
        if (is_null($this->alert) === false) {
            $rs["alert"] = $this->alert;
        }
        if (is_null($this->sound) === false) {
            $rs["sound"] = $this->sound;
        }
        if (is_null($this->badge) === false) {
            $rs["badge"] = $this->badge;
        }
        if (is_null($this->extras) === false) {
            $rs["extras"] = $this->extras;
        }
        if (is_null($this->content_availabe) === false) {
            $rs["content-availabe"] = $this->content_availabe;
        }

        return $rs;
    }



} 