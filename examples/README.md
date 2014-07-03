# PHP Script Example
This example is a simple PHP script using the JPush API PHP Client. It has an example composer.json that fetches the library from Packagist.

## Setup

 1. Download composer.
 ```
 curl -sS https://getcomposer.org/installer | php
 ```
 2. Use composer to fetch the library and dependencies defined in `composer.json`, and install them:

```
$ composer install
#or
$ php composer.phar install
```

 2. Edit the script, or copy it, and replace the `$appkey` and `$masterSecret`.
 3. Run the script `PushExample.php` and `ReportExample.php`

 ## Tip
 请确保程序对当前目录有读写权限，以便写入ｌｏｇ。

 ```
 chmod -777 example
 ```
