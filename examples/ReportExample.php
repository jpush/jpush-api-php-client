<?php
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


try {
    $msg_ids = '1931816610,1466786990,1931499836';
    $result = $client->report($msg_ids);
    foreach($result->received_list as  $received) {
        echo '---------' . $br;
        echo 'msg_id : ' . $received->msg_id . $br;
        echo 'android_received : ' .  $received->android_received . $br;
        echo 'ios_apns_sent : ' .  $received->ios_apns_sent . $br;
    }
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


