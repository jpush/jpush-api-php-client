<?php
include_once "AndroidNotificationTests.php";
include_once "WinphoneNotificationTests.php";
include_once "IOSNotificationTests.php";
include_once "NotificationTests.php";
include_once "MessageTests.php";
include_once "OptionsTests.php";
include_once "PlatformTests.php";
include_once "AudienceTests.php";
include_once "PushPayloadTests.php";

/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-5-24
 * Time: 下午1:25
 */

class AllTests {
    public static function main() {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite() {
        $suite = new PHPUnit_Framework_TestSuite();

        //test model
        $suite->addTestSuite('AndroidNotificationTests');
        $suite->addTestSuite('WinphoneNotificationTests');
        $suite->addTestSuite('IOSNotificationTests');
        $suite->addTestSuite('NotificationTests');
        $suite->addTestSuite('OptionsTests');
        $suite->addTestSuite('PlatformTests');
        $suite->addTestSuite('AudienceTests');
        $suite->addTestSuite('MessageTests');
        $suite->addTestSuite('PushPayloadTests');



        return $suite;
    }
} 