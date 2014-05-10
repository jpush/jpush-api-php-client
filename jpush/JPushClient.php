<?php
include_once 'Push.php';
include_once 'ReportRecevied.php';
include_once 'SecretEncode.php';
include_once 'ReceivedVO.php';
include_once 'SendVO.php';
include_once 'MessageResult.php';
include_once 'ValidateParams.php';
include_once 'ReceiveResult.php';

/**
 * Jpush客户端
 * @author xinxin@jpush.cn
 * 
 */
class JPushClient
{ 
    //初始化参数
  private $initparams;
    
    /**
    * 构造函数
    * @param String $appKey
    * @param String $masterSecret
    * @param int    $timeToLive
    * @param String $platform      取值范围  (android,ios）
    * @param String $apnsProduction
    */
    public function __construct($app_key, $masterSecret, $timeToLive=0, $platform='', $apnsProduction=false)
    {
    $this->initparams = array("app_key" => $app_key, 
                              "masterSecret" => $masterSecret, 
                              "timeToLive" => $timeToLive, 
                              "platform" => $platform, 
                              "apnsProduction" => $apnsProduction);
    }


    /**
    * 获取统计信息
    * @param String $msg_ids  msg_id以，连接
    */
    public function getReportReceiveds($msg_ids)
    {
        $receivedVO = new ReceivedVO($this->initparams, $msg_ids);
        $revResult = new ReceiveResult();
        $revClient = new ReportRecevied();
        $revClient->getReceivedData($receivedVO, $revResult);
        return $revResult;
    }


    /* xiezefan add start */

    /**
    * 发送广播通知
    * @param int $sendno 发送编号,最大支持32位正整数
    * @param String $title 通知标题。填 空字符串 则默认使用该应用的名称
    * @param String $content 通知内容
    * @param String $description 描述此次发送调用,不会发到用户
    * @param array $extras  通知附加参数，默认为[]
    * @param String $build_id  通知框样式，默认为0
    * @param String $override_msg_id  待覆盖的上一条消息的 ID，默认为0
    * 
    * @return MessageResult $msgResult   错误信息对象
    */
    public function sendNotification($sendno, $title, $content, $description = '', $extras = array(), $build_id = '', $override_msg_id = '') { 
        $msgResult = new MessageResult();
        // set params
        $params = array();
        $params['receiver_type'] = 4;
        $params['mes_type'] = 1;
        //send
        return $this->send($params, $msgResult, $sendno, $title, $content, $description, $extras, $build_id, $override_msg_id);  
    }

    /**
    * 发送tag通知
    * @param int $tags tag字符串。多个tag以','（逗号）分隔
    * @param int $sendno 发送编号,最大支持32位正整数
    * @param String $title 通知标题。填 空字符串 则默认使用该应用的名称
    * @param String $content 通知内容
    * @param String $description 描述此次发送调用,不会发到用户
    * @param array $extras  通知附加参数，默认为[]
    * @param String $build_id  通知框样式，默认为0
    * @param String $override_msg_id  待覆盖的上一条消息的 ID，默认为0
    * 
    * @return MessageResult $msgResult   错误信息对象
    */
    public function sendTagNotification($tags, $sendno, $title, $content, $description = '', $extras = array(), $build_id = '', $override_msg_id = '') {
        $msgResult = new MessageResult();
        // set params
        $params = array();
        $params['receiver_type'] = 2;
        $params['receiver_value'] = $tags;
        $params['mes_type'] = 1;
        //send
        return $this->send($params, $msgResult, $sendno, $title, $content, $description, $extras, $build_id, $override_msg_id);  
    }

    /**
    * 发送alias通知
    * @param int $alias alia字符串。多个alia以','（逗号）分隔
    * @param int $sendno 发送编号,最大支持32位正整数
    * @param String $title 通知标题。填 空字符串 则默认使用该应用的名称
    * @param String $content 通知内容
    * @param String $description 描述此次发送调用,不会发到用户
    * @param array $extras  通知附加参数，默认为[]
    * @param String $build_id  通知框样式，默认为0
    * @param String $override_msg_id  待覆盖的上一条消息的 ID，默认为0
    * 
    * @return MessageResult $msgResult   错误信息对象
    */
    public function sendAliasNotification($alias, $sendno, $title, $content, $description = '', $extras = array(), $build_id = '', $override_msg_id = '') {
        $msgResult = new MessageResult();
        // set params
        $params = array();
        $params['receiver_type'] = 3;
        $params['receiver_value'] = $alias;
        $params['mes_type'] = 1;
        //send
        return $this->send($params, $msgResult, $sendno, $title, $content, $description, $extras, $build_id, $override_msg_id);  

    }

