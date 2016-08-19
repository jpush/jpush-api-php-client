<?php
require __DIR__ . '/../conf.php';

$response = $client->device()->deleteTag('tag');
print_r($response);
