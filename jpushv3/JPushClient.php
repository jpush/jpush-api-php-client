<?php
include_once 'Result.php';
include_once 'ParamsBuilder.php';
include_once 'PushClient.php';
include_once 'ReportClient.php';

/**
 * Jpush客户端
 * @author xiezefan@126.com
 * 
 */
class JPushClient { 
    //初始化参数
    private $appKey;
    private $masterSecret;

    private $pushClient;
    private $paramsBuilder;

    /**
     * 构造函数
     * @param $app_key
     * @param $masterSecret
     */
    public function __construct($app_key, $masterSecret) {
        $this->appKey = $app_key;
        $this->masterSecret = $masterSecret;

        $this->pushClient = new PushClient();
        $this->paramsBuilder = new ParamsBuilder();
    }

    /**
     * 发送通知或自定义信息
     * @param $payload
     * @return string
     */
    public function sendPush($payload) {
        $result = new Result();
        $autoCode = $this->paramsBuilder->buildAutoCode($this->appKey, $this->masterSecret, $result);

        return $this->pushClient->sendPush($payload, $autoCode);
    }

    /**
     * 获取统计信息
     * @param String $msg_ids  msg_id以，连接
     * @return Json对象
     */
    public function getReport($msg_ids) {
        $result = new Result();
        $paramsBuilder = new ParamsBuilder();

        $isValidate = $paramsBuilder->vaildateAutoCode($this->appKey, $this->masterSecret, $result);
        if ($isValidate === false) {
            return $result->getJSON();
        }
        $isValidate = $paramsBuilder->validateReceiveParams($msg_ids, $result);
        if ($isValidate === false) {
            return $result->getJSON();
        }

        $reportClient = new ReportClient();
        $autoCode = $paramsBuilder->buildAutoCode($this->appKey, $this->masterSecret, $result);
        return $reportClient->send($msg_ids, $autoCode);
    }

    /**
    * 发送通知或自定义信息
    * @param Notification & Message $msg  消息对象
    *
    * @return Json对象
    */
    /*
    public function send($msg) {
        $result = new Result();

        if (method_exists($msg, 'getMsgType') == false) {
            $result->init(1003, 'Only Notification and Message can be send');
            return $pushResult;
        }

        $msgType = $msg->getMsgType();
        if ($msgType === 'Notification') {
            return $this->sendNotification($msg, $result);
        } else if ($msgType === 'Message') {
            return $this->sendMessage($msg, $result);
        } else {
            $result->init(1003, 'Only Notification and Message can be send');
            return $pushResult;
        }
    }
    */



    /*
    //发送通知
    private function sendNotification($msg, $result) {
        $paramsBuilder = new ParamsBuilder();
        $isValidate = $paramsBuilder->vaildateAutoCode($this->appKey, $this->masterSecret, $result);
        if ($isValidate == false) {
            return $result->getJSON();
        }
        $isValidate = $paramsBuilder->validateParams($msg, $result);
        if ($isValidate == false) {
            return $result->getJSON();
        }
        $isValidate = $paramsBuilder->validateNotificationParams($msg, $result);
        if ($isValidate == false) {
            return $result->getJSON();
        }

        $platform = $paramsBuilder->buildPlatform($msg);
        $audience = $paramsBuilder->buildAudience($msg);
        $notification = $paramsBuilder->buildNotification($msg);
        $options = $paramsBuilder->buildOptions($msg);
        $autoCode = $paramsBuilder->buildAutoCode($this->appKey, $this->masterSecret);

        $sendVO = array("platform"=>$platform,
                                        "audience"=>$audience,
                                        "notification"=>$notification,
                                        "options"=>$options);
        
        $pushClient = new PushClient();
        $result = $pushClient->send($sendVO, $autoCode);

        return $result;
        
    }                  


    //发送自定义信息
    private function sendMessage($msg, $result) {
        $paramsBuilder = new ParamsBuilder();
        $isValidate = $paramsBuilder->vaildateAutoCode($this->appKey, $this->masterSecret, $result);
        if ($isValidate == false) {
            return $result->getJSON();
        }
        $isValidate = $paramsBuilder->validateParams($msg, $result);
        if ($isValidate == false) {
            return $result->getJSON();
        }
        $isValidate = $paramsBuilder->validateMessageParams($msg, $result);
        if ($isValidate == false) {
            return $result->getJSON();
        }

        $platform = $paramsBuilder->buildPlatform($msg);
        $audience = $paramsBuilder->buildAudience($msg);
        $options = $paramsBuilder->buildOptions($msg);
        $message = $paramsBuilder->buildMessage($msg);
        $autoCode = $paramsBuilder->buildAutoCode($this->appKey, $this->masterSecret);

        $sendVO = array("platform"=>$platform,
                                        "audience"=>$audience,
                                        "message"=>$message,
                                        "options"=>$options);
        
        $pushClient = new PushClient();
        $result = $pushClient->send($sendVO, $autoCode);
        return $result;
    }
    */
}


?>