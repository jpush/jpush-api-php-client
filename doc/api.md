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
#### `function JPush/Model/send()`  
将本payload对象推送到JPUSH服务器  
返回：PushResponse 服务器响应对象 

#### `function JPush/Model/getJSON()`  
获取当前payload对象的JSON字符串，仅供调试使用  
返回：String JSON字符串  

#### `function JPush/Model/printJSON()`    
打印当前JSON字符串，仅供调试使用  
返回：PushPayload 当前的payload对象  

#### `function JPush/Model/setAudience()`  
设置audience  
返回：PushPayload 当前的payload对象  

#### `function JPush/Model/setMessage()`  
设置audience  
返回：PushPayload 当前的payload对象  

#### `function JPush/Model/setNotification()`  
设置audience  
返回：PushPayload 当前的payload对象  

#### `function JPush/Model/setMessage()`  
设置audience  
返回：PushPayload 当前的payload对象  

#### `function JPush/Model/setOptions()`  
设置audience  
返回：PushPayload 当前的payload对象  

### Platform Selectors

### Audience Selectors

### Notification Selectors

### Message Selectors

### Options Selectors


  [1]: http://docs.jpush.cn/display/dev/Push-API-v3#Push-API-v3-%E6%8E%A8%E9%80%81%E5%AF%B9%E8%B1%A1