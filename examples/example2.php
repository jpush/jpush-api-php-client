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

$android = new AndroidNotification();
$android->alert = "android alert";
$android->title = "android title";
$android->builder_id = 1;
$android->extras = array("key1"=>"value1", "key2"=>"value2");
$json_arr = $android->toJSON();

$winphone = new WinphoneNotification();
$winphone->alert = "winphone alert";
$winphone->title = "winphone title";
$winphone->_open_page = "/abc.fmal";
$winphone->extras = array("key1"=>"value1", "key2"=>"value2");
$json_arr = $winphone->toJSON();

$ios = new IOSNotification();
$ios->alert = "ios alert";
$ios->badge = 1;
$ios->content_availabe = 1;
$ios->sound = "happy";
$ios->extras = array("key1"=>"value1", "key2"=>"value2");
$json_arr = $ios->toJSON();

$notification = new Notification();
$notification->alert = "notification alert";
$notification->ios = $ios;
$notification->winphone = $winphone;
$notification->android = $android;
$json_arr = $notification->toJSON();

$options = new Options();
$options->apns_production = 1;
$options->override_msg_id = 123456;
$options->sendno = 654321;
$options->time_to_live = 60;
$json_arr = $options->toJSON();

$platform = new Platform();
$platform->ios = true;
$platform->android = true;
$platform->winphone = true;
$json_arr = $platform->toJSON();

$audience = new Audience();
$audience->tag = "tag1,tag2";
$audience->tag_and = "tag3";
$audience->alias = "alias1,alias2";
$audience->registration_id = "id1,id2";
$json_arr = $audience->toJSON();


$message = new Message();
$message->title = "message title";
$message->content_type = "message content tpye";
$message->msg_content = "message msg content";
$message->extras = array("key1"=>"value1", "key2"=>"value2");
$json_arr = $message->toJSON();

$payload = new PushPayload();
//$payload->platform = $platform;
//$payload->audience = $audience;
$payload->message = $message;
$payload->notification = $notification;
$payload->options = $options;
$json_arr = $payload->toJSON();


$json_str = json_encode($json_arr);
echo $json_str;