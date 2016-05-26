[![Build Status](https://travis-ci.org/jpush/jpush-api-php-client.svg?branch=master)](https://travis-ci.org/jpush/jpush-api-php-client)

# JPush API client library for PHP

### 简要概述

* 本API提供简单的接口去调用[JPush Push API](examples/push_example.php)
* 本API提供简单的接口去调用[JPush Report API](examples/report_example.php)
* 本API提供简单的接口去调用[JPush Device API](examples/device_example.php)
* 本API提供简单的接口去调用[JPush Schedule API](examples/schedule_example.php)


#### 快速安装

1.复制`src/JPush`到项目目录下

2.在需要使用JPush的源文件头部 引入 `src/JPush/JPush.php`  既可使用(注意确认引入的路径是否正确).

```
# 引入代码
require_once("../JPush/JPush.php");
```
PS: 在下载的中的[example](https://github.com/jpush/jpush-api-php-client/tree/master/examples)文件夹有简单示例代码, 开发者可以参考其中的样例快速了解该库的使用方法.



#### 使用 Composer

如果你的项目使用composer管理依赖, 亦可以通过以下方式使用JPush PHP Library.


1. 在 `composer.json` 中添加 jpush依赖, 目前最新版本为 v3.3.9

```
{
    "require":{
        "jpush/jpush": "v3.3.9"
    }
}
```
2. 执行 `php composer.phar install` 或 `php composer.phar update` 进行安装




### 快速使用

#### 代码示例

[example](https://github.com/jpush/jpush-api-php-client/tree/master/examples)文件夹有简单示例代码, 开发者可参考以快速使用该库

```
examples/
├── push_example.php Push API使用示例
├── device_example.php Device API使用示例
├── report_example.php Report API使用示例
└── schedule_example.php Schedule API使用示例
```

#### 初始化

```php
$client = new JPush($app_key, $master_secret);
```

#### 简单推送

```php
$result = $client->push()
    ->setPlatform('all')
    ->addAllAudience()
    ->setNotificationAlert('Hi, JPush')
    ->send();

echo 'Result=' . json_encode($result) . $br;
```

#### 完整的推送示例

包含指定Platform,指定Alias,Tag,指定iOS,Android notification,指定Message等

```php
$result = $client->push()
    ->setPlatform('ios', 'android')
    ->addAlias('alias1')
    ->addTag(array('tag1', 'tag2'))
    ->setNotificationAlert('Hi, JPush')
    ->addAndroidNotification('Hi, android notification', 'notification title', 1, array("key1"=>"value1", "key2"=>"value2"))
    ->addIosNotification("Hi, iOS notification", 'iOS sound', '+1', true, 'iOS category', array("key1"=>"value1", "key2"=>"value2"))
    ->setMessage("msg content", 'msg title', 'type', array("key1"=>"value1", "key2"=>"value2"))
    ->setOptions(100000, 3600, null, false)
    ->send();

echo 'Result=' . json_encode($result) . $br;
```

#### 发送短信推送示例

推送未送达的情况下进行短信送达, 该功能需预付短信费用, 并调用Device API绑定设备与手机号

```php
$result = $client->push()
    ->setPlatform('all')
    ->addTag('tag1')
    ->setNotificationAlert("Hi, JPush SMS")
    ->setSmsMessage('Hi, JPush SMS', 60)
    ->send();

echo 'Result=' . json_encode($result) . $br;
```

#### 定时推送示例

```php
$payload = $client->push()
    ->setPlatform("all")
    ->addAllAudience()
    ->setNotificationAlert("Hi, 这是一条定时发送的消息")
    ->build();

// 创建一个2016-12-22 13:45:00触发的定时任务
$response = $client->schedule()->createSingleSchedule("每天14点发送的定时任务", $payload, array("time"=>"2016-12-22 13:45:00"));
echo 'Result=' . json_encode($response) . $br;
```


### 版本更新

[Release页面](https://github.com/jpush/jpush-api-php-client/releases/)有详细的版本发布记录与下载。
