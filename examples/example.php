<?php
    include_once '../jpush/JPushClient.php';
    $master_secret = 'd94f733358cca97b18b2cb98';
    $app_key='47a3ddda34b2602fa9e17c01';
    $platform = '';
    $apnsProduction = false;

    $tags = '555';
    $alias = '666';
    $registrationId = '0004cd4e4a0';

    $client = new JPushClient($app_key,$master_secret);

    //发送广播通知
    $msgResult1 = $client->sendNotification(1, 'ALL-This is title', 'ALL-This is content');

    //发送tag通知
    $msgResult2 = $client->sendTagNotification($tags, 1, 'Tag-This is title', 'Tag-This is content');

    //发送alias通知
    $msgResult3 = $client->sendAliasNotification($alias, 1, 'Alias-This is title', 'Alias-This is content');

    //发送RegistrationID通知
    $msgResult4 = $client->sendRegistrationIDNotification($registrationId, 1, 'RegistrationID-This is title', 'RegistrationID-This is content');

    //发送广播自定义消息
    $msgResult5 = $client->sendCustomMsg(1, 'ALL-This is title', 'ALL-This is content', 'content-type');

    //发送tag自定义消息
    $msgResult6 = $client->sendTagCustomMsg($tags, 1, 'Tag-This is title', 'Tag-This is content', 'content-type');

    //发送alias自定义消息
    $msgResult7 = $client->sendAliasCustomMsg($alias, 1, 'Alias-This is title', 'Alias-This is content', 'content-type');

    //发送RegistrationID自定义消息
    $msgResult8 = $client->sendRegistrationIDCustomMsg($registrationId, 1, 'RegistrationID-This is title', 'RegistrationID-This is content', 'content-type');

    //组装查询统计信息字符串
    $msg_ids = $msgResult1->getMesId().",".$msgResult2->getMesId().",".$msgResult3->getMesId().",".$msgResult4->getMesId().",".$msgResult5->getMesId().",".$msgResult6->getMesId().",".$msgResult7->getMesId().",".$msgResult8->getMesId();


    //Error test
    $errRs1 = $client->sendNotification('1', 'ALL-This is title', 'ALL-This is content');
    $errRs2 = $client->sendNotification(1, 123456, 'ALL-This is content');

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
    <script type="text/javascript" src="jquery-1.9.1.min.js"></script>
    <script type="text/javascript">
  $(function(){
        var surl = "httpReportRevGet.php?msg_ids=<?php echo $msg_ids; ?>";
        sendRes(surl);
        setInterval(function() {
           sendRes(surl);
        }, 10000);
  
  });
  function sendRes(surl)
  {    
       //alert("111");
        $.ajax({
        //url: "/static/test.json",
        url: surl,sync:false,
        cache: false, dataType: "json",jsonpCallback:"success_jsonpCallback",
        type:"get",
        timeout:2000,
        success: function (data) {
          if(data.length!=0)
          {
        var status = "Please wait.";
        var aVal,iVal,theadHtml="<tr><th>msg_id</th><th>ios接收数量</th><th>andriod接收数量</th><th>状态信息</th></tr>";
        $("#revId").text("");
        $("#revId").append(theadHtml);
        $.each(data,function(i,v){
           aVal = "-",iVal = "-";
           if(v.android_received != null)
         {
             aVal = v.android_received;
           status = "Success";
         }             
           if(v.ios_apns_sent != null)
         {
             iVal = v.ios_apns_sent;
           status = "Success";
         }
         var trHtml = "<tr><td>"+v.msg_id+"</td><td>"+ iVal +"</td><td>"+aVal+"</td><td>"+status+"</td></tr>";
         $("#revId").append(trHtml);
         
        })
          }
          else
          {
            var trHtml = "<tr><td colspan='4'>No msg_id to get</td></tr>";
         $("#revId").append(trHtml);
          }             
         }, 
          error: function (XMLHttpRequest, textStatus, errorThrown) {
            var trHtml = "<tr><td>error</td><td colspan='3'>"+errorThrown+"</td></tr>";
         $("#revId").append(trHtml);
                           //console.info("error:"+errorThrown);
             //console.info(textStatus);
         }
    });
  
  }
  </script>
