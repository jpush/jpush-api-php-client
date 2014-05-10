# JPush API client library for PHP

## 概述
这是 JPush REST API 的 PHP 版本封装开发包，是由极光推送官方提供的，一般支持最新的 API 功能。

对应的 REST API 文档：<http://docs.jpush.cn/display/dev/REST+API>

## 环境配置

### PHP 配置支持 SSL

#### Windows 系统中配置
* 在 php.ini 中 extension=php_openssl.dll 去掉前面的注释。（可参考 examples/ 目录下的 php.ini 文件）。
* 复制 php 安装目录中的 libeay32.dll, ssleay32.dll 至 Windows 机器的 c:\windows\system32 目录。
* 复制 php 安装目录的ext子目录中 php_openssl.dll 至 Windows 机器的 c:\windows\system32 目录。
* 重启服务器 IIS 或者 Apache。

#### Linux 系统中配置
* 安装 openssl。
* 如果当前的 PHP 版本未支持 SSL，需要重新编译安装 PHP 以支持。请 Google 文档了解。
* 重启 Apache。

## 使用样例

### 推送API
```php

/**
* 推送API
* @param String $tags tag字符串。多个tag以','（逗号）分隔
* @param String $alias alia字符串。多个alia以','（逗号）分隔
* @param String $registrations registritionId字符串。多个以','（逗号）分隔
* @param int $sendno 发送编号,最大支持32位正整数
* @param String $title 通知标题。填 空字符串 则默认使用该应用的名称
* @param String $content 通知内容
* @param String $content_type Message字段里的内容类型
* @param String $description 描述此次发送调用,不会发到用户
* @param array $extras  通知附加参数，默认为[]
* @param String $build_id  通知框样式，默认为0
* @param String $override_msg_id  待覆盖的上一条消息的 ID，默认为0
* 
* @return MessageResult $msgResult   错误信息对象
*/
//发送广播通知
public function sendNotification($sendno, $title, $content, $description = '', $extras = array(), $build_id = '', $override_msg_id = '');

//发送tag通知
public function sendTagNotification($tags, $sendno, $title, $content, $description = '', $extras = array(), $build_id = '', $override_msg_id = '');

//发送alias通知
public function sendAliasNotification($alias, $sendno, $title, $content, $description = '', $extras = array(), $build_id = '', $override_msg_id = '');

//发送RegistrationID通知
public function sendRegistrationIDNotification($registrations, $sendno, $title, $content, $description = '', $extras = array(), $build_id = '', $override_msg_id = '');

//发送广播自定义消息
public function sendCustomMsg($sendno, $title, $content, $content_type = '', $description = '', $extras = array(), $build_id = '', $override_msg_id = '');

//发送tag自定义消息
public function sendTagCustomMsg($tags, $sendno, $title, $content, $content_type = '', $description = '', $extras = array(), $build_id = '', $override_msg_id = '');

//发送alias自定义消息
public function sendAliasCustomMsg($alias, $sendno, $title, $content, $content_type = '', $description = '', $extras = array(), $build_id = '', $override_msg_id = '');

//发送RegistrationID自定义消息
public function sendRegistrationIDCustomMsg($registrations, $sendno, $title, $content, $content_type = '', $description = '', $extras = array(), $build_id = '', $override_msg_id = '');

```

### 使用样例

```php
$client = new JPushClient($app_key,$master_secret);

//发送广播通知
$msgResult1 = $client->sendNotification($sendno, $title, $content);

//发送tag通知
$msgResult2 = $client->sendTagNotification($tags, $sendno, $title, $content);

//发送alias通知
$msgResult3 = $client->sendAliasNotification($alias, $sendno, $title, $content);

//发送RegistrationID通知
$msgResult4 = $client->sendRegistrationIDNotification($registrationId, $sendno, $title, $content);

//发送广播自定义消息
$msgResult5 = $client->sendCustomMsg($sendno, $title, $content, $content-type);

//发送tag自定义消息
$msgResult6 = $client->sendTagCustomMsg($tags, $sendno, $title, $content, $content-type);

//发送alias自定义消息
$msgResult7 = $client->sendAliasCustomMsg($alias, $sendno, $title, $content, $content-type);

//发送RegistrationID自定义消息
$msgResult8 = $client->sendRegistrationIDCustomMsg($registrationId, $sendno, $title, $content, $content-type);

```

### 统计获取API

```php
/**
* 获取统计信息
* @param String $msg_ids  msg_id以，连接
*
* @return Json对象
*/
public function getReportReceiveds($msg_ids);

```

### 统计获取返回JSON格式

```javascript
//SUCCESS
[
    {
        "android_received": 62,
        "ios_apns_sent": 11,
        "msg_id": 1613113584
    },
    {
        "android_received": 56,
        "ios_apns_sent": 33,
        "msg_id": 1229760629
    },
    {
        "android_received": null,
        "ios_apns_sent": 14,
        "msg_id": 1174658841
    },
    {
        "android_received": 32,
        "ios_apns_sent": null,
        "msg_id": 1174658641
    }
]

//ERROR
{
	"error": {
		"code": 3001, 
		"message": "Basic authentication failed"
	}
}
```

### 统计获取样例

```php
$client = new JPushClient($app_key,$master_secret);
$msg_ids = "123,12345";
$msgstr = $client->getReportReceiveds($msg_ids);
```


## 版本更新
[Release页面](https://github.com/jpush/jpush-api-php-client/releases/) 有详细的版本发布记录与下载。
