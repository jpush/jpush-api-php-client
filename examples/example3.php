<?php
    include_once '../jpushv3/JPushClient.php';

    $master_secret = 'd94f733358cca97b18b2cb98';
    $app_key='47a3ddda34b2602fa9e17c01';
    $jpushClient = new JPushClient($app_key, $master_secret);

    $msg_ids = "631618140,1775190630,433013346";
    echo '<br/>' . $jpushClient->getReport($msg_ids);

    


    

?>
