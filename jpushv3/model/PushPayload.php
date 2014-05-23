<?php

class PushPayload {
    public $platform;
    public $audience;
    public $notification;
    public $message;
    public $options;

    public function toJSON() {
        $rs = array();
        if (is_null($this->platform) === false) {
            $rs["platform"] = $this->platform->toJSON();
        } else {
            $rs["platform"] = "all";
        }
        if (is_null($this->audience) === false) {
            $rs["audience"] = $this->audience->toJSON();
        } else {
            $rs["audience"] = "all";
        }
        if (is_null($this->notification) === false) {
            $rs["notification"] = $this->notification->toJSON();
        }
        if (is_null($this->message) === false) {
            $rs["message"] = $this->message->toJSON();
        }
        if (is_null($this->options) === false) {
            $rs["options"] = $this->options->toJSON();
        }
        return $rs;

    }

}
?>