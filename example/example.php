<?php
  include_once '../lib/jpush_api_php_client.php';
  $master_secret = '570f9aadcffe791658dde66b';
  $app_key='7ebc243ae2b37128472b0875';
  $sendno=9;

  echo phpinfo();
  $client = new JpushClient($app_key,$master_secret,0);
  
  //send message by tag
  $str = $client->sendNotificationByTag('tagapi', $sendno, 'des',
                      'tag notify title','tag notify content', 'android','');
  echo $str."\n";

  //
  $sendno++;
  $str = $client->sendCustomMesByTag('tagapi', $sendno, 'des',
                      'tag notify title','tag notify content', 'android','');
  echo $str."\n";

  //
  $sendno++;
  $str = $client->sendNotificationByAlias('tagapi', $sendno, 'des',
                      'tag notify title','tag notify content', 'android','');
  echo $str."\n";
  		
  //
  $sendno++;
  $str = $client->sendCustomMesByAlias('tagapi', $sendno, 'des',
                      'tag notify title','tag notify content', 'android','');
  echo $str."\n";
  		
  //
  $sendno++;
  $str = $client->sendNotificationByAppkey($sendno, 'des',
                      'tag notify title','tag notify content', 'android','');
  echo $str."\n";
  		
  //
  $sendno++;
  $str = $client->sendCustomMesByAppkey($sendno, 'des',
                      'tag notify title','tag notify content', 'android','');
  echo $str."\n";
  
  $msg_ids="929123086,1197558554";
  $str = $client->getReceivedApi($msg_ids);
  echo $str."\n";


  
?>