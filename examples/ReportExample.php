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

/*$master_secret = 'd94f733358cca97b18b2cb98';
$app_key='47a3ddda34b2602fa9e17c01';*/

$app_key = 'e5c0d34f58732cf09b2d4d74';
$master_secret = '4cdda6d3c8b029941dbc5cb3';


JPushLog::setLogHandlers(array(new StreamHandler('jpush.log', Logger::DEBUG)));
$client = new JPushClient($app_key, $master_secret);


try {
    echo '<h1>API /v3/report</h1>';
    $msg_ids = '1150720279,1492401191,1150722083';
    $result = $client->report($msg_ids);
    foreach($result->received_list as  $item) {
        echo '---------' . $br;
        echo 'msg_id : ' . $item->msg_id . $br;
        echo 'android_received : ' .  $item->android_received . $br;
        echo 'ios_apns_sent : ' .  $item->ios_apns_sent . $br;
    }
} catch (APIRequestException $e) {
    echo 'Push Fail.' . $br;
    echo 'Http Code : ' . $e->httpCode . $br;
    echo 'code : ' . $e->code . $br;
    echo 'Error Message : ' . $e->message . $br;
    echo 'Response JSON : ' . $e->json . $br;
    echo 'rateLimitLimit : ' . $e->rateLimitLimit . $br;
    echo 'rateLimitRemaining : ' . $e->rateLimitRemaining . $br;
    echo 'rateLimitReset : ' . $e->rateLimitReset . $br;
} catch (APIConnectionException $e) {
    echo 'Push Fail: ' . $br;
    echo 'Error Message: ' . $e->getMessage() . $br;
    //response timeout means your request has probably be received by JPUsh Server,please check that whether need to be pushed again.
    echo 'IsResponseTimeout: ' . $e->isResponseTimeout . $br;
}

echo '--------------------------' . $br;

try {
    echo '<h1>API /v3/messages</h1>';
    $msg_ids = '478284636,1150722083,979475499';
    $result = $client->messages($msg_ids);
    echo 'JSON : ' . $result->json . $br;
    foreach($result->received_list as  $item) {
        echo '---------' . $br;
        echo 'msg_id : ' . $item->msg_id . $br;
        if ($item->android) {
            $android = $item->android;
            echo 'android.received : ' .  $android->received . $br;
            echo 'android.target : ' .  $android->target . $br;
            echo 'android.online_push : ' .  $android->online_push . $br;
            echo 'android.click : ' .  $android->click . $br;
        }

        if ($item->ios) {
            $ios = $item->ios;
            echo 'ios.apns_send : ' . $ios->apns_sentz . $br;
            echo 'ios.apns_target : ' . $ios->apns_target . $br;
            echo 'ios.click : ' . $ios->click . $br;
        }
    }

} catch (APIRequestException $e) {
    echo 'Push Fail.' . $br;
    echo 'Http Code : ' . $e->httpCode . $br;
    echo 'code : ' . $e->code . $br;
    echo 'Error Message : ' . $e->message . $br;
    echo 'Response JSON : ' . $e->json . $br;
    echo 'rateLimitLimit : ' . $e->rateLimitLimit . $br;
    echo 'rateLimitRemaining : ' . $e->rateLimitRemaining . $br;
    echo 'rateLimitReset : ' . $e->rateLimitReset . $br;
} catch (APIConnectionException $e) {
    echo 'Push Fail: ' . $br;
    echo 'Error Message: ' . $e->getMessage() . $br;
    //response timeout means your request has probably be received by JPUsh Server,please check that whether need to be pushed again.
    echo 'IsResponseTimeout: ' . $e->isResponseTimeout . $br;
}



try {
    echo '<h1>API /v3/users</h1>';
    $result = $client->users('month', '2014-09', 2);
    echo 'time_unit:' . $result->time_unit . $br;
    echo 'start:' . $result->start . $br;
    echo 'step:' . $result->duration . $br;
    echo 'items:' . $br;
    foreach($result->items as $item) {
        echo $br . '--time:' . $item['time'] . $br;
        if ($item['android']) {
            $android = $item['android'];
            echo '--android.new:' . $android['new'] . $br;
            echo '--android.online:' . $android['online'] . $br;
            echo '--android.active:' . $android['active'] . $br;
        }
        if ($item['ios']) {
            $ios = $item['ios'];
            echo '--ios.new:' . $ios['new'] . $br;
            echo '--ios.active:' . $ios['active'] . $br;
        }
    }
} catch (APIRequestException $e) {
    echo 'Push Fail.' . $br;
    echo 'Http Code : ' . $e->httpCode . $br;
    echo 'code : ' . $e->code . $br;
    echo 'Error Message : ' . $e->message . $br;
    echo 'Response JSON : ' . $e->json . $br;
    echo 'rateLimitLimit : ' . $e->rateLimitLimit . $br;
    echo 'rateLimitRemaining : ' . $e->rateLimitRemaining . $br;
    echo 'rateLimitReset : ' . $e->rateLimitReset . $br;
} catch (APIConnectionException $e) {
    echo 'Push Fail: ' . $br;
    echo 'Error Message: ' . $e->getMessage() . $br;
    //response timeout means your request has probably be received by JPUsh Server,please check that whether need to be pushed again.
    echo 'IsResponseTimeout: ' . $e->isResponseTimeout . $br;
}

echo '--------------------------' . $br;