<?php

$content = '日志数据：' . date('Y-m-d H:i:s') . PHP_EOL;

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'http://192.168.56.102/socket/api-server.php');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, ['info' => $content]);
$result = curl_exec($ch);
curl_close($ch);
echo $result . PHP_EOL;