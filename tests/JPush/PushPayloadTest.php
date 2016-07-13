<?php
namespace JPush\Tests;

class PushPayloadTest extends \PHPUnit_Framework_TestCase {

    protected function setUp() {
        global $client;
        $this->client = $client;
        $this->pusher = $client->push();
    }

    public function testSimplePushToAll() {
        $response = $this->pusher->setPlatform('all')
                         ->addAllAudience()
                         ->setNotificationAlert('Hello World')
                         ->send();
        $this->assertEquals('200', $response['http_code']);
        $body = $response['body'];
        $this->assertTrue(is_array($body));
        $this->assertEquals(2, count($body));
        $this->assertArrayHasKey('sendno', $body);
        $this->assertArrayHasKey('msg_id', $body);
    }
}
