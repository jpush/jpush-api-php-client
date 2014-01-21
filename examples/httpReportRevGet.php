<?php
  include_once '../jpush/JPushClient.php';
  
  $master_secret = '2b38ce69b1de2a7fa95706ea';
  $app_key='dd1066407b044738b6479275';
  $platform = '';
  $apnsProduction = false;

  //echo phpinfo();
  $client = new JpushClient($app_key,$master_secret);
  //$msg_ids = '1613113584';
  $msg_ids = $_GET['msg_ids'];
  //echo $msg_ids;
  $revResult = $client->getReportReceiveds($msg_ids);
  //echo $revResult->getResultStr();
  $msgstr = "";
  if($revResult->isOK())
  {
      $msgstr = $revResult->getResultStr();  
  }
  echo $msgstr;

?>
