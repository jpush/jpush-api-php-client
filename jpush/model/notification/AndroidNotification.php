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
        if (is_null($this->alert) === false && strlen(trim($this->alert)) > 0) {
            $rs["alert"] = $this->alert;
        }
        if (is_null($this->title) === false && strlen(trim($this->title)) > 0) {
            $rs["title"] = $this->title;
        }
        if (is_null($this->builder_id) === false) {
            $rs["builder_id"] = $this->builder_id;
        }
        if (is_null($this->extras) === false) {
            $rs["extras"] = $this->extras;
        }
        return $rs;
    }



} 