# JPush Group Push

## 获取 Group Key 和 Group Master Secret

```php
$group_key = 'xxxx';
$group_master_secret = 'xxxx';
```

##  初始化


```php
$client = new \JPush\Client('group-' . $group_key, $group_master_secret);
```

## 简单群组推送

```php
$client->push()
    ->setPlatform('all')
    ->addAllAudience()
    ->setNotificationAlert('Hello, JPush')
    ->send();
```

> [Example](https://github.com/jpush/jpush-api-php-client/blob/master/examples/push_example.php)
