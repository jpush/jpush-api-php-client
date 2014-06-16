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
include_once '../src/JPush/JPushLog.php';
include_once '../src/JPush/Exception/APIConnectionException.php';
include_once '../src/JPush/Exception/APIRequestException.php';

require_once 'vendor/autoload.php';

use JPush\Model as M;
use JPush\JPushClient;
use JPush\JPushLog;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use JPush\Exception\APIConnectionException;
use JPush\Exception\APIRequestException;

$br = '<br/>';
$spilt = ' - ';




$master_secret = 'd94f733358cca97b18b2cb98';
$app_key='47a3ddda34b2602fa9e17c01';
JPushLog::setLogHandlers(array(new StreamHandler('jpush.log', Logger::DEBUG)));
$client = new JPushClient($app_key, $master_secret);

//easy push
try {
    $result = $client->push()
        ->setPlatform(M\all)
        ->setAudience(M\all)
        ->setNotification(M\notification('Hi, JPush'))
        ->printJSON()
        ->send();
    echo 'Push Success.' . $br;
    echo 'sendno : ' . $result->sendno . $br;
    echo 'msg_id : ' .$result->msg_id . $br;
    echo 'Response JSON : ' . $result->json . $br;
} catch (APIRequestException $e) {
    echo 'Push Fail.' . $br;
    echo 'Http Code : ' . $e->httpCode . $br;
    echo 'code : ' . $e->code . $br;
    echo 'message : ' . $e->message . $br;
    echo 'Response JSON : ' . $e->json . $br;
    echo 'rateLimitLimit : ' . $e->rateLimitLimit . $br;
    echo 'rateLimitRemaining : ' . $e->rateLimitRemaining . $br;
    echo 'rateLimitReset : ' . $e->rateLimitReset . $br;
} catch (APIConnectionException $e) {
    echo 'Push Fail.' . $br;
    echo 'message' . $e->getMessage() . $br;
}

echo $br . '-------------' . $br;

//full push
try {
    $result = $client->push()
        ->setPlatform(M\platform('ios', 'android'))
        ->setAudience(M\audience(M\tag(['555','666']), M\alias(['555', '666'])))
        ->setNotification(M\notification('Hi, JPush', M\android('Hi, android'), M\ios('Hi, ios', 'happy', 1, true)))
        ->setMessage(M\message('msg content', null, null, array('key'=>'value')))
        ->setOptions(M\options(123456, null, null, false))
        ->printJSON()
        ->send();

    echo 'Push Success.' . $br;
    echo 'sendno : ' . $result->sendno . $br;
    echo 'msg_id : ' .$result->msg_id . $br;
    echo 'Response JSON : ' . $result->json . $br;
} catch (APIRequestException $e) {
    echo 'Push Fail.' . $br;
    echo 'Http Code : ' . $e->httpCode . $br;
    echo 'code : ' . $e->code . $br;
    echo 'message : ' . $e->message . $br;
    echo 'Response JSON : ' . $e->json . $br;
    echo 'rateLimitLimit : ' . $e->rateLimitLimit . $br;
    echo 'rateLimitRemaining : ' . $e->rateLimitRemaining . $br;
    echo 'rateLimitReset : ' . $e->rateLimitReset . $br;
} catch (APIConnectionException $e) {
    echo 'Push Fail.' . $br;
    echo 'message' . $e->getMessage() . $br;
}



echo $br . '-------------' . $br;


//fail push
try {
    $result = $client->push()
        ->setPlatform(M\all)
        ->setAudience(M\all)
        ->setNotification(M\notification('Hi, JPush'))
        ->setAudience(M\audience(['no one']))
        ->printJSON()
        ->send();

    echo 'Push Success.' . $br;
    echo 'sendno : ' . $result->sendno . $br;
    echo 'msg_id : ' .$result->msg_id . $br;
    echo 'Response JSON : ' . $result->json . $br;
} catch (APIRequestException $e) {
    echo 'Push Fail.' . $br;
    echo 'Http Code : ' . $e->httpCode . $br;
    echo 'code : ' . $e->code . $br;
    echo 'message : ' . $e->message . $br;
    echo 'Response JSON : ' . $e->json . $br;
    echo 'rateLimitLimit : ' . $e->rateLimitLimit . $br;
    echo 'rateLimitRemaining : ' . $e->rateLimitRemaining . $br;
    echo 'rateLimitReset : ' . $e->rateLimitReset . $br;
} catch (APIConnectionException $e) {
    echo 'Push Fail.' . $br;
    echo 'message' . $e->getMessage() . $br;
}
