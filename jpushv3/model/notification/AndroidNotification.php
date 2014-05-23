<?php
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-5-23
 * Time: 上午10:23
 */

class AndroidNotification {
    public $alert;
    public $title;
    public $builder_id;
    public $extras;

    public function toJSON() {
        $rs = array();
        if (is_null($this->alert) === false) {
            $rs["alert"] = $this->alert;
        }
        if (is_null($this->title) === false) {
            $rs["title"] = $this->title;
        }
        if (is_null($this->alert) === false) {
            $rs["builder_id"] = $this->builder_id;
        }
        if (is_null($this->alert) === false) {
            $rs["extras"] = $this->extras;
        }
        return $rs;
    }



} 