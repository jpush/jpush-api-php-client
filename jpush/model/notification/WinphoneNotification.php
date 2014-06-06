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
        if (is_null($this->alert) === false && strlen(trim($this->alert)) > 0) {
            $rs["alert"] = $this->alert;
        }
        if (is_null($this->title) === false && strlen(trim($this->title)) > 0) {
            $rs["title"] = $this->title;
        }
        if (is_null($this->_open_page) === false && strlen(trim($this->_open_page)) > 0) {
            $rs["_open_page"] = $this->_open_page;
        }
        if (is_null($this->extras) === false) {
            $rs["extras"] = $this->extras;
        }
        return $rs;
    }




} 