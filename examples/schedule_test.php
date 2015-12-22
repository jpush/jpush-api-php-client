<?php

require_once("./JPush.php");

$client = new JPush('94426bda4a12dd1fe5221375', '967b5c5266d33f489781d2ac');

$payload = $client->push()
    ->setPlatform("all")
    ->addAlias("xiezefan")
    ->setNotificationAlert("Hi, 这条信息将会在每天14点发送")
    ->setSmsMessage("Hi, 这条信息将会在每天14点发送", 0)
    ->build();


//$response = $client->schedule()
//    ->createPeriodicalSchedule("定时任务测试", $payload,
//        array(
//            "start"=>"2015-12-22 13:45:00",
//            "end"=>"2015-12-25 13:45:00",
//            "time"=>"14:00:00",
//            "time_unit"=>"DAY",
//            "frequency"=>1
//        ));

$response = $client->schedule()->updatePeriodicalSchedule('7d549648-a86f-11e5-b41a-0021f652c102', null, true);
echo "Response=" . json_encode($response) . "\r\n";

$response = $client->schedule()->getSchedules();
echo "Response=" . json_encode($response) . "\r\n";
