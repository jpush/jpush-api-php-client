<?php
include_once "../jpush/model/Platform.php";
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-5-24
 * Time: 上午11:23
 */

class PlatformTests extends PHPUnit_Framework_TestCase {

    public function testPlatform() {
        $result = '["android","ios","winphone"]';

        $platform = new Platform();
        $platform->ios = true;
        $platform->android = true;
        $platform->winphone = true;
        $json_arr = $platform->toJSON();

        $json_str = json_encode($json_arr);
        $this->assertEquals($result, $json_str);
    }

    public function testAlertAll() {
        $result = '"all"';

        $platform = new Platform();
        $json_arr = $platform->toJSON();

        $json_str = json_encode($json_arr);
        $this->assertEquals($result, $json_str);
    }
}