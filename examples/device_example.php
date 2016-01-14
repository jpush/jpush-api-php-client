<?php

/**
 * 此示例为JPush Device API示例
 * HTTP API文档:http://docs.jpush.io/server/rest_api_v3_device/
 * PHP API文档:https://github.com/jpush/jpush-api-php-client/blob/master/doc/api.md#device-api
 */
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
require_once("../src/JPush/JPush.php");

$br = '<br/>';
$br = "\r\n";
$app_key = 'dd1066407b044738b6479275';
$master_secret = 'e8cc9a76d5b7a580859bcfa7';

$TAG1 = "tag1";
$TAG2 = "tag2";
$TAG3 = "tag3";
$TAG4 = "tag4";
$ALIAS1 = "alias1";
$ALIAS2 = "alias2";
$REGISTRATION_ID1 = "0900e8d85ef";
$REGISTRATION_ID2 = "0a04ad7d8b4";


// 初始化
$client = new JPush($app_key, $master_secret);

// 获取指定设备的Mobile,Alias,Tags等信息
$result = $client->device()->getDevices($REGISTRATION_ID1);
echo 'Result=' . json_encode($result) . $br;

// 获取Tag列表
$result = $client->device()->getTags();
echo 'Result=' . json_encode($result) . $br;

// 判断指定RegistrationId是否在指定Tag中
$result = $client->device()->isDeviceInTag($REGISTRATION_ID1, $TAG1);
echo 'Result=' . json_encode($result) . $br;

// 获取指定Alias下的设备
$result = $client->device()->getAliasDevices($ALIAS1);
echo 'Result=' . json_encode($result) . $br;

// 更新指定的设备的Alias(亦可以增加/删除Tags)
$result = $client->device()->updateDevice($REGISTRATION_ID1, $ALIAS1);
echo 'Result=' . json_encode($result) . $br;

// 增加指定Tag下的设备(亦可以删除设备)
$result = $client->device()->updateTag($TAG1, array($REGISTRATION_ID1, $REGISTRATION_ID2));
echo 'Result=' . json_encode($result) . $br;

// 删除指定Alias
$result = $client->device()->deleteAlias($ALIAS1);
echo 'Result=' . json_encode($result) . $br;