    /**
    * 发送RegistrationID通知
    * @param int $registrations registritionId字符串。多个以','（逗号）分隔
    * @param int $sendno 发送编号,最大支持32位正整数
    * @param String $title 通知标题。填 空字符串 则默认使用该应用的名称
    * @param String $content 通知内容
    * @param String $description 描述此次发送调用,不会发到用户
    * @param array $extras  通知附加参数，默认为[]
    * @param String $build_id  通知框样式，默认为0
    * @param String $override_msg_id  待覆盖的上一条消息的 ID，默认为0
    * 
    * @return MessageResult $msgResult   错误信息对象
    */
    public function sendRegistrationIDNotification($registrations, $sendno, $title, $content, $description = '', $extras = array(), $build_id = '', $override_msg_id = '') {
        $msgResult = new MessageResult();
        // set params
        $params = array();
        $params['receiver_type'] = 5;
        $params['receiver_value'] = $registrations;
        $params['mes_type'] = 1;
        //send
        return $this->send($params, $msgResult, $sendno, $title, $content, $description, $extras, $build_id, $override_msg_id);  
    }

    /**
    * 发送广播自定义消息
    * @param int $sendno 发送编号,最大支持32位正整数
    * @param String $title 通知标题。填 空字符串 则默认使用该应用的名称
    * @param String $content 通知内容
    * @param String $content_type Message字段里的内容类型
    * @param String $description 描述此次发送调用,不会发到用户
    * @param array $extras  通知附加参数，默认为[]
    * @param String $build_id  通知框样式，默认为0
    * @param String $override_msg_id  待覆盖的上一条消息的 ID，默认为0
    * 
    * @return MessageResult $msgResult   错误信息对象
    */
    public function sendCustomMsg($sendno, $title, $content, $content_type = '', $description = '', $extras = array(), $build_id = '', $override_msg_id = '') { 
        $msgResult = new MessageResult();
        // set params
        $params = array();
        $params['receiver_type'] = 4;
        $params['mes_type'] = 2;
        $params['content_type'] = $content_type;
        //send
        return $this->send($params, $msgResult, $sendno, $title, $content, $description, $extras, $build_id, $override_msg_id);  
   }

   /**
    * 发送tag自定义消息
    * @param int $tags tag字符串。多个tag以','（逗号）分隔
    * @param int $sendno 发送编号,最大支持32位正整数
    * @param String $title 通知标题。填 空字符串 则默认使用该应用的名称
    * @param String $content 通知内容
    * @param String $content_type Message字段里的内容类型
    * @param String $description 描述此次发送调用,不会发到用户
    * @param array $extras  通知附加参数，默认为[]
    * @param String $build_id  通知框样式，默认为0
    * @param String $override_msg_id  待覆盖的上一条消息的 ID，默认为0
    * 
    * @return MessageResult $msgResult   错误信息对象
    */
   public function sendTagCustomMsg($tags, $sendno, $title, $content, $content_type = '', $description = '', $extras = array(), $build_id = '', $override_msg_id = '') { 
        $msgResult = new MessageResult();
        // set params
        $params = array();
        $params['receiver_type'] = 2;
        $params['receiver_value'] = $tags;
        $params['mes_type'] = 2;
        $params['content_type'] = $content_type;
        //send
        return $this->send($params, $msgResult, $sendno, $title, $content, $description, $extras, $build_id, $override_msg_id);  
   }

   /**
    * 发送alias自定义消息
    * @param int $alias alia字符串。多个alia以','（逗号）分隔
    * @param int $sendno 发送编号,最大支持32位正整数
    * @param String $title 通知标题。填 空字符串 则默认使用该应用的名称
    * @param String $content 通知内容
    * @param String $content_type Message字段里的内容类型
    * @param String $description 描述此次发送调用,不会发到用户
    * @param array $extras  通知附加参数，默认为[]
    * @param String $build_id  通知框样式，默认为0
    * @param String $override_msg_id  待覆盖的上一条消息的 ID，默认为0
    * 
    * @return MessageResult $msgResult   错误信息对象
    */
   public function sendAliasCustomMsg($alias, $sendno, $title, $content, $content_type = '', $description = '', $extras = array(), $build_id = '', $override_msg_id = '') { 
        $msgResult = new MessageResult();
        // set params
        $params = array();
        $params['receiver_type'] = 3;
        $params['receiver_value'] = $alias;
        $params['mes_type'] = 2;
        $params['content_type'] = $content_type;
        //send
        return $this->send($params, $msgResult, $sendno, $title, $content, $description, $extras, $build_id, $override_msg_id);  
   }

