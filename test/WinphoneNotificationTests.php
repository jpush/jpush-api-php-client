<?php
include_once "../jpush/model/notification/WinphoneNotification.php";

/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-5-24
 * Time: 上午11:25
 */

class WinphoneNotificationTests extends PHPUnit_Framework_TestCase {
    public function testWinphoneNotification() {
        $result = '{"alert":"winphone alert","title":"winphone title","_open_page":"\/abc.fmal","extras":{"key1":"value1","key2":"value2"}}';

        $winphone = new WinphoneNotification();
        $winphone->alert = "winphone alert";
        $winphone->title = "winphone title";
        $winphone->_open_page = "/abc.fmal";
        $winphone->extras = array("key1"=>"value1", "key2"=>"value2");
        $json_arr = $winphone->toJSON();

        $json_str = json_encode($json_arr);
        $this->assertEquals($result, $json_str);
    }
} 