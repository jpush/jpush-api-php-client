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
        $result = '{"platform":["android","ios","winphone"],"audience":{"tag":["tag1","tag2"],"tag_and":["tag3"],"alias":["alias1","alias2"],"registration_is":["id1","id2"]},"notification":{"alert":"notification alert","ios":{"alert":"ios alert","sound":"happy","badge":1,"extras":{"key1":"value1","key2":"value2"},"content_availabe":1},"android":{"alert":"android alert","title":"android title","builder_id":1,"extras":{"key1":"value1","key2":"value2"}},"winphone":{"alert":"winphone alert","title":"winphone title","_open_page":"\/abc.fmal","extras":{"key1":"value1","key2":"value2"}}},"message":{"msg_content":"message msg content","title":"message title","content_type":"message content tpye","extras":{"key1":"value1","key2":"value2"}},"options":{"sendno":654321,"time_to_live":60,"override_msg_id":123456,"apns_production":1}}';

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
        $result = '{"platform":"all","audience":"all","notification":{"alert":"notification alert","ios":{"alert":"ios alert","sound":"happy","badge":1,"extras":{"key1":"value1","key2":"value2"},"content_availabe":1},"android":{"alert":"android alert","title":"android title","builder_id":1,"extras":{"key1":"value1","key2":"value2"}},"winphone":{"alert":"winphone alert","title":"winphone title","_open_page":"\/abc.fmal","extras":{"key1":"value1","key2":"value2"}}},"message":{"msg_content":"message msg content","title":"message title","content_type":"message content tpye","extras":{"key1":"value1","key2":"value2"}},"options":{"sendno":654321,"time_to_live":60,"override_msg_id":123456,"apns_production":1}}';

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
        $this->winphone->_open_page = "/abc.fmal";
        $this->winphone->extras = array("key1"=>"value1", "key2"=>"value2");

        $this->ios = new IOSNotification();
        $this->ios->alert = "ios alert";
        $this->ios->badge = 1;
        $this->ios->content_availabe = 1;
        $this->ios->sound = "happy";
        $this->ios->extras = array("key1"=>"value1", "key2"=>"value2");

        $this->notification = new Notification();
        $this->notification->alert = "notification alert";
        $this->notification->ios = $this->ios;
        $this->notification->winphone = $this->winphone;
        $this->notification->android = $this->android;

        $this->options = new Options();
        $this->options->apns_production = 1;
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
        $this->message->content_type = "message content tpye";
        $this->message->msg_content = "message msg content";
        $this->message->extras = array("key1"=>"value1", "key2"=>"value2");


    }
} 