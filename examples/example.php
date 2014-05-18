<?php
    include_once '../jpushv3/JPushClient.php';
    include_once '../jpushv3/Notification.php';
    include_once '../jpushv3/Message.php';

    $master_secret = 'd94f733358cca97b18b2cb98';
    $app_key='47a3ddda34b2602fa9e17c01';
    $client = new JPushClient($app_key, $master_secret);

    $notification = new Notification('This is content');
    $message = new Message("This is content");

    //发送广播通知
    $result1 = $client->send($notification);

    //发送广播自定义信息
    $result2 = $client->send($message);

    //发送Tag通知
    $notification->setTag("555,666");
    $result3 = $client->send($notification);

    //其他属性测试
    $notification->setTitle("This is title")
        ->setBuilderId(1)
        ->setExtras(array("key"=>"value"))
        ->setSound("happy")
        ->setBadge(1)
        ->setContentAvailabe(true)
        ->setOpenPage("/friends.xaml");
    $result4 = $client->send($notification);

    //其他属性测试
    $message->setTitle("This is title")->setExtras(array("key"=>"value"))->setContentType("content_type");
    $result5 = $client->send($message);

    //组装查询统计信息字符串
    $msg_ids1 = '636946851';
    $msg_ids2 = '636946851,1173817748,636946865';
    $result6 = $client->getReport($msg_ids1);
    $result7 = $client->getReport($msg_ids2);

    //错误测试
    $notification->setTitle(["This is title"]);
    $result8 = $client->send($notification);
    $notification->setTitle("This is title");

    $notification->setBadge("1");
    $result9 = $client->send($notification);
    $notification->setBadge(1);

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
    <tr>
        <td>其他属性测试</td>
        <td><?php echo $result4; ?></td>
    </tr>
    <tr>
        <td>其他属性测试(自定义)</td>
        <td><?php echo $result5; ?></td>
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

<h3>Error Example</h3>
<table>
    <tr><th>错误信息</th><th>返回JSON</th></tr>
    <tr>
        <td>标题错误</td>
        <td><?php echo $result8; ?></td>
    </tr>
    <tr>
        <td>Badge错误</td>
        <td><?php echo $result9; ?></td>
    </tr>
    <tr>
        <td>更多错误</td>
        <td>待添加</td>
    </tr>

</table>




</body>
<body>