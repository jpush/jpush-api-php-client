<?php
include_once "../jpush/model/Message.php";
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-5-24
 * Time: 上午11:24
 */

class MessageTests extends PHPUnit_Framework_TestCase {

    public function testMessage() {
        $result ='{"msg_content":"message msg content","title":"message title","content_type":"message content tpye","extras":{"key1":"value1","key2":"value2"}}';

        $message = new Message();
        $message->title = "message title";
        $message->content_type = "message content tpye";
        $message->msg_content = "message msg content";
        $message->extras = array("key1"=>"value1", "key2"=>"value2");
        $json_arr = $message->toJSON();

        $json_str = json_encode($json_arr);
        $this->assertEquals($result, $json_str);

    }
} 