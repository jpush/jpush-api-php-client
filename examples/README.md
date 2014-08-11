# PHP Script Example
This example is a simple PHP script using the JPush API PHP Client. It has an example composer.json that fetches the library from Packagist.


## 快速安装

解压 **examples/vendor.tar.gz** 到项目目录，在需要使用JPush的源文件头部 引入 vendor/autoload.php  既可使用。
```php
require_once 'vendor/autoload.php';
```


## 使用composer安装
[Composer][1] 是PHP的项目依赖管理工具
比如在本案例中，在当前目录（example）执行
```
curl -sS https://getcomposer.org/installer | php
```
就可以下载 **composer.phar** 文件到 **example** 文件夹下。
为了方便开发者所用，我已经预先把cimposer.phar下载好了。
然后执行
```
php composer.phar install
```
这样，composer就会根据 **examples/composer.json** 去下载该项目涉及的依赖 jpush，httpful，monolog。

下载完成后，example文件夹下就会有一个vender文件夹，你在需要在使用的时候，引入 vendor/autoload.php 这个文件。即可引入所有依赖。


 ## Tip
 如果捕获到此异常
 ```
 Uncaught exception 'UnexpectedValueException' with message 'The stream or file "jpush.log" could not be opened: failed to open stream
 ```
 则表明程序没有当前目录的读写权限，无法写入log。
 请执行一下命令获取权限。
 ```
 sudo chmod 777 example
 ```


  [1]: https://getcomposer.org/