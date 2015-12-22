<?php

include_once '../src/JPush/core/PushPayload.php';

class PushPayloadTest extends PHPUnit_Framework_TestCase {
    public function testPlatform() {
        $this->assertEquals("你这也算写了单元测试?", "你这也算写了单元测试?");
    }
}