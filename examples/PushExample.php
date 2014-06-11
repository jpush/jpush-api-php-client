<?php
include_once '../src/JPush/Model/Audience.php';
include_once '../src/JPush/Model/Message.php';
include_once '../src/JPush/Model/Notification.php';
include_once '../src/JPush/Model/Options.php';
include_once '../src/JPush/Model/Platform.php';
include_once '../src/JPush/Model/PushPayload.php';
include_once '../src/JPush/Model/PushResponse.php';
include_once '../src/JPush/Model/ReportResponse.php';
include_once '../src/JPush/Model/Report.php';
include_once '../src/JPush/Model/Error.php';
include_once '../src/JPush/JPushClient.php';

use JPush\Model as M;
use JPush\JPushClient;

$br = '<br/>';
$spilt = ' - ';

$master_secret = 'd94f733358cca97b18b2cb98';
$app_key='47a3ddda34b2602fa9e17c01';
$client = new JPushClient($app_key, $master_secret);

//easy push
$result = $client->push()
    ->setPlatform(M\all)
    ->setAudience(M\all)
    ->setNotification(M\notification('Hi, JPush'))
    ->printJSON()
    ->send();

if ($result->ok) {
    echo 'ok : ' . ($result->ok ? 'true' : 'false') . $br;
    echo 'sendno : ' . $result->sendno . $br;
    echo 'msg_id : ' .$result->msg_id . $br;
    echo $br . '---------' . $br;
} else {
    echo 'ok : ' . ($result->ok ? 'true' : 'false') . $br;
    echo 'code : ' . $result->error->code . $br;
    echo 'message : ' . $result->error->message . $br;
}


//full push

$result = $client->push()
    ->setPlatform(M\platform('ios', 'android'))
    ->setAudience(M\audience(M\tag(['555','666']), M\alias(['555', '666'])))
    ->setNotification(M\notification('Hi, JPush', M\android('Hi, android'), M\ios('Hi, ios', 'happy', 1, true)))
    ->setMessage(M\message('msg content', null, null, array('key'=>'value')))
    ->setOptions(M\options(123456, null, null, false))
    ->printJSON()
    ->send();

if ($result->ok) {
    echo 'ok : ' . ($result->ok ? 'true' : 'false') . $br;
    echo 'sendno : ' . $result->sendno . $br;
    echo 'msg_id : ' .$result->msg_id . $br;
    echo $br . '---------' . $br;
} else {
    echo 'ok : ' . ($result->ok ? 'true' : 'false') . $br;
    echo 'code : ' . $result->error->code . $br;
    echo 'message : ' . $result->error->message . $br;
}


//fail push
$result = $client->push()
    ->setPlatform(M\all)
    ->setAudience(M\all)
    ->setNotification(M\notification('Hi, JPush'))
    ->setAudience(M\audience(['no one']))
    ->printJSON()
    ->send();

if ($result->ok) {
    echo 'ok : ' . ($result->ok ? 'true' : 'false') . $br;
    echo 'sendno : ' . $result->sendno . $br;
    echo 'msg_id : ' .$result->msg_id . $br;
    echo $br . '---------' . $br;
} else {
    echo 'ok : ' . ($result->ok ? 'true' : 'false') . $br;
    echo 'code : ' . $result->error->code . $br;
    echo 'message : ' . $result->error->message . $br;
}