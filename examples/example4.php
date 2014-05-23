<?php
include_once '../jpushv3/JPushClient.php';

include_once '../jpushv3/model/Audience.php';
include_once '../jpushv3/model/Message.php';
include_once '../jpushv3/model/notification/Notification.php';
include_once '../jpushv3/model/notification/IOSNotification.php';
include_once '../jpushv3/model/notification/AndroidNotification.php';
include_once '../jpushv3/model/notification/WinphoneNotification.php';
include_once '../jpushv3/model/Options.php';
include_once '../jpushv3/model/Platform.php';
include_once '../jpushv3/model/PushPayload.php';
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-5-23
 * Time: 下午1:29
 */

$master_secret = 'd94f733358cca97b18b2cb98';
$app_key='47a3ddda34b2602fa9e17c01';
$client = new JPushClient($app_key, $master_secret);

//init
$payload = new PushPayload();
$platform = new Platform();
$audience = new Audience();
$message = new Message();
$options = new Options();

$notification = new Notification();
$ios = new IOSNotification();
$android = new AndroidNotification();
$winphone = new WinphoneNotification();


//set platform params
//$platform->ios = true;
//$platform->winphone = true;


//set audience params
$audience->tag = "tag1, tag2";
//$audience->tag_and = "tag3, tag4";
//$audience->alias = "alias1,alias2";
//$audience->registration_is = "id1,id2";

//set message params
$message->msg_content = "message content test";
$message->title = "message title test";
$message->content_type = "message content type test";
$message->extras = array("key1"=>"value1", "key2"=>"value2");

//set options params
$options->sendno = 1;
$options->apns_production = true;
$options->override_msg_id = 2;
$options->time_to_live = 60;

//set notification params
$ios->alert = "ios notification alert test";
$ios->sound = "happy";
$ios->badge = 1;
$ios->extras = array("key1"=>"value1", "key2"=>"value2");
$ios->content_availabe = 1;

$android->alert = "android notification alert test";
$android->title = "android notification title test";
$android->builder_id = 1;
$android->extras = array("key1"=>"value1", "key2"=>"value2");

$winphone->alert = "winphone notification alert test";
$winphone->title = "winphone notification title test";
$winphone->_open_page = "/friends.xaml";
$winphone->extras = array("key1"=>"value1", "key2"=>"value2");

$notification->alert = "notification alert test";
$notification->android = $android;
$notification->ios = $ios;
$notification->winphone = $winphone;

//$payload->platform = $platform;
//$payload->audience = $audience;
//$payload->message = $message;
//$payload->options = $options;
$payload->notification = $notification;


echo json_encode($payload->toJSON()) . "<br/>";

//send payload
$result = $client->sendPush($payload);

echo var_dump($result) . "<br/>";




?>