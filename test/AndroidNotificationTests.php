<?php
include_once "../jpush/model/notification/AndroidNotification.php";

/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-5-24
 * Time: 上午11:25
 */

class AndroidNotificationTests extends PHPUnit_Framework_TestCase {
    public function testAndroidNotification() {
        $array = array("alert" => "android alert", "title" => "android title", "builder_id"=>1, "extras" => array("key1"=>"value1", "key2"=>"value2"));

        //$result = '{"alert":"android alert","title":"android title","builder_id":1,"extras":{"key1":"value1","key2":"value2"}}';
        $result = json_encode($array);

        $android = new AndroidNotification();
        $android->alert = "android alert";
        $android->title = "android title";
        $android->builder_id = 1;
        $android->extras = array("key1"=>"value1", "key2"=>"value2");
        $json_arr = $android->toJSON();

        $json_str = json_encode($json_arr);
        $this->assertEquals($result, $json_str);
    }

} 