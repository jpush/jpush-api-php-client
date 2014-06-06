<?php
include_once '../jpush/model/Audience.php';
include_once '../jpush/model/Message.php';
include_once '../jpush/model/notification/Notification.php';
include_once '../jpush/model/notification/IOSNotification.php';
include_once '../jpush/model/notification/AndroidNotification.php';
include_once '../jpush/model/notification/WinphoneNotification.php';
include_once '../jpush/model/Options.php';
include_once '../jpush/model/Platform.php';
include_once '../jpush/model/PushPayload.php';
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-5-24
 * Time: 上午11:23
 */

class PushPayloadTests extends PHPUnit_Framework_TestCase {
    private $platform;
    private $audience;
    private $message;
    private $notification;
    private $options;

    public function testPushPayload() {
        $array = array(
            "platform" => array("android","ios","winphone"),
            "audience" => array(
                "tag" => array("tag1", "tag2"),
                "tag_and" => array("tag3"),
                "alias" => array("alias1", "alias2"),
                "registration_id" => array("id1", "id2")
            ),
            "notification" => array(
                "alert" => "notification alert",
                "ios" => array(
                    "alert" => "ios alert",
                    "sound" => "happy",
                    "badge" => 1,
                    "extras" => array("key1"=>"value1", "key2"=>"value2"),
                    "content-available" => 1
                ),
                "android" => array(
                    "alert" => "android alert",
                    "title" => "android title",
                    "builder_id"=>1,
                    "extras" => array("key1"=>"value1", "key2"=>"value2")
                ),
                "winphone" => array(
                    "alert" => "winphone alert",
                    "title" => "winphone title",
                    "_open_page" => "/friends.xaml",
                    "extras" => array("key1"=>"value1", "key2"=>"value2"),
                )
            ),
            "message" => array(
                "msg_content" => "message msg content",
                "title" => "message title",
                "content_type" => "message content type",
                "extras" => array("key1"=>"value1", "key2"=>"value2")
            ),
            "options" => array(
                "sendno" => 654321,
                "time_to_live" => 60,
                "override_msg_id" => 123456,
                "apns_production" => false
            )
        );
        $result = json_encode($array);
        $payload = new PushPayload();
        $payload->platform = $this->platform;
        $payload->audience = $this->audience;
        $payload->message = $this->message;
        $payload->notification = $this->notification;
        $payload->options = $this->options;
        $json_arr = $payload->toJSON();

        $json_str = json_encode($json_arr);
        $this->assertEquals($result, $json_str);


    }

    public function testAlertAll() {
        $array = array(
            "platform" => "all",
            "audience" => "all",
            "notification" => array(
                "alert" => "notification alert",
                "ios" => array(
                    "alert" => "ios alert",
                    "sound" => "happy",
                    "badge" => 1,
                    "extras" => array("key1"=>"value1", "key2"=>"value2"),
                    "content-available" => 1
                ),
                "android" => array(
                    "alert" => "android alert",
                    "title" => "android title",
                    "builder_id"=>1,
                    "extras" => array("key1"=>"value1", "key2"=>"value2")
                ),
                "winphone" => array(
                    "alert" => "winphone alert",
                    "title" => "winphone title",
                    "_open_page" => "/friends.xaml",
                    "extras" => array("key1"=>"value1", "key2"=>"value2"),
                )
            ),
            "message" => array(
                "msg_content" => "message msg content",
                "title" => "message title",
                "content_type" => "message content type",
                "extras" => array("key1"=>"value1", "key2"=>"value2")
            ),
            "options" => array(
                "sendno" => 654321,
                "time_to_live" => 60,
                "override_msg_id" => 123456,
                "apns_production" => false
            )
        );
        $result = json_encode($array);
        $payload = new PushPayload();
        $payload->message = $this->message;
        $payload->notification = $this->notification;
        $payload->options = $this->options;
        $json_arr = $payload->toJSON();

        $json_str = json_encode($json_arr);
        $this->assertEquals($result, $json_str);

    }

    function setUp() {
        $this->android = new AndroidNotification();
        $this->android->alert = "android alert";
        $this->android->title = "android title";
        $this->android->builder_id = 1;
        $this->android->extras = array("key1"=>"value1", "key2"=>"value2");

        $this->winphone = new WinphoneNotification();
        $this->winphone->alert = "winphone alert";
        $this->winphone->title = "winphone title";
        $this->winphone->_open_page = "/friends.xaml";
        $this->winphone->extras = array("key1"=>"value1", "key2"=>"value2");

        $this->ios = new IOSNotification();
        $this->ios->alert = "ios alert";
        $this->ios->badge = 1;
        $this->ios->content_available = 1;
        $this->ios->sound = "happy";
        $this->ios->extras = array("key1"=>"value1", "key2"=>"value2");

        $this->notification = new Notification();
        $this->notification->alert = "notification alert";
        $this->notification->ios = $this->ios;
        $this->notification->winphone = $this->winphone;
        $this->notification->android = $this->android;

        $this->options = new Options();
        $this->options->apns_production = false;
        $this->options->override_msg_id = 123456;
        $this->options->sendno = 654321;
        $this->options->time_to_live = 60;

        $this->platform = new Platform();
        $this->platform->ios = true;
        $this->platform->android = true;
        $this->platform->winphone = true;

        $this->audience = new Audience();
        $this->audience->tag = "tag1,tag2";
        $this->audience->tag_and = "tag3";
        $this->audience->alias = "alias1,alias2";
        $this->audience->registration_id = "id1,id2";


        $this->message = new Message();
        $this->message->title = "message title";
        $this->message->content_type = "message content type";
        $this->message->msg_content = "message msg content";
        $this->message->extras = array("key1"=>"value1", "key2"=>"value2");


    }
} 