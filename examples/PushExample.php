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

$app_key='dd1066407b044738b6479275';
$master_secret = '6b135be0037a5c1e693c3dfa';
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

echo $br . '-------------' . $br;

// easy push with ios badge +1
// 以下演示推送给 Android, IOS 平台下Tag为tag1的用户的示例
try {
    $result = $client->push()
        ->setPlatform(M\Platform('android', 'ios'))
        ->setAudience(M\Audience(M\Tag(array('tag1'))))
        ->setNotification(M\notification('Hi, JPush',
            M\android('Hi, Android', 'Message Title', 1, array("key1"=>"value1", "key2"=>"value2")),
            M\ios("Hi, IOS", "happy", "+1", true, array("key1"=>"value1", "key2"=>"value2"), "Ios8 Category")
        ))
        ->setMessage(M\message('Message Content', 'Message Title', 'Message Type', array("key1"=>"value1", "key2"=>"value2")))
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

echo $br . '-------------' . $br;


//full push
try {
    $result = $client->push()
        ->setPlatform(M\platform('ios', 'android'))
        ->setAudience(M\audience(M\tag(array('555','666')), M\alias(array('555', '666'))))
        ->setNotification(M\notification('Hi, JPush', M\android('Hi, android'), M\ios('Hi, ios', 'happy', 1, true, null, 'THE-CATEGORY')))
        ->setMessage(M\message('msg content', null, null, array('key'=>'value')))
        ->setOptions(M\options(123456, null, null, false, 0))
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
    echo 'Push Fail: ' . $br;
    echo 'Error Message: ' . $e->getMessage() . $br;
    //response timeout means your request has probably be received by JPUsh Server,please check that whether need to be pushed again.
    echo 'IsResponseTimeout: ' . $e->isResponseTimeout . $br;
}



echo $br . '-------------' . $br;


//fail push
try {
    $result = $client->push()
        ->setPlatform(M\all)
        ->setAudience(M\all)
        ->setNotification(M\notification('Hi, JPush'))
        ->setAudience(M\audience(array('no one')))
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
    echo 'Push Fail: ' . $br;
    echo 'Error Message: ' . $e->getMessage() . $br;
    //response timeout means your request has probably be received by JPUsh Server,please check that whether need to be pushed again.
    echo 'IsResponseTimeout: ' . $e->isResponseTimeout . $br;
}
