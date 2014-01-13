# JPush API client library for PHP

## 概述
这是 JPush REST API 的 PHP 版本封装开发包，是由极光推送官方提供的，一般支持最新的 API 功能。

对应的 REST API 文档：<http://docs.jpush.cn/display/dev/REST+API>

## 环境配置

### windows系统中IIS环境配置
1、在php.ini中 extension=php_openssl.dll去掉前面的注释（可参考example目录php.ini文件） 
2、复制php安装目录中的： libeay32.dll ssleay32.dll 至c:\windows\system32 
3、复制php_openssl.dll至c:\windows\system32 
4、重启IIS 

### windows系统中Apache环境配置
1、在php.ini中 extension=php_openssl.dll去掉前面的注释（可参考example目录php.ini文件） 
2、复制php安装目录中的： libeay32.dll ssleay32.dll 至c:\windows\system32 
3、复制php_openssl.dll至c:\windows\system32 
4、重启重启APache

### 在linux系统中： 
1、安装openssl
2、重新编译PHP
3、重启Apache

## 使用样例
下边是简单直接的使用样例。
详细地了解请参考：[API Docs](http://jpush.github.io/jpush-api-java-client/apidocs/)。

### 推送样例
```

$client = new JpushClient($app_key,$master_secret);
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
$client = new JpushClient($app_key,$master_secret);
$msg_ids=$_GET['msg_ids'];
$msgstr = $client->getReportReceiveds($msg_ids);
```


## 版本更新

[Release页面](https://github.com/jpush/jpush-api-java-client/releases) 有详细的版本发布记录与下载。
