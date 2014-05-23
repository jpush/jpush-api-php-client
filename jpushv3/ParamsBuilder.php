<?php
/**
 * 参数构建器
 * @author xiezefan@126.com
 *
 */
class ParamsBuilder {

    //构建验证字符串
    public function buildAutoCode($appKey, $masterSecret) {
        return base64_encode($appKey . ':' . $masterSecret);;
    }


    //构建Audience
    public function buildAudience($msg) {
        $audience = "all";
        if ($msg->sendToAll == false) {
            $audience = array();
            if (is_null($msg->tag) == false) {
                $audience["tag"] = explode(',',$msg->tag);
            }
            if (is_null($msg->tag_and) == false) {
                $audience["tag_and"] = explode(',',$msg->tag_and);
            }
            if (is_null($msg->alias) == false) {
               $audience["alias"] = explode(',',$msg->alias);
            }
            if (is_null($msg->registration_id) == false) {
                $audience["registration_id"] = explode(',',$msg->registration_id);
            }
        }
        return $audience;
    }

    //构建Platform
    public function buildPlatform($msg) {
        return $msg->platform === "all" ? "all" : explode(',',$msg->platform);
    }

    //构建Notification
    public function buildNotification($msg) {
        $notification = array("alert"=>$msg->content);
        if ($msg->onlyContent == false) {
            $android= array("alert"=>$msg->content);
            $ios = array("alert"=>$msg->content);
            $winphone = array("alert"=>$msg->content);
            if (is_null($msg->extras) == false) {
                $android["extras"] = $msg->extras;
                $ios["extras"] = $msg->extras;
                $winphone["extras"] = $msg->extras;
            }
            if (is_null($msg->builder_id) == false) {
                $android["builder_id"] = $msg->builder_id;
            }
            if (is_null($msg->sound) == false) {
                $ios["sound"] = $msg->sound;
            }
            if (is_null($msg->badge) == false) {
                $ios["badge"] = $msg->badge;
            }
            if (is_null($msg->content_availabe) == false) {
                $ios["content-availabe"] = $msg->content_availabe ? 1 : 0;
            }
            if (is_null($msg->_open_page) == false) {
                $winphone["_open_page"] = $msg->_open_page;
            }
            if (is_null($msg->title) == false) {
                $android["title"] = $msg->title;
                $ios["title"] = $msg->title;
                $winphone["title"] = $msg->title;
            }

            $notification["android"] = $android;
            $notification["ios"] = $ios;
            $notification["winphone"] = $winphone;
        }
        return $notification;
    }

    //构建Message
    public function buildMessage($msg) {
        $message = array("msg_content"=> $msg->content);
        if (is_null($msg->title) == false) {
            $message["title"] = $msg->title;
        }
        if (is_null($msg->extras) == false) {
            $message["extras"] = $msg->extras;
        }
        if (is_null($msg->content_type) == false) {
            $message["content_type"] = $msg->content_type;
        }
        return $message;
    }

    //构建Options
    public function buildOptions($msg) {
        $options = array("time_to_live"=>$msg->time_to_live,
            "apns_production"=>$msg->apns_production);
        if (is_null($msg->sendno) == false) {
            $options["sendno"] = $msg->sendno;
        }
        if ($msg->overrideEnable) {
            $options["override_msg_id"] = $msg->override_msg_id;
        }
        return $options;
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

    public function validatePayload($payload, $result) {
        if (is_null($payload->platform) === false) {
            //TODO something
        }

    }

    public function validateReceiveParams($msg_ids, $result) {
        if (is_string($msg_ids) === false) {
            $result->init(1003, "Parameters 'msg_ids' must be a string");
            return false;
        }
        return true;
    }

    //验证参数合法性
    public function validateParams($msg, $result) {
        

        // validate options params
        if (is_int($msg->time_to_live) === false || $msg->time_to_live < 0 || $msg->time_to_live > 864000) {
           $result->init(1003,"Parameters 'timeToLive' must be a int and in [0, 864000]");
            return false; 
        }
        if (is_bool($msg->apns_production) === false) {
           $result->init(1003,"Parameters 'apnsProduction' must be bool");
            return false; 
        }
        if (is_null($msg->sendno) == false && is_int($msg->sendno) === false) {
             $result->init(1003,"Parameters 'sendno' must be a int");
            return false;
        }
        if (is_null($msg->override_msg_id) == false && is_string($msg->override_msg_id) === false) {
            $result->init(1003,"Parameters 'override_msg_id' must be a string");
            return false;
        }

        // validate audience
        if (is_null($msg->tag) == false && is_string($msg->tag) == false) {
            $result->init(1003,"Parameters 'tag' must be a string");
            return false;
        }
        if (is_null($msg->tag_and) == false && is_string($msg->tag_and) == false) {
            $result->init(1003,"Parameters 'tag_and' must be a string");
            return false;
        }
        if (is_null($msg->alias) == false && is_string($msg->alias) == false) {
            $result->init(1003,"Parameters 'alias' must be a string");
            return false;
        }
        if (is_null($msg->registration_id) == false && is_string($msg->registration_id) == false) {
            $result->init(1003,"Parameters 'registration_id' must be a string");
            return false;
        }
        return true;
    }

    //验证Notification参数合法性
    public function validateNotificationParams($msg, $result) {
        if (is_string($msg->content) == false) {
             $result->init(1003,"Parameters 'content' must be a string");
            return false;
        }
        if (is_null($msg->extras)  == false && is_array($msg->extras) == false) {
             $result->init(1003,"Parameters 'extras' must be a array");
            return false;
        }
        if (is_null($msg->builder_id)  == false && is_int($msg->builder_id) == false) {
            $result->init(1003,"Parameters 'builder_id' must be a string");
            return false;
        }
        if (is_null($msg->sound)  == false && is_string($msg->sound) == false) {
             $result->init(1003,"Parameters 'sound' must be a string");
            return false;
        }
        if (is_null($msg->badge)  == false && is_int($msg->badge) == false) {
            $result->init(1003,"Parameters 'badge' must be a int");
            return false;
        }
        if (is_null($msg->content_availabe)  == false && is_bool($msg->content_availabe) == false) {
            $result->init(1003,"Parameters 'content_availabe' must be a bool");
            return false;
        }
        if (is_null($msg->_open_page)  == false && is_string($msg->_open_page) == false) {
            $result->init(1003,"Parameters '_open_page' must be a string");
            return false;
        }
        if (is_null($msg->title)  == false && is_string($msg->title) == false) {
            $result->init(1003,"Parameters 'title' must be a string");
            return false;
        }
        return true;
    }

    //构建Message
    public function validateMessageParams($msg, $result) {
        if (is_null($msg->content)  == false && is_string($msg->content) == false) {
            $result->init(1003,"Parameters 'content' must be a string");
            return false;
        }
       if (is_null($msg->extras)  == false && is_array($msg->extras) == false) {
             $result->init(1003,"Parameters 'extras' must be a array");
            return false;
        }
        if (is_null($msg->title)  == false && is_string($msg->title) == false) {
            $result->init(1003,"Parameters 'title' must be a string");
            return false;
        }
        if (is_null($msg->content_type)  == false && is_string($msg->content_type) == false) {
            $result->init(1003,"Parameters 'content_type' must be a string");
            return false;
        }
        return true;
    }


}

?>