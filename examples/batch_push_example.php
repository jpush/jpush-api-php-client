<?php
// 这只是使用样例,不应该直接用于实际生产环境中 !!

require 'config.php';

$singlePayloads = array(
    array(
        'platform' => 'all',
        'target' => 'regid1',
        'notification' => array(
           'alert' => 'NotificationAlert1'
        )
    ),
    array(
        'platform' => 'all',
        'target' => 'regid2',
        'notification' => array(
           'alert' => 'NotificationAlert2'
        )
    )
);

$push_payload = $client -> push();
try {
    $response = $push_payload -> batchPushByRegid($singlePayloads);
    print_r($response);
    $response = $push_payload -> batchPushByAlias($singlePayloads);
    print_r($response);
} catch (\JPush\Exceptions\APIConnectionException $e) {
    // try something here
    print $e;
} catch (\JPush\Exceptions\APIRequestException $e) {
    // try something here
    print $e;
}