# JPush API PHP Library doc


JPush API PHP Library 提供简化构建JPush Push JSON的API，开发者只需要完成一下几个操作就能完成一次推送。

 1. 指定推送的平台(platform)
 2. 指定推送的用户(audience)
 3. 构建推送的notification或者message
 4. 指定额外的配置options
 5. 调用推送


## 版本更新

### v3.2.0
* 支持设置IOS Notification的category属性
    * 设置APNs payload中的"category"字段值(仅支持IOS8) 
* 支持设置big_push_duration属性
    * 指定时长。规定应在这个时间内推送完成，用于“定速推送”
* 新增Report接口
    * API /v3/messages 获取消息统计详细数据
    * API /v3/users 获取用户统计详细数据
* 新增Validate接口
    * 调用Validate可以模拟真实推送,获取msgId,查询影响人群以及其他统计信息,但JPush服务器不会将消息推送给目标用户 
* 新增Device API
    * getDeviceTagAlias 获取指定RegistrationId的所有属性，包含tags, alias
    * removeDeviceTag 移除指定RegistrationId的所有tag
    * removeDeviceAlias 移除指定RegistrationId的所有alias
    * updateDeviceTagAlias 更新指定RegistrationId的指定属性，当前支持tags, alias
    * getTags 获取当前应用的所有标签列表
    * isDeviceInTag 查询某个用户是否在tag下
    * updateTagDevices 对指定tag添加或者删除registrationId
    * deleteUpdate 删除指定Tag，以及与其关联的用户之间的关联关系
    * getAliasDevices 获取指定alias下的用户，最多输出10个
    * deleteAlias 删除指定alias，以及该alias与用户的绑定关系

### v3.1.2

* examples中加入**vendor.tar.gz**，现在开发者直接解压此文件到项目目录，引入 **vendor/autoload.php** 既可以使用**JPush**。
* 添加了IOS推送中，支持badge +1， badge -1的操作
    
    ```
    // badge 数值在原来的基础上+1
    ->setNotification(M\notification('Hi, JPush', M\ios("Hi, IOS", "happy", "+1")))
    // badge 数值在原来的基础上-1
    ->setNotification(M\notification('Hi, JPush', M\ios("Hi, IOS", "happy", "-1")))
    // badge 数值在原来的基础上+5
    ->setNotification(M\notification('Hi, JPush', M\ios("Hi, IOS", "happy", "+5")))
    ```
 
## 依赖

PHP >= 5.3

### Dependencies
* Composer
* Httpful
* Monolog

### Development Dependencies
* PHPUnit

### About Log
请确保当前用户对日志文件夹有读写权限。

## Example

以下的示例推送一个广播通知给所有用户
```php
require_once 'vendor/autoload.php';

use JPush\Model as M;
use JPush\JPushClient;
use JPush\Exception\APIConnectionException;
use JPush\Exception\APIRequestException;

$br = '<br/>';
$client = new JPushClient($app_key, $master_secret);

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
```
以上所有的推送对象构建器，都在 namespace： `JPush\Model` 中
```php
use JPush\Model as M;
```
以下的示例获取特定ID的统计信息
```php
require_once 'vendor/autoload.php';

use JPush\Model as M;
use JPush\JPushClient;
use JPush\Exception\APIConnectionException;
use JPush\Exception\APIRequestException;

$br = '<br/>';

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
```

## Payload Selectors
JPush Push JSON Model， JPush API v3中，每一个推送对象都是一个JSON对象。其具体结构可以参考 [推送对象][1]  
为了开发者更方便构建推送对象，本library提供以下方法：


`function: JPush/Model/send()`

将本payload对象推送到JPUSH服务器  
返回：PushResponse 服务器响应对象

 属性        | 类型 | 说明
 -------- | -----  | -----
 $sendno | int | 开发者指定的 API 调用标识
 $msg_id | long | 推送信息的唯一标示
 $json | string | 返回的JSON字符串
 $response | object | 返回的response

