<?php

class Options {
    public $sendno;
    public $time_to_live;
    public $override_msg_id;
    public $apns_production;
   

    public function toJSON() {
        $rs = array();
        if (is_null($this->sendno) === false) {
            $rs["sendno"] = $this->sendno;
        }
        if (is_null($this->time_to_live) === false) {
            $rs["time_to_live"] = $this->time_to_live;
        }
        if (is_null($this->override_msg_id) === false) {
            $rs["override_msg_id"] = $this->override_msg_id;
        }
        if (is_null($this->apns_production) === false) {
             $rs["apns_production"] = $this->apns_production;
        }
        return $rs;
    }

    
}
?>