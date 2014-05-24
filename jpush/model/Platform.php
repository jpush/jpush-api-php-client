<?php

class Platform {
    public $android = false;
    public $ios= false;
    public $winphone= false;

    public function toJSON() {
        if ($this->android === false && $this->ios === false && $this->winphone === false) {
            return "all";
        } else {
            $rs = array();
            if ($this->android === true) {
                array_push($rs, "android");
            } 
            if ($this->ios === true) {
                array_push($rs, "ios");
            }  
            if ($this->winphone === true) {
                array_push($rs, "winphone");
            }
            return $rs;
        }
    }


    
}
?>