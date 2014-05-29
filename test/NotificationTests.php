<?php
include_once "../jpush/model/notification/WinphoneNotification.php";
include_once "../jpush/model/notification/IOSNotification.php";
include_once "../jpush/model/notification/AndroidNotification.php";
include_once "../jpush/model/notification/Notification.php";
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-5-24
 * Time: 上午11:25
 */

class NotificationTests extends PHPUnit_Framework_TestCase {

    public function testNotification() {
        $result = '{"alert":"notification alert","ios":{"alert":"ios alert","sound":"happy","badge":1,"extras":{"key1":"value1","key2":"value2"},"content_availabe":1},"android":{"alert":"android alert","title":"android title","builder_id":1,"extras":{"key1":"value1","key2":"value2"}},"winphone":{"alert":"winphone alert","title":"winphone title","_open_page":"\/abc.fmal","extras":{"key1":"value1","key2":"value2"}}}';

        $android = new AndroidNotification();
        $android->alert = "android alert";
        $android->title = "android title";
        $android->builder_id = 1;
        $android->extras = array("key1"=>"value1", "key2"=>"value2");

        $winphone = new WinphoneNotification();
        $winphone->alert = "winphone alert";
        $winphone->title = "winphone title";
        $winphone->_open_page = "/abc.fmal";
        $winphone->extras = array("key1"=>"value1", "key2"=>"value2");

        $ios = new IOSNotification();
        $ios->alert = "ios alert";
        $ios->badge = 1;
        $ios->content_available = 1;
        $ios->sound = "happy";
        $ios->extras = array("key1"=>"value1", "key2"=>"value2");

        $notification = new Notification();
        $notification->alert = "notification alert";
        $notification->ios = $ios;
        $notification->winphone = $winphone;
        $notification->android = $android;

        $json_arr = $notification->toJSON();

        $json_str = json_encode($json_arr);
        $this->assertEquals($result, $json_str);

    }

} 