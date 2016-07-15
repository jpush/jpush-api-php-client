<?php
namespace JPush\Tests;

class PushPayloadTest extends \PHPUnit_Framework_TestCase {

    protected function setUp() {
        global $client;
        $this->payload = $client->push()
                                ->setPlatform('all')
                                ->addAllAudience()
                                ->setNotificationAlert('Hello JPush');

        $this->payload_without_audience = $client->push()
                                                 ->setPlatform('all')
                                                 ->setNotificationAlert('Hello JPush');
    }

    public function testSimplePushToAll() {
        $payload = $this->payload;
        $result = $payload->build();

        $this->assertTrue(is_array($result));
        $this->assertEquals(4, count($result));
        $this->assertArrayHasKey('platform', $result);
        $this->assertArrayHasKey('audience', $result);
        $this->assertArrayHasKey('notification', $result);
        $this->assertArrayHasKey('options', $result);

        $response = $payload->send();
        $this->assertEquals('200', $response['http_code']);
        $body = $response['body'];
        $this->assertTrue(is_array($body));
        $this->assertEquals(2, count($body));
        $this->assertArrayHasKey('sendno', $body);
        $this->assertArrayHasKey('msg_id', $body);
    }

    public function testSetPlatform() {
        $payload = $this->payload;

        $result1 = $payload->build();
        $this->assertEquals('all', $result1['platform']);

        $result2 = $payload->setPlatform('ios')->build();
        $this->assertTrue(is_array($result2['platform']));
    }

    public function testSetAudience() {
        $result = $this->payload->build();
        $this->assertEquals('all', $result['audience']);
    }

    public function testAddTag() {
        $payload = $this->payload_without_audience;
        $result = $payload->addTag('hello')->build();
        $audience = $result['audience'];
        $this->assertTrue(is_array($audience['tag']));
        $this->assertEquals(1, count($audience['tag']));

        $result = $payload->addTag(array('jpush', 'jiguang'))->build();
        $this->assertEquals(3, count($result['audience']['tag']));
    }
    public function testAddTag2() {
        $payload = $this->payload_without_audience;
        $result = $payload->addTagAnd(array('jpush', 'jiguang'))->build();
        $audience = $result['audience'];
        $this->assertTrue(is_array($audience['tag_and']));
        $this->assertEquals(2, count($audience['tag_and']));

        $result = $payload->addTagAnd('hello')->build();
        $this->assertEquals(3, count($result['audience']['tag_and']));
    }

    public function testAddTagAnd1() {
        $payload = $this->payload_without_audience;
        $result = $payload->addTagAnd('hello')->build();
        $audience = $result['audience'];
        $this->assertTrue(is_array($audience['tag_and']));
        $this->assertEquals(1, count($audience['tag_and']));

        $result = $payload->addTagAnd(array('jpush', 'jiguang'))->build();
        $this->assertEquals(3, count($result['audience']['tag_and']));
    }
    public function testAddTagAnd2() {
        $payload = $this->payload_without_audience;
        $result = $payload->addTagAnd(array('jpush', 'jiguang'))->build();
        $audience = $result['audience'];
        $this->assertTrue(is_array($audience['tag_and']));
        $this->assertEquals(2, count($audience['tag_and']));

        $result = $payload->addTagAnd('hello')->build();
        $this->assertEquals(3, count($result['audience']['tag_and']));
    }

    public function testAddRegistrationId1() {
        $payload = $this->payload_without_audience;
        $result = $payload->addRegistrationId('hello')->build();
        $audience = $result['audience'];
        $this->assertTrue(is_array($audience['registration_id']));
        $this->assertEquals(1, count($audience['registration_id']));

        $result = $payload->addRegistrationId(array('jpush', 'jiguang'))->build();
        $this->assertEquals(3, count($result['audience']['registration_id']));
    }
    public function testAddRegistrationId2() {
        $payload = $this->payload_without_audience;
        $result = $payload->addRegistrationId(array('jpush', 'jiguang'))->build();
        $audience = $result['audience'];
        $this->assertTrue(is_array($audience['registration_id']));
        $this->assertEquals(2, count($audience['registration_id']));

        $result = $payload->addRegistrationId('hello')->build();
        $this->assertEquals(3, count($result['audience']['registration_id']));
    }

    public function testSetNotificationAlert() {
        $result = $this->payload->build();
        $notification = $result['notification'];
        $this->assertTrue(is_array($notification));
        $this->assertEquals(1, count($notification));
        $this->assertEquals('Hello JPush', $result['notification']['alert']);
    }
}
