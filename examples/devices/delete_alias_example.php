<?php
require __DIR__ . '/../conf.php';

$response = $client->device()->deleteAlias('alias');
print_r($response);
