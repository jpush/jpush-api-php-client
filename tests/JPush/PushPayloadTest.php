<?php
namespace JPush\Tests;

class PushPayloadTest extends \PHPUnit_Framework_TestCase {

    protected $client;
    protected function setUp() {
        global $client;
        $this->client = $client;
    }

    public function testPushToAll() {
        $result = $this->client->push()
            ->setPlatform('all')
            ->addAllAudience()
            ->setNotificationAlert('Hi, JPush')
            ->send();
        echo 'Result=' . json_encode($result);
    }
}
