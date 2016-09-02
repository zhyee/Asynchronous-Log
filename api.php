<?php

date_default_timezone_set('Asia/shanghai');
$startTime = microtime(TRUE);

/* 写远程日志 */
$text = '远程日志 : ' . date('Y-m-d H:i:s') . PHP_EOL;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://zyee.org/log-api.php');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, ['info' => $text]);
$result = curl_exec($ch);
curl_close($ch);

$endTime = microtime(TRUE);

echo '本次处理时间 ' . ($endTime - $startTime) * 1000 . 'ms ' . PHP_EOL;
