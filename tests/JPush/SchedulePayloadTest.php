<?php
namespace JPush\Tests;

class SchedulePayloadTest extends \PHPUnit_Framework_TestCase {

    protected function setUp() {
        global $client;
        $this->schedule = $client->schedule();
    }

    public function testGetSchedules() {
        $schedule = $this->schedule;
        $response = $schedule->getSchedules();
        $this->assertEquals('200', $response['http_code']);
    }

}
