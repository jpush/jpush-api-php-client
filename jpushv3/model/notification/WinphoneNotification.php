<?php
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-5-23
 * Time: 上午10:24
 */

class WinphoneNotification {
    public $alert;
    public $title;
    public $_open_page;
    public $extras;

    public function toJSON() {
        $rs = array();
        if (is_null($this->alert) === false) {
            $rs["alert"] = $this->alert;
        }
        if (is_null($this->title) === false) {
            $rs["title"] = $this->title;
        }
        if (is_null($this->_open_page) === false) {
            $rs["_open_page"] = $this->_open_page;
        }
        if (is_null($this->extras) === false) {
            $rs["extras"] = $this->extras;
        }
        return $rs;
    }




} 