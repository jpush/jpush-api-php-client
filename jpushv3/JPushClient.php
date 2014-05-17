<?php
include_once 'PushResult.php';
include_once 'PushClient.php';
/**
 * Jpush客户端
 * @author xiezefan@126.com
 * 
 */
class JPushClient { 
    //初始化参数
    private $appKey;
    private $masterSecret;
    private $autoCode;

    /**
    * 构造函数
    * @param String $appKey
    * @param String $masterSecret
    */
    public function __construct($app_key, $masterSecret) {
        $this->appKey = $app_key;
        $this->masterSecret = $masterSecret;
        $this ->autoCode = base64_encode($app_key . ':' . $masterSecret);

    }

    /**
    *
    *
    **/
    public function send($msg) {
        $pushResult = new PushResult();

        if (method_exists($msg, 'getMsgType') == false) {
            $pushResult->setResult('1003', 'Only Notification and Message can be send');
            return $pushResult;
        }

        $msgType = $msg->getMsgType();
        if ($msgType === 'Notification') {
            return $this->sendNotification($msg, $pushResult);
        } else if ($msgType === 'Message') {
            return $this->sendMessage($msg, $pushResult);
        } else {
            $pushResult->setResult('1003', 'Only Notification and Message can be send');
            return $pushResult;
        }
    }


    private function sendNotification($msg, $pushResult) {
        $isValidate = $this->validateParams($msg, $pushResult);
        if ($isValidate == false) {
            return $pushResult;
        }
        $isValidate = $this->validateNotificationParams($msg, $pushResult);
        if ($isValidate == false) {
            return $pushResult;
        }

        $platform = $this->buildPlatform($msg);
        $audience = $this->buildAudience($msg);
        $notification = $this->buildNotification($msg);
        $options = $this->buildOptions($msg);

        $sendVO = array("platform"=>$platform,
                                        "audience"=>$audience,
                                        "notification"=>$notification,
                                        "options"=>$options);
        
        $pushClient = new PushClient();
        $result = $pushClient->send($sendVO, $this->autoCode);

var_dump($result);
        $pushResult->setResultStr($result);
        return $pushResult;
        
    }                  


    private function sendMessage($msg, $pushResult) {
        $isValidate = $this->validateParams($msg, $pushResult);
        if ($isValidate == false) {
            return $pushResult;
        }
        $isValidate = $this->validateMessageParams($msg, $pushResult);
        if ($isValidate == false) {
            return $pushResult;
        }

        $platform = $this->buildPlatform($msg);
        $audience = $this->buildAudience($msg);
        $options = $this->buildOptions($msg);
        $message = $this->buildMessage($msg);

        $sendVO = array("platform"=>$platform,
                                        "audience"=>$audience,
                                        "message"=>$message,
                                        "options"=>$options);
        
        $pushClient = new PushClient();
        $result = $pushClient->send($sendVO, $this->autoCode);

        $pushResult->setResultStr($result);
        return $pushResult;
    }



    private function buildAudience($msg) {
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

    private function buildPlatform($msg) {
        return $msg->platform === "all" ? "all" : explode(',',$msg->platform);
    }

    private function buildNotification($msg) {
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

    private function buildMessage($msg) {
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


    private function buildOptions($msg) {
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



    




    //验证参数合法性
    private function validateParams($msg, $msgResult) {
        // validate initparams
        if (is_string($this->appKey) === false) {
           $msgResult->setResult(1003,"Parameters 'app_key' must be a string");
            return false; 
        }
        if (is_string($this->masterSecret) === false) {
           $msgResult->setResult(1003,"Parameters 'masterSecret' must be a string");
            return false; 
        }

        // validate options params
        if (is_int($msg->time_to_live) === false || $msg->time_to_live < 0 || $msg->time_to_live > 864000) {
           $msgResult->setResult(1003,"Parameters 'timeToLive' must be a int and in [0, 864000]");
            return false; 
        }
        if (is_bool($msg->apns_production) === false) {
           $msgResult->setResult(1003,"Parameters 'apnsProduction' must be bool");
            return false; 
        }
        if (is_null($msg->sendno) == false && is_int($msg->sendno) === false) {
             $msgResult->setResult(1003,"Parameters 'sendno' must be a int");
            return false;
        }
        if (is_null($msg->override_msg_id) == false && is_string($msg->override_msg_id) === false) {
            $msgResult->setResult(1003,"Parameters 'override_msg_id' must be a string");
            return false;
        }

        // validate audience
        if (is_null($msg->tag) == false && is_string($msg->tag) == false) {
            $msgResult->setResult(1003,"Parameters 'tag' must be a string");
            return false;
        }
        if (is_null($msg->tag_and) == false && is_string($msg->tag_and) == false) {
            $msgResult->setResult(1003,"Parameters 'tag_and' must be a string");
            return false;
        }
        if (is_null($msg->alias) == false && is_string($msg->alias) == false) {
            $msgResult->setResult(1003,"Parameters 'alias' must be a string");
            return false;
        }
        if (is_null($msg->registration_id) == false && is_string($msg->registration_id) == false) {
            $msgResult->setResult(1003,"Parameters 'registration_id' must be a string");
            return false;
        }



        return true;
    }

    private function validateNotificationParams($msg, $msgResult) {
        if (is_string($msg->content) == false) {
             $msgResult->setResult(1003,"Parameters 'content' must be a string");
            return false;
        }
        if (is_null($msg->extras)  == false && is_array($msg->extras) == false) {
             $msgResult->setResult(1003,"Parameters 'extras' must be a array");
            return false;
        }
        if (is_null($msg->builder_id)  == false && is_int($msg->builder_id) == false) {
            $msgResult->setResult(1003,"Parameters 'builder_id' must be a string");
            return false;
        }
        if (is_null($msg->sound)  == false && is_string($msg->sound) == false) {
             $msgResult->setResult(1003,"Parameters 'sound' must be a string");
            return false;
        }
        if (is_null($msg->badge)  == false && is_int($msg->badge) == false) {
            $msgResult->setResult(1003,"Parameters 'badge' must be a int");
            return false;
        }
        if (is_null($msg->content_availabe)  == false && is_bool($msg->content_availabe) == false) {
            $msgResult->setResult(1003,"Parameters 'content_availabe' must be a bool");
            return false;
        }
        if (is_null($msg->_open_page)  == false && is_string($msg->_open_page) == false) {
            $msgResult->setResult(1003,"Parameters '_open_page' must be a string");
            return false;
        }
        if (is_null($msg->title)  == false && is_string($msg->title) == false) {
            $msgResult->setResult(1003,"Parameters 'title' must be a string");
            return false;
        }
        return true;
    }

    private function validateMessageParams($msg, $msgResult) {

       if (is_null($msg->extras)  == false && is_array($msg->extras) == false) {
             $msgResult->setResult(1003,"Parameters 'extras' must be a array");
            return false;
        }
        if (is_null($msg->title)  == false && is_string($msg->title) == false) {
            $msgResult->setResult(1003,"Parameters 'title' must be a string");
            return false;
        }
        if (is_null($msg->content_type)  == false && is_string($msg->content_type) == false) {
            $msgResult->setResult(1003,"Parameters 'content_type' must be a string");
            return false;
        }
        return true;
    }


}
?>