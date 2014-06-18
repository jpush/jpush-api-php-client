<?php

require_once 'vendor/autoload.php';

use JPush\Model as M;
use JPush\JPushClient;

use JPush\Exception\APIConnectionException;
use JPush\Exception\APIRequestException;

$br = '<br/>';

$master_secret = 'd94f733358cca97b18b2cb98';
$app_key='47a3ddda34b2602fa9e17c01';
$client = new JPushClient($app_key, $master_secret);

//easy push
try {
    $result = $client->push()
        ->setPlatform(M\all)
        ->setAudience(M\all)
        ->setNotification(M\notification('Hi, JPush'))
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



