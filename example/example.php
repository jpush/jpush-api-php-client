<?php
  include_once '../lib/jpush_api_php_client.php';
  $master_secret = '570f9aadcffe791658dde66b';
  $app_key='7ebc243ae2b37128472b0875';
  $sendno=9;
  
  $client = new JpushClient($master_secret,0);
  
  //send message by tag
  $str = $client->sendNotificationByTag('tagapi', $app_key, $sendno, 'des',
                      'tag notify title','tag notify content', 'android','');
  echo $str."\n";

  //
  $sendno++;
  $str = $client->sendCustomMesByTag('tagapi', $app_key, $sendno, 'des',
                      'tag notify title','tag notify content', 'android','');
  echo $str."\n";

  //
  $sendno++;
  $str = $client->sendNotificationByAlias('tagapi', $app_key, $sendno, 'des',
                      'tag notify title','tag notify content', 'android','');
  echo $str."\n";
  		
  //
  $sendno++;
  $str = $client->sendCustomMesByAlias('tagapi', $app_key, $sendno, 'des',
                      'tag notify title','tag notify content', 'android','');
  echo $str."\n";
  		
  //
  $sendno++;
  $str = $client->sendNotificationByAppkey($app_key, $sendno, 'des',
                      'tag notify title','tag notify content', 'android','');
  echo $str."\n";
  		
  //
  $sendno++;
  $str = $client->sendCustomMesByAppkey($app_key, $sendno, 'des',
                      'tag notify title','tag notify content', 'android','');
  echo $str."\n";
?>