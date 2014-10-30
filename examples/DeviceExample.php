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

$br = '<br/>';
$TAG1 = "tag1";
$ALIAS1 = "alias1";
$ALIAS2 = "alias2";
$REGISTRATION_ID1 = "0900e8d85ef";
$REGISTRATION_ID2 = "0a04ad7d8b4";

/*----Devices Example----*/

/*----Tags Example----*/

/*----Alias Example----*/

/*$result = $client->getDeviceTagAlias($REGISTRATION_ID1);
echo $result;*/

//{"alias": "alias1", "tags": ["tag1", "tag2"]}
/*$result = $client->getTags();
echo $result;*/

/*$result = ;
echo $result;*/

/*$result = $client->getAliasDevices($ALIAS1, array('android'));
echo $result;*/
/*
$result = $client->updateDeviceTagAlias($REGISTRATION_ID1, '_alias', array('tag1', 'tag2'));
echo $result;*/

//$result = $client->removeDeviceTag($REGISTRATION_ID1);
//echo $result;

//$result = $client->removeDeviceAlias($REGISTRATION_ID1);

/*echo $client->isDeviceInTag($REGISTRATION_ID2, $TAG1) . $br;
echo $client->updateTagDevices($TAG1, null, array($REGISTRATION_ID2)) . $br;
echo $client->isDeviceInTag($REGISTRATION_ID2, $TAG1) . $br;*/

/*
echo $client->getDeviceTagAlias($REGISTRATION_ID1);

echo $client->deleteAlias('_alias') . $br;
echo $client->deleteTag('tag1') . $br;

echo $client->getDeviceTagAlias($REGISTRATION_ID1);*/

