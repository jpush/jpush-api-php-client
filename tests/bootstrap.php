<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app_key = 'xxxx';
$master_secret = 'xxxx';
$client = new JPush\Client($app_key, $master_secret);

$registration_id = 'xxxx';
