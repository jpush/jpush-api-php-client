<?php
/**
 * 参数构建器
 * @author xiezefan@126.com
 *
 */
class ParamsBuilder {

    public function validatePayload($payload, $result) {
        $platform = $payload->platform;
        $audience = $payload->audience;
        $notification = $payload->notification;
        $message = $payload->message;
        $options = $payload->options;

        if (is_null($platform) === false) {
            if ($this->validatePlatform($platform, $result) === false) {
                return false;
            }
        }
        if (is_null($audience) === false) {
            if ($this->validateAudience($audience, $result) === false) {
                return false;
            }
        }
        if (is_null($notification) === false) {
            if ($this->validateNotificationParams($notification, $result) === false) {
                return false;
            }
        }
        if (is_null($message) === false) {
            if ($this->validateMessageParams($message, $result) === false) {
                return false;
            }
        }
        if (is_null($options) === false) {
            if ($this->validateOptions($options, $result) === false) {
                return false;
            }
        }
        return true;

    }

    //验证Message
    public function validateMessageParams($msg, $result) {
        if (is_null($msg->msg_content)  == false && is_string($msg->msg_content) == false) {
            $result->init(1003,"Parameters 'message->msg_content' must be a string");
            return false;
        }
        if (is_null($msg->extras)  == false && is_array($msg->extras) == false) {
            $result->init(1003,"Parameters 'message->extras' must be a array");
            return false;
        }
        if (is_null($msg->title)  == false && is_string($msg->title) == false) {
            $result->init(1003,"Parameters 'message->title' must be a string");
            return false;
        }
        if (is_null($msg->content_type)  == false && is_string($msg->content_type) == false) {
            $result->init(1003,"Parameters 'message->content_type' must be a string");
            return false;
        }
        return true;
    }

    //验证Notification参数合法性
    public function validateNotificationParams($msg, $result) {
        $ios = $msg->ios;
        $android = $msg->android;
        $winphone = $msg->winphone;
        if (is_string($msg->alert) == false) {
            $result->init(1003,"Parameters 'notification->alert' must be a string");
            return false;
        }
        if (is_null($ios) === false) {
            if (is_null($ios->extras)  == false && is_array($ios->extras) == false) {
                $result->init(1003,"Parameters 'iosnotification->extras' must be a array");
                return false;
            }
            if (is_null($ios->sound)  == false && is_string($ios->sound) == false) {
                $result->init(1003,"Parameters 'iosnotification->sound' must be a string");
                return false;
            }
            if (is_null($ios->badge)  == false && is_int($ios->badge) == false) {
                $result->init(1003,"Parameters 'iosnotification->badge' must be a int");
                return false;
            }
            if (is_null($ios->content_available)  == false && $ios->content_available !== 1) {
                $result->init(1003,"Parameters 'iosnotification->content_available' must be int(1)");
                return false;
            }
            if (is_null($ios->alert)  == false && is_string($ios->alert) == false) {
                $result->init(1003,"Parameters 'iosnotification->alert' must be a string");
                return false;
            }
        }
        if (is_null($android) === false) {
            if (is_null($android->extras)  == false && is_array($android->extras) == false) {
                $result->init(1003,"Parameters 'androidnotification->extras' must be a array");
                return false;
            }
            if (is_null($android->builder_id)  == false && is_int($android->builder_id) == false) {
                $result->init(1003,"Parameters 'androidnotification->builder_id' must be a string");
                return false;
            }
            if (is_null($android->title)  == false && is_string($android->title) == false) {
                $result->init(1003,"Parameters 'androidnotification-title' must be a string");
                return false;
            }
            if (is_null($android->alert)  == false && is_string($android->alert) == false) {
                $result->init(1003,"Parameters 'androidnotification->alert' must be a string");
                return false;
            }
        }
        if (is_null($winphone) === false) {
            if (is_null($winphone->extras) == false && is_array($winphone->extras) == false) {
                $result->init(1003,"Parameters 'winphonenotification->extras' must be a array");
                return false;
            }
            if (is_null($winphone->_open_page)  == false && is_string($winphone->_open_page) == false) {
                $result->init(1003,"Parameters 'winphonenotification->_open_page' must be a string");
                return false;
            }
            if (is_null($winphone->title)  == false && is_string($winphone->title) == false) {
                $result->init(1003,"Parameters 'winphonenotification-title' must be a string");
                return false;
            }
            if (is_null($winphone->alert)  == false && is_string($winphone->alert) == false) {
                $result->init(1003,"Parameters 'winphonenotification->alert' must be a string");
                return false;
            }

        }
        return true;
    }

    //验证Notification参数合法性
    public function validatePlatform($platform, $result) {
        if (is_bool($platform->ios) === false) {
            $result->init(1003,"Parameters 'platform->ios' must be bool");
            return false;
        }
        if (is_bool($platform->winphone) === false) {
            $result->init(1003,"Parameters 'platform->winphone' must be bool");
            return false;
        }
        if (is_bool($platform->android) === false) {
            $result->init(1003,"Parameters 'platform->android' must be bool");
            return false;
        }
        return true;
    }

    //验证Audience参数合法性
    public function validateAudience($audience, $result) {
        // validate audience
        if (is_null($audience->tag) == false && is_string($audience->tag) == false) {
            $result->init(1003,"Parameters 'audience->tag' must be a string");
            return false;
        }
        if (is_null($audience->tag_and) == false && is_string($audience->tag_and) == false) {
            $result->init(1003,"Parameters 'audience->tag_and' must be a string");
            return false;
        }
        if (is_null($audience->alias) == false && is_string($audience->alias) == false) {
            $result->init(1003,"Parameters 'audience->alias' must be a string");
            return false;
        }
        if (is_null($audience->registration_id) == false && is_string($audience->registration_id) == false) {
            $result->init(1003,"Parameters 'audience->registration_id' must be a string");
            return false;
        }
        return true;
    }

    //验证Options参数合法性
    public function validateOptions($options, $result) {
        // validate options params
        if (is_null($options->time_to_live) == false && (is_int($options->time_to_live) === false || $options->time_to_live < 0 || $options->time_to_live > 864000)) {
            $result->init(1003,"Parameters 'options->timeToLive' must be a int and in [0, 864000]");
            return false;
        }
        if (is_null($options->time_to_live) == false && is_bool($options->apns_production) === false) {
            $result->init(1003,"Parameters 'options->apnsProduction' must be bool");
            return false;
        }
        if (is_null($options->sendno) == false && is_int($options->sendno) === false) {
            $result->init(1003,"Parameters 'options->sendno' must be a int");
            return false;
        }
        if (is_null($options->override_msg_id) == false && is_string($options->override_msg_id) === false) {
            $result->init(1003,"Parameters 'options->override_msg_id' must be a string");
            return false;
        }
        return true;
    }


    //构建验证字符串
    public function buildAutoCode($appKey, $masterSecret) {
        return base64_encode($appKey . ':' . $masterSecret);;
    }

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

    public function validateReceiveParams($msg_ids, $result) {
        if (is_string($msg_ids) === false) {
            $result->init(1003, "Parameters 'msg_ids' must be a string");
            return false;
        }
        return true;
    }




}

?>