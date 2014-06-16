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
include_once '../src/JPush/Model/Error.php';
include_once '../src/JPush/JPushClient.php';
include_once '../src/JPush/JPushLog.php';

use JPush\Model as M;
use JPush\JPushClient;
use JPush\JPushLog;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class PushTest extends PHPUnit_Framework_TestCase {

    public function testAlertAll() {

    }

    // platform
    public function testAlertAndroid() {}
    public function testAlertIOS() {}
    public function testAlertWinphone() {}


    //audience
    public function testSendByTag() {}
    public function testSendByTagAnd() {}
    public function testSendByAlias() {}
    public function testSendByRegistrationID() {}

    public function testSendByTagMore() {}
    public function testSendByTagAndMore() {}
    public function testSendByAliasMore() {}
    public function testSendByRegistrationIDMore() {}

    public function testSendByTagAlias() {}
    public function testSendByTagRegistrationID() {}
    public function testSendByTagRegistrationID_0() {}
    public function testSendByTagAlias_0() {}
    public function testSendByTagAlias_0_2() {}

    //notification
    public function testNotificationAll() {}
    public function testNotificationAndroidAlert() {}
    public function testNotificationAndroidFull() {}
    public function testNotificationIOSAlert() {}
    public function testNotificationIOSFull() {}
    public function testNotificationWinPhoneAlert() {}
    public function testNotificationWinPhoneFUll() {}


    //message
    public function testMessageContentOnly() {}
    public function testMessageContentFull() {}

    //option
    public function testOptionsSendno() {}







}
 