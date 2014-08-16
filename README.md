[![Build Status](https://travis-ci.org/jpush/jpush-api-php-client.svg?branch=master)](https://travis-ci.org/jpush/jpush-api-php-client)

# JPush API client library for PHP

## 简要概述  

* 本API提供简单的接口去调用[JPush Push API v3][1]
* 本API提供简单的接口去调用[JPush Report API][2]

## 依赖

PHP >= 5.3

### 快速安装
解压 **examples/vendor.tar.gz** 到项目目录，在需要使用JPush的源文件头部 引入 vendor/autoload.php  既可使用。
```php
require_once 'vendor/autoload.php';
```


### Composer install

Use composer to fetch the library and dependencies defined in `composer.json`, and install them:

```
#download the composer.phar
$ curl -sS https://getcomposer.org/installer | php
#install by composer.json
$ php composer.phar install
```



## 快速使用
### Easy Push

```php
require_once 'vendor/autoload.php';

use JPush\Model as M;
use JPush\JPushClient;
use JPush\Exception\APIConnectionException;
use JPush\Exception\APIRequestException;

$br = '<br/>';
$client = new JPushClient($app_key, $master_secret);

$result = $client->push()
    ->setPlatform(M\all)
    ->setAudience(M\all)
    ->setNotification(M\notification('Hi, JPush'))
    ->send();
echo 'Push Success.' . $br;
echo 'sendno : ' . $result->sendno . $br;
echo 'msg_id : ' .$result->msg_id . $br;
echo 'Response JSON : ' . $result->json . $br;

```

### Easy Report
```php
require_once 'vendor/autoload.php';

use JPush\Model as M;
use JPush\JPushClient;
use JPush\Exception\APIConnectionException;
use JPush\Exception\APIRequestException;

$br = '<br/>';

$client = new JPushClient($app_key, $master_secret);

$msg_ids = '1931816610,1466786990,1931499836';
$result = $client->report($msg_ids);
foreach($result->received_list as  $received) {
    echo '---------' . $br;
    echo 'msg_id : ' . $received->msg_id . $br;
    echo 'android_received : ' .  $received->android_received . $br;
    echo 'ios_apns_sent : ' .  $received->ios_apns_sent . $br;
}
```

## 文档

* [JPush Push API v3][4]  
* [JPush Report API][5]
* [JPush Api PHP client doc][6]

## 版本更新

[Release页面][7]有详细的版本发布记录与下载。


  [1]: http://docs.jpush.cn/display/dev/Push-API-v3
  [2]: http://docs.jpush.cn/display/dev/Report-API
  [4]: http://docs.jpush.cn/display/dev/Push-API-v3
  [5]: http://docs.jpush.cn/display/dev/Report-API
  [6]: doc/api.md
  [7]: https://github.com/jpush/jpush-api-php-client/releases/
