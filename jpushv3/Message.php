<?php

/**
 * 消息
 * @author xiezefan@126.com
 * 
 */
class Message { 
    const  msg_type = "Message";
    private $platform = "all";

    //audience params 
    private $sendToAll = true;
    private $tag;
    private $tag_and;
    private $alias;
    private $registration_id;

    //notification params
    private $content;
    private $extras;
    private $title;
    private $content_type;
   

    // options params
    private $sendno;
    // If not present, the default value is 86400(s) (one day)
    private $time_to_live = 86400;
    // If not present, false by default.
    private $apns_production = false;
    // If override messge  enable
    private $overrideEnable = false;
    private $override_msg_id;

        /**
    * 构造函数
    * @param String $content 自定义消息的正文
    */
    public function __construct($content) {
        $this->content = $content;
    }

    //platform setting function
    public function setPlatform($platform) {
        $this->platform = $platform;
        return $this;
    }

    //audience params setting functiuon
    public function setTag($tags) {
        $this->tag = $tags;
        $this->sendToAlls = false;
        return $this;
    }

    public function setTagAnd($tags) {
        $this->tag_and = $tags;
         $this->sendToAll = false;
        return $this;
    }

    public function setAlias($alias) {
        $this->alias = $alias;
         $this->sendToAll = false;
        return $this;
    }

    public function setRegistrationId($ids) {
        $this->registration_id = $ids;
         $this->sendToAll = false;
        return $this;
    }

    //options params setting function
    public function setTimeToLive($time) {
        $this->time_to_live = $time;
        return $this;
    }

    public function setApnsProduction($apnsProduction) {
        $this->apns_production = $apnsProduction;
        return $this;
    }

    public function setOverrideMsgId($id) {
        $this->override_msg_id = $id;
        $this->overrideEnable = true;
        return $this;
    }



    public function getMsgType() {
        return self::msg_type;
    }

    public function __get($property_name) {
        if(isset($this->$property_name)) {
            return($this->$property_name);
        } else {
            return(NULL);
        }
    }

    //Message params setting function
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }
    public function setExtras($extras) {
        $this->extras = $extras;
        return $this;
    }
    public function setContentType($contentType) {
        $this->content_type = $contentType;
        return $this;
    }

    




}
?>

