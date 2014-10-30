<?php


require_once '../vendor/autoload.php';

use JPush\Model as M;
use JPush\JPushClient;

class ValidateTest extends PHPUnit_Framework_TestCase {
    public $appKey = "dd1066407b044738b6479275";
    public $masterSecret = '2b38ce69b1de2a7fa95706ea';
    public $alert = "JPush Test - alert";
    public $title = "JPUsh Test - title";
    public $extras = array("key1" => "value1", "key2" => "value2");
    public $msg_content = "JPush Test - msgContent";
    public $tag1 = "tag1";
    public $tag2 = "tag2";
    public $tag_all = "tag_all";
    public $tag_no = "tag_no";
    public $alias1 = "alias1";
    public $alias2 = "alias2";
    public $alias_no = "alias_no";
    public $registration_id1 = "0900e8d85ef";
    public $registration_id2 = "0a04ad7d8b4";



    public function testAlertAll() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\all)
            ->setNotification(M\notification($this->alert))
            ->validate();
        $this->assertTrue($response->isOk === true);
    }

    // platform
    public function testAlertAndroid() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\platform("android"))
            ->setAudience(M\all)
            ->setNotification(M\notification($this->alert))
            ->send();

        $this->assertTrue($response->isOk === true);
    }
    public function testAlertIOS() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\platform("ios"))
            ->setAudience(M\all)
            ->setNotification(M\notification($this->alert))
            ->send();

        $this->assertTrue($response->isOk === true);
    }
    public function testAlertWinphone() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\platform("winphone"))
            ->setAudience(M\all)
            ->setNotification(M\notification($this->alert))
            ->send();

        $this->assertTrue($response->isOk === true);
    }


    //audience
    public function testSendByTag() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\audience(M\tag(array($this->tag1))))
            ->setNotification(M\notification($this->alert))
            ->send();

        $this->assertTrue($response->isOk === true);
    }
    public function testSendByTagAnd() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\audience(M\tag_and(array($this->tag1))))
            ->setNotification(M\notification($this->alert))
            ->send();

        $this->assertTrue($response->isOk === true);
    }
    public function testSendByAlias() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\audience(M\alias(array($this->alias1))))
            ->setNotification(M\notification($this->alert))
            ->send();

        $this->assertTrue($response->isOk === true);
    }
    public function testSendByRegistrationID() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\audience(M\registration_id(array($this->registration_id1))))
            ->setNotification(M\notification($this->alert))
            ->send();

        $this->assertTrue($response->isOk === true);
    }

    public function testSendByTagMore() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\audience(M\tag(array($this->tag1, $this->tag2))))
            ->setNotification(M\notification($this->alert))
            ->send();

        $this->assertTrue($response->isOk === true);
    }
    public function testSendByTagAndMore() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\audience(M\tag_and(array($this->tag1, $this->tag_all))))
            ->setNotification(M\notification($this->alert))
            ->send();

        $this->assertTrue($response->isOk === true);
    }
    public function testSendByAliasMore() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\audience(M\alias(array($this->alias1, $this->alias2))))
            ->setNotification(M\notification($this->alert))
            ->send();

        $this->assertTrue($response->isOk === true);
    }
    public function testSendByRegistrationIDMore() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\audience(M\registration_id(array($this->registration_id1, $this->registration_id2))))
            ->setNotification(M\notification($this->alert))
            ->send();

        $this->assertTrue($response->isOk === true);
    }

    public function testSendByTagAlias() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\audience(
                M\tag(array($this->tag1)),
                M\alias(array($this->alias1))
            ))
            ->setNotification(M\notification($this->alert))
            ->send();

        $this->assertTrue($response->isOk === true);
    }
    public function testSendByTagRegistrationID() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\audience(
                M\tag(array($this->tag1)),
                M\registration_id(array($this->registration_id1))
            ))
            ->setNotification(M\notification($this->alert))
            ->send();

        $this->assertTrue($response->isOk === true);
    }
    public function testSendByTagRegistrationID_0() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\audience(
                M\tag(array($this->tag_no)),
                M\registration_id(array($this->registration_id1))
            ))
            ->setNotification(M\notification($this->alert))
            ->send();

        $this->assertTrue($response->isOk === true);
    }
    public function testSendByTagAlias_0() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\audience(
                M\tag(array($this->tag_no)),
                M\alias(array($this->alias1))
            ))
            ->setNotification(M\notification($this->alert))
            ->send();

        $this->assertTrue($response->isOk === true);
    }
    public function testSendByTagAlias_0_2() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\audience(
                M\tag(array($this->tag_all)),
                M\alias(array($this->alias_no))
            ))
            ->setNotification(M\notification($this->alert))
            ->send();

        $this->assertTrue($response->isOk === true);
    }

    //notification
    public function testNotificationAndroidAlert() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\all)
            ->setNotification(M\notification(null, M\android($this->alert)))
            ->send();

        $this->assertTrue($response->isOk === true);
    }
    public function testNotificationAndroidFull() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\all)
            ->setNotification(M\notification(null, M\android($this->alert, $this->title, 1, $this->extras)))
            ->send();

        $this->assertTrue($response->isOk === true);
    }
    public function testNotificationIOSAlert() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\all)
            ->setNotification(M\notification(null, M\ios($this->alert)))
            ->send();

        $this->assertTrue($response->isOk === true);
    }
    public function testNotificationIOSFull() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\all)
            ->setNotification(M\notification(null, M\ios($this->alert, 'happy', 1, true, $this->extras)))
            ->send();

        $this->assertTrue($response->isOk === true);
    }
    public function testNotificationWinPhoneAlert() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\all)
            ->setNotification(M\notification(null, M\winphone($this->alert)))
            ->send();

        $this->assertTrue($response->isOk === true);
    }
    public function testNotificationWinPhoneFUll() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\all)
            ->setNotification(M\notification(null, M\winphone($this->alert, $this->title, "abc.test", $this->extras)))
            ->send();

        $this->assertTrue($response->isOk === true);
    }


    //message
    public function testMessageContentOnly() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\all)
            ->setMessage(M\message($this->msg_content))
            ->send();

        $this->assertTrue($response->isOk === true);
    }
    public function testMessageContentFull() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\all)
            ->setMessage(M\message($this->msg_content, $this->title, "content_type", $this->extras))
            ->send();

        $this->assertTrue($response->isOk === true);
    }

    //option
    public function testOptionsSendno() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\all)
            ->setNotification(M\notification($this->alert))
            ->setOptions(M\options(12345))
            ->send();
        $this->assertEquals(12345, $response->sendno);
        $this->assertTrue($response->isOk === true);
    }

    public function testOptionsAndOverride() {
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\all)
            ->setNotification(M\notification($this->alert))
            ->setOptions(M\options(12345, 60, null, true))
            ->send();
        $this->assertEquals(12345, $response->sendno);
        $this->assertTrue($response->isOk === true);



        $override_msg_id = (int)$response->msg_id;
        $client = new JPushClient($this->appKey, $this->masterSecret);
        $response = $client->push()->setPlatform(M\all)
            ->setAudience(M\all)
            ->setNotification(M\notification($this->alert))
            ->setOptions(M\options(null, null, $override_msg_id))
            ->send();
        $this->assertTrue($response->isOk === true);
    }







}
 