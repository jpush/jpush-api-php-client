JPush API client library for Java
API 协议文档： http://docs.jpush.cn/pages/viewpage.action?pageId=2621796

其他语言的开发包： http://docs.jpush.cn/pages/viewpage.action?pageId=2228302

JPush Change List: http://docs.jpush.cn/pages/viewpage.action?pageId=3309737


在windows系统中IIS环境的操作方式：
1、在php.ini中 extension=php_openssl.dll去掉前面的注释（可参考example目录） 
2、复制php安装目录中的： 
libeay32.dll 
ssleay32.dll 
至c:\windows\system32 
3、复制php_openssl.dll至c:\windows\system32 
4、重启IIS 

在linux系统中：
需要安装openssl,然后重新编译PHP