   /**
    * 发送RegistrationID自定义消息
    * @param int $registrations registritionId字符串。多个以','（逗号）分隔
    * @param int $sendno 发送编号,最大支持32位正整数
    * @param String $title 通知标题。填 空字符串 则默认使用该应用的名称
    * @param String $content 通知内容
    * @param String $content_type Message字段里的内容类型
    * @param String $description 描述此次发送调用,不会发到用户
    * @param array $extras  通知附加参数，默认为[]
    * @param String $build_id  通知框样式，默认为0
    * @param String $override_msg_id  待覆盖的上一条消息的 ID，默认为0
    * 
    * @return MessageResult $msgResult   错误信息对象
    */
   public function sendRegistrationIDCustomMsg($registrations, $sendno, $title, $content, $content_type = '', $description = '', $extras = array(), $build_id = '', $override_msg_id = '') { 
        $msgResult = new MessageResult();
        // set params
        $params = array();
        $params['receiver_type'] = 5;
        $params['receiver_value'] = $registrations;
        $params['mes_type'] = 2;
        $params['content_type'] = $content_type;
        //send
        return $this->send($params, $msgResult, $sendno, $title, $content, $description, $extras, $build_id, $override_msg_id);  
   }


    //private
    //发送消息
    private function send($params, $msgResult, $sendno, $title, $content, $description, $extras, $build_id, $override_msg_id) {
        $params['sendno'] = $sendno;
        $params['title'] = $title;
        $params['send_description'] = $description;
        $params['content'] = $content;
        $params['build_id'] = $build_id;
        $params['override_msg_id'] = $override_msg_id;

        // validate params
        $isValidate = $this->validateParams($params, $extras, $msgResult);
        if ($isValidate === false) {
            return $msgResult;
        }

        $sendVO = new SendVO($this->initparams ,$params, $extras);
        //发送通知
        
        $pushClient = new Push();
        $pushClient->pushMsg($sendVO, $msgResult);
        return $msgResult; 
    }


    //验证参数合法性
    private function validateParams($params, $extras, $msgResult) {

        // validate initparams
        if (is_string($this->initparams['app_key']) === false) {
           $msgResult->setResult(1003,"Parameters 'app_key' must be a string");
            return false; 
        }
        if (is_string($this->initparams['masterSecret']) === false) {
           $msgResult->setResult(1003,"Parameters 'masterSecret' must be a string");
            return false; 
        }
        if (is_int($this->initparams['timeToLive']) === false || $this->initparams['timeToLive'] < 0 || $this->initparams['timeToLive'] > 864000) {
           $msgResult->setResult(1003,"Parameters 'timeToLive' must be a int and in [0, 864000]");
            return false; 
        }
        if (is_string($this->initparams['platform']) === false) {
           $msgResult->setResult(1003,"Parameters 'platform' must be a string");
            return false; 
        }
        if (is_bool($this->initparams['apnsProduction']) === false) {
           $msgResult->setResult(1003,"Parameters 'apnsProduction' must be bool");
            return false; 
        }

        //validate push params
        if (is_array($extras) === false) {
            $msgResult->setResult(1003,"Parameters 'extras' must be a array");
            return false;
        }
        if (is_int($params['sendno']) === false) {
             $msgResult->setResult(1003,"Parameters 'sendno' must be a int");
            return false;
        }
        if (is_string($params['title']) === false) {
            $msgResult->setResult(1003,"Parameters 'title' must be a string");
            return false;
        }
        if (is_string($params['content']) === false) {
            $msgResult->setResult(1003,"Parameters 'content' must be a string");
            return false;
        }
        if ('' != $params['build_id'] && (is_int($params['build_id']) === false || $params['build_id'] < 1 || $params['build_id'] > 1000)) {
            $msgResult->setResult(1003,"Parameters 'build_id' must be a int and in [1, 1000]");
            return false;
        }
        if (is_string($params['override_msg_id']) === false) {
            $msgResult->setResult(1003,"Parameters 'override_msg_id' must be a string");
            return false;
        }
        if (array_key_exists('receiver_value', $params) === true && is_string($params['receiver_value']) === false) {
            $msgResult->setResult(1003,"Parameters 'receiver_value' must be a string");
            return false;
        }
        if (array_key_exists('content_type', $params) === true && is_string($params['content_type']) === false) {
            $msgResult->setResult(1003,"Parameters 'content_type' must be a string");
            return false;
        }

    }





  /* xiezefan add end */

}
?>