`function: JPush/Model/getJSON()`

获取当前payload对象的JSON字符串，仅供调试使用  
返回：String JSON字符串


`function: JPush/Model/printJSON()`

打印当前JSON字符串，仅供调试使用  
返回：PushPayload 当前的payload对象


`function: JPush/Model/setAudience()`

设置audience  
返回：PushPayload 当前的payload对象


`function: JPush/Model/setMessage()`

设置audience  
返回：PushPayload 当前的payload对象


`function: JPush/Model/setNotification()`

设置audience  
返回：PushPayload 当前的payload对象

`function: JPush/Model/setMessage()`

设置audience  
返回：PushPayload 当前的payload对象

`function: JPush/Model/setOptions()`

设置audience  
返回：PushPayload 当前的payload对象  

### Platform Selectors

`constant: JPush/Model/all`

设置该payload为推送给所有平台（platform）

Example： 
```php
$payload->setPlatform(M\all);
```

`function: JPush/Model/platform(/* args */)`

构建platform对象
参数： 推送的平台字符串 （android， ios， winphone）

Example：
```php
$payload->setPlatform(M\platform('ios', 'android'))
```
### Audience Selectors

`constant: JPush/Model/all`

设置该payload为推送给所有用户（audience）

Example： 
```php
$payload->setAudience(M\all);
```
`function: JPush/Model/audience`

构建audience对象  
参数：tag(),tag_and(),alias(),registration_id()构建的对象

`function: JPush/Model/tag`

构建tag对象  
参数：tag数组

`function: JPush/Model/tag_and`

构建tag_and对象  
参数：tag_and数组

`function: JPush/Model/alias`

构建alias对象  
参数：alias数组

`function: JPush/Model/registration_id`

构建registration_id对象
参数：registration_id数组


Example:
```php
$payload->setAudience(M\audience(
    M\tag(array('tag1','tag2')), 
    M\alias(array('alias1', 'alias2'),
    M\alias(array("alias1", "alias2")),
    M\registration_id(array("id1", "id2"))));
```
or：
```php
$payload->setAudience(M\audience(array("tag1", "tag2")));
```  
推送给所有用户：
```php
$payload->setAudience(M\all);
```
### Notification Selectors
`function: JPush/Model/notification($alert /* args */)`

构建notification对象

参数:$alert, ios(),android(),winphone()构建的对象

`function: JPush/Model/ios($alert, $sound=null, $badge=null, $contentAvailable=null, $extras=null)`

构建ios对象

`function: JPush/Model/android($alert, $title=null, $builder_id=null, $extras=null, $category=null)`

构建android对象

`function: JPush/Model/winphone($alert, $title=null, $_open_page=null, $extras=null)`

构建winphone对象

Example：
所有平台都推送同一通知

```php
$payload->setNotification(notification('Hi,JPush'));
```  
对象不同平台的通知，需要注意以下几点：  

 1. 设置ios消息时，默认sound=''，如果不需要sound，请指定sound为M\disableSound.
 2. 设置ios消息时，默认badge=１，如果不需要badge,请指定badge为M\disableBadge.

```php
$payload->setNotification(M\notification('Hi, JPush', 
    M\android('Hi, android'), 
    M\ios('Hi, ios', 'happy', 1, true)))；
```


### Message Selectors
`function： JPush/Model/message($msg_content, $title=null, $content_type=null, $extras=null)`

构建message对象
Example:  
```php
$payload->setMessage(M\message('msg content', null, null, array('key'=>'value')));
```
### Options Selectors

`function: options($sendno=null, $time_to_live=null, $override_msg_id=null, $apns_production=null, $big_push_duration=null)`

构建options对象

|PARAMS|DESCRIPTION|REQUIRE|
|----|----|----|
|sendno|-|false|
|time_to_live|离线消息保留时长（秒）。如果不填默认 1 天。不能小于 0|false|
|override_msg_id|要覆盖的消息ID。必须大于 0|false|
|apns_production|APNs 是否生产环境推送。默认为 True|false|
|big_push_duration|大推送指定时长。规定应在这个时间内推送完成，用于“定速推送,单位:分钟|false|


