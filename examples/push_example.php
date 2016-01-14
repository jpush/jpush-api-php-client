<?php
/**
 * 该示例主要为JPush Push API的调用示例
 * HTTP API文档:http://docs.jpush.io/server/rest_api_v3_push/
 * PHP API文档:https://github.com/jpush/jpush-api-php-client/blob/master/doc/api.md#push-api--构建推送pushpayload
 */
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
require_once("../src/JPush/JPush.php");

$br = '<br/>';
$app_key = 'dd1066407b044738b6479275';
$master_secret = 'e8cc9a76d5b7a580859bcfa7';

// 初始化
$client = new JPush($app_key, $master_secret);

// 简单推送示例
$result = $client->push()
    ->setPlatform('all')
    ->addAllAudience()
    ->setNotificationAlert('Hi, JPush')
    ->send();

echo 'Result=' . json_encode($result) . $br;

// 完整的推送示例,包含指定Platform,指定Alias,Tag,指定iOS,Android notification,指定Message等
$result = $client->push()
    ->setPlatform(array('ios', 'android'))
    ->addAlias('alias1')
    ->addTag(array('tag1', 'tag2'))
    ->setNotificationAlert('Hi, JPush')
    ->addAndroidNotification('Hi, android notification', 'notification title', 1, array("key1"=>"value1", "key2"=>"value2"))
    ->addIosNotification("Hi, iOS notification", 'iOS sound', JPush::DISABLE_BADGE, true, 'iOS category', array("key1"=>"value1", "key2"=>"value2"))
    ->setMessage("msg content", 'msg title', 'type', array("key1"=>"value1", "key2"=>"value2"))
    ->setOptions(100000, 3600, null, false)
    ->send();

echo 'Result=' . json_encode($result) . $br;


// 指定推送短信示例(推送未送达的情况下进行短信送达, 该功能需预付短信费用, 并调用Device API绑定设备与手机号)
$result = $client->push()
    ->setPlatform('all')
    ->addTag('tag1')
    ->setNotificationAlert("Hi, JPush SMS")
    ->setSmsMessage('Hi, JPush SMS', 60)
    ->send();

echo 'Result=' . json_encode($result) . $br;