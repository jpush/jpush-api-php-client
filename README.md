# JPush API client library for PHP

## 简要概述  

* 本API提供简单的接口去调用[JPush Push API v3][1]
* 本API提供简单的接口去调用[JPush Report API][2]
* API符合PHP规范，包裹使用namespace

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

* php-curl
* composer
* monolog

### 安装 PHP-CURL

```
sudo apt-get install php5-curl
sudo service apache2 restart
```
其他操作系统安装请访问 [安装PHP-CURL][3]

## 快速使用

### Easy Push

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

### Full Push
```php
$result = $client->push()
    ->setPlatform(M\platform('ios', 'android'))
    ->setAudience(M\audience(M\tag(['tag1','tag2']), M\alias(['alias1', 'alias2'])))
    ->setNotification(M\notification('Hi, JPush', M\android('Hi, android'), M\ios('Hi, ios', 'happy', 1, true)))
    ->setMessage(M\message('msg content', null, null, array('key'=>'value')))
    ->setOptions(M\options(123456, null, null, false))
    ->printJSON()
    ->send();
```

## 文档

[JPush Push API v3][4]
[JPush Report API][5]
[JPush Api PHP client doc][6]

## 版本更新

[Release页面][7]有详细的版本发布记录与下载。


  [1]: http://docs.jpush.cn/display/dev/Push-API-v3
  [2]: http://docs.jpush.cn/display/dev/Report-API
  [3]: http://www.php.net/manual/zh/curl.installation.php
  [4]: http://docs.jpush.cn/display/dev/Push-API-v3
  [5]: http://docs.jpush.cn/display/dev/Report-API
  [6]: doc/api.md
  [7]: https://github.com/jpush/jpush-api-php-client/releases/