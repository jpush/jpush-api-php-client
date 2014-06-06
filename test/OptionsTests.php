<?php
include_once "../jpush/model/Options.php";
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-5-24
 * Time: 上午11:23
 */

class OptionsTests extends PHPUnit_Framework_TestCase {

    public function testOptions() {
        $array = array(
            "sendno" => 654321,
            "time_to_live" => 60,
            "override_msg_id" => 123456,
            "apns_production" => false
        );
        $result = json_encode($array);

        $options = new Options();
        $options->apns_production = false;
        $options->override_msg_id = 123456;
        $options->sendno = 654321;
        $options->time_to_live = 60;
        $json_arr = $options->toJSON();

        $json_str = json_encode($json_arr);
        $this->assertEquals($result, $json_str);
    }
} 