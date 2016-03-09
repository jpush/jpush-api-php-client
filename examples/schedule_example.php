<?php
/**
 * 该示例主要为JPush Schedule API的调用示例
 * HTTP API文档:http://docs.jpush.io/server/rest_api_push_schedule/
 * PHP API文档:https://github.com/jpush/jpush-api-php-client/blob/master/doc/api.md#schedule-api
 */
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
require_once("../src/JPush/JPush.php");

$br = '<br/>';
$app_key = 'dd1066407b044738b6479275';
$master_secret = 'e8cc9a76d5b7a580859bcfa7';

// 初始化
$client = new JPush($app_key, $master_secret);

$payload = $client->push()
    ->setPlatform("all")
    ->addAllAudience()
    ->setNotificationAlert("Hi, 这是一条定时发送的消息")
    ->build();

// 创建一个2016-12-22 13:45:00触发的定时任务
$response = $client->schedule()->createSingleSchedule("每天14点发送的定时任务", $payload, array("time"=>"2016-12-22 13:45:00"));
echo 'Result=' . json_encode($response) . $br;

// 创建一个每天14点发送的定时任务
$response = $client->schedule()->createPeriodicalSchedule("每天14点发送的定时任务", $payload,
        array(
            "start"=>"2016-12-22 13:45:00",
            "end"=>"2016-12-25 13:45:00",
            "time"=>"14:00:00",
            "time_unit"=>"DAY",
            "frequency"=>1
        ));
echo 'Result=' . json_encode($response) . $br;

$schedule_id = $response->data->schedule_id;

// 更新指定的定时任务
$response = $client->schedule()->updatePeriodicalSchedule($schedule_id, null, true);
echo "Result=" . json_encode($response) . $br;


// 获取定时任务列表
$response = $client->schedule()->getSchedules();
echo "Result=" . json_encode($response) . $br;


// 删除定时任务
$response = $client->schedule()->deleteSchedule($schedule_id);
echo "Result=" . json_encode($response) . $br;



