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
        if (is_null($this->tag) === false && strlen(trim($this->tag)) > 0) {
            $rs["tag"] = explode(',',$this->tag);
        }
        if (is_null($this->tag_and) === false && strlen(trim($this->tag_and)) > 0) {
            $rs["tag_and"] = explode(',',$this->tag_and);
        }
        if (is_null($this->alias) === false && strlen(trim($this->alias)) > 0) {
            $rs["alias"] = explode(',',$this->alias);
        }
        if (is_null($this->registration_id) === false && strlen(trim($this->registration_id)) > 0) {
            $rs["registration_id"] = explode(',',$this->registration_id);
        }
        return $rs;
    }

    
}
?>