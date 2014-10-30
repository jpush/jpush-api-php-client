<?php

require_once '../vendor/autoload.php';

use JPush\Model as M;
use JPush\JPushClient;

class DeviceTest extends PHPUnit_Framework_TestCase {
    public $appKey = "dd1066407b044738b6479275";
    public $masterSecret = '2b38ce69b1de2a7fa95706ea';

    public $TAG1 = "tag1";
    public $TAG2 = "tag2";
    public $TAG3 = "tag3";
    public $TAG4 = "tag4";
    public $ALIAS1 = "alias1";
    public $ALIAS2 = "alias2";
    public $REGISTRATION_ID1 = "0900e8d85ef";
    public $REGISTRATION_ID2 = "0a04ad7d8b4";

    /*----RegistrationId Tests----*/
    function testGetDeviceTagAlias() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $result = $client->getDeviceTagAlias($this->REGISTRATION_ID1);
        $this->assertTrue($result->isOk === true);
    }
    function testRemoveDeviceTag() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $result = $client->removeDeviceTag($this->REGISTRATION_ID1);
        $this->assertTrue($result->isOk === true);
    }
    function testRemoveDeviceAlias() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $result = $client->removeDeviceAlias($this->REGISTRATION_ID1);
        $this->assertTrue($result->isOk === true);
    }
    function testUpdateDeviceTagAlias() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $result = $client->updateDeviceTagAlias($this->REGISTRATION_ID1, $this->ALIAS1, array($this->TAG1, $this->TAG2), array($this->TAG3, $this->TAG4));
        $this->assertTrue($result->isOk === true);
    }
    /*----Tag Tests----*/

    function testGetTags() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $result = $client->getTags();
        $this->assertTrue($result->isOk === true);
    }
    function testIsDeviceInTag() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $result = $client->isDeviceInTag($this->REGISTRATION_ID1, $this->TAG1);
        $this->assertTrue($result->isOk === true);
    }
    function testUpdateTagDevices() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $result = $client->updateTagDevices($this->TAG1, array($this->REGISTRATION_ID1), array($this->REGISTRATION_ID2));
        $this->assertTrue($result->isOk === true);
    }
    function testDeleteUpdate() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $result = $client->deleteAlias($this->TAG4);
        $this->assertTrue($result->isOk === true);
    }

    /*----Alias Tests----*/
    function testGetAliasDevices() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $result = $client->getAliasDevices($this->ALIAS1);
        $this->assertTrue($result->isOk === true);
    }

    function testGetAliasDevices2() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $result = $client->getAliasDevices($this->ALIAS1, array('ios', 'android'));
        $this->assertTrue($result->isOk === true);
    }
    function testDeleteAlias() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $result = $client->deleteAlias($this->ALIAS2);
        $this->assertTrue($result->isOk === true);
    }
} 