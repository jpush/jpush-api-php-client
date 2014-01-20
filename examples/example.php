<?php
  include_once '../jpush/JPushClient.php';
  $master_secret = '2b38ce69b1de2a7fa95706ea';
  $app_key='dd1066407b044738b6479275';
  $platform = '';
  $apnsProduction = false;

  $client = new JpushClient($app_key,$master_secret);
  //$client = new JpushClient($app_key,$master_secret,0,'android',false);
  //$client = new JpushClient($app_key,$master_secret,0,'ios',false);
  
  $extras = array();
  $params = array("receiver_type" => 2,
                  "receiver_value" => "tag_api",
				  "sendno" => 1,
				  "send_description" => "",
				  "override_msg_id" => "");
  $msgResult1 = $client->sendNotification("tag notify content", $params, $extras);
  $msgResult2 = $client->sendCustomMessage("tag title","tag notify content", $params, $extras);
  
  $params = array("receiver_type" => 3,
                  "receiver_value" => "alias_api",
				  "sendno" => 1,
				  "send_description" => "",
				  "override_msg_id" => "");
  $msgResult3 = $client->sendNotification("alias notify content", $params, $extras);
  $msgResult4 = $client->sendCustomMessage("tag title","tag notify content", $params, $extras);
				  
  $params = array("receiver_type" => 4,
                  "receiver_value" => "",
				  "sendno" => 1,
				  "send_description" => "",
				  "override_msg_id" => "");
  $msgResult5 = $client->sendNotification("appkey notify content", $params, $extras);
  $msgResult6 = $client->sendCustomMessage("tag title","tag notify content", $params, $extras);  
  
  $msg_ids=$msgResult1->getMesId().",".$msgResult2->getMesId().",".$msgResult3->getMesId().",".$msgResult4->getMesId().",".$msgResult5->getMesId().",".$msgResult6->getMesId();
  $msg_idsRe = "1613113584,1229760629,1174658841,1174658641"
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
     var surl = "reportRecevice.php?msg_ids=<?php echo $msg_idsRe; ?>";
	 sendRes(surl);
	 setInterval(function() {
	     sendRes(surl);
	 }, 30000);
  
  });
  function sendRes(surl)
  {    
        $.ajax({
			//url: "/static/test.json",
			url: surl,sync:false,
			cache: false, dataType: "json",jsonpCallback:"success_jsonpCallback",
			type:"get",
			timeout:2000,
            success: function (data) { 
            	if(data.length!=0)
            	{
				   //alert(data);
                   $.each(data,function(i,v){
				       if(v.android_received == null)
					   {
					       $("#a"+i).text("-");
					   }
					   else
					   {					      
				           $("#a"+i).text(v.android_received);
					   }
				       if(v.ios_apns_sent == null)
					   {
					       $("#i"+i).text("-");
					   }
					   else
					   {					      
				           $("#i"+i).text(v.ios_apns_sent);
					   }
				   })
            	}
            	else
            	{
            		//console.info("no data");
            	}           	

    			//setTimeout(getData,flush_time);
    			//setTimeout(getData,3000);
             }, 
              error: function (XMLHttpRequest, textStatus, errorThrown) { 
                               //console.info("error:"+errorThrown);
                   			//setTimeout(getData,3000);
             }
		});
  
  }
  </script>
</head>
<body>
<h1>JPush Example</h1>
<h3>Push Example</h3>
<table>
  <tr><th>发送方式</th><th>返回状态</th><th>返回信息</th><th>sendno</th><th>msg_id</th></tr>
  <tr>
    <td>发送tag通知</td>
	<td><?php echo $msgResult1->getCode(); ?></td>
	<td><?php echo $msgResult1->getMessage(); ?></td>
	<td><?php echo $msgResult1->getSendno(); ?></td>
	<td><?php echo $msgResult1->getMesId(); ?></td>
  </tr>
  <tr>
    <td>发送tag自定义消息</td>
	<td><?php echo $msgResult2->getCode(); ?></td>
	<td><?php echo $msgResult2->getMessage(); ?></td>
	<td><?php echo $msgResult2->getSendno(); ?></td>
	<td><?php echo $msgResult2->getMesId(); ?></td>
  </tr>
  <tr>
    <td>发送alias通知</td>
	<td><?php echo $msgResult3->getCode(); ?></td>
	<td><?php echo $msgResult3->getMessage(); ?></td>
	<td><?php echo $msgResult3->getSendno(); ?></td>
	<td><?php echo $msgResult3->getMesId(); ?></td>
  </tr>
  <tr>
    <td>发送alias自定义消息</td>
	<td><?php echo $msgResult4->getCode(); ?></td>
	<td><?php echo $msgResult4->getMessage(); ?></td>
	<td><?php echo $msgResult4->getSendno(); ?></td>
	<td><?php echo $msgResult4->getMesId(); ?></td>
  </tr>
  <tr>
    <td>发送广播通知</td>
	<td><?php echo $msgResult5->getCode(); ?></td>
	<td><?php echo $msgResult5->getMessage(); ?></td>
	<td><?php echo $msgResult5->getSendno(); ?></td>
	<td><?php echo $msgResult5->getMesId(); ?></td>
  </tr>
  <tr>
    <td>发送广播自定义消息</td>
	<td><?php echo $msgResult6->getCode(); ?></td>
	<td><?php echo $msgResult6->getMessage(); ?></td>
	<td><?php echo $msgResult6->getSendno(); ?></td>
	<td><?php echo $msgResult6->getMesId(); ?></td>
  </tr>
</table>

<h3>Receive Example</h3>
<table>
  <tr><th>msg_id</th><th>iso接收数量</th><th>andriod接收数量</th></tr>
  <tr>
	<td><?php echo $msgResult1->getMesId(); ?></td>
	<td id="i0" align="center"></td>
	<td id="a0" align="center"></td>
  </tr>
  <tr>
	<td><?php echo $msgResult2->getMesId(); ?></td>
	<td id="i1" align="center"></td>
	<td id="a1" align="center"></td>
  </tr>
  <tr>
	<td><?php echo $msgResult3->getMesId(); ?></td>
	<td id="i2" align="center"></td>
	<td id="a2" align="center"></td>
  </tr>
  <tr>
	<td><?php echo $msgResult4->getMesId(); ?></td>
	<td id="i3" align="center"></td>
	<td id="a3" align="center"></td>
  </tr>
</table>
</body>
<body>