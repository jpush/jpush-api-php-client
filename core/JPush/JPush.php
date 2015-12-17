<?php

require_once("./PushPayload.php");

class JPush {
    const PUSH_URL = 'https://api.jpush.cn/v3/push';
    const REPORT_URL = 'https://report.jpush.cn/v2/received';
    const VALIDATE_URL = 'https://api.jpush.cn/v3/push/validate';
    const MESSAGES_URL = 'https://report.jpush.cn/v3/messages';
    const USERS_URL = 'https://report.jpush.cn/v3/users';
    const DEVICES_URL = 'https://device.jpush.cn/v3/devices/{registration_id}';
    const ALL_TAGS_URL = 'https://device.jpush.cn/v3/tags/';
    const IS_IN_TAG_URL = 'https://device.jpush.cn/v3/tags/{tag}/registration_ids/{registration_id}';
    const TAG_URL = 'https://device.jpush.cn/v3/tags/{tag}';
    const ALIAS_URL = 'https://device.jpush.cn/v3/aliases/{alias}';

    const USER_AGENT = 'JPush-API-PHP-Client';
    const CONNECT_TIMEOUT = 5;
    const READ_TIMEOUT = 30;
    const DEFAULT_MAX_RETRY_TIMES = 3;

    public $appKey;
    public $masterSecret;
    public $retryTimes;


    public function __construct($appKey, $masterSecret, $retryTimes=self::DEFAULT_MAX_RETRY_TIMES)
    {
        if (is_null($appKey) || is_null($masterSecret)) {
            throw new InvalidArgumentException("appKey and masterSecret must be set.");
        }

        if (!is_string($appKey) || !is_string($masterSecret)) {
            throw new InvalidArgumentException("Invalid appKey or masterSecret");
        }
        $this->appKey = $appKey;
        $this->masterSecret = $masterSecret;
        $this->retryTimes = $retryTimes;
    }






}