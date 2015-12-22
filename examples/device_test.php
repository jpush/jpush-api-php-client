<?php
require_once("./JPush.php");

$client = new JPush('94426bda4a12dd1fe5221375', '967b5c5266d33f489781d2ac');
//

//$response = $client->device()->updateDevice('070b1c00c13', 'xiezefan1', array('sms_test'));
//echo "\r\n";
//echo 'Response=' . json_encode($response);

$response = $client->device()->deleteAlias('xiezefan1');
echo "\r\n";
echo 'Response=' . json_encode($response);

$response = $client->device()->getDevices('070b1c00c13');

echo "\r\n";
echo 'Response=' . json_encode($response);

//$response = $client->device()->getTags();
//
//echo "\r\n";
//echo 'Response=' . json_encode($response);
//
//
//$response = $client->device()->isDeviceInTag("070b1c00c13", 'sms_test');
//
//echo "\r\n";
//echo 'Response=' . json_encode($response);

//$response = $client->device()->updateTag('sms_test', null, array('070b1c00c13'));
//
//echo "\r\n";
//echo 'Response=' . json_encode($response);
//
//
//$response = $client->device()->deleteTag('sms_test1');
//
//echo "\r\n";
//echo 'Response=' . json_encode($response);

//$response = $client->device()->getAliasDevices("xiezefan", 'android,ios');
//
//echo "\r\n";
//echo 'Response=' . json_encode($response);


//$response = $client->device()->getDevicesStatus('070b1c00c13,080b6caf096');
//
//echo "\r\n";
//echo 'Response=' . json_encode($response);