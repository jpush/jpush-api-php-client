<?php

/**
 * 通用通知类
 * @author xiezefan@126.com
 * 
 */
class Result { 
    private $code;
    private $message;

    public function __construct($code=200, $message="success") {
        $this->code = $code;
        $this->message = $message;
    }

    public function init($code, $message) {
        $this->code = $code;
        $this->message = $message;
    }

    public function __get($property_name) {
        if(isset($this->$property_name)) {
            return($this->$property_name);
        } else {
            return(NULL);
        }
    }

    public function __set($property_name, $value) {
        $this->$property_name = $value;
    }

    public function toJSON() {
        $arr = array("code"=>$this->code, "message"=>$this->message);
        return json_encode($arr);
    }

}
?>

