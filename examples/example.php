<?php
    include_once '../jpush/JPushClient.php';
    include_once '../jpush/model/Audience.php';
    include_once '../jpush/model/Message.php';
    include_once '../jpush/model/notification/Notification.php';
    include_once '../jpush/model/notification/IOSNotification.php';
    include_once '../jpush/model/notification/AndroidNotification.php';
    include_once '../jpush/model/notification/WinphoneNotification.php';
    include_once '../jpush/model/Options.php';
    include_once '../jpush/model/Platform.php';
    include_once '../jpush/model/PushPayload.php';

    $master_secret = 'd94f733358cca97b18b2cb98';
    $app_key='47a3ddda34b2602fa9e17c01';
    $tag = "tag1,tag2";
    $tag_and = "tag3,tag4";
    $alias = "alias1,alias2";
    $registration_id = "id1,id2";
    $client = new JPushClient($app_key, $master_secret);

    /* init start */
    $platform = new Platform();
    $audience = new Audience();
    $message = new Message();
    $options = new Options();

    $notification = new Notification();
    $ios = new IOSNotification();
    $android = new AndroidNotification();
    $winphone = new WinphoneNotification();

    //set platform params
    $platform->ios = true;
    $platform->winphone = true;


    //set audience params
    $audience->tag = $tag;
    $audience->tag_and = $tag_and;
    $audience->alias = $alias;
    $audience->registration_id = $registration_id;

    //set options params
    $options->sendno = 1;
    $options->apns_production = true;
    $options->override_msg_id = 2;
    $options->time_to_live = 60;

    //set message params
    $message->msg_content = "message content test";
    $message->title = "message title test";
    $message->content_type = "message content type test";
    $message->extras = array("key1"=>"value1", "key2"=>"value2");

    //set options params
    $options->sendno = 1;
    $options->apns_production = true;
    $options->override_msg_id = 2;
    $options->time_to_live = 60;

    //set notification params
    $ios->alert = "ios notification alert test";
    $ios->sound = "happy";
    $ios->badge = 1;
    $ios->extras = array("key1"=>"value1", "key2"=>"value2");
    $ios->content_availabe = 1;

    $android->alert = "android notification alert test";
    $android->title = "android notification title test";
    $android->builder_id = 1;
    $android->extras = array("key1"=>"value1", "key2"=>"value2");

    $winphone->alert = "winphone notification alert test";
    $winphone->title = "winphone notification title test";
    $winphone->_open_page = "/friends.xaml";
    $winphone->extras = array("key1"=>"value1", "key2"=>"value2");

    $notification->alert = "notification alert test";
    $notification->android = $android;
    $notification->ios = $ios;
    $notification->winphone = $winphone;

    /* init end */





    //发送广播通知
    $payload1 = new PushPayload();
    $notification1 = new Notification();
    $notification1->alert = "alert message";
    $payload1->notification = $notification;
    $result1 = $client->sendPush($payload1);

    //发送广播自定义信息
    $payload2 = new PushPayload();
    $payload2->message = $message;
    $result2 = $client->sendPush($payload2);

    //发送Tag通知
    $options3 = new Options();
    $audience3 = new Audience();
    $notification3 = new Notification();
    $notification3->alert = "tag tests";
    $audience3->tag = "555";
    //$audience3->alias = $alias;
    $options3->sendno = 441740752;

    $payload3 = new PushPayload();
    $payload3->audience = $audience3;
    $payload3->notification = $notification3;
    $payload3->options = $options3;
    $result3 = $client->sendPush($payload3);



    //组装查询统计信息字符串
    $msg_ids1 = '636946851';
    $msg_ids2 = '636946851,1173817748,636946865';
    $result6 = $client->getReport($msg_ids1);
    $result7 = $client->getReport($msg_ids2);


?>

<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <title>JPush api test</title>
    <style>
        h1{margin-top:10px;margin-left:40px;}
        table{margin-top:20px;margin-left:10px;}
        table,tr,th,td {border: solid 1px;}
        th {background-color: #EEE;}
    </style>

</head>
<body>
<h1>JPush Example</h1>
<h3>Push Example</h3>
<table>
    <tr><th>发送方式</th><th>返回JSON</th></tr>
    <tr>
        <td>发送广播通知</td>
        <td><?php echo $result1; ?></td>
    </tr>
    <tr>
        <td>发送广播自定义信息</td>
        <td><?php echo $result2; ?></td>
    </tr>
    <tr>
        <td>发送Tag通知</td>
        <td><?php echo $result3; ?></td>
    </tr>

</table>

<h3>Report Example</h3>
<table>
    <tr><th>发送的msg_ids</th><th>返回JSON</th></tr>
    <tr>
        <td><?php echo $msg_ids1; ?></td>
        <td><?php echo $result6; ?></td>
    </tr>
    <tr>
        <td><?php echo $msg_ids2; ?></td>
        <td><?php echo $result7; ?></td>
    </tr>
</table>






</body>
<body>