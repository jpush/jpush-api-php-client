<?php
require __DIR__ . '/../config.php';

$result = $client->report()->getMessagesDetail('149646415212');
print_r($result);