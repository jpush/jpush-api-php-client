<?php
include_once '../src/JPush/Model/Audience.php';
include_once '../src/JPush/Model/Message.php';
include_once '../src/JPush/Model/Notification.php';
include_once '../src/JPush/Model/Options.php';
include_once '../src/JPush/Model/Platform.php';
include_once '../src/JPush/Model/PushPayload.php';
include_once '../src/JPush/Model/PushResponse.php';
include_once '../src/JPush/Model/ReportResponse.php';
include_once '../src/JPush/Model/Report.php';
include_once '../src/JPush/JPushClient.php';

use JPush\Model as M;

class PushPayloadTest extends PHPUnit_Framework_TestCase {

    public function testPlatform() {
        $array = array('android', 'ios', 'winphone');
        $json = json_encode($array);

        $payload = M\platform('android', 'ios', 'winphone');
        $result = json_encode($payload);

        $this->assertEquals($json, $result);
    }

    public function testAudience() {
        $array = array(
            "tag" => array("tag1", "tag2"),
            "tag_and" => array("tag3"),
            "alias" => array("alias1", "alias2"),
            "registration_id" => array("id1", "id2")
        );
        $json = json_encode($array);

        $payload = M\audience(
            M\tag(array("tag1", "tag2")),
            M\tag_and(array("tag3")),
            M\alias(array("alias1", "alias2")),
            M\registration_id(array("id1", "id2")));
        $result = json_encode($payload);

        $this->assertEquals($json, $result);
    }

    public function testMessage() {
        $array = array(
            "msg_content" => "message msg content",
            "title" => "message title",
            "content_type" => "message content type",
            "extras" => array("key1"=>"value1", "key2"=>"value2")
        );
        $json = json_encode($array);

        $payload = M\message('message msg content', 'message title', 'message content type', array("key1"=>"value1", "key2"=>"value2"));
        $result = json_encode($payload);

        $this->assertEquals($json, $result);
    }

    public function testOptions() {
        $array = array(
            "sendno" => 654321,
            "time_to_live" => 60,
            "override_msg_id" => 123456,
            "apns_production" => false
        );
        $json = json_encode($array);

        $payload = M\options(654321, 60, 123456, false);
        $result = json_encode($payload);

        $this->assertEquals($json, $result);
    }

    public function testAndroidNotification() {
        $array = array(
            "platform" => "android",
            "alert" => "android alert",
            "title" => "android title",
            "builder_id"=>1,
            "extras" => array("key1"=>"value1", "key2"=>"value2")
        );
        $json = json_encode($array);

        $payload = M\android('android alert', 'android title', 1, array("key1"=>"value1", "key2"=>"value2"));
        $result = json_encode($payload);

        $this->assertEquals($json, $result);
    }

    public function testIOSNotification() {
        $array = array(
            "platform" => "ios",
            "alert" => "ios alert",
            "sound" => "happy",
            "badge" => 1,
            "content-available" => 1,
            "extras" => array("key1"=>"value1", "key2"=>"value2")

        );
        $json = json_encode($array);

        $payload = M\ios('ios alert', 'happy', 1, true, array("key1"=>"value1", "key2"=>"value2"));
        $result = json_encode($payload);

        $this->assertEquals($json, $result);
    }

    public function testIOSNotificationBadge() {
        $array = array(
            "platform" => "ios",
            "alert" => "ios alert",
            "sound" => "happy",
            "badge" => "+1",
            "content-available" => 1,
            "extras" => array("key1"=>"value1", "key2"=>"value2")

        );
        $json = json_encode($array);

        $payload = M\ios('ios alert', 'happy', "+1", true, array("key1"=>"value1", "key2"=>"value2"));
        $result = json_encode($payload);

        $this->assertEquals($json, $result);
    }

    public function testWinPhoneNotification() {
        $array = array(
            "platform" => "winphone",
            "alert" => "winphone alert",
            "title" => "winphone title",
            "_open_page" => "/friends.xaml",
            "extras" => array("key1"=>"value1", "key2"=>"value2"),
        );
        $json = json_encode($array);
        $payload = M\winphone('winphone alert', 'winphone title', '/friends.xaml', array("key1"=>"value1", "key2"=>"value2"));
        $result = json_encode($payload);

        $this->assertEquals($json, $result);
    }

    public function testNotification() {
        $array = array(
            "alert" => "notification alert",
            "ios" => array(
                "alert" => "ios alert",
                "sound" => "happy",
                "badge" => 1,
                "content-available" => 1,
                "extras" => array("key1"=>"value1", "key2"=>"value2")
            ),
            "android" => array(
                "alert" => "android alert",
                "title" => "android title",
                "builder_id"=>1,
                "extras" => array("key1"=>"value1", "key2"=>"value2")
            ),
            "winphone" => array(
                "alert" => "winphone alert",
                "title" => "winphone title",
                "_open_page" => "/friends.xaml",
                "extras" => array("key1"=>"value1", "key2"=>"value2"),
            )
        );
        $json = json_encode($array);

        $payload = M\notification('notification alert',
            M\ios('ios alert', 'happy', 1, true, array("key1"=>"value1", "key2"=>"value2")),
            M\android('android alert', 'android title', 1, array("key1"=>"value1", "key2"=>"value2")),
            M\winphone('winphone alert', 'winphone title', '/friends.xaml', array("key1"=>"value1", "key2"=>"value2"))
        );
        $result = json_encode($payload);

        $this->assertEquals($json, $result);
    }

