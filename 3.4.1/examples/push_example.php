<?php
/**
 * 该示例主要为JPush Push API的调用示例
 * HTTP API文档:http://docs.jpush.io/server/rest_api_v3_push/
 * PHP API文档:https://github.com/jpush/jpush-api-php-client/blob/master/doc/api.md#push-api--构建推送pushpayload
 	 PHP Push-API-v3 参数说明:http://docs.jpush.cn/display/dev/Push-API-v3#Push-API-v3-platform
 	 修改:黄凯 15201170952
*/
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
require_once("../src/JPush/JPush.php");
require_once("../../../../../commonfiles/config.php");

$br = '<br/>';
$app_key = '1bb81d808d69edc8a334dab8';
$master_secret = 'ab980b3461bcde3e5fac1f85';
$mmm = date("Y-m-d H:i:s");

// 初始化 /* */
$client = new JPush($app_key, $master_secret);

/*
		platform	必填	推送平台设置
		audience	必填	推送设备指定
		notification	可选	通知内容体。是被推送到客户端的内容。与 message 一起二者必须有其一，可以二者并存
		message	可选	消息内容体。是被推送到客户端的内容。与 notification 一起二者必须有其一，可以二者并存
		options	可选	推送参数
*/

// 简单推送示例 通知 
/* 
		可以给安卓或者ios发送不同的内容
    ->addAndroidNotification('Hi, android notification', 'notification title', 1, array("key1"=>"value1", "key2"=>"value2"))
    ->addIosNotification("Hi, iOS notification", 'iOS sound', JPush::DISABLE_BADGE, true, 'iOS category', array("key1"=>"value1", "key2"=>"value2"))
*/

$result = $client->push()
    ->setPlatform('all')
    ->addAllAudience('all')
    ->addAndroidNotification('Hi, android notification', 'notification title', 1, array("key1"=>"value1", "key2"=>"value2"))
    ->addIosNotification("Hi, iOS notification", 'iOS sound', JPush::DISABLE_BADGE, true, 'iOS category', array("key1"=>"value1", "key2"=>"value2"))
    ->setNotificationAlert('one:'.$mmm)
    ->send();

echo 'Result=' . json_encode($result) . $br;


exit;
// 完整的推送示例,包含指定Platform,指定Alias,Tag,指定iOS,Android notification,指定Message等
//   ->setPlatform(array('ios', 'android'))
//   ->addAlias('alias1')
//    ->addTag(array('tag1', 'tag2'))
// ->addAndroidNotification('Hi, android notification', 'notification title', 1, array("key1"=>"value1", "key2"=>"value2"))
   

$result = $client->push()
    ->setPlatform(array('ios', 'android'))
    ->addAllAudience('all')
    ->setMessage("msg content".$mmm, 'msg title', 'type', array("key1"=>"value1", "key2"=>"value2"))
    ->setOptions(100000, 3600, null, false)
    ->send();

echo 'Result=' . json_encode($result) . $br;




// 定推送短信示例(推送未送达的情况下进行短信送达, 该功能需预付短信费用, 并调用Device API绑定设备与手机号)
$result = $client->push()
    ->setPlatform('all')
    ->addTag('tag1')
    ->setNotificationAlert("Hi, JPush SMS")
    ->setSmsMessage('Hi, JPush SMS', 60)
    ->send();

echo 'Result=' . json_encode($result) . $br;


