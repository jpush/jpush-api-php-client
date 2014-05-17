<?php
    include_once '../jpushv3/Notification.php';
    include_once '../jpushv3/Message.php';
    include_once '../jpushv3/JPushClient.php';

    $master_secret = 'd94f733358cca97b18b2cb98';
    $app_key='47a3ddda34b2602fa9e17c01';
    $pushClient = new JPushClient($app_key, $master_secret);

    $notification = new Notification('This is content');

    $notification->setPlatform("ios,android")
        ->setTag("555,666")
        ->setTitle("This is title")
        ->setBuilderId(1)
        ->setExtras(array("key"=>"value"))
        ->setSound("happy")
        ->setBadge(1)
        ->setContentAvailabe(true)
        ->setOpenPage("/friends.xaml");

    $message = new Message("This is content3234");
    $message->setTitle("This is title")->setExtras(array("key"=>"value"))->setContentType("content_type");

    $pushResult = $pushClient->send($notification);


    

?>
