<?php
namespace JPush\Exceptions;

class APIConnectionException extends \Exception {

    public $isResponseTimeout;

    function __construct($message, $isResponseTimeout = false) {
        parent::__construct($message);
        $this->isResponseTimeout = $isResponseTimeout;
    }
}