</head>
<body>
<h1>JPush Example</h1>
<h3>Push Example</h3>
<table>
    <tr><th>发送方式</th><th>返回状态</th><th>返回信息</th><th>sendno</th><th>msg_id</th><th>频率次数</th><th>可用频率次数</th><th>重置时间</th></tr>
    <tr>
        <td>发送广播通知</td>
        <td><?php echo $msgResult1->getCode(); ?></td>
        <td><?php echo $msgResult1->getMessage(); ?></td>
        <td><?php echo $msgResult1->getSendno(); ?></td>
        <td><?php echo $msgResult1->getMesId(); ?></td>
        <td><?php $resCon = $msgResult1->getResponseContent(); echo $resCon["X-Rate-Limit-Limit"]; ?></td>
        <td><?php echo $resCon["X-Rate-Limit-Remaining"]; ?></td>
        <td><?php echo $resCon["X-Rate-Limit-Reset"]; ?></td>
    </tr>
    <tr>
        <td>发送tag通知</td>
        <td><?php echo $msgResult2->getCode(); ?></td>
        <td><?php echo $msgResult2->getMessage(); ?></td>
        <td><?php echo $msgResult2->getSendno(); ?></td>
        <td><?php echo $msgResult2->getMesId(); ?></td>
        <td><?php $resCon = $msgResult2->getResponseContent(); echo $resCon["X-Rate-Limit-Limit"]; ?></td>
        <td><?php echo $resCon["X-Rate-Limit-Remaining"]; ?></td>
        <td><?php echo $resCon["X-Rate-Limit-Reset"]; ?></td>
    </tr>
    <tr>
        <td>发送alias通知</td>
        <td><?php echo $msgResult3->getCode(); ?></td>
        <td><?php echo $msgResult3->getMessage(); ?></td>
        <td><?php echo $msgResult3->getSendno(); ?></td>
        <td><?php echo $msgResult3->getMesId(); ?></td>
        <td><?php $resCon = $msgResult3->getResponseContent(); echo $resCon["X-Rate-Limit-Limit"]; ?></td>
        <td><?php echo $resCon["X-Rate-Limit-Remaining"]; ?></td>
        <td><?php echo $resCon["X-Rate-Limit-Reset"]; ?></td>
    </tr>
    <tr>
        <td>发送RegistrationID通知</td>
        <td><?php echo $msgResult4->getCode(); ?></td>
        <td><?php echo $msgResult4->getMessage(); ?></td>
        <td><?php echo $msgResult4->getSendno(); ?></td>
        <td><?php echo $msgResult4->getMesId(); ?></td>
        <td><?php $resCon = $msgResult4->getResponseContent(); echo $resCon["X-Rate-Limit-Limit"]; ?></td>
        <td><?php echo $resCon["X-Rate-Limit-Remaining"]; ?></td>
        <td><?php echo $resCon["X-Rate-Limit-Reset"]; ?></td>
    </tr>
    <tr>
        <td>发送广播自定义消息</td>
        <td><?php echo $msgResult5->getCode(); ?></td>
        <td><?php echo $msgResult5->getMessage(); ?></td>
        <td><?php echo $msgResult5->getSendno(); ?></td>
        <td><?php echo $msgResult5->getMesId(); ?></td>
        <td><?php $resCon = $msgResult5->getResponseContent(); echo $resCon["X-Rate-Limit-Limit"]; ?></td>
        <td><?php echo $resCon["X-Rate-Limit-Remaining"]; ?></td>
        <td><?php echo $resCon["X-Rate-Limit-Reset"]; ?></td>
    </tr>
    <tr>
        <td>发送tag自定义消息</td>
        <td><?php echo $msgResult6->getCode(); ?></td>
        <td><?php echo $msgResult6->getMessage(); ?></td>
        <td><?php echo $msgResult6->getSendno(); ?></td>
        <td><?php echo $msgResult6->getMesId(); ?></td>
        <td><?php $resCon = $msgResult6->getResponseContent(); echo $resCon["X-Rate-Limit-Limit"]; ?></td>
        <td><?php echo $resCon["X-Rate-Limit-Remaining"]; ?></td>
        <td><?php echo $resCon["X-Rate-Limit-Reset"]; ?></td>
    </tr>
    <tr>
        <td>发送alias自定义消息</td>
        <td><?php echo $msgResult7->getCode(); ?></td>
        <td><?php echo $msgResult7->getMessage(); ?></td>
        <td><?php echo $msgResult7->getSendno(); ?></td>
        <td><?php echo $msgResult7->getMesId(); ?></td>
        <td><?php $resCon = $msgResult7->getResponseContent(); echo $resCon["X-Rate-Limit-Limit"]; ?></td>
        <td><?php echo $resCon["X-Rate-Limit-Remaining"]; ?></td>
        <td><?php echo $resCon["X-Rate-Limit-Reset"]; ?></td>
    </tr>
    <tr>
        <td>发送RegistrationID自定义消息</td>
        <td><?php echo $msgResult8->getCode(); ?></td>
        <td><?php echo $msgResult8->getMessage(); ?></td>
        <td><?php echo $msgResult8->getSendno(); ?></td>
        <td><?php echo $msgResult8->getMesId(); ?></td>
        <td><?php $resCon = $msgResult8->getResponseContent(); echo $resCon["X-Rate-Limit-Limit"]; ?></td>
        <td><?php echo $resCon["X-Rate-Limit-Remaining"]; ?></td>
        <td><?php echo $resCon["X-Rate-Limit-Reset"]; ?></td>
    </tr>
    
   
</table>
<h3>Receive Example</h3>
<table id="revId">
  <tr><th>msg_id</th><th>ios接收数量</th><th>andriod接收数量</th><th>状态信息</th></tr>
</table>

<h3>Error Example</h3>
<table id="revId">
  <tr>
    <th>错误类型</th><th>错误代码</th><th>错误提示</th></tr>
  <tr>
    <td>Sendno Error</td>
    <td><?php echo $errRs1->getCode(); ?></td>
    <td><?php echo $errRs1->getMessage(); ?></td>
  </tr>
  <tr>
    <td>Title Error</td>
    <td><?php echo $errRs2->getCode(); ?></td>
    <td><?php echo $errRs2->getMessage(); ?></td>
  </tr>
</table>



</body>
<body>