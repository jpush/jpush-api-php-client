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
        $response = $this->device->getDevices($registration_id);
        $this->assertEquals('200', $response['http_code']);

        $body = $response['body'];
        $this->assertTrue(is_array($body));
        $this->assertEquals(3, count($body));
        $this->assertArrayHasKey('tags', $body);
        $this->assertArrayHasKey('alias', $body);
        $this->assertArrayHasKey('mobile', $body);
        $this->assertTrue(is_array($body['tags']));
    }

    function testUpdateDevicesAlias() {
        global $registration_id;
        $old_alias = $this->device->getDevices($registration_id)['body']['alias'];
        $new_alias = 'jpush_alias';
        if ($old_alias == $new_alias) {
            $new_alias = $new_alias . time();
        }
        $response = $this->device->updateDevice($registration_id, $alias = $new_alias);
        $this->assertEquals('200', $response['http_code']);

        $response = $this->device->updateDevice($registration_id, $alias = $old_alias);
        $this->assertEquals('200', $response['http_code']);
    }

    function testUpdateDevicesTags() {
        global $registration_id;
        $tags_array = $this->device->getTags()['body']['tags'];
        $new_tag = 'jpush_tag';
        if(in_array($new_tag, $tags_array)) {
            $new_tag = $new_tag . time();
        }
        $response = $this->device->updateDevice($registration_id, $addTags = $new_tag);
        $this->assertEquals('200', $response['http_code']);

        $response = $this->device->updateDevice($registration_id, $removeTags = $new_tag);
        $this->assertEquals('200', $response['http_code']);
    }

    function testGetTags() {
        $response = $this->device->getTags();
        $this->assertEquals('200', $response['http_code']);

        $body = $response['body'];
        $this->assertTrue(is_array($body));
        $this->assertEquals(1, count($body));
        $this->assertArrayHasKey('tags', $body);
    }

    function testIsDeviceInTag() {
        global $registration_id;
        $test_tag = 'jpush_test_tag';
        $tags_array = $this->device->getTags()['body']['tags'];

        if(in_array($test_tag, $tags_array)) {
            $test_tag = $test_tag . time();
        }

        $this->device->updateDevice($registration_id, $addTags = $test_tag);
        $response = $this->device->isDeviceInTag($registration_id, $test_tag);
        $this->assertEquals('200', $response['http_code']);
        $body = $response['body'];
        $this->assertTrue(is_array($body));
        $this->assertTrue($body['result']);

        $this->device->updateDevice($registration_id, $removeTags = $test_tag);
        $response = $this->device->isDeviceInTag($registration_id, $test_tag);
        $this->assertEquals('200', $response['http_code']);
        $body = $response['body'];
        $this->assertTrue(is_array($body));
        $this->assertFalse($body['result']);
    }

}
