<?php

class Audience {
    public $tag;
    public $tag_and;
    public $alias;
    public $registration_id;

    public function toJSON() {
        if (is_null($this->tag) === true && is_null($this->tag_and) === true && is_null($this->alias) === true && is_null($this->registration_id) === true) {
            return "all";
        }
        $rs = array();
        if (is_null($this->tag) === false) {
            $rs["tag"] = explode(',',$this->tag);
        }
        if (is_null($this->tag_and) === false) {
            $rs["tag_and"] = explode(',',$this->tag_and);
        }
        if (is_null($this->alias) === false) {
            $rs["alias"] = explode(',',$this->alias);
        }
        if (is_null($this->registration_id) === false) {
            $rs["registration_is"] = explode(',',$this->registration_id);
        }
        return $rs;
    }

    
}
?>