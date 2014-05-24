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
    private $reportClient;

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
        $this->reportClient = new ReportClient();
    }

    /**
     * 发送通知或自定义信息
     * @param $payload
     * @return string
     */
    public function sendPush($payload) {
        $result = new Result();

        //validate
        $isValidate = $this->paramsBuilder->vaildateAutoCode($this->appKey, $this->masterSecret, $result);
        if ($isValidate === false) {
            return $result->toJSON();
        }
        $isValidate = $this->paramsBuilder->validatePayload($payload, $result);
        if ($isValidate === false) {
            return $result->toJSON();
        }

        //send
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
        $isValidate = $this->paramsBuilder->vaildateAutoCode($this->appKey, $this->masterSecret, $result);
        if ($isValidate === false) {
            return $result->toJSON();
        }
        $isValidate = $this->paramsBuilder->validateReceiveParams($msg_ids, $result);
        if ($isValidate === false) {
            return $result->toJSON();
        }


        $autoCode = $this->paramsBuilder->buildAutoCode($this->appKey, $this->masterSecret, $result);
        return $this->reportClient->send($msg_ids, $autoCode);
    }

}


?>