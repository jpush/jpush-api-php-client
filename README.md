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

## 依赖
* PHP-CURL
* PHPUnit 

### 安装 PHP-CURL

```
sudo apt-get install php5-curl
sudo service apache2 restart
```
其他操作系统安装请访问 [安装PHP-CURL][1]

### 安装 PHPUnit
```
pear channel-discover pear.phpunit.de  
pear install phpunit/PHPUnit
```
进行测试
```
cd test
phpunit AllTest.php
```

## 使用样例

### 推送API使用样例

```php
//发送广播通知
$payload1 = new PushPayload();
$notification1 = new Notification();
$notification1->alert = "alert message";
$payload1->notification = $notification;
$result1 = $client->sendPush($payload1);
```


### 统计获取API使用样例

```php
$client = new JPushClient($app_key,$master_secret);
$msg_ids = '636946851,1173817748,636946865';
$msgstr = $client->getReport($msg_ids);
```

### API 文档
[API Doc][1]


## 版本更新
[Release页面](https://github.com/jpush/jpush-api-php-client/releases/) 有详细的版本发布记录与下载。


  [1]: http://www.php.net/manual/zh/curl.installation.php
  [2]: doc/api.md