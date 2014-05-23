<?php

class RemoteConnectTest extends PHPUnit_Framework_TestCase {
  public function setUp(){ 
    echo "in up" . "</br>";
  }
  public function tearDown(){
    echo "in down" . "</br>";
   }
  public function testConnectionIsValid() {
    echo "in test" . "</br>";
    $this->assertTrue(true === true);
  }
}
?>