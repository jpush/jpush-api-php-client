<?php
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-5-23
 * Time: 下午3:56
 */

class ParamsVerifier {

    public function vaildateAutoCode($appkey, $masterSecret, $result) {
        // validate initparams
        if (is_string($appkey) === false) {
            $result->init(1003, "Parameters 'app_key' must be a string");
            return false;
        }
        if (is_string($masterSecret) === false) {
            $result->init(1003, "Parameters 'masterSecret' must be a string");
            return false;
        }
        return true;
    }

    public function validateAutoCpde() {

    }
    public function validatePayload() {

    }

} 