<?php

/**
 * 通知
 * @author xiezefan@126.com
 * 
 */
class Notification { 
    const  msg_type = "Notification";
    private $platform = "all";

    //audience params 
    private $sendToAll = true;
    private $tag;
    private $tag_and;
    private $alias;
    private $registration_id;

    //notification params
    private $onlyContent = true;
    private $content;
    private $extras;
    //Only Android
    private $builder_id;
    //Only IOS
    private $sound;
    //Only IOS
    private $badge;
    //Only IOS
    private $content_availabe;
    //Only winphone
    private $_open_page;
    //Only Android and  winphone
    private $title;
   

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
    * @param String $content 通知的正文
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

    //notification params  setting function
    public function setTitle($title) {
        $this->title = $title;
        $this->onlyContent = false;
        return $this;
    }
    public function setBuilderId($id) {
        $this->builder_id = $id;
        $this->onlyContent = false;
        return $this;
    }
    public function setExtras($extras) {
        $this->extras = $extras;
        $this->onlyContent = false;
        return $this;
    }
    public function setSound($sound) {
        $this->sound = $sound;
        $this->onlyContent = false;
        return $this;
    }
    public function setBadge($badge) {
        $this->badge = $badge;
        $this->onlyContent = false;
        return $this;
    }
    public function setContentAvailabe($ca) {
        $this->content_availabe = $ca;
        $this->onlyContent = false;
        return $this;
    }
    public function setOpenPage($openPage) {
        $this->_open_page = $openPage;
        $this->onlyContent = false;
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






}
?>

