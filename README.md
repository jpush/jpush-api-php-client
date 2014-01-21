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

### 推送样例
```

$client = new JPushClient($app_key,$master_secret);
$extras = array();
$params = array("receiver_type" => 2,
                "receiver_value" => "tag_api",
                "sendno" => 1,
                "send_description" => "",
                "override_msg_id" => "");
//发送通知
$msgResult1 = $client->sendNotification("tag notify content", $params, $extras);

//发送自定义信息
$msgResult2 = $client->sendCustomMessage("tag title","tag notify content", $params, $extras);

```

### 统计获取样例

```
$client = new JPushClient($app_key,$master_secret);
$msg_ids = "123, 12345, ";
$msgstr = $client->getReportReceiveds($msg_ids);
```


## 版本更新
[Release页面](https://github.com/jpush/jpush-api-php-client/releases/) 有详细的版本发布记录与下载。
