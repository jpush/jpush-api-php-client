<?php
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-6-16
 * Time: 下午10:29
 */

namespace JPush\Exception;


class APIConnectionException extends \Exception {
    function __construct($message) {
        parent::__construct($message);
    }
}