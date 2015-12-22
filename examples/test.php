<?php

require_once("./JPush.php");
//
//$pushPayload = new PushPayload("");
//
//
//$body = $pushPayload->setPlatform("all")
//    ->addAlias("xiezefan")
//    ->setNotificationAlert("Hi, Alert")
//    ->addIosNotification(array("key1"=>"value1", "key2"=>"value2"), "sound", "+1", true, "Hi, category", array("key1"=>"value1", "key2"=>"value2"))
//    ->addAndroidNotification("Hi, android", "Hi title", null, array("key1"=>"value1", "key2"=>"value2"))
//    ->addWinPhoneNotification("Hi, winPhone", "Hi, title", "Hi, open page", array("key1"=>"value1", "key2"=>"value2"))
//    ->setMessage("Hi, message", "Hi, title", "Hi, type", array("key1"=>"value1", "key2"=>"value2"))
//    //->setSmsMessage('Hi, JPush', 10)
//    ->toJSON();



//$client = new JPush('94426bda4a12dd1fe5221375', '967b5c5266d33f489781d2ac');
$client = new JPush('25aae055e4418ac11a18c19d', 'aac73637b983b326b395dbd9');
//try {
//
//} catch (APIRequestException $e) {
//    echo 'Exception=' . json_encode($e);
//
//}
$response = $client->push()
    ->setPlatform("all")
    ->addAllAudience()
    ->setNotificationAlert("Hi, Alert")
    ->addIosNotification(array("key1"=>"value1", "key2"=>"value2"), "sound", "+1", true, "Hi, category", array("key1"=>"value1", "key2"=>"value2"))
    ->addAndroidNotification("Hi, android", "Hi title", null, array("key1"=>"value1", "key2"=>"value2"))
    ->addWinPhoneNotification("Hi, winPhone", "Hi, title", "Hi, open page", array("key1"=>"value1", "key2"=>"value2"))
    ->setMessage("Hi, message", "Hi, title", "Hi, type", array("key1"=>"value1", "key2"=>"value2"))
    ->printJSON()
    ->send();
echo "\r\n";
echo 'Response=' . json_encode($response);
echo "\r\n";
echo 'Response=' . $response->limit->rateLimitLimit;


echo "\r\n";

//$response = $client->report()->getReceived(array('541778586', '1235578218'));
$response = $client->report()->getMessages('541778586,1235578218');
echo "\r\n";
echo 'Response=' . json_encode($response);
echo "\r\n";
echo 'Response=' . $response->limit->rateLimitLimit;

echo "\r\n";

$client = new JPush('dd1066407b044738b6479275', '2b38ce69b1de2a7fa95706ea');
$response = $client->report()->getUsers('DAY', '2014-06-10', 3);
echo "\r\n";
echo 'Response=' . json_encode($response);
echo "\r\n";
echo 'Response=' . $response->limit->rateLimitLimit;