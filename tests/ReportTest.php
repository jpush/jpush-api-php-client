<?php

require_once '../vendor/autoload.php';

use JPush\Model as M;
use JPush\JPushClient;

class ReportTest extends PHPUnit_Framework_TestCase {
    public $appKey = "dd1066407b044738b6479275";
    public $masterSecret = '2b38ce69b1de2a7fa95706ea';


    function testReport() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $result = $client->report('769835449');
        $this->assertTrue($result->isOk === true);
    }

    function testReportMore() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $result = $client->report('769835449,1093175430');
        $this->assertTrue($result->isOk === true);
    }

    function testMessages() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $result = $client->messages('478284636,1150722083,979475499');
        $this->assertTrue($result->isOk === true);
    }

    function testUsers() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $result = $client->messages('month', '2014-09', 2);
        $this->assertTrue($result->isOk === true);
    }
} 