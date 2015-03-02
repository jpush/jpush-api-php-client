[![Build Status](https://travis-ci.org/jpush/jpush-api-php-client.svg?branch=master)](https://travis-ci.org/jpush/jpush-api-php-client)

# JPush API client library for PHP

## 简要概述  

* 本API提供简单的接口去调用[JPush Push API v3][1]
* 本API提供简单的接口去调用[JPush Report API][2]

## 依赖

PHP >= 5.3

### 快速安装
JPush PHP Library 使用 Composer管理项目依赖, 鉴于某些原因, 国内的用户使用Composer下载依赖库比较困难,所以我们将Composer依赖打包. 用户可以通过以下方式在您的项目中加入JPush PHP Library.


1.下载依赖包 [vendor.tar.gz][3]

2.解压 [vendor.tar.gz][4] 到您的项目目录下，在需要使用JPush的源文件头部 引入 `vendor/autoload.php`  既可使用.

```
# 引入代码
php require_once 'vendor/autoload.php';
```
PS: 在下载的[JPush PHP Library][5]中的[example][6]文件夹有简单示例代码, 开发者可以参考其中的样例快速了解该库的使用方法.



### 使用 Composer

如果你的项目使用composer管理依赖, 可以通过以下方式使用JPush PHP Library.


1. 在 `composer.json` 中添加 jpush依赖, 目前最新版本为 v3.2.0

```
{
    "require":{
        "jpush/jpush": "v3.2.0"
    }
}
```
2. 执行 `php composer.phar install` 或 `php composer.phar update`




## 快速使用

### Example

[example][6]文件夹有简单示例代码, 开发者可参考以快速使用该库


├── examples

│   ├── composer.json　项目依赖

│   ├── DeviceExample.php 对Tag, Alias, Registeration_id的操作示例

│   ├── PushExample.php　推送示例

│   ├── README.md　说明

│   ├── ReportExample.php　获取统计信息示例

│   └── ValidateExample.php　使用validate接口示例




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

## FAQ

Q: 运行示例提示　`require_once(vendor/autoload.php): failed to open stream` 怎么解决?

A: 下载下载依赖包 [vendor.tar.gz][3] 并解压到examples目录即可, 也可以使用composer管理依赖, 在composer.json中加入 `"jpush/jpush": "v3.2.0"` 并执行 `php composer.phar install` 即可.

Q: 运行示例提示

```
Fatal error: Uncaught exception 'UnexpectedValueException' with message 'The stream or file "jpush.log" could not be opened: failed to open stream: Permission denied
```
该如何解决?

A: 此问题是因为工程没有写入权限导致不能生成日志文件. 只需对赋予该项目对本目录的写入权限即可,如 `sudo chmod 777 example`


Q: 使用示例每次推送都会打印推送的JSON, 如何禁止其打印?

A: 在调用示例推送的时候, 注释掉 `->printJSON()` 即可, 该函数可以打印当前构建的推送对象.




## 文档

* [JPush Push API v3][7]  
* [JPush Report API][8]
* [JPush Api PHP client doc][9]

## 版本更新

[Release页面][10]有详细的版本发布记录与下载。


  [1]: http://docs.jpush.cn/display/dev/Push-API-v3
  [2]: http://docs.jpush.cn/display/dev/Report-API
  [3]: http://docs.jpush.cn/download/attachments/2228302/vendor.tar.gz
  [4]: http://docs.jpush.cn/download/attachments/2228302/vendor.tar.gz
  [5]: http://jpushsdk.qiniudn.com/jpush-api-php-client-latest.tar.gz
  [6]: /examples
  [7]: http://docs.jpush.cn/display/dev/Push-API-v3
  [8]: http://docs.jpush.cn/display/dev/Report-API
  [9]: doc/api.md
  [10]: https://github.com/jpush/jpush-api-php-client/releases/
