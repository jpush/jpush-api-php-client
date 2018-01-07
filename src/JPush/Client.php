<?php
namespace JPush;
use InvalidArgumentException;

class Client {

    private $appKey;
    private $masterSecret;
    private $retryTimes;
    private $logFile;
    private $zone;

    public function __construct($appKey, $masterSecret, $logFile=Config::DEFAULT_LOG_FILE, $retryTimes=Config::DEFAULT_MAX_RETRY_TIMES, $zone = null) {
        if (!is_string($appKey) || !is_string($masterSecret)) {
            throw new InvalidArgumentException("Invalid appKey or masterSecret");
        }
        $this->appKey = $appKey;
        $this->masterSecret = $masterSecret;
        if (!is_null($retryTimes)) {
            $this->retryTimes = $retryTimes;
        } else {
            $this->retryTimes = 1;
        }
        $this->logFile = $logFile;
        if (!is_null($zone) && in_array(strtoupper($zone), array_keys(Config::ZONES))) {
            $this->zone = strtoupper($zone);
        } else {
            $this->zone= null;
        }
    }

    public function push() { return new PushPayload($this); }
    public function report() { return new ReportPayload($this); }
    public function device() { return new DevicePayload($this); }
    public function schedule() { return new SchedulePayload($this);}

    public function getAuthStr() { return $this->appKey . ":" . $this->masterSecret; }
    public function getRetryTimes() { return $this->retryTimes; }
    public function getLogFile() { return $this->logFile; }

    public function is_group() {
        $str = substr($this->appKey, 0, 6);
        return $str === 'group-';
    }

    public function makeURL($key) {
        if (is_null($this->zone)) {
            return Config::ZONES['URL'][$key];
        } else {
            return Config::ZONES[$this->zone][$key];
        }
    }
}
