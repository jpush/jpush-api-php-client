<?php
namespace JPush;

class Config {
    const DISABLE_SOUND = "_disable_Sound";
    const DISABLE_BADGE = 0x10000;
    const USER_AGENT = 'JPush-API-PHP-Client';
    const CONNECT_TIMEOUT = 20;
    const READ_TIMEOUT = 120;
    const DEFAULT_MAX_RETRY_TIMES = 3;
    const DEFAULT_LOG_FILE = "./jpush.log";
    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';
    const HTTP_DELETE = 'DELETE';
    const HTTP_PUT = 'PUT';
    const ZONES = [
        'URL' => [
            'push' => 'https://api.jpush.cn/v3/',
            'report' => 'https://report.jpush.cn/v3/',
            'device' => 'https://device.jpush.cn/v3/devices/',
            'alias' => 'https://device.jpush.cn/v3/alias/',
            'tag' => 'https://device.jpush.cn/v3/tag/',
            'schedule' => 'https://api.jpush.cn/v3/schedules/',
            'admin' => 'https://admin.jpush.cn/v1/'
        ],
        'BJ' => [
            'push' => 'https://bjapi.push.jiguang.cn/v3/',
            'report' => 'https://bjapi.push.jiguang.cn/v3/report/',
            'device' => 'https://bjapi.push.jiguang.cn/v3/device/',
            'alias' => 'https://bjapi.push.jiguang.cn/v3/alias/',
            'tag' => 'https://bjapi.push.jiguang.cn/v3/tag/',
            'schedules' => 'https://bjapi.push.jiguang.cn/v3/push/schedules/',
            'admin' => 'https://admin.jpush.cn/v1/'
        ]
    ];
}
