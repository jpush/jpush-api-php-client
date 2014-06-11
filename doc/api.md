# JPush API PHP Library doc

JPush API PHP Library 提供简化构建JPush Push JSON的API，开发者只需要完成一下几个操作就能完成一次推送。

 1. 指定推送的平台(platform)
 2. 指定推送的用户(audience)
 3. 构建推送的notification或者message
 4. 指定额外的配置options
 5. 调用推送


以下的示例推送一个广播通知给所有用户
```php
use JPush\Model as M;
use JPush\JPushClient;

$client = new JPushClient($app_key, $master_secret);
$result = $client->push()
    ->setPlatform(M\all)
    ->setAudience(M\all)
    ->setNotification(M\notification('Hi, JPush'))
    ->send();
```
以上所有的推送对象构建器，都在 namespace： `JPush\Model` 中
```php
use JPush\Model as M;
```
以下的示例获取特定ID的统计信息
```php
use JPush\JPushClient;
$client = new JPushClient($app_key, $master_secret);

$msg_ids = '1931816610,1466786990,1931499836';
$result = $client->report($msg_ids);

//处理返回
if ($result->ok) {
    echo 'ok : ' . ($result->ok ? 'true' : 'false') . $br;
    foreach($result->received_list as  $received) {
        echo '---------' . $br;
        echo 'msg_id : ' . $received->msg_id . $br;
        echo 'android_received : ' .  $received->android_received . $br;
        echo 'ios_apns_sent : ' .  $received->ios_apns_sent . $br;
    }
} else {
    echo 'ok : ' . ($result->ok ? 'true' : 'false') . $br;
    echo 'code : ' . $result->error->code . $br;
    echo 'message : ' . $result->error->message . $br;
}
```

## Payload Selectors
JPush Push JSON Model， JPush API v3中，每一个推送对象都是一个JSON对象。其具体结构可以参考 [推送对象][1]  
为了开发者更方便构建推送对象，本library提供以下方法：
#### `function: JPush/Model/send()`  
将本payload对象推送到JPUSH服务器  
返回：PushResponse 服务器响应对象 
PushResponse处理示例:
```php
if ($result->ok) {
    echo 'ok : ' . ($result->ok ? 'true' : 'false') . $br;
    echo 'sendno : ' . $result->sendno . $br;
    echo 'msg_id : ' .$result->msg_id . $br;
    echo $br . '---------' . $br;
} else {
    echo 'ok : ' . ($result->ok ? 'true' : 'false') . $br;
    echo 'code : ' . $result->error->code . $br;
    echo 'message : ' . $result->error->message . $br;
}
```

#### `function: JPush/Model/getJSON()`  
获取当前payload对象的JSON字符串，仅供调试使用  
返回：String JSON字符串  

#### `function: JPush/Model/printJSON()`    
打印当前JSON字符串，仅供调试使用  
返回：PushPayload 当前的payload对象  

#### `function: JPush/Model/setAudience()`  
设置audience  
返回：PushPayload 当前的payload对象  

#### `function: JPush/Model/setMessage()`  
设置audience  
返回：PushPayload 当前的payload对象  

#### `function: JPush/Model/setNotification()`  
设置audience  
返回：PushPayload 当前的payload对象  

#### `function: JPush/Model/setMessage()`  
设置audience  
返回：PushPayload 当前的payload对象  

#### `function: JPush/Model/setOptions()`  
设置audience  
返回：PushPayload 当前的payload对象  

### Platform Selectors

#### `constant: JPush/Model/all`
设置该payload为推送给所有平台（platform）
Example： 
```php
$payload->setPlatform(M\all);
```

#### `function: JPush/Model/platform(/* args */)`
构建platform对象
参数： 推送的平台字符串 （android， ios， winphone）
Example：
```php
$payload->setPlatform(M\platform('ios', 'android'))
```
### Audience Selectors

#### `constant: JPush/Model/all`
设置该payload为推送给所有用户（audience）
Example： 
```php
$payload->setAudience(M\all);
```
#### `function: JPush/Model/audience`
构建audience对象  
参数：tag(),tag_and(),alias(),registration_id()构建的对象
#### `function: JPush/Model/tag`
构建tag对象  
参数：tag数组
#### `function: JPush/Model/tag_and`
构建tag_and对象  
参数：tag_and数组
#### `function: JPush/Model/alias`
构建alias对象  
参数：alias数组
#### `function: JPush/Model/registration_id`
构建registration_id对象  
参数：registration_id数组

Example:
```php
$payload->setAudience(M\audience(
    M\tag(['tag1','tag2']), 
    M\alias(['alias1', 'alias2']),
    M\alias(["alias1", "alias2"]),
    M\registration_id(["id1", "id2"])));
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
#### `function: JPush/Model/notification($alert /* args */)`
构建notification对象
参数:$alert, ios(),android(),winphone()构建的对象
#### `function: JPush/Model/ios($alert, $sound=null, $badge=null, $contentAvailable=null, $extras=null)`
构建ios对象
#### `function: JPush/Model/android($alert, $title=null, $builder_id=null, $extras=null)`
构建android对象
#### `function: JPush/Model/winphone($alert, $title=null, $_open_page=null, $extras=null)`
构建winphone对象  
Example：
所有平台都推送同一通知
```php
$payload->setNotification(notification('Hi,JPush'));
```  
对象不同平台的通知，需要注意以下几点：  

 1. 如果不设定共同的alert， notification() 第一个参数要为null
 2. 第2,3,4个参数无排序要求

```php
$payload->setNotification(M\notification('Hi, JPush', 
    M\android('Hi, android'), 
    M\ios('Hi, ios', 'happy', 1, true)))；
```


### Message Selectors
#### `function： JPush/Model/message($msg_content, $title=null, $content_type=null, $extras=null)`
构建message对象
Example:  
```php
$payload->setMessage(M\message('msg content', null, null, array('key'=>'value')));
```
### Options Selectors
#### `function: options($sendno=null, $time_to_live=null, $override_msg_id=null, $apns_production=null)`  
构建options对象
Example：
```php
$payload->setOptions(M\options(123456, null, null, false))
```

## Report
#### `function: JPush\JPushClient::report($msg_ids)`
获取统计信息，msg_ids为推送API返回的 msg_id 列表，多个 msg_id 用逗号隔开，最多支持100个msg_id。具体细节可参考 [Report API][2]
返回：ReportREsponse 对象
Example：
```php
use JPush\JPushClient;
$client = new JPushClient($app_key, $master_secret);

$msg_ids = '1931816610,1466786990,1931499836';
$result = $client->report($msg_ids);

//处理返回
if ($result->ok) {
    echo 'ok : ' . ($result->ok ? 'true' : 'false') . $br;
    foreach($result->received_list as  $received) {
        echo '---------' . $br;
        echo 'msg_id : ' . $received->msg_id . $br;
        echo 'android_received : ' .  $received->android_received . $br;
        echo 'ios_apns_sent : ' .  $received->ios_apns_sent . $br;
    }
} else {
    echo 'ok : ' . ($result->ok ? 'true' : 'false') . $br;
    echo 'code : ' . $result->error->code . $br;
    echo 'message : ' . $result->error->message . $br;
}
```


  [1]: http://docs.jpush.cn/display/dev/Push-API-v3#Push-API-v3-%E6%8E%A8%E9%80%81%E5%AF%B9%E8%B1%A1
  [2]: http://docs.jpush.cn/display/dev/Report-API