    public function testPayload() {
        $array = array(
            "platform" => array("android","ios","winphone"),
            "audience" => array(
                "tag" => array("tag1", "tag2"),
                "tag_and" => array("tag3"),
                "alias" => array("alias1", "alias2"),
                "registration_id" => array("id1", "id2")
            ),
            "notification" => array(
                "alert" => "notification alert",
                "ios" => array(
                    "alert" => "ios alert",
                    "sound" => "happy",
                    "badge" => 1,
                    "content-available" => 1,
                    "extras" => array("key1"=>"value1", "key2"=>"value2")

                ),
                "android" => array(
                    "alert" => "android alert",
                    "title" => "android title",
                    "builder_id"=>1,
                    "extras" => array("key1"=>"value1", "key2"=>"value2")
                ),
                "winphone" => array(
                    "alert" => "winphone alert",
                    "title" => "winphone title",
                    "_open_page" => "/friends.xaml",
                    "extras" => array("key1"=>"value1", "key2"=>"value2"),
                )
            ),
            "message" => array(
                "msg_content" => "message msg content",
                "title" => "message title",
                "content_type" => "message content type",
                "extras" => array("key1"=>"value1", "key2"=>"value2")
            ),
            "options" => array(
                "sendno" => 654321,
                "time_to_live" => 60,
                "override_msg_id" => 123456,
                "apns_production" => false
            )
        );
        $json = json_encode($array);

        $payload = new M\PushPayload(null);
        $result = $payload->setPlatform(M\platform('android', 'ios', 'winphone'))
            ->setAudience(M\audience(M\tag(array("tag1", "tag2")),
                M\tag_and(array("tag3")),
                M\alias(array("alias1", "alias2")),
                M\registration_id(array("id1", "id2"))))
            ->setNotification(M\notification('notification alert',
                M\ios('ios alert', 'happy', 1, true, array("key1"=>"value1", "key2"=>"value2")),
                M\android('android alert', 'android title', 1, array("key1"=>"value1", "key2"=>"value2")),
                M\winphone('winphone alert', 'winphone title', '/friends.xaml', array("key1"=>"value1", "key2"=>"value2"))))
            ->setMessage(M\message('message msg content', 'message title', 'message content type', array("key1"=>"value1", "key2"=>"value2")))
            ->setOptions(M\options(654321, 60, 123456, false))
            ->getJSON();

        $this->assertEquals($json, $result);
    }

    public function testEasyPayload() {
        $array = array(
            "platform" => "all",
            "audience" => "all",
            "notification" => array(
                "alert" => "Hi, JPush"
            ),
            "options" => array(
                "sendno" => 654321,
                "apns_production" => false
            )
        );
        $json = json_encode($array);

        $payload = new M\PushPayload(null);
        $result = $payload->setPlatform(M\all)
            ->setAudience(M\all)
            ->setNotification(M\notification('Hi, JPush'))
            ->setOptions(M\options(654321))
            ->getJSON();

        $this->assertEquals($json, $result);
    }

    public function testIOSExceedLength1() {
        $payload = new M\PushPayload(null);
        $result = $payload->setPlatform(M\all)
            ->setAudience(M\all)
            ->setNotification(M\notification('Hi, JPush', M\ios("Hi, JPUsh")))
            ->isIosExceedLength();
        $this->assertEquals(false, $result);
    }

    public function testIOSExceedLength2() {
        $tooBig220 = "0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000";

        $payload = new M\PushPayload(null);
        $result = $payload->setPlatform(M\all)
            ->setAudience(M\all)
            ->setNotification(M\notification('Hi, JPush', M\ios($tooBig220)))
            ->isIosExceedLength();
        $this->assertEquals(true, $result);
    }

    public function testIOSExceedLength3() {
        $tooBig220 = "0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000";

        $payload = new M\PushPayload(null);
        $result = $payload->setPlatform(M\all)
            ->setAudience(M\all)
            ->setNotification(M\notification($tooBig220, M\ios("Hi, JPUsh")))
            ->isIosExceedLength();
        $this->assertEquals(false, $result);
    }

    public function testGlobalExceedLength1() {
        $payload = new M\PushPayload(null);
        $result = $payload->setPlatform(M\all)
            ->setAudience(M\all)
            ->setNotification(M\notification('Hi, JPush', M\ios("Hi, JPUsh")))
            ->setMessage(M\message("Hi,JPush"))
            ->isGlobalExceedLength();
        $this->assertEquals(false, $result);
    }

    public function testGlobalExceedLength2() {
        $tooBig220 = "0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000";
        $tooBig1200 = "000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000";

        $payload = new M\PushPayload(null);
        $result = $payload->setPlatform(M\all)
            ->setAudience(M\all)
            ->setNotification(M\notification('Hi, JPush', M\ios("Hi, JPUsh")))
            ->setMessage(M\message($tooBig1200))
            ->isGlobalExceedLength();

        $this->assertEquals(true, $result);
    }

    public function testGlobalExceedLength3() {
        $tooBig220 = "0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000";
        $tooBig1200 = "000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000";

        $payload = new M\PushPayload(null);
        $result = $payload->setPlatform(M\all)
            ->setAudience(M\all)
            ->setNotification(M\notification($tooBig220, M\ios("Hi, JPUsh")))
            ->setMessage(M\message("Hi,JPush"))
            ->isGlobalExceedLength();

        $this->assertEquals(false, $result);
    }
    public function testGlobalExceedLength4() {
        $tooBig220 = "0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000";
        $tooBig1200 = "000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000";

        $payload = new M\PushPayload(null);
        $result = $payload->setPlatform(M\all)
            ->setAudience(M\all)
            ->setNotification(M\notification("HI, JPush", M\ios("Hi, JPUsh"), M\android($tooBig1200)))
            ->setMessage(M\message("Hi,JPush"))
            ->isGlobalExceedLength();

        $this->assertEquals(true, $result);
    }


}
 