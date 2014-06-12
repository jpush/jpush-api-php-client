# JPush Api PHP client doc

## 简要概述 
本API主要实现了  

* JPushClient对象:用于推送PushPayload对象。
* PushPayload对象：单个推送的对象，其具体结构可以参考 [REST API文档 推送对象][1]





## PushPayload
PushPayload的子属性有

* Platform
* Audience
* Notification
* Message
* Options

其中Notification拥有子属性

* IOSNotification
* AndroidNotification
* WinphoneNotification
* alert

上述对象的接口可参考 [REST API文档 推送对象][2]

### 构建PushPayload
Easy Payload  
PushPayload在未指明platform与audience时，会自动设定为'all'
```php
$payload = new PushPayload();
$notification = new Notification();
$notification->alert = "alert message";
$payload->notification = $notification;
//打印该Payload的JSON对象。
echo json_encode($payload->toJSON());

```
打印的JSON字符串
```javascript
{
    "platform": "all",
    "audience": "all",
    "notification": {
        "alert": "alert message"
    }
}
```
Full Payload
```php
$android = new AndroidNotification();
$android->alert = "android alert";
$android->title = "android title";
$android->builder_id = 1;
$android->extras = array("key1"=>"value1", "key2"=>"value2");

$winphone = new WinphoneNotification();
$winphone->alert = "winphone alert";
$winphone->title = "winphone title";
$winphone->_open_page = "/friends.xaml";
$winphone->extras = array("key1"=>"value1", "key2"=>"value2");

$ios = new IOSNotification();
$ios->alert = "ios alert";
$ios->badge = 1;
$ios->content_available = 1;
$ios->sound = "happy";
$ios->extras = array("key1"=>"value1", "key2"=>"value2");

$notification = new Notification();
$notification->alert = "notification alert";
$notification->ios = $ios;
$notification->winphone = $winphone;
$notification->android = $android;

$options = new Options();
$options->apns_production = false;
$options->override_msg_id = 123456;
$options->sendno = 654321;
$options->time_to_live = 60;

$platform = new Platform();
$platform->ios = true;
$platform->android = true;
$platform->winphone = true;

$audience = new Audience();
$audience->tag = "tag1,tag2";
$audience->tag_and = "tag3";
$audience->alias = "alias1,alias2";
$audience->registration_id = "id1,id2";


$message = new Message();
$message->title = "message title";
$message->content_type = "message content type";
$message->msg_content = "message msg content";
$message->extras = array("key1"=>"value1", "key2"=>"value2");

$payload = new PushPayload();
$payload->platform = $platform;
$payload->audience = $audience;
$payload->message = $message;
$payload->notification = $notification;
$payload->options = $options;

//打印该Payload的JSON对象。
echo json_encode($payload->toJSON());
```
打印的JSON字符串
```javascript
{
    "platform": [
        "android",
        "ios",
        "winphone"
    ],
    "audience": {
        "tag": [
            "tag1",
            "tag2"
        ],
        "tag_and": [
            "tag3"
        ],
        "alias": [
            "alias1",
            "alias2"
        ],
        "registration_id": [
            "id1",
            "id2"
        ]
    },
    "notification": {
        "alert": "notification alert",
        "ios": {
            "alert": "ios alert",
            "sound": "happy",
            "badge": 1,
            "extras": {
                "key1": "value1",
                "key2": "value2"
            },
            "content-available": 1
        },
        "android": {
            "alert": "android alert",
            "title": "android title",
            "builder_id": 1,
            "extras": {
                "key1": "value1",
                "key2": "value2"
            }
        },
        "winphone": {
            "alert": "winphone alert",
            "title": "winphone title",
            "_open_page": "/friends.xaml",
            "extras": {
                "key1": "value1",
                "key2": "value2"
            }
        }
    },
    "message": {
        "msg_content": "message msg content",
        "title": "message title",
        "content_type": "message content type",
        "extras": {
            "key1": "value1",
            "key2": "value2"
        }
    },
    "options": {
        "sendno": 654321,
        "time_to_live": 60,
        "override_msg_id": 123456,
        "apns_production": false
    }
}
```
## JPushClient
### 构建
```php
$client = new JPushClient($app_key, $master_secret);
```
### sendPush
推送消息对象PushPayload
返回：服务器返回的JSON字符串，具体可参考 [返回示例][3]
```php
$result = $client->sendPush($payload);
```

### getReport
获取统计信息  
接收一个参数：msg_id，多个msg_id以，连接
返回：服务器返回的JSON字符串，具体可参考 [Report API][4]
```
$result7 = $client->getReport($msg_ids);
```


  [1]: http://docs.jpush.cn/display/dev/Push-API-v3#Push-API-v3-%E6%8E%A8%E9%80%81%E5%AF%B9%E8%B1%A1
  [2]: http://docs.jpush.cn/display/dev/Push-API-v3#Push-API-v3-%E6%8E%A8%E9%80%81%E5%AF%B9%E8%B1%A1
  [3]: http://docs.jpush.cn/display/dev/Push-API-v3#Push-API-v3-%E8%BF%94%E5%9B%9E%E7%A4%BA%E4%BE%8B
  [4]: http://docs.jpush.cn/display/dev/Report-API