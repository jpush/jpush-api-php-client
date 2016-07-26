<?php
namespace JPush\Exceptions;

class APIConnectionException extends JPushException {

    function __toString() {
        return "\n" . __CLASS__ . " -- {$message} \n";
    }
}
