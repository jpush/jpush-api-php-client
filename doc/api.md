# JPush PHP Server SDK Doc

JPush PHP Server SDK主要提供4部分API

* [Push API](http://docs.jpush.io/server/rest_api_v3_push/)
* [Report API](http://docs.jpush.io/server/rest_api_v3_report/)
* [Device API](http://docs.jpush.io/server/rest_api_v3_device/)
* [Schedule API](http://docs.jpush.io/server/rest_api_push_schedule/)


### Init API : 初始化

在调用推送之前，我们必须先初始化JPush，调用以下代码可以进行快速初始化

```php
$client = new JPush($app_key, $master_secret);
```

在初始化JPush的时候，可以指定一些初始参数，如**日志路径**，**失败请求最大重试次数**

```php
$client = new JPush($app_key, $master_secret, $log_path, $max_retry_times);
```

PS:

* 默认日志路径为`./jpush.log`,即保存在当前运行目录，如果想关闭日志，可以指定为`null`。
* 默认请求失败最大重试次数为3，如果想请求关闭失败重试功能，可以指定为`null`。

### Push API : 构建推送PushPayload

在初始化JPush后，调用以下代码将返回一个推送Payload构建器，它提供丰富的API来帮助你构建PushPayload。

```php
$push = $client->push();
```
通过[JPush Push API](docs.jpush.io/server/rest_api_v3_push/) 我们知道，一个PushPayload是由以下几个部分构成的：

* Platform
* Audience
* Notification
* Message
* SmsContent
* Options

接下来我们将了解如何用PushPayload构建器灵活地创建PushPayload。

#### Platform Setter

我们可以通过以下代码指定Platform的对象为`all`

```php
$push->setPlatform('all')
```
如果想指定为特定平台:

```php
$push->setPlatform('ios', 'android')
```

亦或者:

```php
$push->setPlatform(array('ios', 'android'))
```

#### Audience Setter

我们可以通过以下代码指定Audience的对象为`all`

```php
$push->addAllAudience()
```

当然，为了保持API风格的统一，我们也提供一下方法将Audience指定的`all`

```php
$push->setAudience('all')
```

以下示例如何指定Audience的Tags

```php
$push->addTags('tag1');
```

如果需要同时指定多个Tags, 可以用一下方法调用

```php
$push->addTags(array('tag1', 'tag2'));
```

其他诸如 `addAlias()`, `addRegistrationId()`, `addTagAnd()`的使用方法与`addTags()`类似，在此不做赘述。

PS:可以多次调用addXXX操作，最终将在多次结果中取并集。

#### Notification Setter

如果你只是想简单地给所有平台推送相同的消息的话，调用以下方法：

```php
$push->setNotificationAlert($alert)
```

我们也提供单独添加各个移动平台的Notification的方法。

**添加iOS Notification:**

```php
$push->addIosNotification($alert=null, $sound=null, $badge=null, $content_available=null, $category=null, $extras=null)
```

参数说明:

* alert:`String|Array` 通知内容，这里指定了，将会覆盖上级统一指定的`setNotificationAlert()`信息；内容为空则不展示到通知栏。支持 emoji 表情。
    * iOS8.2及以上alert支持JSON格式，可以指定alert为一个Array，如`$alert=array("key1"=>"value1", "key2"=>"value2")`
* sound:`String` 通知提示声音，如果无此字段，则此消息无声音提示；有此字段，如果找到了指定的声音就播放该声音，否则播放默认声音,如果此字段为空字符串，iOS 7 为默认声音，iOS 8 为无声音。
    * 如果为null或者不显式指定，则填充为默认值`''`空字符串
    * 如果不想指定Sound，可以显式的指定为`JPush::DISABLE_SOUND`
* badge:`Int` 应用角标，如果不填，表示不改变角标数字；否则把角标数字改为指定的数字；为 0 表示清除。支持`+1`,`-1`这样的字符串，表示在原有的badge基础上进行增减。
    * 示例：`0`, `1`, `+1`, `-1`
    * 如果为null或者不显式指定，则填充为默认值`+1`
    * 如果想不指定Badge，可以显式的指定为`JPush::DISABLE_BADGE`
* content_abaliable:`Bool` 推送唤醒，为真是表示是`Background Remote Notification`, 不指定则表示是`Remote Notification`
* category: `String` iOS8才支持。设置APNs payload中的"category"字段值
* extras: `Array` 扩展字段，这里自定义 Key/value 信息，以供业务使用
    * 示例：`$extras=array("key1"=>"value1", "key2"=>"value2")`

**添加Android Notification**

```php
$push->addAndroidNotification($alert=null, $title=null, $builderId=null, $extras=null)
```

参数说明:

* alert:`String` 通知内容，这里指定了，将会覆盖上级统一指定的`setNotificationAlert()`信息；内容为空则不展示到通知栏。
* title:`String` 通知标题，如果指定了，则通知里原来展示 App名称的地方，将展示成这个字段。
* builderId:`Int` 通知栏样式ID
* extras:`Array` 扩展字段，这里自定义 Key/value 信息，以供业务使用
    * 示例：`$extras=array("key1"=>"value1", "key2"=>"value2")`

**添加WinPhone Notification**

```php
$push->addWinPhoneNotification($alert=null, $title=null, $_open_page=null, $extras=null)
```

参数说明:

* alert:`String` 通知内容，这里指定了，将会覆盖上级统一指定的`setNotificationAlert()`信息；内容为空则不展示到通知栏。
* title:`String` 通知标题，会填充到 toast 类型 text1 字段上。
* \_open\_page:`String` 点击打开的页面名称
* extras:`Array` 扩展字段，这里自定义 Key/value 信息，以供业务使用
    * 示例：`$extras=array("key1"=>"value1", "key2"=>"value2")`

#### Message Setter

我们可以通过以下方法设置自定义消息Message

```php
$push->setMessage($msg_content, $title=null, $content_type=null, $extras=null)
```

参数说明:

* msg_content:`String` 消息内容本身
* title:`String` 消息标题
* content_type:`String` 消息类型
* extras:`Array` 扩展字段，这里自定义 Key/value 信息，以供业务使用
    * 示例：`$extras=array("key1"=>"value1", "key2"=>"value2")`

#### Sms Message Setter

我们可以通过以下方法设置短信推送消息

```php
$push->setSmsMessage($content, $delay_time)
```

参数说明:

* content:`String` 短信文本，不超过480字符
* delay_time:`Int` 只对Android平台有效，表示指定时间内没收到Push即发送短信

#### Options Setter

我们可以通过以下方法设置Options

```php
$push->setOptions($sendno=null, $time_to_live=null, $override_msg_id=null, $apns_production=null, $big_push_duration=null)
```

参数说明:

* sendno:`Int` 推送序号, 纯粹用来作为 API 调用标识，API 返回时被原样返回，以方便 API 调用方匹配请求与返回。
    * 如未指定或者指定为`null`，则随机生产一个sendno序号
* time\_to\_live:`Int` 离线消息保留时长(秒)，推送当前用户不在线时，为该用户保留多长时间的离线消息，以便其上线时再次推送。
    * 默认 86400 （1 天），最长 10 天。
    * 设置为 0 表示不保留离线消息，只有推送当前在线的用户可以收到。
* override\_msg\_id:`Int` 要覆盖的消息ID，如果当前的推送要覆盖之前的一条推送，这里填写前一条推送的 msg_id 就会产生覆盖效果，
    * 该 msg_id 离线收到的消息是覆盖后的内容；
    * 即使该 msg\_id Android 端用户已经收到，如果通知栏还未清除，则新的消息内容会覆盖之前这条通知；覆盖功能起作用的时限是：1 天。如果在覆盖指定时限内该 msg\_id 不存在，则返回 1003 错误，提示不是一次有效的消息覆盖操作，当前的消息不会被推送。
* apns\_production:`Bool` APNs是否生产环境，True 表示推送生产环境，False 表示要推送开发环境；如果不指定则为推送生产环境。JPush 官方 API LIbrary (SDK) 默认设置为推送 “开发环境”。
    * 如未指定或者指定为`null`, 则默认指定为`false`
* big\_push\_duration:`Int` 定速推送时长(分钟), 又名缓慢推送，把原本尽可能快的推送速度，降低下来，给定的n分钟内，均匀地向这次推送的目标用户推送。
    * 最大值为1400.未设置则不是定速推送。

#### Common Method

**获得当前构建对象**

```php
$push->build();
```

**将当前构建对象打印在控制台**

```php
$push->printJSON()
```

**发送推送**
该方法内部将自动调用构建方法获得当前构建对象，并转化为JSON向JPush服务器发送请求

```php
$push->send()
```

PS: 构建PushPayload的API每一次都会返回自身的引用，所以我们可用使用链式调用的方法提高代码的简洁性，如:

```php
$result = $client->push()
    ->setPlatform(array('ios', 'android'))
    ->addAlias('alias1')
    ->addTag(array('tag1', 'tag2'))
    ->setNotificationAlert('Hi, JPush')
    ->addAndroidNotification('Hi, android notification', 'notification title', 1, array("key1"=>"value1", "key2"=>"value2"))
    ->addIosNotification("Hi, iOS notification", 'iOS sound', JPush::DISABLE_BADGE, true, 'iOS category', array("key1"=>"value1", "key2"=>"value2"))
    ->setMessage("msg content", 'msg title', 'type', array("key1"=>"value1", "key2"=>"value2"))
    ->setOptions(100000, 3600, null, false)
    ->send();
```

### Report API

在初始化JPush后，调用以下代码将返回report对象，它提供丰富的API来帮助你获取Report数据。

```php
 $report = $client->report()
 ```


#### 获取送达统计

调用一下代码可以获取送达统计

```php
$result = $report->getReceived('1150720279');
```

如果你想一次性查询多个MsgId的送达统计，可以使用以下方法调用

```php
$result = $report->getReceived('1150720279,1492401191,1150722083');
```

或者

```php
$result = $report->getReceived(array('1150720279', '1492401191', '1150722083'));
```


#### 获取消息统计

调用一下代码可以获取消息统计

```php
$report->getMessages('541778586,1235578218')
```

消息统计与送达统计一样，接受一个数组的参数，在这里不做赘述

#### 获取用户统计

调用一下代码可以获得用户统计

```php
$report->getUsers($time_unit, $start, $duration)
```

参数说明:

* time_unit:`String` 时间单位, 可取值HOUR, DAY, MONTH
* start:`String` 起始时间
    * 如果单位是小时，则起始时间是小时（包含天），格式例：2014-06-11 09
    * 如果单位是天，则起始时间是日期（天），格式例：2014-06-11
    * 如果单位是月，则起始时间是日期（月），格式例：2014-06
* duration:`String` 持续时长
    * 如果单位是天，则是持续的天数。以此类推
    * 只支持查询60天以内的用户信息，对于time_unit为HOUR的，只支持输出当天的统计结果。



### Device API

在初始化JPush后，调用以下代码将返回device对象，它提供丰富的API来帮助操作Device API

```php
$device = $client->device();
```

#### 操作Device(registration_id)

**查询指定设备的别名与标签**

```php
$device->getDevices($registration_id);
```


**更新指定设备的别名与标签**

```php
$device-> updateDevice($registrationId, $alias = null, $addTags = null, $removeTags = null)
```

参数说明:

* $alais:`String` 别名
* $addTags:`Array` 增加的Tags
* $removeTags:`Array` 移除的Tags

**获取在线用户的登录状态**

```php
$device->getDevicesStatus($registrationId)
```

参数说明:

* registrationId可以指定为一个registrationId的数组，亦可以指定为字符串，多个registrationId以逗号分隔

#### 操作Tag

**获取Tag列表**

```php
$device->getTags()
```

**判断指定设备是否在指定Tag之下**

```php
$device->isDeviceInTag($registrationId, $tag)
```

**更新Tag**

```php
$device->updateTag($tag, $addDevices = null, $removeDevices = null)
```

参数说明:

* tag:`String` 指定的标签
* addDevices:`Array` 增加到指定Tag中的registration_id
* removeDevices:`Array` 从指定Tag中移除的registration_id

**删除Tag**

```php
$device->deleteTag($tag);
```

#### 操作Alias

**获取指定Alias下的设备**

```php
$device->getAliasDevices($alias, $platform=null)
```

参数说明:

* alias: `String` 指定的别名
* platform: `String|Array` 指定的平台，不填表示所有的平台
    * String参数示例: `$platform='ios,android'`
    * Array参数示例: `$platform=array('ios', 'android')`

**删除别名**

```php
$device->deleteAlias($alias)
```

### Schedule API

在初始化JPush后，调用以下代码将返回schedule对象，它提供丰富的API来帮助操作Schedule API

```php
$schedule = $client->schedule();
```

#### 创建定时任务

定时任务分为Single与Periodical两种，可以通过调用以下方法创建定时任务

```php
$schedule->createSingleSchedule($name, $push_payload, $trigger)
$schedule->createPeriodicalSchedule($name, $push_payload, $trigger)
```

参数说明:

* name: `String` 定时任务的名称
* push_payload: `PushPayload` Push的构建对象，通过Push模块的`build()`方法获得
* trigger: `Array` 触发器对象

具体调用示例参考[Schedule Example](https://github.com/jpush/jpush-api-php-client/blob/master/examples/schedule_example.php)

#### 更新定时任务

```php
$schedule->updateSingleSchedule($schedule_id, $name=null, $enabled=null, $push_payload=null, $trigger=null)
$schedule->updatePeriodicalSchedule($schedule_id, $name=null, $enabled=null, $push_payload=null, $trigger=null)
```

#### 获取定时任务列表

```php
$schedule->getSchedules($page=1);
```

#### 获取指定定时任务

```php
$schedule->getSchedule($schedule_id);
```

#### 删除指定定时任务

```php
$schedule->deleteSchedule($schedule_id);
```












