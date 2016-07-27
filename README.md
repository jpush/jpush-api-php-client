# JPush API PHP Client

[![Build Status](https://travis-ci.org/jpush/jpush-api-php-client.svg?branch=master)](https://travis-ci.org/jpush/jpush-api-php-client)

这是 JPush REST API 的 PHP 版本封装开发包，是由极光推送官方提供的，一般支持最新的 API 功能。

对应的 REST API 文档: http://docs.jiguang.cn/server/server_overview/

> 支持的 PHP 版本: 5.3.3 ～ 5.6.x, 7.0.x

> 若需要兼容 PHP 5.3.3 以下版本，可以使用 [v3 分支的代码](https://github.com/jpush/jpush-api-php-client/tree/v3)。
因为运行 Composer 需要 PHP 5.3.2+ 以上版本，所以其不提供 Composer 支持，
也可以[点击链接](https://github.com/jpush/jpush-api-php-client/releases)下载 v3.4.x 版本源码。

## Installation

#### 使用 Composer 安装

- 在项目中的 `composer.json` 文件中添加 jpush 依赖：

```json
"require": {
    "jpush/jpush": "～v3.5"
}
```

- 执行 `$ php composer.phar install` 或 `$ composer install` 进行安装。

## Usage

- [Init API](doc/api.md#init-api)
- [Push API](doc/api.md#push-api)
- [Report API](doc/api.md#report-api)
- [Device API](doc/api.md#device-api)
- [Schedule API](doc/api.md#schedule-api)
- [Exception Handle](doc/api.md#schedule-api)

#### 初始化

```php
use JPush\Client as JPush;
...
...

    $client = new JPush($app_key, $master_secret);

...
```

OR

```php
$client = new \JPush\Client($app_key, $master_secret);
```

#### 简单推送

```php
$client->push()
    ->setPlatform('all')
    ->addAllAudience()
    ->setNotificationAlert('Hello, JPush')
    ->send();
```

#### 异常处理

```php
$pusher = $client->push();
$pusher->setPlatform('all');
$pusher->addAllAudience();
$pusher->setNotificationAlert('Hello, JPush');
try {
    $pusher->send();
} catch (\JPush\Exceptions\JPushException $e) {
    // try something else here
    print $e;
}
```

## Testing

```bash
# 编辑 tests/bootstrap.php 文件，填入必须的变量值
# OR 设置相应的环境变量

# 运行全部测试用例
$ ./vendor/bin/phpunit tests

# 运行某一具体测试用例
$ ./vendor/bin/phpunit tests/JPush/xxTest.php
```

## Contributing

Bug reports and pull requests are welcome on GitHub at https://github.com/jpush/jpush-api-php-client.

## License

The library is available as open source under the terms of the [MIT License](http://opensource.org/licenses/MIT).