Example：
```php
$payload->setOptions(M\options(123456, null, null, false, 60))
```

### Vaildate 

| Method | Description |
| ------- | ------ |
| isIosExceedLength | 检测当前payload是否超出ios notification长度限定。返回true/false。（ios notification不超过220并且ios notification + message不超过1200） |
| isGlobalExceedLength | 检测当前payload是否超出长度限定。返回true/false。（ios notification不超过220并且所有平台的notification + message不超过1200） |


## Report API
`function: JPush\JPushClient::report($msg_ids)`

获取统计信息，msg_ids为推送API返回的 msg_id 列表，多个 msg_id 用逗号隔开，最多支持100个msg_id。具体细节可参考 [Report API][2]
返回：ReportREsponse 对象
Example：
```php
require_once 'vendor/autoload.php';

use JPush\Model as M;
use JPush\JPushClient;
use JPush\Exception\APIConnectionException;
use JPush\Exception\APIRequestException;

$br = '<br/>';

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
```
`function: JPush\JPushClient::messages($msg_ids)`
获取指定msg_ids的详细统计报告，msg_ids为推送API返回的 msg_id 列表，多个 msg_id 用逗号隔开，最多支持100个msg_id。具体细节可参考 [Report API][2]

`function: JPush\JPushClient::users($time_unit, $start, $duration)`

获取当前应用指定时间段内的用户统计数据

* time_unit 时间单位，有 3 个可选：HOUR, DAY, MONTH （这三个字串有效，兼容大小写）
* start 起始时间。根据 time_unit 不同，有效值是不同的。取一般的年月日时字符串形式，比如 "2014-06-06 12"，即年月日用 "-" 隔开，时用空格隔开。
* duration 基于起始时间的步长。即从起始时间开始持续多久。只支持查询60天以内的用户信息。


## Device API
`function: JPush\JPushClient::getDeviceTagAlias($registrationId)`  

获取指定RegistrationId的所有属性，包含tags, alias

`function: JPush\JPushClient::removeDeviceTag($registrationId)`  

移除指定RegistrationId的所有tag

`function: JPush\JPushClient::removeDeviceAlias($registrationId)`  

移除指定RegistrationId的所有alias

`function: JPush\JPushClient::updateDeviceTagAlias($registrationId, $alias = null, $addTags = null, $removeTags = null)`  

更新指定RegistrationId的指定属性，当前支持tags, alias

`function: JPush\JPushClient::getTags()`  

获取当前应用的所有标签列表

`function: JPush\JPushClient::isDeviceInTag($registrationId, $tag)`  

查询某个用户是否在tag下

`function: JPush\JPushClient::updateTagDevices($tag, $addDevices = null, $removeDevices = null)`  
对指定tag添加或者删除registrationId

`function: JPush\JPushClient::deleteUpdate($tag)`  

删除指定Tag，以及与其关联的用户之间的关联关系

`function: JPush\JPushClient::getAliasDevices($alias, $platform = null)`  

获取指定alias下的用户，最多输出10个

`function: JPush\JPushClient::deleteAlias($alias)`  

删除指定alias，以及该alias与用户的绑定关系


## Validate API
与Push API调用方法一致,但最终不执行推送操作
Example:
```
$result = $client->push()
        ->setPlatform(M\all)
        ->setAudience(M\all)
        ->setNotification(M\notification('Hi, JPush'))
        ->setAudience(M\audience(array('no one')))
        ->printJSON()
        ->validate();
```


  [1]: http://docs.jpush.cn/display/dev/Push-API-v3#Push-API-v3-%E6%8E%A8%E9%80%81%E5%AF%B9%E8%B1%A1
  [2]: http://docs.jpush.cn/display/dev/Report-API
