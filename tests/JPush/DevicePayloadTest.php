<?php
namespace JPush\Tests;

use JPush\Client;

class DevicePayloadTest extends \PHPUnit_Framework_TestCase {

    protected $client;
    protected $device;
    protected function setUp() {
        global $client;
        $this->client = $client;
        $this->device = $client->device();
    }

    function testGetDevices() {
      global $registration_id;
      $device = $this->device->getDevices($registration_id);
      echo 'Result=' . json_encode($device);
    }
}
