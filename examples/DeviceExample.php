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
$TAG2 = "tag2";
$TAG3 = "tag3";
$TAG4 = "tag4";
$ALIAS1 = "alias1";
$ALIAS2 = "alias2";
$REGISTRATION_ID1 = "0900e8d85ef";
$REGISTRATION_ID2 = "0a04ad7d8b4";

/*----Common Method----*/
function printAPIRequestErrorStack($e) {
    $br = '<br/>';
    echo 'Push Fail.' . $br;
    echo 'Http Code : ' . $e->httpCode . $br;
    echo 'code : ' . $e->code . $br;
    echo 'Error Message : ' . $e->message . $br;
    echo 'Response JSON : ' . $e->json . $br;
    echo 'rateLimitLimit : ' . $e->rateLimitLimit . $br;
    echo 'rateLimitRemaining : ' . $e->rateLimitRemaining . $br;
    echo 'rateLimitReset : ' . $e->rateLimitReset . $br;
}

function printAPIConnectionErrorStack($e) {
    $br = '<br/>';
    echo 'Push Fail: ' . $br;
    echo 'Error Message: ' . $e->getMessage() . $br;
    //response timeout means your request has probably be received by JPUsh Server,please check that whether need to be pushed again.
    echo 'IsResponseTimeout: ' . $e->isResponseTimeout . $br;
}


/*----Devices Example----*/
try {
    //获取当前用户的所有属性，包含tags, alias。
    $result = $client->getDeviceTagAlias($REGISTRATION_ID1);
    $payload = $result->body;
    echo '<b>getDeviceTagAlias</b>' . $br;
    echo '----Alias:' . $payload['alias'] . $br;
    echo '----Tags:' . json_encode($payload['tags']) . $br;
    echo $br;
} catch (APIRequestException $e) {
    printAPIRequestErrorStack($e);
} catch (APIConnectionException $e) {
    printAPIConnectionErrorStack($e);
}

try {
    //移除指定RegistrationId的所有alias
    $result = $client->removeDeviceAlias($REGISTRATION_ID1);
    echo '<b>removeDeviceAlias</b>' . $br;
    if ($result->isOk) {
        echo 'Remove Device Alias Success' . $br;
    } else {
        echo 'Remove Device Alias Fail' . $br;
    }
    echo $br;
} catch (APIRequestException $e) {
    printAPIRequestErrorStack($e);
} catch (APIConnectionException $e) {
    printAPIConnectionErrorStack($e);
}


try {
    //移除指定RegistrationId的所有tag
    $result = $client->removeDeviceTag($REGISTRATION_ID1);
    echo '<b>removeDeviceTag</b>' . $br;
    if ($result->isOk) {
        echo 'Remove Device Tag Success' . $br;
    } else {
        echo 'Remove Device Tag Fail' . $br;
    }
    echo $br;
} catch (APIRequestException $e) {
    printAPIRequestErrorStack($e);
} catch (APIConnectionException $e) {
    printAPIConnectionErrorStack($e);
}


try {
    //更新指定RegistrationId的指定属性，当前支持tags, alias
    $result = $client->updateDeviceTagAlias($REGISTRATION_ID1, $ALIAS1, array($TAG1, $TAG2), array($TAG3));
    echo '<b>updateTagDevices</b>' . $br;
    if ($result->isOk) {
        echo 'Update Device Tag and Alias Success' . $br;
    } else {
        echo 'Update Device Tag and Alias Fail' . $br;
    }
    echo $br;
} catch (APIRequestException $e) {
    printAPIRequestErrorStack($e);
} catch (APIConnectionException $e) {
    printAPIConnectionErrorStack($e);
}


/*----Tags Example----*/
try {
    //获取当前应用的所有标签列表
    $result = $client->getTags();
    $payload = $result->body;
    echo '<b>getTags</b>' . $br;
    echo 'Tags:' . json_encode($payload['tags']) . $br;
    echo $br;
} catch (APIRequestException $e) {
    printAPIRequestErrorStack($e);
} catch (APIConnectionException $e) {
    printAPIConnectionErrorStack($e);
}

try {
    //查询某个用户是否在tag下
    $result = $client->isDeviceInTag($REGISTRATION_ID1, $TAG1);
    $payload = $result->body;
    echo '<b>isDeviceInTag</b>' . $br;
    echo 'isDeviceInTag:' . json_encode($payload['result']) . $br;
    echo $br;
} catch (APIRequestException $e) {
    printAPIRequestErrorStack($e);
} catch (APIConnectionException $e) {
    printAPIConnectionErrorStack($e);
}

try {
    //对指定tag添加或者删除registrationId
    $result = $client->updateTagDevices($TAG1, array($REGISTRATION_ID1), array($REGISTRATION_ID2));
    echo '<b>updateTagDevices</b>' . $br;
    if ($result->isOk) {
        echo 'Update Tag Devices Success' . $br;
    } else {
        echo 'Update Tag Devices Fail' . $br;
    }
    echo $br;
} catch (APIRequestException $e) {
    printAPIRequestErrorStack($e);
} catch (APIConnectionException $e) {
    printAPIConnectionErrorStack($e);
}

try {
    //删除指定Tag，以及与其关联的用户之间的关联关系
    $result = $client->deleteTag($TAG2);
    echo '<b>deleteTag</b>' . $br;
    if ($result->isOk) {
        echo 'Delete Tag Success' . $br;
    } else {
        echo 'Delete Tag Fail' . $br;
    }
    echo $br;
} catch (APIRequestException $e) {
    printAPIRequestErrorStack($e);
} catch (APIConnectionException $e) {
    printAPIConnectionErrorStack($e);
}

/*----Alias Example----*/
try {
    //删除指定alias，以及该alias与用户的绑定关系
    $result = $client->getAliasDevices($ALIAS1, array('ios', 'android'));
    $payload = $result->body;
    echo '<b>getAliasDevices</b>' . $br;
    echo 'Registration_ids:' . json_encode($payload['registration_ids']) . $br;
    echo $br;
} catch (APIRequestException $e) {
    printAPIRequestErrorStack($e);
} catch (APIConnectionException $e) {
    printAPIConnectionErrorStack($e);
}

try {
    $result = $client->deleteAlias($ALIAS2);
    echo '<b>deleteAlias</b>' . $br;
    if ($result->isOk) {
        echo 'Delete Alias Success' . $br;
    } else {
        echo 'Delete Alias Fail' . $br;
    }
    echo $br;
} catch (APIRequestException $e) {
    printAPIRequestErrorStack($e);
} catch (APIConnectionException $e) {
    printAPIConnectionErrorStack($e);
}

