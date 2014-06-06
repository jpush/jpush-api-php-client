<?php
include_once "../jpush/model/notification/IOSNotification.php";


/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-5-24
 * Time: 上午11:25
 */

class IOSNotificationTests extends PHPUnit_Framework_TestCase  {

    public function testIosNotification() {
        $array = array(
            "alert" => "ios alert",
            "sound" => "happy",
            "badge" => 1,
            "extras" => array("key1"=>"value1", "key2"=>"value2"),
            "content-available" => 1
        );
        $result = json_encode($array);

        $ios = new IOSNotification();
        $ios->alert = "ios alert";
        $ios->badge = 1;
        $ios->content_available = 1;
        $ios->sound = "happy";
        $ios->extras = array("key1"=>"value1", "key2"=>"value2");
        $json_arr = $ios->toJSON();

        $json_str = json_encode($json_arr);
        $this->assertEquals($result, $json_str);
    }
} 