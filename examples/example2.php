<?php
include_once '../src/JPush/Model/Audience.php';
include_once '../src/JPush/Model/Message.php';
include_once '../src/JPush/Model/Notification.php';
include_once '../src/JPush/Model/Options.php';
include_once '../src/JPush/Model/Platform.php';
include_once '../src/JPush/Model/PushPayload.php';
include_once '../src/JPush/JPushClient.php';

use JPush\Model as M;
use JPush\JPushClient;

$br = '<br/>';


/*echo json_encode(P\tag(array("tag1", "tag2"))) . $br;
echo json_encode(P\alias(array("alias1", "alias2"))) . $br;

$json = P\audience(P\tag(array("tag1", "tag2")), P\alias(array("alias1", "alias2")));

echo json_encode($json);*/

//$test = M\tag(array("tag1", "tag2"));
//echo strlen($test);

$client = new JPushClient('appkey', 'masterSecret');

$json = $client->push()
    ->setPlatform(M\platform('ios', 'winphone', 'android'))
    ->setAudience(M\audience(M\tag(['tag1', 'tag2']), M\tag_and(['tag3', 'tag4'])))
    ->setNotification(M\notification('Hi,JPush!', null, M\ios('Hi,IOS', 'happy', 1)))
    ->setMessage(M\message('msg content'))
    ->setOptions(M\options(123456, 60))
    ->getJSON();

echo $json;


