<?php
include_once "../jpush/model/Audience.php";

/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-5-24
 * Time: 上午11:24
 */

class AudienceTests extends PHPUnit_Framework_TestCase {
    public function testAudience() {
        $result = '{"tag":["tag1","tag2"],"tag_and":["tag3"],"alias":["alias1","alias2"],"registration_is":["id1","id2"]}';

        $audience = new Audience();
        $audience->tag = "tag1,tag2";
        $audience->tag_and = "tag3";
        $audience->alias = "alias1,alias2";
        $audience->registration_id = "id1,id2";
        $json_arr = $audience->toJSON();

        $json_str = json_encode($json_arr);
        $this->assertEquals($result, $json_str);
    }

    public function testAlertAll() {
        $result = '"all"';

        $audience = new Audience();
        $json_arr = $audience->toJSON();

        $json_str = json_encode($json_arr);
        $this->assertEquals($result, $json_str);
    }
} 