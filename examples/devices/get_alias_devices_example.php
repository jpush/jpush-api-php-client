<?php
require __DIR__ . '/../conf.php';

// 更新 Alias
$response = $client->device()->getAliasDevices('alias');
print_r($response);
