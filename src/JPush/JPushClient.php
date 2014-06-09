<?php
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-6-9
 * Time: 下午1:49
 */

namespace JPush;


class JPushClient {
    const PUSH_URL = '';
    const REPORT_URL = '';
    const USER_AGENT = 'JPush-API-PHP-Client"';

    public $appKey;
    public $masterSecret;

    public function __construct($appKey, $masterSecret)
    {
        $this->appKey = $appKey;
        $this->masterSecret = $masterSecret;
    }


} 