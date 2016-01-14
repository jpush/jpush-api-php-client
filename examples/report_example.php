<?php

/**
 * 此示例为JPush Report API的调用示例
 * HTTP API文档:http://docs.jpush.io/server/rest_api_v3_report/
 * PHP API文档:https://github.com/jpush/jpush-api-php-client/blob/master/doc/api.md#report-api
 */
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
require_once("../src/JPush/JPush.php");

$br = '<br/>';
$app_key = 'dd1066407b044738b6479275';
$master_secret = 'e8cc9a76d5b7a580859bcfa7';

// 初始化
$client = new JPush($app_key, $master_secret);

// 获取送达统计
$response = $client->report()->getReceived(array('1150720279', '1492401191', '1150722083')); // 也可以如此调用 ->getReceived('1150720279,1492401191,1150722083')
echo 'Result=' . json_encode($response) . $br;

// 获取消息统计
$response = $client->report()->getMessages('541778586,1235578218');
echo 'Result=' . json_encode($response) . $br;

// 获取用户统计
$response = $client->report()->getUsers('DAY', '2014-06-10', 3);
echo 'Result=' . json_encode($response) . $br;
