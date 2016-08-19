<?php
require __DIR__ . '/../conf.php';

// 获取Tag列表
$response = $client->device()->getDevices($registration_id);
print_r($response);